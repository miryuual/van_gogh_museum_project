    <div class="body-layout">

        <!--NAViGASI-->
        <div class="sidebar">
            <aside class="navigasi">
                        <img src="/van_gogh_museum/assets/logo/Logo_-_Van_Gogh_Museum.png" alt="Van Gogh Museum Logo" class="sidebar-logo" >
                    
                <h3>Navigation </h3>

                <a href="/van_gogh_museum/index.php">Home</a>
                <a href="<?= '/van_gogh_museum/page/koleksi/koleksi.php' ?>">Collection</a>
                <a href="<?= '/van_gogh_museum/page/museum/biography.php' ?>">Biography</a>
                <a href="<?= '/van_gogh_museum/page/news/news.php' ?>">News</a>
                <a href="<?= '/van_gogh_museum/page/museum/about-us.php' ?>">About Us</a>
                <a href="<?= '/van_gogh_museum/page/museum/privacy-policy.php' ?>">Privacy Policy</a>

                <h3>Tiket & Visit</h3>
                <a href="<?= '/van_gogh_museum/page/ticket/ticket-price.php' ?>">Ticket & Ticket Prices</a>
                <a href="<?= '/van_gogh_museum/page/museum/addres-opening-hours.php' ?>">Address & Opening Hours</a>
                
                <?php if (isset($_SESSION["user_id"])): ?>
                            <a href="<?= '/van_gogh_museum/page/ticket/booking-tickete.php' ?>">Booking Ticket</a>
                        <?php endif; ?>
            </aside>
            <aside class="navigasi2">
                    
                <h3>Related Website</h3>

                <a href="https://www.vangoghmuseum.nl/en">Ofiicial Van Gogh Museum</a>
                <a href="https://www.vincent-van-gogh-gallery.org/">Vincent Van Gogh Gallery</a>
                <a href="https://www.vggallery.com/">VGGallery</a>
                <a href="https://www.rijksmuseum.nl/en">Rijksmuseum</a>
                <a href="https://www.musee-orsay.fr/en">Musée d'Orsay</a>
                <a href="https://www.louvre.fr/en">The Louvre Museum</a>
            </aside>
        </div>
