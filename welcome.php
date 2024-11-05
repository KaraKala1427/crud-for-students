<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать</title>
    <style>
        body {
            text-align: center;
            padding: 50px;
            background-color: #f0f8ff;
        }
        .welcome-message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            display: inline-block;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="welcome-message">
        Қош келдіңіз, <?php echo $_SESSION['username']; ?>!
    </div>
    <a href="/logout.php" class="btn">Шығу</a>
</body>
</html>
