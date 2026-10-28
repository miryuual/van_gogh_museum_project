<?php
    session_start();
    include 'layout/header.php';?>



        <style>
            
            .main-head{
                font-size: 80px;
            }

            .content{
                display: flex;
            }

            .mini-content{
                margin-right: 300px;
                margin-left: 80px;
                font-weight: 300;

            }

            .main-content{
                margin-left: 50px;
                margin-right: 80px;
                text-align: justify;
            }

            .main-content h4{
                font-size: 30px;
                margin-bottom: 5px;
            }

            .main-content p{
                font-weight: 300;
            }
            ul {
                font-weight: 300;
            }

            table th{
                font-weight: 400;
                border-bottom: 1px solid black;
                text-align: left;
                padding-right: 40px;
            }

            .main-image{
                margin-top: 60px;
                width: 400px;
                height: auto;
                
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
            <h2 class="main-head">Ticket & Ticket Price</h2>
                <div class="mini-content">
                <p>Nikmati pengalaman melihat karya-karya Vincent van Gogh secara langsung dengan mengunjungi Van Gogh Museum di Amsterdam. Sebelum berkunjung, pengunjung perlu memesan tiket secara daring dengan memilih tanggal dan waktu kunjungan yang tersedia.Tiket memberikan akses ke koleksi museum yang menampilkan berbagai lukisan, gambar, dan karya lainnya yang berkaitan dengan kehidupan serta perkembangan artistik Vincent van Gogh. Pengunjung juga dapat menambahkan audiotour untuk memperoleh informasi lebih lanjut mengenai karya dan kehidupan Van Gogh selama menjelajahi museum.</p>
                </div>
            <div class="content">  
                <div>
                    <img src="Material/Interior E.jpg." alt="museum" class="main-image">

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
                <div class="main-content">

                    <h4>Harga Tiket</h4>
                        <table>
                            <tr style="font-size: 20px;">
                                    <th><strong>Jenis Tiket </strong></th>
                                    <th><strong>Harga</strong></th>
                            </tr>
                            <tr>
                                <th>Dewasa</th>
                                <th>€25,00</th>
                            </tr>

                            <tr>
                                <th>Pengunjung di bawah 18 tahun</th>
                                <th>Gratis</th>
                            </tr>

                            <tr>
                                <th>Mahasiswa EU/EEA</th>
                                <th>€16,00</th>
                            </tr>
                            <tr>
                                <th>Museumkaart</th>
                                <th>Gratis</th>
                            </tr>
                            <tr>
                                <th>ICOM</th>
                                <th>Gratis</th>
                            </tr>
                            <tr>
                                <th>Stadspas</th>
                                <th>Gratis</th>
                            </tr>
                            <tr>
                                <th>Vereniging Rembrandt</th>
                                <th>Gratis</th>
                            </tr>
                            <tr>
                                <th>Friends & Partner Passes</th>
                                <th>Gratis</th>
                            </tr>
                            <tr>
                                <th>Tiket Pendamping</th>
                                <th>Gratis</th>
                            </tr>

                        </table>

                        <p>Mahasiswa hanya dapat menggunakan tarif mahasiswa jika terdaftar pada institusi pendidikan di wilayah Uni Eropa (EU) atau Wilayah Ekonomi Eropa (EEA). Pengunjung yang tidak dapat berkeliling museum secara mandiri dapat membawa satu orang pendamping secara gratis. Tiket pendamping sudah termasuk audiotour.</p>


                    <h4>Audiotour</h4>
                        <p>Pengunjung juga dapat menambahkan audiotour untuk mendapatkan informasi lebih lanjut mengenai kehidupan dan karya Vincent van Gogh.</p>
                    
                            <table>
                                <tr>
                                    <th>Dewasa</th>
                                    <th>€3,75</th>
                                </tr>
                                <tr>
                                    <th>Usia 13–17 tahun</th>
                                    <th>€2,00</th>
                                </tr>
                                <tr>
                                    <th>Videotour dalam Bahasa Isyarat Belanda</th>
                                    <th>Gratis</th>
                                </tr>
                            </table>
                        <p>Audiotour tersedia dalam berbagai bahasa.</p>
                    
                    <h4>Hal yang Perlu Diperhatikan</h4>

                        <ul>
                            <li>Setiap pengunjung membutuhkan tiket masuk yang valid.</li>
                            <li>Tiket hanya berlaku pada tanggal dan waktu yang telah dipilih.</li>
                            <li>Tiket yang telah dibeli tidak dapat dikembalikan.</li>
                            <li>Untuk kunjungan kelompok, pemesanan harus dilakukan melalui layanan group visit. Pemesanan kelompok melalui halaman tiket reguler tidak berlaku.</li>

                        </ul>

                    <h4>Tiket Satu Jam</h4>
                        <p>Van Gogh Museum juga menyediakan Final Hour Ticket, yaitu tiket untuk mengunjungi museum selama satu jam pada akhir hari. Tiket ini berlaku pada pukul 16.45–17.00 dan kunjungan berlangsung selama satu jam hingga museum tutup pukul 18.00.</p>
                         
                        <a href="booking-ticket.php" class="back-button" style="margin-top: 10px;"> Pesan Tiket →</a>

                        
                </div> 
         
             </div>

        </main>





    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>