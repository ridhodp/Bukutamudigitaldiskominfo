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

// Hapus data tamu
$query = "DELETE FROM tb_tamu WHERE id = $id";
if (mysqli_query($koneksi, $query)) {
    header("Location: data_tamu.php?success=3");
    exit();
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>