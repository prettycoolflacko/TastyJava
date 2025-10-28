-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 28, 2025 at 08:31 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resep_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Elyuzar Fazlurrohman', 'crovarus@gmail.com', 'Bagus', '2025-10-27 10:49:02'),
(2, 'Ual', 'user@tastyjava.com', 'Saya iungin kontribusi untum menambah resep', '2025-10-28 03:28:31'),
(3, 'user', 'user@tastyjava.com', 'uall', '2025-10-28 03:50:03');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredients` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Bahan-bahan resep',
  `instructions` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Langkah-langkah pembuatan',
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path ke gambar masakan',
  `author_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `ingredients`, `instructions`, `featured_image`, `author_id`, `created_at`) VALUES
(2, 'Nasi Goreng Spesial', 'Bahan Utama:\r\n\r\n2 piring nasi putih dingin (nasi sisa kemarin sangat disarankan)\r\n\r\n2 butir telur ayam\r\n\r\n100 gr daging ayam, potong dadu kecil (atau ganti dengan bakso, sosis, atau udang)\r\n\r\n2 sdm kecap manis (atau sesuai selera)\r\n\r\n1 sdm kecap asin\r\n\r\n1 sdt kaldu bubuk (opsional)\r\n\r\n1/2 sdt merica bubuk\r\n\r\nGaram secukupnya\r\n\r\n2 sdm minyak goreng untuk menumis\r\n\r\nBumbu Halus (Ulek/Blender):\r\n\r\n4 siung bawang merah\r\n\r\n2 siung bawang putih\r\n\r\n3 buah cabai merah keriting (sesuai selera pedas)\r\n\r\n2 buah cabai rawit (opsional, jika suka lebih pedas)\r\n\r\n1/2 sdt terasi bakar (opsional, tapi menambah aroma)\r\n\r\nBahan Pelengkap (Opsional):\r\n\r\nBawang goreng untuk taburan\r\n\r\nAcar timun dan wortel\r\n\r\nIrisan timun dan tomat segar\r\n\r\nKerupuk\r\n\r\nTelur mata sapi (jika suka)', 'Instruksi / Cara Membuat\r\nSiapkan Bumbu: Ulek atau blender semua \"Bumbu Halus\" hingga cukup halus.\r\n\r\nTumis Telur: Panaskan wajan dengan 1 sdm minyak goreng. Masukkan 1 butir telur, buat orak-arik. Angkat dan sisihkan. (Anda juga bisa membuat telur ceplok/mata sapi secara terpisah untuk pelengkap).\r\n\r\nTumis Bumbu: Panaskan sisa 1 sdm minyak di wajan yang sama. Masukkan \"Bumbu Halus\" dan tumis hingga harum dan matang (agak kering).\r\n\r\nMasukkan Isian: Masukkan potongan daging ayam. Masak hingga ayam berubah warna dan matang. Jika menggunakan bakso atau sosis, masukkan di tahap ini.\r\n\r\nMasukkan Nasi: Masukkan nasi putih. Aduk cepat di atas api besar. Gunakan sudip (spatula) untuk menekan dan memisahkan gumpalan nasi agar bumbu merata.\r\n\r\nBeri Bumbu: Tuangkan kecap manis, kecap asin, garam, merica, dan kaldu bubuk. Aduk kembali dengan cepat hingga semua nasi tercampur rata dengan bumbu dan warnanya berubah kecoklatan.\r\n\r\nSatukan Isian: Masukkan kembali telur orak-arik yang sudah disisihkan tadi. Aduk sebentar.\r\n\r\nKoreksi Rasa: Cicipi nasi goreng. Tambahkan kecap manis jika kurang manis, atau garam jika kurang asin. Masak sebentar lagi agar sedikit \"berasap\" untuk aroma yang lebih enak.\r\n\r\nSajikan: Angkat dan sajikan nasi goreng di piring. Taburi dengan bawang goreng dan hidangkan selagi panas bersama bahan pelengkap lainnya.', 'public/uploads/resep_690034a189d92_d37bf17c96e03b533f0f4b1c9b130011.jpg', 2, '2025-10-28 01:36:15'),
(3, 'Gudeg by Tasty Java', '1 Nangka\r\n2 Gudeg\r\n3 Ayam\r\n4 Yummy', '1 Olah gudeg\r\n2 Legenda\r\n3 Jogja\r\n4 Yummy', 'public/uploads/resep_69003659e7557_9b7b2a83-f925-4a0b-b631-b953d20207c0_Go-Biz_20240818_235421.jpeg', 4, '2025-10-28 03:19:53'),
(4, 'Ayam goreng byh Tasty Java', '1 ayam goyeng\r\n2 ayam dan bumbu\r\n3 ayamnya enak', '1 di goreng\r\n2 dihidangkan\r\n3 Maem', 'public/uploads/resep_6900397f9c856_Logo_UPN_Yogyakarta_1.png', 5, '2025-10-28 03:33:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','editor','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`) VALUES
(2, 'Chef Utama', 'chef@resep.com', '$2y$10$NLMH5PE3scKmvi8U3UwQueMfcnHN2GswjU4fRpY/8LRlMMXQOg4Lm', 'admin', '2025-10-27 06:53:14'),
(3, 'user', 'user@tastyjava.com', '$2y$10$skpQvpZ.XJZVOS80p3tiHulc9mDMbXEwcuhRQTjJ11R/kRpGDbapm', 'user', '2025-10-28 02:52:19'),
(4, 'Chef Editor', 'editor@resep.com', '$2y$10$G0aVT3xJnCfZRX0UwAUzG.ZohlIPjb6gF6LLiTQFkc7LQYuRJOC56', 'editor', '2025-10-28 03:00:06'),
(5, 'ual', 'ual@gmail.com', '$2y$10$KrZxtYDMGl.WWHbe6YzNT.wZn5pVdfvtvSqcL0f.uh24Ls9y7sMLq', 'admin', '2025-10-28 03:14:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
