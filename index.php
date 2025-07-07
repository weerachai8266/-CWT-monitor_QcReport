<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'connect.php'; // เชื่อมต่อฐานข้อมูล
session_start();

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CWT inspection</title>
    <!-- <link rel="shortcut icon" href="https://cdn.dinoq.com/datafilerepo/greenpower/greenpowerlogo.ico" type="image/x-icon"> -->
    <link rel="icon" href="img/favicon_circular.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom font for Inter (preferred for modern UI) */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        /* Fallback to Poppins if Inter is not desired, but Inter is generally cleaner for UI */
        /* @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap'); */

        body {
            font-family: 'Inter', sans-serif; /* Using Inter as the primary font */
            background-color: #f3f4f6; /* Light gray background */
        }
        /* Custom scrollbar for table-responsive */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #e0e0e0;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery (kept for existing JS logic) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-light">
    <div class="container mt-4">

        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
            <img src="img/logo-chaiwattana.png" alt="cwt" style="height: 60px;">
            <h1 class="mb-0 mx-auto" style="color:rgb(0, 0, 0); font-family: 'Poppins', sans-serif; font-weight: 600;">
                <!-- Chai Watana Tannery Group -->
            </h1>
            <div style="width: 60px;"></div>
        <!-- </div> -->

        <!-- แถบเมนู -->
        <ul class="nav nav-pills" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="ng-tab" data-bs-toggle="tab" data-bs-target="#ng" type="button" role="tab">NG</button>
            </li>
            <!-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="man-tab" data-bs-toggle="tab" data-bs-target="#man" type="button" role="tab">Man Power</button>
            </li> -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="report-tab" data-bs-toggle="tab" data-bs-target="#report" type="button" role="tab">Report</button>
            </li>
        </ul>
        </div>

        <div class="tab-content mt-3" id="myTabContent">

            <!-- NG -->
            <div class="tab-pane fade show active" id="ng" role="tabpanel">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-danger text-white">
                    ⚠️ บันทึกของเสีย
                    </div>
                    <div class="card-body">
                        <form method="post" action="process/add_ng.php">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">ชิ้นส่วน</label>
                                    <input type="text" name="ng-part" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">ปัญหา</label>
                                    <input type="text" name="ng-detail" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">ล็อต</label>
                                    <input type="text" name="ng-lot" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">ไลน์ผลิต</label>
                                    <!-- <input type="text" name="ng-line" class="form-control" required> -->
                                    <select name="ng-line" class="form-select" required>
                                        <option value="" disabled selected>เลือกไลน์</option>
                                        <option value="F/C">F/C</option>
                                        <option value="F/B">F/B</option>
                                        <option value="R/C">R/C</option>
                                        <option value="R/B">R/B</option>
                                        <option value="3RD & ARM">3RD & ARM</option>
                                        <option value="SUB">SUB</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">จำนวน</label>
                                    <input type="number" name="ng-qty" class="form-control" required>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-danger mt-3">💾 บันทึกข้อมูล</button>
                                    <!-- <a href="import_truck.php" class="btn btn-outline-primary mt-3 ms-2">📥 นำเข้าจากไฟล์ CSV</a> -->
                                </div>                                
                            </div>
                        </form>      
                    </div>                    
                </div> <!-- End of Target Card -->

                <!-- NG Report -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-danger text-white">
                    📋 รายงานของเสีย
                    </div>
                    <div class="card-body">
                        <div class="overflow-x-auto rounded-lg shadow-md">
                            <div class="row g-3">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-blue-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider rounded-tl-lg">วันที่</th>
                                            <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">ชิ้นส่วน</th>
                                            <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">ปัญหา</th>
                                            <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">ล็อต</th>
                                            <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">ไลน์ผลิต</th>
                                            <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">จำนวน</th>
                                            <th scope="col" class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">EDIT</th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <?php 
                                        $stmt = $conn->query("SELECT * FROM qc_ng WHERE DATE(created_at) = CURDATE() ORDER BY id DESC");
                                        // $total_license = $stmt->rowCount();
                                        // $i = $total_license;                        
                                        foreach ($stmt as $row): 
                                    ?>
                                    <tr class="hover:bg-gray-50">                                    
                                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center"><?= $row['created_at'] ?></td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center"><?= $row['part'] ?></td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center"><?= $row['detail'] ?></td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center"><?= $row['lot'] ?></td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center"><?= $row['process'] ?></td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center"><?= $row['qty'] ?></td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center text-sm font-medium">
                                            <!-- ปุ่มแก้ไข -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">✏️</button>
                                            <!-- ปุ่มลบ -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">🗑️</button>
                                        </td>
                                    </tr>
                                    <!-- Modal แก้ไข -->
                                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="process/update_ng.php">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title">📝 แก้ไขข้อมูล</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="form-label">ชิ้นส่วน</label>
                                                        <input name="ng_part" class="form-control mb-2" value="<?= $row['part'] ?>" required>
                                                        <label class="form-label">ปัญหา</label>
                                                        <input name="ng_detail" class="form-control mb-2" value="<?= $row['detail'] ?>" required>
                                                        <label class="form-label">ล็อต</label>
                                                        <input name="ng_lot" class="form-control mb-2" value="<?= $row['lot'] ?>" required>
                                                        <label class="form-label">ไลน์ผลิต</label>
                                                        <select name="ng_line" class="form-select" required>
                                                            <option value="<?= $row['process'] ?>" disabled selected><?= $row['process'] ?></option>
                                                            <option value="F/C">F/C</option>
                                                            <option value="F/B">F/B</option>
                                                            <option value="R/C">R/C</option>
                                                            <option value="R/B">R/B</option>
                                                            <option value="3RD & ARM">3RD & ARM</option>
                                                            <option value="SUB">SUB</option>
                                                        </select>
                                                        <label class="form-label">จำนวน</label>
                                                        <input name="ng_qty" class="form-control mb-2" value="<?= $row['qty'] ?>" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">บันทึก</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal ลบ -->
                                    <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="post" action="process/delete_ng.php">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title">ยืนยันการลบ</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                    <div class="modal-body">
                                                    คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลวันที่  <strong><?= $row['created_at'] ?></strong> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">ลบข้อมูล</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>                                
                            </div>
                        </div>
                    </div>
                </div> <!-- End of Report Card -->
            </div> <!-- End of NG Tab -->

            <!-- Report -->
            <div class="tab-pane fade" id="report" role="tabpanel">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        📊 Report
                    </div>
                    <div class="card-body">
                        <!-- Report Filter -->
                        <div class="row" id="report-filter-form">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <label class="input-group-text">วันที่</label>
                                    <input class="form-control" type="date" id="report_date_start" value="<?= date('Y-m-d') ?>">
                                    <input class="form-control" type="date" id="report_date_end" value="<?= date('Y-m-d') ?>">
                                </div>    
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="ng_line">ไลน์ผลิต</label>
                                    <select class="form-select" id="ng_line">
                                        <option value="">ทั้งหมด</option>
                                        <option value="F/C">F/C</option>
                                        <option value="F/B">F/B</option>
                                        <option value="R/C">R/C</option>
                                        <option value="R/B">R/B</option>
                                        <option value="3RD & ARM">3RD & ARM</option>
                                        <option value="SUB">SUB</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 d-flex justify-content-end gap-3 align-items-start">
                                <button id="btnFilter" class="btn btn-primary">ตกลง</button>
                                <a id="btnExport" href="#" class="btn btn-success">Excel</a>
                            </div>
                        </div>  <!-- End of Report Filter -->

                        <!-- ตารางผลลัพธ์ -->
                        <div class="overflow-x-auto rounded-lg shadow-md" id="report-table-container">
                            <div class="text-center text-muted">⏳ รอโหลดข้อมูล...</div>
                        </div>  <!-- End of Report Table Container -->
                       
                    </div>
                </div> <!-- End of Report Card -->
            </div> <!-- End of Report Tab -->
        </div> <!-- End of Tab Content -->

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById("btnFilter").addEventListener("click", function () {
        const start = document.getElementById("report_date_start").value || '';
        const end = document.getElementById("report_date_end").value || '';
        const lineSelect = document.getElementById("ng_line");
        const line = lineSelect ? lineSelect.value : '';

        // Update export CSV link
        const exportURL = `export/export_xlsx.php?date_start=${encodeURIComponent(start)}&date_end=${encodeURIComponent(end)}&ng_line=${encodeURIComponent(line)}`;
        document.getElementById("btnExport").setAttribute("href", exportURL);

        // AJAX fetch
        const formData = new FormData();
        formData.append("report_date_start", start);
        formData.append("report_date_end", end);
        formData.append("ng_line", line);

        const container = document.getElementById("report-table-container");
        container.innerHTML = "<div class='overflow-x-auto rounded-lg shadow-md'>⏳ กำลังโหลดข้อมูล...</div>";

        fetch("ajax/filter_report.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => container.innerHTML = data)
        .catch(err => container.innerHTML = "<div class='text-danger'>เกิดข้อผิดพลาดในการโหลดข้อมูล</div>");
    });

    // โหลดข้อมูลทันทีเมื่อเปิดแท็บ
    document.getElementById("report-tab").addEventListener("click", () => {
        document.getElementById("btnFilter").click();
    });
    </script>


</body>
</html>