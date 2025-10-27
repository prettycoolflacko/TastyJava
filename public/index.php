<?php 
// 1. Set judul halaman
$page_title = 'Tasty Java, Taste from Indonesia';

// 2. Include header
include __DIR__ . '/_header.php'; 

// 3. Ambil 3 resep terbaru dari database
$sql = "SELECT recipes.id, recipes.title, recipes.featured_image, recipes.ingredients, users.name AS author_name 
        FROM recipes 
        JOIN users ON recipes.author_id = users.id 
        ORDER BY recipes.id DESC
        LIMIT 3";

$result = mysqli_query($conn, $sql);
$latest_recipes = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Ambil excerpt dari ingredients
        $excerpt = substr(strip_tags($row['ingredients']), 0, 120) . '...';
        $latest_recipes[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'image' => $row['featured_image'] ? '/tasty_java/' . $row['featured_image'] : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=1170',
            'author_name' => $row['author_name'],
            'excerpt' => $excerpt
        ];
    }
}

?>
<!-- HERO: Carousel (Full Width) -->
<section class="mb-12">
  <div class="relative">
    <div id="carousel" class="relative overflow-hidden shadow-lg">
      <!-- Slides -->
      <div class="carousel-slides relative h-[420px] md:h-[520px]">
          <div class="carousel-item absolute inset-0 transition-opacity duration-700 ease-in-out opacity-100" data-index="0" aria-hidden="false">
            <img src="https://i.pinimg.com/1200x/0b/bb/e8/0bbbe8435a1373f6564377a6059cb710.jpg" alt="Tasty Java 1" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/30"></div>
            <div class="absolute inset-0 flex flex-col justify-center items-start md:items-center text-left md:text-center px-6 md:px-12 text-white">
              <h2 class="text-3xl md:text-5xl font-extrabold drop-shadow-lg leading-tight">🍳 Welcome to Tasty Java</h2>
              <p class="mt-4 text-sm md:text-lg text-white/90 max-w-3xl">All the local Indonesian taste, in one place one recipe at a time.</p>
              <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <a href="recipes.php" class="inline-block bg-primary text-white px-5 py-3 rounded-lg shadow hover:bg-primary-dark transition duration-300">Jelajahi Resep</a>
                <?php if (!isset($_SESSION['user_id'])): ?>
                  <a href="register.php" class="inline-block border border-white text-white px-5 py-3 rounded-lg hover:bg-white hover:text-primary transition duration-300">Bergabung Sekarang</a>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="carousel-item absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0" data-index="1" aria-hidden="true">
            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=1600" alt="Resep Terbaru" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/30"></div>
            <div class="absolute inset-0 flex flex-col justify-center items-start md:items-center text-left md:text-center px-6 md:px-12 text-white">
              <h2 class="text-3xl md:text-5xl font-extrabold drop-shadow-lg leading-tight">Resep & Tutorial Terbaru</h2>
              <p class="mt-4 text-sm md:text-lg text-white/90 max-w-3xl">Temukan panduan praktis masakan rumahan yang dibuat dengan cinta oleh para chef dan kontributor.</p>
              <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <a href="recipes.php" class="inline-block bg-primary text-white px-5 py-3 rounded-lg shadow hover:bg-primary-dark transition duration-300">Lihat Resep</a>
              </div>
            </div>
          </div>

          <div class="carousel-item absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0" data-index="2" aria-hidden="true">
            <img src="https://res.cloudinary.com/rainforest-cruises/images/c_fill,g_auto/f_auto,q_auto/v1622207839/Indonesian-Food-Stall/Indonesian-Food-Stall.jpg" alt="Berbagi Resep" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/30"></div>
            <div class="absolute inset-0 flex flex-col justify-center items-start md:items-center text-left md:text-center px-6 md:px-12 text-white">
              <h2 class="text-3xl md:text-5xl font-extrabold drop-shadow-lg leading-tight">Berbagi Resep Favorit</h2>
              <p class="mt-4 text-sm md:text-lg text-white/90 max-w-3xl">Bergabung dengan komunitas pecinta kuliner dan bagikan resep favoritmu di sini.</p>
              <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin'): ?>
                  <a href="admin/create_recipe.php" class="inline-block bg-primary text-white px-5 py-3 rounded-lg shadow hover:bg-primary-dark transition duration-300">Tambah Resep Baru</a>
                <?php else: ?>
                  <a href="login.php" class="inline-block bg-primary text-white px-5 py-3 rounded-lg shadow hover:bg-primary-dark transition duration-300">Login untuk Berkontribusi</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Controls -->
        <button id="prevBtn" class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow focus:outline-none transition" aria-label="Previous slide">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button id="nextBtn" class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow focus:outline-none transition" aria-label="Next slide">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
          <button class="carousel-dot w-3 h-3 rounded-full bg-white/90" data-to="0" aria-label="Slide 1"></button>
          <button class="carousel-dot w-3 h-3 rounded-full bg-white/50" data-to="1" aria-label="Slide 2"></button>
          <button class="carousel-dot w-3 h-3 rounded-full bg-white/50" data-to="2" aria-label="Slide 3"></button>
        </div>
      </div>
    </div>
  </section>
</section>

<!-- Main Content Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  <!-- RESEP TERBARU -->
  <section class="mb-12">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">Resep Terbaru</h2>
      <a href="recipes.php" class="text-primary hover:underline text-sm font-medium">Lihat Semua Resep →</a>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <?php if (empty($latest_recipes)): ?>
        <div class="col-span-full text-center py-12">
          <p class="text-gray-600 text-lg">Belum ada resep yang dipublikasikan.</p>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin'): ?>
            <a href="admin/create_recipe.php" class="inline-block mt-4 bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark transition">Tambah Resep Pertama</a>
          <?php else: ?>
            <p class="text-gray-500 mt-2">Silakan login sebagai admin untuk menambah resep.</p>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <?php foreach ($latest_recipes as $recipe): ?>
          <article class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition duration-300">
            <a href="recipe_detail.php?id=<?= $recipe['id'] ?>" class="block h-48">
              <img src="<?= htmlspecialchars($recipe['image']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" class="w-full h-full object-cover hover:scale-105 transition duration-300">
            </a>
            <div class="p-5">
              <h3 class="text-lg font-semibold text-gray-800 hover:text-primary transition">
                <a href="recipe_detail.php?id=<?= $recipe['id'] ?>"><?= htmlspecialchars($recipe['title']) ?></a>
              </h3>
              <p class="text-xs text-gray-500 mt-1">Oleh: <?= htmlspecialchars($recipe['author_name']) ?></p>
              <p class="text-sm text-gray-600 mt-3 line-clamp-3"><?= htmlspecialchars($recipe['excerpt']) ?></p>
              <div class="mt-4 flex items-center justify-between">
                <a href="recipe_detail.php?id=<?= $recipe['id'] ?>" class="text-primary font-medium text-sm hover:underline">Lihat Resep →</a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="mb-12 bg-gradient-to-r from-red-50 to-orange-50 rounded-lg p-8">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-2xl font-semibold text-primary">Tentang Tasty Java</h2>
      <p class="mt-3 text-gray-700">
        Tasty Java adalah platform berbagi resep masakan yang dibuat untuk memudahkan Anda menemukan inspirasi masakan.
        Semua resep dikurasi dengan baik dan mudah diikuti. Di sini kamu dapat menemukan berbagai resep,
        mulai dari masakan tradisional hingga masakan modern yang cocok untuk keluarga.
      </p>
    </div>
  </section>

  <!-- CALL TO ACTION / Social -->
  <section class="mb-16">
    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row items-center justify-between gap-4">
      <div>
        <h3 class="text-lg font-semibold text-gray-800">Tetap Terhubung</h3>
        <p class="text-sm text-gray-600 mt-1">Ikuti update resep terbaru dan tips memasak—jangan lupa bagikan resep favoritmu!</p>
      </div>

      <div class="flex items-center gap-3">
        <!-- Instagram -->
        <a href="https://instagram.com/elyuzar_f" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-yellow-400 shadow hover:scale-110 transition-transform" aria-label="Instagram">
          <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
        </a>

        <!-- WhatsApp -->
        <a href="https://wa.me/6281227948664" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full bg-green-500 shadow hover:scale-110 transition-transform" aria-label="WhatsApp">
          <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>

        <!-- Twitter -->
        <a href="https://twitter.com/asaprocky" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-400 shadow hover:scale-110 transition-transform" aria-label="Twitter">
          <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
        </a>
      </div>
    </div>
  </section>

</div>

<!-- Carousel script -->
<script>
(function(){
  const slides = Array.from(document.querySelectorAll('#carousel .carousel-item'));
  const dots = Array.from(document.querySelectorAll('#carousel .carousel-dot'));
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  let current = 0;
  let timer = null;
  const delay = 3500;

  function show(idx) {
    slides.forEach((s, i) => {
      if (i === idx) {
        s.style.opacity = '1';
        s.setAttribute('aria-hidden','false');
      } else {
        s.style.opacity = '0';
        s.setAttribute('aria-hidden','true');
      }
    });
    dots.forEach((d, i) => {
      d.classList.toggle('bg-white/90', i === idx);
      d.classList.toggle('bg-white/50', i !== idx);
    });
    current = idx;
  }

  function next() { show((current + 1) % slides.length); }
  function prev() { show((current - 1 + slides.length) % slides.length); }

  // auto play
  function startTimer() { timer = setInterval(next, delay); }
  function stopTimer() { if (timer) clearInterval(timer); }

  // events
  nextBtn.addEventListener('click', () => { stopTimer(); next(); startTimer(); });
  prevBtn.addEventListener('click', () => { stopTimer(); prev(); startTimer(); });
  dots.forEach(d => d.addEventListener('click', () => { stopTimer(); show(parseInt(d.getAttribute('data-to'))); startTimer(); }));

  // pause on hover
  const carouselEl = document.getElementById('carousel');
  carouselEl.addEventListener('mouseenter', stopTimer);
  carouselEl.addEventListener('mouseleave', startTimer);

  // init
  show(0);
  startTimer();
})();
</script>

<?php 
// 4. Include footer
include __DIR__ . '/_footer.php'; 
?>