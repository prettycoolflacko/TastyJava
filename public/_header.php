<?php
// Selalu includekan file config di baris pertama
include '../config/config.php'; 

// Get current page for active link highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Blog Resep Sederhana'; ?></title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#c0392b',
                        'primary-dark': '#a93226',
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS for additional styles -->
    <link rel="stylesheet" href="/tasty_java/assets/css/style.css">
</head>
<body class="bg-gray-50">

    <!-- Navigation Header -->
    <nav class="bg-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex-shrink-0">
                    <a href="index.php" class="text-white text-2xl font-bold hover:text-gray-200 transition duration-300">
                        🍳 Dapur Resep
                    </a>
                </div>
                
                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex md:items-center md:space-x-4">
                    <a href="index.php" 
                       class="<?php echo ($current_page == 'index.php') ? 'bg-primary-dark' : ''; ?> text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-dark transition duration-300">
                        Home
                    </a>
                    <a href="recipes.php" 
                       class="<?php echo ($current_page == 'recipes.php') ? 'bg-primary-dark' : ''; ?> text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-dark transition duration-300">
                        Resep
                    </a>

                    <a href="about.php" 
                       class="<?php echo ($current_page == 'about.php') ? 'bg-primary-dark' : ''; ?> text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-dark transition duration-300">
                        Tentang Kami
                    </a>

                    <a href="contact.php" 
                       class="<?php echo ($current_page == 'contact.php') ? 'bg-primary-dark' : ''; ?> text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-dark transition duration-300">
                        Kontak Kami
                    </a>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['user_role'] == 'admin'): ?>
                            <a href="/tasty_java/public/admin/dashboard.php" 
                               class="<?php echo ($current_page == 'dashboard.php') ? 'bg-primary-dark' : ''; ?> text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-dark transition duration-300">
                                Dashboard
                            </a>
                        <?php endif; ?>
                        
                        <!-- User Dropdown -->
                        <div class="flex items-center space-x-3">
                            <span class="text-white text-sm">
                                Halo, <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                            </span>
                            <a href="logout.php" 
                               class="bg-white text-primary px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition duration-300">
                                Logout
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" 
                           class="<?php echo ($current_page == 'login.php') ? 'bg-primary-dark' : ''; ?> text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-dark transition duration-300">
                            Login
                        </a>
                        <a href="register.php" 
                           class="bg-white text-primary px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition duration-300">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" 
                            class="text-white hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="index.php" 
                   class="<?php echo ($current_page == 'index.php') ? 'bg-primary-dark' : ''; ?> text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-dark">
                    Home
                </a>
                <a href="recipes.php" 
                   class="<?php echo ($current_page == 'recipes.php') ? 'bg-primary-dark' : ''; ?> text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-dark">
                    Resep
                </a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] == 'admin'): ?>
                        <a href="admin_dashboard.php" 
                           class="text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-dark">
                            Dashboard
                        </a>
                    <?php endif; ?>
                    <div class="border-t border-primary-dark pt-2 mt-2">
                        <p class="text-white px-3 py-2 text-sm">
                            Halo, <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        </p>
                        <a href="logout.php" 
                           class="text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-dark">
                            Logout
                        </a>
                    </div>
                <?php else: ?>
                    <a href="login.php" 
                       class="<?php echo ($current_page == 'login.php') ? 'bg-primary-dark' : ''; ?> text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-dark">
                        Login
                    </a>
                    <a href="register.php" 
                       class="<?php echo ($current_page == 'register.php') ? 'bg-primary-dark' : ''; ?> text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-primary-dark">
                        Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>




