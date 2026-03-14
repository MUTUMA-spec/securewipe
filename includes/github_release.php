<?php
/**
 * Fetches the latest SecureWipe.exe info from GitHub Releases API.
 * Uses cURL (more reliable than file_get_contents on shared hosting).
 * Results cached for 1 hour in a local JSON file.
 *
 * ── SETUP ──────────────────────────────────────────────────────
 * Change the two lines below after you create your GitHub repo.
 */
define('GITHUB_REPO',  'YOUR_GITHUB_USERNAME/YOUR_REPO_NAME'); // ← change this
define('GITHUB_TOKEN', '');   // optional: paste a GitHub PAT here to avoid rate limits

define('RELEASE_CACHE', __DIR__ . '/../.release_cache.json');
define('RELEASE_TTL',   3600);  // re-check GitHub every hour

function sw_fetch_release(): array {
    // ── Return fresh cache if available ────────────────────────
    if (file_exists(RELEASE_CACHE)) {
        $c = json_decode(file_get_contents(RELEASE_CACHE), true);
        if ($c && !empty($c['fetched_at']) && (time() - $c['fetched_at']) < RELEASE_TTL) {
            return $c;
        }
    }

    $result = [
        'fetched_at'   => time(),
        'download_url' => null,
        'version'      => null,
        'size_mb'      => null,
        'published_at' => null,
        'error'        => null,
    ];

    // ── Try cURL first (most reliable on shared hosts) ─────────
    if (function_exists('curl_init')) {
        $ch = curl_init();
        $headers = ['User-Agent: SecureWipeWebsite/1.0', 'Accept: application/vnd.github+json'];
        if (GITHUB_TOKEN) {
            $headers[] = 'Authorization: Bearer ' . GITHUB_TOKEN;
        }
        curl_setopt_array($ch, [
            CURLOPT_URL            => 'https://api.github.com/repos/' . GITHUB_REPO . '/releases/latest',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 8,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $body = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($err) {
            $result['error'] = "cURL error: $err";
        } elseif ($code !== 200) {
            $result['error'] = "GitHub API returned HTTP $code";
        } else {
            $result = array_merge($result, sw_parse_release($body));
        }

    // ── Fall back to file_get_contents if cURL missing ─────────
    } elseif (ini_get('allow_url_fopen')) {
        $ctx  = stream_context_create(['http' => [
            'method'  => 'GET',
            'header'  => "User-Agent: SecureWipeWebsite/1.0\r\nAccept: application/vnd.github+json\r\n",
            'timeout' => 8,
        ]]);
        $body = @file_get_contents(
            'https://api.github.com/repos/' . GITHUB_REPO . '/releases/latest',
            false, $ctx
        );
        if ($body === false) {
            $result['error'] = 'file_get_contents failed (allow_url_fopen may be off)';
        } else {
            $result = array_merge($result, sw_parse_release($body));
        }
    } else {
        $result['error'] = 'Neither cURL nor allow_url_fopen is available on this server.';
    }

    // ── Cache result (even errors, so we don't hammer the API) ─
    @file_put_contents(RELEASE_CACHE, json_encode($result));
    return $result;
}

function sw_parse_release(string $body): array {
    $data = json_decode($body, true);
    if (!$data || isset($data['message'])) {
        return ['error' => $data['message'] ?? 'Invalid JSON from GitHub API'];
    }

    $out = ['error' => null, 'download_url' => null, 'size_mb' => null];

    foreach ($data['assets'] ?? [] as $asset) {
        if (str_ends_with(strtolower($asset['name']), '.exe')) {
            $out['download_url'] = $asset['browser_download_url'];
            $out['size_mb']      = round($asset['size'] / 1048576, 1);
            break;
        }
    }

    $out['version']      = $data['tag_name']    ?? null;
    $out['published_at'] = $data['published_at'] ?? null;

    if (!$out['download_url']) {
        $out['error'] = 'No .exe found in the latest release assets.';
    }

    return $out;
}
?>
