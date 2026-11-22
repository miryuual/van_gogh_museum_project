
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/config.php';


// =====================================
// MENGAMBIL ID BERITA DARI URL
// =====================================

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location: news.php");
    exit;
}


// =====================================
// MENGAMBIL DATA BERITA
// =====================================

$query = "
    SELECT *
    FROM berita
    WHERE id_berita = ?
      AND status = 'Dipublikasikan'
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Gagal menyiapkan query berita: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$berita = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


// Jika berita tidak ditemukan
if (!$berita) {
    header("Location: news.php");
    exit;
}


// =====================================
// MENYESUAIKAN PATH GAMBAR
// =====================================

$gambarUtama = !empty($berita['gambar_utama'])
    ? '../../' . ltrim($berita['gambar_utama'], '/')
    : '../../Material/no-image.png';

$gambarTambahan = !empty($berita['gambar_tambahan'])
    ? '../../' . ltrim($berita['gambar_tambahan'], '/')
    : '';


// =====================================
// HEADER
// =====================================

include __DIR__ . '/../../layout/header.php';

?>

<style>

.main-head {
    font-size: 60px;
}


.news-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 20px;
    padding: 40px;
}


.news-image {
    width: auto;
    height: 400px;
    max-width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    object-fit: contain;
    box-sizing: border-box;
}


.news-content p {
    font-size: 18px;
    line-height: 1.6;
    text-align: justify;
    font-weight: 400;
}


.news-date {
    font-size: 16px;
    font-weight: 400;
    color: #555;
    padding-left: 40px;
}


.short-detail {
    font-size: 14px;
    font-weight: 400;
    color: #555;
    padding-left: 40px;
    margin-right: 500px;
}


.news2 {
    display: flex;
}


.news2 img {
    width: 300px;
    height: auto;
    margin-right: 50px;
}


.news-content2 {
    font-size: 18px;
    line-height: 1.6;
    text-align: justify;
    font-weight: 400;
    margin-left: 40px;
    margin-right: 40px;
}


/* LINKS */

.kategori {
    margin-top: 60px;
    margin-bottom: 30px;
    margin-left: 50px;
}


.kategori p {
    margin: 0;
    font-size: 25px;
}


.link-a a {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    color: rgb(0, 0, 0);
    text-decoration: none;
    border-radius: 5px;
    border: 1px solid black;
}


.back-button {
    margin-left: 50px;
    margin-top: 50px;
}


/* RESPONSIVE */

@media (max-width: 760px) {

    .short-detail {
        margin-right: 20px;
    }

    .news2 {
        flex-direction: column;
    }

    .news2 img {
        max-width: 100%;
        margin: 0 20px;
    }

    .news-content {
        padding: 20px;
    }

}

</style>


<!-- MAIN BODY -->

<!-- NAVIGASI -->
<?php include __DIR__ . '/../../layout/navigasi.php'; ?>


<!-- MAIN CONTENT -->
<main>


    <!-- JUDUL BERITA -->
    <h2 class="main-head">

        <?= htmlspecialchars($berita['judul_berita'], ENT_QUOTES, 'UTF-8') ?>

    </h2>


    <!-- TANGGAL DAN PENULIS -->
    <h3 class="news-date">

        <?= date('d/m/Y', strtotime($berita['tanggal_berita'])) ?>

        |

        <?= htmlspecialchars($berita['penulis'], ENT_QUOTES, 'UTF-8') ?>

    </h3>


    <!-- RINGKASAN BERITA -->
    <p class="short-detail">

        <?= htmlspecialchars($berita['ringkasan'], ENT_QUOTES, 'UTF-8') ?>

    </p>


    <!-- GAMBAR UTAMA DAN ISI BERITA PERTAMA -->
    <div class="news-content">

        <img
            src="<?= htmlspecialchars($gambarUtama, ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($berita['judul_berita'], ENT_QUOTES, 'UTF-8') ?>"
            class="news-image"
        >

        <p>

            <?= nl2br(htmlspecialchars($berita['isi_berita_1'], ENT_QUOTES, 'UTF-8')) ?>

        </p>

    </div>


    <!-- ISI BERITA KEDUA DAN GAMBAR TAMBAHAN -->
    <div class="news2">

        <section class="news-content2">

            <p>

                <?= nl2br(htmlspecialchars($berita['isi_berita_2'] ?? '', ENT_QUOTES, 'UTF-8')) ?>

            </p>

        </section>


        <section class="news2-image">

            <?php if (!empty($gambarTambahan)): ?>

                <img
                    src="<?= htmlspecialchars($gambarTambahan, ENT_QUOTES, 'UTF-8') ?>"
                    alt="Additional News Image"
                >

            <?php endif; ?>

        </section>

    </div>


    <!-- KATEGORI / LINK -->
    <div class="kategori">

        <p>Lihat Juga:</p>

        <div class="link-a">

            <a href="news.php">News</a>

            <a href="/van_gogh_museum/page/museum/biography.php">
                Biografi
            </a>

            <a href="/van_gogh_museum/page/museum/privacy-policy.php">
                Privacy Policy
            </a>

            <a href="/van_gogh_museum/page/museum/about-us.php">
                About Us
            </a>

            <a href="/van_gogh_museum/page/ticket/ticket-price.php">
                Ticket & Ticket Price
            </a>

        </div>

    </div>


    <!-- KEMBALI KE NEWS -->
    <a href="news.php" class="back-button">

        ← Back to News

    </a>


</main>


</div>

<!-- FOOTER -->
<?php include __DIR__ . '/../../layout/footer.php'; ?>
