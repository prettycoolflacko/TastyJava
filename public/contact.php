<?php
$page_title = 'Kontak Kami';
include __DIR__ . '/_header.php';
?>

<div class="main-content">

    <!-- HERO -->
    <section class="bg-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900">Hubungi Kami</h1>
            <p class="mt-3 text-gray-600">Punya pertanyaan, kritik, saran, atau request resep? Kirim pesan melalui formulir di bawah dan kami akan merespons sesegera mungkin.</p>
        </div>
    </section>

    <!-- CONTENT -->
    <section class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Contact Form -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                <?php if(isset($_GET['error'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-red-50 text-red-700 border border-red-100"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                <?php if(isset($_GET['success'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-green-50 text-green-700 border border-green-100"><?php echo htmlspecialchars($_GET['success']); ?></div>
                <?php endif; ?>

                <form action="/tasty_java/app/process_contact.php" method="POST" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-primary focus:ring-primary">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-primary focus:ring-primary">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                        <textarea name="message" id="message" rows="6" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary-dark transition">Kirim Pesan</button>
                        <small class="text-xs text-gray-500">Kami akan membalas dalam 1-2 hari kerja.</small>
                    </div>
                </form>
            </div>

            <!-- Contact Info / Map -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Kontak</h3>
                    <p class="mt-2 text-gray-600">Alamat: Jalan Contoh No.1, Kota Contoh</p>
                    <p class="mt-1 text-gray-600">Email: <a href="mailto:info@dapurresep.local" class="text-primary hover:underline">info@dapurresep.local</a></p>
                    <p class="mt-1 text-gray-600">Telepon: <a href="tel:+628000000000" class="text-primary hover:underline">+62 800-0000-000</a></p>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
                    <!-- Optional: embedded map or placeholder image -->
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&q=80&w=1200" alt="Map placeholder" class="w-full h-64 object-cover">
                </div>

                <div class="bg-white p-4 rounded-lg border border-gray-100 text-sm text-gray-600">
                    <strong>Jam Operasional:</strong>
                    <p class="mt-1">Senin - Jumat: 09:00 - 17:00</p>
                    <p>Sabtu: 10:00 - 14:00</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-xl font-bold">Ingin berbagi resep?</h3>
            <p class="mt-2 text-gray-600">Daftar dan bagikan kreasi kulinermu supaya lebih banyak orang bisa mencoba.</p>
            <div class="mt-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="admin/create_recipe.php" class="inline-block px-6 py-3 bg-primary text-white rounded-lg">Tambah Resep</a>
                <?php else: ?>
                    <a href="register.php" class="inline-block px-6 py-3 bg-primary text-white rounded-lg">Daftar Sekarang</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php
include __DIR__ . '/_footer.php';
?>





