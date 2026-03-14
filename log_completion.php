<?php
require_once 'includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$log_id = intval($data['log_id']);
$completion_time = date('Y-m-d H:i:s');

$sql = "UPDATE erase_logs SET status = 'COMPLETED', steps_completed = 4, completion_time = ? WHERE log_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $completion_time, $log_id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>