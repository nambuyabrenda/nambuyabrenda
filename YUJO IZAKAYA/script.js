// script.js - Complete JavaScript for Yujo Izakaya

// DOM Elements
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const navbar = document.querySelector('.navbar');
const reservationForm = document.getElementById('quick-reservation');

// Mobile Menu Toggle
if (hamburger) {
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    });
}

// Close mobile menu when clicking a link
document.querySelectorAll('.nav-menu a').forEach(link => {
    link.addEventListener('click', () => {
        hamburger.classList.remove('active');
        navMenu.classList.remove('active');
        document.body.classList.remove('menu-open');
    });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Navbar scroll effect
window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Menu Data from PDFs
const menuData = {
    sake: {
        junmai: [
            { name: "Hakutsuru Excellent Junmai", glass: 23, bottle720: 140, bottle1800: 420, abv: 15, notes: "720ml / 1.8L" },
            { name: "Hakutsuru Organic Junmai", bottle: 300, abv: 14.5, notes: "720ml bottle" },
            { name: "Kikusakari Junmaishu", glass: 20, bottle720: 180, bottle1800: 320, abv: 15, notes: "720ml / 1.8L" }
        ],
        daiginjo: [
            { name: "Kikusakari Junmai Daiginjo", bottle: 480, abv: 16, notes: "720ml bottle" },
            { name: "Kikusakari Junmai Tarusake", glass: 25, bottle: 480, abv: 15, notes: "1.8L" },
            { name: "Keigetsu Gin no Yume", bottle: 420, abv: 15, notes: "720ml" }
        ],
        special: [
            { name: "Keigetsu Sparkling John", bottle: 700, abv: 15, notes: "750ml" },
            { name: "Sake Nature", bottle: 580, abv: 15, notes: "720ml" },
            { name: "Keigetsu Nigori", bottle: 176, abv: 15, notes: "300ml" }
        ]
    },
    shochu: [
        { name: "Kuro Shiranami", glass: 27, bottle: 240, abv: 25, notes: "900ml" },
        { name: "Satsuma Shiranami", glass: 22, bottle: 200, abv: 25, notes: "900ml" },
        { name: "Sakura Shiranami", glass: 27, bottle: 200, abv: 25, notes: "720ml" },
        { name: "Hakutake Yuzumon", glass: 40, bottle: 300, abv: 8, notes: "Yuzu flavored" },
        { name: "Nikaido Kickchomu", shot: 23, bottle: 680, abv: 25, notes: "720ml" },
        { name: "Amatsukaze", shot: 22, bottle: 640, abv: 37, notes: "720ml" }
    ],
    cocktails: [
        { name: "Sake Mojito", price: 30, ingredients: ["sake", "mint leaves", "sour mix"], description: "Refreshing mint and sake combination" },
        { name: "Sake Lemonade", price: 25, ingredients: ["house sake", "lemon juice"], description: "Simple and crisp" },
        { name: "Japanese Old Fashioned", price: 30, ingredients: ["bourbon", "cubed sugar", "orange zest"], description: "Classic with a Japanese twist" },
        { name: "Negroni", price: 28, ingredients: ["gin", "Italian bitters", "sweet vermouth"], description: "Bitter and balanced" },
        { name: "Ume Sour", price: 20, ingredients: ["umeshu", "sour mix"], description: "Sweet plum wine sour" },
        { name: "Midori Illusion", price: 28, ingredients: ["melon liqueur", "vodka", "sour mix"], description: "Sweet melon martini" },
        { name: "Scottish Spritz", price: 38, ingredients: ["hendrick's", "sour mix", "sparkling wine", "soda"], description: "Elegant and refreshing" },
        { name: "Igaku Sour", price: 30, ingredients: ["kwv brandy", "ginger", "lemon", "honey"], description: "Sweet and spicy" }
    ],
    umeshu: [
        { name: "Umeshu Kuro", glass: 52, bottle: 380, abv: 18, notes: "Rich plum wine" },
        { name: "Aragoshi Umeshu", glass: 47, bottle: 340, abv: 12, notes: "Smooth and pulpy" },
        { name: "Kiuchi Umeshu", glass: 30, bottle500: 200, bottle1800: 500, abv: 14.5, notes: "500ml / 1.8L" },
        { name: "Sparkling Umeshu", bottle: 160, abv: 6, notes: "300ml bottle" }
    ],
    whisky: [
        { name: "Nikka Pure Malt Black", shot: 35, bottle50cl: 600, notes: "50cl" },
        { name: "Hibiki", shot: 50, bottle: 1350, abv: 43, notes: "Harmony blend" },
        { name: "Yoichi Single Malt", shot: 50, bottle: 1300, notes: "Peaty and rich" },
        { name: "Nikka Coffey Malt", shot: 40, bottle: 950, notes: "Smooth grain" },
        { name: "Suntory Kakubin", shot: 15, notes: "Everyday whisky" }
    ]
};

// Load Sake Items
function loadSakeItems() {
    const junmaiList = document.getElementById('junmai-list');
    const daiginjoList = document.getElementById('daiginjo-list');
    const shochuList = document.getElementById('shochu-list');
    
    if (junmaiList) {
        junmaiList.innerHTML = menuData.sake.junmai.map(item => `
            <div class="sake-item">
                <div class="sake-info">
                    <h4>${item.name}</h4>
                    <span class="sake-notes">${item.abv}% ABV | ${item.notes || ''}</span>
                </div>
                <div class="sake-price">
                    ${item.glass ? `${item.glass}k` : ''}
                    ${item.bottle ? ` • ${item.bottle}k` : ''}
                </div>
            </div>
        `).join('');
    }
    
    if (daiginjoList) {
        daiginjoList.innerHTML = menuData.sake.daiginjo.map(item => `
            <div class="sake-item">
                <div class="sake-info">
                    <h4>${item.name}</h4>
                    <span class="sake-notes">${item.abv}% ABV | ${item.notes || ''}</span>
                </div>
                <div class="sake-price">
                    ${item.glass ? `${item.glass}k` : ''}
                    ${item.bottle ? `${item.bottle}k` : ''}
                </div>
            </div>
        `).join('');
    }
    
    if (shochuList) {
        shochuList.innerHTML = menuData.shochu.map(item => `
            <div class="sake-item">
                <div class="sake-info">
                    <h4>${item.name}</h4>
                    <span class="sake-notes">${item.abv}% ABV | ${item.notes || ''}</span>
                </div>
                <div class="sake-price">
                    ${item.glass ? `${item.glass}k glass` : ''}
                    ${item.shot ? `${item.shot}k shot` : ''}
                    ${item.bottle ? ` • ${item.bottle}k` : ''}
                </div>
            </div>
        `).join('');
    }
}

// Load Cocktails
function loadCocktails() {
    const cocktailsGrid = document.getElementById('cocktails-grid');
    
    if (cocktailsGrid) {
        cocktailsGrid.innerHTML = menuData.cocktails.map(cocktail => `
            <div class="cocktail-card">
                <div class="cocktail-header">
                    <h3>${cocktail.name}</h3>
                    <div class="cocktail-price">${cocktail.price},000 UGX</div>
                </div>
                <div class="cocktail-body">
                    <ul class="cocktail-ingredients">
                        ${cocktail.ingredients.map(ing => `<li>${ing}</li>`).join('')}
                    </ul>
                    <p class="cocktail-description">${cocktail.description}</p>
                </div>
            </div>
        `).join('');
    }
}

// Quick Reservation Form
if (reservationForm) {
    reservationForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(reservationForm);
        const data = Object.fromEntries(formData);
        
        // Add source to identify it's from quick form
        data.source = 'quick_reservation';
        
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
                alert('Reservation request submitted successfully! We will confirm shortly.');
                reservationForm.reset();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error submitting reservation. Please try again or call us directly.');
        }
    });
}

// Date picker restrictions - set min date to today
const dateInputs = document.querySelectorAll('input[type="date"]');
dateInputs.forEach(input => {
    const today = new Date().toISOString().split('T')[0];
    input.setAttribute('min', today);
});

// Time picker restrictions - restaurant hours
const timeInputs = document.querySelectorAll('input[type="time"]');
timeInputs.forEach(input => {
    input.addEventListener('change', function() {
        const time = this.value;
        if (time < '11:30' || time > '22:30') {
            alert('Please select a time between 11:30 AM and 10:30 PM');
            this.value = '';
        }
    });
});

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
        }
    });
}, observerOptions);

// Observe elements for animation
document.querySelectorAll('.category-card, .feature, .sake-item, .cocktail-card, .info-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'all 0.6s ease';
    observer.observe(el);
});

// Add animate-in class
document.addEventListener('DOMContentLoaded', () => {
    loadSakeItems();
    loadCocktails();
    
    // Add class for animation
    document.querySelectorAll('.animate-in').forEach(el => {
        el.style.opacity = '1';
        el.style.transform = 'translateY(0)';
    });
});

// Lazy load images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                imageObserver.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Back to top button
const backToTop = document.createElement('button');
backToTop.innerHTML = '↑';
backToTop.className = 'back-to-top';
backToTop.style.cssText = `
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: none;
    font-size: 1.5rem;
    z-index: 99;
    transition: all 0.3s ease;
`;

document.body.appendChild(backToTop);

window.addEventListener('scroll', () => {
    if (window.scrollY > 500) {
        backToTop.style.display = 'block';
    } else {
        backToTop.style.display = 'none';
    }
});

backToTop.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Add hover effect for menu items
document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px)';
    });
    
    item.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Initialize any tooltips or popovers
const tooltips = document.querySelectorAll('[data-tooltip]');
tooltips.forEach(tooltip => {
    tooltip.addEventListener('mouseenter', function(e) {
        const tip = document.createElement('div');
        tip.className = 'tooltip';
        tip.textContent = this.dataset.tooltip;
        tip.style.cssText = `
            position: absolute;
            background: var(--text-dark);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.85rem;
            z-index: 1000;
            pointer-events: none;
        `;
        
        document.body.appendChild(tip);
        
        const rect = this.getBoundingClientRect();
        tip.style.top = rect.top - tip.offsetHeight - 10 + 'px';
        tip.style.left = rect.left + (rect.width / 2) - (tip.offsetWidth / 2) + 'px';
        
        this.addEventListener('mouseleave', function() {
            tip.remove();
        });
    });
});

// Add to cart or favorites functionality (if needed)
let favorites = JSON.parse(localStorage.getItem('favorites')) || [];

function toggleFavorite(itemId) {
    const index = favorites.indexOf(itemId);
    if (index === -1) {
        favorites.push(itemId);
    } else {
        favorites.splice(index, 1);
    }
    localStorage.setItem('favorites', JSON.stringify(favorites));
    updateFavoriteButtons();
}

function updateFavoriteButtons() {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        const itemId = btn.dataset.id;
        if (favorites.includes(itemId)) {
            btn.classList.add('active');
            btn.innerHTML = '♥';
        } else {
            btn.classList.remove('active');
            btn.innerHTML = '♡';
        }
    });
}

// Search functionality (for full menu)
function searchMenu(searchTerm) {
    const menuItems = document.querySelectorAll('.full-menu-item');
    searchTerm = searchTerm.toLowerCase();
    
    menuItems.forEach(item => {
        const title = item.querySelector('h3').textContent.toLowerCase();
        const desc = item.querySelector('.description')?.textContent.toLowerCase() || '';
        
        if (title.includes(searchTerm) || desc.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Filter by category
function filterMenu(category) {
    const menuItems = document.querySelectorAll('.full-menu-item');
    
    menuItems.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}