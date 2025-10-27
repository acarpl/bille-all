<!-- app/views/admin/billing/index.php -->
<div style="padding: 2rem 0;">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                Sesi Tagihan
            </h1>
            <p style="color: var(--text-muted);">Kelola sesi tagihan dan pembayaran</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="<?php echo BASE_URL; ?>/admin/bookings" class="btn btn-outline">
                Lihat Booking
            </a>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: start;">
                <div>
                    <p style="color: var(--text-muted); margin-bottom: 0.5rem;">Jumlah Sesi</p>
                    <h3 style="font-size: 2rem; font-weight: 700; margin: 0;">
                        <?php echo $data['stats']['total_sessions'] ?? 0; ?>
                    </h3>
                </div>
                <div style="padding: 0.75rem; background: #e3f2fd; border-radius: 8px;">
                    <span style="font-size: 1.5rem;">⏱️</span>
                </div>
            </div>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: start;">
                <div>
                    <p style="color: var(--text-muted); margin-bottom: 0.5rem;">Sesi Aktif</p>
                    <h3 style="font-size: 2rem; font-weight: 700; margin: 0;">
                        <?php echo $data['stats']['active_sessions'] ?? 0; ?>
                    </h3>
                </div>
                <div style="padding: 0.75rem; background: #fff3e0; border-radius: 8px;">
                    <span style="font-size: 1.5rem;">🔥</span>
                </div>
            </div>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: start;">
                <div>
                    <p style="color: var(--text-muted); margin-bottom: 0.5rem;">Pendapatan Total</p>
                    <h3 style="font-size: 2rem; font-weight: 700; margin: 0;">
                        Rp <?php echo isset($data['stats']['total_revenue']) ? number_format($data['stats']['total_revenue'], 0, ',', '.') : '0'; ?>
                    </h3>
                </div>
                <div style="padding: 0.75rem; background: #e8f5e8; border-radius: 8px;">
                    <span style="font-size: 1.5rem;">💰</span>
                </div>
            </div>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: between; align-items: start;">
                <div>
                    <p style="color: var(--text-muted); margin-bottom: 0.5rem;">Rata-rata Sesi</p>
                    <h3 style="font-size: 2rem; font-weight: 700; margin: 0;">
                        Rp <?php echo isset($data['stats']['avg_session_charge']) ? number_format($data['stats']['avg_session_charge'], 0, ',', '.') : '0'; ?>
                    </h3>
                </div>
                <div style="padding: 0.75rem; background: #f3e5f5; border-radius: 8px;">
                    <span style="font-size: 1.5rem;">📊</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Controls -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
            <h3 style="margin: 0;">Tindakan Cepat</h3>
        </div>
        <div style="padding: 1.5rem;">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="<?php echo BASE_URL; ?>/admin/billings?status=active" class="btn btn-warning">
                    🔥 Sesi Aktif (<?php echo count(array_filter($data['sessions'], fn($s) => $s['is_active'] == 1)); ?>)
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/billings?status=completed" class="btn btn-success">
                    ✅ Sesi Selesai (<?php echo count(array_filter($data['sessions'], fn($s) => $s['is_active'] == 0)); ?>)
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/billings" class="btn btn-outline">
                    📋 Semua Sesi
                </a>
            </div>
        </div>
    </div>

    <!-- Sessions Table -->
    <div class="card">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--card-bg); border-bottom: 2px solid var(--border-color);">
                        <th style="padding: 1rem; text-align: left;">Kode Pemesanan</th>
                        <th style="padding: 1rem; text-align: left;">Pelanggan</th>
                        <th style="padding: 1rem; text-align: left;">Meja</th>
                        <th style="padding: 1rem; text-align: center;">Waktu Mulai</th>
                        <th style="padding: 1rem; text-align: center;">Durasi</th>
                        <th style="padding: 1rem; text-align: right;">Biaya Saat Ini</th>
                        <th style="padding: 1rem; text-align: center;">Status</th>
                        <th style="padding: 1rem; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['sessions'])): ?>
                        <?php foreach ($data['sessions'] as $session): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 600; color: var(--primary-color);">
                                        <?php echo htmlspecialchars($session['booking_code'] ?? 'N/A'); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 600;"><?php echo htmlspecialchars($session['user_name'] ?? 'N/A'); ?></div>
                                    <?php if (isset($session['email'])): ?>
                                        <div style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.25rem;">
                                            <?php echo htmlspecialchars($session['email']); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 1rem;">
                                    <?php echo htmlspecialchars($session['table_number'] ?? 'N/A'); ?>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <?php echo date('H:i', strtotime($session['start_time'])); ?>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <?php echo $this->billingModel->getSessionDuration($session['id']); ?>
                                </td>
                                <td style="padding: 1rem; text-align: right; font-weight: 600;">
                                    Rp <?php echo number_format($session['current_charge'], 0, ',', '.'); ?>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="badge badge-<?php echo $session['is_active'] ? ($session['is_paused'] ? 'warning' : 'success') : 'secondary'; ?>">
                                        <?php echo $session['is_active'] ? ($session['is_paused'] ? 'PAUSED' : 'ACTIVE') : 'COMPLETED'; ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="<?php echo BASE_URL; ?>/admin/billings/detail/<?php echo $session['id']; ?>" 
                                           class="btn btn-sm btn-outline">
                                            👁️ Lihat
                                        </a>
                                        
                                        <?php if ($session['is_active'] && !$session['is_paused']): ?>
                                            <form method="POST" action="<?php echo BASE_URL; ?>/admin/billings/pause/<?php echo $session['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-warning">⏸️ Jeda</button>
                                            </form>
                                        <?php elseif ($session['is_active'] && $session['is_paused']): ?>
                                            <form method="POST" action="<?php echo BASE_URL; ?>/admin/billings/resume/<?php echo $session['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-success">▶️ Lanjutkan</button>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <?php if ($session['is_active']): ?>
                                            <form method="POST" action="<?php echo BASE_URL; ?>/admin/billings/stop/<?php echo $session['id']; ?>" 
                                                  onsubmit="return confirm('Stop this billing session?')">
                                                <button type="submit" class="btn btn-sm btn-error">⏹️ Hentikan</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="padding: 2rem; text-align: center; color: var(--text-muted);">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">⏱️</div>
                                <h3>Sesi Penagihan Tidak Ditemukan</h3>
                                <p>Tidak ada sesi penagihan yang tersedia saat ini.</p>
                                <a href="<?php echo BASE_URL; ?>/admin/bookings" class="btn btn-primary">
                                    Lihat Pemesanan untuk Memulai Sesi
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

