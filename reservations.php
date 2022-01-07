<?php

  $con = mysqli_connect("localhost", "root", "", "hp_reserved"); //STEP 1 : Connect to db, host, username, password, database

  $query = 'SELECT * FROM reservation'; //query

  $result = mysqli_query($con, $query);

  /*if($con) {
    echo "Ok";
  }else {
    echo "No";
    die();
  }*/

  /*if($result) {
    echo "Ok";
  }else {
    echo "No";
    die();
  }*/

?>


<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>H&P - Reservations</title>
        <meta charset="utf-8">
        <link href="Style/style.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" type="ico" href="img/favicon.ico"/>
    </head>
  <body>
  <div id="staffEventsContainer"> <!--Container for the whole page-->
            <header>
                <img src="img/logo_cottage.png" alt="Cottage Logo" id="headerImage" onClick="location.href='signOut.php?type=1'">
                <div id="headerButtons"> <!--This div is used to align the buttons with flexbox-->
                    <div class="headerOneButton" onClick="location.href='reservationsOverview.php'">Reservations</div>
                    <div class="headerOneButton" onClick="location.href='staffEvents.php'">Events</div>
                    <div class="headerOneButton" onClick="location.href='signOut.php'">Sign out</div>
                </div>
            </header>
            
            <div id="staffEventsTitle">
                <h1>Reservations</h1>
            </div> 
            
     <table border="1">
       <tr>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Email</th>
         <th>Payment method</th>
         <th>Check-in date</th>
         <th>Duration</th>
         <th>Details</th>
       </tr>

         <?php
          while($row = mysqli_fetch_assoc($result))
          {
             ?>

             <tr>
                 <td><?php echo $row['custFName'] ?></td>
                 <td><?php echo $row['custLName'] ?></td>
                 <td><?php echo $row['custEmail'] ?></td>
                 <td><?php echo $row['resPayment'] ?></td>
                 <td><?php echo $row['resCheckIn'] ?></td>
                 <td><?php echo $row['resDuration'] ?></td>
                 <td><a href="<?php echo 'view.php?email=' . $row['custEmail'] . '&checkin=' . $row['resCheckIn'] ?>">Details</a></td>
             </tr>
             <?php
         }
         ?>
  </body>
</html>
