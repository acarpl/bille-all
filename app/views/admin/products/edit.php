<!-- app/views/admin/products/edit.php -->
<div style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <a href="<?php echo Router::url('admin/products'); ?>" class="btn btn-outline" style="margin-bottom: 1rem;">
            ← Back to Products
        </a>
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
            Edit Product
        </h1>
        <p style="color: var(--text-muted);">Update product information</p>
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
        <form method="POST" action="<?php echo Router::url('admin/products/update/' . $product['id']); ?>" enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <!-- Basic Information -->
                <div>
                    <h3 style="font-weight: 700; margin-bottom: 1rem;">Basic Information</h3>
                    
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" 
                               value="<?php echo htmlspecialchars($_SESSION['old_input']['name'] ?? $product['name']); ?>" 
                               required style="width: 100%;">
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select id="category" name="category" required style="width: 100%;">
                            <option value="">Select Category</option>
                            <option value="food" <?php echo ($_SESSION['old_input']['category'] ?? $product['category']) === 'food' ? 'selected' : ''; ?>>
                                🍔 Food
                            </option>
                            <option value="beverage" <?php echo ($_SESSION['old_input']['category'] ?? $product['category']) === 'beverage' ? 'selected' : ''; ?>>
                                🥤 Beverage
                            </option>
                            <option value="snack" <?php echo ($_SESSION['old_input']['category'] ?? $product['category']) === 'snack' ? 'selected' : ''; ?>>
                                🍿 Snack
                            </option>
                            <option value="merchandise" <?php echo ($_SESSION['old_input']['category'] ?? $product['category']) === 'merchandise' ? 'selected' : ''; ?>>
                                🛍️ Merchandise
                            </option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price (Rp) *</label>
                        <input type="number" id="price" name="price" 
                               value="<?php echo $_SESSION['old_input']['price'] ?? $product['price']; ?>" 
                               min="0" step="1000" required style="width: 100%;">
                    </div>
                    
                    <div class="form-group">
                        <label for="stock">Stock *</label>
                        <input type="number" id="stock" name="stock" 
                               value="<?php echo $_SESSION['old_input']['stock'] ?? $product['stock']; ?>" 
                               min="0" required style="width: 100%;">
                    </div>

                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="is_available" value="1" 
                                   <?php echo ($_SESSION['old_input']['is_available'] ?? $product['is_available']) ? 'checked' : ''; ?>>
                            <span>Product is available for sale</span>
                        </label>
                    </div>
                </div>
                
                <!-- Additional Information -->
                <div>
                    <h3 style="font-weight: 700; margin-bottom: 1rem;">Additional Information</h3>
                    
                    <!-- Current Image Preview -->
                    <?php if ($product['image']): ?>
                        <div class="form-group">
                            <label>Current Image</label>
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                <img src="<?php echo Router::url('public/assets/images/products/' . $product['image']); ?>"
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid var(--border-color);">
                                <div>
                                    <div style="font-weight: 600; margin-bottom: 0.5rem;">Current Image</div>
                                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                        <input type="checkbox" name="remove_image" value="1">
                                        <span style="color: var(--accent);">Remove image</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <label>Current Image</label>
                            <div style="padding: 2rem; text-align: center; background: var(--card-bg); border-radius: 8px; border: 2px dashed var(--border-color);">
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">📷</div>
                                <div style="color: var(--text-muted);">No image uploaded</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="image"><?php echo $product['image'] ? 'Change Image' : 'Upload Image'; ?></label>
                        <input type="file" id="image" name="image" 
                               accept="image/jpeg,image/png,image/gif,image/webp"
                               style="width: 100%;">
                        <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">
                            Supported formats: JPEG, PNG, GIF, WebP (Max: 2MB)
                            <?php if ($product['image']): ?>
                                <br>Upload new image to replace the current one.
                            <?php endif; ?>
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" 
                                  style="width: 100%; height: 120px; resize: vertical;"
                                  placeholder="Enter product description..."><?php echo htmlspecialchars($_SESSION['old_input']['description'] ?? $product['description'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Product Stats -->
            <div style="background: rgba(255, 255, 255, 0.05); padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0;">
                <h4 style="font-weight: 700; margin-bottom: 1rem;">Product Information</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">Product ID</div>
                        <div style="font-weight: 600;">#<?php echo $product['id']; ?></div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">Created</div>
                        <div style="font-weight: 600;">
                            <?php echo date('M j, Y', strtotime($product['created_at'])); ?>
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">Last Updated</div>
                        <div style="font-weight: 600;">
                            <?php echo date('M j, Y g:i A', strtotime($product['updated_at'] ?? $product['created_at'])); ?>
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">Status</div>
                        <div>
                            <span class="badge <?php echo $product['is_available'] ? 'badge-success' : 'badge-error'; ?>">
                                <?php echo $product['is_available'] ? 'Available' : 'Disabled'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">💾 Update Product</button>
                <a href="<?php echo Router::url('admin/products'); ?>" class="btn btn-outline">Cancel</a>
                
                <!-- Danger Zone -->
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                    <h4 style="font-weight: 700; color: var(--accent); margin-bottom: 1rem;">Danger Zone</h4>
                    <p style="color: var(--text-muted); margin-bottom: 1rem;">
                        Once you delete a product, there is no going back. Please be certain.
                    </p>
                    <form method="POST" action="<?php echo Router::url('admin/products/delete/' . $product['id']); ?>" 
                          onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')"
                          style="display: inline-block;">
                        <button type="submit" class="btn btn-error">🗑️ Delete Product</button>
                    </form>
                </div>
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

.form-group input[type="checkbox"] {
    width: auto;
    margin: 0;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-success { background: #e8f5e8; color: #2e7d32; }
.badge-error { background: #ffebee; color: #c62828; }

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert-error {
    background: #ffebee;
    border: 1px solid #f44336;
    color: #c62828;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview for new image upload
    const imageInput = document.getElementById('image');
    const currentImage = document.querySelector('img[alt*="Current Image"]');
    
    if (imageInput && currentImage) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Remove image checkbox logic
    const removeImageCheckbox = document.querySelector('input[name="remove_image"]');
    if (removeImageCheckbox && currentImage) {
        removeImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                currentImage.style.opacity = '0.5';
                currentImage.style.borderColor = 'var(--accent)';
            } else {
                currentImage.style.opacity = '1';
                currentImage.style.borderColor = 'var(--border-color)';
            }
        });
    }
    
    // Price formatting
    const priceInput = document.getElementById('price');
    if (priceInput) {
        priceInput.addEventListener('blur', function() {
            this.value = parseInt(this.value) || 0;
        });
    }
});
</script>