<?php
//Start session to pass variables between pages
session_start();
//Get important variables from SESSION
$duration = $_SESSION['duration'];
$checkinDate = $_SESSION['checkinYear']."-".$_SESSION['checkinMonth']."-".$_SESSION['checkinDay'];
$checkoutDate = date('Y-m-d', strtotime($checkinDate. ' + '.$duration.' days'));
$cottageType = $_SESSION['cottageType'];

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
                    <div class="headerOneButton" onClick="location.href='locations.html'">Locations</div>
                    <div class="headerOneButton" onClick="location.href='events.php'">Events</div>
                    <div class="headerOneButton" onClick="location.href='contact.html'">Contact</div>
                    <div class="headerOneButton" onClick="location.href='employeeLogin.html'">Staff</div>
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
                                <option value="NULL">No event</option>
                                <?php
                                //Connect to DB and choose DB
                                if ($conn=mysqli_connect('localhost','root','')) {
                                    mysqli_select_db($conn, 'hp_reserved');
                        
                                    //Get all the events and their dates from DB
                                    $sql = "SELECT `eventName`, `eventDate`, `eventId` FROM `event`";
                                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        
                                        //Execute statement if preparation is successful
                                        if (mysqli_stmt_execute($stmt)) {
                                        } else {echo "<div class='reservePHPResponse'><p>Submission error. Try again later</p></div>";}
                        
                                    } else {echo "<div class='reservePHPResponse'><p>Connection check error. Try again later</p></div>";}
                        
                                    //Bind results
                                    mysqli_stmt_bind_result($stmt, $eventName, $eventDate, $eventId);
                                    //Buffer the result to count the data for the loop
                                    mysqli_stmt_store_result($stmt);
                        

                                    if (mysqli_stmt_num_rows($stmt) > 0) {
                                        while (mysqli_stmt_fetch($stmt)) {
                                            if (check_in_range($checkinDate, $checkoutDate, $eventDate)==True) {
                                                echo "<option value='".$eventId."'>".$eventName." on ".$eventDate."</option>";
                                            }
                                        }
                                    }
                        
                
                                } else {echo "<div class='reservePHPResponse'><p>Connection error. Try again later</p></div>";}
                                ?>
                            </select> 
                        </div>

                        <div class="reserveTextInput">
                            <p>Additional Services:</p>
                            <textarea name="addServices"></textarea>
                        </div>

                        <!--Display champagne bottle option only if the cottageType is brick-->
                        <?php
                        if ($cottageType == "Brick") {
                        echo '<div class="reserveCheckbox">
                            <input type="checkbox" name="champagne" value="Champagne Bottle" id="checkboxBottle">
                            <p>Champagne bottle (+15 &euro;)</p>
                        </div>';
                        }
                        ?>


                    <input type="submit" name="submit" value="Next" id="reserveNextButton">
                </form>


                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    //Save choices into session
                    $_SESSION['event'] = filter_input(INPUT_POST, 'eventDropdown');
                    if (isset($_POST['champagne'])) {
                        $_SESSION['addServices'] = filter_input(INPUT_POST, 'addServices')." ".filter_input(INPUT_POST,'champagne');
                        $_SESSION['champagneBottle'] = 1;
                    } else {
                        $_SESSION['addServices'] = filter_input(INPUT_POST, 'addServices');
                        $_SESSION['champagneBottle'] = 0;
                    }


                    //Save name of the event
                    $sql = "SELECT `eventName` FROM `event` WHERE `eventId`=?";
                    if ($stmt = mysqli_prepare($conn, $sql)) {

                        mysqli_stmt_bind_param($stmt, 'i', $_SESSION['event']);
                        
                        //Execute statement if preparation is successful
                        if (mysqli_stmt_execute($stmt)) {
                        } else {echo "<div class='reservePHPResponse'><p>Submission error. Try again later</p></div>";}
        
                    } else {echo "<div class='reservePHPResponse'><p>Connection check error. Try again later</p></div>";}
                    //Bind results
                    mysqli_stmt_bind_result($stmt, $eventName);
                    //Buffer the result to count the data for the loop
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        mysqli_stmt_fetch($stmt);
                        $_SESSION['eventName'] = $eventName;
                    }


                    //Close connection & Statement
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    
                    //Redirect user to the next step of reservation
                    echo '<script type="text/javascript">location.href = "reserve5.php";</script>';
                }
                ?>

            </div>
        </div>
    </body>
</html>