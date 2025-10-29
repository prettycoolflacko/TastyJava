<?php
require_once __DIR__ . '/../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /tasty_java/public/login.php?error=Anda harus login");
    exit();
}

if ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'editor') {
    header("Location: /tasty_java/public/index.php?error=Akses ditolak");
    exit();
}

?>





