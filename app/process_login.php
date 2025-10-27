<?php
// 1. Include config (WAJIB untuk memulai session)
require_once '../config/config.php';

// 2. Pastikan file ini diakses dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Ambil dan bersihkan data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 4. Validasi sederhana
    if (empty($email) || empty($password)) {
        header("Location: /tasty_java/public/login.php?error=Email dan Password wajib diisi");
        exit();
    }

    // 5. Cari user di database (Gunakan Prepared Statement)
    $stmt = $conn->prepare("SELECT id, name, email, password_hash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User ditemukan
        $user = $result->fetch_assoc();

        // 6. Verifikasi password (KEAMANAN WAJIB BNSP)
        if (password_verify($password, $user['password_hash'])) {
            // Password cocok!
            
            // 7. Buat SESSION (WAJIB BNSP)
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            // 8. Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                // Nanti kita akan buat halaman admin/dashboard.php
                header("Location: /tasty_java/public/admin/dashboard.php");
                exit();
            } else {
                // Role 'user'
                header("Location: /tasty_java/public/index.php");
                exit();
            }
            
        } else {
            // Password salah
            header("Location: /tasty_java/public/login.php?error=Email atau Password salah");
            exit();
        }
    } else {
        // User tidak ditemukan
        header("Location: /tasty_java/public/login.php?error=Email atau Password salah");
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




