<!-- app/views/admin/payments.php -->
<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
                Pembayaran <span class="text-accent">Pengelolaan</span>
            </h1>
            <p style="color: var(--text-muted); font-weight: 500;">
                Tinjau dan konfirmasi pembayaran pelanggan
            </p>
        </div>
        <div style="color: var(--text-muted); font-weight: 600;">
            Total Pendapatan: Rp <?php echo number_format($totalRevenue ?? 0, 0, ',', '.'); ?>
        </div>
    </div>

    <!-- Payment Status Filters -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <span style="font-weight: 700; color: var(--text-muted);">Filter berdasarkan status:</span>

            <a href="<?php echo Router::url('admin/payments?status=pending'); ?>"
                style="padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-weight: 600;
                      background: <?php echo $status === 'pending' ? 'rgba(243, 156, 18, 0.2)' : 'rgba(255,255,255,0.05)'; ?>;
                      color: <?php echo $status === 'pending' ? '#f39c12' : 'var(--text-light)'; ?>;
                      border: 1px solid <?php echo $status === 'pending' ? '#f39c12' : 'var(--border-color)'; ?>;">
                ⏳ Menunggu
            </a>

            <a href="<?php echo Router::url('admin/payments?status=paid'); ?>"
                style="padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-weight: 600;
                      background: <?php echo $status === 'paid' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(255,255,255,0.05)'; ?>;
                      color: <?php echo $status === 'paid' ? '#2ecc71' : 'var(--text-light)'; ?>;
                      border: 1px solid <?php echo $status === 'paid' ? '#2ecc71' : 'var(--border-color)'; ?>;">
                ✅ Sudah
            </a>

            <a href="<?php echo Router::url('admin/payments?status=failed'); ?>"
                style="padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-weight: 600;
                      background: <?php echo $status === 'failed' ? 'rgba(231, 76, 60, 0.2)' : 'rgba(255,255,255,0.05)'; ?>;
                      color: <?php echo $status === 'failed' ? '#e74c3c' : 'var(--text-light)'; ?>;
                      border: 1px solid <?php echo $status === 'failed' ? '#e74c3c' : 'var(--border-color)'; ?>;">
                ❌ Gagal
            </a>

            <span style="font-weight: 700; color: var(--text-muted); margin-left: 1rem;">Metode:</span>
            <select onchange="filterByMethod(this.value)"
                style="padding: 0.5rem; background: rgba(255,255,255,0.08); border: 1px solid var(--border-color); 
                       border-radius: 5px; color: var(--text-light);">
                <option value="">Semua Metode</option>
                <option value="cash" <?php echo isset($_GET['method']) && $_GET['method'] === 'cash' ? 'selected' : ''; ?>>Tunai</option>
                <option value="transfer" <?php echo isset($_GET['method']) && $_GET['method'] === 'transfer' ? 'selected' : ''; ?>>Transfer</option>
                <option value="ewallet" <?php echo isset($_GET['method']) && $_GET['method'] === 'ewallet' ? 'selected' : ''; ?>>E-Wallet</option>
            </select>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card">
        <?php if (!empty($payments)): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">ID Pembayaran</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Pelanggan</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Meja</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Jumlah</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Metode</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Status</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Tanggal</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 700; color: var(--accent);">
                                        #<?php echo str_pad($payment['id'], 6, '0', STR_PAD_LEFT); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 600;"><?php echo htmlspecialchars($payment['customer_name']); ?></div>
                                    <div style="color: var(--text-muted); font-size: 0.9rem;">
                                        <?php echo $payment['user_name']; ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 600;">Meja <?php echo $payment['table_number']; ?></div>
                                    <div style="color: var(--text-muted); font-size: 0.9rem;">
                                        #<?php echo str_pad($payment['booking_id'], 6, '0', STR_PAD_LEFT); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 700; color: var(--accent);">
                                        Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                              background: rgba(52, 152, 219, 0.2); color: #3498db;">
                                        <?php echo ucfirst($payment['payment_method']); ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem;">
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                              background: <?php echo getPaymentStatusColor($payment['status']); ?>;
                                              color: <?php echo getPaymentStatusTextColor($payment['status']); ?>;">
                                        <?php echo ucfirst($payment['status']); ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 600;">
                                        <?php echo date('M j, Y', strtotime($payment['created_at'])); ?>
                                    </div>
                                    <div style="color: var(--text-muted); font-size: 0.9rem;">
                                        <?php echo date('g:i A', strtotime($payment['created_at'])); ?>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="display: flex; gap: 0.5rem;">
                                        <!-- View Details -->
                                        <button onclick="viewPayment(<?php echo $payment['id']; ?>)"
                                            style="background: rgba(52, 152, 219, 0.2); color: #3498db; 
                                                       border: none; padding: 0.5rem; border-radius: 5px; 
                                                       cursor: pointer; font-size: 0.8rem;"
                                            title="View Details">
                                            👁️
                                        </button>
                                        <!-- Payment Actions -->
                                        <?php if ($payment['status'] === 'pending'): ?>
                                            <?php if ($payment['payment_method'] === 'transfer'): ?>
                                                <button onclick="viewProof(<?php echo $payment['id']; ?>)"
                                                    style="background: rgba(155, 89, 182, 0.2); color: #9b59b6; 
                                                               border: none; padding: 0.5rem; border-radius: 5px; 
                                                               cursor: pointer; font-size: 0.8rem;"
                                                    title="View Proof">
                                                    📷
                                                </button>
                                            <?php endif; ?>

                                            <button onclick="updatePaymentStatus(<?php echo $payment['id']; ?>, 'paid')"
                                                style="background: rgba(46, 204, 113, 0.2); color: #2ecc71; 
                                                           border: none; padding: 0.5rem; border-radius: 5px; 
                                                           cursor: pointer; font-size: 0.8rem;"
                                                title="Mark as Paid">
                                                ✅
                                            </button>

                                            <button onclick="updatePaymentStatus(<?php echo $payment['id']; ?>, 'failed')"
                                                style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; 
                                                           border: none; padding: 0.5rem; border-radius: 5px; 
                                                           cursor: pointer; font-size: 0.8rem;"
                                                title="Mark as Failed">
                                                ❌
                                            </button>
                                        <?php endif; ?>

                                        <!-- Receipt -->
                                        <?php if ($payment['status'] === 'paid'): ?>
                                            <button onclick="generateReceipt(<?php echo $payment['id']; ?>)"
                                                style="background: rgba(241, 196, 15, 0.2); color: #f1c40f; 
                                                           border: none; padding: 0.5rem; border-radius: 5px; 
                                                           cursor: pointer; font-size: 0.8rem;"
                                                title="Generate Receipt">
                                                🧾
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">
                    <?php echo $status === 'pending' ? '⏳' : ($status === 'paid' ? '✅' : '❌'); ?>
                </div>
                <h3 style="font-weight: 700; margin-bottom: 0.5rem;">
                    Tidak ada <?php echo ucfirst($status); ?> Pembayaran
                </h3>
                <p>Tidak ada pembayaran yang cocok dengan filter yang dipilih.</p>
                <a href="<?php echo Router::url('admin/payments?status=pending'); ?>" class="btn btn-outline" style="margin-top: 1rem;">
                    Lihat Pembayaran Tertunda
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Payment Statistics -->
    <?php if ($status === 'paid' && isset($revenueData)): ?>
        <div class="card" style="margin-top: 2rem;">
            <h2 style="font-weight: 800; margin-bottom: 1.5rem;">Ringkasan Pendapatan</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">💰</div>
                    <div style="font-weight: 700; margin-bottom: 0.25rem;">Hari Ini</div>
                    <div style="color: var(--accent); font-weight: 800; font-size: 1.2rem;">
                        Rp <?php echo number_format($revenueData['today'], 0, ',', '.'); ?>
                    </div>
                </div>

                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📊</div>
                    <div style="font-weight: 700; margin-bottom: 0.25rem;">Minggu Ini</div>
                    <div style="color: var(--accent); font-weight: 800; font-size: 1.2rem;">
                        Rp <?php echo number_format($revenueData['week'], 0, ',', '.'); ?>
                    </div>
                </div>

                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📈</div>
                    <div style="font-weight: 700; margin-bottom: 0.25rem;">Bulan Ini</div>
                    <div style="color: var(--accent); font-weight: 800; font-size: 1.2rem;">
                        Rp <?php echo number_format($revenueData['month'], 0, ',', '.'); ?>
                    </div>
                </div>

                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎯</div>
                    <div style="font-weight: 700; margin-bottom: 0.25rem;">Rata-rata/Hari</div>
                    <div style="color: var(--accent); font-weight: 800; font-size: 1.2rem;">
                        Rp <?php echo number_format($revenueData['month'] / date('j'), 0, ',', '.'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function viewPayment(paymentId) {
        alert('View payment details for ID: ' + paymentId);
        // Bisa di-expand untuk modal detail
    }

    function viewProof(paymentId) {
        // Untuk sekarang, tampilkan alert
        alert('View transfer proof for payment ID: ' + paymentId);

        // Nanti bisa di-expand untuk modal yang menampilkan gambar
        // Contoh: showProofModal(paymentId);
    }

    // Contoh modal untuk view proof (bisa dikembangkan nanti)
    function showProofModal(paymentId) {
        // Implementasi modal untuk menampilkan bukti transfer
        const modal = document.createElement('div');
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.backgroundColor = 'rgba(0,0,0,0.8)';
        modal.style.display = 'flex';
        modal.style.justifyContent = 'center';
        modal.style.alignItems = 'center';
        modal.style.zIndex = '1000';

        modal.innerHTML = `
        <div style="background: var(--card-bg); padding: 2rem; border-radius: 12px; max-width: 500px;">
            <h3 style="font-weight: 700; margin-bottom: 1rem;">Transfer Proof</h3>
            <img src="/uploads/proof_${paymentId}.jpg" alt="Payment Proof" style="max-width: 100%; border-radius: 8px;">
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button onclick="approvePayment(${paymentId})" class="btn btn-primary">Terima</button>
                <button onclick="rejectPayment(${paymentId})" class="btn btn-outline">Tolak</button>
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="btn btn-outline">Tutup</button>
            </div>
        </div>
    `;

        document.body.appendChild(modal);
    }

    function updatePaymentStatus(paymentId, newStatus) {
        const statusText = {
            'paid': 'Paid',
            'failed': 'Failed'
        };

        if (!confirm(`Mark this payment as "${statusText[newStatus]}"?`)) {
            return;
        }

        const formData = new FormData();
        formData.append('payment_id', paymentId);
        formData.append('status', newStatus);

        // ✅ FIXED: Pakai route yang benar
        fetch('<?php echo Router::url('admin/update-payment-status'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Status pembayaran berhasil diperbarui!');
                    location.reload();
                } else {
                    alert('❌ Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Gagal memperbarui status pembayaran');
            });
    }

    function generateReceipt(paymentId) {
        alert('Memuat struk pembayaran untuk ID: ' + paymentId);
        // Bisa redirect ke receipt page atau print
    }

    function filterByMethod(method) {
        const url = new URL(window.location.href);
        if (method) {
            url.searchParams.set('method', method);
        } else {
            url.searchParams.delete('method');
        }
        window.location.href = url.toString();
    }
</script>

<?php
// Helper functions
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

// Temporary revenue functions - nanti bisa diintegrasikan dengan model
function getTodayRevenue()
{
    return 0; // Placeholder
}

function getWeekRevenue()
{
    return 0; // Placeholder  
}

function getMonthRevenue()
{
    return 0; // Placeholder
}

function getAverageRevenue()
{
    return 0; // Placeholder
}
?>