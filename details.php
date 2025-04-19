<?php
session_start();
include 'blocks/header.php';
include 'blocks/functions.php';

$serviceId = $_GET['service'] ?? null;
if (!$serviceId) {
    echo "Услуга не указана!";
    exit;
}

$service = getServiceById($serviceId);
if (!$service) {
    echo "Услуга не найдена!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детали услуги - 4Mans Cargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('img/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1><?= htmlspecialchars($service['title']) ?></h1>
        <p><?= htmlspecialchars($service['desc']) ?></p>
        <p><strong>Цена:</strong> <?= htmlspecialchars($service['price']) ?></p>
        <img src="<?= htmlspecialchars($service['img']) ?>" alt="<?= htmlspecialchars($service['title']) ?>" class="img-fluid">
        <br><br>
        <a href="index.php" class="btn btn-primary">Вернуться на главную</a>
    </div>

    <?php require 'blocks/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>