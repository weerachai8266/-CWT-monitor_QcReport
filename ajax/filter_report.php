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

// แสดงผล
if ($stmt->rowCount()) {
    echo '<table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-blue-100">
            <tr>
                <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider rounded-tl-lg">DATE</th>
                <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">ITEM</th>
                <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">PART</th>
                <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">COLOR</th>
                <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">ISSUE</th>
                <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">LOT</th>
                <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">PROCESS</th>
                <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider rounded-tr-lg">QTY</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">';
        
    foreach ($stmt as $row) {
        // เตรียมคำสั่ง SQL สำหรับดึง nickname และ color
        $itemStmt = $conn->prepare("SELECT nickname, color FROM item WHERE item = :item LIMIT 1");
        $itemStmt->execute([':item' => $row['part']]);
        $itemData = $itemStmt->fetch(PDO::FETCH_ASSOC);

        // ถ้าเจอข้อมูลใน item
        $nickname = $itemData['nickname'] ?? '';
        $color = $itemData['color'] ?? '';
        
        echo "<tr class='hover:bg-gray-50'>
                <td class='px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center'>{$row['created_at']}</td>
                <td class='px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center'>{$row['part']}</td>
                <td class='px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center'>$nickname</td>
                <td class='px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center'>$color</td>
                <td class='px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center'>{$row['detail']}</td>
                <td class='px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center'>{$row['lot']}</td>
                <td class='px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center'>{$row['process']}</td>
                <td class='px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center'>{$row['qty']}</td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo "<div class='text-center text-muted'>ไม่พบข้อมูล</div>";
}
