<?php
// 1. Include file config.php
require_once '../config/config.php';

// 2. Pastikan file ini diakses dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Cek jika ini adalah request delete dari admin
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // Pastikan user adalah admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: /tasty_java/public/index.php?error=Akses ditolak");
            exit();
        }
        
        $contact_id = (int)$_POST['contact_id'];
        
        // Gunakan prepared statement untuk delete
        $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->bind_param("i", $contact_id);
        $stmt->execute();
        $stmt->close();
        exit();
    }

    // 3. Proses form kontak dari pengunjung (existing code)
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // 4. Validasi Sederhana
    if (empty($name) || empty($email) || empty($message)) {
        // Redirect kembali ke contact dengan pesan error
        header("Location: /tasty_java/public/contact.php?error=Semua field wajib diisi");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: /tasty_java/public/contact.php?error=Format email tidak valid");
        exit();
    }

    // 5. Simpan ke database (Gunakan Prepared Statement - WAJIB BNSP)
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    
    if ($stmt->execute()) {
        // Jika berhasil
        header("Location: /tasty_java/public/contact.php?success=Pesan Anda telah terkirim! Terima kasih.");
        exit();
    } else {
        // Jika gagal
        header("Location: /tasty_java/public/contact.php?error=Terjadi kesalahan. Coba lagi.");
        exit();
    }

    $stmt->close();
    $conn->close();

} else {
    // Jika file diakses langsung, tendang ke index
    header("Location: /tasty_java/public/index.php");
    exit();
}
?>





