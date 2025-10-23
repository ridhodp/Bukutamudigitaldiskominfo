<?php
session_start();

// Pemeriksaan session
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config/koneksi.php';

// Get distinct bidang for filter
$query_bidang = mysqli_query($koneksi, "SELECT DISTINCT bidang FROM tb_tamu WHERE bidang IS NOT NULL AND bidang != '' ORDER BY bidang");

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan</title>
    <link rel="icon" href="img/diskominfotbk.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="css/data_laporan.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-1">
        <div class="container-fluid d-flex justify-content-between px-3">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#" style="margin-left: 20px;">
                <img src="img/diskominfotbk.jpg" alt="Logo Staper" style="height: 40px; margin-right: 15px;">
                Buku Tamu Diskominfo Kabupaten Karimun
            </a>
            <div class="d-flex align-items-center ms-auto me-3">
                <div class="search-container me-4">
                    <input class="form-control" type="search" placeholder="Pencarian..." aria-label="Search" style="width: 250px;">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link text-white" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="profilweb.php"><i class="fas fa-globe me-2"></i>Kembali Ke Halaman Profil WEB</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar p-3">
                <div class="user-info text-center mb-4 position-relative">
                    <div class="position-relative d-inline-block">
                        <?php if (isset($_SESSION['foto_profil']) && !empty($_SESSION['foto_profil'])): ?>
                            <img src="<?php echo $_SESSION['foto_profil']; ?>" alt="Profile Picture" class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#profileModal">
                        <?php else: ?>
                            <i class="fas fa-user-circle fa-3x mb-2" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#profileModal"></i>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-outline-primary position-absolute top-0 end-0 rounded-circle p-1" onclick="window.location.href='edit_profile.php'" title="Edit Profile" style="width: 24px; height: 24px; font-size: 10px;">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <p class="mb-1 fw-bold"><?php echo $_SESSION['username']; ?></p>
                    <p class="mb-0 small"><?php echo $_SESSION['email']; ?></p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#dataMasterSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                            <i class="fas fa-database me-2"></i>Data Master <span class="caret"></span>
                        </a>
                        <ul class="collapse nav flex-column ms-3" id="dataMasterSubmenu">
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="data_tamu.php">Data Tamu & Instansi</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#dataLaporanSubmenu" data-bs-toggle="collapse" data-bs-target="#dataLaporanSubmenu" aria-expanded="true">
                            <i class="fas fa-file-alt me-2"></i>Data Laporan <span class="caret"></span>
                        </a>
                        <ul class="collapse nav flex-column ms-3 show" id="dataLaporanSubmenu">
                            <li class="nav-item mb-2">
                                <a class="nav-link <?php echo ($type == 'minggu') ? 'active' : ''; ?>" href="data_laporan.php?type=minggu">Laporan Tamu Perminggu</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link <?php echo ($type == 'bulan') ? 'active' : ''; ?>" href="data_laporan.php?type=bulan">Laporan Tamu Perbulan</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link <?php echo ($type == 'tahun') ? 'active' : ''; ?>" href="data_laporan.php?type=tahun">Laporan Tamu Pertahun</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="data_user.php"><i class="fas fa-user me-2"></i>Data User Admin</a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-4">
                <div class="content-header">
                    <h1 class="fw-bold mb-0"><?php echo $title; ?></h1>
                    <p class="mb-0 text-muted">Halaman <?php echo $title; ?></p>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4><?php echo $title; ?></h4>
                    <div>
                        <?php if ($type == 'minggu'): ?>
                            <form method="GET" class="d-inline me-2">
                                <input type="hidden" name="type" value="minggu">
                                <input type="hidden" name="bidang" value="<?php echo htmlspecialchars($bidang); ?>">
                                <select name="minggu" class="form-select d-inline" style="width: auto;" onchange="this.form.submit()">
                                    <?php
                                    $current_year = date('Y');
                                    for ($y = 2025; $y <= $current_year + 5; $y++) {
                                        for ($w = 1; $w <= 53; $w++) {
                                            $week_value = $y . '-' . str_pad($w, 2, '0', STR_PAD_LEFT);
                                            $selected = ($week_value == $minggu) ? 'selected' : '';
                                            echo "<option value='$week_value' $selected>Minggu $w - $y</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </form>
                        <?php elseif ($type == 'bulan'): ?>
                            <form method="GET" class="d-inline me-2">
                                <input type="hidden" name="type" value="bulan">
                                <input type="hidden" name="bidang" value="<?php echo htmlspecialchars($bidang); ?>">
                                <select name="bulan" class="form-select d-inline" style="width: auto;" onchange="this.form.submit()">
                                    <?php
                                    $current_year = date('Y');
                                    for ($y = 2025; $y <= $current_year + 5; $y++) {
                                        for ($m = 1; $m <= 12; $m++) {
                                            $month_value = $y . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
                                            $selected = ($month_value == $bulan) ? 'selected' : '';
                                            echo "<option value='$month_value' $selected>" . date('F Y', strtotime($y . '-' . $m . '-01')) . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </form>
                        <?php elseif ($type == 'tahun'): ?>
                            <form method="GET" class="d-inline me-2">
                                <input type="hidden" name="type" value="tahun">
                                <input type="hidden" name="bidang" value="<?php echo htmlspecialchars($bidang); ?>">
                                <select name="tahun" class="form-select d-inline" style="width: auto;" onchange="this.form.submit()">
                                    <?php
                                    $current_year = date('Y');
                                    for ($y = 2025; $y <= $current_year + 5; $y++) {
                                        $selected = ($y == $tahun) ? 'selected' : '';
                                        echo "<option value='$y' $selected>$y</option>";
                                    }
                                    ?>
                                </select>
                            </form>
                        <?php endif; ?>
                        <form method="GET" class="d-inline me-2">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <?php if ($type == 'minggu'): ?>
                                <input type="hidden" name="minggu" value="<?php echo $minggu; ?>">
                            <?php elseif ($type == 'bulan'): ?>
                                <input type="hidden" name="bulan" value="<?php echo $bulan; ?>">
                            <?php elseif ($type == 'tahun'): ?>
                                <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
                            <?php endif; ?>
                            <select name="bidang" class="form-select d-inline" style="width: auto;" onchange="this.form.submit()">
                                <option value="">Semua Bidang</option>
                                <?php
                                mysqli_data_seek($query_bidang, 0); // Reset pointer
                                while ($row_bidang = mysqli_fetch_array($query_bidang)) {
                                    $selected_bidang = ($row_bidang['bidang'] == $bidang) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($row_bidang['bidang']) . "' $selected_bidang>" . htmlspecialchars($row_bidang['bidang']) . "</option>";
                                }
                                ?>
                            </select>
                        </form>
                        <a href="preview_laporan.php?type=<?php echo $type; ?><?php echo ($type == 'minggu') ? '&minggu=' . $minggu : (($type == 'bulan') ? '&bulan=' . $bulan : (($type == 'tahun') ? '&tahun=' . $tahun : '')); ?><?php echo (!empty($bidang)) ? '&bidang=' . urlencode($bidang) : ''; ?>" class="btn btn-danger ms-2">
                            <i class="fas fa-print"></i> Cetak PDF
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table id="dataTable" class="table table-striped table-bordered">
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
                                while ($data = mysqli_fetch_array($query)) {
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
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Hidden print content -->
                <div id="printContent" style="display: none;">
                    <div class="print-header">
                        <h3 style="text-align: center; margin: 0 0 10px 0; color: #007bff;">Buku Tamu Diskominfo Kabupaten Karimun</h3>
                        <h4 style="text-align: center; margin: 0 0 15px 0; color: #666;"><?php echo $title; ?><?php echo ($type == 'tahun') ? " - $tahun" : (($type == 'bulan') ? " - " . date('F Y', strtotime($tahun_bulan . '-' . $nomor_bulan . '-01')) : (($type == 'minggu') ? " - Minggu $nomor_minggu Tahun $tahun_minggu" : '')); ?></h4>
                        <p style="text-align: center; margin: 5px 0;">Laporan: <?php echo ($type == 'tahun') ? $tahun : (($type == 'bulan') ? date('F Y', strtotime($tahun_bulan . '-' . $nomor_bulan . '-01')) : (($type == 'minggu') ? "Minggu $nomor_minggu Tahun $tahun_minggu" : date('F Y'))); ?></p>
                        <p style="text-align: center; margin: 5px 0; font-size: 11px; color: #666;">Dicetak pada: <?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s'); ?></p>
                    </div>

                    <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #000; padding: 8px; text-align: center; background-color: #f8f9fa;">No</th>
                                <th style="border: 1px solid #000; padding: 8px; text-align: center; background-color: #f8f9fa;">Tanggal</th>
                                <th style="border: 1px solid #000; padding: 8px; text-align: center; background-color: #f8f9fa;">Nama</th>
                                <th style="border: 1px solid #000; padding: 8px; text-align: center; background-color: #f8f9fa;">Instansi</th>
                                <th style="border: 1px solid #000; padding: 8px; text-align: center; background-color: #f8f9fa;">Keperluan</th>
                                <th style="border: 1px solid #000; padding: 8px; text-align: center; background-color: #f8f9fa;">Bidang</th>
                                <th style="border: 1px solid #000; padding: 8px; text-align: center; background-color: #f8f9fa;">No HP/WA</th>
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
                                    <td style='border: 1px solid #000; padding: 8px; text-align: center;'>{$no}</td>
                                    <td style='border: 1px solid #000; padding: 8px; text-align: center;'>{$data['tanggal']}</td>
                                    <td style='border: 1px solid #000; padding: 8px;'>{$data['nama']}</td>
                                    <td style='border: 1px solid #000; padding: 8px;'>{$data['instansi']}</td>
                                    <td style='border: 1px solid #000; padding: 8px;'>{$data['tujuan']}</td>
                                    <td style='border: 1px solid #000; padding: 8px;'>{$data['bidang']}</td>
                                    <td style='border: 1px solid #000; padding: 8px;'>{$data['alamat']}</td>
                                </tr>";
                                $no++;
                            }
                            if (!$hasData) {
                                echo "<tr><td colspan='7' style='border: 1px solid #000; padding: 8px; text-align: center; font-style: italic;'>Tidak ada data untuk periode ini</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal for Profile Picture -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <?php if (isset($_SESSION['foto_profil']) && !empty($_SESSION['foto_profil'])): ?>
                        <img src="<?php echo $_SESSION['foto_profil']; ?>" alt="Profile Picture" class="img-fluid rounded" style="max-width: 100%; max-height: 400px;">
                    <?php else: ?>
                        <i class="fas fa-user-circle fa-5x text-muted"></i>
                        <p class="mt-3 text-muted">Tidak ada foto profil</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>
</html>
