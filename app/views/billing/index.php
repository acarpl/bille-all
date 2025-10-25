<!-- app/views/billing/index.php -->
<div style="padding: 2rem 0;">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                My Billings
            </h1>
            <p style="color: var(--text-muted);">Manage your billings and payments</p>
        </div>
        <a href="<?php echo BASE_URL; ?>/booking" class="btn btn-primary">
            🎱 New Booking
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            ✅ <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            ❌ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Billing Cards -->
    <?php if (!empty($data['billings'])): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
            <?php foreach ($data['billings'] as $billing): ?>
                <div class="card" style="transition: transform 0.2s; border-left: 4px solid <?php 
                    echo $billing['status'] == 'paid' ? '#4caf50' : 
                         ($billing['status'] == 'pending' ? '#ff9800' : '#f44336'); 
                ?>;">
                    <div style="padding: 1.5rem;">
                        <!-- Header -->
                        <div style="display: flex; justify-content: between; align-items: start; margin-bottom: 1rem;">
                            <div>
                                <h3 style="font-weight: 700; margin: 0 0 0.25rem 0; color: var(--primary-color);">
                                    <?php echo htmlspecialchars($billing['billing_code']); ?>
                                </h3>
                                <span class="badge badge-<?php 
                                    echo $billing['status'] == 'paid' ? 'success' : 
                                         ($billing['status'] == 'pending' ? 'warning' : 'error'); 
                                ?>">
                                    <?php echo strtoupper($billing['status']); ?>
                                </span>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-color);">
                                    Rp <?php echo number_format($billing['amount'], 0, ',', '.'); ?>
                                </div>
                                <div style="font-size: 0.9rem; color: var(--text-muted);">
                                    Due: <?php echo date('d/m/Y', strtotime($billing['due_date'])); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Info -->
                        <?php if ($billing['booking_code']): ?>
                        <div style="margin-bottom: 1rem; padding: 1rem; background: var(--card-bg); border-radius: 8px;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <span style="font-size: 1.2rem;">🎱</span>
                                <strong><?php echo htmlspecialchars($billing['booking_code']); ?></strong>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.9rem;">
                                <div>
                                    <div style="color: var(--text-muted);">Table</div>
                                    <div style="font-weight: 600;"><?php echo $billing['table_number']; ?></div>
                                </div>
                                <div>
                                    <div style="color: var(--text-muted);">Date & Time</div>
                                    <div style="font-weight: 600;">
                                        <?php echo date('d/m/Y', strtotime($billing['play_date'])); ?><br>
                                        <?php echo $billing['play_time']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Notes -->
                        <?php if (isset($billing['notes'])): ?>
                        <div style="margin-bottom: 1rem; padding: 0.75rem; background: #f8f9fa; border-radius: 6px; border-left: 3px solid var(--primary-color);">
                            <div style="font-size: 0.9rem; color: var(--text-muted);">
                                <?php echo htmlspecialchars($billing['notes']); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Actions -->
                        <div style="display: flex; gap: 0.5rem; margin-top: 1.5rem;">
                            <a href="<?php echo BASE_URL; ?>/billing/view/<?php echo $billing['id']; ?>" 
                               class="btn btn-sm btn-outline" style="flex: 1;">
                                👁️ View Details
                            </a>
                            <?php if ($billing['status'] == 'pending'): ?>
                                <a href="<?php echo BASE_URL; ?>/payment/create/<?php echo $billing['id']; ?>" 
                                   class="btn btn-sm btn-success" style="flex: 1;">
                                    💳 Pay Now
                                </a>
                            <?php else: ?>
                                <button class="btn btn-sm btn-success" style="flex: 1;" disabled>
                                    ✅ Paid
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📄</div>
            <h3 style="margin-bottom: 0.5rem;">No Billings Found</h3>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">You don't have any billings yet.</p>
            <a href="<?php echo BASE_URL; ?>/booking" class="btn btn-primary">
                🎱 Make Your First Booking
            </a>
        </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <?php if (!empty($data['billings'])): ?>
    <div style="margin-top: 2rem;">
        <div class="card">
            <div style="padding: 1.5rem;">
                <h4 style="margin-bottom: 1rem;">Billing Summary</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <?php
                    $stats = [
                        'total' => ['label' => 'Total Billings', 'value' => count($data['billings']), 'icon' => '📊', 'color' => '#2196f3'],
                        'pending' => ['label' => 'Pending Payment', 'value' => array_filter($data['billings'], fn($b) => $b['status'] == 'pending'), 'icon' => '⏳', 'color' => '#ff9800'],
                        'paid' => ['label' => 'Paid', 'value' => array_filter($data['billings'], fn($b) => $b['status'] == 'paid'), 'icon' => '✅', 'color' => '#4caf50'],
                        'overdue' => ['label' => 'Overdue', 'value' => array_filter($data['billings'], fn($b) => $b['status'] == 'overdue'), 'icon' => '⚠️', 'color' => '#f44336']
                    ];
                    ?>
                    
                    <?php foreach ($stats as $key => $stat): ?>
                        <div style="text-align: center; padding: 1rem; background: var(--card-bg); border-radius: 8px;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;"><?php echo $stat['icon']; ?></div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: <?php echo $stat['color']; ?>;">
                                <?php echo is_array($stat['value']) ? count($stat['value']) : $stat['value']; ?>
                            </div>
                            <div style="color: var(--text-muted); font-size: 0.9rem;"><?php echo $stat['label']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
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

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    text-decoration: none;
    border-radius: 6px;
    display: inline-block;
    transition: all 0.2s;
    text-align: center;
}

.btn-outline {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-color);
}

.btn-outline:hover {
    background: var(--card-bg);
    border-color: var(--primary-color);
}

.btn-success {
    background: #4caf50;
    border: 1px solid #4caf50;
    color: white;
}

.btn-success:hover {
    background: #45a049;
    border-color: #45a049;
}

.btn-success:disabled {
    background: #a5d6a7;
    border-color: #a5d6a7;
    cursor: not-allowed;
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

.alert-error {
    background: #ffebee;
    border: 1px solid #f44336;
    color: #c62828;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Responsive Design */
@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(auto-fill, minmax(350px, 1fr))"] {
        grid-template-columns: 1fr;
    }
    
    .card {
        margin: 0 -1rem;
        border-radius: 0;
        box-shadow: none;
        border: 1px solid var(--border-color);
    }
}
</style>