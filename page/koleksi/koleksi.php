
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/config.php';

/*
|--------------------------------------------------------------------------
| FUNGSI BIND PARAMETER DINAMIS MYSQLI
|--------------------------------------------------------------------------
| Digunakan untuk pencarian dan filter dengan jumlah parameter berbeda.
*/

function bindCollectionParams($stmt, string $types, array &$params): void
{
    if ($types === '' || empty($params)) {
        return;
    }

    $references = [];

    foreach ($params as $key => &$value) {
        $references[$key] = &$value;
    }

    mysqli_stmt_bind_param($stmt, $types, ...$references);
}

/*
|--------------------------------------------------------------------------
| FUNGSI MENGAMBIL PILIHAN FILTER DARI DATABASE
|--------------------------------------------------------------------------
*/

function getCollectionOptions(mysqli $conn, string $column): array
{
    $allowedColumns = [
        'seniman',
        'jenis_koleksi',
        'lokasi_pembuatan',
        'tahun_pembuatan'
    ];

    if (!in_array($column, $allowedColumns, true)) {
        return [];
    }

    $sql = "
        SELECT DISTINCT `$column`
        FROM koleksi
        WHERE `$column` IS NOT NULL
        AND `$column` != ''
        ORDER BY `$column` ASC
    ";

    $result = mysqli_query($conn, $sql);

    $options = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $options[] = $row[$column];
    }

    return $options;
}

/*
|--------------------------------------------------------------------------
| PENCARIAN DAN FILTER
|--------------------------------------------------------------------------
*/

$keyword = trim($_GET['q'] ?? '');

$artists = $_GET['artist'] ?? [];
$types = $_GET['type'] ?? [];
$locations = $_GET['location'] ?? [];
$years = $_GET['year'] ?? [];

$artists = is_array($artists) ? $artists : [];
$types = is_array($types) ? $types : [];
$locations = is_array($locations) ? $locations : [];
$years = is_array($years) ? $years : [];

// Memastikan nilai filter berupa teks sederhana.
$artists = array_filter($artists, 'is_string');
$types = array_filter($types, 'is_string');
$locations = array_filter($locations, 'is_string');
$years = array_filter($years, 'is_string');

$where = [];
$params = [];
$paramTypes = '';

/*
|--------------------------------------------------------------------------
| PENCARIAN JUDUL, SENIMAN, DAN DESKRIPSI
|--------------------------------------------------------------------------
*/

if ($keyword !== '') {

    $where[] = "(
        judul_koleksi LIKE ?
        OR seniman LIKE ?
        OR deskripsi LIKE ?
    )";

    $searchKeyword = "%{$keyword}%";

    $params[] = $searchKeyword;
    $params[] = $searchKeyword;
    $params[] = $searchKeyword;

    $paramTypes .= 'sss';
}

/*
|--------------------------------------------------------------------------
| FILTER SENIMAN
|--------------------------------------------------------------------------
*/

if (!empty($artists)) {

    $placeholders = implode(
        ',',
        array_fill(0, count($artists), '?')
    );

    $where[] = "seniman IN ($placeholders)";

    foreach ($artists as $artist) {
        $params[] = $artist;
        $paramTypes .= 's';
    }
}

/*
|--------------------------------------------------------------------------
| FILTER JENIS KOLEKSI
|--------------------------------------------------------------------------
*/

if (!empty($types)) {

    $placeholders = implode(
        ',',
        array_fill(0, count($types), '?')
    );

    $where[] = "jenis_koleksi IN ($placeholders)";

    foreach ($types as $type) {
        $params[] = $type;
        $paramTypes .= 's';
    }
}

/*
|--------------------------------------------------------------------------
| FILTER LOKASI
|--------------------------------------------------------------------------
*/

if (!empty($locations)) {

    $placeholders = implode(
        ',',
        array_fill(0, count($locations), '?')
    );

    $where[] = "lokasi_pembuatan IN ($placeholders)";

    foreach ($locations as $location) {
        $params[] = $location;
        $paramTypes .= 's';
    }
}

/*
|--------------------------------------------------------------------------
| FILTER TAHUN
|--------------------------------------------------------------------------
| Mendukung tahun tunggal maupun rentang tahun.
|--------------------------------------------------------------------------
*/

$yearConditions = [];

foreach ($years as $year) {

    if (strpos($year, '-') !== false) {

        $yearParts = explode('-', $year, 2);

        if (
            count($yearParts) === 2 &&
            ctype_digit($yearParts[0]) &&
            ctype_digit($yearParts[1])
        ) {

            $startYear = (int) $yearParts[0];
            $endYear = (int) $yearParts[1];

            $yearConditions[] = "(
                tahun_pembuatan BETWEEN ? AND ?
            )";

            $params[] = $startYear;
            $params[] = $endYear;

            $paramTypes .= 'ii';
        }

    } elseif (ctype_digit($year)) {

        $yearConditions[] = "tahun_pembuatan = ?";

        $params[] = (int) $year;

        $paramTypes .= 'i';
    }
}

if (!empty($yearConditions)) {

    $where[] = "(" . implode(' OR ', $yearConditions) . ")";
}

/*
|--------------------------------------------------------------------------
| PILIHAN FILTER OTOMATIS DARI DATABASE
|--------------------------------------------------------------------------
*/

$artistOptions = getCollectionOptions($conn, 'seniman');

$typeOptions = getCollectionOptions($conn, 'jenis_koleksi');

$locationOptions = getCollectionOptions($conn, 'lokasi_pembuatan');

$yearOptions = getCollectionOptions($conn, 'tahun_pembuatan');

/*
|--------------------------------------------------------------------------
| MENGAMBIL DATA KOLEKSI
|--------------------------------------------------------------------------
*/

$sql = "SELECT * FROM koleksi";

if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

$sql .= " ORDER BY id_koleksi DESC";

$stmt = mysqli_prepare($conn, $sql);

if (!empty($params)) {
    bindCollectionParams($stmt, $paramTypes, $params);
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$koleksi = [];

while ($row = mysqli_fetch_assoc($result)) {
    $koleksi[] = $row;
}

mysqli_stmt_close($stmt);

/*
|--------------------------------------------------------------------------
| FUNGSI ALAMAT GAMBAR
|--------------------------------------------------------------------------
| File berada dua tingkat di bawah folder utama proyek.
*/

function collectionImage(string $path): string
{
    return '../../' . ltrim($path, '/');
}

/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

include __DIR__ . '/../../layout/header.php';

?>

<style>

/* FILTER */

.collection-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
}

button:hover {
    background-color: #f8df50;
    color: #000000;
    transition: background-color 0.3s ease;
}

.collection-header h1 {
    margin: 0;
    font-size: 70px;
}

.filter-button {
    width: 65px;
    height: 39px;
    padding: 0;
    background-color: #000000;
    color: white;
    border: none;
    font-size: 15px;
    font-weight: 300;
    cursor: pointer;
}

.filter-close {
    display: flex;
    justify-content: space-between;
    padding: 0;
    margin-bottom: 10px;
}

.close-button {
    width: 25px;
    height: 25px;
}

/* FILTER POPUP */

.filter-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

#filterPopup {
    width: 800px;
    height: 600px;
    padding: 25px;
    background-color: #f8df50;
    border: 1px solid #f8df50;
    border-radius: 10px;
    box-sizing: border-box;
}

.filter-pop-button button {
    background-color: #000000;
    color: white;
    padding: 5px 5px;
    border: none;
    font-size: 15px;
    font-weight: 300;
    cursor: pointer;
    border-radius: 3px;
}

.filter-close h3 {
    font-size: 20px;
    margin: 0;
}

h4 {
    margin-top: 0;
    margin-bottom: 0;
    font-size: 20px;
}

.filter-group input[type="checkbox"] {
    appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #333;
    border-radius: 3px;
    background-color: #f8df50;
    cursor: pointer;
    margin: 0;
}

.filter-group input[type="checkbox"]:checked {
    background-color: #000000;
    border-color: #000000;
}

/* SEARCH COLLECTION */

.filter-and-search {
    display: flex;
}

.collection-search {
    display: flex;
    margin-left: 40px;
    padding-right: 20px;
}

.collection-search input {
    display: flex;
    width: 150px;
    height: 35px;
    margin: 0;
    padding-left: 5px;
    border: 1px solid #000000;
}

.collection-search button:hover {
    background-color: #f8df50;
    color: #000000;
    transition: background-color 0.3s ease;
}

.collection-search button {
    background-color: #000000;
    color: white;
    border: 1px solid #000000;
    box-shadow: none;
    border: 0px solid;
    outline: none;
    margin: 0;
    height: 39px;
}

/* COLLECTION GRID */

.collection-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
    padding: 20px;
}

.collection-card {
    display: block;
    text-decoration: none;
    color: black;
    overflow: hidden;
    transition: 0.3s ease;
}

.collection-card:hover {
    transform: scale(1.2);
    transition: transform 0.3s ease;
}

.collection-card img {
    width: 100%;
    height: auto;
    display: block;
}

.collection-card-content {
    padding: 6px 0;
}

.collection-card-content h3 {
    text-align: left;
    margin: 0;
    font-size: 15px;
    font-weight: 500;
    margin-left: 5px;
}

.collection-card-content p {
    margin: 0;
    font-size: 12px;
    color: #555;
    text-align: left;
    margin-left: 5px;
}

</style>

<!-- MAIN BODY -->

<!-- NAVIGASI -->

<?php include __DIR__ . '/../../layout/navigasi.php'; ?>

<!-- MAIN CONTENT -->

<main>

    <div class="collection-header">

        <h1>Collection</h1>

        <div class="filter-and-search">

            <!-- SEARCH -->

            <form action="" method="get" class="collection-search">

                <input
                    type="text"
                    name="q"
                    placeholder="Search Collection"
                    value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>"
                >

                <button type="submit">
                    Search
                </button>

            </form>

            <!-- FILTER BUTTON -->

            <button
                class="filter-button"
                type="button"
                onclick="document.getElementById('filterPopup').showModal()"
            >
                Filter
            </button>

            <!-- FILTER POPUP -->

            <dialog id="filterPopup">

                <form action="" method="get" class="filter-pop-button">

                    <input
                        type="hidden"
                        name="q"
                        value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>"
                    >

                    <div class="filter-close">

                        <h3>Select a filter option:</h3>

                        <button
                            type="button"
                            class="close-button"
                            onclick="document.getElementById('filterPopup').close()"
                        >
                            X
                        </button>

                    </div>

                    <div class="filter-grid">

                        <!-- ARTIST -->

                        <section class="filter-group">

                            <h4>Artist</h4>

                            <?php foreach ($artistOptions as $artist): ?>

                                <label>

                                    <input
                                        type="checkbox"
                                        name="artist[]"
                                        value="<?= htmlspecialchars($artist, ENT_QUOTES, 'UTF-8') ?>"
                                        <?= in_array($artist, $artists, true) ? 'checked' : '' ?>
                                    >

                                    <?= htmlspecialchars($artist, ENT_QUOTES, 'UTF-8') ?>

                                </label>

                            <?php endforeach; ?>

                        </section>

                        <!-- TYPE -->

                        <section class="filter-group">

                            <h4>Type</h4>

                            <?php foreach ($typeOptions as $type): ?>

                                <label>

                                    <input
                                        type="checkbox"
                                        name="type[]"
                                        value="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
                                        <?= in_array($type, $types, true) ? 'checked' : '' ?>
                                    >

                                    <?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>

                                </label>

                            <?php endforeach; ?>

                        </section>

                        <!-- LOCATION -->

                        <section class="filter-group">

                            <h4>Location</h4>

                            <?php foreach ($locationOptions as $location): ?>

                                <label>

                                    <input
                                        type="checkbox"
                                        name="location[]"
                                        value="<?= htmlspecialchars($location, ENT_QUOTES, 'UTF-8') ?>"
                                        <?= in_array($location, $locations, true) ? 'checked' : '' ?>
                                    >

                                    <?= htmlspecialchars($location, ENT_QUOTES, 'UTF-8') ?>

                                </label>

                            <?php endforeach; ?>

                        </section>

                        <!-- YEAR -->

                        <section class="filter-group">

                            <h4>Year</h4>

                            <?php foreach ($yearOptions as $year): ?>

                                <label>

                                    <input
                                        type="checkbox"
                                        name="year[]"
                                        value="<?= (int) $year ?>"
                                        <?= in_array((string) $year, array_map('strval', $years), true) ? 'checked' : '' ?>
                                    >

                                    <?= (int) $year ?>

                                </label>

                            <?php endforeach; ?>

                        </section>

                    </div>

                    <div style="margin-top: 20px;">

                        <button type="submit">
                            Apply Filter
                        </button>

                        <a
                            href="collection.php"
                            style="color: black; margin-left: 10px;"
                        >
                            Reset Filter
                        </a>

                    </div>

                </form>

            </dialog>

        </div>

    </div>

    <hr>

    <div class="collection-grid">

        <?php if (!empty($koleksi)): ?>

            <?php foreach ($koleksi as $item): ?>

                <div class="collection-card">

                    <a href="detail_koleksi.php?id_koleksi=<?= (int) $item['id_koleksi']; ?>">

                        <img
                            src="<?= htmlspecialchars(collectionImage($item['gambar_koleksi']), ENT_QUOTES, 'UTF-8'); ?>"
                            alt="<?= htmlspecialchars($item['judul_koleksi'], ENT_QUOTES, 'UTF-8'); ?>"
                        >

                        <h3>
                            <?= htmlspecialchars($item['judul_koleksi'], ENT_QUOTES, 'UTF-8'); ?>
                        </h3>

                        <p>
                            <?= htmlspecialchars($item['seniman'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>

                    </a>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p>
                No collection found.
            </p>

        <?php endif; ?>

    </div>

</main>

</div>

<!-- FOOTER -->

<?php include __DIR__ . '/../../layout/footer.php'; ?>
