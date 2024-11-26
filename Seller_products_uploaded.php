<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <title>FoodSaver - Seller's Products</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">

    <!-- Make sure to include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Make sure to include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</head>

<body>
    <div class="container py-4">
        <!-- Back Button -->
        <div class="row justify-content-center mb-3">
            <div class="col-md-10 text-center">
                <button class="back-btn btn btn-link" onclick="window.location.href='Seller_index.html'" style="text-decoration: none; text-transform: none;">
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

        <div class="container" style="background-color: #FFD09B; width: 930px; border-radius: 10px;">
            <br>
            <!-- Product Listings -->
            <div class="row justify-content-center" id="product-section">
                <div class="col-md-10">
                    <div class="row g-4" id="product-list">
                        <!-- Example of a Product Item -->
                        <div class="col-lg-3 col-sm-6" style="width: 250px;">
                            <div class="service-item rounded pt-3">
                                <div class="p-4 text-center">
                                    <img src="img/corned beef.png" alt="Corned Beef" class="service-image mb-3" style="width: 100%; height: 130px; object-fit: cover;">
                                    <h5>Corned Beef</h5>
                                    <p class="price">Php 20.00</p>
                                    <p>Status: Uploaded</p>
                                    <button class="btn btn-danger">Remove</button>
                                    <br><br>
                                    <!-- Update Button that triggers the modal -->
                                    <button class="btn btn-warning" onclick="fillUpdateForm(1, 'Corned Beef', 'A can of corned beef', '2024-12-31', 20.00, 10, 'img/corned beef.png')" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
                                </div>
                            </div>

                            <!-- Repeat the above block for other uploaded products -->
                        </div>
                    </div>
                </div>
                <br>

                <!-- Modal Structure -->
                <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border-radius: 12px; border: 2px solid #E95F5D;">
                            <div class="modal-header" style="background-color: #FFD09B; color: black; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                <h5 class="modal-title" id="updateModalLabel" style="font-family: 'Nunito', sans-serif; font-weight: 700;">Update Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="background-color: #FFD09B; padding: 20px;">
                                <form id="updateForm" method="POST" action="update_products.php" enctype="multipart/form-data">
                                    <!-- Hidden Fields -->
                                    <input type="hidden" name="productId" id="productId">
                                    <input type="hidden" name="existingImage" id="existingImage">

                                    <!-- Form Fields -->
                                    <div class="mb-3">
                                        <label for="productName" class="form-label" style="font-family: 'Heebo', sans-serif;">Product Name</label>
                                        <input type="text" class="form-control" id="productName" placeholder="Enter Product Name">
                                    </div>

                                    <div class="mb-3">
                                        <label for="productDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="productDescription" rows="3" placeholder="Enter Description"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="bestBefore" class="form-label">Best Before</label>
                                        <input type="date" class="form-control" id="bestBefore">
                                    </div>

                                    <div class="mb-3">
                                        <label for="productPrice" class="form-label">Price (Php)</label>
                                        <input type="number" class="form-control" id="productPrice" placeholder="Enter Price">
                                    </div>

                                    <div class="mb-3">
                                        <label for="productQuantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="productQuantity" placeholder="Enter Quantity">
                                    </div>

                                    <div class="mb-3">
                                        <label for="productImage" class="form-label">Upload Photo</label>
                                        <input type="file" class="form-control" id="productImage">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer" style="background-color: #FFD09B;">
                                <button type="button" class="btn btn-primary" style="background-color: #E95F5D;" onclick="submitUpdateForm()">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Back to Top Button -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <!-- Javascript -->
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.min.js"></script>

        <script>
            // Pre-fill the modal with product data
            function fillUpdateForm(productId, name, description, bestBefore, price, quantity, imageUrl) {
                document.getElementById('productId').value = productId;
                document.getElementById('productName').value = name;
                document.getElementById('productDescription').value = description;
                document.getElementById('bestBefore').value = bestBefore;
                document.getElementById('productPrice').value = price;
                document.getElementById('productQuantity').value = quantity;
                document.getElementById('existingImage').value = imageUrl; // Keep the existing image path for reference
                document.getElementById('productImage').value = ''; // Reset the file input
            }


            // Submit the update form
            function submitUpdateForm() {
                document.getElementById('updateForm').submit();
            }
        </script>
</body>

</html>