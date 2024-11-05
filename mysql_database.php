<?php

// Параметры подключения
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "docker_academy";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
