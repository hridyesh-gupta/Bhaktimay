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
                $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
                $stmt->bind_param("s", $order_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $order = $result->fetch_assoc();
                
                // Commit transaction
                $conn->commit();
                
                // Payment successful - Show detailed success page
                $addons = json_decode($order['addons_json'], true) ?: [];
                $names_gotras = json_decode($order['names_gotras_json'], true) ?: [];
                echo "<!DOCTYPE html>
                <html>
                <head>
                    <title>Payment Successful</title>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <script src='https://cdn.tailwindcss.com'></script>
                    <script>
                      tailwind.config = {
                        theme: {
                          extend: {
                            colors: {
                              primary: '#FF6F00',
                              lightyellow: '#FFF9DB',
                            }
                          }
                        }
                      }
                    </script>
                    <style>
                      @media (max-width: 640px) {
                        .container {
                          padding-left: 16px;
                          padding-right: 16px;
                        }
                        .grid-cols-2 {
                          grid-template-columns: 1fr;
                        }
                        .text-2xl {
                          font-size: 1.5rem;
                        }
                        .text-xl {
                          font-size: 1.25rem;
                        }
                        .p-6 {
                          padding: 1rem;
                        }
                        .space-y-4 > * + * {
                          margin-top: 1rem;
                        }
                      }
                    </style>
                </head>
                <body class='bg-lightyellow min-h-screen'>
                    <div class='min-h-screen flex flex-col'>";
                include 'header.php';
                echo "<div class='flex-grow container mx-auto px-4 py-4 sm:py-8 max-w-2xl'>
                        <div class='bg-green-50 border-l-4 border-green-500 p-4 sm:p-6 rounded-lg shadow-md mb-4 sm:mb-8'>
                            <div class='flex items-center'>
                                <div class='flex-shrink-0'>
                                    <svg class='h-6 w-6 sm:h-8 sm:w-8 text-green-500' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>
                                    </svg>
                                </div>
                                <div class='ml-3 sm:ml-4'>
                                    <h1 class='text-xl sm:text-2xl font-bold text-primary'>Payment Successful!</h1>
                                    <p class='mt-1 sm:mt-2 text-sm sm:text-base text-green-700'>Thank you for your payment. Your order has been confirmed.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class='bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-8'>
                            <h2 class='text-lg sm:text-xl font-semibold text-primary mb-3 sm:mb-4'>Order Details</h2>
                            <div class='space-y-3 sm:space-y-4'>
                                <div class='grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4'>
                                    <div class='text-sm sm:text-base text-gray-600 font-medium'>Order ID:</div>
                                    <div class='text-sm sm:text-base text-gray-800 break-all'>" . htmlspecialchars($order['order_id']) . "</div>
                                    
                                    <div class='text-sm sm:text-base text-gray-600 font-medium'>Payment ID:</div>
                                    <div class='text-sm sm:text-base text-gray-800 break-all'>" . htmlspecialchars($payment_id) . "</div>
                                    
                                    <div class='text-sm sm:text-base text-gray-600 font-medium'>Amount Paid:</div>
                                    <div class='text-sm sm:text-base text-gray-800'>₹" . number_format($order['total_amount'], 2) . "</div>
                                    
                                    <div class='text-sm sm:text-base text-gray-600 font-medium'>Mobile:</div>
                                    <div class='text-sm sm:text-base text-gray-800'>" . htmlspecialchars($order['mobile']) . "</div>
                                </div>
                                
                                <div class='border-t border-gray-200 pt-3 sm:pt-4'>
                                    <div class='text-sm sm:text-base text-gray-600 font-medium mb-2'>Names and Gotras:</div>
                                    <div class='space-y-2'>";
                                    foreach ($names_gotras as $index => $person) {
                                        echo "<div class='text-sm sm:text-base text-gray-800'>
                                            <span class='font-medium'>Person " . ($index + 1) . ":</span><br>
                                            Name: " . htmlspecialchars($person['name']) . "<br>
                                            Gotra: " . htmlspecialchars($person['gotra']) . "
                                        </div>";
                                    }
                                    echo "</div>
                                </div>
                                
                                <div class='border-t border-gray-200 pt-3 sm:pt-4'>
                                    <div class='text-sm sm:text-base text-gray-600 font-medium mb-2'>Address:</div>
                                    <div class='text-sm sm:text-base text-gray-800'>
                                        " . htmlspecialchars($order['address1']) . "<br>
                                        " . htmlspecialchars($order['address2']) . "<br>
                                        PIN: " . htmlspecialchars($order['pincode']) . "
                                    </div>
                                </div>
                            </div>
                        </div>";
                
                echo "<div class='bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-8'>
                        <h2 class='text-lg sm:text-xl font-semibold text-primary mb-3 sm:mb-4'>Payment Summary</h2>
                        <div class='space-y-2'>
                            <div class='flex justify-between text-sm sm:text-base'>
                                <span>Main Item (" . htmlspecialchars($order['main_item_name']) . ")</span>
                                <span>₹" . number_format($order['main_item_price'], 2) . "</span>
                            </div>";
                            foreach ($addons as $addon) {
                                echo "<div class='flex justify-between text-sm sm:text-base'>
                                    <span>" . htmlspecialchars($addon['name']) . " x " . intval($addon['quantity']) . "</span>
                                    <span>₹" . number_format($addon['price'] * $addon['quantity'], 2) . "</span>
                                </div>";
                            }
                            if ($order['custom_amount'] > 0) {
                                echo "<div class='flex justify-between text-sm sm:text-base'>
                                    <span>Custom Amount</span>
                                    <span>₹" . number_format($order['custom_amount'], 2) . "</span>
                                </div>";
                            }
                            echo "<div class='border-t border-gray-200 my-2'></div>
                            <div class='flex justify-between font-bold text-base sm:text-lg'>
                                <span>Total</span>
                                <span>₹" . number_format($order['total_amount'], 2) . "</span>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </body>
                </html>";
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
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://cdn.tailwindcss.com'></script>
        <script>
          tailwind.config = {
            theme: {
              extend: {
                colors: {
                  primary: '#FF6F00',
                  lightyellow: '#FFF9DB',
                }
              }
            }
          }
        </script>
        <style>
          @media (max-width: 640px) {
            .container {
              padding-left: 16px;
              padding-right: 16px;
            }
            .text-2xl {
              font-size: 1.5rem;
            }
            .p-6 {
              padding: 1rem;
            }
          }
        </style>
    </head>
    <body class='bg-lightyellow min-h-screen'>
        <div class='min-h-screen flex flex-col'>
            <!-- Header with centered logo -->
            <header class='w-full bg-lightyellow py-4 shadow-sm mb-4 sm:mb-8'>
              <div class='flex justify-center items-center'>
                <img src='images/logo.png' alt='Bhaktimay Logo' class='h-16 sm:h-20 md:h-28 object-contain' />
              </div>
            </header>
            <div class='flex-grow container mx-auto px-4 py-4 sm:py-8 max-w-2xl'>
                <div class='bg-red-50 border-l-4 border-red-500 p-4 sm:p-6 rounded-lg shadow-md'>
                    <div class='flex items-center'>
                        <div class='flex-shrink-0'>
                            <svg class='h-6 w-6 sm:h-8 sm:w-8 text-red-500' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'></path>
                            </svg>
                        </div>
                        <div class='ml-3 sm:ml-4'>
                            <h1 class='text-xl sm:text-2xl font-bold text-primary'>Payment Verification Failed</h1>
                            <p class='mt-1 sm:mt-2 text-sm sm:text-base text-red-700'>There was an error verifying your payment. Please contact support.</p>
                            <p class='mt-1 sm:mt-2 text-sm sm:text-base text-red-600'>Error: " . htmlspecialchars($e->getMessage()) . "</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>";
}
?> 