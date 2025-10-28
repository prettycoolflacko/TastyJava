
USE `resep_blog`;

-- 1. Ubah kolom role untuk menambahkan 'editor'
ALTER TABLE `users` 
MODIFY COLUMN `role` ENUM('admin', 'editor', 'user') NOT NULL DEFAULT 'user';

-- 2. Insert sample editor user (Password: editor123)
INSERT INTO `users` (`name`, `email`, `password_hash`, `role`) 
VALUES (
  'Chef Editor', 
  'editor@resep.com', 
  '$2y$10$wJRu53TJKhy3on0E1Pz9aO0Sa0BhGVDyyLTPu3eNqgBocMyYrSUG.', 
  'editor'
);

