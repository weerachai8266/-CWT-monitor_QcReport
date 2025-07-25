<?php
require_once '../connect.php';

$q = $_GET['term'] ?? '';
$stmt = $conn->prepare("SELECT detail FROM qc_ng WHERE detail LIKE ? ORDER BY detail ASC LIMIT 20");
$stmt->execute(["%$q%"]);
$details = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($details);
?>