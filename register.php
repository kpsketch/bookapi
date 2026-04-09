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

$name = $conn->real_escape_string($postData['data']['name']);
$email = $conn->real_escape_string($postData['data']['email']);
$password = $conn->real_escape_string($postData['data']['password']);

if (empty($name) || empty($email) || empty($password)) {
    echo json_encode([
        "success" => 0,
        "message" => "All fields are required."
    ]);
    exit();
}

$checkSql = "SELECT id FROM users WHERE email = '$email'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    echo json_encode([
        "success" => 0,
        "message" => "Email already exists."
    ]);
    exit();
}

$sql = "INSERT INTO users (name, email, password)
        VALUES ('$name', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo json_encode([
        "success" => 1,
        "message" => "User registered successfully"
    ]);
} else {
    echo json_encode([
        "success" => 0,
        "message" => "Registration failed: " . $conn->error
    ]);
}

$conn->close();
?>