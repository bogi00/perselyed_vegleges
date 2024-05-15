<?php
require 'config.php';

if(isset($_POST['reg-btn'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $hashpass = password_hash($password, PASSWORD_BCRYPT);
    $profile_image = '';

    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0){
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($_FILES['profile_image']['name']); 
        $imageFileType = strtolower(pathinfo($upload_file,PATHINFO_EXTENSION));
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        if(in_array($imageFileType, $allowed_extensions)){
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_file);
            $profile_image = $upload_file;
        }
    }
	if($profile_image == ""){
            $profile_image = "default_profile_image.svg";
        }
    $query_username = "SELECT * FROM users WHERE username='$username'";
    $result_username = $conn->query($query_username);

    $query_email = "SELECT * FROM users WHERE email='$email'";
    $result_email = $conn->query($query_email);

    if(mysqli_num_rows($result_username) == 0 && mysqli_num_rows($result_email) == 0){
        $conn->query("INSERT INTO users (username, hashpass, email, profile_image) VALUES ('$username','$hashpass','$email','$profile_image')");
        header("Location: login.php");
    } elseif(mysqli_num_rows($result_username) > 0) {
        echo "<script>alert('Már létezik ilyen nevű felhasználó!')</script>";
    } elseif(mysqli_num_rows($result_email) > 0) {
        echo "<script>alert('Már létezik ilyen email-cím!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Regisztrálj a Perselyed Pénzügyi Oldalra és kezdd el nyomon követni megtakarításaidat. Állítsd be céljaidat, kövesd nyomon a fejlődést és érd el pénzügyi célokat!">
    <meta name="keywords" content="regisztráció, pénzügyi oldal, megtakarítás, cél, pénzügyi tervezés">
	<link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="author" content="Petőcz Boglárka, Gémes Lilla">
    <link rel="stylesheet" href="Mycss/regist.css">
    <title>Regisztráció</title>
</head>

<body>
    <div class="container">
        <h1>Regisztráció</h1>
        <form action="registration.php" method="post" enctype="multipart/form-data">
            <div class=registration-form>
                <label for="username">Felhasználónév:</label>
                <input type="text" name="username" placeholder="Username" id="username" required>
                <label for="password">Jelszó:</label>
                <input type="password" name="password" placeholder="Password" id="password" required>
                <label for="email">Email cím:</label>
                <input type="email" name="email" placeholder="Email" id="email" required>
                <label for="profile_image">Profilkép feltöltése:</label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*">
                <input type="submit" value="Regisztráció" name="reg-btn"> 
                <a href="login.php"><p class="reg-href">Van már fiókom!</p></a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php
                    $user_id = $_SESSION['user_id'];
                    $query = "SELECT profile_image FROM users WHERE id = $user_id";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $profile_image = $row['profile_image'];
                    }
                    ?>

                    <?php if (!empty($profile_image)): ?>
                        <img src="<?php echo $profile_image; ?>" alt="Profilkép">
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </form> 
    </div>
</body>
</html>