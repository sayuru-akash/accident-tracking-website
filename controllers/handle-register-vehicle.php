<?php

session_start();

$vehicle_registration_number = $_POST['vehicle_registration_number'];
$chassis_number = $_POST['chassis_number'];
$registered_province = $_POST['vehicle_province'];
$vehicle_type = $_POST['vehicle_type'];
$insurance_registration_number = $_POST['insurance_registration_number'];
$insurance_expiry = $_POST['insurance_expiry_date'];
$insurance_provider = $_POST['insurance_provider'];

$dd=date_create($insurance_expiry);
$insurance_expiry_date=date_format($dd,"Y-m-d");

if ($_SESSION['user_id'] == "") {
    header("Location: ../index.php");
} else {
    $user_id = $_SESSION['user_id'];
}
$conn = "";
require_once('../config/connection.php');

$sql = "INSERT INTO Vehicles (vehicle_registration, chassis_number, registered_province, vehicle_type, insurance_registration, insurance_expiry_date, insurance_provider, user_id) VALUES ('$vehicle_registration_number', '$chassis_number', '$registered_province', '$vehicle_type', '$insurance_registration_number', '$insurance_expiry_date', '$insurance_provider', '$user_id')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
    echo "<script>alert('Vehicle Registration success.');window.location.href='../user-home.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);