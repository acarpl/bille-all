<?php
// app/models/MenuModel.php

class MenuModel extends Model {
    protected $table = 'products';
    protected $primaryKey = 'id';
    
    public function getAllProducts() {
        $sql = "SELECT * FROM {$this->table} 
                WHERE is_available = 1 
                ORDER BY category, name";
        
        return $this->db->fetchAll($sql);
    }
    
    public function getProductsByCategory($category) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE category = ? AND is_available = 1 
                ORDER BY name";
        
        return $this->db->fetchAll($sql, [$category]);
    }
    
    public function getProductById($productId) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->fetch($sql, [$productId]);
    }
    
    public function getCategories() {
        $sql = "SELECT DISTINCT category FROM {$this->table} 
                WHERE is_available = 1 
                ORDER BY category";
        
        return $this->db->fetchAll($sql);
    }
    
    public function updateStock($productId, $newStock) {
        $sql = "UPDATE {$this->table} SET stock = ? WHERE id = ?";
        return $this->db->query($sql, [$newStock, $productId]);
    }
    
    public function getMerchandise() {
        return $this->getProductsByCategory('merchandise');
    }
    
    public function getFoodAndBeverages() {
        $sql = "SELECT * FROM {$this->table} 
                WHERE category IN ('food', 'beverage', 'snack') 
                AND is_available = 1 
                ORDER BY category, name";
        
        return $this->db->fetchAll($sql);
    }
    
    public function searchProducts($searchTerm) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (name LIKE ? OR description LIKE ?) 
                AND is_available = 1 
                ORDER BY category, name";
        
        $searchParam = "%{$searchTerm}%";
        return $this->db->fetchAll($sql, [$searchParam, $searchParam]);
    }
    
    public function getLowStockProducts($threshold = 5) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE stock <= ? AND is_available = 1 
                ORDER BY stock ASC, name";
        
        return $this->db->fetchAll($sql, [$threshold]);
    }
    
    public function getProductsWithImages() {
        $sql = "SELECT * FROM {$this->table} 
                WHERE image IS NOT NULL AND is_available = 1 
                ORDER BY category, name";
        
        return $this->db->fetchAll($sql);
    }
    
    public function getPopularProducts($limit = 10) {
        // Ini contoh - Anda perlu menyesuaikan dengan struktur order_items yang ada
        $sql = "SELECT p.*, COUNT(oi.id) as order_count 
                FROM {$this->table} p
                LEFT JOIN order_items oi ON p.id = oi.product_id
                WHERE p.is_available = 1
                GROUP BY p.id 
                ORDER BY order_count DESC 
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$limit]);
    }

    // Tambahkan di MenuModel.php
public function createProduct($data) {
    $sql = "INSERT INTO products (name, category, price, stock, description, image, is_available) 
            VALUES (?, ?, ?, ?, ?, ?, 1)";
    
    return $this->db->query($sql, [
        $data['name'],
        $data['category'], 
        $data['price'],
        $data['stock'],
        $data['description'],
        $data['image']
    ]);
}

public function updateProduct($productId, $data) {
    $sql = "UPDATE products SET name = ?, category = ?, price = ?, stock = ?, 
            description = ?, image = ?, is_available = ? WHERE id = ?";
    
    return $this->db->query($sql, [
        $data['name'],
        $data['category'],
        $data['price'], 
        $data['stock'],
        $data['description'],
        $data['image'],
        $data['is_available'],
        $productId
    ]);
}

public function deleteProduct($productId) {
    $sql = "DELETE FROM products WHERE id = ?";
    return $this->db->query($sql, [$productId]);
}

public function updateProductStock($productId, $stock) {
    $sql = "UPDATE products SET stock = ? WHERE id = ?";
    return $this->db->query($sql, [$stock, $productId]);
}
}
?>