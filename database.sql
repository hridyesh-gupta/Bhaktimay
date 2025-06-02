-- Create database if not exists
CREATE DATABASE IF NOT EXISTS bhaktimay;
USE bhaktimay;

-- Create orders table (single table for all data)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(255) NOT NULL,
    payment_id VARCHAR(255),
    event_id VARCHAR(255) NOT NULL,
    event_date VARCHAR(255) NOT NULL,
    pooja_name VARCHAR(255) NOT NULL,
    main_item_name VARCHAR(255) NOT NULL,
    main_item_price DECIMAL(10,2) NOT NULL,
    addons_json TEXT, -- JSON string of selected add-ons and their quantities
    custom_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    total_amount DECIMAL(10,2) NOT NULL,
    names_gotras_json TEXT,
    mobile VARCHAR(20) NOT NULL,
    address1 VARCHAR(255) NOT NULL,
    address2 VARCHAR(255) NOT NULL,
    pincode VARCHAR(10) NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

