<!-- app/views/admin/billings/detail.php -->
<div style="padding: 2rem 0;">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                Billing Details
            </h1>
            <p style="color: var(--text-muted);">Billing code: <?php echo htmlspecialchars($data['billing']['billing_code']); ?></p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="<?php echo BASE_URL; ?>/admin/billings" class="btn btn-outline">
                ← Back to Billings
            </a>
            <a href="<?php echo BASE_URL; ?>/billing/view/<?php echo $data['billing']['id']; ?>" 
               class="btn btn-info" target="_blank">
                🖨️ Print Billing
            </a>
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
                <h3 style="font-weight: 600; margin: 0;">Billing Information</h3>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Billing Code</label>
                        <p style="font-weight: 600; margin: 0;"><?php echo htmlspecialchars($data['billing']['billing_code']); ?></p>
                    </div>
                    <div>
                        <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Status</label>
                        <span class="badge badge-<?php 
                            echo $data['billing']['status'] == 'paid' ? 'success' : 
                                ($data['billing']['status'] == 'pending' ? 'warning' : 'error'); 
                        ?>">
                            <?php echo strtoupper($data['billing']['status']); ?>
                        </span>
                    </div>
                    <div>
                        <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Amount</label>
                        <p style="font-weight: 600; margin: 0; font-size: 1.2rem;">
                            Rp <?php echo number_format($data['billing']['amount'], 0, ',', '.'); ?>
                        </p>
                    </div>
                    <div>
                        <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Due Date</label>
                        <p style="font-weight: 600; margin: 0;"><?php echo date('d/m/Y', strtotime($data['billing']['due_date'])); ?></p>
                    </div>
                    <div>
                        <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Created Date</label>
                        <p style="margin: 0;"><?php echo date('d/m/Y H:i', strtotime($data['billing']['created_at'])); ?></p>
                    </div>
                    <div>
                        <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Last Updated</label>
                        <p style="margin: 0;"><?php echo date('d/m/Y H:i', strtotime($data['billing']['updated_at'])); ?></p>
                    </div>
                </div>

                <?php if ($data['billing']['notes']): ?>
                <div style="margin-top: 1.5rem;">
                    <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Notes</label>
                    <p style="margin: 0; padding: 1rem; background: var(--card-bg); border-radius: 8px;">
                        <?php echo htmlspecialchars($data['billing']['notes']); ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Customer Information & Actions -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Customer Info -->
            <div class="card">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <h3 style="font-weight: 600; margin: 0;">Customer Information</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Name</label>
                        <p style="font-weight: 600; margin: 0;"><?php echo htmlspecialchars($data['billing']['user_name']); ?></p>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Email</label>
                        <p style="margin: 0;"><?php echo htmlspecialchars($data['billing']['email']); ?></p>
                    </div>
                    <?php if ($data['billing']['booking_code']): ?>
                    <div>
                        <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Booking Code</label>
                        <p style="margin: 0;">
                            <a href="<?php echo BASE_URL; ?>/admin/bookings/detail/<?php echo $data['billing']['booking_id']; ?>" 
                               class="badge badge-info" style="text-decoration: none;">
                                <?php echo htmlspecialchars($data['billing']['booking_code']); ?>
                            </a>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <h3 style="font-weight: 600; margin: 0;">Quick Actions</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <form action="<?php echo BASE_URL; ?>/admin/billings/update-status/<?php echo $data['billing']['id']; ?>" method="POST">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; color: var(--text-muted); margin-bottom: 0.5rem;">Update Status</label>
                            <select name="status" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                                <option value="pending" <?php echo $data['billing']['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="paid" <?php echo $data['billing']['status'] == 'paid' ? 'selected' : ''; ?>>Paid</option>
                                <option value="overdue" <?php echo $data['billing']['status'] == 'overdue' ? 'selected' : ''; ?>>Overdue</option>
                                <option value="cancelled" <?php echo $data['billing']['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            💾 Update Status
                        </button>
                    </form>

                    <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="mailto:<?php echo htmlspecialchars($data['billing']['email']); ?>?subject=Billing%20Reminder%20<?php echo urlencode($data['billing']['billing_code']); ?>" 
                           class="btn btn-outline" style="text-align: center;">
                            📧 Send Reminder
                        </a>
                        
                        <form method="POST" action="<?php echo BASE_URL; ?>/admin/billings/delete/<?php echo $data['billing']['id']; ?>" 
                              onsubmit="return confirm('Are you sure you want to delete this billing? This action cannot be undone.')">
                            <button type="submit" class="btn btn-error" style="width: 100%;">
                                🗑️ Delete Billing
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the same CSS styles as the index page -->
<style>
/* Same CSS as index.php */
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

.badge-info { 
    background: #e3f2fd; 
    color: #1976d2; 
    border: 1px solid #2196f3;
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
    
    .card {
        margin: 0 -1rem;
        border-radius: 0;
    }
}
</style>