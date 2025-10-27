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

    <!-- Messages -->
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

    <!-- Main Content -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem; max-width: 1000px; margin: 0 auto;">
        <div class="card">
            <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>💳</span> Select Payment Method
            </h2>

            <!-- Payment Methods -->
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                <?php foreach ([
                    ['value' => 'qris', 'icon' => '📱', 'title' => 'QRIS', 'desc' => 'Scan QR Code dengan aplikasi e-wallet'],
                    ['value' => 'transfer', 'icon' => '🏦', 'title' => 'Bank Transfer', 'desc' => 'Transfer ke rekening Bille Southside'],
                    ['value' => 'ewallet', 'icon' => '👛', 'title' => 'E-Wallet', 'desc' => 'Gopay, OVO, Dana, LinkAja'],
                    ['value' => 'cash', 'icon' => '💵', 'title' => 'Cash Payment', 'desc' => 'Bayar langsung di venue']
                ] as $method): ?>
                    <label class="payment-method" data-method="<?= $method['value'] ?>" 
                           style="display: flex; align-items: center; gap: 1rem; padding: 1rem; 
                                  border: 2px solid var(--border-color); border-radius: 12px; cursor: pointer;
                                  transition: all 0.3s ease; background: transparent;">
                        <input type="radio" name="payment_method" value="<?= $method['value'] ?>" 
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
                    <input type="checkbox" id="payment_terms" required 
                           style="margin-top: 0.3rem; accent-color: var(--accent);">
                    <span>
                        Saya menyetujui bahwa pembayaran ini tidak dapat dikembalikan (non-refundable) 
                        kecuali tournament dibatalkan oleh penyelenggara.
                    </span>
                </label>
            </div>

            <!-- Submit Button -->
            <button id="confirmPaymentBtn" class="btn btn-primary" style="width: 100%; padding: 1rem; font-weight: 700; font-size: 1.1rem;" disabled>
                🚀 Confirm Payment Method
            </button>
        </div>

        <!-- Order Summary -->
        <div class="card">
            <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>📋</span> Order Summary
            </h2>
            <!-- ... (sama seperti sebelumnya) ... -->
            <div style="text-align: center; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🎱</div>
                <h3 style="font-weight: 800; font-size: 1.2rem; margin-bottom: 0.5rem;">
                    <?= htmlspecialchars($data['registration']['tournament_name']) ?>
                </h3>
                <div style="color: var(--text-muted);">
                    Team: <strong><?= htmlspecialchars($data['registration']['team_name']) ?></strong>
                </div>
            </div>

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

<!-- QRIS Modal -->
<div id="qrisModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                          background: rgba(0,0,0,0.7); z-index: 2000; justify-content: center; align-items: center;">
    <div class="card" style="width: 90%; max-width: 400px; padding: 2rem; text-align: center; position: relative;">
        <button id="closeQrisModal" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.5rem; cursor: pointer;">✕</button>
        <h3 style="font-weight: 700; margin-bottom: 1.5rem;">📱 Scan QRIS</h3>
        <div style="margin-bottom: 1.5rem;">
            <img src="<?= BASE_URL ?>/assets/images/qris-bille.png" 
                 alt="QRIS Bille Southside" 
                 style="width: 200px; height: 200px; object-fit: contain; margin: 0 auto; display: block;">
        </div>
        <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
            Scan kode di atas menggunakan aplikasi e-wallet kamu (Gopay, OVO, DANA, dll).
        </p>
        <button class="btn btn-primary" onclick="window.location.reload()">
            ✅ Saya Sudah Bayar
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('.payment-method');
    const termsCheckbox = document.getElementById('payment_terms');
    const confirmBtn = document.getElementById('confirmPaymentBtn');
    const qrisModal = document.getElementById('qrisModal');
    const closeQrisModal = document.getElementById('closeQrisModal');

    let selectedMethod = null;

    // Pilih metode pembayaran
    paymentMethods.forEach(method => {
        const radio = method.querySelector('input[type="radio"]');
        method.addEventListener('click', () => {
            // Reset semua
            paymentMethods.forEach(m => {
                m.style.borderColor = 'var(--border-color)';
                m.style.background = 'transparent';
                m.querySelector('input').checked = false;
            });
            
            // Pilih yang diklik
            method.style.borderColor = 'var(--accent)';
            method.style.background = 'rgba(var(--accent-rgb), 0.08)';
            radio.checked = true;
            selectedMethod = radio.value;
            updateConfirmButton();
        });
    });

    // Aktifkan tombol jika syarat terpenuhi
    function updateConfirmButton() {
        confirmBtn.disabled = !(selectedMethod && termsCheckbox.checked);
    }

    termsCheckbox.addEventListener('change', updateConfirmButton);

    // Konfirmasi pembayaran
    confirmBtn.addEventListener('click', function() {
        if (!selectedMethod) return;

        const registrationId = <?= $data['registration']['id'] ?>;
        const totalAmount = <?= $data['registration']['total_fee'] ?>;
        const tournamentName = `<?= addslashes($data['registration']['tournament_name']) ?>`;
        const teamName = `<?= addslashes($data['registration']['team_name']) ?>`;

        if (selectedMethod === 'qris') {
            // Tampilkan QRIS popup
            qrisModal.style.display = 'flex';
        } else {
            // Kirim ke WhatsApp
            let message = `*🧾 BILLE SOUTHSIDE TOURNAMENT PAYMENT*\n\n`;
            message += `• Tournament: ${tournamentName}\n`;
            message += `• Team: ${teamName}\n`;
            message += `• Metode: ${selectedMethod === 'transfer' ? 'Bank Transfer' : (selectedMethod === 'ewallet' ? 'E-Wallet' : 'Cash')}\n`;
            message += `• Total: Rp ${totalAmount.toLocaleString()}\n\n`;
            message += `Mohon konfirmasi pembayaran ini, kak 🙌\n\n`;
            message += `Terima kasih! 🎱🔥`;

            const waUrl = `https://wa.me/6285129482769?text=${encodeURIComponent(message)}`;
            window.open(waUrl, '_blank');

            // Opsional: simpan ke DB via AJAX
            // fetch('/api/save-tournament-payment', { ... })
        }
    });

    // Tutup modal QRIS
    if (closeQrisModal) {
        closeQrisModal.addEventListener('click', () => {
            qrisModal.style.display = 'none';
        });
    }

    // Tutup modal saat klik di luar
    window.addEventListener('click', (e) => {
        if (e.target === qrisModal) {
            qrisModal.style.display = 'none';
        }
    });
});
</script>