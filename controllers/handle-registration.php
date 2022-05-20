<?php

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];

$dob = $_POST['dob'];
$dd=date_create($dob);
$dobdate=date_format($dd,"Y-m-d");

$nic = $_POST['nic'];
$pwd = $_POST['pwd'];
$con_pwd = $_POST['con_pwd'];
$pwdmd = md5($pwd);

$conn = "";
require_once('../config/connection.php');

$sql = "INSERT INTO Users (fname, lname, email, mobile, dob, nic, pwd, regdate)
VALUES ('$fname', '$lname', '$email', '$mobile', '$dobdate', '$nic', '$pwdmd', NOW())";

if (mysqli_query($conn, $sql)) {
    echo "New user created successfully";
    echo "<script>alert('Registration success. Please log in to proceed!');window.location.href='../login.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);