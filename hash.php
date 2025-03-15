<?php
$hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
echo "Хеш пароля: " . $hashed_password;
?>
// Compare this snippet from auth_process.php: