<?php
class BillingController extends Controller {
    private $billingModel;
    private $bookingModel;

    public function __construct() {
        $this->billingModel = $this->model('BillingModel');
        $this->bookingModel = $this->model('BookingModel');
        // Check authentication
        if (!Auth::isLoggedIn() && !Auth::isAdmin()) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }
    
    // USER: View my billings
    public function myBillings() {
        $user_id = Auth::getUserId();
        
        $data = [
            'title' => 'Billings Saya',
            'billings' => $this->billingModel->getUserBillings($user_id)
        ];

        $this->view('billing/index', $data);
    }

    // GANTI: view() menjadi viewBilling()
    public function viewBilling($id) {
        $user_id = Auth::getUserId();
        $billing = $this->billingModel->getBillingSessionById($id);

        // Check if billing belongs to user or user is admin
        if (!$billing || ($billing['user_id'] != $user_id && !Auth::isAdmin())) {
            Flash::setFlash('Billing tidak ditemukan', 'error');
            header('Location: ' . BASE_URL . '/billing/my-billings');
            exit;
        }

        $data = [
            'title' => 'Detail Billing',
            'billing' => $billing
        ];

        // Gunakan parent::view() untuk render view
        $this->view('billing/detail', $data);
    }
    // Create billing from booking
    public function createFromBooking($booking_id) {
        if (!Auth::isAdmin()) {
            header('Location: ' . BASE_URL . '/home');
            exit;
        }

        // You need to get booking data first
        $bookingModel = $this->model('BookingModel');
        $booking = $bookingModel->getBookingById($booking_id);

        if (!$booking) {
            Flash::setFlash('Booking tidak ditemukan', 'error');
            header('Location: ' . BASE_URL . '/admin/bookings');
            exit;
        }

        $billing_data = [
            'booking_id' => $booking_id,
            'user_id' => $booking['user_id'],
            'billing_code' => $this->billingModel->generateBillingCode(),
            'amount' => $booking['total_amount'],
            'payment_method' => 'transfer', // default
            'status' => 'pending',
            'due_date' => date('Y-m-d', strtotime('+3 days')),
            'notes' => 'Billing untuk booking ' . $booking['booking_code']
        ];

        if ($this->billingModel->createBilling($billing_data)) {
            Flash::setFlash('Billing berhasil dibuat', 'success');
        } else {
            Flash::setFlash('Gagal membuat billing', 'error');
        }

        header('Location: ' . BASE_URL . '/admin/bookings');
        exit;
    }

    // Di AdminController atau BillingController - tambahkan method ini

public function userBillingView() {
    // Check if user is logged in
    if (!Auth::isLoggedIn()) {
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }

    // Get all active billing sessions with table info
    $activeSessions = $this->getActiveBillingSessionsWithTables();
    
    // Get table statistics
    $tableStats = $this->getTableStatistics();
    
    $data = [
        'title' => 'Live Table Status - Billing Sessions',
        'current_route' => 'billing/live-tables',
        'activeSessions' => $activeSessions,
        'tableStats' => $tableStats,
        'allTables' => $this->tableModel->getAllTables()
    ];
    
    $this->view('billing/live_tables', $data);
}

private function getActiveBillingSessionsWithTables() {
    $query = "SELECT 
                bs.*,
                b.id as booking_id,
                b.start_time as booking_start,
                b.duration_hours,
                t.id as table_id,
                t.table_number,
                t.name as table_name,
                t.floor_id,
                f.name as floor_name,
                u.name as customer_name,
                u.id as user_id,
                TIMESTAMPDIFF(MINUTE, bs.start_time, NOW()) - bs.total_pause_duration/60 as active_minutes,
                (TIMESTAMPDIFF(MINUTE, bs.start_time, NOW()) - bs.total_pause_duration/60) * (50000/60) as estimated_charge
              FROM billing_sessions bs
              JOIN bookings b ON bs.booking_id = b.id
              JOIN tables t ON b.table_id = t.id
              JOIN floors f ON t.floor_id = f.id
              JOIN users u ON b.user_id = u.id
              WHERE bs.is_active = 1
              ORDER BY t.floor_id, t.table_number";
    
    try {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting active billing sessions: " . $e->getMessage());
        return [];
    }
}

private function getTableStatistics() {
    $query = "SELECT 
                COUNT(*) as total_tables,
                SUM(CASE WHEN t.status = 'available' THEN 1 ELSE 0 END) as available_tables,
                SUM(CASE WHEN t.status = 'occupied' THEN 1 ELSE 0 END) as occupied_tables,
                SUM(CASE WHEN t.status = 'maintenance' THEN 1 ELSE 0 END) as maintenance_tables
              FROM tables t";
    
    try {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting table statistics: " . $e->getMessage());
        return ['total_tables' => 0, 'available_tables' => 0, 'occupied_tables' => 0, 'maintenance_tables' => 0];
    }
}
}