<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
   
    <title>Tambah Data Joki Tugas</title>
</head>
<body class="bg-gray-100 font-poppins">

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
                
            <button class="bg-red-600 rounded-lg p-3 border-red-600 text-white hover:bg-red-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"><a href="index.php">Batal</a></button>
            </div>
        </form>
    </div>


 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/main.js" ></script>
</body>

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
            echo "<script>
                Swal.fire({
                    title: 'Data berhasil ditambahkan!',
                    icon: 'success',
                    showConfirmButton: false, // Menyembunyikan tombol konfirmasi
                    timer: 2000 // Menampilkan alert selama 2 detik
                }).then(function() {
                    window.location.href = 'index.php'; // Redirect ke index.php setelah SweetAlert selesai
                });
            </script>";
        } else {
            echo "Gagal menambah data: " . $conn->error;
        }
    }
    ?>

</html>
