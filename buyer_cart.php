<?php
session_start();
include 'database/db_connection.php'; // Replace with your DB connection script

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/buyer_cart.css">

</head>

<body>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button class="back-btn" onclick="window.location.href='Buyer_index.php'">
                <i class="fas fa-arrow-left"></i> Back
            </button>
        </div>

        <div>
            <input class="form-control mb-3" type="text" value="My Cart" aria-label="Disabled input example" disabled readonly
                style="background-color: white; color: black; border-radius: 8px; border: 2px solid #E95F5D; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
        </div>

        <!-- Cart Items and Summary -->
        <div class="d-flex flex-wrap justify-content-between align-items-start cart-container" style="border: 2px solid #E95F5D; border-radius: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <!-- Cart Items -->
            <div class="cart-container w-100 d-flex flex-column justify-content-between">
                <?php if (!empty($cart)): ?>
                    <?php foreach ($cart as $id => $item): ?>
                        <div class="cart-item d-flex align-items-center justify-content-between" data-id="<?php echo $id; ?>">
                            <!-- Image from cart -->
                            <img src="data:image/jpeg;base64,<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-fluid" style="max-width: 120px;">
                            <div class="d-flex flex-column flex-grow-1 mx-3">
                                <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                                <span class="cart-item-price">Php <?php echo number_format($item['price'], 2); ?></span>
                                <div class="cart-item-quantity">
                                    <button onclick="decreaseQuantity(this)">-</button>
                                    <span class="quantity"><?php echo $item['quantity']; ?></span>
                                    <button onclick="increaseQuantity(this)">+</button>
                                </div>
                            </div>
                            <div class="cart-item-actions">
                                <input class="form-check-input custom-checkbox" type="checkbox" style="width: 25px; height: 25px;">
                                <!-- Delete Button with Icon -->
                                <button onclick="deleteItem(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                        <?php $total += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Your cart is empty.</p>
                <?php endif; ?>

                <!-- Bottom Summary and Checkout -->
                <?php if (!empty($cart)): ?>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <h5>Total Amount:</h5>
                            <span class="cart-item-price cart-item-price-total">Php <?php echo number_format($total, 2); ?></span>
                        </div>
                        <div>
                            <button class="btn btn-warning" onclick="proceedToCheckout()" style="border-radius: 15px;">Checkout</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <script>
        // Function to increase quantity
        function increaseQuantity(button) {
            const quantityElement = button.parentElement.querySelector('.quantity');
            let currentQuantity = parseInt(quantityElement.textContent);
            quantityElement.textContent = currentQuantity + 1;

            // Update the session and total price
            updateCartQuantity(button.closest('.cart-item').getAttribute('data-id'), currentQuantity + 1);
            updateTotal();
        }

        // Function to decrease quantity
        function decreaseQuantity(button) {
            const quantityElement = button.parentElement.querySelector('.quantity');
            let currentQuantity = parseInt(quantityElement.textContent);
            if (currentQuantity > 1) {
                quantityElement.textContent = currentQuantity - 1;
            }

            // Update the session and total price
            updateCartQuantity(button.closest('.cart-item').getAttribute('data-id'), currentQuantity - 1);
            updateTotal();
        }

        // Update the cart session with the new quantity
        function updateCartQuantity(productId, newQuantity) {
            fetch('update_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: newQuantity
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the displayed total
                        document.querySelector('.cart-item-price-total').textContent = 'Php ' + data.newTotal.toFixed(2);
                    } else {
                        alert('Failed to update cart.');
                    }
                })
                .catch((error) => console.error('Error:', error));
        }



        // Function to delete cart item
        function deleteItem(button) {
            const cartItem = button.closest('.cart-item');
            const productId = cartItem.getAttribute('data-id'); // Retrieve the product ID from the data-id attribute

            // Send a request to remove the item from the server-side session
            fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Remove the item from the cart visually
                        cartItem.remove();

                        // Update total price after deletion
                        updateTotal();
                    } else {
                        alert(data.message || 'Failed to remove item from cart.');
                    }
                })
                .catch((error) => console.error('Error:', error));
        }

        // Get selected items for checkout
        function getSelectedItems() {
            let selectedItems = [];

            // Loop through each checkbox and check if it's selected
            document.querySelectorAll('.cart-item .form-check-input:checked').forEach(function(checkbox) {
                const cartItem = checkbox.closest('.cart-item');
                const productId = cartItem.getAttribute('data-id'); // Get the product ID from the cart item
                selectedItems.push(productId);
            });

            return selectedItems;
        }

        // When proceeding to checkout, store selected items in session and navigate
        function proceedToCheckout() {
            const selectedItems = getSelectedItems();

            // Send selected items to the server via a session variable or via a request
            fetch('set_selected_items.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        selectedItems: selectedItems
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Redirect to the checkout page (buyer_place_order.php)
                        window.location.href = 'buyer_place_order.php';
                    } else {
                        alert(data.message || 'Failed to proceed to checkout.');
                    }
                })
                .catch((error) => console.error('Error:', error));
        }

        // Function to update the total amount in the cart
        function updateTotal() {
            let total = 0;

            // Loop through each cart item to calculate total
            document.querySelectorAll('.cart-item').forEach(function(item) {
                const price = parseFloat(item.querySelector('.cart-item-price').textContent.replace('Php ', '').replace(',', ''));
                const quantity = parseInt(item.querySelector('.quantity').textContent);
                total += price * quantity;
            });

            // Update the total amount display
            document.querySelector('.cart-item-price-total').textContent = 'Php ' + total.toFixed(2);
        }
    </script>

    <!-- External Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>