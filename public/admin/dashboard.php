<?php 
$page_title = 'Dashboard';
include '_header_admin.php'; // Include header admin

// Logika untuk mengambil data statistik
// Hitung total resep
$sql_recipes = "SELECT COUNT(*) AS total FROM recipes";
$result_recipes = mysqli_query($conn, $sql_recipes);
$total_recipes = mysqli_fetch_assoc($result_recipes)['total'];

// Hitung total user
$sql_users = "SELECT COUNT(*) AS total FROM users";
$result_users = mysqli_query($conn, $sql_users);
$total_users = mysqli_fetch_assoc($result_users)['total'];

// Hitung total pesan kontak
$sql_contacts = "SELECT COUNT(*) AS total FROM contacts";
$result_contacts = mysqli_query($conn, $sql_contacts);
$total_contacts = mysqli_fetch_assoc($result_contacts)['total'];

?>

<div class="mb-6">
    <h2 class="text-2xl font-semibold mb-2">Selamat Datang di Dashboard Admin</h2>
    <p class="text-sm text-gray-500">Berikut adalah ringkasan statistik website Anda.</p>
</div>

<!-- Statistics Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Recipes Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Total Resep</p>
                <h3 class="text-4xl font-bold"><?php echo $total_recipes; ?></h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-blue-100">Resep yang telah dipublikasikan</span>
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">Total Pengguna</p>
                <h3 class="text-4xl font-bold"><?php echo $total_users; ?></h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-100">Pengguna terdaftar di sistem</span>
        </div>
    </div>

    <!-- Total Messages Card -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">Total Pesan</p>
                <h3 class="text-4xl font-bold"><?php echo $total_contacts; ?></h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-purple-100">Pesan dari pengunjung</span>
        </div>
    </div>
</div>

<!-- Quick Access Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-semibold mb-4">Akses Cepat</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="manage_recipes.php" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-indigo-50 hover:border-indigo-300 transition">
            <div class="bg-indigo-100 rounded-lg p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-900">Kelola Resep</p>
                <p class="text-xs text-gray-500">Lihat semua resep</p>
            </div>
        </a>

        <a href="manage_users.php" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition">
            <div class="bg-green-100 rounded-lg p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-900">Kelola Pengguna</p>
                <p class="text-xs text-gray-500">Manajemen akun</p>
            </div>
        </a>

        <a href="manage_contacts.php" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 transition">
            <div class="bg-purple-100 rounded-lg p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-900">Lihat Pesan</p>
                <p class="text-xs text-gray-500">Pesan kontak</p>
            </div>
        </a>

        <a href="create_recipe.php" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-300 transition">
            <div class="bg-yellow-100 rounded-lg p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-900">Tambah Resep</p>
                <p class="text-xs text-gray-500">Buat resep baru</p>
            </div>
        </a>
    </div>
</div>

<?php 
include '_footer_admin.php'; // Include footer admin
?>





