<?php
// app/core/Router.php

class Router {
    private $routes = [];
    private $currentRoute = '';
    
    public function __construct() {
        $this->loadRoutes();
    }
    
    private function loadRoutes() {
        // Define application routes
        $this->routes = [
            // Public routes
            '' => 'HomeController@index',
            'home' => 'HomeController@index',
            'about' => 'HomeController@about',
            
            // Auth routes
            'auth/login' => 'AuthController@login',
            'auth/register' => 'AuthController@register', 
            'auth/logout' => 'AuthController@logout',
            'auth/profile' => 'AuthController@profile',
            
            // Booking routes
            'booking' => 'BookingController@index',
            'booking/create' => 'BookingController@create',
            'booking/check-availability' => 'BookingController@checkAvailability',
            'booking/calculate-price' => 'BookingController@calculatePrice',
            
            // Admin routes
            'admin/dashboard' => 'AdminController@dashboard',
            'admin/tables' => 'AdminController@tables',
            'admin/bookings' => 'AdminController@bookings',
            'admin/payments' => 'AdminController@payments',
            
            // API routes
            'api/tables/status' => 'ApiController@tableStatus',
            'api/booking/update' => 'ApiController@updateBooking',
        ];
    }
    
    public function route() {
        $url = $this->getCurrentUrl();
        $this->currentRoute = $url;
        
        // Check if route exists
        if (isset($this->routes[$url])) {
            $this->dispatch($this->routes[$url]);
        } else {
            $this->dispatch404();
        }
    }
    
    private function getCurrentUrl() {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return $url;
    }
    
    private function dispatch($route) {
        list($controllerName, $method) = explode('@', $route);
        
        $controllerFile = APP_PATH . "/controllers/{$controllerName}.php";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            // Create controller instance
            $controller = new $controllerName();
            
            // Call the method
            if (method_exists($controller, $method)) {
                $controller->$method();
            } else {
                $this->dispatch404();
            }
        } else {
            $this->dispatch404();
        }
    }
    
    private function dispatch404() {
        http_response_code(404);
        header('Content-Type: text/html');
        
        $viewFile = APP_PATH . "/views/errors/404.php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "<h1>404 - Page Not Found</h1>";
            echo "<p>The requested URL '{$this->currentRoute}' was not found.</p>";
        }
        exit;
    }
    
    // Helper untuk generate URLs
    public static function url($path = '') {
        return BASE_URL . '/' . ltrim($path, '/');
    }
    
    public static function asset($path) {
        return ASSETS_URL . '/' . ltrim($path, '/');
    }
}
?>