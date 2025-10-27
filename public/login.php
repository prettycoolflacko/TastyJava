<?php
// Include config untuk koneksi database dan session
require_once '../config/config.php';

// Jika user SUDAH login, tendang ke index.php
if (isset($_SESSION['user_id'])) {
        header("Location: /tasty_java/public/index.php");
        exit();
}

// Set page title and include header for consistent layout (header loads Tailwind)
$page_title = 'Login - Dapur Resep';
include __DIR__ . '/_header.php';
?>

<!-- Main content wrapper (footer will close .main-content) -->
<div class="main-content">
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Masuk ke Dapur Resep</h2>
                <p class="mt-2 text-sm text-gray-600">Belum punya akun? <a href="register.php" class="text-primary font-medium hover:underline">Daftar sekarang</a></p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <?php if(isset($_GET['error'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-red-50 text-red-700 border border-red-100"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                <?php if(isset($_GET['success'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-green-50 text-green-700 border border-green-100"><?php echo htmlspecialchars($_GET['success']); ?></div>
                <?php endif; ?>

                <form class="mt-4 space-y-4" action="/tasty_java/app/process_login.php" method="POST" novalidate>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-primary focus:ring-primary px-3 py-2" placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-primary focus:ring-primary px-3 py-2" placeholder="Masukkan password Anda">
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-600">Ingat saya</label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark font-medium">Masuk</button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer which closes .main-content
include __DIR__ . '/_footer.php';
?>




