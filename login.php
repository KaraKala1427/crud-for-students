<?php
include 'mysql_database.php';
session_start();

$message = '';

if (isset($_POST['login']) === true) {
    $name = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password']) === true) {
            $_SESSION['username'] = $name;
            // print_r($_SESSION);
            header("Location: index.php");
            exit();
        } else {
            $message = "Қате пароль.";
        }
    } else {
        $message = "Қолданушы табылмады.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <style>
        .form-container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background-color: #FFCA6E;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="password"] {
            width: 80%;
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
            background-color: #28a745;
            color: #fff;
            width: 100%;
        }
        .btn:hover {
            background-color: #218838;
        }
        p {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="login.php" method="POST">
            <h2>Вход</h2>
            <input type="text" name="username" placeholder="Логин енгізіңіз" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="login" class="btn">Кіру</button>
            <a href='/register.php'> Аккаунт ашу </a>
        </form>
        <p><?php echo $message; ?></p>
    </div>
</body>
</html>
