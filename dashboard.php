<?php
session_start();

// Pemeriksaan session
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// testing to commit

// Fetch counts from database
include 'config/koneksi.php';
$query_tamu = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah_tamu FROM tb_tamu");
$data_tamu = mysqli_fetch_assoc($query_tamu);
$jumlah_tamu = $data_tamu['jumlah_tamu'];

$query_instansi = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah_instansi FROM tb_tamu");
$data_instansi = mysqli_fetch_assoc($query_instansi);
$jumlah_instansi = $data_instansi['jumlah_instansi'];

// Fetch current user data
$username = $_SESSION['username'];
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
$user = mysqli_fetch_assoc($query);
if ($user) {
    $_SESSION['foto_profil'] = $user['foto_profil'];
} else {
    // Handle case where user is not found
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $ket = mysqli_real_escape_string($koneksi, $_POST['ket']);

    // Handle file upload for foto_profil
    $foto_profil = isset($user['foto_profil']) ? $user['foto_profil'] : '';
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["foto_profil"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["foto_profil"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $target_file)) {
                $foto_profil = $target_file;
            }
        }
    }

    // Update user data
    $update_query = "UPDATE user SET nama = '$nama', email = '$email', ket = '$ket'" . ($foto_profil ? ", foto_profil = '$foto_profil'" : "") . " WHERE username = '$username'";
    if (mysqli_query($koneksi, $update_query)) {
        // Update session variables
        $_SESSION['email'] = $email;
        $_SESSION['nama'] = $nama;
        $_SESSION['foto_profil'] = $foto_profil;
        $success = "Profile updated successfully!";
        // Refresh user data
        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
        $user = mysqli_fetch_assoc($query);
    } else {
        $error = "Error updating profile: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="img/diskominfotbk.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
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
                        <button class="btn btn-sm btn-outline-primary position-absolute top-0 end-0 rounded-circle p-1" onclick="showEditProfile()" title="Edit Profile" style="width: 24px; height: 24px; font-size: 10px;">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <p class="mb-1 fw-bold"><?php echo $_SESSION['username']; ?></p>
                    <p class="mb-0 small"><?php echo $_SESSION['email']; ?></p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#dataMasterSubmenu" data-bs-toggle="collapse" data-bs-target="#dataMasterSubmenu" aria-expanded="false">
                            <i class="fas fa-database me-2"></i>Data Master <span class="caret"></span>
                        </a>
                        <ul class="collapse nav flex-column ms-3" id="dataMasterSubmenu">
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="data_tamu.php">Data Tamu & Instansi</a>
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

                <!-- Dashboard Content -->
                <div class="content-header">
                    <h1 class="fw-bold mb-0">Dashboard</h1>
                    <p class="mb-0 text-muted">Halaman Dashboard</p>
                </div>

                <!-- Edit Profile Section -->
                <div id="editProfileSection" class="row" style="display: none;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Edit Profile</h5>
                            </div>
                            <div class="card-body">
                                <?php if (isset($success)): ?>
                                    <div class="alert alert-success"><?php echo $success; ?></div>
                                <?php endif; ?>
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ket" class="form-label">Posisi Di Bidang</label>
                                        <input type="text" class="form-control" id="ket" name="ket" value="<?php echo htmlspecialchars($user['ket']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto_profil" class="form-label">Foto Profil</label>
                                        <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
                                        <?php if (isset($user['foto_profil']) && $user['foto_profil']): ?>
                                            <div class="mt-2">
                                                <img src="<?php echo $user['foto_profil']; ?>" alt="Current Profile Picture" class="img-thumbnail" style="max-width: 150px;">
                                                <small class="text-muted d-block mt-1">Foto profil saat ini</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Profile</button>
                                    <button type="button" class="btn btn-secondary" onclick="hideEditProfile()"><i class="fas fa-times me-2"></i>Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Content -->
                <div id="dashboardContent">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card-custom">
                                <h5 class="fw-bold">DATA TAMU</h5>
                                <i class="fas fa-users card-icon"></i>
                                <div class="card-number"><?php echo $jumlah_tamu; ?></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card-custom">
                                <h5 class="fw-bold">DATA INSTANSI</h5>
                                <i class="fas fa-building card-icon"></i>
                                <div class="card-number"><?php echo $jumlah_instansi; ?></div>
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
    <script>
        function showEditProfile() {
            document.getElementById('dashboardContent').style.display = 'none';
            document.getElementById('editProfileSection').style.display = 'block';
            // Update active nav link
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            event.target.classList.add('active');
        }

        function hideEditProfile() {
            document.getElementById('editProfileSection').style.display = 'none';
            document.getElementById('dashboardContent').style.display = 'block';
            // Reset active nav link to dashboard
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            document.querySelector('a[href="dashboard.php"]').classList.add('active');
        }
    </script>
</body>
</html>
