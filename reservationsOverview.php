<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Employee Login</title>
  <link href="Style/style.css" rel="stylesheet" type="text/css">
  <link rel="shortcut icon" type="ico" href="img/favicon.ico"/>
</head>
<body>
  <div id="reservationOverviewContainer"> <!--Container for the whole page-->
        <header>
            <img src="img/logo_cottage.png" alt="Cottage Logo" id="headerImage" onClick="location.href='signOut.php?type=1'">
            <div id="headerButtons"> <!--This div is used to align the buttons with flexbox-->
                <div class="headerOneButton" onClick="location.href='reservationsOverview.php'">Reservations</div>
                <div class="headerOneButton" onClick="location.href='staffEvents.php'">Events</div>
                <div class="headerOneButton" onClick="location.href='signOut.php'">Sign out</div>
            </div>
        </header>

    <div id="reservationOverviewContent">
        <div id = "resHeader"><h1>Reservations</h1></div>
            <?php
                $conn = mysqli_connect("localhost", "root", "")
                OR DIE ("Could not connect to the database");
                mysqli_select_db($conn, "hp_reserved");
                $sql = "SELECT resid, resCheckIn, resDuration, reservation.custEmail, custName, custSurname FROM reservation Join customer WHERE reservation.custEmail = customer.custEmail";
                $stmt = mysqli_prepare($conn, $sql) OR DIE ("Preparation Error");
                mysqli_stmt_execute($stmt) OR DIE ("Data retrieval error");
                $result = $stmt->get_result();

            ?>
            <table id = "reservationOverviewTable">
                <tr>
                    <th>Customer Name</th>
                    <th>Customer Last Name</th>
                    <th>Check-in Date</th>
                    <th>Duration</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>".$row['custName']."</td>";
                        echo "<td>".$row['custSurname']."</td>";
                        echo "<td>".$row['resCheckIn']."</td>";
                        echo "<td>".$row['resDuration']."</td>";
                        echo "<td><a href='reservationDetails.php?id=".$row['resid']."'>Details</a></td>";
                        echo "<td><a href='reservationDelete.php?id=".$row['resid']."'>Delete</a></td>";
                        echo "</tr>";
                    }
                ?>
            </table>
            <?php
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            ?>
    </div>
  </div>
</body>
</html>