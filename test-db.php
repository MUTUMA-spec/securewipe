<?php
// Include your existing config file
require_once('includes/config.php');

echo "<h2>Database Connection Test</h2>";
echo "Connecting to: " . DB_HOST . "<br>";
echo "User: " . DB_USER . "<br>";
echo "Database: " . DB_NAME . "<br>";

$test_conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$test_conn) {
    echo "<p style='color:red;'><strong>FAILURE:</strong> " . mysqli_connect_error() . "</p>";
    echo "<p>Check if your password in config.php matches the 'Hosting Password' in your InfinityFree Client Area.</p>";
} else {
    echo "<p style='color:green;'><strong>SUCCESS:</strong> Connection established perfectly!</p>";
    mysqli_close($test_conn);
}
?>
