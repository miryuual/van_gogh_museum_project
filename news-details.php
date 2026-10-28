<?php
    session_start();
    include 'layout/header.php';?>

     <style>
        .main-head{
            font-size: 60px;
        }
        .news-content{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            padding: 40px;
        }

        .news-image{
            width: auto;
            height: 400px;

            display: flex;
            justify-content: center;
            align-items: center;

            box-sizing: border-box;
        }

        .news-content p{
            font-size: 18px;
            line-height: 1.6;
            text-align: justify;

            font-weight: 400;
        }

        .news-date{
            font-size: 16px;
            font-weight: 400;
            color: #555;
            padding-left: 40px;
        }
        .short-detail{ 
            font-size: 14px;
            font-weight: 400;
            color: #555;
            padding-left: 40px;
            margin-right: 500px

        }

        .news2 {
            display: flex;
            }   
        .news2 img{
            width: 300px;
            height: auto;
            margin-right: 50px;
            }   

        .news-content2{
            font-size: 18px;
            line-height: 1.6;
            text-align: justify;

            font-weight: 400;

            margin-left: 40px;
            margin-right: 40px;
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

       
    <!--MAIN BODY-->

        <!--NAViGASI-->
             <?php include 'layout/navigasi.php'; ?>

    <!--main content-->
        <main>
            <h2 class="main-head">News Headline Lorem ipsum dolor sit amet consectetur</h2>
            <h3 class="news-date">[DD/MM/YYYY] | Author Name</h3>
            <p class="short-detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa ipsam rerum nam sapiente! Voluptatum cupiditate reiciendis quam ea? Illo fugit praesentium beatae incidunt aliquam sequi, molestiae dolore non eius atque?</p>

            <div class="news-content">
                <img src="Material/Sketch_of_Starry_Night_Over_the_Rhone,_enclosed_in_a_letter_from_Vincent_van_Gogh_to_Eugene_Boch.jpg" alt="News Image" class="news-image">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, amet est quam omnis, maxime accusamus eligendi sunt enim, tempore dicta in odit odio doloremque voluptatum illum. Cumque sunt eius quae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem consequatur non est voluptates, quisquam dolorum dicta vitae incidunt, numquam cupiditate expedita at molestias vel obcaecati doloremque quaerat deserunt, in veniam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa atque ut esse perspiciatis earum, molestias enim, fuga minus consectetur temporibus dicta vel facilis error reiciendis ducimus minima laudantium. Neque, pariatur. lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, amet est quam omnis, maxime accusamus eligendi sunt enim, tempore dicta in odit odio doloremque voluptatum illum. Cumque sunt eius quae.</p>
            </div>

            <div class="news2">
                <section class="news-content2">
                   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, amet est quam omnis, maxime accusamus eligendi sunt enim, tempore dicta in odit odio doloremque voluptatum illum. Cumque sunt eius quae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem consequatur non est voluptates, quisquam dolorum dicta vitae incidunt, numquam cupiditate expedita at molestias vel obcaecati doloremque quaerat deserunt, in veniam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa atque ut esse perspiciatis earum, molestias enim, fuga minus consectetur temporibus dicta vel facilis error reiciendis ducimus minima laudantium. Neque, pariatur. lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, amet est quam omnis, maxime accusamus eligendi sunt enim, tempore dicta in odit odio doloremque voluptatum illum. Cumque sunt eius quae.</p>
                   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, amet est quam omnis, maxime accusamus eligendi sunt enim, tempore dicta in odit odio doloremque voluptatum illum. Cumque sunt eius quae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem consequatur non est voluptates, quisquam dolorum dicta vitae incidunt, numquam cupiditate expedita at molestias vel obcaecati doloremque quaerat deserunt, in veniam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa atque ut esse perspiciatis earum, molestias enim, fuga minus consectetur temporibus dicta vel facilis error reiciendis ducimus minima laudantium. Neque, pariatur. lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, amet est quam omnis, maxime accusamus eligendi sunt enim, tempore dicta in odit odio doloremque voluptatum illum. Cumque sunt eius quae.</p>
                   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, amet est quam omnis, maxime accusamus eligendi sunt enim, tempore dicta in odit odio doloremque voluptatum illum. Cumque sunt eius quae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem consequatur non est voluptates, quisquam dolorum dicta vitae incidunt, numquam cupiditate expedita at molestias vel obcaecati doloremque quaerat deserunt, in veniam.</p>
             
                </section>  

                <section class="news2-image">
                    <img src="material/Irises.jpg" alt="Irises">
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
                    <a href="news.php" class="back-button"> ← Back to News</a>
            
        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>