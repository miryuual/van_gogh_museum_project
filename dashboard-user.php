<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['username'] ?? 'Pengunjung';
$koleksi = [
    ['judul' => 'The Starry Night', 'tahun' => '1889', 'jenis' => 'Painting'],
    ['judul' => 'Sunflowers', 'tahun' => '1889', 'jenis' => 'Painting'],
    ['judul' => 'Almond Blossom', 'tahun' => '1890', 'jenis' => 'Painting'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Pengguna | Van Gogh Museum</title>
<link rel="stylesheet" href="General_CSS.css">
<link rel="stylesheet" href="dashboard.css">
</head>
<body>
<header class="dash-topbar">
  <a class="dash-brand" href="index.php">Van Gogh Museum</a>
  <div class="dash-account">
    <span>Halo, <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
    <a class="dash-logout" href="logout.php">Keluar</a>
  </div>
</header>
<div class="dash-layout">
  <aside class="dash-sidebar">
    <p class="dash-side-label">MENU PENGGUNA</p>
    <a class="active" href="dashboard-user.php">Dashboard Utama</a>
    <a href="#katalog">Katalog Koleksi</a>
    <a href="#favorit">Koleksi Tersimpan</a>
    <a href="#aktivitas">Riwayat Aktivitas</a>
    <a href="#tiket-saya">Tiket Saya</a>
    <a href="#kunjungan">Tiket dan Kunjungan</a>
    <a href="#profil">Profil Pengguna</a>
    <a href="#pengaturan">Pengaturan</a>
    <a href="logout.php">Keluar</a>
  </aside>
  <main class="dash-main">
    <div class="dash-heading">
      <div><p class="eyebrow">VAN GOGH MUSEUM</p><h1>Dashboard Pengguna</h1>
      <p class="muted">Jelajahi koleksi seni dan kelola aktivitas kunjunganmu.</p></div>
    </div>
    <section class="welcome-panel">
      <div><p class="eyebrow">SELAMAT DATANG</p>
      <h2>Halo, <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>!</h2>
      <p>Temukan karya Vincent van Gogh dan pelajari kisah di balik setiap karya.</p>
      <a class="button-primary" href="#katalog">Jelajahi Koleksi</a></div>
      <div class="welcome-art" aria-hidden="true">✦</div>
    </section>
    <section class="stats-grid">
      <article class="stat-card"><span>Koleksi tersimpan</span><strong>0</strong><small>Karya favorit kamu</small></article>
      <article class="stat-card"><span>Tiket saya</span><strong>0</strong><small>Pemesanan aktif</small></article>
      <article class="stat-card"><span>Aktivitas</span><strong>—</strong><small>Ringkasan aktivitas</small></article>
    </section>
    <section class="dash-section" id="katalog">
      <div class="section-title"><div><p class="eyebrow">KATALOG DIGITAL</p><h2>Koleksi terbaru</h2></div><a href="index.php">Lihat katalog →</a></div>
      <form class="collection-search" method="get" action="index.php">
        <input type="search" name="search" placeholder="Cari judul karya seni..." aria-label="Cari koleksi">
        <select name="type" aria-label="Filter jenis koleksi">
          <option value="">Semua jenis</option><option value="Painting">Painting</option>
          <option value="Drawing">Drawing</option><option value="Letter">Letter</option>
        </select>
        <button class="button-primary" type="submit">Cari</button>
      </form>
      <div class="collection-grid">
      <?php foreach ($koleksi as $item): ?>
        <article class="collection-card">
          <div class="art-placeholder" aria-hidden="true">✧</div>
          <div class="collection-info"><span class="tag"><?= htmlspecialchars($item['jenis'], ENT_QUOTES, 'UTF-8'); ?></span>
          <h3><?= htmlspecialchars($item['judul'], ENT_QUOTES, 'UTF-8'); ?></h3>
          <p><?= htmlspecialchars($item['tahun'], ENT_QUOTES, 'UTF-8'); ?></p>
          <button type="button" class="text-button" onclick="alert('Hubungkan tombol ini ke halaman detail koleksi.')">Lihat detail →</button></div>
        </article>
      <?php endforeach; ?>
      </div>
      <p class="note">Data koleksi pada contoh ini masih sementara dan dapat diganti dengan data MySQL.</p>
    </section>
    <section class="dash-section two-column">
      <article class="feature-panel" id="favorit"><p class="eyebrow">AKTIVITAS PRIBADI</p><h2>Koleksi tersimpan</h2>
      <p>Karya favorit akan ditampilkan di sini setelah fitur favorit dihubungkan ke database.</p><a class="button-secondary" href="#katalog">Jelajahi karya</a></article>
      <article class="feature-panel" id="tiket-saya"><p class="eyebrow">RENCANAKAN KUNJUNGAN</p><h2>Tiket saya</h2>
      <p>Informasi tiket akan muncul setelah fitur pemesanan dibuat.</p><a class="button-secondary" href="#kunjungan">Info kunjungan</a></article>
    </section>
    <section class="dash-section info-grid">
      <article id="kunjungan"><h3>Tiket dan Kunjungan</h3><p>Informasi harga tiket, jam buka, alamat, dan petunjuk arah museum.</p></article>
      <article id="profil"><h3>Profil Pengguna</h3><p>Nama akun: <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>. Pengeditan profil perlu dihubungkan ke database.</p></article>
      <article id="aktivitas"><h3>Riwayat Aktivitas</h3><p>Riwayat pencarian dapat ditambahkan sesuai kebutuhan.</p></article>
      <article id="pengaturan"><h3>Pengaturan</h3><p>Preferensi bahasa, minat koleksi, dan privasi dapat dikembangkan kemudian.</p></article>
    </section>
  </main>
</div>
<footer class="dash-footer">Proyek pembelajaran website Van Gogh Museum</footer>
</body></html>
