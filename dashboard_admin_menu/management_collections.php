<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



$username = $_SESSION['username'] ?? 'Administrator';

/* ==========================
   DATA KOLEKSI DEMO
   Belum menggunakan database
========================== */
$koleksi = [
    [
        'id' => 1,
        'judul' => 'Almond Blossom',
        'seniman' => 'Vincent van Gogh',
        'tahun' => 1890,
        'gambar' => '../Material/vangoghmuseum-s0176V1962-800.jpg',
        'f_number' => 'F0671',
        'jh_number' => 'JH 1731',
        'object_number' => 's0176V1962',
        'dimensions' => '73.3 cm x 92.4 cm, 94 cm x 112.9 cm, 8 cm',
        'deskripsi' => 'Almond Blossom adalah lukisan karya Vincent van Gogh yang dibuat pada tahun 1890. Lukisan ini menggambarkan cabang-cabang pohon almond yang sedang mekar dengan latar belakang langit biru cerah. Van Gogh menciptakan karya ini sebagai hadiah untuk merayakan kelahiran keponakannya, Vincent Willem van Gogh, anak dari saudaranya Theo. Lukisan ini mencerminkan gaya khas Van Gogh dengan penggunaan warna-warna cerah dan sapuan kuas yang ekspresif, serta menunjukkan ketertarikannya pada alam dan simbolisme kehidupan baru.',
        'provenance' => 'Sent by the artist from Saint-Rémy-de-Provence to his brother Theo van Gogh, Paris, at the end of April 1890; after his death on 25 January 1891, inherited by his widow, Jo van Gogh-Bonger, and their son, Vincent Willem van Gogh, Paris; administered until her death on 2 September 1925 by Jo van Gogh-Bonger, Bussum/Amsterdam/Laren; transferred by Vincent Willem van Gogh, Laren, on 10 July 1962 to the Vincent van Gogh Foundation, Amsterdam; agreement concluded between the Vincent van Gogh Foundation and the State of the Netherlands, in which the preservation and management of the collection, and its placing in the Rijksmuseum Vincent van Gogh, to be realized in Amsterdam, is entrusted to the State, 21 July 1962; given on loan until the opening of the museum on 2 June 1973 to the Stedelijk Museum, Amsterdam; on permanent loan to the Rijksmuseum Vincent van Gogh from 2 June 1973 and at the Van Gogh Museum, Amsterdam, since 1 July 1994.',
        'credits' => 'Van Gogh Museum, Amsterdam (Vincent van Gogh Foundation).'
    ],
    [
        'id' => 2,
        'judul' => 'The Starry Night',
        'seniman' => 'Vincent van Gogh',
        'tahun' => 1889,
        'gambar' => '../Material/starry-night.jpg',
        'f_number' => '-',
        'jh_number' => '-',
        'object_number' => '-',
        'dimensions' => '-',
        'deskripsi' => 'The Starry Night merupakan salah satu karya terkenal Vincent van Gogh yang menggambarkan langit malam dengan pusaran warna dan bintang yang terang.',
        'provenance' => '-',
        'credits' => 'Van Gogh Museum project.'
    ],
    [
        'id' => 3,
        'judul' => 'Sunflowers',
        'seniman' => 'Vincent van Gogh',
        'tahun' => 1889,
        'gambar' => '../Material/sunflowers.jpg',
        'f_number' => '-',
        'jh_number' => '-',
        'object_number' => '-',
        'dimensions' => '-',
        'deskripsi' => 'Sunflowers merupakan karya Vincent van Gogh yang menampilkan bunga matahari dengan dominasi warna kuning.',
        'provenance' => '-',
        'credits' => 'Van Gogh Museum project.'
    ]
];

/* ==========================
   PENCARIAN DAN FILTER TAHUN
========================== */
$keyword = trim($_GET['search'] ?? '');
$tahunFilter = trim($_GET['tahun'] ?? '');

$hasilKoleksi = [];

foreach ($koleksi as $item) {
    $cocokKeyword = (
        $keyword === '' ||
        stripos($item['judul'], $keyword) !== false ||
        stripos($item['seniman'], $keyword) !== false ||
        stripos((string)$item['tahun'], $keyword) !== false
    );

    $cocokTahun = (
        $tahunFilter === '' ||
        (string)$item['tahun'] === $tahunFilter
    );

    if ($cocokKeyword && $cocokTahun) {
        $hasilKoleksi[] = $item;
    }
}

/* ==========================
   DETAIL DAN EDIT KOLEKSI
========================== */
$detailId = (int)($_GET['detail'] ?? 0);
$editId = (int)($_GET['edit'] ?? 0);

$dataDetail = null;
$dataEdit = null;

foreach ($koleksi as $item) {
    if ($item['id'] === $detailId) {
        $dataDetail = $item;
    }

    if ($item['id'] === $editId) {
        $dataEdit = $item;
    }
}

/* ==========================
   SIMULASI FORM
   Belum menyimpan data
========================== */
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'tambah') {
        $pesan = 'Form tambah koleksi berhasil dikirim. Data belum tersimpan permanen karena database belum digunakan.';
    } elseif ($aksi === 'edit') {
        $pesan = 'Form edit koleksi berhasil dikirim. Perubahan belum tersimpan permanen karena database belum digunakan.';
    }
}

/* ==========================
   FUNGSI OUTPUT AMAN
========================== */
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manajemen Koleksi | Van Gogh Museum</title>

    <!-- FONT OUTFIT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-image:
                linear-gradient(
                    to bottom,
                    rgba(0, 0, 0, 0.85),
                    rgba(0, 0, 0, 0.85)
                ),
                url("../Material/Vangogh-Museum Entrance-D.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: "Outfit", sans-serif;
            color: white;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        input,
        select,
        textarea,
        button {
            font-family: "Outfit", sans-serif;
        }

        /* ==========================
           HEADER
        ========================== */

        .dash-topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            min-height: 83px;
            padding: 18px 5%;
            background: white;
            color: black;
            border-top: 4px solid #343744;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .15);
        }

        .dash-brand {
            color: black;
            font-size: 24px;
            font-weight: 800;
        }

        .admin-badge {
            display: inline-block;
            padding: 7px 12px;
            margin-left: 8px;
            background: #F9D71C;
            color: black;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 800;
            vertical-align: middle;
        }

        .dash-account {
            display: flex;
            align-items: center;
            gap: 20px;
            color: black;
            font-size: 13px;
            font-weight: 600;
        }

        .dash-logout {
            display: inline-block;
            padding: 12px 20px;
            background: #F9D71C;
            color: black;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 700;
            transition: background-color .2s;
        }

        .dash-logout:hover {
            background: #e5c20f;
        }

        /* ==========================
           LAYOUT
        ========================== */

        .dash-layout {
            display: flex;
            min-height: calc(100vh - 130px);
        }

        /* ==========================
           SIDEBAR
        ========================== */

        .dash-sidebar {
            width: 265px;
            flex-shrink: 0;
            padding: 26px 16px;
            background: rgba(0, 0, 0, .94);
            border-right: 1px solid rgba(255, 255, 255, .15);
        }

        .dash-side-label {
            padding: 0 13px;
            margin: 0 0 22px;
            color: #F9D71C;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .dash-sidebar a {
            display: block;
            padding: 14px 13px;
            margin-bottom: 5px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            border-radius: 5px;
            transition: background-color .2s, color .2s;
        }

        .dash-sidebar a:hover,
        .dash-sidebar a.active {
            background: #F9D71C;
            color: black;
            font-weight: 700;
        }

        /* ==========================
           KONTEN UTAMA
        ========================== */

        .dash-main {
            flex: 1;
            min-width: 0;
            padding: 35px 4%;
        }

        .dash-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .eyebrow {
            margin: 0 0 12px;
            color: #F9D71C;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .dash-heading h1 {
            margin: 0 0 10px;
            font-size: 32px;
            font-weight: 800;
        }

        .muted {
            color: #eee;
            font-size: 14px;
            font-weight: 300;
            line-height: 1.7;
        }

        .role-badge {
            display: inline-block;
            flex-shrink: 0;
            padding: 8px 13px;
            background: #F9D71C;
            color: black;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 800;
        }

        .dash-section {
            margin-bottom: 30px;
        }

        .section-title {
            margin-bottom: 20px;
        }

        .section-title h2 {
            margin: 0;
            font-size: 25px;
            font-weight: 700;
        }

        /* ==========================
           TOMBOL
        ========================== */

        .button {
            display: inline-block;
            padding: 10px 14px;
            border: 1px solid transparent;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            transition: .2s;
        }

        .button-yellow {
            background: #F9D71C;
            color: black;
        }

        .button-yellow:hover {
            background: #e5c20f;
        }

        .button-outline {
            background: transparent;
            border-color: rgba(255, 255, 255, .4);
            color: white;
        }

        .button-outline:hover {
            color: #F9D71C;
            border-color: #F9D71C;
        }

        /* ==========================
           STATISTIK
        ========================== */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .stat-card {
            padding: 22px;
            background: rgba(0, 0, 0, .78);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 8px;
        }

        .stat-card span {
            color: #eee;
            font-size: 14px;
        }

        .stat-card strong {
            display: block;
            margin: 15px 0;
            color: #F9D71C;
            font-size: 32px;
            font-weight: 800;
        }

        .stat-card small {
            color: #ccc;
            font-size: 12px;
        }

        /* ==========================
           PANEL KONTEN
        ========================== */

        .content-panel {
            padding: 25px;
            margin-bottom: 28px;
            background: rgba(0, 0, 0, .78);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 8px;
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .panel-heading h2,
        .panel-heading h3 {
            font-size: 20px;
            font-weight: 700;
        }

        .panel-heading p {
            margin-top: 6px;
            color: #ccc;
            font-size: 12px;
            line-height: 1.7;
        }

        .yellow-line {
            width: 42px;
            height: 3px;
            margin-top: 12px;
            background: #F9D71C;
        }

        /* ==========================
           SEARCH DAN FILTER
        ========================== */

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 22px;
        }

        .toolbar input,
        .toolbar select {
            min-height: 40px;
            padding: 10px 12px;
            background: white;
            color: #222;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 12px;
            outline: none;
        }

        .toolbar input {
            flex: 1;
            min-width: 180px;
        }

        .toolbar select {
            min-width: 140px;
        }

        /* ==========================
           TABEL KOLEKSI
        ========================== */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 730px;
            border-collapse: collapse;
        }

        th {
            padding: 13px 12px;
            background: #F9D71C;
            color: black;
            font-size: 12px;
            font-weight: 800;
            text-align: left;
        }

        td {
            padding: 13px 12px;
            color: #eee;
            font-size: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, .15);
            vertical-align: middle;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, .05);
        }

        .collection-thumb {
            display: block;
            width: 65px;
            height: 53px;
            object-fit: cover;
            background: #222;
            border-radius: 4px;
        }

        .collection-name {
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: 700;
        }

        .collection-artist {
            color: #bbb;
            font-size: 11px;
        }

        .year-badge {
            display: inline-block;
            padding: 5px 9px;
            color: #F9D71C;
            background: rgba(249, 215, 28, .12);
            border: 1px solid rgba(249, 215, 28, .3);
            border-radius: 4px;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .action-buttons .button {
            padding: 7px 9px;
            font-size: 11px;
        }

        .empty-state {
            padding: 30px;
            color: #ddd;
            text-align: center;
        }

        /* ==========================
           FORM TAMBAH DAN EDIT
        ========================== */

        .notice {
            padding: 13px;
            margin-bottom: 22px;
            color: #f6e8a2;
            background: rgba(249, 215, 28, .1);
            border: 1px solid rgba(249, 215, 28, .4);
            border-radius: 5px;
            font-size: 12px;
            line-height: 1.7;
        }

        .message {
            padding: 13px 16px;
            margin-bottom: 22px;
            color: #fff1a8;
            background: rgba(249, 215, 28, .12);
            border: 1px solid rgba(249, 215, 28, .4);
            border-radius: 5px;
            font-size: 12px;
            line-height: 1.7;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #eee;
            font-size: 12px;
            font-weight: 500;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 12px;
            color: #111;
            background: white;
            border: 1px solid #bbb;
            border-radius: 5px;
            outline: none;
            font-size: 13px;
        }

        .form-control:focus {
            border-color: #F9D71C;
            box-shadow: 0 0 0 2px rgba(249, 215, 28, .15);
        }

        textarea.form-control {
            resize: vertical;
            line-height: 1.7;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }

        /* ==========================
           DETAIL KOLEKSI
        ========================== */

        .detail-layout {
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
            gap: 25px;
        }

        .detail-image {
            display: block;
            width: 100%;
            max-height: 420px;
            object-fit: contain;
            background: rgba(255, 255, 255, .05);
            border-radius: 5px;
        }

        .detail-title {
            margin-bottom: 8px;
            font-size: 25px;
        }

        .detail-artist {
            color: #F9D71C;
            font-size: 13px;
        }

        .detail-description {
            margin-top: 18px;
            color: #ddd;
            font-size: 13px;
            line-height: 1.9;
        }

        .detail-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 15px;
        }

        .object-heading {
            margin: 25px 0 14px;
            font-size: 16px;
        }

        .object-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .object-item {
            padding: 13px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 5px;
            overflow-wrap: anywhere;
        }

        .object-item span {
            display: block;
            margin-bottom: 7px;
            color: #bbb;
            font-size: 11px;
        }

        .object-item strong {
            font-size: 12px;
            font-weight: 500;
        }

        .provenance {
            margin-top: 23px;
            color: #ddd;
            font-size: 12px;
            line-height: 1.9;
            overflow-wrap: anywhere;
        }

        .provenance h4 {
            margin-bottom: 9px;
            color: #F9D71C;
            font-size: 14px;
        }

        .see-also {
            padding-top: 20px;
            margin-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, .2);
        }

        .see-also h4 {
            margin-bottom: 12px;
            font-size: 14px;
        }

        .see-also-links {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .see-also-links a {
            padding: 8px 10px;
            color: white;
            border: 1px solid #555;
            border-radius: 4px;
            font-size: 11px;
        }

        .see-also-links a:hover {
            color: black;
            background: #F9D71C;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #F9D71C;
            font-size: 12px;
            font-weight: 700;
        }

        /* ==========================
           FOOTER
        ========================== */

        .dash-footer {
            padding: 20px;
            background: rgba(0, 0, 0, .95);
            color: #eee;
            border-top: 1px solid rgba(255, 255, 255, .15);
            text-align: center;
            font-size: 13px;
            font-weight: 300;
        }

        /* ==========================
           RESPONSIVE
        ========================== */

        @media (max-width: 1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .dash-sidebar {
                width: 220px;
            }

            .dash-main {
                padding: 30px 3%;
            }

            .detail-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .dash-topbar {
                min-height: auto;
                padding: 15px 4%;
                flex-wrap: wrap;
            }

            .dash-brand {
                font-size: 20px;
            }

            .dash-account {
                gap: 10px;
                font-size: 12px;
            }

            .dash-layout {
                flex-direction: column;
            }

            .dash-sidebar {
                width: 100%;
                padding: 15px;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, .2);
            }

            .dash-side-label {
                margin-bottom: 10px;
            }

            .dash-sidebar a {
                display: inline-block;
                padding: 10px;
                margin: 3px 2px;
                font-size: 12px;
            }

            .dash-main {
                padding: 25px 15px;
            }

            .dash-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .dash-heading h1 {
                font-size: 27px;
            }

            .content-panel {
                padding: 17px;
            }

            .panel-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .form-grid,
            .object-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }
        }

        @media (max-width: 450px) {
            .dash-account {
                width: 100%;
                justify-content: space-between;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .dash-heading h1 {
                font-size: 23px;
            }

            .dash-brand {
                font-size: 19px;
            }
        }
    </style>
</head>

<body>

<!-- ==========================
     HEADER PUTIH
========================== -->
<header class="dash-topbar">
    <div>
        <a href="../dashboard-admin.php" class="dash-brand">
            Van Gogh Museum
        </a>
        <span class="admin-badge">ADMIN</span>
    </div>

    <div class="dash-account">
        <span><?= e($username) ?></span>
        <a href="../logout.php" class="dash-logout">Keluar</a>
    </div>
</header>

<div class="dash-layout">

    <!-- ==========================
         SIDEBAR HITAM
    ========================== -->
    <aside class="dash-sidebar">

        <p class="dash-side-label">MENU PENGELOLA</p>

        <nav>
            <a href="../dashboard-admin.php">Dashboard Utama</a>
            <a href="../index.php">Home</a>
            <a href="management_collections.php" class="active">Manajemen Koleksi</a>
            <a href="management_news.php">Manajemen Berita</a>
            <a href="management_users.php">Manajemen Pengguna</a>
            <a href="management_tickets.php">Manajemen Tiket</a>
            <a href="website_settings.php">Pengaturan Website</a>
            <a href="../logout.php">Logout</a>
        </nav>

    </aside>

    <!-- ==========================
         KONTEN UTAMA
    ========================== -->
    <main class="dash-main">

        <!-- NOTIFIKASI -->
        <?php if ($pesan !== ''): ?>
            <div class="message">
                <?= e($pesan) ?>
            </div>
        <?php endif; ?>

        <!-- JUDUL HALAMAN -->
        <section class="dash-heading">
            <div>
                <p class="eyebrow">PANEL ADMINISTRASI</p>
                <h1>Manajemen Koleksi</h1>
                <p class="muted">
                    Kelola informasi karya seni dalam katalog digital Van Gogh Museum.
                </p>
            </div>

            <span class="role-badge">Administrator</span>
        </section>

        <!-- STATISTIK -->
        <section class="dash-section">
            <div class="section-title">
                <p class="eyebrow">RINGKASAN DATA</p>
                <h2>Statistik Koleksi</h2>
            </div>

            <div class="stats-grid">

                <div class="stat-card">
                    <span>Total Koleksi</span>
                    <strong><?= count($koleksi) ?></strong>
                    <small>Data katalog karya seni</small>
                </div>

                <div class="stat-card">
                    <span>Total Seniman</span>

                    <?php
                    $senimanUnik = [];
                    foreach ($koleksi as $item) {
                        $senimanUnik[$item['seniman']] = true;
                    }
                    ?>

                    <strong><?= count($senimanUnik) ?></strong>
                    <small>Seniman dalam katalog</small>
                </div>

                <div class="stat-card">
                    <span>Hasil Pencarian</span>
                    <strong><?= count($hasilKoleksi) ?></strong>
                    <small>Koleksi sesuai pencarian</small>
                </div>

            </div>
        </section>

        <!-- DAFTAR KOLEKSI -->
        <section class="content-panel">

            <div class="panel-heading">
                <div>
                    <h2>Daftar Koleksi</h2>
                    <p>Daftar karya seni yang tersedia dalam katalog.</p>
                    <div class="yellow-line"></div>
                </div>

                <a href="management_collections.php#form-koleksi"
                   class="button button-yellow">
                    + Tambah Koleksi
                </a>
            </div>

            <!-- FORM PENCARIAN -->
            <form method="GET"
                  action="management_collections.php"
                  class="toolbar">

                <input
                    type="text"
                    name="search"
                    placeholder="Cari judul, seniman, atau tahun..."
                    value="<?= e($keyword) ?>"
                >

                <select name="tahun">
                    <option value="">Semua Tahun</option>

                    <?php
                    $daftarTahun = array_unique(
                        array_column($koleksi, 'tahun')
                    );
                    rsort($daftarTahun);

                    foreach ($daftarTahun as $tahun):
                    ?>
                        <option
                            value="<?= e($tahun) ?>"
                            <?= $tahunFilter === (string)$tahun ? 'selected' : '' ?>
                        >
                            <?= e($tahun) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="button button-yellow">
                    Cari
                </button>

                <a href="management_collections.php"
                   class="button button-outline">
                    Reset
                </a>

            </form>

            <!-- TABEL -->
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Informasi Karya</th>
                            <th>Tahun</th>
                            <th>Object Number</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (count($hasilKoleksi) > 0): ?>

                        <?php foreach ($hasilKoleksi as $item): ?>
                            <tr>
                                <td>
                                    <img
                                        src="<?= e($item['gambar']) ?>"
                                        alt="<?= e($item['judul']) ?>"
                                        class="collection-thumb"
                                    >
                                </td>

                                <td>
                                    <div class="collection-name">
                                        <?= e($item['judul']) ?>
                                    </div>

                                    <div class="collection-artist">
                                        <?= e($item['seniman']) ?>
                                    </div>
                                </td>

                                <td>
                                    <span class="year-badge">
                                        <?= e($item['tahun']) ?>
                                    </span>
                                </td>

                                <td>
                                    <?= e($item['object_number']) ?>
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <a
                                            href="?detail=<?= $item['id'] ?>#detail-koleksi"
                                            class="button button-outline"
                                        >
                                            Detail
                                        </a>

                                        <a
                                            href="?edit=<?= $item['id'] ?>#form-koleksi"
                                            class="button button-yellow"
                                        >
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="5" class="empty-state">
                                Koleksi tidak ditemukan.
                            </td>
                        </tr>

                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </section>

        <!-- DETAIL KOLEKSI -->
        <?php if ($dataDetail !== null): ?>

            <section class="content-panel" id="detail-koleksi">

                <div class="panel-heading">
                    <div>
                        <h2>Detail Koleksi</h2>
                        <p>Informasi lengkap karya yang dipilih.</p>
                        <div class="yellow-line"></div>
                    </div>

                    <a href="management_collections.php"
                       class="button button-outline">
                        Tutup Detail
                    </a>
                </div>

                <div class="detail-layout">

                    <div>
                        <img
                            src="<?= e($dataDetail['gambar']) ?>"
                            alt="<?= e($dataDetail['judul']) ?>"
                            class="detail-image"
                        >

                        <div class="detail-actions">
                            <a
                                href="<?= e($dataDetail['gambar']) ?>"
                                download
                                class="button button-yellow"
                            >
                                Download
                            </a>

                            <a
                                href="../detail_koleksi.php"
                                class="button button-outline"
                            >
                                Share / Halaman Koleksi
                            </a>
                        </div>
                    </div>

                    <div>
                        <h2 class="detail-title">
                            <?= e($dataDetail['judul']) ?>
                        </h2>

                        <p class="detail-artist">
                            <?= e($dataDetail['seniman']) ?>
                            · <?= e($dataDetail['tahun']) ?>
                        </p>

                        <p class="detail-description">
                            <?= e($dataDetail['deskripsi']) ?>
                        </p>

                        <h3 class="object-heading">Object Information</h3>

                        <div class="object-grid">

                            <div class="object-item">
                                <span>F-number</span>
                                <strong><?= e($dataDetail['f_number']) ?></strong>
                            </div>

                            <div class="object-item">
                                <span>JH-number</span>
                                <strong><?= e($dataDetail['jh_number']) ?></strong>
                            </div>

                            <div class="object-item">
                                <span>Object number</span>
                                <strong><?= e($dataDetail['object_number']) ?></strong>
                            </div>

                            <div class="object-item">
                                <span>Dimensions</span>
                                <strong><?= e($dataDetail['dimensions']) ?></strong>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="provenance">
                    <h4>Provenance</h4>
                    <p><?= e($dataDetail['provenance']) ?></p>
                </div>

                <div class="provenance">
                    <h4>Credits</h4>
                    <p><?= e($dataDetail['credits']) ?></p>
                </div>

                <div class="see-also">
                    <h4>Lihat Juga</h4>

                    <div class="see-also-links">
                        <a href="../news.php">News</a>
                        <a href="../biography.php">Biografi</a>
                        <a href="../privacy-policy.php">Privacy Policy</a>
                        <a href="../About%20us.php">About Us</a>
                        <a href="../ticket-ticketprice.php">Ticket &amp; Ticket Price</a>
                    </div>
                </div>

                <a href="../collection.php" class="back-link">
                    &larr; Back to Collection
                </a>

            </section>

        <?php endif; ?>

        <!-- FORM TAMBAH DAN EDIT -->
        <section class="content-panel" id="form-koleksi">

            <div class="panel-heading">
                <div>
                    <h2>
                        <?= $dataEdit ? 'Edit Koleksi' : 'Tambah Koleksi' ?>
                    </h2>

                    <p>
                        Masukkan informasi karya seni melalui formulir berikut.
                    </p>

                    <div class="yellow-line"></div>
                </div>
            </div>

            <div class="notice">
                Formulir ini masih berupa demonstrasi PHP tanpa database.
                Data yang dikirim belum disimpan secara permanen.
            </div>

            <form method="POST"
                  action="management_collections.php#form-koleksi">

                <input
                    type="hidden"
                    name="aksi"
                    value="<?= $dataEdit ? 'edit' : 'tambah' ?>"
                >

                <input
                    type="hidden"
                    name="id"
                    value="<?= e($dataEdit['id'] ?? '') ?>"
                >

                <div class="form-grid">

                    <div class="form-group">
                        <label for="judul">Judul Karya</label>

                        <input
                            class="form-control"
                            type="text"
                            id="judul"
                            name="judul"
                            required
                            value="<?= e($dataEdit['judul'] ?? '') ?>"
                            placeholder="Contoh: Almond Blossom"
                        >
                    </div>

                    <div class="form-group">
                        <label for="seniman">Nama Seniman</label>

                        <input
                            class="form-control"
                            type="text"
                            id="seniman"
                            name="seniman"
                            value="<?= e($dataEdit['seniman'] ?? 'Vincent van Gogh') ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="tahun">Tahun Pembuatan</label>

                        <input
                            class="form-control"
                            type="number"
                            id="tahun"
                            name="tahun"
                            value="<?= e($dataEdit['tahun'] ?? '') ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="gambar">Path Gambar</label>

                        <input
                            class="form-control"
                            type="text"
                            id="gambar"
                            name="gambar"
                            value="<?= e($dataEdit['gambar'] ?? '') ?>"
                            placeholder="../Material/nama-gambar.jpg"
                        >
                    </div>

                    <div class="form-group">
                        <label for="f_number">F-number</label>

                        <input
                            class="form-control"
                            type="text"
                            id="f_number"
                            name="f_number"
                            value="<?= e($dataEdit['f_number'] ?? '') ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="jh_number">JH-number</label>

                        <input
                            class="form-control"
                            type="text"
                            id="jh_number"
                            name="jh_number"
                            value="<?= e($dataEdit['jh_number'] ?? '') ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="object_number">Object Number</label>

                        <input
                            class="form-control"
                            type="text"
                            id="object_number"
                            name="object_number"
                            value="<?= e($dataEdit['object_number'] ?? '') ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="dimensions">Dimensions</label>

                        <input
                            class="form-control"
                            type="text"
                            id="dimensions"
                            name="dimensions"
                            value="<?= e($dataEdit['dimensions'] ?? '') ?>"
                        >
                    </div>

                    <div class="form-group full">
                        <label for="deskripsi">Deskripsi</label>

                        <textarea
                            class="form-control"
                            id="deskripsi"
                            name="deskripsi"
                            rows="5"
                        ><?= e($dataEdit['deskripsi'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group full">
                        <label for="provenance">Provenance</label>

                        <textarea
                            class="form-control"
                            id="provenance"
                            name="provenance"
                            rows="6"
                        ><?= e($dataEdit['provenance'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group full">
                        <label for="credits">Credits</label>

                        <input
                            class="form-control"
                            type="text"
                            id="credits"
                            name="credits"
                            value="<?= e($dataEdit['credits'] ?? 'Van Gogh Museum, Amsterdam (Vincent van Gogh Foundation).') ?>"
                        >
                    </div>

                </div>

                <div class="form-actions">
                    <button type="submit" class="button button-yellow">
                        <?= $dataEdit ? 'Simpan Perubahan' : 'Tambah Koleksi' ?>
                    </button>

                    <a href="management_collections.php"
                       class="button button-outline">
                        Reset
                    </a>
                </div>

            </form>

        </section>

    </main>
</div>

<!-- FOOTER -->
<footer class="dash-footer">
    Proyek pembelajaran website Van Gogh Museum
</footer>

</body>
</html>
