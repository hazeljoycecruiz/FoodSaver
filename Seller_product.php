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
$user_id = intval($_SESSION['user_id']); // Convert to integer for safety

// Verify the database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Prevent redirection loop using a session flag
    if (!isset($_SESSION['form_submitted'])) {
        // Get form data with validation
        $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : NULL;
        $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : NULL;
        $age = isset($_POST['age']) ? trim($_POST['age']) : NULL;
        $birthdate = isset($_POST['birthdate']) ? trim($_POST['birthdate']) : NULL;
        $address = isset($_POST['address']) ? trim($_POST['address']) : NULL;
        $email = isset($_POST['email']) ? trim($_POST['email']) : NULL;
        $phone_num = isset($_POST['phone_num']) ? trim($_POST['phone_num']) : NULL;
        $bussiness_name = isset($_POST['bussiness_name']) ? trim($_POST['bussiness_name']) : NULL;
        $bussiness_type = isset($_POST['bussiness_type']) ? trim($_POST['bussiness_type']) : NULL;


        // Check for duplicate email
        $email_check_query = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
        $stmt_check = $conn->prepare($email_check_query);
        $stmt_check->bind_param("si", $email, $user_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "Error: The email address is already in use.";
            $stmt_check->close();
            exit();
        }
        $stmt_check->close();

        // Update user data in the database, including the file path
        $sql = "UPDATE users 
                SET first_name = ?, 
                    last_name = ?, 
                    age = ?, 
                    birthdate = ?, 
                    address = ?, 
                    email = ?, 
                    phone_num = ?, 
                    bussiness_name = ?, 
                    bussiness_type = ? 
                WHERE user_id = ?";

        // Bind the parameters and execute the update query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssissi", $first_name, $last_name, $age, $birthdate, $address, $email, $phone_num, $bussiness_name, $bussiness_type, $user_id);

        if ($stmt->execute()) {
            // Set session flag to prevent reprocessing
            $_SESSION['form_submitted'] = true;

            // Redirect after success
            header("Location: Seller_profile.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Form already submitted; clear the flag and redirect
        unset($_SESSION['form_submitted']);
        header("Location: Seller_profile.php");
        exit();
    }
}

if(isset($_POST['submit'])){
    $file_name = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = 'img/'.$file_name;

    $query = mysqli_query($conn, "Insert into users (file) values ('$file_name')");

    if(move_uploaded_file($tempname, $folder)){
        echo "<h2> File uploaded successfully</h2>";
    } else{
        echo "<h2> File not uploaded</h2>";
    }

}

// Fetch other user details securely
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
        if (isset($user['bussiness_name']) && $user['bussiness_name'] !== NULL) {
            $bussiness_name = htmlspecialchars($user['bussiness_name']);
     
        } else {
            $first_name = htmlspecialchars($user['first_name']);
     
        }
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
        box-shadow: none; /* Removes the black shadow */
    }

    /* Optional: Add a red focus outline */
    .form-control-lg.border-danger:focus {
        border-color: #dc3545; /* Bootstrap red color */

    }

    .transparent-border {
        border-color: transparent; /* Makes the border transparent */
    }

    .transparent-border:focus {
        outline: none; /* Removes focus outline */
        border-color: transparent; /* Ensures no border on focus */
        box-shadow: none; /* Removes Bootstrap's default box shadow */
    }

        .hov a:hover,
        .hov button:hover {
        background-color: #ffdad6 !important; /* Change background color on hover */
        color: #000000 !important; /* Optional: Change text color if needed */
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
    
        #description {
        height: 255px; /* Adjust height as needed */
    }

     .form-control::placeholder {
        text-align: start; vertical-align: top;
        position: absolute;
        top: 0;
        transform: translateY(10%); /* Optional for precise alignment */
        font-size: 1.25rem; /* Adjust the size if necessary */
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
            <div class="col-md-4" >
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

                <a href="Seller_profile.php" class="pb-4 name" style=";text-decoration: none; "><h5> <?php echo htmlspecialchars($bussiness_name ?? $first_name); ?></h5> 
                        </a>
                        <!-- Display error message if it exists -->
                        <?php if (!empty($error)) { echo "<p>Error: $error</p>"; } ?>


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

                <div class="favorites-container" style="border: 2px solid #E95F5D; border-radius: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">

                    <div class="row align-items-center justify-content-center" style="height: 27vh;"> <!-- Center content vertically and horizontally -->
                        <div class="profiles-picture-container col-4 mb-4 summary-container d-flex justify-content-center align-items-center w-25 h-100">
                            <img src="img/svg_upload.svg" alt="Profile Picture" id="profile-pic" onclick="document.getElementById('file-input').click();" class="img-fluid" style="cursor: pointer;">
                            <input type="file" id="file-input" accept="image/*" style="display: none;" onchange="previewImage(event)">
                        </div>
                    
                        <div class="col-8 mb-4">
                            <input type="text" class="form-control w-100 transparent-border mb-2" id="product_name" placeholder="Product Name">
                            <input type="text" class="form-control w-100 transparent-border mb-2" id="best_before" placeholder="Best before">
                            <input type="text" class="form-control w-100 transparent-border mb-2" id="price" placeholder="Price">
                            <input type="text" class="form-control w-100 transparent-border mb-2" id="qty" placeholder="Qty">
                        </div>
                    </div>
                        <div class="pt-4">
                        </div>
                
                    
                        <textarea 
                            name="description" 
                            class="form-control transparent-border" 
                            id="description" 
                            placeholder="Description" 
                            rows="4" 
                            style="padding: 10px; text-align: left; color: #000; background-color: #fff;">
                        </textarea>

      
                        <div class="mt-4 pt-2"> 

                        </div>
  

                        <div class="d-flex justify-content-end">
                                <button type="submit" name="submit" class="btn btn-primary w-25 rounded-pill">Save</button>
                        </div> 
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