<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                🏆 Tournament Management
            </h1>
            <p style="color: var(--text-muted);">Manage all tournaments and participants</p>
        </div>
        <a href="<?= Router::url('admin/tournaments/create') ?>" class="btn btn-primary">
            + Create Tournament
        </a>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📊</div>
            <div style="font-size: 1.5rem; font-weight: 800;"><?= $stats['total_tournaments'] ?? 0 ?></div>
            <div style="color: var(--text-muted);">Total Tournaments</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔥</div>
            <div style="font-size: 1.5rem; font-weight: 800;"><?= $stats['active_tournaments'] ?? 0 ?></div>
            <div style="color: var(--text-muted);">Active</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">👥</div>
            <div style="font-size: 1.5rem; font-weight: 800;"><?= $stats['tournament_registrations'] ?? 0 ?></div>
            <div style="color: var(--text-muted);">Registrations</div>
        </div>
        <div class="card" style="text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">💰</div>
            <div style="font-size: 1.5rem; font-weight: 800;">Rp <?= number_format($stats['total_revenue'] ?? 0, 0, ',', '.') ?></div>
            <div style="color: var(--text-muted);">Tournament Revenue</div>
        </div>
    </div>

    <!-- Tournaments Table -->
    <div class="card">
        <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-weight: 800;">All Tournaments</h2>
            <div style="display: flex; gap: 0.5rem;">
                <select onchange="window.location.href = '<?= Router::url('admin/tournaments') ?>?status=' + this.value" 
                        style="padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>All Status</option>
                    <option value="upcoming" <?= $status === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>
        </div>

        <?php if (!empty($tournaments)): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color);">
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Tournament</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Type</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Participants</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Prize Pool</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Status</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Start Date</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tournaments as $tournament): ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 1rem;">
                                <div style="font-weight: 700;"><?= htmlspecialchars($tournament['name']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">
                                    Rp <?= number_format($tournament['entry_fee'], 0, ',', '.') ?> entry
                                </div>
                            </td>
                            <td style="padding: 1rem;"><?= ucfirst($tournament['type']) ?></td>
                            <td style="padding: 1rem;">
                                <?= $tournament['participants_count'] ?? 0 ?>/<?= $tournament['max_participants'] ?>
                            </td>
                            <td style="padding: 1rem; font-weight: 700;">
                                Rp <?= number_format($tournament['prize_pool'], 0, ',', '.') ?>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                      background: <?= $tournament['status'] === 'active' ? 'rgba(46, 204, 113, 0.2)' : 
                                                 ($tournament['status'] === 'upcoming' ? 'rgba(52, 152, 219, 0.2)' : 
                                                 'rgba(149, 165, 166, 0.2)') ?>; 
                                      color: <?= $tournament['status'] === 'active' ? '#27ae60' : 
                                             ($tournament['status'] === 'upcoming' ? '#3498db' : 
                                             '#95a5a6') ?>;">
                                    <?= ucfirst($tournament['status']) ?>
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                <?= date('M j, Y', strtotime($tournament['start_date'])) ?>
                            </td>
                            <td style="padding: 1rem;">
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="<?= Router::url('admin/tournaments/participants/' . $tournament['id']) ?>" 
                                       class="btn btn-sm" style="background: var(--bg-secondary);">
                                        👥
                                    </a>
                                    <a href="<?= Router::url('admin/tournaments/edit/' . $tournament['id']) ?>" 
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                    <form method="POST" action="<?= Router::url('admin/tournaments/delete/' . $tournament['id']) ?>" 
                                          style="display: inline;" onsubmit="return confirm('Delete this tournament?')">
                                        <button type="submit" class="btn btn-sm" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">😴</div>
                <h3 style="font-weight: 700; margin-bottom: 0.5rem;">No Tournaments Yet</h3>
                <p>Create your first tournament to get started.</p>
                <a href="<?= Router::url('admin/tournaments/create') ?>" class="btn btn-primary" style="margin-top: 1rem;">
                    Create Tournament
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>