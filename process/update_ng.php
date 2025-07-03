<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include(__DIR__ . "/../connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $ng_part = strtoupper($_POST['ng_part']);
    $ng_detail = $_POST['ng_detail'];
    $ng_lot = strtoupper($_POST['ng_lot']);
    $ng_line = strtoupper($_POST['ng_line']);
    $ng_qty = $_POST['ng_qty'];

    // อัปเดตข้อมูล
    $stmt = $conn->prepare("UPDATE qc_ng SET
        part = ?, 
        detail = ?, 
        lot = ?, 
        process = ?, 
        qty = ?
        WHERE id = ?");
        
    $stmt->execute([
        $ng_part,
        $ng_detail,
        $ng_lot,
        $ng_line,
        $ng_qty,
        $id
    ]);

    echo "<script>alert('✅ แก้ไขข้อมูลสำเร็จ'); location.href='../index.php';</script>";
}
?>
