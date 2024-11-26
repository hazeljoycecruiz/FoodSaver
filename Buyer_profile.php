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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prevent duplicate updates using a session flag
    if (!isset($_SESSION['update_submitted'])) {
        // Get form data
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $birthdate = $_POST['birthdate'];
        $phone_num = $_POST['phone_num'];
        $address = $_POST['address'];
        $user_image = NULL;

        // Handle image upload
        if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
            // Validate the uploaded file
            $fileType = mime_content_type($_FILES['user_image']['tmp_name']);
            if (strpos($fileType, 'image/') === 0) {
                $user_image = file_get_contents($_FILES['user_image']['tmp_name']);
            } else {
                echo "Invalid file type. Please upload an image.";
                exit();
            }
        }

        // Prepare the SQL query for updating user details
        if ($user_image) {
            $sql = "UPDATE users 
                    SET first_name = ?, 
                        last_name = ?, 
                        email = ?, 
                        age = ?, 
                        birthdate = ?, 
                        phone_num = ?, 
                        address = ?, 
                        user_image = ? 
                    WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssi", $first_name, $last_name, $email, $age, $birthdate, $phone_num, $address, $user_image, $user_id);
        } else {
            $sql = "UPDATE users 
                    SET first_name = ?, 
                        last_name = ?, 
                        email = ?, 
                        age = ?, 
                        birthdate = ?, 
                        phone_num = ?, 
                        address = ? 
                    WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $first_name, $last_name, $email, $age, $birthdate, $phone_num, $address, $user_id);
        }

        // Execute the statement
        if ($stmt->execute()) {
            // Set session flag to prevent duplicate updates
            $_SESSION['update_submitted'] = true;

            // Redirect after success
            header("Location: Buyer_profile.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Clear the flag and redirect
        unset($_SESSION['update_submitted']);
        header("Location: Buyer_profile.php");
        exit();
    }
}

// Fetch the user's image from the database securely
try {
    $sql = "SELECT user_image FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['user_image']) {
            $profileImage = 'data:image/jpeg;base64,' . base64_encode($row['user_image']);
        } else {
            $profileImage = 'img/photo_edit.png'; // Default image
        }
    } else {
        $profileImage = 'img/photo_edit.png'; // Default image if user not found
    }
    $stmt->close();
} catch (Exception $e) {
    echo "Error fetching user image: " . $e->getMessage();
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

echo "Saved successfully!";
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
                <button class="back-btn" onclick="window.location.href='Buyer_index.html'">
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
                    <input type="file" id="file-input" accept="image/*" style="display: none;" onchange="previewImage(event)">
                </div>

                    <a href="Buyer_profile.php" class="pb-4 name" style=";text-decoration: none; "><h5> <?php echo htmlspecialchars($first_name); ?></h5> 
                        </a>
                        <!-- Display error message if it exists -->
                        <?php if (!empty($error)) { echo "<p>Error: $error</p>"; } ?>


                         <!-- Other Menu Items -->
                         <div class="hov d-flex justify-content-center pt-3 pb-4">
                            <!-- Purchases Button -->
                            <a href="Buyer_profile_favorites.html" 
                               class="btn btn-light d-flex align-items-center px-4 py-3 bg-white" 
                               style="border-radius: 12px; width: 350px; ">
                               <i class="fas fa-heart me-4"></i>
                                <span class="text-start">Favorites</span>
                            </a>
                        </div>

                    
   
                    <!-- Other Menu Items -->
                    <div class="hov d-flex justify-content-center">
                        <!-- Purchases Button -->
                        <a href="Buyer_profile_purchase.html" 
                           class="btn btn-light d-flex align-items-center px-4 py-3 bg-white" 
                           style="border-radius: 12px; width: 350px; ">
                            <i class="fas fa-shopping-cart me-4"></i>
                            <span class="text-start">Purchases</span>
                        </a>
                    </div>
                    <div class="pb-4"></div>
                    <div class="hov d-flex justify-content-center">
                        <!-- Rating Button -->
                        <a href="Buyer_profile_rating.html" 
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


                    <form action="Buyer_profile.php" method="POST" enctype="multipart/form-data">
                        <div class="profiles-picture-container">
                        <img src="<?= $profileImage ?>" alt="Profile Picture" id="profile-pic"
                            onclick="document.getElementById('file-input').click();" style="cursor: pointer;">
                        <input type="file" id="file-input" name="user_image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                        </div>

                        <script>
                            // Preview the selected image
                            function previewImage(event) {
                                const file = event.target.files[0]; // Get the file
                                if (file) {
                                    const reader = new FileReader(); // FileReader to read the file
                                    reader.onload = function (e) {
                                        const profilePic = document.getElementById('profile-pic');
                                        profilePic.src = e.target.result; // Set the image src to the selected file
                                    };
                                    reader.readAsDataURL(file); // Read the file as a data URL
                                }
                            }
                        </script>
                            
                        <div class="row">
                            <div class="col mb-4">
                                <input type="text" name="first_name" class="form-control-lg w-100 transparent-border" id="first_name" placeholder="First Name" required>
                            </div>
                            <div class="col mb-4">
                                <input type="text" name="last_name" class="form-control-lg w-100 transparent-border" id="last_name" placeholder="Last Name" required>
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
                            <input type="email" name="email" class="form-control-lg w-100 transparent-border" id="email" placeholder="Email" required>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
