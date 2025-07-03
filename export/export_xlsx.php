<?php
require __DIR__ . '/../vendor/autoload.php';
include(__DIR__ . "/../connect.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// รับค่า
$date_start = $_GET['date_start'] ?? date("Y-m-d");
$date_end   = $_GET['date_end'] ?? date("Y-m-d");
$line       = $_GET['ng_line'] ?? '';

// SQL
$sql = "SELECT * FROM qc_ng WHERE DATE(created_at) BETWEEN :start AND :end";
$params = [
    ':start' => $date_start,
    ':end' => $date_end
];
if (!empty($line)) {
    $sql .= " AND process = :line";
    $params[':line'] = $line;
}
$sql .= " ORDER BY id ASC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);

// สร้าง Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// หัวตาราง
$sheet->fromArray(['วันที่', 'ชิ้นส่วน', 'ปัญหา', 'ล็อตผลิต', 'ไลน์ผลิต', 'จำนวน'], NULL, 'A1');

// เขียนข้อมูล
$rowIndex = 2;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sheet->fromArray([
        $row['created_at'],
        $row['part'],
        $row['detail'],
        $row['lot'],
        $row['process'],
        $row['qty']
    ], NULL, "A{$rowIndex}");
    $rowIndex++;
}

// ตั้ง header
$filename = 'report_export_' . date("Ymd_His") . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

// บันทึกเป็น .xlsx
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
