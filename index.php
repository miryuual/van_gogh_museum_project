<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home-Van Gogh Museum</title>

    <!--LINK FONT-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!--CSS-->
        <link rel="stylesheet" href="home_CSS.css">
    
</head>

<body>
<header>

    <section class="identity">
        <a href="index.php">
            <h1>Van Gogh Museum</h1>
        </a>
    </section>

    <form action="" method="get" class="search">
        <input
            type="text"
            name="search"
            placeholder="Search Van Gogh Museum"
        >
        <button type="submit">Search</button>
    </form>

    <div class="user-dropdown">

        <details>
            <summary class="user-dropdown-summary">

                <?php
                echo htmlspecialchars(
                    $_SESSION['username'] ?? 'Anonymous',
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>

                <span>▼</span>
            </summary>

            <div class="user-menu">

                <?php if (isset($_SESSION['username'])): ?>

                    <a href="log-out.php">Log out</a>

                <?php else: ?>

                    <a href="register-page.php">Register</a>

                    <hr>

                    <a href="login.php">Log in</a>

                <?php endif; ?>

            </div>
        </details>

    </div>

</header>

    <!--MAIN BODY-->

        <!--NAViGASI-->
             <?php include 'layout/navigasi.php'; ?>


    <!--main content-->
        <main>
            <div class="home-content">
                <section class="main-head">
                    <h2 >Explore the World of Vincent Van Gogh</h2>
                    <p>Jelajahi kehidupan, perjalanan artistik, dan karya-karya Vincent van Gogh yang telah menginspirasi dunia melalui warna, emosi, dan gaya lukisnya yang khas.</p>
                    <a class="btn" href="index.php">Find More →</a>
                </section>


                <section class="starry-night-over-the-rhone">
                    <img src="Material/Starry_Night_Over_the_Rhone.jpg" alt="starry night over the rhone">

                </section>
            </div>

            <hr>

            

     <!--Biografi-->


            <div class="home-bio">
                <section class="bio-portrait">
                    <img src="material/vangogh-selfpotrait.jpg" alt="Van Gogh Self Portrait">
                    <p><i>Van Gogh-Self Portrait</i></p>
                </section>

                <section class="bio-content">
                    <h4>Vincent Willem van Gogh</h4>
                    <p> (30 March 1853 – 29 July 1890) </p>


                    <p><b>Vincent Willem van Gogh</b> (30 Maret 1853 – 29 Juli 1890) adalah seorang seniman Belanda yang dikenal sebagai salah satu tokoh Pasca-Impresionisme (Post-Impressionisme). Lukisan dan gambarnya termasuk di antara karya seni yang paling terkenal, populer, dan bernilai tinggi di dunia.</p>
                    <p>Van Gogh menghabiskan masa dewasa awalnya bekerja di sebuah perusahaan perdagangan karya seni. Setelah sempat bekerja sebagai guru, ia kemudian menjadi pekerja misionaris di sebuah wilayah pertambangan yang sangat miskin. Ia baru mulai menekuni karier sebagai seniman pada tahun 1880. Pada awalnya, Van Gogh menggunakan warna-warna gelap dalam karyanya, hingga ia mengenal Impresionisme dan Neo-Impresionisme ketika berada di Paris. Ia kemudian mengadopsi warna-warna yang lebih cerah dan teknik melukis dari kedua aliran tersebut, lalu mengembangkannya menjadi gaya yang khas dan mudah dikenali. Gaya tersebut berkembang semakin matang selama ia tinggal di Arles, Prancis.</p>
                    <p>Dalam sepuluh tahun terakhir hidupnya, Van Gogh menghasilkan lebih dari 2.000 karya, termasuk sekitar 900 lukisan dan 1.100 gambar serta sketsa. Sebagian besar karyanya yang paling terkenal dibuat dalam dua tahun terakhir hidupnya. Pada masa tersebut, ia mengalami gangguan dalam hubungannya dengan Paul Gauguin dan dalam sebuah episode krisis, Van Gogh memotong sebagian telinga kirinya. Setelah kejadian tersebut, ia mengalami beberapa kali gangguan kesehatan mental yang berujung pada kematiannya karena bunuh diri.</p>
                    <p>Tokoh yang sangat penting dalam kehidupan Van Gogh adalah adiknya, Theo van Gogh, yang terus memberikan dukungan finansial kepadanya dengan penuh perhatian. Hubungan dekat mereka sepanjang hidup terdokumentasikan dalam banyak surat yang mereka tukarkan sejak Agustus 1872. Van Gogh dikenal sebagai salah satu pelopor aliran yang kemudian disebut Ekspresionisme. Ia memberikan pengaruh besar terhadap perkembangan seni abad ke-20, khususnya terhadap kelompok Fauvisme dan Ekspresionisme Jerman.</p>
                    <a class="btna" href="biography.php">Read Full Biography →</a>
                    <hr>
                </section>

            </div>


        <!--RECOMENDED COLLECTION-->

        <section class="featured-collection">
           <a href="collection.php"><h5>Popular Collection</h5></a>
            <div class="collection-scroll">
                    <a href="collection.php" class="painting-card">
                        <img src="Material/Vincent_van_gogh-sunflower.jpg" alt="Van Gogh Sunflowers">
                        <div class="painting-info">
                            <h6>Sunflowers</h6>
                            <p>AUGUST 1888, ARLES</p>
                        </div>
                    </a>
                    <a href="collection.php" class="painting-card">
                        <img src="Material/The-Pink-Peach-Tree.jpg" alt="The Pink Peach Tree">
                        <div class="painting-info">
                            <h6>The Pink Peach Tree</h6>
                            <p>April-May 1888, Arles</p>
                        </div>
                    </a>
                    <a href="collection.php" class="painting-card">
                        <img src="Material/vangogh-selfpotrait.jpg" alt="Van Gogh Self-Portrait">
                        <div class="painting-info">
                            <h6>Self-Portrait</h6>
                            <p>1889, Paris</p>
                        </div>
                    </a>
                    <a href="collection.php" class="painting-card">
                        <img src="Material/vincent_van_gogh-Trees_and_Undergrowth.jpg" alt="Van Gogh Trees and Undergrowth">
                        <div class="painting-info">
                            <h6>Trees and Undergrowth</h6>
                            <p>1889, Paris</p>
                        </div>

                    </a>
                    <a href="collection.php" class="painting-card">
                        <img src="Material/vangoghmuseum-s0176V1962-800.jpg" alt="Almond Blossom">
                        <div class="painting-info">
                            <h6>Almond Blossom</h6>
                            <p>February 1890, Saint-Rémy</p>
                        </div>
                    </a>
                </div>
            </section>



     <!--News-->

            <section class="news-content">
                <div class="news-head">
                    <a href="news.php">
                        <h4>News</h4>
                    </a>
                 </div>

                    <div class="news-container">

                        <article class="news-card">
                            <a href="news.php">
                                <div class="news-card-image">
                                    <img src="Material/Sketch_of_Starry_Night_Over_the_Rhone,_enclosed_in_a_letter_from_Vincent_van_Gogh_to_Eugene_Boch.jpg" alt="Van Gogh Exhibition">
                                </div>
                                    <h5>[DD/MM/YY] News Headline</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc ut aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl eget nunc. Sed euismod, nunc ut aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl eget nunc.</p>
                            </a>
                            </article>

                        <article class="news-card">
                            <a href="news.php">
                                <div class="news-card-image">
                                    <img src="Material/Sketch_of_Starry_Night_Over_the_Rhone,_enclosed_in_a_letter_from_Vincent_van_Gogh_to_Eugene_Boch.jpg" alt="Van Gogh Exhibition">
                                </div>
                                    <h5>[DD/MM/YY] News Headline</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc ut aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl eget nunc. Sed euismod, nunc ut aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl eget nunc.</p>
                            </a>
                            </article>

                        <article class="news-card">
                            <a href="news.php">
                                <div class="news-card-image">
                                    <img src="Material/Sketch_of_Starry_Night_Over_the_Rhone,_enclosed_in_a_letter_from_Vincent_van_Gogh_to_Eugene_Boch.jpg" alt="Van Gogh Exhibition">
                                </div>
                                    <h5>[DD/MM/YY] News Headline</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc ut aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl eget nunc. Sed euismod, nunc ut aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl eget nunc.</p>
                            </a>
                            </article>

                    </div>
                    
                    <a class="news-btn" href="news.php">News Page →</a>

                </section>

        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>