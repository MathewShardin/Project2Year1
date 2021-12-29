<?php
//Processing page
if ($id = filter_input(INPUT_GET, 'id')) {
    if ($conn = mysqli_connect('localhost','root','')) {
        mysqli_select_db($conn, 'hp_reserved');

        $sql = "DELETE FROM `event` WHERE `eventId`= ?";

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
    //No event id found -> forward user back to events page
    echo '<script type="text/javascript">location.href = "staffEvents.php";</script>';
}

echo '<script type="text/javascript">location.href = "staffEvents.php";</script>';
?>