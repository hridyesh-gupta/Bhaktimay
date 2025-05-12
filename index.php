<?php
require_once 'config.php';
// Hardcoded main item
$main_item = [
    'name' => 'Main Item Name',
    'price' => 1000,
    'image' => 'main-item.jpg'
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
    <!-- Header with centered logo -->
    <header class="w-full bg-lightyellow py-4 shadow-sm mb-8">
      <div class="flex justify-center items-center">
        <img src="images/logo.png" alt="Bhaktimay Logo" class="h-20 md:h-28 object-contain" />
      </div>
    </header>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h1 class="text-3xl font-bold text-center text-primary mb-8">Your Cart</h1>
        
        <!-- Main Item Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col items-start">
                <img src="images/<?php echo $main_item['image']; ?>" alt="Main Item" class="w-full h-auto object-contain rounded-lg mb-4">
                <h2 class="text-xl font-semibold text-gray-700">
                    <?php echo htmlspecialchars($main_item['name']); ?> (₹<span id="main-item-price"><?php echo $main_item['price']; ?></span>)
                </h2>
            </div>
        </div>


        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold text-primary mb-4">Add-ons</h3>
            <!-- Horizontal scroll container -->
            <div class="overflow-x-auto">
                <!-- Flex on small, grid on md+ -->
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
    </script>
    <script src="script.js"></script>
</body>
</html>
