<?php
$currentUser = Auth::user();
$currentRoute = isset($current_route) ? $current_route : '';
?>

<nav style="background: rgba(13, 17, 23, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-color); 
            position: sticky; top: 0; z-index: 1000;">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0;">
        <!-- Logo -->
        <div style="display: flex; align-items: center;">
            <a href="<?php echo Router::url('home'); ?>" style="text-decoration: none; color: var(--text-light);">
                <h1 style="font-size: 1.5rem; font-weight: 800;">
                    <span class="text-accent">Bille</span> Southside
                </h1>
            </a>
        </div>

        <!-- Navigation Links -->
        <div style="display: flex; align-items: center; gap: 2rem;">
            <?php if (Auth::check()): ?>
                <!-- User is logged in -->
                <a href="<?php echo Router::url('home'); ?>" 
                   style="text-decoration: none; 
                          color: <?php echo $currentRoute === 'home' ? 'var(--accent)' : 'var(--text-muted)'; ?>; 
                          font-weight: <?php echo $currentRoute === 'home' ? '700' : '500'; ?>;
                          transition: color 0.3s ease;">
                    Home
                </a>
                <a href="<?php echo Router::url('booking'); ?>" 
                   style="text-decoration: none; 
                          color: <?php echo strpos($currentRoute, 'booking') !== false ? 'var(--accent)' : 'var(--text-muted)'; ?>; 
                          font-weight: <?php echo strpos($currentRoute, 'booking') !== false ? '700' : '500'; ?>;
                          transition: color 0.3s ease;">
                    Booking
                </a>
                <a href="<?php echo Router::url('auth/profile'); ?>" 
                   style="text-decoration: none; 
                          color: <?php echo strpos($currentRoute, 'profile') !== false ? 'var(--accent)' : 'var(--text-muted)'; ?>; 
                          font-weight: <?php echo strpos($currentRoute, 'profile') !== false ? '700' : '500'; ?>;
                          transition: color 0.3s ease;">
                    Profile
                </a>
                
                <?php if (Auth::isAdmin()): ?>
                    <a href="<?php echo Router::url('admin/dashboard'); ?>" 
                       style="text-decoration: none; 
                              color: <?php echo strpos($currentRoute, 'admin') !== false ? 'var(--accent)' : 'var(--text-muted)'; ?>; 
                              font-weight: <?php echo strpos($currentRoute, 'admin') !== false ? '700' : '500'; ?>;
                              transition: color 0.3s ease;">
                        Admin
                    </a>
                <?php endif; ?>

                <!-- User Dropdown -->
                <div style="position: relative; display: inline-block;">
                    <button style="background: var(--card-bg); border: 1px solid var(--border-color); 
                                  cursor: pointer; display: flex; align-items: center; gap: 0.5rem; 
                                  color: var(--text-light); padding: 0.5rem 1rem; border-radius: 8px;
                                  font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600;
                                  transition: all 0.3s ease;">
                        <span>👤 <?php echo htmlspecialchars($currentUser['name']); ?></span>
                        <span style="font-size: 0.8rem;">▼</span>
                    </button>
                    <div style="position: absolute; right: 0; top: 100%; background: var(--bg-darker); 
                                border: 1px solid var(--border-color); border-radius: 8px; min-width: 180px; 
                                display: none; padding: 0.5rem 0; margin-top: 0.5rem; backdrop-filter: blur(10px);">
                        <a href="<?php echo Router::url('auth/profile'); ?>" 
                           style="display: block; padding: 0.75rem 1rem; text-decoration: none; color: var(--text-light);
                                  font-weight: 500; transition: background 0.3s ease;">
                            📊 My Profile
                        </a>
                        <a href="<?php echo Router::url('auth/logout'); ?>" 
                           style="display: block; padding: 0.75rem 1rem; text-decoration: none; color: var(--accent);
                                  font-weight: 600; transition: background 0.3s ease;">
                            🚪 Logout
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <!-- User is not logged in -->
                <a href="<?php echo Router::url('auth/login'); ?>" 
                   style="text-decoration: none; 
                          color: <?php echo $currentRoute === 'auth/login' ? 'var(--accent)' : 'var(--text-muted)'; ?>; 
                          font-weight: <?php echo $currentRoute === 'auth/login' ? '700' : '500'; ?>;
                          transition: color 0.3s ease;">
                    Login
                </a>
                <a href="<?php echo Router::url('auth/register'); ?>" 
                   class="btn btn-primary" 
                   style="font-weight: 700;">
                    Sign Up
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
// Dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.querySelector('button');
    const dropdownMenu = document.querySelector('div[style*="position: absolute"]');
    
    if (dropdownButton && dropdownMenu) {
        dropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isVisible = dropdownMenu.style.display === 'block';
            dropdownMenu.style.display = isVisible ? 'none' : 'block';
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            dropdownMenu.style.display = 'none';
        });
        
        // Prevent dropdown close when clicking inside
        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>