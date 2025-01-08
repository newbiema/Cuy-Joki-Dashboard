<?php
include 'services/db.php'; // Koneksi ke database

ob_start(); // Mulai output buffering

// Memeriksa apakah ID tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data berdasarkan ID menggunakan prepared statements
    $query = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);  // Mengikat parameter ID
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Memeriksa apakah form dikirim untuk mengupdate data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $status = $_POST['status'];
    
        // Validasi nilai status agar sesuai dengan enum
        $allowed_status = ['pending', 'in-progress', 'completed', 'cancelled'];
        if (!in_array($status, $allowed_status)) {
            echo "<script>
                alert('Status tidak valid!');
                window.location = 'main_dashboard.php';
            </script>";
            exit;
        }
    
        // Query update hanya untuk kolom status
        $updateQuery = "UPDATE orders SET status = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        $stmtUpdate->bind_param("si", $status, $id);
    
        if ($stmtUpdate->execute()) {
            echo "<script>
                alert('Status berhasil diupdate!');
                window.location = 'main_dashboard.php';
            </script>";
        } else {
            echo "<script>
                alert('Gagal mengupdate status: " . $stmtUpdate->error . "');
            </script>";
        }
    }
    
    
} else {
    header("Location: main_dashboard.php");
    exit;
}

ob_end_flush(); // Menyelesaikan output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Status Order</title>
    <link href="css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-poppins">

    <!-- Container -->
    <div class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-lg mt-8">

        <h2 class="text-3xl font-semibold text-center text-gray-700 mb-6">Edit Status Order</h2>

        <!-- Form -->
        <form method="POST" action="">

            <div class="space-y-4">
                <!-- User ID -->
                <div>
                    <label for="user_id" class="block text-gray-700 font-semibold">User ID:</label>
                    <p class="bg-gray-100 px-4 py-2 rounded-md"><?php echo htmlspecialchars($row['user_id']); ?></p>
                </div>

                <!-- Nama Service -->
                <div>
                    <label for="service_id" class="block text-gray-700 font-semibold">Pilih Jasa:</label>
                    <p class="bg-gray-100 px-4 py-2 rounded-md">
                        <?php
                            // Menampilkan detail nama layanan
                            $serviceQuery = "SELECT nama_layanan, harga FROM services WHERE id = ?";
                            $stmtService = $conn->prepare($serviceQuery);
                            $stmtService->bind_param("i", $row['service_id']);
                            $stmtService->execute();
                            $serviceResult = $stmtService->get_result();
                            $serviceDetail = $serviceResult->fetch_assoc();

                            echo htmlspecialchars($serviceDetail['nama_layanan']) . " - Rp " . number_format($serviceDetail['harga'], 0, ',', '.');
                        ?>
                    </p>
                </div>

                <!-- Nama Layanan -->
                <div>
                    <label for="nama_service" class="block text-gray-700 font-semibold">Nama Service:</label>
                    <p class="bg-gray-100 px-4 py-2 rounded-md"><?php echo htmlspecialchars($row['nama_service']); ?></p>
                </div>

                <!-- Tanggal Pemesanan -->
                <div>
                    <label for="order_date" class="block text-gray-700 font-semibold">Tanggal Pemesanan:</label>
                    <p class="bg-gray-100 px-4 py-2 rounded-md"><?php echo htmlspecialchars($row['order_date']); ?></p>
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-gray-700 font-semibold">Deadline:</label>
                    <p class="bg-gray-100 px-4 py-2 rounded-md"><?php echo htmlspecialchars($row['deadline']); ?></p>
                </div>

                <!-- Total Harga -->
                <div>
                    <label for="total_price" class="block text-gray-700 font-semibold">Total Harga:</label>
                    <p class="bg-gray-100 px-4 py-2 rounded-md"><?php echo "Rp " . number_format($row['total_price'], 0, ',', '.'); ?></p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-gray-700 font-semibold">Status:</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="in-progress" <?php echo $row['status'] == 'in-progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="completed" <?php echo $row['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo $row['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>

                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-md hover:bg-blue-600">Update Status</button>
                    <a href="main_dashboard.php" class="bg-red-600 text-white font-semibold py-2 px-6 rounded-md hover:bg-red-700">Batal</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
