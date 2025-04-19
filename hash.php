<?php
$password = 'adminpass456'; // Пароль для нового админа
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Хешированный пароль: $hashed_password\n";
?>