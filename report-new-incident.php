<?php

session_start();

if ($_SESSION['user_id'] && $_SESSION['user_id'] != '' && $_SESSION['user_role'] == 'user') {

    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_role = $_SESSION['user_role'];

    $conn = "";
    require_once('./config/connection.php');

    $sql = mysqli_query($conn,"SELECT * FROM Users WHERE email = '$user_email'");
    $result=mysqli_fetch_array($sql);

    if ($result){
        $vsql = "SELECT vehicle_registration FROM Vehicles WHERE user_id = '$user_id'";
        $vresult = $conn->query($vsql);
    }else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}else{
    header('Location: login.php');
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incident Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&family=Poppins:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body{
            background-color: #F8F8F8F8;
        }
        h1{
            font-family: 'Poppins', sans-serif;
            font-size: 60px;
        }
        .caption{
            font-weight: 600;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-left: 30px; padding-right: 30px; background-color: #5632D9 !important;">
    <div class="container-fluid row">
        <a class="navbar-brand col-sm-12 col-lg-10 caption" href="#" style="color: #F8F8F8 !important;">Accident Claim System</a>
    </div>
</nav>
<div class="container">
    <div class="col-lg-11 col-sm-10 text-light mx-auto pt-5 pb-2 shadow-lg" style="margin-top: 8%; background-color: #5632D9; border-radius: 25px">
        <div class="row justify-content-end">
            <div class="col-lg-3 col-sm-3">
                <a class="btn btn-outline-light" style="margin-left: 10px" href="user-home.php">Home</a>
            </div>
        </div>
        <form action="./controllers/handle-report-new-incident.php" method="post" enctype="multipart/form-data" name="incident_form" onsubmit="return validateForm();">
            <div class="col-10 mx-auto">
                <div class="row text-center mb-5 mt-5">
                    <h1 class="mt-4 mb-4">Report Incident</h1>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="driver_licence" class="form-label  caption">Driver Licence No.</label>
                        <input type="text" class="form-control" placeholder="driver's licence number" name="driver_licence">
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="driver_name" class="form-label caption">Driver Name</label>
                        <input type="text" class="form-control" placeholder="name as in driver's licence" name="driver_name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_number" class="form-label  caption">Vehicle No.</label>
                        <select name="vehicle_number" class="form-control">
                            <option value="" selected disabled>--select--</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($vresult)) {
                                echo "<option value='{$row['vehicle_registration']}'>{$row['vehicle_registration']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="cause_of_accident" class="form-label  caption">Cause of Accident</label>
                        <select name="cause_of_accident" class="form-control">
                            <option value="" selected disabled>--select--</option>
                            <option value="Bad Weather">Bad Weather</option>
                            <option value="Distractions">Distractions</option>
                            <option value="Vehicle Failure">Vehicle Failure</option>
                            <option value=""Drunk Driving">Drunk Driving</option>
                            <option value="Speeding">Speeding</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="incident_province" class="form-label  caption">Incident Province</label>
                        <select name="incident_province" class="form-control">
                            <option value="">--select--</option>
                            <option value="Western">Western</option>
                            <option value="Eastern">Eastern</option>
                            <option value="Northern">Northern</option>
                            <option value="Southern">Southern</option>
                            <option value="North Western">North Western</option>
                            <option value="North Central">North Central</option>
                            <option value="Uva">Uva</option>
                            <option value="Sabaragamuwa">Sabaragamuwa</option>
                            <option value="Central">Central</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="incident_city" class="form-label caption">Nearest City</label>
                        <input type="text" class="form-control" placeholder="incident specific city" name="incident_city">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="address_nearby" class="form-label caption">Incident Nearby Address</label>
                        <textarea type="text" class="form-control" placeholder="situation specific address" name="address_nearby"></textarea>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="landmarks_nearby" class="form-label caption">Nearby Landmarks</label>
                        <textarea type="text" class="form-control" placeholder="buildings / shops / etc" name="landmarks_nearby"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="incident_date" class="form-label caption">Date & Time</label>
                        <input type="date" class="form-control" name="incident_date">
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="contact_number" class="form-label caption">Contact No</label>
                        <input type="text" class="form-control" placeholder="071 123 4567" name="contact_number">
                    </div>
                </div>
                <div class="row mx-auto justify-content-center pt-3 mt-4 mb-4 fs-5">
                    <div class="col-lg-5 col-sm-12">
                        <label for="incident_images[]" class="form-label">Import 2 to 5 Photos of the Incident</label>
                        <input class="form-control" type="file" id="formFileMultiple" multiple name="incident_images[]">
                    </div>
                </div>
                <div class="row mx-auto pt-3 mt-4 mb-4 fs-5">
                    <div class="col-lg-10 col-sm-12">
                        <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="agree">&nbsp;
                        <label class="form-check-label" for="flexCheckDefault">
                            I guarantee that the provided information are correct.
                        </label>
                    </div>
                </div>
                <div class="row mb-5">
                    <button type="submit" class="btn btn-outline-light col-11 mx-auto caption fs-4 mt-5 mb-5"><i class="bi bi-check2-square" style="padding-right: 30px"></i>Report Incident</button>
                </div>
            </div>
        </form>
    </div>
</div>
<footer class="text-center text-white mt-5" style="background-color: #5632D9">
    <div class="text-center p-3" style="background-color: #6038F2">
        © 2022 Copyright
    </div>
</footer>
<script>
    function validateForm() {
        var driver_licence = document.forms["incident_form"]["driver_licence"].value;
        var driver_name = document.forms["incident_form"]["driver_name"].value;
        var vehicle_number = document.forms["incident_form"]["vehicle_number"].value;
        var cause_of_accident = document.forms["incident_form"]["cause_of_accident"].value;
        var incident_province = document.forms["incident_form"]["incident_province"].value;
        var nearest_city = document.forms["incident_form"]["incident_city"].value;
        var address_nearby = document.forms["incident_form"]["address_nearby"].value;
        var landmarks_nearby = document.forms["incident_form"]["landmarks_nearby"].value;
        var incident_date = document.forms["incident_form"]["incident_date"].value;
        var contact_number = document.forms["incident_form"]["contact_number"].value;
        var incident_images = document.forms["incident_form"]["incident_images[]"];
        var agree = document.forms["incident_form"]["agree"];

        var files = incident_images.files;

        if (driver_licence == "") {
            alert("Driver's Licence Number is required");
            return false;
        }
        if (driver_name == "") {
            alert("Driver's Name is required");
            return false;
        }
        if (vehicle_number == "") {
            alert("Vehicle Number is required");
            return false;
        }
        if (cause_of_accident == "") {
            alert("Cause of Accident is required");
            return false;
        }
        if (incident_province == "") {
            alert("Province is required");
            return false;
        }
        if (nearest_city == "") {
            alert("Nearest City is required");
            return false;
        }
        if (address_nearby == "") {
            alert("Address Nearby is required");
            return false;
        }
        if (landmarks_nearby == "") {
            alert("Landmarks Nearby is required");
            return false;
        }
        if (incident_date == "") {
            alert("Incident Date is required");
            return false;
        }
        if (contact_number == "") {
            alert("Contact Number is required");
            return false;
        }
        if (contact_number.length != 10) {
            alert("Contact Number must be 10 digits");
            return false;
        }
        if (files.length < 2) {
            alert("At least two images are required");
            return false;
        }
        if(files.length > 5){
            alert("You can upload maximum 5 images");
            return false;
        }
        if (!agree.checked) {
            alert("You must agree to the terms and conditions");
            return false;
        }

        //Image Validation
            /* iterating over the files array */
            for(var i=0;i<files.length;i++){
                var filename = files[i].name;

                /* getting file extenstion eg- .jpg,.png, etc */
                var extension = filename.substr(filename.lastIndexOf("."));

                /* define allowed file types */
                var allowedExtensionsRegx = /(\.jpg|\.jpeg|\.png)$/i;

                /* testing extension with regular expression */
                var isAllowed = allowedExtensionsRegx.test(extension);

                if(isAllowed){
                    //do nothing
                }else{
                    alert("Invalid File Type for the upload! Only .jpg, .jpeg, .png files are allowed");
                    return false;
                }
            }
    }
</script>
</body>
</html>
