<?php
/**
 * download-proxy.php
 * Streams SecureWipe.exe to the user AND logs the download to the database.
 */
require_once 'includes/config.php';
require_once 'includes/github_release.php';

$release      = sw_fetch_release();
$download_url = $release['download_url'] ?? null;

if (!$download_url) {
    http_response_code(503);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html><body style="font-family:sans-serif;padding:40px">';
    echo '<h2>⚠️ Download temporarily unavailable</h2>';
    echo '<p>The release server is unreachable or no build exists yet.</p>';
    echo '<p><a href="downloads.php">← Back to download page</a></p>';
    if (!empty($release['error'])) {
        echo '<p style="color:#888;font-size:.85rem">Detail: ' . htmlspecialchars($release['error']) . '</p>';
    }
    echo '</body></html>';
    exit;
}

// ── Log the download to the database ────────────────────────────
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
// Anonymise IP — zero the last octet
$parts = explode('.', $ip);
if (count($parts) === 4) { $parts[3] = '0'; $ip = implode('.', $parts); }

$ua    = $_SERVER['HTTP_USER_AGENT'] ?? '';
$model = 'SecureWipe.exe';
$dtype = 'download';
$ttype = 'desktop';

$stmt = mysqli_prepare($conn,
    "INSERT INTO erase_logs (device_type, device_model, tool_type, ip_address, user_agent, status, steps_completed, start_time)
     VALUES (?, ?, ?, ?, ?, 'DOWNLOADED', 0, NOW())");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'sssss', $dtype, $model, $ttype, $ip, $ua);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);

// ── Stream the file ──────────────────────────────────────────────
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="SecureWipe.exe"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('X-Robots-Tag: noindex');

if (!empty($release['size_mb'])) {
    header('Content-Length: ' . round($release['size_mb'] * 1048576));
}

if (function_exists('curl_init')) {
    $ch = curl_init($download_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTPHEADER     => ['User-Agent: SecureWipeWebsite/1.0'],
        CURLOPT_BUFFERSIZE     => 131072,
    ]);
    curl_exec($ch);
    curl_close($ch);
} else {
    header('Location: ' . $download_url);
}
exit;
