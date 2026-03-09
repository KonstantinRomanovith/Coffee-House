<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Получение категорий для фильтра
$categories_query = "SELECT * FROM categories ORDER BY name";
$categories_result = mysqli_query($conn, $categories_query);

// Получение продуктов с фильтрацией
$where = "1=1";
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category_id = (int)$_GET['category'];
    $where .= " AND category_id = $category_id";
}

$products_query = "SELECT * FROM products WHERE $where ORDER BY created_at DESC";
$products_result = mysqli_query($conn, $products_query);
?>

<div class="shop-header">
    <div class="container">
        <h1>Наш магазин</h1>
        <p>Выберите свой идеальный кофе</p>
    </div>
</div>

<div class="shop-container">
    <!-- Сайдбар с категориями -->
    <aside class="shop-sidebar">
        <h3>Категории</h3>
        <ul class="category-filter">
            <li>
                <a href="shop.php" <?php echo !isset($_GET['category']) ? 'class="active"' : ''; ?>>
                    Все категории
                </a>
            </li>
            <?php 
            if ($categories_result && mysqli_num_rows($categories_result) > 0) {
                while ($category = mysqli_fetch_assoc($categories_result)): 
            ?>
            <li>
                <a href="shop.php?category=<?php echo $category['id']; ?>" 
                   <?php echo (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'class="active"' : ''; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
            </li>
            <?php 
                endwhile;
            }
            ?>
        </ul>
        
        <h3>Режим просмотра</h3>
        <div class="view-toggle">
            <button class="view-btn active" data-view="grid">Сетка</button>
            <button class="view-btn" data-view="table">Таблица</button>
        </div>
    </aside>
    
    <!-- Основной контент -->
    <div class="shop-content">
        <?php if ($products_result && mysqli_num_rows($products_result) > 0): ?>
            
            <!-- Сетка товаров -->
            <div class="products-grid active" id="grid-view">
                <?php 
                mysqli_data_seek($products_result, 0);
                while ($product = mysqli_fetch_assoc($products_result)): 
                ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="product-overlay">
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="view-details">Подробнее</a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="product-footer">
                            <span class="product-price"><?php echo number_format($product['price'], 0, '', ' '); ?> ₽</span>
                            <?php if (isLoggedIn()): ?>
                            <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">В корзину</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            
            <!-- Таблица товаров -->
            <div class="products-table" id="table-view">
                <table>
                    <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Цена</th>
                            <?php if (isLoggedIn()): ?>
                            <th>Действие</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        mysqli_data_seek($products_result, 0);
                        while ($product = mysqli_fetch_assoc($products_result)): 
                        ?>
                        <tr>
                            <td>
                                <img src="assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     class="table-image">
                            </td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo number_format($product['price'], 0, '', ' '); ?> ₽</td>
                            <?php if (isLoggedIn()): ?>
                            <td>
                                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-small">Детали</a>
                                <button class="btn-small add-to-cart" data-product-id="<?php echo $product['id']; ?>">В корзину</button>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
        <?php else: ?>
            <div class="no-products">
                <p>Товары не найдены</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>