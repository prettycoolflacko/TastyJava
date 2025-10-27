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
<script>document.title = "<?php echo $page_title; ?> - Dapur Resep";</script>

<!-- Main Container -->
<div class="max-w-4xl mx-auto px-4 py-8">
    
    <!-- Back Button -->
    <a href="recipes.php" class="inline-flex items-center gap-2 text-orange-600 hover:text-orange-700 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <span>Kembali ke Daftar Resep</span>
    </a>

    <!-- Recipe Card -->
    <article class="bg-white rounded-lg shadow-md overflow-hidden">
        
        <!-- Featured Image -->
        <?php if ($recipe['featured_image']): ?>
        <div class="w-full h-64 md:h-96 overflow-hidden bg-gray-100">
            <img src="<?php echo '/tasty_java/' . $recipe['featured_image']; ?>" 
                 alt="<?php echo htmlspecialchars($recipe['title']); ?>" 
                 class="w-full h-full object-cover">
        </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="p-6 md:p-8">
            
            <!-- Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo htmlspecialchars($recipe['title']); ?>
            </h1>

            <!-- Meta Info -->
            <div class="flex items-center gap-4 text-sm text-gray-600 pb-6 mb-6 border-b border-gray-200">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span><?php echo htmlspecialchars($recipe['author_name']); ?></span>
                </div>
                <span>•</span>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span><?php echo date('d F Y', strtotime($recipe['created_at'])); ?></span>
                </div>
            </div>

            <!-- Ingredients Section -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-8 bg-orange-500 rounded"></span>
                    Bahan-bahan
                </h2>
                <div class="bg-orange-50 rounded-lg p-6 border-l-4 border-orange-500">
                    <div class="text-gray-700 leading-relaxed prose prose-sm max-w-none">
<?php echo $recipe['ingredients']; ?>
                    </div>
                </div>
            </section>

            <!-- Instructions Section -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-8 bg-orange-500 rounded"></span>
                    Cara Membuat
                </h2>
                <div class="bg-gray-50 rounded-lg p-6 border-l-4 border-gray-400">
                    <div class="text-gray-700 leading-relaxed prose prose-sm max-w-none">
<?php echo $recipe['instructions']; ?>
                    </div>
                </div>
            </section>

        </div>
    </article>

    <!-- CTA -->
    <div class="mt-8 text-center">
        <a href="recipes.php" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
            Lihat Resep Lainnya
        </a>
    </div>

</div>

<?php 
// 4. Include footer
include '_footer.php'; 
?>
