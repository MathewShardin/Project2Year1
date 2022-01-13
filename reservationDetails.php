<!DOCTYPE html>
<?php

//Check if a user is logged in and redirect the user back to login page if not
session_start();
if (!$_SESSION['loggedIn'] == True) {
	echo '<script type="text/javascript">location.href = "employeeLogin.html";</script>';
}

//Get id of the reservation based on which reservation was chosen on the previous page (reservationsOverview.php)
if (!$id = filter_input(INPUT_GET, 'id')) {
	//If there is no is no GET parameter or the GET parameter was tampered with -> send user back to previous page
	echo '<script type="text/javascript">location.href = "reservationsOverview.php";</script>';
}


//Get data from DB
if ($conn = mysqli_connect('localhost','root','')) {
	mysqli_select_db($conn, 'hp_reserved');

	//Data from RESERVATION table of DB
	$sql = "SELECT `resId`,`custEmail`,`resNumberGuests`,`resCheckIn`,`resDuration`,`resAddServices`,`eventId`,`resCottageType`,`resLocation`,`resPayment`,`resPrice` FROM `reservation` WHERE `resId` = ?";

	if ($stmt = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt, 'i', $id);

		//Execute statement if preparation is successful
		if (mysqli_stmt_execute($stmt)) {
		} else {echo "<div class='staffEventsPHPResponse'><p>Submission error. Try again later</p></div>";}

	} else {echo "<div id='staffDetailsAutomaticResponse'><p>Failed to retrieve data. Please go back and try again later</p></div>";}

	//Bind results, save results
	mysqli_stmt_bind_result($stmt, $resId, $custEmail, $resNumberGuests, $resCheckIn, $resDuration, $resAddServices, $eventId, $resCottageType, $resLocation, $resPayment, $resPrice);
	mysqli_stmt_store_result($stmt);
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);



	//Data from CUSTOMER table of DB
	$sqlCust = "SELECT `custName`,`custSurname`,`custAddress`,`custDateofBirth` FROM `customer` WHERE `custEmail` = ?;";

	if ($stmtCust = mysqli_prepare($conn, $sqlCust)) {
		mysqli_stmt_bind_param($stmtCust, 's', $custEmail);

		//Execute statement if preparation is successful
		if (mysqli_stmt_execute($stmtCust)) {
		} else {echo "<div class='staffEventsPHPResponse'><p>Submission error. Try again later</p></div>";}

	} else {echo "<div id='staffDetailsAutomaticResponse'><p>Failed to retrieve data. Please go back and try again later</p></div>";}

	//Bind results, save results
	mysqli_stmt_bind_result($stmtCust, $custName, $custSurname, $custAddress, $custDateofBirth);
	mysqli_stmt_store_result($stmtCust);
	mysqli_stmt_fetch($stmtCust);
	mysqli_stmt_close($stmtCust);



	//Data from GUEST table of DB
	$sqlGuest = "SELECT `guestName`,`guestSurname`,`guestDateofBirth`,`guestGender` FROM `guest` WHERE `resId`= ?;";

	if ($stmtGuest = mysqli_prepare($conn, $sqlGuest)) {
		mysqli_stmt_bind_param($stmtGuest, 'i', $resId);

		//Execute statement if preparation is successful
		if (mysqli_stmt_execute($stmtGuest)) {
		} else {echo "<div class='staffEventsPHPResponse'><p>Submission error. Try again later</p></div>";}

	} else {echo "<div id='staffDetailsAutomaticResponse'><p>Failed to retrieve data. Please go back and try again later</p></div>";}

	//Bind results, save results
	mysqli_stmt_bind_result($stmtGuest, $guestName, $guestSurname, $guestDateofBirth, $guestGender);
	mysqli_stmt_store_result($stmtGuest);




	//Data from EVENT table of DB
	$sqlEvent = "SELECT `eventName` FROM `event` WHERE `eventId`= ?;";

	if ($stmtEvent = mysqli_prepare($conn, $sqlEvent)) {
		mysqli_stmt_bind_param($stmtEvent, 'i', $eventId);

		//Execute statement if preparation is successful
		if (mysqli_stmt_execute($stmtEvent)) {
		} else {echo "<div class='staffEventsPHPResponse'><p>Submission error. Try again later</p></div>";}

	} else {echo "<div id='staffDetailsAutomaticResponse'><p>Failed to retrieve data. Please go back and try again later</p></div>";}

	//Bind results, save results
	mysqli_stmt_bind_result($stmtEvent, $eventName);
	mysqli_stmt_store_result($stmtEvent);
	mysqli_stmt_fetch($stmtEvent);
	mysqli_stmt_close($stmtEvent);

} else {echo "<div id='staffDetailsAutomaticResponse'><p>Failed to connect. Please go back and try again later</p></div>";}

mysqli_close($conn);
?>
<html lnag="en-US">
	<head>
		<title>H&P - Staff</title>
		<link rel="shortcut icon" type="ico" href="img/favicon.ico"/>
		<meta charset="utf-8">
		<link href="Style/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="staffReservationDetailsContainer"> <!--Container for the whole page-->
		<header>
                <img src="img/logo_cottage.png" alt="Cottage Logo" id="headerImage" onClick="location.href='signOut.php?type=1'">
                <div id="headerButtons"> <!--This div is used to align the buttons with flexbox-->
                    <div class="headerOneButton" onClick="location.href='reservationsOverview.php'">Reservations</div>
                    <div class="headerOneButton" onClick="location.href='staffEvents.php'">Events</div>
                    <div class="headerOneButton" onClick="location.href='signOut.php'">Sign out</div>
                </div>
        </header>

		<div id="staffDetailsTitle">
			<h2>Reservation # <?php echo $id ?></h2>
		</div>

		<table id="staffDetailsTable">
			<tr> <!--Row 1-->
				<th>Id</th>
				<th>E-mail</th>
				<th>Name</th>
				<th>Last name</th>
				<th>Address</th>
				<th>D.o.B.</th>
				<th>Location</th>
			</tr>
			<tr> <!--Row 2-->
				<td><?php echo $resId ?></td>
				<td><?php echo $custEmail ?></td>
				<td><?php echo $custName ?></td>
				<td><?php echo $custSurname ?></td>
				<td><?php echo $custAddress ?></td>
				<td><?php echo $custDateofBirth ?></td>
				<td><?php echo $resLocation ?></td>
			</tr>
			<tr> <!--Row 3-->
				<th>Cottage</th>
				<th>Event</th>
				<th>Add. Services</th>
				<th>Check-in</th>
				<th>Duration</th>
				<th>Price</th>
				<th>Payment method</th>
			</tr>
			<tr> <!--Row 3-->
				<td><?php echo $resCottageType ?></td>
				<td><?php echo $eventName ?></td>
				<td><?php echo $resAddServices ?></td>
				<td><?php echo $resCheckIn ?></td>
				<td><?php echo $resDuration ?></td>
				<td><?php echo $resPrice ?></td>
				<td><?php echo $resPayment ?></td>
			</tr>
		</table>

		<table id="staffDetailsGuestTable"> <!--Staff table-->
			<tr> <!--Row 1-->
				<th>Name</th>
				<th>Last name</th>
				<th>D.o.B.</th>
				<th>Gender</th>
			</tr>
			<?php //Guest info rom DB
			if (mysqli_stmt_num_rows($stmtGuest) > 0) {
				while (mysqli_stmt_fetch($stmtGuest)) {
					echo "<tr>";
						echo "<td>".$guestName."</td>";
						echo "<td>".$guestSurname."</td>";
						echo "<td>".$guestDateofBirth."</td>";
						echo "<td>".$guestGender."</td>";
					echo "</tr>";
				}
			}
			?>
			<?php mysqli_stmt_close($stmtGuest);?>
		</table>



		</div>
	</body>
</html>
