-- Buat database
CREATE DATABASE IF NOT EXISTS `resep_blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `resep_blog`;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `recipes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `ingredients` TEXT NOT NULL COMMENT 'Bahan-bahan resep',
  `instructions` TEXT NOT NULL COMMENT 'Langkah-langkah pembuatan',
  `featured_image` VARCHAR(255) NULL COMMENT 'Path ke gambar masakan',
  `author_id` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `contacts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
-- Insert admin user dengan password 'admin123' yang sudah di-hash menggunakan bcrypt
-- Password: admin123
INSERT INTO `users` (`name`, `email`, `password_hash`, `role`) 
VALUES (
  'Chef Admin', 
  'admin@resep.com', 
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
  'admin'
);

-- Insert user biasa dengan password 'user123'
-- Password: user123
INSERT INTO `users` (`name`, `email`, `password_hash`, `role`) 
VALUES (
  'User Test', 
  'user@resep.com', 
  '$2y$10$7KiWJqEd5mGQ5U3PvGQk3OJ8YRq5xGx5wXLJ5Y8vqH0Q.gUKvXqBW', 
  'user'
);
