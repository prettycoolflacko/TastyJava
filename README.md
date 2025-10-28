# 🍳 Tasty Java - Website Resep Masakan

![Tasty Java](https://img.shields.io/badge/PHP-7.4+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.0+-38bdf8.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

Website resep masakan modern dengan fitur manajemen resep, user authentication, dan admin panel yang lengkap.

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi & Setup](#-instalasi--setup)
- [Struktur Proyek](#-struktur-proyek)
- [Panduan Penggunaan](#-panduan-penggunaan)
- [Screenshot](#-screenshot)
- [Troubleshooting](#-troubleshooting)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

## ✨ Fitur Utama

### 🎯 Fitur User (Pengunjung)
- **Homepage**: Tampilan resep terbaru dengan desain modern
- **Daftar Resep**: Browse semua resep dengan search functionality
- **Detail Resep**: Lihat bahan-bahan dan cara membuat lengkap
- **Halaman About**: Informasi tentang website
- **Halaman Contact**: Form kontak untuk menghubungi admin
- **Authentication**: Register dan Login untuk user

### 👨‍💼 Fitur Admin
- **Dashboard**: Statistik total resep, users, dan pesan kontak
- **Kelola Resep**: Create, Read, Update, Delete (CRUD) resep
- **Kelola User**: Manajemen user dan role (admin/user)
- **Kelola Pesan**: Lihat dan hapus pesan dari form kontak
- **Upload Gambar**: Upload featured image untuk setiap resep
- **Admin Sidebar**: Navigasi modern dengan tema orange/red

### 🔒 Keamanan
- Password hashing dengan `password_hash()` dan `password_verify()`
- Prepared statements untuk mencegah SQL injection
- Session management untuk authentication
- Role-based access control (Admin & User)
- XSS protection dengan `htmlspecialchars()`

## 🛠 Teknologi yang Digunakan

### Backend
- **PHP 7.4+**: Server-side scripting
- **MySQL 8.0+**: Database management
- **MySQLi**: Database connection & queries

### Frontend
- **HTML5**: Semantic markup
- **Tailwind CSS 3.0+**: Utility-first CSS framework (via CDN)
- **JavaScript**: Interactive features (image preview, modal)

### Development Tools
- **Laragon**: Local development environment (LAMP stack)
- **Git**: Version control
- **VS Code**: Code editor (recommended)

## 📦 Persyaratan Sistem

### Software Requirements
- PHP >= 7.4
- MySQL >= 8.0 atau MariaDB >= 10.4
- Web Server (Apache/Nginx)
- Browser modern (Chrome, Firefox, Edge, Safari)

### Recommended Setup
- **Laragon** (sudah include Apache, PHP, MySQL)
- RAM minimal 2GB
- Storage minimal 500MB

## 🚀 Instalasi & Setup

### Metode 1: Menggunakan Laragon (Recommended)

#### Step 1: Install Laragon
1. Download Laragon dari [https://laragon.org/download/](https://laragon.org/download/)
2. Install Laragon di komputer Anda
3. Jalankan Laragon

#### Step 2: Clone/Download Project
```bash
# Clone project ke folder www Laragon
cd C:\laragon\www
git clone https://github.com/prettycoolflacko/TastyJava.git tasty_java

# Atau download ZIP dan extract ke C:\laragon\www\tasty_java
```

#### Step 3: Setup Database
1. Buka Laragon → klik **Database** → klik **phpMyAdmin**
2. Atau buka browser: `http://localhost/phpmyadmin`
3. Buat database baru bernama `resep_blog`
4. Import file SQL:
   - Klik database `resep_blog`
   - Klik tab **Import**
   - Pilih file `tasty_java.sql` dari root project
   - Klik **Go**

#### Step 4: Konfigurasi Database
Buka file `config/config.php` dan sesuaikan jika perlu:

```php
$servername = "localhost";
$username = "root";
$password = "";  // Kosongkan jika menggunakan Laragon default
$dbname = "resep_blog";
```

#### Step 5: Buat Folder Uploads
Pastikan folder uploads ada dan memiliki permission write:

```bash
# Di Windows (via Command Prompt di folder project)
mkdir public\uploads

# Atau buat manual folder 'uploads' di dalam folder 'public'
```

#### Step 6: Jalankan Aplikasi
1. Buka browser
2. Akses: `http://localhost/tasty_java/public/index.php`
3. Website siap digunakan! 🎉

### Metode 2: Setup Manual (XAMPP/WAMP)

#### Step 1: Install XAMPP/WAMP
- Download dan install XAMPP atau WAMP

#### Step 2: Copy Project
- Extract project ke `C:\xampp\htdocs\tasty_java` (XAMPP)
- Atau ke `C:\wamp64\www\tasty_java` (WAMP)

#### Step 3: Setup Database
- Start Apache dan MySQL dari XAMPP/WAMP Control Panel
- Buka `http://localhost/phpmyadmin`
- Buat database `resep_blog`
- Import `tasty_java.sql`

#### Step 4: Konfigurasi
- Edit `config/config.php` sesuai kebutuhan
- Buat folder `public/uploads`

#### Step 5: Akses Website
- Buka `http://localhost/tasty_java/public/index.php`

## 📁 Struktur Proyek

```
tasty_java/
│
├── app/                          # Backend Logic
│   ├── admin_auth.php           # Admin authentication guard
│   ├── process_contact.php      # Handle contact form & delete
│   ├── process_login.php        # Login processing
│   ├── process_recipe.php       # CRUD operations for recipes
│   ├── process_register.php     # User registration
│   └── process_user.php         # User management (admin)
│
├── assets/                       # Static Assets
│   └── css/
│       ├── admin_style.css      # Admin panel styles
│       └── style.css            # Public site styles
│
├── config/                       # Configuration
│   └── config.php               # Database connection & session
│
├── public/                       # Public Web Root
│   ├── admin/                   # Admin Panel
│   │   ├── create_recipe.php   # Create new recipe
│   │   ├── dashboard.php        # Admin dashboard
│   │   ├── edit_recipe.php      # Edit existing recipe
│   │   ├── manage_contacts.php  # View/delete contact messages
│   │   ├── manage_recipes.php   # List all recipes (admin)
│   │   ├── manage_users.php     # User management
│   │   ├── _footer_admin.php    # Admin footer
│   │   └── _header_admin.php    # Admin header & sidebar
│   │
│   ├── uploads/                 # Uploaded images
│   │   └── [recipe images]      # Featured images for recipes
│   │
│   ├── about.php                # About page
│   ├── contact.php              # Contact form page
│   ├── index.php                # Homepage
│   ├── login.php                # Login page
│   ├── logout.php               # Logout handler
│   ├── recipe_detail.php        # Single recipe view
│   ├── recipes.php              # All recipes listing
│   ├── register.php             # Registration page
│   ├── _footer.php              # Public footer
│   └── _header.php              # Public header & navigation
│
├── tasty_java.sql               # Database structure & sample data
└── README.md                    # Documentation (this file)
```

## 📖 Panduan Penggunaan

### First Time Setup

#### 1. Login sebagai Admin (Default Account)
Setelah import database, Anda akan memiliki akun admin default:

```
Email: admin@tastyjava.com
Password: admin123
```

⚠️ **PENTING**: Segera ubah password admin setelah login pertama kali!

#### 2. Membuat User Baru
- Klik **Register** di homepage
- Isi form registrasi (Name, Email, Password)
- User baru akan memiliki role "user" secara default
- Admin dapat mengubah role user di menu **Manajemen Akun**

### Menggunakan Admin Panel

#### Akses Admin Panel
1. Login dengan akun admin
2. Otomatis redirect ke: `http://localhost/tasty_java/public/admin/dashboard.php`
3. Atau klik **Dashboard** di navigation bar

#### Mengelola Resep

**Membuat Resep Baru:**
1. Di Dashboard, klik **Tambah Resep** atau menu **Kelola Resep** → **Create Recipe**
2. Isi form:
   - **Judul Resep**: Nama resep
   - **Bahan-bahan**: List bahan (satu baris per bahan)
   - **Cara Membuat**: Step-by-step instruksi
   - **Featured Image**: Upload gambar resep (optional)
3. Klik **Simpan Resep**

**Mengedit Resep:**
1. Di **Kelola Resep**, klik tombol **Edit** pada resep
2. Ubah data yang diperlukan
3. Upload gambar baru jika ingin mengganti (optional)
4. Klik **Update Resep**

**Menghapus Resep:**
1. Di **Kelola Resep**, klik tombol **Hapus**
2. Konfirmasi penghapusan
3. Resep akan terhapus permanen

#### Mengelola User

**Melihat Semua User:**
- Menu **Manajemen Akun** menampilkan semua user terdaftar

**Mengubah Role User:**
1. Pilih role dari dropdown (User/Admin)
2. Klik **Update**
3. User akan mendapat akses admin jika diubah ke role "Admin"

**Menghapus User:**
1. Klik tombol **Hapus** pada user
2. Konfirmasi penghapusan
3. ⚠️ User tidak bisa menghapus akunnya sendiri

#### Mengelola Pesan Kontak

**Melihat Pesan:**
- Menu **Pesan Kontak** menampilkan semua pesan dari form kontak
- Gunakan search untuk mencari pesan tertentu
- Klik **Lihat** untuk membaca pesan lengkap di modal

**Menghapus Pesan:**
1. Klik tombol **Hapus** pada pesan
2. Konfirmasi penghapusan

### Menggunakan Website (User)

#### Browsing Resep
1. **Homepage**: Lihat 6 resep terbaru
2. **Semua Resep**: Klik menu **Resep** untuk melihat semua
3. **Search**: Gunakan search bar untuk mencari resep
4. **Detail**: Klik resep untuk melihat detail lengkap

#### Mengirim Pesan
1. Klik menu **Kontak**
2. Isi form (Nama, Email, Pesan)
3. Klik **Kirim Pesan**
4. Pesan akan masuk ke admin panel

## 📸 Screenshot

### Homepage
![Homepage](docs/screenshots/homepage.png)
*Homepage dengan resep terbaru dan hero section*

### Admin Dashboard
![Admin Dashboard](docs/screenshots/dashboard.png)
*Dashboard admin dengan statistik dan quick access*

### Detail Resep
![Recipe Detail](docs/screenshots/recipe-detail.png)
*Halaman detail resep dengan bahan dan cara membuat*

### Admin Panel - Kelola Resep
![Manage Recipes](docs/screenshots/manage-recipes.png)
*Admin panel untuk mengelola semua resep*

## 🐛 Troubleshooting

### Error: "Database connection failed"
**Solusi:**
- Pastikan MySQL service running di Laragon/XAMPP
- Cek credential di `config/config.php`
- Pastikan database `resep_blog` sudah dibuat

### Error: "Access denied for user 'root'"
**Solusi:**
- Cek username dan password di `config/config.php`
- Default Laragon: username `root`, password kosong
- Default XAMPP: username `root`, password kosong

### Gambar tidak muncul setelah upload
**Solusi:**
- Pastikan folder `public/uploads/` ada
- Cek permission folder (harus writable)
- Windows: Klik kanan → Properties → Security → Full Control

### CSS tidak load / Tampilan berantakan
**Solusi:**
- Cek apakah koneksi internet aktif (Tailwind via CDN)
- Clear browser cache (Ctrl + F5)
- Cek path di `_header.php` dan `_header_admin.php`

### Session expired terus-menerus
**Solusi:**
- Cek `session_start()` di `config/config.php`
- Pastikan PHP session tidak terdisable
- Clear browser cookies

### Error 404 Not Found
**Solusi:**
- Pastikan akses menggunakan path yang benar:
  - ✅ `http://localhost/tasty_java/public/index.php`
  - ❌ `http://localhost/tasty_java/index.php`
- Cek file ada di folder yang benar

### Upload gambar error "File type not allowed"
**Solusi:**
- Hanya support: JPEG, PNG, GIF
- Max file size: Check `upload_max_filesize` di php.ini
- Ubah format gambar jika perlu

## 🤝 Kontribusi

Kontribusi selalu welcome! Jika ingin berkontribusi:

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### Development Guidelines
- Ikuti PHP PSR-12 coding standard
- Gunakan prepared statements untuk query database
- Escape semua output dengan `htmlspecialchars()`
- Tambahkan comment untuk code yang kompleks
- Test semua fitur sebelum commit

## 📄 Lisensi

Project ini menggunakan MIT License. Lihat file `LICENSE` untuk detail lebih lanjut.

## 👨‍💻 Developer

**Pretty Cool Flacko**
- GitHub: [@prettycoolflacko](https://github.com/prettycoolflacko)
- Email: admin@tastyjava.com

## 🙏 Acknowledgments

- Tailwind CSS untuk framework CSS yang amazing
- Flaticon untuk icon assets
- Unsplash untuk placeholder images
- Community PHP Indonesia

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Buka [Issues](https://github.com/prettycoolflacko/TastyJava/issues) di GitHub
2. Email ke: admin@tastyjava.com
3. Baca dokumentasi di README ini

---

**Selamat menggunakan Tasty Java! Happy Coding! 🚀**

*Last Updated: October 28, 2025*
