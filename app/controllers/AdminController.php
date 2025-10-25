<?php
// app/controllers/AdminController.php

class AdminController extends Controller {
    private $bookingModel;
    private $tableModel;
    private $userModel;
    private $paymentModel;
    private $tournamentModel;
    private $menuModel;
    private $billingModel;
    
    public function __construct() {
        parent::__construct();
        $this->requireAdmin();
        
        $this->bookingModel = new BookingModel();
        $this->tableModel = new TableModel();
        $this->userModel = new UserModel();
        $this->paymentModel = new PaymentModel();
        $this->tournamentModel = new TournamentModel();
        $this->menuModel = new MenuModel();
        $this->billingModel = new BillingModel();
    }
    
    // ========== DASHBOARD ==========
    
    public function dashboard() {
    $stats = $this->getDashboardStats();
    
    $data = [
            'title' => 'Admin Dashboard',
            'current_route' => 'admin/dashboard',
            'stats' => $stats,
            'recentBookings' => $this->bookingModel->getRecentBookings(5),
            'recentTournamentRegistrations' => $this->tournamentModel->getRecentRegistrations(5),
            'tableStatus' => $this->tableModel->getAllTables(),
            'upcomingTournaments' => $this->tournamentModel->getUpcomingTournaments(3),
            'recentProductOrders' => $this->getRecentProductOrders(),
            // Tambahkan recent billing sessions
            'activeBillingSessions' => $this->billingModel->getSessionsByStatus(1),
            'recentCompletedSessions' => $this->billingModel->getSessionsByStatus(0)
        ];
    
        $this->view('admin/dashboard', $data);
    }
    
    private function getDashboardStats() {
    // ✅ Ambil billing stats dulu
    $billingStats = $this->billingModel->getBillingStats();

    return [
        'total_bookings' => $this->bookingModel->getTotalBookings('all'),
        'active_bookings' => $this->bookingModel->getTotalBookings('active'),
        'pending_payments' => $this->paymentModel->getTotalPayments('pending'),
        'total_revenue' => $this->paymentModel->getTotalRevenue(),
        'available_tables' => $this->tableModel->getTableCountByStatus('available'),
        'occupied_tables' => $this->tableModel->getTableCountByStatus('occupied'),
        'total_tournaments' => $this->tournamentModel->getTotalTournaments('all'),
        'active_tournaments' => $this->tournamentModel->getTournamentCountByStatus('active'),
        'tournament_registrations' => $this->tournamentModel->getTotalRegistrations('pending'),
        'total_products' => $this->getTotalProducts(),
        'low_stock_products' => $this->getLowStockProducts(),
        'merchandise_revenue' => $this->getMerchandiseRevenue(),
        'food_revenue' => $this->getFoodBeverageRevenue(),
        // ✅ Sekarang aman
        'total_billing_sessions' => $billingStats['total_sessions'] ?? 0,
        'active_billing_sessions' => $billingStats['active_sessions'] ?? 0,
        'billing_revenue' => $billingStats['total_revenue'] ?? 0,
        'avg_session_charge' => $billingStats['avg_session_charge'] ?? 0
    ];
    }
    
    // ========== BOOKING MANAGEMENT ==========
    
    public function bookings() {
        $status = $this->getQuery('status', 'all');
        $page = $this->getQuery('page', 1);
        
        $bookings = $this->bookingModel->getAllBookings($status, $page);
        $totalBookings = $this->bookingModel->getTotalBookings($status);
        
        $data = [
            'title' => 'Manage Bookings',
            'current_route' => 'admin/bookings',
            'bookings' => $bookings,
            'status' => $status,
            'page' => $page,
            'totalPages' => ceil($totalBookings / 10)
        ];
        
        $this->view('admin/bookings', $data);
    }
    
    public function updateBookingStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid method'], 400);
            return;
        }
        
        $bookingId = $this->getPost('booking_id');
        $status = $this->getPost('status');
        
        if ($this->bookingModel->updateBookingStatus($bookingId, $status)) {
            $this->json(['success' => true, 'message' => 'Booking status updated']);
        } else {
            $this->json(['error' => 'Failed to update status'], 500);
        }
    }
    
    // ========== TABLE MANAGEMENT ==========
    
    public function tables() {
        $floors = $this->getFloors();
        
        $data = [
            'title' => 'Manage Tables',
            'current_route' => 'admin/tables',
            'tables' => $this->tableModel->getAllTables(),
            'floors' => $floors
        ];
        
        $this->view('admin/tables', $data);
    }
    
    public function updateTableStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid method'], 400);
            return;
        }
        
        $tableId = $this->getPost('table_id');
        $status = $this->getPost('status');
        
        if ($this->tableModel->updateTableStatus($tableId, $status)) {
            $this->json(['success' => true, 'message' => 'Table status updated']);
        } else {
            $this->json(['error' => 'Failed to update status'], 500);
        }
    }
    
    // ========== PAYMENT MANAGEMENT ==========
    
    public function payments() {
        $status = $this->getQuery('status', 'pending');
        $method = $this->getQuery('method', null);
        
        $revenueData = [];
        if ($status === 'paid') {
            $revenueData = [
                'today' => $this->paymentModel->getRevenueByDateRange(date('Y-m-d'), date('Y-m-d')),
                'week' => $this->paymentModel->getRevenueByDateRange(
                    date('Y-m-d', strtotime('-7 days')), 
                    date('Y-m-d')
                ),
                'month' => $this->paymentModel->getRevenueByDateRange(
                    date('Y-m-01'), 
                    date('Y-m-t')
                )
            ];
        }
        
        $data = [
            'title' => 'Payment Management',
            'current_route' => 'admin/payments',
            'payments' => $this->paymentModel->getPaymentsByStatus($status, $method),
            'status' => $status,
            'method' => $method,
            'totalRevenue' => $this->paymentModel->getTotalRevenue(),
            'revenueData' => $revenueData
        ];
        
        $this->view('admin/payments', $data);
    }
    
    public function updatePaymentStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid method'], 400);
            return;
        }
        
        $paymentId = $this->getPost('payment_id');
        $status = $this->getPost('status');
        
        if ($this->paymentModel->updatePaymentStatus($paymentId, $status)) {
            $this->json(['success' => true, 'message' => 'Payment status updated']);
        } else {
            $this->json(['error' => 'Failed to update payment status'], 500);
        }
    }
    
    // ========== TOURNAMENT MANAGEMENT ==========
    
    public function tournaments() {
        $status = $this->getQuery('status', 'all');
        
        $tournaments = $this->tournamentModel->getAllTournaments();
        $stats = $this->tournamentModel->getTournamentStats();
        
        if ($status !== 'all') {
            $tournaments = array_filter($tournaments, function($tournament) use ($status) {
                return $tournament['status'] === $status;
            });
        }
        
        $data = [
            'title' => 'Tournament Management',
            'current_route' => 'admin/tournaments',
            'tournaments' => $tournaments,
            'stats' => $stats,
            'status' => $status
        ];
        
        $this->view('admin/tournaments/index', $data);
    }
    
    public function tournamentCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tournamentData = [
                'name' => $this->getPost('name'),
                'type' => $this->getPost('type'),
                'entry_fee' => floatval($this->getPost('entry_fee', 0)),
                'prize_pool' => floatval($this->getPost('prize_pool', 0)),
                'max_participants' => intval($this->getPost('max_participants')),
                'registration_deadline' => $this->getPost('registration_deadline'),
                'start_date' => $this->getPost('start_date'),
                'rules' => $this->getPost('rules', ''),
                'status' => 'upcoming'
            ];

            if (empty($tournamentData['name']) || empty($tournamentData['start_date'])) {
                $_SESSION['admin_error'] = 'Name and start date are required';
                $this->redirect('admin/tournaments/create');
                return;
            }

            $tournamentData['registration_deadline'] = date('Y-m-d H:i:s', strtotime($tournamentData['registration_deadline']));
            $tournamentData['start_date'] = date('Y-m-d H:i:s', strtotime($tournamentData['start_date']));

            if ($this->tournamentModel->create($tournamentData)) {
                $_SESSION['admin_success'] = 'Tournament created successfully!';
                $this->redirect('admin/tournaments');
            } else {
                $_SESSION['admin_error'] = 'Failed to create tournament. Please try again.';
                $this->redirect('admin/tournaments/create');
            }
            return;
        }

        $data = [
            'title' => 'Create New Tournament',
            'current_route' => 'admin/tournaments'
        ];

        $this->view('admin/tournaments/create', $data);
    }
    
    public function tournamentEdit($id) {
        $tournament = $this->tournamentModel->getTournamentById($id);
        
        if (!$tournament) {
            $_SESSION['admin_error'] = 'Tournament not found';
            $this->redirect('admin/tournaments');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tournamentData = [
                'name' => $this->getPost('name'),
                'type' => $this->getPost('type'),
                'entry_fee' => floatval($this->getPost('entry_fee', 0)),
                'prize_pool' => floatval($this->getPost('prize_pool', 0)),
                'max_participants' => intval($this->getPost('max_participants')),
                'registration_deadline' => $this->getPost('registration_deadline'),
                'start_date' => $this->getPost('start_date'),
                'rules' => $this->getPost('rules', ''),
                'status' => $this->getPost('status')
            ];
            
            $tournamentData['registration_deadline'] = date('Y-m-d H:i:s', strtotime($tournamentData['registration_deadline']));
            $tournamentData['start_date'] = date('Y-m-d H:i:s', strtotime($tournamentData['start_date']));
            
            $success = $this->tournamentModel->update($id, $tournamentData);
            
            if ($success) {
                $_SESSION['admin_success'] = 'Tournament updated successfully!';
            } else {
                $_SESSION['admin_error'] = 'Failed to update tournament';
            }
            
            $this->redirect('admin/tournaments');
            return;
        }
        
        $data = [
            'title' => 'Edit Tournament - ' . $tournament['name'],
            'current_route' => 'admin/tournaments',
            'tournament' => $tournament
        ];
        
        $this->view('admin/tournaments/edit', $data);
    }
    
    public function tournamentDelete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/tournaments');
            return;
        }
        
        $success = $this->tournamentModel->delete($id);
        
        if ($success) {
            $_SESSION['admin_success'] = 'Tournament deleted successfully!';
        } else {
            $_SESSION['admin_error'] = 'Failed to delete tournament';
        }
        
        $this->redirect('admin/tournaments');
    }
    
    public function tournamentParticipants($id) {
        $tournament = $this->tournamentModel->getTournamentById($id);
        $participants = $this->tournamentModel->getTournamentRegistrations($id);
        
        if (!$tournament) {
            $_SESSION['admin_error'] = 'Tournament not found';
            $this->redirect('admin/tournaments');
            return;
        }
        
        $data = [
            'title' => 'Manage Participants - ' . $tournament['name'],
            'current_route' => 'admin/tournaments',
            'tournament' => $tournament,
            'participants' => $participants
        ];
        
        $this->view('admin/tournaments/participants', $data);
    }
    
    public function updateTournamentStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid method'], 400);
            return;
        }
        
        $tournamentId = $this->getPost('tournament_id');
        $status = $this->getPost('status');
        
        if ($this->tournamentModel->updateStatus($tournamentId, $status)) {
            $this->json(['success' => true, 'message' => 'Tournament status updated']);
        } else {
            $this->json(['error' => 'Failed to update tournament status'], 500);
        }
    }
    
    public function tournamentPayments() {
        $status = $this->getQuery('status', 'pending');
        $payments = $this->paymentModel->getPendingTournamentPayments();
        
        $data = [
            'title' => 'Tournament Payment Management',
            'current_route' => 'admin/tournaments',
            'payments' => $payments,
            'status' => $status
        ];
        
        $this->view('admin/tournaments/payments', $data);
    }
    
    public function updateTournamentPayment($paymentId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid method'], 400);
            return;
        }
        
        $status = $this->getPost('status');
        $notes = $this->getPost('notes', '');
        
        if ($this->paymentModel->updateTournamentPaymentStatus($paymentId, $status)) {
            $this->json(['success' => true, 'message' => 'Payment status updated successfully']);
        } else {
            $this->json(['error' => 'Failed to update payment status'], 500);
        }
    }
    
// ========== PRODUCT MANAGEMENT - FIXED PDO ==========
public function products() {
        $products = $this->menuModel->getAllProducts();
        $categories = $this->menuModel->getCategories();
        
        $data = [
            'title' => 'Product Management',
            'current_route' => 'admin/products',
            'products' => $products,
            'categories' => $categories
        ];
        
        $this->view('admin/products/index', $data);
    }
    
    public function productCreate() {
        $categories = ['food', 'beverage', 'snack', 'merchandise'];
        
        $data = [
            'title' => 'Add New Product',
            'current_route' => 'admin/products',
            'categories' => $categories
        ];
        
        $this->view('admin/products/create', $data);
    }

public function productStore() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('admin/products/create');
        return;
    }
    
    $name = $this->getPost('name');
    $category = $this->getPost('category');
    $price = floatval($this->getPost('price', 0));
    $stock = intval($this->getPost('stock', 0));
    $description = $this->getPost('description');
    
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Product name is required';
    }
    
    if (!in_array($category, ['food', 'beverage', 'snack', 'merchandise'])) {
        $errors[] = 'Invalid category';
    }
    
    if ($price <= 0) {
        $errors[] = 'Price must be greater than 0';
    }
    
    if ($stock < 0) {
        $errors[] = 'Stock cannot be negative';
    }
    
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        try {
            $imageName = $this->handleImageUpload($_FILES['image']);
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['old_input'] = $_POST;
        $this->redirect('admin/products/create');
        return;
    }
    
    try {
        $sql = "INSERT INTO products (name, category, price, stock, description, image, is_available) 
                VALUES (?, ?, ?, ?, ?, ?, 1)";
        
        // PERBAIKAN: Gunakan PDO prepare/execute
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $name, $category, $price, $stock, $description, $imageName
        ]);
        
        if ($result) {
            $_SESSION['admin_success'] = 'Product created successfully!';
            $this->redirect('admin/products');
        } else {
            $_SESSION['admin_error'] = 'Failed to create product';
            $this->redirect('admin/products/create');
        }
    } catch (Exception $e) {
        $_SESSION['admin_error'] = 'Database error: ' . $e->getMessage();
        $this->redirect('admin/products/create');
    }
}

public function productUpdate($productId) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('admin/products');
        return;
    }
    
    $product = $this->menuModel->getProductById($productId);
    if (!$product) {
        $_SESSION['admin_error'] = 'Product not found';
        $this->redirect('admin/products');
        return;
    }
    
    $name = $this->getPost('name');
    $category = $this->getPost('category');
    $price = floatval($this->getPost('price', 0));
    $stock = intval($this->getPost('stock', 0));
    $description = $this->getPost('description');
    $isAvailable = $this->getPost('is_available') ? 1 : 0;
    
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Product name is required';
    }
    
    if (!in_array($category, ['food', 'beverage', 'snack', 'merchandise'])) {
        $errors[] = 'Invalid category';
    }
    
    if ($price <= 0) {
        $errors[] = 'Price must be greater than 0';
    }
    
    if ($stock < 0) {
        $errors[] = 'Stock cannot be negative';
    }
    
    $imageName = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        try {
            if ($imageName) {
                $this->deleteImage($imageName);
            }
            $imageName = $this->handleImageUpload($_FILES['image']);
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
    
    if ($this->getPost('remove_image')) {
        if ($imageName) {
            $this->deleteImage($imageName);
        }
        $imageName = null;
    }
    
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['old_input'] = $_POST;
        $this->redirect('admin/products/edit/' . $productId);
        return;
    }
    
    try {
        $sql = "UPDATE products SET name = ?, category = ?, price = ?, stock = ?, 
                description = ?, image = ?, is_available = ? WHERE id = ?";
        
        // PERBAIKAN: Gunakan PDO prepare/execute
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $name, $category, $price, $stock, $description, $imageName, $isAvailable, $productId
        ]);
        
        if ($result) {
            $_SESSION['admin_success'] = 'Product updated successfully!';
            $this->redirect('admin/products');
        } else {
            $_SESSION['admin_error'] = 'Failed to update product';
            $this->redirect('admin/products/edit/' . $productId);
        }
    } catch (Exception $e) {
        $_SESSION['admin_error'] = 'Database error: ' . $e->getMessage();
        $this->redirect('admin/products/edit/' . $productId);
    }
}

public function productDelete($productId) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('admin/products');
        return;
    }
    
    $product = $this->menuModel->getProductById($productId);
    
    if (!$product) {
        $_SESSION['admin_error'] = 'Product not found';
        $this->redirect('admin/products');
        return;
    }
    
    try {
        if ($product['image']) {
            $this->deleteImage($product['image']);
        }
        
        $sql = "DELETE FROM products WHERE id = ?";
        
        // PERBAIKAN: Gunakan PDO prepare/execute
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$productId]);
        
        if ($result) {
            $_SESSION['admin_success'] = 'Product deleted successfully!';
        } else {
            $_SESSION['admin_error'] = 'Failed to delete product';
        }
    } catch (Exception $e) {
        $_SESSION['admin_error'] = 'Database error: ' . $e->getMessage();
    }
    
    $this->redirect('admin/products');
}

public function productStock($productId) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('admin/products');
        return;
    }
    
    $stock = intval($this->getPost('stock', 0));
    
    if ($stock < 0) {
        $_SESSION['admin_error'] = 'Stock cannot be negative';
        $this->redirect('admin/products');
        return;
    }
    
    try {
        $sql = "UPDATE products SET stock = ? WHERE id = ?";
        
        // PERBAIKAN: Gunakan PDO prepare/execute
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$stock, $productId]);
        
        if ($result) {
            $_SESSION['admin_success'] = 'Stock updated successfully!';
        } else {
            $_SESSION['admin_error'] = 'Failed to update stock';
        }
    } catch (Exception $e) {
        $_SESSION['admin_error'] = 'Database error: ' . $e->getMessage();
    }
    
    $this->redirect('admin/products');
}
    
    // ========== USER MANAGEMENT ==========
    
    public function users() {
        $users = $this->userModel->getAllUsers();
        
        $data = [
            'title' => 'User Management',
            'current_route' => 'admin/users',
            'users' => $users
        ];
        
        $this->view('admin/users/index', $data);
    }
    
    // ========== BILLING MANAGEMENT ==========

public function billings() {
    // Main billing dashboard
    $stats = $this->getBillingOverviewStats();
    
    $data = [
        'title' => 'Billing Management',
        'current_route' => 'admin/billings',
        'stats' => $stats,
        'recentSessions' => $this->billingModel->getRecentSessions(5),
        'recentInvoices' => $this->getRecentInvoices(5)
    ];
    
    $this->view('admin/billing/dashboard', $data);
}

public function billingSessions() {
    $status = $this->getQuery('status', 'active');
    
    $sessions = $this->billingModel->getAllBillingSessions();
    
    // Filter by status
    if ($status === 'active') {
        $sessions = array_filter($sessions, function($session) {
            return $session['is_active'] == 1;
        });
    } elseif ($status === 'completed') {
        $sessions = array_filter($sessions, function($session) {
            return $session['is_active'] == 0;
        });
    } elseif ($status === 'paused') {
        $sessions = array_filter($sessions, function($session) {
            return $session['is_active'] == 1 && $session['is_paused'] == 1;
        });
    }
    
    $stats = $this->billingModel->getBillingStats();
    
    $data = [
        'title' => 'Billing Sessions',
        'current_route' => 'admin/billings/sessions',
        'sessions' => $sessions,
        'stats' => $stats,
        'status' => $status
    ];
    
    $this->view('admin/billing/sessions', $data);
}

public function billingSession($id) {
    $session = $this->billingModel->getBillingSessionById($id);
    
    if (!$session) {
        $_SESSION['admin_error'] = 'Billing session not found';
        $this->redirect('admin/billings/sessions');
        return;
    }
    
    $data = [
        'title' => 'Billing Session - #' . $id,
        'current_route' => 'admin/billings/sessions',
        'session' => $session,
        'duration' => $this->billingModel->getSessionDuration($id)
    ];
    
    $this->view('admin/billing/session_detail', $data);
}

public function billingReports() {
    $data = [
        'title' => 'Billing Reports',
        'current_route' => 'admin/billings/reports'
    ];
    
    $this->view('admin/billing/reports', $data);
}

// ========== BILLING CREATION ==========

public function createBillingFromBooking($booking_id) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        if ($this->isAjax()) {
            $this->json(['success' => false, 'error' => 'Invalid request method'], 400);
        } else {
            $this->redirect('admin/bookings');
        }
        return;
    }

    $booking = $this->bookingModel->getBookingById($booking_id);

    if (!$booking) {
        if ($this->isAjax()) {
            $this->json(['success' => false, 'error' => 'Booking not found']);
        } else {
            $_SESSION['admin_error'] = 'Booking not found';
            $this->redirect('admin/bookings');
        }
        return;
    }

    $existingSession = $this->billingModel->getActiveSessionByBooking($booking_id);
    if ($existingSession) {
        if ($this->isAjax()) {
            $this->json(['success' => false, 'error' => 'Billing session already exists for this booking']);
        } else {
            $_SESSION['admin_error'] = 'Billing session already exists for this booking';
            $this->redirect('admin/bookings');
        }
        return;
    }

    $sessionCreated = $this->billingModel->startBillingSession($booking_id);

    if ($sessionCreated) {
        if ($this->isAjax()) {
            // ✅ KIRIM DURASI UNTUK COUNTDOWN
            $this->json([
                'success' => true,
                'duration_hours' => (int)($booking['duration_hours'] ?? 1)
            ]);
        } else {
            $_SESSION['admin_success'] = 'Billing session created successfully!';
            $this->redirect('admin/bookings');
        }
    } else {
        if ($this->isAjax()) {
            $this->json(['success' => false, 'error' => 'Failed to create billing session']);
        } else {
            $_SESSION['admin_error'] = 'Failed to create billing session';
            $this->redirect('admin/bookings');
        }
    }
}

public function bookingsWithoutBilling() {
    $query = "SELECT b.*, u.name as user_name, t.table_number 
              FROM bookings b
              LEFT JOIN users u ON b.user_id = u.id
              LEFT JOIN tables t ON b.table_id = t.id
              WHERE b.id NOT IN (SELECT booking_id FROM billing_sessions WHERE is_active = 1)
              AND b.status = 'confirmed'
              ORDER BY b.play_date DESC, b.play_time DESC";
    
    try {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting bookings without billing: " . $e->getMessage());
        $bookings = [];
    }
    
    $data = [
        'title' => 'Bookings Without Billing Sessions',
        'current_route' => 'admin/bookings',
        'bookings' => $bookings
    ];
    
    $this->view('admin/bookings/without_billing', $data);
}

// ========== BILLING HELPER METHODS ==========

private function getBillingOverviewStats() {
    $sessionStats = $this->billingModel->getBillingStats();
    
    return [
        'total_sessions' => $sessionStats['total_sessions'] ?? 0,
        'active_sessions' => $sessionStats['active_sessions'] ?? 0,
        'total_revenue' => $sessionStats['total_revenue'] ?? 0,
        'avg_session_charge' => $sessionStats['avg_session_charge'] ?? 0
    ];
}

private function getRecentInvoices($limit = 5) {
    $query = "SELECT bs.*, 
                     u.name as customer_name,
                     t.table_number
              FROM billing_sessions bs
              LEFT JOIN bookings b ON bs.booking_id = b.id
              LEFT JOIN users u ON b.user_id = u.id
              LEFT JOIN tables t ON b.table_id = t.id
              WHERE bs.is_active = 0 AND bs.current_charge > 0
              ORDER BY bs.start_time DESC
              LIMIT :limit";
    
    try {
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting recent invoices: " . $e->getMessage());
        return [];
    }
}
    
// ========== HELPER METHODS - USING MODELS ==========

private function getFloors() {
    $sql = "SELECT * FROM floors ORDER BY floor_number";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

private function getTotalProducts() {
    $products = $this->menuModel->getAllProducts();
    return count($products);
}

private function getLowStockProducts() {
    $products = $this->menuModel->getLowStockProducts(5);
    return count($products);
}

private function getMerchandiseRevenue() {
    // Gunakan approach yang sama dengan model
    $sql = "SELECT SUM(oi.total_price) as revenue 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE p.category = 'merchandise'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['revenue'] ?? 0;
}

private function getFoodBeverageRevenue() {
    $sql = "SELECT SUM(oi.total_price) as revenue 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE p.category IN ('food', 'beverage', 'snack')";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['revenue'] ?? 0;
}

private function getRecentProductOrders() {
    // PERBAIKAN: Gunakan kolom yang sesuai dengan struktur database
    $sql = "SELECT o.id, 
                   COALESCE(b.customer_name, 'Walk-in Customer') as customer_name, 
                   o.total_amount, 
                   o.status, 
                   o.created_at,
                   COUNT(oi.id) as item_count
            FROM orders o
            LEFT JOIN order_items oi ON o.id = oi.order_id
            LEFT JOIN bookings b ON o.booking_id = b.id
            WHERE oi.product_id IS NOT NULL
            GROUP BY o.id
            ORDER BY o.created_at DESC
            LIMIT 5";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
private function getActiveBillingSessions() {
    $sql = "SELECT bs.*, b.customer_name, t.table_number 
            FROM billing_sessions bs
            JOIN bookings b ON bs.booking_id = b.id
            JOIN tables t ON b.table_id = t.id
            WHERE bs.is_active = 1";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

private function getRevenueReport($range) {
    $today = date('Y-m-d');
    
    switch ($range) {
        case 'today':
            $startDate = $today;
            $endDate = $today;
            break;
        case 'week':
            $startDate = date('Y-m-d', strtotime('-7 days'));
            $endDate = $today;
            break;
        case 'month':
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t');
            break;
        default:
            $startDate = $today;
            $endDate = $today;
    }
    
    return [
        'total' => $this->getRevenueByDateRange($startDate, $endDate),
        'booking' => $this->getBookingRevenueByDateRange($startDate, $endDate),
        'merchandise' => $this->getMerchandiseRevenueByDateRange($startDate, $endDate),
        'tournament' => $this->getTournamentRevenueByDateRange($startDate, $endDate)
    ];
}

private function getRevenueByDateRange($startDate, $endDate) {
    $sql = "SELECT SUM(amount) as revenue FROM payments 
            WHERE status = 'paid' AND DATE(paid_at) BETWEEN ? AND ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$startDate, $endDate]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['revenue'] ?? 0;
}

private function getBookingRevenueByDateRange($startDate, $endDate) {
    $sql = "SELECT SUM(amount) as revenue FROM payments 
            WHERE status = 'paid' AND booking_id IS NOT NULL 
            AND DATE(paid_at) BETWEEN ? AND ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$startDate, $endDate]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['revenue'] ?? 0;
}

private function getMerchandiseRevenueByDateRange($startDate, $endDate) {
    $sql = "SELECT SUM(oi.total_price) as revenue 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            JOIN orders o ON oi.order_id = o.id
            WHERE p.category = 'merchandise' 
            AND DATE(o.created_at) BETWEEN ? AND ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$startDate, $endDate]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['revenue'] ?? 0;
}

private function getTournamentRevenueByDateRange($startDate, $endDate) {
    $sql = "SELECT SUM(amount) as revenue FROM tournament_payments 
            WHERE status = 'paid' AND DATE(paid_at) BETWEEN ? AND ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$startDate, $endDate]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['revenue'] ?? 0;
}

private function handleImageUpload($file) {
    $uploadDir = APP_PATH . '../../public/assets/images/products/';
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileType = mime_content_type($file['tmp_name']);
    
    if (!in_array($fileType, $allowedTypes)) {
        throw new Exception('Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.');
    }
    
    if ($file['size'] > 2 * 1024 * 1024) {
        throw new Exception('File size too large. Maximum size is 2MB.');
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'product_' . time() . '_' . uniqid() . '.' . $extension;
    $filepath = $uploadDir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return $filename;
    } else {
        throw new Exception('Failed to upload image.');
    }
}

private function deleteImage($filename) {
    $filepath = APP_PATH . '../../public/assets/images/products/' . $filename;
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}

}
?>