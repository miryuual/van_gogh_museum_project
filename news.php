<?php
    session_start();
    include 'layout/header.php';?>

    <style>
        .main-head{
            font-size: 50px;
            font-weight: 600;
        }



        /*NEWS*/

        .news-container {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 55px;
            padding: 20px;
        }


        .news-card-image{
            width: 330px;
            height: 150px;
            border-radius: 2px;

            object-fit: cover;
            overflow: hidden;

            display: flex;
            justify-content: center;
            align-items: center;

            box-sizing: border-box;
        }


        .news-card-image img{
            width: 100%;
            height: auto;
        }
        .news-card-image img:hover{
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }


        .news-card h5{
            font-size: 18px;
            font-weight: 500;
            margin: 10px 0 5px 0;
            border-bottom: 1px solid #000000;
            padding-bottom: 5px;
        }

        .news-card p{
            font-size: 12px;
            line-height: 1;
            margin: 0;
            color: rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;

        }


        .read-more-link:hover .read-more{
            background-color: #f8df50;
            color: #000000;
            padding: 2px 5px;
    
        }


    </style>


    <!--MAIN BODY-->

        <!--NAViGASI-->
             <?php include 'layout/navigasi.php'; ?>


    <!--main content-->
        <main>
            <h2 class="main-head">Museum News</h2>

                    <div class="news-container">

                        <article class="news-card">
                            <a href="news-details.php">
                                <div class="news-card-image">
                                    <img src="Material/Sketch_of_Starry_Night_Over_the_Rhone,_enclosed_in_a_letter_from_Vincent_van_Gogh_to_Eugene_Boch.jpg" alt="Van Gogh Exhibition">
                              </a>
                         
                                </div>
                                    <h5 class="read-more-link"><a href="news-details.php"><strong class="read-more">[DD/MM/YY] News Headline</strong></a></h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.  Sed euismod, nunc ut aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl eget nunc.</p>
                                    <p class="read-more-link"><a href="news-details.php"><strong class="read-more">Read More →</strong></a></p>
                            </article>

                        <article class="news-card">
                            <a href="news-details.php">
                                <div class="news-card-image">
                                    <img src="Material/Sketch_of_Starry_Night_Over_the_Rhone,_enclosed_in_a_letter_from_Vincent_van_Gogh_to_Eugene_Boch.jpg" alt="Van Gogh Exhibition">
                            </a>
                                </div>
                                    <h5 class="read-more-link"><a href="news-details.php"><strong class="read-more">[DD/MM/YY] News Headline</strong></a></h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc ut aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl eget nunc. .</p>
                                    <p class="read-more-link"><a href="news-details.php"><strong class="read-more">Read More →</strong></a></p>
                            </article>

                        <article class="news-card">
                            <a href="news-details.php">
                                <div class="news-card-image">
                                    <img src="Material/Sketch_of_Starry_Night_Over_the_Rhone,_enclosed_in_a_letter_from_Vincent_van_Gogh_to_Eugene_Boch.jpg" alt="Van Gogh Exhibition">
                               </a>
                                </div>
                                    <h5 class="read-more-link"><a href="news-details.php"><strong class="read-more">[DD/MM/YY] News Headline</strong></a></h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc ut aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl eget nunc. </p>
                                    <p class="read-more-link"><a href="news-details.php"><strong class="read-more">Read More →</strong></a></p>
                            </article>

                    </div>





        </main>

    </div>

<!--FOOTERR-->
    <?php include 'layout/footer.php';?>