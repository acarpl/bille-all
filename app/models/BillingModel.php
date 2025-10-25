<?php
class BillingModel extends Model {
    protected $table = 'billing_sessions';
    
    public function __construct() {
        parent::__construct();
    }

    // Get all active billing sessions with booking info - FIXED
    public function getAllBillingSessions() {
        $query = "SELECT bs.*, 
                         u.name as user_name, 
                         u.email,
                         b.id as booking_id,
                         b.table_id,
                         t.name as table_name,
                         t.table_number,
                         b.play_date,
                         b.play_time,
                         b.total_amount as booking_total
                  FROM billing_sessions bs
                  LEFT JOIN bookings b ON bs.booking_id = b.id
                  LEFT JOIN users u ON b.user_id = u.id
                  LEFT JOIN tables t ON b.table_id = t.id
                  ORDER BY bs.start_time DESC";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getAllBillingSessions: " . $e->getMessage());
            return [];
        }
    }

    // Get billing session by ID - FIXED
    public function getBillingSessionById($id) {
        $query = "SELECT bs.*, 
                         u.name as user_name, 
                         u.email,
                         b.id as booking_id,
                         b.table_id,
                         t.name as table_name,
                         t.table_number,
                         b.play_date,
                         b.play_time,
                         b.total_amount as booking_total
                  FROM billing_sessions bs
                  LEFT JOIN bookings b ON bs.booking_id = b.id
                  LEFT JOIN users u ON b.user_id = u.id
                  LEFT JOIN tables t ON b.table_id = t.id
                  WHERE bs.id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getBillingSessionById: " . $e->getMessage());
            return null;
        }
    }

    // Get user's active billing sessions - FIXED
    public function getUserBillingSessions($user_id) {
        $query = "SELECT bs.*, 
                         b.id as booking_id,
                         b.table_id,
                         t.name as table_name,
                         t.table_number,
                         b.play_date,
                         b.play_time
                  FROM billing_sessions bs
                  LEFT JOIN bookings b ON bs.booking_id = b.id
                  LEFT JOIN tables t ON b.table_id = t.id
                  WHERE b.user_id = :user_id AND bs.is_active = 1
                  ORDER BY bs.start_time DESC";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([':user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getUserBillingSessions: " . $e->getMessage());
            return [];
        }
    }

    // Start new billing session
    public function startBillingSession($booking_id) {
        $query = "INSERT INTO billing_sessions (booking_id, start_time, is_active, is_paused) 
                  VALUES (:booking_id, NOW(), 1, 0)";
        
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute([':booking_id' => $booking_id]);
        } catch (PDOException $e) {
            error_log("Database error in startBillingSession: " . $e->getMessage());
            return false;
        }
    }

    // Pause billing session
    public function pauseBillingSession($id) {
        $query = "UPDATE billing_sessions 
                  SET is_paused = 1, last_pause_time = NOW() 
                  WHERE id = :id AND is_active = 1";
        
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Database error in pauseBillingSession: " . $e->getMessage());
            return false;
        }
    }

    // Resume billing session
    public function resumeBillingSession($id) {
        $query = "UPDATE billing_sessions 
                  SET is_paused = 0, 
                      total_pause_duration = total_pause_duration + TIMESTAMPDIFF(SECOND, last_pause_time, NOW()),
                      last_pause_time = NULL 
                  WHERE id = :id AND is_active = 1";
        
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Database error in resumeBillingSession: " . $e->getMessage());
            return false;
        }
    }

    // Stop billing session and calculate final charge
    public function stopBillingSession($id, $rate_per_hour = 50000) {
        $session = $this->getBillingSessionById($id);
        
        if (!$session) {
            return false;
        }

        // Calculate play duration in seconds (excluding pause time)
        $end_time = date('Y-m-d H:i:s');
        $total_seconds = strtotime($end_time) - strtotime($session['start_time']);
        $play_seconds = $total_seconds - ($session['total_pause_duration'] ?? 0);
        
        // Calculate charge (convert seconds to hours)
        $play_hours = $play_seconds / 3600;
        $final_charge = $play_hours * $rate_per_hour;

        $query = "UPDATE billing_sessions 
                  SET is_active = 0, 
                      current_charge = :charge 
                  WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                ':charge' => $final_charge,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Database error in stopBillingSession: " . $e->getMessage());
            return false;
        }
    }

    // Update current charge (for real-time updates)
    public function updateCurrentCharge($id, $rate_per_hour = 50000) {
        $session = $this->getBillingSessionById($id);
        
        if (!$session || !$session['is_active']) {
            return false;
        }

        // Calculate current play duration
        $current_time = date('Y-m-d H:i:s');
        $total_seconds = strtotime($current_time) - strtotime($session['start_time']);
        
        // Subtract pause duration if currently paused
        if ($session['is_paused']) {
            $pause_duration = strtotime($current_time) - strtotime($session['last_pause_time']);
            $total_pause_duration = ($session['total_pause_duration'] ?? 0) + $pause_duration;
        } else {
            $total_pause_duration = $session['total_pause_duration'] ?? 0;
        }
        
        $play_seconds = $total_seconds - $total_pause_duration;
        $play_hours = $play_seconds / 3600;
        $current_charge = $play_hours * $rate_per_hour;

        $query = "UPDATE billing_sessions 
                  SET current_charge = :charge 
                  WHERE id = :id AND is_active = 1";
        
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                ':charge' => $current_charge,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Database error in updateCurrentCharge: " . $e->getMessage());
            return false;
        }
    }

    // Get active sessions count
    public function getActiveSessionsCount() {
        $query = "SELECT COUNT(*) as count FROM billing_sessions WHERE is_active = 1";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (PDOException $e) {
            error_log("Database error in getActiveSessionsCount: " . $e->getMessage());
            return 0;
        }
    }

    // Get total revenue from completed sessions
    public function getTotalRevenue() {
        $query = "SELECT SUM(current_charge) as total_revenue 
                  FROM billing_sessions 
                  WHERE is_active = 0 AND current_charge > 0";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_revenue'] ?? 0;
        } catch (PDOException $e) {
            error_log("Database error in getTotalRevenue: " . $e->getMessage());
            return 0;
        }
    }

    // Get billing session statistics
    public function getBillingStats() {
        $query = "SELECT 
                    COUNT(*) as total_sessions,
                    SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_sessions,
                    SUM(CASE WHEN is_active = 0 THEN current_charge ELSE 0 END) as total_revenue,
                    AVG(CASE WHEN is_active = 0 THEN current_charge ELSE NULL END) as avg_session_charge
                  FROM billing_sessions";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getBillingStats: " . $e->getMessage());
            return [
                'total_sessions' => 0,
                'active_sessions' => 0,
                'total_revenue' => 0,
                'avg_session_charge' => 0
            ];
        }
    }

    // Get session duration in readable format
    public function getSessionDuration($session_id) {
        $session = $this->getBillingSessionById($session_id);
        
        if (!$session) {
            return '0:00';
        }

        $current_time = $session['is_active'] ? date('Y-m-d H:i:s') : null;
        $end_time = $current_time ?: $session['end_time'] ?? $current_time;
        
        if (!$end_time) {
            return '0:00';
        }

        $total_seconds = strtotime($end_time) - strtotime($session['start_time']);
        $play_seconds = $total_seconds - ($session['total_pause_duration'] ?? 0);
        
        $hours = floor($play_seconds / 3600);
        $minutes = floor(($play_seconds % 3600) / 60);
        
        return sprintf("%d:%02d", $hours, $minutes);
    }

    // Get sessions by active status
    public function getSessionsByStatus($is_active = 1) {
        $query = "SELECT bs.*, 
                         u.name as user_name, 
                         b.id as booking_id,
                         t.name as table_name,
                         t.table_number
                  FROM billing_sessions bs
                  LEFT JOIN bookings b ON bs.booking_id = b.id
                  LEFT JOIN users u ON b.user_id = u.id
                  LEFT JOIN tables t ON b.table_id = t.id
                  WHERE bs.is_active = :is_active
                  ORDER BY bs.start_time DESC
                  LIMIT 5";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([':is_active' => $is_active]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getSessionsByStatus: " . $e->getMessage());
            return [];
        }
    }

    // Delete billing session
    public function deleteBilling($id) {
        $query = "DELETE FROM billing_sessions WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Database error in deleteBilling: " . $e->getMessage());
            return false;
        }
    }
    // Di models/BillingModel.php

public function getRecentSessions($limit = 5) {
    $query = "SELECT bs.*, 
                     u.name as user_name,
                     t.table_number
              FROM billing_sessions bs
              LEFT JOIN bookings b ON bs.booking_id = b.id
              LEFT JOIN users u ON b.user_id = u.id
              LEFT JOIN tables t ON b.table_id = t.id
              ORDER BY bs.start_time DESC
              LIMIT :limit";
    
    try {
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting recent sessions: " . $e->getMessage());
        return [];
    }
}

public function getActiveSessionByBooking($booking_id) {
    $query = "SELECT * FROM billing_sessions 
              WHERE booking_id = :booking_id AND is_active = 1 
              LIMIT 1";
    
    try {
        $stmt = $this->db->prepare($query);
        $stmt->execute([':booking_id' => $booking_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error in getActiveSessionByBooking: " . $e->getMessage());
        return null;
    }
}
}