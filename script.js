document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    const mainItemPrice = parseInt(document.getElementById('main-item-price').textContent);
    const totalAmountElement = document.getElementById('total-amount');
    const customAmountInput = document.getElementById('custom-amount');
    const checkoutBtn = document.getElementById('checkout-btn');
    
    // Function to update total amount
    function updateTotalAmount() {
        let total = mainItemPrice;
        
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
        
        // Collect form data
        const formData = {
            name: document.getElementById('name').value,
            gotra: document.getElementById('gotra').value,
            mobile: document.getElementById('mobile').value,
            address1: document.getElementById('address1').value,
            address2: document.getElementById('address2').value,
            pincode: document.getElementById('pincode').value,
            total_amount: parseInt(totalAmountElement.textContent),
            addons: Array.from(document.querySelectorAll('.quantity')).map(input => ({
                id: input.dataset.id,
                quantity: parseInt(input.value) || 0
            })),
            custom_amount: parseInt(customAmountInput.value) || 0
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
                        color: "#28a745"
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
        });
    });
    
    // Initialize total amount
    updateTotalAmount();
}); 