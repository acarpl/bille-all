<?php
// app/config/database.php

class DatabaseConfig {
    // Local development settings
    const HOST = 'localhost';
    const USERNAME = 'root';
    const PASSWORD = ''; // Sesuaikan dengan local MySQL kamu
    const DATABASE = 'systemv2';
    const PORT = 3306;
    const CHARSET = 'utf8mb4';
    
    // PDO options
    public static function getOptions() {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
    }
    
    // Get DSN string
    public static function getDSN() {
        return "mysql:host=" . self::HOST . ";dbname=" . self::DATABASE . ";charset=" . self::CHARSET . ";port=" . self::PORT;
    }
}

// Test connection (optional)
function testDatabaseConnection() {
    try {
        $pdo = new PDO(
            DatabaseConfig::getDSN(),
            DatabaseConfig::USERNAME,
            DatabaseConfig::PASSWORD,
            DatabaseConfig::getOptions()
        );
        return "Database connection successful!";
    } catch (PDOException $e) {
        return "Database connection failed: " . $e->getMessage();
    }
}
?>