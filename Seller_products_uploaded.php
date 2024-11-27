<?php
// Database connection
include('database/db_connection.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>FoodSaver - Seller's Products</title>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container py-4">
        <!-- Back Button -->
        <div class="row justify-content-center mb-3">
            <div class="col-md-10 text-center">
                <button class="back-btn btn btn-link" onclick="window.location.href='Seller_index.php'" style="text-decoration: none; text-transform: none;">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
        </div>

        <!-- Page Title -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 text-center">
                <input class="form-control" type="text" value="     Uploaded Products" aria-label="Disabled input example" disabled readonly style="background-color: white; color: black; border: 2px solid #E95F5D; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            </div>
        </div>

        <div class="container" style="background-color: #FFD09B; width: 930px; border-radius: 10px; width: 1075px; max-width: 100%;">
            <br>
            <!-- Product Listings -->
            <div class="row justify-content-center" id="product-section">
                <div class="col-md-10">
                    <div class="row g-4" id="product-list">
                        <?php
                        // Check if there are any products in the database
                        if ($result->num_rows > 0) {
                            // Loop through each product and display it
                            while($row = $result->fetch_assoc()) {
                                // Get image from BLOB and encode it as base64 for display
                                $image = base64_encode($row['product_image']);
                                // Display each product dynamically
                                echo '<div class="col-lg-3 col-sm-6" style="width: 250px;" id="product-' . $row['product_id'] . '">';
                                echo '    <div class="service-item rounded pt-3">';
                                echo '        <div class="p-4 text-center">';
                                echo '            <img src="' . $row['product_image'] . '" alt="' . $row['product_name'] . '" class="service-image mb-3" style="width: 100%; height: 130px; object-fit: cover;">';
                                echo '            <h5>' . $row['product_name'] . '</h5>';
                                echo '            <p class="price">Php ' . number_format($row['price'], 2) . '</p>';
                                echo '            <p>Status: Uploaded</p>';
                                echo '            <button class="btn btn-danger" onclick="removeProduct(\'' . $row['product_id'] . '\')">Remove</button>';
                                echo '            <br><br>';
                                echo '            <button class="btn btn-warning" onclick="fillUpdateForm(\'' . $row['product_id'] . '\', \'' . $row['product_name'] . '\', \'' . $row['description'] . '\', \'' . $row['best_before'] . '\', ' . $row['price'] . ', ' . $row['stock_quantity'] . ', \'' . $image . '\')" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>';
                                echo '        </div>';
                                echo '    </div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No products uploaded yet.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <br>
        </div>

        <!-- Modal Structure for Update -->
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm" method="POST" action="update_product.php" enctype="multipart/form-data">
                            <input type="hidden" id="productId" name="product_id">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="product_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription" name="description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Price (Php)</label>
                                <input type="number" class="form-control" id="productPrice" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="productStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" id="productStock" name="stock_quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="bestBefore" class="form-label">Best Before</label>
                                <input type="text" class="form-control" id="bestBefore" name="best_before" required>
                            </div>
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Product Image (optional)</label>
                                <input type="file" class="form-control" id="productImage" name="product_image">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to top button -->
        <a href="#" class="btn btn-light btn-lg rounded-circle" id="back-to-top" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
            <i class="bi bi-arrow-up"></i>
        </a>
    </div>

    <script>
        // Product Removal Function
        function removeProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: 'delete_product.php',
                    type: 'POST',
                    data: { product_id: productId },
                    success: function(response) {
                        if (response === 'success') {
                            // Remove the product element from the page
                            $('#product-' + productId).remove();
                        } else {
                            alert('Failed to delete product.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the product.');
                    }
                });
            }
        }

        // Function to fill the update form with existing product data
        function fillUpdateForm(productId, productName, description, bestBefore, price, stockQuantity, productImage) {
            $('#productId').val(productId);
            $('#productName').val(productName);
            $('#productDescription').val(description);
            $('#bestBefore').val(bestBefore);
            $('#productPrice').val(price);
            $('#productStock').val(stockQuantity);
            // If there's an image, display it
            if (productImage) {
                $('#productImage').val(productImage);
            }
        }
    </script>
</body>
</html>
