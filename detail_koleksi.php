<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/config.php';

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

// =====================================
// FAVORIT TERHUBUNG KE DATABASE
// =====================================

$user_id = $_SESSION['user_id'] ?? null;
$isFavorite = false;

// Token keamanan
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Proses tombol Favorite
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['favorite_action'])
) {
    // Pengguna harus login
    if (!$user_id) {
        header("Location: login.php");
        exit;
    }

    // Validasi CSRF
    $csrf_token = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        die("Permintaan tidak valid.");
    }

    // Memeriksa apakah koleksi sudah difavoritkan
    $check = $pdo->prepare("
        SELECT id_favorit
        FROM favorit
        WHERE user_id = :user_id
          AND id_koleksi = :id_koleksi
        LIMIT 1
    ");

    $check->execute([
        'user_id' => $user_id,
        'id_koleksi' => $id
    ]);

    $favoriteData = $check->fetch();

    if ($favoriteData) {

        // Jika sudah ada, hapus dari favorit
        $delete = $pdo->prepare("
            DELETE FROM favorit
            WHERE user_id = :user_id
              AND id_koleksi = :id_koleksi
        ");

        $delete->execute([
            'user_id' => $user_id,
            'id_koleksi' => $id
        ]);

    } else {

        // Membuat ID favorit baru
        $nextId = $pdo->query("
            SELECT COALESCE(MAX(id_favorit), 0) + 1
            FROM favorit
        ")->fetchColumn();

        // Jika belum ada, tambahkan ke favorit
        $insert = $pdo->prepare("
            INSERT INTO favorit
            (id_favorit, user_id, id_koleksi, tanggal_favorit)
            VALUES
            (:id_favorit, :user_id, :id_koleksi, NOW())
        ");

        $insert->execute([
            'id_favorit' => $nextId,
            'user_id' => $user_id,
            'id_koleksi' => $id
        ]);
    }

    // Kembali ke halaman detail koleksi
    header("Location: detail_koleksi.php?id=" . $id);
    exit;
}

// Memeriksa status favorit pengguna
if ($user_id) {

    $checkFavorite = $pdo->prepare("
        SELECT id_favorit
        FROM favorit
        WHERE user_id = :user_id
          AND id_koleksi = :id_koleksi
        LIMIT 1
    ");

    $checkFavorite->execute([
        'user_id' => $user_id,
        'id_koleksi' => $id
    ]);

    $isFavorite = (bool) $checkFavorite->fetch();
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

                <?php if ($user_id): ?>

                    <form method="POST" action="detail_koleksi.php?id=<?= (int) $id ?>" style="display:inline;">

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

                    <a href="login.php" class="favorite-btn">
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