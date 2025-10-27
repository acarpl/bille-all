<!-- app/views/booking/success.php -->
<div style="padding: 3rem 0; text-align: center;">
    <div style="max-width: 500px; margin: 0 auto;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">&#x1F44F;</div>
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">
            Konfirmasi Pemesanan
        </h1>
        
        <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 2rem; font-weight: 500;">
            Meja Anda telah berhasil dipesan. Silakan selesaikan pembayaran Anda.
        </p>

        <!-- Booking & Payment Details Card -->
        <div class="card" style="text-align: left; margin-bottom: 2rem;">
            <h3 style="font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>&#x1F4CB;</span> Detail Pemesanan & Pembayaran
            </h3>
            <div style="display: grid; gap: 1rem;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted); font-weight: 600;">Kode Pemesanan:</span>
                    <span style="font-weight: 700;">#<?php echo str_pad($booking['booking_id'], 6, '0', STR_PAD_LEFT); ?></span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted); font-weight: 600;">Meja:</span>
                    <span style="font-weight: 700;"><?php echo $booking['table_number']; ?></span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted); font-weight: 600;">Tanggal & Jam:</span>
                    <span style="font-weight: 700;"><?php echo date('M j, Y g:i A', strtotime($booking['start_time'])); ?></span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted); font-weight: 600;">Durasi:</span>
                    <span style="font-weight: 700;"><?php echo $booking['duration']; ?> jam</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                    <span style="color: var(--text-muted); font-weight: 600;">Total Pembayaran:</span>
                    <span style="font-size: 1.2rem; font-weight: 800; color: var(--accent);">
                        Rp <?php echo number_format($booking['total_price'], 0, ',', '.'); ?>
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-muted); font-weight: 600;">Status Pembayaran:</span>
                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                              background: rgba(243, 156, 18, 0.2); color: #f39c12;">
                        ⏳ Tertunda
                    </span>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="card" style="margin-bottom: 2rem;">
            <h3 style="font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>💳</span> Metode Pembayaran
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; 
                            background: rgba(255, 255, 255, 0.05); border-radius: 8px;">
                    <div style="font-size: 1.5rem;">💵</div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600;">Pembayaran Tunai</div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">Bayar di tempat ketika Anda tiba</div>
                    </div>
                    <button onclick="selectPaymentMethod('cash')" 
                            class="btn btn-outline" style="font-size: 0.8rem;">
                        Pilih
                    </button>
                </div>
                
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; 
                            background: rgba(255, 255, 255, 0.05); border-radius: 8px;">
                    <div style="font-size: 1.5rem;">🏦</div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600;">QRIS</div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">Pindai QRIS BILLE untuk membayar</div>
                    </div>
                    <button onclick="openQrisModal()" 
                            class="btn btn-outline" style="font-size: 0.8rem;">
                        Pilih
                    </button>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="<?php echo Router::url('booking'); ?>" class="btn btn-outline" style="font-weight: 600;">
                📅 Pemesanan Meja Lain
            </a>
            <a href="<?php echo Router::url('home'); ?>" class="btn btn-primary" style="font-weight: 700;">
                🏠 Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

<!-- QRIS Modal -->
<div id="qrisModal" style="
    display: none; 
    position: fixed; 
    inset: 0;
    background: rgba(0,0,0,0.6); 
    z-index: 9999;
    justify-content: center; 
    align-items: center;">
    <div style="background: #fff; border-radius: 16px; padding: 2rem; max-width: 400px; text-align: center; color: #333;">
        <h3 style="font-weight: 700; margin-bottom: 1rem;">Pindai QRIS BILLE</h3>
        <img src="https://billesouthside.biz.id/public/images/qris-bille.jpg" alt="QRIS BILLE" style="width: 250px; height: 250px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">
            Pindai QRIS BILLE untuk membayar pesanan Anda. Jangan konfirmasi setelah membayar.
        </p>
       <button onclick="confirmQrisPayment()" class="btn btn-primary" style="margin-bottom: 0.5rem;">✅ I’ve Paid</button><br>
        <button onclick="closeQrisModal()" class="btn btn-outline">✖ Close</button>
    </div>
</div>

<script>
function openQrisModal() {
    document.getElementById('qrisModal').style.display = 'flex';
}
function closeQrisModal() {
    document.getElementById('qrisModal').style.display = 'none';
}

function confirmQrisPayment() {
    const bookingId = <?php echo $booking['booking_id']; ?>;
    if (confirm('Confirm that you have paid via QRIS?')) {
        updatePaymentMethod(bookingId, 'qris');
        closeQrisModal();
    }
}

function selectPaymentMethod(method) {
    const methodNames = {
        'cash': 'Cash',
        'transfer': 'Bank Transfer', 
        'ewallet': 'E-Wallet',
        'qris': 'Qris'
    };
    
    if (confirm(`Select ${methodNames[method]} as payment method?`)) {
        updatePaymentMethod(<?php echo $booking['booking_id']; ?>, method);
    }
}

function updatePaymentMethod(bookingId, method) {
    const formData = new FormData();
    formData.append('booking_id', bookingId);
    formData.append('payment_method', method);
    
    fetch('<?php echo Router::url('booking/update-payment-method'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`✅ Payment method set to ${method}`);
            location.reload();
        } else {
            alert('❌ Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to update payment method');
    });
}
</script>
