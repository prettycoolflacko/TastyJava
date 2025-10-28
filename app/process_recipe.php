<?php
// 1. Panggil Penjaga Keamanan & Config
require_once __DIR__ . '/admin_auth.php'; // Memastikan hanya admin yang bisa akses
// config.php sudah di-include oleh admin_auth.php

// 2. Cek metode request - DELETE bisa pakai GET dengan ID
// POST untuk create/update, GET untuk delete
$is_delete_request = (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']));

if ($_SERVER["REQUEST_METHOD"] != "POST" && !$is_delete_request) {
    // Jika bukan POST atau DELETE request, tendang
    header("Location: /tasty_java/public/admin/dashboard.php");
    exit();
}

// ----------------------------------------------------
// AKSI CREATE (dari Langkah 4)
// ----------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] == 'create') {
    
    // Ambil data dari form
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $author_id = $_SESSION['user_id']; // Ambil ID Chef dari session

    // Validasi dasar
    if (empty($title) || empty($ingredients) || empty($instructions)) {
        header("Location: /tasty_java/public/admin/create_recipe.php?error=Semua field teks wajib diisi");
        exit();
    }

    // Logika Upload Gambar
    $db_path_image = NULL; // Default jika tidak ada gambar
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
        
        $upload_dir = '../public/uploads/'; // Path dari file ini ke folder uploads
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['featured_image']['type'];

        if (in_array($file_type, $allowed_types)) {
            // Buat nama file unik
            $file_name = uniqid('resep_') . '_' . basename($_FILES['featured_image']['name']);
            $upload_path = $upload_dir . $file_name;
            
            // Path yang akan disimpan ke DB (dari root proyek)
            $db_path_image = 'public/uploads/' . $file_name; 

            // Pindahkan file
            if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                header("Location: /tasty_java/public/admin/create_recipe.php?error=Gagal mengupload gambar");
                exit();
            }
        } else {
            header("Location: /tasty_java/public/admin/create_recipe.php?error=Tipe file gambar tidak valid");
            exit();
        }
    }

    // Simpan ke Database
    $stmt = $conn->prepare("INSERT INTO recipes (title, ingredients, instructions, featured_image, author_id) VALUES (?, ?, ?, ?, ?)");
    // ssssi = string, string, string, string, integer
    $stmt->bind_param("ssssi", $title, $ingredients, $instructions, $db_path_image, $author_id);

    if ($stmt->execute()) {
        // Berhasil
        header("Location: /tasty_java/public/admin/manage_recipes.php?success=Resep baru berhasil ditambahkan!");
    } else {
        // Gagal
        header("Location: /tasty_java/public/admin/create_recipe.php?error=Gagal menyimpan ke database: " . $stmt->error);
    }
    $stmt->close();
    exit();
}

// ----------------------------------------------------
// AKSI UPDATE (dari Langkah 5)
// ----------------------------------------------------
elseif (isset($_POST['action']) && $_POST['action'] == 'update') {
    
    // Ambil data dari form
    $id = (int)$_POST['id']; // Cast to integer for ID
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $old_image_path = $_POST['old_image_path']; // Tidak perlu escape, hanya diteruskan
    
    // Validasi
    if (empty($id) || empty($title) || empty($ingredients) || empty($instructions)) {
        header("Location: /tasty_java/public/admin/edit_recipe.php?id=".$id."&error=Semua field teks wajib diisi");
        exit();
    }

    // Set path gambar ke path yang lama sebagai default
    $db_path_image = $old_image_path;

    // Cek jika ada gambar BARU yang di-upload
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
        
        $upload_dir = '../public/uploads/'; 
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['featured_image']['type'];

        if (in_array($file_type, $allowed_types)) {
            // Buat nama file unik
            $file_name = uniqid('resep_') . '_' . basename($_FILES['featured_image']['name']);
            $upload_path = $upload_dir . $file_name;
            $db_path_image = 'public/uploads/' . $file_name; // Path BARU untuk DB

            // Pindahkan file BARU
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                // Hapus gambar LAMA jika ada
                if (!empty($old_image_path) && file_exists('../' . $old_image_path)) {
                    unlink('../' . $old_image_path);
                }
            } else {
                header("Location: /tasty_java/public/admin/edit_recipe.php?id=".$id."&error=Gagal mengupload gambar baru");
                exit();
            }
        } else {
            header("Location: /tasty_java/public/admin/edit_recipe.php?id=".$id."&error=Tipe file gambar tidak valid");
            exit();
        }
    }

    // Update Database (Prepared Statement)
    $stmt = $conn->prepare("UPDATE recipes SET title = ?, ingredients = ?, instructions = ?, featured_image = ? WHERE id = ?");
    // ssssi = string, string, string, string, integer
    $stmt->bind_param("ssssi", $title, $ingredients, $instructions, $db_path_image, $id);

    if ($stmt->execute()) {
        header("Location: /tasty_java/public/admin/manage_recipes.php?success=Resep berhasil diperbarui!");
    } else {
        header("Location: /tasty_java/public/admin/edit_recipe.php?id=".$id."&error=Gagal memperbarui database: " . $stmt->error);
    }
    $stmt->close();
    exit();
}

// ----------------------------------------------------
// AKSI DELETE (dari manage_recipes.php)
// ----------------------------------------------------
elseif ($is_delete_request) {
    
    $recipe_id = (int)$_GET['id'];
    
    // (PENTING) Ambil path gambar sebelum menghapus data
    $stmt_select = $conn->prepare("SELECT featured_image FROM recipes WHERE id = ?");
    $stmt_select->bind_param("i", $recipe_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    
    if ($result->num_rows === 1) {
        $recipe = $result->fetch_assoc();
        $image_path = $recipe['featured_image'];
    } else {
        // Resep tidak ditemukan
        header("Location: /tasty_java/public/admin/manage_recipes.php?error=Resep tidak ditemukan");
        exit();
    }
    $stmt_select->close();

    // Hapus data dari Database (Prepared Statement)
    $stmt_delete = $conn->prepare("DELETE FROM recipes WHERE id = ?");
    $stmt_delete->bind_param("i", $recipe_id);

    if ($stmt_delete->execute()) {
        // Jika data di DB berhasil dihapus, hapus file gambar
        if (!empty($image_path)) {
            $file_to_delete = '../' . $image_path;
            if (file_exists($file_to_delete)) {
                unlink($file_to_delete);
            }
        }
        // Berhasil
        header("Location: /tasty_java/public/admin/manage_recipes.php?success=Resep berhasil dihapus!");
    } else {
        // Gagal
        header("Location: /tasty_java/public/admin/manage_recipes.php?error=Gagal menghapus resep: " . $stmt_delete->error);
    }
    $stmt_delete->close();
    exit();
}

// Jika tidak ada aksi yang cocok
else {
    header("Location: /tasty_java/public/admin/dashboard.php?error=Aksi tidak dikenal");
    exit();
}

$conn->close();
?>




