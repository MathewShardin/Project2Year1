<?php
session_start();
//Processing Page for logging in
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Get input values
    $employeeID=$_POST["EmployeeID"];
    $employeePassword=$_POST["EmployeePassword"];


    //Connect to DB and Select DB
    if ($conn = mysqli_connect('localhost','root','')) {
        mysqli_select_db($conn, 'hp_reserved');

        //Select the record with user data from DB
        $sql = "SELECT `userName`, `password`, `userType` FROM `hpstaff` WHERE `userName`= ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $employeeID);

            //Execute statement if preparation is successful
            if (mysqli_stmt_execute($stmt)) {
            } else {echo "Error. Failed to check staff ID. Try again later";}

        } else {echo "Preparation error. Try again later";}

        //Bind results
        mysqli_stmt_bind_result($stmt, $userName, $password, $userType);
        mysqli_stmt_store_result($stmt);
        

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_fetch($stmt);
            if ($employeeID == $userName AND $employeePassword == $password) {
                //If credentials are correct
                $_SESSION['loggedIn'] = true;
                //Redirect user to staff page
                echo '<script type="text/javascript">location.href = "reservationsOverview.php";</script>';
            } else {
                //Credentials are incorrect
                session_destroy();
                echo "<script type='text/javascript'>alert('Incorrect Employee ID or Password');</script>";
                echo '<script type="text/javascript">location.href = "employeeLogin.html";</script>';

            }
        } else {
            //No employee ID found
            session_destroy();
            echo "<script type='text/javascript'>alert('Input Employee ID does not exist. Please try again');</script>";
            echo '<script type="text/javascript">location.href = "employeeLogin.html";</script>';
        }

    } else {echo "Connection error. Try again later";}
}
?>