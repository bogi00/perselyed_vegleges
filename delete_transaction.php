<?php
session_start();
require 'config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
print_r($_POST);


if(isset($_POST['id'])){
    $id = $_POST["id"];
   

$sql = "DELETE FROM tranzakcio WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0) {
        echo "A tranzakció sikeresen törölve lett!";
    } else {
        http_response_code(400);
        echo "A tranzakció törlése sikertelen!";
    }
} else {
    http_response_code(400);
    echo "Hibás kérés - hiányzó adatok!";
}

$conn->close();
?>