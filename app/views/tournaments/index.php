<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
            🏆 <span class="text-accent">Tournaments</span>
        </h1>
        <p style="color: var(--text-muted); font-weight: 500;">
            Compete with the best and win amazing prizes
        </p>
        
        <!-- My Registrations Button -->
        <?php if (Auth::check()): ?>
            <div style="margin-top: 1.5rem;">
                <a href="<?= Router::url('tournaments/my') ?>" class="btn" 
                   style="background: var(--bg-secondary); font-weight: 600;">
                    📋 My Registrations
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['tournament_success'])): ?>
        <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid rgba(46, 204, 113, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="color: #2ecc71; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ✅ <?php echo $_SESSION['tournament_success']; unset($_SESSION['tournament_success']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['tournament_error'])): ?>
        <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid rgba(231, 76, 60, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="color: #e74c3c; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ❌ <?php echo $_SESSION['tournament_error']; unset($_SESSION['tournament_error']); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Active Tournaments -->
    <?php if (!empty($activeTournaments)): ?>
        <div style="margin-bottom: 3rem;">
            <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>🔥</span> Active Tournaments
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
                <?php foreach ($activeTournaments as $tournament): ?>
                    <div class="card" style="border-left: 4px solid var(--accent);">
                        <div style="display: flex; justify-content: between; align-items: start; margin-bottom: 1rem;">
                            <div>
                                <h3 style="font-weight: 800; margin-bottom: 0.5rem;"><?php echo $tournament['name']; ?></h3>
                                <div style="color: var(--text-muted); font-size: 0.9rem;">
                                    🏆 Prize Pool: Rp <?php echo number_format($tournament['prize_pool'], 0, ',', '.'); ?>
                                </div>
                            </div>
                            <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                      background: rgba(231, 76, 60, 0.2); color: #e74c3c;">
                                Live
                            </span>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Type</div>
                                <div style="font-weight: 700;"><?php echo ucfirst($tournament['type']); ?></div>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Entry Fee</div>
                                <div style="font-weight: 700; color: var(--accent);">
                                    Rp <?php echo number_format($tournament['entry_fee'], 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Participants</div>
                                <div style="font-weight: 700;">
                                    <?= $tournament['participants_count'] ?? 0 ?>/<?= $tournament['max_participants'] ?>
                                </div>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Status</div>
                                <div style="font-weight: 700; color: #e74c3c;">
                                    In Progress
                                </div>
                            </div>
                        </div>
                        
                        <div style="border-top: 1px solid var(--border-color); padding-top: 1rem;">
                            <a href="<?php echo Router::url('tournaments/view/' . $tournament['id']); ?>" 
                               class="btn btn-primary" style="width: 100%; font-weight: 600;">
                                🔥 View Tournament
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Upcoming Tournaments -->
    <div style="margin-bottom: 3rem;">
        <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <span>📅</span> Upcoming Tournaments
        </h2>
        
        <?php if (!empty($upcomingTournaments)): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
                <?php foreach ($upcomingTournaments as $tournament): ?>
                    <div class="card">
                        <div style="display: flex; justify-content: between; align-items: start; margin-bottom: 1rem;">
                            <div>
                                <h3 style="font-weight: 800; margin-bottom: 0.5rem;"><?php echo $tournament['name']; ?></h3>
                                <div style="color: var(--text-muted); font-size: 0.9rem;">
                                    🏆 Prize Pool: Rp <?php echo number_format($tournament['prize_pool'], 0, ',', '.'); ?>
                                </div>
                            </div>
                            <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                      background: rgba(52, 152, 219, 0.2); color: #3498db;">
                                Upcoming
                            </span>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Type</div>
                                <div style="font-weight: 700;"><?php echo ucfirst($tournament['type']); ?></div>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Entry Fee</div>
                                <div style="font-weight: 700; color: var(--accent);">
                                    Rp <?php echo number_format($tournament['entry_fee'], 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                            <div>
                                <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Starts</div>
                                <div style="font-weight: 700; font-size: 0.9rem;">
                                    <?php echo date('M j, Y', strtotime($tournament['start_date'])); ?>
                                </div>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Register By</div>
                                <div style="font-weight: 700; font-size: 0.9rem;">
                                    <?php echo date('M j, Y', strtotime($tournament['registration_deadline'])); ?>
                                </div>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem;">Participants</div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="flex: 1; background: var(--bg-secondary); height: 8px; border-radius: 4px; overflow: hidden;">
                                    <div style="background: var(--accent); height: 100%; width: <?= min(100, (($tournament['participants_count'] ?? 0) / $tournament['max_participants']) * 100) ?>%;"></div>
                                </div>
                                <div style="font-weight: 700; font-size: 0.9rem;">
                                    <?= $tournament['participants_count'] ?? 0 ?>/<?= $tournament['max_participants'] ?>
                                </div>
                            </div>
                        </div>
                        
                        <div style="border-top: 1px solid var(--border-color); padding-top: 1rem;">
                            <a href="<?php echo Router::url('tournaments/view/' . $tournament['id']); ?>" 
                               class="btn btn-primary" style="width: 100%; font-weight: 600;">
                                🚀 Register Now
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">😴</div>
                <h3 style="font-weight: 700; margin-bottom: 0.5rem;">No Upcoming Tournaments</h3>
                <p>Check back later for new tournament announcements.</p>
                <?php if (Auth::check() && Auth::isAdmin()): ?>
                    <a href="<?= Router::url('admin/tournaments/create') ?>" class="btn btn-primary" style="margin-top: 1rem;">
                        ➕ Create Tournament
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tournament Info -->
    <div class="card">
        <h2 style="font-weight: 800; margin-bottom: 1rem;">About Our Tournaments</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div style="text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎯</div>
                <div style="font-weight: 700; margin-bottom: 0.5rem;">Competitive Play</div>
                <div style="color: var(--text-muted);">Test your skills against the best players</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">💰</div>
                <div style="font-weight: 700; margin-bottom: 0.5rem;">Cash Prizes</div>
                <div style="color: var(--text-muted);">Win amazing prize pools</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🏆</div>
                <div style="font-weight: 700; margin-bottom: 0.5rem;">Trophies & Recognition</div>
                <div style="color: var(--text-muted);">Become a champion</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">👥</div>
                <div style="font-weight: 700; margin-bottom: 0.5rem;">Community</div>
                <div style="color: var(--text-muted);">Join our billiard community</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div style="border-top: 1px solid var(--border-color); margin-top: 2rem; padding-top: 2rem;">
            <h3 style="font-weight: 800; margin-bottom: 1rem;">Quick Actions</h3>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <?php if (Auth::check()): ?>
                    <a href="<?= Router::url('tournaments/my') ?>" class="btn" style="background: var(--bg-secondary);">
                        📋 My Registrations
                    </a>
                <?php endif; ?>
                
                <?php if (Auth::check() && Auth::isAdmin()): ?>
                    <a href="<?= Router::url('admin/tournaments') ?>" class="btn btn-primary">
                        🛠️ Manage Tournaments
                    </a>
                <?php endif; ?>
                
                <a href="<?= Router::url('booking') ?>" class="btn" style="background: var(--bg-secondary);">
                    🎱 Book a Table
                </a>
            </div>
        </div>
    </div>
</div>