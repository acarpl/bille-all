<?php
// app/models/TournamentModel.php

class TournamentModel extends Model {
    protected $table = 'tournaments';
    protected $primaryKey = 'id';
   
    // ==================== BASIC TOURNAMENT METHODS ====================
    
    public function getAllTournaments() {
        try {
            $stmt = $this->db->prepare(
                "SELECT t.*, 
                        (SELECT COUNT(*) FROM tournament_registrations tr WHERE tr.tournament_id = t.id) as participants_count
                 FROM tournaments t 
                 ORDER BY t.created_at DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all tournaments error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getTournamentById($id) {
    $stmt = $this->db->prepare("SELECT * FROM tournaments WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

    public function getTournamentWithParticipants($id) {
        $tournament = $this->getTournamentById($id);
        if ($tournament) {
            $tournament['participants_count'] = $this->countTournamentRegistrations($id);
        }
        return $tournament;
    }
    
    public function getUpcomingTournaments($limit = null) {
        try {
            $sql = "SELECT t.*, 
                           (SELECT COUNT(*) FROM tournament_registrations tr WHERE tr.tournament_id = t.id) as participants_count
                    FROM tournaments t 
                    WHERE t.status = 'upcoming' AND t.start_date > NOW() 
                    ORDER BY t.start_date ASC";
            
            if ($limit) {
                $sql .= " LIMIT ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$limit]);
            } else {
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
            }
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get upcoming tournaments error: " . $e->getMessage());
            return [];
        }
    }
    
    public function getActiveTournaments() {
        try {
            $stmt = $this->db->prepare(
                "SELECT t.*, 
                        (SELECT COUNT(*) FROM tournament_registrations tr WHERE tr.tournament_id = t.id) as participants_count
                 FROM tournaments t 
                 WHERE t.status = 'ongoing' 
                 ORDER BY t.start_date ASC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active tournaments error: " . $e->getMessage());
            return [];
        }
    }
    
    // ==================== TOURNAMENT STATISTICS ====================
    
    public function getTournamentStats() {
        try {
            $stmt = $this->db->prepare(
                "SELECT 
                    COUNT(*) as total_tournaments,
                    SUM(CASE WHEN status = 'ongoing' THEN 1 ELSE 0 END) as active_tournaments,
                    SUM(CASE WHEN status = 'upcoming' THEN 1 ELSE 0 END) as upcoming_tournaments,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_tournaments,
                    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_tournaments,
                    (SELECT COUNT(*) FROM tournament_registrations) as total_registrations,
                    (SELECT COALESCE(SUM(entry_fee), 0) FROM tournaments WHERE status IN ('ongoing', 'completed')) as total_revenue
                 FROM tournaments"
            );
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get tournament stats error: " . $e->getMessage());
            return [
                'total_tournaments' => 0,
                'active_tournaments' => 0,
                'upcoming_tournaments' => 0,
                'completed_tournaments' => 0,
                'cancelled_tournaments' => 0,
                'total_registrations' => 0,
                'total_revenue' => 0
            ];
        }
    }
    
    public function getTotalTournaments() {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM tournaments");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Get total tournaments error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getTournamentCountByStatus($status) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM tournaments WHERE status = ?");
            $stmt->execute([$status]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Get tournament count by status error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getTotalRegistrations() {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM tournament_registrations");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Get total registrations error: " . $e->getMessage());
            return 0;
        }
    }
    
    // ==================== REGISTRATION METHODS ====================
    
    public function isUserRegistered($tournamentId, $userId) {
    $stmt = $this->db->prepare(
        "SELECT COUNT(*) FROM tournament_registrations WHERE tournament_id = ? AND user_id = ?"
    );
    $stmt->execute([$tournamentId, $userId]);
    return $stmt->fetchColumn() > 0;
}

    
    public function getTournamentRegistrations($tournamentId) {
    $stmt = $this->db->prepare(
        "SELECT tr.*, u.name as user_name, u.email, u.phone 
         FROM tournament_registrations tr 
         LEFT JOIN users u ON tr.user_id = u.id 
         WHERE tr.tournament_id = ? 
         ORDER BY tr.created_at ASC"
    );
    $stmt->execute([$tournamentId]);
    return $stmt->fetchAll();
}

    public function getUserRegistrations($userId) {
    try {
        $stmt = $this->db->prepare(
            "SELECT 
                tr.*, 
                t.name as tournament_name, 
                t.start_date, 
                t.prize_pool, 
                t.status as tournament_status,
                t.registration_deadline,
                COALESCE(tp.status, 'pending') as payment_status,
                tp.amount as paid_amount,
                tp.id as payment_id
             FROM tournament_registrations tr 
             JOIN tournaments t ON tr.tournament_id = t.id 
             LEFT JOIN tournament_payments tp ON tr.payment_id = tp.id
             WHERE tr.user_id = ? 
             ORDER BY t.start_date DESC"
        );
        $stmt->execute([$userId]);
        $registrations = $stmt->fetchAll();
        
        // Debug: Log hasil query
        error_log("User Registrations for user $userId: " . print_r($registrations, true));
        
        return $registrations;
    } catch (PDOException $e) {
        error_log("Get user registrations error: " . $e->getMessage());
        return [];
    }
}

public function countTournamentRegistrations($tournamentId) {
    try {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tournament_registrations WHERE tournament_id = ?");
        $stmt->execute([$tournamentId]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Count registrations error: " . $e->getMessage());
        return 0;
    }
}
    
    public function getRecentRegistrations($limit = 5) {
        try {
            $stmt = $this->db->prepare(
                "SELECT tr.*, t.name as tournament_name, u.name as user_name 
                 FROM tournament_registrations tr 
                 JOIN tournaments t ON tr.tournament_id = t.id 
                 LEFT JOIN users u ON tr.user_id = u.id 
                 ORDER BY tr.created_at DESC 
                 LIMIT ?"
            );
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get recent registrations error: " . $e->getMessage());
            return [];
        }
    }
    
    public function registerPlayer($tournamentId, $userId, $teamName, $playerCount) {
        try {
            // Get tournament entry fee
            $tournament = $this->getTournamentById($tournamentId);
            if (!$tournament) {
                return false;
            }
            
            $totalFee = $tournament['entry_fee'] * $playerCount;
            
            $stmt = $this->db->prepare(
                "INSERT INTO tournament_registrations 
                 (tournament_id, user_id, team_name, player_count, total_fee, created_at) 
                 VALUES (?, ?, ?, ?, ?, NOW())"
            );
            return $stmt->execute([$tournamentId, $userId, $teamName, $playerCount, $totalFee]);
        } catch (PDOException $e) {
            error_log("Register player error: " . $e->getMessage());
            return false;
        }
    }
    
    // ==================== ADMIN CRUD METHODS ====================
    
    public function create($data) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO tournaments 
                 (name, type, entry_fee, prize_pool, max_participants, 
                  registration_deadline, start_date, rules, status, created_at) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())"
            );
            
            $success = $stmt->execute([
                $data['name'],
                $data['type'],
                $data['entry_fee'] ?? 0,
                $data['prize_pool'] ?? 0,
                $data['max_participants'],
                $data['registration_deadline'],
                $data['start_date'],
                $data['rules'] ?? '',
                $data['status'] ?? 'upcoming'
            ]);
            
            return $success ? $this->db->lastInsertId() : false;
            
        } catch (PDOException $e) {
            error_log("Create tournament error: " . $e->getMessage());
            return false;
        }
    }
    
    public function update($id, $data) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE tournaments SET 
                 name = ?, type = ?, entry_fee = ?, prize_pool = ?, 
                 max_participants = ?, registration_deadline = ?, start_date = ?, 
                 rules = ?, status = ?
                 WHERE id = ?"
            );
            
            return $stmt->execute([
                $data['name'],
                $data['type'],
                $data['entry_fee'] ?? 0,
                $data['prize_pool'] ?? 0,
                $data['max_participants'],
                $data['registration_deadline'],
                $data['start_date'],
                $data['rules'] ?? '',
                $data['status'] ?? 'upcoming',
                $id
            ]);
        } catch (PDOException $e) {
            error_log("Update tournament error: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM tournaments WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete tournament error: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateStatus($id, $status) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE tournaments SET status = ? WHERE id = ?"
            );
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            error_log("Update tournament status error: " . $e->getMessage());
            return false;
        }
    }
    
    // ==================== USER METHODS ====================
    
    public function cancelRegistration($registrationId, $userId) {
        try {
            $stmt = $this->db->prepare(
                "DELETE FROM tournament_registrations 
                 WHERE id = ? AND user_id = ?"
            );
            return $stmt->execute([$registrationId, $userId]);
        } catch (PDOException $e) {
            error_log("Cancel registration error: " . $e->getMessage());
            return false;
        }
    }
    
    // ==================== PAYMENT METHODS ====================
    
    public function updatePaymentStatus($registrationId, $status) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE tournament_registrations SET payment_status = ? WHERE id = ?"
            );
            return $stmt->execute([$status, $registrationId]);
        } catch (PDOException $e) {
            error_log("Update payment status error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getPendingPayments() {
        try {
            $stmt = $this->db->prepare(
                "SELECT tr.*, t.name as tournament_name, u.name as user_name, u.email
                 FROM tournament_registrations tr 
                 JOIN tournaments t ON tr.tournament_id = t.id 
                 JOIN users u ON tr.user_id = u.id 
                 WHERE tr.payment_status = 'pending'
                 ORDER BY tr.created_at DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get pending payments error: " . $e->getMessage());
            return [];
        }
    }
    
    // ==================== VALIDATION METHODS ====================
    
    public function isTournamentFull($tournamentId) {
        try {
            $tournament = $this->getTournamentById($tournamentId);
            if (!$tournament) return true;
            
            $currentParticipants = $this->countTournamentRegistrations($tournamentId);
            return $currentParticipants >= $tournament['max_participants'];
        } catch (PDOException $e) {
            error_log("Check tournament full error: " . $e->getMessage());
            return true;
        }
    }
    
    public function isRegistrationOpen($tournamentId) {
        try {
            $tournament = $this->getTournamentById($tournamentId);
            if (!$tournament) return false;
            
            $deadline = strtotime($tournament['registration_deadline']);
            return $deadline > time();
        } catch (PDOException $e) {
            error_log("Check registration open error: " . $e->getMessage());
            return false;
        }
    }

    // Tambahkan method ini ke TournamentModel
// TournamentModel.php - Fix method
public function getRegistrationById($registrationId) {
    try {
        error_log("=== getRegistrationById Called ===");
        error_log("Registration ID: " . $registrationId);
        
        $stmt = $this->db->prepare(
            "SELECT 
                tr.*, 
                t.name as tournament_name, 
                t.start_date, 
                t.registration_deadline,
                t.status as tournament_status,
                u.name as user_name, 
                u.email,
                p.status as payment_status,
                p.id as payment_id
             FROM tournament_registrations tr
             JOIN tournaments t ON tr.tournament_id = t.id
             JOIN users u ON tr.user_id = u.id
             LEFT JOIN payments p ON tr.payment_id = p.id
             WHERE tr.id = ?"
        );
        $stmt->execute([$registrationId]);
        $result = $stmt->fetch();
        
        error_log("Query Result: " . ($result ? 'FOUND' : 'NOT FOUND'));
        if ($result) {
            error_log("Registration Data: " . print_r($result, true));
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Get registration by ID error: " . $e->getMessage());
        return null;
    }
}

public function updateRegistrationPaymentStatus($registrationId, $status) {
    try {
        $stmt = $this->db->prepare(
            "UPDATE tournament_registrations SET payment_status = ? WHERE id = ?"
        );
        return $stmt->execute([$status, $registrationId]);
    } catch (PDOException $e) {
        error_log("Update registration payment status error: " . $e->getMessage());
        return false;
    }
}
}
?>