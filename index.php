<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Получение популярных продуктов для слайд-шоу
$slides_query = "SELECT * FROM products ORDER BY RAND() LIMIT 3";
$slides_result = mysqli_query($conn, $slides_query);
$slides = [];
while ($row = mysqli_fetch_assoc($slides_result)) {
    $slides[] = $row;
}
?>

<div class="hero">
    <div class="slideshow-container">
        <?php foreach ($slides as $index => $slide): ?>
        <div class="slide fade" <?php echo $index === 0 ? 'style="display: block;"' : ''; ?>>
            <img src="assets/images/products/<?php echo $slide['image']; ?>" alt="<?php echo $slide['name']; ?>">
            <div class="slide-text">
                <h2><?php echo $slide['name']; ?></h2>
                <p><?php echo $slide['description']; ?></p>
                <a href="product.php?id=<?php echo $slide['id']; ?>" class="btn">Подробнее</a>
            </div>
        </div>
        <?php endforeach; ?>
        
        <a class="prev" onclick="changeSlide(-1)">❮</a>
        <a class="next" onclick="changeSlide(1)">❯</a>
        
        <div class="dots-container">
            <?php for ($i = 0; $i < count($slides); $i++): ?>
            <span class="dot" onclick="currentSlide(<?php echo $i + 1; ?>)"></span>
            <?php endfor; ?>
        </div>
    </div>
</div>

<section class="features">
    <h2 class="section-title">Почему выбирают нас</h2>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🌱</div>
            <h3>Свежая обжарка</h3>
            <p>Мы обжариваем кофе только после заказа</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🚚</div>
            <h3>Бесплатная доставка</h3>
            <p>При заказе от 1500 рублей</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⭐</div>
            <h3>Только лучшие сорта</h3>
            <p>Отбираем зерна высшего качества</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">💝</div>
            <h3>Подарочная упаковка</h3>
            <p>Упакуем красиво для любого повода</p>
        </div>
    </div>
</section>

<section class="categories">
    <h2 class="section-title">Наши категории</h2>
    <div class="categories-grid">
        <?php
        $categories_query = "SELECT * FROM categories";
        $categories_result = mysqli_query($conn, $categories_query);
        while ($category = mysqli_fetch_assoc($categories_result)):
        ?>
        <div class="category-card">
            <h3><?php echo $category['name']; ?></h3>
            <p><?php echo $category['description']; ?></p>
            <a href="shop.php?category=<?php echo $category['id']; ?>" class="btn-secondary">Смотреть</a>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<section class="about-shop">
    <div class="about-content">
        <h2>О нашем магазине</h2>
        <p>Мы - команда настоящих кофейных энтузиастов. Наша миссия - приносить радость людям через вкусный и качественный кофе. Мы напрямую сотрудничаем с фермерами из разных стран мира, чтобы предложить вам самый свежий и вкусный кофе.</p>
        <p>Каждую партию мы тщательно тестируем и обжариваем с любовью к своему делу. В нашем ассортименте вы найдете как классические сорта, так и уникальные миксы от лучших обжарщиков.</p>
        <a href="about.php" class="btn">Узнать больше</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>