<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "book_manager";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die(json_encode([
        "success" => 0,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}
?>