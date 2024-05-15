<?php
session_start();

require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
        $goal_name = $_POST["goal_name"];
        $goal_amount = $_POST["goal_amount"];
        $current_amount = $_POST["current_amount"];

        $sql = "INSERT INTO expens (user_id, goal_name,goal_amount, current_amount ) VALUES ('$id', '$goal_name', '$goal_amount','$current_amount')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Költség sikeresen mentve!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Hiba a költség mentése során: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Nem vagy bejelentkezve!"]);
    }
}
$conn->close();
?>
