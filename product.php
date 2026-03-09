<?php
require_once 'includes/config.php';
include 'includes/header.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT p.*, c.name as category_name FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header('Location: shop.php');
    exit;
}

$characteristics = json_decode($product['characteristics'], true);
?>

<div class="product-detail">
    <div class="product-detail-container">
        <div class="product-gallery">
            <div class="main-image">
                <img src="assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
        </div>
        
        <div class="product-info">
            <h1><?php echo $product['name']; ?></h1>
            <p class="product-category">Категория: <?php echo $product['category_name']; ?></p>
            
            <div class="product-price-section">
                <span class="product-price-large"><?php echo number_format($product['price'], 0, '', ' '); ?> ₽</span>
                <span class="product-stock <?php echo $product['stock'] > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                    <?php echo $product['stock'] > 0 ? 'В наличии: ' . $product['stock'] . ' шт.' : 'Нет в наличии'; ?>
                </span>
            </div>
            
            <div class="product-description-full">
                <h3>Описание</h3>
                <p><?php echo $product['full_description']; ?></p>
            </div>
            
            <?php if (!empty($characteristics)): ?>
            <div class="product-characteristics">
                <h3>Характеристики</h3>
                <table class="characteristics-table">
                    <?php foreach ($characteristics as $key => $value): ?>
                    <tr>
                        <td><?php echo $key; ?>:</td>
                        <td><?php echo $value; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
            
            <?php if (isLoggedIn() && $product['stock'] > 0): ?>
            <div class="product-actions">
                <div class="quantity-selector">
                    <button class="quantity-btn minus">-</button>
                    <input type="number" value="1" min="1" max="<?php echo $product['stock']; ?>" class="quantity-input">
                    <button class="quantity-btn plus">+</button>
                </div>
                <button class="btn add-to-cart-large" data-product-id="<?php echo $product['id']; ?>">Добавить в корзину</button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>