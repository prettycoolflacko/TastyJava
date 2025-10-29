<?php 
$page_title = 'Tasty Java Recipes';

include __DIR__ . '/_header.php'; 

$sql = "SELECT recipes.id, recipes.title, recipes.featured_image, recipes.ingredients, 
               users.name AS author_name, recipes.created_at 
        FROM recipes 
        JOIN users ON recipes.author_id = users.id 
        ORDER BY recipes.created_at DESC";

$result = mysqli_query($conn, $sql);

// Array untuk menampung data
$recipes = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $clean_text = strip_tags($row['ingredients']);
        $clean_text = preg_replace('/\s+/', ' ', $clean_text);
        $clean_text = trim($clean_text);
        $excerpt = substr($clean_text, 0, 100) . '...';
        $recipes[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'image' => $row['featured_image'] ? '/tasty_java/' . $row['featured_image'] : '../assets/placeholder.jpg',
            'author_name' => $row['author_name'],
            'excerpt' => $excerpt,
            'created_at' => $row['created_at']
        ];
    }
}

// Hitung total resep
$total_recipes = count($recipes);
?>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    🍳 <?php echo $page_title; ?>
                </h1>
                <p class="text-gray-600 text-lg">
                    Temukan inspirasi masakan harian Anda di sini. Total <span class="font-semibold text-primary"><?php echo $total_recipes; ?></span> resep tersedia.
                </p>
            </div>
            
            <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'editor')): ?>
                <div class="mt-4 md:mt-0">
                    <a href="admin/create_recipe.php" 
                       class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg shadow-md hover:bg-primary-dark transition duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Resep Baru
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recipes Grid -->
    <?php if (empty($recipes)): ?>
        <!-- Empty State -->
        <div class="text-center py-16 bg-gray-50 rounded-lg">
            <div class="text-8xl mb-4">🍽️</div>
            <h3 class="mt-4 text-xl font-semibold text-gray-900">Belum ada resep</h3>
            <p class="mt-2 text-gray-600">Belum ada resep yang dipublikasikan saat ini.</p>
            
            <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'editor')): ?>
                <div class="mt-6">
                    <a href="admin/create_recipe.php" 
                       class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg shadow hover:bg-primary-dark transition duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Resep Pertama
                    </a>
                </div>
            <?php else: ?>
                <p class="mt-4 text-gray-500">Silakan login sebagai admin untuk menambah resep.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php foreach ($recipes as $recipe): ?>
                <article class="group bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-2xl hover:border-primary transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Image Container -->
                    <a href="recipe_detail.php?id=<?= $recipe['id'] ?>" class="block relative h-52 overflow-hidden">
                        <img src="<?= htmlspecialchars($recipe['image']) ?>" 
                             alt="<?= htmlspecialchars($recipe['title']) ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-3 left-3 right-3">
                                <span class="inline-block px-3 py-1 bg-white/90 text-primary text-xs font-semibold rounded-full">
                                    Lihat Detail →
                                </span>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Card Content -->
                    <div class="p-5">
                        <!-- Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors duration-300 line-clamp-2">
                            <a href="recipe_detail.php?id=<?= $recipe['id'] ?>">
                                <?= htmlspecialchars($recipe['title']) ?>
                            </a>
                        </h3>
                        
                        <!-- Author & Date -->
                        <div class="flex items-center text-xs text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="mr-3"><?= htmlspecialchars($recipe['author_name']) ?></span>
                            
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span><?= date('d M Y', strtotime($recipe['created_at'])) ?></span>
                        </div>
                        
                        <!-- Excerpt -->
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            <?= htmlspecialchars($recipe['excerpt']) ?>
                        </p>
                        
                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <a href="recipe_detail.php?id=<?= $recipe['id'] ?>" 
                               class="inline-flex items-center text-primary font-semibold text-sm hover:text-primary-dark transition-colors duration-300">
                                Lihat Resep
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination Placeholder (bisa dikembangkan nanti) -->
        <div class="mt-12 flex justify-center">
            <p class="text-gray-500 text-sm">
                Menampilkan semua <?= $total_recipes ?> resep
            </p>
        </div>
    <?php endif; ?>
    
    <!-- Call to Action -->
    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="mt-12 bg-gradient-to-r from-primary to-primary-dark rounded-xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-3">Ingin Berbagi Resep Favoritmu?</h2>
            <p class="text-white/90 mb-6 max-w-2xl mx-auto">
                Bergabunglah dengan komunitas Tasty Java dan bagikan kreasi masakanmu dengan ribuan pecinta kuliner lainnya!
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="register.php" 
                   class="inline-block px-8 py-3 bg-white text-primary font-semibold rounded-lg shadow hover:bg-gray-100 transition duration-300">
                    Daftar Sekarang
                </a>
                <a href="login.php" 
                   class="inline-block px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-primary transition duration-300">
                    Login
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php 
// 4. Include footer
include __DIR__ . '/_footer.php'; 
?>





