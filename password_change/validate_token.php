<?php
require_once("../config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
        $token = $_POST['token'];
        $new_password = $_POST['new_password'];
        
        $sql = "SELECT email, created_at FROM password_resets WHERE token = '$token'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $date = strtotime($row["created_at"]);
            $email = $row["email"];
            $now = time();
            $difference = $now - $date;
            $minutesDifference = floor($difference / 60);
            $hashpass = password_hash($new_password, PASSWORD_BCRYPT);
            
            if ($minutesDifference <= 300) {
                $result = mysqli_query($conn, "UPDATE users SET hashpass='$hashpass' WHERE email='$email'");
                if($result) {
                    header("Location: ../login.php");
                    exit();
                } else {
                    echo "Hiba történt!";
                }
            } else {
                header("Location: send_token.php");
                exit();
            }
        } else {
            echo "Nincs találat a megadott kódhoz.";
        }

}


?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Mycss/regist.css">
    <title>Elfelejtett jelszó</title>
</head>
<body>
<div class="container">
    <h1>Jelszó megváltoztatása</h1>
    <form class="" action="" method="post">
        <div class="col-md-12 mb-3">
            <label for="text" class="form-label">Emailben kapott kód:</label>
            <input type="text" class="form-control" name="token" required>
            <label for="new_password">Új jelszó:</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="send">Küldés</button>
    </form>
</div>
</body>
</html>
