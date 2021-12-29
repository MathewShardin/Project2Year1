<!DOCTYPE html>
<?php
//Check if a user is logged in and redirect the user back to login page if not
session_start();
if (!$_SESSION['loggedIn'] == True) {
    echo '<script type="text/javascript">location.href = "employeeLogin.html";</script>';
}
?>
<html lang="en-US">
    <head>
        <title>H&P - Staff</title>
        <meta charset="utf-8">
        <link href="Style/style.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" type="ico" href="img/favicon.ico"/>
    </head>
    <body>
        <div id="staffEventsContainer"> <!--Container for the whole page-->
            <header>
                <img src="img/logo_cottage.png" alt="Cottage Logo" id="headerImage" onClick="location.href='signOut.php?type=1'">
                <div id="headerButtons"> <!--This div is used to align the buttons with flexbox-->
                    <div class="headerOneButton" onClick="location.href='reservationsOverview.php'">Reservations</div>
                    <div class="headerOneButton" onClick="location.href='staffEvents.php'">Events</div>
                    <div class="headerOneButton" onClick="location.href='signOut.php'">Sign out</div>
                </div>
            </header>

            <!--Title of the website. Big text in the center-->
            <div id="staffEventsTitle">
                <h1>New event</h1>
            </div>

            <form method="POST" action="#" id="staffAddEventForm">
                <div class="staffEventTextInput">
                    <p>Name of the event:</p>
                    <input type="text" name="eventName" required>
                </div>

                <div class="staffEventTextInput">
                    <p>Date:</p>
                    <input type="date" name="eventDate" required>
                </div>

                <input type="submit" name="submit" value="Save" id="staffAddEventButton">
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Validate the input data
                if ($eventName = filter_input(INPUT_POST, 'eventName') AND $eventDate = filter_input(INPUT_POST, 'eventDate')) {
                    if ($conn = mysqli_connect('localhost','root','')) {
                        mysqli_select_db($conn,'hp_reserved');

                        $sql = "INSERT INTO `event` (`eventDate`, `eventName`) VALUES (?,?)";

                        if ($stmt = mysqli_prepare($conn, $sql)) {

                            mysqli_stmt_bind_param($stmt, 'ss', $eventDate, $eventName);
            
                            //Execute statement if preparation is successful
                            if (mysqli_stmt_execute($stmt)) {
                                //Redirect user back to events overview if statement executed successfully
                                echo '<script type="text/javascript">location.href = "staffEvents.php";</script>';

                            } else {echo "<div class='staffEventsPHPResponse'><p>Submission error. Try again later</p></div>";}
            
                        } else {echo "<div class='staffEventsPHPResponse'><p>Connection check error. Try again later</p></div>";}
                    } else {echo "<div class='staffEventsPHPResponse'><p>Connection error. Try again later</p></div>";}

                }else {echo "<div class='staffEventsPHPResponse'><p>Please fill out the fields correctly</p></div>";}

                //Close connection & Statement
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            }

            ?>
        </div>
    </body>
</html>