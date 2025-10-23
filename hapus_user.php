<?php
session_start();

// Pemeriksaan session
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config/koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Hapus data user
$query = "DELETE FROM user WHERE username = '$id'";
if (mysqli_query($koneksi, $query)) {
    header("Location: data_user.php?success=3");
    exit();
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>