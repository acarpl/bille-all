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
    gap: 0.75rem;
}

.navbar-logo a {
    text-decoration: none;
    color: var(--text-light);
    display: flex;
    align-items: center;
}

.navbar-logo-icon {
    font-size: 1.8rem;
}

.navbar-logo h1 {
    font-size: 1.5rem;
    font-weight: 800;
    margin: 0;
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
        align-items: center;
        gap: 0.75rem;
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
}

/* Desktop Styles */
@media (min-width: 769px) {
    .navbar-menu.mobile-menu {
        display: none;
    }
    
    .mobile-controls {
        display: none;
    }
}
</style>

<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="navbar-logo">
            <a href="<?php echo Router::url('home'); ?>">
                <img style="width: 50px; height: 50px; border-radius: 50px; margin-right: 10px;" src="<?php echo BASE_URL; ?>/public/assets/images/LOGOBILLE.jpg" alt="Bille Southside Logo">

                <h1><span class="text-accent">Bille</span> Southside</h1>
            </a>
        </div>
        

        <!-- Desktop Navigation -->
        <div class="navbar-menu">
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
                    🏠 Beranda
                </a>
                <a href="<?php echo Router::url('booking'); ?>" 
                   class="navbar-link <?php echo strpos($currentRoute, 'booking') !== false ? 'active' : ''; ?>">
                    📅 Pemesanan
                </a>
                <a href="<?php echo Router::url('tournaments'); ?>" 
                   class="navbar-link <?php echo strpos($currentRoute, 'tournaments') !== false ? 'active' : ''; ?>">
                    🏆 Turnamen
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
                            📊 Profil Saya
                        </a>
                        <a href="<?php echo Router::url('auth/logout'); ?>" class="navbar-dropdown-link logout">
                            🚪 Keluar
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <!-- Mobile menu for guests -->
                <a href="<?php echo Router::url('auth/login'); ?>" 
                   class="navbar-link <?php echo $currentRoute === 'auth/login' ? 'active' : ''; ?>">
                    🔐 Masuk
                </a>
                <a href="<?php echo Router::url('auth/register'); ?>" 
                   class="navbar-link <?php echo $currentRoute === 'auth/register' ? 'active' : ''; ?>">
                    📝 Daftar
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileDropdown = document.getElementById('mobileDropdown');
    
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