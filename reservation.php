<?php

  $email = $_GET['email'];
  $checkin = $_GET['checkin'];

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
          <th>Email</th>
          <th>Check In</th>
        </tr>
        <tr>
          <td><?php echo $email ?> </td>
          <td><?php echo $checkin ?></td>
        </tr>
     </table>
   </body>
 </html>
