<?php
require_once '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Cek jika ini adalah request delete dari admin
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
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

    // Validasi: user harus login dan memiliki role user, editor, atau admin
    if (!isset($_SESSION['user_id'])) {
        header("Location: /tasty_java/public/login.php?error=Anda harus login untuk mengirim pesan");
        exit();
    }

    // Validasi role: hanya user, editor, dan admin yang bisa mengirim pesan
    $allowed_roles = ['user', 'editor', 'admin'];
    if (!in_array($_SESSION['user_role'], $allowed_roles)) {
        header("Location: /tasty_java/public/contact.php?error=Akses ditolak");
        exit();
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        // Redirect kembali ke contact dengan pesan error
        header("Location: /tasty_java/public/contact.php?error=Semua field wajib diisi");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: /tasty_java/public/contact.php?error=Format email tidak valid");
        exit();
    }

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





