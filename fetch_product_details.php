<?php
// fetch_product_details.php

// Database connection (use your own database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from the GET request
$product_id = $_GET['product_id'];

// Fetch product details from the database
$sql = "SELECT product_name, product_image, price FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the product exists
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    // Return product details as JSON
    echo json_encode($product);
} else {
    echo json_encode(["error" => "Product not found"]);
}

// Close the connection
$conn->close();
?>
