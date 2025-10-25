<!-- app/views/admin/tables.php -->
<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
                Manage <span class="text-accent">Tables</span>
            </h1>
            <p style="color: var(--text-muted); font-weight: 500;">
                Monitor and update table status in real-time
            </p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <button onclick="refreshTableStatus()" class="btn btn-outline" style="font-weight: 600;">
                🔄 Refresh
            </button>
        </div>
    </div>

    <!-- Table Status Summary -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <?php
        $statusSummary = [
            'available' => ['count' => 0, 'color' => '#27ae60', 'icon' => '✅'],
            'occupied' => ['count' => 0, 'color' => '#e74c3c', 'icon' => '🎱'],
            'reserved' => ['count' => 0, 'color' => '#f39c12', 'icon' => '⏰'],
            'maintenance' => ['count' => 0, 'color' => '#95a5a6', 'icon' => '🛠️']
        ];
        
        foreach ($tables as $table) {
            $statusSummary[$table['status']]['count']++;
        }
        ?>
        
        <?php foreach ($statusSummary as $status => $data): ?>
            <div class="card" style="text-align: center; border-left: 4px solid <?php echo $data['color']; ?>;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;"><?php echo $data['icon']; ?></div>
                <h3 style="font-weight: 700; margin-bottom: 0.5rem; text-transform: capitalize;">
                    <?php echo $status; ?>
                </h3>
                <div style="font-size: 2rem; font-weight: 800; color: <?php echo $data['color']; ?>;">
                    <?php echo $data['count']; ?>
                </div>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Tables</p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Tables Grid -->
    <div class="card">
        <h2 style="font-weight: 800; margin-bottom: 1.5rem;">All Tables</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            <?php foreach ($tables as $table): ?>
                <div class="table-card" 
                     style="background: var(--card-bg); border: 2px solid <?php echo getTableBorderColor($table['status']); ?>; 
                            border-radius: 12px; padding: 1.5rem; transition: all 0.3s ease;">
                    
                    <!-- Table Header -->
                    <div style="display: flex; justify-content: between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <h3 style="font-weight: 800; margin-bottom: 0.25rem; font-size: 1.3rem;">
                                <?php echo $table['name']; ?>
                            </h3>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">
                                <?php echo $table['floor_name']; ?> • Capacity: <?php echo $table['capacity']; ?> players
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                        background: <?php echo getStatusColor($table['status']); ?>;
                                        color: <?php echo getStatusTextColor($table['status']); ?>;">
                                <?php echo ucfirst($table['status']); ?>
                            </span>
                            <div style="margin-top: 0.5rem; color: var(--accent); font-weight: 700;">
                                Rp <?php echo number_format($table['hourly_rate'], 0, ',', '.'); ?>/hour
                            </div>
                        </div>
                    </div>

                    <!-- Current Booking Info -->
                    <?php if (in_array($table['status'], ['occupied', 'reserved'])): ?>
                        <?php
                        $currentBooking = getCurrentBooking($table['id']);
                        if ($currentBooking): ?>
                            <div style="background: rgba(255, 255, 255, 0.05); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                                <div style="font-weight: 600; margin-bottom: 0.5rem;">Current Booking</div>
                                <div style="display: grid; gap: 0.25rem; font-size: 0.9rem;">
                                    <div style="display: flex; justify-content: between;">
                                        <span style="color: var(--text-muted);">Customer:</span>
                                        <span style="font-weight: 600;"><?php echo $currentBooking['customer_name']; ?></span>
                                    </div>
                                    <div style="display: flex; justify-content: between;">
                                        <span style="color: var(--text-muted);">Started:</span>
                                        <span><?php echo date('g:i A', strtotime($currentBooking['start_time'])); ?></span>
                                    </div>
                                    <div style="display: flex; justify-content: between;">
                                        <span style="color: var(--text-muted);">Duration:</span>
                                        <span><?php echo $currentBooking['duration_hours']; ?> hours</span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Status Actions -->
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <?php if ($table['status'] === 'available'): ?>
                            <button onclick="updateTableStatus(<?php echo $table['id']; ?>, 'occupied')" 
                                    class="btn btn-primary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                🎱 Mark Occupied
                            </button>
                            <button onclick="updateTableStatus(<?php echo $table['id']; ?>, 'maintenance')" 
                                    class="btn btn-outline" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                🛠️ Maintenance
                            </button>
                        <?php elseif ($table['status'] === 'occupied'): ?>
                            <button onclick="updateTableStatus(<?php echo $table['id']; ?>, 'available')" 
                                    class="btn btn-primary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                ✅ Available
                            </button>
                            <button onclick="updateTableStatus(<?php echo $table['id']; ?>, 'maintenance')" 
                                    class="btn btn-outline" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                🛠️ Maintenance
                            </button>
                        <?php elseif ($table['status'] === 'reserved'): ?>
                            <button onclick="updateTableStatus(<?php echo $table['id']; ?>, 'occupied')" 
                                    class="btn btn-primary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                🎱 Start Session
                            </button>
                            <button onclick="updateTableStatus(<?php echo $table['id']; ?>, 'available')" 
                                    class="btn btn-outline" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                ❌ Cancel
                            </button>
                        <?php elseif ($table['status'] === 'maintenance'): ?>
                            <button onclick="updateTableStatus(<?php echo $table['id']; ?>, 'available')" 
                                    class="btn btn-primary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                ✅ Ready
                            </button>
                        <?php endif; ?>
                        
                        <!-- Quick Booking -->
                        <button onclick="quickBooking(<?php echo $table['id']; ?>)" 
                                class="btn btn-outline" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                            📅 Quick Book
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function refreshTableStatus() {
    location.reload();
}

function updateTableStatus(tableId, newStatus) {
    const statusText = {
        'available': 'Available',
        'occupied': 'Occupied', 
        'reserved': 'Reserved',
        'maintenance': 'Maintenance'
    };
    
    if (!confirm(`Change table status to "${statusText[newStatus]}"?`)) {
        return;
    }
    
    const formData = new FormData();
    formData.append('table_id', tableId);
    formData.append('status', newStatus);
    
    fetch('<?php echo Router::url('admin/update-table-status'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Table status updated successfully!');
            location.reload();
        } else {
            alert('❌ Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to update table status');
    });
}

function quickBooking(tableId) {
    // Redirect ke booking page dengan table pre-selected
    window.location.href = '<?php echo Router::url('booking'); ?>?table_id=' + tableId;
}

// Auto-refresh every 30 seconds
setInterval(refreshTableStatus, 30000);
</script>

<?php
// Helper functions
function getTableBorderColor($status) {
    switch ($status) {
        case 'available': return '#27ae60';
        case 'occupied': return '#e74c3c';
        case 'reserved': return '#f39c12';
        case 'maintenance': return '#95a5a6';
        default: return 'var(--border-color)';
    }
}

function getStatusColor($status) {
    switch ($status) {
        case 'available': return 'rgba(39, 174, 96, 0.2)';
        case 'occupied': return 'rgba(231, 76, 60, 0.2)';
        case 'reserved': return 'rgba(243, 156, 18, 0.2)';
        case 'maintenance': return 'rgba(149, 165, 166, 0.2)';
        default: return 'rgba(149, 165, 166, 0.2)';
    }
}

function getStatusTextColor($status) {
    switch ($status) {
        case 'available': return '#27ae60';
        case 'occupied': return '#e74c3c';
        case 'reserved': return '#f39c12';
        case 'maintenance': return '#95a5a6';
        default: return '#95a5a6';
    }
}

function getCurrentBooking($tableId) {
    // Temporary function - nanti bisa diintegrasikan dengan model
    // Untuk sekarang return false atau data dummy
    return false;
}
?>