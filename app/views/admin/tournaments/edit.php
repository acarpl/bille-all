<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <a href="<?= Router::url('admin/tournaments') ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; 
                 color: var(--text-muted); font-weight: 600; text-decoration: none; margin-bottom: 1rem;">
            ← Kembali ke Daftar Turnamen
        </a>
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
            Edit Turnamen
        </h1>
        <p style="color: var(--text-muted);">Ubah informasi turnamen</p>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['admin_success'])): ?>
        <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid rgba(46, 204, 113, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="color: #2ecc71; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <?php echo $_SESSION['admin_success'] ?>
            </div>
        </div>
        <?php unset($_SESSION['admin_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['admin_error'])): ?>
        <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid rgba(231, 76, 60, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="color: #e74c3c; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <?php echo $_SESSION['admin_error'] ?>
            </div>
        </div>
        <?php unset($_SESSION['admin_error']); ?>
    <?php endif; ?>

    <!-- Edit Tournament Form -->
    <div class="card">
        <form method="POST" action="<?= Router::url('admin/tournaments/edit/' . $tournament['id']) ?>">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <!-- Left Column -->
                <div>
                    <!-- Nama Turnamen -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Nama Turnamen *
                        </label>
                        <input type="text" name="name" value="<?= htmlspecialchars($tournament['name']) ?>" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                      border-radius: 8px; font-size: 1rem;">
                    </div>

                    <!-- Jenis Turnamen -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Jenis Turnamen *
                        </label>
                        <select name="type" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                       border-radius: 8px; font-size: 1rem;">
                            <option value="singles" <?= $tournament['type'] === 'singles' ? 'selected' : '' ?>>Singles</option>
                            <option value="doubles" <?= $tournament['type'] === 'doubles' ? 'selected' : '' ?>>Doubles</option>
                            <option value="team" <?= $tournament['type'] === 'team' ? 'selected' : '' ?>>Team</option>
                            <option value="open" <?= $tournament['type'] === 'open' ? 'selected' : '' ?>>Open</option>
                            <option value="amateur" <?= $tournament['type'] === 'amateur' ? 'selected' : '' ?>>Amateur</option>
                            <option value="pro" <?= $tournament['type'] === 'pro' ? 'selected' : '' ?>>Professional</option>
                        </select>
                    </div>

                    <!-- Biaya Masuk & Hadiah Turnamen -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Biaya Masuk (Rp)
                            </label>
                            <input type="number" name="entry_fee" value="<?= $tournament['entry_fee'] ?>" min="0"
                                style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                          border-radius: 8px; font-size: 1rem;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Hadiah Turnamen (Rp)
                            </label>
                            <input type="number" name="prize_pool" value="<?= $tournament['prize_pool'] ?>" min="0"
                                style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                          border-radius: 8px; font-size: 1rem;">
                        </div>
                    </div>

                    <!-- Maksimum Peserta -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Maksimum Peserta *
                        </label>
                        <input type="number" name="max_participants" value="<?= $tournament['max_participants'] ?>"
                            required min="2" max="128"
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                      border-radius: 8px; font-size: 1rem;">
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <!-- Status -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Status Turnamen *
                        </label>
                        <select name="status" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                       border-radius: 8px; font-size: 1rem;">
                            <option value="upcoming" <?= $tournament['status'] === 'upcoming' ? 'selected' : '' ?>>Akan Datang</option>
                            <option value="active" <?= $tournament['status'] === 'active' ? 'selected' : '' ?>>Aktif</option>
                            <option value="completed" <?= $tournament['status'] === 'completed' ? 'selected' : '' ?>>Selesai</option>
                            <option value="cancelled" <?= $tournament['status'] === 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Tanggal & Jam -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Tanggal & Jam Daftar Turnamen *
                        </label>
                        <input type="datetime-local" name="registration_deadline"
                            value="<?= date('Y-m-d\TH:i', strtotime($tournament['registration_deadline'])) ?>" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                      border-radius: 8px; font-size: 1rem;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Tanggal & Jam Mulai Turnamen *
                        </label>
                        <input type="datetime-local" name="start_date"
                            value="<?= date('Y-m-d\TH:i', strtotime($tournament['start_date'])) ?>" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                      border-radius: 8px; font-size: 1rem;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                            Tanggal & Jam Berakhir Turnamen
                        </label>
                        <input type="datetime-local" name="end_date"
                            value="<?= $tournament['end_date'] ? date('Y-m-d\TH:i', strtotime($tournament['end_date'])) : '' ?>"
                            style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                      border-radius: 8px; font-size: 1rem;">
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                    Deskripsi Turnamen
                </label>
                <textarea name="description" rows="3"
                    style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                 border-radius: 8px; font-size: 1rem; resize: vertical;"
                    placeholder="Deskripsikan turnamen..."><?= htmlspecialchars($tournament['description'] ?? '') ?></textarea>
            </div>

            <!-- Aturan -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                    Aturan dan Informasi Turnamen
                </label>
                <textarea name="rules" rows="6"
                    style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                 border-radius: 8px; font-size: 1rem; resize: vertical;"
                    placeholder="Masukkan aturan dan informasi turnamen...<?= htmlspecialchars($tournament['rules'] ?? '') ?></textarea>
            </div>

            <!-- Aksi Form -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <a href="<?= Router::url('admin/tournaments') ?>"
                    style="padding: 0.75rem 1.5rem; border: 1px solid var(--border-color); border-radius: 8px; 
                          text-decoration: none; color: var(--text-muted); font-weight: 600;">
                    Batal
                </a>
                <button type="submit"
                    style="padding: 0.75rem 2rem; background: var(--accent); color: white; 
                               border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer;">
                    Perbarui Turnamen
                </button>
            </div>
        </form>
    </div>