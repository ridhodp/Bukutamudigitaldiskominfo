<?php
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $level = 2; // Default level User
    $ket = $_POST['ket'];

    // Validasi password
    if ($password != $confirm_password) {
        header("Location: register.php?error=3");
        exit();
    }

    // Cek username sudah ada
    $query_check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($query_check_username) > 0) {
        header("Location: register.php?error=1");
        exit();
    }

    // Cek email sudah ada
    $query_check_email = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'");
    if (mysqli_num_rows($query_check_email) > 0) {
        header("Location: register.php?error=2");
        exit();
    }

    // Hash password
    $password_hash = md5($password);

    // Insert data
    $query = "INSERT INTO user (username, email, paswd, level, ket) VALUES ('$username', '$email', '$password_hash', '$level', '$ket')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: register.php?success=1");
        exit();
    } else {
        header("Location: register.php?error=4");
        exit();
    }
} else {
    header("Location: register.php");
    exit();
}
?>