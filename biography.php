
<?php
    session_start();
    include 'layout/header.php';?>

      
      <style>
            .main-head{
                margin-left: 50px;
            }
            .main-head h2{
                font-size: 50px;
                font-weight: 500;
                margin-top: 20px;
                margin-bottom: 0;
                
            }
            .main-head p{
                font-size: 20px;
                font-weight: 300;
                margin-top: 0;
            }

            main{
                flex: 1;
                min-height: 3650px;

                background-color: white;
                border-radius: 7px;
                padding-left: 30px;
                padding-left: 30px;
                padding-top: 30px;

            }



            /*BIOGRAPHY PAGE1*/
            .van-bio{
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 30px;


                margin-top: 30px;
                margin-bottom: 20px;
            }
            .van-bio img{
                width: 300px;
                height: auto;
                border-radius: 2px;
                margin-left: 50px;

                padding-top: 0;
                margin-top: 0;
            }

            .bio-portrait p{
                font-weight: 300;
                font-size: 14px;
                text-align: center;
                margin-top: 5px;
            }

            .bio-content h4{
                font-size: 35px;
                font-weight: 500;
                margin: 0;
                padding-left: 35px;
            }
            .bio-content p{
                font-size: 17px;
                font-weight: 400;
                padding-right: 130px;
                padding-left: 45px;
                text-align: justify;
            }

            /*BIOGRAPHY PAGE2*/
            .van-bio2{
                display: flex;
                justify-content: center;
                align-items: center;


                margin-top: 30px;
                margin-bottom: 20px;
                margin-right: 50px;
            }
            .van-bio2 img{
                width: 300px;
                height: auto;
                border-radius: 2px;

                padding-top: 0;
                margin-top: 0;
            }

            .bio-portrait2 p{
                font-weight: 300;
                font-size: 14px;
                text-align: center;
                margin-top: 5px;
                margin-bottom: 250px;
            }

            .bio-content2 h4{
                font-size: 35px;
                font-weight: 500;
                margin: 0;
                padding-left: 35px;
            }
            .bio-content2 p{
                font-size: 17px;
                font-weight: 400;
                padding-right: 130px;
                padding-left: 45px;
                text-align: justify;
            }

            /*LINKS*/
            .kategori{
                margin-top: 60px;
                margin-bottom: 30px;
                margin-left: 50px;
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
                margin-left: 50px;
                margin-top: 50px;
            }

        </style>

    
    <!--Navigasi-->
      <?php include 'layout/navigasi.php'; ?>

    <!--MAIN BODY-->

    <!--main content-->
        <main>
            <div class="main-head">
                <h2 >Vincent Willem van Gogh Biography In Details</h2>
                <p> (30 March 1853 – 29 July 1890) </p>
            </div>

            <div class="van-bio">
                <section class="bio-portrait">
                    <img src="material/vangogh-selfpotrait.jpg" alt="Van Gogh Self Portrait">
                    <p><i>Van Gogh-Self Portrait</i></p>
                </section>

                <section class="bio-content">
                    <h4>Vincent Willem van Gogh</h4>


                    <p><b>Vincent Willem van Gogh</b> (30 Maret 1853 – 29 Juli 1890) adalah seorang seniman Belanda yang dikenal sebagai salah satu tokoh Pasca-Impresionisme (Post-Impressionisme). Lukisan dan gambarnya termasuk di antara karya seni yang paling terkenal, populer, dan bernilai tinggi di dunia.</p>
                    <p>Van Gogh menghabiskan masa dewasa awalnya bekerja di sebuah perusahaan perdagangan karya seni. Setelah sempat bekerja sebagai guru, ia kemudian menjadi pekerja misionaris di sebuah wilayah pertambangan yang sangat miskin. Ia baru mulai menekuni karier sebagai seniman pada tahun 1880. Pada awalnya, Van Gogh menggunakan warna-warna gelap dalam karyanya, hingga ia mengenal Impresionisme dan Neo-Impresionisme ketika berada di Paris. Ia kemudian mengadopsi warna-warna yang lebih cerah dan teknik melukis dari kedua aliran tersebut, lalu mengembangkannya menjadi gaya yang khas dan mudah dikenali. Gaya tersebut berkembang semakin matang selama ia tinggal di Arles, Prancis.</p>
                    <p>Dalam sepuluh tahun terakhir hidupnya, Van Gogh menghasilkan lebih dari 2.000 karya, termasuk sekitar 900 lukisan dan 1.100 gambar serta sketsa. Sebagian besar karyanya yang paling terkenal dibuat dalam dua tahun terakhir hidupnya. Pada masa tersebut, ia mengalami gangguan dalam hubungannya dengan Paul Gauguin dan dalam sebuah episode krisis, Van Gogh memotong sebagian telinga kirinya. Setelah kejadian tersebut, ia mengalami beberapa kali gangguan kesehatan mental yang berujung pada kematiannya karena bunuh diri.</p>
                    <p>Tokoh yang sangat penting dalam kehidupan Van Gogh adalah adiknya, Theo van Gogh, yang terus memberikan dukungan finansial kepadanya dengan penuh perhatian. Hubungan dekat mereka sepanjang hidup terdokumentasikan dalam banyak surat yang mereka tukarkan sejak Agustus 1872. Van Gogh dikenal sebagai salah satu pelopor aliran yang kemudian disebut Ekspresionisme. Ia memberikan pengaruh besar terhadap perkembangan seni abad ke-20, khususnya terhadap kelompok Fauvisme dan Ekspresionisme Jerman.</p>
                </section>

            </div>

            <div class="van-bio2">

                <section class="bio-content2">
                    <h4>Life and Career</h4>
                    <p>Vincent lahir di Zundert, Belanda. Ayahnya adalah seorang pendeta Protestan, profesi yang menarik bagi Vincent dan kemudian sedikit banyak memengaruhi kehidupannya. Menurut saudara perempuannya, Vincent adalah anak yang serius dan suka merenung.</p>
                    <p>Pada usia 16 tahun, Vincent mulai bekerja di perusahaan perdagangan karya seni Goupil & Co. di Den Haag. Adiknya, Theo, yang empat tahun lebih muda dan memiliki hubungan persahabatan yang sangat dekat dengannya, kemudian ikut bekerja di perusahaan tersebut. Hubungan mereka sepanjang hidup terdokumentasikan dengan baik melalui banyak surat yang mereka kirimkan satu sama lain. Surat-surat tersebut disimpan dan diterbitkan pada tahun 1914. Isinya memberikan banyak gambaran tentang kehidupan Van Gogh sekaligus menunjukkan bahwa ia adalah seorang penulis berbakat dengan pemikiran yang tajam. Theo juga terus memberikan dukungan finansial kepada Vincent sepanjang hidupnya.</p>
                    <p>Pada tahun 1873, perusahaan tempatnya bekerja memindahkannya ke London, kemudian ke Paris. Vincent semakin tertarik pada agama dan pada tahun 1876 Goupil memberhentikannya karena dianggap kurang memiliki motivasi. Ia kemudian menjadi asisten pengajar di Ramsgate dekat London, sebelum kembali ke Amsterdam pada tahun 1877 untuk mempelajari teologi.</p>
                    <p>Setelah berhenti dari studinya pada tahun 1878, Vincent menjadi pengkhotbah awam di sebuah wilayah pertambangan miskin bernama Borinage, Belgia. Ia bahkan berkhotbah di dalam tambang dan sangat peduli terhadap kehidupan para pekerja. Setelah enam bulan, ia diberhentikan dan tetap melanjutkan kegiatannya tanpa menerima bayaran. Pada masa inilah ia mulai membuat sketsa menggunakan arang.</p>
                    <p>Pada tahun 1880, mengikuti saran dari adiknya Theo, Vincent van Gogh mulai menekuni seni lukis dengan serius. Untuk waktu yang singkat, ia belajar melukis dari Anton Mauve di Den Haag. Meskipun hubungan Vincent dan Anton kemudian berakhir karena perbedaan pandangan artistik, pengaruh aliran Den Haag tetap terlihat dalam karya Vincent, terutama dalam cara ia memainkan cahaya dan menggunakan sapuan kuas yang lebih bebas. Namun, penggunaan warna-warna gelap dalam karya Vincent membedakannya dari gurunya.</p>
                    <p>Pada tahun 1881, Vincent menyatakan cintanya kepada sepupunya yang telah menjadi janda, Kee Vos, tetapi cintanya ditolak. Ia kemudian tinggal bersama seorang pekerja seks bernama Sien Hoornik dan anak-anaknya serta sempat mempertimbangkan untuk menikahinya. Ayahnya sangat menentang hubungan tersebut, bahkan Theo juga menyarankan agar Vincent tidak melanjutkannya. Hubungan mereka akhirnya berakhir</p>
                    <p>Terinspirasi oleh Jean-François Millet, Van Gogh mulai berfokus pada kehidupan para petani dan pemandangan pedesaan. Ia kemudian pindah ke provinsi Drenthe dan selanjutnya ke Nuenen, Brabant Utara, Belanda. Di sana, pada tahun 1885, ia menghasilkan sejumlah karya yang menggambarkan kehidupan pedesaan.</p>
                    <p>Pada musim dingin 1885–1886, Van Gogh mengikuti pendidikan di akademi seni di Antwerpen, Belgia. Pengalaman tersebut tidak berlangsung lama karena ia dikeluarkan oleh profesornya setelah beberapa bulan. Namun, selama berada di Antwerpen, Van Gogh mulai mengenal seni Jepang dan sangat tertarik untuk mengoleksinya. Ia mengagumi penggunaan warna-warna cerah, pemanfaatan ruang kanvas, serta peran garis dalam karya seni Jepang. Pengaruh tersebut kemudian terlihat kuat dalam karya-karyanya. Ia bahkan membuat beberapa lukisan dengan gaya Jepang dan menggunakan latar yang terinspirasi dari seni Jepang dalam beberapa potret yang dibuatnya.</p>
                    <p>Pada musim semi 1886, Vincent van Gogh pergi ke Paris dan tinggal bersama adiknya Theo. Mereka menempati sebuah rumah di Montmartre. Di sana ia bertemu dengan sejumlah pelukis, termasuk Edgar Degas, Camille Pissarro, Émile Bernard, Henri de Toulouse-Lautrec, dan Paul Gauguin. Vincent kemudian mengenal Impresionisme dan menyukai penggunaan cahaya serta warnanya, meskipun ia merasa aliran tersebut kurang memiliki keterlibatan sosial. Ia terutama tertarik pada teknik pointilisme, yaitu teknik menggunakan banyak titik kecil pada kanvas yang dari kejauhan menyatu menjadi warna tertentu dalam pandangan mata. Teknik ini memberikan pengaruh terhadap perkembangan gaya Van Gogh. Meskipun demikian, Van Gogh lebih dikenal sebagai seniman Pasca-Impresionisme, bukan Impresionisme.</p>
                    <p>Pada tahun 1888, kehidupan di kota dan tinggal bersama adiknya membuat Van Gogh merasa tidak nyaman. Ia meninggalkan Paris dan pergi ke Arles, Prancis. Ia terkesan dengan pemandangan daerah tersebut dan berharap dapat mendirikan sebuah komunitas seniman. Ia menghias sebuah rumah yang dikenal sebagai “Yellow House” dan menciptakan rangkaian lukisan bunga matahari yang terkenal. Dari rencana tersebut, hanya Paul Gauguin yang menerima undangannya untuk bergabung. Van Gogh tertarik pada penggunaan warna dan bentuk sederhana dalam gaya Gauguin yang dikenal sebagai sintetisme. Keduanya saling mengagumi, dan Gauguin bahkan melukis Van Gogh ketika sedang membuat lukisan bunga matahari. Namun, hubungan mereka berakhir dalam pertengkaran. Van Gogh mengalami krisis dan memotong sebagian telinga kirinya, yang kemudian ia berikan kepada seorang perempuan yang dikenalnya. Gauguin meninggalkan Arles pada Desember 1888.</p>
                    <p>Satu-satunya lukisan yang berhasil dijual Van Gogh selama hidupnya adalah The Red Vineyard, yang dibuat pada tahun 1888. Saat ini, lukisan tersebut dipamerkan di Pushkin Museum di Moskow, Rusia.</p>
                    <p>Setelah itu, Van Gogh mulai mengganti teknik titik-titiknya dengan sapuan kuas kecil berbentuk garis. Ia mengalami depresi dan pada tahun 1889, atas permintaannya sendiri, Van Gogh dirawat di pusat kesehatan jiwa Saint-Paul-de-Mausole di Saint-Rémy-de-Provence, Prancis. Selama berada di sana, bangunan klinik dan tamannya menjadi salah satu subjek utama dalam karya-karyanya. Sapuan pensil dan kuasnya kemudian kembali berubah menjadi bentuk lengkung seperti spiral.</p>
                    <p>Pada Mei 1890, Vincent van Gogh meninggalkan klinik dan pergi menemui dokter Paul Gachet di Auvers-sur-Oise, dekat Paris. Lokasi tersebut juga membuatnya lebih dekat dengan adiknya Theo yang baru saja menikah. Gachet direkomendasikan kepada Van Gogh oleh Pissarro dan sebelumnya telah menangani beberapa seniman. Di sana, Van Gogh membuat satu-satunya karya etsa miliknya, yaitu potret dokter Gachet. Kondisi depresinya semakin memburuk. Pada 27 Juli 1890, di usia 37 tahun, setelah melalui periode produktivitas melukis yang tinggi, Van Gogh menembak dirinya sendiri di bagian dada. Ia meninggal dua hari kemudian dengan Theo berada di sisinya. Theo melaporkan bahwa kata-kata terakhir Vincent adalah “La tristesse durera toujours” (bahasa Prancis: “Kesedihan akan berlangsung selamanya”).</p>
                    <p>Van Gogh dimakamkan di pemakaman Auvers-sur-Oise. Theo, yang tidak mampu menerima kepergian saudaranya, meninggal enam bulan kemudian dan dimakamkan di sebelah Vincent. Tidak lama setelah kematian mereka, ketenaran Van Gogh mulai berkembang pesat. Berbagai pameran besar kemudian diselenggarakan, antara lain di Paris pada 1901, Amsterdam pada 1905, Köln pada 1912, New York pada 1913, dan Berlin pada 1914.</p>
                    <p>Ibu Vincent van Gogh pernah membuang cukup banyak lukisan karya anaknya, baik ketika Vincent masih hidup maupun setelah kematiannya. Namun, ia hidup cukup lama untuk menyaksikan putranya menjadi seorang pelukis yang dikenal di seluruh dunia.</p>
                </section>


                <section class="bio-portrait2">
                    <img src="material/Irises.jpg" alt="Irises">
                    <p><i>Van Gogh-Irisses</i></p>

                    <img src="material/Boulevard de Clichy.jpg" alt="Boulevard de Clichy">
                    <p><i>Van Gogh-Boulevard de Clichy</i></p>

                    <img src="material/Self-Portrait with Grey Felt Hat.jpg" alt="Self-Portrait with Grey Felt Hat">
                    <p><i>Van Gogh-Self-Portrait with Grey Felt Hat</i></p>

                    <img src="material/Wheatfield with Crows.jpg" alt="Wheatfield with Crows">
                    <p><i>Van Gogh-Wheatfield with Crows</i></p>
                </section>

            </div>

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
        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php'; ?>