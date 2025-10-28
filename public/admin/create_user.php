<?php
require_once '../../config/config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /tasty_java/public/login.php");
    exit();
}

$page_title = 'Tambah User Baru';
include '_header_admin.php';

// Helper function for alert messages
function showAlert($type, $message) {
    $icon = $type === 'error' ? 'exclamation-circle' : 'check-circle';
    $class = $type === 'error' ? 'danger' : 'success';
    echo "<div class='alert alert-{$class} alert-dismissible fade show'>
            <i class='fas fa-{$icon}'></i> " . htmlspecialchars($message) . "
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          </div>";
}

// Get old input values
$oldName = $_GET['name'] ?? '';
$oldEmail = $_GET['email'] ?? '';
$oldRole = $_GET['role'] ?? '';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus"></i> Tambah User Baru</h4>
                </div>
                <div class="card-body">
                    <?php 
                    if (isset($_GET['error'])) showAlert('error', $_GET['error']);
                    if (isset($_GET['success'])) showAlert('success', $_GET['success']);
                    ?>

                    <form action="/tasty_java/app/process_user.php" method="POST">
                        <input type="hidden" name="action" value="create_user">
                        
                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required 
                                   placeholder="Masukkan nama lengkap" value="<?= htmlspecialchars($oldName) ?>">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required 
                                   placeholder="contoh@email.com" value="<?= htmlspecialchars($oldEmail) ?>">
                            <small class="text-muted">Email harus unik dan belum terdaftar</small>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required 
                                   placeholder="Minimal 6 karakter">
                            <small class="text-muted">Password minimal 6 karakter</small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="confirm_password" required 
                                   placeholder="Ketik ulang password">
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="user" <?= $oldRole === 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $oldRole === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                            <small class="text-muted">User: Dapat melihat resep | Admin: Dapat mengelola semua konten</small>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="/tasty_java/public/admin/manage_users.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '_footer_admin.php'; ?>
