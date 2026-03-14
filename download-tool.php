<?php
require_once 'includes/config.php';
require_once 'includes/github_release.php';

$release       = sw_fetch_release();
$download_url  = $release['download_url']  ?? null;
$version       = $release['version']       ?? null;
$size_mb       = $release['size_mb']       ?? '~20';
$published_at  = $release['published_at']  ?? null;
$api_error     = $release['error']         ?? null;

$pub_date = $published_at ? date('F j, Y', strtotime($published_at)) : null;

// The download goes through our own proxy script so users never see GitHub URLs
$proxy_url = 'download-proxy.php';

include 'includes/header.php';
?>

<div class="download-container">

  <div class="download-header">
    <h1>⬇️ Download SecureWipe Desktop</h1>
    <p class="lead">One file. Double-click. No Python, no packages, no setup required.</p>
  </div>

  <!-- ── Main download card ── -->
  <div class="download-card featured">
    <div class="card-icon">🛡️</div>
    <h2>SecureWipe.exe</h2>
    <p class="card-description">
      Fully standalone Windows application — Python runtime, ADB and all
      dependencies bundled inside a single file. Nothing else to install.
    </p>

    <?php if ($api_error && !$download_url): ?>
    <!-- Diagnostic error — only shown if the EXE truly cannot be served -->
    <div class="alert alert-warning" style="text-align:left;margin-bottom:20px">
      <strong>⚠️ Download temporarily unavailable</strong><br>
      Could not reach the release server. Please try again in a few minutes.
      <details style="margin-top:8px">
        <summary style="cursor:pointer;font-size:.82rem;color:var(--text-muted)">Technical detail</summary>
        <code style="font-size:.8rem"><?= htmlspecialchars($api_error) ?></code>
      </details>
    </div>
    <?php endif; ?>

    <div class="requirements">
      <h3>✅ Everything included — nothing to install:</h3>
      <ul>
        <li>✅ Python 3.11 runtime (bundled inside the EXE)</li>
        <li>✅ ADB — Android Debug Bridge (bundled)</li>
        <li>✅ All libraries — zero external dependencies</li>
        <li>✅ Generates a wipe certificate when done</li>
      </ul>
      <h3 style="margin-top:14px">📋 What your PC needs:</h3>
      <ul>
        <li>Windows 10 or 11 (64-bit)</li>
        <li>A USB cable for your Android phone</li>
        <li>USB Debugging enabled on the phone (guide below)</li>
      </ul>
    </div>

    <?php if ($download_url): ?>
    <a href="<?= htmlspecialchars($proxy_url) ?>" class="download-btn">
      ⬇️ &nbsp;Download SecureWipe.exe
    </a>
    <?php else: ?>
    <button class="download-btn" disabled style="opacity:.5;cursor:not-allowed">
      ⬇️ &nbsp;Download temporarily unavailable
    </button>
    <?php endif; ?>

    <div style="margin-top:16px;display:flex;justify-content:center;gap:20px;flex-wrap:wrap">
      <?php if ($version): ?>
      <span style="font-size:.82rem;color:var(--text-muted)">
        🏷 <strong style="color:var(--text-secondary)"><?= htmlspecialchars($version) ?></strong>
      </span>
      <?php endif; ?>
      <span style="font-size:.82rem;color:var(--text-muted)">
        📦 <strong style="color:var(--text-secondary)"><?= $size_mb ?> MB</strong>
      </span>
      <?php if ($pub_date): ?>
      <span style="font-size:.82rem;color:var(--text-muted)">
        📅 <strong style="color:var(--text-secondary)"><?= $pub_date ?></strong>
      </span>
      <?php endif; ?>
    </div>
  </div>

  <!-- ── How to use ── -->
  <div class="instructions">
    <h2>🚀 How To Use — 4 Steps</h2>

    <div class="step">
      <div class="step-number">1</div>
      <div class="step-content">
        <h3>Download &amp; Run</h3>
        <p>Click the download button above. When it finishes, double-click
           <strong>SecureWipe.exe</strong> to open it.</p>
        <p class="tip">💡 Windows SmartScreen may show a warning. Click
           <strong>More info → Run anyway</strong>. This is normal for any
           downloaded EXE that isn't commercially signed.</p>
      </div>
    </div>

    <div class="step">
      <div class="step-number">2</div>
      <div class="step-content">
        <h3>Enable USB Debugging on your Android</h3>
        <ul>
          <li>Go to <strong>Settings → About Phone</strong></li>
          <li>Tap <strong>Build Number</strong> seven times → "You are now a developer!"</li>
          <li>Go back → <strong>Settings → System → Developer Options</strong></li>
          <li>Toggle <strong>USB Debugging</strong> ON</li>
        </ul>
      </div>
    </div>

    <div class="step">
      <div class="step-number">3</div>
      <div class="step-content">
        <h3>Connect &amp; Detect</h3>
        <p>Plug your phone into the PC with a USB cable, then click
           <strong>"Detect Android Device"</strong> in the tool.</p>
        <p>When the popup appears on your phone, tap <strong>Allow</strong>.</p>
        <div class="code-block">adb devices  ←  the tool runs this automatically</div>
        <p style="font-size:.82rem;color:var(--text-muted);margin-top:8px">
          The device should show as
          <code style="color:var(--success)">device</code>, not
          <code style="color:var(--danger)">unauthorized</code>.
        </p>
      </div>
    </div>

    <div class="step">
      <div class="step-number">4</div>
      <div class="step-content">
        <h3>Start Secure Wipe</h3>
        <p>Click <strong>"START SECURE WIPE"</strong>. The tool walks through all
           4 steps and saves a <strong>wipe certificate</strong> (a .txt file) in
           the same folder when complete.</p>
      </div>
    </div>
  </div>

  <!-- ── iPhone ── -->
  <div class="download-card" style="border-color:rgba(249,115,22,.3)">
    <div class="card-icon">🍎</div>
    <h2 style="font-size:1.4rem">iPhone Users</h2>
    <p class="card-description">
      Apple restricts third-party USB access on all platforms. The tool includes a
      built-in <strong>guided mode</strong> for iPhone — it walks you through each
      step on-screen and generates a completion certificate at the end.
    </p>
    <p style="font-size:.875rem;color:var(--text-muted)">
      iPhone storage is hardware-encrypted by default. A factory reset
      cryptographically destroys the encryption key, making all data permanently
      unrecoverable — no extra overwrite step is needed.
    </p>
  </div>

  <!-- ── Troubleshooting ── -->
  <div class="troubleshooting">
    <h3>🔍 Troubleshooting</h3>

    <div class="trouble-item">
      <h4>"Windows protected your PC" / SmartScreen warning</h4>
      <p>Click <strong>More info → Run anyway</strong>. This appears on any unsigned
         EXE downloaded from the internet. The full source code is available on request.</p>
    </div>

    <div class="trouble-item">
      <h4>"No device found" after clicking Detect</h4>
      <p>Check: (1) your USB cable transfers data (not charge-only), (2) USB Debugging
         is on in Developer Options, (3) you tapped <strong>Allow</strong> on the phone's
         popup. Unplug and reconnect, then try again.</p>
    </div>

    <div class="trouble-item">
      <h4>Device shows "unauthorized"</h4>
      <p>Your phone is waiting. Look for "Allow USB Debugging?" on the screen — tap
         <strong>Allow</strong> and check "Always allow from this computer".</p>
    </div>

    <div class="trouble-item">
      <h4>Antivirus blocks the tool</h4>
      <p>Add an exception for <code>SecureWipe.exe</code> in your antivirus settings.
         False positives are common with PyInstaller-built executables because they
         bundle a Python runtime in an unusual way.</p>
    </div>

    <div class="trouble-item">
      <h4>Tool opens then immediately closes</h4>
      <p>Right-click <code>SecureWipe.exe</code> → <strong>Run as administrator</strong>.
         Some systems require elevated privileges for USB device access.</p>
    </div>
  </div>

  <div class="alert alert-info">
    <strong>Android:</strong> Fully automated via ADB. &nbsp;
    <strong>iPhone:</strong> Step-by-step guided mode (Apple restricts direct USB access). &nbsp;
    A wipe certificate is generated for both device types.
  </div>

</div>

<?php include 'includes/footer.php'; ?>
