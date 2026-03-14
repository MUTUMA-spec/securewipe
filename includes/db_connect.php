<?php
// This file is now just a wrapper
// The actual connection is in config.php
require_once 'config.php';

// Function to get database connection
function getConnection() {
    global $conn;
    return $conn;
}
?>