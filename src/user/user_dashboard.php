<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); // Jika belum login, arahkan ke halaman login
    exit();
}

// Mengambil data pengguna yang login dari session
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Menyambung ke database dan mengambil gambar profil pengguna
include '../services/db.php';

// Query untuk mendapatkan data pengguna berdasarkan user_id
$query = "SELECT profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($profile_pic);
$stmt->fetch();
$stmt->close();

// Jika tidak ada gambar profil yang tersimpan, gunakan gambar default
$profile_pic = $profile_pic ? $profile_pic : 'default_profil.jpeg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>MicroServices User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Import Tailwind CSS -->
</head>
<body class="bg-gray-100 font-poppins text-gray-900">

<!-- Sidebar (Mobile Only) -->
<div id="sidebar" class="lg:hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden">
    <div class="w-64 bg-blue-500 h-full p-6">
        <a href="https://cuyjoki.vercel.app/" class="flex items-center space-x-3 mb-6">
            <img src="../img/logo.png" class="h-8" alt="Logo CuyJoki" />
            <span class="text-2xl font-poppins font-bold text-white">Micro Services</span>
        </a>
        <div class="text-white space-y-4">
            <!-- Menampilkan foto profil pengguna -->
            <img src="<?php echo htmlspecialchars("../img/uploads/$profile_pic"); ?>" class="h-12 w-12 rounded-full mb-4" alt="Profile Picture">
            <span class="text-lg font-semibold text-yellow-300 block"><?php echo htmlspecialchars($user_name); ?></span> <!-- Menonjolkan username -->
            <a href="edit_profil.php" class="block text-sm hover:text-blue-300">Edit Profil</a>
            <a href="logout.php" class="block text-sm hover:text-blue-300">Logout</a>
        </div>
    </div>  
</div>

<!-- Navbar -->
<nav class="bg-blue-500 w-auto shadow-md p-4">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center">
        <a href="https://cuyjoki.vercel.app/" class="flex items-center space-x-3">
            <img src="../img/logo.png" class="h-8" alt="Logo CuyJoki" />
            <span class="text-2xl font-poppins font-bold text-white">Micro Services</span>
        </a>
        <!-- Hamburger Menu (Visible on Mobile) -->
        <div class="lg:hidden flex items-center">
            <button id="menuButton" class="text-white text-2xl" onclick="toggleSidebar()">☰</button>
        </div>
        <!-- User Profile Section (Visible on Desktop) -->
        <div class="hidden lg:flex items-center space-x-3 text-white">
            <!-- Menampilkan foto profil pengguna -->
            <img src="<?php echo htmlspecialchars("../img/uploads/$profile_pic"); ?>" class="h-8 w-8 rounded-full" alt="Profile Picture">
            <span class="text-sm"><?php echo htmlspecialchars($user_name); ?></span>
            <a href="edit_profil.php" class="text-white text-sm hover:text-blue-300">Edit Profil</a>
            <a href="logout.php" class="text-white text-sm hover:text-blue-300">Logout</a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="max-w-screen-xl mx-auto mt-10 px-4">
    <!-- Header Section -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-700">Dashboard Pengguna</h1>
        <p class="text-gray-500">Pilih layanan yang tersedia</p>
    </div>

    <!-- Microservices List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
        <?php
        // Query untuk mendapatkan daftar microservices
        $query = "SELECT * FROM services";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                    <div class='bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105 flex flex-col items-center'>
                        <img src='../img/jasa.jpg' alt='Service Icon' class='w-16 h-16 mb-4'>
                        <h2 class='text-lg font-semibold text-gray-800 mb-3 text-center'>{$row['nama_layanan']}</h2>
                        <p class='text-sm text-gray-600 text-center mb-4 overflow-hidden text-ellipsis' style='max-height: 4rem;'>{$row['deskripsi']}</p>
                        <a href='order_service.php?id={$row['id']}' class='inline-block px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 transition duration-300'>
                            Pesan Jasa
                        </a>
                    </div>
                ";
            }
        } else {
            echo "<p class='text-center text-gray-600 col-span-full'>Tidak ada layanan tersedia saat ini.</p>";
        }

        $conn->close();
        ?>
    </div>
</div>

<!-- Footer -->
<footer class="mt-10 text-center text-gray-500">
    <div class="flex justify-center space-x-6 mb-4">
        <!-- Social Media Icons -->
        <a href="https://www.instagram.com/yourusername" target="_blank" class="text-gray-500 hover:text-blue-500">
            <img src="https://img.icons8.com/ios-filled/50/000000/instagram-new.png" alt="Instagram" class="w-6 h-6">
        </a>
        <a href="https://twitter.com/yourusername" target="_blank" class="text-gray-500 hover:text-blue-500">
            <img src="https://img.icons8.com/ios-filled/50/000000/twitter.png" alt="Twitter" class="w-6 h-6">
        </a>
        <a href="https://www.facebook.com/yourusername" target="_blank" class="text-gray-500 hover:text-blue-500">
            <img src="https://img.icons8.com/ios-filled/50/000000/facebook.png" alt="Facebook" class="w-6 h-6">
        </a>
        <a href="https://www.linkedin.com/in/yourusername" target="_blank" class="text-gray-500 hover:text-blue-500">
            <img src="https://img.icons8.com/ios-filled/50/000000/linkedin.png" alt="LinkedIn" class="w-6 h-6">
        </a>
    </div>
    <p>&copy; 2024 EvanFreelance. All rights reserved.</p>
</footer>


<!-- JavaScript to Toggle Sidebar -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('hidden');
    }

    // Close sidebar when clicked outside
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const menuButton = document.getElementById('menuButton');
        if (!sidebar.contains(event.target) && !menuButton.contains(event.target)) {
            sidebar.classList.add('hidden');
        }
    });
</script>

</body>
</html>
