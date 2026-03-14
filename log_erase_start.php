<?php
require_once 'includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$device_type = sanitizeInput($data['device_type']);
$device_model = sanitizeInput($data['device_model']);
$tool_type = isset($data['tool_type']) ? $data['tool_type'] : 'web';

// Anonymize IP (keep first 3 octets only)
$ip_address = $_SERVER['REMOTE_ADDR'];
$ip_parts = explode('.', $ip_address);
if (count($ip_parts) == 4) {
    $ip_parts[3] = '0';
    $ip_address = implode('.', $ip_parts);
}

$user_agent = $_SERVER['HTTP_USER_AGENT'];

$sql = "INSERT INTO erase_logs (device_type, device_model, tool_type, ip_address, user_agent, status) 
        VALUES (?, ?, ?, ?, ?, 'STARTED')";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $device_type, $device_model, $tool_type, $ip_address, $user_agent);

if (mysqli_stmt_execute($stmt)) {
    $log_id = mysqli_insert_id($conn);
    echo json_encode(['success' => true, 'log_id' => $log_id]);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>