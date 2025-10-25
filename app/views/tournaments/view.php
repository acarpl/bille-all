<div style="padding: 2rem 0;">
        <!-- Back Button -->
        <div style="margin-bottom: 2rem;">
            <a href="<?= Router::url('tournaments') ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; 
                     color: var(--text-muted); font-weight: 600; text-decoration: none;">
                ← Back to Tournaments
            </a>
        </div>

        <!-- Tournament Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
                🏆 <span class="text-accent"><?= $data['tournament']['name'] ?></span>
            </h1>
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.5rem; 
                     border-radius: 20px; font-weight: 600; font-size: 0.9rem;
                     background: <?= $data['tournament']['status'] === 'ongoing' ? 'rgba(231, 76, 60, 0.2)' : 'rgba(52, 152, 219, 0.2)' ?>; 
                     color: <?= $data['tournament']['status'] === 'ongoing' ? '#e74c3c' : '#3498db' ?>;">
                <?= $data['tournament']['status'] === 'ongoing' ? '🔥 Live' : '📅 ' . ucfirst($data['tournament']['status']) ?>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['tournament_success'])): ?>
            <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid rgba(46, 204, 113, 0.3); 
                        padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <div style="color: #2ecc71; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    ✅ <?= $_SESSION['tournament_success'] ?>
                </div>
            </div>
            <?php unset($_SESSION['tournament_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['tournament_error'])): ?>
            <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid rgba(231, 76, 60, 0.3); 
                        padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <div style="color: #e74c3c; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    ❌ <?= $_SESSION['tournament_error'] ?>
                </div>
            </div>
            <?php unset($_SESSION['tournament_error']); ?>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 2rem; align-items: start;">
            <!-- Left Column - Tournament Details -->
            <div>
                <!-- Tournament Info Card -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span>📋</span> Tournament Details
                    </h2>
                    
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                        <div>
                            <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;">
                                🎮 Tournament Type
                            </div>
                            <div style="font-weight: 700; font-size: 1.1rem;">
                                <?= ucfirst($data['tournament']['type']) ?>
                            </div>
                        </div>
                        
                        <div>
                            <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;">
                                💰 Entry Fee
                            </div>
                            <div style="font-weight: 700; font-size: 1.1rem; color: var(--accent);">
                                Rp <?= number_format($data['tournament']['entry_fee'], 0, ',', '.') ?>
                            </div>
                        </div>
                        
                        <div>
                            <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;">
                                🏆 Prize Pool
                            </div>
                            <div style="font-weight: 700; font-size: 1.1rem;">
                                Rp <?= number_format($data['tournament']['prize_pool'], 0, ',', '.') ?>
                            </div>
                        </div>
                        
                        <div>
                            <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;">
                                👥 Max Participants
                            </div>
                            <div style="font-weight: 700; font-size: 1.1rem;">
                                <?= $data['tournament']['max_participants'] ?> teams
                            </div>
                        </div>
                        
                        <div>
                            <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;">
                                📅 Start Date
                            </div>
                            <div style="font-weight: 700; font-size: 1.1rem;">
                                <?= date('M j, Y g:i A', strtotime($data['tournament']['start_date'])) ?>
                            </div>
                        </div>
                        
                        <div>
                            <div style="font-weight: 600; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;">
                                ⏰ Register By
                            </div>
                            <div style="font-weight: 700; font-size: 1.1rem;">
                                <?= date('M j, Y g:i A', strtotime($data['tournament']['registration_deadline'])) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Status -->
                    <div style="margin-top: 1rem; padding: 1rem; background: rgba(52, 152, 219, 0.1); 
                                border-radius: 8px; border-left: 4px solid #3498db;">
                        <div style="font-weight: 600; margin-bottom: 0.5rem;">📊 Registration Status</div>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; text-align: center;">
                            <div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">Registered</div>
                                <div style="font-weight: 800; font-size: 1.2rem;">
                                    <?= count($data['registrations']) ?>
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">Capacity</div>
                                <div style="font-weight: 800; font-size: 1.2rem;">
                                    <?= $data['tournament']['max_participants'] ?>
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">Available</div>
                                <div style="font-weight: 800; font-size: 1.2rem; 
                                     color: <?= ($data['tournament']['max_participants'] - count($data['registrations'])) > 0 ? '#2ecc71' : '#e74c3c' ?>">
                                    <?= $data['tournament']['max_participants'] - count($data['registrations']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rules & Information -->
                <?php if (!empty($data['tournament']['rules'])): ?>
                <div class="card">
                    <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span>📜</span> Tournament Rules
                    </h2>
                    <div style="line-height: 1.6; white-space: pre-line;">
                        <?= htmlspecialchars($data['tournament']['rules']) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right Column - Registration & Participants -->
            <!-- Right Column - Registration & Participants -->
<div>
    <!-- Registration Card -->
    <div class="card" style="position: sticky; top: 2rem;">
        <?php if (Auth::check()): ?>
            <?php if (!$data['isRegistered']): ?>
                <?php if (strtotime($data['tournament']['registration_deadline']) > time()): ?>
                    <?php if (count($data['registrations']) < $data['tournament']['max_participants']): ?>
                        <h3 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span>🚀</span> Ready to Join?
                        </h3>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <div style="background: rgba(52, 152, 219, 0.1); padding: 1rem; border-radius: 8px; 
                                      border-left: 4px solid #3498db;">
                                <div style="font-weight: 600; margin-bottom: 0.5rem;">📝 Registration Open</div>
                                <div style="font-size: 0.9rem; color: var(--text-muted);">
                                    Spots available: <strong><?= $data['tournament']['max_participants'] - count($data['registrations']) ?></strong>
                                </div>
                            </div>
                        </div>
                        
                        <a href="<?= Router::url('tournaments/register/' . $data['tournament']['id']) ?>" 
                           style="width: 100%; padding: 1rem; background: var(--accent); color: white; 
                                  border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; 
                                  cursor: pointer; text-decoration: none; display: block; text-align: center;">
                            🎯 Register Now
                        </a>
                    <?php else: ?>
                        <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">😔</div>
                            <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Tournament Full</h3>
                            <p>All spots have been taken.</p>
                            <div style="margin-top: 1rem; font-size: 0.9rem;">
                                <a href="<?= Router::url('tournaments') ?>" style="color: var(--accent);">
                                    Browse other tournaments
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">⏰</div>
                        <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Registration Closed</h3>
                        <p>Registration deadline has passed.</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
                    <h3 style="font-weight: 700; margin-bottom: 0.5rem; color: #2ecc71;">
                        You're Registered!
                    </h3>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
                        Good luck in the tournament! 🏆
                    </p>
                    
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <a href="<?= Router::url('tournaments/my') ?>" class="btn btn-primary">
                            📋 View My Registrations
                        </a>
                        <a href="<?= Router::url('tournaments') ?>" class="btn" style="background: var(--bg-secondary);">
                            🏆 Browse More Tournaments
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔒</div>
                <h3 style="font-weight: 700; margin-bottom: 1rem;">Login Required</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
                    Please login to register for this tournament.
                </p>
                <a href="<?= Router::url('auth/login') ?>?redirect=<?= urlencode('tournaments/view/' . $data['tournament']['id']) ?>" 
                   style="display: inline-block; padding: 0.75rem 1.5rem; 
                          background: var(--accent); color: white; border-radius: 8px; 
                          text-decoration: none; font-weight: 600;">
                    🔑 Login Now
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Participants Card -->
    <div class="card" style="margin-top: 1.5rem;">
        <h3 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <span>👥</span> Participants 
            <span style="margin-left: auto; padding: 0.25rem 0.75rem; border-radius: 20px; 
                  font-size: 0.8rem; font-weight: 600; background: var(--bg-secondary);">
                <?= count($data['registrations']) ?>/<?= $data['tournament']['max_participants'] ?>
            </span>
        </h3>
        
        <?php if (!empty($data['registrations'])): ?>
            <div style="max-height: 300px; overflow-y: auto;">
                <?php foreach ($data['registrations'] as $index => $registration): ?>
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; 
                             <?= $index > 0 ? 'border-top: 1px solid var(--border-color);' : '' ?>">
                        <div style="width: 32px; height: 32px; border-radius: 50%; 
                                  background: var(--bg-secondary); display: flex; align-items: center; 
                                  justify-content: center; font-weight: 700; font-size: 0.8rem;">
                            <?= $index + 1 ?>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700;">
                                <?= htmlspecialchars($registration['team_name']) ?>
                                <?php if ($registration['user_id'] == Auth::id()): ?>
                                    <span style="color: var(--accent); font-size: 0.8rem;"> (You)</span>
                                <?php endif; ?>
                            </div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                by <?= htmlspecialchars($registration['user_name'] ?? 'Anonymous') ?>
                            </div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                <?= $registration['player_count'] ?> player<?= $registration['player_count'] > 1 ? 's' : '' ?>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <span style="padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.7rem; font-weight: 600;
                                  background: <?= $registration['payment_status'] === 'paid' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(241, 196, 15, 0.2)' ?>; 
                                  color: <?= $registration['payment_status'] === 'paid' ? '#27ae60' : '#f39c12' ?>;">
                                <?= ucfirst($registration['payment_status']) ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">😴</div>
                <p>No participants yet. Be the first to register!</p>
            </div>
        <?php endif; ?>
    </div>
</div>
        </div>
    </div>