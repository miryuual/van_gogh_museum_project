
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/config.php';

// =====================================
// MENGAMBIL ID KOLEKSI DARI URL
// =====================================

// Mendukung parameter id_koleksi dan id
$id = filter_input(INPUT_GET, 'id_koleksi', FILTER_VALIDATE_INT);

if (!$id) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}

if (!$id || $id <= 0) {
    header("Location: koleksi.php");
    exit;
}

// =====================================
// MENGAMBIL DATA KOLEKSI
// =====================================

$query = "
    SELECT *
    FROM koleksi
    WHERE id_koleksi = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$koleksi = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

// Jika koleksi tidak ditemukan
if (!$koleksi) {
    header("Location: koleksi.php");
    exit;
}

// =====================================
// MENYESUAIKAN PATH GAMBAR
// =====================================

if (!empty($koleksi['gambar_koleksi'])) {
    $gambar = '../../' . ltrim($koleksi['gambar_koleksi'], '/');
} else {
    $gambar = '../../Material/no-image.png';
}

// =====================================
// FAVORIT TERHUBUNG KE DATABASE
// =====================================

$user_id = $_SESSION['user_id'] ?? null;
$isFavorite = false;

// Membuat token keamanan CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// =====================================
// PROSES TOMBOL FAVORITE
// =====================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['favorite_action'])
) {

    // Pengguna harus login
    if (!$user_id) {
        header("Location: ../../login.php");
        exit;
    }

    // Validasi CSRF
    $csrf_token = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        die("Permintaan tidak valid.");
    }

    // Memeriksa apakah koleksi sudah difavoritkan
    $check = mysqli_prepare($conn, "
        SELECT id_favorit
        FROM favorit
        WHERE user_id = ?
          AND id_koleksi = ?
        LIMIT 1
    ");

    mysqli_stmt_bind_param($check, "ii", $user_id, $id);
    mysqli_stmt_execute($check);

    $checkResult = mysqli_stmt_get_result($check);
    $favoriteData = mysqli_fetch_assoc($checkResult);

    mysqli_stmt_close($check);

    if ($favoriteData) {

        // Jika sudah ada, hapus dari favorit
        $delete = mysqli_prepare($conn, "
            DELETE FROM favorit
            WHERE user_id = ?
              AND id_koleksi = ?
        ");

        mysqli_stmt_bind_param($delete, "ii", $user_id, $id);
        mysqli_stmt_execute($delete);

        mysqli_stmt_close($delete);

    } else {

        // Membuat ID favorit baru
        $resultNextId = mysqli_query($conn, "
            SELECT COALESCE(MAX(id_favorit), 0) + 1 AS next_id
            FROM favorit
        ");

        $rowNextId = mysqli_fetch_assoc($resultNextId);
        $nextId = (int) $rowNextId['next_id'];

        // Menambahkan koleksi ke favorit
        $insert = mysqli_prepare($conn, "
            INSERT INTO favorit
            (id_favorit, user_id, id_koleksi, tanggal_favorit)
            VALUES (?, ?, ?, NOW())
        ");

        mysqli_stmt_bind_param($insert, "iii", $nextId, $user_id, $id);
        mysqli_stmt_execute($insert);

        mysqli_stmt_close($insert);
    }

    // Kembali ke halaman detail koleksi
    header("Location: detail_koleksi.php?id_koleksi=" . $id);
    exit;
}

// =====================================
// MEMERIKSA STATUS FAVORIT
// =====================================

if ($user_id) {

    $checkFavorite = mysqli_prepare($conn, "
        SELECT id_favorit
        FROM favorit
        WHERE user_id = ?
          AND id_koleksi = ?
        LIMIT 1
    ");

    mysqli_stmt_bind_param($checkFavorite, "ii", $user_id, $id);
    mysqli_stmt_execute($checkFavorite);

    $favoriteResult = mysqli_stmt_get_result($checkFavorite);
    $isFavorite = (bool) mysqli_fetch_assoc($favoriteResult);

    mysqli_stmt_close($checkFavorite);
}

// =====================================
// HEADER
// =====================================

include __DIR__ . '/../../layout/header.php';

?>

<style>

/*MAIN CONTENT*/
main{

    min-height: 1900px;

}



/* Collection Detail Page CSS */

.main-head{
    margin-bottom: 40px;

}
.collection-detail{
    position: relative;

    width: 100%;
    height: 550px;
}
.collection-bacground{
   position: absolute;

    top: 0;
    left: 0;

    margin-left: 60px;

    width: calc(100% - 60px);
    height: 500px;

    background-color: #d3e1ea;
    border: 1.5px solid #8cb1c8;
}
.collection-detail-image{

    padding: 55px;
    position: absolute;

    top: 0;
    left: 50%;

    transform: translateX(-50%);

    height: 500px;
    width: auto;

    z-index: 2;

}

h4{
    text-align: center;
    margin-top: 10px;
    font-size: 45px;
    margin-bottom: 6px;
}

.artwork-container{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 0px;
    margin-bottom: 40px;
    font-size: 20px;

}
.object-information{
    margin-right: 70px;
    margin-left: 0;
    margin-bottom: 20px;
}
.back-button{
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #000000;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
.kategori{
    margin-top: 60px;
    margin-bottom: 40px;
}
.kategori p{
    margin: 0;
    font-size: 60px;
}

.link-a a{
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    color: rgb(0, 0, 0);
    text-decoration: none;
    border-radius: 5px;
    border: 1px solid black;
}
/* Object Information and Description Section */

.collection-detail{
    display: grid;
    grid-template-columns: repeat(2,1fr);

}

.collection-detail h4{
    font-size: 30px;
    font-weight: 600;
    text-align: left;
    margin-bottom: 10px;
}

.collection-detail p{
    font-size: 18px;
    line-height: 1.5;
    font-weight: 400;
    text-align: justify;
}

.collection-description p{
    margin-right: 80px;
}

.artwork-actions {
    cursor: pointer;
}

</style>

<body>

    <!-- MAIN BODY -->

    <!-- NAVIGASI -->
    <?php include __DIR__ . '/../../layout/navigasi.php'; ?>


    <!-- MAIN CONTENT -->
    <main>

        <!-- JUDUL KOLEKSI -->
        <h2 class="main-head">
            <?= htmlspecialchars($koleksi['judul_koleksi'], ENT_QUOTES, 'UTF-8') ?>
        </h2>


        <!-- GAMBAR KOLEKSI -->
        <section class="collection-detail">

            <div
                class="collection-bacground"
                style="--artwork-color: #8B6F47;"
            ></div>

            <img
                src="<?= htmlspecialchars($gambar, ENT_QUOTES, 'UTF-8') ?>"
                alt="<?= htmlspecialchars($koleksi['judul_koleksi'], ENT_QUOTES, 'UTF-8') ?>"
                class="collection-detail-image"
                id="artworkImage"
            >

        </section>


        <!-- JUDUL DI BAWAH GAMBAR -->
        <h4>
            <?= htmlspecialchars($koleksi['judul_koleksi'], ENT_QUOTES, 'UTF-8') ?>
        </h4>


        <!-- ARTWORK ACTIONS -->
        <div class="artwork-container">

            <div class="artwork-actions">

                <a href="#" id="zoomOut">[−]</a>

                <a href="#" id="zoomIn">[+]</a>

                <a
                    href="<?= htmlspecialchars($gambar, ENT_QUOTES, 'UTF-8') ?>"
                    download
                >
                    [Download]
                </a>

                <a href="#" id="shareButton">[Share]</a>

                <?php if ($user_id): ?>

                    <form
                        method="POST"
                        action="detail_koleksi.php?id_koleksi=<?= (int) $id ?>"
                        style="display:inline;"
                    >

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
                        >

                        <button
                            type="submit"
                            name="favorite_action"
                            value="toggle"
                            class="favorite-btn"
                            style="border:none; background:none; font:inherit; cursor:pointer;"
                        >
                            <?= $isFavorite ? '[♥ Favorite]' : '[♡ Favorite]' ?>
                        </button>

                    </form>

                <?php else: ?>

                    <a href="../../login.php" class="favorite-btn">
                        [♡ Login to Favorite]
                    </a>

                <?php endif; ?>

            </div>

        </div>


        <!-- DESCRIPTION AND OBJECT INFORMATION -->
        <section class="collection-detail">


            <!-- DESCRIPTION -->
            <div class="collection-description">

                <h4>Description</h4>

                <p>
                    <?= nl2br(htmlspecialchars($koleksi['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
                </p>


                <!-- LINK RELATED PAGES -->
                <div class="kategori">

                    <p><strong>Lihat Juga:</strong></p>
                        <div class="link-a">
                            <a href="/van_gogh_museum/page/news/news.php">News</a>
                            <a href="/van_gogh_museum/page/museum/biography.php">Biografi</a>
                            <a href="/van_gogh_museum/page/museum/privacy-policy.php">Privacy Policy</a>
                            <a href="/van_gogh_museum/page/museum/about-us.php">About Us</a>
                            <a href="/van_gogh_museum/page/ticket/ticket-price.php"> Ticket & Ticket Price</a>
                        </div>

                </div>


                <!-- BACK TO COLLECTION -->
                <a href="koleksi.php" class="back-button">
                    ← Back to koleksi
                </a>

            </div>


            <!-- OBJECT INFORMATION -->
            <div class="object-information">

                <h4>Object Information</h4>


                <p><strong>F-number:</strong></p>

                <p>
                    <?= htmlspecialchars($koleksi['f_number'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </p>


                <p><strong>JH-number:</strong></p>

                <p>
                    <?= htmlspecialchars($koleksi['jh_number'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </p>


                <p><strong>Object number:</strong></p>

                <p>
                    <?= htmlspecialchars($koleksi['object_number'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </p>


                <p><strong>Dimensions:</strong></p>

                <p>
                    <?= htmlspecialchars($koleksi['dimensi'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </p>


                <p><strong>Provenance:</strong></p>

                <p>
                    <?= nl2br(htmlspecialchars($koleksi['provenance'] ?? '-', ENT_QUOTES, 'UTF-8')) ?>
                </p>


                <p><strong>Artist:</strong></p>

                <p>
                    <?= htmlspecialchars($koleksi['seniman'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </p>


                <p><strong>Credits (obliged to state):</strong></p>

                <p>
                    <?= htmlspecialchars($koleksi['credits'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                </p>

            </div>

        </section>

    </main>

 </div>

    <!-- FOOTER -->
    <?php include __DIR__ . '/../../layout/footer.php'; ?>
