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
        $stmt = $conn->prepare("INSERT INTO orders (order_id, event_id, event_date, pooja_name, main_item_name, main_item_price, addons_json, custom_amount, total_amount, names_gotras_json, mobile, address1, address2, pincode, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $addons_json = json_encode($data['addons']);
        $names_gotras_json = json_encode($data['names_gotras']);
        $stmt->bind_param(
            "sssssdsdssssss",
            $orderArray['id'],
            $data['event_id'],
            $data['event_date'],
            $data['pooja_name'],
            $data['main_item_name'],
            $data['main_item_price'],
            $addons_json,
            $data['custom_amount'],
            $data['total_amount'],
            $names_gotras_json,
            $data['mobile'],
            $data['address1'],
            $data['address2'],
            $data['pincode']
        );
        $stmt->execute();
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