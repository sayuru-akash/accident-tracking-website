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
        if($result['role']!=$user_role){
            header("Location: ./controllers/handle-logout.php");
        }
    }else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}else{
    header('Location: login.php');
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Home</title>
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
<div class="container mb-5">
    <div class="col-lg-11 col-sm-10 text-light mx-auto pt-5 pb-5 shadow-lg" style="margin-top: 8%; background-color: #5632D9; border-radius: 25px;">
        <div class="col-8 mx-auto mb-5">
            <div class="row text-center mb-5 mt-5">
                <h1 class="mt-4 mb-4 fs-1">Hi, <?php echo $user_name ?>!</br> Welcome to the Accident Report Portal</h1>
            </div>
            <div class="row justify-content-center mb-5 pt-3 pb-3">
                <div class="col-lg-7 col-sm-10">
                    <a class="btn btn-outline-light w-100 caption fs-3 mb-4" href="check-report-status.php" style="text-align: left !important;"><i class="bi bi-clipboard-check" style="padding-right: 30px"></i>Check Report Status</a>
                </div>
                <div class="col-lg-7 col-sm-10">
                    <a class="btn btn-outline-light w-100 caption fs-3 mb-4 mt-3" href="register-vehicle.php" style="text-align: left !important;"><i class="bi bi-clipboard-check" style="padding-right: 30px"></i>Register a New Vehicle</a>
                </div>
                <div class="col-lg-7 col-sm-10">
                    <a class="btn btn-outline-light w-100 caption fs-3 mt-3 mb-4" href="report-new-incident.php" style="text-align: left !important;"><i class="bi bi-clipboard-check" style="padding-right: 30px"></i>Report New Incident</a>
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
<footer class="text-center text-white" style="background-color: #5632D9">
    <div class="text-center p-3" style="background-color: #6038F2">
        © 2022 Copyright
    </div>
</footer>
</body>
</html>