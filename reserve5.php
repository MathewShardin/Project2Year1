<?php
//Start session to pass variables between pages
session_start();
//Get important variables from SESSION
$numOfGuests = $_SESSION['numOfGuests'];

//Redirect user to next page if CUSTOMER is the only person staying
if ($numOfGuests <= 1) {
    echo '<script type="text/javascript">location.href = "reserve6.php";</script>'; 
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
                    <div class="headerOneButton" onClick="location.href='contact.html'">Contact</div>
                    <div class="headerOneButton">Staff</div>
                </div>
            </header>


            <div id="reserveInputsBackground"><!--Grey background behind the form-->
                <article id="reserveTitle"><p>Book Your Stay</p></article>
                <article id="reserveSubTitle"><p>People staying with you</p></article>
                
                <!--Input Form-->
                <form action="#" method="POST" id="reserveForm">
                    <?php
                    //Display an appropriate amount of input fileds according to the number of guests
                    for ($i=1;$i<=$numOfGuests-1;$i++) {
                        echo '
                            <div class="reserveGuestInputLine"> <!--One line of guest input-->
                                <!--Labels-->
                                <p class="guestName">Name:</p>
                                <p class="guestSurname">Last name:</p>
                                <p class="guestGender">Gender:</p>
                                <p class="guestDOB">Date of birth:</p>

                                <input type="text" name="guestName'.$i.'" required class="reserveGuestNameInp">
                                <input type="text" name="guestSurname'.$i.'" required class="reserveGuestSurnameInp">
                                <select name="guestGender'.$i.'" class="reserveGuestGenderInp">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <input type="date" name="guestDOB'.$i.'" required class="reserveGuestDOBInp">
                            </div>
                        ';
                    }
                    ?>

                    <input type="submit" name="submit" value="Next" id="reserveNextButton">
                </form>


                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    //Save guest info into SESSION
                    for ($a=1;$a<=$numOfGuests-1;$a++) {
                        $_SESSION['guestName'.$a.''] = filter_input(INPUT_POST, 'guestName'.$a.'');
                        $_SESSION['guestSurname'.$a.''] = filter_input(INPUT_POST, 'guestSurname'.$a.'');
                        $_SESSION['guestGender'.$a.''] = filter_input(INPUT_POST, 'guestGender'.$a.'');
                        $_SESSION['guestDOB'.$a.''] = filter_input(INPUT_POST, 'guestDOB'.$a.'');
                    }
                    //Redirect user to processing page
                    echo '<script type="text/javascript">location.href = "reserve6.php";</script>'; 
                }
                ?>

            </div>
        </div>
    </body>
</html>