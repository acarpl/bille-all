<?php
// app/models/BookingModel.php

class BookingModel extends Model {
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    
    public function createBooking($bookingData) {
        $bookingData['created_at'] = date('Y-m-d H:i:s');
        return $this->create($bookingData);
    }
    
    public function getUserBookings($userId) {
        $sql = "SELECT b.*, t.table_number, t.name as table_name, 
                       f.name as floor_name, p.name as package_name
                FROM {$this->table} b
                JOIN tables t ON b.table_id = t.id
                JOIN floors f ON b.floor_id = f.id
                JOIN packages p ON b.package_id = p.id
                WHERE b.user_id = ?
                ORDER BY b.created_at DESC";
        
        return $this->db->fetchAll($sql, [$userId]);
    }
    
    public function getActiveBookings() {
        $sql = "SELECT b.*, t.table_number, t.name as table_name, 
                       u.name as customer_name, p.name as package_name
                FROM {$this->table} b
                JOIN tables t ON b.table_id = t.id
                JOIN users u ON b.user_id = u.id
                JOIN packages p ON b.package_id = p.id
                WHERE b.status IN ('confirmed', 'active')
                ORDER BY b.start_time ASC";
        
        return $this->db->fetchAll($sql);
    }
    
    public function updateBookingStatus($bookingId, $status) {
        $sql = "UPDATE {$this->table} SET status = ? WHERE id = ?";
        return $this->db->query($sql, [$status, $bookingId]);
    }
    
    public function checkTableAvailability($tableId, $startTime, $durationHours) {
        $endTime = date('Y-m-d H:i:s', strtotime("$startTime + $durationHours hours"));
        
        $sql = "SELECT COUNT(*) as conflict_count 
                FROM {$this->table} 
                WHERE table_id = ? 
                AND status IN ('confirmed', 'active')
                AND (
                    (start_time < ? AND DATE_ADD(start_time, INTERVAL duration_hours HOUR) > ?)
                    OR (start_time < ? AND DATE_ADD(start_time, INTERVAL duration_hours HOUR) > ?)
                    OR (start_time >= ? AND start_time < ?)
                )";
        
        $params = [$tableId, $endTime, $startTime, $endTime, $startTime, $startTime, $endTime];
        $result = $this->db->fetch($sql, $params);
        
        return $result['conflict_count'] == 0;
    }

    public function getAllBookings($status = 'all', $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT b.*, t.table_number, t.name as table_name, 
                       f.name as floor_name, p.name as package_name,
                       u.name as customer_name, u.email, u.phone
                FROM {$this->table} b
                JOIN tables t ON b.table_id = t.id
                JOIN floors f ON b.floor_id = f.id
                JOIN packages p ON b.package_id = p.id
                JOIN users u ON b.user_id = u.id";
        
        $params = [];
        
        if ($status !== 'all') {
            $sql .= " WHERE b.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY b.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        
        return $this->db->fetchAll($sql, $params);
    }
    
    public function getTotalBookings($status = 'all') {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $params = [];
        
        if ($status !== 'all') {
            $sql .= " WHERE status = ?";
            $params[] = $status;
        }
        
        $result = $this->db->fetch($sql, $params);
        return $result['total'];
    }
    
    public function getRecentBookings($limit = 5) {
        $sql = "SELECT b.*, t.table_number, u.name as customer_name
                FROM {$this->table} b
                JOIN tables t ON b.table_id = t.id
                JOIN users u ON b.user_id = u.id
                ORDER BY b.created_at DESC
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$limit]);
    }

     // TAMBAHKAN METHOD INI - YANG HILANG
    public function getBookingById($id) {
        $sql = "SELECT b.*, t.table_number, t.name as table_name, 
                       u.name as customer_name, u.email, u.phone,
                       p.name as package_name, f.name as floor_name
                FROM {$this->table} b
                JOIN tables t ON b.table_id = t.id
                JOIN users u ON b.user_id = u.id
                LEFT JOIN packages p ON b.package_id = p.id
                LEFT JOIN floors f ON t.floor_id = f.id
                WHERE b.id = ?";
        
        return $this->db->fetch($sql, [$id]);
    }

    // TAMBAHKAN METHOD INI JUGA - untuk AdminController
    public function getBookingByIdSimple($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
?>