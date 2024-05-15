<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../config.php';

if(isset($_POST["send"])) {

    generateAndSaveToken($conn);

}

function generateAndSaveToken($con){
    $token = getRandomStringMd5();

    $email = $_POST["email"];

    $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) == 0) {
        echo "Nem létező email címet adtál meg!";
        return;
    }

    $result = mysqli_query($con, "INSERT INTO password_resets (email, token) VALUE ('$email', '$token')");

    if ($result) {
        sendMail($token);
    } else {
        echo "Hiba történt!";
    }

}

function getRandomStringMd5($length = 8)
{
    $string = md5(rand());
    $randomString = substr($string, 0, $length);
    return $randomString;
}

function sendMail($token)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'infoperselyed@gmail.com';
    $mail->Password = 'asju wblv baej delq';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ));

    $mail->setFrom("infoperselyed@gmail.com");
    $mail->addAddress($_POST["email"]);
    $mail->Subject = "Password Reset";
    $mail->Body = "A jelszó megváltoztatásához az alábbi kódot használja. A kód 20 percig érvényes.<br><br> <h3>$token</h3>";
    $mail->IsHTML(true);

    try {

        $mail->send();
        header("Location: validate_token.php");

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <h1>Forgot Password</h1>

    <form method="post">

    <div class="col-md-12 mb-3">
                <label for="email" class="form-label">Email cím</label>
                <input type="email" class="form-control" id="email" name="email" aria-label="Email cím megadása" required>
              </div>
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary" name="send" value="Küldés" aria-label="Küldés">Küldés</button>

    </form>

</body>
</html>
