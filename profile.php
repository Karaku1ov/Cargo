<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT first_name, last_name, email, city, street, house, phone FROM clients WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Ошибка: Пользователь не найден!";
        exit();
    }
} catch (PDOException $e) {
    die("Ошибка: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - 4Mans Cargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('img/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .editable:hover {
            cursor: pointer;
            color: #007bff;
        }
    </style>
</head>
<body>
    <?php require 'blocks/header.php'; ?>

    <div class="container mt-5">
        <div class="text-center">
            <img src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="72" height="57">
            <h2 class="mt-3">Личный кабинет</h2>
            <p class="lead">Здесь вы можете просмотреть и изменить свои данные.</p>
        </div>
        
        <div class="row g-5">
            <!-- Левая колонка (профиль) -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Avatar">
                        <h4><?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></h4>
                        <p class="text-muted"><?= htmlspecialchars($user['email']) ?></p>
                        <button id="editButton" class="btn btn-primary mt-3">Редактировать</button>
                    </div>
                </div>
            </div>
            
            <!-- Правая колонка (форма редактирования) -->
            <div class="col-md-8">
                <h4 class="mb-3">Ваши данные</h4>
                <form id="profileForm" method="POST" action="update_profile.php" style="display: none;">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Фамилия</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>">
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">Город</label>
                            <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="street" class="form-label">Улица</label>
                            <input type="text" class="form-control" id="street" name="street" value="<?= htmlspecialchars($user['street'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="house" class="form-label">Дом</label>
                            <input type="text" class="form-control" id="house" name="house" value="<?= htmlspecialchars($user['house'] ?? '') ?>">
                        </div>
                    </div>
                    <hr class="my-4">
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Сохранить изменения</button>
                </form>
                <div id="viewProfile" class="mt-3">
                    <p><strong>Город:</strong> <?= htmlspecialchars($user['city'] ?? 'Не указан') ?></p>
                    <p><strong>Улица:</strong> <?= htmlspecialchars($user['street'] ?? 'Не указана') ?></p>
                    <p><strong>Дом:</strong> <?= htmlspecialchars($user['house'] ?? 'Не указан') ?></p>
                    <p><strong>Телефон:</strong> <?= htmlspecialchars($user['phone'] ?? 'Не указан') ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php require 'blocks/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            document.getElementById('viewProfile').style.display = 'none';
            document.getElementById('profileForm').style.display = 'block';
        });
    </script>
</body>
</html>
