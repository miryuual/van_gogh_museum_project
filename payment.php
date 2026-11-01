<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id_booking = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id_booking || $id_booking < 1) {
    die("ID booking tidak valid.");
}

// Ambil data booking dan pembayaran milik pengguna yang sedang login
$query = "SELECT
            b.*,
            p.id_pembayaran,
            p.metode_pembayaran,
            p.nominal_pembayaran,
            p.bukti_pembayaran,
            p.status_pembayaran,
            p.tanggal_pembayaran
          FROM booking_tiket b
          INNER JOIN pembayaran p
            ON b.id_booking = p.id_booking
          WHERE b.id_booking = :id_booking
            AND b.user_id = :user_id
          LIMIT 1";

$stmt = $pdo->prepare($query);
$stmt->execute([
    'id_booking' => $id_booking,
    'user_id' => $user_id
]);

$booking = $stmt->fetch();

if (!$booking) {
    die("Data booking tidak ditemukan.");
}

// Daftar nama tiket
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

$jenis_tiket = $nama_tiket[$booking['jenis_tiket']] ?? $booking['jenis_tiket'];

// Proses upload bukti pembayaran
$pesan = '';
$jenis_pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($booking['status_pembayaran'] === 'Paid') {
        $pesan = "Pembayaran booking ini sudah diverifikasi.";
        $jenis_pesan = "error";

    } elseif ($booking['status_pembayaran'] === 'Menunggu Verifikasi') {
        $pesan = "Bukti pembayaran sudah dikirim dan sedang menunggu verifikasi.";
        $jenis_pesan = "error";

    } elseif (
        !isset($_FILES['bukti_pembayaran']) ||
        $_FILES['bukti_pembayaran']['error'] !== UPLOAD_ERR_OK
    ) {
        $pesan = "Silakan pilih file bukti pembayaran terlebih dahulu.";
        $jenis_pesan = "error";

    } else {

        $file = $_FILES['bukti_pembayaran'];

        // Maksimal ukuran file 2 MB
        if ($file['size'] > 2 * 1024 * 1024) {
            $pesan = "Ukuran file maksimal 2 MB.";
            $jenis_pesan = "error";

        } else {

            // Validasi tipe file berdasarkan MIME
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);

            $tipe_diizinkan = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
            ];

            if (!isset($tipe_diizinkan[$mime])) {
                $pesan = "Format file harus JPG, PNG, atau WEBP.";
                $jenis_pesan = "error";

            } else {

                $folder = __DIR__ . '/uploads/bukti-pembayaran/';

                if (!is_dir($folder)) {
                    mkdir($folder, 0755, true);
                }

                // Nama file dibuat unik
                $ekstensi = $tipe_diizinkan[$mime];
                $nama_file = 'booking_' . $id_booking . '_' .
                             bin2hex(random_bytes(8)) . '.' . $ekstensi;

                $lokasi_file = $folder . $nama_file;

                if (move_uploaded_file($file['tmp_name'], $lokasi_file)) {

                    try {
                        $update = $pdo->prepare(
                            "UPDATE pembayaran
                             SET bukti_pembayaran = :bukti,
                                 status_pembayaran = 'Menunggu Verifikasi',
                                 tanggal_pembayaran = NOW()
                             WHERE id_booking = :id_booking"
                        );

                        $update->execute([
                            'bukti' => 'uploads/bukti-pembayaran/' . $nama_file,
                            'id_booking' => $id_booking
                        ]);

                        header("Location: payment.php?id=" . $id_booking . "&uploaded=1");
                        exit;

                    } catch (PDOException $e) {
                        if (file_exists($lokasi_file)) {
                            unlink($lokasi_file);
                        }

                        $pesan = "Bukti pembayaran gagal disimpan.";
                        $jenis_pesan = "error";
                    }

                } else {
                    $pesan = "File gagal diunggah. Silakan coba kembali.";
                    $jenis_pesan = "error";
                }
            }
        }
    }
}

// Pesan setelah berhasil upload
if (isset($_GET['uploaded']) && $_GET['uploaded'] == '1') {
    $pesan = "Bukti pembayaran berhasil dikirim dan menunggu verifikasi.";
    $jenis_pesan = "success";

    // Ambil ulang status pembayaran setelah upload
    $stmt->execute([
        'id_booking' => $id_booking,
        'user_id' => $user_id
    ]);

    $booking = $stmt->fetch();
}

// Format nomor booking
$nomor_booking = 'VGM-' .
    date('Ymd', strtotime($booking['created_at'])) . '-' .
    str_pad($booking['id_booking'], 4, '0', STR_PAD_LEFT);

// Format tanggal dan waktu kunjungan
$tanggal_kunjungan = date(
    'd F Y',
    strtotime($booking['tanggal_kunjungan'])
);

$waktu_kunjungan = date(
    'H:i',
    strtotime($booking['waktu_kunjungan'])
);

// Format total pembayaran
$total_euro = number_format(
    (float) $booking['total_harga'],
    2,
    ',',
    '.'
);

$total_rupiah = 'Rp ' . number_format(
    (float) $booking['total_rupiah'],
    0,
    ',',
    '.'
);

$status = $booking['status_pembayaran'];

include 'layout/header.php';
?>

<style>
    .payment-page {
        width: 85%;
        max-width: 900px;
        margin: 50px auto;
        color: #ffffff;
        flex: 1;
        box-sizing: border-box;
    }

    .payment-container h1 {
        text-align: center;
        margin-bottom: 10px;
    }

    .payment-container > p {
        text-align: center;
        margin-bottom: 30px;
    }

    .payment-card {
        background: rgba(255, 255, 255, 0.95);
        color: #222;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .payment-card h2 {
        margin-top: 0;
        margin-bottom: 20px;
    }

    .payment-detail {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .payment-detail strong {
        text-align: right;
    }

    .total-payment {
        font-size: 18px;
        border-bottom: none;
        margin-top: 10px;
    }

    .qris-simulation {
        text-align: center;
        margin: 25px 0;
    }

    .qris-placeholder {
        width: 200px;
        height: 200px;
        margin: 15px auto;
        border: 3px dashed #777;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: #f4f4f4;
        color: #222;
    }

    .qris-placeholder span {
        font-size: 32px;
        font-weight: bold;
    }

    .qris-placeholder p {
        font-size: 12px;
        font-weight: bold;
    }

    .payment-card input[type="file"] {
        display: block;
        width: 100%;
        margin: 12px 0;
    }

    .payment-button,
    .back-button {
        display: inline-block;
        padding: 12px 20px;
        background: #F9D71C;
        color: #222;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        cursor: pointer;
        margin-top: 15px;
    }

    .payment-button:hover,
    .back-button:hover {
        background: #000000;
        color: #f9d71c;
    }

    .payment-message {
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        background: #eee;
        color: #222;
    }

    .payment-message.success {
        border-left: 5px solid #27864a;
    }

    .payment-message.error {
        border-left: 5px solid #c0392b;
    }

    .payment-card small {
        display: block;
        color: #555;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .payment-page {
            width: 100%;
            margin: 20px auto;
        }

        .payment-card {
            padding: 18px;
        }

        .payment-detail {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 480px) {
        .payment-detail {
            flex-direction: column;
            gap: 5px;
        }

        .payment-detail strong {
            text-align: left;
        }
    }
</style>

<!-- MAIN BODY -->
<div class="body-layout">

    <!-- NAVIGASI -->

    <!-- MAIN CONTENT -->
    <main class="payment-page">

        <section class="payment-container">

            <h1 style= "color:black;" >Payment</h1>

            <p style="color:black;">
                Complete your booking payment using the QRIS simulation below.
            </p>

            <?php if ($pesan !== ''): ?>

                <div class="payment-message <?php echo htmlspecialchars($jenis_pesan, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?>
                </div>

            <?php endif; ?>

            <!-- BOOKING INFORMATION -->
            <div class="payment-card">

                <h2>Booking Information</h2>

                <div class="payment-detail">
                    <span>Booking Number</span>
                    <strong>
                        <?php echo htmlspecialchars($nomor_booking, ENT_QUOTES, 'UTF-8'); ?>
                    </strong>
                </div>

                <div class="payment-detail">
                    <span>Visitor Name</span>
                    <strong>
                        <?php echo htmlspecialchars($booking['nama_pengunjung'], ENT_QUOTES, 'UTF-8'); ?>
                    </strong>
                </div>

                <div class="payment-detail">
                    <span>Email</span>
                    <strong>
                        <?php echo htmlspecialchars($booking['email'], ENT_QUOTES, 'UTF-8'); ?>
                    </strong>
                </div>

                <div class="payment-detail">
                    <span>Visit Date</span>
                    <strong>
                        <?php echo htmlspecialchars($tanggal_kunjungan, ENT_QUOTES, 'UTF-8'); ?>
                    </strong>
                </div>

                <div class="payment-detail">
                    <span>Visit Time</span>
                    <strong>
                        <?php echo htmlspecialchars($waktu_kunjungan, ENT_QUOTES, 'UTF-8'); ?>
                    </strong>
                </div>

                <div class="payment-detail">
                    <span>Ticket</span>
                    <strong>
                        <?php echo htmlspecialchars($jenis_tiket, ENT_QUOTES, 'UTF-8'); ?>
                        × <?php echo (int) $booking['jumlah_tiket']; ?>
                    </strong>
                </div>

                <hr>

                <div class="payment-detail">
                    <span>Total (EUR)</span>
                    <strong>
                        €<?php echo $total_euro; ?>
                    </strong>
                </div>

                <div class="payment-detail total-payment">
                    <span>Total Payment</span>
                    <strong>
                        <?php echo $total_rupiah; ?>
                    </strong>
                </div>

            </div>

            <!-- PAYMENT METHOD -->
            <div class="payment-card">

                <h2>Payment Method</h2>

                <p><strong>QRIS</strong></p>

                <div class="qris-simulation">

                    <div class="qris-placeholder">
                        <span>QRIS</span>
                        <p>SIMULATION ONLY</p>
                    </div>

                    <p>
                        This is a payment simulation for academic prototype purposes.
                        This QR code is not active and cannot receive real payments.
                    </p>

                </div>

                <div class="payment-detail">
                    <span>Payment Status</span>
                    <strong>
                        <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                    </strong>
                </div>

                <?php if ($status === 'Belum Dibayar'): ?>

                    <form
                        method="POST"
                        enctype="multipart/form-data"
                        action="payment.php?id=<?php echo (int) $id_booking; ?>"
                    >

                        <label for="bukti_pembayaran">
                            Upload Payment Proof
                        </label>

                        <input
                            type="file"
                            name="bukti_pembayaran"
                            id="bukti_pembayaran"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                        >

                        <small>
                            Accepted formats: JPG, PNG, WEBP.
                            Maximum size: 2 MB.
                        </small>

                        <button type="submit" class="payment-button">
                            Submit Payment Proof
                        </button>

                    </form>

                <?php elseif ($status === 'Menunggu Verifikasi'): ?>

                    <p>
                        Your payment proof has been submitted.
                        Please wait for the administrator to verify it.
                    </p>

                    <?php if (!empty($booking['bukti_pembayaran'])): ?>

                        <p>
                            <a
                                href="<?php echo htmlspecialchars($booking['bukti_pembayaran'], ENT_QUOTES, 'UTF-8'); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                View Uploaded Proof
                            </a>
                        </p>

                    <?php endif; ?>

                <?php elseif ($status === 'Paid'): ?>

                    <p>
                        Your payment has been verified successfully.
                    </p>

                <?php elseif ($status === 'Rejected'): ?>

                    <p>
                        Your payment proof was rejected.
                        Please contact the administrator for further information.
                    </p>

                <?php endif; ?>

            </div>

        </section>

    </main>

</div>

