<?php
// Include database connection
include('database/db_connection.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if product ID is set
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Delete the product from the database
    $sql = "DELETE FROM products WHERE product_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $productId);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }

        $stmt->close();
    } else {
        echo 'error';
    }
}

$conn->close();
?>
