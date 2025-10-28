<?php
// 1. Include header (config.php otomatis ter-include)
// Kita tidak set $page_title dulu, kita set setelah dapat data resep
include '_header.php';

// 2. Cek apakah 'id' ada di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Jika tidak ada ID, tendang ke halaman recipes
    header("Location: recipes.php");
    exit();
}

$recipe_id = $_GET['id'];

// 3. Ambil data resep spesifik (WAJIB PAKAI PREPARED STATEMENT - Keamanan BNSP)
$stmt = $conn->prepare("SELECT r.title, r.ingredients, r.instructions, r.featured_image, u.name AS author_name, r.created_at 
                       FROM recipes r 
                       JOIN users u ON r.author_id = u.id 
                       WHERE r.id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $recipe = $result->fetch_assoc();
    // Set judul halaman setelah dapat data
    $page_title = htmlspecialchars($recipe['title']);
} else {
    // Jika resep tidak ditemukan
    echo "<div class='container'><p>Resep tidak ditemukan.</p></div>";
    include '_footer.php';
    exit(); // Hentikan eksekusi
}

$stmt->close();
?>

<!-- Menimpa judul di <head> -->
<script>document.title = "<?php echo $page_title; ?> - Tasty Java";</script>

<!-- Main Container -->
<div class="min-h-screen bg-gradient-to-b from-orange-50 to-white">
    <div class="max-w-5xl mx-auto px-4 py-8">
        
        <!-- Back Button -->
        <div class="flex items-center justify-between mb-6">
            <a href="recipes.php" class="inline-flex items-center gap-2 text-orange-600 hover:text-orange-700 transition-all hover:gap-3 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Kembali</span>
            </a>

            <!-- Admin/Editor Edit Button -->
            <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'editor')): ?>
            <a href="admin/edit_recipe.php?id=<?php echo $recipe_id; ?>" 
               class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Edit Resep</span>
            </a>
            <?php endif; ?>
        </div>

        <!-- Recipe Card -->
        <article class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            
            <!-- Featured Image with Overlay -->
            <?php if ($recipe['featured_image']): ?>
            <div class="relative w-full h-72 md:h-[28rem] overflow-hidden bg-gradient-to-br from-orange-100 to-red-100">
                <img src="<?php echo '/tasty_java/' . $recipe['featured_image']; ?>" 
                     alt="<?php echo htmlspecialchars($recipe['title']); ?>" 
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
            </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="p-8 md:p-12">
                
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    <?php echo htmlspecialchars($recipe['title']); ?>
                </h1>

                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-6 text-gray-600 pb-8 mb-8 border-b-2 border-orange-100">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Oleh</p>
                            <p class="font-semibold text-gray-900"><?php echo htmlspecialchars($recipe['author_name']); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Dipublikasikan</p>
                            <p class="font-semibold text-gray-900"><?php echo date('d F Y', strtotime($recipe['created_at'])); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Two Column Layout for Desktop -->
                <div class="grid lg:grid-cols-2 gap-8">
                    
                    <!-- Ingredients Section -->
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Bahan-bahan</h2>
                        </div>
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100/50 rounded-xl p-6 border border-orange-200 shadow-sm">
                            <div class="text-gray-800 leading-relaxed space-y-2">
                                <?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?>
                            </div>
                        </div>
                    </section>

                    <!-- Instructions Section -->
                    <section>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Cara Membuat</h2>
                        </div>
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-100/50 rounded-xl p-6 border border-blue-200 shadow-sm">
                            <div class="text-gray-800 leading-relaxed space-y-2">
                                <?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?>
                            </div>
                        </div>
                    </section>

                </div>

            </div>
        </article>

        <!-- CTA Section -->
        <div class="mt-12 text-center">
            <div class="inline-block">
                <p class="text-gray-600 mb-4">Tertarik dengan resep lainnya?</p>
                <a href="recipes.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span>Lihat Semua Resep</span>
                </a>
            </div>
        </div>

    </div>
</div>

<?php 
// 4. Include footer
include '_footer.php'; 
?>
