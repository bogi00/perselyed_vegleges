<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    require '../config.php';
    session_start();
    $stmt = $conn->prepare("SELECT * FROM messages ORDER BY date  DESC LIMIT 5");
    $stmt->execute();
    $message =$stmt->get_result();
    if(isset($_SESSION['admin_name'])) {
        $un = $_SESSION['admin_name'];
    } else {
        header('Location: login.php');
    }

$sql = "SELECT * FROM admin_func WHERE id = '1'";	 
$result = $conn->query($sql);	
while($row = $result->fetch_assoc()) 
{
$num=$row['klikk_index'];	
}

$sql0 = "SELECT * FROM admins WHERE 1";	 
$result1 = $conn->query($sql0);	
$num1=$result1->num_rows ;

$sql0 = "SELECT * FROM blog WHERE 1";	 
$result1 = $conn->query($sql0);	
$num2=$result1->num_rows ;

$sql0 = "SELECT * FROM users WHERE 1";	 
$result1 = $conn->query($sql0);	
$num3=$result1->num_rows ;



?>
<!DOCTYPE html>
<html lang="hu">

<head>
<meta charset="utf-8">
    <title>Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="admin" name="description">
    <meta content="admin, kezelőfelület" name="keywords">
    <meta name="robots" content="index, follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <?php require "slidebar.php";?>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-1 col-xl-4">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Regisztráltak száma</p>
                                <h6 class="mb-0"><?php echo $num3; ?> db</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Postok száma</p>
                                <h6 class="mb-0"><?php echo $num2; ?> db</h6>
                            </div>
                        </div>
                    </div>
					<div class="col-sm-6 col-xl-4">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Adminok száma</p>
                                <h6 class="mb-0"><?php echo $num1; ?> db</h6>
                            </div>
                        </div>
                    </div>s
					<div class="col-sm-6 col-xl-4">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Oldal megnyitások száma</p>
                                <h6 class="mb-0"><?php echo $num;?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="js/main.js"></script>
</body>

</html>