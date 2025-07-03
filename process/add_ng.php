<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include(__DIR__ . "/../connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ng_part = strtoupper ($_POST['ng-part']);
    $ng_detail = $_POST['ng-detail'];
    $ng_lot = strtoupper($_POST['ng-lot']);
    $ng_line = strtoupper($_POST['ng-line']);
    $ng_qty = $_POST['ng-qty'];


    // เพิ่มข้อมูล
    $stmt = $conn->prepare("INSERT INTO qc_ng (part, detail, lot, process, qty)
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $ng_part,
        $ng_detail,
        $ng_lot,
        $ng_line,
        $ng_qty
    ]);

    echo "<script>alert('✅ เพิ่มข้อมูลเรียบร้อยแล้ว'); location.href='../index.php';</script>";
}
?>
