<?php
require_once 'database/db_connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Check if the product exists
    $product_query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Product not found']);
        exit();
    }

    // Check if the product is already in the cart
    $cart_check_query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($cart_check_query);
    $stmt->bind_param("ss", $user_id, $product_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    if ($cart_result->num_rows > 0) {
        // Update the quantity
        $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $user_id, $product_id);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Product quantity updated in cart']);
        exit();
    }

    // Insert new product into the cart
    $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ss", $user_id, $product_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product added to cart']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add product to cart']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
