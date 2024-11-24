<?php
// Include database connection
include 'database/db_connection.php'; // Update path if needed

// Initialize variables for form handling
$email = $password = $error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Check if password field is set and sanitize further if needed
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $error = "Password is required.";
    }

    // Validate user credentials if no error
    if (empty($error)) {
        $sql = "SELECT * FROM users WHERE email = ?";  // Make sure to replace with your actual table and column names
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Correctly reference 'password_hash' instead of 'password'
            if (password_verify($password, $user['password_hash'])) {
                // Check the user's role and redirect accordingly
                $role = $user['role'];  // Assuming the role is stored in the 'role' column of your 'users' table
                
                if ($role === 'Buyer') {
                    header("Location: Buyer_index.html");
                } elseif ($role === 'Seller') {
                    header("Location: Seller_index.html");
                } elseif ($role === 'Admin') {
                    header("Location: Admin_index.html");
                } else {
                    $error = "Invalid role.";
                }
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No account found with this email.";
        }
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodSaver - Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 shadow-lg rounded-4 overflow-hidden" style="max-width: 900px;">
            
            <!-- Left Column with Image -->
            <div class="col-md-5 p-0 d-none d-md-block">
                <div class="h-100 bg-image" style="background-image: url('img/bcd.png'); background-size: cover; background-position: center;">
                </div>
            </div>

            <!-- Right Column with Form -->
            <div class="col-md-7 p-4 bg-white border-red border-3">
                <div class="text-center mb-4">
                    <img src="img/logo.png" alt="FoodSaver Logo" class="mb-3" style="width: 100px;">
                    <h2 class="fw-bold">Welcome Back!</h2>
                </div>

                <!-- Display Error Message -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger w-100 text-center">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST" class="d-flex flex-column align-items-center" style="width: 75%; margin: auto;">
                    <!-- Email Input -->
                    <div class="mb-3 w-100">
                        <input type="email" 
                               class="form-control border-danger" 
                               id="email" name="email" 
                               placeholder="Email" 
                               value="<?= htmlspecialchars($email) ?>" required>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3 w-100">
                        <input type="password" 
                               class="form-control border-danger" 
                               id="password" name="password" 
                               placeholder="Password" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mb-5 w-25 rounded-pill">Login</button>

                    <!-- Forgot Password Link -->
                    <div class="mb-4">
                        <a href="#" class="text-decoration-underline text-gray">Forgot password?</a>
                    </div>

                    <!-- Sign Up Link -->
                    <div class="text-center">
                        <span>Don't have an account? 
                            <a href="index_signup.php" class="text-decoration-none fw-bold">Sign Up</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
