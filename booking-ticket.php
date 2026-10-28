<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan pengunjung sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
 <?php
INCLUDE 'layout/header.php';?>

        <style>

            .main-head{
                font-size: 90px;
                background-color: rgba(22, 15, 15, 0.8);

                text-align: center;

                padding: 0;
                
            }

            h4{
                font-size: 30px;
            }
            .main-p{
                font-weight: 300;
            }
            .booking{
                margin-left: 200px;
                margin-right: 220px;

                border: 1px solid black;

                padding-left: 40px;
                padding-right: 40px;

                padding-bottom: 20px;

                background-color: rgba(22, 15, 15, 0.9);
                color: white;


                font-weight: 300;
            }

            main{
                background-image: url("Material/Vangogh-Museum Entrance-D.jpg");
                color: rgb(252, 252, 252);
                flex: 1;
                background-size: cover;
                background-position: center;
                min-width: 0;
                min-height: 600px;

                background-color: white;

                border-radius: 7px;

                padding: 30px;
            }

            button{
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;

                background-color: #F9D71C;
                color: rgb(5, 0, 0);

                font-weight: 700;

                text-decoration: none;
            }

            .btn-b{
                display: flex;
                
            }

            .btn-c{
                margin-left: 300px;

            }

            .back-button:hover{
                background-color: #000000;
                color: #f8df50;
                transition: background-color 0.3s ease;
            }

            /*back button*/
            .back-button{
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                background-color: #f8df50;
                color: rgb(0, 0, 0);
                text-decoration: none;
                border-radius: 5px;
            }
        </style>


    
    <!--MAIN BODY-->

        <!--NAViGASI-->
      <?php include 'layout/navigasi.php'; ?>


    <!--main content-->
        <main>
            <h2 class="main-head">Booking Ticket</h2>


            <div class="booking">
                 <h4>Book Your Ticket</h4>
                    <p class="main-p"> Plan your visit to the Van Gogh Museum by selecting your preferred visit date and ticket type.</p>
                <form action="booking-ticket-confirmation.html" method="post">
                    <fieldset>
                        <legend>Visit Information</legend>

                        <p>
                            <label for="visit-date">Visit Date</label><br>
                                <input 
                                    type="date" 
                                    id="visit-date" 
                                    name="visit-date" 
                                    required
                                >
                        </p>
                    <p>
                        <label for="visit-time">Preferred time:</label><br>
                        <input 
                            type="time" 
                            id="visit-time" 
                            name="visit-time"
                            required
                        >
                    </p>

                    </fieldset>
                    <br>

                    <fieldset>
                        <legend>Ticket Type</legend>
                            <p>
                                <label for="ticket-type">Select ticket:</label><br>

                                <select id="ticket-type" name="ticket-type" required>
                                    <option value="">-- Select ticket --</option>
                                    <option value="adult">Adult</option>
                                    <option value="student">Student</option>
                                    <option value="child">Child</option>
                                    <option value="senior">Senior</option>
                                </select>
                            </p>
                            <p>
                                <label for="quantity">Number of tickets:</label><br>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    name="quantity"
                                    min="1"
                                    max="10"
                                    value="1"
                                    required
                                >
                            </p>

                    </fieldset>
                    <br>
                    <fieldset>
                        <legend>Visitor Information</legend>
                            <p>
                                <label for="name">Full name:</label><br>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name"
                                    required
                                >
                            </p>

                            <p>
                                <label for="email">Email:</label><br>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email"
                                    required
                                >
                            </p>

                            <p>
                                <label for="phone">Phone number:</label><br>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone"
                                >
                            </p>


                    </fieldset>

                    <fieldset>
                        <legend>Additional Information</legend>
                            <p>
                                <input 
                                    type="checkbox" 
                                    id="audio-guide" 
                                    name="audio-guide"
                                >

                                <label for="audio-guide">
                                    I would like an audio guide.
                                </label>
                            </p>

                            <p>
                                <input 
                                    type="checkbox" 
                                    id="newsletter" 
                                    name="newsletter"
                                >

                                <label for="newsletter">
                                    I would like to receive museum information by email.
                                </label>
                            </p>


                    </fieldset>

                    <div class="btn-b">
                        <a href="ticket-ticketprice.php" class="back-button"> ← Back </a>

                            <div class="btn-c">
                                <button type="reset">Reset</button>
                                <button type="submit">Continue to Booking</button>
                        </div>
                    </div>
                </form>


            </div>



        </main>

    </div>


<!--FOOTERR-->
    <?php include 'layout/footer.php';?>