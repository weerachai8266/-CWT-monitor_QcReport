<?php
include '../connect.php';

$conditions = [];
$params = [];

if (!empty($_POST['report_date_start']) && !empty($_POST['report_date_end'])) {
    $conditions[] = "DATE(created_at) BETWEEN ? AND ?";
    $params[] = $_POST['report_date_start'];
    $params[] = $_POST['report_date_end'];
}

if (!empty($_POST['ng_line'])) {
    $conditions[] = "process = ?";
    $params[] = $_POST['ng_line'];
}

$sql = "SELECT * FROM qc_ng";
if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);

if ($stmt->rowCount()) {
    echo '<table class="table table-bordered table-hover">
        <thead class="table-info text-center">
            <tr>
                <th>วันที่</th>
                <th>ชิ้นส่วน</th>
                <th>ปัญหา</th>
                <th>ล็อต</th>
                <th>ไลน์ผลิต</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody class="text-center">';
    foreach ($stmt as $row) {
        echo "<tr>
                <td>{$row['created_at']}</td>
                <td>{$row['part']}</td>
                <td>{$row['detail']}</td>
                <td>{$row['lot']}</td>
                <td>{$row['process']}</td>
                <td>{$row['qty']}</td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo "<div class='text-center text-muted'>ไม่พบข้อมูล</div>";
}
