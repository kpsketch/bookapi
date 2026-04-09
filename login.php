<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db.php';

$postData = json_decode(file_get_contents("php://input"), true);

if (!isset($postData['data'])) {
    echo json_encode([
        "success" => 0,
        "message" => "No input data received"
    ]);
    exit();
}

$email = $conn->real_escape_string($postData['data']['email']);
$password = $conn->real_escape_string($postData['data']['password']);

if (empty($email) || empty($password)) {
    echo json_encode([
        "success" => 0,
        "message" => "Email and password are required."
    ]);
    exit();
}

$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    echo json_encode([
        "success" => 1,
        "message" => "Login successful",
        "data" => $user
    ]);
} else {
    echo json_encode([
        "success" => 0,
        "message" => "Invalid email or password."
    ]);
}

$conn->close();
?>