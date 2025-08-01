<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include(__DIR__ . "/../connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $issue = $_POST['issue'];
    $id = $_POST['id'];

    // อัปเดตข้อมูล
    $stmt = $conn->prepare("UPDATE qc_issue SET issue = ? WHERE id = ?");
        
    $stmt->execute([
        $issue,
        $id
    ]);

    echo "<script>alert('✅ แก้ไขข้อมูลสำเร็จ'); location.href='../index.php';</script>";
}
?>
