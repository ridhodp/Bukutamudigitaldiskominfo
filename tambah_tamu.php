<?php
session_start();

// Pemeriksaan session
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config/koneksi.php';

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $instansi = mysqli_real_escape_string($koneksi, $_POST['instansi']);
    $tujuan = mysqli_real_escape_string($koneksi, $_POST['tujuan']);
    $bidang = mysqli_real_escape_string($koneksi, $_POST['bidang']);


    // Handle file upload for PDF
    $bukti = '';
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["bukti"]["name"]);
        $target_file = $target_dir . $file_name;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is PDF
        if ($fileType == "pdf") {
            if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
                $bukti = $file_name;
            }
        }
    }

    // Insert data
    $query = "INSERT INTO tb_tamu (tanggal, nama, alamat, instansi, tujuan, bidang, perihal) VALUES ('$tanggal', '$nama', '$alamat', '$instansi', '$tujuan', '$bidang', '')";
    if (mysqli_query($koneksi, $query)) {
        // Check if instansi already exists, if not, add it
        $check_instansi = mysqli_query($koneksi, "SELECT * FROM tb_instansi WHERE nama = '$nama' AND alamat = '$alamat'");
        if (mysqli_num_rows($check_instansi) == 0) {
            $insert_instansi = "INSERT INTO tb_instansi (tanggal, nama, alamat) VALUES ('$tanggal', '$nama', '$alamat')";
            mysqli_query($koneksi, $insert_instansi);
        }
        header("Location: data_tamu.php?success=1");
        exit();
    } else {
        $error = "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tamu - Buku Tamu Diskominfo Kabupaten Karimun</title>
    <link rel="icon" href="img/diskominfotbk.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/tambah_tamu.css" rel="stylesheet">
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
                        <a class="nav-link" href="#dataMasterSubmenu" data-bs-toggle="collapse" data-bs-target="#dataMasterSubmenu" aria-expanded="true">
                            <i class="fas fa-database me-2"></i>Data Master <span class="caret"></span>
                        </a>
                        <ul class="collapse nav flex-column ms-3 show" id="dataMasterSubmenu">
                            <li class="nav-item mb-2">
                                <a class="nav-link active" href="data_tamu.php">Data Tamu & Instansi</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="data_laporan.php"><i class="fas fa-file-alt me-2"></i>Data Laporan</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="data_user.php"><i class="fas fa-user me-2"></i>Data User Admin</a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-4">
                <!-- Content -->
                <div class="content-header">
                    <h1 class="fw-bold mb-0">Tambah Tamu & Instansi</h1>
                    <p class="mb-0 text-muted">Form Tambah Data Tamu & Instansi</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">No HP/WA</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="instansi" class="form-label">Instansi</label>
                                        <input type="text" class="form-control" id="instansi" name="instansi" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tujuan" class="form-label">Keperluan</label>
                                        <input type="text" class="form-control" id="tujuan" name="tujuan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bidang" class="form-label">Bidang</label>
                                        <select class="form-select" id="bidang" name="bidang" required>
                                            <option value="">Pilih Bidang</option>
                                            <option value="Bidang Sekretariat & Umum">Bidang Sekretariat & Umum</option>
                                            <option value="Bidang Pengelolaan dan Layanan Informasi Publik">Bidang Pengelolaan dan Layanan Informasi Publik</option>
                                            <option value="Bidang Komunikasi Publik dan Kehumasan">Bidang Komunikasi Publik dan Kehumasan</option>
                                            <option value="Bidang TIK">Bidang TIK</option>
                                            <option value="Bidang Statistik & Persandian">Bidang Statistik & Persandian</option>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="data_tamu.php" class="btn btn-secondary">Kembali</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>