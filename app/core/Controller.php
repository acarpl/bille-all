<?php
// app/core/Controller.php

class Controller {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->init();
    }
    
    protected function init() {
        // Initialize common controller stuff
        session_start();
    }
    
    // View rendering
    protected function view($view, $data = [], $useLayout = true) {
        $viewFile = APP_PATH . "/views/{$view}.php";
        
        if (file_exists($viewFile)) {
            // Extract data untuk view
            extract($data);
            
            // Start output buffering
            ob_start();
            
            // Include the view file
            require_once $viewFile;
            
            // Get the content
            $content = ob_get_clean();
            
            if ($useLayout) {
                // Include layout dengan content
                $layoutData = array_merge($data, ['content' => $content]);
                extract($layoutData);
                require_once APP_PATH . "/views/layouts/base.php";
            } else {
                // Output content langsung (untuk login/register pages)
                echo $content;
            }
        } else {
            die("View not found: {$view}");
        }
    }
    
    // Method untuk render tanpa layout (untuk auth pages)
    protected function viewWithoutLayout($view, $data = []) {
        $this->view($view, $data, false);
    }
    
    // JSON response
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    // Redirect
    protected function redirect($url) {
        header("Location: " . BASE_URL . "/" . ltrim($url, '/'));
        exit;
    }
    
    // Authentication helpers
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    protected function requireAuth() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }
    
    protected function requireAdmin() {
        $this->requireAuth();
        if ($_SESSION['user_role'] !== ROLE_ADMIN) {
            $this->redirect('home/access-denied');
        }
    }
    
    // Input sanitization
    protected function sanitize($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitize'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    // Get POST data
    protected function getPost($key = null, $default = null) {
        if ($key === null) {
            return $this->sanitize($_POST);
        }
        return isset($_POST[$key]) ? $this->sanitize($_POST[$key]) : $default;
    }
    
    // Get GET data
    protected function getQuery($key = null, $default = null) {
        if ($key === null) {
            return $this->sanitize($_GET);
        }
        return isset($_GET[$key]) ? $this->sanitize($_GET[$key]) : $default;
    }
}
?>