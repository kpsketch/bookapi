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

if (!isset($postData['id'])) {
    echo json_encode([
        "success" => 0,
        "message" => "No ID received"
    ]);
    exit();
}

$id = (int)$postData['id'];

$sql = "DELETE FROM books WHERE id = $id";

if ($conn->query($sql)) {
    echo json_encode([
        "success" => 1,
        "message" => "Book deleted successfully"
    ]);
} else {
    echo json_encode([
        "success" => 0,
        "message" => "Delete failed"
    ]);
}

$conn->close();
?>
