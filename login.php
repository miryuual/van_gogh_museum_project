<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$email_benar = "try@mail.com";
$password_benar = "tiket123";

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === $email_benar && $password === $password_benar) {
        session_regenerate_id(true);

        $_SESSION["user_id"] = 1;
        $_SESSION["role"] = "pengunjung";
        $_SESSION["username"] = "Example User";

        header("Location: booking-ticket.php");
        exit;
    } else {
        $pesan = "Email or password is incorrect.";
    }
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login - Van Gogh Museum</title>

<!-- LINK FONT -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        padding: 40px 20px;

        display: flex;
        justify-content: center;
        align-items: center;

        background-image: url("Material/Vangogh-Museum Entrance-D.jpg");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;

        font-family: "Outfit", sans-serif;
        font-optical-sizing: auto;
        font-style: normal;
        font-weight: 400;
    }

    .main-form {
        width: 500px;
        max-width: 100%;
        color: white;
    }

    h2 {
        margin-bottom: 10px;
        text-align: center;
        font-size: 40px;
        font-weight: 600;
        margin-top: 0;
    }

    .description {
        margin-bottom: 25px;
        text-align: center;
        color: white;
        font-size: 15px;
        line-height: 1.6;
        font-weight: 300;
    }

    fieldset {
        padding: 25px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 5px;

        background-color: rgba(0, 0, 0, 0.7);
        color: white;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: inline-block;
        margin-bottom: 8px;
        font-size: 15px;
        font-weight: 400;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        height: 40px;
        padding: 8px 10px;

        border: 1px solid #ccc;
        border-radius: 3px;

        background-color: white;
        color: #222;

        font-family: inherit;
        font-size: 14px;
    }

    input:focus {
        outline: 2px solid #F9D71C;
        border-color: #F9D71C;
    }

    .error {
        margin-bottom: 20px;
        padding: 12px;

        border: 1px solid #ff0000;
        border-radius: 3px;

        background-color: rgba(255, 0, 0, 1);
        color: white;

        font-size: 14px;
    }

    .btn {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    button {
        padding: 10px 20px;
        border: none;
        border-radius: 3px;

        background-color: #F9D71C;
        color: rgb(5, 0, 0);

        font-family: inherit;
        font-size: 15px;
        font-weight: 700;

        cursor: pointer;
        transition: background-color 0.2s;
    }

    button[type="submit"] {
        flex: 1;
    }

    button:hover {
        background-color: #e5c20f;
    }

    .demo-info {
        margin-top: 20px;
        padding: 12px;

        background-color: rgba(255, 255, 255, 0.12);
        border-radius: 3px;

        font-size: 13px;
        line-height: 1.7;
        font-weight: 300;
    }

    .register-link,
    .back-link {
        display: block;
        margin-top: 18px;

        color: #F9D71C;
        text-align: center;
        font-size: 14px;

        text-decoration: none;
    }

    .register-link:hover,
    .back-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        body {
            padding: 25px 15px;
        }

        h2 {
            font-size: 32px;
        }

        fieldset {
            padding: 20px;
        }
    }
</style>

</head>

<body>

<main class="main-form">


    <form action="" method="POST">

        <fieldset>
            <h2>Login</h2>

            <p class="description">
                Welcome to Van Gogh Museum.<br>
                Login to continue planning your museum visit.
            </p>

            <?php if ($pesan !== ""): ?>
                <div class="error" role="alert">
                    <?= htmlspecialchars($pesan, ENT_QUOTES, "UTF-8") ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="example@email.com"
                    autocomplete="username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <div class="btn">
                <button type="submit">Login</button>
            </div>

            <div class="demo-info">
                <strong>Demo Account</strong><br>
                Email: try@mail.com<br>
                Password: tiket123
            </div>

            <a href="register-page.php" class="register-link">
                Don't have an account? Register here
            </a>

            <a href="index.php" class="back-link">
                Back to Home
            </a>

        </fieldset>

    </form>

</main>

</body>
</html>