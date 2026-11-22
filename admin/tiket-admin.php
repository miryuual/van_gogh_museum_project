
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../layout/admin-ui.php';

// AUTENTIKASI KHUSUS ADMINISTRATOR
if (empty($_SESSION['admin_id'])) {
    header("Location: /van_gogh_museum/login.php");
    exit;
}

$message = '';
$error = '';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'update_booking'
) {
    $id = (int)($_POST['id_booking'] ?? 0);
    $bookingStatus = $_POST['status_booking'] ?? '';
    $paymentStatus = $_POST['status_pembayaran'] ?? '';

    $validBooking = ['Pending', 'Confirmed', 'Cancelled'];
    $validPayment = ['Belum Dibayar', 'Menunggu Verifikasi', 'Paid', 'Rejected'];

    if (
        $id < 1 ||
        !in_array($bookingStatus, $validBooking, true) ||
        !in_array($paymentStatus, $validPayment, true)
    ) {
        $error = 'Pilihan status tidak valid.';
    } else {
        try {
            // MEMULAI TRANSAKSI
            mysqli_begin_transaction($conn);

            // MEMERIKSA DATA BOOKING DAN PEMBAYARAN
            $queryCheck = "
                SELECT
                    b.id_booking,
                    b.total_rupiah,
                    p.id_pembayaran
                FROM booking_tiket b
                LEFT JOIN pembayaran p ON p.id_booking = b.id_booking
                WHERE b.id_booking = ?
                FOR UPDATE
            ";

            $check = mysqli_prepare($conn, $queryCheck);

            if (!$check) {
                throw new RuntimeException(
                    'Gagal memeriksa booking: ' . mysqli_error($conn)
                );
            }

            mysqli_stmt_bind_param($check, "i", $id);
            mysqli_stmt_execute($check);

            $resultCheck = mysqli_stmt_get_result($check);
            $row = mysqli_fetch_assoc($resultCheck);

            mysqli_stmt_close($check);

            if (!$row) {
                throw new RuntimeException('Booking tidak ditemukan.');
            }

            // MEMPERBARUI STATUS BOOKING
            $queryBooking = "
                UPDATE booking_tiket
                SET status_booking = ?
                WHERE id_booking = ?
            ";

            $updateBooking = mysqli_prepare($conn, $queryBooking);

            if (!$updateBooking) {
                throw new RuntimeException(
                    'Gagal menyiapkan pembaruan booking: ' . mysqli_error($conn)
                );
            }

            mysqli_stmt_bind_param(
                $updateBooking,
                "si",
                $bookingStatus,
                $id
            );

            if (!mysqli_stmt_execute($updateBooking)) {
                throw new RuntimeException(
                    'Gagal memperbarui status booking.'
                );
            }

            mysqli_stmt_close($updateBooking);

            // MEMERIKSA APAKAH DATA PEMBAYARAN SUDAH ADA
            if (!empty($row['id_pembayaran'])) {

                // MEMPERBARUI DATA PEMBAYARAN
                $queryPayment = "
                    UPDATE pembayaran
                    SET
                        status_pembayaran = ?,
                        tanggal_verifikasi = CASE
                            WHEN ? IN ('Paid', 'Rejected') THEN NOW()
                            ELSE NULL
                        END
                    WHERE id_booking = ?
                ";

                $updatePayment = mysqli_prepare($conn, $queryPayment);

                if (!$updatePayment) {
                    throw new RuntimeException(
                        'Gagal menyiapkan pembaruan pembayaran: ' .
                        mysqli_error($conn)
                    );
                }

                mysqli_stmt_bind_param(
                    $updatePayment,
                    "ssi",
                    $paymentStatus,
                    $paymentStatus,
                    $id
                );

                if (!mysqli_stmt_execute($updatePayment)) {
                    throw new RuntimeException(
                        'Gagal memperbarui status pembayaran.'
                    );
                }

                mysqli_stmt_close($updatePayment);

            } else {

                // MENGAMBIL ID PEMBAYARAN BERIKUTNYA
                $queryNextId = "
                    SELECT COALESCE(MAX(id_pembayaran), 0) + 1 AS next_id
                    FROM pembayaran
                ";

                $resultNextId = mysqli_query($conn, $queryNextId);

                if (!$resultNextId) {
                    throw new RuntimeException(
                        'Gagal mengambil ID pembayaran: ' .
                        mysqli_error($conn)
                    );
                }

                $nextPaymentRow = mysqli_fetch_assoc($resultNextId);
                $nextPaymentId = (int)$nextPaymentRow['next_id'];

                mysqli_free_result($resultNextId);

                // MENAMBAHKAN DATA PEMBAYARAN BARU
                $queryInsert = "
                    INSERT INTO pembayaran (
                        id_pembayaran,
                        id_booking,
                        nominal_pembayaran,
                        status_pembayaran,
                        tanggal_verifikasi
                    )
                    VALUES (
                        ?, ?, ?, ?,
                        CASE
                            WHEN ? IN ('Paid', 'Rejected') THEN NOW()
                            ELSE NULL
                        END
                    )
                ";

                $insertPayment = mysqli_prepare($conn, $queryInsert);

                if (!$insertPayment) {
                    throw new RuntimeException(
                        'Gagal menyiapkan data pembayaran: ' .
                        mysqli_error($conn)
                    );
                }

                $nominalPembayaran = (int)$row['total_rupiah'];

                mysqli_stmt_bind_param(
                    $insertPayment,
                    "iiiss",
                    $nextPaymentId,
                    $id,
                    $nominalPembayaran,
                    $paymentStatus,
                    $paymentStatus
                );

                if (!mysqli_stmt_execute($insertPayment)) {
                    throw new RuntimeException(
                        'Gagal menambahkan data pembayaran.'
                    );
                }

                mysqli_stmt_close($insertPayment);
            }

            // MENYIMPAN SELURUH PERUBAHAN
            mysqli_commit($conn);

            $message = 'Status booking dan pembayaran berhasil diperbarui.';

        } catch (Throwable $e) {

            // MEMBATALKAN TRANSAKSI JIKA TERJADI KESALAHAN
            mysqli_rollback($conn);

            $error = $e instanceof mysqli_sql_exception
                ? 'Status gagal diperbarui. Periksa kembali database.'
                : $e->getMessage();

            error_log('Tiket admin: ' . $e->getMessage());
        }
    }
}

// FILTER STATUS BOOKING
$filter = $_GET['status'] ?? '';
$allowedFilters = ['Pending', 'Confirmed', 'Cancelled'];

// MENGAMBIL DATA BOOKING DAN PEMBAYARAN
$sql = "
    SELECT
        b.*,
        p.status_pembayaran,
        p.metode_pembayaran,
        p.bukti_pembayaran,
        p.tanggal_pembayaran,
        u.full_name AS nama_akun
    FROM booking_tiket b
    LEFT JOIN pembayaran p ON p.id_booking = b.id_booking
    LEFT JOIN users u ON u.user_id = b.user_id
";

if (in_array($filter, $allowedFilters, true)) {
    $sql .= " WHERE b.status_booking = ?";
}

$sql .= " ORDER BY b.created_at DESC";

$st = mysqli_prepare($conn, $sql);

if (!$st) {
    die("Gagal menyiapkan data booking: " . mysqli_error($conn));
}

if (in_array($filter, $allowedFilters, true)) {
    mysqli_stmt_bind_param($st, "s", $filter);
}

if (!mysqli_stmt_execute($st)) {
    die("Gagal mengambil data booking: " . mysqli_stmt_error($st));
}

$result = mysqli_stmt_get_result($st);

$bookings = [];

while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
}

mysqli_stmt_close($st);

// MEMULAI TAMPILAN ADMIN
admin_start(
    'tiket',
    'Booking & Verifikasi Tiket',
    'Periksa bukti pembayaran dan perbarui status pemesanan pengunjung.'
);

admin_flash($message);
admin_flash($error, 'error');
?>

<section class="admin-panel">
    <div class="admin-panel-title">
        <div>
            <h2>Daftar Pemesanan</h2>
        </div>
    </div>

    <form method="GET" class="admin-search">
        <label class="admin-inline-label">
            Status booking
            <select name="status">
                <option value="">Semua status</option>

                <?php foreach ($allowedFilters as $s): ?>
                    <option
                        value="<?= admin_e($s) ?>"
                        <?= $filter === $s ? 'selected' : '' ?>
                    >
                        <?= admin_e($s) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <button class="admin-button" type="submit">
            Tampilkan
        </button>

        <a class="admin-button admin-button-light" href="tiket-admin.php">
            Reset
        </a>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table admin-booking-table">
            <thead>
                <tr>
                    <th>Booking / Pengunjung</th>
                    <th>Kunjungan</th>
                    <th>Tiket</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Verifikasi & status</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td>
                            <strong>
                                #<?= (int)$b['id_booking'] ?> ·
                                <?= admin_e($b['nama_pengunjung']) ?>
                            </strong>
                            <small><?= admin_e($b['email']) ?></small>
                        </td>

                        <td>
                            <?= date('d-m-Y', strtotime($b['tanggal_kunjungan'])) ?>
                            <small>
                                <?= admin_e(substr($b['waktu_kunjungan'], 0, 5)) ?>
                            </small>
                        </td>

                        <td>
                            <?= admin_e($b['jenis_tiket']) ?>
                            <small><?= (int)$b['jumlah_tiket'] ?> tiket</small>
                        </td>

                        <td>
                            Rp<?= number_format((float)$b['total_rupiah'], 0, ',', '.') ?>
                        </td>

                        <td>
                            <span class="admin-status">
                                <?= admin_e($b['status_pembayaran'] ?? 'Belum Dibayar') ?>
                            </span>

                            <?php if (!empty($b['bukti_pembayaran'])): ?>
                                <a
                                    class="admin-text-link"
                                    target="_blank"
                                    rel="noopener"
                                    href="../<?= admin_e($b['bukti_pembayaran']) ?>"
                                >
                                    Lihat bukti
                                </a>
                            <?php else: ?>
                                <small>Belum ada bukti</small>
                            <?php endif; ?>
                        </td>

                        <td>
                            <form method="POST" class="admin-status-form">
                                <input
                                    type="hidden"
                                    name="action"
                                    value="update_booking"
                                >

                                <input
                                    type="hidden"
                                    name="id_booking"
                                    value="<?= (int)$b['id_booking'] ?>"
                                >

                                <label>
                                    Status pembayaran
                                    <select name="status_pembayaran">
                                        <?php foreach (
                                            ['Belum Dibayar', 'Menunggu Verifikasi', 'Paid', 'Rejected']
                                            as $s
                                        ): ?>
                                            <option
                                                value="<?= admin_e($s) ?>"
                                                <?= ($b['status_pembayaran'] ?? 'Belum Dibayar') === $s ? 'selected' : '' ?>
                                            >
                                                <?= admin_e($s) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>

                                <label>
                                    Status booking
                                    <select name="status_booking">
                                        <?php foreach ($allowedFilters as $s): ?>
                                            <option
                                                value="<?= admin_e($s) ?>"
                                                <?= $b['status_booking'] === $s ? 'selected' : '' ?>
                                            >
                                                <?= admin_e($s) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>

                                <button
                                    class="admin-button admin-button-small"
                                    type="submit"
                                >
                                    Simpan Status
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (!$bookings): ?>
                    <tr>
                        <td colspan="6" class="admin-empty">
                            Tidak ada data booking.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <p class="admin-note">
        Catatan: status pembayaran dan status booking disimpan secara terpisah.
        Pastikan bukti pembayaran sudah diperiksa sebelum memilih “Paid”.
    </p>
</section>

<?php
admin_end();
?>
