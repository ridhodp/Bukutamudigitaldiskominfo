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
    <title>Login - Buku Tamu Digital Diskominfo Kabupaten Karimun</title>
    <link rel="icon" href="img/diskominfotbk.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="img/diskominfotbk.jpg" alt="Logo Staper">
            <h2>Login</h2>
            <p>Buku Tamu Digital Diskominfo Kabupaten Karimun</p>
        </div>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'yes'): ?>
            <div class="alert alert-danger">
                Username atau password salah!
            </div>
        <?php endif; ?>

        <form method="POST" action="cek_login.php">
            <div class="form-group">
                <input type="text" class="form-control" name="user" placeholder="Username" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="pwd" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="register-link">
            <a href="register.php">Belum punya akun? Daftar di sini</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>