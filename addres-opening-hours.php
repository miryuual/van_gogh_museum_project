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
            <h2 class="main-head">Addres & Opening Hours</h2>
            <p class="sub-p">Terkadang kami meminta Anda memberikan data pribadi. Informasi apa saja yang mungkin kami kumpulkan tentang Anda? Bagaimana kami mengelola data tersebut? Silakan baca kebijakan privasi kami untuk mengetahui informasi lebih lanjut.</p>


            <div class="about-us-container">
                <img src="Material/_museum_flat_crop_HR.jpg" alt="Van Gogh Museum enterance" class="header-image">
                <div class="about-us-content">
                    <h4>Alamat</h4>

                        <p>Kunjungi Van Gogh Museum di:</p>
                        <p>Museumplein 6</p>
                        <p>1071 DJ Amsterdam</p>
                        <p>Pintu masuk utama Van Gogh Museum. Foto: Tom Elst</p>
                        <p>Pintu masuk utama Van Gogh Museum terletak di Museumplein.</p>


                   
                        <div CLASS="more-info">
                            <details class="comtent-summary">
                                <summary class="content-list">Jam Buka</summary>
                                <p>Jam Buka</p>
                                <p>Oktober</p>
                                    <ul>
                                        <li>1–12 Oktober: pukul 09.00–18.00, Jumat hingga pukul 21.00.</li>
                                        <li>3 Oktober: pukul 09.00–17.00.</li>
                                        <li>14 Oktober: pukul 09.00–18.00.</li>
                                        <li>15–18 Oktober: pukul 09.00–17.00, Jumat hingga pukul 21.00, Sabtu dan Minggu hingga pukul 18.00.</li>
                                        <li>19–31 Oktober: pukul 09.00–18.00, Jumat hingga pukul 21.00.</li>
                                    </ul>
                                <p>November</p>
                                    <ul>
                                        <li>1 November: pukul 09.00–18.00.</li>
                                        <li>2–30 November: pukul 09.00–17.00, Jumat hingga pukul 21.00, kecuali 27 November. Lihat program Vincent on Friday untuk informasi lebih lanjut.</li>
                                    </ul>
                                <p>Desember</p>
                                    <ul>
                                        <li>1–18 Desember: pukul 09.00–17.00, Jumat hingga pukul 21.00.</li>
                                        <li>19–23 Desember: pukul 09.00–18.00.</li>
                                        <li>24, 25, dan 26 Desember (libur Natal): pukul 09.00–17.00.</li>
                                        <li>27–30 Desember: pukul 09.00–18.00.</li>
                                        <li>31 Desember: pukul 09.00–17.00.</li>

                                    </ul>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list" >Kapan Kami Memproses Data Pribadi?</summary>
                                <p>Data pribadi hanya diproses jika:</p>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Tiket Masuk</summary>
                                <p>Semua tiket tersedia secara daring dan sudah termasuk akses ke koleksi permanen serta pameran yang sedang berlangsung. Semua pengunjung diwajibkan melakukan pemesanan tiket masuk terlebih dahulu dengan memilih waktu kunjungan.</p>
                                
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list" >Aksesibilitas</summary>
                                    <p>Van Gogh Museum berkomitmen untuk memastikan akses yang nyaman bagi seluruh pengunjung. Pengunjung yang tidak dapat menjelajahi museum secara mandiri diperbolehkan membawa satu orang pendamping secara gratis dan dapat menggunakan berbagai fasilitas, termasuk alat bantu mobilitas.</p>
                                    <p>Pengunjung dengan disabilitas tersembunyi, seperti sensitivitas sensorik, demensia, atau PTSD, akan mendapatkan dukungan sesuai dengan kebutuhan mereka dengan menggunakan Hidden Disabilities Sunflower Keychain.</p>
                            </details>




                            <details class="comtent-summary">
                                <summary class="content-list">Petunjuk Arah</summary> 
                                <p>Bagaimana cara menuju Van Gogh Museum menggunakan transportasi umum atau mobil?</p>
                                <p>Transportasi Umum</p>
                                <p>Halte terdekat adalah Museumplein dan Concertgebouw.</p>
                                <p>Dari Museumplein, pengunjung dapat menggunakan:</p>
                                        <ul>
                                            <li>Trem 2, 5, atau 24</li>
                                            <li>Bus 357 atau 397</li>
                                        </ul>
                                <p>Dari Concertgebouw, pengunjung dapat menggunakan:</p>
                                        <ul>
                                            <li>Trem 5, 12, atau 24</li>
                                            <li>Bus 347 atau 357</li>
                                        </ul>
                                <p>Rencanakan perjalanan melalui situs atau aplikasi 9292, atau hubungi +31 900 9292.</p>
                                <p>Rencanakan perjalanan melalui 9292</p>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Dari Amsterdam Central Station</summary>
                                <p>Naik trem 2, 5, atau 24. Turun di halte Museumplein.</p>
                                
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Dari Zuid WTC Station</summary>
                                  <p>Naik trem 5 menuju Westergasfabriek. Turun di halte Concertgebouw.</p>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Dari Amsterdam Amstel Station</summary>
                                <p>Dari Amsterdam Amstel Station</p>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Dari Amsterdam Sloterdijk Station</summary>
                                <p>Naik trem 19, kemudian berganti di Leidseplein ke trem 2, 5, atau 24. Turun di halte Museumplein</p>
                            </details>

                            <details class="comtent-summary">
                                <summary class="content-list">Parkir</summary>
                                <p>Q-Park, yang berada di bawah Museumplein, merupakan tempat parkir terdekat dengan Van Gogh Museum. Pintu masuknya berada di Van Baerlestraat. Perlu diperhatikan bahwa parkir berbayar juga berlaku di jalan-jalan di sekitar museum.</p>
                                    <ul>
                                        <li>Informasi lebih lanjut mengenai parkir di Amsterdam</li>
                                        <li>Rencanakan rute melalui Google Maps</li>


                                    </ul>
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