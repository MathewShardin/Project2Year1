<!DOCTYPE html>
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
			<h2>Reservation #</h2>
		</div>

		<table id="staffDetailsTable">
			<tr>
				<th>Id</th>
				<th>E-mail</th>
				<th>Name</th>
				<th>Last name</th>
				<th>Address</th>
				<th>D.o.B.</th>
				<th>Location</th>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>

		</table>



		</div>
	</body>
</html>
