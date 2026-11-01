<?php
session_start();
require_once 'koneksi.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Mengambil data dari form
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birthdate = $_POST['birthdate'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $language = $_POST['language'] ?? '';
    $interests = $_POST['interest'] ?? [];
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';

    // Validasi data wajib
    if ($fullname === '') {
        $errors[] = "Full Name wajib diisi.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }

    if ($username === '') {
        $errors[] = "Username wajib diisi.";
    }

    if (empty($birthdate)) {
        $errors[] = "Date of Birth wajib diisi.";
    }

    // Validasi password
    if ($password !== $confirmPassword) {
        $errors[] = "Password dan Confirm Password tidak sama.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password minimal 8 karakter.";
    }

    // Validasi persetujuan
    if (!isset($_POST['terms'])) {
        $errors[] = "Silakan setujui Terms and Conditions.";
    }

    if (!isset($_POST['privacy'])) {
        $errors[] = "Silakan setujui Privacy Policy.";
    }

    // Validasi Collection Interests
    if (!is_array($interests)) {
        $interests = [];
    }

    $allowedInterests = [
        'painting',
        'drawing',
        'letters',
        'prints',
        'others'
    ];

    $interests = array_values(
        array_intersect($interests, $allowedInterests)
    );

    // Validasi gender dan bahasa
    if (!in_array($gender, ['male', 'female'], true)) {
        $errors[] = "Pilihan gender tidak valid.";
    }

    if (!in_array($language, ['english', 'dutch', 'indonesian'], true)) {
        $errors[] = "Pilihan bahasa tidak valid.";
    }

    // Memeriksa email dan username
    if (empty($errors)) {

        $check = $pdo->prepare(
            "SELECT user_id FROM users
             WHERE email = :email OR username = :username"
        );

        $check->execute([
            'email' => $email,
            'username' => $username
        ]);

        if ($check->fetch()) {
            $errors[] = "Email atau username sudah digunakan.";
        }
    }

    // Menyimpan data pengguna
    if (empty($errors)) {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $collectionInterests = json_encode($interests);

        try {

            $query = "INSERT INTO users (
                full_name,
                birthdate,
                email,
                gender,
                preferred_language,
                collection_interests,
                username,
                password
            ) VALUES (
                :full_name,
                :birthdate,
                :email,
                :gender,
                :preferred_language,
                :collection_interests,
                :username,
                :password
            )";

            $stmt = $pdo->prepare($query);

            $stmt->execute([
                'full_name' => $fullname,
                'birthdate' => $birthdate,
                'email' => $email,
                'gender' => $gender,
                'preferred_language' => $language,
                'collection_interests' => $collectionInterests,
                'username' => $username,
                'password' => $hashedPassword
            ]);

            // Kembali ke halaman login
            header("Location: login.php?registered=1");
            exit;

        } catch (PDOException $e) {

            $errors[] = "Registrasi gagal. Silakan coba kembali.";

        }
    }
}

// Mempertahankan pilihan Collection Interests
// jika validasi mengalami kesalahan
$selectedInterests = $_POST['interest'] ?? [];

if (!is_array($selectedInterests)) {
    $selectedInterests = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register-Van Gogh Museum</title>

    <!-- LINK FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url("Material/Vangogh-Museum Entrance-D.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;

            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 600;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"],
        form input[type="date"],
        form select {
            width: 700px;
            height: 35px;
            padding: 5px 10px;
            box-sizing: border-box;
        }

        .main-form {
            width: 700px;
            margin-left: 400px;
            margin-top: 60px;
            padding-bottom: 40px;
            color: white;
            font-weight: 300;
        }

        h2 {
            text-align: center;
            font-size: 40px;
            margin-bottom: 10px;
        }

        fieldset {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
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

        /* Ukuran dan warna checkbox serta radio button */
        form input[type="checkbox"],
        form input[type="radio"] {
            width: 17px;
            height: 17px;
            margin: 0 6px 0 5px;
            accent-color: #F9D71C;
            cursor: pointer;
            vertical-align: middle;
        }

        /* Label checkbox dan radio button */
        form input[type="checkbox"] + label,
        form input[type="radio"] + label {
            cursor: pointer;
            vertical-align: middle;
        }

        /* Pengaturan Gender */
        .gender-options {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
        }

        /* Pengaturan Collection Interests */
        .collection-options {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
            margin-top: 8px;
        }

        .collection-options .option {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Pengaturan Terms and Conditions dan Privacy Policy */
        .agreement-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 25px;
        }

        .agreement-options .option {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            line-height: 1.5;
        }

        .agreement-options input[type="checkbox"] {
            flex-shrink: 0;
            margin-top: 5px;
        }

        /* Tampilan pada layar kecil */
        @media (max-width: 600px) {
            .main-form {
                width: auto;
                max-width: calc(100% - 20px);
                margin: 25px auto 0;
            }

            form input[type="text"],
            form input[type="email"],
            form input[type="password"],
            form input[type="date"],
            form select {
                width: 100%;
            }

            h2 {
                font-size: 30px;
            }
        }

        .privacy-inf {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>

<body>

<form action="Register-page.php" method="post" class="main-form">

    <fieldset>

        <h2>Registration Form</h2>

        <!-- Pesan kesalahan -->
        <?php if (!empty($errors)): ?>
            <div style="color: #ff7777; margin-bottom: 15px;">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <p>
            <label for="fullname">Full Name</label><br>
            <input
                type="text"
                id="fullname"
                name="fullname"
                placeholder="Enter your full name"
                value="<?= htmlspecialchars($_POST['fullname'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >
        </p>

        <p>
            <label for="email">Email Address</label><br>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="example@email.com"
                value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >
        </p>

        <p>
            <label for="birthdate">Date of Birth</label><br>
            <input
                type="date"
                id="birthdate"
                name="birthdate"
                value="<?= htmlspecialchars($_POST['birthdate'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >
        </p>

        <p>
            <label>Gender</label><br>

            <input
                type="radio"
                id="male"
                name="gender"
                value="male"
                <?= (($_POST['gender'] ?? '') === 'male') ? 'checked' : '' ?>
                required
            >
            <label for="male">Male</label>

            <input
                type="radio"
                id="female"
                name="gender"
                value="female"
                <?= (($_POST['gender'] ?? '') === 'female') ? 'checked' : '' ?>
            >
            <label for="female">Female</label>
        </p>

        <p>
            <label for="language">Preferred Language</label><br>

            <select id="language" name="language" required>
                <option value="">-- Select Language --</option>

                <option
                    value="english"
                    <?= (($_POST['language'] ?? '') === 'english') ? 'selected' : '' ?>
                >
                    English
                </option>

                <option
                    value="dutch"
                    <?= (($_POST['language'] ?? '') === 'dutch') ? 'selected' : '' ?>
                >
                    Dutch
                </option>

                <option
                    value="indonesian"
                    <?= (($_POST['language'] ?? '') === 'indonesian') ? 'selected' : '' ?>
                >
                    Indonesian
                </option>
            </select>
        </p>

        <p>
            <label>Collection Interests</label><br>

            <input
                type="checkbox"
                id="painting"
                name="interest[]"
                value="painting"
                <?= in_array('painting', $selectedInterests, true) ? 'checked' : '' ?>
            >
            <label for="painting">Paintings</label>

            <br>

            <input
                type="checkbox"
                id="drawing"
                name="interest[]"
                value="drawing"
                <?= in_array('drawing', $selectedInterests, true) ? 'checked' : '' ?>
            >
            <label for="drawing">Drawings</label>

            <br>

            <input
                type="checkbox"
                id="letters"
                name="interest[]"
                value="letters"
                <?= in_array('letters', $selectedInterests, true) ? 'checked' : '' ?>
            >
            <label for="letters">Letters</label>

            <br>

            <input
                type="checkbox"
                id="prints"
                name="interest[]"
                value="prints"
                <?= in_array('prints', $selectedInterests, true) ? 'checked' : '' ?>
            >
            <label for="prints">Prints</label>

            <br>

            <input
                type="checkbox"
                id="others"
                name="interest[]"
                value="others"
                <?= in_array('others', $selectedInterests, true) ? 'checked' : '' ?>
            >
            <label for="others">Others</label>
        </p>

        <p>
            <label for="username">Username</label><br>
            <input
                type="text"
                id="username"
                name="username"
                placeholder="Create your username"
                value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >
        </p>

        <p>
            <label for="password">Password</label><br>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimum 8 characters"
                minlength="8"
                required
            >
        </p>

        <p>
            <label for="confirm-password">Confirm Password</label><br>
            <input
                type="password"
                id="confirm-password"
                name="confirm-password"
                placeholder="Re-enter your password"
                required
            >
        </p>

        <p>
            <input
                type="checkbox"
                id="terms"
                name="terms"
                value="accepted"
                <?= isset($_POST['terms']) ? 'checked' : '' ?>
                required
            >

            <label for="terms">
                I agree to the
                <a class="privacy-inf" href="privacy-policy.php">
                    Terms and Conditions.
                </a>
            </label>

            <br>

            <input
                type="checkbox"
                id="privacy"
                name="privacy"
                value="accepted"
                <?= isset($_POST['privacy']) ? 'checked' : '' ?>
                required
            >

            <label for="privacy">
                I have read and understood the
                <a class="privacy-inf" href="privacy-policy.php">
                    Privacy Policy.
                </a>
            </label>
        </p>

        <div class="btn">
            <button type="submit">Create Account</button>
        </div>

        <a href="login.php" class="register-link">
            Already have an account? Login here
        </a>

        <a href="index.php" class="back-link">
            Back to Home
        </a>

    </fieldset>

</form>

</body>
</html>