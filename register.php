<?php
session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Buku Tamu Digital Diskominfo Kabupaten Karimun</title>
    <link rel="icon" href="img/diskominfotbk.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <img src="img/diskominfotbk.jpg" alt="Logo Staper">
            <h2>Register</h2>
            <p>Buku Tamu Digital Diskominfo Kabupaten Karimun</p>
        </div>

        <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
            <div class="alert alert-success">
                Registrasi berhasil! Silakan login.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php
                if ($_GET['error'] == '1') echo "Username sudah digunakan!";
                elseif ($_GET['error'] == '2') echo "Email sudah digunakan!";
                elseif ($_GET['error'] == '3') echo "Password tidak cocok!";
                elseif ($_GET['error'] == '4') echo "Gagal registrasi!";
                ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="proses_register.php">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="confirm_password" placeholder="Konfirmasi Password" required>
            </div>


            <div class="form-group">
                <input type="text" class="form-control" name="ket" placeholder="Status Jabatan DiDinas" required>
            </div>

            <button type="submit" class="btn-register">Register</button>
        </form>

        <div class="login-link">
            <a href="login.php">Sudah punya akun? Login di sini</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>