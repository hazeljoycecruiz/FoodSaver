<?php
// Include your database connection file
include('database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $best_before = $_POST['best_before'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $product_image = $_POST['product_image'];

    // Handle the product image upload (if a new image is uploaded)
    if ($_FILES['productImage']['name']) {
        // Get the uploaded image details
        $productImage = addslashes(file_get_contents($_FILES['productImage']['tmp_name']));
    } else {
        // If no new image is uploaded, use the existing one
        $productImage = $existingImage;
    }

    // Update the product in the database
    $query = "UPDATE products SET 
                product_name = ?, 
                description = ?, 
                price = ?, 
                best_before = ?, 
                stock_quantity = ?, 
                product_image = ?, 
                updated_at = CURRENT_TIMESTAMP 
              WHERE product_id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssdsdss", $productName, $description, $price, $bestBefore, $quantity, $productImage, $productId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect to the products page or display success message
            echo "Product updated successfully!";
        } else {
            echo "No changes made or an error occurred.";
        }

        $stmt->close();
    } else {
        echo "Error in preparing the query.";
    }

    // Close the database connection
    $conn->close();
}
?>
