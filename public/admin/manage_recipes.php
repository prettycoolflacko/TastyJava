<?php 
$page_title = 'Manajemen Resep';
include '_header_admin.php'; 
// Ambil semua resep (dengan pencarian sederhana)
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$base_sql = "SELECT r.id, r.title, r.featured_image, u.name AS author_name, r.created_at 
                FROM recipes r
                JOIN users u ON r.author_id = u.id";
if ($q !== '') {
        $safe = mysqli_real_escape_string($conn, $q);
        $base_sql .= " WHERE r.title LIKE '%$safe%' OR u.name LIKE '%$safe%'";
}
$base_sql .= " ORDER BY r.created_at DESC";
$result = mysqli_query($conn, $base_sql);

?>
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-semibold">Manajemen Resep</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola resep yang dipublikasikan di situs.</p>
    </div>

    <div class="flex items-center gap-3">
        <form method="GET" action="" class="flex items-center">
            <label for="q" class="sr-only">Cari</label>
            <input id="q" name="q" value="<?php echo htmlspecialchars($q); ?>" type="search" placeholder="Cari judul atau nama author..." class="rounded-md border border-gray-200 px-3 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-primary">
            <button type="submit" class="ml-2 px-4 py-2 bg-primary text-white rounded-md">Cari</button>
        </form>

        <a href="create_recipe.php" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700">+ Tambah Resep Baru</a>
    </div>
</div>

<div class="bg-white shadow-sm border border-gray-100 rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dipublikasikan</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $row['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                        <img src="<?php echo $row['featured_image'] ? '/tasty_java/' . $row['featured_image'] : 'https://placehold.co/300x200?text=No+Image'; ?>" alt="" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['title']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($row['author_name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="edit_recipe.php?id=<?php echo $row['id']; ?>" class="inline-flex items-center px-3 py-1 rounded-md bg-yellow-100 text-yellow-800 hover:bg-yellow-200">Edit</a>
                                <a href="/tasty_java/app/process_recipe.php?action=delete&id=<?php echo $row['id']; ?>" class="inline-flex items-center px-3 py-1 rounded-md bg-red-100 text-red-700 hover:bg-red-200" onclick="return confirm('Apakah Anda yakin ingin menghapus resep ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">Belum ada resep yang ditambahkan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>





