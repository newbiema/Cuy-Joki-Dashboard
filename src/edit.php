<?php
include 'services/db.php'; // Koneksi ke database

ob_start(); // Mulai output buffering

// Memeriksa apakah ID tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data berdasarkan ID
    $query = "SELECT * FROM daftar_joki WHERE id = $id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    // Memeriksa apakah form dikirim untuk mengupdate data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_klien = $_POST['nama_klien'];
        $jasa = $_POST['jasa'];
        $deadline = $_POST['deadline'];
        $harga = $_POST['harga'];
        $status = $_POST['status'];

        // Query update data
        $updateQuery = "UPDATE daftar_joki SET nama_klien='$nama_klien', jasa='$jasa', deadline='$deadline', harga='$harga', status='$status' WHERE id = $id";
        
        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>
                alert('Data berhasil diupdate!');
                window.location = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Gagal mengupdate data: " . $conn->error . "');
            </script>";
        }
    }
} else {
    header("Location: index.php");
    exit;
}

ob_end_flush(); // Menyelesaikan output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Joki Tugas</title>
    <link href="css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-poppins">

    <!-- Container -->
    <div class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-lg mt-8">

        <h2 class="text-3xl font-semibold text-center text-gray-700 mb-6">Edit Data Freelance</h2>

        <!-- Form -->
        <form method="POST" action="">
            <div class="space-y-4">
                <!-- Nama Klien -->
                <div>
                    <label for="nama_klien" class="block text-gray-700 font-semibold">Nama Klien:</label>
                    <input type="text" name="nama_klien" id="nama_klien" value="<?php echo htmlspecialchars($row['nama_klien']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <!-- Jasa -->
                <div>
                    <label for="jasa" class="block text-gray-700 font-semibold">Jasa:</label>
                    <input type="text" name="jasa" id="jasa" value="<?php echo htmlspecialchars($row['jasa']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-gray-700 font-semibold">Deadline:</label>
                    <input type="date" name="deadline" id="deadline" value="<?php echo htmlspecialchars($row['deadline']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-gray-700 font-semibold">Harga:</label>
                    <input type="number" name="harga" id="harga" value="<?php echo htmlspecialchars($row['harga']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-gray-700 font-semibold">Status:</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="Pending" <?php echo $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Dalam Proses" <?php echo $row['status'] == 'Dalam Proses' ? 'selected' : ''; ?>>Dalam Proses</option>
                        <option value="Selesai" <?php echo $row['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-md hover:bg-blue-600">Update Data</button>
                    <a href="index.php" class="bg-red-600 text-white font-semibold py-2 px-6 rounded-md hover:bg-red-700">Batal</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
