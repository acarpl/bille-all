<?php
// app/core/Autoloader.php

class Autoloader {
    public static function register() {
        spl_autoload_register(function ($className) {
            // Define possible file paths
            $paths = [
                APP_PATH . "/core/{$className}.php",
                APP_PATH . "/controllers/{$className}.php", 
                APP_PATH . "/models/{$className}.php",
                APP_PATH . "/config/{$className}.php"
            ];
            
            // Include the file if it exists
            foreach ($paths as $path) {
                if (file_exists($path)) {
                    require_once $path;
                    return;
                }
            }
            
            // Debug: Tampilkan class mana yang tidak ditemukan
            // echo "Class not found: {$className}";
        });
    }
}
?>