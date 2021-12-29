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
                <h1>Events</h1>
            </div>

            <div id="staffEventsTable">
                <table>
                    <tr>
                        <th>Event Date</th>
                        <th>Event Name</th>
                        <th></th>
                    </tr>
                    <?php
                    //Connect to DB and select DB
                    if ($conn=mysqli_connect('localhost','root','')) {
                        mysqli_select_db($conn, 'hp_reserved');

                        $sql = "SELECT `eventId`,`eventDate`,`eventName` FROM `event`";

                        if ($stmt = mysqli_prepare($conn, $sql)) {
            
                            //Execute statement if preparation is successful
                            if (mysqli_stmt_execute($stmt)) {
                            } else {echo "<div class='staffEventsPHPResponse'><p>Submission error. Try again later</p></div>";}
            
                        } else {echo "<div class='staffEventsPHPResponse'><p>Connection check error. Try again later</p></div>";}

                        //Bind results, save results
                        mysqli_stmt_bind_result($stmt, $eventId, $eventDate, $eventName);
                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) > 0) {
                            while (mysqli_stmt_fetch($stmt)) {
                                echo "<tr>";
                                    echo "<td>".$eventDate."</td>";
                                    echo "<td>".$eventName."</td>";
                                    echo "<td><a href='staffEventDelete.php?id=".$eventId."'>Delete</td>";
                                echo "</tr>";
                            }
                        }
                    } else {echo "<div class='staffEventsPHPResponse'><p>Connection error. Try again later</p></div>";}

                    //Close connection & Statement
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    ?>

                    <!--Last line of table with link to add new events-->
                    <tr>
                        <td><a href='staffAddEvent.php'>+ New event</a></td>
                    </tr>

                </table>
            </div>
        </div>
    </body>
</html>