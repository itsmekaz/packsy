<?php 
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: ../login.php");
        exit;
    }

    require_once "../koneksi.php";

    $activities = show("SELECT a.nama, p.nama_produk, l.aksi, l.timestamp
          FROM admin_logs l
          JOIN admin a ON l.admin_id = a.id
          JOIN products p ON l.produk_id = p.id
          ORDER BY l.timestamp DESC");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACKSY | REPORTING</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/styles/basic.css">
    <link rel="stylesheet" href="../assets/styles/reporting.css">
    
    
</head>
<body>
    <main class="d-flex">
        <?php include "../layout/sidebar.php"?>
        
        <!-- Content -->
        <section class="content p-4 container-fluid">
            <div class="mt-2 mb-4 title d-flex justify-content-between align-items-center">
                <h1>Admin Activity Report</h1>

                <div class="text-center d-flex justify-content-center align-items-center gap-3">
                    <button id="pdfExport" name="pdfExport" class="btn btn-danger">Download PDF <i class="bi bi-file-earmark-pdf-fill"></i></button>
                    <button id="wordExport" name="wordExport" class="btn btn-primary">Download Word <i class="bi bi-file-earmark-word-fill"></i></button>
                </div>
            </div>

            <!-- Tabel transaksi -->
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Nama Admin</th>
                        <th>Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($activities) > 0): ?>
                        <?php $i = 1?>
                        <?php foreach ($activities as $activity): ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= date("d M Y, H:i:s", strtotime($activity['timestamp'])) ?></td>
                                <td><?= $activity['nama'] ?></td>
                                <td><?= $activity['nama_produk'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $activity['aksi'] === ('Add' OR 'Edit') ? 'success' : 'warning' ?>">
                                        <?= $activity['aksi'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php $i++ ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No activity found.</td>
                        </tr>
                    <?php endif ?>    
                </tbody>
            </table>
        </section>
    </main>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // download pdf
        document.getElementById('pdfExport').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Tambahkan judul
            doc.setFontSize(18);
            doc.text("Admin Activity Report", 14, 20);

            // Ambil data tabel
            const table = document.querySelector('table');
            const tableData = [];
            const tableHeaders = [];

            // Ambil header tabel
            table.querySelectorAll('thead th').forEach(th => tableHeaders.push(th.innerText));

            // Ambil isi tabel
            table.querySelectorAll('tbody tr').forEach(row => {
                const rowData = [];
                row.querySelectorAll('td').forEach(td => rowData.push(td.innerText));
                tableData.push(rowData);
            });

            // Generate tabel di PDF
            doc.autoTable({
                head: [tableHeaders],
                body: tableData,
                startY: 30,
            });

            // Download file
            doc.save("admin-activity-packsy-report.pdf");
        });


        // download word
        document.getElementById('wordExport').addEventListener('click', function () {
            const table = document.querySelector('table');
            let html = `
                <h1 style="text-align: center;">Transactions Report</h1>
                <table border="1" style="width: 100%; text-align: center; border-collapse: collapse;">
                    ${table.innerHTML}
                </table>
            `;

            const blob = new Blob(['\ufeff' + html], { type: 'application/msword' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'admin-activity-packsy-report.doc';
            a.click();
            URL.revokeObjectURL(url);
        });
    </script>
</body>
</html>
