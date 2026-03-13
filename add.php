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
        "message" => "No input data received."
    ]);
    exit();
}

$title = $conn->real_escape_string($postData['data']['title']);
$author = $conn->real_escape_string($postData['data']['author']);
$description = $conn->real_escape_string($postData['data']['description']);

if (empty($title) || empty($author) || empty($description)) {
    echo json_encode([
        "success" => 0,
        "message" => "All fields are required."
    ]);
    exit();
}

$sql = "INSERT INTO books (title, author, description)
        VALUES ('$title', '$author', '$description')";

if ($conn->query($sql) === TRUE) {
    echo json_encode([
        "success" => 1,
        "data" => [
            "message" => "Book added successfully"
        ]
    ]);
} else {
    echo json_encode([
        "success" => 0,
        "message" => "Insert failed: " . $conn->error
    ]);
}

$conn->close();
?>