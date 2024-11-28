<?php
// Include database connection
include('database/db_connection.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    // Get form data
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stock_quantity'];
    $bestBefore = $_POST['best_before'];

    // Initialize image variable
    $image = null;

    // If a new image is uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded image
        $image = file_get_contents($_FILES['product_image']['tmp_name']);
    } else {
        // Fetch the existing image from the database if no new image is uploaded
        $sql = "SELECT product_image FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $productId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($currentImage);
        $stmt->fetch();
        $image = $currentImage;  // Keep the existing image
    }


    // Prepare SQL to update the product
    $sql = "UPDATE products 
            SET product_name = ?, 
                description = ?, 
                price = ?, 
                stock_quantity = ?, 
                best_before = ?, 
                product_image = ?, 
                updated_at = NOW()
            WHERE product_id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters and execute
        $stmt->bind_param("ssdisss", $productName, $description, $price, $stockQuantity, $bestBefore, $image, $productId);

        if ($stmt->execute()) {
            // Redirect with success notification
            header("Location: Seller_products_uploaded.php?update=success");
            exit();
        } else {
            echo 'Failed to update product.';
        }

        $stmt->close();
    } else {
        echo 'Error in updating product.';
    }
}

// Close the database connection
$conn->close();
