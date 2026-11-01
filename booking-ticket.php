<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan pengunjung sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Koneksi database
require_once 'koneksi.php';

// Mengambil data akun pengunjung yang sedang login
$user_id = $_SESSION["user_id"];

$query = "SELECT full_name, email FROM users WHERE user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch();

// Jika akun tidak ditemukan
if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include 'layout/header.php';
?>

<style>
    .main-head {
        font-size: 90px;
        background-color: rgba(22, 15, 15, 0.8);
        text-align: center;
        padding: 0;
    }

    h4 {
        font-size: 30px;
    }

    .main-p {
        font-weight: 300;
    }

    .booking {
        margin-left: 200px;
        margin-right: 220px;
        border: 1px solid black;
        padding-left: 40px;
        padding-right: 40px;
        padding-bottom: 20px;
        background-color: rgba(22, 15, 15, 0.9);
        color: white;
        font-weight: 300;
    }

    main {
        background-image: url("Material/Vangogh-Museum Entrance-D.jpg");
        color: rgb(252, 252, 252);
        flex: 1;
        background-size: cover;
        background-position: center;
        min-width: 0;
        min-height: 600px;
        background-color: white;
        border-radius: 7px;
        padding: 30px;
    }

    .btn {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-b {
        display: flex;
        gap: 10px;
        margin-top: 20px;
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
        background-color: #000000;
        color: #f8df50;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: #000000;
        color: #f8df50;
        transition: background-color 0.3s ease;
    }

    /* Back button */
    .back-button {
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
        text-decoration: none;
    }
    /* INPUT, SELECT, AND TEXTAREA */
    .booking input:not([type="checkbox"]),
    .booking select {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        margin-top: 7px;

        cursor: pointer;

        background-color: #ffffff;
        color: #222222;

        border: 1px solid #b8b8b8;
        border-radius: 5px;

        font-family: inherit;
        font-size: 15px;
        outline: none;

        transition: border-color 0.2s ease,
                    box-shadow 0.2s ease;
    }

    /* INPUT FOCUS */
    .booking input:not([type="checkbox"]):focus,
    .booking select:focus {
        border-color: #F9D71C;
        box-shadow: 0 0 0 3px rgba(249, 215, 28, 0.2);
    }

    /* FIELDSET */
    .booking fieldset {
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 5px;
        padding: 15px 20px;
        margin-bottom: 10px;
    }

    /* LEGEND */
    .booking legend {
        padding: 0 8px;
        font-weight: 600;
    }

    /* CHECKBOX */
    .booking input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #F9D71C;
        cursor: pointer;
        vertical-align: middle;
    }

    /* CHECKBOX LABEL */
    .booking input[type="checkbox"] + label {
        cursor: pointer;
    }

    /* BUTTON CONTAINER */
    .btn-b {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        align-items: center;
    }

    /* SUBMIT BUTTON */
    .btn-b button[type="submit"] {
        flex: 1;
    }
</style>

<!-- MAIN BODY -->

<!-- NAVIGASI -->
<?php include 'layout/navigasi.php'; ?>

<!-- MAIN CONTENT -->
<main>

    

    <div class="booking">

        <h2 class="main-head">Booking Ticket</h2>

        <p class="main-p">
            Plan your visit to the Van Gogh Museum by selecting your preferred visit date and ticket type.
        </p>

        <form action="booking-ticket-confirmation.php" method="POST">

            <!-- VISIT INFORMATION -->
            <fieldset>
                <legend>Visit Information</legend>

                <p>
                    <label for="visit-date">Visit Date</label><br>

                    <input
                        type="date"
                        id="visit-date"
                        name="visit-date"
                        min="<?= date('Y-m-d') ?>"
                        required
                    >
                </p>

                <p>
                    <label for="visit-time">Preferred time:</label><br>

                    <input
                        type="time"
                        id="visit-time"
                        name="visit-time"
                        required
                    >
                </p>

            </fieldset>

            <br>

            <!-- TICKET TYPE -->
            <fieldset>
                <legend>Ticket Type</legend>

                <p>
                    <label for="ticket-type">Select ticket:</label><br>

                    <select id="ticket-type" name="ticket-type" required>

                        <option value="">-- Select ticket --</option>

                        <option value="adult">
                            Adult - €25.00
                        </option>

                        <option value="under18">
                            Under 18 - Free
                        </option>

                        <option value="student_eu">
                            Student EU/EEA - €16.00
                        </option>

                        <option value="museumkaart">
                            Museumkaart - Free
                        </option>

                        <option value="icom">
                            ICOM - Free
                        </option>

                        <option value="stadspas">
                            Stadspas - Free
                        </option>

                        <option value="vereniging_rembrandt">
                            Vereniging Rembrandt - Free
                        </option>

                        <option value="friends_partner">
                            Friends & Partner Passes - Free
                        </option>

                        <option value="companion">
                            Companion Ticket - Free
                        </option>

                    </select>
                </p>

                <p>
                    <label for="quantity">Number of tickets:</label><br>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="1"
                        max="10"
                        value="1"
                        required
                    >
                </p>

            </fieldset>

            <br>

            <!-- VISITOR INFORMATION -->
            <fieldset>
                <legend>Visitor Information</legend>

                <p>
                    <label for="name">Full name:</label><br>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?= htmlspecialchars($user['full_name'], ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </p>

                <p>
                    <label for="email">Email:</label><br>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </p>

                <p>
                    <label for="phone">Phone number:</label><br>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                    >
                </p>

            </fieldset>

            <!-- ADDITIONAL INFORMATION -->
            <fieldset>
                <legend>Additional Information</legend>

                <p>
                    <input
                        type="checkbox"
                        id="audio-guide"
                        name="audio-guide"
                        value="1"
                    >

                    <label for="audio-guide">
                        I would like an audio guide.
                    </label>
                </p>

                <p>
                    <input
                        type="checkbox"
                        id="newsletter"
                        name="newsletter"
                        value="1"
                    >

                    <label for="newsletter">
                        I would like to receive museum information by email.
                    </label>
                </p>

            </fieldset>

            <!-- BUTTON -->
            <div class="btn-b">
                <button type="submit">
                    Continue to Booking
                </button>

            </div>

        </form>

    </div>

</main>

</div>

<!-- FOOTER -->
<?php include 'layout/footer.php'; ?>