<?php
// app/controllers/BookingController.php

class BookingController extends Controller {
    private $tableModel;
    private $packageModel;
    private $bookingModel;
    private $paymentModel;
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        
        $this->tableModel = new TableModel();
        $this->packageModel = new PackageModel();
        $this->bookingModel = new BookingModel();
        $this->paymentModel = new PaymentModel();
    }
    
    public function index() {
        $data = [
            'title' => 'Book a Table',
            'current_route' => 'booking'
        ];
        
        $this->view('booking/index', $data);
    }
    
    public function checkAvailability() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid request method'], 400);
            return;
        }
        
        $date = $this->getPost('date');
        $startTime = $this->getPost('start_time');
        $duration = $this->getPost('duration', 1);
        
        // Validasi input
        if (empty($date) || empty($startTime)) {
            $this->json(['error' => 'Date and time are required'], 400);
            return;
        }
        
        // Cek tables available
        $availableTables = $this->tableModel->getAvailableTables($date, $startTime, $duration);
        
        // Get available packages untuk waktu tersebut
        $availablePackages = $this->packageModel->getAvailablePackages($date, $startTime);
        
        $this->json([
            'success' => true,
            'tables' => $availableTables,
            'packages' => $availablePackages,
            'search_params' => [
                'date' => $date,
                'start_time' => $startTime,
                'duration' => $duration
            ]
        ]);
    }
    
    public function calculatePrice() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid request method'], 400);
            return;
        }
        
        $tableId = $this->getPost('table_id');
        $packageId = $this->getPost('package_id');
        $duration = $this->getPost('duration', 1);
        
        $table = $this->tableModel->getTableWithFloor($tableId);
        $totalPrice = $this->packageModel->calculatePackagePrice($packageId, $duration, $table['hourly_rate']);
        
        $this->json([
            'success' => true,
            'total_price' => $totalPrice,
            'formatted_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
            'table' => $table,
            'duration' => $duration
        ]);
    }
    public function create() {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->redirect('booking');
                return;
            }
            
            $userId = Auth::id();
            $tableId = $this->getPost('table_id');
            $packageId = $this->getPost('package_id');
            $date = $this->getPost('date');
            $startTime = $this->getPost('start_time');
            $duration = $this->getPost('duration', 1);
            $customerName = $this->getPost('customer_name');
            
            // Validasi
            $errors = [];
            if (empty($tableId)) $errors[] = 'Table selection is required';
            if (empty($packageId)) $errors[] = 'Package selection is required';
            if (empty($date)) $errors[] = 'Date is required';
            if (empty($startTime)) $errors[] = 'Start time is required';
            if (empty($customerName)) $errors[] = 'Customer name is required';
            
            if (!empty($errors)) {
                $_SESSION['booking_error'] = implode(', ', $errors);
                $this->redirect('booking');
                return;
            }
            
            $startDateTime = $date . ' ' . $startTime;
            
            // Cek availability
            $isAvailable = $this->bookingModel->checkTableAvailability($tableId, $startDateTime, $duration);
            
            if (!$isAvailable) {
                $_SESSION['booking_error'] = 'Selected table is no longer available for the chosen time';
                $this->redirect('booking');
                return;
            }
            
            // Calculate price
            $table = $this->tableModel->getTableWithFloor($tableId);
            $totalPrice = $this->packageModel->calculatePackagePrice($packageId, $duration, $table['hourly_rate']);
            
            // Create booking
            $bookingData = [
                'user_id' => $userId,
                'table_id' => $tableId,
                'floor_id' => $table['floor_id'],
                'package_id' => $packageId,
                'customer_name' => $customerName,
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,          // ← TAMBAHKAN INI
                'duration_hours' => $duration,       // ← PASTIKAN INI ADA
                'total_amount' => $totalPrice,
                'status' => 'confirmed',
                'booking_type' => 'per_jam'
            ];
            
            $bookingId = $this->bookingModel->createBooking($bookingData);
            
            if ($bookingId) {
                // Update table status
                $this->tableModel->updateTableStatus($tableId, 'reserved');
                
                // AUTO-CREATE PAYMENT - FIXED: Pakai createPayment method
                $paymentData = [
                    'booking_id' => $bookingId,
                    'amount' => $totalPrice,
                    'payment_method' => 'cash', // Default method
                    'status' => 'pending'
                ];
                $this->paymentModel->createPayment($paymentData); // ✅ SEKARANG HARUSNYA WORK
                
                $_SESSION['booking_success'] = [
                    'booking_id' => $bookingId,
                    'table_number' => $table['table_number'],
                    'start_time' => $startDateTime,
                    'duration' => $duration,
                    'total_price' => $totalPrice
                ];
                
                // Redirect ke success page
                header('Location: ' . Router::url('booking/success'));
                exit;
                
            } else {
                $_SESSION['booking_error'] = 'Failed to create booking. Please try again.';
                $this->redirect('booking');
            }
        }

public function success() {
    // FIXED: Cek session data dengan key yang benar
    if (!isset($_SESSION['booking_success'])) {
        error_log("No booking_success found in session");
        $this->redirect('booking');
        return;
    }
    
    $bookingData = $_SESSION['booking_success'];
    
    // Debug: Log data yang akan di-pass ke view
    error_log("Success page - Booking data: " . print_r($bookingData, true));
    
    // Hapus session data setelah digunakan
    unset($_SESSION['booking_success']);
    
    $data = [
        'title' => 'Booking Confirmed',
        'current_route' => 'booking',
        'booking' => $bookingData // ✅ Pastikan ini ada
    ];
    
    $this->view('booking/success', $data);
}

public function updatePaymentMethod() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid method'], 400);
            return;
        }
        
        $bookingId = $this->getPost('booking_id');
        $paymentMethod = $this->getPost('payment_method');
        
        // Update payment method in payments table
        $sql = "UPDATE payments SET payment_method = ? WHERE booking_id = ?";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([$paymentMethod, $bookingId]);
        
        if ($success) {
            $this->json(['success' => true, 'message' => 'Payment method updated']);
        } else {
            $this->json(['error' => 'Failed to update payment method'], 500);
        }
    }
};
?>