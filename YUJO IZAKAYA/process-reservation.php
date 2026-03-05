<?php
// process-reservation.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'yujo_reservations');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Email configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'reservations@yujoizakaya.ug');
define('SMTP_PASS', 'your-email-password');
define('FROM_EMAIL', 'reservations@yujoizakaya.ug');
define('FROM_NAME', 'Yujo Izakaya');

// Response array
$response = [
    'success' => false,
    'message' => '',
    'data' => null
];

try {
    // Get JSON data from request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    // If no JSON data, try POST data
    if (!$data) {
        $data = $_POST;
    }
    
    if (!$data) {
        throw new Exception('No data received');
    }
    
    // Validate required fields
    $required = ['name', 'email', 'phone', 'date', 'time', 'guests'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }
    
    // Sanitize and validate data
    $name = filter_var(trim($data['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($data['phone']), FILTER_SANITIZE_STRING);
    $date = filter_var(trim($data['date']), FILTER_SANITIZE_STRING);
    $time = filter_var(trim($data['time']), FILTER_SANITIZE_STRING);
    $guests = filter_var($data['guests'], FILTER_SANITIZE_NUMBER_INT);
    $special_requests = isset($data['special_requests']) ? 
        filter_var(trim($data['special_requests']), FILTER_SANITIZE_STRING) : '';
    $source = isset($data['source']) ? $data['source'] : 'website';
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address');
    }
    
    // Validate phone (Ugandan format)
    if (!preg_match('/^[0-9+\-\s]{10,15}$/', $phone)) {
        throw new Exception('Invalid phone number format');
    }
    
    // Validate date (must be today or future)
    $reservation_date = new DateTime($date);
    $today = new DateTime('today');
    $today->setTime(0, 0, 0);
    
    if ($reservation_date < $today) {
        throw new Exception('Reservation date must be today or future');
    }
    
    // Check if date is too far in advance (max 3 months)
    $max_date = new DateTime('+3 months');
    if ($reservation_date > $max_date) {
        throw new Exception('Reservations can only be made up to 3 months in advance');
    }
    
    // Validate time (restaurant hours: 11:30 - 22:30)
    $reservation_time = new DateTime($time);
    $open_time = new DateTime('11:30');
    $close_time = new DateTime('22:30');
    $last_seating = new DateTime('22:00'); // Last seating 30 mins before close
    
    if ($reservation_time < $open_time || $reservation_time > $last_seating) {
        throw new Exception('Reservations only available from 11:30 AM to 10:00 PM');
    }
    
    // Validate guests
    if ($guests < 1 || $guests > 20) {
        throw new Exception('Number of guests must be between 1 and 20');
    }
    
    // Connect to database
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        throw new Exception('Unable to connect to database. Please try again later.');
    }
    
    // Check if table exists, if not create it
    $pdo->exec("
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
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_date (reservation_date),
            INDEX idx_status (status),
            INDEX idx_email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    // Check for double booking (same time, within 2 hours)
    $check_sql = "SELECT COUNT(*) as count FROM reservations 
                  WHERE reservation_date = :date 
                  AND ABS(TIME_TO_SEC(TIMEDIFF(reservation_time, :time))) < 7200 
                  AND status IN ('pending', 'confirmed')";
    
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->execute([
        ':date' => $date,
        ':time' => $time
    ]);
    $result = $check_stmt->fetch();
    
    if ($result['count'] >= 10) { // Max 10 tables at same time slot
        throw new Exception('Sorry, this time slot is fully booked. Please choose another time.');
    }
    
    // Insert reservation
    $sql = "INSERT INTO reservations (name, email, phone, reservation_date, reservation_time, guests, special_requests, source) 
            VALUES (:name, :email, :phone, :date, :time, :guests, :special_requests, :source)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':date' => $date,
        ':time' => $time,
        ':guests' => $guests,
        ':special_requests' => $special_requests,
        ':source' => $source
    ]);
    
    $reservation_id = $pdo->lastInsertId();
    
    // Format data for email
    $formatted_date = $reservation_date->format('l, F j, Y');
    $formatted_time = $reservation_time->format('g:i A');
    
    // Send confirmation email to customer
    $to = $email;
    $subject = "Yujo Izakaya - Reservation Confirmation #$reservation_id";
    
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #8B0000; color: white; padding: 20px; text-align: center; }
            .header h1 { margin: 0; font-size: 24px; }
            .content { padding: 30px; background: #f9f9f9; }
            .details { background: white; padding: 20px; border-radius: 5px; margin: 20px 0; }
            .details h2 { color: #8B0000; margin-top: 0; }
            .details table { width: 100%; }
            .details td { padding: 10px; border-bottom: 1px solid #eee; }
            .details td:first-child { font-weight: bold; width: 40%; }
            .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
            .footer a { color: #8B0000; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Yujo Izakaya</h1>
                <p>Reservation Confirmation</p>
            </div>
            <div class='content'>
                <p>Dear <strong>$name</strong>,</p>
                <p>Thank you for choosing Yujo Izakaya! We have received your reservation request and are pleased to confirm the following details:</p>
                
                <div class='details'>
                    <h2>Reservation Details</h2>
                    <table>
                        <tr>
                            <td>Reservation ID:</td>
                            <td><strong>#$reservation_id</strong></td>
                        </tr>
                        <tr>
                            <td>Date:</td>
                            <td><strong>$formatted_date</strong></td>
                        </tr>
                        <tr>
                            <td>Time:</td>
                            <td><strong>$formatted_time</strong></td>
                        </tr>
                        <tr>
                            <td>Number of Guests:</td>
                            <td><strong>$guests</strong></td>
                        </tr>
                        " . ($special_requests ? "<tr><td>Special Requests:</td><td>$special_requests</td></tr>" : "") . "
                    </table>
                </div>
                
                <p><strong>Important Information:</strong></p>
                <ul>
                    <li>Please arrive 10 minutes before your reservation time</li>
                    <li>We hold tables for 15 minutes after the reserved time</li>
                    <li>For changes or cancellations, please contact us at least 2 hours in advance</li>
                </ul>
                
                <p>We look forward to serving you!</p>
                
                <p><strong>Yujo Izakaya</strong><br>
                36 Kyadondo Rd, Nakasero, Kampala<br>
                Tel: <a href='tel:+256708109856'>0708 109856</a><br>
                Email: <a href='mailto:info@yujoizakaya.ug'>info@yujoizakaya.ug</a></p>
            </div>
            <div class='footer'>
                <p>© 2024 Yujo Izakaya. All rights reserved.<br>
                Zero Waste Partner of Kamikatsu, Japan</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . FROM_NAME . " <" . FROM_EMAIL . ">" . "\r\n";
    $headers .= "Reply-To: " . FROM_EMAIL . "\r\n";
    
    // Send email (use mail() for basic, or implement SMTP for production)
    mail($to, $subject, $message, $headers);
    
    // Send notification to restaurant
    $restaurant_email = "reservations@yujoizakaya.ug";
    $restaurant_subject = "New Reservation #$reservation_id - $name";
    
    $restaurant_message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .header { background: #8B0000; color: white; padding: 10px; }
            .details { padding: 20px; }
            table { width: 100%; border-collapse: collapse; }
            td, th { padding: 10px; border: 1px solid #ddd; }
            th { background: #f5f5f5; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>New Reservation Received</h2>
        </div>
        <div class='details'>
            <table>
                <tr><th>Field</th><th>Details</th></tr>
                <tr><td>Reservation ID</td><td><strong>#$reservation_id</strong></td></tr>
                <tr><td>Name</td><td>$name</td></tr>
                <tr><td>Email</td><td>$email</td></tr>
                <tr><td>Phone</td><td>$phone</td></tr>
                <tr><td>Date</td><td>$formatted_date</td></tr>
                <tr><td>Time</td><td>$formatted_time</td></tr>
                <tr><td>Guests</td><td>$guests</td></tr>
                <tr><td>Special Requests</td><td>" . ($special_requests ?: 'None') . "</td></tr>
                <tr><td>Source</td><td>$source</td></tr>
                <tr><td>Received</td><td>" . date('Y-m-d H:i:s') . "</td></tr>
            </table>
        </div>
    </body>
    </html>
    ";
    
    mail($restaurant_email, $restaurant_subject, $restaurant_message, $headers);
    
    // Return success response
    $response['success'] = true;
    $response['message'] = 'Reservation submitted successfully';
    $response['data'] = [
        'reservation_id' => $reservation_id,
        'name' => $name,
        'date' => $formatted_date,
        'time' => $formatted_time,
        'guests' => $guests
    ];
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    
    // Log error
    error_log("Reservation error: " . $e->getMessage());
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>