<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/output.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-poppins">
<!-- Background gradient with pulsating animation -->
<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 via-green-500 to-teal-500">
    <div class="relative">
        <div class="absolute -top-2 -left-2 -right-2 -bottom-2 rounded-lg bg-gradient-to-r from-blue-400 via-green-500 to-teal-500 shadow-lg animate-pulse"></div>
        <div id="form-container" class="bg-white p-16 rounded-lg shadow-2xl w-80 relative z-10">
            <div class="flex flex-col items-center justify-center mb-10">
                <img class="h-10 mb-2" src="img/logo.png" alt="logo">
                <h2 id="form-title" class="text-3xl font-bold text-gray-800 text-center">
                    Register
                </h2>
            </div>

            <form class="space-y-5" method="POST" action="register.php">
                <input class="w-full h-12 border border-gray-800 px-3 rounded-lg" placeholder="Username" id="username" name="username" required>
                <input class="w-full h-12 border border-gray-800 px-3 rounded-lg" placeholder="Email" id="email" name="email" type="email" required>
                <input class="w-full h-12 border border-gray-800 px-3 rounded-lg" placeholder="Password" id="password" name="password" type="password" required>
                <button class="w-full h-12 bg-white cursor-pointer rounded-3xl border-2 border-[#9748FF] shadow-[inset_0px_-2px_0px_1px_#9748FF] group hover:bg-[#9748FF] transition duration-300 ease-in-out">
                    Register
                </button>
            </form>
        </div>
    </div>
</div>
</body>

<?php
include 'services/db.php'; // Koneksi ke database

session_start(); // Memulai session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash password

    // Cek apakah username atau email sudah digunakan
    $query_check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result_check = $conn->query($query_check);

    if ($result_check->num_rows > 0) {
        echo "<script>
                Swal.fire({
                    title: 'Registrasi Gagal!',
                    text: 'Username atau Email sudah digunakan!',
                    icon: 'error',
                    showConfirmButton: false
                });
                setTimeout(function() {
                    window.location.href = 'register.php';
                }, 2000);
              </script>";
    } else {
        // Insert data ke database
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($query) === TRUE) {
            // Ambil data pengguna yang baru didaftarkan
            $user_id = $conn->insert_id; // ID pengguna yang baru
            $_SESSION['user_id'] = $user_id; // Menyimpan ID pengguna ke session
            $_SESSION['user_name'] = $username; // Menyimpan username ke session
            $_SESSION['email'] = $email; // Menyimpan email ke session

            echo "<script>
                    Swal.fire({
                        title: 'Registrasi Berhasil!',
                        text: 'Silakan login menggunakan akun Anda.',
                        icon: 'success',
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        window.location.href = 'user/user_dashboard.php'; // Arahkan ke dashboard setelah registrasi berhasil
                    }, 2000);
                  </script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

</html>
