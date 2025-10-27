<!-- app/views/admin/bookings.php -->
<div style="padding: 1.5rem 0;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                Kelola <span class="text-accent">Pemesanan</span>
            </h1>
            <p style="color: var(--text-muted); font-weight: 500; font-size: 0.95rem;">
                Lihat dan kelola semua reservasi pelanggan
            </p>
        </div>
        <a href="<?php echo Router::url('booking'); ?>" class="btn btn-primary" style="font-weight: 700; white-space: nowrap;">
            ➕ Pemesanan Baru
        </a>
    </div>

    <!-- Status Filters -->
    <div class="card" style="margin-bottom: 2rem; padding: 1.25rem;">
        <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; font-size: 0.95rem;">
            <span style="font-weight: 700; color: var(--text-muted); white-space: nowrap;">Filter berdasarkan status:</span>

            <a href="<?php echo Router::url('admin/bookings'); ?>"
                style="padding: 0.4rem 0.9rem; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem;
                      background: <?php echo $status === 'all' ? 'var(--accent)' : 'rgba(255,255,255,0.05)'; ?>;
                      color: <?php echo $status === 'all' ? 'white' : 'var(--text-light)'; ?>;
                      border: 1px solid <?php echo $status === 'all' ? 'var(--accent)' : 'var(--border-color)'; ?>;">
                Semua (<?php echo $totalBookings ?? 0; ?>)
            </a>

            <a href="<?php echo Router::url('admin/bookings?status=confirmed'); ?>"
                style="padding: 0.4rem 0.9rem; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem;
                      background: <?php echo $status === 'confirmed' ? 'rgba(52, 152, 219, 0.2)' : 'rgba(255,255,255,0.05)'; ?>;
                      color: <?php echo $status === 'confirmed' ? '#3498db' : 'var(--text-light)'; ?>;
                      border: 1px solid <?php echo $status === 'confirmed' ? '#3498db' : 'var(--border-color)'; ?>;">
                Dikonfirmasi
            </a>

            <a href="<?php echo Router::url('admin/bookings?status=active'); ?>"
                style="padding: 0.4rem 0.9rem; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem;
                      background: <?php echo $status === 'active' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(255,255,255,0.05)'; ?>;
                      color: <?php echo $status === 'active' ? '#2ecc71' : 'var(--text-light)'; ?>;
                      border: 1px solid <?php echo $status === 'active' ? '#2ecc71' : 'var(--border-color)'; ?>;">
                Aktif
            </a>

            <a href="<?php echo Router::url('admin/bookings?status=completed'); ?>"
                style="padding: 0.4rem 0.9rem; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem;
                      background: <?php echo $status === 'completed' ? 'rgba(149, 165, 166, 0.2)' : 'rgba(255,255,255,0.05)'; ?>;
                      color: <?php echo $status === 'completed' ? '#95a5a6' : 'var(--text-light)'; ?>;
                      border: 1px solid <?php echo $status === 'completed' ? '#95a5a6' : 'var(--border-color)'; ?>;">
                Selesai
            </a>

            <a href="<?php echo Router::url('admin/bookings?status=cancelled'); ?>"
                style="padding: 0.4rem 0.9rem; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem;
                      background: <?php echo $status === 'cancelled' ? 'rgba(231, 76, 60, 0.2)' : 'rgba(255,255,255,0.05)'; ?>;
                      color: <?php echo $status === 'cancelled' ? '#e74c3c' : 'var(--text-light)'; ?>;
                      border: 1px solid <?php echo $status === 'cancelled' ? '#e74c3c' : 'var(--border-color)'; ?>;">
                Dibatalkan
            </a>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card">
        <?php if (!empty($bookings)): ?>
            <div style="overflow-x: auto; width: 100%;">
                <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color);">
                            <th style="padding: 1rem; text-align: left; font-weight: 700; color: var(--text-light);">ID Pemesanan</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700; color: var(--text-light);">Pelanggan</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700; color: var(--text-light);">Meja</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700; color: var(--text-light);">Tanggal & Waktu</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700; color: var(--text-light);">Durasi</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700; color: var(--text-light);">Jumlah</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700; color: var(--text-light);">Status</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700; color: var(--text-light);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 1rem; vertical-align: middle;">
                                    <div style="font-weight: 700; color: var(--accent);">
                                        #<?php echo str_pad($booking['id'], 6, '0', STR_PAD_LEFT); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem; vertical-align: middle;">
                                    <div style="font-weight: 600; font-size: 0.95rem;"><?php echo htmlspecialchars($booking['customer_name']); ?></div>
                                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">
                                        <?php echo htmlspecialchars($booking['email'] ?? ''); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem; vertical-align: middle;">
                                    <div style="font-weight: 600; font-size: 0.95rem;"><?php echo htmlspecialchars($booking['table_number']); ?></div>
                                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">
                                        <?php echo htmlspecialchars($booking['floor_name']); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem; vertical-align: middle;">
                                    <div style="font-weight: 600; font-size: 0.95rem;">
                                        <?php echo date('M j, Y', strtotime($booking['start_time'])); ?>
                                    </div>
                                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">
                                        <?php echo date('g:i A', strtotime($booking['start_time'])); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem; vertical-align: middle;">
                                    <div style="font-weight: 600; font-size: 0.95rem;">
                                        <?php echo $booking['duration_hours']; ?> jam
                                    </div>
                                </td>
                                <td style="padding: 1rem; vertical-align: middle;">
                                    <div style="font-weight: 700; color: var(--accent); font-size: 0.95rem;">
                                        Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem; vertical-align: middle;">
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; 
                                                font-size: 0.8rem; font-weight: 600;
                                                background: <?php echo getStatusColor($booking['status']); ?>;
                                                color: <?php echo getStatusTextColor($booking['status']); ?>;">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem; vertical-align: middle;">
                                    <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: nowrap;">
                                        <!-- View Details -->
                                        <button onclick="viewBooking(<?php echo $booking['id']; ?>)"
                                            style="background: rgba(52, 152, 219, 0.2); color: #3498db; 
                                                       border: none; padding: 0.45rem; border-radius: 6px; 
                                                       cursor: pointer; font-size: 0.85rem; min-width: 32px; display: flex; align-items: center; justify-content: center;"
                                            title="View Details">
                                            👁️
                                        </button>

                                        <!-- Status Actions -->
                                        <?php if ($booking['status'] === 'confirmed'): ?>
                                            <button onclick="updateStatus(<?php echo $booking['id']; ?>, 'active')"
                                                style="background: rgba(46, 204, 113, 0.2); color: #2ecc71; 
                                                           border: none; padding: 0.45rem; border-radius: 6px; 
                                                           cursor: pointer; font-size: 0.85rem; min-width: 32px; display: flex; align-items: center; justify-content: center;"
                                                title="Mark as Active">
                                                ▶️
                                            </button>
                                        <?php endif; ?>

                                        <!-- 🔥 Start Billing (AJAX + Countdown) -->
                                        <?php if (in_array($booking['status'], ['confirmed', 'active'])): ?>
                                            <button
                                                onclick="startBilling(<?php echo $booking['id']; ?>, <?php echo (int)$booking['duration_hours']; ?>)"
                                                class="btn btn-sm btn-success"
                                                style="padding: 0.4rem 0.6rem; font-size: 0.85rem; border: none; cursor: pointer; white-space: nowrap;"
                                                title="Start billing session">
                                                ⏱️ Mulai Tagihan
                                            </button>
                                            <span id="countdown-<?php echo $booking['id']; ?>"
                                                style="display: none; margin-left: 0.5rem; font-weight: 700; color: var(--accent); min-width: 90px; text-align: right; font-size: 0.9rem;">
                                            </span>
                                        <?php endif; ?>

                                        <?php if ($booking['status'] === 'active'): ?>
                                            <button onclick="updateStatus(<?php echo $booking['id']; ?>, 'completed')"
                                                style="background: rgba(149, 165, 166, 0.2); color: #95a5a6; 
                                                           border: none; padding: 0.45rem; border-radius: 6px; 
                                                           cursor: pointer; font-size: 0.85rem; min-width: 32px; display: flex; align-items: center; justify-content: center;"
                                                title="Mark as Completed">
                                                ✅
                                            </button>
                                        <?php endif; ?>

                                        <?php if (in_array($booking['status'], ['confirmed', 'active'])): ?>
                                            <button onclick="updateStatus(<?php echo $booking['id']; ?>, 'cancelled')"
                                                style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; 
                                                           border: none; padding: 0.45rem; border-radius: 6px; 
                                                           cursor: pointer; font-size: 0.85rem; min-width: 32px; display: flex; align-items: center; justify-content: center;"
                                                title="Cancel Booking">
                                                ❌
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <?php if (($totalPages ?? 1) > 1): ?>
                <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--border-color); flex-wrap: wrap;">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?php echo Router::url('admin/bookings?status=' . urlencode($status) . '&page=' . $i); ?>"
                            style="padding: 0.45rem 0.9rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95rem;
                                  background: <?php echo $i == $page ? 'var(--accent)' : 'rgba(255,255,255,0.05)'; ?>;
                                  color: <?php echo $i == $page ? 'white' : 'var(--text-light)'; ?>;
                                  border: 1px solid <?php echo $i == $page ? 'var(--accent)' : 'var(--border-color)'; ?>;">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div style="text-align: center; padding: 3rem 1.5rem; color: var(--text-muted);">
                <div style="font-size: 3.5rem; margin-bottom: 1rem;">😴</div>
                <h3 style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1.4rem;">Tidak ada pemesanan yang ditemukan.</h3>
                <p style="font-size: 1rem;">Tidak ada pemesanan yang sesuai dengan filter yang dipilih.</p>
                <a href="<?php echo Router::url('admin/bookings'); ?>" class="btn btn-outline" style="margin-top: 1rem; padding: 0.5rem 1.5rem;">
                    Lihat Semua Pemesanan
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function viewBooking(bookingId) {
        alert('Lihat detail pemesanan untuk ID: ' + bookingId);
    }

    function updateStatus(bookingId, newStatus) {
        if (!confirm('Apakah Anda yakin ingin memperbarui status pemesanan ini menjadi "' + newStatus + '"?')) {
            return;
        }

        const formData = new FormData();
        formData.append('booking_id', bookingId);
        formData.append('status', newStatus);

        fetch('<?php echo Router::url('admin/update-booking-status'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Status pemesanan berhasil diperbarui!');
                    location.reload();
                } else {
                    alert('❌ Error: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Gagal memperbarui status');
            });
    }

    // 🔥 Start Billing + Countdown
    function startBilling(bookingId, durationHours) {
        if (!confirm('Mulai sesi penagihan untuk pemesanan ini? Ini akan memulai hitungan mundur.')) {
            return;
        }

        const button = document.querySelector(`button[onclick="startBilling(${bookingId}, ${durationHours})"]`);
        const countdownEl = document.getElementById(`countdown-${bookingId}`);

        button.disabled = true;
        button.innerHTML = '⏳ Starting...';

        fetch('<?php echo BASE_URL; ?>/admin/billings/create-from-booking/' + bookingId, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.style.display = 'none';
                    startCountdown(bookingId, durationHours * 60);
                } else {
                    alert('❌ ' + (data.error || 'Gagal memulai penagihan'));
                    button.disabled = false;
                    button.innerHTML = '⏱️ Mulai Tagihan';
                }
            })
            .catch(error => {
                console.error('Billing error:', error);
                alert('❌ Gagal memperbarui status');
                button.disabled = false;
                button.innerHTML = '⏱️ Mulai Tagihan';
            });
    }

    function startCountdown(bookingId, totalMinutes) {
        const countdownEl = document.getElementById(`countdown-${bookingId}`);
        if (!countdownEl) return;

        let minutesLeft = totalMinutes;
        countdownEl.style.display = 'inline-block';

        const formatTime = (mins) => {
            const hrs = Math.floor(mins / 60);
            const minsRemain = mins % 60;
            if (hrs > 0) {
                return `${hrs}h ${minsRemain.toString().padStart(2, '0')}m`;
            }
            return `${minsRemain}m`;
        };

        const tick = () => {
            if (minutesLeft < 0) {
                countdownEl.textContent = '⏰ Waktu habis!';
                countdownEl.style.color = '#e74c3c';
                return;
            }

            countdownEl.textContent = `⏱️ ${formatTime(minutesLeft)} tersisa`;
            minutesLeft--;

            if (minutesLeft >= 0) {
                setTimeout(tick, 60000);
            }
        };

        tick();
    }
</script>

<?php
function getStatusColor($status)
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

function getStatusTextColor($status)
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
?>