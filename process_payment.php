<?php
// Set header to JSON
header('Content-Type: application/json');

require_once 'config.php';
require_once 'vendor/autoload.php';

use Razorpay\Api\Api;

// Get POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid data received'
    ]);
    exit;
}

try {
    // Initialize Razorpay API
    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
    
    // Create order
    $orderData = [
        'receipt'         => 'rcpt_' . time(),
        'amount'          => $data['total_amount'] * 100, // Convert to paise
        'currency'        => 'INR',
        'payment_capture' => 1
    ];
    
    $razorpayOrder = $api->order->create($orderData);
    
    // Convert Razorpay order object to array
    $orderArray = $razorpayOrder->toArray();
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Store order details in database
        $stmt = $conn->prepare("INSERT INTO orders (order_id, name, gotra, mobile, address1, address2, pincode, total_amount, custom_amount, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssssdi", 
            $orderArray['id'],
            $data['name'],
            $data['gotra'],
            $data['mobile'],
            $data['address1'],
            $data['address2'],
            $data['pincode'],
            $data['total_amount'],
            $data['custom_amount']
        );
        $stmt->execute();
        $orderId = $conn->insert_id;
        
        // Store add-ons
        if (!empty($data['addons'])) {
            $stmt = $conn->prepare("INSERT INTO order_addons (order_id, addon_id, quantity) VALUES (?, ?, ?)");
            foreach ($data['addons'] as $addon) {
                if ($addon['quantity'] > 0) {
                    $stmt->bind_param("iii", $orderId, $addon['id'], $addon['quantity']);
                    $stmt->execute();
                }
            }
        }
        
        // Commit transaction
        $conn->commit();
        
        // Return success response
        echo json_encode([
            'success' => true,
            'key_id' => RAZORPAY_KEY_ID,
            'amount' => $data['total_amount'] * 100,
            'order_id' => $orderArray['id']
        ]);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        throw $e;
    }
    
} catch (Exception $e) {
    // Log error
    error_log("Payment processing failed: " . $e->getMessage());
    
    // Return error response
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 