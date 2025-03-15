<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $country = trim($_POST['country']);
    $city = trim($_POST['city']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($country)) {
        $_SESSION['error'] = "Пожалуйста, заполните все обязательные поля.";
        header("Location: profile.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, country = ?, city = ? WHERE id = ?");
        $stmt->execute([$first_name, $last_name, $email, $country, $city, $user_id]);
        $_SESSION['success'] = "Профиль успешно обновлён.";
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Ошибка: " . $e->getMessage();
        header("Location: profile.php");
        exit();
    }
}
?>