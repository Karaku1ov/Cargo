<?php
session_start();
session_destroy();

if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600, '/');
}

$redirect = isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'admin/login.php' : 'auth.php';
header("Location: $redirect");
exit();
?>