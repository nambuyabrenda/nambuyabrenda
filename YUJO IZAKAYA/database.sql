-- database.sql - Complete database structure for Yujo Izakaya
-- This version is compatible with MySQL/MariaDB and has no syntax errors

-- Create database
CREATE DATABASE IF NOT EXISTS yujo_reservations 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE yujo_reservations;

-- =====================================================
-- CORE TABLES
-- =====================================================

-- Reservations table
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    reservation_date DATE NOT NULL,
    reservation_time TIME NOT NULL,
    guests INT NOT NULL,
    special_requests TEXT,
    source VARCHAR(50) DEFAULT 'website',
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (reservation_date),
    INDEX idx_status (status),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100),
    role VARCHAR(20) DEFAULT 'staff',
    status VARCHAR(20) DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Menu items table
CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    subcategory VARCHAR(50),
    name VARCHAR(200) NOT NULL,
    name_jp VARCHAR(200),
    description TEXT,
    price_glass DECIMAL(10,2),
    price_shot DECIMAL(10,2),
    price_small DECIMAL(10,2),
    price_large DECIMAL(10,2),
    price_bottle DECIMAL(10,2),
    abv DECIMAL(4,1),
    volume_ml INT,
    is_vegetarian TINYINT(1) DEFAULT 0,
    is_spicy TINYINT(1) DEFAULT 0,
    is_available TINYINT(1) DEFAULT 1,
    has_seasons TINYINT(1) DEFAULT 0,
    notes TEXT,
    image_url VARCHAR(255),
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_available (is_available)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Drinks table
CREATE TABLE IF NOT EXISTS drinks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    name VARCHAR(200) NOT NULL,
    name_jp VARCHAR(200),
    price_glass DECIMAL(10,2),
    price_bottle DECIMAL(10,2),
    price_shot DECIMAL(10,2),
    abv DECIMAL(4,1),
    volume_ml INT,
    notes TEXT,
    ingredients TEXT,
    is_available TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_available (is_available)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sake table
CREATE TABLE IF NOT EXISTS sake (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    name_jp VARCHAR(200),
    type VARCHAR(50) NOT NULL,
    abv DECIMAL(4,1),
    rice_polishing VARCHAR(50),
    volume_ml INT,
    price_glass DECIMAL(10,2),
    price_bottle DECIMAL(10,2),
    tasting_notes TEXT,
    food_pairings TEXT,
    is_available TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Shochu table
CREATE TABLE IF NOT EXISTS shochu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    name_jp VARCHAR(200),
    type VARCHAR(50) NOT NULL,
    abv DECIMAL(4,1),
    volume_ml INT,
    price_glass DECIMAL(10,2),
    price_shot DECIMAL(10,2),
    price_bottle DECIMAL(10,2),
    tasting_notes TEXT,
    is_available TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Umeshu table
CREATE TABLE IF NOT EXISTS umeshu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    name_jp VARCHAR(200),
    abv DECIMAL(4,1),
    volume_ml INT,
    price_glass DECIMAL(10,2),
    price_bottle DECIMAL(10,2),
    sweetness VARCHAR(20) DEFAULT 'sweet',
    tasting_notes TEXT,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cocktails table
CREATE TABLE IF NOT EXISTS cocktails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    category VARCHAR(50) NOT NULL,
    ingredients TEXT NOT NULL,
    preparation TEXT,
    price DECIMAL(10,2) NOT NULL,
    glass_type VARCHAR(50),
    garnish VARCHAR(100),
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Whisky table
CREATE TABLE IF NOT EXISTS whisky (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    type VARCHAR(50) NOT NULL,
    age INT,
    abv DECIMAL(4,1),
    volume_ml INT,
    price_shot DECIMAL(10,2),
    price_bottle DECIMAL(10,2),
    tasting_notes TEXT,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Wines table
CREATE TABLE IF NOT EXISTS wines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    type VARCHAR(50) NOT NULL,
    vintage YEAR,
    region VARCHAR(100),
    price_glass DECIMAL(10,2),
    price_bottle DECIMAL(10,2),
    tasting_notes TEXT,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Beers table
CREATE TABLE IF NOT EXISTS beers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    brewery VARCHAR(100),
    type VARCHAR(50),
    abv DECIMAL(4,1),
    ibu INT,
    price_330ml DECIMAL(10,2),
    price_500ml DECIMAL(10,2),
    price_bottle DECIMAL(10,2),
    tasting_notes TEXT,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Soft drinks table
CREATE TABLE IF NOT EXISTS soft_drinks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    size_ml INT,
    price DECIMAL(10,2) NOT NULL,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Juices table
CREATE TABLE IF NOT EXISTS juices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    is_fresh TINYINT(1) DEFAULT 1,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Teas table
CREATE TABLE IF NOT EXISTS teas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    name_jp VARCHAR(100),
    type VARCHAR(50),
    description TEXT,
    price DECIMAL(10,2),
    caffeine_content VARCHAR(20) DEFAULT 'medium',
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    event_date DATE NOT NULL,
    event_time TIME,
    end_time TIME,
    capacity INT,
    price DECIMAL(10,2),
    image_url VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (event_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_read (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Newsletter subscribers table
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    name VARCHAR(100),
    is_active TINYINT(1) DEFAULT 1,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at TIMESTAMP NULL,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Special offers table
CREATE TABLE IF NOT EXISTS special_offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    discount_percent INT,
    valid_from DATE,
    valid_to DATE,
    terms_conditions TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_valid_dates (valid_from, valid_to)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Staff table
CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100),
    bio TEXT,
    image_url VARCHAR(255),
    join_date DATE,
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Gallery table
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200),
    image_url VARCHAR(255) NOT NULL,
    category VARCHAR(50),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Testimonials table
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_title VARCHAR(100),
    content TEXT NOT NULL,
    rating INT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Settings table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type VARCHAR(20) DEFAULT 'text',
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SAMPLE DATA INSERTION
-- =====================================================

-- Insert default admin user
-- IMPORTANT: You need to generate a proper password hash!
-- For now, this is a placeholder. Run this PHP code to generate a real hash:
-- echo password_hash('YujoAdmin2024!', PASSWORD_DEFAULT);
-- Then replace the hash below with the generated one
INSERT INTO admin_users (username, password_hash, email, full_name, role, status) VALUES
('admin', '$2y$10$YourHashedPasswordHere', 'admin@yujoizakaya.ug', 'Administrator', 'admin', 'active');

-- Insert default settings
INSERT INTO settings (setting_key, setting_value, setting_type, description) VALUES
('restaurant_name', 'Yujo Izakaya', 'text', 'Restaurant name'),
('restaurant_phone', '0708 109856', 'text', 'Contact phone number'),
('restaurant_email', 'info@yujoizakaya.ug', 'text', 'Contact email'),
('restaurant_address', '36 Kyadondo Rd, Nakasero, Kampala', 'text', 'Physical address'),
('opening_time', '11:30', 'text', 'Opening time'),
('closing_time', '23:00', 'text', 'Closing time'),
('kitchen_close', '22:30', 'text', 'Kitchen closing time'),
('max_guests_per_reservation', '20', 'number', 'Maximum guests per reservation'),
('reservation_advance_days', '90', 'number', 'How many days in advance reservations can be made'),
('enable_online_reservations', '1', 'boolean', 'Enable/disable online reservations');

-- Insert sample reservation for testing
INSERT INTO reservations (name, email, phone, reservation_date, reservation_time, guests, special_requests, status) VALUES
('Test User', 'test@example.com', '0700123456', DATE_ADD(CURDATE(), INTERVAL 1 DAY), '19:30:00', 4, 'Anniversary celebration', 'pending');

-- Insert sample sake data
INSERT INTO sake (name, type, abv, volume_ml, price_glass, price_bottle) VALUES
('Hakutsuru Excellent Junmai', 'junmai', 15, 720, 23, 140),
('Hakutsuru Excellent Junmai', 'junmai', 15, 1800, 23, 420),
('Hakutsuru Organic Junmai', 'junmai', 14.5, 720, NULL, 300),
('Kikusakari Junmai Daiginjo', 'daiginjo', 16, 720, NULL, 480),
('Kikusakari Junmai Tarusake', 'taruzake', 15, 1800, 25, 480),
('Kikusakari Yamahai Genshu', 'yamahai', 17, 720, NULL, 240),
('Kikusakari Junmaishu', 'junmai', 15, 720, 20, 180),
('Keigetsu Sparkling John', 'sparkling', 15, 750, NULL, 700),
('Sake Nature', 'junmai', 15, 720, NULL, 580),
('Keigetsu Gin no Yume', 'daiginjo', 15, 720, NULL, 420),
('Keigetsu Cel 24', 'daiginjo', 15, 720, NULL, 420),
('Keigetsu Nigori', 'nigori', 15, 300, NULL, 176);

-- Insert sample shochu data
INSERT INTO shochu (name, type, abv, volume_ml, price_glass, price_shot, price_bottle) VALUES
('Kuro Shiranami', 'kome', 25, 900, 27, NULL, 240),
('Satsuma Shiranami', 'imo', 25, 900, 22, NULL, 200),
('Sakura Shiranami', 'kome', 25, 720, 27, NULL, 200),
('Hakutake Yuzumon', 'kome', 8, 720, 40, NULL, 300),
('Nikaido Kickchomu', 'mugi', 25, 720, NULL, 23, 680),
('Amatsukaze', 'kome', 37, 720, NULL, 22, 640);

-- Insert sample umeshu data
INSERT INTO umeshu (name, abv, volume_ml, price_glass, price_bottle, sweetness) VALUES
('Umeshu Kuro', 18, 720, 52, 380, 'sweet'),
('Aragoshi Umeshu', 12, 720, 47, 340, 'sweet'),
('Kiuchi Umeshu', 14.5, 500, 30, 200, 'semi_sweet'),
('Sparkling Umeshu', 6, 300, NULL, 160, 'sweet'),
('Hakusturu Umeshu', 19, 720, 47, 340, 'sweet'),
('Hakutake Umepon', 10, 720, 42, 300, 'semi_sweet');

-- Insert sample cocktail data
INSERT INTO cocktails (name, category, ingredients, price) VALUES
('Sake Mojito', 'signature', 'sake, mint leaves, lime, soda', 30),
('Sake Lemonade', 'signature', 'sake, lemon juice, sugar', 25),
('Ume Sour', 'signature', 'umeshu, sour mix', 20),
('Japanese Old Fashioned', 'classic', 'bourbon, sugar, bitters, orange zest', 30),
('Negroni', 'classic', 'gin, Campari, sweet vermouth', 28),
('Midori Illusion', 'signature', 'Midori, vodka, sour mix', 28);

-- Insert sample soft drinks
INSERT INTO soft_drinks (name, size_ml, price) VALUES
('Aquelle Still Water', 500, 5),
('Aquelle Still Water', 750, 10),
('Aquelle Sparkling Water', 330, 6),
('Aquelle Sparkling Water', 750, 12),
('Soda', 300, 4),
('Coke Zero', 330, 5),
('Pepsi Max', 330, 5),
('Red Bull', 250, 12);

-- Insert sample juices
INSERT INTO juices (name, price) VALUES
('Mulberry', 20),
('Strawberry', 20),
('Pixie Orange', 20),
('Passion', 15),
('Mango', 15),
('Watermelon', 12),
('Mulberry Passion', 20),
('Strawberry Passion', 20);

-- Insert sample teas
INSERT INTO teas (name, name_jp, type, description, price) VALUES
('Awa Bancha', '阿波番茶', 'fermented', 'Traditional lactic acid tea from Kamikatsu, Tokushima', 15),
('Sencha', '煎茶', 'green', 'Steamed and rubbed green tea', 12),
('Genmai Cha', '玄米茶', 'green', 'Green tea with roasted rice', 12),
('Hoji Cha', 'ほうじ茶', 'roasted', 'Roasted green tea, low caffeine', 12),
('Matcha', '抹茶', 'powdered', 'Ceremonial grade powdered green tea', 18),
('Oolong Cha', '烏龍茶', 'oolong', 'Semi-fermented Chinese tea', 12);

-- Insert sample staff data
INSERT INTO staff (name, position, bio, join_date, sort_order) VALUES
('Chef Jackie Tuck', 'Head Chef', 'Leading our 90% female kitchen team with passion and precision', '2018-01-15', 1),
('Mika Suzuki', 'Sushi Master', 'Trained in Tokyo, bringing authentic Edomae sushi techniques', '2019-03-20', 2),
('Sarah Namubiru', 'Restaurant Manager', 'Ensuring every guest has an exceptional dining experience', '2020-06-10', 3);

-- Insert sample testimonials
INSERT INTO testimonials (customer_name, customer_title, content, rating) VALUES
('John Mukasa', 'Regular Customer', 'Best Japanese food in Kampala! The sushi is always fresh and the service is excellent.', 5),
('Grace Akello', 'Food Blogger', 'The Black Dragon Roll is to die for. Love the authentic izakaya atmosphere.', 5),
('Michael Ochieng', 'Business Traveler', 'Reminds me of the ramen shops in Tokyo. A hidden gem in Kampala.', 5);

-- Insert sample events
INSERT INTO events (title, description, event_date, event_time, capacity, price, is_active) VALUES
('New Year Sake Tasting', 'Celebrate the New Year with our special sake tasting event featuring 5 premium sakes', '2024-12-31', '20:00:00', 50, 150000, 1),
('Sushi Making Workshop', 'Learn to make sushi from our master chefs', '2024-11-15', '15:00:00', 20, 200000, 1),
('Japanese Whisky Night', 'Explore Japanese whiskies with guided tasting', '2024-11-30', '19:00:00', 30, 180000, 1);

-- Insert sample special offers
INSERT INTO special_offers (title, description, discount_percent, valid_from, valid_to, is_active) VALUES
('Early Bird Special', '15% off for reservations before 6:30 PM', 15, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 1),
('Birthday Celebration', 'Free dessert for birthday guests', NULL, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 60 DAY), 1),
('Group Booking Discount', '10% off for groups of 8 or more', 10, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 90 DAY), 1);

-- =====================================================
-- CREATE INDEXES FOR BETTER PERFORMANCE
-- =====================================================

CREATE INDEX idx_reservations_date_status ON reservations(reservation_date, status);
CREATE INDEX idx_menu_category_available ON menu_items(category, is_available);
CREATE INDEX idx_drinks_category_available ON drinks(category, is_available);

-- =====================================================
-- NOTE ABOUT ADMIN PASSWORD
-- =====================================================
-- IMPORTANT: The admin user password needs to be properly hashed!
-- After importing this SQL, run this PHP code to update the password:
-- 
-- <?php
-- $pdo = new PDO('mysql:host=localhost;dbname=yujo_reservations', 'root', '');
-- $hash = password_hash('YujoAdmin2024!', PASSWORD_DEFAULT);
-- $stmt = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE username = 'admin'");
-- $stmt->execute([$hash]);
-- echo "Admin password updated successfully!";
-- ?>