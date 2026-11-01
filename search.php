<?php
require_once 'koneksi.php';
include 'layout/header.php';

// Mengambil kata kunci pencarian
$keyword = trim($_GET['search'] ?? '');

$hasil = [];

// Daftar halaman statis website
$halaman = [
    [
        'judul' => 'Home',
        'deskripsi' => 'Welcome to Van Gogh Museum. Explore the museum and discover the artworks of Vincent van Gogh.',
        'url' => 'index.php',
        'kategori' => 'Website Page'
    ],
    [
        'judul' => 'Biography',
        'deskripsi' => 'Discover the life, background, journey, and artistic development of Vincent van Gogh.',
        'url' => 'biografi.php',
        'kategori' => 'Website Page'
    ],
    [
        'judul' => 'Collection',
        'deskripsi' => 'Explore paintings, drawings, prints, and letters by Vincent van Gogh.',
        'url' => 'koleksi.php',
        'kategori' => 'Website Page'
    ],
    [
        'judul' => 'News',
        'deskripsi' => 'Read the latest news and announcements from Van Gogh Museum.',
        'url' => 'news.php',
        'kategori' => 'Website Page'
    ],
    [
        'judul' => 'About Us',
        'deskripsi' => 'Learn about the museum history, collection, research, and museum building.',
        'url' => 'about.php',
        'kategori' => 'Website Page'
    ],
    [
        'judul' => 'Privacy Policy',
        'deskripsi' => 'Information about privacy policy and visitor data.',
        'url' => 'privacy-policy.php',
        'kategori' => 'Website Page'
    ],
    [
        'judul' => 'Ticket and Ticket Prices',
        'deskripsi' => 'Find information about museum tickets and admission prices.',
        'url' => 'ticket-ticketprice.php',
        'kategori' => 'Website Page'
    ]
];

// Menjalankan pencarian
if ($keyword !== '') {

    // 1. Pencarian halaman statis
    foreach ($halaman as $page) {

        if (
            stripos($page['judul'], $keyword) !== false ||
            stripos($page['deskripsi'], $keyword) !== false
        ) {
            $hasil[] = $page;
        }
    }

    // Kata kunci untuk pencarian database
    $searchKeyword = '%' . $keyword . '%';

    // 2. Pencarian data koleksi
    $sqlKoleksi = "
        SELECT
            id_koleksi AS id,
            judul_koleksi AS judul,
            deskripsi AS deskripsi,
            'Collection' AS kategori,
            CONCAT('detail_koleksi.php?id=', id_koleksi) AS url
        FROM koleksi
        WHERE judul_koleksi LIKE :judul
           OR seniman LIKE :artis
           OR deskripsi LIKE :deskripsi
    ";

    $stmtKoleksi = $pdo->prepare($sqlKoleksi);
    $stmtKoleksi->execute([
        ':judul' => $searchKeyword,
        ':artis' => $searchKeyword,
        ':deskripsi' => $searchKeyword
    ]);

    $dataKoleksi = $stmtKoleksi->fetchAll();

    foreach ($dataKoleksi as $item) {
        $hasil[] = $item;
    }

    // 3. Pencarian data berita
    $sqlBerita = "
    SELECT
        id_berita AS id,
        judul_berita AS judul,
        isi_berita_1 AS deskripsi,
        'News' AS kategori,
        CONCAT('detail-berita.php?id=', id_berita) AS url
    FROM berita
    WHERE judul_berita LIKE :judul
       OR isi_berita_1 LIKE :isi
";

$stmtBerita = $pdo->prepare($sqlBerita);
$stmtBerita->execute([
    ':judul' => $searchKeyword,
    ':isi' => $searchKeyword
]);

$dataBerita = $stmtBerita->fetchAll();
}
?>
      <style>
        .search-main {
            flex: 1;
            min-width: 0;
            background: #ffffff;
            border-radius: 10px;
            padding: 40px;
            box-sizing: border-box;
        }

        /* Heading */

        .search-heading {
            padding-bottom: 25px;
            border-bottom: 1px solid #eeeeee;
        }

        .search-eyebrow {
            display: inline-block;
            color: #a28a00;
            background: #fff8c9;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.2px;
        }

        .search-heading h2 {
            color: #252525;
            font-size: 30px;
            margin: 15px 0 8px;
            font-weight: 700;
        }

        .search-heading p {
            color: #777777;
            font-size: 14px;
            margin: 0;
            font-weight: 400;
            line-height: 1.6;
        }

        /* Search Summary */

        .search-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin: 28px 0 20px;
            flex-wrap: wrap;
        }

        .search-summary > div > span {
            display: block;
            color: #000000;
            font-size: 30px;
            font-weight: 800;
        }

        .search-summary h3 {
            margin: 5px 0 0;
            color: #252525;
            font-size: 19px;
            overflow-wrap: anywhere;
        }

        .result-count {
            background: #000000;
            color: #ffffff;
            padding: 8px 13px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Search Result Cards */

        .search-results-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .search-result {
            position: relative;
            background: #ffffff;
            border: 1px solid #000000;
            border-radius: 3px;
            padding: 22px 24px;
            transition: 0.25s ease;
        }

        .search-result:hover {
            border-color: #e5c72e;
            background: #ffd900;
            transform: translateY(-2px);
        }

        .result-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .result-category {
            display: inline-block;
            color: #ffcc00;
            background: #000000;
            padding: 5px 11px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
        }

        .result-arrow {
            color: #aaaaaa;
            font-size: 19px;
        }

        .search-result h3 {
            color: #292929;
            font-size: 19px;
            margin: 15px 0 8px;
        }

        .search-result p {
            color: #4e4d4d;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.7;
            margin: 0 0 15px;
        }

        .result-link {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #000000;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .result-link:hover {
            color: #000000;
            gap: 13px;
        }

        .result-link span {
            font-size: 17px;
        }

        /* Empty Search State */

        .search-empty {
            text-align: center;
            padding: 65px 20px;
            margin-top: 25px;
            background: #fafafa;
            border: 1px dashed #dddddd;
            border-radius: 10px;
        }

        .search-empty-icon {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: #fff3b0;
            color: #927700;
            font-size: 35px;
        }

        .search-empty h3 {
            color: #333333;
            font-size: 19px;
            margin: 0 0 9px;
        }

        .search-empty p {
            color: #777777;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.7;
            margin: 0 0 8px;
        }

        .search-empty > span {
            color: #999999;
            font-size: 12px;
        }

        /* Responsive */

        @media (max-width: 768px) {

            .search-main {
                padding: 25px 18px;
            }

            .search-heading h2 {
                font-size: 25px;
            }

            .search-summary {
                align-items: flex-start;
                flex-direction: column;
            }

            .search-result {
                padding: 18px;
            }
        }
    </style>

    
    <!--Navigasi-->
      <?php include 'layout/navigasi.php'; ?>

    <!--MAIN BODY-->

    <!--main content-->
        <main class="search-main">

            <?php if ($keyword === ''): ?>

                <div class="search-empty">
                    <div class="search-empty-icon">⌕</div>
                    <h3>Start Your Search</h3>
                    <p>Enter a keyword to discover more about Van Gogh Museum.</p>
                </div>

            <?php else: ?>

                <div class="search-summary">
                    <div>
                        <span>Search results for</span>
                        <h3>"<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"</h3>
                    </div>

                    <span class="result-count">
                        <?= count($hasil); ?> result(s) found
                    </span>
                </div>

                <?php if (!empty($hasil)): ?>

                    <div class="search-results-list">

                        <?php foreach ($hasil as $item): ?>

                            <article class="search-result">

                                <div class="result-top">
                                    <span class="result-category">
                                        <?= htmlspecialchars($item['kategori'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>

                                    <span class="result-arrow">↗</span>
                                </div>

                                <h3>
                                    <?= htmlspecialchars($item['judul'], ENT_QUOTES, 'UTF-8'); ?>
                                </h3>

                                <p>
                                    <?= htmlspecialchars($item['deskripsi'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>

                                <a
                                    class="result-link"
                                    href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8'); ?>"
                                >
                                    View Details
                                    <span>→</span>
                                </a>

                            </article>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <div class="search-empty">
                        <div class="search-empty-icon">⌕</div>
                        <h3>No Results Found</h3>
                        <p>
                            We couldn't find anything matching
                            "<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>".
                        </p>
                        <span>Try another keyword or check your spelling.</span>
                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </main>
    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php'; ?>