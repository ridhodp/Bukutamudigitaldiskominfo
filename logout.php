<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Arahkan kembali ke index.php
header("Location: login.php");
exit();
?>
