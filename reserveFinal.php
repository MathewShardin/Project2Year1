<?php
//PROCESSING PAGE


//Initialize PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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
$fullName = $_SESSION['fullName'];

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


//PHPMailer settings
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'hpreservednl@gmail.com'; //Corprate email
$mail->Password = 'hpreservedemmen'; 
$mail->SMTPSecure = 'tls';
$mail->Port = 587; //Typically 587
//Generate message
$message = "<p>Hello! Thank you for your reservation with Huff & Puff.</p>
<p>We <b>confirm</b> a reservation for:</p>
<p>Name: ".$fullName."</p>
<p>Check-in date: ".$checkinDate."</p>
<p>Duration of your stay: ".$duration." days</p>
<p>Event you would like to attend: ".$event."</p>
<p>Additional Services: ".$addServices."</p>
<p>Payment Method: ".$paymentMethod."</p>
<p>Price: ".$finalPrice." &euro;</p>
<p>Something is wrong? Contact us!</p>
";
//Letter details
$mail->setFrom('hpreservednl@gmail.com', 'H&P Reserved');
$mail->addReplyTo('hpreservednl@gmail.com', 'H&P Reserved');
$mail->addAddress($email, $fullName);
//Letter contents
$mail->Subject = 'Reservation confirmation';
$mail->isHTML(true);
$mail->Body = $message;
$mail->Send(); //Send email


//Close session
session_unset(); //delete all SESSION variables
session_destroy();

//Redirect user to thank you page
echo '<script type="text/javascript">location.href = "reservationthankyou.html";</script>'; 


?>