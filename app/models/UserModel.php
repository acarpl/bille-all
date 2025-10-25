<?php
// app/models/UserModel.php - FINAL WORKING VERSION

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? AND is_active = TRUE";
        $stmt = $this->db->query($sql, [$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createUser($userData) {
        // Hash password
        if (isset($userData['password'])) {
            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        }
        $userData['created_at'] = date('Y-m-d H:i:s');
        $userData['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->create($userData);
    }
    
    public function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }
    
    public function emailExists($email) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->query($sql, [$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
    
    public function updateLastLogin($userId) {
        $sql = "UPDATE {$this->table} SET updated_at = ? WHERE id = ?";
        $this->db->query($sql, [date('Y-m-d H:i:s'), $userId]);
        return true;
    }

    public function getCustomerStats($userId) {
        $sql = "SELECT 
                COUNT(*) as total_bookings,
                COALESCE(SUM(total_amount), 0) as total_spent,
                COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_bookings,
                COUNT(CASE WHEN status = 'active' THEN 1 END) as active_bookings
                FROM bookings 
                WHERE user_id = ?";
        
        return $this->db->fetch($sql, [$userId]);
    }
}
?>