<!-- app/views/auth/profile.php - UPDATE dengan responsive design -->
<style>
    /* Responsive Styles */
    .profile-container {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
    }

    .profile-sidebar {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .profile-main {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .booking-card,
    .payment-card {
        background: rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-light);
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-light);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--accent);
        background: rgba(255, 255, 255, 0.12);
    }

    .form-group input:disabled {
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-muted);
        cursor: not-allowed;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .profile-container {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .profile-sidebar {
            order: 2;
        }

        .profile-main {
            order: 1;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .booking-card,
        .payment-card {
            padding: 1rem;
        }

        .booking-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .booking-details {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .payment-item {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .payment-info {
            text-align: left;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 0 0.5rem;
        }

        .card {
            padding: 1rem;
        }

        h1 {
            font-size: 2rem !important;
        }

        h2 {
            font-size: 1.5rem !important;
        }
    }

    /* Utility Classes */
    .flex-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .flex-column {
        display: flex;
        flex-direction: column;
    }

    .text-small {
        font-size: 0.9rem;
    }

    .text-muted {
        color: var(--text-muted);
    }
</style>

<div style="padding: 1rem 0;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
            Profil Saya <span class="text-accent">Saya</span>
        </h1>
        <p class="text-muted" style="font-weight: 500;">
            Kelola profil dan lihat riwayat booking
        </p>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['profile_success'])): ?>
        <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid rgba(46, 204, 113, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <div style="color: #2ecc71; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ✅ <?php echo $_SESSION['profile_success'];
                    unset($_SESSION['profile_success']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['profile_error'])): ?>
        <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid rgba(231, 76, 60, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <div style="color: #e74c3c; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ❌ <?php echo $_SESSION['profile_error'];
                    unset($_SESSION['profile_error']); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="profile-container">
        <!-- Sidebar - Profile & Stats -->
        <div class="profile-sidebar">
            <!-- Profile Card -->
            <div class="card">
                <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>👤</span> Informasi Profil
                </h2>

                <form method="POST" action="<?php echo Router::url('auth/update-profile'); ?>">
                    <div class="flex-column" style="gap: 1rem;">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                            <small class="text-muted">Email tidak dapat diubah</small>
                        </div>

                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label>ID Pelajar</label>
                            <input type="text" name="student_id" value="<?php echo htmlspecialchars($user['student_id'] ?? ''); ?>"
                                placeholder="Untuk promo khusus pelajar">
                        </div>

                        <div class="form-group">
                            <label>Kata Sandi Baru</label>
                            <input type="password" name="password"
                                placeholder="Kosongkan kata sandi jika tidak ingin mengubah">
                            <small class="text-muted">Minimum 6 karakter</small>
                        </div>

                        <button type="submit" class="btn btn-primary" style="font-weight: 700; width: 100%;">
                            💾 Update Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats Card -->
            <div class="card">
                <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📊</span> Statistik Saya
                </h2>

                <div class="stats-grid">
                    <div class="flex-column" style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent);"><?php echo $stats['total_bookings']; ?></div>
                        <div class="text-small text-muted">Total Pemesanan</div>
                    </div>

                    <div class="flex-column" style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: #27ae60;"><?php echo $stats['completed_bookings']; ?></div>
                        <div class="text-small text-muted">Selesai</div>
                    </div>

                    <div class="flex-column" style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: #f39c12;"><?php echo $stats['active_bookings']; ?></div>
                        <div class="text-small text-muted">Aktif</div>
                    </div>

                    <div class="flex-column" style="text-align: center; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                        <div style="font-size: 1.2rem; font-weight: 800; color: var(--accent);">
                            Rp <?php echo number_format($stats['total_spent'], 0, ',', '.'); ?>
                        </div>
                        <div class="text-small text-muted">Total Biaya</div>
                    </div>
                </div>

                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <div class="flex-between">
                        <span class="text-muted">Poin Loyalitas:</span>
                        <span style="font-weight: 700; color: #9b59b6;"><?php echo $user['loyalty_points']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content - Bookings & Payments -->
        <div class="profile-main">
            <!-- Bookings History -->
            <div class="card">
                <div class="flex-between" style="margin-bottom: 1.5rem;">
                    <h2 style="font-weight: 800;">Riwayat Pemesanan</h2>
                    <a href="<?php echo Router::url('booking'); ?>" class="btn btn-outline" style="font-weight: 600; white-space: nowrap;">
                        📅 Pemesanan Baru
                    </a>
                </div>

                <?php if (!empty($bookings)): ?>
                    <div class="flex-column" style="gap: 1rem;">
                        <?php foreach ($bookings as $booking): ?>
                            <div class="booking-card">
                                <div class="booking-header">
                                    <div>
                                        <div style="font-weight: 700; margin-bottom: 0.25rem;">
                                            Meja <?php echo $booking['table_number']; ?> • <?php echo $booking['floor_name']; ?>
                                        </div>
                                        <div class="text-small text-muted">
                                            <?php echo date('M j, Y g:i A', strtotime($booking['start_time'])); ?> •
                                            <?php echo $booking['duration_hours']; ?> jam
                                        </div>
                                    </div>
                                    <div>
                                        <span class="status-badge"
                                            style="background: <?php echo getBookingStatusColor($booking['status']); ?>; 
                                                     color: <?php echo getBookingStatusTextColor($booking['status']); ?>;">
                                            <?php echo ucfirst($booking['status']); ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="booking-details" style="margin-top: 1rem;">
                                    <div class="text-small text-muted">
                                        Paket: <?php echo $booking['package_name']; ?>
                                    </div>
                                    <div style="font-weight: 700; color: var(--accent);">
                                        Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?>
                                    </div>
                                </div>

                                <?php if (in_array($booking['status'], ['confirmed', 'active'])): ?>
                                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                                        <button onclick="cancelBooking(<?php echo $booking['id']; ?>)"
                                            class="btn btn-outline" style="font-size: 0.8rem; padding: 0.5rem 1rem; width: 100%;">
                                            ❌ Batalkan Booking
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
                        <p>Tidak ada riwayat pemesanan.</p>
                        <a href="<?php echo Router::url('booking'); ?>" class="btn btn-primary" style="margin-top: 1rem;">
                            Buat Pemesanan Pertama Anda
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Payment History -->
            <div class="card">
                <h2 style="font-weight: 800; margin-bottom: 1.5rem;">Riwayat Pembayaran</h2>

                <?php if (!empty($payments)): ?>
                    <div class="flex-column" style="gap: 1rem;">
                        <?php foreach ($payments as $payment): ?>
                            <div class="payment-card payment-item">
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; margin-bottom: 0.25rem;">
                                        Tabel <?php echo $payment['table_number']; ?>
                                    </div>
                                    <div class="text-small text-muted">
                                        <?php echo date('M j, Y', strtotime($payment['created_at'])); ?> •
                                        <?php echo ucfirst($payment['payment_method']); ?>
                                    </div>
                                </div>
                                <div class="payment-info">
                                    <div style="font-weight: 700; color: var(--accent); margin-bottom: 0.25rem;">
                                        Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?>
                                    </div>
                                    <span class="status-badge"
                                        style="background: <?php echo getPaymentStatusColor($payment['status']); ?>; 
                                                 color: <?php echo getPaymentStatusTextColor($payment['status']); ?>;">
                                        <?php echo ucfirst($payment['status']); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 1rem; color: var(--text-muted);">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">💳</div>
                        <p>Tidak ada riwayat pembayaran.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function cancelBooking(bookingId) {
        if (!confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')) {
            return;
        }

        // Implement cancel booking functionality
        alert('Fitur batalkan pemesanan akan segera hadir!');
    }
</script>

<?php
// Helper functions (tetap sama)
function getBookingStatusColor($status)
{
    switch ($status) {
        case 'confirmed':
            return 'rgba(52, 152, 219, 0.2)';
        case 'active':
            return 'rgba(46, 204, 113, 0.2)';
        case 'completed':
            return 'rgba(149, 165, 166, 0.2)';
        case 'cancelled':
            return 'rgba(231, 76, 60, 0.2)';
        default:
            return 'rgba(149, 165, 166, 0.2)';
    }
}

function getBookingStatusTextColor($status)
{
    switch ($status) {
        case 'confirmed':
            return '#3498db';
        case 'active':
            return '#2ecc71';
        case 'completed':
            return '#95a5a6';
        case 'cancelled':
            return '#e74c3c';
        default:
            return '#95a5a6';
    }
}

function getPaymentStatusColor($status)
{
    switch ($status) {
        case 'pending':
            return 'rgba(243, 156, 18, 0.2)';
        case 'paid':
            return 'rgba(46, 204, 113, 0.2)';
        case 'failed':
            return 'rgba(231, 76, 60, 0.2)';
        default:
            return 'rgba(149, 165, 166, 0.2)';
    }
}

function getPaymentStatusTextColor($status)
{
    switch ($status) {
        case 'pending':
            return '#f39c12';
        case 'paid':
            return '#2ecc71';
        case 'failed':
            return '#e74c3c';
        default:
            return '#95a5a6';
    }
}
?>