<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Bhaktimay</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        
        <!-- Main Item Section -->
        <div class="main-item">
            <img src="images/main-item.jpg" alt="Main Item" class="main-item-image">
            <h2>Main Item Name (₹<span id="main-item-price">1</span>)</h2>
        </div>

        <!-- Add-ons Section -->
        <div class="add-ons">
            <h3>Add-ons</h3>
            <div class="add-ons-container">
                <?php
                // Sample add-ons data - In production, fetch from database
                $addons = [
                    ['id' => 1, 'name' => 'Add-on 1', 'price' => 100, 'image' => 'addon1.jpg'],
                    ['id' => 2, 'name' => 'Add-on 2', 'price' => 200, 'image' => 'addon2.jpg'],
                    ['id' => 3, 'name' => 'Add-on 3', 'price' => 150, 'image' => 'addon3.jpg'],
                    ['id' => 4, 'name' => 'Add-on 4', 'price' => 300, 'image' => 'addon4.jpg'],
                    ['id' => 5, 'name' => 'Add-on 5', 'price' => 250, 'image' => 'addon5.jpg']
                ];

                foreach ($addons as $addon) {
                    echo '<div class="add-on-item">
                            <img src="images/' . $addon['image'] . '" alt="' . $addon['name'] . '">
                            <p>' . $addon['name'] . ' (₹' . $addon['price'] . ')</p>
                            <div class="quantity-control">
                                <button class="minus-btn" data-id="' . $addon['id'] . '">-</button>
                                <input type="number" class="quantity" value="0" min="0" data-id="' . $addon['id'] . '" data-price="' . $addon['price'] . '">
                                <button class="plus-btn" data-id="' . $addon['id'] . '">+</button>
                            </div>
                          </div>';
                }
                ?>
            </div>
        </div>

        <!-- Custom Amount Section -->
        <div class="custom-amount">
            <h3>Custom Amount</h3>
            <input type="number" id="custom-amount" placeholder="Enter custom amount" min="0">
        </div>

        <!-- Customer Details Form -->
        <form id="checkout-form">
            <div class="form-group">
                <input type="text" id="name" name="name" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="text" id="gotra" name="gotra" placeholder="Gotra" required>
            </div>
            <div class="form-group">
                <input type="tel" id="mobile" name="mobile" placeholder="Mobile Number" required>
            </div>
            <div class="form-group">
                <input type="text" id="address1" name="address1" placeholder="Address Line 1" required>
            </div>
            <div class="form-group">
                <input type="text" id="address2" name="address2" placeholder="Address Line 2" required>
            </div>
            <div class="form-group">
                <input type="text" id="pincode" name="pincode" placeholder="PIN Code" required>
            </div>
        </form>

        <!-- Total Amount Section -->
        <div class="total-amount">
            <h3>Total Amount: ₹<span id="total-amount">1000</span></h3>
        </div>

        <!-- Checkout Button -->
        <button id="checkout-btn" class="checkout-btn">Proceed to Payment</button>
    </div>

    <script src="script.js"></script>
</body>
</html>
