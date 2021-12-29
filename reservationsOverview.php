<!DOCTYPE html>
<?php
//Check if a user is logged in and redirect the user back to login page if not
session_start();
if (!$_SESSION['loggedIn'] == True) {
    echo '<script type="text/javascript">location.href = "employeeLogin.html";</script>';
}
?>
<html lang="en-US">
    <head>
        <title>H&P - Staff</title>
        <link href = "Style/style.css" type = "text/css" rel = "stylesheet" >
        <link rel="shortcut icon" type="ico" href="img/favicon.ico"/>
    </head>
    <!--TEMPORARY CODE. DELETE IT!-->
    Page under construction
    <a href="staffEvents.php">Events</a>
    <body>
    </body>
</html>