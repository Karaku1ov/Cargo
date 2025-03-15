<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']); // Заменили country на address
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($address) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Пожалуйста, заполните все поля.";
        header("Location: register.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Пароли не совпадают.";
        header("Location: register.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Проверяем, есть ли уже такой email в таблице clients
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM clients WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $_SESSION['error'] = "Email уже занят.";
        header("Location: register.php");
        exit();
    }

    // Вставляем нового клиента в таблицу clients
    $stmt = $pdo->prepare("INSERT INTO clients (first_name, last_name, email, address, password) VALUES (?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$first_name, $last_name, $email, $address, $hashed_password]);
        $_SESSION['success'] = "Регистрация прошла успешно. Пожалуйста, войдите.";
        header("Location: auth.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Ошибка: " . $e->getMessage();
        header("Location: register.php");
        exit();
    }
}
?>
