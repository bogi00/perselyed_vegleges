<?php
session_start();
require 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
print_r($_POST);
$_COOKIE['id']=$user_id;

if (!empty($_POST["names"]) && !empty($_POST["amount"]) && !empty($_POST["dates"]) && !empty($_POST["selected_type"])) {
    $type = $_POST["selected_type"];
    $name = $_POST["names"];
    $amount = $_POST["amount"];
     $dates = date('Y-m-d', strtotime($_POST["dates"]));
		
		if($type=="kiadas"){$amount0="-".$amount;}
		if($type=="bevetel"){$amount0=$amount;}
    $sql = "INSERT INTO tranzakcio (user_id, name, amount, dates, type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiss", $_COOKIE['user_id'], $name, $amount0, $dates, $type);
    $stmt->execute();
    $result = mysqli_query($conn, "SELECT amount FROM tranzakcio WHERE user_id='1' limit 6");
    $transactionList = "";
    while ($row = $result->fetch_assoc()) {
        $transactionList .= $row['amount'] . "<br>";
    }
    
} else {
    http_response_code(400);
    echo "Hibás kérés - hiányzó adatok!";
}

$conn->close();
?>