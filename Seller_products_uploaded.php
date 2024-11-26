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
        <div class="row justify-content-center mb-4" >
            <div class="col-md-10 text-center">
                <input class="form-control" type="text" value="     Uploaded Products" aria-label="Disabled input example" disabled readonly style="background-color: white; color: black; border: 2px solid #E95F5D; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            </div>
        </div>

        <div class="container" style="background-color: #FFD09B; width: 930px; border-radius: 10px;">
            <br>
        
       <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confirmationModalLabel">Confirm Cancellation</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are you sure you want to remove a product?
            </div>
            <div class="modal-footer">        
              <button type="button" class="btn btn-danger" id="confirmCancelBtn">Yes</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
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
                                <button class="btn btn-danger remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6" style="width: 250px;">
                        <div class="service-item rounded pt-3">
                            <div class="p-4 text-center">
                                <img src="img/pancit canton.jpg" alt="Corned Beef" class="service-image mb-3" style="width: 100%; height: 130px; object-fit: cover;">
                                <h5>Pancit Canton</h5>
                                <p class="price">Php 8.00</p>
                                <p>Status: Uploaded</p>
                                <button class="btn btn-danger remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6" style="width: 250px;">
                        <div class="service-item rounded pt-3">
                            <div class="p-4 text-center">
                                <img src="img/centurytuna.jpg" alt="Corned Beef" class="service-image mb-3" style="width: 100%; height: 130px; object-fit: cover;">
                                <h5>Century Tuna</h5>
                                <p class="price">Php 20.00</p>
                                <p>Status: Uploaded</p>
                                <button class="btn btn-danger remove-btn">Remove</button>
                            </div>
                        </div>
                    </div>
                    <!-- Repeat the above block for other uploaded products -->
                </div>
            </div>
        </div>

        <script>
            // Wait for the DOM to be ready
            document.addEventListener('DOMContentLoaded', () => {
                let rowToDelete = null; // Store the row to delete

                // Get all remove buttons
                const removeButtons = document.querySelectorAll('.remove-btn');

                // Add event listener for each remove button
                removeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Store the product column (col-lg-3 col-sm-6) to delete
                        rowToDelete = button.closest('.col-lg-3');

                        // Show the Bootstrap modal
                        const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                        modal.show();
                    });
                });

                // Confirm cancellation and remove the product column
                document.getElementById('confirmCancelBtn').addEventListener('click', function() {
                    if (rowToDelete) {
                        rowToDelete.remove(); // Remove the entire product column
                    }

                    // Hide the modal after confirming
                    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
                    modal.hide();
                });
            });

        </script>

        <br>
    </div>

        <!-- Back to Top Button -->

    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>

</html>