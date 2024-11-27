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

    // Check if product image was uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        // Process the image upload
        $image = file_get_contents($_FILES['product_image']['tmp_name']);
    } else {
        // If no new image, keep the existing image (fetch from the database)
        $sql = "SELECT product_image FROM products WHERE product_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $productId);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($image);
            $stmt->fetch();
        }
    }

    // Prepare SQL to update the product
    $sql = "UPDATE products SET product_name = ?, description = ?, price = ?, stock_quantity = ?, best_before = ?, product_image = ? WHERE product_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters and execute
        $stmt->bind_param("ssdisss", $productName, $description, $price, $stockQuantity, $bestBefore, $image, $productId);

        if ($stmt->execute()) {
            echo 'Product updated successfully.';
            header("Location: Seller_index.php"); // Redirect to the seller's product page
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
?>
