
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Van Gogh Museum</title>

    <!-- LINK FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap"
        rel="stylesheet"
    >

    <!-- CSS -->
    <link rel="stylesheet" href="/van_gogh_museum/css/General_CSS.css">

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

                    <!-- AKUN PENGGUNA -->

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


            <!-- ISI DROPDOWN -->
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

                    <!-- MENU PENGGUNA -->

                    <a href="/van_gogh_museum/user/dashboard-user.php?tab=account">
                        Profil Saya
                    </a>

                    <a href="/van_gogh_museum/auth/log-out.php">
                        Log out
                    </a>


                <?php else: ?>

                    <!-- MENU PENGUNJUNG -->

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
