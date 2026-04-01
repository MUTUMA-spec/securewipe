<?php
require_once 'includes/config.php';

$total_downloads = 0;
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM erase_logs WHERE tool_type='desktop'");
if ($result) { $row = mysqli_fetch_assoc($result); $total_downloads = $row['count']; }

// ── GitHub Release URL ─────────────────────────────────────────
// Update this URL each time you make a new GitHub Release
$github_exe_url  = "https://github.com/MUTUMA-spec/securewipe/releases/download/v1.0/SecureWipe.exe";
$github_releases = "https://github.com/MUTUMA-spec/securewipe/releases";

include 'includes/header.php';
?>

<div class="dl-page">

  <!-- Page header -->
  <div class="dl-page-header">
    <h1>Desktop Wipe Tools</h1>
    <p>Two options depending on how much you want to spend. Both achieve the same result.</p>
  </div>

  <!-- Side-by-side comparison -->
  <div class="dl-compare">
    <div class="dl-compare-item free">
      <div class="dl-compare-badge free-badge">Free</div>
      <div class="dl-compare-title">SecureWipe.exe</div>
      <div class="dl-compare-sub">
        One file. Double-click. No setup required.<br>
        Opens the reset screen — you tap one confirm button on the phone.
      </div>
    </div>
    <div class="dl-compare-vs">or</div>
    <div class="dl-compare-item paid">
      <div class="dl-compare-badge paid-badge">Paid</div>
      <div class="dl-compare-title">Dr.Fone – Data Eraser</div>
      <div class="dl-compare-sub">
        Install one app, plug in phone, click Erase.<br>
        Fully guided — no manual steps on the phone at all.
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       FREE SECTION
  ═══════════════════════════════════════════ -->
  <div class="dl-section">
    <div class="dl-section-label free-label">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
           stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      Free Option — SecureWipe Desktop Tool
    </div>

    <p class="dl-section-intro">
      A standalone Windows application — Python runtime, ADB, and all dependencies
      are bundled inside a single file. Nothing to install. Just download and run.
    </p>

    <!-- Honest capability box -->
    <div class="dl-honest-box">
      <div class="dl-honest-grid">
        <div class="dl-honest-does">
          <div class="dl-honest-col-title">✅ What it does</div>
          <ul>
            <li>Detects your phone brand automatically via USB</li>
            <li>Opens the factory reset screen directly on the phone</li>
            <li>Gives brand-specific step-by-step instructions</li>
            <li>Overwrites free storage with zeros after reset</li>
            <li>Generates a wipe certificate when complete</li>
          </ul>
        </div>
        <div class="dl-honest-doesnt">
          <div class="dl-honest-col-title">⚠️ What you still need to do</div>
          <ul>
            <li>Enable USB Debugging on the phone once</li>
            <li>Tap <strong>Allow</strong> on the phone's USB popup</li>
            <li>Tap the final <strong>Erase everything</strong> on the phone</li>
            <li>Windows 10 or 11 PC required</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Main download card — links to GitHub Releases -->
    <div class="dl-exe-card">
      <div class="dl-exe-left">
        <div class="dl-exe-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="1.5"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"/>
          </svg>
        </div>
        <div>
          <div class="dl-exe-name">SecureWipe.exe</div>
          <div class="dl-exe-meta">
            Windows 10/11 &nbsp;·&nbsp; 64-bit &nbsp;·&nbsp;
            ~15 MB &nbsp;·&nbsp; No installation required
          </div>
        </div>
      </div>
      <div class="dl-exe-buttons">
        <a href="download-proxy.php" class="dl-btn dl-btn-green">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" y1="15" x2="12" y2="3"/>
          </svg>
          Download SecureWipe.exe
        </a>
        <a href="<?= $github_releases ?>" class="dl-btn-releases" target="_blank">
          All releases ↗
        </a>
      </div>
    </div>

    <!-- SmartScreen note -->
    <div class="dl-smartscreen-note">
      <strong>💡 Windows SmartScreen warning?</strong>
      This is normal for any downloaded EXE that is not commercially code-signed.
      When the warning appears: click <strong>More info</strong> then <strong>Run anyway</strong>.
      The full source code is available on
      <a href="<?= $github_releases ?>" target="_blank">GitHub</a>.
    </div>

    <!-- Advanced / Python fallback collapsed -->
    <details class="dl-advanced">
      <summary>Advanced users — run the Python script directly</summary>
      <div class="dl-advanced-body">
        <p>If you already have Python 3.11 and ADB set up, you can run the script without the EXE.</p>
        <div class="dl-free-grid">
          <div class="dl-card">
            <div class="dl-card-top">
              <div class="dl-card-icon" style="background:rgba(16,185,129,.1);border-color:rgba(16,185,129,.25)">
                <svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="1.5"><path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"/></svg>
              </div>
              <div>
                <div class="dl-card-name">secure_wipe_tool.py</div>
                <div class="dl-card-meta">Python script · ~50 KB</div>
              </div>
            </div>
            <p class="dl-card-desc">The tool source. Requires Python 3.11 and ADB already installed.</p>
            <a href="python/secure_wipe_tool.py" class="dl-btn dl-btn-green" download>Download .py</a>
          </div>
          <div class="dl-card">
            <div class="dl-card-top">
              <div class="dl-card-icon" style="background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.25)">
                <svg viewBox="0 0 24 24" fill="#3b82f6"><path d="M11.998 2C6.477 2 6.818 4.388 6.818 4.388l.006 2.476h5.264v.744H4.71S2 7.3 2 12.87c0 5.57 3.076 5.37 3.076 5.37h1.836v-2.582s-.099-3.076 3.024-3.076h5.207s2.924.047 2.924-2.824V6.824S18.565 2 11.998 2zm-2.89 1.678a.932.932 0 1 1 0 1.864.932.932 0 0 1 0-1.864z"/><path d="M12.002 22c5.521 0 5.18-2.388 5.18-2.388l-.006-2.476h-5.264v-.744h7.378S22 16.7 22 11.13c0-5.57-3.076-5.37-3.076-5.37h-1.836v2.582s.099 3.076-3.024 3.076H8.857s-2.924-.047-2.924 2.824v4.934S5.435 22 12.002 22zm2.89-1.678a.932.932 0 1 1 0-1.864.932.932 0 0 1 0 1.864z"/></svg>
              </div>
              <div>
                <div class="dl-card-name">Python 3.11</div>
                <div class="dl-card-meta">~27 MB · Windows 64-bit</div>
              </div>
            </div>
            <p class="dl-card-desc">Tick <strong>"Add to PATH"</strong> during install.</p>
            <a href="https://www.python.org/ftp/python/3.11.9/python-3.11.9-amd64.exe"
               class="dl-btn dl-btn-blue" target="_blank">Download Python</a>
          </div>
          <div class="dl-card">
            <div class="dl-card-top">
              <div class="dl-card-icon" style="background:rgba(245,158,11,.1);border-color:rgba(245,158,11,.25)">
                <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.5"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18" stroke-width="2"/><path d="M9 7h6M9 11h4"/></svg>
              </div>
              <div>
                <div class="dl-card-name">ADB Platform Tools</div>
                <div class="dl-card-meta">~8 MB ZIP · Windows</div>
              </div>
            </div>
            <p class="dl-card-desc">Extract and copy adb.exe to the tool folder.</p>
            <a href="https://dl.google.com/android/repository/platform-tools-latest-windows.zip"
               class="dl-btn dl-btn-amber" download>Download ADB</a>
          </div>
        </div>
        <div class="dl-setup-link"><a href="download-tool.php">Full setup guide →</a></div>
      </div>
    </details>

    <?php if ($total_downloads > 0): ?>
    <div class="dl-stat-note">
      The SecureWipe tool has been used
      <strong><?= number_format($total_downloads) ?></strong> times so far.
    </div>
    <?php endif; ?>
  </div>

  <!-- ══════════════════════════════════════════
       PAID SECTION
  ═══════════════════════════════════════════ -->
  <div class="dl-section">
    <div class="dl-section-label paid-label">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
           stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      Premium Option — Dr.Fone Data Eraser (Third-Party, Paid)
    </div>

    <div class="dl-paid-warning">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
           stroke-linecap="round" stroke-linejoin="round"
           style="width:20px;height:20px;flex-shrink:0;color:var(--warning)">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      <div>
        <strong>This is a paid third-party product.</strong>
        Dr.Fone is made by Wondershare — not by SecureWipe.
        A purchase is required before you can use the erase feature.
        We do not earn anything if you click this link.
      </div>
    </div>

    <p class="dl-section-intro">
      Dr.Fone connects to your phone via USB and handles the entire wipe from the PC —
      no manual navigation on the phone required. It is the closest thing to a fully
      automatic wipe on an unrooted device.
    </p>

    <div class="dl-paid-card">
      <div class="dl-paid-left">
        <div class="dl-paid-logo">Dr.Fone</div>
        <div class="dl-paid-by">by Wondershare</div>
        <div class="dl-paid-features">
          <div class="dl-paid-feature">✅ Plug in phone, click Erase — fully guided from PC</div>
          <div class="dl-paid-feature">✅ Works on Android and iPhone</div>
          <div class="dl-paid-feature">✅ Multiple overwrite passes</div>
          <div class="dl-paid-feature">✅ No Python, ADB, or manual setup needed</div>
          <div class="dl-paid-feature paid-con">💳 Purchase required to use erase feature</div>
          <div class="dl-paid-feature paid-con">🌐 Third-party — not made by this project</div>
        </div>
      </div>
      <div class="dl-paid-right">
        <div class="dl-paid-price-note">
          Check current pricing on the Dr.Fone website before downloading.
          A free trial may exist but the erase feature requires payment.
        </div>
        <a href="https://drfone.wondershare.com/android-data-eraser.html"
           class="dl-btn dl-btn-paid" target="_blank" rel="noopener noreferrer"
           onclick="return confirm(
             'You are leaving SecureWipe and going to Dr.Fone by Wondershare.\n\n' +
             'Dr.Fone is a PAID third-party product.\n' +
             'A purchase is required to use the erase feature.\n\n' +
             'Continue to Dr.Fone website?')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
          </svg>
          Go to Dr.Fone Website
        </a>
        <p class="dl-paid-disclaimer">
          You will leave this website. SecureWipe is not responsible for Dr.Fone's
          pricing, terms, or availability.
        </p>
      </div>
    </div>

    <div class="dl-iphone-note">
      <strong>🍎 iPhone users:</strong>
      Apple does not allow any third-party app — paid or free — to trigger a wipe over USB.
      Both tools provide guided step-by-step instructions. The final erase button must be
      tapped on the phone. This is Apple's security design, not a limitation of either tool.
    </div>
  </div>

</div>

<style>
.dl-page{max-width:960px;margin:0 auto;padding:48px 24px}
.dl-page-header{text-align:center;margin-bottom:40px}
.dl-page-header h1{font-family:var(--font-display);font-size:clamp(1.8rem,3vw,2.6rem);font-weight:800;letter-spacing:-.5px;color:var(--text-primary);margin-bottom:10px}
.dl-page-header p{font-size:1.05rem;color:var(--text-secondary)}
.dl-compare{display:flex;align-items:stretch;gap:0;margin-bottom:44px;flex-wrap:wrap}
.dl-compare-item{flex:1;min-width:220px;padding:22px 24px;background:var(--bg-glass);backdrop-filter:blur(10px);border:1px solid var(--border);border-radius:var(--radius-xl);transition:all .22s}
.dl-compare-item.free{border-color:rgba(16,185,129,.3)}
.dl-compare-item.paid{border-color:rgba(245,158,11,.3)}
.dl-compare-vs{display:flex;align-items:center;padding:0 20px;font-size:1rem;font-weight:700;color:var(--text-muted);flex-shrink:0}
.dl-compare-badge{display:inline-flex;padding:3px 12px;border-radius:20px;font-size:.72rem;font-weight:700;letter-spacing:.5px;margin-bottom:10px}
.free-badge{background:rgba(16,185,129,.1);color:var(--success);border:1px solid rgba(16,185,129,.25)}
.paid-badge{background:rgba(245,158,11,.1);color:var(--warning);border:1px solid rgba(245,158,11,.25)}
.dl-compare-title{font-family:var(--font-display);font-size:1.05rem;font-weight:700;color:var(--text-primary);margin-bottom:6px}
.dl-compare-sub{font-size:.82rem;color:var(--text-secondary);line-height:1.55}
.dl-section{background:var(--bg-glass);backdrop-filter:blur(10px);border:1px solid var(--border);border-radius:24px;padding:32px;margin-bottom:28px}
.dl-section-label{display:flex;align-items:center;gap:8px;font-family:var(--font-display);font-size:1rem;font-weight:700;margin-bottom:16px}
.dl-section-label svg{width:18px;height:18px;flex-shrink:0}
.free-label{color:var(--success)}
.paid-label{color:var(--warning)}
.dl-section-intro{font-size:.9rem;color:var(--text-secondary);line-height:1.65;margin-bottom:22px;max-width:720px}
.dl-honest-box{background:var(--bg-elevated);border:1px solid var(--border);border-radius:16px;padding:22px;margin-bottom:22px}
.dl-honest-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
.dl-honest-col-title{font-size:.82rem;font-weight:700;margin-bottom:10px;color:var(--text-primary)}
.dl-honest-does ul,.dl-honest-doesnt ul{list-style:none;padding:0;margin:0}
.dl-honest-does li,.dl-honest-doesnt li{font-size:.82rem;color:var(--text-secondary);padding:5px 0 5px 18px;border-bottom:1px solid var(--border);position:relative}
.dl-honest-does li:last-child,.dl-honest-doesnt li:last-child{border-bottom:none}
.dl-honest-does li::before{content:'✓';position:absolute;left:0;color:var(--success);font-weight:700}
.dl-honest-doesnt li::before{content:'→';position:absolute;left:0;color:var(--text-muted)}
.dl-honest-doesnt li strong{color:var(--text-primary)}
.dl-exe-card{display:flex;align-items:center;justify-content:space-between;gap:20px;background:var(--bg-elevated);border:1px solid rgba(16,185,129,.3);border-radius:16px;padding:22px 24px;margin-bottom:14px;flex-wrap:wrap}
.dl-exe-left{display:flex;align-items:center;gap:16px;flex:1}
.dl-exe-icon{width:48px;height:48px;background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.dl-exe-icon svg{width:24px;height:24px}
.dl-exe-name{font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--text-primary);margin-bottom:4px}
.dl-exe-meta{font-size:.78rem;color:var(--text-muted)}
.dl-exe-buttons{display:flex;flex-direction:column;align-items:center;gap:8px;flex-shrink:0}
.dl-btn-releases{font-size:.78rem;color:var(--text-muted);text-decoration:none;transition:color .2s}
.dl-btn-releases:hover{color:var(--accent)}
.dl-smartscreen-note{background:rgba(14,165,233,.06);border:1px solid rgba(14,165,233,.2);border-radius:12px;padding:12px 16px;font-size:.82rem;color:var(--text-secondary);margin-bottom:18px}
.dl-smartscreen-note strong{color:var(--text-primary)}
.dl-smartscreen-note a{color:var(--accent);text-decoration:none}
.dl-smartscreen-note a:hover{text-decoration:underline}
.dl-advanced{margin-bottom:14px}
.dl-advanced summary{font-size:.875rem;color:var(--text-muted);cursor:pointer;padding:8px 0;list-style:none;display:flex;align-items:center;gap:6px}
.dl-advanced summary::before{content:'▶';font-size:.7rem;transition:transform .2s}
.dl-advanced[open] summary::before{transform:rotate(90deg)}
.dl-advanced summary:hover{color:var(--text-secondary)}
.dl-advanced-body{padding-top:14px}
.dl-advanced-body>p{font-size:.875rem;color:var(--text-secondary);margin-bottom:14px}
.dl-free-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:14px}
.dl-card{background:var(--bg-elevated);border:1px solid var(--border);border-radius:16px;padding:18px;display:flex;flex-direction:column;gap:10px;transition:all .22s}
.dl-card:hover{border-color:var(--border-accent);transform:translateY(-2px)}
.dl-card-top{display:flex;align-items:center;gap:10px}
.dl-card-icon{width:36px;height:36px;flex-shrink:0;border:1px solid;border-radius:9px;display:flex;align-items:center;justify-content:center}
.dl-card-icon svg{width:18px;height:18px}
.dl-card-name{font-family:var(--font-display);font-size:.9rem;font-weight:700;color:var(--text-primary)}
.dl-card-meta{font-size:.72rem;color:var(--text-muted);margin-top:2px}
.dl-card-desc{font-size:.8rem;color:var(--text-secondary);flex:1;line-height:1.5}
.dl-card-desc strong{color:var(--text-primary)}
.dl-btn{display:flex;align-items:center;justify-content:center;gap:7px;padding:10px 16px;border-radius:10px;font-size:.875rem;font-weight:700;text-decoration:none;transition:all .2s;border:1px solid transparent}
.dl-btn svg{width:14px;height:14px}
.dl-btn-green{background:rgba(16,185,129,.12);border-color:rgba(16,185,129,.3);color:var(--success)}
.dl-btn-green:hover{background:var(--success);color:#fff;box-shadow:0 4px 14px rgba(16,185,129,.3)}
.dl-btn-blue{background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.25);color:#3b82f6}
.dl-btn-blue:hover{background:#3b82f6;color:#fff}
.dl-btn-amber{background:rgba(245,158,11,.1);border-color:rgba(245,158,11,.25);color:var(--warning)}
.dl-btn-amber:hover{background:var(--warning);color:#fff}
.dl-setup-link{font-size:.82rem;color:var(--text-muted)}
.dl-setup-link a{color:var(--accent);font-weight:600;text-decoration:none}
.dl-setup-link a:hover{text-decoration:underline}
.dl-stat-note{font-size:.82rem;color:var(--text-muted);margin-top:12px;padding:10px 14px;background:var(--bg-elevated);border-radius:10px;border:1px solid var(--border)}
.dl-stat-note strong{color:var(--text-primary);font-family:var(--font-display)}
.dl-paid-warning{display:flex;gap:12px;align-items:flex-start;background:rgba(245,158,11,.07);border:1px solid rgba(245,158,11,.25);border-left:4px solid var(--warning);border-radius:12px;padding:14px 16px;font-size:.875rem;color:var(--text-secondary);margin-bottom:20px;line-height:1.6}
.dl-paid-warning strong{color:var(--text-primary)}
.dl-paid-card{display:grid;grid-template-columns:1fr 280px;gap:28px;background:var(--bg-elevated);border:1px solid rgba(245,158,11,.2);border-radius:16px;padding:24px;margin-bottom:18px}
.dl-paid-logo{font-family:var(--font-display);font-size:1.6rem;font-weight:800;color:var(--text-primary);margin-bottom:2px}
.dl-paid-by{font-size:.78rem;color:var(--text-muted);margin-bottom:14px}
.dl-paid-features{display:flex;flex-direction:column;gap:6px}
.dl-paid-feature{font-size:.82rem;color:var(--text-secondary)}
.paid-con{color:var(--text-muted)!important}
.dl-paid-right{display:flex;flex-direction:column;justify-content:center;gap:8px}
.dl-paid-price-note{font-size:.8rem;color:var(--text-muted);line-height:1.5;margin-bottom:10px;padding:10px 12px;background:rgba(245,158,11,.05);border:1px solid rgba(245,158,11,.15);border-radius:8px}
.dl-btn-paid{display:flex;align-items:center;justify-content:center;gap:8px;padding:13px 22px;border-radius:12px;font-size:.95rem;font-weight:700;text-decoration:none;background:rgba(245,158,11,.12);border:1px solid rgba(245,158,11,.35);color:var(--warning);width:100%;box-sizing:border-box;margin-bottom:10px;transition:all .2s}
.dl-btn-paid:hover{background:var(--warning);color:#000;box-shadow:0 4px 18px rgba(245,158,11,.3)}
.dl-btn-paid svg{width:16px;height:16px}
.dl-paid-disclaimer{font-size:.75rem;color:var(--text-muted);text-align:center;line-height:1.4;margin:4px 0}
.dl-iphone-note{background:var(--bg-elevated);border:1px solid var(--border);border-radius:12px;padding:14px 18px;font-size:.84rem;color:var(--text-secondary);line-height:1.6}
.dl-iphone-note strong{color:var(--text-primary)}
@media(max-width:768px){
  .dl-compare{flex-direction:column;gap:10px}
  .dl-compare-vs{justify-content:center;padding:4px 0}
  .dl-free-grid{grid-template-columns:1fr}
  .dl-honest-grid{grid-template-columns:1fr}
  .dl-paid-card{grid-template-columns:1fr}
  .dl-exe-card{flex-direction:column;align-items:flex-start}
  .dl-exe-buttons{width:100%}
}
</style>

<?php include 'includes/footer.php'; ?>
