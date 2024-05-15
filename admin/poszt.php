<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../config.php";
if(isset($_SESSION['admin_name'])) {
    $un = $_SESSION['admin_name'];
} else {
    header('Location: login.php');
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date = date("Y-m-d H:i:s");
    $text = $_POST['text'];
    $title = $_POST['title'];
    $title2= $_POST['title2'];
    $category= $_POST['category'];
    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../blog/assets/images/';
        $uploadedFileName = $_FILES['image']['name'];
        $uploadedFile = $uploadDir . uniqid() . '_' . $uploadedFileName;
		
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $uploadedFileName)) {
            $sql = "INSERT INTO blog (date, text, title, title2, category, image,admin) VALUES ('$date', '$text', '$title', '$title2', '$category', '$uploadedFileName','$un')";
            if ($conn->query($sql)) {
				echo "Sikeres feltöltés.";
            
            } else {
                echo "Hiba történt az adatbázisban.";
            }
        } else {
            echo "A fájl feltöltése sikertelen.";
        }
    } else {
        echo "Hiba történt a fájl feltöltése során.";
    }
}
$stmt = $conn->prepare("SELECT * FROM messages ORDER BY date  DESC LIMIT 5");
    $stmt->execute();
    $message =$stmt->get_result();
    if(isset($_SESSION['admin_name'])) {
        $un = $_SESSION['admin_name'];
    } else {
        header('Location: login.php');
    }

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
                <div class="bg-secondary text-center rounded p-4">
                <h2>Poszt létrehozása</h2><br><br>
                <form method="post" action="poszt.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="col-sm-2 col-form-label">Poszt címe</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="title2" class="form-label">Poszt alcíme</label>
                        <input type="text" name="title2" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="text" class="form-label">Szöveg</label>
                        <textarea name="text" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Dátum</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputState"class="form-label">Kategória</label>
                        <select id="inputState" class="form-select" name="category" require>
                        <option selected>Válassz</option>
                        <option>Könyv</option>
                        <option>Befektetés</option>
                        <option>tipp</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Kép</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Létrehozás</button>
                </form>
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