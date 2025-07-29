<?php
require_once '../connect.php';

$q = $_GET['term'] ?? ''; // term มาจาก jQuery UI
$stmt = $conn->prepare("SELECT item FROM item WHERE item LIKE ? ORDER BY item ASC LIMIT 10");
$stmt->execute(["%$q%"]);
$items = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($items);

?>