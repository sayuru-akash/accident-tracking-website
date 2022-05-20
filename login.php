<?php
session_start();

if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&family=Poppins:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/9bc19d88e4.js" crossorigin="anonymous"></script>
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
    <div class="col-lg-6 text-light mx-auto pt-5 pb-2 shadow-lg" style="margin-top: 8%; background-color: #5632D9; border-radius: 25px;">
        <div class="row justify-content-end">
            <div class="col-lg-3 col-sm-3">
                <a class="btn btn-outline-light" style="margin-left: 10px" href="signup.php">Register</a>
            </div>
        </div>
        <form action="./controllers/handle-login.php" method="post" name="login-form" onsubmit="return validateForm();">
            <div class="col-10 mx-auto">
                <div class="row text-center mb-5 mt-5">
                    <h1>Log In</h1>
                </div>
                <div class="row mb-5 my-auto">
                    <div class="mb-4">
                        <label for="email" class="form-label  caption">Email address</label>
                        <input type="email" class="form-control" placeholder="example@email.com" name="email">
                    </div>
                    <div class="mb-4">
                        <label for="pwd" class="form-label caption">Password</label>
                        <input type="password" class="form-control" placeholder="enter your password" name="pwd">
                    </div>
                    <button type="submit" class="btn btn-outline-light col-11 mx-auto caption fs-4 mt-5">Log In</button>
<!--                    <a href="#" class="link-light col-10 mx-auto pt-4 text-center">Forgot Password?</a>-->
                </div>
            </div>
        </form>
        <div class="row justify-content-end mb-4">
            <i class="fa-solid fa-car-burst col-lg-8 col-sm-12" style="font-size: 250px"></i>
        </div>
    </div>
</div>
<footer class="text-center text-white mt-5" style="background-color: #5632D9">
    <div class="text-center p-3" style="background-color: #6038F2">
        © 2022 Copyright
    </div>
</footer>
<script>
    function validateForm(){
        var email = document.forms["login-form"]["email"].value;
        var pwd = document.forms["login-form"]["pwd"].value;
        if(email == "" || pwd == ""){
            alert("Please fill all the fields");
            return false;
        }
    }
</script>
</body>
</html>
