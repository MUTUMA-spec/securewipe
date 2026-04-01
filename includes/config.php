<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================
// AUTO-DETECT ENVIRONMENT (Localhost or Live)
// ============================================
$is_localhost = false;

// Check if running on localhost
if (isset($_SERVER['HTTP_HOST'])) {
    if ($_SERVER['HTTP_HOST'] == 'localhost' || 
        $_SERVER['HTTP_HOST'] == '127.0.0.1' ||
        strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
        $is_localhost = true;
    }
}

// ============================================
// DATABASE CONFIGURATION
// ============================================
if ($is_localhost) {
    // --- LOCAL DEVELOPMENT SETTINGS ---
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'secure_wipe_education');
    define('SITE_URL', 'http://localhost/secure-wipe-website');
    define('SITE_NAME', 'Secure Data Wiping Education');
    
    // Error reporting ON for local development
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
} else {
    // --- LIVE PRODUCTION SETTINGS ---
    // YOUR INFINITYFREE DATABASE DETAILS
    define('DB_HOST', 'sql300.infinityfree.com');      // From your screenshot
    define('DB_USER', 'if0_41357689');                 // From your screenshot
    define('DB_PASS', '‎vKCHsglbhLBP');                 // From your screenshot
    define('DB_NAME', 'if0_41357689_securetool_db');   // From your screenshot
    define('SITE_URL', 'http://securetool.infinityfreeapp.com'); // Your domain
    define('SITE_NAME', 'Secure Data Wiping Education');
    
    // Error reporting ON for live site
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// ============================================
// DATABASE CONNECTION
// ============================================
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// Check connection
if (!$conn) {
    // Log error but don't show details to users
    error_log("Database connection failed: " . mysqli_connect_error());
    
    if ($is_localhost) {
        // Show detailed error on localhost
        die("Database connection failed: " . mysqli_connect_error());
    } else {
        // Show generic message on live site
        die("We're experiencing technical difficulties. Please try again later.");
    }
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8");

// ============================================
// SECURITY FUNCTIONS
// ============================================

/**
 * Clean user input to prevent XSS attacks
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Check if admin is logged in
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

/**
 * Redirect to a URL
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Get base URL for the site
 */
function base_url($path = '') {
    return SITE_URL . '/' . ltrim($path, '/');
}

// Optional: Uncomment to see which environment you're in
// echo "<!-- Running on: " . ($is_localhost ? "LOCALHOST" : "LIVE SERVER") . " -->";
?>
