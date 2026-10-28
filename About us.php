<?php
    session_start();
    include 'layout/header.php';?>


    <style>
        /*head*/
        .main-head{
            font-size: 80px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .header-image {

            width: 1200px;
            height: 400px;
            border-radius: 2px;

            object-fit: cover;
            overflow: hidden;

            display: flex;
            justify-content: center;
            align-items: center;

            box-sizing: border-box;
        }


        /*CONTENTT*/
        .about-us-container {
            display: flex;
            gap: 20px;
            margin-top: 80px;
            margin-right: 80px;

            text-align: justify;
        

        }

        .about-us-container img {
            width: 400px;
            height: 300px;
            padding-right: 20px;

            padding-top: 90px;

        }

        .about-us-container h4 {
            font-size: 45px;
            font-weight: 600;
            margin-bottom: 10px;

        }
        .about-us-container p{
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
            font-weight: 400;

        }


        /*HIDDEN LIST*/
        .comtent-summary img{
            width: 400px;
            height: 300px;
            border-radius: 2px;
            object-fit: cover;
            overflow: hidden;

            display: flex;
            justify-content: center;
            align-items: center;

            box-sizing: border-box;


        }

        .comtent-summary p{
            font-size: 17px;
            margin-top: 0;


        }

        .content-list{
            font-size: 27px;
            gap: 15px;
            font-weight: 500;
            width: 95%;

            padding-bottom: 15px;
            padding-top: 10px;

            border-top: 1.5px solid black;
            cursor: pointer;

            margin-top: 30px;
        }


        h5{
            font-size: 24px;
            padding-bottom: 0;
            margin-top: 0;
            margin-top: 0;

        }
        .enterance img{
            padding-top: 0;
            margin-bottom: 25px;

        }
        
        ul{
            font-weight: 400;
        }


        /*LINKS*/

        .kategori{
            margin-top: 50px;
        }
        .kategori p{
           margin: 0;
           font-size: 25px;
        }

        .link-a a{
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            color: rgb(0, 0, 0);
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid black;
        }

        .back-button{
            margin-top: 50px;
            margin-bottom: 40px;
        }
        
    </style>

    
    <!--MAIN BODY-->
    <?php
    include 'layout/navigasi.php';?>

    <!--main content-->
        <main>
            <h2 class="main-head">About Us</h2>

            <img src="material/Interior F.jpg" alt="Van Gogh Museum Entrance" class="header-image">

            <div class="about-us-container">
                <img src="Material/_museum_flat_visual_LR_2.jpg" alt="Van Gogh Museum enterance">
                <div class="about-us-content">
                    <h4>Vangogh Museum, Amsterdam</h4>

                        <p>Van Gogh Museum adalah museum di Amsterdam yang didedikasikan untuk kehidupan dan karya Vincent van Gogh. Museum ini menghadirkan koleksi lukisan, gambar, dan surat Vincent van Gogh, serta karya seniman yang berkaitan dengan lingkungan artistiknya. Melalui koleksi dan pamerannya, pengunjung dapat mengikuti perkembangan Van Gogh sebagai seniman, mengenal gagasan dan ambisinya, serta memahami konteks seni pada masanya.</p>
                        <p>Selain mengelola koleksi, Van Gogh Museum juga menjalankan penelitian, konservasi, dan kegiatan edukasi untuk memperluas pengetahuan mengenai Vincent van Gogh dan menjaga koleksi agar tetap dapat dipelajari oleh generasi mendatang. Museum menyatakan misinya untuk menginspirasi beragam audiens melalui kehidupan dan karya Vincent van Gogh serta zamannya.</p>
                   
                   
                    <h4>About the Museum</h4>
                        <div CLASS="more-info">
                            <details class="comtent-summary">
                                <summary class="content-list">Our History</summary>
                                <p>Sejarah Van Gogh Museum berkaitan erat dengan keluarga Vincent van Gogh dan upaya mereka untuk menjaga koleksi Vincent tetap utuh. Setelah Vincent van Gogh meninggal pada Juli 1890, karya-karya yang dibuat dan dimilikinya berpindah kepada saudaranya, Theo van Gogh. Theo kemudian meninggal pada Januari 1891. Koleksi tersebut selanjutnya berada pada istrinya, Jo van Gogh-Bonger, dan putranya, Vincent Willem van Gogh.</p>
                                <p>Jo van Gogh-Bonger memiliki peran penting dalam memperkenalkan karya Vincent kepada publik. Setelah Jo meninggal pada 1925, Vincent Willem van Gogh melanjutkan tanggung jawab terhadap koleksi tersebut. Pada 1962, Vincent Willem menyerahkan koleksi berupa lukisan, gambar, dan surat kepada Vincent van Gogh Foundation melalui kesepakatan dengan Negara Belanda. Sebagai bagian dari kesepakatan tersebut, Negara Belanda berkomitmen membangun Van Gogh Museum agar koleksi dapat tetap terpelihara dan dapat diakses oleh masyarakat.</p>
                                <p>Van Gogh Museum kemudian dibuka untuk umum pada 1973. Museum tersebut pada awalnya dikenal sebagai Rijksmuseum Vincent van Gogh dan kemudian menggunakan nama Van Gogh Museum sejak 1994. </p>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list" >Timeline</summary>
                                <ul>
                                    <li>1890 -Vincent van Gogh meninggal. Karya-karyanya kemudian berliindah kepada saudaranya, Theo van Gogh.</li>
                                    <li>1891 -Theo van Gogh meninggal. Koleksi kemudian berada liada Jo van Gogh-Bonger dan putranya, Vincent Willem van Gogh.</li>
                                    <li>1925 -Jo van Gogh-Bonger meninggal dan Vincent Willem van Gogh melanjutkan pengelolaan koleksi</li>
                                    <li>1962 -Vincent Willem van Gogh menyerahkan koleksi kepada Vincent van Gogh Foundation melalui kesepakatan dengan Negara Belanda.</li>
                                    <li>1973 -Van Gogh Museum dibuka untuk publik.</li>
                                </ul>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Museum Building</summary>
                                <p>Van Gogh Museum terdiri dari dua bangunan utama, yaitu Rietveld Building dan Kurokawa Wing. Kedua bangunan memiliki fungsi dan karakter arsitektur yang berbeda. Keduanya kini dihubungkan oleh glass Entrance Hall di Museumplein yang menjadi pintu masuk utama museum. Perkembangan bangunan ini mencerminkan perjalanan museum dalam menyajikan koleksi permanen sekaligus menyelenggarakan pameran sementara.</p>
                                    <div class="enterance">
                                        <h5>Rietveld Building- 1973</h5>
                                        <img src="Material/Rietveld Building.jpg" alt="Van Gogh rietveld Building">
                                        <p>Rietveld Building merupakan bangunan utama Van Gogh Museum yang terletak di Paulus Potterstraat. Bangunan ini dirancang oleh arsitek Belanda Gerrit Rietveld pada 1963–1964 dan dibuka pada 1973. Bangunan ini menjadi tempat utama untuk menampilkan koleksi permanen Van Gogh Museum, termasuk karya Vincent van Gogh dan para seniman sezamannya.</p>
                                        <p>Rietveld merupakan salah satu tokoh penting dalam kelompok De Stijl, sebuah gerakan seni dan arsitektur yang berkembang di Belanda pada awal abad ke-20. Pendekatan modernis Rietveld terlihat pada penggunaan bentuk-bentuk geometris dan ruang yang terang serta terbuka. Salah satu karakter bangunan yang menonjol terdapat pada tangga di aula tengah, tempat cahaya alami masuk melalui ruang vertikal yang tinggi dan kemudian menyebar ke ruang-ruang museum.</p>
                                        <p>Dalam fungsi museumnya, Rietveld Building terutama digunakan untuk menyajikan kisah perkembangan Vincent van Gogh melalui koleksi permanen. Pengunjung dapat melihat lukisan, gambar, dan karya lain dalam konteks perkembangan artistik Van Gogh.</p>
                                    </div>
                                    <div class="enterance">
                                        <h5>Kurokawa Wing- 1999</h5>
                                        <img src="Material/Van_Gogh_Museum,_Kurokawa_wing.jpg" alt="Van Gogh kawa Wing">
                                        <p>Kurokawa Wing atau Exhibition Wing dirancang oleh arsitek Jepang Kisho Kurokawa dan dibuka pada 1999. Berbeda dengan Rietveld Building yang menjadi tempat koleksi permanen, bangunan ini terutama digunakan untuk menyelenggarakan pameran sementara.</p>
                                        <p>Desain Kurokawa menunjukkan gagasan mengenai hubungan antara lingkungan dan arsitektur serta perpaduan antara budaya Jepang dan Eropa. Sebagai tanggapan terhadap bentuk yang lebih geometris dari bangunan Rietveld, Kurokawa menggunakan pendekatan yang lebih asimetris. Salah satu cirinya adalah bentuk bangunan yang menyerupai elips, sementara bagian ruang penyimpanan atau kabinet cetak (print cabinet) dibuat dengan orientasi yang diputar terhadap sumbu bangunan.</p>
                                        <p>Kurokawa sendiri dikenal sebagai arsitek yang banyak merancang bangunan budaya di Jepang dan berbagai negara lain. Pada Van Gogh Museum, pendekatan arsitekturnya memberikan karakter yang berbeda namun tetap terhubung dengan bangunan Rietveld.</p>
                                        
                                    </div>
                                    <div class="enterance">
                                        <h5>Glass Entrance Hall- 2015</h5>
                                        <img src="Material/Glass Entrance Hall.jpg" alt="Van Gogh Glass Entrance Hall">
                                        <p>Untuk menghubungkan kedua bangunan, Van Gogh Museum memiliki glass Entrance Hall di Museumplein. Pembangunan pintu masuk baru ini dimulai pada 2014 dan bangunan tersebut dibuka pada 5 September 2015. Bangunan kaca ini menjadi pintu masuk utama museum yang menghadap Museumplein.</p>
                                        <p>Gedung ini dirancang untuk menghubungkan Rietveld Building dan Kurokawa Wing sekaligus memberikan akses masuk yang lebih luas bagi pengunjung. Realisasi bangunan kaca tersebut melibatkan Hans van Heeswijk architects bekerja sama dengan Octatube.</p>
                                    </div>


                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Our Collection</summary>
                                <p>Van Gogh Museum memiliki koleksi karya Vincent van Gogh yang terbesar di dunia. Koleksi tersebut mencakup lebih dari 200 lukisan, 500 gambar, 800 surat, serta berbagai karya seni lainnya yang dikumpulkan oleh keluarga Van Gogh. Koleksi ini memperlihatkan perkembangan artistik Van Gogh, termasuk gagasan, minat, dan perjalanannya sebagai seorang seniman.</p>
                                <p>oleksi museum tidak hanya berfokus pada karya Van Gogh, tetapi juga mencakup karya seniman yang sezaman, memengaruhi, maupun dipengaruhi olehnya. Melalui koleksi dan katalog daring, pengunjung dapat menelusuri berbagai jenis karya, seperti lukisan, gambar, surat, sketsa, dan cetakan, serta mempelajari lebih jauh hubungan antara karya Van Gogh dengan perkembangan seni pada masanya.</p>

                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Research & Expertise</summary>
                                <p>Van Gogh Museum berperan sebagai pusat keahlian yang melakukan penelitian mengenai kehidupan dan karya Vincent van Gogh. Penelitian tersebut mencakup kajian sejarah seni dan penelitian teknis untuk memahami bahan, teknik, kondisi, serta kebutuhan konservasi karya. Museum juga memanfaatkan koleksi, dokumentasi, perpustakaan, dan berbagai sumber sejarah sebagai bahan penelitian. </p>
                                <p>Salah satu contohnya adalah penelitian mengenai Jo van Gogh-Bonger yang menggunakan surat, buku harian, buku rekening, dan dokumen sejarah untuk mempelajari kehidupannya serta perannya dalam memperkenalkan karya Vincent van Gogh kepada publik. Hasil penelitian kemudian dapat digunakan untuk mendukung pameran, publikasi, konservasi, dan pengembangan pengetahuan mengenai Van Gogh.</p>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Education</summary>
                                <p>Van Gogh Museum menyediakan berbagai program pendidikan untuk membantu pengunjung memahami kehidupan dan karya Vincent van Gogh. Program tersebut ditujukan bagi sekolah, siswa, keluarga, dan pengunjung umum melalui kegiatan seperti tur, workshop, audiotour, dan aktivitas interaktif. Beberapa program, seperti Looking at Van Gogh dan Open Up met Vincent, membantu siswa mengamati karya secara lebih kritis serta mengeksplorasi museum melalui berbagai tugas dan aktivitas.</p>
                                <p>Museum juga menyediakan kegiatan pendidikan yang disesuaikan dengan kelompok usia, termasuk pendidikan dasar. Melalui berbagai kegiatan tersebut, koleksi museum tidak hanya menjadi objek untuk dilihat, tetapi juga dapat digunakan sebagai sumber pembelajaran dan pengalaman bagi pengunjung. </p>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Accessibility</summary>
                                <p>Van Gogh Museum berupaya memberikan akses yang luas bagi pengunjung. Seluruh lantai museum dapat dijangkau menggunakan lift dan tersedia fasilitas seperti toilet aksesibel, kursi roda, wheeled walkers, serta kereta bayi. Museum juga menyediakan berbagai fasilitas, informasi, dan program bagi pengunjung dengan kebutuhan aksesibilitas tertentu</p>
                                <p>Pengunjung yang membutuhkan pendamping juga dapat memperoleh fasilitas pendampingan sesuai ketentuan museum. Selain itu, tersedia kegiatan aksesibilitas bagi pengunjung dengan disabilitas agar lebih banyak orang dapat menikmati dan mengenal koleksi museum</p>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Mission & Vision</summary>
                                    <div class="mission">
                                        <h5>Mission</h5>
                                        <p>Misi Van Gogh Museum adalah:</p>
                                        <blockquote>
                                            <p>“The Van Gogh Museum inspires a diverse audience with the life and work of Vincent van Gogh and his time.”</p>
                                        </blockquote>
                                        <p>Dalam bahasa Indonesia, misi tersebut berarti Van Gogh Museum menginspirasi beragam audiens melalui kehidupan dan karya Vincent van Gogh serta zamannya.</p>
                                    </div>

                                    <div class="core-value">
                                        <h5>Core Value</h5>
                                        <p>Van Gogh Museum memiliki tiga nilai utama, yaitu:</p>

                                        <ul>
                                            <li> <strong>Authentic</strong>-berlandaskan keaslian, pengetahuan, dan keahlian mengenai Vincent van Gogh serta koleksinya.</li>
                                            <li><strong> connection </strong>-menghubungkan karya Van Gogh dengan kehidupan, zamannya, lingkungan artistiknya, serta berbagai audiens dan perspektif. </li>
                                            <li> <strong>Original</strong>-mengembangkan pendekatan yang khas dalam menyajikan, meneliti, dan menghubungkan masyarakat dengan koleksi. </li>
                                        
                                        </ul>
                                    </div>

                                    <div class="vision">
                                        <h5>Core Value</h5>
                                        <p>Van Gogh Museum memiliki visi untuk menjadi lembaga yang tetap aktual dan relevan, mendorong batas, memilih jalannya sendiri, serta menjadi contoh yang orisinal bagi dan bersama pihak lain. Dalam rencana strategis 2025–2028, museum juga menekankan perannya dalam menjaga, mengelola, dan menyajikan koleksi serta menghubungkan masa lalu dengan masa kini melalui pameran, penelitian, pendidikan, dan kegiatan yang melibatkan masyarakat</p>

                                    </div>

                            </details>
                            <div class="kategori">
                                <P>Lihat Juga:</P>
                                    <div class="link-a">
                                        <a href="news.php">News</a>
                                        <a href="biography.php">Biografi</a>
                                        <a href="privacy-policy.php">Privacy Policy</a>
                                        <a href="About us.php">About Us</a>
                                        <a href="ticket-ticketprice.php">Ticket & Ticket Price</a>
                                    </div>
                            </div>
                                    <a href="news.php" class="back-button"> ← Back to News</a>





                        </div>
                </div>


            </div>
        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>