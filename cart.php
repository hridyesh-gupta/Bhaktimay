<?php
require_once 'config.php';

// Define packages (same as in packages.php)
$packages = [
    'individual' => [
        'name' => 'Individual Package',
        'price' => 1000,
        'description' => 'Perfect for single person',
        'image' => 'addon1.jpg',
        'features' => ['1 Person', 'Basic Pooja Items', 'Standard Prasad']
    ],
    'couple' => [
        'name' => 'Couple Package',
        'price' => 2000,
        'description' => 'Ideal for couples',
        'image' => 'addon2.jpg',
        'features' => ['2 Persons', 'Premium Pooja Items', 'Special Prasad']
    ],
    'family' => [
        'name' => 'Family Package',
        'price' => 3500,
        'description' => 'Best for small families',
        'image' => 'addon3.jpg',
        'features' => ['4 Persons', 'Deluxe Pooja Items', 'Family Prasad']
    ],
    'joint_family' => [
        'name' => 'Joint Family Package',
        'price' => 5000,
        'description' => 'Perfect for large families',
        'image' => 'addon4.jpg',
        'features' => ['8 Persons', 'Premium Pooja Items', 'Large Prasad']
    ]
];

// Get selected package
$selected_package = $_GET['package'] ?? 'individual';
if (!isset($packages[$selected_package])) {
    $selected_package = 'individual';
}

// Set main item based on selected package
$main_item = [
    'name' => $packages[$selected_package]['name'],
    'price' => $packages[$selected_package]['price'],
    'image' => $packages[$selected_package]['image']
];

// Hardcoded add-ons
$addons = [
    ['id' => 1, 'name' => 'Add-on 1', 'price' => 100, 'image' => 'addon1.jpg'],
    ['id' => 2, 'name' => 'Add-on 2', 'price' => 200, 'image' => 'addon2.jpg'],
    ['id' => 3, 'name' => 'Add-on 3', 'price' => 150, 'image' => 'addon3.jpg'],
    ['id' => 4, 'name' => 'Add-on 4', 'price' => 300, 'image' => 'addon4.jpg'],
    ['id' => 5, 'name' => 'Add-on 5', 'price' => 250, 'image' => 'addon5.jpg'],
    ['id' => 6, 'name' => 'Add-on 6', 'price' => 250, 'image' => 'addon6.jpg']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Bhaktimay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: '#FF6F00', // Reddish/orange
              lightyellow: '#FFF9DB', // Light yellowish
            }
          }
        }
      }
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body class="bg-lightyellow min-h-screen">
    <?php include 'header.php'; ?>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h1 class="text-3xl font-bold text-center text-primary mb-8">Your Cart</h1>
        
        <!-- Main Item Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col items-start">
                <img src="images/<?php echo $main_item['image']; ?>" alt="Main Item" class="w-full h-auto object-contain rounded-lg mb-4" style="height: 100px">
                <h2 class="text-xl font-semibold text-gray-700">
                    <?php echo htmlspecialchars($main_item['name']); ?> (₹<span id="main-item-price"><?php echo $main_item['price']; ?></span>)
                </h2>
                <p class="text-gray-600 mt-2"><?php echo $packages[$selected_package]['description']; ?></p>
                <div class="mt-4">
                    <h3 class="font-semibold text-gray-700 mb-2">Package Features:</h3>
                    <ul class="space-y-1">
                        <?php foreach ($packages[$selected_package]['features'] as $feature): ?>
                        <li class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <?php echo $feature; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold text-primary mb-4">Add-ons</h3>
            <div class="overflow-x-auto">
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <?php foreach ($addons as $addon): ?>
                        <div class="bg-gray-50 rounded-lg p-2 sm:p-3 border border-gray-200 text-xs sm:text-sm">
                            <div class="flex justify-center mb-2">
                                <img src="images/<?php echo $addon['image']; ?>" alt="<?php echo $addon['name']; ?>" class="w-20 sm:w-24 aspect-square object-cover rounded">
                            </div>
                            <p class="font-medium text-primary mb-2 text-center text-xs sm:text-sm"><?php echo $addon['name']; ?> (₹<?php echo $addon['price']; ?>)</p>
                            <div class="flex items-center justify-center space-x-1">
                                <button class="minus-btn bg-lightyellow hover:bg-primary hover:text-white text-primary px-2 py-1 sm:px-3 sm:py-1 rounded text-xs sm:text-sm" data-id="<?php echo $addon['id']; ?>">-</button>
                                <input type="number" class="quantity w-10 sm:w-12 text-center border border-gray-300 rounded px-1 sm:px-2 py-1 text-xs sm:text-sm" value="0" min="0" data-id="<?php echo $addon['id']; ?>" data-price="<?php echo $addon['price']; ?>" data-name="<?php echo htmlspecialchars($addon['name']); ?>">
                                <button class="plus-btn bg-lightyellow hover:bg-primary hover:text-white text-primary px-2 py-1 sm:px-3 sm:py-1 rounded text-xs sm:text-sm" data-id="<?php echo $addon['id']; ?>">+</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Custom Amount Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold text-primary mb-4">Custom Amount</h3>
            <input type="number" id="custom-amount" placeholder="Enter custom amount" min="0" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
        </div>

        <!-- Customer Details Form -->
        <form id="checkout-form" class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <h3 class="text-xl font-semibold text-primary mb-4 col-span-full">Your Details</h3>
                <div class="form-group col-span-full">
                    <input type="text" id="name" name="name" placeholder="Full Name" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                <div class="form-group col-span-full">
                    <input type="text" id="gotra" name="gotra" placeholder="Gotra" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                <div class="form-group col-span-full">
                    <input type="tel" id="mobile" name="mobile" placeholder="Mobile Number" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                <div class="form-group col-span-full">
                    <input type="text" id="address1" name="address1" placeholder="Address Line 1 (Compulsory if you've ordered prasad)" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                <div class="form-group col-span-full">
                    <input type="text" id="address2" name="address2" placeholder="Address Line 2 (Compulsory if you've ordered prasad)" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                <div class="form-group col-span-full">
                    <input type="text" id="pincode" name="pincode" placeholder="PIN Code" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
            </div>
        </form>

        <!-- Total Amount Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-2xl font-bold text-center text-primary">Total Amount: ₹<span id="total-amount"><?php echo $main_item['price']; ?></span></h3>
        </div>

        <!-- Checkout Button -->
        <button id="checkout-btn" class="w-full bg-primary hover:bg-orange-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200">
            Proceed to Payment
        </button>
    </div>

    <script>
        // Expose main item and add-ons to JS
        window.MAIN_ITEM = <?php echo json_encode($main_item); ?>;
        window.ADDONS = <?php echo json_encode($addons); ?>;
        
        document.addEventListener('DOMContentLoaded', function() {
            const mainItem = window.MAIN_ITEM;
            const addons = window.ADDONS;
            const totalAmountElement = document.getElementById('total-amount');
            const customAmountInput = document.getElementById('custom-amount');
            const checkoutBtn = document.getElementById('checkout-btn');
            
            // Function to update total amount
            function updateTotalAmount() {
                let total = mainItem.price;
                
                // Add add-ons prices
                document.querySelectorAll('.quantity').forEach(input => {
                    const quantity = parseInt(input.value) || 0;
                    const price = parseInt(input.dataset.price);
                    total += quantity * price;
                });
                
                // Add custom amount
                const customAmount = parseInt(customAmountInput.value) || 0;
                total += customAmount;
                
                totalAmountElement.textContent = total;
            }
            
            // Handle quantity buttons
            document.querySelectorAll('.plus-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity');
                    input.value = parseInt(input.value) + 1;
                    updateTotalAmount();
                });
            });
            
            document.querySelectorAll('.minus-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity');
                    const currentValue = parseInt(input.value);
                    if (currentValue > 0) {
                        input.value = currentValue - 1;
                        updateTotalAmount();
                    }
                });
            });
            
            // Handle quantity input changes
            document.querySelectorAll('.quantity').forEach(input => {
                input.addEventListener('change', updateTotalAmount);
            });
            
            // Handle custom amount changes
            customAmountInput.addEventListener('input', updateTotalAmount);
            
            // Handle checkout button click
            checkoutBtn.addEventListener('click', function() {
                const form = document.getElementById('checkout-form');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                
                // Collect selected add-ons
                const selectedAddons = Array.from(document.querySelectorAll('.quantity')).map(input => ({
                    id: input.dataset.id,
                    name: input.dataset.name,
                    price: parseInt(input.dataset.price),
                    quantity: parseInt(input.value) || 0
                })).filter(addon => addon.quantity > 0);
                
                // Collect form data
                const formData = {
                    main_item_name: mainItem.name,
                    main_item_price: mainItem.price,
                    addons: selectedAddons,
                    custom_amount: parseInt(customAmountInput.value) || 0,
                    total_amount: parseInt(totalAmountElement.textContent),
                    name: document.getElementById('name').value,
                    gotra: document.getElementById('gotra').value,
                    mobile: document.getElementById('mobile').value,
                    address1: document.getElementById('address1').value,
                    address2: document.getElementById('address2').value,
                    pincode: document.getElementById('pincode').value
                };
                
                // Create Razorpay order
                fetch('process_payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const options = {
                            key: data.key_id,
                            amount: data.amount,
                            currency: "INR",
                            name: "Bhaktimay",
                            description: "Payment for your order",
                            order_id: data.order_id,
                            handler: function (response) {
                                // Store payment details in localStorage for backup
                                localStorage.setItem('lastPayment', JSON.stringify({
                                    payment_id: response.razorpay_payment_id,
                                    order_id: response.razorpay_order_id,
                                    signature: response.razorpay_signature,
                                    amount: data.amount,
                                    timestamp: new Date().toISOString()
                                }));
                                
                                // Redirect to success page
                                window.location.href = 'payment_success.php?payment_id=' + response.razorpay_payment_id;
                            },
                            prefill: {
                                name: formData.name,
                                contact: formData.mobile
                            },
                            theme: {
                                color: "#FF6F00"
                            },
                            modal: {
                                ondismiss: function() {
                                    console.log('Payment modal closed');
                                }
                            }
                        };
                        
                        const rzp = new Razorpay(options);
                        rzp.open();
                    } else {
                        alert('Error creating order: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing your payment. Please try again.');
                });
            });
            
            // Initialize total amount
            updateTotalAmount();
        }); 
    </script>
</body>
</html>
