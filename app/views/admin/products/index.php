<!-- app/views/admin/products/index.php -->
<div style="padding: 2rem 0;">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                Pengelolaan Produk
            </h1>
            <p style="color: var(--text-muted);">Kelola produk menu dan barang dagangan Anda</p>
        </div>
        <a href="<?php echo Router::url('admin/products/create'); ?>" class="btn btn-primary">
            ➕ Tambah Produk Baru
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            ✅ <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            ❌ <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Products Table -->
    <div class="card">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--card-bg); border-bottom: 2px solid var(--border-color);">
                        <th style="padding: 1rem; text-align: left;">Produk</th>
                        <th style="padding: 1rem; text-align: left;">Kategori</th>
                        <th style="padding: 1rem; text-align: right;">Harga</th>
                        <th style="padding: 1rem; text-align: center;">Stok</th>
                        <th style="padding: 1rem; text-align: center;">Status</th>
                        <th style="padding: 1rem; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <?php if ($product['image']): ?>
                                            <img src="<?php echo BASE_URL; ?>/public/assets/images/products/<?php echo htmlspecialchars($product['image']); ?>"
                                                alt="<?php echo htmlspecialchars($product['name']); ?>"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        <?php else: ?>
                                            <div style="width: 50px; height: 50px; background: var(--card-bg); 
                                                        border-radius: 8px; display: flex; align-items: center; 
                                                        justify-content: center; font-size: 1.2rem;">
                                                <?php
                                                $icons = [
                                                    'food' => '🍔',
                                                    'beverage' => '🥤',
                                                    'snack' => '🍿',
                                                    'merchandise' => '👕'
                                                ];
                                                echo $icons[$product['category']] ?? '📦';
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div style="font-weight: 600;"><?php echo htmlspecialchars($product['name']); ?></div>
                                            <?php if ($product['description']): ?>
                                                <div style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.25rem;">
                                                    <?php echo htmlspecialchars(substr($product['description'], 0, 50)); ?>...
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <span class="badge badge-<?php echo $product['category']; ?>">
                                        <?php echo ucfirst($product['category']); ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: right; font-weight: 600;">
                                    Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <form method="POST" action="<?php echo Router::url('admin/products/stock/' . $product['id']); ?>"
                                        style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                                        <input type="number" name="stock" value="<?php echo $product['stock']; ?>"
                                            style="width: 80px; padding: 0.5rem; border: 1px solid var(--border-color); 
                                                      border-radius: 4px; text-align: center;"
                                            min="0">
                                        <button type="submit" class="btn btn-sm btn-outline">Perbarui</button>
                                    </form>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="badge <?php echo $product['is_available'] ? 'badge-success' : 'badge-error'; ?>">
                                        <?php echo $product['is_available'] ? 'Tersedia' : 'Tidak Tersedia'; ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="<?php echo Router::url('admin/products/edit/' . $product['id']); ?>"
                                            class="btn btn-sm btn-outline">✏️ Edit</a>
                                        <form method="POST" action="<?php echo Router::url('admin/products/delete/' . $product['id']); ?>"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <button type="submit" class="btn btn-sm btn-error">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: var(--text-muted);">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                                <h3>Tidak Ditemukan Produk</h3>
                                <p>Mulailah dengan menambahkan produk pertama Anda.</p>
                                <a href="<?php echo Router::url('admin/products/create'); ?>" class="btn btn-primary">
                                    Tambahkan Produk Pertama Anda
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-food {
        background: #e3f2fd;
        color: #1976d2;
    }

    .badge-beverage {
        background: #e8f5e8;
        color: #2e7d32;
    }

    .badge-snack {
        background: #fff3e0;
        color: #f57c00;
    }

    .badge-merchandise {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .badge-success {
        background: #e8f5e8;
        color: #2e7d32;
    }

    .badge-error {
        background: #ffebee;
        color: #c62828;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-success {
        background: #e8f5e8;
        border: 1px solid #4caf50;
        color: #2e7d32;
    }

    .alert-error {
        background: #ffebee;
        border: 1px solid #f44336;
        color: #c62828;
    }
</style>