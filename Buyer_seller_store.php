<?php
// Database connection
require_once 'database/db_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize the user_id (UUID format)
$user_id = isset($_GET['id']) ? $_GET['id'] : '';  // Use 'id' parameter from the URL
if (empty($user_id)) {
    die("Invalid User ID.");
}

// Check if the user_id exists in the database
$user_check_query = $conn->prepare(
    "SELECT user_id FROM users WHERE user_id = ?"
);
$user_check_query->bind_param("s", $user_id);
$user_check_query->execute();
$user_check_result = $user_check_query->get_result();

// Check user validity
if ($user_check_result->num_rows === 0) {
    die("Invalid User ID: User not found in the database.");
}

// Fetch seller details
$seller_query = $conn->prepare(
    "SELECT bussiness_name, bussiness_type, email, phone_num, address 
     FROM users 
     WHERE user_id = ? AND role_id = 1"
);
$seller_query->bind_param("s", $user_id);
$seller_query->execute();
$seller_result = $seller_query->get_result();

if ($seller_result->num_rows === 0) {
    die("Seller not found for user_id: " . htmlspecialchars($user_id));
}

$seller = $seller_result->fetch_assoc();

// Fetch seller's products
$product_query = $conn->prepare(
    "SELECT product_id, product_name, description, price, stock_quantity, product_image 
     FROM products 
     WHERE user_id = ?"
);
$product_query->bind_param("s", $user_id);
$product_query->execute();
$product_result = $product_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($seller['bussiness_name']); ?> - Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;600&family=Nunito:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #FFB0B0;
            padding: 15px;
            border-radius: 10px;
        }
        header img {
            border-radius: 10%;
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .profile-info {
            color: #444;
        }
        .profile-info h1 {
            font-size: 24px;
            margin: 0;
        }
        .profile-info p {
            margin: 5px 0;
        }
        /* New Bar Styles */
        .navbar {
            display: flex;
            justify-content: center;
            background-color: #FFD09B;
            margin-top: 20px;
            border-radius: 8px;
        }
        .navbar a {
            text-decoration: none;
            color: #333;
            padding: 12px 25px;
            font-weight: bold;
            text-transform: uppercase;
            border-right: 1px solid #ddd;
        }
        .navbar a:last-child {
            border-right: none;
        }
        .navbar a:hover {
            background-color: #E95F5D;
            color: white;
        }
        /* Follow button styles */
        .follow-btn {
            background-color: #E95F5D;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            text-transform: uppercase;
        }
        .follow-btn:hover {
            background-color: #FFB0B0;
        }
        .vouchers, .products {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .voucher-card, .product-card {
            background: #FFD09B;
            padding: 20px;
            border-radius: 8px;
            width: 30%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .voucher-card {
            background-color: #FFB0B0;
        }
        .voucher-card p {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .voucher-card a {
            text-decoration: none;
            color: white;
            padding: 10px;
            background-color: #E95F5D;
            border-radius: 5px;
        }
        .product-card img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .product-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .product-card p {
            font-size: 14px;
        }
        .product-card button {
            background-color: #FFB0B0;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .product-card button:hover {
            background-color: #E95F5D;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        .product-grid .product-card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="img/store.jpg" alt="Seller Profile Image">
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($seller['bussiness_name']); ?></h1>
            </div>
            <!-- Follow Button -->
            <div>
                <button class="follow-btn">+ Follow</button>
            </div>
        </header>

        <!-- Navbar Section -->
        <div class="navbar">
            <a href="#about">About</a>
            <a href="#products">Products</a>
            <a href="#reviews">Reviews</a>
        </div>

        <!-- About Section -->
        <div id="about" style="margin-top: 50px;">
            <h2>About Us</h2>
            <p><strong>Business Name:</strong> <?php echo htmlspecialchars($seller['bussiness_name']); ?></p>
            <p><strong>Type of Business:</strong> <?php echo htmlspecialchars($seller['bussiness_type']); ?></p>
            <p><strong>Contact Email:</strong> <?php echo htmlspecialchars($seller['email']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($seller['phone_num']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($seller['address']); ?></p>
        </div>

        <h2 id="products">Recommended Products</h2>
        <div class="product-grid">
            <?php if ($product_result->num_rows > 0): ?>
                <?php while ($product = $product_result->fetch_assoc()): ?>
                    <div class="product-card">
                        <?php if ($product['product_image']): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['product_image']); ?>" alt="Product Image">
                        <?php else: ?>
                            <img src="default-image.jpg" alt="Product Image"> <!-- Fallback image -->
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p>₱<?php echo number_format($product['price'], 2); ?></p>
                        <button>Add to Cart</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
        </div>

        <!-- Reviews Section -->
        <div id="reviews" style="margin-top: 50px;">
            <h2>Customer Reviews</h2>
            <!-- Add review content here -->
        </div>
    </div>
</body>
</html>

<?php
// Close database connections
$seller_query->close();
$product_query->close();
$user_check_query->close();
$conn->close();
?>
