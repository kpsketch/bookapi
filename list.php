<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'db.php';

$sql = "SELECT * FROM books ORDER BY id DESC";
$result = $conn->query($sql);

$books = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

echo json_encode([
    "success" => 1,
    "data" => $books
]);

$conn->close();
?>