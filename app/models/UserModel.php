<?php
// app/models/UserModel.php

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? AND is_active = TRUE";
        return $this->db->fetch($sql, [$email]);
    }
    
    public function createUser($userData) {
        // Hash password sebelum simpan
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        $userData['created_at'] = date('Y-m-d H:i:s');
        
        return $this->create($userData);
    }
    
    public function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }
    
    public function updateLastLogin($userId) {
        $sql = "UPDATE {$this->table} SET updated_at = ? WHERE id = ?";
        return $this->db->query($sql, [date('Y-m-d H:i:s'), $userId]);
    }
    
    public function getCustomerStats($userId) {
        $sql = "SELECT 
                COUNT(*) as total_bookings,
                COALESCE(SUM(total_amount), 0) as total_spent
                FROM bookings 
                WHERE user_id = ? AND status = 'completed'";
        return $this->db->fetch($sql, [$userId]);
    }
}
?>