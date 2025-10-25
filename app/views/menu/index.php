<!-- app/views/menu/index.php -->
<div style="padding: 2rem 0;">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">
            Our <span class="text-accent">Menu</span>
        </h1>
        <p style="color: var(--text-muted); font-size: 1.1rem; font-weight: 500;">
            Discover delicious food, refreshing drinks, and exclusive Bille merchandise
        </p>
    </div>

    <!-- Category Navigation -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <button class="category-filter btn btn-outline active" data-category="all">
                🍴 All Menu
            </button>
            <button class="category-filter btn btn-outline" data-category="food">
                🍔 Food
            </button>
            <button class="category-filter btn btn-outline" data-category="beverage">
                🥤 Beverages
            </button>
            <button class="category-filter btn btn-outline" data-category="snack">
                🍿 Snacks
            </button>
            <button class="category-filter btn btn-outline" data-category="merchandise">
                🛍️ Merchandise
            </button>
        </div>
    </div>

    <!-- Menu Items Grid -->
    <div class="card">
        <!-- Food Category -->
        <div class="category-section" data-category="food">
            <h3 style="font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>🍔</span> Food & Meals
            </h3>
            
            <div class="products-grid">
                <?php foreach ($groupedProducts['food'] ?? [] as $product): ?>
                    <div class="product-card" data-category="food">
                        <div class="product-image">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <div style="width: 100%; height: 120px; background: var(--card-bg); 
                                            border-radius: 8px; display: flex; align-items: center; 
                                            justify-content: center; font-size: 2rem;">
                                    🍔
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-name">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </div>
                            
                            <div class="product-price">
                                Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                            </div>
                            
                            <div class="product-stock <?php 
                                echo $product['stock'] > 10 ? 'stock-available' : 
                                    ($product['stock'] > 0 ? 'stock-low' : 'stock-out');
                            ?>">
                                Stock: <?php echo $product['stock']; ?> pcs
                            </div>
                            
                            <?php if (!empty($product['description'])): ?>
                                <div class="product-description">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <button class="btn btn-outline add-to-order" 
                                data-product-id="<?php echo $product['id']; ?>"
                                data-product-name="<?php echo htmlspecialchars($product['name']); ?>"
                                data-product-price="<?php echo $product['price']; ?>"
                                <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>
                                style="width: 100%; margin-top: 1rem;">
                            <?php echo $product['stock'] <= 0 ? 'Out of Stock' : 'Add to Order'; ?>
                        </button>
                    </div>
                <?php endforeach; ?>
                
                <?php if (empty($groupedProducts['food'])): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🍔</div>
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem;">No Food Items Available</h4>
                        <p>Check back later for our delicious food options.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Beverages Category -->
        <div class="category-section" data-category="beverage">
            <h3 style="font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>🥤</span> Beverages & Drinks
            </h3>
            
            <div class="products-grid">
                <?php foreach ($groupedProducts['beverage'] ?? [] as $product): ?>
                    <div class="product-card" data-category="beverage">
                        <div class="product-image">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <div style="width: 100%; height: 120px; background: var(--card-bg); 
                                            border-radius: 8px; display: flex; align-items: center; 
                                            justify-content: center; font-size: 2rem;">
                                    🥤
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-name">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </div>
                            
                            <div class="product-price">
                                Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                            </div>
                            
                            <div class="product-stock <?php 
                                echo $product['stock'] > 10 ? 'stock-available' : 
                                    ($product['stock'] > 0 ? 'stock-low' : 'stock-out');
                            ?>">
                                Stock: <?php echo $product['stock']; ?> pcs
                            </div>
                            
                            <?php if (!empty($product['description'])): ?>
                                <div class="product-description">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <button class="btn btn-outline add-to-order" 
                                data-product-id="<?php echo $product['id']; ?>"
                                data-product-name="<?php echo htmlspecialchars($product['name']); ?>"
                                data-product-price="<?php echo $product['price']; ?>"
                                <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>
                                style="width: 100%; margin-top: 1rem;">
                            <?php echo $product['stock'] <= 0 ? 'Out of Stock' : 'Add to Order'; ?>
                        </button>
                    </div>
                <?php endforeach; ?>
                
                <?php if (empty($groupedProducts['beverage'])): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🥤</div>
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem;">No Beverages Available</h4>
                        <p>Check back later for our refreshing drinks.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Snacks Category -->
        <div class="category-section" data-category="snack">
            <h3 style="font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>🍿</span> Snacks & Sides
            </h3>
            
            <div class="products-grid">
                <?php foreach ($groupedProducts['snack'] ?? [] as $product): ?>
                    <div class="product-card" data-category="snack">
                        <div class="product-image">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <div style="width: 100%; height: 120px; background: var(--card-bg); 
                                            border-radius: 8px; display: flex; align-items: center; 
                                            justify-content: center; font-size: 2rem;">
                                    🍿
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-name">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </div>
                            
                            <div class="product-price">
                                Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                            </div>
                            
                            <div class="product-stock <?php 
                                echo $product['stock'] > 10 ? 'stock-available' : 
                                    ($product['stock'] > 0 ? 'stock-low' : 'stock-out');
                            ?>">
                                Stock: <?php echo $product['stock']; ?> pcs
                            </div>
                            
                            <?php if (!empty($product['description'])): ?>
                                <div class="product-description">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <button class="btn btn-outline add-to-order" 
                                data-product-id="<?php echo $product['id']; ?>"
                                data-product-name="<?php echo htmlspecialchars($product['name']); ?>"
                                data-product-price="<?php echo $product['price']; ?>"
                                <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>
                                style="width: 100%; margin-top: 1rem;">
                            <?php echo $product['stock'] <= 0 ? 'Out of Stock' : 'Add to Order'; ?>
                        </button>
                    </div>
                <?php endforeach; ?>
                
                <?php if (empty($groupedProducts['snack'])): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🍿</div>
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem;">No Snacks Available</h4>
                        <p>Check back later for our tasty snacks.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Merchandise Category -->
        <div class="category-section" data-category="merchandise">
            <h3 style="font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>🛍️</span> Bille Merchandise
            </h3>
            
            <div class="products-grid">
                <?php foreach ($groupedProducts['merchandise'] ?? [] as $product): ?>
                    <div class="product-card" data-category="merchandise">
                        <div class="product-image">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <div style="width: 100%; height: 120px; background: var(--card-bg); 
                                            border-radius: 8px; display: flex; align-items: center; 
                                            justify-content: center; font-size: 2rem;">
                                    👕
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-name">
                                <?php echo htmlspecialchars($product['name']); ?>
                                <span class="merchandise-badge">MERCH</span>
                            </div>
                            
                            <div class="product-price">
                                Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                            </div>
                            
                            <div class="product-stock <?php 
                                echo $product['stock'] > 10 ? 'stock-available' : 
                                    ($product['stock'] > 0 ? 'stock-low' : 'stock-out');
                            ?>">
                                Stock: <?php echo $product['stock']; ?> pcs
                            </div>
                            
                            <?php if (!empty($product['description'])): ?>
                                <div class="product-description">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <button class="btn btn-outline add-to-order" 
                                data-product-id="<?php echo $product['id']; ?>"
                                data-product-name="<?php echo htmlspecialchars($product['name']); ?>"
                                data-product-price="<?php echo $product['price']; ?>"
                                <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>
                                style="width: 100%; margin-top: 1rem;">
                            <?php echo $product['stock'] <= 0 ? 'Out of Stock' : 'Add to Cart'; ?>
                        </button>
                    </div>
                <?php endforeach; ?>
                
                <?php if (empty($groupedProducts['merchandise'])): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🛍️</div>
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem;">No Merchandise Available</h4>
                        <p>Check back later for our exclusive Bille merchandise.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Shopping Cart Sidebar -->
<div id="cartSidebar" style="position: fixed; top: 0; right: -400px; width: 400px; height: 100vh; 
                            background: var(--card-bg); border-left: 1px solid var(--border-color);
                            transition: right 0.3s ease; z-index: 1000; padding: 2rem; overflow-y: auto;">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 2rem;">
        <h3 style="font-weight: 700;">🛒 Your Order</h3>
        <button id="closeCart" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
            ✕
        </button>
    </div>
    
    <div id="cartItems">
        <!-- Cart items will be loaded here -->
    </div>
    
    <div id="cartEmpty" style="text-align: center; padding: 2rem; color: var(--text-muted);">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🛒</div>
        <p>Your cart is empty</p>
    </div>
    
    <div id="cartTotal" style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--border-color); 
                              display: none;">
        <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1.2rem;">
            <span>Total:</span>
            <span id="totalAmount">Rp 0</span>
        </div>
        
        <button id="checkoutBtn" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
            💳 Checkout
        </button>
    </div>
</div>

<!-- Cart Toggle Button -->
<button id="cartToggle" style="position: fixed; bottom: 2rem; right: 2rem; background: var(--accent); 
                              color: white; border: none; border-radius: 50%; width: 60px; height: 60px; 
                              font-size: 1.5rem; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.3); 
                              z-index: 999;">
    🛒
</button>

<style>
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.product-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-name {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: between;
}

.product-price {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--accent);
    margin-bottom: 0.5rem;
}

.product-stock {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.stock-available { color: #28a745; }
.stock-low { color: #ffc107; }
.stock-out { color: #dc3545; }

.product-description {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.4;
}

.merchandise-badge {
    background: var(--accent);
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.7rem;
    margin-left: 8px;
}

.category-section {
    margin-bottom: 3rem;
}

.category-section:last-child {
    margin-bottom: 0;
}

/* Hide all categories initially, show via JavaScript */
.category-section {
    display: block;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.cart-item:last-child {
    border-bottom: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = [];
    
    // Category Filter
    const categoryFilters = document.querySelectorAll('.category-filter');
    const categorySections = document.querySelectorAll('.category-section');
    
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active state
            categoryFilters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');
            
            // Show/hide categories
            categorySections.forEach(section => {
                if (category === 'all' || section.dataset.category === category) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });
    
    // Add to Order/Cart
    document.querySelectorAll('.add-to-order').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = parseFloat(this.dataset.productPrice);
            
            addToCart(productId, productName, productPrice);
        });
    });
    
    // Cart Functions
    function addToCart(productId, productName, productPrice) {
        const existingItem = cart.find(item => item.id === productId);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1
            });
        }
        
        updateCartDisplay();
        showNotification(`${productName} added to cart!`);
    }
    
    function updateCartDisplay() {
        const cartItems = document.getElementById('cartItems');
        const cartEmpty = document.getElementById('cartEmpty');
        const cartTotal = document.getElementById('cartTotal');
        const totalAmount = document.getElementById('totalAmount');
        
        cartItems.innerHTML = '';
        
        if (cart.length === 0) {
            cartEmpty.style.display = 'block';
            cartTotal.style.display = 'none';
        } else {
            cartEmpty.style.display = 'none';
            cartTotal.style.display = 'block';
            
            let total = 0;
            
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div>
                        <div style="font-weight: 600;">${item.name}</div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">
                            Rp ${item.price.toLocaleString()} x ${item.quantity}
                        </div>
                    </div>
                    <div style="font-weight: 700;">
                        Rp ${itemTotal.toLocaleString()}
                    </div>
                `;
                cartItems.appendChild(cartItem);
            });
            
            totalAmount.textContent = `Rp ${total.toLocaleString()}`;
        }
    }
    
    function showNotification(message) {
        // Simple notification - you can enhance this
        alert('✅ ' + message);
    }
    
    // Cart Toggle
    const cartToggle = document.getElementById('cartToggle');
    const cartSidebar = document.getElementById('cartSidebar');
    const closeCart = document.getElementById('closeCart');
    
    cartToggle.addEventListener('click', function() {
        cartSidebar.style.right = '0';
    });
    
    closeCart.addEventListener('click', function() {
        cartSidebar.style.right = '-400px';
    });
    
    // Checkout
    // Checkout ke WhatsApp
document.getElementById('checkoutBtn').addEventListener('click', function() {
    if (cart.length === 0) {
        alert('🛒 Your cart is empty!');
        return;
    }

    let total = 0;
    let message = '*🧾 BILLE SOUTHSIDE ORDER*\n\n';
    cart.forEach(item => {
        const subtotal = item.price * item.quantity;
        total += subtotal;
        message += `• ${item.name} x${item.quantity} = Rp ${subtotal.toLocaleString()}\n`;
    });

    message += `\n*Total:* Rp ${total.toLocaleString()}`;
    message += `\n\nMohon konfirmasi pesanan ini, kak 🙌`;
    message += `\n\nTerima kasih sudah order di *BILLE SOUTHSIDE*! 🎱🔥`;

    const encodedMessage = encodeURIComponent(message);
    const phoneNumber = '6285129482769'; // ← GANTI ke nomor WhatsApp BILLE (format internasional, tanpa +)
    
    const waLink = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    window.open(waLink, '_blank');
});

});
</script>