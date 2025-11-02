<!-- Hero Section with Background Image -->
<div style="
    position: relative;
    height: 100vh;
    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background-image: url('<?php echo BASE_URL; ?>/public/assets/images/bille-hero.jpg');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    color: white;
">
    <!-- Overlay gelap agar teks mudah dibaca -->
    <div style="
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Hitam transparan */
        z-index: 1;
    "></div>

    <!-- Konten Hero -->
    <div style="
        position: relative;
        z-index: 2;
        max-width: 800px;
        padding: 0 1.5rem;
    ">
        <h1 style="
            font-size: clamp(2.5rem, 6vw, 3.5rem);
            margin-bottom: 1rem;
            font-weight: 800;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        ">
            Selamat Datang Di Website<span style="color: var(--accent);"> Bille</span> Southside
        </h1>
        <p style="
            font-size: clamp(1rem, 3vw, 1.3rem);
            margin: 0 auto 2rem;
            font-weight: 500;
            max-width: 600px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.4);
        ">
            Where precision meets passion. Experience premium billiard in the heart of the city.
        </p>

        <?php if (!Auth::check()): ?>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo Router::url('auth/register'); ?>" class="btn btn-primary" style="font-weight: 700; white-space: nowrap;">
                    🎱 Mulai main!
                </a>
                <a href="<?php echo Router::url('about'); ?>" class="btn btn-outline" style="font-weight: 600; white-space: nowrap;">
                    Info selengkapnya
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<div style="padding: 3rem 0;">
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

<!-- Facilities Section -->
<div style="margin-top: 4rem;">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <h2 style="font-size: 2.25rem; font-weight: 800; color: var(--text-light);">
            Galeri Kami
        </h2>
    </div>

    <div style="
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.25rem;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    ">
        <?php for ($i = 1; $i <= 12; $i++): ?>
            <div style="
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 10px rgba(0,0,0,0.2);
                height: 180px;
                background-image: url('<?php echo BASE_URL; ?>/public/assets/images/facilities/facility-<?php echo $i; ?>.jpg');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            "></div>
        <?php endfor; ?>
    </div>

    <!-- Tentang Section -->
<div style="margin-top: 4rem; padding: 3rem 0; background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.00));">
  <div style="max-width: 1100px; margin: 0 auto; padding: 0 1rem;">
    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 2rem; align-items: center;">

      <div>
        <h2 style="font-size: 2.25rem; font-weight: 800; margin-bottom: .75rem;">Tentang <span style="color: var(--accent);">Bille Southside</span></h2>
        <p style="color: var(--text-muted); font-weight: 500; line-height: 1.7; margin-bottom: 1.25rem;">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget justo non magna dignissim gravida. 
          Maecenas interdum, libero vel euismod sodales, felis nisl porttitor lorem, nec euismod urna ligula ut elit. 
          Curabitur sit amet augue sit amet ligula faucibus tincidunt.
        </p>
        <p style="color: var(--text-muted); font-weight: 500; line-height: 1.7; margin-bottom: 1.25rem;">
          Vivamus sagittis, velit in sodales tincidunt, lorem sapien pretium neque, at dignissim augue lorem nec orci. 
          Aenean placerat quam in odio iaculis, in suscipit neque vestibulum. Pellentesque habitant morbi tristique senectus et netus.
        </p>
      </div>

      <!-- Gambar -->
      <div>
        <div style="
          border-radius: 14px; overflow:hidden; height: 100%; min-height: 320px;
          box-shadow: 0 10px 30px rgba(0,0,0,.25);
          background-image: url('<?php echo BASE_URL; ?>/public/assets/images/bille-hero.jpg');
          background-size: cover; background-position: center;">
        </div>
      </div>
    </div>
  </div>
</div>
</div>