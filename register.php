<?php
include 'mysql_database.php';

$message = '';

if(isset($_POST['register']) === true) {
    $name     = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (strlen($_POST['password']) < 6 ) {
        $message = "Кемінде 6 символдан тұру керек";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);
    
            if ($stmt->execute()) {
                $message = "Регистрация прошла успешно. Перейдите на страницу <a href='/login.php'>входа</a>.";
            }
        } catch (mysqli_sql_exception $e) {
            // Проверка кода ошибки на дублирующий email
            if ($e->getCode() == 1062) {
                $message = "Ошибка: Пользователь с таким email или логином уже существует.";
            } else {
                $message = "Ошибка: " . $e->getMessage();
            }
        }
    }

}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        /* CSS для формы */
        .form-container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f0f8ff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            width: 100%;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="register.php" method="POST">
            <h2>Регистрация</h2>
            <input type="text" name="username" placeholder="Логин енгізіңіз" required>
            <input type="email" name="email" placeholder="Поштаныз" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="register" class="btn">Зарегистрироваться</button>
            <a href='/login.php'> Логин </a>
        </form>
        <p><?php echo $message; ?></p>
    </div>
</body>
</html>
