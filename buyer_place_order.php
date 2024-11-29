<?php 
session_start();
include 'database/db_connection.php';

// Retrieve selected items from session
$selectedItems = isset($_SESSION['selected_items']) ? $_SESSION['selected_items'] : [];

$subtotal = 0; // Initialize subtotal

if (!empty($selectedItems)) {
    $selectedItemsQuery = implode(',', array_map('intval', $selectedItems)); // Sanitize IDs
    $query = "SELECT * FROM products WHERE product_id IN ($selectedItemsQuery)";
    $result = mysqli_query($conn, $query);
    $cartItems = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Calculate subtotal
    foreach ($cartItems as &$item) {
        // Fetch quantity from the session for the current product
        $productId = $item['product_id'];
        $quantity = isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId]['quantity'] : 1; // Default to 1 if not found
        $item['quantity'] = $quantity; // Update the item with the quantity
        $subtotal += $item['price'] * $quantity; // Add the price * quantity to the subtotal
    }
}

// Example fixed shipping fee, can be dynamic based on delivery method
$shippingFee = 50;

// Calculate total (subtotal + shipping fee)
$total = $subtotal + $shippingFee;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/buyer_place_order.css">
</head>

<body>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="back-btn" onclick="window.location.href='buyer_cart.php'">
                <i class="fas fa-arrow-left"></i> Back
            </button>
        </div>
        <div style="border: 2px solid #E95F5D; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <input class="form-control" type="text" value="My Cart" aria-label="Disabled input example" disabled readonly style="background-color: white; color: black; border-radius: 8px;">
        </div>

        <!-- Cart Items and Summary -->
        <div class="col-md-12 mt-4" style="border: 2px solid #E95F5D; border-radius: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="cart-container d-flex justify-content-between" style="height: 575px;">

                <!-- Cart Items Section -->
                <div class="cart-items" style="width: 350px;">
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <div class="cart-item mb-3 w-75" style="display: flex; align-items: center; background-color: #ffeedd; border-radius: 15px; padding: 10px;">
                                <img src="data:image/jpeg;base64,<?php echo isset($item['product_image']) ? base64_encode($item['product_image']) : ''; ?>"
                                    alt="<?php echo isset($item['product_name']) ? htmlspecialchars($item['product_name']) : 'No name'; ?>"
                                    style="width: 70px; height: 70px; border-radius: 50%; margin-left: 10px; margin-right: 22px; background-color: #ffebcc;">

                                <div style="flex-grow: 1;">
                                    <div class="cart-item-title" style="font-size: 16px; font-weight: bold;">
                                        <?php echo isset($item['product_name']) ? htmlspecialchars($item['product_name']) : 'No name'; ?>
                                    </div>
                                    <div class="cart-item-price" style="color: #ff5555; font-weight: bold;">
                                        Php <?php echo isset($item['price']) ? number_format($item['price'], 2) : '0.00'; ?>
                                    </div>
                                    <!-- Display Quantity -->
                                    <div class="cart-item-quantity mt-1" style="font-size: 14px; color: #555;">
                                        Quantity: <?php echo isset($item['quantity']) ? htmlspecialchars($item['quantity']) : '1'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No items selected for checkout.</p>
                    <?php endif; ?>
                </div>

                <!-- Summary Section -->
                <div class="summary-container ms-3 h-100" style="width: 375px; max-width: 100%; margin-right: 1.5rem;">
                    <div>
                        <input class="form-control" type="text" value="Total Product" aria-label="Disabled input example" disabled readonly style="background-color: white; color: black; text-align: center; border-radius: 25px; border: 3.5px solid #ffeedd;">
                    </div>
                    <div class="d-flex justify-content-between mt-5 mb-3">
                        <span>Subtotal</span>
                        <span>Php <?php echo number_format($subtotal, 2); ?></span>
                    </div>

                    <div class="row mt-4">
                        <span>Delivery Option:</span>
                        <div class="col mb-4" style="max-width: 100%">
                            <button class="btn mt-2 shipping-method" style="background-color: #FFECC8; color: black; border-radius: 25px; width: 153.5px; max-width: 100%;" onclick="toggleActive(this)">
                                Online Payment
                            </button>
                        </div>
                        <div class="col mb-4">
                            <button class="btn mt-2 shipping-method" style="background-color: #FFECC8; color: black; border-radius: 25px; width: 153.5px; max-width: 100%;" data-bs-toggle="modal" data-bs-target="#codModal">
                                Cash on Delivery
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 pb-4"></div>

                    <div class="d-flex justify-content-between pt-4 mt-5 mb-4">
                        <span>Shipping Fee</span>
                        <span>Php <?php echo number_format($shippingFee, 2); ?></span>
                    </div>
                    <div>
                        <input class="form-control mb-2" type="text" value="Total Product Php <?php echo number_format($total, 2); ?>" aria-label="Disabled input example" disabled readonly style="background-color: #ffeedd; color: black; border-radius: 25px; border: 3.5px solid #ffeedd;">
                    </div>

                    <!-- Place Order Button -->
                    <button class="btn w-100 mt-1" onclick="window.location.href='buyer_place_order_summary.php'" style="border-radius: 25px; background-color: #E95F5D; color: white;">Place Order</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
