<?php 
$page_title = 'Buat Resep Baru';
include '_header_admin.php'; 
?>

<div class="max-w-4xl">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold mb-2">Tambah Resep Baru</h2>
        <p class="text-sm text-gray-500">Isi form di bawah untuk menambahkan resep baru ke website.</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <form action="/tasty_java/app/process_recipe.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create">

            <!-- Nama Resep -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Resep <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh: Nasi Goreng by Tasty Java">
            </div>

            <!-- Bahan-bahan -->
            <div class="mb-6">
                <label for="ingredients" class="block text-sm font-medium text-gray-700 mb-2">
                    Bahan-bahan <span class="text-red-500">*</span>
                </label>
                <textarea id="ingredients" name="ingredients" rows="8" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh:&#10;2 siung bawang putih, cincang halus&#10;1 sdm garam&#10;1/2 ekor ayam, potong dadu&#10;200g beras"></textarea>
                <p class="mt-1 text-xs text-gray-500">Tulis setiap bahan di baris baru</p>
            </div>

            <!-- Langkah-langkah -->
            <div class="mb-6">
                <label for="instructions" class="block text-sm font-medium text-gray-700 mb-2">
                    Langkah-langkah Pembuatan <span class="text-red-500">*</span>
                </label>
                <textarea id="instructions" name="instructions" rows="12" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Contoh:&#10;1. Cincang bawang putih hingga halus.&#10;2. Panaskan minyak di wajan dengan api sedang.&#10;3. Tumis bawang putih hingga harum.&#10;4. Masukkan ayam, masak hingga berubah warna."></textarea>
                <p class="mt-1 text-xs text-gray-500">Tulis langkah-langkah secara detail dan berurutan</p>
            </div>

            <!-- Upload Foto -->
            <div class="mb-6">
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Masakan
                </label>
                <div class="mt-2 flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <div id="image-preview" class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border-2 border-dashed border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <input type="file" id="featured_image" name="featured_image" accept="image/jpeg, image/png, image/gif"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            onchange="previewImage(event)">
                        <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF hingga 5MB</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Publikasikan Resep
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





