-- Create database if not exists
CREATE DATABASE IF NOT EXISTS bhaktimay;
USE bhaktimay;

-- Create orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(255) NOT NULL,
    payment_id VARCHAR(255),
    name VARCHAR(255) NOT NULL,
    gotra VARCHAR(100) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    address1 VARCHAR(255) NOT NULL,
    address2 VARCHAR(255) NOT NULL,
    pincode VARCHAR(10) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    custom_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create addons table
CREATE TABLE IF NOT EXISTS addons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create order_addons table
CREATE TABLE IF NOT EXISTS order_addons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    addon_id INT NOT NULL,
    quantity INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (addon_id) REFERENCES addons(id)
);

-- Insert sample add-ons
INSERT INTO addons (name, price, image) VALUES
('Add-on 1', 100.00, 'addon1.jpg'),
('Add-on 2', 200.00, 'addon2.jpg'),
('Add-on 3', 150.00, 'addon3.jpg'),
('Add-on 4', 300.00, 'addon4.jpg'),
('Add-on 5', 250.00, 'addon5.jpg'); 