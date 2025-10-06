    <footer style="background: var(--bg-dark); border-top: 1px solid var(--border-color); padding: 3rem 0; margin-top: 4rem;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div>
                    <h3 style="margin-bottom: 1rem; font-weight: 800;">
                        <span class="text-accent">Bille</span> Southside
                    </h3>
                    <p style="color: var(--text-muted); line-height: 1.6;">
                        Premium billiard experience with modern facilities and unparalleled atmosphere. 
                        Where every shot tells a story.
                    </p>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem; font-weight: 700;">Quick Links</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="<?php echo Router::url('home'); ?>" 
                           style="color: var(--text-muted); text-decoration: none; transition: color 0.3s ease; font-weight: 500;">
                            🏠 Home
                        </a>
                        <a href="<?php echo Router::url('booking'); ?>" 
                           style="color: var(--text-muted); text-decoration: none; transition: color 0.3s ease; font-weight: 500;">
                            📅 Booking
                        </a>
                        <a href="<?php echo Router::url('auth/profile'); ?>" 
                           style="color: var(--text-muted); text-decoration: none; transition: color 0.3s ease; font-weight: 500;">
                            👤 Profile
                        </a>
                    </div>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem; font-weight: 700;">Contact Info</h4>
                    <div style="color: var(--text-muted); display: flex; flex-direction: column; gap: 0.5rem; font-weight: 500;">
                        <p>📍 Southside Street 123, Jakarta</p>
                        <p>📞 (021) 1234-5678</p>
                        <p>🕒 Open daily 12:00 - 03:00</p>
                        <p>✉️ hello@billesouthside.com</p>
                    </div>
                </div>
            </div>
            <div style="border-top: 1px solid var(--border-color); margin-top: 3rem; padding-top: 2rem; 
                       text-align: center; color: var(--text-muted);">
                <p style="font-weight: 600;">&copy; <?php echo date('Y'); ?> Bille Southside. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script src="<?php echo Router::asset('js/main.js'); ?>"></script>
</body>
</html>