<?php
session_start();

if ($_SESSION['user_id'] && $_SESSION['user_id'] != '' && $_SESSION['user_role'] == 'rda_admin') {

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
    $queryT = "SELECT * FROM Incidents";
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



        if (!isset ($_GET['submission_filter']) ) {
            $sql = "SELECT * FROM Incidents LIMIT ".$page_first_result.",".$results_per_page;
            $result_data = mysqli_query($conn, $sql);
        } else {
            $search = $_GET['submission_filter'];
            if ($search == "all"){
                $sql = "SELECT * FROM Incidents LIMIT ".$page_first_result.",".$results_per_page;
                $result_data = mysqli_query($conn, $sql);
            }else{
                $sql = "SELECT * FROM Incidents WHERE rda_status = '$search' LIMIT ".$page_first_result.",".$results_per_page;
                $result_data = mysqli_query($conn, $sql);
            }
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
        <a class="navbar-brand col-sm-12 col-lg-10 caption" href="rda-admin-home.php" style="color: #F8F8F8 !important;">Accident Claim System</a>
        <ul class="desktop navbar-nav ml-auto" style="max-width: fit-content">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="rda-admin-home.php"  style="color: #F8F8F8 !important;font-weight: bold;">Home</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="col-lg-12 col-sm-10 text-light mx-auto pt-5 pb-3 shadow-lg" style="margin-top: 8%; background-color: #5632D9; border-radius: 25px">
        <form>
            <div class="col-10 mx-auto">
                <div class="row text-center mb-5 mt-3">
                    <h1 class="mt-4 mb-4">Submissions</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-10 col-sm-10 mb-2">
                        <div class="row">
                            <div class="col-lg-9 col-sm-6" style="margin-top: 32px">
                                <select name="submission_filter" class="form-control">
                                    <option value="all" selected>All</option>
                                    <option value="approved">Approved</option>
                                    <option value="processing">Pending</option>
                                    <option value="declined">Declined</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-4" style="margin-top: 32px">
                                <button class="btn btn-outline-light w-100" type="submit"><i class="fas fa-search" style="padding-right: 30px"></i>Filter</button>
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
                                <th scope="col" class="align-middle" style="min-width: 150px">Driver Licence No</th>
                                <th scope="col" class="align-middle" style="min-width: 150px">Driver Name</th>
                                <th scope="col" class="align-middle" style="min-width: 150px">Vehicle No</th>
                                <th scope="col" class="align-middle" style="min-width: 150px">Entry Date & Time</th>
                                <th scope="col" class="align-middle" style="min-width: 150px">RDA Status</th>
                                <th scope="col" class="align-middle" style="min-width: 150px">Police Status</th>
                                <th scope="col" class="align-middle" style="min-width: 150px">Insurance Status</th>
                                <th scope="col" class="align-middle" style="min-width: 150px">RDA Passed?</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (mysqli_num_rows($result_data) > 0) {
                                $sn = 1;
                                while($row = mysqli_fetch_assoc($result_data)) {
                                    echo '<tr>
                                <th scope="row">'.$sn.'</th>
                                <td>'.$row["driver_licence"].'</td>
                                <td>'.$row["driver_name"].'</td>
                                <td>'.$row["vehicle_number"].'</td>
                                <td>'.$row["entry_datetime"].'</td>
                                <td>'.$row["rda_status"].'</td></td>
                                <td>'.$row["police_status"].'</td>
                                <td>'.$row["insurance_status"].'</td>
                                <td class="d-flex" style="min-width: 800px">
                                <a class="btn btn-primary w-100" style="margin: 10px" href="./report-details.php?id='.$row["incident_id"].'"><i class="fa fa-eye me-2"></i>View</a>
                                <a class="btn btn-success w-100" style="margin: 10px"  href="./controllers/handle-approves.php?id='.$row["incident_id"].'"><i class="fa fa-circle-check me-2" ></i>Approve</a>
                                <a class="btn btn-danger w-100" style="margin: 10px"  href="./controllers/handle-declines.php?id='.$row["incident_id"].'"><i class="fa fa-circle-xmark me-2"></i>Decline</a>
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
                            <tr><td colspan="9">
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