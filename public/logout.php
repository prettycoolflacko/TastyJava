<?php
// Selalu mulai dengan config.php untuk mengakses session
require_once '../config/config.php';

// Hancurkan semua data session
session_unset();
session_destroy();

// Arahkan kembali ke halaman utama
header("Location: /tasty_java/public/index.php");
exit();
?>




