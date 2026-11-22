
<?php

// Memulai session jika belum aktif.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| AUTENTIKASI ADMINISTRATOR
|--------------------------------------------------------------------------
| Hanya akun administrator yang dapat menggunakan halaman pengelola.
*/

if (empty($_SESSION['admin_id'])) {
    header("Location: /van_gogh_museum/auth/login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| FUNGSI ESCAPE HTML
|--------------------------------------------------------------------------
*/

function admin_e($value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

/*
|--------------------------------------------------------------------------
| NOTIFIKASI
|--------------------------------------------------------------------------
*/

function admin_flash(string $message, string $type = 'success'): void
{
    if ($message === '') {
        return;
    }

    $class = $type === 'error'
        ? 'admin-alert admin-alert-error'
        : 'admin-alert';

    ?>
    <div class="<?= admin_e($class) ?>">
        <?= admin_e($message) ?>
    </div>
    <?php
}

/*
|--------------------------------------------------------------------------
| HEADER DAN SIDEBAR ADMIN
|--------------------------------------------------------------------------
*/

function admin_start(string $active, string $title, string $description = ''): void
{
    $name = $_SESSION['admin_name'] ?? $_SESSION['username'] ?? 'Administrator';

    $menu = [
        'dashboard' => ['index.php', 'Dashboard'],
        'koleksi' => ['koleksi-admin.php', 'Kelola Koleksi'],
        'tiket' => ['tiket-admin.php', 'Booking Tiket'],
        'berita' => ['berita-admin.php', 'Kelola Berita'],
        'pengguna' => ['pengguna-admin.php', 'Data Pengguna'],
    ];

    ?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= admin_e($title) ?> - Van Gogh Museum</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link
            href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap"
            rel="stylesheet"
        >

        <link rel="stylesheet" href="/van_gogh_museum/css/admin-panel.css">
    </head>

    <body class="admin-page">

    <header class="admin-topbar">

        <a class="admin-brand" href="/van_gogh_museum/admin/index.php">
            <span>Van Gogh Museum</span>
        </a>

        <div class="admin-topbar-right">

            <span class="admin-topbar-label">
                ADMINISTRATION
            </span>

            <span class="admin-user">
                <?= admin_e($name) ?>
            </span>

        </div>

    </header>

    <div class="admin-shell">

        <aside class="admin-sidebar">

            <!-- LOGO SIDEBAR -->
            <div class="admin-sidebar-logo">

                <img
                    src="/van_gogh_museum/assets/logo/Logo_-_Van_Gogh_Museum.png"
                    alt="Van Gogh Museum Logo"
                >

            </div>

            <div class="admin-sidebar-heading">
                PENGELOLAAN MUSEUM
            </div>

            <!-- MENU SIDEBAR -->
            <nav class="admin-menu">

                <?php foreach ($menu as $key => $item): ?>

                    <a
                        class="admin-menu-link <?= $active === $key ? 'is-active' : '' ?>"
                        href="<?= admin_e($item[0]) ?>"
                    >
                        <span>
                            <?= admin_e($item[1]) ?>
                        </span>
                    </a>

                <?php endforeach; ?>

            </nav>

            <!-- MENU BAGIAN BAWAH -->
            <div class="admin-sidebar-bottom">

                <a
                    href="/van_gogh_museum/index.php"
                    class="admin-side-secondary"
                >
                    Lihat Website
                </a>

                <a
                    href="/van_gogh_museum/auth/log-out.php"
                    class="admin-side-secondary"
                >
                    Keluar
                </a>

            </div>

        </aside>

        <main class="admin-main">

            <div class="admin-page-heading">

                <div>

                    <div class="admin-eyebrow">
                        VAN GOGH MUSEUM / ADMIN
                    </div>

                    <h1><?= admin_e($title) ?></h1>

                    <?php if ($description !== ''): ?>

                        <p><?= admin_e($description) ?></p>

                    <?php endif; ?>

                </div>

            </div>

    <?php
}

/*
|--------------------------------------------------------------------------
| FOOTER ADMIN
|--------------------------------------------------------------------------
*/

function admin_end(): void
{
    ?>

        </main>

    </div>

    <footer class="admin-footer">

        <div class="footer-left">

            <p><b>Van Gogh Museum</b></p>
            <p>Museumplein 6, 1071 DJ Amsterdam, Netherlands</p>

            <section class="footer-left-bottom">
                <p><b>&copy; Van Gogh Museum, Amsterdam</b></p>
            </section>

            <p>Collection: Vincent van Gogh Foundation</p>

        </div>

        <div class="footer-middle">

            <p><b>Contact</b></p>
            <p>+31 (0)20 570 5200</p>
            <p>info@vangoghmuseum.nl</p>
            <p>www.vangoghmuseum.nl</p>

        </div>

        <div class="footer-right">

            <p><b>Website Project</b></p>
            <p>Dibuat oleh: Dinda Nur Alisa Putri | NIM: 250911718464</p>
            <p>&copy; 2026 Diploma Vokasi Perpustakaan Digital</p>
            <p>Universitas Negeri Malang</p>

        </div>

    </footer>

    </body>
    </html>

    <?php
}
