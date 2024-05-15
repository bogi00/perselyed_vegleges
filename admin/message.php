<?php
session_start();
require "../config.php";

    $stmt = $conn->prepare("SELECT * FROM messages ORDER BY date  DESC LIMIT 5");
    $stmt->execute();
    $message =$stmt->get_result();
    if(isset($_SESSION['admin_name'])) {
        $un = $_SESSION['admin_name'];
    } else {
        header('Location: login.php');
    }
    $stmt = $conn->prepare("SELECT * FROM messages ORDER BY date DESC");
    $stmt->execute();
    $uzenetek =$stmt->get_result();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <?php include("slidebar.php");?>
  
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center te rounded p-4">
                <?php while($row = $uzenetek->fetch_assoc()) { ?>
                    <div class="card mb-3 uzenet-doboz ">
                        <div class="card-header">
                            <h5 class="card-title ">Üzenet</h5>
                            <div class="d-flex justify-content-between">
                                <p class="card-text text-muted email-cim"><?= $row['email'] ?></p>
                                <p class="card-text text-muted datum"><?= $row['date'] ?></p>
                            </div>
                        </div>
                            <div class="card-body uzenet-szoveg">
                                <p class="card-text"><?= $row['message'] ?></p>
                            </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-danger btn-sm torles-gomb" onclick="torolUzenet()">Törlés</button>
                        </div>
                    </div>
                    <?php }?>
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