<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>О нас - 4Mans Cargo</title>
    <style>
        body {
            background: url('img/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .navbar {
            background: rgba(0, 0, 0, 0.8);
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .hero {
            text-align: center;
            padding: 100px 20px;
            color: white;
            background: rgba(0, 0, 0, 0.5);
        }
        .btn-custom {
            background: #28a745;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php require "blocks/header.php"; ?>
    <div class="hero">
        <h1>Быстрая и надежная карго-доставка</h1>
        <p>Доставляем товары из Китая, Европы, США и других стран</p>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Левая колонка -->
            <div class="col-md-6">
                <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <h6 class="border-bottom pb-2 mb-0">Почему именно мы?</h6>
                    <div class="d-flex text-body-secondary pt-3">
                        <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <rect width="100%" height="100%" fill="#007bff"></rect>
                        </svg>
                        <p class="pb-3 mb-0 small lh-sm border-bottom">
                            <strong class="d-block text-gray-dark">Оперативность</strong>
                            Оперативность – минимальные сроки доставки благодаря отлаженным маршрутам.
                        </p>
                    </div>
                    <div class="d-flex text-body-secondary pt-3">
                        <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <rect width="100%" height="100%" fill="#e83e8c"></rect>
                        </svg>
                        <p class="pb-3 mb-0 small lh-sm border-bottom">
                            <strong class="d-block text-gray-dark">Гарантия безопасности</strong>
                            Работаем с проверенными перевозчиками и обеспечиваем страхование груза.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Правая колонка -->
            <div class="col-md-6">
                <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <h6 class="border-bottom pb-2 mb-0">Наши предложения</h6>
                    <div class="d-flex text-body-secondary pt-3">
                        <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <rect width="100%" height="100%" fill="#28a745"></rect>
                        </svg>
                        <p class="pb-3 mb-0 small lh-sm border-bottom">
                            <strong class="d-block text-gray-dark">Доступные цены</strong>
                            Мы предлагаем конкурентоспособные тарифы на перевозку.
                        </p>
                    </div>
                    <div class="d-flex text-body-secondary pt-3">
                        <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <rect width="100%" height="100%" fill="#ffc107"></rect>
                        </svg>
                        <p class="pb-3 mb-0 small lh-sm border-bottom">
                            <strong class="d-block text-gray-dark">Индивидуальный подход</strong>
                            Подбираем оптимальный маршрут и условия для каждого клиента.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3>Контактная форма</h3>
        <form action="check.php" method="post">
            <input type="email" name="email" placeholder="Введите ваш email" class="form-control" required><br>
            <textarea name="message" class="form-control" placeholder="Введите ваше сообщение" required></textarea><br>
            <button type="submit" name="send" class="btn btn-success">Отправить</button>
        </form>
    </div>

    <?php require "blocks/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>