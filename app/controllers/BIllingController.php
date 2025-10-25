<?php
class BillingController extends Controller {
    private $billingModel;

    public function __construct() {
        $this->billingModel = $this->model('BillingModel');
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

    // USER: View billing detail
    public function view($id) {
        $user_id = Auth::getUserId();
        $billing = $this->billingModel->getBillingById($id);

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
}