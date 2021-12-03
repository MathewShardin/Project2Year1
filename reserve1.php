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
                <article id="reserveSubTitle"><p>The information below is used to create an invoice</p></article>
                
                <!--Input Form-->
                <form action="#" method="POST" id="reserveForm">
                    <div class="reserveTextInput">
                        <p>E-mail:</p>
                        <input type="email" name="email">
                    </div>

                    <div class="reserveTextInput">
                        <p>Name:</p>
                        <input type="text" name="name">
                    </div>

                    <div class="reserveTextInput">
                        <p>Last name:</p>
                        <input type="text" name="lastname">
                    </div>

                    <div class="reserveTextInput">
                        <p>Address:</p>
                        <input type="text" name="address">
                    </div>

                    <div id="reserveSelects"> <!--Two divs (reserveSelects and reserveAgeInput) are used to place the <p> element above <select> elements-->
                        <p>Date of birth (18+):</p>
                        <div id="reserveAgeInput">
                            <select name="dobDay"> <!--Birth date - Day-->
                                <?php
                                for ($i=1; $i<=9; $i++) {
                                    echo "<option value='0".$i."'>0".$i."</option>";
                                }
                                for ($i=10; $i<=31; $i++) {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                                ?>
                            </select>
                            <select name="dobMonth"> <!--Birth date - Month-->
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">May</option>
                                <option value="06">Jun</option>
                                <option value="07">Jul</option>
                                <option value="08">Aug</option>
                                <option value="09">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                            <select name="dobYear"> <!--Birth date - Year. Only for people 18+ -->
                                <?php
                                for ($i=1920; $i<=date('Y')-17; $i++) {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <input type="submit" name="submit" value="Next" id="reserveNextButton">
                </form>
            </div>


            <?php
            
            ?>
        </div>
    </body>
</html>