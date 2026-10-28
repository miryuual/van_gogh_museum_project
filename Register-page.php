<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register-Van Gogh Museum</title>

    <!--LINK FONT-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body{
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

        h2{
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

        /* Posisi setiap pilihan koleksi */
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

        /* Posisi checkbox persetujuan */
        .agreement-options .option {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            line-height: 1.5;
        }

        /* Menjaga checkbox tetap sejajar dengan teks */
        .agreement-options input[type="checkbox"] {
            flex-shrink: 0;
            margin-top: 5px;
        }

        /* Tampilan pada layar kecil */
        @media (max-width: 600px) {
            .main-form {
                max-width: calc(100% - 20px);
                margin: 25px auto 0;
            }

            h2 {
                font-size: 30px;
            }
        }

        
    </style>
</head>

<body>

<form action="login.html" method="post" class="main-form">

    

    <fieldset>

        <h2>Registration Form</h2>

        <p>
            <label for="fullname">Full Name</label><br>
            <input
                type="text"
                id="fullname"
                name="fullname"
                placeholder="Enter your full name"
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
                required
            >
        </p>

        <p>
            <label for="birthdate">Date of Birth</label><br>
            <input
                type="date"
                id="birthdate"
                name="birthdate"
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
                required
            >
            <label for="male">Male</label>

            <input
                type="radio"
                id="female"
                name="gender"
                value="female"
            >
            <label for="female">Female</label>
        </p>

        <p>
            <label for="language">Preferred Language</label><br>

            <select id="language" name="language" required>
                <option value="">-- Select Language --</option>
                <option value="english">English</option>
                <option value="dutch">Dutch</option>
                <option value="indonesian">Indonesian</option>
            </select>
        </p>

        <p>
            <label>Collection Interests</label><br>

            <input
                type="checkbox"
                id="painting"
                name="interest"
                value="painting"
            >
            <label for="painting">Paintings</label>

            <br>

            <input
                type="checkbox"
                id="drawing"
                name="interest"
                value="drawing"
            >
            <label for="drawing">Drawings</label>

            <br>

            <input
                type="checkbox"
                id="letters"
                name="interest"
                value="letters"
            >
            <label for="letters">Letters</label>

            <br>

            <input
                type="checkbox"
                id="prints"
                name="interest"
                value="prints"
            >
            <label for="prints">Prints</label>

            <br>
            
            <input
                type="checkbox"
                id="others"
                name="interest"
                value="others"
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
                pattern=".{8,}"
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
                required
            >

            <label for="terms">
                I agree to the Terms and Conditions.
            </label>

            <br>

            <input
                type="checkbox"
                id="privacy"
                name="privacy"
                required
            >

            <label for="privacy">
                I have read and understood the Privacy Policy.
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