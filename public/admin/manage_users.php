<?php
$page_title = 'Manajemen Pengguna';
include '_header_admin.php';

// Ambil semua data pengguna dari database
$sql = "SELECT id, name, email, role, created_at FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

// Ambil ID admin yang sedang login
$current_admin_id = $_SESSION['user_id'];
?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-semibold">Manajemen Pengguna</h2>
        <p class="text-sm text-gray-500 mt-1">Di halaman ini Anda dapat melihat semua pengguna, mengganti peran, atau menghapus akun.</p>
    </div>

    <div class="flex items-center gap-3">
        <a href="<?= $public ?>/admin/create_user.php" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700">+ Tambah Pengguna</a>
    </div>
</div>

<div class="bg-white shadow-sm border border-gray-100 rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($user = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $user['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-sm text-gray-500">
                                        <?php echo strtoupper(substr($user['name'],0,1)); ?>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user['name']); ?></div>
                                        <div class="text-xs text-gray-500">Terdaftar: <?php echo date('d M Y', strtotime($user['created_at'])); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="/tasty_java/app/process_user.php" method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="action" value="update_role">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <select name="new_role" class="rounded-md border border-gray-200 px-2 py-1 text-sm" <?php echo ($user['id'] == $current_admin_id) ? 'disabled' : ''; ?>>
                                        <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                                        <option value="editor" <?php echo ($user['role'] == 'editor') ? 'selected' : ''; ?>>Editor</option>
                                        <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                    </select>
                                    <button type="submit" class="ml-2 px-3 py-1 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700" <?php echo ($user['id'] == $current_admin_id) ? 'disabled' : ''; ?>>Ubah</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="<?= $public ?>/admin/edit_user.php?id=<?php echo $user['id']; ?>" class="inline-flex items-center px-3 py-1 rounded-md bg-yellow-100 text-yellow-800 hover:bg-yellow-200">Edit</a>
                                
                                <?php if ($user['id'] == $current_admin_id): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed" title="Anda tidak dapat menghapus akun sendiri">Hapus</span>
                                <?php else: ?>
                                    <form action="/tasty_java/app/process_user.php" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda YAKIN ingin menghapus pengguna ini? Tindakan ini tidak bisa dibatalkan.');">
                                        <input type="hidden" name="action" value="delete_user">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md bg-red-100 text-red-700 hover:bg-red-200">Hapus</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">Belum ada pengguna terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>




