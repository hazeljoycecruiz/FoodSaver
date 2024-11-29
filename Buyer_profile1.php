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

// Get the logged-in user's ID securely
$user_id = intval($_SESSION['user_id']); // Convert to integer for safety

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Prevent redirection loop using a session flag
    if (!isset($_SESSION['form_submitted'])) {
        // Get form data with validation
        $first_name = isset($_POST['first_name']) && !empty(trim($_POST['first_name'])) ? trim($_POST['first_name']) : NULL;
        $last_name = isset($_POST['last_name']) && !empty(trim($_POST['last_name'])) ? trim($_POST['last_name']) : NULL;
        $age = isset($_POST['age']) && !empty(trim($_POST['age'])) ? trim($_POST['age']) : NULL;
        $birthdate = isset($_POST['birthdate']) && !empty(trim($_POST['birthdate'])) ? trim($_POST['birthdate']) : NULL;
        $address = isset($_POST['address']) && !empty(trim($_POST['address'])) ? trim($_POST['address']) : NULL;
        $email = isset($_POST['email']) && !empty(trim($_POST['email'])) ? trim($_POST['email']) : NULL;
        $phone_num = isset($_POST['phone_num']) && !empty(trim($_POST['phone_num'])) ? trim($_POST['phone_num']) : NULL;
 

        $first_name = isset($_POST['first_name']) && !empty(trim($_POST['first_name'])) ? trim($_POST['first_name']) : NULL;
        $last_name = isset($_POST['last_name']) && !empty(trim($_POST['last_name'])) ? trim($_POST['last_name']) : NULL;
        $age = isset($_POST['age']) && !empty(trim($_POST['age'])) ? trim($_POST['age']) : NULL;
        $birthdate = isset($_POST['birthdate']) && !empty(trim($_POST['birthdate'])) ? trim($_POST['birthdate']) : NULL;
        $address = isset($_POST['address']) && !empty(trim($_POST['address'])) ? trim($_POST['address']) : NULL;
        $email = isset($_POST['email']) && !empty(trim($_POST['email'])) ? trim($_POST['email']) : NULL;
        $phone_num = isset($_POST['phone_num']) && !empty(trim($_POST['phone_num'])) ? trim($_POST['phone_num']) : NULL;
  
        // Retrieve the current user details
        $user_query = "SELECT * FROM users WHERE user_id = ?";
        $stmt_user = $conn->prepare($user_query);
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        $current_user = $stmt_user->get_result()->fetch_assoc();
        $stmt_user->close();
    
        // Use current values if fields are left blank
        $first_name = $first_name ?? $current_user['first_name'];
        $last_name = $last_name ?? $current_user['last_name'];
        $age = $age ?? $current_user['age'];
        $birthdate = $birthdate ?? $current_user['birthdate'];
        $address = $address ?? $current_user['address'];
        $email = $email ?? $current_user['email'];
        $phone_num = $phone_num ?? $current_user['phone_num'];

    
        // Check for duplicate email if the email is changed
        if ($email !== $current_user['email']) {
            $email_check_query = "SELECT user_id FROM users WHERE email = ?";
            $stmt_check = $conn->prepare($email_check_query);
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
    
            if ($result_check->num_rows > 0) {
                echo "Error: The email address is already in use.";
                $stmt_check->close();
                exit();
            }
            $stmt_check->close();
        }

        // Update user data in the database, including the file path
        $sql = "UPDATE users 
                SET first_name = ?, 
                    last_name = ?, 
                    age = ?, 
                    birthdate = ?, 
                    address = ?, 
                    email = ?, 
                    phone_num = ?
                WHERE user_id = ?";

        // Bind the parameters and execute the update query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssii", $first_name, $last_name, $age, $birthdate, $address, $email, $phone_num, $user_id);

        if ($stmt->execute()) {
            // Set session flag to prevent reprocessing
            $_SESSION['form_submitted'] = true;

           // Show success alert
            // Output JavaScript to show the success alert and then redirect after 2 seconds
// Show success alert
                echo "<script>
                    function showSuccessAlert() {
                        const alertDiv = document.getElementById('success-alert');
                        
                        // Remove the 'd-none' class to make the alert visible
                        alertDiv.classList.remove('d-none');
                        
                        // Set a timeout to hide the alert and redirect after 5 seconds
                        setTimeout(() => {
                            alertDiv.classList.add('d-none'); // Hide the alert after 5 seconds
                            window.location.href = 'Buyer_profile.php'; // Redirect after alert disappears
                        }, 5000); // Delay of 5 seconds
                    }
                    
                    showSuccessAlert(); // Call the function to show the alert
                </script>";

        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Form already submitted; clear the flag and redirect
        unset($_SESSION['form_submitted']);
        header("Location: Buyer_profile.php");
        exit();
    }
}



// Fetch the user's image from the database securely
try {
    $sql = "SELECT file FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['file']) {
            $profileImage = 'data:img/jpeg;base64,' . base64_encode($row['file']);
        } else {
            $profileImage = 'img/photo_edit.png'; // Default image
        }
    } else {
        $profileImage = 'img/photo_edit.png'; // Default image if user not found
    }
    $stmt->close();
} catch (Exception $e) {
   // echo "Error fetching user image: " . $e->getMessage();
}

// Fetch other user details securely
try {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $first_name = htmlspecialchars($user['first_name']); // Securely use data
    } else {
        // User not found
        session_destroy(); // Clear session
        header("Location: index_login.php"); // Redirect to login
        exit();
    }
    $stmt->close();
} catch (Exception $e) {
    echo "Error fetching user details: " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile </title>
    <link href="img/favicon.ico" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Heebo:wght@400;600;700&display=swap" rel="stylesheet">


    <!-- Icon Font Stylesheet -->


    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    
</head>

<style>
    .sidebar {
  border: 2px solid #E95F5D; /* Light gray border */
  border-radius: 12px; /* Rounded corners */
  padding: 20px; /* Add padding to create space between the border and content */
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
}

</style>

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
        <div style="border: 2px solid #E95F5D; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <input class="form-control" type="text" value="       My Profile" 
            aria-label="Disabled input example" disabled readonly 
            style="background-color: white; color: black;">
        </div>
        <!-- Profile Content -->
        <div class="row g-3 mt-1 ">
            <!-- Sidebar -->
            <div class="col-md-4" >
                <div class="sidebar pt-5">
                    <!-- Profile Icon -->

                <!-- Display the Profile Picture -->
                <div class="profile-picture-container">
                    <img src="img/uriel1.png" alt="Profile Picture" id="profile-pic" onclick="document.getElementById('file-input').click();" style="cursor: pointer;">
                    <input type="file" name="file" id="file-input" accept="image/*" style="display: none;" onchange="previewImage(event)">
                </div>

                    <a href="Buyer_profile.php" class="pb-4 name" style=";text-decoration: none; "><h5> <?php echo htmlspecialchars($first_name); ?></h5> 
                        </a>
                        <!-- Display error message if it exists -->
                        <?php if (!empty($error)) { echo "<p>Error: $error</p>"; } ?>


                         <!-- Other Menu Items -->
                         <div class="hov d-flex justify-content-center pt-3 pb-4">
                            <!-- Purchases Button -->
                            <a href="Buyer_profile_favorites.php" 
                               class="btn btn-light d-flex align-items-center px-4 py-3 bg-white" 
                               style="border-radius: 12px; width: 350px; ">
                               <i class="fas fa-heart me-4"></i>
                                <span class="text-start">Favorites</span>
                            </a>
                        </div>

                    
   
                    <!-- Other Menu Items -->
                    <div class="hov d-flex justify-content-center">
                        <!-- Purchases Button -->
                        <a href="Buyer_profile_purchase.php" 
                           class="btn btn-light d-flex align-items-center px-4 py-3 bg-white" 
                           style="border-radius: 12px; width: 350px; ">
                            <i class="fas fa-shopping-cart me-4"></i>
                            <span class="text-start">Purchases</span>
                        </a>
                    </div>
                    <div class="pb-4"></div>
                    <div class="hov d-flex justify-content-center">
                        <!-- Rating Button -->
                        <a href="Buyer_profile_rating.php" 
                           class="btn btn-light d-flex align-items-center px-4 py-3 bg-white" 
                           style="border-radius: 12px; width: 350px;">
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
                <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none position-fixed top-0 start-50 translate-middle-x mt-3 w-50 text-center" role="alert" style="z-index: 1050;">
                    Updating information successfully!
                </div>


                <script>
                    function showSuccessAlert() {
                        const alert = document.getElementById('success-alert');
                        alert.classList.remove('d-none'); // Show the alert
                        setTimeout(() => {
                            alert.classList.add('d-none'); // Hide the alert after 1 second
                        }, 1000);
                    }
                </script>


                    <form method="POST" enctype="multipart/form-data">
                    <div class="profiles-picture-container">
                        <img src="img/photo_edit.png" alt="Profile Picture" id="profile-pic"
                            onclick="document.getElementById('file-input').click();" style="cursor: pointer;">
                        <input type="file" id="file-input" name="file" accept="image/*" style="display: none;" onchange="previewImage(event)">
                    </div>

                
            
                            
                        <div class="row">
                            <div class="col mb-4">
                                <input type="text" name="first_name" class="form-control-lg w-100 transparent-border" id="first_name" placeholder="First Name">
                            </div>
                            <div class="col mb-4">
                                <input type="text" name="last_name" class="form-control-lg w-100 transparent-border" id="last_name" placeholder="Last Name" >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-4">
                                <input type="text" name="age" class="form-control-lg w-100 transparent-border" id="age" placeholder="Age">
                            </div>
                            <div class="col mb-4">
                                <input type="text" name="birthdate" class="form-control-lg w-100 transparent-border" id="birthdate" placeholder="Birthdate (e.g., March 21, 1977)">
                            </div>
                        </div>

                        <div class="mb-4 w-100">
                            <input type="text" name="address" class="form-control-lg w-100 transparent-border" id="address" placeholder="Address">
                        </div>

                        <div class="mb-4 w-100">
                            <input type="email" name="email" class="form-control-lg w-100 transparent-border" id="email" placeholder="Email" >
                        </div>

                        <div class="mb-3">
                            <input type="text" name="phone_num" class="form-control-lg w-100 transparent-border" id="phone_num" placeholder="Contact Number">
                        </div>

                        <div class="d-flex justify-content-end pt-1">
                            <button type="submit" name="submit" class="btn btn-primary w-25 rounded-pill">Save</button>
                        </div>
                    </form>
                    
    
                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->

    <script src="js/main.js"></script>

</body>
</html>
