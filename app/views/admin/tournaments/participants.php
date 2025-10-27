<div style="padding: 2rem 0;">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <a href="<?= Router::url('admin/tournaments') ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; 
                 color: var(--text-muted); font-weight: 600; text-decoration: none; margin-bottom: 1rem;">
            ← Kembali ke Daftar Turnamen
        </a>
        <div style="display: flex; justify-content: between; align-items: start;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                    Mengelola Peserta
                </h1>
                <p style="color: var(--text-muted);">
                    <?= htmlspecialchars($tournament['name']) ?>
                </p>
            </div>
            <div style="text-align: right;">
                <div style="padding: 0.5rem 1rem; border-radius: 8px; background: var(--bg-secondary); 
                            font-weight: 700; margin-bottom: 0.5rem;">
                    <?= count($participants) ?>/<?= $tournament['max_participants'] ?> Terdaftar
                </div>
                <div style="font-size: 0.9rem; color: var(--text-muted);">
                    <?= $tournament['status'] === 'upcoming' ? 'Mulai: ' . date('M j, Y', strtotime($tournament['start_date'])) : 
                       ucfirst($tournament['status']) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tournament Info Card -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
            <div>
                <div style="font-weight: 600; color: var(--text-muted); margin-bottom: 0.25rem;">Tipe Turnamen</div>
                <div style="font-weight: 700;"><?= ucfirst($tournament['type']) ?></div>
            </div>
            <div>
                <div style="font-weight: 600; color: var(--text-muted); margin-bottom: 0.25rem;">Biaya Pendaftaran</div>
                <div style="font-weight: 700; color: var(--accent);">
                    Rp <?= number_format($tournament['entry_fee'], 0, ',', '.') ?>
                </div>
            </div>
            <div>
                <div style="font-weight: 600; color: var(--text-muted); margin-bottom: 0.25rem;">Total Hadiah</div>
                <div style="font-weight: 700;">
                    Rp <?= number_format($tournament['prize_pool'], 0, ',', '.') ?>
                </div>
            </div>
            <div>
                <div style="font-weight: 600; color: var(--text-muted); margin-bottom: 0.25rem;">Batas Waktu Pendaftaran</div>
                <div style="font-weight: 700;">
                    <?= date('M j, Y g:i A', strtotime($tournament['registration_deadline'])) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants List -->
    <div class="card">
        <h2 style="font-weight: 800; margin-bottom: 1.5rem;">Daftar Peserta yang Sudak Terdaftar</h2>

        <?php if (!empty($participants)): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color)">
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">#</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Tim/Pemain</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Kontak</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Pemain</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Tanggal Daftar</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Status</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 700;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participants as $index => $participant): ?>
                        <tr style="border-bottom: 1px solid var(--border-color)">
                            <td style="padding: 1rem; font-weight: 700;"><?= $index + 1 ?></td>
                            <td style="padding: 1rem;">
                                <div style="font-weight: 700;"><?= htmlspecialchars($participant['team_name']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">
                                    @<?= htmlspecialchars($participant['username'] ?? 'N/A') ?>
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                <div style="font-size: 0.9rem;"><?= htmlspecialchars($participant['email'] ?? 'N/A') ?></div>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                      background: rgba(52, 152, 219, 0.2); color: #3498db;">
                                    <?= $participant['player_count'] ?> player<?= $participant['player_count'] > 1 ? 's' : '' ?>
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                <?= date('M j, Y', strtotime($participant['created_at'])) ?>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;
                                      background: rgba(46, 204, 113, 0.2); color: #27ae60;">
                                    Terdaftar
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                <div style="display: flex; gap: 0.5rem;">
                                    <button class="btn btn-sm btn-primary">
                                        Hubungi
                                    </button>
                                    <form method="POST" action="#" 
                                        onsubmit="return confirm('Hapus peserta ini?')" style="display: inline;">
                                        <button type="submit" class="btn btn-sm" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Export Options -->
            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; margin-top: 1.5rem;">
                <h3 style="font-weight: 700; margin-bottom: 1rem;">Ekspor Peserta</h3>
                <div style="display: flex; gap: 1rem;">
                    <button class="btn" style="background: var(--bg-secondary)">
                        Ekspor ke CSV
                    </button>
                    <button class="btn" style="background: var(--bg-secondary)">
                        Kirim Email ke Semua Peserta
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem; color: var(--text-muted)">
                <div style="font-size: 4rem; margin-bottom: 1rem;">😴</div>
                <h3 style="font-weight: 700; margin-bottom: 0.5rem;">Belum Ada Peserta</h3>
                <p>Belum ada peserta yang terdaftar untuk turnamen ini.</p>
            </div>
        <?php endif; ?>
    </div>
