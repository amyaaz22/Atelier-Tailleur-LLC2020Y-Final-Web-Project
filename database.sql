-- Run this in phpMyAdmin or MySQL to set up the Atelier Tailleur database

CREATE DATABASE IF NOT EXISTS atelier_tailleur;
USE atelier_tailleur;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    reset_token VARCHAR(100) DEFAULT NULL,
    reset_expires DATETIME DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Services table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50),
    image VARCHAR(255)
);

-- Orders (bookings) table
CREATE TABLE IF NOT EXISTS orders (
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
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL
);

-- Enquiries (contact) table
CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150),
    message TEXT NOT NULL,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Uploads table
CREATE TABLE IF NOT EXISTS uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    original_name VARCHAR(255),
    saved_name VARCHAR(255),
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- -------------------------------------------------------
-- Sample data
-- -------------------------------------------------------

INSERT INTO users (full_name, email, password, phone) VALUES
('Alice Moreau',    'alice@example.com',   '$2y$10$e0NRp1234567890abcdefOABCDEFGHIJKLMNOPQRSTUVWXYZ12', '+230 5211 1001'),
('Bernard Leroy',   'bernard@example.com', '$2y$10$e0NRp1234567890abcdefOABCDEFGHIJKLMNOPQRSTUVWXYZ12', '+230 5211 1002'),
('Chloé Dupont',    'chloe@example.com',   '$2y$10$e0NRp1234567890abcdefOABCDEFGHIJKLMNOPQRSTUVWXYZ12', '+230 5211 1003');

INSERT INTO services (name, description, price, category, image) VALUES
('Bespoke Suit',       'Fully hand-crafted suit tailored to your exact measurements.',      8500.00, 'Suits',    'suit.jpg'),
('Evening Gown',       'Elegant gown design and fitting service for special occasions.',    6200.00, 'Gowns',    'gown.jpg'),
('Shirt Alteration',   'Professional shirt alterations for a perfect fit.',                  950.00, 'Alterations','shirt.jpg'),
('Wedding Dress',      'Bespoke bridal wear crafted with finest fabrics.',                 12000.00, 'Bridal',   'wedding.jpg'),
('Casual Dress',       'Smart-casual dress design for everyday elegance.',                  3500.00, 'Casual',   'dress.jpg'),
('Trouser Alteration', 'Hem, waist, and leg adjustments for trousers.',                      750.00, 'Alterations','trouser.jpg');

INSERT INTO orders (user_id, service_id, full_name, email, phone, appointment_date, notes, total_price, status) VALUES
(1, 1, 'Alice Moreau',  'alice@example.com',   '+230 5211 1001', '2025-08-10', 'Navy blue, slim fit.',  8500.00, 'Confirmed'),
(2, 4, 'Bernard Leroy', 'bernard@example.com', '+230 5211 1002', '2025-08-15', 'For son wedding.',     12000.00, 'Pending'),
(3, 2, 'Chloé Dupont',  'chloe@example.com',   '+230 5211 1003', '2025-08-20', 'Deep burgundy color.',  6200.00, 'In Progress');

INSERT INTO enquiries (full_name, email, subject, message) VALUES
('Marie Jean',   'marie@example.com',   'Pricing query',      'Could you please share more details about your bespoke suit pricing?'),
('Raj Gopal',    'raj@example.com',     'Appointment',        'I would like to schedule a fitting appointment for next week.'),
('Sophie Martin','sophie@example.com',  'Wedding package',    'Do you offer a full wedding package including bridesmaids dresses?');

INSERT INTO uploads (order_id, original_name, saved_name) VALUES
(1, 'reference_suit.jpg',    'upload_1_ref.jpg'),
(2, 'wedding_inspo.png',     'upload_2_ref.png'),
(3, 'gown_reference.jpg',    'upload_3_ref.jpg');
