<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
            🏆 <span class="text-accent">My Tournament Registrations</span>
        </h1>
        <p style="color: var(--text-muted); font-weight: 500;">
            Manage your tournament participations and payments
        </p>
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

    <?php if (isset($_SESSION['payment_success'])): ?>
        <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid rgba(46, 204, 113, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="color: #2ecc71; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ✅ <?= $_SESSION['payment_success'] ?>
            </div>
        </div>
        <?php unset($_SESSION['payment_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['payment_error'])): ?>
        <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid rgba(231, 76, 60, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="color: #e74c3c; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ❌ <?= $_SESSION['payment_error'] ?>
            </div>
        </div>
        <?php unset($_SESSION['payment_error']); ?>
    <?php endif; ?>

    <!-- Registrations List -->
    <?php if (!empty($registrations)): ?>
        <div class="card">
            <h2 style="font-weight: 800; margin-bottom: 1.5rem;">Your Tournament Registrations</h2>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <?php foreach ($registrations as $registration): ?>
                    <div style="display: flex; justify-content: between; align-items: center; 
                                padding: 1.5rem; background: rgba(255, 255, 255, 0.05); 
                                border-radius: 8px; border-left: 4px solid var(--accent);">
                        <div style="flex: 1;">
                            <div style="font-weight: 800; font-size: 1.1rem; margin-bottom: 0.5rem;">
                                <?= htmlspecialchars($registration['tournament_name']) ?>
                            </div>
                            <div style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">
                                Team: <strong><?= htmlspecialchars($registration['team_name']) ?></strong> • 
                                Players: <?= $registration['player_count'] ?> • 
                                Fee: <strong>Rp <?= number_format($registration['total_fee'], 0, ',', '.') ?></strong>
                            </div>
                            <div style="display: flex; gap: 2rem; font-size: 0.9rem;">
                                <div>
                                    <span style="color: var(--text-muted);">Start Date:</span>
                                    <strong><?= date('M j, Y', strtotime($registration['start_date'])) ?></strong>
                                </div>
                                <div>
                                    <span style="color: var(--text-muted);">Tournament Status:</span>
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                          background: <?= $registration['tournament_status'] === 'upcoming' ? 'rgba(52, 152, 219, 0.2)' : 
                                                     ($registration['tournament_status'] === 'ongoing' ? 'rgba(46, 204, 113, 0.2)' : 
                                                     'rgba(149, 165, 166, 0.2)') ?>; 
                                          color: <?= $registration['tournament_status'] === 'upcoming' ? '#3498db' : 
                                                 ($registration['tournament_status'] === 'ongoing' ? '#27ae60' : 
                                                 '#95a5a6') ?>;">
                                        <?= ucfirst($registration['tournament_status']) ?>
                                    </span>
                                </div>
                                <div>
    <span style="color: var(--text-muted);">Payment Status:</span>
    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
          background: <?= isset($registration['payment_status']) ? 
                     ($registration['payment_status'] === 'paid' ? 'rgba(46, 204, 113, 0.2)' : 
                     ($registration['payment_status'] === 'pending' ? 'rgba(241, 196, 15, 0.2)' : 
                     'rgba(231, 76, 60, 0.2)')) : 'rgba(241, 196, 15, 0.2)' ?>; 
          color: <?= isset($registration['payment_status']) ? 
                 ($registration['payment_status'] === 'paid' ? '#27ae60' : 
                 ($registration['payment_status'] === 'pending' ? '#f39c12' : 
                 '#e74c3c')) : '#f39c12' ?>;">
        <?= isset($registration['payment_status']) ? ucfirst($registration['payment_status']) : 'Pending' ?>
    </span>
</div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="display: flex; gap: 0.5rem; flex-direction: column; align-items: flex-end;">
                                <a href="<?= Router::url('tournaments/view/' . $registration['tournament_id']) ?>" 
                                   class="btn btn-sm" style="background: var(--bg-secondary);">
                                    👁️ View Tournament
                                </a>
                                
                                <?php 
$paymentStatus = $registration['payment_status'] ?? 'pending';
$tournamentStatus = $registration['tournament_status'] ?? 'upcoming';
?>

<?php if ($registration['payment_status'] === 'pending' && $registration['tournament_status'] === 'upcoming'): ?>
                <a href="<?= Router::url('payment/tournament/' . $registration['id']) ?>" 
                   class="btn btn-sm btn-primary">
                    💰 Pay Now
                </a>
<?php elseif ($paymentStatus === 'paid'): ?>
    <span style="padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
          background: rgba(46, 204, 113, 0.2); color: #27ae60;">
        ✅ Paid
    </span>
<?php elseif ($tournamentStatus !== 'upcoming'): ?>
    <span style="padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
          background: rgba(149, 165, 166, 0.2); color: #95a5a6;">
        Tournament Ended
    </span>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="card" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">😴</div>
            <h3 style="font-weight: 700; margin-bottom: 0.5rem;">No Registrations Yet</h3>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">
                You haven't registered for any tournaments yet.
            </p>
            <a href="<?= Router::url('tournaments') ?>" class="btn btn-primary">
                Browse Tournaments
            </a>
        </div>
    <?php endif; ?>

    <!-- Payment Summary -->
    <?php if (!empty($registrations)): ?>
        <?php
        $totalRegistrations = count($registrations);
        $pendingPayments = array_filter($registrations, function($reg) {
            return $reg['payment_status'] === 'pending' && $reg['tournament_status'] === 'upcoming';
        });
        $totalPendingAmount = array_sum(array_column($pendingPayments, 'total_fee'));
        ?>
        
        <div class="card" style="margin-top: 2rem;">
            <h3 style="font-weight: 800; margin-bottom: 1.5rem;">💰 Payment Summary</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📋</div>
                    <div style="font-size: 1.5rem; font-weight: 800;"><?= $totalRegistrations ?></div>
                    <div style="color: var(--text-muted); font-size: 0.9rem;">Total Registrations</div>
                </div>
                
                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">⏳</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #f39c12;">
                        <?= count($pendingPayments) ?>
                    </div>
                    <div style="color: var(--text-muted); font-size: 0.9rem;">Pending Payments</div>
                </div>
                
                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">💰</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent);">
                        Rp <?= number_format($totalPendingAmount, 0, ',', '.') ?>
                    </div>
                    <div style="color: var(--text-muted); font-size: 0.9rem;">Total Due</div>
                </div>
                
                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">✅</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #27ae60;">
                        <?= $totalRegistrations - count($pendingPayments) ?>
                    </div>
                    <div style="color: var(--text-muted); font-size: 0.9rem;">Completed Payments</div>
                </div>
            </div>

            <!-- Quick Pay All Button -->
            <?php if (!empty($pendingPayments)): ?>
                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); text-align: center;">
                    <div style="font-weight: 600; margin-bottom: 1rem;">
                        You have <?= count($pendingPayments) ?> pending payment<?= count($pendingPayments) > 1 ? 's' : '' ?>
                    </div>
                    <div style="display: flex; gap: 1rem; justify-content: center;">
                        <?php foreach ($pendingPayments as $pending): ?>
                            <a href="<?= Router::url('payment/tournament/' . $pending['id']) ?>" 
                               class="btn btn-primary">
                                Pay <?= htmlspecialchars($pending['team_name']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>