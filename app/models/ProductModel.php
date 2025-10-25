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
}
?>