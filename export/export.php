<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . "/../connect.php"); // ต้องเป็น PDO $conn

// รับค่า filter
$date_start = $_GET['date_start'] ?? date("Y-m-d");
$date_end   = $_GET['date_end'] ?? date("Y-m-d");
$line       = $_GET['ng_line'] ?? '';

// ตั้งค่า Header สำหรับไฟล์ CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=report_export_' . date("Ymd_His") . '.csv');

// เปิดไฟล์สำหรับเขียน
$output = fopen('php://output', 'w');
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel
fputcsv($output, ['วันที่', 'ชิ้นส่วน', 'ปัญหา', 'ล็อตผลิต', 'ไลน์ผลิต', 'จำนวน']);

// สร้าง SQL พร้อมเงื่อนไข
$sql = "SELECT * FROM qc_ng WHERE DATE(created_at) BETWEEN :start AND :end";
$params = [
    ':start' => $date_start,
    ':end'   => $date_end
];

if (!empty($line)) {
    $sql .= " AND process = :line";
    $params[':line'] = $line;
}

$sql .= " ORDER BY id ASC";

// เตรียมและ execute
$stmt = $conn->prepare($sql);
$stmt->execute($params);

// ดึงข้อมูลและเขียนลง CSV
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [
        $row['created_at'],
        $row['part'],
        $row['detail'],
        $row['lot'],
        $row['process'],
        $row['qty'],
    ]);
}

fclose($output);
exit();
?>
