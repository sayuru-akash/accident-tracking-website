<?php

session_start();

if ($_SESSION['user_id'] && $_SESSION['user_id'] != '' && $_SESSION['user_role'] == 'police_admin') {

    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_role = $_SESSION['user_role'];

    $conn = "";
    require_once('./config/connection.php');

    $sql = mysqli_query($conn,"SELECT * FROM Users WHERE email = '$user_email'");
    $result=mysqli_fetch_array($sql);

    if ($result){
        if($result['role']!=$user_role){
            header("Location: ./controllers/handle-logout.php");
        }

        $sql = "SELECT * FROM Incidents";
        $result = $conn->query($sql);

        $bad_weather_count = 0;
        $distractions_count = 0;
        $vehicle_failure_count = 0;
        $drunk_driving_count = 0;
        $speeding_count = 0;
        $other_count = 0;

        $western_count = 0;
        $central_count = 0;
        $eastern_count = 0;
        $northern_count = 0;
        $sabaragamuwa_count = 0;
        $uva_count = 0;
        $southern_count = 0;
        $north_central_count = 0;
        $north_western_count = 0;

        $pending_rda_count = 0;
        $pending_insurance_count = 0;
        $approved_rda_count = 0;
        $approved_insurance_count = 0;
        $declined_rda_count = 0;
        $declined_insurance_count = 0;

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if ($row['cause_of_accident'] == 'Bad Weather') {
                    $bad_weather_count++;
                } else if ($row['cause_of_accident'] == 'Distractions') {
                    $distractions_count++;
                } else if ($row['cause_of_accident'] == 'Vehicle Failure') {
                    $vehicle_failure_count++;
                } else if ($row['cause_of_accident'] == 'Drunk Driving') {
                    $drunk_driving_count++;
                } else if ($row['cause_of_accident'] == 'Speeding') {
                    $speeding_count++;
                } else if ($row['cause_of_accident'] == 'Other') {
                    $other_count++;
                }

                if ($row['incident_province'] == 'Western') {
                    $western_count++;
                } else if ($row['incident_province'] == 'Eastern') {
                    $eastern_count++;
                } else if ($row['incident_province'] == 'Northern') {
                    $northern_count++;
                } else if ($row['incident_province'] == 'Southern') {
                    $southern_count++;
                } else if ($row['incident_province'] == 'Central') {
                    $central_count++;
                } else if ($row['incident_province'] == 'Sabaragamuwa') {
                    $sabaragamuwa_count++;
                } else if ($row['incident_province'] == 'Uva') {
                    $uva_count++;
                } else if ($row['incident_province'] == 'North Western') {
                    $north_western_count++;
                } else if ($row['incident_province'] == 'North Central') {
                    $north_central_count++;
                }

                if ($row['rda_status'] == 'Processing') {
                    $pending_rda_count++;
                } else if ($row['rda_status'] == 'Approved') {
                    $approved_rda_count++;
                } else if ($row['rda_status'] == 'Declined') {
                    $declined_rda_count++;
                }

                if ($row['insurance_status'] == 'Processing') {
                    $pending_insurance_count++;
                } else if ($row['insurance_status'] == 'Approved') {
                    $approved_insurance_count++;
                } else if ($row['insurance_status'] == 'Declined') {
                    $declined_insurance_count++;
                }
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
    <title>Incident Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&family=Poppins:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/9bc19d88e4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body{
            background-color: #F8F8F8;
        }
        .caption{
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-left: 30px; padding-right: 30px; background-color: #5632D9 !important;">
    <div class="container-fluid row">
        <a class="navbar-brand col-sm-12 col-lg-10 caption" href="police-admin-home.php" style="color: #F8F8F8 !important;">Accident Claim System</a>
        <ul class="desktop navbar-nav ml-auto" style="max-width: fit-content">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="police-admin-home.php"  style="color: #F8F8F8 !important;font-weight: bold;">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="police-submissions.php"  style="color: #F8F8F8 !important;">Submissions</a>
            </li>
        </ul>
    </div>
</nav>
<script>
    window.onload = function(){
    // <block:setup:0>
    const data0 = {
        labels: [
            'Bad Weather',
            'Distractions',
            'Vehicle Failure',
            'Drunk Driving',
            'Speeding',
            'Other'
        ],
        datasets: [{
            label: 'Causes Dataset',
            data: [<?php echo $bad_weather_count ?>, <?php echo $distractions_count ?>, <?php echo $vehicle_failure_count ?>, <?php echo $drunk_driving_count ?>, <?php echo $speeding_count ?>, <?php echo $other_count ?>],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(153, 102, 255)',
                'rgb(255, 159, 64)'
            ],
            hoverOffset: 4
        }]
    };

    // <block:config:0>
    const config0 = {
        type: 'pie',
        data: data0,
    };
    // <block:setup:1>
    const data1 = {
        labels: [
            'Western',
            'Northern',
            'Southern',
            'Eastern',
            'Central',
            'Sabaragamuwa',
            'Uva',
            'North Western',
            'North Central'
        ],
        datasets: [{
            label: 'Provinces Dataset',
            data: [<?php echo $western_count ?>, <?php echo $northern_count ?>, <?php echo $southern_count ?>, <?php echo $eastern_count ?>, <?php echo $central_count ?>, <?php echo $sabaragamuwa_count ?>, <?php echo $uva_count ?>, <?php echo $north_western_count ?>, <?php echo $north_central_count ?>],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(153, 102, 255)',
                'rgb(255, 159, 64)',
                'rgb(255, 130, 132)',
                'rgb(254, 162, 235)',
                'rgb(255, 245, 86)'
            ],
            hoverOffset: 4
        }]
    };

    // <block:config:1>
    const config1 = {
        type: 'pie',
        data: data1,
    };
    // <block:setup:2>
    const data2 = {
        labels: [
            'Pending',
            'Approved',
            'Declined'
        ],
        datasets: [{
            label: 'RDA Dataset',
            data: [<?php echo $pending_rda_count ?>, <?php echo $approved_rda_count ?>, <?php echo $declined_rda_count ?>],
            backgroundColor: [
                'rgb(255, 205, 86)',
                'rgb(54, 162, 235)',
                'rgb(255, 99, 132)'
            ],
            hoverOffset: 4
        }]
    };

    // <block:config:2>
    const config2 = {
        type: 'pie',
        data: data2,
    };
    // <block:setup:3>
    const data3 = {
        labels: [
            'Pending',
            'Approved',
            'Declined'
        ],
        datasets: [{
            label: 'Insurance Dataset',
            data: [<?php echo $pending_insurance_count ?>, <?php echo $approved_insurance_count ?>, <?php echo $declined_insurance_count ?>],
            backgroundColor: [
                'rgb(255, 205, 86)',
                'rgb(54, 162, 235)',
                'rgb(255, 99, 132)'
            ],
            hoverOffset: 4
        }]
    };

    // <block:config:3>
    const config3 = {
        type: 'pie',
        data: data3,
    };

        var ctx0 = document.getElementById("myChart").getContext("2d");
        window.myLine = new Chart(ctx0, config0);

        var ctx1 = document.getElementById("myChart1").getContext("2d");
        window.myLine = new Chart(ctx1, config1);

        var ctx2 = document.getElementById("myChart2").getContext("2d");
        window.myLine = new Chart(ctx2, config2);

        var ctx3 = document.getElementById("myChart3").getContext("2d");
        window.myLine = new Chart(ctx3, config3);
    }
</script>
<div class="container">
    <div class="col-lg-12 col-sm-10 text-light mx-auto pt-5 pb-3 shadow-lg" style="margin-top: 8%; background-color: #5632D9; border-radius: 25px">
            <div class="col-10 mx-auto">
                <div class="row text-center mb-5 mt-3">
                    <h1 class="mt-4 mb-4">Police Dashboard</h1>
                </div>
                <div class="row mb-5 justify-content-center">
                    <div class="col-lg-5 col-sm-10 justify-content-center" style="background: #F8F8F8;border-radius: 25px;padding: 15px;margin: 20px">
                        <label for="accident_causes" class="form-label  caption text-dark pt-2">Accident Causes</label>
                        <canvas id="myChart" style="padding: 15px"></canvas>
                    </div>
                    <div class="col-lg-5 col-sm-10 justify-content-center" style="background: #F8F8F8;border-radius: 25px;padding: 15px;margin: 20px">
                        <label for="accident_causes" class="form-label  caption text-dark pt-2">Accident Provinces</label>
                        <canvas id="myChart1" style="padding: 15px"></canvas>
                    </div>
                </div>
                <div class="row mb-5 justify-content-center">
                    <div class="col-lg-5 col-sm-10 justify-content-center" style="background: #F8F8F8;border-radius: 25px;padding: 15px;margin: 20px">
                        <label for="accident_causes" class="form-label  caption text-dark pt-2">RDA Status</label>
                        <canvas id="myChart2" style="padding: 15px"></canvas>
                    </div>
                    <div class="col-lg-5 col-sm-10 justify-content-center" style="background: #F8F8F8;border-radius: 25px;padding: 15px;margin: 20px">
                        <label for="accident_causes" class="form-label  caption text-dark pt-2">Insurance Status</label>
                        <canvas id="myChart3" style="padding: 15px"></canvas>
                    </div>
                </div>
            </div>
        <div class="row justify-content-end">
            <div class="col-lg-2 col-sm-3">
                <a class="btn btn-danger" style="margin-left: 10px" href="./controllers/handle-logout.php">Log Out</a>
            </div>
        </div>
    </div>
</div>
<footer class="text-center text-white mt-5" style="background-color: #5632D9">
    <div class="text-center p-3" style="background-color: #6038F2">
        © 2022 Copyright
    </div>
</footer>
</body>
</html>