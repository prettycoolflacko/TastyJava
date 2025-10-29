<?php
$page_title = 'Tentang Kami'; 
include __DIR__ . '/_header.php';
?>

<!-- Main wrapper -->
<div class="main-content">

    <!-- HERO -->
    <section class="bg-gradient-to-r from-red-50 to-orange-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900">Tentang Tasty Java</h1>
                    <p class="mt-4 text-lg text-gray-700 max-w-xl text-justify">
                        Tasty Java adalah ruang berbagi resep yang menghadirkan masakan 
                        lokal dari berbagai daerah di Indonesia dengan sederhana, praktis, 
                        dan lezat untuk kegiatan memasak sehari-hari. Kami membangun komunitas 
                        yang saling berbagi ide, teknik, dan inspirasi kuliner.</p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="recipes.php" class="inline-block bg-primary text-white px-5 py-3 rounded-lg shadow hover:bg-primary-dark transition">Jelajahi Resep</a>
                        <a href="contact.php" class="inline-block border border-primary text-primary px-5 py-3 rounded-lg hover:bg-primary hover:text-white transition">Hubungi Kami</a>
                    </div>
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="../assets/about.jpg" alt="About Tasty Java" class="w-full h-full object-cover">
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
                    <p class="mt-3 text-gray-600">Kreativitas, Kebersamaan, dan Kepraktisan. Masakan yang mengandung unsur Bhineka Tunggal Ika.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Apa yang Kami Tawarkan</h3>
                    <p class="mt-3 text-gray-600">Kumpulan resep, tutorial langkah demi langkah, dan ruang bagi kontributor/editor untuk berbagi kreasi kuliner lokal.</p>
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
                    <img src="../assets/pendiri.jpg" alt="Chef" class="w-full h-44 object-cover">
                    <div class="p-5">
                        <h3 class="font-semibold">Chef Admin</h3>
                        <p class="text-sm text-gray-500">Pendiri, Elyuzar Fazlurrahman</p>
                        <p class="mt-3 text-gray-600 text-sm">Memastikan resep yang dipublikasikan jelas, enak, dan mudah diikuti.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <img src="../assets/editor.jpg" alt="Contributor" class="w-full h-44 object-cover">
                    <div class="p-5">
                        <h3 class="font-semibold">Kontributor/Editor</h3>
                        <p class="text-sm text-gray-500">Penulis Resep</p>
                        <p class="mt-3 text-gray-600 text-sm">Membagikan resep masakan lokal dari berbagai daerah di Indonesia.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <img src="../assets/team.jpg" alt="Support" class="w-full h-44 object-cover">
                    <div class="p-5">
                        <h3 class="font-semibold">Tim Teknik</h3>
                        <p class="text-sm text-gray-500">Pengembang & Infrastruktur, Me Myself and I</p>
                        <p class="mt-3 text-gray-600 text-sm">Menjaga website cepat, aman, dan mudah digunakan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
include __DIR__ . '/_footer.php';
?>





