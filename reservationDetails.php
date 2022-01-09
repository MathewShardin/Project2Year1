<?php

if($_SERVER['REQUEST_METHOD'] === 'GET') {
  $resId= $_GET['resId'];
  $custEmail = $_GET['custEmail'];
  $custFName = $_GET['custFName'];
  $custLName = $_GET['custLName'];
  $addr = $_GET['addr'];
  $dob = $_GET['dob'];
  $resLocation = $_GET['resLocation'];
  $resCottageType = $_GET['resCottageType'];
  $eventId = $_GET['eventId'];
  $resAddServices = $_GET['resAddServices'];
  $resCheckIn = $_GET['resCheckIn'];
  $resDuration = $_GET['resDuration'];
  $resPrice = $_GET['resPrice'];
  $resPayment = $_GET['resPayment'];
  $gender = $_GET['gender'];
}
 ?>


 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>View</title>
   </head>
   <body>
     <table border="1">
        <tr>
          <th>Id</th>
          <th>E-mail</th>
          <th>Name</th>
          <th>Last Name</th>
          <th>Address</th>
          <th>D.o.B</th>
          <th>Location</th>
          <!-- Move one row down -->
          <th>Cottage</th>
          <th>Event</th>
          <th>Additional services</th>
          <th>Check-in</th>
          <th>Duration</th>
          <th>Price</th>
          <th>Payment method</th>
        </tr>
        <tr>
          <td><?php echo $resId ?> </td>
          <td><?php echo $custEmail ?></td>
          <td><?php echo $custFName ?></td>
          <td><?php echo $custLName ?></td>
          <td><?php echo $addr ?></td>
          <td><?php echo $dob ?></td>
          <td><?php echo $resLocation ?></td>
          <td><?php echo $resCottageType ?></td>
          <td><?php echo $eventId ?></td>
          <td><?php echo $resAddServices ?></td>
          <td><?php echo $resCheckIn ?></td>
          <td><?php echo $resDuration ?></td>
          <td><?php echo $resPrice ?></td>
          <td><?php echo $resPayment ?></td>
        </tr>
     </table>

    <br>
    <br>
    <br>

     <table border="1">
        <tr>
          <th>Name</th>
          <th>Last name</th>
          <th>D.o.B</th>
          <th>Gender</th>
        </tr>
        <tr>
          <td><?php echo $custEmail ?></td>
          <td><?php echo $custFName ?></td>
          <td><?php echo $custLName ?></td>
          <td><?php echo $gender ?></td>
        </tr>
     </table>
   </body>
 </html>
