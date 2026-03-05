<?php
// Start session for any user messages
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yujo Izakaya - Modern Japanese Restaurant & Pub in Kampala</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" type="images/yujo.png" href="images/yujo.png">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="index.php">YUJO IZAKAYA</a>
            </div>
            <ul class="nav-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#drinks">Drinks</a></li>
                <li><a href="#sake">Sake & Shochu</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="reservation.php" class="btn-reserve">Reserve</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-subtitle">Est. 2011</span>
            <h1>HELLO SUNSHINE!</h1>
            <p class="hero-description">Modern Japanese Izakaya • Sushi Bar • Teppanyaki Grill</p>
            <p class="hero-address">36 Kyadondo Rd, Nakasero, Kampala</p>
            <div class="hero-buttons">
                <a href="#menu" class="btn-primary">Explore Menu</a>
                <a href="reservation.php" class="btn-secondary">Make a Reservation</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <span class="section-subtitle">Our Story</span>
                    <h2>Welcome to Yujo Izakaya</h2>
                    <p class="about-highlight">"Yujo" means friendship, and we've built lasting friendships with our guests over a decade of exceptional dining.</p>
                    
                    <div class="about-features">
                        <div class="feature">
                            <i class="fas fa-fish"></i>
                            <h3>Fresh Seafood</h3>
                            <p>Sourcing from East African coast, featuring tuna, snapper, and local specialties</p>
                        </div>
                        <div class="feature">
                            <i class="fas fa-fire"></i>
                            <h3>Chef Jackie Tuck</h3>
                            <p>Leading our 90% female kitchen team with passion and precision</p>
                        </div>
                        <div class="feature">
                            <i class="fas fa-leaf"></i>
                            <h3>Zero Waste</h3>
                            <p>Partnering with Kamikatsu, Japan's first Zero Waste village</p>
                        </div>
                    </div>

                    <div class="chef-story">
                        <h3>The Story of Chef Jackie Tuck</h3>
                        <p>Jackie san hails from the Northern part of Uganda, and she's here burning things up in the kitchen to prove a point. The team at Yujo Izakaya is now roughly 90% female. What can we say, this trend is doing pretty well for us, and we're gonna ride with it into the sunset.</p>
                    </div>

                    <div class="hours">
                        <h3>Hours</h3>
                        <p><i class="far fa-clock"></i> Open Daily: 11:30 AM - 11:00 PM</p>
                        <p><i class="fas fa-utensils"></i> Kitchen closes at 10:30 PM</p>
                        <p><i class="fas fa-phone"></i> <a href="tel:+256708109856">0708 109856</a></p>
                    </div>
                </div>
                <div class="about-image">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='600' height='800' viewBox='0 0 600 800'%3E%3Crect width='600' height='800' fill='%238B0000'/%3E%3Ctext x='100' y='400' font-family='Arial' font-size='30' fill='%23fff'%3EYujo Izakaya%3C/text%3E%3C/svg%3E" alt="Yujo Izakaya Interior">
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Preview Section -->
    <section id="menu" class="menu-preview">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">Our Offerings</span>
                <h2>Signature Dishes</h2>
            </div>
            
            <div class="menu-categories">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-fish"></i>
                    </div>
                    <h3>Sushi & Sashimi</h3>
                    <ul>
                        <li>Tuna Nigiri <span>30k</span></li>
                        <li>Salmon Sashimi <span>78k</span></li>
                        <li>Black Dragon Roll <span>95k</span></li>
                        <li>Rainbow Roll <span>62k</span></li>
                    </ul>
                    <a href="full-menu.php#sushi" class="category-link">View All →</a>
                </div>

                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <h3>Hot Dishes</h3>
                    <ul>
                        <li>Kara Age Chicken <span>36k</span></li>
                        <li>Pork Katsu Curry <span>48k</span></li>
                        <li>Teriyaki Salmon <span>125k</span></li>
                        <li>Gyoza (6pcs) <span>32k</span></li>
                    </ul>
                    <a href="full-menu.php#hot" class="category-link">View All →</a>
                </div>

                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-wine-bottle"></i>
                    </div>
                    <h3>Japanese Sake</h3>
                    <ul>
                        <li>Hakutsuru Junmai <span>23k/glass</span></li>
                        <li>Kikusakari <span>20k/glass</span></li>
                        <li>Sparkling Sake <span>700k/bottle</span></li>
                    </ul>
                    <a href="#sake" class="category-link">View All →</a>
                </div>
            </div>
            
            <div class="menu-footer">
                <a href="full-menu.php" class="btn-primary">View Full Menu</a>
            </div>
        </div>
    </section>

    <!-- Sake & Shochu Section -->
    <section id="sake" class="sake-section">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">Japanese Specialties</span>
                <h2>Sake & Shochu Selection</h2>
            </div>

            <div class="sake-grid">
                <div class="sake-category">
                    <h3><i class="fas fa-wine-bottle"></i> Junmai Sake</h3>
                    <div class="sake-items" id="junmai-list">
                        <!-- Loaded via JavaScript -->
                    </div>
                </div>
                
                <div class="sake-category">
                    <h3><i class="fas fa-wine-glass-alt"></i> Daiginjo & Premium</h3>
                    <div class="sake-items" id="daiginjo-list">
                        <!-- Loaded via JavaScript -->
                    </div>
                </div>
                
                <div class="sake-category">
                    <h3><i class="fas fa-flask"></i> Shochu</h3>
                    <div class="sake-items" id="shochu-list">
                        <!-- Loaded via JavaScript -->
                    </div>
                </div>
            </div>

            <div class="sake-note">
                <p><i class="fas fa-info-circle"></i> How to drink Shochu - Japanese style: Add ice cube, still water, or hot water. Ask our staff for recommendations!</p>
            </div>
        </div>
    </section>

    <!-- Cocktails Section -->
    <section id="drinks" class="cocktails-section">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">Bar Menu</span>
                <h2>Signature Cocktails</h2>
                <p class="section-description">Crafted with Japanese spirits and fresh ingredients</p>
            </div>

            <div class="cocktails-grid" id="cocktails-grid">
                <!-- Loaded via JavaScript -->
            </div>

            <div class="cocktails-note">
                <p>* Note: All prices are in '000 UGX</p>
                <a href="full-menu.php#drinks" class="btn-secondary">View All Drinks</a>
            </div>
        </div>
    </section>

    <!-- Zero Waste Story -->
    <section class="zero-waste">
        <div class="container">
            <div class="waste-content">
                <span class="section-subtitle">Sustainability</span>
                <h2>Zero Waste Story</h2>
                <p>Tying Yujo Izakaya to Kamikatsu, Japan's first Zero Waste village. Nestled amongst the cedar forested mountains of Shikoku Island, we've partnered with this tiny village with a big reputation to bring you Awa Bancha tea and sustainable practices.</p>
                
                <div class="waste-features">
                    <div class="waste-item">
                        <i class="fas fa-recycle"></i>
                        <h4>Glass Upcycling</h4>
                        <p>Partnered with Good Glass since 2012</p>
                    </div>
                    <div class="waste-item">
                        <i class="fas fa-seedling"></i>
                        <h4>Local Sourcing</h4>
                        <p>East African rice for sake brewing</p>
                    </div>
                    <div class="waste-item">
                        <i class="fas fa-leaf"></i>
                        <h4>Awa Bancha Tea</h4>
                        <p>Traditional lactic acid tea from Kamikatsu</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <span class="section-subtitle">Visit Us</span>
                    <h2>Find Yujo Izakaya</h2>
                    
                    <div class="info-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Address</h3>
                            <p>36 Kyadondo Rd, Nakasero<br>Kampala, Uganda</p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p><a href="tel:+256708109856">0708 109856</a></p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p><a href="mailto:info@yujoizakaya.ug">info@yujoizakaya.ug</a></p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3>Hours</h3>
                            <p>Open Daily: 11:30 AM - 11:00 PM</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h2>Quick Reservation</h2>
                    <form id="quick-reservation" action="process-reservation.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <input type="date" name="date" required>
                            </div>
                            <div class="form-group">
                                <input type="time" name="time" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <select name="guests" required>
                                <option value="">Number of Guests</option>
                                <option value="1">1 Person</option>
                                <option value="2">2 People</option>
                                <option value="3">3 People</option>
                                <option value="4">4 People</option>
                                <option value="5">5 People</option>
                                <option value="6">6 People</option>
                                <option value="8">8 People</option>
                                <option value="10">10+ People</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary">Request Reservation</button>
                    </form>
                </div>
            </div>
            
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7475!2d32.5775!3d0.3156!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMTgnNTYuMiJOIDMywqAzNCczOS4wIkU!5e0!3m2!1sen!2sug!4v1620000000000!5m2!1sen!2sug" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
                        <li><a href="#about">About Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Menu Categories</h4>
                    <ul>
                        <li><a href="full-menu.php#sushi">Sushi & Sashimi</a></li>
                        <li><a href="full-menu.php#rolls">Specialty Rolls</a></li>
                        <li><a href="full-menu.php#hot">Hot Dishes</a></li>
                        <li><a href="full-menu.php#noodles">Noodles & Rice</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                    <p class="footer-phone"><i class="fas fa-phone"></i> <a href="tel:+256708109856">0708 109856</a></p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Yujo Izakaya. All rights reserved. | Zero Waste Partner of Kamikatsu, Japan</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>