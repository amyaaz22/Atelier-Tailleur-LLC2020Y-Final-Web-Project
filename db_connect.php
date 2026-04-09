<?php
$host     = "localhost";
$dbname   = "atelier_tailleur";
$username = "root";
$password = "";

// Connect without selecting DB first
$conn = mysqli_connect($host, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create DB if it doesn't exist, then select it
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$dbname`");
mysqli_select_db($conn, $dbname);

// Create tables if they don't exist yet
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    reset_token VARCHAR(100) DEFAULT NULL,
    reset_expires DATETIME DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50),
    image VARCHAR(255)
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    service_id INT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    appointment_date DATE,
    notes TEXT,
    reference_image VARCHAR(255),
    total_price DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'Pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150),
    message TEXT NOT NULL,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    original_name VARCHAR(255),
    saved_name VARCHAR(255),
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Seed services table if empty
$check = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM services");
$row   = mysqli_fetch_assoc($check);
if ($row['cnt'] == 0) {
    mysqli_query($conn, "INSERT INTO services (name, description, price, category) VALUES
        ('Bespoke Suit',       'Fully hand-crafted suit tailored to your exact measurements.',     8500.00, 'Suits'),
        ('Evening Gown',       'Elegant gown design and fitting service for special occasions.',   6200.00, 'Gowns'),
        ('Shirt Alteration',   'Professional shirt alterations for a perfect fit.',                 950.00, 'Alterations'),
        ('Wedding Dress',      'Bespoke bridal wear crafted with finest fabrics.',               12000.00, 'Bridal'),
        ('Casual Dress',       'Smart-casual dress design for everyday elegance.',                3500.00, 'Casual'),
        ('Trouser Alteration', 'Hem, waist, and leg adjustments for trousers.',                    750.00, 'Alterations')
    ");
}
?>
