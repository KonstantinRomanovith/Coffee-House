<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Настройки базы данных
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'coffee_shop');

// Подключение к базе данных
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Установка кодировки
mysqli_set_charset($conn, "utf8mb4");

// Функция для проверки авторизации
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Функция для получения информации о пользователе
function getUserInfo($user_id) {
    global $conn;
    $user_id = (int)$user_id;
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}
?>