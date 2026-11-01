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

    <!--LINK FONT-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!--CSS-->
        <link rel="stylesheet" href="General_CSS.css">
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
                    $profilePicture = 'Material/default-profile.png';

                    if (!empty($_SESSION['profile_picture'])) {
                        $profilePicture = $_SESSION['profile_picture'];
                    }
                    ?>

                    <img
                        src="<?php echo htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8'); ?>"
                        alt="Foto profil"
                        class="topbar-avatar"
                    >

                    <?php
                    echo htmlspecialchars(
                        $_SESSION['username'] ?? 'Pengguna',
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>

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