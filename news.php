

        <?php
        session_start();

        include 'koneksi.php';
        include 'layout/header.php';

        // Mengambil berita yang sudah dipublikasikan
        $query = "SELECT * FROM berita
                WHERE status = 'Dipublikasikan'
                ORDER BY tanggal_berita DESC";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $berita = $stmt->fetchAll();
        ?>

    <style>
        .main-head{
            font-size: 50px;
            font-weight: 600;
        }



        /*NEWS*/

        .news-container {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 55px;
            padding: 20px;
        }


        .news-card-image{
            width: 330px;
            height: 150px;
            border-radius: 2px;

            object-fit: cover;
            overflow: hidden;

            display: flex;
            justify-content: center;
            align-items: center;

            box-sizing: border-box;
        }


        .news-card-image img{
            width: 100%;
            height: auto;
        }
        .news-card-image img:hover{
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }


        .news-card h5{
            font-size: 18px;
            font-weight: 500;
            margin: 10px 0 5px 0;
            border-bottom: 1px solid #000000;
            padding-bottom: 5px;
        }

        .news-card p{
            font-size: 12px;
            line-height: 1;
            margin: 0;
            color: rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;

        }


        .read-more-link:hover .read-more{
            background-color: #f8df50;
            color: #000000;
            padding: 2px 5px;
    
        }


    </style>


    <!--MAIN BODY-->

        <!--NAViGASI-->
             <?php include 'layout/navigasi.php'; ?>


    <!--main content-->
        <main>
            <h2 class="main-head">Museum News</h2>

                <div class="news-container">

                    <?php if (!empty($berita)): ?>

                        <?php foreach ($berita as $item): ?>

                            <article class="news-card">

                                <a href="news-details.php?id=<?= (int) $item['id_berita'] ?>">
                                    <div class="news-card-image">
                                        <img
                                            src="<?= htmlspecialchars($item['gambar_utama']) ?>"
                                            alt="<?= htmlspecialchars($item['judul_berita']) ?>"
>
                                    </div>
                                </a>

                                <h5 class="read-more-link">
                                    <a href="news-details.php?id=<?= (int) $item['id_berita'] ?>">
                                        <strong class="read-more">
                                            <?= htmlspecialchars($item['judul_berita']) ?>
                                        </strong>
                                    </a>
                                </h5>

                                <p>
                                    <?= htmlspecialchars($item['ringkasan']) ?>
                                </p>

                                <p class="read-more-link">
                                    <a href="news-details.php?id=<?= (int) $item['id_berita'] ?>">
                                        <strong class="read-more">Read More →</strong>
                                    </a>
                                </p>

                            </article>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <p>Belum ada berita yang dipublikasikan.</p>

                    <?php endif; ?>

                </div>

        </main>

    </div>

<!--FOOTERR-->
    <?php include 'layout/footer.php';?>