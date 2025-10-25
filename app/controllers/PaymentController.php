<?php
class PaymentController extends Controller {
    private $paymentModel;
    private $tournamentModel;
    
    public function __construct() {
        parent::__construct();
        $this->paymentModel = new PaymentModel();
        $this->tournamentModel = new TournamentModel();
    }
    
    // PaymentController.php - Update tournamentPayment method
public function tournamentPayment($registrationId) {
    $this->requireAuth();
    
    error_log("=== tournamentPayment Debug ===");
    error_log("Registration ID: " . $registrationId);
    error_log("User ID: " . Auth::id());
    
    // Get registration data
    $registration = $this->tournamentModel->getRegistrationById($registrationId);
    
    if (!$registration) {
        $_SESSION['payment_error'] = 'Registration not found';
        error_log("Redirecting: Registration not found");
        $this->redirect('tournaments/my');
        return;
    }
    
    // Check user ownership
    if ($registration['user_id'] != Auth::id()) {
        $_SESSION['payment_error'] = 'This registration does not belong to you';
        error_log("Redirecting: User mismatch - Registration user: " . $registration['user_id'] . ", Logged in: " . Auth::id());
        $this->redirect('tournaments/my');
        return;
    }
    
    // Check if already paid
    if ($registration['payment_status'] === 'paid' || $registration['payment_id']) {
        $_SESSION['payment_error'] = 'Payment already completed for this registration';
        error_log("Redirecting: Payment already completed");
        $this->redirect('tournaments/my');
        return;
    }
    
    // Check tournament status
    if ($registration['tournament_status'] !== 'upcoming') {
        $_SESSION['payment_error'] = 'Cannot pay for completed or cancelled tournament';
        error_log("Redirecting: Tournament status not upcoming");
        $this->redirect('tournaments/my');
        return;
    }
    
    // Check registration deadline
    if (strtotime($registration['registration_deadline']) < time()) {
        $_SESSION['payment_error'] = 'Registration deadline has passed';
        error_log("Redirecting: Registration deadline passed");
        $this->redirect('tournaments/my');
        return;
    }
    
    error_log("Rendering payment page successfully");
    
    $data = [
        'title' => 'Tournament Payment - ' . $registration['tournament_name'],
        'current_route' => 'payment',
        'registration' => $registration
    ];
    
    $this->view('payments/tournament', $data);
}
    
    public function processTournamentPayment() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('tournaments/my');
            return;
        }
        
        $registrationId = $_POST['registration_id'] ?? null;
        $paymentMethod = $_POST['payment_method'] ?? null;
        
        // Validasi
        if (empty($registrationId) || empty($paymentMethod)) {
            $_SESSION['payment_error'] = 'Please select payment method';
            $this->redirect('payment/tournament/' . $registrationId);
            return;
        }
        
        // Get registration
        $registration = $this->tournamentModel->getRegistrationById($registrationId);
        
        if (!$registration || $registration['user_id'] != Auth::id()) {
            $_SESSION['payment_error'] = 'Invalid registration';
            $this->redirect('tournaments/my');
            return;
        }
        
        // Create payment record
        $paymentId = $this->paymentModel->createTournamentPayment(
            $registrationId, 
            $registration['total_fee'], 
            $paymentMethod
        );
        
        if ($paymentId) {
            // Redirect ke payment instruction page
            $this->redirect('payment/instructions/' . $paymentId);
        } else {
            $_SESSION['payment_error'] = 'Failed to create payment. Please try again.';
            $this->redirect('payment/tournament/' . $registrationId);
        }
    }
    
    public function paymentInstructions($paymentId) {
        $this->requireAuth();
        
        $payment = $this->paymentModel->getPaymentById($paymentId);
        
        if (!$payment || $payment['user_id'] != Auth::id()) {
            $_SESSION['payment_error'] = 'Payment not found';
            $this->redirect('tournaments/my');
            return;
        }
        
        $data = [
            'title' => 'Payment Instructions',
            'current_route' => 'payment',
            'payment' => $payment
        ];
        
        $this->view('payments/instructions', $data);
    }
    
    public function uploadProof() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid method'], 400);
            return;
        }
        
        $paymentId = $_POST['payment_id'] ?? null;
        $payment = $this->paymentModel->getPaymentById($paymentId);
        
        if (!$payment || $payment['user_id'] != Auth::id()) {
            $this->json(['error' => 'Payment not found'], 404);
            return;
        }
        
        // Handle file upload
        if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/payments/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = 'proof_' . $paymentId . '_' . time() . '_' . basename($_FILES['payment_proof']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $uploadFile)) {
                // Update payment dengan proof path
                if ($this->paymentModel->updatePaymentStatus($paymentId, 'pending', $uploadFile)) {
                    $_SESSION['payment_success'] = 'Payment proof uploaded successfully. Waiting for verification.';
                    $this->json(['success' => true, 'message' => 'Proof uploaded successfully']);
                } else {
                    $this->json(['error' => 'Failed to update payment'], 500);
                }
            } else {
                $this->json(['error' => 'Failed to upload file'], 500);
            }
        } else {
            $this->json(['error' => 'No file uploaded or upload error'], 400);
        }
    }

    // Tambahkan method ini ke PaymentController
public function uploadPage($paymentId) {
    $this->requireAuth();
    
    $payment = $this->paymentModel->getPaymentById($paymentId);
    
    if (!$payment || $payment['user_id'] != Auth::id()) {
        $_SESSION['payment_error'] = 'Payment not found';
        $this->redirect('tournaments/my');
        return;
    }
    
    if ($payment['status'] === 'paid') {
        $_SESSION['payment_error'] = 'Payment already verified';
        $this->redirect('tournaments/my');
        return;
    }
    
    $data = [
        'title' => 'Upload Payment Proof',
        'current_route' => 'payment',
        'payment' => $payment
    ];
    
    $this->view('payments/upload', $data);
}
}
?>