


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/output.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <!-- Pastikan script SweetAlert2 dimuat -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>   
</head>
<body class="font-poppins">
 <!-- Background gradient with pulsating animation -->
 <div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-purple-400 via-pink-500 to-red-500">
  <div class="relative">
    <div class="absolute -top-2 -left-2 -right-2 -bottom-2 rounded-lg bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 shadow-lg animate-pulse"></div>
    <div id="form-container" class="bg-white p-16 rounded-lg shadow-2xl w-80 relative z-10 transform transition duration-500 ease-in-out">
        <div class="flex flex-col items-center justify-center mb-10">
            <img class="h-10 mb-2" src="img/logo.png" alt="logo">
            <h2 id="form-title" class="text-3xl font-bold text-gray-800 text-center">
                Login
            </h2>
        </div>

      <form class="space-y-5" method="POST" action="login.php">
        <input class="w-full h-12 border border-gray-800 px-3 rounded-lg" placeholder="username" id="username" name="username" >
        <input class="w-full h-12 border border-gray-800 px-3 rounded-lg" placeholder="Password" id="password" name="password" type="password" required>
        
        <button class="w-full h-12 bg-white cursor-pointer rounded-3xl border-2 border-[#9748FF] shadow-[inset_0px_-2px_0px_1px_#9748FF] group hover:bg-[#9748FF] transition duration-300 ease-in-out">
        <span class="font-medium text-[#333] group-hover:text-white">Login Admin</span>
        </button>
        <p class="w-full text-center  cursor-pointer p-2 rounded-3xl border-2 border-[#9748FF] shadow-[inset_0px_-2px_0px_1px_#9748FF] group hover:bg-[#9748FF] transition duration-300 ease-in-out">
            <a href="https://cuyjoki.vercel.app/">Login User</a>
        </p>
      </form>
    </div>
  </div>
</div> 
</body>

<?php
session_start();
include 'services/db.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // hash password

    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result) { // Mengecek apakah query berhasil dieksekusi
        if ($result->num_rows > 0) {
            $_SESSION['admin'] = $username; // Set session admin
            echo "<script>
            Swal.fire({
                title: 'Login Berhasil!',
                text: 'Selamat Datang Admin',
                icon: 'success',
                showConfirmButton: false // Menyembunyikan tombol konfirmasi
            });
            setTimeout(function() {
                window.location.href = 'index.php'; // Redirect ke login.php setelah 2 detik
            }, 2000); // 2000ms = 2 detik
          </script>";
            exit();
        } else {
            // Login gagal, tampilkan SweetAlert selama 2 detik
            echo "<script>
                    Swal.fire({
                        title: 'Login Gagal!',
                        text: 'Username atau password salah!',
                        icon: 'error',
                        showConfirmButton: false // Menyembunyikan tombol konfirmasi
                    });
                    setTimeout(function() {
                        window.location.href = 'login.php'; // Redirect ke login.php setelah 2 detik
                    }, 2000); // 2000ms = 2 detik
                  </script>";
        }
    } else {
        echo "Error pada query: " . $conn->error; // Menampilkan error jika ada masalah pada query
    }
}
?>

</html>
