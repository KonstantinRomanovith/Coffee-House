<?php
require_once 'includes/config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Добавление в корзину
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    
    if ($_POST['action'] == 'add') {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        
        // Проверяем, есть ли уже товар в корзине
        $check_query = "SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $cart_item = mysqli_fetch_assoc($check_result);
            $new_quantity = $cart_item['quantity'] + $quantity;
            $update_query = "UPDATE cart SET quantity = $new_quantity WHERE id = {$cart_item['id']}";
            mysqli_query($conn, $update_query);
        } else {
            $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
            mysqli_query($conn, $insert_query);
        }
    } elseif ($_POST['action'] == 'remove') {
        $cart_id = (int)$_POST['cart_id'];
        $delete_query = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id";
        mysqli_query($conn, $delete_query);
    } elseif ($_POST['action'] == 'update') {
        $cart_id = (int)$_POST['cart_id'];
        $quantity = (int)$_POST['quantity'];
        $update_query = "UPDATE cart SET quantity = $quantity WHERE id = $cart_id AND user_id = $user_id";
        mysqli_query($conn, $update_query);
    }
}

// Получение корзины
$cart_query = "SELECT c.*, p.name, p.price, p.image, p.stock 
               FROM cart c 
               JOIN products p ON c.product_id = p.id 
               WHERE c.user_id = {$_SESSION['user_id']}";
$cart_result = mysqli_query($conn, $cart_query);

include 'includes/header.php';
?>

<div class="cart-container">
    <h1>Корзина</h1>
    
    <?php if (mysqli_num_rows($cart_result) > 0): ?>
    <div class="cart-items">
        <?php 
        $total = 0;
        while ($item = mysqli_fetch_assoc($cart_result)): 
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        ?>
        <div class="cart-item">
            <img src="assets/images/products/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="cart-item-image">
            <div class="cart-item-info">
                <h3><?php echo $item['name']; ?></h3>
                <p class="cart-item-price"><?php echo number_format($item['price'], 0, '', ' '); ?> ₽</p>
            </div>
            <div class="cart-item-quantity">
                <button class="quantity-btn minus" data-cart-id="<?php echo $item['id']; ?>">-</button>
                <input type="number" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>" class="cart-quantity-input" data-cart-id="<?php echo $item['id']; ?>">
                <button class="quantity-btn plus" data-cart-id="<?php echo $item['id']; ?>">+</button>
            </div>
            <div class="cart-item-subtotal">
                <?php echo number_format($subtotal, 0, '', ' '); ?> ₽
            </div>
            <form method="POST" class="cart-item-remove">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                <button type="submit" class="remove-btn">×</button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>
    
    <div class="cart-summary">
        <h3>Итого</h3>
        <div class="cart-total">
            <span>Общая сумма:</span>
            <span class="total-amount"><?php echo number_format($total, 0, '', ' '); ?> ₽</span>
        </div>
        <button class="btn btn-full checkout-btn">Оформить заказ</button>
    </div>
    <?php else: ?>
    <div class="cart-empty">
        <p>Ваша корзина пуста</p>
        <a href="shop.php" class="btn">Перейти в магазин</a>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>