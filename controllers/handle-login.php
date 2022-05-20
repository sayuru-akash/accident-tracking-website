<?php
session_start();
$email = $_POST['email'];
$pwd = $_POST['pwd'];
$pwdmd = md5($pwd);

$conn = "";
require_once('../config/connection.php');

$sql = "SELECT * FROM Users WHERE email = '$email' AND pwd = '$pwdmd'";
$query = mysqli_query($conn,$sql);
$result=mysqli_fetch_array($query);
if($result){
    $_SESSION['user_id'] = $result['id'];
    $_SESSION['user_name'] = $result['fname'] . " " . $result['lname'];
    $_SESSION['user_email'] = $result['email'];
    $_SESSION['user_role'] = $result['role'];

    if ($_SESSION['user_role'] == "user") {
        header("Location: ../user-home.php");
    } else if ($_SESSION['user_role'] == "rda_admin") {
        header("Location: ../rda-admin-home.php");
    } else if ($_SESSION['user_role'] == "insurance_admin") {
        header("Location: ../insurance-admin-home.php");
    } else if ($_SESSION['user_role'] == "police_admin"){
        header("Location: ../police-admin-home.php");
    } else if ($_SESSION['user_role'] == "super_admin"){
        header("Location: ../super-admin-home.php");
    }else{
        header("Location: ../login.php");
    }

} else {
    echo "<script>alert('Invalid email and password combination.');window.location.href='../login.php';</script>";
}