<?php
//Start session to pass variables between pages
session_start();
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>H&P Reserved</title>
        <meta charset="utf-8">
        <link href="Style/style.css" rel="stylesheet" type="text/css">
        <!--LINK FAVICON <link rel="shortcut icon" type="image/jpg" href=""/>-->
    </head>
    <body>
        <div id="containerReserve"> <!--Container for the whole page-->
            <header>
                <img src="img/logo_cottage.png" alt="Cottage Logo" id="headerImage" onClick="location.href='index.html'">
                <div id="headerButtons"> <!--This div is used to align the buttons with flexbox-->
                    <div class="headerOneButton" id="headerDropDown">
                        Accommodation
                        <div class="dropdown-content"> <!--Drop down menu contents-->
                            <a href="cottagestraw.html">Straw</a>
                            <a href="cottagebamboo.html">Bamboo</a>
                            <a href="cottagebrick.html">Brick</a>
                        </div>
                    </div>
                    <div class="headerOneButton" onClick="location.href='locations.html'">Locations</div>
                    <div class="headerOneButton">Events</div>
                    <div class="headerOneButton" onClick="location.href='contact.html'">Contact</div>
                    <div class="headerOneButton" onClick="location.href='employeeLogin.html'">Staff</div>
                </div>
            </header>


            <div id="reserveInputsBackground"><!--Grey background behind the form-->
                <article id="reserveTitle"><p>Book Your Stay</p></article>
                <article id="reserveSubTitle"><p>Reservation details</p></article>
                
                <!--Input Form-->
                <form action="#" method="POST" id="reserveForm">
                    <div class="reserveDropInput">
                        <p>Location:</p>
                        <select name="location">
                            <option value="Location 1">Location 1</option>
                            <option value="Location 2">Location 2</option>
                        </select>
                    </div>

                    <div class="reserveDropInput">
                        <p>Cottage type <a href="cottagestraw.html" target="blank">(learn more)</a>:</p>
                        <select name="cottageType">
                            <option value="Straw">Straw</option>
                            <option value="Bamboo">Bamboo</option>
                            <option value="Brick">Brick</option>
                        </select>
                    </div>

                    <div class="reserveTextInput">
                        <p>Total number of guests:</p>
                        <input type="number" name="numOfGuests" max="8" required>
                    </div>

                    <div class="reserveDropInput">
                        <p>Payment method:</p>
                        <select name="payment">
                            <option value="cash">Cash on site</option>
                            <option value="ideal">iDeal</option>
                            <option value="paypal">PayPal</option>
                            <option value="card">Card on site</option>
                        </select>
                    </div>

                    <input type="submit" name="submit" value="Next" id="reserveNextButton">
                </form>


                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //Check if all fields are filled out correctly
                    if (!empty($_POST['numOfGuests']) AND is_numeric($_POST['numOfGuests']) AND $_POST['numOfGuests']<=8) {
                        //If all fields are completed correctly save the input values to SESSION to pass to the next page
                        $_SESSION['location'] = filter_input(INPUT_POST, 'location');
                        $_SESSION['cottageType'] = filter_input(INPUT_POST, 'cottageType');
                        $_SESSION['numOfGuests'] = filter_input(INPUT_POST, 'numOfGuests');
                        $_SESSION['payment'] = filter_input(INPUT_POST, 'payment');
                        //Redirect user to the next step of reservation
                        echo '<script type="text/javascript">location.href = "reserve3.php?duration=1&year='.Date('Y').'&month=1";</script>';
                        

                    } else {echo "<div class='reservePHPResponse'><p>Please fill out all the fields</p></div>";}
                }
                ?>

            </div>
        </div>
    </body>
</html>