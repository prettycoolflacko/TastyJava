<?php
// app/functions.php
if (!function_exists('e')) {
  function e($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
}

if (!function_exists('slugify')) {
  function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text ?: 'n-a';
  }
}

// Generate CSRF token dan simpan di session
if (!function_exists('csrf_token')) {
  function csrf_token() {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (empty($_SESSION['_csrf_token'])) {
      $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
  }
}

// Validasi CSRF token dari POST
if (!function_exists('verify_csrf')) {
  function verify_csrf() {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (empty($_POST['_csrf_token']) || empty($_SESSION['_csrf_token'])) {
      return false;
    }
    return hash_equals($_SESSION['_csrf_token'], $_POST['_csrf_token']);
  }
}

// Redirect dengan pesan
if (!function_exists('redirect')) {
  function redirect($url, $message = null, $type = 'info') {
    if ($message) {
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
      $_SESSION['flash_message'] = $message;
      $_SESSION['flash_type'] = $type; // 'success', 'error', 'warning', 'info'
    }
    header("Location: " . $url);
    exit();
  }
}

// Tampilkan flash message
if (!function_exists('flash_message')) {
  function flash_message() {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (isset($_SESSION['flash_message'])) {
      $message = $_SESSION['flash_message'];
      $type = $_SESSION['flash_type'] ?? 'info';
      
      // Hapus dari session
      unset($_SESSION['flash_message']);
      unset($_SESSION['flash_type']);
      
      // Color mapping
      $colors = [
        'success' => 'bg-green-100 text-green-800 border-green-300',
        'error' => 'bg-red-100 text-red-800 border-red-300',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
        'info' => 'bg-blue-100 text-blue-800 border-blue-300'
      ];
      
      $color = $colors[$type] ?? $colors['info'];
      
      echo '<div class="mb-4 p-4 rounded-lg border ' . $color . '">' . e($message) . '</div>';
    }
  }
}

// Format tanggal Indonesia
if (!function_exists('format_date')) {
  function format_date($date, $format = 'd M Y') {
    if (empty($date)) return '-';
    $timestamp = is_numeric($date) ? $date : strtotime($date);
    return date($format, $timestamp);
  }
}

// Format tanggal relative (contoh: "2 jam yang lalu")
if (!function_exists('time_ago')) {
  function time_ago($datetime) {
    $timestamp = is_numeric($datetime) ? $datetime : strtotime($datetime);
    $diff = time() - $timestamp;
    
    if ($diff < 60) return 'Baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit yang lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam yang lalu';
    if ($diff < 604800) return floor($diff / 86400) . ' hari yang lalu';
    if ($diff < 2592000) return floor($diff / 604800) . ' minggu yang lalu';
    if ($diff < 31536000) return floor($diff / 2592000) . ' bulan yang lalu';
    return floor($diff / 31536000) . ' tahun yang lalu';
  }
}

// Potong teks dengan aman
if (!function_exists('excerpt')) {
  function excerpt($text, $length = 150, $suffix = '...') {
    $text = strip_tags($text);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);
    
    if (strlen($text) <= $length) {
      return $text;
    }
    
    return substr($text, 0, $length) . $suffix;
  }
}

// Validasi email
if (!function_exists('is_valid_email')) {
  function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
  }
}

// Validasi password strength
if (!function_exists('is_strong_password')) {
  function is_strong_password($password, $min_length = 8) {
    if (strlen($password) < $min_length) return false;
    
    // Minimal ada huruf dan angka
    $has_letter = preg_match('/[a-zA-Z]/', $password);
    $has_number = preg_match('/[0-9]/', $password);
    
    return $has_letter && $has_number;
  }
}

// Sanitasi input
if (!function_exists('sanitize_input')) {
  function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
  }
}

// Upload gambar dengan validasi
if (!function_exists('upload_image')) {
  function upload_image($file, $upload_dir = 'public/uploads/', $allowed_types = ['image/jpeg', 'image/png', 'image/gif'], $max_size = 5242880) {
    // $max_size default = 5MB
    
    if (!isset($file) || $file['error'] !== 0) {
      return ['success' => false, 'error' => 'Tidak ada file yang diupload'];
    }
    
    // Validasi tipe file
    if (!in_array($file['type'], $allowed_types)) {
      return ['success' => false, 'error' => 'Tipe file tidak diizinkan. Hanya JPG, PNG, dan GIF'];
    }
    
    // Validasi ukuran file
    if ($file['size'] > $max_size) {
      $max_mb = $max_size / 1048576;
      return ['success' => false, 'error' => 'Ukuran file terlalu besar. Maksimal ' . $max_mb . 'MB'];
    }
    
    // Buat nama file unik
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = uniqid('img_') . '_' . time() . '.' . $extension;
    
    // Path absolut dan relatif
    $absolute_path = __DIR__ . '/../' . $upload_dir . $file_name;
    $db_path = $upload_dir . $file_name;
    
    // Buat direktori jika belum ada
    if (!file_exists(dirname($absolute_path))) {
      mkdir(dirname($absolute_path), 0755, true);
    }
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $absolute_path)) {
      return ['success' => true, 'path' => $db_path, 'filename' => $file_name];
    }
    
    return ['success' => false, 'error' => 'Gagal mengupload file'];
  }
}

// Hapus file gambar
if (!function_exists('delete_image')) {
  function delete_image($path) {
    if (empty($path)) return false;
    
    $absolute_path = __DIR__ . '/../' . $path;
    
    if (file_exists($absolute_path)) {
      return unlink($absolute_path);
    }
    
    return false;
  }
}

// Cek apakah user sudah login
if (!function_exists('is_logged_in')) {
  function is_logged_in() {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
  }
}

// Cek role user
if (!function_exists('has_role')) {
  function has_role($role) {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
  }
}

// Get current user ID
if (!function_exists('current_user_id')) {
  function current_user_id() {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    return $_SESSION['user_id'] ?? null;
  }
}

// Get current user name
if (!function_exists('current_user_name')) {
  function current_user_name() {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    return $_SESSION['user_name'] ?? 'Guest';
  }
}

// Pagination helper
if (!function_exists('paginate')) {
  function paginate($total_items, $items_per_page = 10, $current_page = 1) {
    $total_pages = ceil($total_items / $items_per_page);
    $current_page = max(1, min($current_page, $total_pages));
    $offset = ($current_page - 1) * $items_per_page;
    
    return [
      'total_items' => $total_items,
      'items_per_page' => $items_per_page,
      'total_pages' => $total_pages,
      'current_page' => $current_page,
      'offset' => $offset,
      'has_prev' => $current_page > 1,
      'has_next' => $current_page < $total_pages
    ];
  }
}

// Generate URL dengan query string
if (!function_exists('url_with_query')) {
  function url_with_query($base_url, $params = []) {
    if (empty($params)) return $base_url;
    
    $query = http_build_query($params);
    $separator = strpos($base_url, '?') !== false ? '&' : '?';
    
    return $base_url . $separator . $query;
  }
}



