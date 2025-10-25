<!-- app/views/admin/products/create.php -->
<div style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <a href="<?php echo Router::url('admin/products'); ?>" class="btn btn-outline" style="margin-bottom: 1rem;">
            ← Back to Products
        </a>
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
            Add New Product
        </h1>
        <p style="color: var(--text-muted);">Create a new menu item or merchandise</p>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['form_errors'])): ?>
        <div class="alert alert-error">
            <strong>Please fix the following errors:</strong>
            <ul style="margin: 0.5rem 0 0 1rem;">
                <?php foreach ($_SESSION['form_errors'] as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
            <?php unset($_SESSION['form_errors']); ?>
        </div>
    <?php endif; ?>

    <!-- Product Form -->
    <div class="card">
        <form method="POST" action="<?php echo Router::url('admin/products/store'); ?>" enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <!-- Basic Information -->
                <div>
                    <h3 style="font-weight: 700; margin-bottom: 1rem;">Basic Information</h3>
                    
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" 
                               value="<?php echo $_SESSION['old_input']['name'] ?? ''; ?>" 
                               required style="width: 100%;">
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select id="category" name="category" required style="width: 100%;">
                            <option value="">Select Category</option>
                            <option value="food" <?php echo ($_SESSION['old_input']['category'] ?? '') === 'food' ? 'selected' : ''; ?>>
                                🍔 Food
                            </option>
                            <option value="beverage" <?php echo ($_SESSION['old_input']['category'] ?? '') === 'beverage' ? 'selected' : ''; ?>>
                                🥤 Beverage
                            </option>
                            <option value="snack" <?php echo ($_SESSION['old_input']['category'] ?? '') === 'snack' ? 'selected' : ''; ?>>
                                🍿 Snack
                            </option>
                            <option value="merchandise" <?php echo ($_SESSION['old_input']['category'] ?? '') === 'merchandise' ? 'selected' : ''; ?>>
                                🛍️ Merchandise
                            </option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price (Rp) *</label>
                        <input type="number" id="price" name="price" 
                               value="<?php echo $_SESSION['old_input']['price'] ?? ''; ?>" 
                               min="0" step="1000" required style="width: 100%;">
                    </div>
                    
                    <div class="form-group">
                        <label for="stock">Initial Stock *</label>
                        <input type="number" id="stock" name="stock" 
                               value="<?php echo $_SESSION['old_input']['stock'] ?? '0'; ?>" 
                               min="0" required style="width: 100%;">
                    </div>
                </div>
                
                <!-- Additional Information -->
                <div>
                    <h3 style="font-weight: 700; margin-bottom: 1rem;">Additional Information</h3>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" 
                                  style="width: 100%; height: 100px; resize: vertical;"
                                  placeholder="Enter product description..."><?php echo $_SESSION['old_input']['description'] ?? ''; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" id="image" name="image" 
                               accept="image/jpeg,image/png,image/gif,image/webp"
                               style="width: 100%;">
                        <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">
                            Supported formats: JPEG, PNG, GIF, WebP (Max: 2MB)
                        </small>
                    </div>
                </div>
            </div>
            
            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">➕ Create Product</button>
                <a href="<?php echo Router::url('admin/products'); ?>" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php unset($_SESSION['old_input']); ?>

<style>
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-light);
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-light);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--accent);
}
</style>