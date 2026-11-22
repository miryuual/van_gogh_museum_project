
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

$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$editing = null;

/*
|--------------------------------------------------------------------------
| FUNGSI UPLOAD GAMBAR KOLEKSI
|--------------------------------------------------------------------------
*/

function saveCollectionImage(array $file, string $oldPath = ''): string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $oldPath;
    }

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Gambar gagal diunggah.');
    }

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true)) {
        throw new RuntimeException(
            'Format gambar harus JPG, JPEG, PNG, atau WEBP.'
        );
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('Ukuran gambar maksimal 5 MB.');
    }

    $dir = __DIR__ . '/../uploads/koleksi';

    if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
        throw new RuntimeException(
            'Folder upload koleksi tidak dapat dibuat.'
        );
    }

    $filename = 'koleksi_' . bin2hex(random_bytes(8)) . '.' . $ext;

    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $filename)) {
        throw new RuntimeException('Gagal menyimpan gambar.');
    }

    return 'uploads/koleksi/' . $filename;
}

/*
|--------------------------------------------------------------------------
| PROSES TAMBAH, EDIT, DAN HAPUS KOLEKSI
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    try {

        /*
        |--------------------------------------------------------------------------
        | HAPUS KOLEKSI
        |--------------------------------------------------------------------------
        */

        if ($action === 'delete') {

            $id = (int) ($_POST['id_koleksi'] ?? 0);

            if ($id <= 0) {
                throw new RuntimeException('ID koleksi tidak valid.');
            }

            $stmt = mysqli_prepare(
                $conn,
                "DELETE FROM koleksi WHERE id_koleksi = ?"
            );

            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $message = 'Data koleksi berhasil dihapus.';
            } else {
                $error = 'Data koleksi tidak ditemukan.';
            }

            mysqli_stmt_close($stmt);

        /*
        |--------------------------------------------------------------------------
        | TAMBAH DAN EDIT KOLEKSI
        |--------------------------------------------------------------------------
        */

        } elseif ($action === 'save') {

            $id = (int) ($_POST['id_koleksi'] ?? 0);

            $title = trim($_POST['judul_koleksi'] ?? '');
            $artist = trim($_POST['seniman'] ?? '');
            $type = trim($_POST['jenis_koleksi'] ?? '');
            $location = trim($_POST['lokasi_pembuatan'] ?? '');
            $year = trim($_POST['tahun_pembuatan'] ?? '');
            $description = trim($_POST['deskripsi'] ?? '');

            if ($title === '' || $artist === '' || $type === '') {
                throw new RuntimeException(
                    'Judul, seniman, dan jenis koleksi wajib diisi.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | AMBIL GAMBAR LAMA SAAT EDIT
            |--------------------------------------------------------------------------
            */

            $old = '';

            if ($id > 0) {

                $stmt = mysqli_prepare(
                    $conn,
                    "SELECT gambar_koleksi
                     FROM koleksi
                     WHERE id_koleksi = ?"
                );

                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                $oldData = mysqli_fetch_assoc($result);

                mysqli_stmt_close($stmt);

                if (!$oldData) {
                    throw new RuntimeException(
                        'Data koleksi tidak ditemukan.'
                    );
                }

                $old = (string) $oldData['gambar_koleksi'];
            }

            /*
            |--------------------------------------------------------------------------
            | UPLOAD GAMBAR
            |--------------------------------------------------------------------------
            */

            $image = saveCollectionImage(
                $_FILES['gambar_koleksi'] ?? [],
                $old
            );

            if ($image === '') {
                throw new RuntimeException(
                    'Gambar koleksi wajib diunggah untuk data baru.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | PERSIAPAN DATA
            |--------------------------------------------------------------------------
            */

            $location = $location !== '' ? $location : null;
            $year = $year !== '' ? (int) $year : null;
            $description = $description !== '' ? $description : null;

            $fNumber = trim($_POST['f_number'] ?? '') ?: null;
            $jhNumber = trim($_POST['jh_number'] ?? '') ?: null;
            $objectNumber = trim($_POST['object_number'] ?? '') ?: null;
            $dimension = trim($_POST['dimensi'] ?? '') ?: null;
            $provenance = trim($_POST['provenance'] ?? '') ?: null;
            $credits = trim($_POST['credits'] ?? '') ?: null;

            /*
            |--------------------------------------------------------------------------
            | UPDATE KOLEKSI
            |--------------------------------------------------------------------------
            */

            if ($id > 0) {

                $sql = "
                    UPDATE koleksi
                    SET
                        judul_koleksi = ?,
                        seniman = ?,
                        jenis_koleksi = ?,
                        lokasi_pembuatan = ?,
                        tahun_pembuatan = ?,
                        gambar_koleksi = ?,
                        deskripsi = ?,
                        f_number = ?,
                        jh_number = ?,
                        object_number = ?,
                        dimensi = ?,
                        provenance = ?,
                        credits = ?
                    WHERE id_koleksi = ?
                ";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param(
                    $stmt,
                    "ssssissssssssi",
                    $title,
                    $artist,
                    $type,
                    $location,
                    $year,
                    $image,
                    $description,
                    $fNumber,
                    $jhNumber,
                    $objectNumber,
                    $dimension,
                    $provenance,
                    $credits,
                    $id
                );

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $message = 'Perubahan koleksi berhasil disimpan.';

            /*
            |--------------------------------------------------------------------------
            | INSERT KOLEKSI BARU
            |--------------------------------------------------------------------------
            */

            } else {

                // Menentukan ID berikutnya karena id_koleksi
                // pada database belum menggunakan AUTO_INCREMENT.

                $result = mysqli_query(
                    $conn,
                    "SELECT COALESCE(MAX(id_koleksi), 0) + 1 AS next_id
                     FROM koleksi"
                );

                $row = mysqli_fetch_assoc($result);
                $nextId = (int) $row['next_id'];

                $sql = "
                    INSERT INTO koleksi (
                        id_koleksi,
                        judul_koleksi,
                        seniman,
                        jenis_koleksi,
                        lokasi_pembuatan,
                        tahun_pembuatan,
                        gambar_koleksi,
                        deskripsi,
                        f_number,
                        jh_number,
                        object_number,
                        dimensi,
                        provenance,
                        credits
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param(
                    $stmt,
                    "issssissssssss",
                    $nextId,
                    $title,
                    $artist,
                    $type,
                    $location,
                    $year,
                    $image,
                    $description,
                    $fNumber,
                    $jhNumber,
                    $objectNumber,
                    $dimension,
                    $provenance,
                    $credits
                );

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $message = 'Koleksi baru berhasil ditambahkan.';
            }

            $editId = 0;
        }

    } catch (Throwable $e) {

        $error = $e instanceof mysqli_sql_exception
            ? 'Data gagal disimpan. Periksa kembali input dan koneksi database.'
            : $e->getMessage();

        error_log('Koleksi admin: ' . $e->getMessage());
    }
}

/*
|--------------------------------------------------------------------------
| AMBIL DATA KOLEKSI UNTUK EDIT
|--------------------------------------------------------------------------
*/

if ($editId > 0) {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT *
         FROM koleksi
         WHERE id_koleksi = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $editId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $editing = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if (!$editing) {
        $error = 'Data koleksi yang dipilih tidak ditemukan.';
        $editId = 0;
    }
}

/*
|--------------------------------------------------------------------------
| PENCARIAN DAN DAFTAR KOLEKSI
|--------------------------------------------------------------------------
*/

$search = trim($_GET['q'] ?? '');

$sql = "
    SELECT
        id_koleksi,
        judul_koleksi,
        seniman,
        jenis_koleksi,
        tahun_pembuatan,
        gambar_koleksi
    FROM koleksi
";

if ($search !== '') {

    $sql .= "
        WHERE judul_koleksi LIKE ?
        OR seniman LIKE ?
        OR jenis_koleksi LIKE ?
    ";

    $keyword = "%{$search}%";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $keyword,
        $keyword,
        $keyword
    );

} else {

    $sql .= " ORDER BY id_koleksi DESC";

    $stmt = mysqli_prepare($conn, $sql);
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$collections = [];

while ($row = mysqli_fetch_assoc($result)) {
    $collections[] = $row;
}

mysqli_stmt_close($stmt);

/*
|--------------------------------------------------------------------------
| TAMPILAN ADMIN
|--------------------------------------------------------------------------
*/

admin_start(
    'koleksi',
    'Kelola Koleksi',
    'Tambahkan dan perbarui informasi karya dalam katalog museum.'
);

admin_flash($message);
admin_flash($error, 'error');

?>

<section class="admin-panel">
    <div class="admin-panel-title">
        <div>
            <h2><?= $editing ? 'Ubah Informasi Koleksi' : 'Tambah Koleksi Baru' ?></h2>
            <p>Lengkapi informasi karya sesuai data katalog.</p>
        </div>

        <?php if ($editing): ?>
            <a class="admin-button admin-button-light" href="koleksi-admin.php">
                Batal mengubah
            </a>
        <?php endif; ?>
    </div>

    <form method="POST" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="action" value="save">

        <input
            type="hidden"
            name="id_koleksi"
            value="<?= (int) ($editing['id_koleksi'] ?? 0) ?>"
        >

        <div class="admin-form-grid">

            <label>
                Judul koleksi
                <input
                    type="text"
                    name="judul_koleksi"
                    required
                    maxlength="255"
                    value="<?= admin_e($editing['judul_koleksi'] ?? '') ?>"
                >
            </label>

            <label>
                Seniman
                <input
                    type="text"
                    name="seniman"
                    required
                    maxlength="150"
                    value="<?= admin_e($editing['seniman'] ?? 'Vincent van Gogh') ?>"
                >
            </label>

            <label>
                Jenis koleksi
                <select name="jenis_koleksi" required>

                    <?php foreach (['Painting', 'Drawing', 'Print', 'Letter'] as $type): ?>

                        <option
                            value="<?= admin_e($type) ?>"
                            <?= (($editing['jenis_koleksi'] ?? '') === $type) ? 'selected' : '' ?>
                        >
                            <?= admin_e($type) ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </label>

            <label>
                Lokasi pembuatan
                <input
                    type="text"
                    name="lokasi_pembuatan"
                    value="<?= admin_e($editing['lokasi_pembuatan'] ?? '') ?>"
                >
            </label>

            <label>
                Tahun pembuatan
                <input
                    type="number"
                    name="tahun_pembuatan"
                    min="1000"
                    max="2100"
                    value="<?= admin_e($editing['tahun_pembuatan'] ?? '') ?>"
                >
            </label>

            <label>
                Nomor F
                <input
                    type="text"
                    name="f_number"
                    value="<?= admin_e($editing['f_number'] ?? '') ?>"
                >
            </label>

            <label>
                Nomor JH
                <input
                    type="text"
                    name="jh_number"
                    value="<?= admin_e($editing['jh_number'] ?? '') ?>"
                >
            </label>

            <label>
                Object number
                <input
                    type="text"
                    name="object_number"
                    value="<?= admin_e($editing['object_number'] ?? '') ?>"
                >
            </label>

            <label>
                Dimensi
                <input
                    type="text"
                    name="dimensi"
                    value="<?= admin_e($editing['dimensi'] ?? '') ?>"
                >
            </label>

            <label class="admin-field-wide">
                Gambar koleksi

                <input
                    type="file"
                    name="gambar_koleksi"
                    accept=".jpg,.jpeg,.png,.webp"
                    <?= $editing ? '' : 'required' ?>
                >

                <small>
                    Format JPG, PNG, WEBP; maksimal 5 MB.
                    <?= $editing ? 'Kosongkan jika tidak ingin mengganti gambar.' : '' ?>
                </small>
            </label>

            <label class="admin-field-wide">
                Deskripsi
                <textarea name="deskripsi" rows="4"><?= admin_e($editing['deskripsi'] ?? '') ?></textarea>
            </label>

            <label class="admin-field-wide">
                Provenance
                <textarea name="provenance" rows="3"><?= admin_e($editing['provenance'] ?? '') ?></textarea>
            </label>

            <label class="admin-field-wide">
                Credits
                <input
                    type="text"
                    name="credits"
                    value="<?= admin_e($editing['credits'] ?? '') ?>"
                >
            </label>

        </div>

        <div class="admin-form-actions">
            <button class="admin-button" type="submit">
                <?= $editing ? 'Simpan Perubahan' : 'Tambah Koleksi' ?>
            </button>
        </div>

    </form>
</section>

<section class="admin-panel">

    <div class="admin-panel-title">
        <div>
            <h2>Daftar Koleksi</h2>
            <p><?= count($collections) ?> data ditampilkan.</p>
        </div>
    </div>

    <form method="GET" class="admin-search">

        <input
            type="search"
            name="q"
            placeholder="Cari judul, seniman, atau jenis koleksi..."
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
                    <th>Gambar</th>
                    <th>Judul koleksi</th>
                    <th>Seniman</th>
                    <th>Jenis</th>
                    <th>Tahun</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($collections as $item): ?>

                    <tr>

                        <td>
                            <img
                                class="admin-thumb"
                                src="../<?= admin_e($item['gambar_koleksi']) ?>"
                                alt=""
                            >
                        </td>

                        <td>
                            <strong>
                                <?= admin_e($item['judul_koleksi']) ?>
                            </strong>
                        </td>

                        <td>
                            <?= admin_e($item['seniman']) ?>
                        </td>

                        <td>
                            <?= admin_e($item['jenis_koleksi']) ?>
                        </td>

                        <td>
                            <?= admin_e($item['tahun_pembuatan'] ?: '-') ?>
                        </td>

                        <td class="admin-actions">

                            <a
                                class="admin-text-link"
                                href="?edit=<?= (int) $item['id_koleksi'] ?>"
                            >
                                Edit
                            </a>

                            <form
                                method="POST"
                                onsubmit="return confirm('Hapus koleksi ini? Data favorit terkait juga dapat terhapus.');"
                            >

                                <input
                                    type="hidden"
                                    name="action"
                                    value="delete"
                                >

                                <input
                                    type="hidden"
                                    name="id_koleksi"
                                    value="<?= (int) $item['id_koleksi'] ?>"
                                >

                                <button
                                    class="admin-link-danger"
                                    type="submit"
                                >
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

                <?php if (!$collections): ?>

                    <tr>
                        <td colspan="6" class="admin-empty">
                            Belum ada data koleksi.
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
