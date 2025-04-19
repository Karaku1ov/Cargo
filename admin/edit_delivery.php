<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$request = null;
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM requests WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$request) {
        header('Location: delivery_requests.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];
    $collection_zip = $_POST['collection_zip'];
    $collection_city = $_POST['collection_city'];
    $collection_country = $_POST['collection_country'];
    $delivery_zip = $_POST['delivery_zip'];
    $delivery_city = $_POST['delivery_city'];
    $delivery_country = $_POST['delivery_country'];
    $delivery_method = $_POST['delivery_method'];
    $status = $_POST['status'];
    $created_at = $_POST['created_at'];

    // Отладочный вывод
    echo "Старый статус: " . htmlspecialchars($request['status']) . "<br>";
    echo "Новый статус: " . htmlspecialchars($status) . "<br>";

    // Обновление данных в базе данных
    $stmt = $pdo->prepare("UPDATE requests SET name = ?, email = ?, phone = ?, company = ?, collection_zip = ?, collection_city = ?, collection_country = ?, delivery_zip = ?, delivery_city = ?, delivery_country = ?, delivery_method = ?, status = ?, created_at = ? WHERE id = ?");
    $success = $stmt->execute([$name, $email, $phone, $company, $collection_zip, $collection_city, $collection_country, $delivery_zip, $delivery_city, $delivery_country, $delivery_method, $status, $created_at, $id]);

    if ($success) {
        echo "Запрос успешно обновлен.<br>";
        
        // Проверим, что статус обновился в базе данных
        $stmt = $pdo->prepare("SELECT status FROM requests WHERE id = ?");
        $stmt->execute([$id]);
        $new_status = $stmt->fetchColumn();
        
        if ($new_status === $status) {
            echo "Статус в базе данных успешно обновлен: " . htmlspecialchars($new_status) . "<br>";
        } else {
            echo "Статус не обновился, текущий статус: " . htmlspecialchars($new_status) . "<br>";
        }
    } else {
        echo "Ошибка при обновлении запроса.<br>";
    }

    header('Location: delivery_requests.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать заявку #<?= isset($request['id']) ? $request['id'] : 'Неизвестно' ?> — 4Mans Cargo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Редактировать заявку #<?= isset($request['id']) ? $request['id'] : 'Неизвестно' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($request['id']) ?>">
        
        <div class="form-group">
            <label>Имя клиента</label>
            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($request['name'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($request['email'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Телефон</label>
            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($request['phone'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Компания</label>
            <input type="text" class="form-control" name="company" value="<?= htmlspecialchars($request['company'] ?? '') ?>">
        </div>
        
        <div class="form-group">
            <label>Индекс забора</label>
            <input type="text" class="form-control" name="collection_zip" value="<?= htmlspecialchars($request['collection_zip'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Город забора</label>
            <input type="text" class="form-control" name="collection_city" value="<?= htmlspecialchars($request['collection_city'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Страна забора</label>
            <input type="text" class="form-control" name="collection_country" value="<?= htmlspecialchars($request['collection_country'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Индекс доставки</label>
            <input type="text" class="form-control" name="delivery_zip" value="<?= htmlspecialchars($request['delivery_zip'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Город доставки</label>
            <input type="text" class="form-control" name="delivery_city" value="<?= htmlspecialchars($request['delivery_city'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Страна доставки</label>
            <input type="text" class="form-control" name="delivery_country" value="<?= htmlspecialchars($request['delivery_country'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Метод транспортировки</label>
            <select class="form-control" name="delivery_method" required>
                <option value="car" <?= ($request['delivery_method'] ?? '') === 'car' ? 'selected' : '' ?>>Автомобиль</option>
                <option value="railway" <?= ($request['delivery_method'] ?? '') === 'railway' ? 'selected' : '' ?>>Железная дорога</option>
                <option value="sea" <?= ($request['delivery_method'] ?? '') === 'sea' ? 'selected' : '' ?>>Море</option>
                <option value="air" <?= ($request['delivery_method'] ?? '') === 'air' ? 'selected' : '' ?>>Воздух</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Статус</label>
            <select class="form-control" name="status" required>
                <option value="Новая" <?= ($request['status'] ?? '') === 'Новая' ? 'selected' : '' ?>>Новая</option>
                <option value="В обработке" <?= ($request['status'] ?? '') === 'В обработке' ? 'selected' : '' ?>>В обработке</option>
                <option value="Завершена" <?= ($request['status'] ?? '') === 'Завершена' ? 'selected' : '' ?>>Завершена</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Дата создания</label>
            <input type="datetime-local" class="form-control" name="created_at" 
                   value="<?= isset($request['created_at']) && $request['created_at'] ? date('Y-m-d\TH:i', strtotime($request['created_at'])) : '' ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="delivery_requests.php" class="btn btn-secondary">Отмена</a>
    </form>
</div>
</body>
</html>
