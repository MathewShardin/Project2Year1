<?php
//Start session to pass variables between pages
session_start();
//Get important variables from SESSION
$duration = $_SESSION['duration'];
$cottageType = $_SESSION['cottageType'];
$checkinDate = $_SESSION['checkinYear']."-".$_SESSION['checkinMonth']."-".$_SESSION['checkinDay'];
$checkoutDate = date('Y-m-d', strtotime($checkinDate. ' + '.$duration.' days'));
$location = $_SESSION['location'];
$paymentMethod = $_SESSION['payment'];
$champagneBottle = $_SESSION['champagneBottle'];
$addServices = $_SESSION['addServices'];

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
//Calculate final price
function calculateFinalPrice($start_date, $end_date, $cotType, $champagne) {
    $price=0;
    //Determine price per night
    switch ($cotType) {
        case "Straw":
            $pricePerNight=50;
            break;
        case "Bamboo":
            $pricePerNight=100;
            break;
        case "Brick":
            $pricePerNight=150;
            break;
        default:
            $pricePerNight=150;
            break;
    }
    //Create an array with all dates of stay
    $stayRange = getDatesFromRange($start_date, $end_date);

    //Check if a date falls on summer season
    foreach ($stayRange as $key => $date) {
        if (substr($date, 5, 2) == 6 OR substr($date, 5, 2) == 7 OR substr($date, 5, 2) == 8) {
            $price = $price + (($pricePerNight*0.20)+$pricePerNight);
        } else {
            $price = $price + $pricePerNight;
        }
    }

    //Remove the cost of one day, because a cottage is paid per night of stay
    if (substr($date, 5, 2) == 6 OR substr($date, 5, 2) == 7 OR substr($date, 5, 2) == 8) {
        $price = $price - (($pricePerNight*0.20)+$pricePerNight);
    } else {
        $price = $price - $pricePerNight;
    }

    //Add the price of a champagne bottle
    if ($champagne == 1) {
        $price = $price + 15;
    }

    //Add VAT 21%
    $price = $price + ($price*0.21);

    return $price;
}

//Get final price
$finalPrice = calculateFinalPrice($checkinDate, $checkoutDate, $cottageType, $champagneBottle);
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>H&P Reserved</title>
        <meta charset="utf-8">
        <link href="Style/style.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" type="ico" href="img/favicon.ico"/>
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
                <article id="reserveSubTitle"><p>Overview of your reservation</p></article>
                
                <!--Input Form-->
                <form action="#" method="POST" id="reserveForm">
                    <article class="reserveOverview">
                    <ul class="reserveOverviewList">
                        <li><i>Cottage type:</i> <?php echo $cottageType;?></li>
                        <li>&nbsp;</li>
                        <li><i>Location:</i> <?php echo $location;?></li>
                        <li>&nbsp;</li>
                        <li><i>Check-in date:</i> <?php echo $checkinDate;?></li>
                        <li>&nbsp;</li>
                        <li><i>Check-out date:</i> <?php echo $checkoutDate;?></li>
                        <li>&nbsp;</li>
                        <li><i>Payment method:</i> <?php echo $paymentMethod;?></li>
                        <li>&nbsp;</li>
                        <li><i>Additional services:</i> <?php echo $addServices;?></li>
                    </ul>
                    </article>

                    <article class="reserveOverview">
                    <ul class="reserveOverviewList">
                        <li><b>Price </b>(VAT inc.): <?php echo $finalPrice;?> &euro;</li>
                    </ul>
                    </article>

                    <input type="submit" name="submit" value="Reserve" id="reserveNextButton">
                </form>


                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $_SESSION['finalPrice'] = $finalPrice;
                    //Redirect user to the processing page
                    echo '<script type="text/javascript">location.href = "reserveFinal.php";</script>'; 
                }
                ?>

            </div>
        </div>
    </body>
</html>