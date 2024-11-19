<?php
// Include database connection
include 'database/db_connection.php'; // Replace with the actual path to your connection script

// Initialize variables for form handling
$email = $password = "";
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Do additional sanitization if needed

    // Validate user credentials
    $sql = "SELECT * FROM users WHERE email = ?"; // Adjust table and column names as per your database
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password (if hashed in the database)
        if (password_verify($password, $user['password'])) {
            // Redirect to dashboard or home page
            header("Location: Buyer_index.html");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with this email.";
    }
}
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
<body>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 shadow-lg rounded-4 overflow-hidden" style="max-width: 900px;">
        <!-- Left Column with Image -->
        <div class="col-md-5 p-0 d-none d-md-block">
            <div class="h-100 bg-image" style="background-image: url('img/bcd.png'); background-size: cover; background-position: center;"></div>
        </div>

        <!-- Right Column with Form -->
        <div class="col-md-7 p-4 bg-white">
            <div class="text-center mb-4">
                <img src="img/logo.png" alt="FoodSaver Logo" class="mb-3" style="width: 100px;">
                <h2 class="fw-bold">Welcome Back!</h2>
            </div>
            <form method="POST" action="" class="d-flex flex-column align-items-center" style="width: 75%; margin: auto;">
                <!-- Display Error Message -->
                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger w-100 text-center" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <!-- Email Input -->
                <div class="mb-3 w-100">
                    <input type="email" name="email" class="form-control border-danger" id="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <!-- Password Input -->
                <div class="mb-3 w-100">
                    <input type="password" name="password" class="form-control border-danger" id="password" placeholder="Password" required>
                </div>
                <!-- Login Button -->
                <button type="submit" class="btn btn-primary mb-5 w-25 rounded-pill">Login</button>
                <!-- Forgot Password -->
                <div class="mb-4">
                    <a href="#" class="text-decoration-underline text-gray">Forgot password?</a>
                </div>
                <!-- Sign Up Link -->
                <div class="text-center">
                    <span>Don't have an account? <a href="signup.php" class="text-decoration-none fw-bold">Sign Up</a></span>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
