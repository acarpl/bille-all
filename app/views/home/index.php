<!-- app/views/home/index.php -->
<div style="padding: 3rem 0;">
    <!-- Hero Section -->
    <div style="text-align: center; margin-bottom: 4rem;">
        <h1 style="font-size: 3.5rem; margin-bottom: 1rem; font-weight: 800; background: linear-gradient(135deg, var(--text-light) 0%, var(--accent) 100%); 
                   -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Welcome to <span class="text-accent">Bille</span> Southside
        </h1>
        <p style="font-size: 1.3rem; color: var(--text-muted); max-width: 600px; margin: 0 auto 2rem; font-weight: 500;">
            Where precision meets passion. Experience premium billiard in the heart of the city.
        </p>
        
        <?php if (!Auth::check()): ?>
            <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                <a href="<?php echo Router::url('auth/register'); ?>" class="btn btn-primary" style="font-weight: 700;">
                    🎱 Start Playing
                </a>
                <a href="<?php echo Router::url('about'); ?>" class="btn btn-outline" style="font-weight: 600;">
                    Learn More
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if (Auth::check()): ?>
        <!-- Dashboard untuk user yang sudah login -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            <div class="card">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🎯</div>
                <h3 style="margin-bottom: 1rem; font-weight: 700;">Quick Booking</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-weight: 500;">
                    Reserve your table and dive into the game. Fast, easy, and seamless.
                </p>
                <a href="<?php echo Router::url('booking'); ?>" class="btn btn-primary" style="font-weight: 600;">
                    Book Table
                </a>
            </div>
            
            <div class="card">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🏆</div>
                <h3 style="margin-bottom: 1rem; font-weight: 700;">Tournaments</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-weight: 500;">
                    Compete with the best. Join exciting tournaments and claim your victory.
                </p>
                <a href="<?php echo Router::url('tournaments'); ?>" class="btn btn-outline" style="font-weight: 600;">
                    View Events
                </a>
            </div>
            
            <div class="card">
                <div style="font-size: 2rem; margin-bottom: 1rem;">⭐</div>
                <h3 style="margin-bottom: 1rem; font-weight: 700;">Your Journey</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-weight: 500;">
                    Track your progress, manage bookings, and unlock exclusive member benefits.
                </p>
                <a href="<?php echo Router::url('auth/profile'); ?>" class="btn btn-outline" style="font-weight: 600;">
                    View Profile
                </a>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="card">
            <h2 style="margin-bottom: 2rem; font-weight: 800; text-align: center;">Your <span class="text-accent">Southside</span> Stats</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; text-align: center;">
                <div>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--accent);">0</div>
                    <div style="color: var(--text-muted); font-weight: 600;">Games Played</div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--accent);">100</div>
                    <div style="color: var(--text-muted); font-weight: 600;">Loyalty Points</div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--accent);">0</div>
                    <div style="color: var(--text-muted); font-weight: 600;">Tournaments</div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--accent);">⭐</div>
                    <div style="color: var(--text-muted); font-weight: 600;">New Member</div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Features untuk non-logged in users -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 3rem;">
            <div class="card">
                <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">🎱</div>
                <h3 style="text-align: center; margin-bottom: 1rem; font-weight: 700;">Premium Tables</h3>
                <p style="text-align: center; color: var(--text-muted); font-weight: 500;">
                    Competition-grade billiard tables maintained to perfection for the ultimate playing experience.
                </p>
            </div>
            <div class="card">
                <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">⚡</div>
                <h3 style="text-align: center; margin-bottom: 1rem; font-weight: 700;">Fast Booking</h3>
                <p style="text-align: center; color: var(--text-muted); font-weight: 500;">
                    Reserve your table in seconds with our streamlined digital booking system.
                </p>
            </div>
            <div class="card">
                <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">🏆</div>
                <h3 style="text-align: center; margin-bottom: 1rem; font-weight: 700;">Competitive Scene</h3>
                <p style="text-align: center; color: var(--text-muted); font-weight: 500;">
                    Join tournaments, climb leaderboards, and prove your skills against the best players.
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>