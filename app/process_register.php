<?php
require_once '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
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

    // Hash password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Masukkan data ke database
    $stmt_insert = $conn->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, 'user')");
    $stmt_insert->bind_param("sss", $name, $email, $password_hash);
    
    if ($stmt_insert->execute()) {
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
    header("Location: /tasty_java/public/index.php");
    exit();
}
?>




