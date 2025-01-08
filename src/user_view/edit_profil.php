<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); // Jika belum login, arahkan ke halaman login
    exit();
}

include '../services/db.php';

// Mengambil data pengguna yang login
$user_id = $_SESSION['user_id'];

// Ambil data pengguna dari database
$query = "SELECT username, email, password, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $password, $profile_pic);
$stmt->fetch();
$stmt->close(); // Menutup statement setelah selesai

// Variabel untuk status update
$update_success = false;

// Cek jika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    $profile_pic = $_FILES['profile_pic']['name']; // Nama file gambar
    $target_dir = "../img/uploads/"; // Direktori tujuan untuk menyimpan gambar
    $target_file = $target_dir . basename($profile_pic);

    // Proses untuk memperbarui password jika diubah
    if (!empty($new_password)) {
        $new_password = md5($new_password); // Enkripsi password baru
    } else {
        $new_password = $password; // Jika password kosong, gunakan password lama
    }

    // Proses upload gambar profil
    if (!empty($profile_pic)) {
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
            // Update gambar profil di database
            $update_query = "UPDATE users SET username = ?, email = ?, password = ?, profile_pic = ? WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ssssi", $new_username, $new_email, $new_password, $profile_pic, $user_id);
        } else {
            echo "Terjadi kesalahan saat mengupload gambar.";
        }
    } else {
        // Jika tidak ada gambar yang diupload, hanya update username, email, dan password
        $update_query = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssi", $new_username, $new_email, $new_password, $user_id);
    }

    // Eksekusi query update
    if ($stmt->execute()) {
        $_SESSION['username'] = $new_username; // Simpan username baru ke session
        $update_success = true; // Set flag success
    } else {
        echo "Terjadi kesalahan dalam memperbarui data.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Edit Profil</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-poppins text-gray-900">

    <!-- Navbar -->
    <nav class="bg-blue-500 w-auto shadow-md p-4">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center">
            <a href="user_dashboard.php" class="flex items-center space-x-3">
                <img src="../img/logo.png" class="h-8" alt="Logo">
                <span class="text-2xl font-poppins font-bold text-white">Micro Services</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-screen-xl mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold text-gray-700 text-center">Edit Profil</h1>
        <form action="edit_profil.php" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto mt-6 bg-white p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-semibold">Username</label>
                <input type="text" name="username" id="username" class="mt-2 p-2 border rounded w-full" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-semibold">Email</label>
                <input type="email" name="email" id="email" class="mt-2 p-2 border rounded w-full" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-semibold">Password</label>
                <input type="password" name="password" id="password" class="mt-2 p-2 border rounded w-full" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>
            <div class="mb-4">
                <label for="profile_pic" class="block text-gray-700 text-sm font-semibold">Gambar Profil</label>
                <input type="file" name="profile_pic" id="profile_pic" class="mt-2 p-2 border rounded w-full">
            </div>
            <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">Update Profil</button>
        </form>
    </div>

    <!-- SweetAlert Notification -->
    <?php if ($update_success): ?>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: 'Profil Anda telah diperbarui.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'user_dashboard.php';
        });
    </script>
    <?php endif; ?>

</body>
</html>
