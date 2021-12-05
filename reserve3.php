<?php
//Start session to pass variables between pages
session_start();
//Get reservation details from previous page to check the avaliable dates
$location = $_SESSION['location'];
$cottageType = $_SESSION['cottageType'];
//There are 4 types of months: 31days, 30days, 28days, 29days. These arrays contain all dates of a month. Used to check for avaliable dates
$thirtyDays = range(1,30);
$thirtyOneDays = range(1,31);
$twentyEightDays = range(1,28);
$twentyNineDays = range(1,29);
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
                            <select name="checkinDay"> <!--Check-in date - Day-->
                                <?php
                                //Find out how many days are in a selected month
                                if ($_GET['month']==2 AND $_GET['year']%400==0) {
                                    //Leap year
                                    $monthtype = "twentyNineDays";
                                } else {
                                    switch ($_GET['month']) {
                                        case 1:
                                        case 3:
                                        case 5:
                                        case 7:
                                        case 8:
                                        case 10:
                                        case 12:
                                            $monthtype = "thirtyOneDays";
                                            break;
                                        case 2:
                                            $monthtype = "twentyEightDays";
                                        default:
                                            $monthtype = "thirtyDays";
                                            break;
                                    }
                                }

                                
                                
                                
                                ?>
                            </select>
                        </div>
                    </div>

                    <input type="submit" name="submit" value="Next" id="reserveNextButton">
                </form>

            </div>
        </div>
    </body>
</html>