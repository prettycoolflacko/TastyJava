<?php
// Selalu includekan file config di baris pertama
include '../config/config.php'; 

require_once __DIR__ . '/../app/functions.php';
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
                        primary: '#801304ff',
                        'primary-dark': '#a93226',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">

    <!-- Navigation Header -->
    <nav class="bg-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-2">
                    <img src="https://i.pinimg.com/1200x/2f/dc/d3/2fdcd309a463162eeac0396152b68a1d.jpg" alt="" class="h-8 w-auto"/>
                    <a href="index.php" class="text-white text-2xl font-bold hover:text-gray-200 transition duration-300"> 
                        Tasty Java
                    </a>
                </div>
                
                <!-- Desktop Navigation Links -->
                <div class="flex items-center space-x-4">
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

                    <!-- Admin/Editor Links -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'editor'): ?>
                            <a href="/tasty_java/public/admin/dashboard.php" 
                               class="<?php echo ($current_page == 'dashboard.php') ? 'bg-primary-dark' : ''; ?> text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-dark transition duration-300">
                                <?php echo $_SESSION['user_role'] == 'admin' ? 'Dashboard' : 'Panel Editor'; ?>
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
            </div>
        </div>
    </nav>




