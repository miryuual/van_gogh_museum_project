    <?php
    session_start();
    include 'koneksi.php';

    // Menampung kata pencarian
    $keyword = trim($_GET['q'] ?? '');

    // Menampung filter
    $artists = $_GET['artist'] ?? [];
    $types = $_GET['type'] ?? [];
    $locations = $_GET['location'] ?? [];
    $years = $_GET['year'] ?? [];

    // Memastikan nilai filter berbentuk array
    $artists = is_array($artists) ? $artists : [];
    $types = is_array($types) ? $types : [];
    $locations = is_array($locations) ? $locations : [];
    $years = is_array($years) ? $years : [];

    // Menyiapkan kondisi pencarian
    $where = [];
    $params = [];

    // Pencarian berdasarkan judul, seniman, atau deskripsi
    if ($keyword !== '') {
        $where[] = "(
            judul_koleksi LIKE :keyword
            OR seniman LIKE :keyword
            OR deskripsi LIKE :keyword
        )";

        $params['keyword'] = "%$keyword%";
    }

    // Filter seniman
    if (!empty($artists)) {
        $placeholders = [];

        foreach ($artists as $i => $artist) {
            $key = "artist_" . $i;
            $placeholders[] = ":" . $key;
            $params[$key] = $artist;
        }

        $where[] = "seniman IN (" . implode(',', $placeholders) . ")";
    }

    // Filter jenis koleksi
    if (!empty($types)) {
        $placeholders = [];

        foreach ($types as $i => $type) {
            $key = "type_" . $i;
            $placeholders[] = ":" . $key;
            $params[$key] = $type;
        }

        $where[] = "jenis_koleksi IN (" . implode(',', $placeholders) . ")";
    }

    // Filter lokasi
    if (!empty($locations)) {
        $placeholders = [];

        foreach ($locations as $i => $location) {
            $key = "location_" . $i;
            $placeholders[] = ":" . $key;
            $params[$key] = $location;
        }

        $where[] = "lokasi_pembuatan IN (" . implode(',', $placeholders) . ")";
    }

    // Filter tahun
    $yearConditions = [];

    foreach ($years as $i => $year) {
        $key = "year_" . $i;

        if (strpos($year, '-') !== false) {
            // Filter berdasarkan rentang tahun
            [$startYear, $endYear] = explode('-', $year);

            $startKey = $key . "_start";
            $endKey = $key . "_end";

            $yearConditions[] =
                "(tahun_pembuatan BETWEEN :$startKey AND :$endKey)";

            $params[$startKey] = (int) $startYear;
            $params[$endKey] = (int) $endYear;

        } else {
            // Filter berdasarkan satu tahun
            $yearConditions[] = "tahun_pembuatan = :$key";
            $params[$key] = (int) $year;
        }
    }

    if (!empty($yearConditions)) {
        $where[] = "(" . implode(' OR ', $yearConditions) . ")";
    }

    // Menyusun query utama
    $sql = "SELECT * FROM koleksi";

    if (!empty($where)) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    $sql .= " ORDER BY id_koleksi DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $koleksi = $stmt->fetchAll();

    // Memuat header setelah proses PHP
    include 'layout/header.php';
    ?>

    <style>

        /* FILTER */
        .collection-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        button:hover{
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

        .filter-close{
            display: flex;
            justify-content: space-between;
            padding: 0;
            margin-bottom: 10px;
        }

        .close-button{
            width: 25px;
            height: 25px;
        }

        /*filter popup */
        .filter-grid{
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 10px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        
        #filterPopup{
            width: 800px;
            height: 600px;
            padding: 25px;

            background-color:  #f8df50;
            border: 1px solid #f8df50;
            border-radius: 10px;

            box-sizing: border-box;
        }

        .filter-pop-button button{
            background-color: #000000;
            color: white;

            padding: 5px 5px;


            border: none;

            font-size: 15px;
            font-weight: 300;

            cursor: pointer;
            border-radius: 3px;
            
        }
        .filter-close h3{
            font-size: 20px;
            margin: 0 0 0 0;
        }

        h4{
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



        /*search collection*/

        .filter-and-search{
            display: flex;
        }


        .collection-search{
            display: flex;
            margin-left: 40px;
            padding-right: 20px;
        }
        .collection-search input{
            display: flex;
            width: 150px;
            height: 35px;
            margin: 0;
            padding-left: 5px;
            
            border: 1px solid #000000;
        }

        .collection-search button:hover{
            background-color: #f8df50;
            color: #000000;
            transition: background-color 0.3s ease;
        }

        .collection-search button{
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
            grid-template-columns: repeat(5,1fr);
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
        .collection-card:hover{
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
            margin: 0 0 0 0;
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


    
    <!--MAIN BODY-->

        <!--NAViGASI-->
      <?php include 'layout/navigasi.php'; ?>

    <!--main content-->
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
                        value="<?= htmlspecialchars($keyword) ?>"
                    >

                    <button type="submit">Search</button>

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
                            value="<?= htmlspecialchars($keyword) ?>"
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

                                <?php
                                $artistOptions = [
                                    'Vincent van Gogh',
                                    'Claude Monet',
                                    'Henri Rivière',
                                    'Utagawa Kunisada',
                                    'Emile Bernard'
                                ];
                                ?>

                                <?php foreach ($artistOptions as $artist): ?>
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="artist[]"
                                            value="<?= htmlspecialchars($artist) ?>"
                                            <?= in_array($artist, $artists) ? 'checked' : '' ?>
                                        >
                                        <?= htmlspecialchars($artist) ?>
                                    </label>
                                <?php endforeach; ?>

                            </section>


                            <!-- TYPE -->
                            <section class="filter-group">

                                <h4>Type</h4>

                                <?php
                                $typeOptions = [
                                    'Painting',
                                    'Drawing',
                                    'Print',
                                    'Letter',
                                    'Sketch',
                                    "Artist's Book"
                                ];
                                ?>

                                <?php foreach ($typeOptions as $type): ?>
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="type[]"
                                            value="<?= htmlspecialchars($type) ?>"
                                            <?= in_array($type, $types) ? 'checked' : '' ?>
                                        >
                                        <?= htmlspecialchars($type) ?>
                                    </label>
                                <?php endforeach; ?>

                            </section>


                            <!-- LOCATION -->
                            <section class="filter-group">

                                <h4>Location</h4>

                                <?php
                                $locationOptions = [
                                    'Nuenen',
                                    'Paris',
                                    'Arles',
                                    'Saint-Rémy-de-Provence',
                                    'Auvers-sur-Oise',
                                    'Osaka'
                                ];
                                ?>

                                <?php foreach ($locationOptions as $location): ?>
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="location[]"
                                            value="<?= htmlspecialchars($location) ?>"
                                            <?= in_array($location, $locations) ? 'checked' : '' ?>
                                        >
                                        <?= htmlspecialchars($location) ?>
                                    </label>
                                <?php endforeach; ?>

                            </section>


                            <!-- YEAR -->
                            <section class="filter-group">

                                <h4>Year</h4>

                                <?php
                                $yearOptions = [
                                    '1860-1870',
                                    '1871-1880',
                                    '1881',
                                    '1882',
                                    '1883',
                                    '1884',
                                    '1885',
                                    '1886',
                                    '1887',
                                    '1888',
                                    '1889',
                                    '1890',
                                    '1891-1900'
                                ];
                                ?>

                                <?php foreach ($yearOptions as $year): ?>
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="year[]"
                                            value="<?= $year ?>"
                                            <?= in_array($year, $years) ? 'checked' : '' ?>
                                        >
                                        <?= str_replace('-', ' - ', $year) ?>
                                    </label>
                                <?php endforeach; ?>

                            </section>

                        </div>

                        <div style="margin-top: 20px;">
                            <button type="submit">Apply Filter</button>

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

                        <a
                            href="detail_koleksi.php?id=<?= (int) $item['id_koleksi'] ?>"
                            class="collection-card"
                        >

                            <img
                                src="<?= htmlspecialchars($item['gambar_koleksi']) ?>"
                                alt="<?= htmlspecialchars($item['judul_koleksi']) ?>"
                            >

                            <div class="collection-card-content">

                                <h3>
                                    <?= htmlspecialchars($item['judul_koleksi']) ?>
                                </h3>

                                <p>
                                    <?= htmlspecialchars($item['seniman']) ?>
                                </p>

                            </div>

                        </a>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p>
                        No collection found.
                    </p>

                <?php endif; ?>

            </div>
        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>