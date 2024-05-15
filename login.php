<?php    
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    require 'config.php';
    session_start();
    
    if(isset($_POST['login-btn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $lekerdezes = "SELECT * FROM users WHERE email='$email'";
        $talalt_fh = $conn->query($lekerdezes);

        
        if(mysqli_num_rows($talalt_fh) == 1){

            $felhasznalo = $talalt_fh->fetch_assoc();
            $hashpass = $felhasznalo['hashpass'];
            if(password_verify($password, $hashpass)){

                if(mysqli_num_rows($talalt_fh) == 1){
                    setcookie('user_id',$felhasznalo['user_id'],time()+360000,'/');
                    header("Location: index.php");
                    
                }
                else{
                    echo "<script>alert('Nem jó a felhasználó, vagy a jelszó!')</script>";
                }
            }
            else{
                echo "<script>alert('Nem jó az email cím, vagy a jelszó!')</script>";
            }
        }else{
            echo "<script>alert('Nincs ilyen felhasználó!')</script>";
        }
    }   
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Petőcz Boglárka, Gémes Lilla">
    <meta name="description" content="Bejelentkezés a Perselyed oldalra. Kövesd nyomon megtakarításaidat, és érd el pénzügyi céljaidat!">
    <meta name="keywords" content="bejelentkezés, belépés, pénzügyi oldal, megtakarítás">
    <link rel="stylesheet" href="Mycss/log.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <title>Bejelentkezés</title>
</head>

<body>
    
<div class="container">
    <h1>Bejelentkezés</h1>
    <form action="login.php" method="post">
      <div class="registration-form">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="email" id="email" required>
        <label for="password">Jelszó:</label>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <input type="submit" value="Bejelentkezés" name="login-btn">
        <div class="registration-form">
		  <a href="registration.php"><button type="button" class="registration-button">Regisztráció</button></a>
		  <a href="password_change/send_token.php"><button type="button" class="forgot-button">Elfelejtette a jelszavát?</button></a>
		</div>
      </div>
    </form>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
