<?php
include '../services/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_layanan = $_POST['nama_layanan'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO services (nama_layanan, deskripsi, harga) VALUES ('$nama_layanan', '$deskripsi', '$harga')";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Layanan berhasil ditambahkan!'); window.location.href='services_table.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan layanan: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan</title>
    <link rel="stylesheet" href="../css/output.css">
</head>
<body class="bg-gray-100 font-poppins">
    <div class="max-w-lg mx-auto mt-10 bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Tambah Layanan Baru</h1>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="nama_layanan" class="block text-gray-700">Nama Layanan</label>
                <input type="text" id="nama_layanan" name="nama_layanan" required class="w-full border p-2 rounded-lg">
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" required class="w-full border p-2 rounded-lg"></textarea>
            </div>
            <div class="mb-4">
                <label for="harga" class="block text-gray-700">Harga</label>
                <input type="number" id="harga" name="harga" required class="w-full border p-2 rounded-lg">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Tambah Layanan</button>
        </form>
    </div>
</body>
</html>
