    <div style="padding: 2rem 0;">
        <!-- Back Button -->
        <div style="margin-bottom: 2rem;">
            <a href="<?= Router::url('tournaments/view/' . $data['tournament']['id']) ?>" 
               style="display: inline-flex; align-items: center; gap: 0.5rem; 
                      color: var(--text-muted); font-weight: 600; text-decoration: none;">
                ← Back to Tournament
            </a>
        </div>

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
                🚀 Register for Tournament
            </h1>
            <p style="color: var(--text-muted); font-weight: 500;">
                Complete your registration for <?= $data['tournament']['name'] ?>
            </p>
        </div>

        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['tournament_success'])): ?>
            <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid rgba(46, 204, 113, 0.3); 
                        padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <div style="color: #2ecc71; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    ✅ <?= $_SESSION['tournament_success'] ?>
                </div>
            </div>
            <?php unset($_SESSION['tournament_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['tournament_error'])): ?>
            <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid rgba(231, 76, 60, 0.3); 
                        padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <div style="color: #e74c3c; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    ❌ <?= $_SESSION['tournament_error'] ?>
                </div>
            </div>
            <?php unset($_SESSION['tournament_error']); ?>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; max-width: 1200px; margin: 0 auto;">
            <!-- Left Column - Registration Form -->
            <div class="card">
                <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📝</span> Registration Form
                </h2>

                <form method="POST" action="<?= Router::url('tournaments/register') ?>">
                    <input type="hidden" name="tournament_id" value="<?= $data['tournament']['id'] ?>">
                    
                    <!-- Team Information -->
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-weight: 700; margin-bottom: 1rem; color: var(--accent);">
                            Team Information
                        </h3>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Team Name *
                            </label>
                            <input type="text" name="team_name" required 
                                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                          border-radius: 8px; font-size: 1rem;"
                                   placeholder="Enter your team name"
                                   value="<?= $_POST['team_name'] ?? '' ?>">
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                                Choose a creative name for your team
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Number of Players *
                            </label>
                            <select name="player_count" required 
                                    style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                           border-radius: 8px; font-size: 1rem;">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= ($_POST['player_count'] ?? 1) == $i ? 'selected' : '' ?>>
                                        <?= $i ?> player<?= $i > 1 ? 's' : '' ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                                Select how many players in your team
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-weight: 700; margin-bottom: 1rem; color: var(--accent);">
                            Payment Summary
                        </h3>
                        
                        <div style="background: rgba(255, 255, 255, 0.05); padding: 1rem; border-radius: 8px;">
                            <div style="display: flex; justify-content: between; margin-bottom: 0.5rem;">
                                <span>Entry Fee (per player):</span>
                                <span>Rp <?= number_format($data['tournament']['entry_fee'], 0, ',', '.') ?></span>
                            </div>
                            <div style="display: flex; justify-content: between; margin-bottom: 0.5rem;">
                                <span>Number of Players:</span>
                                <span id="player-count-display">1</span>
                            </div>
                            <div style="border-top: 1px solid var(--border-color); padding-top: 0.5rem; 
                                      display: flex; justify-content: between; font-weight: 700; font-size: 1.1rem;">
                                <span>Total Amount:</span>
                                <span id="total-amount">Rp <?= number_format($data['tournament']['entry_fee'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                        
                        <div style="margin-top: 1rem; padding: 1rem; background: rgba(52, 152, 219, 0.1); 
                                    border-radius: 8px; border-left: 4px solid #3498db;">
                            <div style="font-weight: 600; margin-bottom: 0.5rem;">💡 Payment Instructions</div>
                            <div style="font-size: 0.9rem;">
                                Payment can be made at the venue before the tournament starts. 
                                Please bring exact amount for smooth registration.
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div style="margin-bottom: 2rem;">
                        <div style="display: flex; align-items: start; gap: 0.5rem; margin-bottom: 1rem;">
                            <input type="checkbox" id="terms" name="terms" required 
                                   style="margin-top: 0.25rem;">
                            <label for="terms" style="font-size: 0.9rem;">
                                I agree to the <a href="#" style="color: var(--accent);">tournament rules and terms</a>. 
                                I understand that the entry fee is non-refundable.
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            style="width: 100%; padding: 1rem; background: var(--accent); color: white; 
                                   border: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; 
                                   cursor: pointer; transition: background 0.3s ease;">
                        🎯 Complete Registration
                    </button>
                </form>
            </div>

            <!-- Right Column - Tournament Summary -->
            <div>
                <!-- Tournament Card -->
                <div class="card" style="position: sticky; top: 2rem;">
                    <h2 style="font-weight: 800; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span>🏆</span> Tournament Summary
                    </h2>
                    
                    <div style="text-align: center; margin-bottom: 1.5rem;">
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">🎱</div>
                        <h3 style="font-weight: 800; font-size: 1.3rem; margin-bottom: 0.5rem;">
                            <?= htmlspecialchars($data['tournament']['name']) ?>
                        </h3>
                        <div style="color: var(--text-muted);">
                            <?= ucfirst($data['tournament']['type']) ?> Tournament
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: between;">
                            <span style="color: var(--text-muted);">Prize Pool:</span>
                            <span style="font-weight: 700;">
                                Rp <?= number_format($data['tournament']['prize_pool'], 0, ',', '.') ?>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: between;">
                            <span style="color: var(--text-muted);">Start Date:</span>
                            <span style="font-weight: 700;">
                                <?= date('M j, Y', strtotime($data['tournament']['start_date'])) ?>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: between;">
                            <span style="color: var(--text-muted);">Register By:</span>
                            <span style="font-weight: 700;">
                                <?= date('M j, Y', strtotime($data['tournament']['registration_deadline'])) ?>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: between;">
                            <span style="color: var(--text-muted);">Available Spots:</span>
                            <span style="font-weight: 700;">
                                <?= $data['tournament']['max_participants'] - $data['current_participants'] ?> left
                            </span>
                        </div>
                    </div>

                    <!-- Rules Preview -->
                    <?php if (!empty($data['tournament']['rules'])): ?>
                    <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem;">📜 Tournament Rules</h4>
                        <div style="font-size: 0.9rem; color: var(--text-muted); max-height: 150px; overflow-y: auto;">
                            <?= nl2br(htmlspecialchars(substr($data['tournament']['rules'], 0, 200))) ?>...
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Dynamic Calculation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const playerCountSelect = document.querySelector('select[name="player_count"]');
            const playerCountDisplay = document.getElementById('player-count-display');
            const totalAmountDisplay = document.getElementById('total-amount');
            const entryFee = <?= $data['tournament']['entry_fee'] ?>;
            
            function updatePaymentSummary() {
                const playerCount = parseInt(playerCountSelect.value);
                playerCountDisplay.textContent = playerCount;
                
                const totalAmount = entryFee * playerCount;
                totalAmountDisplay.textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');
            }
            
            playerCountSelect.addEventListener('change', updatePaymentSummary);
            updatePaymentSummary(); // Initial calculation
        });
    </script>