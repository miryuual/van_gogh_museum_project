    <div class="body-layout">

        <!--NAViGASI-->
        <div class="sidebar">
            <aside class="navigasi">
                        <img src="Material/Logo_-_Van_Gogh_Museum.png" alt="Van Gogh Museum Logo" class="sidebar-logo" >
                    
                <h3>Navigation </h3>

                <a href="index.php">Home</a>
                <a href="collection.php">Collection</a>
                <a href="biography.php">Biography</a>
                <a href="news.php">News</a>
                <a href="About us.php">About Us</a>
                <a href="privacy-policy.php">Privacy Policy</a>

                <h3>Tiket & Visit</h3>
                <a href="ticket-ticketprice.php">Ticket & Ticket Prices</a>
                <a href="addres-opening-hours.php">Address & Opening Hours</a>
                
                <?php if (isset($_SESSION["user_id"])): ?>
                            <a href="booking-ticket.php">Booking Ticket</a>
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
