<?php
// Include config and redirect logged-in users
require_once '../config/config.php';
if (isset($_SESSION['user_id'])) {
        header('Location: /tasty_java/public/index.php');
        exit();
}

$page_title = 'Daftar - Dapur Resep';
include __DIR__ . '/_header.php';
?>

<div class="main-content">
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Buat Akun Baru</h2>
                <p class="mt-2 text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-primary font-medium hover:underline">Masuk di sini</a></p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <?php if(isset($_GET['error'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-red-50 text-red-700 border border-red-100"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                <?php if(isset($_GET['success'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-green-50 text-green-700 border border-green-100"><?php echo htmlspecialchars($_GET['success']); ?></div>
                <?php endif; ?>

                <form class="mt-4 space-y-4" action="/tasty_java/app/process_register.php" method="POST" novalidate>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-primary focus:ring-primary px-3 py-2">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-primary focus:ring-primary px-3 py-2">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-primary focus:ring-primary px-3 py-2">
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input id="confirm_password" name="confirm_password" type="password" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-primary focus:ring-primary px-3 py-2">
                    </div>

                    <div>
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark font-medium">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/_footer.php'; ?>




