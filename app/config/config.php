<?php
// app/config/config.php

// Base configuration
define('APP_NAME', 'Bille Southside');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'development'); // development, production

// Path constants
define('BASE_PATH', dirname(dirname(__DIR__)));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');

// URL constants (sesuaikan dengan local setup kamu)
define('BASE_URL', 'http://localhost/bille-all');
define('ASSETS_URL', BASE_URL . '/public/assets');

// Session configuration
define('SESSION_TIMEOUT', 3600); // 1 hour
define('SESSION_NAME', 'billeallacsess');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Error reporting (untuk development)
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Include other config files
require_once 'database.php';
require_once 'constants.php';
?>