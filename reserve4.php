<?php
//Start session to pass variables between pages
session_start();
$checkinDate = $_SESSION['checkinYear']."-".$_SESSION['checkinMonth']."-".$_SESSION['checkinDay'];
//Function to check if a date falls between two dates
function check_in_range($start_date, $end_date, $date_from_user) {
    // Convert to timestamp
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    $user_ts = strtotime($date_from_user);

    // Check that user date is between start & end
    if (($user_ts >= $start_ts) && ($user_ts <= $end_ts)) {
        return true;
    } else {
        return false;
    }
}
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
                    <div class="headerOneButton">Locations</div>
                    <div class="headerOneButton">Events</div>
                    <div class="headerOneButton">Contact</div>
                    <div class="headerOneButton">Staff</div>
                </div>
            </header>


            <div id="reserveInputsBackground"><!--Grey background behind the form-->
                <article id="reserveTitle"><p>Book Your Stay</p></article>
                <article id="reserveSubTitle"><p>Your preferences</p></article>
                
                <!--Input Form-->
                <form action="#" method="POST" id="reserveForm">
                    <div class="reserveDropInput">
                            <p>Event to attend:</p>
                            <select name="eventDropdown">
                                <option value="victory day">9 May</option>
                                <?php
                                //Connect to DB and choose DB
                                if ($conn=mysqli_connect('localhost','root','')) {
                                    mysqli_select_db($conn, 'hp_reserved');
                        
                                    //Get all the events and their dates from DB
                                    $sql = "SELECT `eventName`, `eventDate` FROM `event`";
                                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        
                                        //Execute statement if preparation is successful
                                        if (mysqli_stmt_execute($stmt)) {
                                        } else {echo "<div class='reservePHPResponse'><p>Submission error. Try again later</p></div>";}
                        
                                    } else {echo "<div class='reservePHPResponse'><p>Connection check error. Try again later</p></div>";}
                        
                                    //Bind results
                                    mysqli_stmt_bind_result($stmt, $eventName, $eventDate);
                                    //Buffer the result to count the data for the loop
                                    mysqli_stmt_store_result($stmt);
                        

                                    if (mysqli_stmt_num_rows($stmt) > 0) {
                                        while (mysqli_stmt_fetch($stmt)) {

                                        }
                                    }
                        
                
                                } else {echo "<div class='reservePHPResponse'><p>Connection error. Try again later</p></div>";}
                                ?>
                            </select> 
                        </div>


                    <input type="submit" name="submit" value="Next" id="reserveNextButton">
                </form>


                <?php
                ?>

            </div>
        </div>
    </body>
</html>