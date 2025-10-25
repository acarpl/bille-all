<!-- app/views/tournaments/payment.php -->
<div style="padding: 2rem 0;">
    <!-- Navigation -->
    <div style="margin-bottom: 2rem;">
        <a href="<?= Router::url('tournaments/my') ?>" 
           style="display: inline-flex; align-items: center; gap: 0.5rem; 
                  color: var(--text-muted); font-weight: 600; text-decoration: none;">
            ← Back to My Registrations
        </a>
    </div>

    <!-- Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
            💰 Tournament Payment
        </h1>
        <p style="color: var(--text-muted); font-weight: 500;">
            Complete your payment for <?= htmlspecialchars($data['registration']['tournament_name']) ?>
        </p>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['payment_success'])): ?>
        <div class="card" style="background: rgba(46, 204, 113, 0.1); border: 1px solid rgba(46, 204, 113, 0.3); margin-bottom: 2rem;">
            <div style="color: #2ecc71; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ✅ <?= $_SESSION['payment_success'] ?>
            </div>
        </div>
        <?php unset($_SESSION['payment_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['payment_error'])): ?>
        <div class="card" style="background: rgba(231, 76, 60, 0.1); border: 1px solid rgba(231, 76, 60, 0.3); margin-bottom: 2rem;">
            <div style="color: #e74c3c; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ❌ <?= $_SESSION['payment_error'] ?>
            </div>
        </div>
        <?php unset($_SESSION['payment_error']); ?>
    <?php endif; ?>

    <!-- Main Content Grid -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem; max-width: 1000px; margin: 0 auto;">
        <!-- Payment Methods Card -->
        <div class="card">
            <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>💳</span> Select Payment Method
            </h2>

            <form method="POST" action="<?= Router::url('payment/process') ?>">
                <input type="hidden" name="registration_id" value="<?= $data['registration']['id'] ?>">

                <!-- Payment Methods -->
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                    <?php foreach ([
                        ['value' => 'qris', 'icon' => '📱', 'title' => 'QRIS', 'desc' => 'Scan QR Code dengan aplikasi e-wallet'],
                        ['value' => 'transfer', 'icon' => '🏦', 'title' => 'Bank Transfer', 'desc' => 'Transfer ke rekening Bille Southside'],
                        ['value' => 'ewallet', 'icon' => '👛', 'title' => 'E-Wallet', 'desc' => 'Gopay, OVO, Dana, LinkAja'],
                        ['value' => 'cash', 'icon' => '💵', 'title' => 'Cash Payment', 'desc' => 'Bayar langsung di venue']
                    ] as $method): ?>
                        <label style="display: flex; align-items: center; gap: 1rem; padding: 1rem; 
                                     border: 2px solid var(--border-color); border-radius: 12px; cursor: pointer;
                                     transition: all 0.3s ease; background: transparent;">
                            <input type="radio" name="payment_method" value="<?= $method['value'] ?>" required 
                                   style="transform: scale(1.3); accent-color: var(--accent);">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="font-size: 2rem;"><?= $method['icon'] ?></div>
                                <div>
                                    <div style="font-weight: 700;"><?= $method['title'] ?></div>
                                    <div style="font-size: 0.9rem; color: var(--text-muted);"><?= $method['desc'] ?></div>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- Terms -->
                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: start; gap: 0.75rem; font-size: 0.95rem;">
                        <input type="checkbox" id="payment_terms" name="payment_terms" required 
                               style="margin-top: 0.3rem; accent-color: var(--accent);">
                        <span>
                            Saya menyetujui bahwa pembayaran ini tidak dapat dikembalikan (non-refundable) 
                            kecuali tournament dibatalkan oleh penyelenggara.
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-weight: 700; font-size: 1.1rem;">
                    🚀 Continue to Payment
                </button>
            </form>
        </div>

        <!-- Order Summary Card -->
        <div class="card">
            <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>📋</span> Order Summary
            </h2>

            <!-- Tournament Info -->
            <div style="text-align: center; margin-bottom: 1.5rem; padding-bottom: 1.5rem; 
                       border-bottom: 1px solid var(--border-color);">
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🎱</div>
                <h3 style="font-weight: 800; font-size: 1.2rem; margin-bottom: 0.5rem;">
                    <?= htmlspecialchars($data['registration']['tournament_name']) ?>
                </h3>
                <div style="color: var(--text-muted);">
                    Team: <strong><?= htmlspecialchars($data['registration']['team_name']) ?></strong>
                </div>
            </div>

            <!-- Payment Details -->
            <div style="margin-bottom: 1.5rem;">
                <h4 style="font-weight: 700; margin-bottom: 1rem;">Payment Details</h4>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">Entry Fee (<?= $data['registration']['player_count'] ?> players):</span>
                        <span>Rp <?= number_format($data['registration']['total_fee'], 0, ',', '.') ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">Admin Fee:</span>
                        <span>Rp 0</span>
                    </div>
                    <div style="border-top: 1px solid var(--border-color); padding-top: 0.75rem; 
                              display: flex; justify-content: space-between; font-weight: 700; font-size: 1.1rem;">
                        <span>Total Amount:</span>
                        <span style="color: var(--accent);">
                            Rp <?= number_format($data['registration']['total_fee'], 0, ',', '.') ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tournament Details -->
            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <h4 style="font-weight: 700; margin-bottom: 0.75rem;">Tournament Info</h4>
                <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.95rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">Start Date:</span>
                        <span><?= date('M j, Y', strtotime($data['registration']['start_date'])) ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">Payment Deadline:</span>
                        <span><?= date('M j, Y', strtotime($data['registration']['registration_deadline'])) ?></span>
                    </div>
                </div>
            </div>

            <!-- Important Notes -->
            <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(241, 196, 15, 0.1); 
                       border-radius: 12px; border-left: 4px solid #f39c12;">
                <div style="font-weight: 600; margin-bottom: 0.5rem;">⚠️ Important</div>
                <div style="font-size: 0.95rem; color: var(--text-muted);">
                    Registration will be cancelled automatically if payment is not completed 
                    before the deadline.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentLabels = document.querySelectorAll('label[style*="border: 2px solid"]');
    
    paymentLabels.forEach(label => {
        const radio = label.querySelector('input[type="radio"]');
        if (!radio) return;

        radio.addEventListener('change', function() {
            // Reset semua
            paymentLabels.forEach(l => {
                l.style.borderColor = 'var(--border-color)';
                l.style.background = 'transparent';
            });
            
            // Highlight yang dipilih
            if (this.checked) {
                label.style.borderColor = 'var(--accent)';
                label.style.background = 'rgba(var(--accent-rgb), 0.08)';
            }
        });
    });
});
</script>