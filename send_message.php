<?php
session_start();
require 'db.php';

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отправка сообщения - 4Mans Cargo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php require 'blocks/header.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-lg p-4 bg-white rounded">
            <h2 class="mb-4 text-center">Отправка сообщения</h2>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST['email'] ?? '';
                $message = $_POST['message'] ?? '';

                if (!empty($email) && !empty($message)) {
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
                    $stmt->execute(['email' => $email]);
                    $user = $stmt->fetch();

                    if ($user) {
                        $user_id = $user['id'];
                        $sql = "INSERT INTO messages (user_id, message, created_at) VALUES (:user_id, :message, NOW())";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(['user_id' => $user_id, 'message' => $message]);

                        echo '<div class="alert alert-success" role="alert">Сообщение успешно отправлено!</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Ошибка: Пользователь с таким email не найден!</div>';
                    }
                } else {
                    echo '<div class="alert alert-warning" role="alert">Ошибка: Заполните все поля!</div>';
                }
            }
            ?>

            <a href="index.php" class="btn btn-primary mt-3">Вернуться на главную</a>
        </div>
    </div>

    <?php require 'blocks/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>