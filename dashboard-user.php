<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Koneksi database
require_once 'koneksi.php';

$user_id = $_SESSION['user_id'];

// Membuat token keamanan untuk formulir pembatalan
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Mengambil informasi pengguna dari database
$query_user = "
    SELECT user_id, kode_user, full_name, email, username,
           birthdate, gender, preferred_language,
           collection_interests, created_at
    FROM users
    WHERE user_id = :user_id
    LIMIT 1
";

$stmt_user = $pdo->prepare($query_user);
$stmt_user->execute(['user_id' => $user_id]);
$user = $stmt_user->fetch();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$username = $user['username'];
$role = $_SESSION['role'] ?? 'pengunjung';

// =====================================
// PROSES PEMBATALAN TIKET
// =====================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['cancel_booking'])
) {
    $id_booking = filter_input(
        INPUT_POST,
        'id_booking',
        FILTER_VALIDATE_INT
    );

    $csrf_token = $_POST['csrf_token'] ?? '';

    if (
        !$id_booking ||
        !hash_equals($_SESSION['csrf_token'], $csrf_token)
    ) {
        die("Permintaan pembatalan tidak valid.");
    }

    try {
        // Hanya tiket milik pengguna yang belum dibayar
        // dan masih berstatus Pending yang dapat dibatalkan.
        $query_cancel = "
            UPDATE booking_tiket b
            INNER JOIN pembayaran p
                ON b.id_booking = p.id_booking
            SET b.status_booking = 'Cancelled'
            WHERE b.id_booking = :id_booking
              AND b.user_id = :user_id
              AND b.status_booking = 'Pending'
              AND p.status_pembayaran = 'Belum Dibayar'
        ";

        $stmt_cancel = $pdo->prepare($query_cancel);

        $stmt_cancel->execute([
            'id_booking' => $id_booking,
            'user_id' => $user_id
        ]);

        if ($stmt_cancel->rowCount() > 0) {
            header("Location: dashboard-user.php?tab=tickets&cancelled=1");
            exit;
        } else {
            header("Location: dashboard-user.php?tab=tickets&cancel_error=1");
            exit;
        }

    } catch (PDOException $e) {
        error_log($e->getMessage());
        die("Pembatalan tiket gagal diproses.");
    }
}

// =====================================
// MENGAMBIL DATA TIKET DARI DATABASE
// =====================================

// Tiket yang sudah dibatalkan tidak ditampilkan
$query_tickets = "
    SELECT
        b.id_booking,
        b.created_at,
        b.tanggal_kunjungan,
        b.waktu_kunjungan,
        b.jenis_tiket,
        b.jumlah_tiket,
        b.total_harga,
        b.total_rupiah,
        b.status_booking,
        p.status_pembayaran
    FROM booking_tiket b
    INNER JOIN pembayaran p
        ON b.id_booking = p.id_booking
    WHERE b.user_id = :user_id
      AND b.status_booking <> 'Cancelled'
    ORDER BY b.created_at DESC
";

$stmt_tickets = $pdo->prepare($query_tickets);
$stmt_tickets->execute(['user_id' => $user_id]);
$activeTickets = $stmt_tickets->fetchAll();

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

// =====================================
// Favorit
// =====================================

// Belum dihubungkan karena tabel favorit belum tersedia.
$savedCollections = [];

// =====================================
// MENENTUKAN TAB
// =====================================

$activeTab = $_GET['tab'] ?? 'saved';

$allowedTabs = [
    'saved',
    'tickets',
    'history',
    'account'
];

if (!in_array($activeTab, $allowedTabs, true)) {
    $activeTab = 'saved';
}

// Pesan pembatalan
$cancelled = isset($_GET['cancelled']);
$cancelError = isset($_GET['cancel_error']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pengguna - Van Gogh Museum</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- CSS -->
    <link rel="stylesheet" href="General_CSS.css">
    <link rel="stylesheet" href="dashboard-user.css">

    <style>

        /* PESAN PEMBATALAN */
        .dashboard-message {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background: #eeeeee;
            color: #222222;
        }

        .dashboard-message.success {
            border-left: 5px solid #27864a;
        }

        .dashboard-message.error {
            border-left: 5px solid #c0392b;
        }

        /* STATUS TIKET */
        .status-pill {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            background: #eeeeee;
            color: #333333;
        }

        .status-cancelled {
            background: #ffa2aa;
            color: #fc0015;
        }

        .status-confirmed {
            background: #00ff22;
            color: #ffffff;
        }

        .status-pending {
            background: #ff0303;
            color: #ffffff;
        }

        /* AKSI TIKET */
        .ticket-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .ticket-cancel-button {
            padding: 7px 11px;
            border: none;
            border-radius: 4px;
            background: #c0392b;
            color: white;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .ticket-cancel-button:hover {
            background: #922b21;
        }

        .ticket-view-link {
            color: #222222;
            font-weight: 600;
        }

        .account-information {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .account-information > div {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 12px 0;
            border-bottom: 1px solid #dddddd;
        }

        .account-information span {
            color: #666666;
        }

        .account-information strong {
            text-align: right;
            overflow-wrap: anywhere;
        }

        @media (max-width: 600px) {
            .account-information > div {
                flex-direction: column;
                gap: 5px;
            }

            .account-information strong {
                text-align: left;
            }
        }
    </style>
</head>

<body class="user-dashboard-page">

    <!-- HEADER -->
  
        <?php
            include 'layout/header.php';
                ?>
    </header>


    <!-- LAYOUT DASHBOARD -->
    <div class="user-dashboard-layout">

        <!-- SIDEBAR PROFIL -->
        <aside class="user-profile-sidebar">

            <div class="profile-avatar" aria-hidden="true">
                <span>
                    <?= htmlspecialchars(
                        strtoupper(substr($username, 0, 1)),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </span>
            </div>

            <div class="profile-name">

                <strong>
                    <?= htmlspecialchars(
                        $username,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </strong>

                <span style="color:white;">Museum Member</span>

            </div>

            <a class="sidebar-primary-button" href="index.php">
                Home
            </a>

            <a class="sidebar-logout-button" href="log-out.php">
                <span aria-hidden="true">⇥</span>
                Keluar
            </a>

        </aside>


        <!-- KONTEN UTAMA -->
        <main class="user-dashboard-main">

            <div class="member-label">
                <span class="member-dot"></span>
                Museum Member
            </div>

            <div class="welcome-heading">
                <h1>
                    Welcome,
                    <?= htmlspecialchars(
                        $username,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </h1>
            </div>

            <p class="welcome-description">
                Selamat datang di area pengguna Van Gogh Museum.
                Kelola koleksi favorit, periksa tiket kunjungan,
                dan lihat aktivitas Anda di sini.
            </p>


            <!-- MENU TAB -->
            <nav
                class="dashboard-tabs"
                aria-label="Navigasi dashboard pengguna"
            >

                <a
                    class="<?= $activeTab === 'saved' ? 'active' : '' ?>"
                    href="dashboard-user.php?tab=saved"
                    <?= $activeTab === 'saved' ? 'aria-current="page"' : '' ?>
                >
                    Favorit
                </a>

                <a
                    class="<?= $activeTab === 'tickets' ? 'active' : '' ?>"
                    href="dashboard-user.php?tab=tickets"
                    <?= $activeTab === 'tickets' ? 'aria-current="page"' : '' ?>
                >
                    Tiket Saya
                </a>

                <a
                    class="<?= $activeTab === 'history' ? 'active' : '' ?>"
                    href="dashboard-user.php?tab=history"
                    <?= $activeTab === 'history' ? 'aria-current="page"' : '' ?>
                >
                    Riwayat Aktivitas
                </a>

                <a
                    class="<?= $activeTab === 'account' ? 'active' : '' ?>"
                    href="dashboard-user.php?tab=account"
                    <?= $activeTab === 'account' ? 'aria-current="page"' : '' ?>
                >
                    Akun Saya
                </a>

            </nav>


            <!-- PANEL KONTEN -->
            <section class="dashboard-panel">

                <?php if ($cancelled): ?>

                    <div class="dashboard-message success">
                        Tiket berhasil dibatalkan.
                    </div>

                <?php elseif ($cancelError): ?>

                    <div class="dashboard-message error">
                        Tiket tidak dapat dibatalkan.
                        Pastikan tiket masih berstatus Pending
                        dan belum dibayar.
                    </div>

                <?php endif; ?>


                <!-- ================================= -->
                <!-- TAB Favorit             -->
                <!-- ================================= -->

                <?php if ($activeTab === 'saved'): ?>

                    <h2>Favorit</h2>

                    <p class="panel-intro">
                        Daftar karya seni yang Anda tandai
                        untuk dilihat kembali.
                    </p>

                    <?php if (!empty($savedCollections)): ?>

                        <div class="table-scroll">

                            <table class="dashboard-table">

                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tahun</th>
                                        <th>Jenis Koleksi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($savedCollections as $collection): ?>

                                        <tr>
                                            <td>
                                                <?= htmlspecialchars(
                                                    $collection['title'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $collection['year'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $collection['type'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <a
                                                    href="collection.php"
                                                    class="table-link"
                                                >
                                                    Buka koleksi
                                                </a>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <div class="empty-state">

                            <span>☆</span>

                            <strong>
                                Belum ada Favorit
                            </strong>

                            <p>
                                Koleksi yang Anda tandai akan
                                ditampilkan di bagian ini.
                            </p>

                        </div>

                    <?php endif; ?>


                <!-- ================================= -->
                <!-- TAB TIKET SAYA                    -->
                <!-- ================================= -->

                <?php elseif ($activeTab === 'tickets'): ?>

                    <h2>Tiket Saya</h2>

                    <p class="panel-intro">
                        Informasi tiket kunjungan dan status pembayaran Anda.
                    </p>

                    <?php if (!empty($activeTickets)): ?>

                        <div class="table-scroll">

                            <table class="dashboard-table">

                                <thead>
                                    <tr>
                                        <th>Kode Tiket</th>
                                        <th>Jenis</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($activeTickets as $ticket): ?>

                                        <?php
                                        $kode_booking = 'VGM-' .
                                            date(
                                                'Ymd',
                                                strtotime($ticket['created_at'])
                                            ) . '-' .
                                            str_pad(
                                                $ticket['id_booking'],
                                                4,
                                                '0',
                                                STR_PAD_LEFT
                                            );

                                        $label_tiket =
                                            $nama_tiket[$ticket['jenis_tiket']]
                                            ?? $ticket['jenis_tiket'];

                                        $boleh_dibatalkan =
                                            $ticket['status_booking'] === 'Pending' &&
                                            $ticket['status_pembayaran'] === 'Belum Dibayar';

                                        if ($ticket['status_pembayaran'] === 'Paid') {
                                            $status_tampil = 'Terkonfirmasi';
                                            $status_class = 'status-confirmed';

                                        } elseif ($ticket['status_pembayaran'] === 'Menunggu Verifikasi') {
                                            $status_tampil = 'Menunggu Verifikasi';
                                            $status_class = 'status-pending';

                                        } elseif ($ticket['status_pembayaran'] === 'Rejected') {
                                            $status_tampil = 'Pembayaran Ditolak';
                                            $status_class = 'status-pending';

                                        } else {
                                            $status_tampil = 'Belum Dibayar';
                                            $status_class = 'status-pending';
                                        }
                                        ?>

                                        <tr>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $kode_booking,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $label_tiket,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                                (<?= (int) $ticket['jumlah_tiket']; ?>)
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    date(
                                                        'd-m-Y',
                                                        strtotime($ticket['tanggal_kunjungan'])
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    substr($ticket['waktu_kunjungan'], 0, 5),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <span class="status-pill <?= $status_class ?>">
                                                    <?= htmlspecialchars(
                                                        $status_tampil,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>
                                                </span>
                                            </td>

                                            <td>

                                                <div class="ticket-actions">

                                                    <?php if ($boleh_dibatalkan): ?>

                                                        <!-- LANJUTKAN PEMBAYARAN -->
                                                        <a
                                                            class="ticket-cancel-button"
                                                            style="background: #00bc32;"
                                                            href="payment.php?id=<?= (int) $ticket['id_booking']; ?>"
                                                        >
                                                            Lanjutkan Pembayaran
                                                        </a>

                                                        <!-- BATALKAN TIKET -->
                                                        <form
                                                            method="POST"
                                                            action="dashboard-user.php?tab=tickets"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan tiket ini?');"
                                                        >

                                                            <input
                                                                type="hidden"
                                                                name="id_booking"
                                                                value="<?= (int) $ticket['id_booking']; ?>"
                                                            >

                                                            <input
                                                                type="hidden"
                                                                name="csrf_token"
                                                                value="<?= htmlspecialchars(
                                                                    $_SESSION['csrf_token'],
                                                                    ENT_QUOTES,
                                                                    'UTF-8'
                                                                ) ?>"
                                                            >

                                                            <button
                                                                type="submit"
                                                                name="cancel_booking"
                                                                class="ticket-cancel-button"
                                                            >
                                                                Batalkan
                                                            </button>

                                                        </form>

                                                    <?php else: ?>

                                                        <!-- DETAIL UNTUK STATUS LAIN -->
                                                        <a
                                                            class="ticket-view-link"
                                                            href="payment.php?id=<?= (int) $ticket['id_booking']; ?>"
                                                        >
                                                            Detail
                                                        </a>

                                                    <?php endif; ?>

                                                </div>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <div class="empty-state">

                            <span>▤</span>

                            <strong>
                                Belum ada tiket
                            </strong>

                            <p>
                                Tiket kunjungan Anda akan
                                ditampilkan di bagian ini.
                            </p>

                        </div>

                    <?php endif; ?>

                    <a
                        href="booking-ticket.php"
                        class="dashboard-action-button"
                    >
                        Pesan tiket
                    </a>


                <!-- ================================= -->
                <!-- TAB RIWAYAT AKTIVITAS             -->
                <!-- ================================= -->

                <?php elseif ($activeTab === 'history'): ?>

                    <h2>Riwayat Aktivitas</h2>

                    <p class="panel-intro">
                        Lihat riwayat pemesanan tiket Anda.
                    </p>

                    <?php if (!empty($activeTickets)): ?>

                        <div class="table-scroll">

                            <table class="dashboard-table">

                                <thead>
                                    <tr>
                                        <th>Kode Booking</th>
                                        <th>Tanggal Kunjungan</th>
                                        <th>Total Pembayaran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($activeTickets as $ticket): ?>

                                        <?php
                                        $kode_booking = 'VGM-' .
                                            date(
                                                'Ymd',
                                                strtotime($ticket['created_at'])
                                            ) . '-' .
                                            str_pad(
                                                $ticket['id_booking'],
                                                4,
                                                '0',
                                                STR_PAD_LEFT
                                            );

                                        if ($ticket['status_pembayaran'] === 'Paid') {
                                            $riwayat_status = 'Terkonfirmasi';
                                        } elseif ($ticket['status_pembayaran'] === 'Menunggu Verifikasi') {
                                            $riwayat_status = 'Menunggu Verifikasi';
                                        } elseif ($ticket['status_pembayaran'] === 'Rejected') {
                                            $riwayat_status = 'Pembayaran Ditolak';
                                        } else {
                                            $riwayat_status = 'Belum Dibayar';
                                        }
                                        ?>

                                        <tr>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $kode_booking,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    date(
                                                        'd-m-Y',
                                                        strtotime($ticket['tanggal_kunjungan'])
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                            <td>
                                                Rp<?= number_format(
                                                    (float) $ticket['total_rupiah'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $riwayat_status,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <div class="empty-state">

                            <span>◷</span>

                            <strong>
                                Belum ada riwayat aktivitas
                            </strong>

                            <p>
                                Riwayat pemesanan tiket akan
                                ditampilkan di bagian ini.
                            </p>

                        </div>

                    <?php endif; ?>


                <!-- ================================= -->
                <!-- TAB AKUN SAYA                     -->
                <!-- ================================= -->

                <?php elseif ($activeTab === 'account'): ?>

                    <h2>Akun Saya</h2>

                    <p class="panel-intro">
                        Informasi akun yang terdaftar di Van Gogh Museum.
                    </p>

                    <div class="account-information">

                        <div>
                            <span>Nama Lengkap</span>
                            
                                <?= htmlspecialchars(
                                    $user['full_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </div>

                        <div>
                            <span>Username</span>
                            <strong>
                                <?= htmlspecialchars(
                                    $user['username'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </div>

                        <div>
                            <span>Email</span>
                            <strong>
                                <?= htmlspecialchars(
                                    $user['email'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </div>

                        <div>
                            <span>Kode Pengguna</span>
                            <strong>
                                <?= htmlspecialchars(
                                    $user['kode_user'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </div>

                        <div>
                            <span>Tanggal Lahir</span>
                            <strong>
                                <?= htmlspecialchars(
                                    date('d-m-Y', strtotime($user['birthdate'])),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </div>

                        <div>
                            <span>Jenis Kelamin</span>
                            <strong>
                                <?= htmlspecialchars(
                                    $user['gender'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </div>

                        <div>
                            <span>Bahasa Pilihan</span>
                            <strong>
                                <?= htmlspecialchars(
                                    $user['preferred_language'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </div>

                        <div>
                            <span>Tanggal Pendaftaran</span>
                            <strong>
                                <?= htmlspecialchars(
                                    date('d-m-Y', strtotime($user['created_at'])),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </div>

                    </div>


                <?php endif; ?>

            </section>

        </main>

    </div>

    <!-- FOOTER -->
    <?php include 'layout/footer.php'; ?>

</body>

</html>