<?php
    session_start();
    include 'layout/header.php';?>
   
   
<style>

/*MAIN CONTENT*/
main{

    min-height: 1900px;

}



/* Collection Detail Page CSS */

.main-head{
    margin-bottom: 40px;

}
.collection-detail{
    position: relative;

    width: 100%;
    height: 550px;
}
.collection-bacground{
   position: absolute;

    top: 0;
    left: 0;

    margin-left: 60px;

    width: calc(100% - 60px);
    height: 500px;

    background-color: #d3e1ea;
    border: 1.5px solid #8cb1c8;
}
.collection-detail-image{

    padding: 55px;
    position: absolute;

    top: 0;
    left: 50%;

    transform: translateX(-50%);

    height: 500px;
    width: auto;

    z-index: 2;

}

h4{
    text-align: center;
    margin-top: 10px;
    font-size: 45px;
    margin-bottom: 6px;
}

.artwork-container{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 0px;
    margin-bottom: 40px;
    font-size: 20px;

}
.object-information{
    margin-right: 70px;
    margin-left: 0;
    margin-bottom: 20px;
}
.back-button{
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #000000;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
.kategori{
    margin-top: 60px;
    margin-bottom: 40px;
}
.kategori p{
    margin: 0;
    font-size: 60px;
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
/* Object Information and Description Section */

.collection-detail{
    display: grid;
    grid-template-columns: repeat(2,1fr);

}

.collection-detail h4{
    font-size: 30px;
    font-weight: 600;
    text-align: left;
    margin-bottom: 10px;
}

.collection-detail p{
    font-size: 18px;
    line-height: 1.5;
    font-weight: 400;
    text-align: justify;
}

.collection-description p{
    margin-right: 80px;
}


</style>
    




<body>
    
    <!--MAIN BODY-->

        <!--NAViGASI-->
             <?php include 'layout/navigasi.php'; ?>

    <!--main content-->
        <main>
            <h2 class="main-head">Almond Blossom</h2>

            <section class="collection-detail">
                <div class="collection-bacground"  style="--artwork-color: #8B6F47;"></div>
                <img src="Material/vangoghmuseum-s0176V1962-800.jpg" alt="Almond Blossom" class="collection-detail-image">

            </section>

            <h4>Almond Blossom</h4>
            <div class="artwork-container">
                <div class="artwork-actions">
                    <a id="zoomOut">[−]</a>
                    <a id="zoomIn">[+]</a>

                    <a href="Material/vangoghmuseum-s0176V1962-800.jpg" download>
                       [Download]
                    </a>

                    <a href="" id="shareButton">
                        [Share]
                    </a>
                </div>

            </div>
            <section class="collection-detail">

                <div class="collection-description">
                    <h4>Description</h4>
                    <p>Almond Blossom adalah lukisan karya Vincent van Gogh yang dibuat pada tahun 1890. Lukisan ini menggambarkan cabang-cabang pohon almond yang sedang mekar dengan latar belakang langit biru cerah. Van Gogh menciptakan karya ini sebagai hadiah untuk merayakan kelahiran keponakannya, Vincent Willem van Gogh, anak dari saudaranya Theo. Lukisan ini mencerminkan gaya khas Van Gogh dengan penggunaan warna-warna cerah dan sapuan kuas yang ekspresif, serta menunjukkan ketertarikannya pada alam dan simbolisme kehidupan baru.</p>
               
                    <div class="kategori">
                        <P><strong>Lihat Juga: </strong></P>
                            <div class="link-a">
                                <a href="news.php">News</a>
                                <a href="biography.php">Biografi</a>
                                <a href="privacy-policy.php">Privacy Policy</a>
                                <a href="About us.php">About Us</a>
                                <a href="ticket-ticketprice.php">Ticket & Ticket Price</a>
                            </div>
                    </div>

                    <a href="collection.php" class="back-button"> ← Back to Collection</a>

                </div>

                <div class="object-information">
                    <h4>Object Information</h4>

                    <p><strong>F-number:</strong></p>
                    <p>F0671</p>

                    <p><strong>JH-number:</strong> </p>
                    <p>JH 1731</p>

                    <p><strong>Object number:</strong></p>
                    <P>s0176V1962</P>

                    <p><strong>Dimensions:</strong> </p>
                    <p>73.3 cm x 92.4 cm, 94 cm x 112.9 cm, 8 cm</p>

                    <p><strong>Provenance:</strong></p>
                    <p>Sent by the artist from Saint-Rémy-de-Provence to his brother Theo van Gogh, Paris, at the end of April 1890; after his death on 25 January 1891, inherited by his widow, Jo van Gogh-Bonger, and their son, Vincent Willem van Gogh, Paris; administered until her death on 2 September 1925 by Jo van Gogh-Bonger, Bussum/Amsterdam/Laren; transferred by Vincent Willem van Gogh, Laren, on 10 July 1962 to the Vincent van Gogh Foundation, Amsterdam; agreement concluded between the Vincent van Gogh Foundation and the State of the Netherlands, in which the preservation and management of the collection, and its placing in the Rijksmuseum Vincent van Gogh, to be realized in Amsterdam, is entrusted to the State, 21 July 1962; given on loan until the opening of the museum on 2 June 1973 to the Stedelijk Museum, Amsterdam; on permanent loan to the Rijksmuseum Vincent van Gogh from 2 June 1973 and at the Van Gogh Museum, Amsterdam, since 1 July 1994.</p>
                    
                    <p><strong>artist</strong> </p>
                    <p>Vincent van Gogh</p>

                    
                    <p><strong>Credits (obliged to state)</strong> </p>
                    <p>Van Gogh Museum, Amsterdam (Vincent van Gogh Foundation)</p>
                </div>
            </section>







        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>