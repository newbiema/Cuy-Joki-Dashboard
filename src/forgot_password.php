
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-poppins">
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-purple-400 via-pink-500 to-red-500">
        <div class="relative">
            <div class="absolute -top-2 -left-2 -right-2 -bottom-2 rounded-lg bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 shadow-lg animate-pulse"></div>
            <div class="bg-white p-16 rounded-lg shadow-2xl w-80 relative z-10">
                <div class="flex flex-col items-center justify-center mb-10">
                    <img class="h-10 mb-2" src="img/logo.png" alt="logo">
                    <h2 class="text-3xl font-bold text-gray-800 text-center">Lupa Password</h2>
                </div>
                <form class="space-y-5" method="POST" action="forgot_password.php">
                    <input class="w-full h-12 border border-gray-800 px-3 rounded-lg" placeholder="Email" id="email" name="email" type="email" required>
                    <button class="w-full h-12 bg-white cursor-pointer rounded-3xl border-2 border-[#9748FF] shadow-[inset_0px_-2px_0px_1px_#9748FF] group hover:bg-[#9748FF] transition duration-300 ease-in-out">
                        <span class="font-medium text-[#333] group-hover:text-white">Kirim Password Baru</span>
                    </button>
                </form>
                <p class="text-center mt-4">
                    Kembali ke <a href="index.php" class="text-blue-600 hover:underline">Login</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
session_start();
require __DIR__ . '/../vendor/autoload.php'; // Autoload Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Koneksi database
include 'services/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Cari user berdasarkan email
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];

        // Generate password baru
        $new_password = bin2hex(random_bytes(4)); // Password acak 8 karakter
        $hashed_password = md5($new_password); // Hash password baru

        // Update password di database
        $update_query = "UPDATE users SET password='$hashed_password' WHERE email='$email'";
        if ($conn->query($update_query)) {
            // Kirim email dengan password baru
            $mail = new PHPMailer(true);

            try {
                // Konfigurasi SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Host SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'evanjamaq123@gmail.com'; // Ganti dengan email Anda
                $mail->Password = 'dtto ulgb ntal cnkp';       // Ganti dengan password email Anda
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Pengirim dan penerima
                $mail->setFrom('evanjamaq123@gmail.com', 'Admin CuyJoki');
                $mail->addAddress($email, $username);

                // Konten email
                $mail->isHTML(true);
                $mail->Subject = 'Password Baru Anda';
                $mail->Body = "Halo $username,<br><br>Berikut adalah password baru Anda: <strong>$new_password</strong><br><br>Silakan login menggunakan password ini dan ganti password Anda segera setelah login.";

                $mail->send();

                echo "<script>
                    alert('Password baru telah dikirim ke email Anda.');
                    window.location.href = 'index.php';
                </script>";
            } catch (Exception $e) {
                echo "<script>
                    alert('Gagal mengirim email: {$mail->ErrorInfo}');
                    window.location.href = 'forgot_password.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Gagal memperbarui password.');
                window.location.href = 'forgot_password.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Email yang Anda masukkan tidak terdaftar.');
            window.location.href = 'forgot_password.php';
        </script>";
    }
}
?>



