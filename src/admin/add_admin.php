<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
   
    <title>Tambah Data Admin</title>
</head>
<body class="bg-gray-100 font-poppins">

    <!-- Header -->
    <div class="bg-blue-600 text-white py-4 text-center">
        <h1 class="text-3xl font-bold">Tambah Data Admin</h1>
    </div>

    <!-- Form Section -->
    <div class="max-w-lg mx-auto bg-white p-8 mt-8 rounded-lg shadow-md">
        <form method="POST" action="" class="space-y-6">
            <div>
                <label for="username" class="block text-gray-700">Username Admin</label>
                <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label for="password" class="block text-gray-700">Password:</label>
                <input type="text" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="flex justify-between">
            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah Data</button>
                
            <button class="bg-red-600 rounded-lg p-3 border-red-600 text-white hover:bg-red-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"><a href="admin_tabel.php">Batal</a></button>
            </div>
        </form>
    </div>


 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/main.js" ></script>
</body>

<?php
    include '../services/db.php'; // Koneksi ke database

    // Menyimpan data ketika form dikirim
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = md5($_POST['password']); // hash password


        // Query untuk menambah data baru
        $query = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

        if ($conn->query($query) === TRUE) {
            echo "<script>
                Swal.fire({
                    title: 'Data berhasil ditambahkan!',
                    icon: 'success',
                    showConfirmButton: false, // Menyembunyikan tombol konfirmasi
                    timer: 2000 // Menampilkan alert selama 2 detik
                }).then(function() {
                    window.location.href = 'admin_tabel.php'; // Redirect ke admin_table.php setelah SweetAlert selesai
                });
            </script>";
        } else {
            echo "Gagal menambah data: " . $conn->error;
        }
    }
    ?>

</html>
