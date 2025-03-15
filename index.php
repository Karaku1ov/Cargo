<?php
session_start();
require 'db.php';

// Получаем отзывы из БД
try {
    $sql = "SELECT messages.message, messages.created_at, users.email 
            FROM messages 
            JOIN users ON messages.user_id = users.id 
            ORDER BY messages.created_at DESC";
    $stmt = $pdo->query($sql);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка выполнения запроса: " . $e->getMessage());
}

require "blocks/header.php"; 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <style>
        body {
            background: url('img/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4Mans Cargo - Карго-доставка</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Hero section -->
    <div class="hero text-center py-5" style="background: #e9ecef;">
        <h1>Быстрая и надежная карго-доставка</h1>
        <p class="lead">Доставляем товары из Китая, Европы, США и других стран</p>
        <a href="register.php" class="btn btn-custom">Оставить заявку</a>
    </div>

    <!-- About section -->
    <div class="container my-5">
        <section id="about">
            <h2>О нас</h2>
            <p>Компания 4Mans Cargo занимается международной карго-доставкой грузов, обеспечивая надежность, скорость и выгодные тарифы. Мы работаем с различными странами и предлагаем полный комплекс логистических услуг.</p>
        </section>
    </div>

    <!-- Delivery Methods (подключение блока) -->
    <?php require "blocks/delivery_methods.php"; ?>

    <!-- Services section -->
    <div class="container my-5">
        <h1 class="text-center mb-4">Наши услуги</h1>
        <div class="row">
            <?php foreach ($services as $id => $service): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($service['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($service['title']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($service['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($service['desc']) ?></p>
                            <button type="button" class="w-100 btn btn-lg btn-outline-primary" onclick="window.location.href='details.php?service=<?= urlencode($id) ?>'">Подробнее</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Contact section -->
    <section id="contact" class="container my-5">
        <h2>Свяжитесь с нами</h2>
        <form action="send_message.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Ваш Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Сообщение:</label>
                <textarea name="message" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-custom">Отправить</button>
        </form>
    </section>

    <!-- Reviews section -->
    <section class="container my-5">
        <h2>Отзывы клиентов</h2>
        <?php if (count($messages) > 0): ?>
            <?php foreach ($messages as $msg): ?>
                <div class="alert alert-secondary">
                    <strong><?= htmlspecialchars($msg['email']) ?>:</strong> 
                    <?= htmlspecialchars($msg['message']) ?> 
                    <em>(<?= htmlspecialchars($msg['created_at']) ?>)</em>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Пока нет отзывов. Будьте первым!</p>
        <?php endif; ?>
    </section>

    <?php require "blocks/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>