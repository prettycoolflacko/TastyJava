<?php
// 1. Panggil Penjaga Keamanan & Config
require_once __DIR__ . '/admin_auth.php'; // Memastikan hanya admin yang bisa akses

// 2. Pastikan file ini diakses dengan metode POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /tasty_java/public/admin/dashboard.php");
    exit();
}

// ----------------------------------------------------
// AKSI UBAH ROLE
// ----------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] == 'update_role') {
    
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $new_role = mysqli_real_escape_string($conn, $_POST['new_role']);
    
    // Validasi: Pastikan role-nya 'admin' atau 'user'
    if (!in_array($new_role, ['admin', 'user'])) {
        header("Location: /tasty_java/public/admin/manage_users.php?error=Role tidak valid");
        exit();
    }
    
    // Keamanan: Admin tidak bisa mengubah role dirinya sendiri
    if ($user_id == $_SESSION['user_id']) {
        header("Location: /tasty_java/public/admin/manage_users.php?error=Anda tidak dapat mengubah role akun Anda sendiri");
        exit();
    }

    // Update role di database
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $new_role, $user_id);
    
    if ($stmt->execute()) {
        header("Location: /tasty_java/public/admin/manage_users.php?success=Role pengguna berhasil diperbarui");
    } else {
        header("Location: /tasty_java/public/admin/manage_users.php?error=Gagal memperbarui role: " . $stmt->error);
    }
    $stmt->close();
    exit();
}

// ----------------------------------------------------
// AKSI HAPUS USER
// ----------------------------------------------------
elseif (isset($_POST['action']) && $_POST['action'] == 'delete_user') {

    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    // Keamanan: Admin tidak bisa menghapus dirinya sendiri
    if ($user_id == $_SESSION['user_id']) {
        header("Location: /tasty_java/public/admin/manage_users.php?error=Anda tidak dapat menghapus akun Anda sendiri");
        exit();
    }

    // Hapus user dari database
    // CATATAN: Jika ada 'foreign key constraint' (misal: resep terkait),
    // penghapusan bisa gagal. Di database kita (ON DELETE SET NULL), author_id resep akan jadi NULL.
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        header("Location: /tasty_java/public/admin/manage_users.php?success=Pengguna berhasil dihapus");
    } else {
        // Kemungkinan error karena foreign key
        header("Location: /tasty_java/public/admin/manage_users.php?error=Gagal menghapus pengguna. Pastikan semua resep pengguna ini sudah dihapus/dialihkan.");
    }
    $stmt->close();
    exit();
}

// Jika tidak ada aksi yang cocok
else {
    header("Location: /tasty_java/public/admin/dashboard.php?error=Aksi tidak dikenal");
    exit();
}

$conn->close();
?>




