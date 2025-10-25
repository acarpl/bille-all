<?php
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
            'auth/update-profile' => 'AuthController@updateProfile',
                
            // Booking routes
            'booking' => 'BookingController@index',
            'booking/check-availability' => 'BookingController@checkAvailability',
            'booking/calculate-price' => 'BookingController@calculatePrice',
            'booking/create' => 'BookingController@create',
            'booking/success' => 'BookingController@success',
            'booking/update-payment-method' => 'BookingController@updatePaymentMethod', 
                
            // ========== MENU & MERCHANDISE ROUTES ==========
            'menu' => 'MenuController@index',
            'menu/category/(.+)' => 'MenuController@category/$1',
            'menu/merchandise' => 'MenuController@merchandise',
            'menu/api/get-products' => 'MenuController@apiGetProducts',
            'menu/api/get-product/(.+)' => 'MenuController@apiGetProduct/$1',
                
            // ========== BILLING ROUTES ==========
            'billing' => 'BillingController@index',
            'billing/sessions' => 'BillingController@sessions',
            'billing/session/(.+)' => 'BillingController@session/$1',
            'billing/start/(.+)' => 'BillingController@start/$1',
            'billing/pause/(.+)' => 'BillingController@pause/$1',
            'billing/resume/(.+)' => 'BillingController@resume/$1',
            'billing/stop/(.+)' => 'BillingController@stop/$1',
            'billing/add-order/(.+)' => 'BillingController@addOrder/$1',
            'billing/remove-order/(.+)' => 'BillingController@removeOrder/$1',
            'billing/checkout/(.+)' => 'BillingController@checkout/$1',
            'billing/payment/(.+)' => 'BillingController@payment/$1',
            'billing/complete/(.+)' => 'BillingController@complete/$1',
            'billing/api/add-item' => 'BillingController@apiAddItem',
            'billing/api/update-item/(.+)' => 'BillingController@apiUpdateItem/$1',
            'billing/api/remove-item/(.+)' => 'BillingController@apiRemoveItem/$1',
                
            // ========== FACILITIES ROUTES ==========
            'facilities' => 'FacilitiesController@index',
            'facilities/gallery' => 'FacilitiesController@gallery',
                
            // ========== FEEDBACK ROUTES ==========
            'feedback' => 'FeedbackController@index',
            'feedback/submit' => 'FeedbackController@submit',
            'feedback/thank-you' => 'FeedbackController@thankYou',
            'feedback/api/submit' => 'FeedbackController@apiSubmit',
                
            // ========== ORDER ROUTES ==========
            'orders' => 'OrderController@index',
            'orders/create' => 'OrderController@create',
            'orders/view/(.+)' => 'OrderController@view/$1',
            'orders/update/(.+)' => 'OrderController@update/$1',
            'orders/cancel/(.+)' => 'OrderController@cancel/$1',
                
            // Admin routes
            'admin/dashboard' => 'AdminController@dashboard',
            'admin/bookings' => 'AdminController@bookings',
            'admin/tables' => 'AdminController@tables',
            'admin/payments' => 'AdminController@payments',
            'admin/update-booking-status' => 'AdminController@updateBookingStatus',
            'admin/update-table-status' => 'AdminController@updateTableStatus',
            'admin/update-payment-status' => 'AdminController@updatePaymentStatus',
                
            // ========== ADMIN MENU & PRODUCTS ==========
            'admin/products' => 'AdminController@products',
            'admin/products/create' => 'AdminController@productCreate',
            'admin/products/store' => 'AdminController@productStore',
            'admin/products/edit/(.+)' => 'AdminController@productEdit/$1',
            'admin/products/update/(.+)' => 'AdminController@productUpdate/$1',
            'admin/products/delete/(.+)' => 'AdminController@productDelete/$1',
            'admin/products/stock/(.+)' => 'AdminController@productStock/$1',
                
            // ========== ADMIN BILLING ==========
            // ========== ADMIN BILLING ROUTES ==========
            'admin/billings' => 'AdminController@billings',
            'admin/billings/sessions' => 'AdminController@billingSessions', 
            'admin/billings/session/(.+)' => 'AdminController@billingSession/$1',
            'admin/billings/reports' => 'AdminController@billingReports',
            'admin/billings/create-from-booking/(.+)' => 'AdminController@createBillingFromBooking/$1', // TAMBAH INI
            'admin/bookings/without-billing' => 'AdminController@bookingsWithoutBilling', // TAMBAH INI
                
            // ========== ADMIN FEEDBACK ==========
            'admin/feedback' => 'AdminController@feedback',
            'admin/feedback/view/(.+)' => 'AdminController@feedbackView/$1',
            'admin/feedback/delete/(.+)' => 'AdminController@feedbackDelete/$1',
                
            // Tournament routes
            'admin/tournaments' => 'AdminController@tournaments',
            'admin/tournaments/create' => 'AdminController@tournamentCreate',
            'admin/tournaments/edit/(.+)' => 'AdminController@tournamentEdit/$1',
            'admin/tournaments/delete/(.+)' => 'AdminController@tournamentDelete/$1',
            'admin/tournaments/participants/(.+)' => 'AdminController@tournamentParticipants/$1',
            'admin/tournaments/update-status' => 'AdminController@updateTournamentStatus',
            'admin/tournaments/payments' => 'AdminController@tournamentPayments',
            'admin/tournaments/update-payment/(.+)' => 'AdminController@updateTournamentPayment/$1',

            // Tournament routes
            'tournaments' => 'TournamentController@index',
            'tournaments/view/(.+)' => 'TournamentController@show/$1',
            'tournaments/register' => 'TournamentController@register',
            'tournaments/register/(.+)' => 'TournamentController@registerPage/$1',
            'tournaments/my' => 'TournamentController@myRegistrations',

            // Payment routes
            'payment/tournament/(.+)' => 'PaymentController@tournamentPayment/$1',
            'payments/tournament/(.+)' => 'PaymentController@tournamentPayment/$1',
            'payment/process' => 'PaymentController@processTournamentPayment',
            'payment/instructions/(.+)' => 'PaymentController@paymentInstructions/$1',
            'payment/upload-proof' => 'PaymentController@uploadProof',
            'payment/upload/(.+)' => 'PaymentController@uploadPage/$1',
                
            // API routes
            'api/tables/status' => 'ApiController@tableStatus',
            'api/booking/update' => 'ApiController@updateBooking',
                
            // ========== NEW API ROUTES ==========
            'api/menu/products' => 'ApiController@menuProducts',
            'api/menu/categories' => 'ApiController@menuCategories',
            'api/billing/active-sessions' => 'ApiController@billingActiveSessions',
            'api/billing/add-item' => 'ApiController@billingAddItem',
            'api/feedback/submit' => 'ApiController@feedbackSubmit',
        ];
    }
    
    public function route() {
        $url = $this->getCurrentUrl();

        // Check if requesting a static file
        if (preg_match('#\.(jpg|jpeg|png|gif|css|js|webp|svg|ico|woff|woff2|ttf|eot)$#i', $url)) {
            $this->serveStaticFileSimple($url);
            return;
        }
        
        $this->currentRoute = $url;
        
        // Check for exact match first
        if (isset($this->routes[$url])) {
            $this->dispatch($this->routes[$url]);
            return;
        }
        
        // Check for pattern match with parameters
        foreach ($this->routes as $pattern => $route) {
            // Convert route pattern to regex
            $regex = "#^" . $pattern . "$#";
            
            if (preg_match($regex, $url, $matches)) {
                array_shift($matches); // Remove full match
                
                // Extract controller and method
                if (strpos($route, '@') !== false) {
                    list($controllerName, $method) = explode('@', $route);
                    
                    // Handle parameters in method (e.g., show/$1)
                    if (strpos($method, '/') !== false) {
                        $methodParts = explode('/', $method);
                        $method = $methodParts[0];
                        $matches = array_merge($matches, array_slice($methodParts, 1));
                    }
                    
                    $this->dispatchWithParams($controllerName, $method, $matches);
                    return;
                }
            }
        }
        
        // No route found
        $this->dispatch404();
    }
    
    private function getCurrentUrl() {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return $url;
    }
    
    private function dispatch($route) {
        list($controllerName, $method) = explode('@', $route);
        $this->dispatchWithParams($controllerName, $method, []);
    }
    
    private function dispatchWithParams($controllerName, $method, $params = []) {
        $controllerFile = APP_PATH . "/controllers/{$controllerName}.php";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            // Create controller instance
            $controller = new $controllerName();
            
            // Call the method with parameters
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                $this->dispatch404();
            }
        } else {
            $this->dispatch404();
        }
    }
    
    private function serveStaticFileSimple($url) {
        // Build the file path - use BASE_PATH constant
        $rootPath = defined('BASE_PATH') ? BASE_PATH : dirname(dirname(__DIR__));
        $filePath = $rootPath . '/' . $url;
        
        // Security check: prevent directory traversal
        $realPath = realpath($filePath);
        $rootPathReal = realpath($rootPath);
        
        if ($realPath === false || strpos($realPath, $rootPathReal) !== 0) {
            http_response_code(403);
            echo "Access forbidden";
            exit;
        }
        
        // Check if file exists
        if (!file_exists($filePath) || !is_file($filePath)) {
            http_response_code(404);
            echo "File not found: " . htmlspecialchars($url);
            exit;
        }
        
        // Get file extension and set content type
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $contentTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject'
        ];
        
        $contentType = isset($contentTypes[$extension]) ? $contentTypes[$extension] : 'application/octet-stream';
        
        // Set headers
        header('Content-Type: ' . $contentType);
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: public, max-age=31536000');
        
        // Output file
        readfile($filePath);
        exit;
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
            echo "<h3>Debug Info:</h3>";
            echo "<pre>Routes: " . print_r($this->routes, true) . "</pre>";
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