<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>MicroServices Dashboard</title>
</head>
<body class="bg-gray-100 font-poppins text-gray-900">
    <!-- Navbar -->
    <nav class="bg-blue-500 shadow-md p-4">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center">
            <a href="https://cuyjoki.vercel.app/" class="flex items-center space-x-3">
                <img src="img/logo.png" class="h-8" alt="Logo CuyJoki" />
                <span class="text-2xl font-poppins font-bold text-white">CuyJoki</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex max-w-screen-xl mx-auto mt-10">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-600 text-white p-6 shadow-md rounded-l-lg space-y-6">
            <div class="text-center">
                <h2 class="text-xl font-bold">Admin Menu</h2>
            </div>
            <ul class="space-y-4">
                <li>
                    <a href="dashboard.php" class="flex items-center space-x-3 hover:bg-blue-700 p-3 rounded-lg transition-colors">
                        <img src="img/home.png" class="h-5" alt="icon home"> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="create.php" class="flex items-center space-x-3 hover:bg-blue-700 p-3 rounded-lg transition-colors">
                        <img src="img/add.png" class="h-5" alt="icon add"> <span>Tambah Data</span>
                    </a>
                </li>
                <li>
                    <a href="add_admin.php" class="flex items-center space-x-3 hover:bg-blue-700 p-3 rounded-lg transition-colors">
                        <img src="img/services.png" class="h-5" alt="icon services"> <span>Tambah Admin</span>
                    </a>
                </li>
                <li>
                    <a href="login.php" class="flex items-center space-x-3 hover:bg-blue-700 p-3 rounded-lg transition-colors">
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

            <!-- Tabel Daftar Joki -->
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th class="px-6 py-3">Nama Klien</th>
                            <th class="px-6 py-3">Jasa</th>
                            <th class="px-6 py-3">Deadline</th>
                            <th class="px-6 py-3">Harga</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'services/db.php';

                        // Query untuk menampilkan daftar joki
                        $query = "SELECT * FROM daftar_joki";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='bg-white border-b hover:bg-gray-100 transition duration-150'>";
                                echo "<td class='px-6 py-4'>" . $row['nama_klien'] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row['jasa'] . "</td>";
                                echo "<td class='px-6 py-4'>" . $row['deadline'] . "</td>";
                                echo "<td class='px-6 py-4'>" . number_format($row['harga'], 0, ',', '.') . "</td>";
                                echo "<td class='px-6 py-4'>" . $row['status'] . "</td>";
                                echo "<td class='px-6 py-4 space-x-2'>
                                        <a href='edit.php?id=" . $row['id'] . "' class='text-blue-500 hover:text-blue-700'><img class='h-5' src='img/edit.png' alt='icon edit'></a>
                                        <a href='delete.php?id=" . $row['id'] . "' class='text-red-500 hover:text-red-700 delete-link'><img class='h-5' src='img/delete.png' alt='icon delete'></a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center py-4 text-gray-600'>Tidak ada data joki tugas.</td></tr>";
                        }

                        // Query untuk menghitung total pendapatan
                        $queryTotal = "SELECT SUM(harga) AS total_pendapatan FROM daftar_joki";
                        $resultTotal = $conn->query($queryTotal);
                        $totalPendapatan = $resultTotal->fetch_assoc()['total_pendapatan'];

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Display Total Pendapatan -->
            <div class="mt-4 p-4 bg-gray-100 rounded-md text-lg font-bold text-black">
                Total Pendapatan: Rp. <?php echo number_format($totalPendapatan, 0, ',', '.'); ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-10 text-center text-gray-500">
        <p>&copy; 2024 EvanFreelance. All rights reserved.</p>
    </footer>

    <!-- SweetAlert untuk konfirmasi hapus -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteLinks = document.querySelectorAll('.delete-link');
        
        deleteLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah navigasi default
                const id = link.getAttribute('href').split('=')[1]; // Ambil ID dari href

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
                        window.location.href = `delete.php?id=${id}`;
                    }
                });
            });
        });
    });
    </script>
</body>
</html>
