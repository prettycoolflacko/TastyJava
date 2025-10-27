<?php
// 1. Panggil Penjaga Keamanan
// Path ../../ app/admin_auth.php
require_once dirname(__DIR__, 2) . '/app/admin_auth.php';

// Mendapatkan nama file saat ini untuk 'active' link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo isset($page_title) ? $page_title : 'Admin Panel'; ?> - Dapur Resep</title>
        <!-- Tailwind for admin UI -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="/tasty_java/assets/css/admin_style.css">
        <style>
            /* small helper to ensure main area shifts when sidebar shown */
            .admin-layout { display: flex; min-height: 100vh; }
        </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <?php
        // Public URL untuk links
        $public = '/tasty_java/public';
        $avatar_url = 'https://cdn-icons-png.flaticon.com/128/3177/3177440.png';
        $user_name = $_SESSION['user_name'] ?? 'Admin';
        $user_role = $_SESSION['user_role'] ?? 'admin';
        // small esc helper
        function e($s) { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    ?>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r hidden md:block">
            <div class="p-6">
                <a href="<?= $public ?>/admin/dashboard.php" class="text-lg font-semibold text-indigo-600 flex items-center gap-2">
                    Dapur Resep — Admin
                </a>
            </div>

            <nav class="px-4 py-6 space-y-2 text-gray-700">
                <a href="<?= $public ?>/admin/dashboard.php"
                     class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-50 <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'bg-indigo-50 font-semibold' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8" />
                    </svg>
                    Dashboard
                </a>

                <a href="<?= $public ?>/admin/manage_recipes.php" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-50 <?= (basename($_SERVER['PHP_SELF']) === 'manage_recipes.php') ? 'bg-indigo-50 font-semibold' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-8-4h8M4 6h16v12H4z" />
                    </svg>
                    Kelola Resep
                </a>

                <a href="<?= $public ?>/admin/manage_users.php" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-50 <?= (basename($_SERVER['PHP_SELF']) === 'manage_users.php') ? 'bg-indigo-50 font-semibold' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-8-4h8M4 6h16v12H4z" />
                    </svg>
                    Manajemen Akun
                </a>

                <a href="<?= $public ?>/logout.php" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-50 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2H11a2 2 0 012 2v1" />
                    </svg>
                    Logout
                </a>
            </nav>

            <div class="p-4 border-t text-sm text-gray-600">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="<?= $avatar_url ?>" alt="avatar" class="w-8 h-8 rounded-full object-cover border">
                        <div>
                            <div class="text-xs text-gray-500 mb-1">Signed in as</div>
                            <div class="font-medium"><?= e($user_name) ?></div>
                            <div class="text-xs text-gray-500 mt-1">Role: <?= e($user_role) ?></div>
                        </div>
                    </div>

                    <a href="<?= $public ?>/admin/profile.php" title="Edit Profile" class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-gray-100">
                        <img src="https://cdn-icons-png.flaticon.com/128/484/484562.png" alt="Edit Profile" class="w-5 h-5" />
                    </a>
                </div>
            </div>

            <div class="border-t p-4 text-sm text-gray-600 space-y-3">
                <a href="<?= $public ?>/index.php" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m0 0l2 2m-2-2v8a2 2 0 01-2 2H7a2 2 0 01-2-2v-8z" />
                    </svg>
                    Kembali Halaman Utama
                </a>
            </div>
        </aside>

        <!-- Main content area -->
        <main class="flex-1">
            <header class="bg-white border-b px-6 py-4 flex items-center justify-between">
                <h1 class="text-lg font-semibold"><?php echo isset($page_title) ? $page_title : 'Admin Panel'; ?></h1>
                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-sm text-gray-600">Halo, <strong><?php echo e($_SESSION['user_name']); ?></strong></div>
                    <a href="<?= $public ?>/logout.php" class="text-sm text-red-600 hover:underline">Logout</a>
                </div>
            </header>

            <section class="p-6">
                <?php if(isset($_GET['success'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-green-50 text-green-700 border border-green-100"><?php echo htmlspecialchars($_GET['success']); ?></div>
                <?php endif; ?>
                <?php if(isset($_GET['error'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-red-50 text-red-700 border border-red-100"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>




