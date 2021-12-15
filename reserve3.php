<?php
//Start session to pass variables between pages
session_start();
//Get reservation details from previous page to check the avaliable dates
$location = $_SESSION['location'];
$cottageType = $_SESSION['cottageType'];

//Function to create an array of dates between two given dates 
function getDatesFromRange($start, $end, $format = 'Y-m-d') {
    $array = array();
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach($period as $date) { 
        $array[] = $date->format($format); 
    }

    return $array;
}

//Function to check if an at least one date from an array of dates falls between two given dates
function dates_in_range( string $start_date, string $end_date, array $dates ): bool {
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    foreach ( $dates as $key => $date ) {
        $user_ts = strtotime($date);
        if (($user_ts >= $start_ts) && ($user_ts <= $end_ts)) {
            return true;
        }
    }
    return false;
}

//Assign variables needed to find out avliable dates
$getyear= $_GET['year'];
$getmonth= $_GET['month'];
$getduration= $_GET['duration'];
$occupiedDates = array(); //Contains dates unavalibale to be chosen in YYYY-MM-DD format
$occupiedOnlyDay = array(); //Contains dates unavalibale to be chosen in DD format
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
                <article id="reserveSubTitle"><p>Dates of stay</p></article>
                
                <!--Input Form-->
                <form action="#" method="POST" id="reserveForm">
                    <div class="reserveDropInput">
                        <p>Duration of stay:</p>
                        <select name="durationDropdown" onchange="window.location.search=this.value"> <!--Automatically update chosen value in $_GET-->
                            <?php
                            for ($i=1;$i<=7;$i++) {
                                //If statement allows to save the chosen option after the page gets updated to save the chosen value into GET
                                if ($_GET['duration'] == $i) { 
                                echo "<option selected value='?duration=".$i."&year=".$_GET['year']."&month=".$_GET['month']."'>".$i."</option>";
                                } else {
                                    echo "<option value='?duration=".$i."&year=".$_GET['year']."&month=".$_GET['month']."'>".$i."</option>";
                                }
                            }
                            ?>
                        </select> 
                    </div>

                    <div id="reserveSelects"> <!--Two divs (reserveSelects and reserveAgeInput) are used to place the <p> element above <select> elements-->
                        <p>Check-in date:</p>
                        <div id="reserveAgeInput">
                            <select name="checkinYear" onchange="window.location.search=this.value"> <!--Check-in date - Year-->
                                <?php
                                for ($i=Date('Y');$i<=(Date('Y')+2);$i++) {
                                    if ($_GET['year']== $i) {
                                        echo "<option selected value='?duration=".$_GET['duration']."&year=".$i."&month=".$_GET['month']."'>".$i."</option>";
                                    } else {
                                        echo "<option value='?duration=".$_GET['duration']."&year=".$i."&month=".$_GET['month']."'>".$i."</option>";
                                    }
                                }
                                ?>
                            </select>
                            <select name="checkinMonth" onchange="window.location.search=this.value"> <!--Check-in date - Month-->
                            <?php 
                            for ($i=1; $i<=12; $i++) {
                                if ($_GET['month'] == $i) {
                                    echo "<option selected value='?duration=".$_GET['duration']."&year=".$_GET['year']."&month=".$i."'>".date('M', mktime(0, 0, 0, $i, 10))."</option>";
                                } else {
                                    echo "<option value='?duration=".$_GET['duration']."&year=".$_GET['year']."&month=".$i."'>".date('M', mktime(0, 0, 0, $i, 10))."</option>";
                                }
                            }
                            ?>
                            </select>
                            <select name="checkinDay" class="checkinDayDropdown"> <!--Check-in date - Day-->
                                <?php
                                //Find out how many days are in a selected month
                                if ($_GET['month']==2 AND $_GET['year']%400==0) {
                                    //Leap year
                                    $monthtype = 29;
                                } else {
                                    switch ($_GET['month']) {
                                        case 1:
                                        case 3:
                                        case 5:
                                        case 7:
                                        case 8:
                                        case 10:
                                        case 12:
                                            $monthType = 31;
                                            break;
                                        case 2:
                                            $monthType = 28;
                                            break;
                                        default:
                                            $monthType = 30;
                                            break;
                                    }
                                } 


                                //Connect to DB and choose DB
                                if ($conn=mysqli_connect('localhost','root','')) {
                                    mysqli_select_db($conn, 'hp_reserved');
                        
                                    //Get all the occupied dates from DB
                                    $sql = "SELECT `resCheckIn`,`resDuration` FROM `reservation` WHERE `resCottageType`=? AND `resLocation`=?";
                                    if ($stmt = mysqli_prepare($conn, $sql)) {

                                        //Bind parameters
                                        mysqli_stmt_bind_param($stmt, 'ss', $cottageType, $location);
                        
                                        //Execute statement if preparation is successful
                                        if (mysqli_stmt_execute($stmt)) {
                                        } else {echo "<div class='reservePHPResponse'><p>Submission error. Try again later</p></div>";}
                        
                                    } else {echo "<div class='reservePHPResponse'><p>Connection check error. Try again later</p></div>";}
                        
                                    //Bind results
                                    mysqli_stmt_bind_result($stmt, $checkIn, $duration);
                                    //Buffer the result to count the data for the loop
                                    mysqli_stmt_store_result($stmt);
                        

                                    if (mysqli_stmt_num_rows($stmt) > 0) {
                                        //Iterate through each line of the database containing check-in date and duration
                                        while (mysqli_stmt_fetch($stmt)) {
                                            //Generate checkout date for each line from the DB
                                            $checkOut=date('Y-m-d', strtotime($checkIn. ' + '.$duration.' days'));
                                            //Iterate through each day of a month. Starting from 1st of the month
                                            for ($i=1;$i<=$monthType;$i++) {
                                                //Create a date object
                                                $iterationDate = strtotime($i."-".$getmonth."-".$getyear);
                                                $iterationDate = date('Y-m-d',$iterationDate); //Convert date to YYYY-MM-DD format
                                                //Create the hypothetical checkout date based on the duration of stay
                                                $iterationCheckout = date('Y-m-d', strtotime($iterationDate. ' + '.$getduration.' days'));
                                                //Create an array of dates from iterationDate to iterationCheckoutDate
                                                $iterationRange = GetDatesFromRange($iterationDate, $iterationCheckout);
                                                //Check if any of the dates from an array fall into occupied dates from the DB
                                                if (dates_in_range($checkIn, $checkOut, $iterationRange)==true) {
                                                    //Add occpid starting dates to an array
                                                    array_push($occupiedDates, $iterationDate);
                                                }
                                            }
                                        }
                                        //Convert from date to string. DD format
                                        foreach ($occupiedDates as $date) {
                                            $dayTemp=substr($date, 8, 2);
                                            array_push($occupiedOnlyDay, $dayTemp);
                                        }
                                    }
                                    //Only echo <option> with dates, which are avliable to be chosen
                                    for ($a=1;$a<=$monthType;$a++) {
                                        if (in_array($a, $occupiedOnlyDay)==false) {
                                            echo "<option value='".$a."'>".$a."</option>";
                                        } else {
                                            echo "<option value='".$a."' disabled>".$a."</option>";
                                        }
                                    }
                        
                
                                } else {echo "<div class='reservePHPResponse'><p>Connection error. Try again later</p></div>";}
                                //Close connection & Statement
                                mysqli_stmt_close($stmt);
                                mysqli_close($conn);
                                ?>
                            </select>
                        </div>
                    </div>

                    <input type="submit" name="submit" value="Next" id="reserveNextButton">
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                    //Save the input values to SESSION to pass to the next page
                    $_SESSION['duration']= $_GET['duration'];
                    $_SESSION['checkinYear'] = $_GET['year'];
                    $_SESSION['checkinMonth'] = $_GET['month'];
                    $_SESSION['checkinDay'] = filter_input(INPUT_POST, 'checkinDay');
                    //Redirect user to the next step of reservation
                    echo '<script type="text/javascript">location.href = "reserve4.php";</script>';
                }
                ?>

            </div>
        </div>
    </body>
</html>