<?php
require_once '../config/config.php';

session_unset();
session_destroy();
header("Location: /tasty_java/public/index.php");
exit();
?>




