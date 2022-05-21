<?php

session_start();

$driver_licence = $_POST['driver_licence'];
$driver_name = $_POST['driver_name'];
$vehicle_number = $_POST['vehicle_number'];
$cause_of_accident = $_POST['cause_of_accident'];
$incident_province = $_POST['incident_province'];
$incident_city = $_POST['incident_city'];
$address_nearby = $_POST['address_nearby'];
$landmarks_nearby = $_POST['landmarks_nearby'];
$incident_date = $_POST['incident_date'];
$contact_number = $_POST['contact_number'];
$incident_images = 'incident_images';

$dd=date_create($incident_date);
$incident_date_formatted=date_format($dd,"Y-m-d");

define ('SITE_ROOT', realpath(dirname(__FILE__)));
$image_count = count($_FILES[$incident_images]['name']);

for ($i=0; $i< $image_count; $i++) {
    $image_name = $_FILES[$incident_images]['name'][$i];
    $image_tmp_name = $_FILES[$incident_images]['tmp_name'][$i];
    $image_size = $_FILES[$incident_images]['size'][$i];
    $image_error = $_FILES[$incident_images]['error'][$i];
    $image_type = $_FILES[$incident_images]['type'][$i];

    $image_ext = explode('.', $image_name);
    $image_ext = strtolower(end($image_ext));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($image_ext, $allowed)) {
        if ($image_error === 0) {
            if ($image_size <= 2097152) {
                $image_name_new = uniqid('', true) . '.' . $image_ext;
                $image_destination = '../images/' . $image_name_new;
                move_uploaded_file($image_tmp_name, $image_destination);
                $image_array[] = $image_name_new;
            }
        }
    }
}


    $proof_image1 = $image_array[0];
    $proof_image2 = $image_array[1];
    $proof_image3 = "NULL";
    $proof_image4 = "NULL";
    $proof_image5 = "NULL";

    if (count($image_array) > 2) {
        $proof_image3 = $image_array[2];
    }
    if (count($image_array) > 3) {
        $proof_image4 = $image_array[3];
    }
    if (count($image_array) > 4) {
        $proof_image5 = $image_array[4];
    }

    if ($_SESSION['user_id'] == "") {
        header("Location: ../index.php");
    } else {
        $user_id = $_SESSION['user_id'];
    }
$conn = "";
    require_once('../config/connection.php');

$sql = "INSERT INTO Incidents (driver_licence, driver_name, vehicle_number, cause_of_accident, incident_province, incident_city, address_nearby, landmarks_nearby, incident_date, contact_number, user_id, entry_datetime, proof_image1, proof_image2, proof_image3, proof_image4, proof_image5) VALUES ('$driver_licence', '$driver_name', '$vehicle_number', '$cause_of_accident' , '$incident_province', '$incident_city', '$address_nearby', '$landmarks_nearby', '$incident_date_formatted', '$contact_number', '$user_id', NOW(), '$proof_image1', '$proof_image2', '$proof_image3', '$proof_image4', '$proof_image5')";


if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
    //header( "refresh:2;url=../user-home.php" );
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);