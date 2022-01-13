<?php
//Processing page
//Check if a user is logged in and redirect the user back to login page if not
session_start();
if (!$_SESSION['loggedIn'] == True) {
    echo '<script type="text/javascript">location.href = "employeeLogin.html";</script>';
}
?>

<?php
//Processing page
if ($id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
    if ($conn = mysqli_connect('localhost','root','')) {
        mysqli_select_db($conn, 'hp_reserved');

        $sql = "DELETE FROM `reservation` WHERE `resId` = ?;";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            
            //Execute statement if preparation is successful
            if (mysqli_stmt_execute($stmt)) {}
        }
    }

    //Close connection & Statement
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    //No event id found/ id tempered with (not integer) -> forward user back to events page
    echo '<script type="text/javascript">location.href = "reservationsOverview.php";</script>';
}

echo '<script type="text/javascript">location.href = "reservationsOverview.php";</script>';
?>