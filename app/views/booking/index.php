<div style="padding: 2rem 0;">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">
            Book Your <span class="text-accent">Table</span>
        </h1>
        <p style="color: var(--text-muted); font-size: 1.1rem; font-weight: 500;">
            Reserve your billiard table and get ready for an amazing game
        </p>
    </div>

    <?php if (isset($_SESSION['booking_error'])): ?>
        <div style="background: rgba(230, 57, 70, 0.1); border: 1px solid rgba(230, 57, 70, 0.3); 
                    padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="color: var(--accent); font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                ⚠️ <?php echo $_SESSION['booking_error']; unset($_SESSION['booking_error']); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Booking Form -->
    <div class="card">
        <form id="bookingForm" method="POST" action="<?php echo Router::url('booking/create'); ?>">

            <!-- HIDDEN FIELDS -->
            <input type="hidden" id="selected_table_id" name="table_id" value="">
            <input type="hidden" id="selected_package_id" name="package_id" value="">

            <!-- Step 1: Date & Time Selection -->
            <div style="margin-bottom: 2.5rem;">
                <h3 style="font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📅</span> When do you want to play?
                </h3>

                <!-- Responsive Grid -->
                <div class="datetime-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="date" style="font-weight: 600;">Date</label>
                        <input type="date" id="date" name="date" 
                               min="<?php echo date('Y-m-d'); ?>" 
                               required
                               style="width: 100%; padding: 0.75rem; background: rgba(255, 255, 255, 0.08); 
                                      border: 1px solid var(--border-color); border-radius: 8px; 
                                      color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
                    </div>

                    <div class="form-group">
                        <label for="start_time" style="font-weight: 600;">Start Time</label>
                        <select id="start_time" name="start_time" required
                                style="width: 100%; padding: 0.75rem; background: rgba(255, 255, 255, 0.08); 
                                       border: 1px solid var(--border-color); border-radius: 8px; 
                                       color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
                            <option value="">Select time</option>
                            <?php for ($hour = 12; $hour <= 23; $hour++): ?>
                                <option value="<?php echo sprintf('%02d:00', $hour); ?>">
                                    <?php echo sprintf('%02d:00', $hour); ?>
                                </option>
                                <option value="<?php echo sprintf('%02d:30', $hour); ?>">
                                    <?php echo sprintf('%02d:30', $hour); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="duration" style="font-weight: 600;">Duration (hours)</label>
                        <select id="duration" name="duration" required
                                style="width: 100%; padding: 0.75rem; background: rgba(255, 255, 255, 0.08); 
                                       border: 1px solid var(--border-color); border-radius: 8px; 
                                       color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
                            <?php for ($i = 1; $i <= 15; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?> hour<?= $i > 1 ? 's' : '' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <button type="button" id="checkAvailability" 
                        class="btn btn-outline" 
                        style="margin-top: 1.5rem; font-weight: 600; width: 100%; max-width: 300px;">
                    🔍 Check Available Tables
                </button>
            </div>

            <!-- Step 2: Table Selection -->
            <div id="tableSelection" style="display: none; margin-bottom: 2.5rem;">
                <h3 style="font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>🎱</span> Select Your Table
                </h3>
                <div id="tablesContainer" 
                     style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                    <!-- Tables loaded dynamically -->
                </div>
            </div>

            <!-- Step 3: Package Selection -->
            <div id="packageSelection" style="display: none; margin-bottom: 2.5rem;">
                <h3 style="font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>💰</span> Choose Your Package
                </h3>
                <div id="packagesContainer" style="display: flex; flex-direction: column; gap: 1rem;">
                    <!-- Packages loaded dynamically -->
                </div>
            </div>

            <!-- Step 4: Booking Summary -->
            <div id="bookingSummary" style="display: none; margin-bottom: 2rem;">
                <h3 style="font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📋</span> Booking Summary
                </h3>
                <div class="card" style="background: rgba(255, 255, 255, 0.05);">
                    <div id="summaryContent"></div>
                    <div style="margin-top: 1.5rem;">
                        <label for="customer_name" style="font-weight: 600;">Customer Name</label>
                        <input type="text" id="customer_name" name="customer_name" 
                               value="<?php echo htmlspecialchars(Auth::user()['name'] ?? ''); ?>"
                               style="width: 100%; padding: 0.75rem; background: rgba(255, 255, 255, 0.08); 
                                      border: 1px solid var(--border-color); border-radius: 8px; 
                                      color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;"
                               required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 1.5rem; font-weight: 700; width: 100%;">
                    🎯 Confirm Booking
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Responsive & Readability CSS -->
<style>
    /* Ensure dropdown text is readable */
    #start_time,
    #duration,
    #date,
    #customer_name {
        color: #ffffff !important;
    }

    select option {
        color: #000000 !important;
        background-color: #ffffff !important;
    }

    /* Mobile: stack form fields vertically */
    @media (max-width: 768px) {
        .datetime-grid {
            grid-template-columns: 1fr !important;
            gap: 1.25rem !important;
        }

        /* Prevent iOS zoom on form focus */
        .datetime-grid input,
        .datetime-grid select {
            font-size: 16px !important;
        }

        /* Full-width buttons on mobile */
        #checkAvailability,
        #bookingSummary button[type="submit"] {
            width: 100% !important;
            max-width: none !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAvailabilityBtn = document.getElementById('checkAvailability');
    const tableSelection = document.getElementById('tableSelection');
    const packageSelection = document.getElementById('packageSelection');
    
    window.selectedTable = null;
    window.selectedPackage = null;

    checkAvailabilityBtn.addEventListener('click', function() {
        const date = document.getElementById('date').value;
        const startTime = document.getElementById('start_time').value;
        const duration = document.getElementById('duration').value;
        
        if (!date || !startTime || !duration) {
            alert('❌ Please fill in all fields: date, start time, and duration.');
            return;
        }
        
        checkAvailabilityBtn.innerHTML = '⏳ Checking...';
        checkAvailabilityBtn.disabled = true;
        
        const formData = new URLSearchParams();
        formData.append('date', date);
        formData.append('start_time', startTime);
        formData.append('duration', duration);
        
        fetch('<?php echo Router::url('booking/check-availability'); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayTables(data.tables);
                displayPackages(data.packages);
                tableSelection.style.display = 'block';
                packageSelection.style.display = 'block';
                window.selectedTable = null;
                window.selectedPackage = null;
                document.getElementById('selected_table_id').value = '';
                document.getElementById('selected_package_id').value = '';
                tableSelection.scrollIntoView({ behavior: 'smooth' });
            } else {
                alert('❌ ' + (data.error || 'No tables available for this time.'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('❌ Failed to check availability. Please try again.');
        })
        .finally(() => {
            checkAvailabilityBtn.innerHTML = '🔍 Check Available Tables';
            checkAvailabilityBtn.disabled = false;
        });
    });
    
    function displayTables(tables) {
        const container = document.getElementById('tablesContainer');
        container.innerHTML = '';
        if (tables.length === 0) {
            container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">😔</div>
                    <h4 style="font-weight: 700;">No Tables Available</h4>
                    <p>Please try a different date or time.</p>
                </div>
            `;
            return;
        }
        tables.forEach(table => {
            const div = document.createElement('div');
            div.className = 'table-card';
            div.innerHTML = `
                <div style="background: var(--card-bg); border: 2px solid var(--border-color); 
                            border-radius: 12px; padding: 1.5rem; text-align: center; cursor: pointer;
                            transition: all 0.3s ease; height: 100%;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎱</div>
                    <h4 style="font-weight: 700; margin-bottom: 0.5rem;">${table.name}</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">
                        ${table.floor_name}
                    </p>
                    <p style="color: var(--text-muted); font-size: 0.8rem;">
                        Capacity: ${table.capacity} players
                    </p>
                    <div style="margin-top: 0.5rem; color: var(--accent); font-weight: 700;">
                        Rp ${table.hourly_rate.toLocaleString()}/hour
                    </div>
                </div>
            `;
            div.querySelector('div').addEventListener('click', () => selectTable(table.id, div.querySelector('div')));
            container.appendChild(div);
        });
    }
    
    function displayPackages(packages) {
        const container = document.getElementById('packagesContainer');
        container.innerHTML = '';
        if (packages.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                    <h4>No Packages Available</h4>
                </div>
            `;
            return;
        }
        packages.forEach(pkg => {
            let floorPricingHTML = '';
            if (pkg.floor_pricing?.length) {
                floorPricingHTML = pkg.floor_pricing.map(fp => 
                    `<span style="display: inline-block; margin-right: 1rem;">
                        ${fp.floor_name}: <strong>${fp.formatted_price}rb/jam</strong>
                    </span>`
                ).join('');
            }
            const div = document.createElement('div');
            div.innerHTML = `
                <div style="background: var(--card-bg); border: 2px solid var(--border-color); 
                            border-radius: 12px; padding: 1.5rem; cursor: pointer;
                            transition: all 0.3s ease;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                        <div>
                            <h4 style="font-weight: 700; font-size: 1.1rem;">${pkg.name}</h4>
                            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0.25rem 0;">
                                ${getPackageDescription(pkg)}
                            </p>
                        </div>
                        <div style="text-align: right; color: var(--text-muted); font-size: 0.8rem; font-weight: 600;">
                            ${getPackageType(pkg.package_type)}
                        </div>
                    </div>
                    ${floorPricingHTML ? `
                        <div style="border-top: 1px solid var(--border-color); padding-top: 0.75rem; color: var(--accent); font-size: 0.9rem;">
                            ${floorPricingHTML}
                        </div>
                    ` : ''}
                </div>
            `;
            div.querySelector('div').addEventListener('click', () => selectPackage(pkg.id, div.querySelector('div')));
            container.appendChild(div);
        });
    }
    
    function getPackageDescription(pkg) {
        if (pkg.package_type === 'unlimited') return 'Main sepuasnya • All floors';
        if (pkg.package_type === 'flat_rate') return `${pkg.duration_hours} hours • Special rate`;
        return 'Per hour • Flexible duration';
    }
    
    function getPackageType(type) {
        const types = { hourly: 'Per Hour', flat_rate: 'Package', unlimited: 'All You Can Play' };
        return types[type] || type;
    }
});

function selectTable(tableId, element) {
    document.querySelectorAll('.table-card > div').forEach(el => {
        el.style.borderColor = 'var(--border-color)';
        el.style.background = 'var(--card-bg)';
    });
    element.style.borderColor = 'var(--accent)';
    element.style.background = 'rgba(230, 57, 70, 0.1)';
    document.getElementById('selected_table_id').value = tableId;
    window.selectedTable = tableId;
    if (window.selectedPackage) calculatePrice();
}

function selectPackage(packageId, element) {
    document.querySelectorAll('#packagesContainer > div > div').forEach(el => {
        el.style.borderColor = 'var(--border-color)';
        el.style.background = 'var(--card-bg)';
    });
    element.style.borderColor = 'var(--accent)';
    element.style.background = 'rgba(230, 57, 70, 0.1)';
    document.getElementById('selected_package_id').value = packageId;
    window.selectedPackage = packageId;
    if (window.selectedTable) calculatePrice();
}

function calculatePrice() {
    const duration = document.getElementById('duration').value;
    if (!window.selectedTable || !window.selectedPackage) return;
    const formData = new URLSearchParams();
    formData.append('table_id', window.selectedTable);
    formData.append('package_id', window.selectedPackage);
    formData.append('duration', duration);
    fetch('<?php echo Router::url('booking/calculate-price'); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData
    })
    .then(r => r.json())
    .then(data => { if (data.success) displayBookingSummary(data); })
    .catch(err => console.error('Price calc error:', err));
}

function displayBookingSummary(data) {
    const date = document.getElementById('date').value;
    const startTime = document.getElementById('start_time').value;
    const duration = document.getElementById('duration').value;
    const dateObj = new Date(date);
    const formattedDate = dateObj.toLocaleDateString('en-US', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });
    document.getElementById('summaryContent').innerHTML = `
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div><strong style="color: var(--text-muted);">Date:</strong><br><span style="font-weight: 600;">${formattedDate}</span></div>
            <div><strong style="color: var(--text-muted);">Time:</strong><br><span style="font-weight: 600;">${startTime} (${duration} hour${duration > 1 ? 's' : ''})</span></div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div><strong style="color: var(--text-muted);">Table:</strong><br><span style="font-weight: 600;">${data.table.name}</span></div>
            <div><strong style="color: var(--text-muted);">Floor:</strong><br><span style="font-weight: 600;">${data.table.floor_name}</span></div>
        </div>
        <div style="border-top: 1px solid var(--border-color); padding-top: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <strong style="color: var(--text-muted);">Total Amount:</strong>
                <span style="font-size: 1.5rem; font-weight: 800; color: var(--accent);">${data.formatted_price}</span>
            </div>
        </div>
    `;
    document.getElementById('bookingSummary').style.display = 'block';
    document.getElementById('bookingSummary').scrollIntoView({ behavior: 'smooth' });
}

document.getElementById('bookingForm').addEventListener('submit', function(e) {
    const tableId = document.getElementById('selected_table_id').value;
    const packageId = document.getElementById('selected_package_id').value;
    const date = document.getElementById('date').value;
    const startTime = document.getElementById('start_time').value;
    if (!tableId || !packageId || !date || !startTime) {
        e.preventDefault();
        alert('❌ Please complete all steps:\n• Choose date & time\n• Select a table\n• Choose a package');
        return false;
    }
});
</script>