Swal.fire({
    title: 'Data berhasil ditambahkan!',
    icon: 'success',
    showConfirmButton: false, // Menyembunyikan tombol konfirmasi
    timer: 2000 // Menampilkan alert selama 5 detik
}).then(function() {
    // Setelah SweetAlert selesai, baru lakukan redirect
    setTimeout(function() {
        window.location.href = 'index.php'; // Redirect ke index.php setelah 5 detik
    }, 1000); // 5000ms = 5 detik
});
