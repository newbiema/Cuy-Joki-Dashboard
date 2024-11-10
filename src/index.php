<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <title>CuyJoki Dashboard</title>
</head>
<body class="bg-gray-100 font-poppins text-gray-900">
    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center">
            <a href="#" class="flex items-center space-x-3">
                <img src="img/logo.png" class="h-8" alt="Logo CuyJoki" />
                <span class="text-2xl font-bold text-gray-800">CuyJoki</span>
            </a>
        </div>
    </nav>

    <!-- Container -->
    <div class="max-w-screen-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-semibold text-gray-700">Daftar Joki Tugas</h1>
            <a href="create.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
                Tambah Data
            </a>
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
                    $query = "SELECT * FROM daftar_joki";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='bg-white border-b hover:bg-gray-100 transition duration-150'>";
                            echo "<td class='px-6 py-4'>" . $row['nama_klien'] . "</td>";
                            echo "<td class='px-6 py-4'>" . $row['jasa'] . "</td>";
                            echo "<td class='px-6 py-4'>" . $row['deadline'] . "</td>";
                            echo "<td class='px-6 py-4'>" . $row['harga'] . "</td>";
                            echo "<td class='px-6 py-4'>" . $row['status'] . "</td>";
                            echo "<td class='px-6 py-4 space-x-2'>
                                    <a href='edit.php?id=" . $row['id'] . "' class=' text-blue-500 hover:text-blue-700'><img class='h-5' src='img/edit.png' alt='icon edit'></a>
                                    <a href='delete.php?id=" . $row['id'] . "' class=' text-red-500 hover:text-red-700' onclick='deleteData()'><img class='h-5' src='img/delete.png' alt='icon delete'></a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center py-4 text-gray-600'>Tidak ada data joki tugas.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-10 text-center text-gray-500">
        <p>&copy; 2024 CuyJoki. All rights reserved.</p>
    </footer>

    

    

    
    <script src="js/main.js" ></script>
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>
