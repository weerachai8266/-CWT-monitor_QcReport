<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include(__DIR__ . "/../connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $issue = strtoupper ($_POST['issue-detail']);


    // เพิ่มข้อมูล
    $stmt = $conn->prepare("INSERT INTO qc_issue (issue)
                            VALUES (?)");
    $stmt->execute([
        $issue
    ]);

    echo "<script>alert('✅ เพิ่มข้อมูลเรียบร้อยแล้ว'); location.href='../index.php';</script>";
}
?>
