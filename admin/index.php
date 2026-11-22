
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../layout/admin-ui.php';

/*
|--------------------------------------------------------------------------
| PEMERIKSAAN AKSES ADMINISTRATOR
|--------------------------------------------------------------------------
| Hanya akun administrator yang memiliki session admin_id
| yang dapat mengakses halaman dashboard.
*/

if (empty($_SESSION['admin_id'])) {
    header("Location: /van_gogh_museum/login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| MENGHITUNG TOTAL DATA
|--------------------------------------------------------------------------
*/

$queryKoleksi = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM koleksi"
);

if (!$queryKoleksi) {
    die("Gagal menghitung koleksi: " . mysqli_error($conn));
}

$totalKoleksi = (int) mysqli_fetch_assoc($queryKoleksi)['total'];
mysqli_free_result($queryKoleksi);


$queryPengguna = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM users"
);

if (!$queryPengguna) {
    die("Gagal menghitung pengguna: " . mysqli_error($conn));
}

$totalPengguna = (int) mysqli_fetch_assoc($queryPengguna)['total'];
mysqli_free_result($queryPengguna);


$queryBerita = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM berita"
);

if (!$queryBerita) {
    die("Gagal menghitung berita: " . mysqli_error($conn));
}

$totalBerita = (int) mysqli_fetch_assoc($queryBerita)['total'];
mysqli_free_result($queryBerita);


$queryBooking = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM booking_tiket"
);

if (!$queryBooking) {
    die("Gagal menghitung booking: " . mysqli_error($conn));
}

$totalBooking = (int) mysqli_fetch_assoc($queryBooking)['total'];
mysqli_free_result($queryBooking);


/*
|--------------------------------------------------------------------------
| MENGHITUNG PEMBAYARAN YANG MENUNGGU VERIFIKASI
|--------------------------------------------------------------------------
*/

$queryPending = mysqli_query(
    $conn,
    "
        SELECT COUNT(*) AS total
        FROM pembayaran
        WHERE status_pembayaran = 'Menunggu Verifikasi'
    "
);

if (!$queryPending) {
    die("Gagal menghitung pembayaran: " . mysqli_error($conn));
}

$pendingPayment = (int) mysqli_fetch_assoc($queryPending)['total'];
mysqli_free_result($queryPending);


/*
|--------------------------------------------------------------------------
| MENGAMBIL LIMA KOLEKSI TERBARU
|--------------------------------------------------------------------------
*/

$collections = [];

$queryCollections = mysqli_query(
    $conn,
    "
        SELECT
            id_koleksi,
            judul_koleksi,
            seniman,
            jenis_koleksi,
            tahun_pembuatan
        FROM koleksi
        ORDER BY created_at DESC, id_koleksi DESC
        LIMIT 5
    "
);

if (!$queryCollections) {
    die("Gagal mengambil data koleksi: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($queryCollections)) {
    $collections[] = $row;
}

mysqli_free_result($queryCollections);


/*
|--------------------------------------------------------------------------
| MENGAMBIL LIMA BOOKING TERBARU
|--------------------------------------------------------------------------
*/

$bookings = [];

$queryBookings = mysqli_query(
    $conn,
    "
        SELECT
            b.id_booking,
            b.nama_pengunjung,
            b.tanggal_kunjungan,
            b.jenis_tiket,
            b.total_rupiah,
            b.status_booking,
            p.status_pembayaran
        FROM booking_tiket b
        LEFT JOIN pembayaran p
            ON p.id_booking = b.id_booking
        ORDER BY b.created_at DESC
        LIMIT 5
    "
);

if (!$queryBookings) {
    die("Gagal mengambil data booking: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($queryBookings)) {
    $bookings[] = $row;
}

mysqli_free_result($queryBookings);


/*
|--------------------------------------------------------------------------
| MEMULAI TAMPILAN DASHBOARD
|--------------------------------------------------------------------------
*/

admin_start(
    'dashboard',
    'Dashboard Pengelola',
    'Ringkasan aktivitas dan akses cepat untuk mengelola website museum.'
);

?>

<section class="admin-stat-grid">

    <a class="admin-stat" href="koleksi-admin.php">
        <span>Total Koleksi</span>
        <strong><?= $totalKoleksi ?></strong>
        <small>Lihat katalog koleksi ↗</small>
    </a>

    <a class="admin-stat" href="tiket-admin.php">
        <span>Booking Tiket</span>
        <strong><?= $totalBooking ?></strong>
        <small>Kelola pemesanan ↗</small>
    </a>

    <a class="admin-stat" href="berita-admin.php">
        <span>Berita</span>
        <strong><?= $totalBerita ?></strong>
        <small>Kelola publikasi ↗</small>
    </a>

    <a class="admin-stat" href="pengguna-admin.php">
        <span>Pengguna</span>
        <strong><?= $totalPengguna ?></strong>
        <small>Lihat data akun ↗</small>
    </a>

</section>


<?php if ($pendingPayment > 0): ?>

    <div class="admin-alert admin-alert-warning">
        <?= $pendingPayment ?> pembayaran menunggu verifikasi.
        <a href="tiket-admin.php">Periksa sekarang</a>
    </div>

<?php endif; ?>


<section class="admin-panel">

    <div class="admin-panel-title">
        <div>
            <h2>Akses Pengelolaan</h2>
        </div>
    </div>

    <div class="admin-shortcuts">

        <a href="koleksi-admin.php">
            <span>▧</span>
            <div>
                <strong>Kelola Koleksi</strong>
                <small>Input dan perbarui data karya museum</small>
            </div>
            <b>→</b>
        </a>

        <a href="tiket-admin.php">
            <span>▣</span>
            <div>
                <strong>Booking & Verifikasi Tiket</strong>
                <small>Periksa pembayaran dan status kunjungan</small>
            </div>
            <b>→</b>
        </a>

        <a href="berita-admin.php">
            <span>▤</span>
            <div>
                <strong>Kelola Berita</strong>
                <small>Tambah berita dan atur publikasi</small>
            </div>
            <b>→</b>
        </a>

        <a href="pengguna-admin.php">
            <span>♙</span>
            <div>
                <strong>Data Pengguna</strong>
                <small>Lihat dan perbarui informasi akun</small>
            </div>
            <b>→</b>
        </a>

    </div>

</section>


<section class="admin-panel">

    <div class="admin-panel-title">
        <div>
            <h2>Booking Terbaru</h2>
            <p>Lima pemesanan terakhir yang masuk.</p>
        </div>

        <a class="admin-text-link" href="tiket-admin.php">
            Lihat semua
        </a>
    </div>

    <div class="admin-table-wrap">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pengunjung</th>
                    <th>Tanggal kunjungan</th>
                    <th>Total</th>
                    <th>Status booking</th>
                    <th>Pembayaran</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($bookings as $b): ?>

                    <tr>
                        <td>#<?= (int) $b['id_booking'] ?></td>

                        <td>
                            <?= admin_e($b['nama_pengunjung']) ?>
                        </td>

                        <td>
                            <?= !empty($b['tanggal_kunjungan'])
                                ? date('d-m-Y', strtotime($b['tanggal_kunjungan']))
                                : '-' ?>
                        </td>

                        <td>
                            Rp<?= number_format((float) $b['total_rupiah'], 0, ',', '.') ?>
                        </td>

                        <td>
                            <span class="admin-status">
                                <?= admin_e($b['status_booking']) ?>
                            </span>
                        </td>

                        <td>
                            <?= admin_e($b['status_pembayaran'] ?? 'Belum Dibayar') ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

                <?php if (!$bookings): ?>

                    <tr>
                        <td colspan="6" class="admin-empty">
                            Belum ada booking.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<section class="admin-panel">

    <div class="admin-panel-title">
        <div>
            <h2>Koleksi Terakhir Ditambahkan</h2>
            <p>Data koleksi terbaru pada katalog.</p>
        </div>

        <a class="admin-text-link" href="koleksi-admin.php">
            Kelola koleksi
        </a>
    </div>

    <div class="admin-table-wrap">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Judul koleksi</th>
                    <th>Seniman</th>
                    <th>Jenis</th>
                    <th>Tahun</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($collections as $c): ?>

                    <tr>
                        <td>
                            <strong><?= admin_e($c['judul_koleksi']) ?></strong>
                        </td>

                        <td>
                            <?= admin_e($c['seniman']) ?>
                        </td>

                        <td>
                            <?= admin_e($c['jenis_koleksi']) ?>
                        </td>

                        <td>
                            <?= admin_e($c['tahun_pembuatan'] ?: '-') ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

                <?php if (!$collections): ?>

                    <tr>
                        <td colspan="4" class="admin-empty">
                            Belum ada koleksi.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<?php
admin_end();
?>
