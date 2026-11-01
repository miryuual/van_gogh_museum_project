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

// Halaman hanya menerima data dari formulir
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: booking-ticket.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Mengambil data dari formulir
$tanggal_kunjungan = $_POST["visit-date"] ?? "";
$waktu_kunjungan = $_POST["visit-time"] ?? "";
$jenis_tiket = $_POST["ticket-type"] ?? "";
$jumlah_tiket = filter_var(
    $_POST["quantity"] ?? 0,
    FILTER_VALIDATE_INT
);
$nama_pengunjung = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$no_telepon = trim($_POST["phone"] ?? "");

$audio_guide = isset($_POST["audio-guide"]) ? 1 : 0;
$newsletter = isset($_POST["newsletter"]) ? 1 : 0;

// Daftar harga tiket dalam Euro
$daftar_harga = [
    'adult' => 25.00,
    'under18' => 0.00,
    'student_eu' => 16.00,
    'museumkaart' => 0.00,
    'icom' => 0.00,
    'stadspas' => 0.00,
    'vereniging_rembrandt' => 0.00,
    'friends_partner' => 0.00,
    'companion' => 0.00
];

// Nama tiket
$nama_tiket = [
    'adult' => 'Adult',
    'under18' => 'Under 18',
    'student_eu' => 'Student EU/EEA',
    'museumkaart' => 'Museumkaart',
    'icom' => 'ICOM',
    'stadspas' => 'Stadspas',
    'vereniging_rembrandt' => 'Vereniging Rembrandt',
    'friends_partner' => 'Friends & Partner Passes',
    'companion' => 'Companion Ticket'
];

// Validasi data
if (
    empty($tanggal_kunjungan) ||
    empty($waktu_kunjungan) ||
    empty($jenis_tiket) ||
    $jumlah_tiket === false ||
    empty($nama_pengunjung) ||
    empty($email)
) {
    die("Please complete all required fields.");
}

// Validasi jenis tiket
if (!array_key_exists($jenis_tiket, $daftar_harga)) {
    die("Invalid ticket type.");
}

// Validasi jumlah tiket
if ($jumlah_tiket < 1 || $jumlah_tiket > 10) {
    die("Ticket quantity must be between 1 and 10.");
}

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

// Validasi tanggal
$tanggal_obj = DateTime::createFromFormat(
    'Y-m-d',
    $tanggal_kunjungan
);

if (
    !$tanggal_obj ||
    $tanggal_obj->format('Y-m-d') !== $tanggal_kunjungan ||
    $tanggal_kunjungan < date('Y-m-d')
) {
    die("Invalid visit date.");
}

// Validasi waktu
$waktu_obj = DateTime::createFromFormat(
    'H:i',
    $waktu_kunjungan
);

if (
    !$waktu_obj ||
    $waktu_obj->format('H:i') !== $waktu_kunjungan
) {
    die("Invalid visit time.");
}

// Menghitung harga tiket
$harga_satuan = $daftar_harga[$jenis_tiket];

$total_harga = $harga_satuan * $jumlah_tiket;

// Kurs simulasi Euro ke Rupiah
$kurs_euro = 18000;

$total_rupiah = round($total_harga * $kurs_euro);

// Menyimpan data booking dan pembayaran
try {
    $pdo->beginTransaction();

    // Insert data booking
    $query_booking = "
        INSERT INTO booking_tiket (
            user_id,
            tanggal_kunjungan,
            waktu_kunjungan,
            jenis_tiket,
            jumlah_tiket,
            nama_pengunjung,
            email,
            no_telepon,
            harga_satuan,
            total_harga,
            kurs_euro,
            total_rupiah,
            audio_guide,
            newsletter,
            status_booking
        ) VALUES (
            :user_id,
            :tanggal_kunjungan,
            :waktu_kunjungan,
            :jenis_tiket,
            :jumlah_tiket,
            :nama_pengunjung,
            :email,
            :no_telepon,
            :harga_satuan,
            :total_harga,
            :kurs_euro,
            :total_rupiah,
            :audio_guide,
            :newsletter,
            'Pending'
        )
    ";

    $stmt_booking = $pdo->prepare($query_booking);

    $stmt_booking->execute([
        ':user_id' => $user_id,
        ':tanggal_kunjungan' => $tanggal_kunjungan,
        ':waktu_kunjungan' => $waktu_kunjungan,
        ':jenis_tiket' => $jenis_tiket,
        ':jumlah_tiket' => $jumlah_tiket,
        ':nama_pengunjung' => $nama_pengunjung,
        ':email' => $email,
        ':no_telepon' => $no_telepon,
        ':harga_satuan' => $harga_satuan,
        ':total_harga' => $total_harga,
        ':kurs_euro' => $kurs_euro,
        ':total_rupiah' => $total_rupiah,
        ':audio_guide' => $audio_guide,
        ':newsletter' => $newsletter
    ]);

    // Mengambil ID booking yang baru dibuat
    $id_booking = $pdo->lastInsertId();

    // Insert data pembayaran
    $query_pembayaran = "
        INSERT INTO pembayaran (
            id_booking,
            metode_pembayaran,
            nominal_pembayaran,
            status_pembayaran
        ) VALUES (
            :id_booking,
            'QRIS',
            :nominal_pembayaran,
            'Belum Dibayar'
        )
    ";

    $stmt_pembayaran = $pdo->prepare($query_pembayaran);

    $stmt_pembayaran->execute([
        ':id_booking' => $id_booking,
        ':nominal_pembayaran' => $total_rupiah
    ]);

    // Menyimpan seluruh transaksi
    $pdo->commit();

    // Mengambil kembali data booking
    $query_detail = "
        SELECT
            b.*,
            p.metode_pembayaran,
            p.nominal_pembayaran,
            p.status_pembayaran
        FROM booking_tiket b
        INNER JOIN pembayaran p
            ON b.id_booking = p.id_booking
        WHERE b.id_booking = :id_booking
        AND b.user_id = :user_id
    ";

    $stmt_detail = $pdo->prepare($query_detail);

    $stmt_detail->execute([
        ':id_booking' => $id_booking,
        ':user_id' => $user_id
    ]);

    $booking = $stmt_detail->fetch();

    if (!$booking) {
        die("Booking information could not be found.");
    }

} catch (PDOException $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    die(
        "Pemesanan gagal diproses. " .
        "Silakan periksa kembali data dan database."
    );
}

// Format nomor booking
$nomor_booking = 'VGM-' .
    date('Ymd', strtotime($booking['created_at'])) .
    '-' .
    str_pad($booking['id_booking'], 4, '0', STR_PAD_LEFT);

// Format tanggal kunjungan
$tanggal_tampil = date(
    'd F Y',
    strtotime($booking['tanggal_kunjungan'])
);

// Format waktu kunjungan
$waktu_tampil = date(
    'H:i',
    strtotime($booking['waktu_kunjungan'])
);

// Mengambil nama jenis tiket
$jenis_tiket_tampil =
    $nama_tiket[$booking['jenis_tiket']] ?? 'Unknown';

// Format harga
$total_euro_tampil = number_format(
    (float) $booking['total_harga'],
    2,
    '.',
    ','
);

$total_rupiah_tampil = number_format(
    (float) $booking['total_rupiah'],
    0,
    ',',
    '.'
);

// Status pembayaran
$status_pembayaran = $booking['status_pembayaran'];

// Menghindari XSS ketika menampilkan data
function aman($data) {
    return htmlspecialchars(
        (string) $data,
        ENT_QUOTES,
        'UTF-8'
    );
}

include 'layout/header.php';
?>

<style>
    /* SUBTITLE */
    .confirmation-subtitle {
        color: #555555;
        font-size: 16px;
        font-weight: 300;
        margin-bottom: 25px;
    }

    /* PAYMENT STATUS */
    .confirmation-status {
        padding: 18px 22px;
        margin-bottom: 25px;
        border: 1px solid #f91c1c;
        border-radius: 6px;
        background-color: #ff0000;
        color: #ffffff;
    }

    .confirmation-status h3 {
        margin-top: 0;
        margin-bottom: 8px;
        font-size: 17px;
    }

    .confirmation-status p {
        margin: 0;
        font-weight: 400;
        line-height: 1.5;
    }

    /* BOOKING CARD */
    .confirmation-card {
        padding: 25px;
        margin-bottom: 25px;
        background-color: #f7f7f7;
        border: 1px solid #dddddd;
        border-radius: 6px;
        color: #222222;
    }

    .confirmation-card h3 {
        margin-top: 0;
        padding-bottom: 12px;
        border-bottom: 1px solid #cccccc;
        font-size: 21px;
    }

    /* BOOKING ROW */
    .confirmation-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 13px 0;
        border-bottom: 1px solid #dddddd;
        font-size: 15px;
    }

    .confirmation-row span {
        font-weight: 400;
    }

    .confirmation-row strong {
        text-align: right;
        overflow-wrap: anywhere;
    }

    /* TOTAL */
    .confirmation-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding-top: 18px;
        margin-top: 10px;
        font-size: 18px;
        font-weight: 700;
    }

    /* NOTE */
    .confirmation-note {
        padding: 18px 22px;
        margin-bottom: 25px;
        border-left: 4px solid #f9d71c;
        background-color: #ffd000;
        color: #222222;
        line-height: 1.6;
        font-weight: 400;
    }

    .confirmation-note h3 {
        margin-top: 0;
    }

    /* BUTTONS */
    .confirmation-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .confirmation-buttons a {
        display: inline-block;
        padding: 12px 22px;
        border-radius: 4px;
        background-color: #f9d71c;
        color: #111111;
        text-decoration: none;
        font-weight: 700;
        transition: 0.2s;
    }

    .confirmation-buttons a:hover {
        background-color: #000000;
        color: #f9d71c;
    }

    /* RESPONSIVE */
    @media (max-width: 600px) {
        .confirmation-row,
        .confirmation-total {
            align-items: flex-start;
            flex-direction: column;
            gap: 5px;
        }

        .confirmation-row strong {
            text-align: left;
        }

        .confirmation-card {
            padding: 18px;
        }

        .confirmation-buttons {
            flex-direction: column;
        }

        .confirmation-buttons a {
            text-align: center;
        }
    }
</style>

<!-- MAIN BODY -->
<div class="body-layout">

    <!-- NAVIGASI -->
    <?php include 'layout/navigasi.php'; ?>

    <!-- MAIN CONTENT -->
    <main>

        <h2 class="main-head">Booking Confirmation</h2>

        <p class="confirmation-subtitle">
            Your booking has been successfully recorded.
        </p>

        <!-- PAYMENT STATUS -->
        <div class="confirmation-status">

            <h3>
                Payment Status:
                <?= aman($status_pembayaran); ?>
            </h3>

            <?php if ($status_pembayaran === 'Belum Dibayar'): ?>

                <p>
                    Please complete your payment to proceed with
                    your booking.
                </p>

            <?php elseif ($status_pembayaran === 'Menunggu Verifikasi'): ?>

                <p>
                    Your payment proof has been submitted.
                    Please wait for administrator verification.
                </p>

            <?php elseif ($status_pembayaran === 'Paid'): ?>

                <p>
                    Your payment has been verified.
                    Your booking is confirmed.
                </p>

            <?php elseif ($status_pembayaran === 'Rejected'): ?>

                <p>
                    Your payment was rejected.
                    Please contact the museum administrator.
                </p>

            <?php endif; ?>

        </div>

        <!-- BOOKING INFORMATION -->
        <div class="confirmation-card">

            <h3>Booking Information</h3>

            <div class="confirmation-row">
                <span>Booking Number</span>
                <strong>
                    <?= aman($nomor_booking); ?>
                </strong>
            </div>

            <div class="confirmation-row">
                <span>Visitor Name</span>
                <strong>
                    <?= aman($booking['nama_pengunjung']); ?>
                </strong>
            </div>

            <div class="confirmation-row">
                <span>Email</span>
                <strong>
                    <?= aman($booking['email']); ?>
                </strong>
            </div>

            <div class="confirmation-row">
                <span>Visit Date</span>
                <strong>
                    <?= aman($tanggal_tampil); ?>
                </strong>
            </div>

            <div class="confirmation-row">
                <span>Visit Time</span>
                <strong>
                    <?= aman($waktu_tampil); ?>
                </strong>
            </div>

            <div class="confirmation-row">
                <span>Ticket</span>
                <strong>
                    <?= aman($jenis_tiket_tampil); ?>
                    ×
                    <?= aman($booking['jumlah_tiket']); ?>
                </strong>
            </div>

            <div class="confirmation-row">
                <span>Audio Guide</span>
                <strong>
                    <?= $booking['audio_guide'] ? 'Yes' : 'No'; ?>
                </strong>
            </div>

            <div class="confirmation-row">
                <span>Newsletter</span>
                <strong>
                    <?= $booking['newsletter'] ? 'Yes' : 'No'; ?>
                </strong>
            </div>

            <div class="confirmation-row">
                <span>Total (EUR)</span>
                <strong>
                    €<?= aman($total_euro_tampil); ?>
                </strong>
            </div>

            <div class="confirmation-total">
                <span>Total Payment (IDR)</span>
                <strong>
                    Rp<?= aman($total_rupiah_tampil); ?>
                </strong>
            </div>

        </div>

        <!-- IMPORTANT INFORMATION -->
        <div class="confirmation-note">

            <h3>Important Information</h3>

            <p>
                Your booking is currently recorded in our system.
                Please note that your booking will not be confirmed
                until the payment has been completed and verified
                by the museum administrator.
            </p>

            <p>
                Please keep your booking number for future reference.
            </p>

        </div>

        <!-- BUTTONS -->
        <div class="confirmation-buttons">

            <?php if (
                $status_pembayaran === 'Belum Dibayar' ||
                $status_pembayaran === 'Rejected'
            ): ?>

                <a href="payment.php?id=<?= (int) $booking['id_booking']; ?>">
                    Continue to Payment
                </a>

            <?php elseif ($status_pembayaran === 'Menunggu Verifikasi'): ?>

                <a href="payment.php?id=<?= (int) $booking['id_booking']; ?>">
                    View Payment
                </a>

            <?php endif; ?>

            <a href="index.php">
                Back to Home
            </a>

        </div>

    </main>

</div>

<!-- FOOTER -->
