<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'db.php';

if (!isset($_GET['id'])) {
    echo json_encode([
        "success" => 0,
        "message" => "No ID received"
    ]);
    exit();
}

$id = (int)$_GET['id'];

$sql = "SELECT * FROM books WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();

    echo json_encode([
        "success" => 1,
        "data" => $book
    ]);
} else {
    echo json_encode([
        "success" => 0,
        "message" => "Book not found"
    ]);
}

$conn->close();
?>