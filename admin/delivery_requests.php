<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM requests");

$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Запросы на доставку — 4Mans Cargo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Запросы на доставку</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя клиента</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Компания</th>
                <th>Индекс забора</th>
                <th>Город забора</th>
                <th>Страна забора</th>
                <th>Индекс доставки</th>
                <th>Город доставки</th>
                <th>Страна доставки</th>
                <th>Метод транспортировки</th>
                <th>Статус</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $req): ?>
                <tr>
                    <td><?= htmlspecialchars($req['id']) ?></td>
                    <td><?= htmlspecialchars($req['name']) ?></td>
                    <td><?= htmlspecialchars($req['email']) ?></td>
                    <td><?= htmlspecialchars($req['phone']) ?></td>
                    <td><?= htmlspecialchars($req['company']) ?></td>
                    <td><?= htmlspecialchars($req['collection_zip']) ?></td>
                    <td><?= htmlspecialchars($req['collection_city']) ?></td>
                    <td><?= htmlspecialchars($req['collection_country']) ?></td>
                    <td><?= htmlspecialchars($req['delivery_zip']) ?></td>
                    <td><?= htmlspecialchars($req['delivery_city']) ?></td>
                    <td><?= htmlspecialchars($req['delivery_country']) ?></td>
                    <td>
                        <?php
                        $delivery_method = $req['delivery_method'];
                        if ($delivery_method === 'car') echo 'Автомобиль';
                        elseif ($delivery_method === 'railway') echo 'Железная дорога';
                        elseif ($delivery_method === 'sea') echo 'Море';
                        elseif ($delivery_method === 'air') echo 'Воздух';
                        else echo htmlspecialchars($delivery_method);
                        ?>
                    </td>
                    <td>
                        <?php
                        $status = $req['status'] ?? 'Не указано';
                        if ($status === 'Новая') {
                            echo 'Ожидает';
                        } elseif ($status === 'В обработке') {
                            echo 'В обработке';
                        } elseif ($status === 'Завершена') {
                            echo 'Завершена';
                        } else {
                            echo htmlspecialchars($status);
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($req['created_at']) ?></td>
                    <td>
                        <a href="edit_delivery.php?id=<?= $req['id'] ?>" class="btn btn-sm btn-primary">Редактировать</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
</body>
</html>