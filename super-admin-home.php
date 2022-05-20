<?php
session_start();

if ($_SESSION['user_id'] && $_SESSION['user_id'] != '' && $_SESSION['user_role'] == 'super_admin') {

    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_role = $_SESSION['user_role'];

    $conn = "";
    require_once('./config/connection.php');

    $sql = mysqli_query($conn,"SELECT * FROM Users WHERE email = '$user_email'");
    $result_user=mysqli_fetch_array($sql);

    //define total number of results you want per page
    $results_per_page = 10;

    //find the total number of results stored in the database
    $user_id_string = (string)($user_id);
    $queryT = "SELECT * FROM Users WHERE role = 'police_admin' OR role = 'rda_admin' OR role = 'insurance_admin'";
    $result = mysqli_query($conn, $queryT);
    $number_of_result = mysqli_num_rows($result);

    //determine the total number of pages available
    $number_of_page = ceil ($number_of_result / $results_per_page);

    //determine which page number visitor is currently on
    if (!isset ($_GET['page']) ) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    //determine the sql LIMIT starting number for the results on the displaying page
    $page_first_result = ($page-1) * $results_per_page;

    if ($result_user){

        if($result_user['role']!=$user_role){
            header("Location: ./controllers/handle-logout.php");
        }
        $sql = "SELECT * FROM Users  WHERE role = 'police_admin' OR role = 'rda_admin' OR role = 'insurance_admin' LIMIT ".$page_first_result.",".$results_per_page;
        $result_d = mysqli_query($conn, $sql);
        if (!isset ($_GET['search']) ) {
            $sql = "SELECT * FROM Users  WHERE role = 'police_admin' OR role = 'rda_admin' OR role = 'insurance_admin' LIMIT ".$page_first_result.",".$results_per_page;
            $result_d = mysqli_query($conn, $sql);
        } else {
            $search = $_GET['search'];
            $sql = "SELECT * FROM Users WHERE role = '$search' OR email = '$search' OR fname = '$search' OR lname = '$search' LIMIT ".$page_first_result.",".$results_per_page;
            $result_d = mysqli_query($conn, $sql);
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
    <title>Super Admin Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&family=Poppins:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/9bc19d88e4.js" crossorigin="anonymous"></script>
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
        <a class="navbar-brand col-sm-12 col-lg-10 caption" href="super-admin-home.php" style="color: #F8F8F8 !important;">Accident Claim System</a>
        <ul class="desktop navbar-nav ml-auto" style="max-width: fit-content">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="super-admin-home.php"  style="color: #F8F8F8 !important;font-weight: bold;">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add-users.php"  style="color: #F8F8F8 !important;">Add User</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="col-lg-12 col-sm-10 text-light mx-auto pt-5 pb-3 shadow-lg" style="margin-top: 8%; background-color: #5632D9; border-radius: 25px">
        <form>
            <div class="col-10 mx-auto">
                <div class="row text-center mb-5 mt-3">
                    <h1 class="mt-4 mb-4">Administrator Details</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-10 col-sm-10 mb-2">
                        <div class="row">
                            <div class="col-lg-9 col-sm-6" style="margin-top: 32px">
                                <input class="form-control mr-sm-2" name="search" type="text" aria-label="Search" placeholder="Search (Name/Email/Role)">
                            </div>
                            <div class="col-lg-3 col-sm-4" style="margin-top: 32px">
                                <button class="btn btn-outline-light w-100" type="submit"><i class="fas fa-search" style="padding-right: 30px"></i>Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="table-responsive">
                    <table class="table table-light shadow-lg table-bordered" style="margin-top: 8%; margin-top: 8%;">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" style="min-width: 150px">User ID</th>
                            <th scope="col" style="min-width: 150px">NIC</th>
                            <th scope="col" style="min-width: 150px">First Name</th>
                            <th scope="col" style="min-width: 150px">Last Name</th>
                            <th scope="col" style="min-width: 150px">E-Mail</th>
                            <th scope="col" style="min-width: 150px">Mobile No</th>
                            <th scope="col" style="min-width: 150px">Role</th>
                            <th scope="col" style="min-width: 150px">Date of Birth</th>
                            <th scope="col" style="min-width: 150px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (mysqli_num_rows($result_d) > 0) {
                            $sn = 1;
                            while($row = mysqli_fetch_assoc($result_d)) {
                                echo '<tr>
                                <th scope="row">'.$sn.'</th>
                                <td>'.$row["id"].'</td>
                                <td>'.$row["nic"].'</td>
                                <td>'.$row["fname"].'</td>
                                <td>'.$row["lname"].'</td>
                                <td>'.$row["email"].'</td></td>
                                <td>'.$row["mobile"].'</td>
                                <td>'.$row["role"].'</td>
                                <td>'.$row["dob"].'</td>
                                <td class="d-flex" style="min-width: 500px">
                                <a class="btn btn-primary w-100" style="margin: 10px" href="./edit-users.php?id='.$row["id"].'"><i class="fa fa-eye me-2"></i>Edit</a>
                                <a class="btn btn-danger w-100" style="margin: 10px"   href="./controllers/handle-declines.php?id='.$row["id"].'"><i class="fa fa-circle-xmark me-2"></i>Delete</a>
                                </td>
                                </tr>';
                                $sn++;
                            }
                        }else{
                            echo '<tr>
                            <th scope="row">No Data</th>
                            <td>No Data</td>
                            <td>No Data</td>
                            <td>No Data</td>
                            <td>No Data</td>
                            <td>No Data</td>
                            <td>No Data</td>
                            <td>No Data</td>
                            <td>No Data</td>
                            </tr>';
                        }
                        ?>
                        <tr><td colspan="10">
                                <?php
                                for($page = 1; $page<= $number_of_page; $page++) {
                                    echo "&nbsp;".'<a href = "?page=' . $page . '"class="btn btn-outline-dark btm-sm">' . $page . ' </a>'."&nbsp;";
                                }
                                ?>
                            </td></tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </form>
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
<script>

</script>
</body>
</html>