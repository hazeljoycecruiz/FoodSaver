<?php
session_start();

// Get the cart item ID and new quantity from the request
$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'];
$quantity = $data['quantity'];

// Update the session cart if the product exists
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] = $quantity;

    // Recalculate the total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    echo json_encode(['success' => true, 'newTotal' => $total]);
} else {
    echo json_encode(['success' => false, 'message' => 'Product not found in cart.']);
}
?>
