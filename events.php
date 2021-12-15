<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Events</title>
</head>

<link href="Style/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<div id="containerEvents"> <!--Container for the whole page-->
  <header>
    <img src="img/logo_cottage.png" alt="Cottage Logo" id="headerImage" onClick="location.href='index.html'">
    <div id="headerButtons"> <!--This div is used to align the buttons with flexbox-->
      <div class="headerOneButton" id="headerDropDown">
        Accommodation
        <div class="dropdown-content"> <!--Drop down menu contents-->
          <a href="cottagestraw.html">Straw</a>
          <a href="cottagebamboo.html">Bamboo</a>
          <a href="cottagebrick.html">Brick</a>
        </div>
      </div>
      <div class="headerOneButton" onClick="location.href='locations.html'">Locations</div>
      <div class="headerOneButton" onClick="location.href='events.php'">Events</div>
      <div class="headerOneButton" onClick="location.href='contact.html'">Contact</div>
      <div class="headerOneButton" onClick="location.href='employeeLogin.html'">Staff</div>
    </div>
  </header>
  <div id="contentEvents">
    <p class="titleEvents">Events</p>
    <div id="eventsTable">
        <table class="Tableevents">

            <?php
            $conn = mysqli_connect("localhost","root","","hp_reserved");
            if ($conn-> connect_error) {
                die("Connection failed:" . $conn-> connect_error);
            }
            $sql ="SELECT eventDate, eventName from event";
            $result = $conn-> query($sql);
            if ($result-> num_rows > 0 ){
                while ($row = $result-> fetch_assoc()){
                    echo "<tr class='trevents'><td class='tdTable'> 	" .$row["eventDate"] . "</td><td class=''>" . $row["eventName"] . "</td></tr>";
                }
                echo"</table>";
            }
            else {
                echo " 0 result";
            }
            $conn-> close();
            ?>

        </table>


    </div>

    <div id="imageEvents">
      <img class="imageEvents" src="img/Fox_Mascot_HPReserved.png" alt="Cottage Logo">
    </div>
    <div id="eventsTextEnd">
      <p class="eventsTextEnd">Events require a reservation in advance. Don't forget to choose the event you
        would like to attend while reserving your stay. Contact us if you have any questions!</p> </a>
    </div>


  </div>

</div>
</body>
</html>