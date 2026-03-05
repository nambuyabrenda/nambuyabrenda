<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Menu - Yujo Izakaya | Japanese Restaurant Kampala</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .menu-page-header {
            background: linear-gradient(rgba(139,0,0,0.9), rgba(139,0,0,0.9)), url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="1920" height="400" viewBox="0 0 1920 400"%3E%3Crect width="1920" height="400" fill="%238B0000"/%3E%3Ctext x="600" y="200" font-family="Arial" font-size="60" fill="%23fff"%3EYUJO MENU%3C/text%3E%3C/svg%3E');
            background-size: cover;
            padding: 150px 0 80px;
            text-align: center;
            color: white;
        }
        .menu-page-header h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .menu-page-header p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.9;
        }
        .menu-nav {
            background: white;
            padding: 1rem 0;
            position: sticky;
            top: 70px;
            z-index: 99;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .menu-nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            gap: 2rem;
            flex-wrap: wrap;
        }
        .menu-nav a {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: var(--transition);
        }
        .menu-nav a:hover,
        .menu-nav a.active {
            background: var(--primary-color);
            color: white;
        }
        .menu-section {
            padding: 60px 0;
            border-bottom: 1px solid var(--border-color);
        }
        .menu-section:last-child {
            border-bottom: none;
        }
        .menu-section h2 {
            font-size: 2.5rem;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }
        .menu-section h2:after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            margin: 1rem auto;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
        .menu-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: var(--transition);
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(139,0,0,0.2);
        }
        .menu-card-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem;
        }
        .menu-card-header h3 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0;
        }
        .menu-card-body {
            padding: 1.5rem;
        }
        .menu-description {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }
        .menu-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .menu-tag {
            background: var(--bg-gray);
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
        }
        .price-note {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-muted);
            font-style: italic;
        }
        .search-box {
            max-width: 500px;
            margin: 2rem auto;
            position: relative;
        }
        .search-box input {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 2px solid var(--border-color);
            border-radius: 50px;
            font-size: 1rem;
            transition: var(--transition);
        }
        .search-box input:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        .search-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        .filter-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
            flex-wrap: wrap;
        }
        .filter-btn {
            padding: 0.5rem 1.5rem;
            border: 2px solid var(--primary-color);
            background: transparent;
            color: var(--primary-color);
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }
        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary-color);
            color: white;
        }
        @media (max-width: 768px) {
            .menu-page-header h1 {
                font-size: 2.5rem;
            }
            .menu-grid {
                grid-template-columns: 1fr;
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
                <li><a href="full-menu.php" class="active">Menu</a></li>
                <li><a href="index.php#drinks">Drinks</a></li>
                <li><a href="reservation.php">Reservations</a></li>
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

    <!-- Page Header -->
    <header class="menu-page-header">
        <h1>OUR MENU</h1>
        <p>Authentic Japanese cuisine crafted with East African ingredients</p>
    </header>

    <!-- Menu Navigation -->
    <div class="menu-nav">
        <ul>
            <li><a href="#sushi">Sushi & Sashimi</a></li>
            <li><a href="#rolls">Specialty Rolls</a></li>
            <li><a href="#hot">Hot Dishes</a></li>
            <li><a href="#noodles">Noodles & Rice</a></li>
            <li><a href="#salads">Salads & Starters</a></li>
            <li><a href="#bento">Bento Boxes</a></li>
            <li><a href="#dessert">Desserts</a></li>
        </ul>
    </div>

    <!-- Search and Filter -->
    <div class="container">
        <div class="search-box">
            <input type="text" id="menuSearch" placeholder="Search menu...">
            <i class="fas fa-search"></i>
        </div>
        
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="vegetarian">Vegetarian</button>
            <button class="filter-btn" data-filter="spicy">Spicy</button>
            <button class="filter-btn" data-filter="signature">Signature</button>
        </div>
    </div>

    <!-- SUSHI & SASHIMI SECTION -->
    <section id="sushi" class="menu-section">
        <div class="container">
            <h2>SUSHI & SASHIMI</h2>
            
            <div class="menu-grid">
                <!-- Nigiri -->
                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Tuna Nigiri (Maguro)</span>
                            <span>30,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Fresh tuna over pressed sushi rice</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                            <span class="menu-tag">SIGNATURE</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Salmon Nigiri (Sake)</span>
                            <span>38,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Fresh salmon over pressed sushi rice</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                            <span class="menu-tag">POPULAR</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Prawn Nigiri (Ebi)</span>
                            <span>35,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Cooked prawn over sushi rice</p>
                        <div class="menu-tags">
                            <span class="menu-tag">COOKED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Octopus Nigiri (Tako)</span>
                            <span>30,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Tender octopus slice</p>
                        <div class="menu-tags">
                            <span class="menu-tag">COOKED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>BBQ Eel Nigiri (Unagi)</span>
                            <span>45,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Grilled freshwater eel with tare sauce</p>
                        <div class="menu-tags">
                            <span class="menu-tag">GRILLED</span>
                            <span class="menu-tag">PREMIUM</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Shiitake Mushroom Nigiri</span>
                            <span>25,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Marinated shiitake mushroom</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                        </div>
                    </div>
                </div>

                <!-- Sashimi -->
                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Tuna Sashimi (5pcs)</span>
                            <span>60,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Freshly sliced yellowfin tuna</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                            <span class="menu-tag">SIGNATURE</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Salmon Sashimi (5pcs)</span>
                            <span>78,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Fresh Norwegian salmon</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                            <span class="menu-tag">PREMIUM</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Scallop Sashimi (5pcs)</span>
                            <span>95,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Fresh Hokkaido scallops</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                            <span class="menu-tag">PREMIUM</span>
                        </div>
                    </div>
                </div>

                <!-- Gunkan Maki -->
                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Flying Fish Roe (Tobiko)</span>
                            <span>38,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Gunkan style with crispy seaweed</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Salmon Roe (Ikura)</span>
                            <span>50,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Baby salmon caviar</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                            <span class="menu-tag">PREMIUM</span>
                        </div>
                    </div>
                </div>

                <!-- Temaki (Hand Rolls) -->
                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Tuna Temaki</span>
                            <span>30,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Cone-shaped hand roll with fresh tuna</p>
                        <div class="menu-tags">
                            <span class="menu-tag">HAND ROLL</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SPECIALTY ROLLS SECTION -->
    <section id="rolls" class="menu-section">
        <div class="container">
            <h2>SPECIALTY ROLLS</h2>
            <p class="section-description">All rolls are 8 pieces | *Seafood has seasons. Ask about availability</p>
            
            <div class="menu-grid">
                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Black Dragon Roll</span>
                            <span>95,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Outside: Grilled unagi, chives, sesame, tare sauce. Inside: Prawn tempura, cucumber, leaf lettuce</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SIGNATURE</span>
                            <span class="menu-tag">COOKED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Rainbow Roll</span>
                            <span>62,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Outside: Tuna, salmon, avocado, red snapper, prawn, mango. Inside: Cucumber, avocado, kani</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                            <span class="menu-tag">POPULAR</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="true">
                    <div class="menu-card-header">
                        <h3>
                            <span>Red Dragon 2.0</span>
                            <span>75,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Outside: Tuna, orange caviar, crunchy tenkasu. Inside: Salmon, mozzarella, prawn tempura</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SIGNATURE</span>
                            <span class="menu-tag">SPICY</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="true">
                    <div class="menu-card-header">
                        <h3>
                            <span>Spicy Crunchy Tuna</span>
                            <span>55,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Tuna, cucumber, avocado, spicy mayo, crunch</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SPICY</span>
                            <span class="menu-tag">RAW</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Double Salmon Aburi</span>
                            <span>85,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Outside: Seared salmon, crunchy tenkasu, chives, sesame sauce. Inside: Salmon, cream cheese, cucumber</p>
                        <div class="menu-tags">
                            <span class="menu-tag">ABURI</span>
                            <span class="menu-tag">TORCHED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Prawn Wrapped Dragon</span>
                            <span>85,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Inside: 2x crispy prawn, cucumber, avocado. Outside: 3x steamed prawn</p>
                        <div class="menu-tags">
                            <span class="menu-tag">COOKED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Norwegian Caterpillar</span>
                            <span>80,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Outside: Salmon, spring onion, crunchy tenkasu. Inside: Kani, avocado, cucumber</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Scallop Aburi Dragon</span>
                            <span>82,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Outside: Sliced & torched scallop, crunchy tenkasu, chives. Inside: Crispy prawn, cucumber, avocado</p>
                        <div class="menu-tags">
                            <span class="menu-tag">ABURI</span>
                            <span class="menu-tag">PREMIUM</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Volcano Roll (Crispy)</span>
                            <span>75,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Outside: Tobiko, crunchy tenkasu, spring onion, spicy aioli. Inside: Salmon, cucumber, avocado, mango</p>
                        <div class="menu-tags">
                            <span class="menu-tag">CRISPY</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOT DISHES SECTION -->
    <section id="hot" class="menu-section">
        <div class="container">
            <h2>HOT DISHES</h2>
            
            <div class="menu-grid">
                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Kara Age Chicken</span>
                            <span>36,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Crispy bite-sized morsels of chicken, tangy aioli, lemon wedge</p>
                        <div class="menu-tags">
                            <span class="menu-tag">FRIED</span>
                            <span class="menu-tag">POPULAR</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Pork Katsu Curry</span>
                            <span>48,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Breaded pork cutlet with traditional Japanese curry sauce, carrot, onion, potato. Served with rice</p>
                        <div class="menu-tags">
                            <span class="menu-tag">CURRY</span>
                            <span class="menu-tag">KATSU</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Vegetable Katsu Curry</span>
                            <span>38,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Aubergine schnitzel with Japanese curry sauce</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                            <span class="menu-tag">CURRY</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Teriyaki Salmon</span>
                            <span>125,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Grilled salmon steak with teriyaki glaze, served with market fresh veggies</p>
                        <div class="menu-tags">
                            <span class="menu-tag">GRILLED</span>
                            <span class="menu-tag">PREMIUM</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Chicken Yakitori (4pcs)</span>
                            <span>42,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Chicken and spring onion skewers with savory sweet soy glaze</p>
                        <div class="menu-tags">
                            <span class="menu-tag">GRILLED</span>
                            <span class="menu-tag">SKEWER</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Gyoza (6pcs)</span>
                            <span>32,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Pan-fried pork dumplings with soy vinaigrette. Homemade rayu chili oil optional</p>
                        <div class="menu-tags">
                            <span class="menu-tag">DUMPLINGS</span>
                            <span class="menu-tag">APPETIZER</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Vegetable Gyoza (6pcs)</span>
                            <span>29,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Crispy vegetable dumplings with soy vinaigrette</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Age Dashi Tofu</span>
                            <span>22,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Soft tofu blocks with crisp exterior, sweetened soy broth, spring onion</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Tatsuta-Age Chicken</span>
                            <span>38,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Deep fried chicken with Nara style marination, lemon wedge, tangy aioli</p>
                        <div class="menu-tags">
                            <span class="menu-tag">FRIED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Pork Butayaki</span>
                            <span>45,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Sliced pork with teriyaki glaze</p>
                        <div class="menu-tags">
                            <span class="menu-tag">GRILLED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Sweet & Sour Sake Prawns (6pcs)</span>
                            <span>95,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Sake prawns with sweet and sour sauce, market fresh veggies, steamed rice</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SIGNATURE</span>
                            <span class="menu-tag">PRAWNS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NOODLES & RICE SECTION -->
    <section id="noodles" class="menu-section">
        <div class="container">
            <h2>NOODLES & RICE</h2>
            
            <div class="menu-grid">
                <!-- Ramen -->
                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Shoyu Ramen</span>
                            <span>38,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Noodles handmade with East African wheat flour. Choice of chicken paitan or veggie broth</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SOUP</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Miso Ramen</span>
                            <span>42,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Rich miso broth with handmade noodles, choice of chicken paitan or veggie broth</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SOUP</span>
                            <span class="menu-tag">MISO</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Tempura Udon</span>
                            <span>52,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Hot udon noodles with 2pcs prawn tempura</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SOUP</span>
                            <span class="menu-tag">TEMPURA</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Vegetable Tempura Udon</span>
                            <span>45,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Hot udon with mixed vegetable tempura</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SOUP</span>
                            <span class="menu-tag">VEGETARIAN</span>
                        </div>
                    </div>
                </div>

                <!-- Mazemen (Soupless) -->
                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Mazemen</span>
                            <span>42,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Soupless ramen for mixing. Marinated egg, sesame, bean sprout, menma bamboo shoot, shoyu tare. Choice of chicken/beef/pork</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SOUPLESS</span>
                            <span class="menu-tag">SIGNATURE</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Tsukemen</span>
                            <span>42,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Soupless ramen for dipping. Concentrated shoyu tare sauce. Choice of chicken/beef/pork</p>
                        <div class="menu-tags">
                            <span class="menu-tag">DIPPING</span>
                            <span class="menu-tag">SIGNATURE</span>
                        </div>
                    </div>
                </div>

                <!-- Yaki Noodles -->
                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Yaki Soba</span>
                            <span>33,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Ramen noodles pan fried with market vegetables. Choice of veggie, chicken, beef, pork, seafood</p>
                        <div class="menu-tags">
                            <span class="menu-tag">STIR-FRY</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Yaki Udon</span>
                            <span>33,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Udon noodles pan fried with market vegetables</p>
                        <div class="menu-tags">
                            <span class="menu-tag">STIR-FRY</span>
                        </div>
                    </div>
                </div>

                <!-- Curry Udon -->
                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Curry Udon</span>
                            <span>38,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Thick udon in Japanese curry gravy with carrot, onion, spring onion, potato, green pepper</p>
                        <div class="menu-tags">
                            <span class="menu-tag">CURRY</span>
                        </div>
                    </div>
                </div>

                <!-- Rice Bowls -->
                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Chicken Katsu Don</span>
                            <span>50,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Rice bowl with chicken cutlet, egg, and onions in sweet soy sauce</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RICE BOWL</span>
                            <span class="menu-tag">DONBURI</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Kinoko Tofu Don</span>
                            <span>45,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Shiitake mushroom, oyster mushroom, tofu, spring onion, sweet shoyu</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                            <span class="menu-tag">MUSHROOM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SALADS & STARTERS SECTION -->
    <section id="salads" class="menu-section">
        <div class="container">
            <h2>SALADS & STARTERS</h2>
            
            <div class="menu-grid">
                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Wakame Salad</span>
                            <span>35,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Seaweed, leaf lettuce, fresh vegetables. Choice of marinated crispy tofu, chicken, or octopus</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SEAWEED</span>
                            <span class="menu-tag">HEALTHY</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Chicken Ginger Salad</span>
                            <span>39,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Leaf lettuce, cabbage, avocado, orange. Choice of sesame or shoyu ginger vinaigrette</p>
                        <div class="menu-tags">
                            <span class="menu-tag">GINGER</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>House Avocado Salad</span>
                            <span>27,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Avocado slices, shredded cabbage, shiso, shoyu ginger vinaigrette</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                            <span class="menu-tag">AVOCADO</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Tuna Tataki</span>
                            <span>65,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Seared tuna, sliced and sprinkled with toasted sesame, served with shredded cabbage, garlic chips, ponzu vinaigrette</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SIGNATURE</span>
                            <span class="menu-tag">SEARED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Tuna Tartare</span>
                            <span>65,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Raw seasoned tuna, avocado, ponzu dressing, sesame, wasabi</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                            <span class="menu-tag">SIGNATURE</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Salmon Ponzu Salad</span>
                            <span>75,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Cubed salmon sashimi, avocado, mango, ponzu dressing, wasabi</p>
                        <div class="menu-tags">
                            <span class="menu-tag">RAW</span>
                            <span class="menu-tag">PONZU</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Moyashi Salad</span>
                            <span>25,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Fresh bean sprout, leaf lettuce, sesame dressing</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                            <span class="menu-tag">LIGHT</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Nasu Dengaku</span>
                            <span>30,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Sliced aubergines, pan grilled with miso</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                            <span class="menu-tag">MISO</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TEMPURA & FRIED SECTION -->
    <section id="tempura" class="menu-section">
        <div class="container">
            <h2>TEMPURA & FRIED</h2>
            
            <div class="menu-grid">
                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Vegetable Tempura</span>
                            <span>34,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Thinly sliced veggies delicately fried, served with light sweet dip</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                            <span class="menu-tag">TEMPURA</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Prawn Tempura (2pcs)</span>
                            <span>39,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Tail-on prawns in light tempura batter</p>
                        <div class="menu-tags">
                            <span class="menu-tag">TEMPURA</span>
                            <span class="menu-tag">PRAWNS</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Mixed Tempura</span>
                            <span>65,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Assorted vegetables and seafood tempura</p>
                        <div class="menu-tags">
                            <span class="menu-tag">TEMPURA</span>
                            <span class="menu-tag">ASSORTED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Fish Furai</span>
                            <span>60,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Fish fillet fried with panko, sweet shoyu dipping sauce. Served with choice of rice or fries</p>
                        <div class="menu-tags">
                            <span class="menu-tag">FRIED</span>
                            <span class="menu-tag">PANKO</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Chicken Katsu</span>
                            <span>55,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Sliced crunchy chicken cutlet, shredded cabbage, ground sesame, sweet katsu sauce</p>
                        <div class="menu-tags">
                            <span class="menu-tag">KATSU</span>
                            <span class="menu-tag">POPULAR</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Pork Katsu</span>
                            <span>55,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Sliced crunchy pork cutlet, shredded cabbage, ground sesame, sweet katsu sauce</p>
                        <div class="menu-tags">
                            <span class="menu-tag">KATSU</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Ika Kara Age (Calamari)</span>
                            <span>48,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Crispy fried squid, tangy aioli, lemon wedge</p>
                        <div class="menu-tags">
                            <span class="menu-tag">FRIED</span>
                            <span class="menu-tag">CALAMARI</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Shiitake Furai</span>
                            <span>32,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Crispy fried shiitake mushrooms</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                            <span class="menu-tag">MUSHROOM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BENTO BOXES SECTION -->
    <section id="bento" class="menu-section">
        <div class="container">
            <h2>BENTO BOXES</h2>
            <p class="section-description">Lunch boxes served with miso soup</p>
            
            <div class="menu-grid">
                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Yujo Bento</span>
                            <span>52,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Chef's choice inside out roll, prawn tempura, gyoza, and salad</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SIGNATURE</span>
                            <span class="menu-tag">BEST SELLER</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Sushi Bento</span>
                            <span>68,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Assorted nigiri sushi, maki rolls, tempura, and salad</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SUSHI</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Grilled Salmon Bento</span>
                            <span>85,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Grilled medallion of salmon, steamed rice, gyoza, and salad</p>
                        <div class="menu-tags">
                            <span class="menu-tag">GRILLED</span>
                            <span class="menu-tag">PREMIUM</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Kara Age Bento</span>
                            <span>48,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Lightly battered and fried chicken nuggets, steamed rice, gyoza, salad</p>
                        <div class="menu-tags">
                            <span class="menu-tag">CHICKEN</span>
                            <span class="menu-tag">FRIED</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Katsu Bento</span>
                            <span>50,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Crispy strips of pork/chicken cutlet, steamed rice, gyoza, salad</p>
                        <div class="menu-tags">
                            <span class="menu-tag">KATSU</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Unagi Bento</span>
                            <span>110,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">100g grilled freshwater eel, vegetable tempura, gyoza, salad</p>
                        <div class="menu-tags">
                            <span class="menu-tag">PREMIUM</span>
                            <span class="menu-tag">UNAGI</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Kinoko Tofu Bento</span>
                            <span>48,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Shiitake mushroom, oyster mushroom, tofu, spring onion, sweet shoyu, veggie gyoza, salad</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                            <span class="menu-tag">MUSHROOM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- DESSERTS SECTION -->
    <section id="dessert" class="menu-section">
        <div class="container">
            <h2>DESSERTS</h2>
            
            <div class="menu-grid">
                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Tiramasu</span>
                            <span>20,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Tiramisu + masu = Japanese-style tiramisu</p>
                        <div class="menu-tags">
                            <span class="menu-tag">DESSERT</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>New York Style Cheesecake</span>
                            <span>25,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Thick slice of rich cheesecake made with cream cheese from R.E.A.L. (Revival of East African Ladies). Please wait for it to soften.</p>
                        <div class="menu-tags">
                            <span class="menu-tag">CHEESECAKE</span>
                            <span class="menu-tag">LOCAL</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>French Style Tart of the Day</span>
                            <span>20,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Homemade pastry crust filled with seasonal fruits</p>
                        <div class="menu-tags">
                            <span class="menu-tag">TART</span>
                            <span class="menu-tag">SEASONAL</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Craft Chocolate Snicker Bar</span>
                            <span>25,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Latitude chocolate bar filled with layered cream, peanuts, and caramel</p>
                        <div class="menu-tags">
                            <span class="menu-tag">CHOCOLATE</span>
                            <span class="menu-tag">CRAFT</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Matcha Ice Cream</span>
                            <span>7,000 UGX / 15,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Guinomi (small) 7k | Masu (medium) 15k</p>
                        <div class="menu-tags">
                            <span class="menu-tag">MATCHA</span>
                            <span class="menu-tag">ICE CREAM</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Gourmand</span>
                            <span>35,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Selection of 4 super-mini desserts, served with choice of Japanese tea, black tea, or coffee</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SAMPLER</span>
                            <span class="menu-tag">TEA PAIRING</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Mini Chocolate Mousse Guinomi</span>
                            <span>7,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">A very tiny Latitude chocolate mousse served in a sake cup. Please wait for it to soften.</p>
                        <div class="menu-tags">
                            <span class="menu-tag">MOUSSE</span>
                            <span class="menu-tag">MINI</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CRAFT BURGERS SECTION -->
    <section id="burgers" class="menu-section">
        <div class="container">
            <h2>CRAFT BURGERS</h2>
            <p class="section-description">On homemade brioche bun with a Japanese touch</p>
            
            <div class="menu-grid">
                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="true">
                    <div class="menu-card-header">
                        <h3>
                            <span>Buffalo Chicken Burger</span>
                            <span>42,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Spicy chicken breast, shredded lettuce, QP mayo, panko, served with fries</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SPICY</span>
                            <span class="menu-tag">CHICKEN</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Romeoville BBQ Chicken Burger</span>
                            <span>42,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">BBQ chicken breast, shredded lettuce, QP mayo, panko, fries</p>
                        <div class="menu-tags">
                            <span class="menu-tag">BBQ</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Li San's Cheese Slam Burger</span>
                            <span>45,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Juicy 250g beef patty, UG mozzarella, red onion, tomato, lettuce, Japanese aioli, fries. Choice of cheese: goat's/camembert/mozzarella</p>
                        <div class="menu-tags">
                            <span class="menu-tag">BEEF</span>
                            <span class="menu-tag">CHEESE</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="signature" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Yakuza Chashu Burger</span>
                            <span>49,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Crumbled pork chashu, juicy 250g beef patty, UG mozzarella, panko onion rings, lettuce, Japanese aioli, fries</p>
                        <div class="menu-tags">
                            <span class="menu-tag">SIGNATURE</span>
                            <span class="menu-tag">CHASHU</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="vegetarian" data-vegetarian="true" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Mushroom Slam Burger</span>
                            <span>39,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Juicy 250g patty of oyster mushrooms, onions, carrot & diced tofu, crispy red onion, green pepper, Japanese aioli, fries</p>
                        <div class="menu-tags">
                            <span class="menu-tag">VEGETARIAN</span>
                            <span class="menu-tag">MUSHROOM</span>
                        </div>
                    </div>
                </div>

                <div class="menu-card" data-category="" data-vegetarian="false" data-spicy="false">
                    <div class="menu-card-header">
                        <h3>
                            <span>Katsu Burger</span>
                            <span>39,000 UGX</span>
                        </h3>
                    </div>
                    <div class="menu-card-body">
                        <p class="menu-description">Chicken or pork katsu, shredded cabbage, chips, tangy mayo</p>
                        <div class="menu-tags">
                            <span class="menu-tag">KATSU</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Note about seafood seasons -->
    <div class="container">
        <div class="price-note">
            <p><i class="fas fa-fish"></i> Seafood has seasons. Please ask about availability of specific items.</p>
            <p>* All prices are in '000 UGX. 10% service charge may apply.</p>
        </div>
    </div>

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
                    <h4>Menu Categories</h4>
                    <ul>
                        <li><a href="#sushi">Sushi & Sashimi</a></li>
                        <li><a href="#rolls">Specialty Rolls</a></li>
                        <li><a href="#hot">Hot Dishes</a></li>
                        <li><a href="#noodles">Noodles & Rice</a></li>
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
    <script>
        // Menu search functionality
        document.getElementById('menuSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const menuCards = document.querySelectorAll('.menu-card');
            
            menuCards.forEach(card => {
                const title = card.querySelector('h3 span:first-child').textContent.toLowerCase();
                const description = card.querySelector('.menu-description').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                const menuCards = document.querySelectorAll('.menu-card');
                
                menuCards.forEach(card => {
                    if (filter === 'all') {
                        card.style.display = 'block';
                    } else if (filter === 'vegetarian') {
                        if (card.dataset.vegetarian === 'true') {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    } else if (filter === 'spicy') {
                        if (card.dataset.spicy === 'true') {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    } else if (filter === 'signature') {
                        if (card.dataset.category === 'signature') {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            });
        });

        // Smooth scroll for menu navigation
        document.querySelectorAll('.menu-nav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    const offset = 140;
                    const targetPosition = targetElement.offsetTop - offset;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Update active class
                    document.querySelectorAll('.menu-nav a').forEach(a => a.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });

        // Update active menu nav on scroll
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('.menu-section');
            const navLinks = document.querySelectorAll('.menu-nav a');
            const offset = 150;
            
            sections.forEach((section, index) => {
                const sectionTop = section.offsetTop - offset;
                const sectionBottom = sectionTop + section.offsetHeight;
                
                if (window.scrollY >= sectionTop && window.scrollY < sectionBottom) {
                    navLinks.forEach(link => link.classList.remove('active'));
                    navLinks[index].classList.add('active');
                }
            });
        });
    </script>
</body>
</html>