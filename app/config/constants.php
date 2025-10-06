<?php
// app/config/constants.php

// User roles
define('ROLE_CUSTOMER', 'customer');
define('ROLE_ADMIN', 'admin');
define('ROLE_STAFF', 'staff');

// Booking statuses
define('STATUS_PENDING', 'pending');
define('STATUS_CONFIRMED', 'confirmed');
define('STATUS_ACTIVE', 'active');
define('STATUS_COMPLETED', 'completed');
define('STATUS_CANCELLED', 'cancelled');

// Table statuses
define('TABLE_AVAILABLE', 'available');
define('TABLE_OCCUPIED', 'occupied');
define('TABLE_RESERVED', 'reserved');
define('TABLE_MAINTENANCE', 'maintenance');

// Payment methods
define('PAYMENT_CASH', 'cash');
define('PAYMENT_TRANSFER', 'transfer');
define('PAYMENT_EWALLET', 'ewallet');

// Payment statuses
define('PAYMENT_PENDING', 'pending');
define('PAYMENT_PAID', 'paid');
define('PAYMENT_FAILED', 'failed');
define('PAYMENT_REFUNDED', 'refunded');

// Package types
define('PACKAGE_HOURLY', 'hourly');
define('PACKAGE_FLAT_RATE', 'flat_rate');
define('PACKAGE_UNLIMITED', 'unlimited');

// Order statuses (F&B)
define('ORDER_PENDING', 'pending');
define('ORDER_PREPARING', 'preparing');
define('ORDER_READY', 'ready');
define('ORDER_SERVED', 'served');
define('ORDER_CANCELLED', 'cancelled');

// Product categories
define('CATEGORY_FOOD', 'food');
define('CATEGORY_BEVERAGE', 'beverage');
define('CATEGORY_MERCHANDISE', 'merchandise');
define('CATEGORY_SNACK', 'snack');

// Time constants (dalam menit)
define('AUTO_PAUSE_MINUTES', 15); // Auto-pause jika meja kosong
define('PAYMENT_TIMEOUT_MINUTES', 30); // Timeout payment session
define('BOOKING_BUFFER_MINUTES', 15); // Buffer antara booking

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);
?>