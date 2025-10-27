<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                💰 Manajemen Pembayaran Turnamen
            </h1>
            <p style="color: var(--text-muted);">
                Kelola pembayaran turnamen dan verifikasi pembayaran turnamen
            </p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="<?= Router::url('admin/tournaments') ?>" class="btn" style="background: var(--bg-secondary)">
                🏆 Kembali ke Halaman Turnamen
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">⏳</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #f39c12;">
                <?= count($payments) ?>
            </div>
            <div style="color: var(--text-muted); font-size: 0.9rem;">Pending Payments</div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">💰</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent);">
                Rp <?= number_format(array_sum(array_column($payments, 'amount')), 0, ',', '.') ?>
            </div>
            <div style="color: var(--text-muted); font-size: 0.9rem;">Total Amount</div>

        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">👥</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #3498db;">
                <?= count(array_unique(array_column($payments, 'user_id'))) ?>
            </div>
            <div style="color: var(--text-muted); font-size: 0.9rem;">Pengguna Unik</div>
        </div>

    <!-- Payments Table -->
    <div class="card">
        <h2 style="font-weight: 800; margin-bottom: 1.5rem;">Pembayaran Tertunda</h2>

        <?php if (!empty($payments)): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color);">
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Kode Pembayaran</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">User & Team</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Turnamen</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Jumlah</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Metode</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Dikirim</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Bukti</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 700; font-family: monospace;">
                                        <?= $payment['payment_code'] ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 700;"><?= htmlspecialchars($payment['user_name']) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">
                                        Tim: <?= htmlspecialchars($payment['team_name']) ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">
                                        <?= $payment['email'] ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 700;"><?= htmlspecialchars($payment['tournament_name']) ?></div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 700; color: var(--accent);">
                                        Rp <?= number_format($payment['amount'], 0, ',', '.') ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                      background: rgba(52, 152, 219, 0.2); color: #3498db; text-transform: capitalize;">
                                        <?= $payment['payment_method'] ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-size: 0.9rem;">
                                        <?= date('M j, Y', strtotime($payment['created_at'])) ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">
                                        <?= date('H:i', strtotime($payment['created_at'])) ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <?php if ($payment['payment_proof']): ?>
                                        <a href="/<?= $payment['payment_proof'] ?>" target="_blank"
                                            class="btn btn-sm" style="background: var(--bg-secondary);">
                                            👁️ Lihat Bukti
                                        </a>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted); font-size: 0.9rem;">Tidak ada bukti</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button onclick="updatePaymentStatus(<?= $payment['id'] ?>, 'paid')"
                                            class="btn btn-sm btn-primary">
                                            ✅ Terima
                                        </button>
                                        <button onclick="updatePaymentStatus(<?= $payment['id'] ?>, 'failed')"
                                            class="btn btn-sm" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                                            ❌ Tolak
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">😴</div>
                <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Tidak Ada Pembayaran Tertunda</h3>
                <p>Semua pembayaran turnamen telah diproses.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function updatePaymentStatus(paymentId, status) {
        if (!confirm(`Are you sure you want to ${status === 'paid' ? 'approve' : 'reject'} this payment?`)) {
            return;
        }

        const formData = new FormData();
        formData.append('status', status);

        fetch(`<?= Router::url('admin/tournaments/update-payment/') ?>${paymentId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Payment status updated successfully!');
                    location.reload();
                } else {
                    alert(data.error || 'Failed to update payment status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update payment status');
            });
    }
</script>