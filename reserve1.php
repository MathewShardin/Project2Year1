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
                <article id="reserveSubTitle"><p>The information below is used to create an invoice</p></article>
                
                <!--Input Form-->
                <form action="#" method="POST" id="reserveForm">
                    <div class="reserveTextInput">
                        <p>E-mail:</p>
                        <input type="email" name="email" required>
                    </div>

                    <div class="reserveTextInput">
                        <p>Name:</p>
                        <input type="text" name="name" required>
                    </div>

                    <div class="reserveTextInput">
                        <p>Last name:</p>
                        <input type="text" name="lastname" required>
                    </div>

                    <div class="reserveTextInput">
                        <p>Address:</p>
                        <input type="text" name="address" required>
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


                <?php
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                    //Validate all input data
                    if (!empty($_POST['email']) AND $email=filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                        if (!empty($_POST['name']) AND !empty($_POST['lastname']) AND !empty($_POST['address'])) {
                            //If all inputs are valid
                            //Assign variables not to adress superglobals directly
                            $_SESSION['email'] = $email;
                            $name=filter_input(INPUT_POST, 'name');
                            $lastname=filter_input(INPUT_POST, 'lastname');
                            $address=filter_input(INPUT_POST, 'address');
                            //Concatenate the year, month, date of birth to satisfy mySQLi date format
                            $dob=filter_input(INPUT_POST, 'dobYear').".".filter_input(INPUT_POST, 'dobMonth').".".filter_input(INPUT_POST, 'dobDay');
                            $_SESSION['fullName'] = $name." ".$lastname;


                            //Check if a CUSTOMER with this email already exists
                            if ($conn = mysqli_connect("localhost", "root", "")) { //Connect to DB and select the DB
                                mysqli_select_db($conn, "hp_reserved");

                                //Check if the input email already exists
                                $sql = 'SELECT * FROM `customer` WHERE custEmail = ?';
                                if ($stmt = mysqli_prepare($conn, $sql)) {

                                    mysqli_stmt_bind_param($stmt, 's', $email);

                                    //Execute statement if preparation is successful
                                    if (mysqli_stmt_execute($stmt)) {
                                    } else {echo "<div class='reservePHPResponse'><p>Submission error. Try again later</p></div>";}

                                } else {echo "<div class='reservePHPResponse'><p>Connection check error. Try again later</p></div>";}

                                mysqli_stmt_store_result($stmt);
                                if (mysqli_stmt_num_rows($stmt) == 0) {
                                    //If the CUSTOMER with this email is not present in the DB add it to the DB
                                    $sql = 'INSERT INTO `CUSTOMER` VALUES (?,?,?,?,?)';
                                    if ($stmt = mysqli_prepare($conn, $sql)) {

                                        mysqli_stmt_bind_param($stmt, 'sssss', $email, $name, $lastname, $address, $dob);
                
                                        //Execute statement if preparation is successful
                                        if (mysqli_stmt_execute($stmt)) {
                                            //Redirect user to next page
                                            echo '<script type="text/javascript">location.href = "reserve2.php";</script>';
                                        } else {echo "<div class='reservePHPResponse'><p>Connection error. Try again later</p></div>";}
                
                                    } else {echo "<div class='reservePHPResponse'><p>Connection error. Try again later</p></div>";}

                                } else {
                                    //Redirect user to next page even if CUSTOMER with this email already exists
                                    echo '<script type="text/javascript">location.href = "reserve2.php";</script>';
                                }


                                //Close connection & Statement
                                mysqli_stmt_close($stmt);
                                mysqli_close($conn);

                            } else {echo "<div class='reservePHPResponse'><p>Connection error. Try again later</p></div>";}


                        } else {echo "<div class='reservePHPResponse'><p>Please fill out all the fields</p></div>";}
                    } else {echo "<div class='reservePHPResponse'><p>Please provide a valid e-mail address</p></div>";}
                }
                ?>
            </div>
        </div>
    </body>
</html>