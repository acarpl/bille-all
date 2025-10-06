<?php
// index.php - FRONT CONTROLLER

// Define app running constant
define('APP_RUNNING', true);

// Load configuration
require_once 'app/config/config.php';

// Register autoloader
require_once 'app/core/Autoloader.php';
Autoloader::register();

// Load core classes (sekarang bisa di-autoload, tapi kita require manual untuk pastikan)
require_once 'app/core/Database.php';
require_once 'app/core/Router.php';
require_once 'app/core/Model.php';
require_once 'app/core/Controller.php';
require_once 'app/core/Auth.php';

// Initialize and run the router
$router = new Router();
$router->route();
?>