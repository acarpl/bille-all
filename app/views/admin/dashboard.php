<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
                Admin <span class="text-accent">Dashboard</span>
            </h1>
            <p style="color: var(--text-muted); font-weight: 500;">
                Manage your billiard center operations & tournaments
            </p>
        </div>
        <div style="color: var(--text-muted); font-weight: 600;">
            <?php echo date('l, F j, Y'); ?>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <!-- Total Bookings -->
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 1rem;">📊</div>
            <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Total Bookings</h3>
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--accent);">
                <?php echo $stats['total_bookings']; ?>
            </div>
            <p style="color: var(--text-muted); font-size: 0.9rem;">All time</p>
        </div>

        <!-- Active Bookings -->
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 1rem;">🎯</div>
            <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Active Now</h3>
            <div style="font-size: 2.5rem; font-weight: 800; color: #27ae60;">
                <?php echo $stats['active_bookings']; ?>
            </div>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Currently playing</p>
        </div>

        <!-- Available Tables -->
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 1rem;">🎱</div>
            <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Available Tables</h3>
            <div style="font-size: 2.5rem; font-weight: 800; color: #27ae60;">
                <?php echo $stats['available_tables']; ?>
            </div>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Ready to book</p>
        </div>

        <!-- Total Revenue -->
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 1rem;">💰</div>
            <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Total Revenue</h3>
            <div style="font-size: 2rem; font-weight: 800; color: var(--accent);">
                Rp <?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?>
            </div>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Lifetime</p>
        </div>
    </div>

    <!-- Tournament Statistics -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Total Tournaments -->
        <div class="card" style="text-align: center;">
            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🏆</div>
            <h3 style="font-weight: 700; margin-bottom: 0.25rem; font-size: 0.9rem;">Total Tournaments</h3>
            <div style="font-size: 2rem; font-weight: 800; color: var(--accent);">
                <?php echo $stats['total_tournaments'] ?? 0; ?>
            </div>
        </div>

        <!-- Active Tournaments -->
        <div class="card" style="text-align: center;">
            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🔥</div>
            <h3 style="font-weight: 700; margin-bottom: 0.25rem; font-size: 0.9rem;">Active Tournaments</h3>
            <div style="font-size: 2rem; font-weight: 800; color: #e74c3c;">
                <?php echo $stats['active_tournaments'] ?? 0; ?>
            </div>
        </div>

        <!-- Tournament Registrations -->
        <div class="card" style="text-align: center;">
            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">👥</div>
            <h3 style="font-weight: 700; margin-bottom: 0.25rem; font-size: 0.9rem;">Registrations</h3>
            <div style="font-size: 2rem; font-weight: 800; color: #3498db;">
                <?php echo $stats['tournament_registrations'] ?? 0; ?>
            </div>
        </div>

        <!-- Tournament Revenue -->
        <div class="card" style="text-align: center;">
            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">💎</div>
            <h3 style="font-weight: 700; margin-bottom: 0.25rem; font-size: 0.9rem;">Tournament Revenue</h3>
            <div style="font-size: 1.5rem; font-weight: 800; color: #27ae60;">
                Rp <?php echo number_format($stats['tournament_revenue'] ?? 0, 0, ',', '.'); ?>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Recent Bookings & Tournaments -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- Recent Bookings -->
            <div class="card">
                <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 style="font-weight: 800;">Recent Bookings</h2>
                    <a href="<?php echo Router::url('admin/bookings'); ?>" 
                       style="color: var(--accent); text-decoration: none; font-weight: 600;">
                        View All →
                    </a>
                </div>

                <?php if (!empty($recentBookings)): ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php foreach ($recentBookings as $booking): ?>
                            <div style="display: flex; justify-content: between; align-items: center; 
                                        padding: 1rem; background: rgba(255, 255, 255, 0.05); 
                                        border-radius: 8px;">
                                <div>
                                    <div style="font-weight: 700; margin-bottom: 0.25rem;">
                                        <?php echo htmlspecialchars($booking['customer_name']); ?>
                                    </div>
                                    <div style="color: var(--text-muted); font-size: 0.9rem;">
                                        Table <?php echo $booking['table_number']; ?> • 
                                        <?php echo date('M j, g:i A', strtotime($booking['start_time'])); ?>
                                    </div>
                                </div>
                                <div>
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 20px; 
                                                font-size: 0.8rem; font-weight: 600;
                                                background: <?php echo getStatusColor($booking['status']); ?>;">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">😴</div>
                        <p>No recent bookings</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent Tournament Registrations -->
            <div class="card">
                <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 style="font-weight: 800;">Recent Tournament Registrations</h2>
                    <a href="<?php echo Router::url('admin/tournaments'); ?>" 
                       style="color: var(--accent); text-decoration: none; font-weight: 600;">
                        Manage →
                    </a>
                </div>

                <?php if (!empty($recentTournamentRegistrations)): ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php foreach ($recentTournamentRegistrations as $registration): ?>
                            <div style="display: flex; justify-content: between; align-items: center; 
                                        padding: 1rem; background: rgba(255, 255, 255, 0.05); 
                                        border-radius: 8px;">
                                <div>
                                    <div style="font-weight: 700; margin-bottom: 0.25rem;">
                                        <?php echo htmlspecialchars($registration['team_name']); ?>
                                    </div>
                                    <div style="color: var(--text-muted); font-size: 0.9rem;">
                                        <?php echo htmlspecialchars($registration['tournament_name']); ?> • 
                                        <?php echo $registration['player_count']; ?> player<?php echo $registration['player_count'] > 1 ? 's' : ''; ?>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">
                                        <?php echo date('M j', strtotime($registration['created_at'])); ?>
                                    </div>
                                    <div style="font-size: 0.8rem; font-weight: 600; color: #27ae60;">
                                        Registered
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 1rem; color: var(--text-muted);">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">🏆</div>
                        <p>No recent tournament registrations</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- Table Status -->
            <div class="card">
                <h2 style="font-weight: 800; margin-bottom: 1.5rem;">Table Status</h2>
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php 
                    $statusCount = [
                        'available' => 0,
                        'occupied' => 0,
                        'reserved' => 0,
                        'maintenance' => 0
                    ];
                    
                    foreach ($tableStatus as $table) {
                        $statusCount[$table['status']]++;
                    }
                    ?>
                    
                    <div style="display: flex; justify-content: between; align-items: center;">
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="display: inline-block; width: 12px; height: 12px; 
                                        border-radius: 50%; background: #27ae60;"></span>
                            Available
                        </span>
                        <span style="font-weight: 700;"><?php echo $statusCount['available']; ?></span>
                    </div>
                    
                    <div style="display: flex; justify-content: between; align-items: center;">
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="display: inline-block; width: 12px; height: 12px; 
                                        border-radius: 50%; background: var(--accent);"></span>
                            Occupied
                        </span>
                        <span style="font-weight: 700;"><?php echo $statusCount['occupied']; ?></span>
                    </div>
                    
                    <div style="display: flex; justify-content: between; align-items: center;">
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="display: inline-block; width: 12px; height: 12px; 
                                        border-radius: 50%; background: #f39c12;"></span>
                            Reserved
                        </span>
                        <span style="font-weight: 700;"><?php echo $statusCount['reserved']; ?></span>
                    </div>
                    
                    <div style="display: flex; justify-content: between; align-items: center;">
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="display: inline-block; width: 12px; height: 12px; 
                                        border-radius: 50%; background: #95a5a6;"></span>
                            Maintenance
                        </span>
                        <span style="font-weight: 700;"><?php echo $statusCount['maintenance']; ?></span>
                    </div>
                </div>
                
                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <a href="<?php echo Router::url('admin/tables'); ?>" 
                       class="btn btn-outline" 
                       style="width: 100%; text-align: center; font-weight: 600;">
                        🎱 Manage Tables
                    </a>
                </div>
            </div>

            <!-- Tambah di dashboard, setelah Recent Tournament Registrations -->
<div class="card">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-weight: 800;">Recent Product Orders</h2>
        <a href="<?php echo Router::url('admin/products'); ?>" 
           style="color: var(--accent); text-decoration: none; font-weight: 600;">
            Manage Products →
        </a>
    </div>

    <?php if (!empty($recentProductOrders)): ?>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <?php foreach ($recentProductOrders as $order): ?>
                <div style="display: flex; justify-content: between; align-items: center; 
                            padding: 1rem; background: rgba(255, 255, 255, 0.05); 
                            border-radius: 8px;">
                    <div>
                        <div style="font-weight: 700; margin-bottom: 0.25rem;">
                            <?php echo htmlspecialchars($order['customer_name']); ?>
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">
                            <?php echo $order['item_count']; ?> items • 
                            Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.8rem; color: var(--text-muted);">
                            <?php echo date('M j', strtotime($order['created_at'])); ?>
                        </div>
                        <span style="padding: 0.25rem 0.75rem; border-radius: 20px; 
                                    font-size: 0.8rem; font-weight: 600;
                                    background: <?php echo getOrderStatusColor($order['status']); ?>;">
                            <?php echo ucfirst($order['status']); ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 1rem; color: var(--text-muted);">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🛒</div>
            <p>No recent product orders</p>
        </div>
    <?php endif; ?>
</div>

<?php
// Tambah helper function
function getOrderStatusColor($status) {
    switch ($status) {
        case 'pending': return 'rgba(243, 156, 18, 0.2)';
        case 'preparing': return 'rgba(52, 152, 219, 0.2)';
        case 'ready': return 'rgba(46, 204, 113, 0.2)';
        case 'served': return 'rgba(149, 165, 166, 0.2)';
        case 'cancelled': return 'rgba(231, 76, 60, 0.2)';
        default: return 'rgba(149, 165, 166, 0.2)';
    }
}
?>

            <!-- Upcoming Tournaments -->
            <div class="card">
                <h2 style="font-weight: 800; margin-bottom: 1.5rem;">Upcoming Tournaments</h2>
                
                <?php if (!empty($upcomingTournaments)): ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php foreach ($upcomingTournaments as $tournament): ?>
                            <div style="padding: 1rem; background: rgba(52, 152, 219, 0.1); 
                                        border-radius: 8px; border-left: 4px solid #3498db;">
                                <div style="font-weight: 700; margin-bottom: 0.25rem; font-size: 0.9rem;">
                                    <?php echo htmlspecialchars($tournament['name']); ?>
                                </div>
                                <div style="color: var(--text-muted); font-size: 0.8rem;">
                                    <?php echo date('M j, g:i A', strtotime($tournament['start_date'])); ?>
                                </div>
                                <div style="font-size: 0.8rem; font-weight: 600; color: #3498db; margin-top: 0.25rem;">
                                    <?php echo $tournament['registered_count'] ?? 0; ?>/<?php echo $tournament['max_participants']; ?> registered
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 1rem; color: var(--text-muted);">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">📅</div>
                        <p>No upcoming tournaments</p>
                    </div>
                <?php endif; ?>
                
                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <a href="<?php echo Router::url('admin/tournaments'); ?>" 
                       class="btn btn-outline" 
                       style="width: 100%; text-align: center; font-weight: 600;">
                        🏆 Manage Tournaments
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card" style="margin-top: 2rem;">
        <h2 style="font-weight: 800; margin-bottom: 1.5rem;">Quick Actions</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <!-- Booking Management -->
            <a href="<?php echo Router::url('admin/bookings'); ?>" 
               style="display: flex; align-items: center; gap: 1rem; padding: 1rem; 
                      background: rgba(255, 255, 255, 0.05); border-radius: 8px; 
                      text-decoration: none; color: var(--text-light); transition: all 0.3s ease;">
                <div style="font-size: 1.5rem;">📋</div>
                <div>
                    <div style="font-weight: 700;">Manage Bookings</div>
                    <div style="color: var(--text-muted); font-size: 0.9rem;">View all reservations</div>
                </div>
            </a>
            
            <!-- Table Management -->
            <a href="<?php echo Router::url('admin/tables'); ?>" 
               style="display: flex; align-items: center; gap: 1rem; padding: 1rem; 
                      background: rgba(255, 255, 255, 0.05); border-radius: 8px; 
                      text-decoration: none; color: var(--text-light); transition: all 0.3s ease;">
                <div style="font-size: 1.5rem;">🎱</div>
                <div>
                    <div style="font-weight: 700;">Table Management</div>
                    <div style="color: var(--text-muted); font-size: 0.9rem;">Update table status</div>
                </div>
            </a>
            
            <!-- Tournament Management -->
            <a href="<?php echo Router::url('admin/tournaments'); ?>" 
               style="display: flex; align-items: center; gap: 1rem; padding: 1rem; 
                      background: rgba(255, 255, 255, 0.05); border-radius: 8px; 
                      text-decoration: none; color: var(--text-light); transition: all 0.3s ease;">
                <div style="font-size: 1.5rem;">🏆</div>
                <div>
                    <div style="font-weight: 700;">Tournaments</div>
                    <div style="color: var(--text-muted); font-size: 0.9rem;">Manage events</div>
                </div>
            </a>
            
            <!-- Create Tournament -->
            <a href="<?php echo Router::url('admin/tournaments/create'); ?>" 
               style="display: flex; align-items: center; gap: 1rem; padding: 1rem; 
                      background: rgba(255, 255, 255, 0.05); border-radius: 8px; 
                      text-decoration: none; color: var(--text-light); transition: all 0.3s ease;">
                <div style="font-size: 1.5rem;">➕</div>
                <div>
                    <div style="font-weight: 700;">New Tournament</div>
                    <div style="color: var(--text-muted); font-size: 0.9rem;">Create event</div>
                </div>
            </a>

            <a href="<?php echo Router::url('admin/tournaments/payments'); ?>" 
               style="display: flex; align-items: center; gap: 1rem; padding: 1rem; 
                      background: rgba(255, 255, 255, 0.05); border-radius: 8px; 
                      text-decoration: none; color: var(--text-light); transition: all 0.3s ease;">
                <div style="font-size: 1.5rem;">📋</div>
                <div>
                    <div style="font-weight: 700;">Manage and verify tournament entry fee payments</div>
                    <div style="color: var(--text-muted); font-size: 0.9rem;">Manage Registration</div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php
// Helper function untuk status color
function getStatusColor($status) {
    switch ($status) {
        case 'confirmed': return 'rgba(52, 152, 219, 0.2)';
        case 'active': return 'rgba(46, 204, 113, 0.2)';
        case 'completed': return 'rgba(149, 165, 166, 0.2)';
        case 'cancelled': return 'rgba(231, 76, 60, 0.2)';
        default: return 'rgba(149, 165, 166, 0.2)';
    }
}
?>