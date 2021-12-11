<?php
//PROCESSING PAGE

//Start session to pass variables between pages
session_start();
//Get important variables from SESSION
$email = $_SESSION['email'];
$duration = $_SESSION['duration'];
$cottageType = $_SESSION['cottageType'];
$checkinDate = $_SESSION['checkinYear']."-".$_SESSION['checkinMonth']."-".$_SESSION['checkinDay'];
$checkoutDate = date('Y-m-d', strtotime($checkinDate. ' + '.$duration.' days'));
$location = $_SESSION['location'];
$paymentMethod = $_SESSION['payment'];
$champagneBottle = $_SESSION['champagneBottle'];
$addServices = $_SESSION['addServices'];
$finalPrice = $_SESSION['finalPrice'];
$event = $_SESSION['event'];
$numOfGuests = $_SESSION['numOfGuests'];

//Save infomration to RESERVATION table of DB
//Connect to DB and choose DB
if ($conn=mysqli_connect('localhost','root','')) {
    mysqli_select_db($conn, 'hp_reserved');

    //Insert info into DB
    if ($event == "NULL") {
        $sql = "INSERT INTO `reservation` (custEmail, resNumberGuests, resCheckIn, resDuration, resAddServices, resCottageType, resLocation, resPayment, resPrice) VALUES (?,?,?,?,?,?,?,?,?)";
    } else {
        $sql = "INSERT INTO `reservation` (custEmail, resNumberGuests, resCheckIn, resDuration, resAddServices, eventId, resCottageType, resLocation, resPayment, resPrice) VALUES (?,?,?,?,?,?,?,?,?,?)";

    }
    if ($stmt = mysqli_prepare($conn, $sql)) {
        //Bind paramemters
        if ($event == "NULL") {
            mysqli_stmt_bind_param($stmt, 'sisissssi', $email, $numOfGuests, $checkinDate, $duration, $addServices, $cottageType, $location, $paymentMethod, $finalPrice);
        } else {
            mysqli_stmt_bind_param($stmt, 'sisisisssi', $email, $numOfGuests, $checkinDate, $duration, $addServices, $event, $cottageType, $location, $paymentMethod, $finalPrice);
        }

        //Execute statement if preparation is successful
        if (mysqli_stmt_execute($stmt)) {
            //Get id of the inserted record
            $last_id = mysqli_insert_id($conn);
        } else {echo "<div class='reservePHPResponse'><p>Submission error. Try again later</p></div>";}

    } else {echo "<div class='reservePHPResponse'><p>Connection check error. Try again later</p></div>";}


} else {echo "<div class='reservePHPResponse'><p>Connection error. Try again later</p></div>";}


//Get GUEST information from SESSION
for ($a=1; $a<=$numOfGuests-1; $a++) {
    $guestName = $_SESSION['guestName'.$a.''];
    $guestSurname = $_SESSION['guestSurname'.$a.''];
    $guestGender = $_SESSION['guestGender'.$a.''];
    $guestDOB = $_SESSION['guestDOB'.$a.''];

    //Insert record into DB
    //Connect and choose DB
    if ($conn=mysqli_connect('localhost','root','')) {
        mysqli_select_db($conn, 'hp_reserved');
    
        //Insert info into DB
        $sql = "INSERT INTO `guest` (guestName, guestSurname, guestDateofBirth, guestGender, resId) VALUES (?,?,?,?,?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            //Bind paramemters
            mysqli_stmt_bind_param($stmt, 'ssssi', $guestName, $guestSurname, $guestDOB, $guestGender, $last_id);
    
            //Execute statement if preparation is successful
            if (mysqli_stmt_execute($stmt)) {
                //Get id of the inserted record
            } else {echo "<div class='reservePHPResponse'><p>Submission error. Try again later</p></div>";}
    
        } else {echo "<div class='reservePHPResponse'><p>Connection check error. Try again later</p></div>";}
    
    
    } else {echo "<div class='reservePHPResponse'><p>Connection error. Try again later</p></div>";}
}

//Close session
session_unset(); //delete all SESSION variables
session_destroy();

//Redirect user to thank you page
echo '<script type="text/javascript">location.href = "reservationthankyou.html";</script>'; 


?>