<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>Admin Dashboard</title>
</head>
<body class="bg-gray-100 font-poppins text-gray-900">
    <!-- Navbar -->
    <nav class="bg-blue-500 w-auto shadow-md p-4">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center">
            <a href="" class="flex items-center space-x-3">
                <img src="img/logo.png" class="h-8" alt="Logo CuyJoki" />
                <span class="text-2xl font-poppins font-bold text-white">CuySolutions</span>
            </a>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="flex max-w-screen-xl mx-auto mt-10">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-200 p-6 shadow-md rounded-l-lg text-white space-y-6">
            <div class="text-center">
                <h2 class="text-xl text-black font-bold">Admin Menu</h2>
            </div>
            <ul class="space-y-4 text-black">
                <li>
                    <a href="index.php" class="flex bg-white items-center space-x-3 hover:bg-blue-700 hover:text-white p-3 rounded-lg transition-colors">
                        <img src="img/home.png" class="h-5" alt="icon home"> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="admin/admin_tabel.php" class="flex items-center space-x-3 hover:bg-blue-700 p-3 rounded-lg transition-colors">
                        <img src="img/admin.png" class="h-5" alt="icon services"> <span>Lihat Admin</span>
                    </a>
                </li>
                <li>
                    <a href="user_tabel/user_tabel.php" class="flex items-center space-x-3 hover:bg-blue-700 p-3 rounded-lg transition-colors">
                        <img src="img/user.png" class="h-5" alt="icon services"> <span>Lihat User</span>
                    </a>
                </li>
                <li>
                    <a href="layanan/services_table.php" class="flex items-center space-x-3 hover:bg-blue-700 p-3 rounded-lg transition-colors">
                        <img src="img/services.png" class="h-5" alt="icon add service"> <span>Lihat Services</span>
                    </a>
                </li>
                <li>
                    <a href="index.php" class="flex items-center space-x-3 hover:bg-blue-700 p-3 rounded-lg transition-colors">
                        <img src="img/logout.png" class="h-5" alt="icon logout"> <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 p-6 bg-white rounded-r-lg shadow-md">
            <!-- Header Section -->
            <div class="mb-4 text-center">
                <h1 class="text-3xl font-poppins font-medium text-gray-700">Daftar Micro Services</h1>
            </div>

            <!-- Tabel Daftar Orders -->
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th class="px-6 py-3">Order ID</th>
                            <th class="px-6 py-3">Customer Name</th>
                            <th class="px-6 py-3">Nama Jasa</th>
                            <th class="px-6 py-3">Order Date</th>
                            <th class="px-6 py-3">Deadline</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Harga</th>
                            <th class="px-6 py-3">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'services/db.php';

                        // Query untuk mengambil data dari tabel orders
                        $query = "SELECT orders.id, orders.user_id, users.username, orders.nama_service, orders.order_date, orders.deadline, orders.total_price, orders.status
                            FROM orders
                            INNER JOIN users ON orders.user_id = users.id";


                        $result = $conn->query($query);

                        // Memeriksa apakah ada data orders
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='bg-white border-b hover:bg-gray-100 transition duration-150'>";
                                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['username']) . "</td>"; // Menampilkan username
                                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['nama_service']) . "</td>";
                                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['order_date']) . "</td>";
                                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['deadline']) . "</td>";
                                

                                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['total_price']) . "</td>";
                                echo "<td class='px-6 py-4 space-x-2'>
                                        <a href='edit.php?id=" . urlencode($row['id']) . "' class='text-blue-500 hover:text-blue-700'><img class='h-5' src='img/edit.png' alt='icon edit'></a>
                                        <a href='delete.php?id=" . urlencode($row['id']) . "' class='text-red-500 hover:text-red-700 delete-link'><img class='h-5' src='img/delete.png' alt='icon delete'></a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-4 text-gray-600'>Tidak ada data orders.</td></tr>";
                            }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Display Total Pendapatan -->
            <div class="mt-4 text-center p-4 bg-gray-100 rounded-md text-lg font-bold text-black">
                Total Pendapatan: Rp. <?php echo isset($totalPendapatan) ? number_format($totalPendapatan, 0, ',', '.') : '0'; ?>
            </div>
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

    <!-- SweetAlert untuk konfirmasi hapus -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteLinks = document.querySelectorAll('.delete-link');

        deleteLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const id = link.getAttribute('href').split('=')[1];

                Swal.fire({
                    title: "Apakah kamu yakin?",
                    text: "Data ini akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `delete_order.php?id=${id}`;
                    }
                });
            });
        });
    });
    </script>
</body>
</html>
