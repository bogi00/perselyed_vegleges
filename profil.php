<?php
session_start();
require("config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $username = $row['username'];
	$img = $row['profile_image'];
} else {
    header("location: login.php");
}
if(isset($_POST['profil_csere'])) {
    if(isset($_FILES['new_img']) && $_FILES['new_img']['error'] === 0) {
        $uploadsDir = 'images/';
        $tempName = $_FILES['new_img']['tmp_name'];
        $fileName = $_FILES['new_img']['name'];
        $filePath = $uploadsDir . $fileName;
        if(move_uploaded_file($tempName, $filePath)) {
            $update_query = "UPDATE users SET profile_image = ? WHERE user_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("si", $filePath, $user_id);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Hiba történt a kép feltöltése során.";
        }
    }
}
if(isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $hashed_password = $row['hashpass'];
    if(password_verify($old_password, $hashed_password)) {
        if($new_password === $confirm_password) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET hashpass = ? WHERE user_id = ?"; 
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("si", $hashed_new_password, $user_id);
            $stmt->execute();
            $stmt->close();
            echo "<script>alert('Sikeres jelszócsere!');</script>";
        } else {
            echo "<script>alert('Az új jelszavak nem egyeznek meg.');</script>";
        }
    } else {
        echo "<script>alert('Hibás régi jelszó.');</script>";
    }
}
if(isset($_POST['change_email'])) {
    $new_email = $_POST['new_email'];
    $password = $_POST['email_password'];
    if(password_verify($password, $row['hashpass'])) {
        $check_query = "SELECT * FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $new_email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
		
        
        if($new_email === $row['email']) {
            echo '<script>alert("Az új email cím megegyezik a régi email címmel.");</script>';
        } else {
            if($check_result->num_rows > 0) {
                echo '<script>alert("Ezzel az email címmel már regisztráltak!");</script>';
            } else {
                $update_query = "UPDATE users SET email = ? WHERE user_id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("si", $new_email, $user_id);
                $stmt->execute();
                $stmt->close();
                echo '<script>alert("Sikeres email csere!");</script>';
            }
        }
    } else {
        echo '<script>alert("Hibás jelszó!");</script>';
    }
}
if(isset($_POST['change_user'])) {
    $new_user = $_POST['new_username'];
    $password = $_POST['pass_user'];
    if(password_verify($password, $row['hashpass'])) {
        $check_query = "SELECT * FROM users WHERE username = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $new_email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
		
        
        if($new_user === $row['username']) {
            echo '<script>alert("Az új felhasználónév cím megegyezik a régivel.");</script>';
        } else {
            if($check_result->num_rows > 0) {
                echo '<script>alert("Ezzel az felhasználónévvel már regisztráltak!");</script>';
            } else {
                $update_query = "UPDATE users SET username = ? WHERE user_id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("si", $new_user, $user_id);
                $stmt->execute();
                $stmt->close();
                echo '<script>alert("Sikeres felhasználónév csere!");</script>';
            }
        }
    } else {
        echo '<script>alert("Hibás jelszó!");</script>';
    }
}
?>

 <!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Perselyed</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="keywords" content="persely, tranzakciókezelő, pénzügyek, kiadások, bevétel, megtakaritás, tudatos">
    <meta name="description" content="A perselyed  segítségével könnyedén nyomon követheti megtakaritásait,kiadásait és bevételeit. Adja hozzá új tranzakcióit és tekintse meg az összes tranzakciót az oldalon.Hozd létre a virtuális perselyed és gyűjts. ">
    <meta name="author" content="Petőcz Boglárka, Gémes Lilla">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body class="main-layout">

    <div id="mySidepanel" class="sidepanel">
        <?php include("sidenav.php"); ?>
    </div>
	
    <header id="navbar">
        <?php include("nav.php"); ?>
    </header>
	
	<div class="container rounded bg-white mt-5 mb-5">
	<div class="row mt-2 algin-center">
                    <h4 class="text-center prof">Profil szerkesztés</h4>
					<h2 class="text-dark text-center udv">Üdv <?php echo $username; ?>!</h2>
                </div>
    <div class="row">
        <div class="col-md-4">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                
                <div class="rounded-circle mt-5" style="width: 150px; height: 150px; overflow: hidden;">
                    <img class="w-100 h-100 align-items-center" src="<?php echo $img; ?>" style="object-fit: cover; border-radius: 50%;">
                </div>

                <form method="post" action="" enctype="multipart/form-data" class="mt-4">
                    <div class="mb-3">
                        <input type="file" name="new_img" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="profil_csere" class="btn btn-primary csere" value="Profilkép csere">
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-7 prof">
            <div class="p-3 py-5">
				<form method="post" action="" class="mt-2">
					<div class="row mt-5 text-center">
						<p>Jelszó csere</p>
					</div>
					<div class="row mt-2">
						<div class="col-md-4">
							<label class="labels"></label>
							<input type="password" name="old_password" class="form-control" placeholder="Régi jelszó">
						</div>
						<div class="col-md-4">
							<label class="labels"></label>
							<input type="password" name="new_password" class="form-control" placeholder="Új jelszó">
						</div>
						<div class="col-md-4">
							<label class="labels"></label>
							<input type="password" name="confirm_password" class="form-control" placeholder="Új jelszó újra">
						</div>
					</div>
					<div class="mt-5 text-center">
						<button class="btn btn-primary profile-button" type="submit" name="change_password">Jelszó csere</button>
					</div>
				</form>	
				<form method="post" action="">
					<div class="row mt-5 text-center">
						<p>Email csere</p>
					</div>
					<div class="row mt-2">
						<div class="col-md-8">
							<label class="labels"></label>
							<input type="text" class="form-control"name="new_email" placeholder="Új email" value="">
						</div>
						<div class="col-md-4">
							<label class="labels"></label>
							<input type="text" class="form-control" name="email_password" value="" placeholder="Jelszó">
						</div>
					</div>
					<div class="mt-5 text-center">
						<button class="btn btn-primary profile-button" type="submit" name="change_email">Email csere</button>
					</div>
				</form>
				</form>
            
				<form method="post" action="">
					<div class="row mt-3">
						<div class="mt-5 text-center"><p>Felhasználó név csere</p></div>
						<div class="col-md-6">
							<label class="labels"></label>
							<input type="email" class="form-control"name="new_username" placeholder="új felhasználó név" value=""></div>
						<div class="col-md-6">
							<label class="labels"></label>
							<input type="password" class="form-control"  name="pass_user"placeholder="jelszó">
						</div>
						<div class="mt-5 text-center">
							<button class="btn btn-primary profile-button" name="change_user" type="submit">Felhasználó név csere</button>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>

    <footer>
        <?php include("footer.php") ?>
    </footer>
<style>
	.profile-button,
.csere {
    background: #3366cc;
    box-shadow: none;
    border: none;
}

.profile-button:hover,
.csere:hover {
    background: #4d7bb0;
}

.profile-button:focus,
.profile-button:active,
.csere:focus,
.csere:active {
    background: #265999;
    box-shadow: none;
}

.back:hover {
    color: #3366cc;
    cursor: pointer;
}

.labels {
    font-size: 11px;
}

.add-experience:hover {
    background: #4d7bb0;
    color: #fff;
    cursor: pointer;
    border: solid 1px #4d7bb0;
}

.prof h4 {
    color: #3366cc !important;
    background-color: unset;
}

.prof p {
    color: #3366cc !important;
    text-decoration: underline;
    padding-top: 8%;
    padding-bottom: 3%;
    font-size: 23px;
}

.udv {
    padding-top: 3%;
}

	</style>
	<script src="js/bootstrap.bundle.min.js "></script>
	<script src="js/custom.js "></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
	<script>
		document.getElementsByTagName('html')[0].addEventListener("click", closeNav);
	</script>
 </body>
</html>
