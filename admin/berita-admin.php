
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


// =====================================
// FUNGSI UPLOAD GAMBAR BERITA
// =====================================

function saveNewsImage(array $file, string $oldPath = ''): string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $oldPath;
    }

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Gambar gagal diunggah.');
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
        throw new RuntimeException('Format gambar harus JPG, PNG, atau WEBP.');
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('Ukuran gambar maksimal 5 MB.');
    }

    $dir = __DIR__ . '/../uploads/berita';

    if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
        throw new RuntimeException('Folder upload berita tidak dapat dibuat.');
    }

    $filename = 'berita_' . bin2hex(random_bytes(8)) . '.' . $ext;

    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $filename)) {
        throw new RuntimeException('Gagal menyimpan gambar.');
    }

    return 'uploads/berita/' . $filename;
}


// =====================================
// ID BERITA UNTUK EDIT
// =====================================

$editId = (int) ($_GET['edit'] ?? 0);


// =====================================
// PROSES FORM
// =====================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        $action = $_POST['action'] ?? '';

        // ---------------------------------
        // HAPUS BERITA
        // ---------------------------------

        if ($action === 'delete') {

            $id = (int) ($_POST['id_berita'] ?? 0);

            if ($id <= 0) {
                throw new RuntimeException('ID berita tidak valid.');
            }

            $delete = mysqli_prepare(
                $conn,
                "
                    DELETE FROM berita
                    WHERE id_berita = ?
                "
            );

            if (!$delete) {
                throw new RuntimeException(
                    'Gagal menyiapkan penghapusan berita: ' . mysqli_error($conn)
                );
            }

            mysqli_stmt_bind_param($delete, "i", $id);
            mysqli_stmt_execute($delete);

            $message = mysqli_stmt_affected_rows($delete) > 0
                ? 'Berita berhasil dihapus.'
                : 'Berita tidak ditemukan.';

            mysqli_stmt_close($delete);

            $editId = 0;
        }


        // ---------------------------------
        // SIMPAN BERITA
        // ---------------------------------

        elseif ($action === 'save') {

            $id = (int) ($_POST['id_berita'] ?? 0);

            $title = trim($_POST['judul_berita'] ?? '');
            $date = $_POST['tanggal_berita'] ?? date('Y-m-d');
            $author = trim($_POST['penulis'] ?? '');
            $summary = trim($_POST['ringkasan'] ?? '');

            $body1 = trim($_POST['isi_berita_1'] ?? '');
            $body2 = trim($_POST['isi_berita_2'] ?? '');

            $status = $_POST['status'] ?? 'Draft';


            // Validasi input
            if (
                $title === '' ||
                $author === '' ||
                $summary === '' ||
                $body1 === ''
            ) {
                throw new RuntimeException(
                    'Judul, penulis, ringkasan, dan isi berita utama wajib diisi.'
                );
            }

            if (!in_array($status, ['Draft', 'Dipublikasikan'], true)) {
                throw new RuntimeException('Status berita tidak valid.');
            }

            $dateObject = DateTime::createFromFormat('Y-m-d', $date);

            if (!$dateObject || $dateObject->format('Y-m-d') !== $date) {
                throw new RuntimeException('Tanggal berita tidak valid.');
            }


            // Mengambil gambar lama ketika edit
            $oldMain = '';
            $oldExtra = '';

            if ($id > 0) {

                $q = mysqli_prepare(
                    $conn,
                    "
                        SELECT gambar_utama, gambar_tambahan
                        FROM berita
                        WHERE id_berita = ?
                    "
                );

                if (!$q) {
                    throw new RuntimeException(
                        'Gagal mengambil data berita: ' . mysqli_error($conn)
                    );
                }

                mysqli_stmt_bind_param($q, "i", $id);
                mysqli_stmt_execute($q);

                $result = mysqli_stmt_get_result($q);
                $old = mysqli_fetch_assoc($result);

                mysqli_stmt_close($q);

                if (!$old) {
                    throw new RuntimeException('Berita tidak ditemukan.');
                }

                $oldMain = $old['gambar_utama'];
                $oldExtra = $old['gambar_tambahan'] ?? '';
            }


            // Upload gambar utama
            $main = saveNewsImage(
                $_FILES['gambar_utama'] ?? [],
                $oldMain
            );

            if ($main === '') {
                throw new RuntimeException('Gambar utama wajib diunggah.');
            }


            // Upload gambar tambahan
            $extra = saveNewsImage(
                $_FILES['gambar_tambahan'] ?? [],
                $oldExtra
            );


            // Menyiapkan data berita
            $extra = $extra !== '' ? $extra : null;
            $body2 = $body2 !== '' ? $body2 : null;


            // Memperbarui berita
            if ($id > 0) {

                $update = mysqli_prepare(
                    $conn,
                    "
                        UPDATE berita SET
                            judul_berita = ?,
                            tanggal_berita = ?,
                            penulis = ?,
                            ringkasan = ?,
                            gambar_utama = ?,
                            isi_berita_1 = ?,
                            gambar_tambahan = ?,
                            isi_berita_2 = ?,
                            status = ?
                        WHERE id_berita = ?
                    "
                );

                if (!$update) {
                    throw new RuntimeException(
                        'Gagal menyiapkan perubahan berita: ' . mysqli_error($conn)
                    );
                }

                mysqli_stmt_bind_param(
                    $update,
                    "sssssssssi",
                    $title,
                    $date,
                    $author,
                    $summary,
                    $main,
                    $body1,
                    $extra,
                    $body2,
                    $status,
                    $id
                );

                mysqli_stmt_execute($update);
                mysqli_stmt_close($update);

                $message = 'Berita berhasil diperbarui.';

            }


            // Menambahkan berita baru
            else {

                $insert = mysqli_prepare(
                    $conn,
                    "
                        INSERT INTO berita (
                            judul_berita,
                            tanggal_berita,
                            penulis,
                            ringkasan,
                            gambar_utama,
                            isi_berita_1,
                            gambar_tambahan,
                            isi_berita_2,
                            status
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                    "
                );

                if (!$insert) {
                    throw new RuntimeException(
                        'Gagal menyiapkan penambahan berita: ' . mysqli_error($conn)
                    );
                }

                mysqli_stmt_bind_param(
                    $insert,
                    "sssssssss",
                    $title,
                    $date,
                    $author,
                    $summary,
                    $main,
                    $body1,
                    $extra,
                    $body2,
                    $status
                );

                mysqli_stmt_execute($insert);
                mysqli_stmt_close($insert);

                $message = 'Berita baru berhasil ditambahkan.';
            }

            $editId = 0;
        }

    } catch (Throwable $e) {

        $error = $e instanceof mysqli_sql_exception
            ? 'Berita gagal disimpan. Periksa input dan database.'
            : $e->getMessage();

        error_log('Berita admin: ' . $e->getMessage());
    }
}


// =====================================
// MENGAMBIL DATA BERITA UNTUK DIEDIT
// =====================================

$editing = null;

if ($editId > 0) {

    $q = mysqli_prepare(
        $conn,
        "
            SELECT *
            FROM berita
            WHERE id_berita = ?
        "
    );

    if (!$q) {
        die("Gagal menyiapkan data berita: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($q, "i", $editId);
    mysqli_stmt_execute($q);

    $result = mysqli_stmt_get_result($q);
    $editing = mysqli_fetch_assoc($result);

    mysqli_stmt_close($q);

    if (!$editing) {
        $error = 'Berita tidak ditemukan.';
        $editId = 0;
    }
}


// =====================================
// PENCARIAN BERITA
// =====================================

$search = trim($_GET['q'] ?? '');

$sql = "
    SELECT
        id_berita,
        judul_berita,
        tanggal_berita,
        penulis,
        status
    FROM berita
";

if ($search !== '') {

    $sql .= "
        WHERE judul_berita LIKE ?
        OR penulis LIKE ?
    ";

    $keyword = "%{$search}%";

    $q = mysqli_prepare($conn, $sql);

    if (!$q) {
        die("Gagal menyiapkan pencarian berita: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $q,
        "ss",
        $keyword,
        $keyword
    );

} else {

    $sql .= " ORDER BY tanggal_berita DESC, id_berita DESC";

    $q = mysqli_prepare($conn, $sql);

    if (!$q) {
        die("Gagal mengambil daftar berita: " . mysqli_error($conn));
    }
}

mysqli_stmt_execute($q);

$result = mysqli_stmt_get_result($q);

$news = [];

while ($row = mysqli_fetch_assoc($result)) {
    $news[] = $row;
}

mysqli_stmt_close($q);


// =====================================
// TAMPILAN HALAMAN
// =====================================

admin_start(
    'berita',
    'Kelola Berita',
    'Buat dan atur berita yang ditampilkan pada halaman museum.'
);

admin_flash($message);
admin_flash($error, 'error');

?>


<section class="admin-panel">

    <div class="admin-panel-title">

        <div>
            <h2><?= $editing ? 'Edit Berita' : 'Input Berita' ?></h2>
            <p>Konten dengan status Draft belum ditampilkan kepada pengunjung.</p>
        </div>

        <?php if ($editing): ?>

            <a class="admin-button admin-button-light" href="berita-admin.php">
                Batal
            </a>

        <?php endif; ?>

    </div>


    <form method="POST" enctype="multipart/form-data" class="admin-form">

        <input type="hidden" name="action" value="save">

        <input
            type="hidden"
            name="id_berita"
            value="<?= (int) ($editing['id_berita'] ?? 0) ?>"
        >


        <div class="admin-form-grid">

            <label class="admin-field-wide">
                Judul berita

                <input
                    name="judul_berita"
                    maxlength="255"
                    required
                    value="<?= admin_e($editing['judul_berita'] ?? '') ?>"
                >
            </label>


            <label>
                Tanggal berita

                <input
                    type="date"
                    name="tanggal_berita"
                    required
                    value="<?= admin_e($editing['tanggal_berita'] ?? date('Y-m-d')) ?>"
                >
            </label>


            <label>
                Penulis

                <input
                    name="penulis"
                    maxlength="150"
                    required
                    value="<?= admin_e($editing['penulis'] ?? ($_SESSION['username'] ?? 'Admin Museum')) ?>"
                >
            </label>


            <label>
                Status publikasi

                <select name="status">

                    <option
                        value="Draft"
                        <?= ($editing['status'] ?? 'Draft') === 'Draft' ? 'selected' : '' ?>
                    >
                        Draft
                    </option>

                    <option
                        value="Dipublikasikan"
                        <?= ($editing['status'] ?? '') === 'Dipublikasikan' ? 'selected' : '' ?>
                    >
                        Dipublikasikan
                    </option>

                </select>
            </label>


            <label class="admin-field-wide">
                Ringkasan

                <textarea
                    name="ringkasan"
                    rows="3"
                    required
                ><?= admin_e($editing['ringkasan'] ?? '') ?></textarea>
            </label>


            <label class="admin-field-wide">
                Gambar utama

                <input
                    type="file"
                    name="gambar_utama"
                    accept=".jpg,.jpeg,.png,.webp"
                    <?= $editing ? '' : 'required' ?>
                >

                <small>
                    JPG, PNG, WEBP; maksimal 5 MB.
                    Saat edit, kosongkan jika tidak diganti.
                </small>
            </label>


            <label class="admin-field-wide">
                Isi berita bagian 1

                <textarea
                    name="isi_berita_1"
                    rows="6"
                    required
                ><?= admin_e($editing['isi_berita_1'] ?? '') ?></textarea>
            </label>


            <label class="admin-field-wide">
                Gambar tambahan (opsional)

                <input
                    type="file"
                    name="gambar_tambahan"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <?php if (!empty($editing['gambar_tambahan'])): ?>

                    <small>
                        Gambar tambahan saat ini sudah tersimpan.
                        Kosongkan jika tidak ingin menggantinya.
                    </small>

                <?php endif; ?>

            </label>


            <label class="admin-field-wide">
                Isi berita bagian 2 (opsional)

                <textarea
                    name="isi_berita_2"
                    rows="5"
                ><?= admin_e($editing['isi_berita_2'] ?? '') ?></textarea>
            </label>

        </div>


        <div class="admin-form-actions">

            <button class="admin-button" type="submit">
                <?= $editing ? 'Simpan Perubahan' : 'Terbitkan / Simpan Draft' ?>
            </button>

        </div>

    </form>

</section>


<section class="admin-panel">

    <div class="admin-panel-title">

        <div>
            <h2>Daftar Berita</h2>
            <p><?= count($news) ?> berita terdaftar.</p>
        </div>

    </div>


    <form method="GET" class="admin-search">

        <input
            type="search"
            name="q"
            placeholder="Cari judul atau penulis..."
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
                    <th>Judul berita</th>
                    <th>Tanggal</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>


            <tbody>

                <?php foreach ($news as $n): ?>

                    <tr>

                        <td>
                            <strong>
                                <?= admin_e($n['judul_berita']) ?>
                            </strong>
                        </td>

                        <td>
                            <?= date('d-m-Y', strtotime($n['tanggal_berita'])) ?>
                        </td>

                        <td>
                            <?= admin_e($n['penulis']) ?>
                        </td>

                        <td>
                            <span class="admin-status">
                                <?= admin_e($n['status']) ?>
                            </span>
                        </td>

                        <td class="admin-actions">

                            <a
                                class="admin-text-link"
                                href="?edit=<?= (int) $n['id_berita'] ?>"
                            >
                                Edit
                            </a>

                            <form method="POST">

                                <input type="hidden" name="action" value="delete">

                                <input
                                    type="hidden"
                                    name="id_berita"
                                    value="<?= (int) $n['id_berita'] ?>"
                                >

                                <button class="admin-link-danger" type="submit">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>


                <?php if (!$news): ?>

                    <tr>
                        <td colspan="5" class="admin-empty">
                            Belum ada berita.
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
