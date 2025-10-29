<?php
require_once __DIR__ . '/admin_auth.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /tasty_java/public/admin/dashboard.php");
    exit();
}

// ----------------------------------------------------
// AKSI CREATE USER
// ----------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] == 'create_user') {
    
    // Ambil dan bersihkan data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    // Validasi data
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Nama wajib diisi";
    }
    
    if (empty($email)) {
        $errors[] = "Email wajib diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    if (empty($password)) {
        $errors[] = "Password wajib diisi";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Password dan konfirmasi password tidak cocok";
    }
    
    if (empty($role) || !in_array($role, ['user', 'admin', 'editor'])) {
        $errors[] = "Role tidak valid";
    }
    
    // Cek apakah email sudah terdaftar
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "Email sudah terdaftar";
        }
        $stmt->close();
    }
    
    // Jika ada error, redirect kembali dengan pesan error
    if (!empty($errors)) {
        $error_message = implode(", ", $errors);
        $redirect_params = http_build_query([
            'error' => $error_message,
            'name' => $name,
            'email' => $email,
            'role' => $role
        ]);
        header("Location: /tasty_java/public/admin/create_user.php?" . $redirect_params);
        exit();
    }
    
    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user ke database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password_hash, $role);
    
    if ($stmt->execute()) {
        // Berhasil
        $stmt->close();
        $conn->close();
        header("Location: /tasty_java/public/admin/manage_users.php?success=User berhasil ditambahkan");
        exit();
    } else {
        // Gagal
        $stmt->close();
        $conn->close();
        header("Location: /tasty_java/public/admin/create_user.php?error=Gagal menambahkan user: " . urlencode($conn->error));
        exit();
    }
}

// ----------------------------------------------------
// AKSI EDIT USER
// ----------------------------------------------------
elseif (isset($_POST['action']) && $_POST['action'] == 'edit_user') {
    
    // Ambil dan bersihkan data
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
    
    // Validasi data
    $errors = [];
    
    if (empty($id)) {
        $errors[] = "ID user tidak valid";
    }
    
    if (empty($name)) {
        $errors[] = "Nama wajib diisi";
    }
    
    if (empty($email)) {
        $errors[] = "Email wajib diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    if (empty($role) || !in_array($role, ['user', 'editor', 'admin'])) {
        $errors[] = "Role tidak valid";
    }
    
    // Validasi password jika diisi
    if (!empty($new_password)) {
        if (strlen($new_password) < 6) {
            $errors[] = "Password minimal 6 karakter";
        }
        
        if ($new_password !== $confirm_password) {
            $errors[] = "Password dan konfirmasi password tidak cocok";
        }
    }
    
    // Cek apakah user exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $errors[] = "User tidak ditemukan";
        }
        $stmt->close();
    }
    
    // Cek apakah email sudah digunakan oleh user lain
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "Email sudah digunakan oleh user lain";
        }
        $stmt->close();
    }
    
    // Jika ada error, redirect kembali dengan pesan error
    if (!empty($errors)) {
        $error_message = implode(", ", $errors);
        header("Location: /tasty_java/public/admin/edit_user.php?id=" . $id . "&error=" . urlencode($error_message));
        exit();
    }
    
    // Update user
    if (!empty($new_password)) {
        // Update dengan password baru
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ?, password_hash = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $role, $password_hash, $id);
    } else {
        // Update tanpa mengubah password
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);
    }
    
    if ($stmt->execute()) {
        // Berhasil
        $stmt->close();
        $conn->close();
        header("Location: /tasty_java/public/admin/manage_users.php?success=User berhasil diupdate");
        exit();
    } else {
        // Gagal
        $error = $conn->error;
        $stmt->close();
        $conn->close();
        header("Location: /tasty_java/public/admin/edit_user.php?id=" . $id . "&error=" . urlencode("Gagal mengupdate user: " . $error));
        exit();
    }
}

// ----------------------------------------------------
// AKSI UBAH ROLE
// ----------------------------------------------------
elseif (isset($_POST['action']) && $_POST['action'] == 'update_role') {
    
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $new_role = mysqli_real_escape_string($conn, $_POST['new_role']);
    
    // Validasi: Pastikan role-nya 'admin' atau 'user'
    if (!in_array($new_role, ['admin', 'user', 'editor'])) {
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




