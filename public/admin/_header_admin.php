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
        /* Admin layout with sidebar */
        .admin-layout { 
        display: flex; 
        min-height: 100vh; 
        position: relative;
        }
        /* Sidebar fixed positioning */
        aside {
        position: relative;
        height: 100vh;
        overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <?php
    // Public URL untuk links
    $public = '/tasty_java/public';
    $avatar_url = 'https://i.pinimg.com/736x/c2/37/a9/c237a934a134ce378470cd76501d30bc.jpg';
    $user_name = $_SESSION['user_name'] ?? 'Admin';
    $user_role = $_SESSION['user_role'] ?? 'admin';
    // small esc helper
    function e($s) { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    ?>

    <div class="admin-layout">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#801304ff] text-white shadow-lg">
        
        <!-- Logo/Brand Section -->
        <div class="p-6 border-b border-white/20">
        <a href="<?= $public ?>/admin/dashboard.php" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-[#6b1003] rounded-xl flex items-center justify-center group-hover:bg-[#5a0d02] transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            </div>
            <div>
            <div class="text-lg font-bold">Tasty Java</div>
            <div class="text-xs text-white/70">Admin Panel</div>
            </div>
        </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="px-4 py-6 space-y-2">
        
        <!-- Dashboard Link -->
        <a href="<?= $public ?>/admin/dashboard.php"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'bg-white text-[#801304ff] shadow-md font-semibold' : 'text-white hover:bg-[#6b1003]' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Manage Recipes Link -->
        <a href="<?= $public ?>/admin/manage_recipes.php" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= basename($_SERVER['PHP_SELF']) === 'manage_recipes.php' ? 'bg-white text-[#801304ff] shadow-md font-semibold' : 'text-white hover:bg-[#6b1003]' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>Kelola Resep</span>
        </a>

        <!-- Manage Users Link - Only for Admin -->
        <?php if ($_SESSION['user_role'] == 'admin'): ?>
        <a href="<?= $public ?>/admin/manage_users.php" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= basename($_SERVER['PHP_SELF']) === 'manage_users.php' ? 'bg-white text-[#801304ff] shadow-md font-semibold' : 'text-white hover:bg-[#6b1003]' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span>Manajemen Akun</span>
        </a>
        <?php endif; ?>

        <!-- Manage Contacts Link - Only for Admin -->
        <?php if ($_SESSION['user_role'] == 'admin'): ?>
        <a href="<?= $public ?>/admin/manage_contacts.php" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= basename($_SERVER['PHP_SELF']) === 'manage_contacts.php' ? 'bg-white text-[#801304ff] shadow-md font-semibold' : 'text-white hover:bg-[#6b1003]' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span>Pesan Kontak</span>
        </a>
        <?php endif; ?>

        <!-- Divider -->
        <div class="border-t border-white/20 my-4"></div>

        <!-- Logout Link -->
        <a href="<?= $public ?>/logout.php" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-red-700 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span>Logout</span>
        </a>
        </nav>

        <!-- User Profile Section -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/20 bg-[#6b1003]">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 bg-white rounded-full overflow-hidden border-2 border-white">
            <img src="<?= $avatar_url ?>" alt="avatar" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 min-w-0">
            <div class="font-semibold text-white truncate"><?= e($user_name) ?></div>
            <div class="text-xs text-white/70 flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <?= e($user_role) ?>
            </div>
            </div>
        </div>

        <!-- Back to Home Button -->
        <a href="<?= $public ?>/index.php" 
           class="flex items-center justify-center gap-2 w-full px-4 py-2 rounded-lg bg-[#5a0d02] hover:bg-[#4a0a01] text-white text-sm font-medium transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Ke Halaman Utama</span>
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
