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
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Test</title>
  </head>
  <body>
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
