<?php
require_once 'includes/config.php';

// ── Set your GitHub repo once ──────────────────────────────
// Format: 'username/reponame'
define('GITHUB_REPO', 'YOUR_GITHUB_USERNAME/YOUR_REPO_NAME');

$repo            = GITHUB_REPO;
$releases_page   = "https://github.com/{$repo}/releases/latest";
$direct_exe_url  = "https://github.com/{$repo}/releases/latest/download/SecureWipe.exe";

include 'includes/header.php';
?>

<div class="download-container">

  <div class="download-header">
    <h1>⬇️ Download SecureWipe Desktop</h1>
    <p class="lead">One file. Double-click. No Python, no packages, no setup required.</p>
  </div>

  <!-- Main download card -->
  <div class="download-card featured">
    <div class="card-icon">🛡️</div>
    <h2>SecureWipe.exe</h2>
    <p class="card-description">
      Fully standalone Windows application — Python runtime, ADB and all
      dependencies bundled inside. Nothing else to install.
    </p>

    <div class="requirements">
      <h3>✅ Everything included:</h3>
      <ul>
        <li>✅ Python runtime — no install needed on your PC</li>
        <li>✅ ADB (Android Debug Bridge) — bundled automatically</li>
        <li>✅ All libraries — zero external dependencies</li>
        <li>✅ Wipe certificate generator</li>
      </ul>
      <h3 style="margin-top:14px">📋 System requirements:</h3>
      <ul>
        <li>Windows 10 / 11 (64-bit)</li>
        <li>USB cable for your Android phone</li>
        <li>USB Debugging enabled on phone (guide below)</li>
      </ul>
    </div>

    <!-- Direct download — GitHub serves this URL from the latest release automatically -->
    <a href="<?= $direct_exe_url ?>" class="download-btn">
      ⬇️ &nbsp;Download SecureWipe.exe
    </a>

    <p style="margin-top:14px;font-size:.82rem;color:var(--text-muted)">
      ~20 MB &nbsp;·&nbsp; Windows 10/11 &nbsp;·&nbsp;
      <a href="<?= $releases_page ?>" target="_blank"
         style="color:var(--accent)">View all releases ↗</a>
    </p>
  </div>

  <!-- Steps -->
  <div class="instructions">
    <h2>🚀 How To Use — 4 Steps</h2>

    <div class="step">
      <div class="step-number">1</div>
      <div class="step-content">
        <h3>Download &amp; Run</h3>
        <p>Download <strong>SecureWipe.exe</strong> above and double-click it — no installation wizard, no next-next-finish.</p>
        <p class="tip">💡 Windows SmartScreen may warn about an unsigned app. Click <strong>More info → Run anyway</strong>. This is normal for any downloaded EXE that isn't commercially code-signed.</p>
      </div>
    </div>

    <div class="step">
      <div class="step-number">2</div>
      <div class="step-content">
        <h3>Enable USB Debugging on your Android phone</h3>
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
        <p>Plug your phone in with a USB cable, then click <strong>"Detect Android Device"</strong> in the tool.</p>
        <p>When the popup appears on your phone, tap <strong>Allow</strong>.</p>
        <div class="code-block">adb devices  ←  the tool runs this automatically</div>
        <p style="font-size:.82rem;color:var(--text-muted);margin-top:8px">
          The device should show as <code style="color:var(--success)">device</code> (not <code style="color:var(--danger)">unauthorized</code>).
        </p>
      </div>
    </div>

    <div class="step">
      <div class="step-number">4</div>
      <div class="step-content">
        <h3>Start Secure Wipe</h3>
        <p>Click <strong>"START SECURE WIPE"</strong>. The tool runs all 4 steps and saves a <strong>wipe certificate</strong> (.txt file) in the same folder when done.</p>
      </div>
    </div>
  </div>

  <!-- iPhone -->
  <div class="download-card" style="border-color:rgba(249,115,22,0.3)">
    <div class="card-icon">🍎</div>
    <h2 style="font-size:1.4rem">iPhone Users</h2>
    <p class="card-description">
      Apple restricts direct USB access from third-party apps. The tool includes a
      built-in <strong>guided mode</strong> for iPhone — it detects your device,
      walks you through the steps on-screen, and generates a certificate at the end.
    </p>
    <p style="font-size:.875rem;color:var(--text-muted)">
      iPhone storage is hardware-encrypted by default. A proper factory reset
      cryptographically destroys the encryption key — data becomes unrecoverable
      without any additional overwrite step.
    </p>
  </div>

  <!-- Troubleshooting -->
  <div class="troubleshooting">
    <h3>🔍 Troubleshooting</h3>

    <div class="trouble-item">
      <h4>"Windows protected your PC" / SmartScreen warning</h4>
      <p>Click <strong>More info → Run anyway</strong>. This appears on any unsigned EXE.
         The full source code is available for review on
         <a href="https://github.com/<?= $repo ?>" target="_blank"
            style="color:var(--accent)">GitHub ↗</a>.</p>
    </div>

    <div class="trouble-item">
      <h4>"No device found" after clicking Detect</h4>
      <p>Check: (1) your USB cable transfers data (not charge-only), (2) USB Debugging is
         enabled in Developer Options, (3) you tapped <strong>Allow</strong> on the phone's
         popup. Try unplugging and reconnecting.</p>
    </div>

    <div class="trouble-item">
      <h4>Device shows "unauthorized"</h4>
      <p>Your phone is waiting for approval. Look for a popup saying "Allow USB Debugging?"
         — tap <strong>Allow</strong>, check "Always allow from this computer", then click
         Detect again.</p>
    </div>

    <div class="trouble-item">
      <h4>Antivirus blocks the tool</h4>
      <p>Add an exception for <code>SecureWipe.exe</code> in your antivirus settings.
         False positives are common with PyInstaller-built executables.</p>
    </div>

    <div class="trouble-item">
      <h4>Tool opens then immediately closes</h4>
      <p>Right-click <code>SecureWipe.exe</code> → <strong>Run as administrator</strong>.</p>
    </div>
  </div>

  <!-- Source -->
  <div class="video-tutorial">
    <h3>🔧 Open Source</h3>
    <p>Full source code on GitHub. The EXE is built automatically via GitHub Actions on every push — no manual compilation needed.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;position:relative;z-index:1">
      <a href="https://github.com/<?= $repo ?>" target="_blank" class="video-btn">⭐ View on GitHub</a>
      <a href="<?= $releases_page ?>" target="_blank" class="video-btn">📦 All Releases</a>
      <a href="https://youtu.be/EdID5Xo1fa8" target="_blank" class="video-btn">▶️ Video Tutorial</a>
    </div>
  </div>

  <div class="alert alert-info" style="margin-top:8px">
    <strong>Android:</strong> Fully automated via ADB. &nbsp;
    <strong>iPhone:</strong> Step-by-step guided mode (Apple restricts direct USB access).
    A wipe certificate is generated for both.
  </div>

</div>

<?php include 'includes/footer.php'; ?>
