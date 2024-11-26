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

    <style>
        body {
            background-color: #ffe6e2;
            font-family: 'Heebo', sans-serif;
        }

        .cart-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            margin-right: 10px;
        }

        .cart-item-content {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-item-title {
            font-size: 16px;
            font-weight: 600;
        }

        .cart-item-price {
            color: #ff6b6b;
            font-weight: bold;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
        }

        .cart-item-quantity input {
            width: 40px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .summary-container {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 20px;
            border: 2px solid black;
        }

        .summary-container .btn {
            border-radius: 10px;
            font-weight: bold;
        }

        .summary-container .total {
            font-size: 20px;
            font-weight: bold;
        }

        .row-gutter {
            gap: 20px;
        }

        .custom-checkbox {
            border: 10px solid black !important; /* Black border with higher thickness */
            border-radius: 5px; /* Optional: rounded corners */
            appearance: none; /* Remove default checkbox style */
         }

         /* When the checkbox is checked */
        .custom-checkbox:checked {
            background-color: black; /* Optional: black fill when checked */
            border-color: black; /* Ensure the border stays black */
        }
    </style>
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
            <input class="form-control" type="text" value="       My Cart" 
            aria-label="Disabled input example" disabled readonly 
            style="background-color: white; color: black; border-radius: 8px;">
        </div>

        <!-- Cart Items and Summary -->
        <div class="col-md-12 mt-4 "  style="border: 2px solid #E95F5D; border-radius: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="cart-container d-flex justify-content-between " style="height: 575px; ">

                <!-- Cart Items Section -->
                <div class="cart-items" style="width: 350px;">
                    <div class="cart-item mb-3 w-75" style="display: flex; align-items: center; background-color: #ffeedd; border-radius: 15px; padding: 10px;">
                        <!-- Image Section -->
                        <img src="img/bicol express.jpg" alt="Macarons" style="width: 70px; height: 70px; border-radius: 50%; margin-left: 10px; margin-right: 22px; background-color: #ffebcc; ">

                        <!-- Content Section -->
                        <div style="flex-grow: 1;">
                            <div class="cart-item-title" style="font-size: 16px; font-weight: bold;">Bicol Express</div>
                            <div class="cart-item-price" style="color: #ff5555; font-weight: bold;">Php 20.00</div>
                        </div>
                    </div>

                    <div class="cart-item mb-3 w-75" style="display: flex; align-items: center; background-color: #ffeedd; border-radius: 15px; padding: 10px;">
                        <!-- Image Section -->
                        <img src="img/fried rice.jpg" alt="Macarons" style="width: 70px; height: 70px; border-radius: 50%; margin-left: 10px; margin-right: 22px; background-color: #ffebcc; ">
                    
                        <!-- Content Section -->
                        <div style="flex-grow: 1;">
                            <div class="cart-item-title" style="font-size: 16px; font-weight: bold;">Fried Rice</div>
                            <div class="cart-item-price" style="color: #ff5555; font-weight: bold;">Php 5.00</div>
                        </div>
                    </div>

                    <div class="cart-item mb-3 w-75" style="display: flex; align-items: center; background-color: #ffeedd; border-radius: 15px; padding: 10px;">
                        <!-- Image Section -->
                        <img src="img/ginataangGulay.jpg" alt="Macarons" style="width: 70px; height: 70px; border-radius: 50%; margin-left: 10px; margin-right: 22px; background-color: #ffebcc; ">

                        <!-- Content Section -->
                        <div style="flex-grow: 1;">
                            <div class="cart-item-title" style="font-size: 16px; font-weight: bold;">Ginataang Gulay</div>
                            <div class="cart-item-price" style="color: #ff5555; font-weight: bold;">Php 10.00</div>
                        </div>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="summary-container ms-3 h-100" style="width: 375px;   max-width: 100%; margin-right: 1.5rem;">
                    <div>
                        <input class="form-control" type="text" value="Total Product" 
                        aria-label="Disabled input example" disabled readonly 
                        style="background-color: white; color: black; text-align: center; border-radius: 25px; border: 3.5px solid #ffeedd;">
                    </div>
                    <div class="d-flex justify-content-between mt-5 mb-3">
                        <span>Subtotal</span>
                        <span>Php 000.00</span>
                    </div>

                    <div class="row mt-4">
                        <span>Delivery Option:</span>
                        <div class="col mb-4" style="max-width: 100%">
                            <button 
                                class="btn mt-2 shipping-method" 
                                style="background-color: #FFECC8; color: black; border-radius: 25px; width: 153.5px; max-width: 100%;" 
                                onclick="toggleActive(this)">
                                Online Payment
                            </button>
                        </div>
                        <div class="col mb-4">
                            <button 
                                class="btn mt-2 shipping-method" 
                                style="background-color: #FFECC8; color: black; border-radius: 25px; width: 153.5px; max-width: 100%;" 
                                data-bs-toggle="modal" 
                                data-bs-target="#codModal">
                                Cash on Delivery
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 pb-4"></div>

                    <div class="d-flex justify-content-between pt-4 mt-5 mb-4">
                        <span>Shipping Fee</span>
                        <span>Php 000.00</span>
                    </div>
                    <div>
                        <input class="form-control mb-2" type="text" value="Total Product                                Php 000.00 " 
                        aria-label="Disabled input example" disabled readonly 
                        style="background-color: #ffeedd; color: black; border-radius: 25px; border: 3.5px solid #ffeedd;">
                    </div>

                    <!-- Place Order Button -->
                    <button class="btn  w-100 mt-1" onclick="window.location.href='buyer_place_order_summary.php'" style="border-radius: 25px; background-color: #ff6b6b; color: white;">Place Order</button>
                </div>
            </div>

            <!-- Cash on Delivery Modal with Address Form -->
            <div class="modal fade" id="codModal" tabindex="-1" aria-labelledby="codModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="border-radius: 12px; border: 2px solid #E95F5D;">
                        <div class="modal-header" style="background-color: #FFD09B; color: black; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                            <h5 class="modal-title" id="codModalLabel" style="font-family: 'Nunito', sans-serif; font-weight: 700;">Enter Your Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: black;"></button>
                        </div>
                        <div class="modal-body" style="background-color: #FFD09B; padding: 20px;">
                            <form>
                                <div class="mb-3">
                                    <label for="city" class="form-label" style="font-family: 'Heebo', sans-serif;">City/Municipality</label>
                                    <input type="text" class="form-control" id="city" placeholder="Enter City or Municipality" style="border-radius: 10px; border: 1px solid #E95F5D; font-family: 'Heebo', sans-serif; background-color: white; color: black;">
                                </div>
                                <div class="mb-3">
                                    <label for="barangay" class="form-label" style="font-family: 'Heebo', sans-serif;">Barangay</label>
                                    <input type="text" class="form-control" id="barangay" placeholder="Enter Barangay" style="border-radius: 10px; border: 1px solid #E95F5D; font-family: 'Heebo', sans-serif; background-color: white; color: black;">
                                </div>
                                <div class="mb-3">
                                    <label for="street" class="form-label" style="font-family: 'Heebo', sans-serif;">Street</label>
                                    <input type="text" class="form-control" id="street" placeholder="Enter Street" style="border-radius: 10px; border: 1px solid #E95F5D; font-family: 'Heebo', sans-serif; background-color: white; color: black;">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer" style="background-color: #FFD09B; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                            <button type="button" class="btn btn-primary" onclick="saveAddress()" style="border-radius: 10px; font-family: 'Nunito', sans-serif; background-color: #E95F5D; color: white;">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        function saveAddress() {
            // Simply save the address and redirect to order summary without any notifications
            window.location.href = 'buyer_place_order_summary.php';
        }
    </script>
</body>
</html>
