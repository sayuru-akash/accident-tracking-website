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
        //do nothing
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
    <title>Vehicle Registration</title>
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
        <form action="./controllers/handle-register-vehicle.php" method="post" enctype="multipart/form-data" name="vehicle_registration_form" onsubmit="return validateForm();">
            <div class="col-10 mx-auto">
                <div class="row text-center mb-5 mt-5">
                    <h1 class="mt-4 mb-4">Register a Vehicle</h1>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Vehicle Registration No.</label>
                        <input type="text" class="form-control" placeholder="vehicle registration no." name="vehicle_registration_number">
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="chassis_number" class="form-label caption">Chassis No.</label>
                        <input type="text" class="form-control" placeholder="chassis no." name="chassis_number">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_province" class="form-label  caption">Registered Province</label>
                        <select name="vehicle_province" class="form-control">
                            <option value="" selected disabled>--select--</option>
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
                        <label for="vehicle_type" class="form-label caption">Vehicle Type</label>
                        <select name="vehicle_type" class="form-control">
                            <option value="" selected disabled>--select--</option>
                            <option value="motorbike">Motorbike</option>
                            <option value="threewheeler">Three Wheeler</option>
                            <option value="car">Car</option>
                            <option value="truck">Truck</option>
                            <option value="bus">Bus</option>
                            <option value="van">Van</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="insurance_registration_number" class="form-label caption">Insurance Registration No.</label>
                        <input type="text" class="form-control" placeholder="insurance no." name="insurance_registration_number">
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="insurance_expiry_date" class="form-label caption">Insurance Expire Date</label>
                        <input type="date" class="form-control" placeholder="insurance expire date" name="insurance_expiry_date">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="insurance_provider" class="form-label caption">Insurance Provider</label>
                        <select name="insurance_provider" class="form-control">
                            <option value="" selected disabled>--select--</option>
                            <option value="AIA Insurance">AIA Insurance</option>
                            <option value="Arpico Insurance">Arpico Insurance</option>
                            <option value="Ceylinco Life">Ceylinco Life</option>
                            <option value="HNB Finance">HNB Finance</option>
                            <option value="LB Finance">LB Finance</option>
                            <option value="other">Other</option>
                        </select>
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
                    <button type="submit" class="btn btn-outline-light col-11 mx-auto caption fs-4 mt-5 mb-5"><i class="bi bi-check2-square" style="padding-right: 30px"></i>Register Vehicle</button>
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
    function validateForm(){
        var vehicle_registration_number = document.forms["vehicle_registration_form"]["vehicle_registration_number"].value;
        var chassis_number = document.forms["vehicle_registration_form"]["chassis_number"].value;
        var vehicle_province = document.forms["vehicle_registration_form"]["vehicle_province"].value;
        var vehicle_type = document.forms["vehicle_registration_form"]["vehicle_type"].value;
        var insurance_registration_number = document.forms["vehicle_registration_form"]["insurance_registration_number"].value;
        var insurance_expiry_date = document.forms["vehicle_registration_form"]["insurance_expiry_date"].value;
        var insurance_provider = document.forms["vehicle_registration_form"]["insurance_provider"].value;
        var agree = document.forms["vehicle_registration_form"]["agree"];

        if(vehicle_registration_number == ""){
            alert("Please enter vehicle registration number");
            return false;
        }
        if(chassis_number == ""){
            alert("Please enter chassis number");
            return false;
        }
        if(vehicle_province == ""){
            alert("Please enter vehicle province");
            return false;
        }
        if(vehicle_type == ""){
            alert("Please enter vehicle type");
            return false;
        }
        if(insurance_registration_number == ""){
            alert("Please enter insurance registration number");
            return false;
        }
        if(insurance_expiry_date == ""){
            alert("Please enter insurance expiry date");
            return false;
        }
        if(insurance_provider == ""){
            alert("Please enter insurance provider");
            return false;
        }
        if(!agree.checked){
            alert("Please agree to the terms and conditions");
            return false;
        }
        return true;
    }
</script>
</body>
</html>