<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Reservation - Yujo Izakaya</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .reservation-hero {
            background: linear-gradient(rgba(139,0,0,0.9), rgba(139,0,0,0.8)), url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="1920" height="400" viewBox="0 0 1920 400"%3E%3Crect width="1920" height="400" fill="%238B0000"/%3E%3C/svg%3E');
            padding: 150px 0 80px;
            text-align: center;
            color: white;
        }
        .reservation-hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }
        .reservation-hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.9;
        }
        .reservation-wrapper {
            padding: 60px 0;
            background: #f9f9f9;
        }
        .reservation-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .reservation-header {
            background: var(--primary-color);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .reservation-header h2 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .reservation-header p {
            opacity: 0.9;
        }
        .reservation-form-container {
            padding: 3rem;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-dark);
        }
        .form-group label i {
            color: var(--primary-color);
            margin-right: 0.5rem;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #eaeaea;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: var(--transition);
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        .time-slots {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .time-slot {
            padding: 0.75rem;
            text-align: center;
            border: 2px solid #eaeaea;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
        }
        .time-slot:hover {
            border-color: var(--primary-color);
        }
        .time-slot.selected {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        .time-slot.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f5f5f5;
        }
        .reservation-info {
            background: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 2rem 0;
            border-left: 4px solid var(--primary-color);
        }
        .reservation-info h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .reservation-info ul {
            list-style: none;
        }
        .reservation-info li {
            margin: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
        }
        .reservation-info li:before {
            content: '•';
            color: var(--primary-color);
            position: absolute;
            left: 0;
            font-size: 1.2rem;
        }
        .submit-btn {
            background: var(--primary-color);
            color: white;
            padding: 1.2rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
        }
        .submit-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(139,0,0,0.3);
        }
        .availability-check {
            display: flex;
            gap: 1rem;
            align-items: center;
            background: #f0f0f0;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .availability-check i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }
        .special-requests-note {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5rem;
        }
        @media (max-width: 768px) {
            .reservation-hero h1 {
                font-size: 2.5rem;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
            .reservation-form-container {
                padding: 1.5rem;
            }
            .time-slots {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="index.php">YUJO IZAKAYA</a>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="full-menu.php">Menu</a></li>
                <li><a href="reservation.php" class="active">Reservations</a></li>
                <li><a href="index.php#contact">Contact</a></li>
                <li><a href="reservation.php" class="btn-reserve">Book Now</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="reservation-hero">
        <h1>MAKE A RESERVATION</h1>
        <p>Secure your table at Kampala's premier Japanese izakaya</p>
    </section>

    <!-- Reservation Form -->
    <section class="reservation-wrapper">
        <div class="container">
            <div class="reservation-container">
                <div class="reservation-header">
                    <h2>Book Your Table</h2>
                    <p>Open Daily: 11:30 AM - 11:00 PM | Kitchen closes at 10:30 PM</p>
                </div>
                
                <div class="reservation-form-container">
                    <!-- Availability Notice -->
                    <div class="availability-check">
                        <i class="fas fa-calendar-check"></i>
                        <div>
                            <strong>Same Day Reservations:</strong> Please call us at <a href="tel:+256708109856">0708 109856</a> for same-day bookings
                        </div>
                    </div>

                    <form id="reservationForm" action="process-reservation.php" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Your Name *</label>
                                <input type="text" name="name" required placeholder="Enter your full name">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-envelope"></i> Email Address *</label>
                                <input type="email" name="email" required placeholder="your@email.com">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Phone Number *</label>
                                <input type="tel" name="phone" required placeholder="e.g., 0708123456">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-users"></i> Number of Guests *</label>
                                <select name="guests" required>
                                    <option value="">Select number of guests</option>
                                    <option value="1">1 Person</option>
                                    <option value="2">2 People</option>
                                    <option value="3">3 People</option>
                                    <option value="4">4 People</option>
                                    <option value="5">5 People</option>
                                    <option value="6">6 People</option>
                                    <option value="7">7 People</option>
                                    <option value="8">8 People</option>
                                    <option value="9">9 People</option>
                                    <option value="10">10 People</option>
                                    <option value="12">12 People (Large Party)</option>
                                    <option value="15">15 People (Private Event)</option>
                                    <option value="20">20 People (Full Buyout)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt"></i> Reservation Date *</label>
                                <input type="date" name="date" id="reservationDate" required min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+3 months')); ?>">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-clock"></i> Preferred Time *</label>
                                <select name="time" id="reservationTime" required>
                                    <option value="">Select a time</option>
                                    <option value="11:30">11:30 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="12:30">12:30 PM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="13:30">1:30 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="14:30">2:30 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="17:30">5:30 PM</option>
                                    <option value="18:00">6:00 PM</option>
                                    <option value="18:30">6:30 PM</option>
                                    <option value="19:00">7:00 PM</option>
                                    <option value="19:30">7:30 PM</option>
                                    <option value="20:00">8:00 PM</option>
                                    <option value="20:30">8:30 PM</option>
                                    <option value="21:00">9:00 PM</option>
                                    <option value="21:30">9:30 PM</option>
                                    <option value="22:00">10:00 PM</option>
                                </select>
                            </div>
                        </div>

                        <!-- Quick Time Slot Selector -->
                        <div class="form-group">
                            <label>Quick Select Time</label>
                            <div class="time-slots" id="timeSlots">
                                <div class="time-slot" data-time="12:00">12:00 PM</div>
                                <div class="time-slot" data-time="13:00">1:00 PM</div>
                                <div class="time-slot" data-time="18:00">6:00 PM</div>
                                <div class="time-slot" data-time="19:00">7:00 PM</div>
                                <div class="time-slot" data-time="19:30">7:30 PM</div>
                                <div class="time-slot" data-time="20:00">8:00 PM</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-comment"></i> Special Requests</label>
                            <textarea name="special_requests" placeholder="Dietary restrictions, allergies, special occasions, seating preferences..."></textarea>
                            <div class="special-requests-note">
                                <i class="fas fa-info-circle"></i> We'll do our best to accommodate your requests
                            </div>
                        </div>

                        <!-- Reservation Information -->
                        <div class="reservation-info">
                            <h3><i class="fas fa-info-circle"></i> Important Information</h3>
                            <ul>
                                <li>We hold tables for 15 minutes past the reservation time</li>
                                <li>For parties of 8 or more, a 10% service charge may apply</li>
                                <li>Please inform us of any allergies or dietary restrictions</li>
                                <li>For large parties (12+), please call us directly</li>
                                <li>Free cancellation up to 2 hours before reservation</li>
                            </ul>
                        </div>

                        <!-- Private Events Notice -->
                        <div class="availability-check" style="background: #fff3cd; border-left-color: #856404;">
                            <i class="fas fa-star" style="color: #856404;"></i>
                            <div>
                                <strong>Private Events:</strong> Interested in booking the entire restaurant? Contact us for exclusive buyout options.
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-calendar-check"></i> Confirm Reservation
                        </button>
                    </form>

                    <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eaeaea;">
                        <p><strong>Prefer to call?</strong> <a href="tel:+256708109856">0708 109856</a></p>
                        <p style="color: #666; font-size: 0.9rem; margin-top: 0.5rem;">
                            <i class="fas fa-clock"></i> We're open 7 days a week from 11:30 AM to 11:00 PM
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Yujo Izakaya</h4>
                    <p>Modern Japanese Restaurant & Pub<br>Est. 2011</p>
                    <p class="footer-address">36 Kyadondo Rd, Nakasero<br>Kampala, Uganda</p>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="full-menu.php">Full Menu</a></li>
                        <li><a href="reservation.php">Reservations</a></li>
                        <li><a href="index.php#about">About Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Contact</h4>
                    <ul>
                        <li><a href="tel:+256708109856">0708 109856</a></li>
                        <li><a href="mailto:info@yujoizakaya.ug">info@yujoizakaya.ug</a></li>
                    </ul>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Yujo Izakaya. All rights reserved. | Zero Waste Partner of Kamikatsu, Japan</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
    <script>
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('reservationDate').setAttribute('min', today);

        // Time slot selector
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.addEventListener('click', function() {
                if (!this.classList.contains('disabled')) {
                    document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                    this.classList.add('selected');
                    const timeValue = this.dataset.time;
                    document.getElementById('reservationTime').value = timeValue;
                }
            });
        });

        // Form validation
        document.getElementById('reservationForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch('process-reservation.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Show success message
                    alert(`Reservation confirmed! We've sent a confirmation to ${data.email}`);
                    
                    // Redirect or clear form
                    this.reset();
                    
                    // Optionally redirect to thank you page
                    // window.location.href = 'reservation-confirmation.php?id=' + result.data.reservation_id;
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error submitting reservation. Please try again or call us directly.');
            } finally {
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Disable past times for today
        const dateInput = document.getElementById('reservationDate');
        const timeSelect = document.getElementById('reservationTime');
        
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0,0,0,0);
            
            // If selected date is today, disable past times
            if (selectedDate.getTime() === today.getTime()) {
                const now = new Date();
                const currentHour = now.getHours();
                const currentMinute = now.getMinutes();
                
                Array.from(timeSelect.options).forEach(option => {
                    if (option.value) {
                        const [hour, minute] = option.value.split(':').map(Number);
                        if (hour < currentHour || (hour === currentHour && minute <= currentMinute)) {
                            option.disabled = true;
                        } else {
                            option.disabled = false;
                        }
                    }
                });
            } else {
                // Enable all options for future dates
                Array.from(timeSelect.options).forEach(option => {
                    option.disabled = false;
                });
            }
        });
    </script>
</body>
</html>