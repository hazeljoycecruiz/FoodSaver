<?php
// Include the database connection file
require_once 'database/db_connection.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index_login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Verify the database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


try {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        $stmt->close();

        // Check if bussiness_name exists and is not NULL
       
        $first_name = htmlspecialchars($user['first_name']);
      
    } else {
        // User not found
        session_destroy(); // Clear session
        header("Location: index_login.php"); // Redirect to login
        exit();
    }
} catch (Exception $e) {
    echo "Error fetching user details: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FoodSaver - Rescue, Savor, and Share</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
    <link rel="stylesheet" href="css/buyer_index.css">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <!-- <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>FoodSaver</h1> -->
                    <img src="img/logo-fs.png" alt="FoodSaver Logo" class="logo">
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <a href="Buyer_index.php" class="nav-item nav-link active">Home</a>
                        <a href="#food-section1" class="nav-item nav-link">Offer</a>
                        <a href="#food-section" class="nav-item nav-link">Menu</a>
                        <a href="Buyer_order_status.php" class="nav-item nav-link">Order Status</a>
                    </div>
                    <div class="profile-container">
                        <i class="bi bi-person-circle profile-icon" onclick="window.location.href='Buyer_profile.php'" style="cursor: pointer; font-size: 1.5rem;"></i>
                        <a href="Buyer_profile.php" class="text-dark profile-link" style="font-size: 16px; text-decoration: none; margin-left: 10px;">
                            <?php echo htmlspecialchars($first_name); ?>
                        </a>
                        <!-- Display error message if it exists -->
                        <?php if (!empty($error)) {
                            echo "<p>Error: $error</p>";
                        } ?>

                        <!-- Logout Icon -->
                        <i class="bi bi-cart4" style="font-size: 25px; margin-left: 20px; cursor: pointer;" onclick="window.location.href='Buyer_cart.php'"></i>
                        <i class="bi bi-box-arrow-right"
                            onclick="window.location.href='logout.php'"
                            style="cursor: pointer; font-size: 1.5rem; margin-left: 20px;">
                        </i>
                    </div>

                    <!-- <a href="" class="btn btn-primary py-2 px-4">Book A Table</a> -->
                </div>
            </nav>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">
                        <!-- Left Column: Text and Search Bar -->
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="display-3 animated slideInLeft" style="color: #E95F5D;">Rescue, Savor, and Share</h1>
                            <p class="animated slideInLeft mb-4 pb-2" style="color: #E95F5D;">Cuts waste and will delight your plate!</p>
                            <h3>Welcome Buyer! <?php echo htmlspecialchars($first_name); ?></h3>
                            <!-- Search Bar -->
                            <div class="d-flex">
                                <div class="form-outline flex-grow-1">
                                    <input id="search-input" type="search" class="form-control" placeholder="What's yours?">
                                </div>
                                <button id="search-button" type="button" class="btn btn-custom1 ms-2">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>


                            <!-- Buy Now Button -->
                            <!-- <a href="" class="btn btn-custom py-sm-3 px-sm-5 me-3 animated slideInLeft">Buy Now</a> -->
                        </div>

                        <!-- Right Column: Image -->
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                            <img class="img-fluid" src="img/hero.png" alt="Hero Image">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Navbar & Hero End -->

        <!-- Food Section Start -->
        <div class="container-xxl py-5" id="food-section1">
            <div class="container text-center">
                <h1><span style="color: #E95F5D;">On Sale!</span></h1>
                <div class="d-flex justify-content-center">
                    <div class="menu-box rounded p-4 border text-center" style="width: 80%; background-color: #f8f9fa;">
                        <!-- Row 1 -->
                        <div class="row justify-content-center mb-4">
                            <!-- Image 1 -->
                            <div class="col-3">
                                <img src="img/corned beef.png" alt="Corned Beef" class="img-fluid rounded-pill mb-2" style="border: 3px solid #E95F5D; width: 130px; height: 130px; object-fit: cover;">
                                <p class="name mb-1" style="font-weight: bold;">Corned Beef</p>
                                <p class="price">Php 15.00</p>
                            </div>
                            <!-- Image 2 -->
                            <div class="col-3">
                                <img src="img/moist cake.jpg" alt="Moist Cake" class="img-fluid rounded-pill mb-2" style="border: 3px solid #E95F5D; width: 130px; height: 130px; object-fit: cover;">
                                <p class="name mb-1" style="font-weight: bold;">Moist Cake</p>
                                <p class="price">Php 5.00</p>
                            </div>
                            <!-- Image 3 -->
                            <div class="col-3">
                                <img src="img/pancit canton.jpg" alt="Eggplant" class="img-fluid rounded-pill mb-2" style="border: 3px solid #E95F5D; width: 130px; height: 130px; object-fit: cover;">
                                <p class="name mb-1" style="font-weight: bold;">Pancit Canton</p>
                                <p class="price">Php 6.00</p>
                            </div>
                            <!-- Image 4 -->
                            <div class="col-3">
                                <img src="img/ensaymada.jpg" alt="Ensaymada" class="img-fluid rounded-pill mb-2" style="border: 3px solid #E95F5D; width: 130px; height: 130px; object-fit: cover;">
                                <p class="name mb-1" style="font-weight: bold;">Ensaymada</p>
                                <p class="price">Php 3.00</p>
                            </div>
                        </div>
                        <!-- Row 2 -->
                        <div class="row justify-content-center">
                            <!-- Image 5 -->
                            <div class="col-3">
                                <img src="img/pinakbet.jpg" alt="Pinakbet" class="img-fluid rounded-pill mb-2" style="border: 3px solid #E95F5D; width: 130px; height: 130px; object-fit: cover;">
                                <p class="name mb-1" style="font-weight: bold;">Pinakbet</p>
                                <p class="price">Php 10.00</p>
                            </div>
                            <!-- Image 6 -->
                            <div class="col-3">
                                <img src="img/centurytuna.jpg" alt="Adobong Pusit" class="img-fluid rounded-pill mb-2" style="border: 3px solid #E95F5D; width: 130px; height: 130px; object-fit: cover;">
                                <p class="name mb-1" style="font-weight: bold;">Century Tuna</p>
                                <p class="price">Php 15.00</p>
                            </div>
                            <!-- Image 7 -->
                            <div class="col-3">
                                <img src="img/ginataangGulay.jpg" alt="Ginataang Gulay" class="img-fluid rounded-pill mb-2" style="border: 3px solid #E95F5D; width: 130px; height: 130px; object-fit: cover;">
                                <p class="name mb-1" style="font-weight: bold;">Ginataang Gulay</p>
                                <p class="price">Php 10.00</p>
                            </div>
                            <!-- Image 8 -->
                            <div class="col-3">
                                <img src="img/mango.jpg" alt="Cheese Cupcake" class="img-fluid rounded-pill mb-2" style="border: 3px solid #E95F5D; width: 130px; height: 130px; object-fit: cover;">
                                <p class="name mb-1" style="font-weight: bold;">Mango</p>
                                <p class="price">Php 10.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Food Section End -->

        <style>
            .price {
                color: #E95F5D;
                font-weight: bold;
            }
        </style>


        <!-- Food 1 Section Start -->
        <div class="container-xxl py-5" id="food-section">
            <div class="container">
                <div class="row g-4">
                    <h1>Our <span style="color: #E95F5D;">Regular</span> Menu</h1>

                    <?php
                    // Loop through the products and display them
                    if (mysqli_num_rows($result) > 0) {
                        while ($product = mysqli_fetch_assoc($result)) {
                            $product_name = htmlspecialchars($product['product_name']); // Safe output
                            $product_price = number_format($product['price'], 2); // Format price
                            $product_description = htmlspecialchars($product['description']); // Safe output
                            $product_best_before = htmlspecialchars($product['best_before']); // Safe output
                            $product_image = $product['product_image']; // BLOB image data (to be handled in base64)
                            $product_id = $product['product_id']; // Product ID (UUID)
                    ?>

                            <div class="col-lg-3 col-sm-6">
                                <div class="service-item rounded pt-3">
                                    <div class="p-4 text-center">
                                        <!-- Handle image as base64 if it's a BLOB -->
                                        <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" class="service-image mb-3" style="width: 130px; height: 130px; object-fit: cover; border-radius: 50%;">
                                        <h5><?php echo $product_name; ?></h5>
                                        <div class="star-rating mb-2">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                        <p class="price">Php <?php echo $product_price; ?></p>
                                        <button class="btn" onclick="showPopup('<?php echo $product_image; ?>', '5', '<?php echo $product_name; ?>', '<?php echo $product_best_before; ?>', 'Php <?php echo $product_price; ?>', '3', 'FoodSaver Convinience Store', 'Butuan City', 'Buyer_seller_store.php?id=<?php echo $product_id; ?>')">Add to Cart</button>
                                    </div>
                                </div>
                            </div>

                    <?php
                        }
                    } else {
                        echo "<p>No products available at the moment.</p>";
                    }
                    ?>
                </div>
                <!-- Popup -->
                <div id="popupOverlay" class="popup-overlay">
                    <div id="popup" class="popup">
                        <!-- Square Section -->
                        <div class="popup-square">
                            <!-- Product Name with Close Button -->
                            <div class="popup-header">
                                <span class="close-x" onclick="closePopup()">&#10006;</span>
                            </div>

                            <!-- Centered Image -->
                            <img id="popupImage" src="" alt="Product Image" class="popup-image">


                            <!-- Information Section -->
                            <div class="popup-info">
                                <p id="popupQty"><strong>Quantity:</strong></p>
                                <p id="popupName"><strong>Product Name:</strong> </p>
                                <p id="popupDate"><strong>Best Before:</strong> </p>
                                <p id="popupPrice"><strong>Price:</strong> </p>
                                <p id="popupRating"><strong>Rating:</strong> </p>

                                <!-- Line between Rating and Store Name -->
                                <hr class="popup-divider">
                                <p id="popupStore"><strong>Store Name:</strong> </p>
                                <p id="popupLoc"><strong>Location:</strong> </p>
                            </div>

                            <!-- Add to Cart Button -->
                            <button class="btn btn-primary add-to-cart" data-id="product_id">Add to Cart</button>



                        </div>
                    </div>
                </div>
            </div>
            <div id="confirmationPopup" class="popup-overlay" style="display: none;">
                <div class="confirmation-popup">
                    <span class="check-icon">&#10004;</span>
                    <p class="confirmation-text">Added to Cart</p>
                </div>
            </div>
        </div>
        <!-- Food 1 Section End -->

        <div id="confirmationPopup" class="popup-overlay" style="display: none;">
            <div class="confirmation-popup">
                <span class="check-icon">&#10004;</span>
                <p class="confirmation-text">Added to Cart</p>
            </div>
        </div>
        <!-- food 6 end -->
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script>
        // Function to show the popup with product details
        // Function to show the popup with product details
        function showPopup(image, qty, name, date, price, rating, store, location, storeUrl) {
            document.getElementById('popupImage').src = image;
            document.getElementById('popupQty').innerHTML = '<strong>Quantity: </strong>' + qty;
            document.getElementById('popupName').innerHTML = '<strong>Name: </strong>' + name;
            document.getElementById('popupDate').innerHTML = '<strong>Best Before: </strong>' + date;
            document.getElementById('popupPrice').innerHTML = '<strong>Price: </strong>' + price;
            document.getElementById('popupRating').innerHTML = '<strong>Rating: </strong>' + rating + ' <i class="fas fa-star" style="color: #FFD700;"></i>';
            document.getElementById('popupStore').innerHTML = '<strong>Store Name: </strong>' + store;
            document.getElementById('popupLoc').innerHTML = '<strong>Location: </strong>' + location;

            // Store the URL for the View Store button
            window.currentStoreUrl = storeUrl;

            // Display the popup
            document.getElementById('popupOverlay').style.display = 'flex';
        }

        // Function to redirect the buyer to the store page
        function viewStore() {
            // Redirect to the store URL passed in the showPopup function
            if (window.currentStoreUrl) {
                window.location.href = window.currentStoreUrl;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart').forEach(function(button) {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id'); // Get product ID
                    fetch('add_to_cart.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                product_id: productId
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Product added to cart!');
                                window.location.href = 'buyer_cart.php'; // Redirect to cart
                            } else {
                                alert('Failed to add to cart.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });



        // Function to close the popup
        function closePopup() {
            document.getElementById('popupOverlay').style.display = 'none';
        }

        // Function to show the confirmation popup
        function showConfirmation() {
            // Show the confirmation popup
            const confirmationPopup = document.getElementById('confirmationPopup');
            confirmationPopup.style.display = 'flex';

            // Hide the confirmation popup after 3 seconds
            setTimeout(() => {
                confirmationPopup.style.display = 'none';
            }, 3000);
        }
    </script>

    <script>
        function showConfirmation() {
            // Show the confirmation popup
            const confirmationPopup = document.getElementById('confirmationPopup');
            confirmationPopup.style.display = 'flex';

            // Hide the confirmation popup after 3 seconds
            setTimeout(() => {
                confirmationPopup.style.display = 'none';
            }, 3000);
        }

        function closePopup() {
            // Hide the main popup
            document.getElementById('popupOverlay').style.display = 'none';
        }
    </script>



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