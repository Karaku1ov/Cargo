<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$message_id = $_GET['id'] ?? null;
if (!$message_id) {
    header('Location: messages.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $stmt = $pdo->prepare("UPDATE messages SET message = ? WHERE id = ?");
        $stmt->execute([$message, $message_id]);
        header('Location: messages.php');
        exit;
    }
}

$stmt = $pdo->prepare("SELECT messages.message, users.email FROM messages JOIN users ON messages.user_id = users.id WHERE messages.id = ?");
$stmt->execute([$message_id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$message) {
    header('Location: messages.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать сообщение - Админ-панель</title>
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">Пользователи</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="messages.php">Сообщения</a>
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

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Редактировать сообщение</h1>
                </div>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email">Пользователь</label>
                        <input type="text" class="form-control" id="email" value="<?php echo htmlspecialchars($message['email']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="message">Сообщение</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required><?php echo htmlspecialchars($message['message']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a href="messages.php" class="btn btn-secondary">Отмена</a>
                </form>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>