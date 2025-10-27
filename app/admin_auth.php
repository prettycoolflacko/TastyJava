<?php
// File ini akan di-include di setiap halaman admin
// 1. Pastikan config sudah di-include (untuk memulai session dan koneksi DB)
require_once __DIR__ . '/../config/config.php';

// 2. Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, tendang ke halaman login
    header("Location: /tasty_java/public/login.php?error=Anda harus login");
    exit();
}

// 3. Cek apakah rolenya adalah 'admin'
if ($_SESSION['user_role'] != 'admin') {
    // Jika bukan admin, tendang ke halaman utama
    header("Location: /tasty_java/public/index.php?error=Akses ditolak");
    exit();
}

// Jika lolos semua, user adalah admin
?>





