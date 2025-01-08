<?php
include '../services/db.php'; // Koneksi ke database

ob_start(); // Mulai output buffering

// Memeriksa apakah ID tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data berdasarkan ID
    $query = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    // Memeriksa apakah form dikirim untuk mengupdate data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password=md5($_POST['password']) ;


        // Query update data
        $updateQuery = "UPDATE users SET username='$username', password='$password' WHERE id = $id";
        
        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>
                alert('Data berhasil diupdate!');
                window.location = 'user_tabel.php';
            </script>";
        } else {
            echo "<script>
                alert('Gagal mengupdate data: " . $conn->error . "');
            </script>";
        }
    }
} else {
    header("Location: user_tabel.php");
    exit;
}

ob_end_flush(); // Menyelesaikan output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data User</title>
    <link href="../css/output.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body class="bg-gray-100 font-poppins">

    <!-- Container -->
    <div class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-lg mt-8">

        <h2 class="text-3xl font-semibold text-center text-gray-700 mb-6">Edit Data users</h2>

        <!-- Form -->
        <form method="POST" action="">
            <div class="space-y-4">
                <!-- Username -->
                <div>
                    <label for="username" class="block text-gray-700 font-semibold">Username:</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($row['username']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 font-semibold">Password:</label>
                    <input type="text" name="password" id="password" value="<?php echo htmlspecialchars($row['password']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>



                <!-- Buttons -->
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-md hover:bg-blue-600">Update Data</button>
                    <a href="user_tabel.php" class="bg-red-600 text-white font-semibold py-2 px-6 rounded-md hover:bg-red-700">Batal</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
