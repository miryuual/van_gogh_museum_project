<?php
session_start();

include 'koneksi.php';

// Mengambil ID berita dari URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Mengambil data berita berdasarkan ID
$query = "SELECT * FROM berita
          WHERE id_berita = :id
          AND status = 'Dipublikasikan'";

$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);

$berita = $stmt->fetch();

// Jika berita tidak ditemukan
if (!$berita) {
    die("Berita tidak ditemukan atau belum dipublikasikan.");
}

include 'layout/header.php';
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
        display: flex;
        justify-content: center;
        align-items: center;
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
</style>

<!-- MAIN BODY -->

<!-- NAVIGASI -->
<?php include 'layout/navigasi.php'; ?>

<!-- MAIN CONTENT -->
<main>

    <!-- Judul Berita -->
    <h2 class="main-head">
        <?= htmlspecialchars($berita['judul_berita']) ?>
    </h2>

    <!-- Tanggal dan Penulis -->
    <h3 class="news-date">
        <?= date('d/m/Y', strtotime($berita['tanggal_berita'])) ?>
        | <?= htmlspecialchars($berita['penulis']) ?>
    </h3>

    <!-- Ringkasan Berita -->
    <p class="short-detail">
        <?= htmlspecialchars($berita['ringkasan']) ?>
    </p>

    <!-- Gambar Utama dan Isi Berita Pertama -->
    <div class="news-content">

        <img
            src="<?= htmlspecialchars($berita['gambar_utama']) ?>"
            alt="<?= htmlspecialchars($berita['judul_berita']) ?>"
            class="news-image"
        >

        <p>
            <?= nl2br(htmlspecialchars($berita['isi_berita_1'])) ?>
        </p>

    </div>

    <!-- Isi Berita Kedua dan Gambar Tambahan -->
    <div class="news2">

        <section class="news-content2">

            <p>
                <?= nl2br(htmlspecialchars($berita['isi_berita_2'] ?? '')) ?>
            </p>

        </section>

        <section class="news2-image">

            <?php if (!empty($berita['gambar_tambahan'])): ?>

                <img
                    src="<?= htmlspecialchars($berita['gambar_tambahan']) ?>"
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
            <a href="biography.php">Biografi</a>
            <a href="privacy-policy.php">Privacy Policy</a>
            <a href="About us.php">About Us</a>
            <a href="ticket-ticketprice.php">Ticket & Ticket Price</a>

        </div>

    </div>

    <a href="news.php" class="back-button">
        ← Back to News
    </a>

</main>

</div>

<!-- FOOTER -->
<?php include 'layout/footer.php'; ?>