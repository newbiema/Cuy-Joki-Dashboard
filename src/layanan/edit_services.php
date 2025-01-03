<?php
include '../services/db.php'; // Koneksi ke database

ob_start(); // Mulai output buffering

// Memeriksa apakah ID tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data layanan berdasarkan ID menggunakan prepared statements
    $query = "SELECT * FROM services WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);  // Mengikat parameter ID
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Memeriksa apakah form dikirim untuk mengupdate data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_layanan = $_POST['nama_layanan'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];

        // Query update data menggunakan prepared statement
        $updateQuery = "UPDATE services SET nama_layanan = ?, deskripsi = ?, harga = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        $stmtUpdate->bind_param("ssdi", $nama_layanan, $deskripsi, $harga, $id);

        if ($stmtUpdate->execute()) {
            echo "<script>
                alert('Data layanan berhasil diupdate!');
                window.location = 'services_table.php';
            </script>";
        } else {
            echo "<script>
                alert('Gagal mengupdate data: " . $stmtUpdate->error . "');
            </script>";
        }
    }
} else {
    header("Location: services_table.php");
    exit;
}

ob_end_flush(); // Menyelesaikan output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Layanan</title>
    <link href="../css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-poppins">

    <!-- Container -->
    <div class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-lg mt-8">

        <h2 class="text-3xl font-semibold text-center text-gray-700 mb-6">Edit Layanan</h2>

        <!-- Form -->
        <form method="POST" action="">

            <div class="space-y-4">
                <!-- Nama Layanan -->
                <div>
                    <label for="nama_layanan" class="block text-gray-700 font-semibold">Nama Layanan:</label>
                    <input type="text" name="nama_layanan" id="nama_layanan" value="<?php echo htmlspecialchars($row['nama_layanan']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <!-- Deskripsi Layanan -->
                <div>
                    <label for="deskripsi" class="block text-gray-700 font-semibold">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>
                </div>

                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-gray-700 font-semibold">Harga:</label>
                    <input type="number" name="harga" id="harga" value="<?php echo htmlspecialchars($row['harga']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-md hover:bg-blue-600">Update Layanan</button>
                    <a href="services_table.php" class="bg-red-600 text-white font-semibold py-2 px-6 rounded-md hover:bg-red-700">Batal</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
