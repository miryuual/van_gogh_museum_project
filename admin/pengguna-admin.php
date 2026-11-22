
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';

// AUTENTIKASI KHUSUS ADMINISTRATOR
if (empty($_SESSION['admin_id'])) {
    header("Location: /van_gogh_museum/login.php");
    exit;
}

require_once __DIR__ . '/../layout/admin-ui.php';

$message = '';
$error = '';


// Mengambil ID pengguna untuk melihat detail
$selectedId = (int) ($_GET['detail'] ?? 0);


// Proses pembaruan data pengguna
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['action'] ?? '') === 'update_user'
) {

    $id = (int) ($_POST['user_id'] ?? 0);

    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $birthdate = $_POST['birthdate'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $language = $_POST['preferred_language'] ?? '';

    // Validasi input
    if (
        $id < 1 ||
        $name === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        $birthdate === '' ||
        $gender === '' ||
        $language === ''
    ) {

        $error = 'Lengkapi data pengguna dengan benar.';

    } else {

        try {

            $st = mysqli_prepare(
                $conn,
                "
                    UPDATE users SET
                        full_name = ?,
                        email = ?,
                        birthdate = ?,
                        gender = ?,
                        preferred_language = ?
                    WHERE user_id = ?
                "
            );

            if (!$st) {
                throw new RuntimeException(
                    'Gagal menyiapkan pembaruan pengguna: ' . mysqli_error($conn)
                );
            }

            mysqli_stmt_bind_param(
                $st,
                "sssssi",
                $name,
                $email,
                $birthdate,
                $gender,
                $language,
                $id
            );

            mysqli_stmt_execute($st);
            mysqli_stmt_close($st);

            $message = 'Informasi pengguna berhasil diperbarui.';
            $selectedId = $id;

        } catch (Throwable $e) {

            $error = $e instanceof mysqli_sql_exception
                ? 'Perubahan gagal. Pastikan email tidak digunakan akun lain.'
                : $e->getMessage();

            error_log('Pengguna admin: ' . $e->getMessage());
        }
    }
}


// Mengambil detail pengguna
$detail = null;

if ($selectedId > 0) {

    $st = mysqli_prepare(
        $conn,
        "
            SELECT
                user_id,
                kode_user,
                full_name,
                birthdate,
                email,
                gender,
                preferred_language,
                collection_interests,
                username,
                created_at
            FROM users
            WHERE user_id = ?
        "
    );

    if (!$st) {
        die("Gagal menyiapkan detail pengguna: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($st, "i", $selectedId);
    mysqli_stmt_execute($st);

    $result = mysqli_stmt_get_result($st);
    $detail = mysqli_fetch_assoc($result);

    mysqli_stmt_close($st);

    if (!$detail) {
        $error = 'Pengguna tidak ditemukan.';
    }
}


// Pencarian pengguna
$search = trim($_GET['q'] ?? '');

$sql = "
    SELECT
        user_id,
        kode_user,
        full_name,
        email,
        username,
        preferred_language,
        created_at
    FROM users
";

if ($search !== '') {

    $sql .= "
        WHERE full_name LIKE ?
        OR email LIKE ?
        OR kode_user LIKE ?
        OR username LIKE ?
    ";

    $keyword = "%{$search}%";

    $st = mysqli_prepare($conn, $sql);

    if (!$st) {
        die("Gagal menyiapkan pencarian pengguna: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $st,
        "ssss",
        $keyword,
        $keyword,
        $keyword,
        $keyword
    );

} else {

    $sql .= " ORDER BY created_at DESC, user_id DESC";

    $st = mysqli_prepare($conn, $sql);

    if (!$st) {
        die("Gagal mengambil daftar pengguna: " . mysqli_error($conn));
    }
}

mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);

$users = [];

while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

mysqli_stmt_close($st);


// Tampilan halaman
admin_start(
    'pengguna',
    'Data Pengguna',
    'Lihat informasi akun dan perbarui data profil pengguna.'
);

admin_flash($message);
admin_flash($error, 'error');

?>


<?php if ($detail): ?>

<section class="admin-panel">

    <div class="admin-panel-title">

        <div>
            <h2>
                Detail Pengguna · <?= admin_e($detail['kode_user']) ?>
            </h2>

            <p>
                Informasi akun yang terdaftar pada website museum.
            </p>
        </div>

        <a class="admin-button admin-button-light" href="pengguna-admin.php">
            Tutup detail
        </a>

    </div>


    <form method="POST" class="admin-form">

        <input type="hidden" name="action" value="update_user">

        <input
            type="hidden"
            name="user_id"
            value="<?= (int) $detail['user_id'] ?>"
        >


        <div class="admin-form-grid">

            <label>
                Kode pengguna

                <input
                    value="<?= admin_e($detail['kode_user']) ?>"
                    disabled
                >
            </label>


            <label>
                Username

                <input
                    value="<?= admin_e($detail['username']) ?>"
                    disabled
                >
            </label>


            <label>
                Nama lengkap

                <input
                    name="full_name"
                    required
                    maxlength="150"
                    value="<?= admin_e($detail['full_name']) ?>"
                >
            </label>


            <label>
                Email

                <input
                    type="email"
                    name="email"
                    required
                    maxlength="150"
                    value="<?= admin_e($detail['email']) ?>"
                >
            </label>


            <label>
                Tanggal lahir

                <input
                    type="date"
                    name="birthdate"
                    required
                    value="<?= admin_e($detail['birthdate']) ?>"
                >
            </label>


            <label>
                Gender

                <select name="gender" required>

                    <?php foreach (['female', 'male', 'other'] as $g): ?>

                        <option
                            value="<?= $g ?>"
                            <?= $detail['gender'] === $g ? 'selected' : '' ?>
                        >
                            <?= ucfirst($g) ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </label>


            <label>
                Bahasa pilihan

                <select name="preferred_language" required>

                    <?php foreach (['indonesian' => 'Indonesian', 'english' => 'English'] as $v => $label): ?>

                        <option
                            value="<?= $v ?>"
                            <?= $detail['preferred_language'] === $v ? 'selected' : '' ?>
                        >
                            <?= $label ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </label>


            <label>
                Terdaftar sejak

                <input
                    value="<?= admin_e(date('d-m-Y', strtotime($detail['created_at']))) ?>"
                    disabled
                >
            </label>


            <label class="admin-field-wide">
                Minat koleksi

                <textarea rows="2" disabled><?= admin_e($detail['collection_interests']) ?></textarea>

                <small>
                    Data minat disimpan dalam format JSON pada database.
                </small>
            </label>

        </div>


        <div class="admin-form-actions">

            <button class="admin-button" type="submit">
                Simpan Perubahan Profil
            </button>

        </div>

    </form>

</section>

<?php endif; ?>


<section class="admin-panel">

    <div class="admin-panel-title">

        <div>
            <h2>Daftar Pengguna</h2>
            <p><?= count($users) ?> akun ditemukan.</p>
        </div>

    </div>


    <form method="GET" class="admin-search">

        <input
            type="search"
            name="q"
            placeholder="Cari nama, email, username, atau kode..."
            value="<?= admin_e($search) ?>"
        >

        <button class="admin-button" type="submit">
            Cari
        </button>

    </form>


    <div class="admin-table-wrap">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama pengguna</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Bahasa</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>


            <tbody>

                <?php foreach ($users as $u): ?>

                    <tr>

                        <td>
                            <?= admin_e($u['kode_user']) ?>
                        </td>

                        <td>
                            <strong>
                                <?= admin_e($u['full_name']) ?>
                            </strong>
                        </td>

                        <td>
                            <?= admin_e($u['email']) ?>
                        </td>

                        <td>
                            <?= admin_e($u['username']) ?>
                        </td>

                        <td>
                            <?= admin_e($u['preferred_language']) ?>
                        </td>

                        <td>
                            <?= date('d-m-Y', strtotime($u['created_at'])) ?>
                        </td>

                        <td>
                            <a
                                class="admin-text-link"
                                href="?detail=<?= (int) $u['user_id'] ?>"
                            >
                                Lihat / Edit
                            </a>
                        </td>

                    </tr>

                <?php endforeach; ?>


                <?php if (!$users): ?>

                    <tr>
                        <td colspan="7" class="admin-empty">
                            Tidak ada pengguna yang cocok.
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
