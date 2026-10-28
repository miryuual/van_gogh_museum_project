<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION['username'] ?? 'Administrator';

$menus = [
    ['Home', 'Beranda', 'index.php'],
    ['Manajemen Koleksi', 'Kelola katalog karya seni dan detail koleksi.', 'dashboard_admin_menu/management_collections.php'],
    ['Manajemen Berita', 'Kelola berita dan informasi terbaru museum.', 'dashboard_admin_menu/management_news.php'],
    ['Manajemen Pengguna', 'Lihat akun dan status pengguna website.', 'dashboard_admin_menu/management_users.php'],
    ['Manajemen Tiket', 'Periksa pemesanan dan status tiket pengunjung.', 'dashboard_admin_menu/management_tickets.php'],
    ['Pengaturan Website', 'Kelola informasi dasar website.', 'dashboard_admin_menu/website_settings.php'],
    ['Logout', 'Keluar dari akun pengelola.', 'logout.php']

];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengelola | Van Gogh Museum</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-image:
                linear-gradient(to bottom, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)),
                url("Material/Vangogh-Museum Entrance-D.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: "Outfit", sans-serif;
            color: white;
        }

        a {
            text-decoration: none;
        }

        .dash-topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 18px 5%;
            background: white;
            color: black;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .15);
        }

        .dash-brand {
            color: black;
            font-size: 23px;
            font-weight: 800;
        }

        .admin-badge {
            display: inline-block;
            padding: 5px 10px;
            margin-left: 8px;
            background: #F9D71C;
            color: black;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 800;
            vertical-align: middle;
        }

        .dash-account {
            display: flex;
            align-items: center;
            gap: 18px;
            font-size: 14px;
            font-weight: 600;
        }

        .dash-logout {
            padding: 9px 16px;
            background: #F9D71C;
            color: black;
            border-radius: 4px;
            font-weight: 700;
        }

        .dash-logout:hover {
            background: #e5c20f;
        }

        .dash-layout {
            display: flex;
            min-height: calc(100vh - 130px);
        }

        .dash-sidebar {
            width: 245px;
            flex-shrink: 0;
            padding: 25px 15px;
            background: rgba(0, 0, 0, .85);
            border-right: 1px solid rgba(255, 255, 255, .2);
        }

        .dash-side-label {
            padding: 0 12px;
            margin: 0 0 20px;
            color: #F9D71C;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .dash-sidebar a {
            display: block;
            padding: 12px;
            margin-bottom: 5px;
            color: white;
            font-size: 14px;
            border-radius: 4px;
            transition: background-color .2s, color .2s;
        }

        .dash-sidebar a:hover,
        .dash-sidebar a.active {
            background: #F9D71C;
            color: black;
            font-weight: 700;
        }

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
            margin-bottom: 25px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: #F9D71C;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .dash-heading h1 {
            margin: 0;
            font-size: 34px;
            font-weight: 800;
        }

        .muted {
            color: #eee;
            font-size: 14px;
            font-weight: 300;
        }


        .dash-section {
            margin-bottom: 35px;
        }

        .section-title {
            margin-bottom: 20px;
        }

        .section-title h2 {
            margin: 0;
            font-size: 25px;
            font-weight: 700;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
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
            margin: 12px 0;
            color: #F9D71C;
            font-size: 32px;
            font-weight: 800;
        }

        .stat-card small {
            color: #ccc;
            font-size: 12px;
        }

        .admin-menu-card {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 22px;
            min-height: 210px;
            background: rgba(0, 0, 0, .82);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 8px;
            transition: transform .2s, border-color .2s;
        }

        .admin-menu-card:hover {
            transform: translateY(-4px);
            border-color: #F9D71C;
        }

        .admin-card-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 42px;
            height: 42px;
            margin-bottom: 15px;
            background: #F9D71C;
            color: black;
            border-radius: 6px;
            font-size: 25px;
        }

        .admin-menu-card h3 {
            margin: 0 0 10px;
            font-size: 17px;
            font-weight: 700;
        }

        .admin-menu-card p {
            flex: 1;
            margin: 0 0 20px;
            color: #ddd;
            font-size: 13px;
            font-weight: 300;
            line-height: 1.7;
        }

        .admin-menu-card a {
            color: #F9D71C;
            font-size: 13px;
            font-weight: 700;
        }

        .admin-menu-card a:hover {
            color: white;
        }

        .dash-footer {
            padding: 20px;
            background: rgba(0, 0, 0, .9);
            color: #eee;
            text-align: center;
            font-size: 13px;
            font-weight: 300;
        }

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
        }

        @media (max-width: 700px) {
            .dash-topbar {
                padding: 15px 4%;
                flex-wrap: wrap;
            }

            .dash-brand {
                font-size: 19px;
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

            .dash-heading h1 {
                font-size: 27px;
            }

            .welcome-panel {
                padding: 22px;
            }

            .welcome-panel h2 {
                font-size: 21px;
            }

            .welcome-art {
                font-size: 45px;
            }

            .admin-menu-card {
                min-height: auto;
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

            .welcome-panel {
                padding: 17px;
            }

            .welcome-panel h2 {
                font-size: 18px;
            }

            .welcome-art {
                font-size: 35px;
            }
        }
    </style>
</head>
<body>
    <header class="dash-topbar">
        <a class="dash-brand" href="dashboard-admin.php">
            Van Gogh Museum <span class="admin-badge">ADMIN</span>
        </a>

        <div class="dash-account">
            <span><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
            <a class="dash-logout" href="logout.php">Keluar</a>
        </div>
    </header>

    <div class="dash-layout">
        <aside class="dash-sidebar">
            <p class="dash-side-label">MENU PENGELOLA</p>

            <a href="dashboard-admin.php"
               class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard-admin.php' ? 'active' : '' ?>">
                Dashboard Utama
            </a>
            <?php foreach ($menus as $menu): ?>
                <a href="<?= htmlspecialchars($menu[2], ENT_QUOTES, 'UTF-8'); ?>"
                   class="<?= basename($_SERVER['PHP_SELF']) === $menu[2] ? 'active' : '' ?>">
                    <?= htmlspecialchars($menu[0], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            <?php endforeach; ?>
        </aside>

        <main class="dash-main">
            <div class="dash-heading">
                    <div>
                        <p class="eyebrow">PANEL ADMINISTRASI</p>
                        <h2>Selamat datang, <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>!</h2>
                    </div>
                <span class="admin-badge">Administrator</span>
            </div>

            <section class="dash-section">
                <div class="section-title">
                    <p class="eyebrow">RINGKASAN DATA</p>
                    <h2>Statistik Website</h2>
                </div>

                <div class="stats-grid">
                    <article class="stat-card">
                        <span>Total Koleksi</span>
                        <strong>—</strong>
                        <small>Data katalog karya seni</small>
                    </article>
                    <article class="stat-card">
                        <span>Total Berita</span>
                        <strong>—</strong>
                        <small>Berita dan informasi museum</small>
                    </article>
                    <article class="stat-card">
                        <span>Total Pengguna</span>
                        <strong>—</strong>
                        <small>Akun terdaftar di website</small>
                    </article>
                    <article class="stat-card">
                        <span>Pemesanan Tiket</span>
                        <strong>—</strong>
                        <small>Total pemesanan pengunjung</small>
                    </article>
                </div>
            </section>


        </main>
    </div>

    <footer class="dash-footer">
        Proyek pembelajaran website Van Gogh Museum
    </footer>
</body>
</html>
