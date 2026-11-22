
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/config.php';


// =====================================
// MENGAMBIL BERITA YANG DIPUBLIKASIKAN
// =====================================

$query = "
    SELECT
        id_berita,
        judul_berita,
        tanggal_berita,
        penulis,
        ringkasan,
        gambar_utama
    FROM berita
    WHERE status = 'Dipublikasikan'
    ORDER BY tanggal_berita DESC, id_berita DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Gagal mengambil data berita: " . mysqli_error($conn));
}

$berita = [];

while ($row = mysqli_fetch_assoc($result)) {
    $berita[] = $row;
}

mysqli_free_result($result);


// =====================================
// HEADER
// =====================================

include __DIR__ . '/../../layout/header.php';

?>

<style>

.main-head {
    font-size: 50px;
    font-weight: 600;
}


/* NEWS */

.news-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 55px;
    padding: 20px;
}


.news-card-image {
    width: 330px;
    height: 150px;
    border-radius: 2px;

    object-fit: cover;
    overflow: hidden;

    display: flex;
    justify-content: center;
    align-items: center;

    box-sizing: border-box;
}


.news-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.news-card-image img:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}


.news-card h5 {
    font-size: 18px;
    font-weight: 500;
    margin: 10px 0 5px 0;
    border-bottom: 1px solid #000000;
    padding-bottom: 5px;
}


.news-card p {
    font-size: 12px;
    line-height: 1.4;
    margin: 0;
    color: rgba(0, 0, 0, 0.5);
    margin-bottom: 10px;
}


.read-more-link:hover .read-more {
    background-color: #f8df50;
    color: #000000;
    padding: 2px 5px;
}


/* RESPONSIVE */

@media (max-width: 1200px) {
    .news-container {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 900px) {
    .news-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .news-container {
        grid-template-columns: 1fr;
    }

    .news-card-image {
        width: 100%;
    }
}

</style>


<!-- MAIN BODY -->

<!-- NAVIGASI -->
<?php include __DIR__ . '/../../layout/navigasi.php'; ?>


<!-- MAIN CONTENT -->
<main>

    <h2 class="main-head">Museum News</h2>


    <div class="news-container">

        <?php if (!empty($berita)): ?>

            <?php foreach ($berita as $item): ?>

                <?php
                $gambar = !empty($item['gambar_utama'])
                    ? '../../' . ltrim($item['gambar_utama'], '/')
                    : '../../Material/no-image.png';
                ?>

                <article class="news-card">

                    <a href="news-details.php?id=<?= (int) $item['id_berita'] ?>">

                        <div class="news-card-image">

                            <img
                                src="<?= htmlspecialchars($gambar, ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($item['judul_berita'], ENT_QUOTES, 'UTF-8') ?>"
                            >

                        </div>

                    </a>


                    <h5 class="read-more-link">

                        <a href="news-details.php?id=<?= (int) $item['id_berita'] ?>">

                            <strong class="read-more">
                                <?= htmlspecialchars($item['judul_berita'], ENT_QUOTES, 'UTF-8') ?>
                            </strong>

                        </a>

                    </h5>


                    <p>
                        <?= htmlspecialchars($item['ringkasan'], ENT_QUOTES, 'UTF-8') ?>
                    </p>


                    <p>
                        <?= date('d/m/Y', strtotime($item['tanggal_berita'])) ?>
                    </p>


                    <p class="read-more-link">

                        <a href="news-details.php?id=<?= (int) $item['id_berita'] ?>">

                            <strong class="read-more">
                                Read More →
                            </strong>

                        </a>

                    </p>

                </article>

            <?php endforeach; ?>


        <?php else: ?>

            <p>Belum ada berita yang dipublikasikan.</p>

        <?php endif; ?>

    </div>

</main>


</div>

<!-- FOOTER -->
<?php include __DIR__ . '/../../layout/footer.php'; ?>
