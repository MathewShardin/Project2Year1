<!DOCTYPE html>
<?php
//Check if a user is logged in and redirect the user back to login page if not
session_start();
//if (!$_SESSION['loggedIn'] == True) {
//    echo '<script type="text/javascript">location.href = "employeeLogin.html";</script>';
//}
?>
<html lang="en-US">
    <head>
        <title>H&P - Staff</title>
        <link href = "Style/style.css" type = "text/css" rel = "stylesheet" >
        <link rel="shortcut icon" type="ico" href="img/favicon.ico"/>
    </head>
    <body>
        <?php
            $conn = mysqli_connect("localhost", "root", "")
            OR DIE ("Could not connect to the database");
            mysqli_select_db($conn, "hp_reserved");
            $sql = "SELECT * FROM customer";
            $stmt = mysqli_prepare($conn, $sql) OR DIE ("Preparation Error");
            mysqli_stmt_execute($stmt) OR DIE ("Data retrieval error");
            $result = $stmt->get_result();

            $sql1 = "SELECT * FROM reservation";
            $stmt1 = mysqli_prepare($conn, $sql1) OR DIE ("Preparation Error");
            mysqli_stmt_execute($stmt1) OR DIE ("Data retrieval error");
            $result1 = $stmt1->get_result();
        ?>
        <table id="reservationsOverviewTable">
            <tr>
                <th>Customer Name</th>
                <th>Customer Last Name</th>
                <th>Check-in Date</th>
                <th>Duration</th>
                <th>Details</th>
            </tr>
            <?php
                while ($row = mysqli_fetch_array($result) and $row1 = mysqli_fetch_array($result1)) {
                    echo "<tr>";
                    echo "<td>".$row['custName']."</td>";
                    echo "<td>".$row['custSurname']."</td>";
                    echo "<td>".$row1['resCheckIn']."</td>";
                    echo "<td>".$row1['resDuration']."</td>";
                    echo "<td><a href='reservationDetails.php?id=".$row['custEmail']."'>Details</a></td>";
                    echo "</tr>";
                }
        


            ?>
        </table>
        <?php
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        ?>
    </body>
</html>