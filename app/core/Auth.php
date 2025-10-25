<?php
// app/core/Auth.php

class Auth {
    public static function login($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['logged_in'] = true;
    }
    
    public static function logout() {
        session_destroy();
        session_start(); // Start fresh session
    }
    
    public static function check() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    public static function user() {
        if (self::check()) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'],
                'email' => $_SESSION['user_email'],
                'role' => $_SESSION['user_role']
            ];
        }
        return null;
    }
    
    public static function id() {
        return self::check() ? $_SESSION['user_id'] : null;
    }
    
    public static function role() {
        return self::check() ? $_SESSION['user_role'] : null;
    }
    
    public static function isAdmin() {
        return self::check() && $_SESSION['user_role'] === ROLE_ADMIN;
    }
    
    public static function isCustomer() {
        return self::role() === ROLE_CUSTOMER;
    }
    
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header('Location: ' . Router::url('auth/login'));
            exit;
        }
    }
}
?>