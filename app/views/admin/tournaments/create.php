<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <a href="<?= Router::url('admin/tournaments') ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; 
                 color: var(--text-muted); font-weight: 600; text-decoration: none; margin-bottom: 1rem;">
            ← Back to Tournaments
        </a>
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
            🏆 Create New Tournament
        </h1>
        <p style="color: var(--text-muted);">Create a new tournament event</p>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['admin_success'])): ?>
        <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid rgba(46, 204, 113, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="color: #2ecc71; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ✅ <?= $_SESSION['admin_success'] ?>
            </div>
        </div>
        <?php unset($_SESSION['admin_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['admin_error'])): ?>
        <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid rgba(231, 76, 60, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="color: #e74c3c; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ❌ <?= $_SESSION['admin_error'] ?>
            </div>
        </div>
        <?php unset($_SESSION['admin_error']); ?>
    <?php endif; ?>

    <!-- Create Tournament Form -->
    <div class="card">
        <form method="POST" action="<?= Router::url('admin/tournaments/create') ?>">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Left Column -->
        <div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                    Tournament Name *
                </label>
                <input type="text" name="name" required 
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                              border-radius: 8px; font-size: 1rem;"
                       placeholder="Enter tournament name">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                    Tournament Type *
                </label>
                <select name="type" required 
                        style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                               border-radius: 8px; font-size: 1rem;">
                    <option value="singles">Singles</option>
                    <option value="doubles">Doubles</option>
                    <option value="team">Team</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                        Entry Fee (Rp)
                    </label>
                    <input type="number" name="entry_fee" value="0" min="0" step="1000"
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                  border-radius: 8px; font-size: 1rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                        Prize Pool (Rp)
                    </label>
                    <input type="number" name="prize_pool" value="0" min="0" step="1000"
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                  border-radius: 8px; font-size: 1rem;">
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                    Maximum Participants *
                </label>
                <input type="number" name="max_participants" required min="2" max="128" value="16"
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                              border-radius: 8px; font-size: 1rem;">
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                    Registration Deadline *
                </label>
                <input type="datetime-local" name="registration_deadline" required
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                              border-radius: 8px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                    Start Date & Time *
                </label>
                <input type="datetime-local" name="start_date" required
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                              border-radius: 8px; font-size: 1rem;">
            </div>
        </div>
    </div>

    <!-- Rules -->
    <div style="margin-bottom: 2rem;">
        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
            Tournament Rules
        </label>
        <textarea name="rules" rows="6"
                  style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                         border-radius: 8px; font-size: 1rem; resize: vertical;"
                  placeholder="Enter tournament rules and information..."></textarea>
    </div>

    <!-- Form Actions -->
    <div style="display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
        <a href="<?= Router::url('admin/tournaments') ?>" 
           style="padding: 0.75rem 1.5rem; border: 1px solid var(--border-color); border-radius: 8px; 
                  text-decoration: none; color: var(--text-muted); font-weight: 600;">
            Cancel
        </a>
        <button type="submit" 
                style="padding: 0.75rem 2rem; background: var(--accent); color: white; 
                       border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer;">
            Create Tournament
        </button>
    </div>
</form>
    </div>
</div>