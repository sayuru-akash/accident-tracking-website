<?php

session_start();

if ($_SESSION['user_id'] && $_SESSION['user_id'] != '') {

    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_role = $_SESSION['user_role'];

    $incident_id = $_GET['id'];

    $conn = "";
    require_once('./config/connection.php');

    $sql = mysqli_query($conn,"SELECT * FROM Users WHERE email = '$user_email'");
    $result=mysqli_fetch_array($sql);

    if ($result){
        if ($user_role == 'user'){
            $isql = "SELECT * FROM Incidents WHERE incident_id = '$incident_id' AND user_id = '$user_id'";
            $iresult = $conn->query($isql);
            if ($iresult->num_rows == 0){
                echo "<script>alert('You are not authorized to view this report.');window.location.href='user-home.php';</script>";
            }
        } else {
            $isql = "SELECT * FROM Incidents WHERE incident_id = '$incident_id'";
            $iresult = $conn->query($isql);
        }

        if ($iresult->num_rows > 0) {
            // output data of each row
            while($row = $iresult->fetch_assoc()) {
                $driver_license = $row["driver_licence"];
                $driver_name = $row["driver_name"];
                $vehicle_number = $row["vehicle_number"];
                $cause_of_accident = $row["cause_of_accident"];
                $incident_province = $row["incident_province"];
                $incident_city = $row["incident_city"];
                $address_nearby = $row["address_nearby"];
                $landmarks_nearby = $row["landmarks_nearby"];
                $incident_date = $row["incident_date"];
                $contact_number = $row["contact_number"];
                $entry_datetime = $row["entry_datetime"];
                $rda_status = $row["rda_status"];
                $police_status = $row["police_status"];
                $insurance_status = $row["insurance_status"];
                $proof_image1 = $row["proof_image1"];
                $proof_image2 = $row["proof_image2"];
                $proof_image3 = $row["proof_image3"];
                $proof_image4 = $row["proof_image4"];
                $proof_image5 = $row["proof_image5"];
            }

        } else {
            echo "0 results";
        }
        $bsql = "SELECT * FROM Vehicles WHERE vehicle_registration = '$vehicle_number'";
        $bresult = $conn->query($bsql);
        if ($bresult->num_rows > 0) {
            // output data of each row
            while ($row = $bresult->fetch_assoc()) {
                $chassis_number = $row["chassis_number"];
                $registered_province = $row["registered_province"];
                $vehicle_type = $row["vehicle_type"];
                $insurance_registration = $row["insurance_registration"];
                $insurance_expiry_date = $row["insurance_expiry_date"];
                $insurance_provider = $row["insurance_provider"];
            }
        } else {
            echo "0 results";
        }
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
    <div class="col-lg-11 col-sm-10 text-light mx-auto pt-5 pb-5 shadow-lg" style="margin-top: 8%; background-color: #5632D9; border-radius: 25px;">
        <form action="./controllers/handle-register-vehicle.php" method="post" enctype="multipart/form-data">
            <div class="col-10 mx-auto">
                <div class="row text-center mb-5 mt-5">
                    <h1 class="mt-4 mb-4">Report Details</h1>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Driver License No.</label>
                        <input type="text" class="form-control" placeholder="driver license no" name="driver_license_no" value="<?php echo $driver_license ?>" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="chassis_number" class="form-label caption">Driver's Name</label>
                        <input type="text" class="form-control" placeholder="drive's name" name="driver_name" value="<?php echo $driver_name ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Vehicle Registration No.</label>
                        <input type="text" class="form-control" placeholder="vehicle registration no." name="vehicle_registration_number" value="<?php echo $vehicle_number ?>" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="chassis_number" class="form-label caption">Chassis No.</label>
                        <input type="text" class="form-control" placeholder="chassis no." name="chassis_number" value="<?php echo $chassis_number ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Vehicle Registered Province.</label>
                        <input type="text" class="form-control" placeholder="vehicle registration province" name="vehicle_registration_province" value="<?php echo $registered_province ?>" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="chassis_number" class="form-label caption">Vehicle Type</label>
                        <input type="text" class="form-control" placeholder="vehicle_type" name="vehicle_type" value="<?php echo $vehicle_type ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="cause_of_accident" class="form-label  caption">Cause of Accident</label>
                        <input type="text" class="form-control" placeholder="cause of accident" name="cause_of_accident" value="<?php echo $cause_of_accident ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Insurance Registration No.</label>
                        <input type="text" class="form-control" placeholder="vehicle registration no." name="vehicle_registration_number" value="<?php echo $insurance_registration ?>" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="chassis_number" class="form-label caption">Insurance Expiry Date</label>
                        <input type="text" class="form-control" placeholder="insurance expiry date" name="insurance_expiry_date" value="<?php echo $insurance_expiry_date ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Insurance Provider</label>
                        <input type="text" class="form-control" placeholder="insurance provider" name="insurance_provider" value="<?php echo $insurance_provider ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Incident Province</label>
                        <input type="text" class="form-control" placeholder="incident province" name="incident_province" value="<?php echo $incident_province ?>" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="chassis_number" class="form-label caption">Incident City</label>
                        <input type="text" class="form-control" placeholder="incident city" name="incident_city" value="<?php echo $incident_city ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Address Nearby</label>
                        <input type="text" class="form-control" placeholder="address nearby" name="address_nearby" value="<?php echo $address_nearby ?>" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="chassis_number" class="form-label caption">Landmarks Nearby</label>
                        <input type="text" class="form-control" placeholder="landmarks nearby" name="landmarks_nearby" value="<?php echo $landmarks_nearby ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Incident Date</label>
                        <input type="text" class="form-control" placeholder="incident date" name="incident_date" value="<?php echo $incident_date ?>" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="chassis_number" class="form-label caption">Contact No.</label>
                        <input type="text" class="form-control" placeholder="contact no" name="contact_no" value="<?php echo $contact_number ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Entry Date & Time</label>
                        <input type="text" class="form-control" placeholder="entry date & time" name="entry_date_time" value="<?php echo $entry_datetime ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">RDA Status</label>
                        <input type="text" class="form-control" placeholder="RDA status" name="rda_status" value="<?php echo $rda_status ?>" disabled>
                    </div>
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="chassis_number" class="form-label caption">Police Status</label>
                        <input type="text" class="form-control" placeholder="police status" name="chpolice_status" value="<?php echo $police_status ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-sm-10 mb-4">
                        <label for="vehicle_registration_number" class="form-label  caption">Insurance Status</label>
                        <input type="text" class="form-control" placeholder="insurance status" name="insurance_status" value="<?php echo $insurance_status ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <label for="evidence" class="form-label  caption">Evidence</label>
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <?php if ($proof_image3 != "" && $proof_image3 != "NULL") { ?>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            <?php } ?>
                            <?php if ($proof_image4 != "" && $proof_image4 != "NULL") { ?>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                            <?php } ?>
                            <?php if ($proof_image5 != ""  && $proof_image5 != "NULL") { ?>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                            <?php } ?>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="../images/<?php echo $proof_image1 ?>" style="width: 1000px; height: 600px; object-fit: cover" class="d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="../images/<?php echo $proof_image2 ?>" style="width: 1000px; height: 600px; object-fit: cover" class="d-block w-100">
                            </div>
                            <?php if ($proof_image3 != ""  && $proof_image3 != "NULL") { ?>
                                <div class="carousel-item">
                                    <img src="../images/<?php echo $proof_image3 ?>" style="width: 1000px; height: 600px; object-fit: cover" class="d-block w-100">
                                </div>
                            <?php } ?>
                            <?php if ($proof_image4 != ""  && $proof_image4 != "NULL") { ?>
                                <div class="carousel-item">
                                    <img src="../images/<?php echo $proof_image4 ?>" style="width: 1000px; height: 600px; object-fit: cover" class="d-block w-100">
                                </div>
                            <?php } ?>
                            <?php if ($proof_image5 != ""  && $proof_image5 != "NULL") { ?>
                                <div class="carousel-item">
                                    <img src="../images/<?php echo $proof_image5 ?>" style="width: 1000px; height: 600px; object-fit: cover" class="d-block w-100">
                                </div>
                            <?php } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
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
</body>
</html>