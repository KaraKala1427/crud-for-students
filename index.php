<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'mysql_database.php';

// Инициализация переменных
$name = '';
$email = '';
$update = false;
$id = 0;

// Обработка добавления новой записи
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $conn->query("INSERT INTO users (name, email) VALUES ('$name', '$email')") or die($conn->error);
    header("Location: index.php");
}

// Обработка удаления записи
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id") or die($conn->error);
    header("Location: index.php");
}

// Обработка редактирования записи
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id") or die($conn->error);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $update = true;
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id") or die($conn->error);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MySQL CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>CRUD бағдарлама PHP және MySQL</h1>

    <div class="logout">
        <a href="/logout.php" class="btn">Шығу</a>
    </div>

    <!-- Форма для добавления и редактирования -->
    <div class="form-container">
        <form action="index.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="name">Имя</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            <?php if ($update): ?>
                <button type="submit" name="update" class="btn btn-primary">Обновить</button>
            <?php else: ?>
                <button type="submit" name="save" class="btn btn-primary">Сохранить</button>
            <?php endif; ?>
        </form>
    </div>

    <!-- Таблица для отображения данных -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Чтение всех записей из базы данных
                $result = $conn->query("SELECT * FROM users") or die($conn->error);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td class="actions">
                        <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Редактировать</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту запись?');">Удалить</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
