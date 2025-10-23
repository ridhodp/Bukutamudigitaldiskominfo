<?php
session_start();

// Ambil data dari form login
$user = $_POST['user'];
$pwd = $_POST['pwd'];
$pwd_enkripsi = md5($pwd);

// Baca data ke database
include 'config/koneksi.php';
$sql = "SELECT * FROM user WHERE username='$user' AND paswd='$pwd_enkripsi'";
$query = mysqli_query($koneksi, $sql) or die("SQL Login Error");
$jumlahdata = mysqli_num_rows($query);

if ($jumlahdata > 0) {
    $data = mysqli_fetch_array($query);
    $_SESSION['username'] = $user;
    $_SESSION['idsesi'] = session_id();
    $_SESSION['level'] = $data['level'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['ket'] = $data['ket'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['foto_profil'] = $data['foto_profil'];
    // Arahkan ke dashboard
    header("Location: dashboard.php");
    exit();
} else {
    // Arahkan kembali ke index.php dengan pesan error
    header("Location: login.php?error=yes");
    exit();
}
?>