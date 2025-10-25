<?php
$currentUser = Auth::user();
$currentRoute = isset($current_route) ? $current_route : '';
?>

<style>
/* Navbar Mobile Styles */
.navbar {
    background: rgba(13, 17, 23, 0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
}

.navbar-logo {
    display: flex;
    align-items: center;
}

.navbar-logo a {
    text-decoration: none;
    color: var(--text-light);
}

.navbar-logo h1 {
    font-size: 1.5rem;
    font-weight: 800;
}

.navbar-menu {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.navbar-link {
    text-decoration: none;
    color: var(--text-muted);
    font-weight: 500;
    transition: color 0.3s ease;
    white-space: nowrap;
}

.navbar-link.active {
    color: var(--accent);
    font-weight: 700;
}

.navbar-link:hover {
    color: var(--accent);
}

.navbar-dropdown {
    position: relative;
    display: inline-block;
}

.navbar-dropdown-btn {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-light);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 600;
    transition: all 0.3s ease;
}

.navbar-dropdown-content {
    position: absolute;
    right: 0;
    top: 100%;
    background: var(--bg-darker);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    min-width: 180px;
    display: none;
    padding: 0.5rem 0;
    margin-top: 0.5rem;
    backdrop-filter: blur(10px);
    z-index: 1001;
}

.navbar-dropdown-link {
    display: block;
    padding: 0.75rem 1rem;
    text-decoration: none;
    color: var(--text-light);
    font-weight: 500;
    transition: background 0.3s ease;
}

.navbar-dropdown-link:hover {
    background: rgba(255, 255, 255, 0.05);
}

.navbar-dropdown-link.logout {
    color: var(--accent);
    font-weight: 600;
}

/* Mobile Hamburger Menu */
.navbar-hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    gap: 4px;
    padding: 0.5rem;
}

/* Mobile Controls */
.mobile-controls {
    display: none;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 1001;
}

.mobile-translate-container {
    display: none;
}

.mobile-translate-show {
    display: none;
}

.translate-wrapper {
    position: relative;
    z-index: 1002;
}

.desktop-translate {
    display: flex;
}

.mobile-translate {
    display: none;
}

/* Google Translate Dropdown Fix */
.goog-te-menu-frame {
    z-index: 9999 !important;
}

.goog-te-menu2 {
    max-width: 100% !important;
    overflow-x: auto !important;
}

/* Style Google Translate widget */
.goog-te-gadget {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    color: var(--text-light) !important;
}

.goog-te-gadget-simple {
    background: rgba(255, 255, 255, 0.95) !important;
    border: 1px solid var(--border-color) !important;
    padding: 0.5rem 0.75rem !important;
    border-radius: 6px !important;
    font-size: 0.9rem !important;
    color: #000 !important;
}

.goog-te-gadget-simple:hover {
    background: rgba(255, 255, 255, 1) !important;
    border-color: var(--accent) !important;
}

.goog-te-gadget-simple .goog-te-menu-value {
    color: #000 !important;
}

.goog-te-gadget-simple .goog-te-menu-value span {
    color: #000 !important;
}

.goog-te-gadget-icon {
    display: none !important;
}

/* Google Translate Dropdown Styling */
.goog-te-menu-frame {
    z-index: 9999 !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
}

.goog-te-menu2 {
    max-width: 100% !important;
    overflow-x: auto !important;
    background: white !important;
    border: 1px solid #ddd !important;
    border-radius: 8px !important;
}

.goog-te-menu2-item {
    color: #000 !important;
}

.goog-te-menu2-item:hover {
    background: #f0f0f0 !important;
}

.goog-te-menu2-item-selected {
    background: var(--accent) !important;
    color: white !important;
}

/* Force visibility on mobile */
@media (max-width: 768px) {
    #google_translate_element {
        display: block !important;
        min-width: 100px;
        visibility: visible !important;
        opacity: 1 !important;
        position: relative !important;
    }
    
    #google_translate_element .goog-te-gadget-simple {
        background: rgba(255, 255, 255, 0.95) !important;
        display: block !important;
    }
    
    /* Make sure mobile controls are visible */
    .mobile-controls {
        display: flex !important;
        visibility: visible !important;
    }
    
    .mobile-translate-container {
        display: block !important;
        visibility: visible !important;
    }
    
    .mobile-translate-show {
        display: block !important;
        visibility: visible !important;
    }
    
    /* Move translate element to mobile on small screens */
    .navbar-menu:not(.mobile-menu) #google_translate_element {
        position: absolute;
        right: 60px;
        top: 50%;
        transform: translateY(-50%);
    }
}

@media (min-width: 769px) {
    #google_translate_element {
        display: block !important;
        position: static !important;
        transform: none !important;
    }
}

.navbar-hamburger span {
    width: 25px;
    height: 3px;
    background: var(--text-light);
    border-radius: 2px;
    transition: all 0.3s ease;
}

.navbar-hamburger.active span:nth-child(1) {
    transform: rotate(45deg) translate(6px, 6px);
}

.navbar-hamburger.active span:nth-child(2) {
    opacity: 0;
}

.navbar-hamburger.active span:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -6px);
}

/* Mobile Styles */
@media (max-width: 768px) {
    .navbar-container {
        padding: 0.75rem 1rem;
    }
    
    .navbar-logo h1 {
        font-size: 1.3rem;
    }
    
    .navbar-menu {
        position: fixed;
        top: 60px;
        left: 0;
        width: 100%;
        background: var(--bg-darker);
        border-top: 1px solid var(--border-color);
        flex-direction: column;
        align-items: stretch;
        padding: 0;
        gap: 0;
        display: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        max-height: calc(100vh - 60px);
        overflow-y: auto;
        z-index: 999;
    }
    
    .navbar-menu.active {
        display: flex;
    }
    
    .navbar-link {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .navbar-link:last-child {
        border-bottom: none;
    }
    
    .navbar-dropdown {
        width: 100%;
    }
    
    .navbar-dropdown-btn {
        width: 100%;
        justify-content: space-between;
        padding: 1rem;
        border: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.05);
    }
    
    .navbar-dropdown-content {
        position: static;
        width: 100%;
        margin-top: 0.5rem;
        border: 1px solid var(--border-color);
        display: none;
    }
    
    .navbar-dropdown.active .navbar-dropdown-content {
        display: block;
    }
    
    .navbar-hamburger {
        display: flex;
    }
    
    .mobile-controls {
        display: flex;
    }
    
    .mobile-translate-container {
        display: block;
    }
    
    .mobile-translate-show {
        display: block;
    }
    
    .desktop-translate {
        display: none !important;
        visibility: hidden !important;
    }
    
    .mobile-translate {
        display: flex !important;
        visibility: visible !important;
    }
    
    /* Hide regular menu on mobile, show hamburger */
    .navbar-menu:not(.mobile-menu) {
        display: none;
    }
}

@media (max-width: 480px) {
    .navbar-container {
        padding: 0.5rem;
    }
    
    .navbar-logo h1 {
        font-size: 1.2rem;
    }
    
    .navbar-dropdown-btn {
        font-size: 0.9rem;
    }
    
    .mobile-controls {
        gap: 0.5rem;
    }
    
    .goog-te-gadget-simple {
        font-size: 0.8rem !important;
        padding: 0.4rem 0.6rem !important;
    }
}

/* Desktop Styles */
@media (min-width: 769px) {
    .navbar-menu.mobile-menu {
        display: none;
    }
    
    .mobile-controls {
        display: none !important;
    }
    
    #google_translate_element {
        display: block !important;
    }
    
    #google_translate_element_mobile {
        display: none !important;
    }
}
</style>

<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="navbar-logo">
            <a href="<?php echo Router::url('home'); ?>">
                <h1><span class="text-accent">Bille</span> Southside
                </h1>
            </a>
        </div>
        

        <!-- Desktop Navigation -->
        <div class="navbar-menu">
            <div class="translate-wrapper desktop-translate" id="google_translate_element"></div>
            <?php if (Auth::check()): ?>
                <!-- User is logged in -->
                <a href="<?php echo Router::url('home'); ?>" 
                   class="navbar-link <?php echo $currentRoute === 'home' ? 'active' : ''; ?>">
                    🏠 Home
                </a>
                <a href="<?php echo Router::url('booking'); ?>" 
                   class="navbar-link <?php echo strpos($currentRoute, 'booking') !== false ? 'active' : ''; ?>">
                    📅 Booking
                </a>
                <a href="<?php echo Router::url('tournaments'); ?>" 
                   class="navbar-link <?php echo strpos($currentRoute, 'tournaments') !== false ? 'active' : ''; ?>">
                    🏆 Tournaments
                </a>
                <a href="<?php echo Router::url('menu'); ?>" 
                   class="navbar-link <?php echo strpos($currentRoute, 'menu') !== false ? 'active' : ''; ?>">
                    🍔 Menu
                </a>
                
                <?php if (Auth::isAdmin()): ?>
                    <a href="<?php echo Router::url('admin/dashboard'); ?>" 
                       class="navbar-link <?php echo strpos($currentRoute, 'admin') !== false ? 'active' : ''; ?>">
                        ⚙️ Admin
                    </a>
                <?php endif; ?>

                <!-- User Dropdown -->
                <div class="navbar-dropdown">
                    <button class="navbar-dropdown-btn">
                        <span>👨🏻‍💼 <?php echo htmlspecialchars($currentUser['name']); ?></span>
                        <span style="font-size: 0.8rem;">▼</span>
                    </button>
                    <div class="navbar-dropdown-content">
                        <a href="<?php echo Router::url('auth/profile'); ?>" class="navbar-dropdown-link">
                            📊 My Profile
                        </a>
                        <a href="<?php echo Router::url('auth/logout'); ?>" class="navbar-dropdown-link logout">
                            🚪 Logout
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <!-- User is not logged in -->
                <a href="<?php echo Router::url('auth/login'); ?>" 
                   class="navbar-link <?php echo $currentRoute === 'auth/login' ? 'active' : ''; ?>">
                    🔐 Login
                </a>
                <a href="<?php echo Router::url('auth/register'); ?>" 
                   class="btn btn-primary" style="font-weight: 700; white-space: nowrap;">
                    Sign Up
                </a>
            <?php endif; ?>
        </div>

        <!-- Mobile Controls -->
        <div class="mobile-controls">
            <!-- Show translate in mobile -->
            <div class="mobile-translate-container">
                <!-- This will be filled by cloning desktop element -->
            </div>
            
            <div class="navbar-hamburger" id="mobileMenuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="navbar-menu mobile-menu" id="mobileMenu">
            <?php if (Auth::check()): ?>
                <!-- Mobile menu for logged in users -->
                <a href="<?php echo Router::url('home'); ?>" 
                   class="navbar-link <?php echo $currentRoute === 'home' ? 'active' : ''; ?>">
                    🏠 Home
                </a>
                <a href="<?php echo Router::url('booking'); ?>" 
                   class="navbar-link <?php echo strpos($currentRoute, 'booking') !== false ? 'active' : ''; ?>">
                    📅 Booking
                </a>
                <a href="<?php echo Router::url('tournaments'); ?>" 
                   class="navbar-link <?php echo strpos($currentRoute, 'tournaments') !== false ? 'active' : ''; ?>">
                    🏆 Tournaments
                </a>
                <a href="<?php echo Router::url('menu'); ?>" 
                   class="navbar-link <?php echo strpos($currentRoute, 'menu') !== false ? 'active' : ''; ?>">
                    🍔 Menu
                </a>
                
                <?php if (Auth::isAdmin()): ?>
                    <a href="<?php echo Router::url('admin/dashboard'); ?>" 
                       class="navbar-link <?php echo strpos($currentRoute, 'admin') !== false ? 'active' : ''; ?>">
                        ⚙️ Admin
                    </a>
                <?php endif; ?>

                <div class="navbar-dropdown" id="mobileDropdown">
                    <button class="navbar-dropdown-btn">
                        <span>👨🏻‍💼 <?php echo htmlspecialchars($currentUser['name']); ?></span>
                        <span style="font-size: 0.8rem;">▼</span>
                    </button>
                    <div class="navbar-dropdown-content">
                        <a href="<?php echo Router::url('auth/profile'); ?>" class="navbar-dropdown-link">
                            📊 My Profile
                        </a>
                        <a href="<?php echo Router::url('auth/logout'); ?>" class="navbar-dropdown-link logout">
                            🚪 Logout
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <!-- Mobile menu for guests -->
                <a href="<?php echo Router::url('auth/login'); ?>" 
                   class="navbar-link <?php echo $currentRoute === 'auth/login' ? 'active' : ''; ?>">
                    🔐 Login
                </a>
                <a href="<?php echo Router::url('auth/register'); ?>" 
                   class="navbar-link <?php echo $currentRoute === 'auth/register' ? 'active' : ''; ?>">
                    📝 Sign Up
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
// Initialize Google Translate
function googleTranslateElementInit() {
    console.log('Initializing Google Translate...');
    
    // Initialize only ONE element
    if (document.getElementById('google_translate_element')) {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'id,zh-CN,ja,ko,ar,es,fr,de,ru',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');
        console.log('Google Translate initialized on single element');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileDropdown = document.getElementById('mobileDropdown');
    
    // Clone Google Translate to mobile on smaller screens
    function handleTranslatePosition() {
        const isMobile = window.innerWidth <= 768;
        const translateEl = document.getElementById('google_translate_element');
        const mobileContainer = document.querySelector('.mobile-translate-container');
        const desktopWrapper = document.querySelector('.desktop-translate');
        
        if (isMobile && translateEl && mobileContainer && desktopWrapper) {
            // Move to mobile container
            if (!mobileContainer.querySelector('#google_translate_element')) {
                mobileContainer.appendChild(translateEl);
            }
        } else if (!isMobile && translateEl && desktopWrapper) {
            // Move back to desktop
            if (!desktopWrapper.querySelector('#google_translate_element')) {
                desktopWrapper.appendChild(translateEl);
            }
        }
    }
    
    // Run on load and resize
    handleTranslatePosition();
    window.addEventListener('resize', handleTranslatePosition);
    
    // Also run after Google Translate initializes
    setTimeout(handleTranslatePosition, 1000);
    
    // Mobile menu toggle
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenuToggle.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });
    }
    
    // Mobile dropdown toggle
    if (mobileDropdown) {
        const dropdownBtn = mobileDropdown.querySelector('.navbar-dropdown-btn');
        const dropdownContent = mobileDropdown.querySelector('.navbar-dropdown-content');
        
        dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileDropdown.classList.toggle('active');
        });
    }
    
    // Close menus when clicking outside
    document.addEventListener('click', function() {
        // Close mobile menu
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.classList.remove('active');
            mobileMenu.classList.remove('active');
        }
        
        // Close mobile dropdown
        if (mobileDropdown) {
            mobileDropdown.classList.remove('active');
        }
        
        // Close desktop dropdowns
        const desktopDropdowns = document.querySelectorAll('.navbar-dropdown');
        desktopDropdowns.forEach(dropdown => {
            if (dropdown.id !== 'mobileDropdown') {
                const content = dropdown.querySelector('.navbar-dropdown-content');
                if (content) content.style.display = 'none';
            }
        });
    });
    
    // Prevent close when clicking inside menus
    if (mobileMenu) {
        mobileMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Desktop dropdown functionality
    const desktopDropdowns = document.querySelectorAll('.navbar-dropdown:not(#mobileDropdown)');
    desktopDropdowns.forEach(dropdown => {
        const btn = dropdown.querySelector('.navbar-dropdown-btn');
        const content = dropdown.querySelector('.navbar-dropdown-content');
        
        if (btn && content) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isVisible = content.style.display === 'block';
                content.style.display = isVisible ? 'none' : 'block';
            });
            
            content.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
    
    // Close dropdowns when clicking links (mobile)
    const mobileLinks = document.querySelectorAll('.mobile-menu .navbar-link, .mobile-menu .navbar-dropdown-link');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
            }
            if (mobileDropdown) {
                mobileDropdown.classList.remove('active');
            }
        });
    });
});
</script>

<!-- Google Translate Script -->
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>