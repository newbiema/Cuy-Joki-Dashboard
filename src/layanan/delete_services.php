<?php
include '../services/db.php'; // Koneksi ke database

// Memeriksa apakah ID tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data
    $query = "DELETE FROM services WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        header("Location: services_table.php "); // Kembali ke halaman utama setelah menghapus
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }
} else {
    header("Location: main_dashboard.php");
}
?>
