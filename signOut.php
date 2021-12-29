<?php
//Processing page for logging out
session_start();
$_SESSION['loggedIn'] = true;
session_destroy();
if ($signOutType = filter_input(INPUT_GET, 'type')) {
    //If user pressed on HP logo -> log the user out and redirect to index page
    echo '<script type="text/javascript">location.href = "index.html";</script>';
}
echo '<script type="text/javascript">location.href = "employeeLogin.html";</script>';

?>