<?php
session_start();

$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

$error = '';
if (trim($email) == '') {
    $error = 'Введите ваш email';
} elseif (trim($message) == '') {
    $error = 'Введите ваше сообщение';
} elseif (strlen($message) < 10) {
    $error = 'Сообщение должно быть более 10 символов';
}

if ($error != '') {
    $_SESSION['error'] = $error;
    header('Location: about.php');
    exit;
}

$subject = "=?utf-8?B?" . base64_encode("Сообщение от пользователя сайта 4Mans Cargo") . "?=";
$headers = "From: $email\r\nReply-to: $email\r\nContent-type: text/html; charset=utf-8\r\n";

if (mail('admin@itproger.com', $subject, $message, $headers)) {
    $_SESSION['success'] = "Сообщение успешно отправлено!";
} else {
    $_SESSION['error'] = "Ошибка при отправке сообщения.";
}

header('Location: about.php');
exit;
?>