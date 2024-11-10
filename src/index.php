<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>CuyJoki Dashboard</title>
</head>
<body class="bg-gray-100 font-poppins text-gray-900">
    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center">
            <a href="https://cuyjoki.vercel.app/" class="flex items-center space-x-3">
                <img src="img/logo.png" class="h-8" alt="Logo CuyJoki" />
                <span class="text-2xl font-poppins font-bold text-gray-800">CuyJoki</span>
            </a>

            <a class="text-xs" href="login.php">
                <img class="h-5 items-center" src="img/logout.png" alt="">Log Out</a>
        </div>
    </nav>

    <!-- Container -->
    <div class="max-w-screen-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <!-- Header Section -->
        <div class=" items-center mb-4">
            <h1 class="text-3xl font-poppins text-center font-medium text-gray-700">Daftar Joki Tugas</h1>
        </div>
        <div class="">
            <button class=" flex justify-center gap-2 items-center mx-auto shadow-xl text-xs bg- backdrop-blur-md lg:font-semibold isolation-auto border-gray-50 before:absolute before:w-full before:transition-all before:duration-700 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-blue-500 hover:text-gray-50 before:-z-10 before:aspect-square before:hover:scale-150 before:hover:duration-700 relative z-10 px-4 py-2 overflow-hidden border-2 rounded-full group">
            <a href="create.php" >Tambah Data</a>
            <svg
                class="w-8 h-8 justify-end group-hover:rotate-90 group-hover:bg-gray-50 text-gray-50 ease-linear duration-300 rounded-full border border-gray-700 group-hover:border-none p-2 rotate-45"
                viewBox="0 0 16 19"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                class="fill-gray-800 group-hover:fill-gray-800"
                ></path>
            </svg>
            </button>
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
            
                    // Cek apakah ada data
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
                                    <a href='delete.php?id=" . $row['id'] . "' class=' text-red-500 hover:text-red-700 delete-link''><img class='h-5' src='img/delete.png' alt='icon delete'></a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>
