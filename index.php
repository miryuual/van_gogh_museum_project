
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/config.php';


/*
|--------------------------------------------------------------------------
| FUNGSI PATH GAMBAR
|--------------------------------------------------------------------------
| Menyesuaikan path gambar dari database agar dapat ditampilkan
| dari halaman index.php yang berada di folder utama.
*/

function homeImagePath($path, $folder)
{
    $path = trim((string) $path);

    if ($path === '') {
        return 'Material/no-image.png';
    }

    // Jika path berupa URL, gunakan langsung.
    if (preg_match('/^https?:\/\//i', $path)) {
        return $path;
    }

    // Mengubah pemisah path menjadi slash.
    $path = str_replace('\\', '/', $path);

    // Menghapus awalan slash jika ada.
    $path = ltrim($path, '/');

    // Jika database hanya menyimpan nama file,
    // tambahkan folder upload yang sesuai.
    if (strpos($path, '/') === false) {
        $path = $folder . '/' . $path;
    }

    return $path;
}


// =====================================
// MENGAMBIL 3 BERITA TERBARU
// YANG SUDAH DIPUBLIKASIKAN
// =====================================

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

$resultBerita = mysqli_query($conn, $sqlBerita);

if (!$resultBerita) {
    die("Gagal mengambil data berita: " . mysqli_error($conn));
}

$beritaTerbaru = [];

while ($row = mysqli_fetch_assoc($resultBerita)) {
    $beritaTerbaru[] = $row;
}

mysqli_free_result($resultBerita);


// =====================================
// MENGAMBIL 5 KOLEKSI TERBARU
// =====================================

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

$resultKoleksi = mysqli_query($conn, $sqlKoleksi);

if (!$resultKoleksi) {
    die("Gagal mengambil data koleksi: " . mysqli_error($conn));
}

$popularCollections = [];

while ($row = mysqli_fetch_assoc($resultKoleksi)) {
    $popularCollections[] = $row;
}

mysqli_free_result($resultKoleksi);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home - Van Gogh Museum</title>

    <!-- LINK FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap"
        rel="stylesheet"
    >

    <!-- CSS -->
    <link rel="stylesheet" href="css/home_CSS.css">

</head>

<body>

<header>

    <!-- IDENTITAS WEBSITE -->
    <section class="identity">

        <a href="/van_gogh_museum/index.php">
            <h1>Van Gogh Museum</h1>
        </a>

    </section>


    <!-- FORM PENCARIAN -->
    <form
        action="/van_gogh_museum/search.php"
        method="GET"
        class="search"
    >

        <input
            type="text"
            name="search"
            placeholder="Search Van Gogh Museum"
            value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            required
        >

        <button type="submit">Search</button>

    </form>


    <!-- DROPDOWN PENGGUNA -->
    <div class="user-dropdown">

        <details>

            <summary class="user-dropdown-summary">

                <?php if (
                    !empty($_SESSION['admin_id']) &&
                    ($_SESSION['role'] ?? '') === 'admin'
                ): ?>

                    <!-- AKUN ADMINISTRATOR -->

                    <img
                        src="/van_gogh_museum/assets/logo/Logo_-_Van_Gogh_Museum.png"
                        alt="Foto administrator"
                        class="topbar-avatar"
                    >

                    <?= htmlspecialchars(
                        $_SESSION['admin_name'] ?? 'Administrator',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>


                <?php elseif (
                    !empty($_SESSION['user_id']) &&
                    ($_SESSION['role'] ?? '') === 'pengunjung'
                ): ?>

                    <!-- AKUN PENGUNJUNG -->

                    <?php
                    $profilePicture = '/van_gogh_museum/assets/logo/Logo_-_Van_Gogh_Museum.png';

                    if (!empty($_SESSION['profile_picture'])) {
                        $profilePicture = $_SESSION['profile_picture'];
                    }
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

                    <!-- BELUM LOGIN -->

                    <span>Anonymous</span>

                <?php endif; ?>

                <span class="dropdown-arrow">▼</span>

            </summary>


            <!-- MENU DROPDOWN -->
            <div class="user-menu">

                <?php if (
                    !empty($_SESSION['admin_id']) &&
                    ($_SESSION['role'] ?? '') === 'admin'
                ): ?>

                    <!-- MENU ADMINISTRATOR -->

                    <a href="/van_gogh_museum/admin/index.php">
                        Dashboard Admin
                    </a>

                    <a href="/van_gogh_museum/auth/log-out.php">
                        Log out
                    </a>


                <?php elseif (
                    !empty($_SESSION['user_id']) &&
                    ($_SESSION['role'] ?? '') === 'pengunjung'
                ): ?>

                    <!-- MENU PENGUNJUNG LOGIN -->

                    <a href="/van_gogh_museum/user/dashboard-user.php?tab=account">
                        Profil Saya
                    </a>

                    <a href="/van_gogh_museum/auth/log-out.php">
                        Log out
                    </a>


                <?php else: ?>

                    <!-- MENU PENGUNJUNG BELUM LOGIN -->

                    <a href="/van_gogh_museum/auth/register-page.php">
                        Register
                    </a>

                    <hr>

                    <a href="/van_gogh_museum/auth/login.php">
                        Log in
                    </a>

                <?php endif; ?>

            </div>

        </details>

    </div>

</header>


<!-- MAIN BODY -->

<!-- NAVIGASI -->
<?php include __DIR__ . '/layout/navigasi.php'; ?>


<!-- MAIN CONTENT -->

<main>

    <div class="home-content">

        <section class="main-head">

            <h2>Explore the World of Vincent Van Gogh</h2>

            <p>
                Jelajahi kehidupan, perjalanan artistik, dan karya-karya
                Vincent van Gogh yang telah menginspirasi dunia melalui
                warna, emosi, dan gaya lukisnya yang khas.
            </p>

            <a class="btn" href="page/museum/about-us.php">
                Learn About Us →
            </a>

        </section>


        <section class="starry-night-over-the-rhone">

            <img
                src="assets/images/koleksi/starry_Night_Over_the_Rhone.jpg"
                alt="Starry Night Over the Rhone"
            >

        </section>

    </div>

    <hr>


    <!-- BIOGRAFI -->

    <div class="home-bio">

        <section class="bio-portrait">

            <img
                src="assets/images/koleksi/vangogh-selfpotrait.jpg"
                alt="Van Gogh Self Portrait"
            >

            <p><i>Van Gogh - Self Portrait</i></p>

        </section>


        <section class="bio-content">

            <h4>Vincent Willem van Gogh</h4>

            <p>(30 March 1853 – 29 July 1890)</p>

            <p>
                <b>Vincent Willem van Gogh</b> (30 Maret 1853 – 29 Juli 1890)
                adalah seorang seniman Belanda yang dikenal sebagai salah
                satu tokoh Pasca-Impresionisme (Post-Impressionisme).
                Lukisan dan gambarnya termasuk di antara karya seni yang
                paling terkenal, populer, dan bernilai tinggi di dunia.
            </p>

            <p>
                Van Gogh menghabiskan masa dewasa awalnya bekerja di sebuah
                perusahaan perdagangan karya seni. Setelah sempat bekerja
                sebagai guru, ia kemudian menjadi pekerja misionaris di
                sebuah wilayah pertambangan yang sangat miskin. Ia baru
                mulai menekuni karier sebagai seniman pada tahun 1880.
                Pada awalnya, Van Gogh menggunakan warna-warna gelap dalam
                karyanya, hingga ia mengenal Impresionisme dan
                Neo-Impresionisme ketika berada di Paris. Ia kemudian
                mengadopsi warna-warna yang lebih cerah dan teknik melukis
                dari kedua aliran tersebut, lalu mengembangkannya menjadi
                gaya yang khas dan mudah dikenali. Gaya tersebut berkembang
                semakin matang selama ia tinggal di Arles, Prancis.
            </p>

            <p>
                Dalam sepuluh tahun terakhir hidupnya, Van Gogh menghasilkan
                lebih dari 2.000 karya, termasuk sekitar 900 lukisan dan
                1.100 gambar serta sketsa. Sebagian besar karyanya yang
                paling terkenal dibuat dalam dua tahun terakhir hidupnya.
                Pada masa tersebut, ia mengalami gangguan dalam hubungannya
                dengan Paul Gauguin dan dalam sebuah episode krisis,
                Van Gogh memotong sebagian telinga kirinya. Setelah kejadian
                tersebut, ia mengalami beberapa kali gangguan kesehatan
                mental yang berujung pada kematiannya karena bunuh diri.
            </p>

            <p>
                Tokoh yang sangat penting dalam kehidupan Van Gogh adalah
                adiknya, Theo van Gogh, yang terus memberikan dukungan
                finansial kepadanya dengan penuh perhatian. Hubungan dekat
                mereka sepanjang hidup terdokumentasikan dalam banyak surat
                yang mereka tukarkan sejak Agustus 1872. Van Gogh dikenal
                sebagai salah satu pelopor aliran yang kemudian disebut
                Ekspresionisme. Ia memberikan pengaruh besar terhadap
                perkembangan seni abad ke-20, khususnya terhadap kelompok
                Fauvisme dan Ekspresionisme Jerman.
            </p>

            <a class="btna" href="page/museum/biography.php">
                Read Full Biography →
            </a>

            <hr>

        </section>

    </div>


    <!-- RECOMMENDED COLLECTION -->

    <section class="featured-collection">

        <a href="/van_gogh_museum/page/koleksi/koleksi.php">
            <h5>Popular Collection</h5>
        </a>


        <div class="collection-scroll">

            <?php if (!empty($popularCollections)): ?>

                <?php foreach ($popularCollections as $collection): ?>

                    <?php
                    $collectionImage = homeImagePath(
                        $collection['gambar_koleksi'] ?? '',
                        'uploads/koleksi'
                    );
                    ?>

                    <a
                        href="/van_gogh_museum/page/koleksi/detail_koleksi.php?id_koleksi=<?= (int) $collection['id_koleksi']; ?>"
                        class="painting-card"
                    >

                        <img
                            src="<?= htmlspecialchars($collectionImage, ENT_QUOTES, 'UTF-8'); ?>"
                            alt="<?= htmlspecialchars($collection['judul_koleksi'], ENT_QUOTES, 'UTF-8'); ?>"
                            onerror="this.onerror=null; this.src='/van_gogh_museum/Material/no-image.png';"
                        >

                        <div class="painting-info">

                            <h6>
                                <?= htmlspecialchars(
                                    $collection['judul_koleksi'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </h6>

                            <p>

                                <?php if (!empty($collection['tahun_pembuatan'])): ?>

                                    <?= htmlspecialchars(
                                        (string) $collection['tahun_pembuatan'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                <?php endif; ?>

                                <?php if (!empty($collection['lokasi_pembuatan'])): ?>

                                    <?= !empty($collection['tahun_pembuatan']) ? ', ' : ''; ?>

                                    <?= htmlspecialchars(
                                        $collection['lokasi_pembuatan'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

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


    <!-- NEWS -->

    <section class="news-content">

        <div class="news-head">

            <a href="/van_gogh_museum/page/news/news.php">
                <h4>News</h4>
            </a>

        </div>


        <div class="news-container">

            <?php if (!empty($beritaTerbaru)): ?>

                <?php foreach ($beritaTerbaru as $berita): ?>

                    <?php
                    $newsImage = homeImagePath(
                        $berita['gambar_utama'] ?? '',
                        'uploads/berita'
                    );
                    ?>

                    <article class="news-card">

                        <a href="/van_gogh_museum/page/news/news-details.php?id=<?= (int) $berita['id_berita']; ?>">

                            <div class="news-card-image">

                                <img
                                    src="<?= htmlspecialchars($newsImage, ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?= htmlspecialchars($berita['judul_berita'], ENT_QUOTES, 'UTF-8'); ?>"
                                    onerror="this.onerror=null; this.src='/van_gogh_museum/Material/no-image.png';"
                                >

                            </div>

                            <h5>

                                [<?= !empty($berita['tanggal_berita'])
                                    ? date('d/m/y', strtotime($berita['tanggal_berita']))
                                    : ''; ?>]

                                <?= htmlspecialchars(
                                    $berita['judul_berita'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                            </h5>

                            <p>
                                <?= htmlspecialchars(
                                    $berita['ringkasan'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </p>

                        </a>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <p>There are no news articles available yet.</p>

            <?php endif; ?>

        </div>


        <a class="news-btn" href="/van_gogh_museum/page/news/news.php">
            News Page →
        </a>

    </section>

</main>


</div>


<!-- FOOTER -->
<?php include __DIR__ . '/layout/footer.php'; ?>
