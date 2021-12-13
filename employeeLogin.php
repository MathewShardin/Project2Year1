<?php
$conn= mysqli_connect("localhost","root","","hp_reserved") or
die("Connection Failed" .mysqli_connect_error());
if(!$conn)
{
    die("connection error");
}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $EmployeeID=$_POST["EmployeeID"];
    $EmployeePassword=$_POST["EmployeePassword"];
    $sql="SELECT * from hpstaff where username='".$EmployeeID."'AND password='".$EmployeePassword."' ";
    $result= mysqli_query($conn, $sql);
    $row= mysqli_fetch_array($result);
    if($row["usertype"]=="user")
    {
        echo"user";
    }
    elseif($row["usertype"]=="admin")
    {
        header("location:add.php");
    }
    else
    {
        echo"username or password incorrect";
    }
}
?>