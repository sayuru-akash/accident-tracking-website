<?php
session_start();

if ($_SESSION['user_id'] && $_SESSION['user_id'] != '' && $_SESSION['user_role'] == 'super_admin') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $dob = $_POST['dob'];
    $dd = date_create($dob);
    $dobdate = date_format($dd, "Y-m-d");

    $nic = $_POST['nic'];
    $pwd = $_POST['pwd'];
    $con_pwd = $_POST['con_pwd'];
    $pwdmd = md5($pwd);
    $role = $_POST['role'];

    $conn = "";
    require_once('../config/connection.php');

    $sql = "INSERT INTO Users (fname, lname, email, mobile, dob, nic, pwd, role, regdate)
VALUES ('$fname', '$lname', '$email', '$mobile', '$dobdate', '$nic', '$pwdmd', '$role', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        echo "<script>alert('User has been created.');window.location.href='../super-admin-home.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        echo "<script>alert('Error Occurred.');window.location.href='../super-admin-home.php';</script>";
    }

    mysqli_close($conn);
}else{
    header("Location: ../login.php");
}