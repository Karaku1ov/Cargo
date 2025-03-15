<?php
$passwords = ['password123', 'pass456', 'pass789'];
foreach ($passwords as $password) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    echo "Пароль: $password -> Хеш: $hashed\n";
}
?>