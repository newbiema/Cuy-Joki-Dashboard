<?php
include 'services/db.php'; // Koneksi ke database

// Menyimpan data ketika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_klien = $_POST['nama_klien'];
    $jasa = $_POST['jasa'];
    $deadline = $_POST['deadline'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    // Query untuk menambah data baru
    $query = "INSERT INTO daftar_joki (nama_klien, jasa, deadline, harga, status) VALUES ('$nama_klien', '$jasa', '$deadline', '$harga', '$status')";

    if ($conn->query($query) === TRUE) {
        header("Location: index.php"); // Redirect ke halaman utama setelah berhasil menambah data
    } else {
        echo "Gagal menambah data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <title>Tambah Data Joki Tugas</title>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <div class="bg-blue-600 text-white py-4 text-center">
        <h1 class="text-3xl font-bold">Tambah Data Joki Tugas</h1>
    </div>

    <!-- Form Section -->
    <div class="max-w-lg mx-auto bg-white p-8 mt-8 rounded-lg shadow-md">
        <form method="POST" action="" class="space-y-6">
            <div>
                <label for="nama_klien" class="block text-gray-700">Nama Klien:</label>
                <input type="text" id="nama_klien" name="nama_klien" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="jasa" class="block text-gray-700">Jasa:</label>
                <input type="text" id="jasa" name="jasa" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="deadline" class="block text-gray-700">Deadline:</label>
                <input type="date" id="deadline" name="deadline" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="harga" class="block text-gray-700">Harga:</label>
                <input type="number" id="harga" name="harga" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="status" class="block text-gray-700">Status:</label>
                <select id="status" name="status" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Pending">Pending</option>
                    <option value="Dalam Proses">Dalam Proses</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah Data</button>
                <a href="index.php" class="text-blue-600 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Batal</a>
            </div>
        </form>
    </div>

</body>
</html>
