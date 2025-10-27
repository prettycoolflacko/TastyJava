<?php 
$page_title = 'Edit Resep';
include '_header_admin.php'; 

// 1. Cek apakah 'id' ada di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_recipes.php?error=ID Resep tidak valid");
    exit();
}
$recipe_id = $_GET['id'];

// 2. Ambil data resep dari database (WAJIB Prepared Statement)
$stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $recipe = $result->fetch_assoc();
} else {
    // Jika resep tidak ditemukan
    header("Location: manage_recipes.php?error=Resep tidak ditemukan");
    exit();
}
$stmt->close();
?>

<div class="max-w-4xl">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">Edit Resep</h2>
        <p class="text-sm text-gray-500">Perbarui informasi resep di bawah ini.</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <form action="/tasty_java/app/process_recipe.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
            <input type="hidden" name="old_image_path" value="<?php echo htmlspecialchars($recipe['featured_image']); ?>">

            <!-- Nama Resep -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Resep <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" required
                    value="<?php echo htmlspecialchars($recipe['title']); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Bahan-bahan -->
            <div class="mb-6">
                <label for="ingredients" class="block text-sm font-medium text-gray-700 mb-2">
                    Bahan-bahan <span class="text-red-500">*</span>
                </label>
                <textarea id="ingredients" name="ingredients" rows="8" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
                <p class="mt-1 text-xs text-gray-500">Tulis setiap bahan di baris baru</p>
            </div>

            <!-- Langkah-langkah -->
            <div class="mb-6">
                <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">
                    Langkah-langkah Pembuatan <span class="text-red-500">*</span>
                </label>
                <textarea id="instructions" name="instructions" rows="12" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
                <p class="mt-1 text-xs text-gray-500">Tulis langkah-langkah secara detail dan berurutan</p>
            </div>

            <!-- Upload Foto -->
            <div class="mb-6">
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Ganti Foto Masakan
                </label>
                
                <div class="mt-2 flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div id="image-preview" class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border-2 border-gray-200">
                            <?php if (!empty($recipe['featured_image'])): ?>
                                <img src="<?php echo '/tasty_java/' . htmlspecialchars($recipe['featured_image']); ?>" alt="Current" class="w-full h-full object-cover">
                            <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex-1">
                        <?php if (!empty($recipe['featured_image'])): ?>
                            <p class="text-sm text-gray-600 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Gambar saat ini sudah ter-upload
                            </p>
                        <?php endif; ?>
                        <input type="file" id="featured_image" name="featured_image" accept="image/jpeg, image/png, image/gif"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            onchange="previewImage(event)">
                        <p class="mt-2 text-xs text-gray-500">Upload file baru untuk mengganti gambar. PNG, JPG, GIF hingga 5MB</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="manage_recipes.php" class="inline-flex items-center px-6 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('image-preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" />';
        }
        reader.readAsDataURL(file);
    }
}
</script>

<?php 
include '_footer_admin.php'; 
?>





