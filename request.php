<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $collection_zip = trim($_POST['collection_zip'] ?? '');
    $collection_city = trim($_POST['collection_city'] ?? '');
    $collection_country = trim($_POST['collection_country'] ?? '');
    $delivery_zip = trim($_POST['delivery_zip'] ?? '');
    $delivery_city = trim($_POST['delivery_city'] ?? '');
    $delivery_country = trim($_POST['delivery_country'] ?? '');
    $delivery_method = trim($_POST['delivery_method'] ?? '');
    $transport_details = trim($_POST['transport_details'] ?? '');
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

    // Валидация
    if (empty($name) || empty($email) || empty($phone) || empty($collection_zip) || empty($collection_city) || empty($collection_country) || empty($delivery_zip) || empty($delivery_city) || empty($delivery_country) || empty($delivery_method)) {
        $_SESSION['error'] = 'Пожалуйста, заполните все обязательные поля.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Пожалуйста, введите корректный email.';
    } elseif (!in_array($delivery_method, ['car', 'railway', 'air', 'sea'])) {
        $_SESSION['error'] = 'Пожалуйста, выберите корректный способ доставки.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO requests (user_id, name, email, phone, company, collection_zip, collection_city, collection_country, delivery_zip, delivery_city, delivery_country, delivery_method, transport_details)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $user_id,
                htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($company, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($collection_zip, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($collection_city, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($collection_country, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($delivery_zip, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($delivery_city, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($delivery_country, ENT_QUOTES, 'UTF-8'),
                $delivery_method,
                htmlspecialchars($transport_details, ENT_QUOTES, 'UTF-8')
            ]);
            $_SESSION['success'] = 'Ваш запрос успешно отправлен! Мы свяжемся с вами в ближайшее время.';
            header('Location: request.php');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Ошибка: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваш запрос на транспорт - 4Mans Cargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('img/background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            max-width: 800px;
            margin: 2rem auto;
        }
        .btn-primary {
            background-color: #f28c38;
            border-color: #f28c38;
        }
        .btn-primary:hover {
            background-color: #e07b30;
            border-color: #e07b30;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: none;
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
    <?php require 'blocks/header.php'; ?>

    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center">Ваш запрос на транспорт</h2>
            <p class="text-center text-muted">Получите необязательную оценку сейчас</p>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <form method="POST" id="requestForm" novalidate>
                <h5>Контактные данные</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Имя <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
                        <div class="invalid-feedback">Пожалуйста, введите ваше имя.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="company" class="form-label">Компания</label>
                        <input type="text" class="form-control" id="company" name="company" value="<?= htmlspecialchars($company ?? '') ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Электронная почта <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                        <div class="invalid-feedback">Пожалуйста, введите корректный email.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Телефон для связи <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($phone ?? '') ?>" required>
                        <div class="invalid-feedback">Пожалуйста, введите корректный номер телефона.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="delivery_method" class="form-label">Способ доставки <span class="text-danger">*</span></label>
                    <select class="form-select" id="delivery_method" name="delivery_method" required>
                        <option value="" disabled selected>Выберите способ доставки</option>
                        <option value="car" <?= isset($delivery_method) && $delivery_method === 'car' ? 'selected' : '' ?>>Авто</option>
                        <option value="air" <?= isset($delivery_method) && $delivery_method === 'air' ? 'selected' : '' ?>>Авиа</option>
                        <option value="sea" <?= isset($delivery_method) && $delivery_method === 'sea' ? 'selected' : '' ?>>Морской</option>
                        <option value="railway" <?= isset($delivery_method) && $delivery_method === 'railway' ? 'selected' : '' ?>>Железнодорожный</option>
                    </select>
                    <div class="invalid-feedback">Пожалуйста, выберите способ доставки.</div>
                </div>

                <h5>Информация о доставке</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Коллекция: почтовый индекс, город, страна <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="collection_zip" placeholder="Почтовый индекс" value="<?= htmlspecialchars($collection_zip ?? '') ?>" required>
                                <div class="invalid-feedback">Пожалуйста, укажите почтовый индекс.</div>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="collection_city" placeholder="Город" value="<?= htmlspecialchars($collection_city ?? '') ?>" required>
                                <div class="invalid-feedback">Пожалуйста, укажите город.</div>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="collection_country" placeholder="Страна" value="<?= htmlspecialchars($collection_country ?? '') ?>" required>
                                <div class="invalid-feedback">Пожалуйста, укажите страну.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Доставка: почтовый индекс, город, страна <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="delivery_zip" placeholder="Почтовый индекс" value="<?= htmlspecialchars($delivery_zip ?? '') ?>" required>
                                <div class="invalid-feedback">Пожалуйста, укажите почтовый индекс.</div>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="delivery_city" placeholder="Город" value="<?= htmlspecialchars($delivery_city ?? '') ?>" required>
                                <div class="invalid-feedback">Пожалуйста, укажите город.</div>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="delivery_country" placeholder="Страна" value="<?= htmlspecialchars($delivery_country ?? '') ?>" required>
                                <div class="invalid-feedback">Пожалуйста, укажите страну.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="transport_details" class="form-label">Подробная информация о вашем транспорте (вес, размеры, упаковка и т.д.)</label>
                    <textarea class="form-control" id="transport_details" name="transport_details" rows="3"><?= htmlspecialchars($transport_details ?? '') ?></textarea>
                </div>

                <p class="text-muted small">
                    Более подробную информацию об обработке персональных данных можно найти в нашей <a href="privacy.php">Политике конфиденциальности</a>.
                </p>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Отправить запрос сейчас</button>
                </div>
            </form>
        </div>
    </div>

    <?php require 'blocks/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            'use strict';
            const form = document.getElementById('requestForm');
            form.addEventListener('submit', function (event) {
                let isValid = true;
                const email = form.querySelector('#email');
                const emailValue = email.value.trim();
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const deliveryMethod = form.querySelector('#delivery_method');
                const deliveryMethodValue = deliveryMethod.value;

                // Проверка всех обязательных полей
                form.querySelectorAll('[required]').forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                // Проверка email
                if (emailValue && !emailPattern.test(emailValue)) {
                    email.classList.add('is-invalid');
                    isValid = false;
                } else {
                    email.classList.remove('is-invalid');
                }

                // Проверка способа доставки
                if (!['car', 'railway', 'air', 'sea'].includes(deliveryMethodValue)) {
                    deliveryMethod.classList.add('is-invalid');
                    isValid = false;
                } else {
                    deliveryMethod.classList.remove('is-invalid');
                }

                if (!isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            }, false);
        })();
    </script>
</body>
</html>