<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth.php');
    exit;
}

$id = $_GET['id'] ?? null;
$user = null;

if ($id) {
    $stmt = $pdo->prepare("SELECT id, name, email, created_at FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (empty($name) || empty($email)) {
        $_SESSION['error'] = "Пожалуйста, заполните все поля.";
        header("Location: edit_user.php?id=$id");
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE clients SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $email, $id]);
        $_SESSION['success'] = "Пользователь успешно обновлён.";
        header('Location: users.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Ошибка: " . $e->getMessage();
        header("Location: edit_user.php?id=$id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование пользователя - 4Mans Cargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require '../blocks/header.php'; ?>

    <div class="container mt-5">
        <h2>Редактирование пользователя</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if ($user): ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        <?php else: ?>
            <p>Пользователь не найден.</p>
        <?php endif; ?>
    </div>

    <?php require '../blocks/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>