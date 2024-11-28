<?php
// Include your database connection file
include('database/db_connection.php');

// Initialize a success flag
$upload_success = false;

// Check if the form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $best_before = $_POST['best_before'];
    $price = (float)$_POST['price'];
    $stock_quantity = (int)$_POST['stock_quantity'];

    // Handle the product image upload
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['productImage']['tmp_name']);
        $file_size = $_FILES['productImage']['size'];

        if (!in_array($file_type, $allowed_types)) {
            die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
        }

        if ($file_size > 2 * 1024 * 1024) { // 2 MB limit
            die("File size exceeds the limit of 2 MB.");
        }

        $file_name = $_FILES['productImage']['name'];
        $file_tmp = $_FILES['productImage']['tmp_name'];
        $file_path = 'img/' . $file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            $product_image = $file_path;
        } else {
            die("Error uploading image.");
        }
    } else {
        $product_image = null; // Default image
    }

    // Prepare the SQL query for inserting the new product into the database
    $query = "INSERT INTO products (product_name, description, price, best_before, stock_quantity, product_image, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssdsis", $product_name, $description, $price, $best_before, $stock_quantity, $product_image);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $upload_success = true; // Set the success flag to true
        } else {
            echo "Error posting product: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the query.";
    }

    $conn->close();
}

?>

<!-- Notification Display Script -->
<?php if ($upload_success): ?>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const notification = document.createElement("div");
            notification.className = "alert alert-success alert-dismissible fade show";
            notification.style.position = "fixed";
            notification.style.top = "20px";
            notification.style.right = "20px";
            notification.style.zIndex = "9999";
            notification.innerHTML = `
                <strong>Success!</strong> Product uploaded successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.classList.remove("show");
                notification.remove();
                window.location.href = "Seller_products_uploaded.php"; // Redirect after 3 seconds
            }, 1000);
        });
    </script>
<?php endif; ?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bussiness Product </title>
    <link href="img/favicon.ico" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
            border-radius: 8px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .favorite-item:hover {
            background-color: #ffdad6;
        }

        .favorite-item i {
            color: #ff6b6b;
        }

        .form-control-lg.border-danger {
            box-shadow: none;
            /* Removes the black shadow */
        }

        /* Optional: Add a red focus outline */
        .form-control-lg.border-danger:focus {
            border-color: #dc3545;
            /* Bootstrap red color */

        }

        .transparent-border {
            border-color: transparent;
            /* Makes the border transparent */
        }

        .transparent-border:focus {
            outline: none;
            /* Removes focus outline */
            border-color: transparent;
            /* Ensures no border on focus */
            box-shadow: none;
            /* Removes Bootstrap's default box shadow */
        }

        .hov a:hover,
        .hov button:hover {
            background-color: #ffdad6 !important;
            /* Change background color on hover */
            color: #000000 !important;
            /* Optional: Change text color if needed */
        }

        .summary-container {
            background-color: #ffffff;
            border-radius: 75px;
            padding: 20px;
        }

        .summary-container .btn {
            border-radius: 10px;
            font-weight: bold;
        }

        .summary-container .total {
            font-size: 20px;
            font-weight: bold;
        }


        .form-control::placeholder {
            text-align: start;
            vertical-align: top;
            position: absolute;
            top: 0;
            transform: translateY(10%);
            /* Optional for precise alignment */
            font-size: 1.25rem;
            /* Adjust the size if necessary */
        }

        .product-picture-container {
            background-color: rgba(255, 255, 255, 0);
            /* Fully transparent */
            border: none;
            /* Remove borders if needed */
            box-shadow: none;
            /* Remove shadows if present */
        }
    </style>

</head>

<body>
    <div class="container py-4">
        <!-- Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="back-btn" onclick="window.location.href='Seller_index.php'">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
        </div>
        <div style="border: 2px solid #E95F5D; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <input class="form-control" type="text" value="       My Profile/ Sell Product"
                aria-label="Disabled input example" disabled readonly
                style="background-color: white; color: black;">
        </div>
        <!-- Profile Content -->
        <div class="row g-3 mt-1 ">
            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="sidebar pt-5" style="border: 2px solid #E95F5D; border-radius: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Profile Icon -->

                    <!-- Display the Profile Picture -->
                    <div class="profile-picture-container">
                        <img
                            src="img/store.jpg"
                            alt="Profile Picture"
                            id="profile-pic"
                            style="cursor: pointer;"
                            onclick="window.location.href='Seller_profile.php';">
                    </div>

                    <h5> <?php echo htmlspecialchars($bussiness_name ?? $first_name ?? 'Business Name'); ?></h5>
                    </a>
                    <!-- Display error message if it exists -->
                    <?php if (!empty($error)) {
                        echo "<p>Error: $error</p>";
                    } ?>


                    <!-- Other Menu Items -->

                    <div class="pb-5"></div>

                    <!-- Other Menu Items -->

                    <div class="d-flex justify-content-center " id="navbarCollapse">
                        <!-- Favorites Button -->
                        <button
                            type="button"
                            class="btn text-white d-flex align-items-center px-4 py-3"
                            style="background-color: #ff6b6b;  border-radius: 12px; pointer-events: none; width: 350px;">
                            <i class="fas fa-shopping-cart me-4"></i>
                            <span class="text-start">Sell Product</span>
                        </button>
                    </div>



                    <div class="nav flex-column">

                    </div>
                    <div class="pt-5 pb-5">
                    </div>
                    <div class="pt-5 pb-4">
                    </div>
                    <div class="pt-5  pb-3">
                    </div>

                </div>
            </div>

            <!-- Favorites -->
            <div class="col-md-8">

                <div class="favorites-container" style="border: 2px solid #E95F5D; 
            border-radius: 12px; 
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
            box-sizing: border-box; 
            height: 575px; /* Fixed height */ 
            padding: 16px; 
           ">

                    <div class="row align-items-center justify-content-center"> <!-- Center content vertically and horizontally -->
                        <!-- <div class="product-picture-container col-4 mb-4 summary-container d-flex justify-content-center align-items-center w-25 h-100">
                        <img src="img/svg_upload.svg" 
                            alt="product_pic" 
                            id="product_pic" 
                            onclick="document.getElementById('file-input').click();" 
                            class="img-fluid" 
                            style="cursor: pointer; width: 150px; height: 150x; object-fit: cover; border-radius: 8px; border: 2px solid #E95F5D;">
                        <input type="file" id="file-input" accept="image/*" style="display: none;" onchange="previewImage(event)">
                    </div> -->

                        <script>
                            // Function to preview the image after it's selected
                            function previewImage(event) {
                                // Get the file selected by the user
                                const file = event.target.files[0];

                                // Check if the file is valid
                                if (file) {
                                    // Create a FileReader instance
                                    const reader = new FileReader();

                                    // Set up the callback for when the file is read
                                    reader.onload = function(e) {
                                        // Update the image source with the new image's data URL
                                        document.getElementById('product_pic').src = e.target.result;
                                    };

                                    // Read the file as a data URL to preview it
                                    reader.readAsDataURL(file);
                                }
                            }
                        </script>



                        <!-- <div class="col-8 mb-4">
                        <input type="text" class="form-control w-100 transparent-border mb-2" id="product_name" placeholder="Product Name">
                        <input type="date" class="form-control w-100 transparent-border mb-2" id="best_before" placeholder="Best before" required style="font-size: 20px;">
                        <input type="number" class="form-control w-100 transparent-border mb-2" id="price" placeholder="Price" min="0" step="any" required>
                        <input type="number" class="form-control w-100 transparent-border mb-2" id="qty" placeholder="Qty" min="0" required>
                    </div> -->

                        <div class="col-8 mb-4">
                            <!-- Form for submitting product data -->
                            <form method="POST" action="" enctype="multipart/form-data">

                                <!-- Display a placeholder image that will update when a user selects an image -->
                                <img
                                    src="img/svg_upload.svg" 
                                alt="Upload"
                                id="product_pic"
                                onclick="document.getElementById('file-input').click();"
                                style="cursor: pointer; width: 150px; height: 150px; object-fit: cover; display: block; margin: 0 auto;">

                                <br>

                                <!-- Input Fields for Product Details -->
                                <input
                                    type="text"
                                    name="product_name"
                                    class="form-control w-100 transparent-border mb-2"
                                    placeholder="Product Name"
                                    required>

                                <textarea
                                    name="description"
                                    class="form-control w-100 transparent-border mb-2"
                                    placeholder="Description"
                                    required></textarea>

                                <input
                                    type="date"
                                    name="best_before"
                                    class="form-control w-100 transparent-border mb-2"
                                    required>

                                <input
                                    type="number"
                                    name="price"
                                    class="form-control w-100 transparent-border mb-2"
                                    placeholder="Price"
                                    min="0"
                                    step="any"
                                    required>

                                <input
                                    type="number"
                                    name="stock_quantity"
                                    class="form-control w-100 transparent-border mb-2"
                                    placeholder="Qty"
                                    min="0"
                                    required>

                                <!-- Hidden File Input to Upload Image -->
                                <input
                                    type="file"
                                    name="productImage"
                                    id="file-input"
                                    accept="image/*"
                                    style="display: none;" onchange="previewImage(event)">

                                <button
                                    type="submit"
                                    class="btn btn-primary w-25 rounded-pill mt-3"
                                    style="float: right;">
                                    Save
                                </button>

                            </form>




                        </div>


                    </div>
                    <div class="pt-4">
                    </div>



                    <!-- <textarea id="comments" class="form-control" rows="4" placeholder="Description" style=" border-radius: 10px; height: 242px;"></textarea> -->

                    <div class="mt-4 pt-2">

                    </div>


                    <!-- <div class="d-flex justify-content-end">
                                <button type="submit" name="submit" class="btn btn-primary w-25 rounded-pill" onclick="window.location.href='Seller_products_uploaded.php'">Save</button>
                        </div>  -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>