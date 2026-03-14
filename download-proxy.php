<?php
/**
 * download-proxy.php
 * Streams SecureWipe.exe from GitHub to the user.
 * The user only ever sees your domain in the download URL.
 */
require_once 'includes/github_release.php';

$release      = sw_fetch_release();
$download_url = $release['download_url'] ?? null;

if (!$download_url) {
    http_response_code(503);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html><body style="font-family:sans-serif;padding:40px">';
    echo '<h2>⚠️ Download temporarily unavailable</h2>';
    echo '<p>The EXE has not been built yet, or the release server is unreachable.</p>';
    echo '<p><a href="download-tool.php">← Back to download page</a></p>';
    if ($release['error']) {
        echo '<p style="color:#888;font-size:.85rem">Detail: ' . htmlspecialchars($release['error']) . '</p>';
    }
    echo '</body></html>';
    exit;
}

// Stream the file through PHP so the user's browser gets it from your domain
if (function_exists('curl_init')) {
    // Set download headers before we start streaming
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="SecureWipe.exe"');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('X-Robots-Tag: noindex');

    // Pass size through if we have it (shows progress bar in browser)
    if (!empty($release['size_mb'])) {
        $bytes = round($release['size_mb'] * 1048576);
        header("Content-Length: $bytes");
    }

    $ch = curl_init($download_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => false,   // stream directly to output
        CURLOPT_FOLLOWLOCATION => true,    // follow GitHub's redirect
        CURLOPT_TIMEOUT        => 120,     // 2 min max for large file
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTPHEADER     => ['User-Agent: SecureWipeWebsite/1.0'],
        CURLOPT_BUFFERSIZE     => 131072,  // 128 KB chunks
    ]);

    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        // Headers already sent, can't send 503 — just exit
        exit;
    }
} else {
    // No cURL — redirect directly to GitHub (last resort)
    header('Location: ' . $download_url);
}
exit;
?>
