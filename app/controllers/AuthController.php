<?php
// app/controllers/AuthController.php

class AuthController extends Controller {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }
    
    public function login() {
        // Jika sudah login, redirect ke home
        if (Auth::check()) {
            $this->redirect('home');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleLogin();
        } else {
            $this->view('auth/login');
        }
    }
    
    private function handleLogin() {
        $email = $this->getPost('email');
        $password = $this->getPost('password');
        
        // Validasi input
        $errors = [];
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }
        
        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }
        
        if (empty($errors)) {
            // Cari user by email
            $user = $this->userModel->findByEmail($email);
            
            if ($user && $this->userModel->verifyPassword($password, $user['password'])) {
                // Login successful
                Auth::login($user);
                $this->userModel->updateLastLogin($user['id']);
                
                // Redirect berdasarkan role
                if ($user['role'] === ROLE_ADMIN) {
                    $this->redirect('admin/dashboard');
                } else {
                    $this->redirect('home');
                }
            } else {
                $errors['general'] = 'Invalid email or password';
            }
        }
        
        // Tampilkan form dengan errors
        $this->view('auth/login', ['errors' => $errors, 'old_input' => $_POST]);
    }
    
    public function register() {
        if (Auth::check()) {
            $this->redirect('home');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleRegister();
        } else {
            $this->view('auth/register');
        }
    }
    
    private function handleRegister() {
        $data = [
            'name' => $this->getPost('name'),
            'email' => $this->getPost('email'),
            'phone' => $this->getPost('phone'),
            'password' => $this->getPost('password'),
            'password_confirm' => $this->getPost('password_confirm'),
            'student_id' => $this->getPost('student_id')
        ];
        
        $errors = $this->validateRegistration($data);
        
        if (empty($errors)) {
            // Check if email already exists
            $existingUser = $this->userModel->findByEmail($data['email']);
            
            if ($existingUser) {
                $errors['email'] = 'Email already registered';
            } else {
                // Create new user
                $userData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => $data['password'],
                    'student_id' => $data['student_id'],
                    'role' => ROLE_CUSTOMER,
                    'loyalty_points' => 100 // Bonus points for registration
                ];
                
                $userId = $this->userModel->createUser($userData);
                
                if ($userId) {
                    // Auto login after registration
                    $user = $this->userModel->find($userId);
                    Auth::login($user);
                    $this->redirect('home?registered=1');
                } else {
                    $errors['general'] = 'Registration failed. Please try again.';
                }
            }
        }
        
        $this->view('auth/register', ['errors' => $errors, 'old_input' => $data]);
    }
    
    private function validateRegistration($data) {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors['name'] = 'Full name is required';
        } elseif (strlen($data['name']) < 2) {
            $errors['name'] = 'Name must be at least 2 characters';
        }
        
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }
        
        if ($data['password'] !== $data['password_confirm']) {
            $errors['password_confirm'] = 'Passwords do not match';
        }
        
        if (!empty($data['phone']) && !preg_match('/^[0-9+\-\s()]{10,}$/', $data['phone'])) {
            $errors['phone'] = 'Invalid phone number format';
        }
        
        return $errors;
    }
    
    public function logout() {
        Auth::logout();
        $this->redirect('auth/login');
    }
    
    public function profile() {
        $this->requireAuth();
        
        $user = Auth::user();
        $stats = $this->userModel->getCustomerStats($user['id']);
        
        $this->view('auth/profile', [
            'user' => $user,
            'stats' => $stats
        ]);
    }
}
?>