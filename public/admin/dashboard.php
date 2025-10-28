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
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Dashboard <?php echo ($_SESSION['user_role'] == 'admin') ? 'Admin' : 'Editor'; ?></h2>
    <p class="text-gray-600">Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></p>
</div>

<!-- Statistics Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-<?php echo ($_SESSION['user_role'] == 'admin') ? '3' : '1'; ?> gap-4 mb-6">
    
    <!-- Total Recipes Card -->
    <div class="bg-white border border-gray-300 rounded p-4">
        <h3 class="text-gray-600 text-sm mb-2">Total Resep</h3>
        <p class="text-3xl font-bold text-gray-800"><?php echo $total_recipes; ?></p>
    </div>

    <?php if ($_SESSION['user_role'] == 'admin'): ?>
    <!-- Total Users Card (Admin Only) -->
    <div class="bg-white border border-gray-300 rounded p-4">
        <h3 class="text-gray-600 text-sm mb-2">Total Pengguna</h3>
        <p class="text-3xl font-bold text-gray-800"><?php echo $total_users; ?></p>
    </div>

    <!-- Total Messages Card (Admin Only) -->
    <div class="bg-white border border-gray-300 rounded p-4">
        <h3 class="text-gray-600 text-sm mb-2">Total Pesan</h3>
        <p class="text-3xl font-bold text-gray-800"><?php echo $total_contacts; ?></p>
    </div>
    <?php endif; ?>
</div>

<!-- Quick Access Section -->
<div class="bg-white border border-gray-300 rounded p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Akses Cepat</h3>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-<?php echo ($_SESSION['user_role'] == 'admin') ? '4' : '2'; ?> gap-4">
        
        <!-- Manage Recipes -->
        <a href="manage_recipes.php" class="block border border-gray-300 rounded p-4 hover:bg-gray-50 text-center">
            <p class="font-bold text-gray-800 mb-1">Kelola Resep</p>
            <p class="text-xs text-gray-600">Lihat & edit semua resep</p>
        </a>

        <?php if ($_SESSION['user_role'] == 'admin'): ?>
        <!-- Manage Users (Admin Only) -->
        <a href="manage_users.php" class="block border border-gray-300 rounded p-4 hover:bg-gray-50 text-center">
            <p class="font-bold text-gray-800 mb-1">Kelola Pengguna</p>
            <p class="text-xs text-gray-600">Manajemen akun user</p>
        </a>

        <!-- Manage Contacts (Admin Only) -->
        <a href="manage_contacts.php" class="block border border-gray-300 rounded p-4 hover:bg-gray-50 text-center">
            <p class="font-bold text-gray-800 mb-1">Lihat Pesan</p>
            <p class="text-xs text-gray-600">Pesan dari kontak</p>
        </a>
        <?php endif; ?>

        <!-- Create Recipe -->
        <a href="create_recipe.php" class="block border border-gray-300 rounded p-4 hover:bg-gray-50 text-center">
            <p class="font-bold text-gray-800 mb-1">Tambah Resep</p>
            <p class="text-xs text-gray-600">Buat resep baru</p>
        </a>
    </div>
</div>

<?php 
include '_footer_admin.php'; // Include footer admin
?>
