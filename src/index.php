<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-poppins">
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-purple-400 via-pink-500 to-red-500">
        <div class="relative">
            <div class="absolute -top-2 -left-2 -right-2 -bottom-2 rounded-lg bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 shadow-lg animate-pulse"></div>
            <div class="bg-white p-16 rounded-lg shadow-2xl w-80 relative z-10">
                <div class="flex flex-col items-center justify-center mb-10">
                    <img class="h-10 mb-2" src="img/logo.png" alt="logo">
                    <h2 class="text-3xl font-bold text-gray-800 text-center">Login</h2>
                </div>
                <form class="space-y-5" method="POST" action="index.php">
                    <input class="w-full h-12 border border-gray-800 px-3 rounded-lg" placeholder="Username" id="username" name="username" required>
                    <input class="w-full h-12 border border-gray-800 px-3 rounded-lg" placeholder="Password" id="password" name="password" type="password" required>
                    <select class="w-full h-12 border border-gray-800 px-3 rounded-lg" name="role" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    <button class="w-full h-12 bg-white cursor-pointer rounded-3xl border-2 border-[#9748FF] shadow-[inset_0px_-2px_0px_1px_#9748FF] group hover:bg-[#9748FF] transition duration-300 ease-in-out">
                        <span class="font-medium text-[#333] group-hover:text-white">Login</span>
                    </button>
                </form>
                <p class="text-center mt-4">
                    Belum punya akun? 
                    <a href="register.php" class="text-blue-600 hover:underline">Daftar di sini</a>
                </p>
                <p class="text-center mt-4">
                    Lupa Password? 
                    <a href="forgot_password.php" class="text-blue-600 hover:underline">Klik Disini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
session_start();
include 'services/db.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password untuk validasi
    $role = $_POST['role']; // Ambil role dari form

    // Query berdasarkan role
    $query = "";
    if ($role === 'admin') {
        $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    } elseif ($role === 'user') {
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Login Gagal!',
                text: 'Peran tidak valid!',
                icon: 'error',
                showConfirmButton: false
            });
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 2000);
        </script>";
        exit();
    }

    $result = $conn->query($query);

    // Cek hasil query
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Ambil data user
        // Simpan data ke session
        $_SESSION['user_id'] = $row['id']; // ID pengguna
        $_SESSION['user_name'] = $row['username']; // Nama pengguna

        if ($role === 'admin') {
            $_SESSION['role'] = 'admin';
            echo "<script>
                Swal.fire({
                    title: 'Login Berhasil!',
                    text: 'Selamat Datang Admin',
                    icon: 'success',
                    showConfirmButton: false
                });
                setTimeout(function() {
                    window.location.href = 'main_dashboard.php';
                }, 2000);
            </script>";
            exit();
        } elseif ($role === 'user') {
            $_SESSION['role'] = 'user';
            echo "<script>
                Swal.fire({
                    title: 'Login Berhasil!',
                    text: 'Selamat Datang, {$row['username']}!',
                    icon: 'success',
                    showConfirmButton: false
                });
                setTimeout(function() {
                    window.location.href = 'user_view/user_dashboard.php';
                }, 2000);
            </script>";
            exit();
        }
    } else {
        // Login gagal
        echo "<script>
            Swal.fire({
                title: 'Login Gagal!',
                text: 'Username atau password salah!',
                icon: 'error',
                showConfirmButton: false
            });
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 2000);
        </script>";
    }
}
?>

