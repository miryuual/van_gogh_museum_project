<?php
session_start();

require_once 'koneksi.php';

// Mengambil 3 berita terbaru yang sudah dipublikasikan
$sqlBerita = "
    SELECT
        id_berita,
        judul_berita,
        tanggal_berita,
        ringkasan,
        gambar_utama
    FROM berita
    WHERE status = 'Dipublikasikan'
    ORDER BY tanggal_berita DESC, id_berita DESC
    LIMIT 3
";

$stmtBerita = $pdo->prepare($sqlBerita);
$stmtBerita->execute();
$beritaTerbaru = $stmtBerita->fetchAll();

// Mengambil 5 koleksi terbaru
$sqlKoleksi = "
    SELECT
        id_koleksi,
        judul_koleksi,
        lokasi_pembuatan,
        tahun_pembuatan,
        gambar_koleksi
    FROM koleksi
    ORDER BY id_koleksi DESC
    LIMIT 5
";

$stmtKoleksi = $pdo->prepare($sqlKoleksi);
$stmtKoleksi->execute();
$popularCollections = $stmtKoleksi->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home-Van Gogh Museum</title>

    <!--LINK FONT-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!--CSS-->
        <link rel="stylesheet" href="home_CSS.css">
    
</head>

<body>
<header>

    <section class="identity">
        <a href="index.php">
            <h1>Van Gogh Museum</h1>
        </a>
    </section>

    <form action="search.php" method="get" class="search">
        <input
            type="text"
            name="search"
            placeholder="Search Van Gogh Museum"
            value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            required
        >
        <button type="submit">Search</button>
    </form>

        <div class="user-dropdown">
            <details>
                <summary class="user-dropdown-summary">

                    <?php if (isset($_SESSION['user_id'])): ?>

                        <?php
                        $profilePicture = !empty($_SESSION['profile_picture'])
                            ? $_SESSION['profile_picture']
                            : 'Material/default-profile.png';
                        ?>

                        <img
                            src="<?= htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8'); ?>"
                            alt="Foto profil"
                            class="topbar-avatar"
                        >

                        <?= htmlspecialchars(
                            $_SESSION['username'] ?? 'Pengguna',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                    <?php else: ?>

                        <span>Anonymous</span>

                    <?php endif; ?>

                    <span class="dropdown-arrow">▼</span>

                </summary>

                <div class="user-menu">

                    <?php if (isset($_SESSION['user_id'])): ?>

                        <a href="dashboard-user.php?tab=account">Profil Saya</a>
                        <a href="log-out.php">Log out</a>

                    <?php else: ?>

                        <a href="register-page.php">Register</a>
                        <hr>
                        <a href="login.php">Log in</a>

                    <?php endif; ?>

                </div>
            </details>
        </div>

</header>

    <!--MAIN BODY-->

        <!--NAViGASI-->
             <?php include 'layout/navigasi.php'; ?>


    <!--main content-->
        <main>
            <div class="home-content">
                <section class="main-head">
                    <h2 >Explore the World of Vincent Van Gogh</h2>
                    <p>Jelajahi kehidupan, perjalanan artistik, dan karya-karya Vincent van Gogh yang telah menginspirasi dunia melalui warna, emosi, dan gaya lukisnya yang khas.</p>
                    <a class="btn" href="index.php">Find More →</a>
                </section>


                <section class="starry-night-over-the-rhone">
                    <img src="Material/Starry_Night_Over_the_Rhone.jpg" alt="starry night over the rhone">

                </section>
            </div>

            <hr>

            

     <!--Biografi-->


            <div class="home-bio">
                <section class="bio-portrait">
                    <img src="material/vangogh-selfpotrait.jpg" alt="Van Gogh Self Portrait">
                    <p><i>Van Gogh-Self Portrait</i></p>
                </section>

                <section class="bio-content">
                    <h4>Vincent Willem van Gogh</h4>
                    <p> (30 March 1853 – 29 July 1890) </p>


                    <p><b>Vincent Willem van Gogh</b> (30 Maret 1853 – 29 Juli 1890) adalah seorang seniman Belanda yang dikenal sebagai salah satu tokoh Pasca-Impresionisme (Post-Impressionisme). Lukisan dan gambarnya termasuk di antara karya seni yang paling terkenal, populer, dan bernilai tinggi di dunia.</p>
                    <p>Van Gogh menghabiskan masa dewasa awalnya bekerja di sebuah perusahaan perdagangan karya seni. Setelah sempat bekerja sebagai guru, ia kemudian menjadi pekerja misionaris di sebuah wilayah pertambangan yang sangat miskin. Ia baru mulai menekuni karier sebagai seniman pada tahun 1880. Pada awalnya, Van Gogh menggunakan warna-warna gelap dalam karyanya, hingga ia mengenal Impresionisme dan Neo-Impresionisme ketika berada di Paris. Ia kemudian mengadopsi warna-warna yang lebih cerah dan teknik melukis dari kedua aliran tersebut, lalu mengembangkannya menjadi gaya yang khas dan mudah dikenali. Gaya tersebut berkembang semakin matang selama ia tinggal di Arles, Prancis.</p>
                    <p>Dalam sepuluh tahun terakhir hidupnya, Van Gogh menghasilkan lebih dari 2.000 karya, termasuk sekitar 900 lukisan dan 1.100 gambar serta sketsa. Sebagian besar karyanya yang paling terkenal dibuat dalam dua tahun terakhir hidupnya. Pada masa tersebut, ia mengalami gangguan dalam hubungannya dengan Paul Gauguin dan dalam sebuah episode krisis, Van Gogh memotong sebagian telinga kirinya. Setelah kejadian tersebut, ia mengalami beberapa kali gangguan kesehatan mental yang berujung pada kematiannya karena bunuh diri.</p>
                    <p>Tokoh yang sangat penting dalam kehidupan Van Gogh adalah adiknya, Theo van Gogh, yang terus memberikan dukungan finansial kepadanya dengan penuh perhatian. Hubungan dekat mereka sepanjang hidup terdokumentasikan dalam banyak surat yang mereka tukarkan sejak Agustus 1872. Van Gogh dikenal sebagai salah satu pelopor aliran yang kemudian disebut Ekspresionisme. Ia memberikan pengaruh besar terhadap perkembangan seni abad ke-20, khususnya terhadap kelompok Fauvisme dan Ekspresionisme Jerman.</p>
                    <a class="btna" href="biography.php">Read Full Biography →</a>
                    <hr>
                </section>

            </div>


        <!--RECOMENDED COLLECTION-->

        <section class="featured-collection">
    <a href="collection.php">
        <h5>Popular Collection</h5>
    </a>

            <div class="collection-scroll">

                <?php if (!empty($popularCollections)): ?>

                    <?php foreach ($popularCollections as $collection): ?>

                        <a href="detail_koleksi.php?id=<?= (int) $collection['id_koleksi']; ?>"
                        class="painting-card">

                            <img
                                src="<?= htmlspecialchars($collection['gambar_koleksi'], ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($collection['judul_koleksi'], ENT_QUOTES, 'UTF-8'); ?>"
                            >

                            <div class="painting-info">

                                <h6>
                                    <?= htmlspecialchars($collection['judul_koleksi'], ENT_QUOTES, 'UTF-8'); ?>
                                </h6>

                                <p>
                                    <?php if (!empty($collection['tahun_pembuatan'])): ?>
                                        <?= htmlspecialchars((string) $collection['tahun_pembuatan'], ENT_QUOTES, 'UTF-8'); ?>
                                    <?php endif; ?>

                                    <?php if (!empty($collection['lokasi_pembuatan'])): ?>
                                        <?= !empty($collection['tahun_pembuatan']) ? ', ' : ''; ?>
                                        <?= htmlspecialchars($collection['lokasi_pembuatan'], ENT_QUOTES, 'UTF-8'); ?>
                                    <?php endif; ?>
                                </p>

                            </div>
                        </a>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p>No collections available yet.</p>

                <?php endif; ?>

            </div>
        </section>



     <!--News-->

     <section class="news-content">
            <div class="news-head">
                <a href="news.php">
                    <h4>News</h4>
                </a>
            </div>

            <div class="news-container">

                <?php if (!empty($beritaTerbaru)): ?>

                    <?php foreach ($beritaTerbaru as $berita): ?>

                        <article class="news-card">
                            <a href="news-details.php?id=<?= (int) $berita['id_berita']; ?>">

                                <div class="news-card-image">
                                    <img
                                        src="<?= htmlspecialchars($berita['gambar_utama'], ENT_QUOTES, 'UTF-8'); ?>"
                                        alt="<?= htmlspecialchars($berita['judul_berita'], ENT_QUOTES, 'UTF-8'); ?>"
                                    >
                                </div>

                                <h5>
                                    [<?= date('d/m/y', strtotime($berita['tanggal_berita'])); ?>]
                                    <?= htmlspecialchars($berita['judul_berita'], ENT_QUOTES, 'UTF-8'); ?>
                                </h5>

                                <p>
                                    <?= htmlspecialchars($berita['ringkasan'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>

                            </a>
                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p>There are no news articles available yet.</p>

                <?php endif; ?>

            </div>

            <a class="news-btn" href="news.php">News Page →</a>
        </section>
        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>