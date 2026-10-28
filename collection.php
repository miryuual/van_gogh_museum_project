<?php
    session_start();
    include 'layout/header.php';?>



    <style>

        /* FILTER */
        .collection-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        button:hover{
            background-color: #f8df50;
            color: #000000;
            transition: background-color 0.3s ease;
        }

        .collection-header h1 {
            margin: 0;
            font-size: 70px;
        }


        .filter-button {
            width: 65px;
            height: 39px;

            padding: 0;

            background-color: #000000;
            color: white;
            border: none;

            font-size: 15px;
            font-weight: 300;

            cursor: pointer;
            
        }

        .filter-close{
            display: flex;
            justify-content: space-between;
            padding: 0;
            margin-bottom: 10px;
        }

        .close-button{
            width: 25px;
            height: 25px;
        }

        /*filter popup */
        .filter-grid{
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 10px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        
        #filterPopup{
            width: 800px;
            height: 600px;
            padding: 25px;

            background-color:  #f8df50;
            border: 1px solid #f8df50;
            border-radius: 10px;

            box-sizing: border-box;
        }

        .filter-pop-button button{
            background-color: #000000;
            color: white;

            padding: 5px 5px;


            border: none;

            font-size: 15px;
            font-weight: 300;

            cursor: pointer;
            border-radius: 3px;
            
        }
        .filter-close h3{
            font-size: 20px;
            margin: 0 0 0 0;
        }

        h4{
            margin-top: 0;
            margin-bottom: 0;
            font-size: 20px;
        }
        .filter-group input[type="checkbox"] {
            appearance: none;

            width: 20px;
            height: 20px;

            border: 2px solid #333;
            border-radius: 3px;

            background-color: #f8df50;

            cursor: pointer;

            margin: 0;
        }
        .filter-group input[type="checkbox"]:checked {
            background-color: #000000;
            border-color: #000000;
        }



        /*search collection*/

        .filter-and-search{
            display: flex;
        }


        .collection-search{
            display: flex;
            margin-left: 40px;
            padding-right: 20px;
        }
        .collection-search input{
            display: flex;
            width: 150px;
            height: 35px;
            margin: 0;
            padding-left: 5px;
            
            border: 1px solid #000000;
        }

        .collection-search button:hover{
            background-color: #f8df50;
            color: #000000;
            transition: background-color 0.3s ease;
        }

        .collection-search button{
            background-color: #000000;
            color: white;
            border: 1px solid #000000;
            box-shadow: none;
            border: 0px solid;
            outline: none;
            margin: 0;
            height: 39px;
        }            


       

        /* COLLECTION GRID */
        .collection-grid {
            display: grid;
            grid-template-columns: repeat(5,1fr);
            gap: 20px;
            padding: 20px;
        }

        .collection-card {
            display: block;
            text-decoration: none;
            color: black;

            overflow: hidden;
            transition: 0.3s ease;
        }
        .collection-card:hover{
            transform: scale(1.2);
            transition: transform 0.3s ease;
        }
        .collection-card img {
            width: 100%;
            height: auto;
            display: block;
        }

        .collection-card-content {
            padding: 6px 0;
        }

        .collection-card-content h3 {
            text-align: left;
            margin: 0 0 0 0;
            font-size: 15px;
            font-weight: 500;
            margin-left: 5px;
        }
        .collection-card-content p {
            margin: 0;
            font-size: 12px;
            color: #555;
            text-align: left;
            margin-left: 5px;

        }

    </style>


    
    <!--MAIN BODY-->

        <!--NAViGASI-->
      <?php include 'layout/navigasi.php'; ?>

    <!--main content-->
        <main>
            <div class="collection-header">
                <h1>Collection</h1>
                    <div class="filter-and-search">
                          <form action="" method="get" class="collection-search">
                                <input type="text" placeholder="Search Collection">
                                <button type="submit">Search</button>
                           </form>
                       
                        <button class="filter-button" onclick="filterPopup.showModal()">Filter</button>
                            <dialog id="filterPopup">

                            <form class="filter-pop-button" method="dialog">
                                <div class="filter-close">
                                    <h3>Select a filter option:</h3>
                                    <button type="submit" class="close-button">X</button>
                                </div>
                                    <div class="filter-grid">
                                        <section class="filter-group">
                                                    <h4>Artist</h4>

                                                    <label>
                                                        <input type="checkbox" name="type" value="Van Gogh">
                                                        Van Gogh
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="Claude Monet">
                                                        Claude Monet
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="Henri Rivière">
                                                        Henri Rivière
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="Utagawa Kunisada ">
                                                        Utagawa Kunisada
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="Emile Bernard">
                                                        Emile Bernard
                                                    </label>
                                        </section>

                                        <section class="filter-group">
                                                    <h4>Type</h4>

                                                    <label>
                                                        <input type="checkbox" name="type" value="painting">
                                                        Painting
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="drawing">
                                                        Drawing
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="print">
                                                        Print
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="letter">
                                                        Letter
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="sketch">
                                                        Sketch
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="artist’s book">
                                                        Artist’s Book
                                                    </label>
                                        </section>
                                        <section class="filter-group">
                                                    <h4>Location</h4>

                                                    <label>
                                                        <input type="checkbox" name="type" value="Nuenen">
                                                        Nuenen
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="Paris">
                                                        Paris
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="Arles">
                                                        Arles
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="Saint-Rémy-de-Provence ">
                                                        Saint-Rémy-de-Provence
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="Auvers-sur-Oise">
                                                        Auvers-sur-Oise
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="Osaka">
                                                        Osaka
                                                    </label>
                                    
                                        </section>
                                        <section class="filter-group">
                                                    <h4>Year</h4>

                                                    <label>
                                                        <input type="checkbox" name="type" value="1860 - 1870">
                                                        1860 - 1870
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="1871-1880 ">
                                                        1871-1880 
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="1881 ">
                                                        1881 
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="type" value="1882">
                                                        1882
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="1883">
                                                        1883
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="1884">
                                                        1884
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="1885">
                                                        1885
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="1886">
                                                        1886
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="1887">
                                                        1887
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="1888">
                                                        1888
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="1889">
                                                        1889
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="type" value="1890">
                                                        1890
                                                    </label>
                                                     
                                                    <label>
                                                        <input type="checkbox" name="type" value="1891-1900">
                                                        1891-1900
                                                    </label>


                                        </section>

                                    </div>
                            </form>
                        </dialog>
                    </div>
            </div>

            <hr>
            
            <div class="collection-grid">
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/The-Pink-Peach-Tree.jpg" alt="The Pink Peach Tree">
                    <div class="collection-card-content">
                        <h3>The Pink Peach Tree</h3>
                        <p>Van Gogh</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/vangogh-selfpotrait.jpg" alt="Van Gogh Self-Portrait">
                    <div class="collection-card-content">
                        <h3>Van Gogh Self-Portrait</h3>
                        <p>Van Gogh</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/Vincent_van_gogh-sunflower.jpg" alt="Sunflower">
                    <div class="collection-card-content">
                        <h3>Sunflower</h3>
                        <p>Van Gogh</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/vincent_van_gogh-Kingfisher_by_the_Waterside.jpg" alt="Kingfisher by the Waterside">
                    <div class="collection-card-content">
                        <h3>Kingfisher by the Waterside</h3>
                        <p>Van Gogh</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/view-of-paris-vangogh.jpg" alt="View of Paris">
                    <div class="collection-card-content">
                        <h3>View of Paris</h3>
                        <p>Van Gogh</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/vangoghmuseum-s0176V1962-800.jpg" alt="Almond Blossom">
                    <div class="collection-card-content">
                        <h3>Almond Blossom</h3>
                        <p>Van Gogh</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/vangoghmuseum-s0184V1962-800.jpg" alt="Blossoming Almond Branch in a Glass">
                    <div class="collection-card-content">
                        <h3>Blossoming Almond Branch in a Glass</h3>
                        <p>Van Gogh</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/Claude_Monet-Tulip_Fields_near_The_Hague.jpg" alt="Tulip Fields near The Hague">
                    <div class="collection-card-content">
                        <h3>Tulip Fields near The Hague</h3>
                        <p>Claude Monet</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/The Bridge at Courbevoie.jpg" alt="The Bridge at Courbevoie">
                    <div class="collection-card-content">
                        <h3>The Bridge at Courbevoie</h3>
                        <p>Van Gogh</p>
                    </div>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/The-Bedroom.jpg" alt="The Bedroom">
                    <div class="collection-card-content">
                        <h3>The Bedroom</h3>
                        <p>Van Gogh</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/Seascape near Les Saintes-Maries-de-la-Mer.jpg" alt="Seascape near Les Saintes-Maries-de-la-Mer">
                    <div class="collection-card-content">
                        <h3>Seascape near Les Saintes-Maries-de-la-Mer</h3>
                        <p>Van Gogh</p>
                    </div>
                    
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/Gate in the Paris Ramparts.jpg" alt="Gate in the Paris Ramparts">
                    <div class="collection-card-content">
                        <h3>Gate in the Paris Ramparts</h3>
                        <p>Van Gogh</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/From the Place de la Concorde (De la place de la Concorde).jpg" alt="From the Place de la Concorde">
                    <div class="collection-card-content">
                        <h3>From the Place de la Concorde</h3>
                        <p>Henri Rivière</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/The Eiffel Tower under Construction, seen from the Trocadéro (La Tour en construction, vue de Trocadéro).jpg" alt="The Eiffel Tower under Construction">
                    <div class="collection-card-content">
                        <h3>The Eiffel Tower under Construction, seen from the Trocadéro</h3>
                        <p>Henri Rivière</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/From the Pont des Saints Pères (Du Pont des Saints Pères).jpg" alt="From the Pont des Saints Pères">
                    <div class="collection-card-content">
                        <h3>From the Pont des Saints Pères</h3>
                        <p>Henri Rivière</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/Nihon Bridge, from the series Views of Famous Places Along the Tōkaidō.jpg" alt="Nihon Bridge, from the series Views of Famous Places Along the Tōkaidō">
                    <div class="collection-card-content">
                        <h3>Nihon Bridge, from the series Views of Famous Places Along the Tōkaidō</h3>
                        <p>Utagawa Kunisada</p>
                    </div>
                </a>
                <a href="detail_koleksi.php" class="collection-card">
                    <img src="Material/A Newly Printed Overview of the Eight Views on Famous Places in Edo, fourth sheet of a pentaptych.jpg" alt="A Newly Printed Overview of the Eight Views on Famous Places in Edo, fourth sheet of a pentaptych">
                    <div class="collection-card-content">
                        <h3>A Newly Printed Overview of the Eight Views on Famous Places in Edo, fourth sheet of a pentaptych</h3>
                        <p>Utagawa Kunisada</p>
                    </div>
                </a>


            </div>







        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>