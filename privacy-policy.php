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

            width: 300px;
            height: 400px;
            border-radius: 2px;


            display: flex;
            justify-content: center;
            align-items: center;

            box-sizing: border-box;
        }

        .sub-p{
            font-size: 16px;
            font-weight: 300;
            margin-right: 550px;
            margin-left: 60px;
        }


        /*CONTENTT*/
        .about-us-container {
            display: flex;
            gap: 20px;
            margin-top: 0;
            margin-right: 80px;

            text-align: justify;
        

        }

        .about-us-container img {
            width: 400px;
            height: 300px;
            padding-right: 20px;

            padding-top: 70px;

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

        .about-us-content h6{
            font-size: 20px;
            margin-top: 17px;
            margin-bottom: 5px;
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

        <!--NAViGASI-->
             <?php include 'layout/navigasi.php'; ?>


    <!--main content-->
        <main>
            <h2 class="main-head">Privacy Policy and Personal Information</h2>
            <p class="sub-p">Terkadang kami meminta Anda memberikan data pribadi. Informasi apa saja yang mungkin kami kumpulkan tentang Anda? Bagaimana kami mengelola data tersebut? Silakan baca kebijakan privasi kami untuk mengetahui informasi lebih lanjut.</p>


            <div class="about-us-container">
                <img src="Material/Interior C.jpg" alt="Van Gogh Museum enterance" class="header-image">
                <div class="about-us-content">
                    <h4>Privacy Policy</h4>

                        <p>Semua orang dipersilakan datang ke Van Gogh Museum untuk mendapatkan inspirasi dari Vincent van Gogh dan para seniman sezamannya. Dalam beberapa kondisi, kami memerlukan informasi mengenai Anda yang berkaitan dengan kunjungan Anda. Misalnya, ketika Anda membeli tiket secara online, memesan tur berpemandu, atau membeli barang melalui toko daring kami. Kami menangani data pribadi Anda dengan penuh kehati-hatian karena data tersebut berkaitan dengan privasi Anda.</p>
                        <p>Van Gogh Museum</p>
                        <p>Pernyataan privasi ini berlaku untuk:</p>
                        <p><strong>Van Gogh Museum Foundation,</strong> sebelumnya bernama Rijksmuseum Vincent van Gogh/Rijksmuseum H.W. Mesdag.</p>
                        <p>Dalam semua kondisi ketika istilah “Van Gogh Museum”, “museum”, atau “kami” digunakan, informasi tersebut berlaku untuk pihak ini.</p>
                   
                        <div CLASS="more-info">
                            <details class="comtent-summary">
                                <summary class="content-list">Bagaimana Van Gogh Museum Menangani Data Pribadi Anda?</summary>
                                <p>Van Gogh Museum membatasi pemrosesan data pribadi seminimal mungkin. Namun, museum tetap membutuhkan data pribadi tertentu untuk menyediakan berbagai produk dan layanan. Misalnya, toko daring dan toko tiket online memerlukan data pribadi tertentu agar produk atau layanan yang dipesan dapat diberikan dengan benar.</p>
                                <p>Data pribadi juga diperlukan dalam kondisi lain, seperti ketika Anda memesan tur berpemandu atau acara online, berlangganan komunikasi melalui email, melamar pekerjaan di museum, atau memberikan donasi untuk mendukung museum.</p>
                                <p>Data pribadi ditangani dengan sangat hati-hati. Pada prinsipnya, data tidak diberikan kepada pihak ketiga, kecuali jika hal tersebut diperlukan untuk layanan tertentu atau diwajibkan oleh hukum. Museum berupaya mengamankan data sebaik mungkin dan juga mewajibkan pihak yang memproses data untuk melakukan hal yang sama.</p>
                                <p>Data pribadi disimpan selama waktu sesingkat mungkin dengan tetap mempertimbangkan masa penyimpanan yang diwajibkan oleh hukum.</p>
                                <p>Data hanya diproses apabila museum memiliki kepentingan yang sah, kewajiban hukum, atau apabila Anda telah memberikan izin secara langsung maupun tidak langsung. Sebagai pemilik data pribadi, Anda juga dapat menarik kembali izin tersebut dan meminta data pribadi Anda dihapus.</p>
                             
                                <h6>1. Apa yang Dimaksud dengan Data Pribadi?</h6>
                                <p>Data pribadi adalah semua data yang berkaitan dengan seseorang yang telah atau dapat diidentifikasi. Artinya, informasi tersebut berhubungan langsung dengan seseorang atau dapat dilacak kembali kepada orang tersebut. Data mengenai orang yang telah meninggal atau organisasi tidak dianggap sebagai data pribadi.</p>
                                <h6>2. Apa yang Dimaksud dengan Pemrosesan Data Pribadi?</h6>
                                <p>Pemrosesan berarti seluruh tindakan yang dilakukan terhadap data pribadi, baik secara digital maupun dalam bentuk kertas. Hal tersebut meliputi pengumpulan, pencatatan, pengelompokan, penyimpanan, pengeditan, perubahan, permintaan, konsultasi, penggunaan, penerusan, pendistribusian, penggabungan, penghubungan, perlindungan, penghapusan, pemusnahan, serta penyediaan data pribadi.</p>
                                <h6>3. Data Pribadi Apa yang Kami Proses?</h6>
                                <p>Van Gogh Museum dapat memproses berbagai jenis data pribadi berikut.</p>
                                <h6>Kunjungan Museum</h6>
                                <ul>
                                    <li>Rekaman CCTV dibuat di dalam dan di luar museum untuk tujuan keamanan. Rekaman digunakan untuk membantu menjaga keamanan pengunjung, staf, dan karya seni.</li>
                                    <li>Dalam acara tertentu, seperti Vincent on Friday, pembukaan pameran baru, pembelian karya seni baru, dan kegiatan lainnya, museum dapat mengambil foto atau video untuk memberikan laporan dan gambaran mengenai kegiatan tersebut. Persetujuan tidak diminta untuk gambar yang dibuat dalam konteks kebebasan pers. Jika Anda tidak ingin difoto, Anda dapat memberi tahu fotografer. Untuk anak di bawah umur atau orang yang tidak memiliki kapasitas hukum, persetujuan akan diminta dari perwakilan hukum yang ditunjuk.</li>
                                    <li>Untuk gambar lain yang dibuat di dalam atau di luar museum, museum akan meminta persetujuan.</li>
                                </ul>
                                <h6>Kunjungan Museum</h6>
                                <p>Website menyediakan berbagai layanan. Pengunjung dapat membeli tiket masuk museum, tiket acara online, atau merchandise Van Gogh. Pengunjung juga dapat memesan tur berpemandu, audiotour, workshop, memberikan dukungan kepada museum, berlangganan komunikasi email, atau meminta museum memeriksa apakah suatu karya merupakan karya Van Gogh.</p>
                                <p>Dalam kondisi tersebut, pengunjung diminta memberikan data pribadi agar pembelian, permintaan, atau pertanyaan dapat ditangani dengan baik</p>
                                <p>Museum juga menggunakan kamera penghitung pengunjung. Kamera tersebut langsung mengubah gambar menjadi angka. Teknologi ini digunakan untuk membantu mengatur penyebaran pengunjung di dalam museum serta menjaga keselamatan pengunjung dan karyawan. Tidak ada gambar yang disimpan.</p>
                                <p>Museum menggunakan cookies, analytics, dan teknologi lainnya pada website dan aplikasi. Teknologi tersebut membantu memastikan website dan aplikasi berfungsi dengan baik serta mengumpulkan data untuk meningkatkan website. Data dianonimkan jika memungkinkan dan tidak diberikan kepada pihak ketiga</p>
                         
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list" >Kapan Kami Memproses Data Pribadi?</summary>
                                <p>Data pribadi hanya diproses jika:</p>
                                <ul>
                                    <li>diperlukan untuk memenuhi suatu perjanjian;</li>
                                    <li>pemilik data memberikan izin yang jelas;</li>
                                    <li>terdapat kepentingan yang sah bagi Van Gogh Museum, misalnya untuk analisis, keamanan, atau pemasaran langsung;</li>
                                    <li>pemrosesan diperlukan untuk memenuhi kewajiban hukum.</li>
                                    <li>1973 -Van Gogh Museum dibuka untuk publik.</li>
                                </ul>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list" >Pemrosesan oleh Pihak Ketiga</summary>
                                <p>Museum memberikan data pribadi kepada pihak ketiga apabila diperlukan karena alasan teknis atau kewajiban hukum. Pihak ketiga dapat membantu menyediakan layanan atau memenuhi perjanjian, misalnya layanan pengiriman untuk mengirim pesanan toko online atau penyedia layanan untuk mengirim tiket ke email.</p>
                                <p>Museum memilih pihak ketiga yang memenuhi standar keamanan dan pedoman privasi serta membuat perjanjian mengenai pengelolaan data pribadi. Van Gogh Museum tetap bertanggung jawab atas pemrosesan data tersebut.</p>
                                <p>Dalam kasus tertentu, polisi, pengadilan, pengawas, kantor pajak, atau hakim dapat meminta data berdasarkan dasar hukum yang berlaku. Dalam kondisi tersebut museum wajib memberikan data yang diperlukan</p>
                                
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list" >Mengapa Kami Memproses Data Ini?</summary>
                                <p>Data pribadi hanya diproses jika:</p>
                                <ul>
                                    <li>Menangani pesanan, permintaan autentikasi, permintaan materi visual, workshop, penyewaan tempat, tur berpemandu, dan aktivitas museum lainnya.</li>
                                    <li>Menghubungi pengunjung jika terdapat masalah atau pertanyaan mengenai pelaksanaan perjanjian.</li>
                                    <li>Menghubungi pengunjung jika terjadi perubahan mendesak terhadap waktu atau tanggal kunjungan.</li>
                                    <li>Membuat kunjungan ke museum senyaman mungkin.</li>
                                    <li>Menyediakan layanan dan informasi yang diperlukan sebelum kunjungan.</li>
                                    <li>Menjaga keamanan pengunjung, staf, dan karya seni.</li>
                                    <li>Menyediakan tur atau workshop dalam bahasa yang diinginkan.</li>
                                    <li>Menyesuaikan workshop anak berdasarkan usia peserta.</li>
                                    <li>Menerima donasi.</li>
                                    <li>Melakukan pembayaran atas layanan atau menerima donasi.</li>
                                    <li>Menyelenggarakan pameran.</li>
                                    <li>Berkomunikasi dalam bahasa pilihan pengunjung.</li>
                                    <li>Menangani lamaran pekerjaan.</li>
                                    <li>Memberikan informasi yang diminta.</li>
                                    <li>Mengundang pengunjung ke acara.</li>
                                    <li>Menjawab pertanyaan atau menangani keluhan melalui media sosial, email, surat, atau telepon.</li>
                                    <li>Memungkinkan Sharingbox mengirim foto yang dibuat melalui photo booth.</li>
                                    <li>Memungkinkan pengunjung mengikuti giveaway dan menerima hadiah.</li>
                                    <li>Mengucapkan selamat ulang tahun.</li>
                                    <li>Memahami jaringan dan hubungan museum untuk meningkatkan kegiatan penggalangan dana.</li>
                                    <li>Melakukan analisis untuk meningkatkan layanan, dengan data dianonimkan jika memungkinkan.</li>
                                    <li>Memproses data berdasarkan persetujuan.</li>
                                    <li>Menganalisis asal pengunjung melalui laporan anonim untuk membantu mengatur arus wisatawan di Amsterdam.</li>
                                    <li>Menguji pencapaian tujuan museum dalam bidang inklusivitas dan keberlanjutan melalui laporan anonim.</li>
                                    <li>Menyediakan laporan anonim mengenai pengunjung dan asal mereka kepada Kementerian Pendidikan, Kebudayaan, dan Ilmu Pengetahuan Belanda jika diminta.</li>
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
                            <a href="index.php" class="back-button"> ← Back to Home</a>





                        </div>
                </div>


            </div>
        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>