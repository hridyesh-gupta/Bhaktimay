<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use Razorpay\Api\Api;

// Get payment ID from URL
$payment_id = $_GET['payment_id'] ?? null;

if (!$payment_id) {
    die("Payment ID not found");
}

try {
    // Initialize Razorpay API
    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
    
    // Fetch payment details
    $payment = $api->payment->fetch($payment_id);
    
    // Verify payment status
    if ($payment->status === 'captured') {
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Get order details from the payment
            $order_id = $payment->order_id;
            
            // Update order status and payment ID
            $stmt = $conn->prepare("UPDATE orders SET 
                payment_id = ?, 
                payment_status = 'completed',
                updated_at = NOW()
                WHERE order_id = ?");
            $stmt->bind_param("ss", $payment_id, $order_id);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                // Get the order details for display
                $stmt = $conn->prepare("SELECT o.*, 
                    GROUP_CONCAT(CONCAT(a.name, ' (', oa.quantity, ')') SEPARATOR ', ') as addon_details
                    FROM orders o
                    LEFT JOIN order_addons oa ON o.id = oa.order_id
                    LEFT JOIN addons a ON oa.addon_id = a.id
                    WHERE o.order_id = ?
                    GROUP BY o.id");
                $stmt->bind_param("s", $order_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $order = $result->fetch_assoc();
                
                // Commit transaction
                $conn->commit();
                
                // Payment successful - Show detailed success page
                echo "<!DOCTYPE html>
                <html>
                <head>
                    <title>Payment Successful</title>
                    <style>
                        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; }
                        .success-box { background: #d4edda; border: 1px solid #c3e6cb; padding: 20px; border-radius: 5px; }
                        .details-box { background: #f8f9fa; border: 1px solid #dee2e6; padding: 20px; margin-top: 20px; border-radius: 5px; }
                        h1 { color: #155724; }
                        .detail-row { margin: 10px 0; }
                        .label { font-weight: bold; }
                    </style>
                </head>
                <body>
                    <div class='success-box'>
                        <h1>Payment Successful!</h1>
                        <p>Thank you for your payment. Your order has been confirmed.</p>
                    </div>
                    
                    <div class='details-box'>
                        <h2>Order Details</h2>
                        <div class='detail-row'>
                            <span class='label'>Order ID:</span> " . htmlspecialchars($order['order_id']) . "
                        </div>
                        <div class='detail-row'>
                            <span class='label'>Payment ID:</span> " . htmlspecialchars($payment_id) . "
                        </div>
                        <div class='detail-row'>
                            <span class='label'>Amount Paid:</span> ₹" . number_format($order['total_amount'], 2) . "
                        </div>
                        <div class='detail-row'>
                            <span class='label'>Name:</span> " . htmlspecialchars($order['name']) . "
                        </div>
                        <div class='detail-row'>
                            <span class='label'>Gotra:</span> " . htmlspecialchars($order['gotra']) . "
                        </div>
                        <div class='detail-row'>
                            <span class='label'>Mobile:</span> " . htmlspecialchars($order['mobile']) . "
                        </div>
                        <div class='detail-row'>
                            <span class='label'>Address:</span><br>
                            " . htmlspecialchars($order['address1']) . "<br>
                            " . htmlspecialchars($order['address2']) . "<br>
                            PIN: " . htmlspecialchars($order['pincode']) . "
                        </div>";
                
                if ($order['addon_details']) {
                    echo "<div class='detail-row'>
                            <span class='label'>Selected Add-ons:</span><br>
                            " . htmlspecialchars($order['addon_details']) . "
                        </div>";
                }
                
                if ($order['custom_amount'] > 0) {
                    echo "<div class='detail-row'>
                            <span class='label'>Custom Amount:</span> ₹" . number_format($order['custom_amount'], 2) . "
                        </div>";
                }
                
                echo "</div></body></html>";
            } else {
                throw new Exception("Order not found");
            }
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            throw $e;
        }
    } else {
        throw new Exception("Payment not captured");
    }
} catch (Exception $e) {
    // Log error
    error_log("Payment verification failed: " . $e->getMessage());
    
    // Show error to user
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Payment Verification Failed</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; }
            .error-box { background: #f8d7da; border: 1px solid #f5c6cb; padding: 20px; border-radius: 5px; }
            h1 { color: #721c24; }
        </style>
    </head>
    <body>
        <div class='error-box'>
            <h1>Payment Verification Failed</h1>
            <p>There was an error verifying your payment. Please contact support.</p>
            <p>Error: " . htmlspecialchars($e->getMessage()) . "</p>
        </div>
    </body>
    </html>";
}
?> 