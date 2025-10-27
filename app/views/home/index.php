<!-- app/views/home/index.php -->
<div style="padding: 3rem 0;">
    <!-- Hero Section -->
    <div style="text-align: center; margin-bottom: 4rem;">
        <h1 style="font-size: 3.5rem; margin-bottom: 1rem; font-weight: 800; background: linear-gradient(135deg, var(--text-light) 0%, var(--accent) 100%); 
                   -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Selamat Datang Di Website<span class="text-accent">Bille</span> Southside
        </h1>
        <p style="font-size: 1.3rem; color: var(--text-muted); max-width: 600px; margin: 0 auto 2rem; font-weight: 500;">
            Where precision meets passion. Experience premium billiard in the heart of the city.
        </p>
        
        <?php if (!Auth::check()): ?>
            <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                <a href="<?php echo Router::url('auth/register'); ?>" class="btn btn-primary" style="font-weight: 700;">
                    🎱 Mulai main!
                </a>
                <a href="<?php echo Router::url('about'); ?>" class="btn btn-outline" style="font-weight: 600;">
                    Info selengkapnya
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
                    Pesan meja dengan mudah dan cepat. Pilih meja favorit anda.
                </p>
                <a href="<?php echo Router::url('booking'); ?>" class="btn btn-primary" style="font-weight: 600;">
                    Book Table
                </a>
            </div>
            
            <div class="card">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🏆</div>
                <h3 style="margin-bottom: 1rem; font-weight: 700;">Tournaments</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-weight: 500;">
                    Ikuti turnamen, jadi pemenang dan hadiah yang menunggu anda.
                </p>
                <a href="<?php echo Router::url('tournaments'); ?>" class="btn btn-outline" style="font-weight: 600;">
                    View Events
                </a>
            </div>
            
            <div class="card">
                <div style="font-size: 2rem; margin-bottom: 1rem;">⭐</div>
                <h3 style="margin-bottom: 1rem; font-weight: 700;">Your Journey</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-weight: 500;">
                    Lihat riwayat pemesanan anda.
                </p>
                <a href="<?php echo Router::url('auth/profile'); ?>" class="btn btn-outline" style="font-weight: 600;">
                    View Profile
                </a>
            </div>
        </div>

    <?php else: ?>
        <!-- Features untuk non-logged in users -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 3rem;">
            <div class="card">
                <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">🎱</div>
                <h3 style="text-align: center; margin-bottom: 1rem; font-weight: 700;">Meja Terbaik dari Rasson</h3>
                <p style="text-align: center; color: var(--text-muted); font-weight: 500;">
                    Pilih meja favorit anda.
                </p>
            </div>
            <div class="card">
                <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">⚡</div>
                <h3 style="text-align: center; margin-bottom: 1rem; font-weight: 700;">Booking Cepat</h3>
                <p style="text-align: center; color: var(--text-muted); font-weight: 500;">
                    Pesan meja dengan cepat.
                </p>
            </div>
            <div class="card">
                <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">🏆</div>
                <h3 style="text-align: center; margin-bottom: 1rem; font-weight: 700;">Ikuti Turnaments</h3>
                <p style="text-align: center; color: var(--text-muted); font-weight: 500;">
                    Ikuti turnamen.
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>