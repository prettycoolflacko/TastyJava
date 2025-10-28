<?php
require_once '../../config/config.php';

// Check admin authentication
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: /tasty_java/public/login.php");
    exit();
}

// Validate and get user ID
$user_id = intval($_GET['id'] ?? 0);
if (!$user_id) {
    header("Location: /tasty_java/public/admin/manage_users.php?error=ID user tidak ditemukan");
    exit();
}

// Fetch user data
$stmt = $conn->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    header("Location: /tasty_java/public/admin/manage_users.php?error=User tidak ditemukan");
    exit();
}

$page_title = 'Edit User';
include '_header_admin.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit User</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                    <?php endif; ?>

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
                    <?php endif; ?>

                    <form action="/tasty_java/app/process_user.php" method="POST">
                        <input type="hidden" name="action" value="edit_user">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" class="form-control" name="name" required 
                                   value="<?= htmlspecialchars($user['name']) ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" required 
                                   value="<?= htmlspecialchars($user['email']) ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role *</label>
                            <select class="form-select" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">Ubah Password (Opsional)</h6>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" 
                                   placeholder="Minimal 6 karakter">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="confirm_password">
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="/tasty_java/public/admin/manage_users.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '_footer_admin.php'; ?>
