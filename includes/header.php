<?php
if (!isset($conn)) {
    require_once 'config.php';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кофейный магазин</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-logo">
                    <a href="index.php">
                        <img src="assets/images/logo.png" alt="Coffee Shop" class="logo">
                        <span>Coffee House</span>
                    </a>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="shop.php">Магазин</a></li>
                    <li><a href="about.php">О нас</a></li>
                </ul>
                <div class="nav-auth">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="cart.php" class="cart-link">
                            <span class="cart-icon">🛒</span>
                            <span class="cart-count">0</span>
                        </a>
                        <span class="user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <a href="logout.php" class="auth-link">Выйти</a>
                    <?php else: ?>
                        <a href="login.php" class="auth-link">Войти</a>
                        <a href="register.php" class="auth-link register">Регистрация</a>
                    <?php endif; ?>
                </div>
                <div class="nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>
    <main>