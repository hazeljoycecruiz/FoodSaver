<?php
require_once 'database/db_connection.php';

// Initialize message variables
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? ''; // Add confirm password validation
    $role = $_POST['role'] ?? 'buyer';

    // Check if passwords match
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Check if the email already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists
            $message = "Email already exists. Please choose a different email.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            try {
                // Insert new user into the database
                $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

                // Execute the statement
                if ($stmt->execute()) {
                    // Successful registration
                    $message = "User registered successfully! You will be redirected to the login page.";
                    // Redirect after 3 seconds
                    echo '<meta http-equiv="refresh" content="1;url=index_login.php">';
                } else {
                    $message = "Error: " . $stmt->error;
                }

                $stmt->close();
            } catch (Exception $e) {
                $message = "Error: " . $e->getMessage();
            }
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
    <title>FoodSaver - Signup</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <!-- Password validation JavaScript -->
    <script>
        // Password validation function
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var errorMessage = document.getElementById("password_error");

            // Password validation pattern
            var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;

            if (!password.match(passwordRegex)) {
                errorMessage.innerHTML = "Password must be at least 6 characters long, contain at least one uppercase letter, one number, and one special character.";
                document.getElementById("password").classList.add("is-invalid");
                return false;
            } else if (password !== confirmPassword) {
                errorMessage.innerHTML = "Passwords do not match!";
                document.getElementById("confirm_password").classList.add("is-invalid");
                return false;
            } else {
                errorMessage.innerHTML = "";
                document.getElementById("password").classList.remove("is-invalid");
                document.getElementById("confirm_password").classList.remove("is-invalid");
                return true;
            }
        }
    </script>
</head>

<body class="login">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 shadow-lg rounded-4 overflow-hidden" style="max-width: 900px;">
            
            <!-- Left side image -->
            <div class="col-md-5 p-0 d-none d-md-block border-red">
                <div class="h-100 bg-image" style="background-image: url('img/bcd.png'); background-size: cover; background-position: center;"></div>
            </div>

            <!-- Right side form -->
            <div class="col-md-7 p-4 bg-white border-red border-3">
                <div class="text-center mb-4">
                    <img src="img/logo.png" alt="FoodSaver Logo" class="mb-3" style="width: 100px;">
                    <h2 class="fw-bold">Create an Account</h2>
                </div>

                <!-- Display message (error or success) -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-info w-100 text-center">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <form class="d-flex flex-column align-items-center" style="width: 75%; margin: auto;" method="POST" action="" onsubmit="return validatePassword()">
                    <!-- Username Input -->
                    <div class="mb-3 w-100">
                        <input type="text" name="username" class="form-control border-danger" placeholder="Enter Username" required>
                    </div>

                    <!-- Email Input -->
                    <div class="mb-3 w-100">
                        <input type="email" name="email" class="form-control border-danger" placeholder="Enter Email" required>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3 w-100">
                        <input type="password" id="password" name="password" class="form-control border-danger" placeholder="Password" required>
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="mb-3 w-100">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control border-danger" placeholder="Confirm Password" required>
                    </div>

                    <!-- Error message for password validation -->
                    <div id="password_error" class="text-danger mb-3"></div>

                    <!-- Role Selection -->
                    <div class="d-flex justify-content-center form-group mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role" value="Buyer" id="buyer" required>
                            <label class="form-check-label" for="buyer">Buyer</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role" value="Seller" id="seller" required>
                            <label class="form-check-label" for="seller">Seller</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="role" value="Admin" id="admin" required>
                            <label class="form-check-label" for="admin">Admin</label>
                        </div>
                    </div>

                    <!-- Sign Up Link -->
                    <div class="text-center">
                        <span>Do you have an account? 
                            <a href="index_login.php" class="text-decoration-none fw-bold">Log In</a>
                        </span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-3 w-25 rounded-pill">Signup</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
