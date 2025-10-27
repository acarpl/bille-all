<!-- app/views/billing/live_tables.php -->
<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
                Live <span style="color: var(--accent);">Table Status</span>
            </h1>
            <p style="color: var(--text-muted); font-weight: 500;">
                Real-time view of all occupied tables and active billing sessions
            </p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <button onclick="refreshTableStatus()" class="btn btn-outline">
                🔄 Refresh
            </button>
            <a href="<?php echo BASE_URL; ?>/booking" class="btn btn-primary">
                🎱 Book Table
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎱</div>
            <div style="font-size: 1.5rem; font-weight: 700;"><?php echo $data['tableStats']['total_tables']; ?></div>
            <div style="color: var(--text-muted);">Total Tables</div>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem; color: #2ecc71;">✅</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #2ecc71;"><?php echo $data['tableStats']['available_tables']; ?></div>
            <div style="color: var(--text-muted);">Available</div>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem; color: #e74c3c;">🔥</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #e74c3c;"><?php echo count($data['activeSessions']); ?></div>
            <div style="color: var(--text-muted);">Active Sessions</div>
        </div>
        
        <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem; color: #f39c12;">⏱️</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #f39c12;">
                <?php 
                $totalMinutes = array_sum(array_column($data['activeSessions'], 'active_minutes'));
                echo floor($totalMinutes / 60) . 'h ' . ($totalMinutes % 60) . 'm';
                ?>
            </div>
            <div style="color: var(--text-muted);">Total Play Time</div>
        </div>
    </div>

    <!-- Active Billing Sessions -->
    <div class="card">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
            <h2 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #e74c3c;">🔥</span>
                Currently Occupied Tables (<?php echo count($data['activeSessions']); ?>)
            </h2>
        </div>
        
        <?php if (!empty($data['activeSessions'])): ?>
            <div style="padding: 1.5rem;">
                <div style="display: grid; gap: 1.5rem;">
                    <?php 
                    $currentFloor = null;
                    foreach ($data['activeSessions'] as $session): 
                        if ($currentFloor !== $session['floor_name']):
                            $currentFloor = $session['floor_name'];
                    ?>
                        <div style="margin-top: 1rem;">
                            <h3 style="margin: 0 0 1rem 0; padding: 0.5rem 1rem; background: var(--card-bg); 
                                      border-radius: 8px; font-size: 1.1rem; color: var(--text-muted);">
                                🏠 <?php echo htmlspecialchars($session['floor_name']); ?> Floor
                            </h3>
                        </div>
                    <?php endif; ?>
                    
                    <div style="display: grid; grid-template-columns: 1fr 2fr 1fr; gap: 1.5rem; align-items: center; 
                                padding: 1.5rem; background: #fff3e0; border-radius: 12px; border-left: 4px solid #ff9800;">
                        <!-- Table Info -->
                        <div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 60px; height: 60px; background: #ff9800; border-radius: 12px; 
                                            display: flex; align-items: center; justify-content: center; font-size: 1.5rem; 
                                            font-weight: 700; color: white;">
                                    <?php echo $session['table_number']; ?>
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 1.1rem;">
                                        <?php echo htmlspecialchars($session['table_name']); ?>
                                    </div>
                                    <div style="color: var(--text-muted); font-size: 0.9rem;">
                                        Floor <?php echo htmlspecialchars($session['floor_name']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Session Info -->
                        <div>
                            <div style="margin-bottom: 0.5rem;">
                                <span style="font-weight: 600;">Customer:</span>
                                <span style="color: var(--text-color);"><?php echo htmlspecialchars($session['customer_name']); ?></span>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.9rem;">
                                <div>
                                    <span style="color: var(--text-muted);">Started:</span>
                                    <div style="font-weight: 600;">
                                        <?php echo date('H:i', strtotime($session['start_time'])); ?>
                                    </div>
                                </div>
                                <div>
                                    <span style="color: var(--text-muted);">Duration:</span>
                                    <div style="font-weight: 600;">
                                        <?php 
                                        $hours = floor($session['active_minutes'] / 60);
                                        $minutes = $session['active_minutes'] % 60;
                                        echo sprintf("%dh %02dm", $hours, $minutes);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Billing Info -->
                        <div style="text-align: right;">
                            <div style="margin-bottom: 0.5rem;">
                                <div style="font-size: 0.9rem; color: var(--text-muted);">Current Charge</div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #e74c3c;">
                                    Rp <?php echo number_format($session['estimated_charge'], 0, ',', '.'); ?>
                                </div>
                            </div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                <?php if ($session['is_paused']): ?>
                                    <span style="color: #f39c12;">⏸️ PAUSED</span>
                                <?php else: ?>
                                    <span style="color: #2ecc71;">▶️ ACTIVE</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🎱</div>
                <h3 style="font-weight: 700; margin-bottom: 0.5rem;">All Tables Available</h3>
                <p>No active billing sessions at the moment.</p>
                <a href="<?php echo BASE_URL; ?>/booking" class="btn btn-primary" style="margin-top: 1rem;">
                    Book a Table Now
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- All Tables Overview -->
    <div class="card" style="margin-top: 2rem;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
            <h2 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #3498db;">📊</span>
                All Tables Overview
            </h2>
        </div>
        <div style="padding: 1.5rem;">
            <?php if (!empty($data['allTables'])): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 1rem;">
                    <?php foreach ($data['allTables'] as $table): 
                        $isOccupied = false;
                        $sessionInfo = null;
                        
                        // Check if table is in active sessions
                        foreach ($data['activeSessions'] as $session) {
                            if ($session['table_id'] == $table['id']) {
                                $isOccupied = true;
                                $sessionInfo = $session;
                                break;
                            }
                        }
                    ?>
                        <div style="text-align: center; padding: 1rem; border-radius: 8px; 
                                    background: <?php echo $isOccupied ? '#fff3e0' : '#e8f5e8'; ?>; 
                                    border: 2px solid <?php echo $isOccupied ? '#ff9800' : '#4caf50'; ?>;
                                    position: relative;">
                            
                            <!-- Table Number -->
                            <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;
                                        color: <?php echo $isOccupied ? '#ff9800' : '#4caf50'; ?>;">
                                <?php echo $table['table_number']; ?>
                            </div>
                            
                            <!-- Table Name -->
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                                <?php echo htmlspecialchars($table['name']); ?>
                            </div>
                            
                            <!-- Status -->
                            <div style="font-size: 0.7rem; font-weight: 600; 
                                        color: <?php echo $isOccupied ? '#e74c3c' : '#2ecc71'; ?>;">
                                <?php echo $isOccupied ? '🔥 OCCUPIED' : '✅ AVAILABLE'; ?>
                            </div>
                            
                            <!-- Occupied Info -->
                            <?php if ($isOccupied && $sessionInfo): ?>
                                <div style="position: absolute; top: -5px; right: -5px; 
                                            background: #e74c3c; color: white; border-radius: 50%; 
                                            width: 20px; height: 20px; display: flex; align-items: center; 
                                            justify-content: center; font-size: 0.6rem; font-weight: 700;">
                                    ⏱️
                                </div>
                                <div style="margin-top: 0.5rem; font-size: 0.7rem; color: #e74c3c;">
                                    <?php 
                                    $hours = floor($sessionInfo['active_minutes'] / 60);
                                    $minutes = $sessionInfo['active_minutes'] % 60;
                                    echo sprintf("%dh %02dm", $hours, $minutes);
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                    <p>No tables configured in the system.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function refreshTableStatus() {
    const refreshBtn = event.target;
    const originalText = refreshBtn.innerHTML;
    
    // Show loading state
    refreshBtn.innerHTML = '⏳ Refreshing...';
    refreshBtn.disabled = true;
    
    // Simulate refresh (in real app, this would be an AJAX call)
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Auto-refresh every 2 minutes
setTimeout(() => {
    location.reload();
}, 120000);

// Real-time clock update
function updateClock() {
    const now = new Date();
    document.getElementById('current-time').textContent = 
        now.toLocaleTimeString('en-US', { hour12: false });
}

setInterval(updateClock, 1000);
updateClock(); // Initial call
</script>

<style>
.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: var(--accent);
    color: white;
}

.btn-outline {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-color);
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Responsive design */
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 2fr 1fr"] {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    div[style*="grid-template-columns: repeat(auto-fill, minmax(120px, 1fr))"] {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }
}
</style>