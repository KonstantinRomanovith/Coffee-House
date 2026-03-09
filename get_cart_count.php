<?php
require_once 'includes/config.php';

header('Content-Type: application/json');

if (isLoggedIn()) {
    $user_id = (int)$_SESSION['user_id'];
    $query = "SELECT COALESCE(SUM(quantity), 0) as count FROM cart WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode(['count' => (int)$data['count']]);
    } else {
        echo json_encode(['count' => 0]);
    }
} else {
    echo json_encode(['count' => 0]);
}
?>