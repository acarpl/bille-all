<!-- app/views/billing/detail.php -->
<div style="padding: 2rem 0;">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                Detail Tagihan
            </h1>
            <p style="color: var(--text-muted);">Kode Tagihan: <?php echo htmlspecialchars($data['billing']['billing_code']); ?></p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="<?php echo BASE_URL; ?>/billing/my-billings" class="btn btn-outline">
                ← Kembali ke Tagihan
            </a>
            <button onclick="window.print()" class="btn btn-info">
                🖨️ Print
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            ✅ <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Billing Information -->
        <div class="card">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                <h3 style="font-weight: 600; margin: 0;">Tagihan</h3>
            </div>
            <div style="padding: 1.5rem;">
                <!-- Header -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <h4 style="margin: 0 0 0.5rem 0; color: var(--primary-color);">BILLIARD CLUB</h4>
                        <p style="margin: 0; color: var(--text-muted);">Jl. Example Street No. 123</p>
                        <p style="margin: 0; color: var(--text-muted);">Phone: (021) 123-4567</p>
                        <p style="margin: 0; color: var(--text-muted);">Email: info@billiardclub.com</p>
                    </div>
                    <div style="text-align: right;">
                        <h4 style="margin: 0 0 0.5rem 0; color: var(--primary-color);">TAGIHAN</h4>
                        <p style="margin: 0; font-weight: 600;"><?php echo htmlspecialchars($data['billing']['billing_code']); ?></p>
                        <p style="margin: 0; color: var(--text-muted);">Tanggal: <?php echo date('d/m/Y', strtotime($data['billing']['created_at'])); ?></p>
                        <p style="margin: 0; color: var(--text-muted);">Jatuh Tempo: <?php echo date('d/m/Y', strtotime($data['billing']['due_date'])); ?></p>
                    </div>
                </div>

                <!-- Status & Amount -->
                <div style="display: flex; justify-content: between; align-items: center; padding: 1.5rem; background: var(--card-bg); border-radius: 8px; margin-bottom: 2rem;">
                    <div>
                        <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">Status</div>
                        <span class="badge badge-<?php 
                            echo $data['billing']['status'] == 'paid' ? 'success' : 
                                 ($data['billing']['status'] == 'pending' ? 'warning' : 'error'); 
                        ?>" style="font-size: 1rem;">
                            <?php echo strtoupper($data['billing']['status']); ?>
                        </span>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">Jumlah Total</div>
                        <div style="font-size: 2rem; font-weight: 700; color: var(--primary-color);">
                            Rp <?php echo number_format($data['billing']['amount'], 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <?php if ($data['billing']['booking_code']): ?>
                <div style="margin-bottom: 2rem;">
                    <h4 style="margin-bottom: 1rem;">Informasi Pemesanan</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                        <div>
                            <div style="font-size: 0.9rem; color: var(--text-muted);">Kode Pemesanan</div>
                            <div style="font-weight: 600;"><?php echo htmlspecialchars($data['billing']['booking_code']); ?></div>
                        </div>
                        <div>
                            <div style="font-size: 0.9rem; color: var(--text-muted);">Nomor Meja</div>
                            <div style="font-weight: 600;"><?php echo $data['billing']['table_number']; ?></div>
                        </div>
                        <div>
                            <div style="font-size: 0.9rem; color: var(--text-muted);">Tanggal Bermain</div>
                            <div style="font-weight: 600;"><?php echo date('d/m/Y', strtotime($data['billing']['play_date'])); ?></div>
                        </div>
                        <div>
                            <div style="font-size: 0.9rem; color: var(--text-muted);">Waktu Bermain</div>
                            <div style="font-weight: 600;"><?php echo $data['billing']['play_time']; ?></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Payment Details -->
                <div>
                    <h4 style="margin-bottom: 1rem;">Detail Pembayaran</h4>
                    <div style="border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--card-bg);">
                                    <th style="padding: 1rem; text-align: left; border-bottom: 1px solid var(--border-color);">Deskripsi</th>
                                    <th style="padding: 1rem; text-align: right; border-bottom: 1px solid var(--border-color);">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 1rem; border-bottom: 1px solid var(--border-color);">
                                        <div style="font-weight: 600;"><?php echo $data['billing']['booking_code'] ? 'Pemesanan Meja' : 'Biaya Layanan'; ?></div>
                                        <?php if ($data['billing']['notes']): ?>
                                        <div style="font-size: 0.9rem; color: var(--text-muted); margin-top: 0.25rem;">
                                            <?php echo htmlspecialchars($data['billing']['notes']); ?>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem; text-align: right; border-bottom: 1px solid var(--border-color);">
                                        Rp <?php echo number_format($data['billing']['amount'], 0, ',', '.'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 1rem; text-align: right; font-weight: 600;">Total</td>
                                    <td style="padding: 1rem; text-align: right; font-weight: 600;">
                                        Rp <?php echo number_format($data['billing']['amount'], 0, ',', '.'); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Actions -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Payment Status -->
            <div class="card">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <h3 style="font-weight: 600; margin: 0;">Status Pembayaran</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <div style="text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">
                            <?php echo $data['billing']['status'] == 'paid' ? '✅' : 
                                  ($data['billing']['status'] == 'pending' ? '⏳' : '⚠️'); ?>
                        </div>
                        <h4 style="margin-bottom: 0.5rem;">
                            <?php echo $data['billing']['status'] == 'paid' ? 'Payment Completed' : 
                                  ($data['billing']['status'] == 'pending' ? 'Pending Payment' : 'Payment Overdue'); ?>
                        </h4>
                        <p style="color: var(--text-muted); margin: 0;">
                            <?php if ($data['billing']['status'] == 'paid'): ?>
                                Terima kasih atas pembayaran Anda!
                            <?php elseif ($data['billing']['status'] == 'pending'): ?>
                                Silakan selesaikan pembayaran Anda sebelum <?php echo date('d/m/Y', strtotime($data['billing']['due_date'])); ?>
                            <?php else: ?>
                                Pembayaran telah melewati batas waktu. Silakan hubungi dukungan.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Payment Actions -->
            <?php if ($data['billing']['status'] == 'pending'): ?>
            <div class="card">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <h3 style="font-weight: 600; margin: 0;">Bayar Sekarang</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <a href="<?php echo BASE_URL; ?>/payment/create/<?php echo $data['billing']['id']; ?>" 
                       class="btn btn-success" style="width: 100%; margin-bottom: 1rem;">
                        💳 Bayar dengan Transfer
                    </a>
                    <div style="text-align: center;">
                        <div style="font-size: 0.9rem; color: var(--text-muted);">
                            atau pindai kode QR di halaman pembayaran
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Payment Instructions -->
            <div class="card">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <h3 style="font-weight: 600; margin: 0;">Petunjuk Pembayaran</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <div style="margin-bottom: 1rem;">
                        <strong>Transfer Bank:</strong>
                        <div style="font-size: 0.9rem; color: var(--text-muted);">
                            BCA: 123-456-7890<br>
                            a.n. BILLIARD CLUB
                        </div>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <strong>QRIS:</strong>
                        <div style="font-size: 0.9rem; color: var(--text-muted);">
                            Tersedia di halaman pembayaran
                        </div>
                    </div>
                    <div>
                        <strong>Penting:</strong>
                        <div style="font-size: 0.9rem; color: var(--text-muted);">
                            Sertakan kode tagihan sebagai referensi pembayaran Anda.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support -->
            <div class="card">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <h3 style="font-weight: 600; margin: 0;">Butuh Bantuan?</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <p style="margin: 0 0 1rem 0; color: var(--text-muted);">
                        Hubungi tim dukungan kami untuk bantuan:
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="mailto:support@billiardclub.com" class="btn btn-outline">
                            📧 Email Support
                        </a>
                        <a href="tel:+62123456789" class="btn btn-outline">
                            📞 Call Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    .navbar, .btn, .card[style*="display: flex; flex-direction: column;"] {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #000 !important;
    }
    
    a {
        text-decoration: none !important;
        color: #000 !important;
    }
}

/* Same CSS as index page */
.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-success { 
    background: #e8f5e8; 
    color: #2e7d32; 
    border: 1px solid #4caf50;
}

.badge-warning { 
    background: #fff3e0; 
    color: #f57c00; 
    border: 1px solid #ff9800;
}

.badge-error { 
    background: #ffebee; 
    color: #c62828; 
    border: 1px solid #f44336;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert-success {
    background: #e8f5e8;
    border: 1px solid #4caf50;
    color: #2e7d32;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

/* Responsive Design */
@media (max-width: 768px) {
    div[style*="grid-template-columns: 2fr 1fr"] {
        grid-template-columns: 1fr;
    }
}
</style>