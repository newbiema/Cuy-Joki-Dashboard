<?php
session_start();
include '../services/db.php';

// Pastikan pengguna login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];

    // Ambil nama layanan dan harga dari tabel services
    $query = "SELECT nama_layanan, harga FROM services WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $stmt->bind_result($nama_service, $total_price);
    $stmt->fetch();
    $stmt->close();

    // Simpan pesanan ke tabel orders
    $order_date = date('Y-m-d'); // Tanggal hari ini
    $deadline = date('Y-m-d', strtotime('+7 days')); // Tenggat waktu 7 hari ke depan
    $query = "INSERT INTO orders (user_id, service_id, nama_service, order_date, deadline, total_price) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisssd", $user_id, $service_id, $nama_service, $order_date, $deadline, $total_price);

    if ($stmt->execute()) {
        $message = "Pesanan berhasil dibuat!";
    } else {
        $message = "Terjadi kesalahan saat memproses pesanan Anda.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Jasa</title>
    <link rel="stylesheet" href="../css/output.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Pesan Jasa</h1>

    <?php if (!empty($message)): ?>
        <script>
            Swal.fire({
                title: "<?php echo $message === 'Pesanan berhasil dibuat!' ? 'Berhasil!' : 'Gagal!'; ?>",
                text: "<?php echo $message; ?>",
                icon: "<?php echo $message === 'Pesanan berhasil dibuat!' ? 'success' : 'error'; ?>",
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "user_dashboard.php";
                }
            });
        </script>
    <?php endif; ?>

    <form method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="service_id" class="block mb-2 font-medium">Pilih Jasa</label>
            <select name="service_id" id="service_id" class="block w-full border-gray-300 rounded" onchange="updatePrice()">
                <option value="" data-price="0">-- Pilih Layanan --</option>
                <?php
                // Ambil daftar jasa dari database
                $query = "SELECT id, nama_layanan, harga FROM services";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}' data-price='{$row['harga']}'>{$row['nama_layanan']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="price" class="block mb-2 font-medium">Harga</label>
            <input type="text" id="price" class="block w-full border-gray-300 rounded bg-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label for="order_date" class="block mb-2 font-medium">Tanggal Pemesanan</label>
            <input type="date" name="order_date" id="order_date" class="block w-full border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="deadline" class="block mb-2 font-medium">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="block w-full border-gray-300 rounded" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Pesan</button>
    </form>
</div>

<script>
    function updatePrice() {
        const serviceSelect = document.getElementById('service_id');
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        document.getElementById('price').value = `Rp ${parseInt(price).toLocaleString('id-ID')}`;
    }
</script>
</body>
</html>
