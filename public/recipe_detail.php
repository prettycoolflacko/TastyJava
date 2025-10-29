<?php
include '_header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: recipes.php");
    exit();
}

$recipe_id = $_GET['id'];
$stmt = $conn->prepare("SELECT r.title, r.ingredients, r.instructions, r.featured_image, u.name AS author_name, r.created_at 
                       FROM recipes r 
                       JOIN users u ON r.author_id = u.id 
                       WHERE r.id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $recipe = $result->fetch_assoc();
    $page_title = htmlspecialchars($recipe['title']);
} else {
    echo "<div class='container'><p>Resep tidak ditemukan.</p></div>";
    include '_footer.php';
    exit();
}

$stmt->close();
?>

<script>document.title = "<?php echo $page_title; ?> - Tasty Java";</script>

<!-- Main Container -->
<div class="min-h-screen bg-amber-50">
    
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Navigation Bar -->
        <div class="flex items-center justify-between mb-8">
            <a href="recipes.php" class="group inline-flex items-center gap-2 text-amber-800 hover:text-amber-600 transition-all duration-300 font-medium">
                <div class="p-2 rounded-full bg-amber-100 group-hover:bg-amber-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <span class="text-lg">Back to Recipes</span>
            </a>

            <!-- Admin/Editor Edit Button -->
            <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'editor')): ?>
            <a href="admin/edit_recipe.php?id=<?php echo $recipe_id; ?>" 
               class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Edit Recipe</span>
            </a>
            <?php endif; ?>
        </div>

        <!-- Recipe Article -->
        <article class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <!-- Content -->
            <div class="p-8 md:p-12">
                
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 mb-6 leading-tight">
                    <?php echo htmlspecialchars($recipe['title']); ?>
                </h1>

                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-6 text-gray-700 mb-10 pb-8 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-100 rounded-full">
                            <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Chef</p>
                            <p class="font-semibold text-gray-900"><?php echo htmlspecialchars($recipe['author_name']); ?></p>
                        </div>
                    </div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-100 rounded-full">
                            <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Published</p>
                            <p class="font-semibold text-gray-900"><?php echo date('M d, Y', strtotime($recipe['created_at'])); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Featured Image Section -->
                <?php if ($recipe['featured_image']): ?>
                <section class="mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-amber-700 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-serif font-bold text-gray-900">Final Result</h2>
                    </div>
                    <div class="rounded-xl overflow-hidden shadow-lg border-4 border-amber-100 mx-auto" style="width: 600px; height: 400px;">
                        <img src="<?php echo '/tasty_java/' . $recipe['featured_image']; ?>" 
                             alt="<?php echo htmlspecialchars($recipe['title']); ?>" 
                             class="w-full h-auto object-cover bg-gray-50"
                             style="height: 450px;">
                    </div>
                    <p class="text-center text-gray-600 mt-4 italic">Tasty Java Original's Recipe</p>
                </section>
                <?php endif; ?>

                <!-- Ingredients Section -->
                <section class="mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-amber-700 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-serif font-bold text-gray-900">Ingredients</h2>
                    </div>
                    <div class="bg-amber-50 rounded-xl p-8 border-l-4 border-amber-700">
                        <div class="text-gray-800 text-lg leading-relaxed space-y-3">
                            <?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?>
                        </div>
                    </div>
                </section>

                <!-- Instructions Section -->
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-amber-700 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-serif font-bold text-gray-900">Instructions</h2>
                    </div>
                    <div class="bg-amber-50 rounded-xl p-8 border-l-4 border-amber-700">
                        <div class="text-gray-800 text-lg leading-relaxed space-y-4">
                            <?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?>
                        </div>
                    </div>
                </section>

            </div>
        </article>

        <!-- CTA Section -->
        <div class="mt-16 text-center py-12 bg-amber-100 rounded-2xl">
            <p class="text-2xl text-gray-800 mb-8 font-serif">Discover more delicious recipes from our kitchen</p>
            <a href="recipes.php" class="group inline-flex items-center gap-3 bg-amber-700 hover:bg-amber-800 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <svg class="w-6 h-6 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                <span>Explore All Recipes</span>
            </a>
        </div>

    </div>
</div>

<?php 
// 4. Include footer
include '_footer.php'; 
?>
