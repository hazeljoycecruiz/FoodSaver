<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile / Favorites</title>
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

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Stylesheets -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">

    <style>
        .profile-container {
            background-color: #ffe6e2;
            border-radius: 10px;
            padding: 20px;
        }

        .sidebar {
            background-color: #ffe6e2;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .sidebar img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar h5 {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .sidebar .menu-item {
            background-color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar .menu-item:hover {
            background-color: #ffdad6;
        }

        .sidebar .menu-item i {
            margin-right: 8px;
            color: #ff6b6b;
        }

        .favorites-container {
            background-color: #ffe6e2;
            border-radius: 10px;
            padding: 20px;
        }

        .favorite-item {
            background-color: #fff;
            border-radius: 10px;
            padding: 13.5px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .favorite-heart {
            font-size: 32px;
            color: red;
        }

        .favorite-item:hover {
            background-color: #ffdad6;
        }

        .favorite-item i {
            color: #ff6b6b;
        }

        .hov a:hover,
        .hov button:hover {
            background-color: #ffdad6 !important;
            color: #000000 !important;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <!-- Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="back-btn" onclick="window.location.href='Buyer_index.php'">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
        </div>
        <!-- Title -->
        <div style="border: 2px solid #E95F5D; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <input class="form-control" type="text" value="       My Profile / Favorites" aria-label="Disabled input example" disabled readonly style="background-color: white; color: black;">
        </div>

        <!-- Profile Content -->
        <div class="row g-3 mt-1">
            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="sidebar pt-5" style="border: 2px solid #E95F5D; border-radius: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Profile Icon -->
                    <div class="profile-picture-container">
                        <img src="img/uriel1.png" alt="Profile Picture" id="profile-pic" style="cursor: pointer;" onclick="window.location.href='Buyer_profile.php';">
                    </div>
                    <a href="Buyer_profile.php" class="pb-4 name" style="text-decoration: none;">
                        <h5>Hau C.</h5>
                    </a>
                    <!-- Favorites Menu Item -->
                    <div class="d-flex justify-content-center pt-3 pb-4" id="navbarCollapse">
                        <button type="button" class="btn text-white d-flex align-items-center px-4 py-3" style="background-color: #ff6b6b;  border-radius: 12px; pointer-events: none; width: 350px;">
                            <i class="fas fa-heart me-4"></i>
                            <span class="text-start">Favorites</span>
                        </button>
                    </div>

                    <!-- Other Menu Items -->
                    <div class="hov d-flex justify-content-center">
                        <a href="Buyer_profile_purchase.php" class="btn btn-light d-flex align-items-center px-4 py-3 bg-white" style="border-radius: 12px; width: 350px;">
                            <i class="fas fa-shopping-cart me-4"></i>
                            <span class="text-start">Purchases</span>
                        </a>
                    </div>
                    <div class="pb-4"></div>
                    <div class="hov d-flex justify-content-center">
                        <a href="Buyer_profile_rating.php" class="btn btn-light d-flex align-items-center px-4 py-3 bg-white" style="border-radius: 12px; width: 350px;">
                            <i class="fas fa-star me-4"></i>
                            <span class="text-start">Rating</span>
                        </a>
                    </div>
                     
                    <div class="nav flex-column">
                        
                    </div>
                    <div class="pt-5 pb-5">
                    </div>

                    <div class="pt-2 ">
                    </div>
                </div>
            </div>

            <!-- Favorites -->
            <div class="col-md-8">
                <div class="favorites-container" style="border: 2px solid #E95F5D; border-radius: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <div class="favorite-item mt-2" onclick="showPopup('img/kinilaw.jpg', 'Kinilaw', 'November 30, 2024', 'Php 35.00', 'FoodSaver Convenience Store', 'Butuan City')">
                        <span>Kinilaw</span>
                        <i class="fas fa-heart favorite-heart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #FFECC8; border-radius: 20px; border: 2px solid #FFD09B;">

                <!-- Modal Header -->
                <div class="modal-header" style="border-bottom: 1px solid #FFD09B;">
                    <h5 class="modal-title" id="productModalLabel" style="color: #E95F5D; font-weight: bold;">
                        Product Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: #FFB0B0;"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <!-- Product Image -->
                        <img id="productImage" src="img/centurytuna.jpg" alt="Product Image" style="width: 100px; height: 100px; border-radius: 10px; margin-right: 20px;">

                        <!-- Product Information -->
                        <div>
                            <p id="productName" style="font-size: 16px; color: #000; margin: 5px 0;">
                                <strong>Product Name:</strong> Century Tuna
                            </p>
                            <p id="bestBefore" style="font-size: 16px; color: #000; margin: 5px 0;">
                                <strong>Best Before:</strong> November 30, 2024
                            </p>
                            <p id="price" style="font-size: 16px; color: #000000; margin: 5px 0;">
                                <strong>Price:</strong> Php 20.00
                            </p>
                            <p id="store" style="font-size: 16px; color: #000; margin: 5px 0;">
                                <strong>Store:</strong> FoodSaver Convenience Store
                            </p>
                            <p id="location" style="font-size: 16px; color: #000; margin: 5px 0;">
                                <strong>Location:</strong> Butuan City
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPopup(imageSrc, name, bestBefore, price, store, location) {
            document.getElementById('productImage').src = imageSrc;
            document.getElementById('productName').innerHTML = `<strong>Product Name:</strong> ${name}`;
            document.getElementById('bestBefore').innerHTML = `<strong>Best Before:</strong> ${bestBefore}`;
            document.getElementById('price').innerHTML = `<strong>Price:</strong> ${price}`;
            document.getElementById('store').innerHTML = `<strong>Store:</strong> ${store}`;
            document.getElementById('location').innerHTML = `<strong>Location:</strong> ${location}`;
            new bootstrap.Modal(document.getElementById('productModal')).show();
        }
    </script>
</body>

</html>
