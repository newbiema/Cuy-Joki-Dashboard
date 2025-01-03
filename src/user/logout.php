<?php
session_start(); // Memulai session

// Menghapus semua data session
session_unset(); // Menghapus semua variabel session
session_destroy(); // Menghancurkan session

// Redirect ke halaman login
header("Location: ../index.php");
exit();
?>
