<?php
/**
 * log_desktop_start.php
 * Called by the Python desktop tool at the START of each wipe session.
 * Creates a new erase_logs row and returns the log_id so the tool
 * can reference the same row when posting completion.
 */
require_once 'includes/config.php';

header('Content-Type: application/json');

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

$device_type  = mysqli_real_escape_string($conn, $data['device_type']  ?? 'android');
$device_model = mysqli_real_escape_string($conn, $data['device_model'] ?? 'Unknown');
$tool_type    = 'desktop';

$result = mysqli_query($conn,
    "INSERT INTO erase_logs (device_type, device_model, tool_type, status, steps_completed, start_time)
     VALUES ('$device_type', '$device_model', '$tool_type', 'STARTED', 0, NOW())"
);

if ($result) {
    $log_id = mysqli_insert_id($conn);
    echo json_encode(['success' => true, 'log_id' => $log_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
