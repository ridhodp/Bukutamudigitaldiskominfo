<?php
session_start();

// Pemeriksaan session
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config/koneksi.php';

// Determine report type
$type = isset($_GET['type']) ? $_GET['type'] : 'minggu';
$bidang = isset($_GET['bidang']) ? $_GET['bidang'] : '';
$title = '';
$query_filter = '';

switch ($type) {
    case 'minggu':
        $title = 'Laporan Tamu Perminggu';
        $minggu = isset($_GET['minggu']) ? $_GET['minggu'] : date('Y-W');
        list($tahun_minggu, $nomor_minggu) = explode('-', $minggu);
        $query_filter = "WHERE YEAR(tanggal) = $tahun_minggu AND WEEK(tanggal, 1) = $nomor_minggu";
        break;
    case 'bulan':
        $title = 'Laporan Tamu Perbulan';
        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
        list($tahun_bulan, $nomor_bulan) = explode('-', $bulan);
        $query_filter = "WHERE YEAR(tanggal) = $tahun_bulan AND MONTH(tanggal) = $nomor_bulan";
        break;
    case 'tahun':
        $title = 'Laporan Tamu Pertahun';
        $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        $query_filter = "WHERE YEAR(tanggal) = $tahun";
        break;
    default:
        $title = 'Laporan Tamu Perminggu';
        $query_filter = "WHERE YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1)";
        break;
}

// Add bidang filter if selected
if (!empty($bidang)) {
    $query_filter .= " AND bidang = '" . mysqli_real_escape_string($koneksi, $bidang) . "'";
}

// Handle PDF generation
if (isset($_GET['generate_pdf'])) {
    // Include Dompdf autoload only when needed
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
    } else {
        // Fallback: use basic HTML to PDF without Dompdf
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html><head><title>Laporan PDF</title></head><body>';
        echo '<h1>Buku Tamu Diskominfo Kabupaten Karimun</h1>';
        echo '<p>Library Dompdf tidak tersedia. Silakan install dependencies dengan composer.</p>';
        echo '<p>Untuk sementara, gunakan fitur preview saja.</p>';
        echo '</body></html>';
        exit();
    }

    // Generate HTML content for PDF
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?> - PDF</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                font-size: 12px;
                line-height: 1.4;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
                position: relative;
            }
            .header h2 {
                color: #000;
                margin: 0;
                font-size: 18px;
                font-weight: bold;
            }
            .header h3 {
                color: #666;
                margin: 5px 0;
                font-size: 14px;
            }
            .info {
                text-align: center;
                margin-bottom: 20px;
                font-size: 11px;
                color: #666;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 11px;
            }
            th, td {
                border: 1px solid #000;
                padding: 6px;
                text-align: left;
                vertical-align: top;
            }
            th {
                background-color: #f8f9fa;
                font-weight: bold;
                text-align: center;
                font-size: 12px;
            }
            td {
                text-align: center;
            }
            td:nth-child(3), td:nth-child(4), td:nth-child(5) {
                text-align: left;
                word-wrap: break-word;
            }
            .footer {
                position: fixed;
                bottom: 20px;
                left: 20px;
                right: 20px;
                text-align: center;
                font-size: 10px;
                color: #666;
                border-top: 1px solid #ccc;
                padding-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h2>Buku Tamu Diskominfo Kabupaten Karimun</h2>
            <h3><?php echo $title; ?></h3>
        </div>
        <div class="info">
            <p>Laporan: <?php echo ($type == 'tahun') ? $tahun : (($type == 'bulan') ? date('F Y', strtotime($tahun_bulan . '-' . $nomor_bulan . '-01')) : (($type == 'minggu') ? "Minggu $nomor_minggu Tahun $tahun_minggu" : date('F Y'))); ?><?php echo (!empty($bidang)) ? " - Bidang: $bidang" : ''; ?></p>
            <p>Dicetak pada: <?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s'); ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Instansi</th>
                    <th>Keperluan</th>
                    <th>Bidang</th>
                    <th>No HP/WA</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_tamu $query_filter ORDER BY tanggal DESC");
                $no = 1;
                $hasData = false;
                while ($data = mysqli_fetch_array($query)) {
                    $hasData = true;
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$data['tanggal']}</td>
                        <td>{$data['nama']}</td>
                        <td>{$data['instansi']}</td>
                        <td>{$data['tujuan']}</td>
                        <td>{$data['bidang']}</td>
                        <td>{$data['alamat']}</td>
                    </tr>";
                    $no++;
                }
                if (!$hasData) {
                    echo "<tr><td colspan='7' style='text-align: center; font-style: italic;'>Tidak ada data untuk periode ini</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="footer">
            <p>Dokumen ini dicetak secara otomatis oleh Sistem Buku Tamu Diskominfo Kabupaten Karimun</p>
            <p>&copy; <?php echo date('Y'); ?> Diskominfo Kabupaten Karimun - Dinas Komunikasi dan Informatika</p>
        </div>
    </body>
    </html>
    <?php
    $html = ob_get_clean();

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Generate filename based on type
    $filename = '';
    $bidang_suffix = (!empty($bidang)) ? ' - ' . $bidang : '';
    switch ($type) {
        case 'minggu':
            $filename = 'Laporan Tamu Perminggu-Minggu ' . $nomor_minggu . ' Tahun ' . $tahun_minggu . $bidang_suffix . '.pdf';
            break;
        case 'bulan':
            $bulan_nama = date('F', mktime(0, 0, 0, $nomor_bulan, 1, $tahun_bulan));
            $filename = 'Laporan Tamu Perbulan-' . $bulan_nama . ' ' . $tahun_bulan . $bidang_suffix . '.pdf';
            break;
        case 'tahun':
            $filename = 'Laporan Tamu Pertahun-' . $tahun . $bidang_suffix . '.pdf';
            break;
        default:
            $filename = $title . '_Laporan' . $bidang_suffix . '.pdf';
            break;
    }

    // Output the generated PDF to browser
    $dompdf->stream($filename, array('Attachment' => true));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Laporan</title>
    <link rel="icon" href="img/diskominfotbk.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 {
            color: #000;
            margin: 0;
        }
        .header h3 {
            color: #666;
            margin: 5px 0;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        td {
            text-align: center;
        }
        td:nth-child(3), td:nth-child(4), td:nth-child(5) {
            text-align: left;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Buku Tamu Diskominfo Kabupaten Karimun</h2>
            <h3><?php echo $title; ?></h3>
        </div>
        <div class="info">
            <p>Laporan: <?php echo ($type == 'tahun') ? $tahun : (($type == 'bulan') ? date('F Y', strtotime($tahun_bulan . '-' . $nomor_bulan . '-01')) : (($type == 'minggu') ? "Minggu $nomor_minggu Tahun $tahun_minggu" : date('F Y'))); ?><?php echo (!empty($bidang)) ? " - Bidang: $bidang" : ''; ?></p>
            <p>Preview tanggal: <?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s'); ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Instansi</th>
                    <th>Keperluan</th>
                    <th>Bidang</th>
                    <th>No HP/WA</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_tamu $query_filter ORDER BY tanggal DESC");
                $no = 1;
                $hasData = false;
                while ($data = mysqli_fetch_array($query)) {
                    $hasData = true;
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$data['tanggal']}</td>
                        <td>{$data['nama']}</td>
                        <td>{$data['instansi']}</td>
                        <td>{$data['tujuan']}</td>
                        <td>{$data['bidang']}</td>
                        <td>{$data['alamat']}</td>
                    </tr>";
                    $no++;
                }
                if (!$hasData) {
                    echo "<tr><td colspan='7' style='text-align: center; font-style: italic;'>Tidak ada data untuk periode ini</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="btn-container">
            <a href="preview_laporan.php?type=<?php echo $type; ?><?php echo ($type == 'minggu') ? '&minggu=' . $minggu : (($type == 'bulan') ? '&bulan=' . $bulan : (($type == 'tahun') ? '&tahun=' . $tahun : '')); ?><?php echo (!empty($bidang)) ? '&bidang=' . urlencode($bidang) : ''; ?>&generate_pdf=1" class="btn btn-success">
                <i class="fas fa-download"></i> Print PDF
            </a>
            <a href="data_laporan.php?type=<?php echo $type; ?><?php echo ($type == 'minggu') ? '&minggu=' . $minggu : (($type == 'bulan') ? '&bulan=' . $bulan : (($type == 'tahun') ? '&tahun=' . $tahun : '')); ?><?php echo (!empty($bidang)) ? '&bidang=' . urlencode($bidang) : ''; ?>" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>