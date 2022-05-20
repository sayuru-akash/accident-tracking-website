<?php
session_start();

if ($_SESSION['user_id'] && $_SESSION['user_id'] != '' && $_SESSION['user_role'] == 'super_admin') {

    $u_id = $_POST['u_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $dob = $_POST['dob'];
    $dd = date_create($dob);
    $dobdate = date_format($dd, "Y-m-d");

    $nic = $_POST['nic'];
    $pwd = $_POST['pwd'];
    $role = $_POST['role'];

    $conn = "";
    require_once('../config/connection.php');

    if ($pwd != "") {
        $pwdmd = md5($pwd);
        $sql = "UPDATE Users SET fname = '$fname', lname = '$lname', email = '$email', mobile = '$mobile', dob = '$dob', nic = '$nic', pwd = '$pwdmd', role = '$role' WHERE id = '$u_id'";
    } else {
        $sql = "UPDATE Users SET fname = '$fname', lname = '$lname', email = '$email', mobile = '$mobile', dob = '$dob', nic = '$nic', role = '$role' WHERE id = '$u_id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('User has been updated.');window.location.href='../super-admin-home.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        echo "<script>alert('Error Occurred!.');window.location.href='../super-admin-home.php';</script>";
    }

    mysqli_close($conn);
}