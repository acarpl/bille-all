<?php
class PaymentModel extends Model {
    
    public function createPayment($paymentData) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO payments (booking_id, amount, payment_method, status, created_at) 
                 VALUES (?, ?, ?, ?, NOW())"
            );
            
            return $stmt->execute([
                $paymentData['booking_id'],
                $paymentData['amount'],
                $paymentData['payment_method'],
                $paymentData['status'] ?? 'pending'
            ]);
        } catch (PDOException $e) {
            error_log("Create payment error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getPaymentsByStatus($status = 'pending', $method = null) {
        try {
            $sql = "SELECT p.*, 
                           b.customer_name, b.id as booking_id,
                           t.table_number, 
                           u.name as user_name
                    FROM payments p
                    JOIN bookings b ON p.booking_id = b.id
                    JOIN tables t ON b.table_id = t.id
                    JOIN users u ON b.user_id = u.id
                    WHERE p.status = ?";
            
            $params = [$status];
            
            if ($method) {
                $sql .= " AND p.payment_method = ?";
                $params[] = $method;
            }
            
            $sql .= " ORDER BY p.created_at DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get payments by status error: " . $e->getMessage());
            return [];
        }
    }

    public function getUserPayments($userId) {
        try {
            $sql = "SELECT p.*, b.customer_name, t.table_number
                    FROM payments p
                    JOIN bookings b ON p.booking_id = b.id
                    JOIN tables t ON b.table_id = t.id
                    WHERE b.user_id = ?
                    ORDER BY p.created_at DESC
                    LIMIT 10";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get user payments error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getTotalPayments($status = null) {
        try {
            $sql = "SELECT COUNT(*) as total FROM payments";
            $params = [];
            
            if ($status) {
                $sql .= " WHERE status = ?";
                $params[] = $status;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch();
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get total payments error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getTotalRevenue() {
        try {
            $sql = "SELECT COALESCE(SUM(amount), 0) as revenue 
                    FROM payments 
                    WHERE status = 'paid'";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['revenue'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get total revenue error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function updatePaymentStatus($paymentId, $status) {
        try {
            $sql = "UPDATE payments SET status = ?, paid_at = ? WHERE id = ?";
            $paidAt = $status === 'paid' ? date('Y-m-d H:i:s') : null;
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $paidAt, $paymentId]);
        } catch (PDOException $e) {
            error_log("Update payment status error: " . $e->getMessage());
            return false;
        }
    }
    
    // Get payments with date range for statistics
    public function getRevenueByDateRange($startDate, $endDate) {
        try {
            $sql = "SELECT COALESCE(SUM(amount), 0) as revenue 
                    FROM payments 
                    WHERE status = 'paid' 
                    AND DATE(paid_at) BETWEEN ? AND ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
            $result = $stmt->fetch();
            return $result['revenue'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get revenue by date range error: " . $e->getMessage());
            return 0;
        }
    }

    // ==================== TOURNAMENT PAYMENT METHODS ====================
    
    public function createTournamentPayment($registrationId, $amount, $paymentMethod) {
        try {
            $paymentCode = $this->generatePaymentCode();
            $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
            
            $stmt = $this->db->prepare(
                "INSERT INTO tournament_payments 
                 (registration_id, amount, payment_method, payment_code, expires_at, created_at) 
                 VALUES (?, ?, ?, ?, ?, NOW())"
            );
            
            $success = $stmt->execute([
                $registrationId, 
                $amount, 
                $paymentMethod,
                $paymentCode,
                $expiresAt
            ]);
            
            if ($success) {
                $paymentId = $this->db->lastInsertId();
                
                // Update registration dengan payment_id
                $updateStmt = $this->db->prepare(
                    "UPDATE tournament_registrations SET payment_id = ? WHERE id = ?"
                );
                $updateStmt->execute([$paymentId, $registrationId]);
                
                return $paymentId;
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Create tournament payment error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getPaymentById($paymentId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT tp.*, tr.team_name, tr.total_fee, tr.player_count, t.name as tournament_name,
                        u.name as user_name, u.email, u.phone
                 FROM tournament_payments tp
                 JOIN tournament_registrations tr ON tp.registration_id = tr.id
                 JOIN tournaments t ON tr.tournament_id = t.id
                 JOIN users u ON tr.user_id = u.id
                 WHERE tp.id = ?"
            );
            $stmt->execute([$paymentId]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get payment by ID error: " . $e->getMessage());
            return null;
        }
    }
    
    public function updateTournamentPaymentStatus($paymentId, $status, $proofPath = null) {
        try {
            $paidAt = $status === 'paid' ? date('Y-m-d H:i:s') : null;
            
            $stmt = $this->db->prepare(
                "UPDATE tournament_payments 
                 SET status = ?, payment_proof = ?, paid_at = ?
                 WHERE id = ?"
            );
            
            $success = $stmt->execute([$status, $proofPath, $paidAt, $paymentId]);
            
            if ($success && $status === 'paid') {
                // Update registration payment_status
                $updateStmt = $this->db->prepare(
                    "UPDATE tournament_registrations tr
                     JOIN tournament_payments tp ON tr.payment_id = tp.id
                     SET tr.payment_status = 'paid'
                     WHERE tp.id = ?"
                );
                $updateStmt->execute([$paymentId]);
            }
            
            return $success;
        } catch (PDOException $e) {
            error_log("Update tournament payment status error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getUserTournamentPayments($userId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT tp.*, tr.team_name, t.name as tournament_name, t.start_date
                 FROM tournament_payments tp
                 JOIN tournament_registrations tr ON tp.registration_id = tr.id
                 JOIN tournaments t ON tr.tournament_id = t.id
                 WHERE tr.user_id = ?
                 ORDER BY tp.created_at DESC"
            );
            $stmt->execute([$userId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get user tournament payments error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getPendingTournamentPayments() {
        try {
            $stmt = $this->db->prepare(
                "SELECT tp.*, tr.team_name, t.name as tournament_name, 
                        u.name as user_name, u.email
                 FROM tournament_payments tp
                 JOIN tournament_registrations tr ON tp.registration_id = tr.id
                 JOIN tournaments t ON tr.tournament_id = t.id
                 JOIN users u ON tr.user_id = u.id
                 WHERE tp.status = 'pending'
                 ORDER BY tp.created_at DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get pending tournament payments error: " . $e->getMessage());
            return [];
        }
    }
    
    private function generatePaymentCode() {
        return 'TRN' . date('Ymd') . strtoupper(substr(uniqid(), -6));
    }

    // ==================== PAYMENT STATISTICS ====================
    
    public function getPaymentStats() {
        try {
            $stmt = $this->db->prepare(
                "SELECT 
                    COUNT(*) as total_payments,
                    SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_payments,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_payments,
                    SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed_payments,
                    COALESCE(SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END), 0) as total_revenue
                 FROM payments"
            );
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get payment stats error: " . $e->getMessage());
            return [
                'total_payments' => 0,
                'paid_payments' => 0,
                'pending_payments' => 0,
                'failed_payments' => 0,
                'total_revenue' => 0
            ];
        }
    }

    public function getTournamentPaymentStats() {
        try {
            $stmt = $this->db->prepare(
                "SELECT 
                    COUNT(*) as total_payments,
                    SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_payments,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_payments,
                    COALESCE(SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END), 0) as total_revenue
                 FROM tournament_payments"
            );
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Get tournament payment stats error: " . $e->getMessage());
            return [
                'total_payments' => 0,
                'paid_payments' => 0,
                'pending_payments' => 0,
                'total_revenue' => 0
            ];
        }
    }
}
?>