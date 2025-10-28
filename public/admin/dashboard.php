<?php 
$page_title = 'Dashboard';
include '_header_admin.php'; // Include header admin

// Logika untuk mengambil data statistik
// Hitung total resep (untuk semua role)
$sql_recipes = "SELECT COUNT(*) AS total FROM recipes";
$result_recipes = mysqli_query($conn, $sql_recipes);
$total_recipes = mysqli_fetch_assoc($result_recipes)['total'];

// Hitung total user (hanya untuk admin)
if ($_SESSION['user_role'] == 'admin') {
    $sql_users = "SELECT COUNT(*) AS total FROM users";
    $result_users = mysqli_query($conn, $sql_users);
    $total_users = mysqli_fetch_assoc($result_users)['total'];

    // Hitung total pesan kontak (hanya untuk admin)
    $sql_contacts = "SELECT COUNT(*) AS total FROM contacts";
    $result_contacts = mysqli_query($conn, $sql_contacts);
    $total_contacts = mysqli_fetch_assoc($result_contacts)['total'];
}
?>

<!-- Welcome Header -->
<div class="mb-8">
    <div class="flex items-center gap-3 mb-3">
        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Dashboard <?php echo ($_SESSION['user_role'] == 'admin') ? 'Admin' : 'Editor'; ?></h2>
            <p class="text-gray-600">Welcome, <span class="font-semibold text-orange-600"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span></p>
        </div>
    </div>
    <p class="text-sm text-gray-500 ml-15"><?php echo ($_SESSION['user_role'] == 'admin') ? 'Manage recipe, user, and message content' : 'Manage recipe content'; ?></p>
</div>

<!-- Statistics Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-<?php echo ($_SESSION['user_role'] == 'admin') ? '3' : '1'; ?> gap-6 mb-8">
    
    <!-- Total Recipes Card -->
    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
        <div class="bg-blue-500 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium mb-2">Total Resep</p>
                    <h3 class="text-5xl font-bold text-white"><?php echo $total_recipes; ?></h3>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:scale-110 transition-transform">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-orange-50">
            <p class="text-sm text-gray-700 font-medium">📖 Semua Resep</p>
        </div>
    </div>

    <?php if ($_SESSION['user_role'] == 'admin'): ?>
    <!-- Total Users Card (Admin Only) -->
    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
        <div class="bg-emerald-500 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium mb-2">Total Pengguna</p>
                    <h3 class="text-5xl font-bold text-white"><?php echo $total_users; ?></h3>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:scale-110 transition-transform">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-emerald-50">
            <p class="text-sm text-gray-700 font-medium">👥 Daftar Pengguna</p>
        </div>
    </div>

    <!-- Total Messages Card (Admin Only) -->
    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
        <div class="bg-blue-500 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-2">Total Pesan</p>
                    <h3 class="text-5xl font-bold text-white"><?php echo $total_contacts; ?></h3>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:scale-110 transition-transform">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-blue-50">
            <p class="text-sm text-gray-700 font-medium">💬 Pesan dari pengunjung</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Quick Access Section -->
<div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900">Akses Cepat</h3>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-<?php echo ($_SESSION['user_role'] == 'admin') ? '4' : '2'; ?> gap-4">
        
        <!-- Manage Recipes -->
        <a href="manage_recipes.php" class="group flex flex-col items-center gap-4 p-6 border-2 border-gray-200 rounded-xl hover:border-orange-400 hover:bg-orange-50 transition-all duration-300 hover:shadow-lg">
            <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="text-center">
                <p class="font-bold text-gray-900 text-lg mb-1">Kelola Resep</p>
                <p class="text-xs text-gray-600">Lihat & edit semua resep</p>
            </div>
        </a>

        <?php if ($_SESSION['user_role'] == 'admin'): ?>
        <!-- Manage Users (Admin Only) -->
        <a href="manage_users.php" class="group flex flex-col items-center gap-4 p-6 border-2 border-gray-200 rounded-xl hover:border-emerald-400 hover:bg-emerald-50 transition-all duration-300 hover:shadow-lg">
            <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="text-center">
                <p class="font-bold text-gray-900 text-lg mb-1">Kelola Pengguna</p>
                <p class="text-xs text-gray-600">Manajemen akun user</p>
            </div>
        </a>

        <!-- Manage Contacts (Admin Only) -->
        <a href="manage_contacts.php" class="group flex flex-col items-center gap-4 p-6 border-2 border-gray-200 rounded-xl hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 hover:shadow-lg">
            <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="text-center">
                <p class="font-bold text-gray-900 text-lg mb-1">Lihat Pesan</p>
                <p class="text-xs text-gray-600">Pesan dari kontak</p>
            </div>
        </a>
        <?php endif; ?>

        <!-- Create Recipe -->
        <a href="create_recipe.php" class="group flex flex-col items-center gap-4 p-6 border-2 border-gray-200 rounded-xl hover:border-amber-400 hover:bg-amber-50 transition-all duration-300 hover:shadow-lg">
            <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div class="text-center">
                <p class="font-bold text-gray-900 text-lg mb-1">Tambah Resep</p>
                <p class="text-xs text-gray-600">Buat resep baru</p>
            </div>
        </a>
    </div>
</div>

<?php 
include '_footer_admin.php'; // Include footer admin
?>
