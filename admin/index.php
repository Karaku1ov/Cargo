<?php
session_start();
require_once '../db.php';

// Проверка авторизации и роли
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Получение статистики
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_messages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$total_requests = $pdo->query("SELECT COUNT(*) FROM requests")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель — 4Mans Cargo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #333;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Боковое меню -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Пользователи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="messages.php">Сообщения</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="delivery_requests.php">Запросы на доставку</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Вернуться на сайт</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Выход</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Основная область -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Добро пожаловать в админ-панель</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="logout.php" class="btn btn-sm btn-outline-danger">Выйти</a>
                </div>
            </div>

            <!-- Панель статистики -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Всего пользователей</h5>
                            <p class="card-text"><?php echo htmlspecialchars($total_users); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Всего сообщений</h5>
                            <p class="card-text"><?php echo htmlspecialchars($total_messages); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Запросов на доставку</h5>
                            <p class="card-text"><?php echo htmlspecialchars($total_requests); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Краткий список последних сообщений -->
            <h3 class="mt-4">Последние сообщения</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Пользователь</th>
                        <th>Сообщение</th>
                        <th>Дата</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("
                        SELECT messages.id, users.email, messages.message, messages.created_at 
                        FROM messages 
                        JOIN users ON messages.user_id = users.id 
                        ORDER BY messages.created_at DESC 
                        LIMIT 5
                    ");
                    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($messages as $message):
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['id']); ?></td>
                        <td><?php echo htmlspecialchars($message['email']); ?></td>
                        <td><?php echo htmlspecialchars($message['message']); ?></td>
                        <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                        <td>
                            <a href="edit_message.php?id=<?php echo $message['id']; ?>" class="btn btn-sm btn-primary">Редактировать</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
