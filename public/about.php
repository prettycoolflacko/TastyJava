<?php
$page_title = 'Tentang Kami'; // Set judul halaman
include __DIR__ . '/_header.php'; // Include template header (Tailwind is loaded in header)
?>

<!-- Main wrapper (footer expects to close .main-content) -->
<div class="main-content">

    <!-- HERO -->
    <section class="bg-gradient-to-r from-red-50 to-orange-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900">Tentang Tasty Java</h1>
                    <p class="mt-4 text-lg text-gray-700 max-w-xl">
                        Tasty Java adalah ruang berbagi resep yang 
                        menghadirkan masakan sederhana, praktis, dan lezat untuk 
                        kegiatan memasak sehari-hari. Kami membangun komunitas yang 
                        saling berbagi ide, teknik, dan inspirasi kuliner.</p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="recipes.php" class="inline-block bg-primary text-white px-5 py-3 rounded-lg shadow hover:bg-primary-dark transition">Jelajahi Resep</a>
                        <a href="contact.php" class="inline-block border border-primary text-primary px-5 py-3 rounded-lg hover:bg-primary hover:text-white transition">Hubungi Kami</a>
                    </div>
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="https://i.pinimg.com/1200x/5d/c8/13/5dc813fddddd9edea5a439a886c85c90.jpg" alt="About Tasty Java" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- MISSION & VALUES -->
    <section class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Misi Kami</h3>
                    <p class="mt-3 text-gray-600">Menginspirasi setiap orang untuk memasak di rumah dengan resep yang mudah diikuti dan bahan yang mudah ditemukan.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Nilai Kami</h3>
                    <p class="mt-3 text-gray-600">Kreativitas, Kebersamaan, dan Kepraktisan. Kami percaya memasak menyatukan keluarga dan teman.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Apa yang Kami Tawarkan</h3>
                    <p class="mt-3 text-gray-600">Kumpulan resep, tutorial langkah demi langkah, dan ruang bagi kontributor untuk berbagi kreasi kuliner.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES / Highlights -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Fitur Utama</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100 text-center">
                    <div class="text-3xl">🍲</div>
                    <h4 class="mt-3 font-semibold">Resep Teruji</h4>
                    <p class="mt-2 text-sm text-gray-600">Resep yang mudah diikuti dan dicoba di rumah.</p>
                </div>
                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100 text-center">
                    <div class="text-3xl">📚</div>
                    <h4 class="mt-3 font-semibold">Tutorial Praktis</h4>
                    <p class="mt-2 text-sm text-gray-600">Panduan langkah demi langkah untuk pemula.</p>
                </div>
                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100 text-center">
                    <div class="text-3xl">🤝</div>
                    <h4 class="mt-3 font-semibold">Komunitas</h4>
                    <p class="mt-2 text-sm text-gray-600">Berbagi resep dan tips antar pengguna.</p>
                </div>
                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100 text-center">
                    <div class="text-3xl">⚡</div>
                    <h4 class="mt-3 font-semibold">Cepat & Mudah</h4>
                    <p class="mt-2 text-sm text-gray-600">Resep yang hemat waktu dan bahan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM / CONTRIBUTORS -->
    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Tim & Kontributor</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <img src="https://i.pinimg.com/736x/2c/db/a7/2cdba7f219f0a15880bb6286c15fadf1.jpg" alt="Chef" class="w-full h-44 object-cover">
                    <div class="p-5">
                        <h3 class="font-semibold">Chef Admin</h3>
                        <p class="text-sm text-gray-500">Pendiri</p>
                        <p class="mt-3 text-gray-600 text-sm">Memastikan resep yang dipublikasikan jelas, enak, dan mudah diikuti.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <img src="https://i.pinimg.com/736x/a9/fa/69/a9fa6925b303116061edb98e27c453c6.jpg" alt="Contributor" class="w-full h-44 object-cover">
                    <div class="p-5">
                        <h3 class="font-semibold">Kontributor</h3>
                        <p class="text-sm text-gray-500">Penulis Resep</p>
                        <p class="mt-3 text-gray-600 text-sm">Membagikan kreasi masakan rumahan dari berbagai daerah.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <img src="https://i.pinimg.com/1200x/21/f9/b1/21f9b15d71cf787cf10823cf2c499f53.jpg" alt="Support" class="w-full h-44 object-cover">
                    <div class="p-5">
                        <h3 class="font-semibold">Tim Teknik</h3>
                        <p class="text-sm text-gray-500">Pengembang & Infrastruktur</p>
                        <p class="mt-3 text-gray-600 text-sm">Menjaga website cepat, aman, dan mudah digunakan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CALL TO ACTION
    <section class="py-12 bg-gradient-to-r from-primary to-primary-dark text-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold">Ingin Berkontribusi Resep?</h2>
            <p class="mt-3 text-white/90">Bergabunglah sebagai kontributor dan bagikan resep favoritmu kepada komunitas kami.</p>
            <div class="mt-6 flex justify-center gap-3">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="create_recipe.php" class="bg-white text-primary px-6 py-3 rounded-lg font-medium">Tambah Resep</a>
                <?php else: ?>
                    <a href="register.php" class="bg-white text-primary px-6 py-3 rounded-lg font-medium">Daftar Sekarang</a>
                    <a href="login.php" class="border-2 border-white px-6 py-3 rounded-lg">Login</a>
                <?php endif; ?>
            </div>
        </div> -->
    <!-- </section> -->

<?php
// Include footer (footer closes the .main-content div)
include __DIR__ . '/_footer.php';
?>





