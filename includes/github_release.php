<?php
/**
 * Fetches the latest SecureWipe.exe download URL from GitHub Releases.
 * Results are cached for 1 hour to avoid hitting the GitHub API every pageload.
 *
 * SETUP: Set GITHUB_REPO below to your "username/repo" after pushing to GitHub.
 */

define('GITHUB_REPO', 'MUTUMA-spec/securewipe'); // ← change this
define('RELEASE_CACHE_FILE', __DIR__ . '/../.release_cache.json');
define('RELEASE_CACHE_TTL',  3600); // seconds

function get_latest_release(): array {
    // Return cached data if fresh
    if (file_exists(RELEASE_CACHE_FILE)) {
        $cache = json_decode(file_get_contents(RELEASE_CACHE_FILE), true);
        if ($cache && isset($cache['fetched_at']) && (time() - $cache['fetched_at']) < RELEASE_CACHE_TTL) {
            return $cache;
        }
    }

    // Fetch from GitHub API
    $api_url = 'https://api.github.com/repos/' . GITHUB_REPO . '/releases/latest';
    $ctx = stream_context_create(['http' => [
        'method'  => 'GET',
        'header'  => "User-Agent: SecureWipeWebsite/1.0\r\n",
        'timeout' => 5,
    ]]);

    $result = [
        'fetched_at'   => time(),
        'download_url' => null,
        'version'      => null,
        'size_mb'      => null,
        'published_at' => null,
        'error'        => null,
    ];

    $json = @file_get_contents($api_url, false, $ctx);
    if ($json === false) {
        $result['error'] = 'Could not reach GitHub API';
        return $result;
    }

    $data = json_decode($json, true);
    if (!$data || isset($data['message'])) {
        $result['error'] = $data['message'] ?? 'Invalid response';
        return $result;
    }

    // Find the .exe asset
    foreach ($data['assets'] ?? [] as $asset) {
        if (str_ends_with($asset['name'], '.exe')) {
            $result['download_url'] = $asset['browser_download_url'];
            $result['size_mb']      = round($asset['size'] / 1048576, 1);
            break;
        }
    }

    $result['version']      = $data['tag_name']   ?? null;
    $result['published_at'] = $data['published_at'] ?? null;

    // Cache it
    @file_put_contents(RELEASE_CACHE_FILE, json_encode($result));

    return $result;
}
?>
