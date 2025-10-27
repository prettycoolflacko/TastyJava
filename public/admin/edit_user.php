<?php
require_once '../../config/config.php';

// Cek apakah user sudah login dan adalah admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: /tasty_java/public/login.php");
    exit();
}

// Ambil ID user yang akan diedit
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: /tasty_java/public/admin/manage_users.php?error=ID user tidak ditemukan");
    exit();
}

$user_id = intval($_GET['id']);

// Ambil data user dari database
$stmt = $conn->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header("Location: /tasty_java/public/admin/manage_users.php?error=User tidak ditemukan");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

$page_title = 'Edit User';
include '_header_admin.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit User</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_GET['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="/tasty_java/app/process_user.php" method="POST">
                        <input type="hidden" name="action" value="edit_user">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required 
                                   placeholder="Masukkan nama lengkap" 
                                   value="<?php echo htmlspecialchars($user['name']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required 
                                   placeholder="contoh@email.com" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>">
                            <div class="form-text">Email harus unik dan belum terdaftar</div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            </select>
                            <div class="form-text">
                                <strong>User:</strong> Dapat melihat resep<br>
                                <strong>Admin:</strong> Dapat mengelola semua konten
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Ubah Password (Opsional)</h5>
                        <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                   placeholder="Minimal 6 karakter (kosongkan jika tidak diubah)">
                            <div class="form-text">Password minimal 6 karakter</div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   placeholder="Ketik ulang password baru">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/tasty_java/public/admin/manage_users.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '_footer_admin.php'; ?>
