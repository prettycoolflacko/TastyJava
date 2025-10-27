<?php
// 1. Include file config.php
require_once '../config/config.php';

// 2. Pastikan file ini diakses dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Ambil dan bersihkan data dari form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // 4. Validasi Sederhana
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        // Redirect kembali ke register dengan pesan error
        header("Location: /tasty_java/public/register.php?error=Semua field wajib diisi");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: /tasty_java/public/register.php?error=Format email tidak valid");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: /tasty_java/public/register.php?error=Password dan konfirmasi tidak cocok");
        exit();
    }

    // 5. Cek apakah email sudah terdaftar (Gunakan Prepared Statement)
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();
    
    if ($stmt_check->num_rows > 0) {
        // Jika email sudah ada
        header("Location: /tasty_java/public/register.php?error=Email sudah terdaftar");
        $stmt_check->close();
        exit();
    }
    $stmt_check->close();

    // 6. Hash password (KEAMANAN WAJIB BNSP)
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // 7. Masukkan data ke database (Gunakan Prepared Statement - WAJIB BNSP)
    // Role default adalah 'user' (sesuai database.sql kita)
    $stmt_insert = $conn->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, 'user')");
    $stmt_insert->bind_param("sss", $name, $email, $password_hash);
    
    if ($stmt_insert->execute()) {
        // Jika registrasi berhasil
        header("Location: /tasty_java/public/login.php?success=Registrasi berhasil! Silakan login.");
        exit();
    } else {
        // Jika gagal
        header("Location: /tasty_java/public/register.php?error=Terjadi kesalahan. Coba lagi.");
        exit();
    }

    $stmt_insert->close();
    $conn->close();

} else {
    // Jika file diakses langsung, tendang ke index
    header("Location: /tasty_java/public/index.php");
    exit();
}
?>




