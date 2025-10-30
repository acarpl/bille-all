<?php
// app/models/TableModel.php

class TableModel extends Model {
    protected $table = 'tables';
    protected $primaryKey = 'id';
    
public function getAvailableTables($date, $startTime, $durationHours) {
    $startDateTime = $date . ' ' . $startTime;
    $endTime = date('Y-m-d H:i:s', strtotime("$startDateTime + $durationHours hours"));
    
    $sql = "SELECT t.*, f.name as floor_name, f.base_hourly_rate
            FROM {$this->table} t
            JOIN floors f ON t.floor_id = f.id
            WHERE t.id NOT IN (
                SELECT table_id FROM bookings 
                WHERE status IN ('confirmed', 'active')
                AND (
                    (start_time < ? AND DATE_ADD(start_time, INTERVAL duration_hours HOUR) > ?)
                    OR (start_time < ? AND DATE_ADD(start_time, INTERVAL duration_hours HOUR) > ?)
                )
            )
            ORDER BY t.floor_id, t.table_number";
    
    $params = [$endTime, $startDateTime, $endTime, $startDateTime];
    
    return $this->db->fetchAll($sql, $params);
}
    
    public function getTableWithFloor($tableId) {
        $sql = "SELECT t.*, f.name as floor_name, f.base_hourly_rate
                FROM {$this->table} t
                JOIN floors f ON t.floor_id = f.id
                WHERE t.id = ?";
        
        return $this->db->fetch($sql, [$tableId]);
    }
    
    public function updateTableStatus($tableId, $status) {
        $sql = "UPDATE {$this->table} SET status = ? WHERE id = ?";
        return $this->db->query($sql, [$status, $tableId]);
    }
    
    public function getAllTables() {
        $sql = "SELECT t.*, f.name as floor_name 
                FROM {$this->table} t
                JOIN floors f ON t.floor_id = f.id
                ORDER BY f.floor_number, t.table_number";
        
        return $this->db->fetchAll($sql);
    }

    public function getTableCountByStatus($status) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = ?";
        $result = $this->db->fetch($sql, [$status]);
        return $result['count'];
    }
}
?>