    <?php
    session_start();

    include 'koneksi.php';

    // Mengambil ID koleksi dari URL
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    // Mengambil data koleksi berdasarkan ID
    $query = "SELECT * FROM koleksi WHERE id_koleksi = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    $koleksi = $stmt->fetch();

    // Jika koleksi tidak ditemukan
    if (!$koleksi) {
        die("Koleksi tidak ditemukan.");
    }

    // Fitur Favorite berdasarkan ID koleksi
    if (isset($_GET['favorite']) && $_GET['favorite'] === 'toggle') {

        // Membuat array favorite jika belum tersedia
        if (!isset($_SESSION['favorite'])) {
            $_SESSION['favorite'] = [];
        }

        // Mengubah status favorite
        if (isset($_SESSION['favorite'][$id])) {
            unset($_SESSION['favorite'][$id]);
        } else {
            $_SESSION['favorite'][$id] = true;
        }

        // Kembali ke halaman detail koleksi yang sama
        header("Location: detail_koleksi.php?id=" . $id);
        exit;
    }

    include 'layout/header.php';
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
    
    <!--MAIN BODY-->

        <!--NAViGASI-->
             <?php include 'layout/navigasi.php'; ?>

<!-- MAIN CONTENT -->
<main>

    <!-- JUDUL KOLEKSI -->
    <h2 class="main-head">
        <?= htmlspecialchars($koleksi['judul_koleksi']) ?>
    </h2>


    <!-- GAMBAR KOLEKSI -->
    <section class="collection-detail">

        <div
            class="collection-bacground"
            style="--artwork-color: #8B6F47;"
        ></div>

        <img
            src="<?= htmlspecialchars($koleksi['gambar_koleksi']) ?>"
            alt="<?= htmlspecialchars($koleksi['judul_koleksi']) ?>"
            class="collection-detail-image"
            id="artworkImage"
        >

    </section>


    <!-- JUDUL DI BAWAH GAMBAR -->
    <h4>
        <?= htmlspecialchars($koleksi['judul_koleksi']) ?>
    </h4>


    <!-- ARTWORK ACTIONS -->
    <div class="artwork-container">

        <div class="artwork-actions">

            <a href="#" id="zoomOut">[−]</a>

            <a href="#" id="zoomIn">[+]</a>

            <a
                href="<?= htmlspecialchars($koleksi['gambar_koleksi']) ?>"
                download
            >
                [Download]
            </a>

            <a href="#" id="shareButton">[Share]</a>

            <a
                href="detail_koleksi.php?id=<?= $id ?>&favorite=toggle"
                class="favorite-btn"
            >

                <?php
                echo isset($_SESSION['favorite'][$id])
                    ? '[♥ Favorite]'
                    : '[♡ Favorite]';
                ?>

            </a>

        </div>

    </div>


    <!-- DESCRIPTION AND OBJECT INFORMATION -->
    <section class="collection-detail">


        <!-- DESCRIPTION -->
        <div class="collection-description">

            <h4>Description</h4>

            <p>
                <?= nl2br(htmlspecialchars($koleksi['deskripsi'] ?? '')) ?>
            </p>


            <!-- LINK RELATED PAGES -->
            <div class="kategori">

                <p><strong>Lihat Juga:</strong></p>

                <div class="link-a">

                    <a href="news.php">News</a>

                    <a href="biography.php">Biografi</a>

                    <a href="privacy-policy.php">Privacy Policy</a>

                    <a href="About us.php">About Us</a>

                    <a href="ticket-ticketprice.php">
                        Ticket & Ticket Price
                    </a>

                </div>

            </div>


            <!-- BACK TO COLLECTION -->
            <a href="collection.php" class="back-button">
                ← Back to Collection
            </a>

        </div>


        <!-- OBJECT INFORMATION -->
        <div class="object-information">

            <h4>Object Information</h4>


            <p><strong>F-number:</strong></p>

            <p>
                <?= htmlspecialchars($koleksi['f_number'] ?? '-') ?>
            </p>


            <p><strong>JH-number:</strong></p>

            <p>
                <?= htmlspecialchars($koleksi['jh_number'] ?? '-') ?>
            </p>


            <p><strong>Object number:</strong></p>

            <p>
                <?= htmlspecialchars($koleksi['object_number'] ?? '-') ?>
            </p>


            <p><strong>Dimensions:</strong></p>

            <p>
                <?= htmlspecialchars($koleksi['dimensi'] ?? '-') ?>
            </p>


            <p><strong>Provenance:</strong></p>

            <p>
                <?= nl2br(htmlspecialchars($koleksi['provenance'] ?? '-')) ?>
            </p>


            <p><strong>Artist:</strong></p>

            <p>
                <?= htmlspecialchars($koleksi['seniman']) ?>
            </p>


            <p><strong>Credits (obliged to state):</strong></p>

            <p>
                <?= htmlspecialchars($koleksi['credits'] ?? '-') ?>
            </p>

        </div>

    </section>

</main>
    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>