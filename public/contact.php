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
                <?php if (isset($_GET['error'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-red-50 text-red-700 border border-red-100"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['success'])): ?>
                    <div class="mb-4 px-4 py-3 rounded-md bg-green-50 text-green-700 border border-green-100"><?php echo htmlspecialchars($_GET['success']); ?></div>
                <?php endif; ?>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <!-- Pesan jika belum login -->
                    <div class="mb-4 px-4 py-3 rounded-md bg-yellow-50 text-yellow-800 border border-yellow-200">
                        <div class="flex items-center gap-2">
                            <p class="font-medium">Anda harus login terlebih dahulu untuk mengirim pesan.</p>
                        </div>
                        <div class="mt-3 flex gap-3">
                            <a href="/tasty_java/public/login.php" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                                Login
                            </a>
                            <a href="/tasty_java/public/register.php" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                Daftar
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Form hanya tampil jika sudah login -->
                    <form action="/tasty_java/app/process_contact.php" method="POST" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="name" id="name" required value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" readonly class="mt-1 block w-full rounded-md border-gray-200 bg-gray-50 shadow-sm cursor-not-allowed">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" readonly class="mt-1 block w-full rounded-md border-gray-200 bg-gray-50 shadow-sm cursor-not-allowed">
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
                <?php endif; ?>
            </div>

            <!-- Contact Info / Map -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Kontak</h3>
                    <p class="mt-2 text-gray-600">Alamat: <span id="alamatText">Gg. Kruwing No. 51, Yogyakarta</span></p>
                    <p class="mt-1 text-gray-600">Email: <a href="mailto:info@tastyjava.local" class="text-primary hover:underline">info@tastyjava.local</a></p>
                    <p class="mt-1 text-gray-600">Telepon: <a href="tel:+628000000000" class="text-primary hover:underline">+62 800-0000-000</a></p>

                    <!-- Copy Address Button -->
                    <button
                        id="copyAddressBtn"
                        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm text-gray-700 hover:bg-gray-50 shadow-sm"
                        aria-label="Salin alamat ke clipboard">
                        <!-- copy icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M16 1H4a2 2 0 00-2 2v12h2V3h12V1z" />
                            <path d="M20 5H8a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2zm0 16H8V7h12v14z" />
                        </svg>
                        Copy Alamat
                    </button>

                    <!-- Open Map Button -->
                    <button
                        id="openMapBtn"
                        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm hover:bg-indigo-700 shadow"
                        aria-haspopup="dialog" aria-controls="mapModal">
                        <!-- expand icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M10 3H5a2 2 0 00-2 2v5h2V5h5V3zM14 21h5a2 2 0 002-2v-5h-2v5h-5v2zM21 7h-5V5h5v2zM3 17h5v2H3v-2z" />
                        </svg>
                        Perbesar Peta
                    </button>
                </div>

                <!-- Map -->
                <div class="w-full h-40 overflow-hidden rounded-lg border border-gray-100 mt-3">
                    <button id="mapThumbBtn" class="w-full h-full block p-0 m-0" aria-label="Buka peta besar" style="all: unset;">
                        <iframe
                            title="Lokasi Tasty Java (thumbnail)"
                            width="200%"
                            height="200%"
                            frameborder="0"
                            style="border:0"
                            src="https://www.google.com/maps?q=Jl.+Contoh+No.1+Kota+Contoh+Indonesia&output=embed"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </button>
                </div>

                <div class="bg-white p-4 rounded-lg border border-gray-100 text-sm text-gray-600">
                    <strong>Jam Operasional:</strong>
                    <p class="mt-1">Senin - Jumat: 09:00 - 17:00</p>
                    <p>Sabtu: 10:00 - 14:00</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Peta -->
    <div id="mapModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold">Lokasi Tasty Java</h3>
                <button id="closeMapBtn" class="text-gray-500 hover:text-gray-700" aria-label="Tutup peta">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="w-full h-96">
                <iframe
                    title="Lokasi Tasty Java (peta besar)"
                    width="100%"
                    height="100%"
                    frameborder="0"
                    style="border:0"
                    src="https://www.google.com/maps?q=Gg.+Kruwing+No.+51+Yogyakarta&output=embed"
                    allowfullscreen
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <section class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-xl font-bold">Ingin berbagi resep?</h3>
            <?php if (isset($_SESSION['user_id'])): ?>
                <p class="mt-2 text-gray-600">Kontak kami dengan memberikan kontribusi, resep, atau saran. Anda akan kami jadikan kontributir/editor Tasty Java.</p>
            <?php else: ?>
                <p class="mt-2 text-gray-600">Daftar dan bagikan kreasi kulinermu supaya lebih banyak orang bisa mencoba.</p>
                <div class="mt-4">
                    <a href="register.php" class="inline-block px-6 py-3 bg-primary text-white rounded-lg">Daftar Sekarang</a>
                <?php endif; ?>
                </div>
        </div>
    </section>

    <!-- Script: copy alamat + buka modal -->
    <script>
        // Copy alamat ke clipboard
        document.getElementById('copyAddressBtn').addEventListener('click', function() {
            const text = document.getElementById('alamatText').innerText.trim();
            if (!navigator.clipboard) {
                // fallback
                const el = document.createElement('textarea');
                el.value = text;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                alert('Alamat disalin ke clipboard');
                return;
            }
            navigator.clipboard.writeText(text).then(() => {
                // notifikasi kecil (bisa diganti toast)
                this.classList.add('ring-2', 'ring-green-300');
                setTimeout(() => this.classList.remove('ring-2', 'ring-green-300'), 800);
            }, () => {
                alert('Gagal menyalin alamat');
            });
        });

        // Modal map
        const mapModal = document.getElementById('mapModal');
        const openMapBtn = document.getElementById('openMapBtn');
        const mapThumbBtn = document.getElementById('mapThumbBtn');
        const closeMapBtn = document.getElementById('closeMapBtn');

        function openModal() {
            mapModal.classList.remove('hidden');
            mapModal.classList.add('flex');
            mapModal.setAttribute('aria-hidden', 'false');
        }

        function closeModal() {
            mapModal.classList.add('hidden');
            mapModal.classList.remove('flex');
            mapModal.setAttribute('aria-hidden', 'true');
        }

        openMapBtn.addEventListener('click', openModal);
        mapThumbBtn.addEventListener('click', openModal);
        closeMapBtn.addEventListener('click', closeModal);
        // close on backdrop click
        mapModal.addEventListener('click', (e) => {
            if (e.target === mapModal) closeModal();
        });
    </script>

    <!-- Simple client-side validation (enhanced UX) -->
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const form = e.target;
            if (!form.reportValidity()) {
                e.preventDefault();
            }
        });
    </script>

    <?php
    include __DIR__ . '/_footer.php';
    ?>