<?php
session_start();
include 'database/db_connection.php'; // Include your database connection

header('Content-Type: application/json');

// Decode JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['product_id'])) {
    $productId = intval($input['product_id']);
    
    // Query to fetch product details
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Store product in cart (session or database)
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = [];
        }

        $_SESSION['products'][] = $product;

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid product']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Product ID not provided']);
}
?>
