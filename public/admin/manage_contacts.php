<?php
$page_title = 'Manajemen Pesan Kontak';
include '_header_admin.php';

// Ambil semua pesan kontak dari database (dengan pencarian sederhana)
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$base_sql = "SELECT id, name, email, message, created_at FROM contacts";
if ($q !== '') {
    $safe = mysqli_real_escape_string($conn, $q);
    $base_sql .= " WHERE name LIKE '%$safe%' OR email LIKE '%$safe%' OR message LIKE '%$safe%'";
}
$base_sql .= " ORDER BY created_at DESC";
$result = mysqli_query($conn, $base_sql);
?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-semibold">Manajemen Pesan Kontak</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola pesan yang dikirim pengunjung melalui formulir kontak.</p>
    </div>

    <div class="flex items-center gap-3">
        <form method="GET" action="" class="flex items-center">
            <label for="q" class="sr-only">Cari</label>
            <input id="q" name="q" value="<?php echo htmlspecialchars($q); ?>" type="search" placeholder="Cari nama, email, atau pesan..." class="rounded-md border border-gray-200 px-3 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-primary">
            <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Cari</button>
        </form>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pesan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($contact = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $contact['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-sm text-purple-600 font-semibold">
                                        <?php echo strtoupper(substr($contact['name'],0,1)); ?>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($contact['name']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline">
                                    <?php echo htmlspecialchars($contact['email']); ?>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 max-w-md">
                                    <?php 
                                    $message = htmlspecialchars($contact['message']);
                                    echo (strlen($message) > 100) ? substr($message, 0, 100) . '...' : $message;
                                    ?>
                                </div>
                                <?php if(strlen($contact['message']) > 100): ?>
                                    <button onclick="showFullMessage(<?php echo $contact['id']; ?>)" class="text-xs text-indigo-600 hover:underline mt-1">Lihat selengkapnya</button>
                                <?php endif; ?>
                                <!-- Hidden full message for modal -->
                                <div id="full-message-<?php echo $contact['id']; ?>" class="hidden">
                                    <?php echo nl2br(htmlspecialchars($contact['message'])); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('d M Y, H:i', strtotime($contact['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo urlencode($contact['email']); ?>&su=<?php echo urlencode('Re: Pesan Anda'); ?>" target="_blank" class="inline-flex items-center px-3 py-1 rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                    </svg>
                                    Balas
                                </a>
                                <form action="/tasty_java/app/process_contact.php" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
                                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md bg-red-100 text-red-700 hover:bg-red-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p>Belum ada pesan kontak yang masuk.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for full message -->
<div id="messageModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[80vh] overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Pesan Lengkap</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="px-6 py-4 overflow-y-auto max-h-96">
            <div id="modalMessageContent" class="text-gray-700"></div>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Tutup</button>
        </div>
    </div>
</div>

<script>
function showFullMessage(contactId) {
    const fullMessage = document.getElementById('full-message-' + contactId).innerHTML;
    document.getElementById('modalMessageContent').innerHTML = fullMessage;
    document.getElementById('messageModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('messageModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('messageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>

<?php
include '_footer_admin.php';
?>