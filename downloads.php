<?php
require_once 'includes/config.php';

$total_downloads = 0;
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM erase_logs WHERE tool_type='desktop'");
if ($result) { $row = mysqli_fetch_assoc($result); $total_downloads = $row['count']; }

include 'includes/header.php';
?>

<div class="dl-page">

  <!-- ── Page header ──────────────────────────────────────────── -->
  <div class="dl-page-header">
    <h1>Desktop Wipe Tools</h1>
    <p>Two options depending on how much setup you want to do. Both do the same job.</p>
  </div>

  <!-- ── Comparison strip ─────────────────────────────────────── -->
  <div class="dl-compare">
    <div class="dl-compare-item free">
      <div class="dl-compare-badge free-badge">Free</div>
      <div class="dl-compare-title">SecureWipe Tool</div>
      <div class="dl-compare-sub">Requires a 3-step setup (Python + ADB + script)<br>Opens the reset screen — you tap one button</div>
    </div>
    <div class="dl-compare-vs">or</div>
    <div class="dl-compare-item paid">
      <div class="dl-compare-badge paid-badge">Paid</div>
      <div class="dl-compare-title">Dr.Fone – Data Eraser</div>
      <div class="dl-compare-sub">Install one app, plug in phone, click Erase<br>Fully guided — no manual steps on the phone</div>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════════
       FREE OPTION
  ════════════════════════════════════════════════════════════ -->
  <div class="dl-section">
    <div class="dl-section-label free-label">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      Free Option — SecureWipe Desktop Tool
    </div>

    <p class="dl-section-intro">
      Our own open-source tool. Uses ADB to connect to your phone and open the factory
      reset screen directly — so you only need to tap the final <strong>Erase everything</strong>
      button on the phone. Everything else is handled automatically.
    </p>

    <!-- What it does honestly -->
    <div class="dl-honest-box">
      <div class="dl-honest-title">What it does and doesn't do</div>
      <div class="dl-honest-grid">
        <div class="dl-honest-does">
          <div class="dl-honest-col-title">✅ Does</div>
          <ul>
            <li>Detects your phone and its brand automatically</li>
            <li>Opens the exact factory reset screen on the phone</li>
            <li>Provides brand-specific step-by-step instructions</li>
            <li>Overwrites free storage space with zeros after reset</li>
            <li>Generates a wipe certificate when complete</li>
            <li>Logs the session to this website's admin dashboard</li>
          </ul>
        </div>
        <div class="dl-honest-doesnt">
          <div class="dl-honest-col-title">⚠️ Requires</div>
          <ul>
            <li>Python 3.11 installed on your Windows PC</li>
            <li>ADB (Android Debug Bridge) set up</li>
            <li>USB Debugging enabled on the phone</li>
            <li>One manual tap on the phone to confirm the reset</li>
            <li>Works on Android only (iPhone: guided steps provided)</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Download cards -->
    <div class="dl-free-grid">

      <div class="dl-card dl-card-featured">
        <div class="dl-card-top">
          <div class="dl-card-icon" style="background:rgba(16,185,129,.12);border-color:rgba(16,185,129,.3)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="1.5"><path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"/></svg>
          </div>
          <div>
            <div class="dl-card-name">SecureWipe Tool</div>
            <div class="dl-card-meta">secure_wipe_tool.py · ~50 KB · Step 3 of 3</div>
          </div>
        </div>
        <p class="dl-card-desc">The main tool. Download this last, after Python and ADB are set up.</p>
        <a href="python/secure_wipe_tool.py" class="dl-btn dl-btn-green" download>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Download Tool
        </a>
      </div>

      <div class="dl-card">
        <div class="dl-card-top">
          <div class="dl-card-icon" style="background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.25)">
            <svg viewBox="0 0 24 24" fill="#3b82f6"><path d="M11.998 2C6.477 2 6.818 4.388 6.818 4.388l.006 2.476h5.264v.744H4.71S2 7.3 2 12.87c0 5.57 3.076 5.37 3.076 5.37h1.836v-2.582s-.099-3.076 3.024-3.076h5.207s2.924.047 2.924-2.824V6.824S18.565 2 11.998 2zm-2.89 1.678a.932.932 0 1 1 0 1.864.932.932 0 0 1 0-1.864z"/><path d="M12.002 22c5.521 0 5.18-2.388 5.18-2.388l-.006-2.476h-5.264v-.744h7.378S22 16.7 22 11.13c0-5.57-3.076-5.37-3.076-5.37h-1.836v2.582s.099 3.076-3.024 3.076H8.857s-2.924-.047-2.924 2.824v4.934S5.435 22 12.002 22zm2.89-1.678a.932.932 0 1 1 0-1.864.932.932 0 0 1 0 1.864z"/></svg>
          </div>
          <div>
            <div class="dl-card-name">Python 3.11</div>
            <div class="dl-card-meta">~27 MB · Windows 64-bit · Step 1 of 3</div>
          </div>
        </div>
        <p class="dl-card-desc">Required to run the tool. During install, tick <strong>"Add Python to PATH"</strong>.</p>
        <a href="https://www.python.org/ftp/python/3.11.9/python-3.11.9-amd64.exe"
           class="dl-btn dl-btn-blue" download target="_blank">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Download Python
        </a>
      </div>

      <div class="dl-card">
        <div class="dl-card-top">
          <div class="dl-card-icon" style="background:rgba(245,158,11,.1);border-color:rgba(245,158,11,.25)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.5"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18" stroke-width="2"/><path d="M9 7h6M9 11h4"/></svg>
          </div>
          <div>
            <div class="dl-card-name">ADB Platform Tools</div>
            <div class="dl-card-meta">~8 MB ZIP · Windows · Step 2 of 3</div>
          </div>
        </div>
        <p class="dl-card-desc">Android Debug Bridge — lets the tool talk to the phone over USB.</p>
        <a href="https://dl.google.com/android/repository/platform-tools-latest-windows.zip"
           class="dl-btn dl-btn-amber" download>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Download ADB
        </a>
      </div>

    </div>

    <div class="dl-setup-link">
      Need help setting it up?
      <a href="download-tool.php">Full step-by-step setup guide →</a>
    </div>

    <?php if ($total_downloads > 0): ?>
    <div class="dl-stat-note">
      The SecureWipe tool has been used
      <strong><?= number_format($total_downloads) ?></strong> times so far.
    </div>
    <?php endif; ?>
  </div>

  <!-- ═══════════════════════════════════════════════════════════
       PAID OPTION
  ════════════════════════════════════════════════════════════ -->
  <div class="dl-section">
    <div class="dl-section-label paid-label">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Premium Option — Dr.Fone Data Eraser (Third-Party, Paid)
    </div>

    <!-- Paid warning box -->
    <div class="dl-paid-warning">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;flex-shrink:0;color:var(--warning)"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <div>
        <strong>This is a paid third-party product.</strong>
        Dr.Fone is made by Wondershare, not by SecureWipe.
        A one-time purchase or subscription fee is required before you can use the erase feature.
        We do not earn anything if you click this link — we include it because it is the most
        complete automated option available.
      </div>
    </div>

    <p class="dl-section-intro">
      Dr.Fone – Data Eraser is a professional Windows/Mac application that connects to
      your Android phone via USB and handles the entire wipe process from the PC — no
      manual navigation on the phone required. It is the closest thing to a fully
      automatic wipe without needing a rooted device.
    </p>

    <div class="dl-paid-card">
      <div class="dl-paid-left">
        <div class="dl-paid-logo">Dr.Fone</div>
        <div class="dl-paid-by">by Wondershare</div>
        <div class="dl-paid-features">
          <div class="dl-paid-feature">✅ Fully guided — plug in and click Erase</div>
          <div class="dl-paid-feature">✅ Works on Android and iPhone</div>
          <div class="dl-paid-feature">✅ Overwrites data multiple times</div>
          <div class="dl-paid-feature">✅ No Python or ADB setup needed</div>
          <div class="dl-paid-feature">✅ Generates wipe report</div>
          <div class="dl-paid-feature paid-con">💳 Requires purchase to use erase feature</div>
          <div class="dl-paid-feature paid-con">🌐 Third-party software — not made by us</div>
        </div>
      </div>
      <div class="dl-paid-right">
        <div class="dl-paid-price-note">
          Check current pricing on the Dr.Fone website before downloading.
          A free trial may be available but the erase feature typically requires payment.
        </div>
        <a href="https://drfone.wondershare.com/android-data-eraser.html"
           class="dl-btn dl-btn-paid" target="_blank" rel="noopener noreferrer"
           onclick="return confirm('You are leaving SecureWipe and going to Dr.Fone by Wondershare.\n\nDr.Fone is a PAID third-party product. A purchase is required to use the erase feature.\n\nContinue?')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          Go to Dr.Fone Website
        </a>
        <p class="dl-paid-disclaimer">
          You will leave this website. SecureWipe is not responsible for Dr.Fone's
          pricing, terms, or availability.
        </p>
        <a href="https://drfone.wondershare.com/android-data-eraser.html"
           class="dl-btn-alt-link" target="_blank" rel="noopener noreferrer">
          Read about Dr.Fone first ↗
        </a>
      </div>
    </div>

    <!-- iPhone note -->
    <div class="dl-iphone-note">
      <strong>🍎 iPhone users:</strong>
      Apple does not allow any third-party app — paid or free — to trigger an automatic
      wipe over USB. Both our free tool and Dr.Fone provide step-by-step guided
      instructions for iPhone. The actual erase button must be tapped on the phone by you.
      This is Apple's design, not a limitation of either tool.
    </div>
  </div>

</div><!-- end .dl-page -->

<style>
.dl-page { max-width:960px; margin:0 auto; padding:48px 24px; }

/* ── Page header ─────────────────────────────────────── */
.dl-page-header { text-align:center; margin-bottom:40px; }
.dl-page-header h1 {
  font-family:var(--font-display); font-size:clamp(1.8rem,3vw,2.6rem);
  font-weight:800; letter-spacing:-.5px;
  color:var(--text-primary); margin-bottom:10px;
}
.dl-page-header p { font-size:1.05rem; color:var(--text-secondary); }

/* ── Compare strip ───────────────────────────────────── */
.dl-compare {
  display:flex; align-items:center; justify-content:center;
  gap:0; margin-bottom:44px; flex-wrap:wrap;
}
.dl-compare-item {
  flex:1; min-width:220px; max-width:380px;
  padding:22px 24px;
  background:var(--bg-glass); backdrop-filter:var(--blur-sm);
  border:1px solid var(--border); border-radius:var(--radius-xl);
  transition:all var(--transition);
}
.dl-compare-item.free  { border-color:rgba(16,185,129,.3); }
.dl-compare-item.paid  { border-color:rgba(245,158,11,.3); }
.dl-compare-vs {
  padding:0 24px; font-size:1.1rem; font-weight:700;
  color:var(--text-muted); flex-shrink:0;
}
.dl-compare-badge {
  display:inline-flex; padding:3px 12px; border-radius:20px;
  font-size:.72rem; font-weight:700; letter-spacing:.5px;
  margin-bottom:10px;
}
.free-badge { background:rgba(16,185,129,.1); color:var(--success); border:1px solid rgba(16,185,129,.25); }
.paid-badge { background:rgba(245,158,11,.1);  color:var(--warning); border:1px solid rgba(245,158,11,.25); }
.dl-compare-title { font-family:var(--font-display); font-size:1.1rem; font-weight:700; color:var(--text-primary); margin-bottom:6px; }
.dl-compare-sub { font-size:.82rem; color:var(--text-secondary); line-height:1.5; }

/* ── Section wrapper ─────────────────────────────────── */
.dl-section {
  background:var(--bg-glass); backdrop-filter:var(--blur-sm);
  border:1px solid var(--border); border-radius:var(--radius-2xl);
  padding:32px; margin-bottom:28px;
}
.dl-section-label {
  display:flex; align-items:center; gap:8px;
  font-family:var(--font-display); font-size:1rem; font-weight:700;
  margin-bottom:16px;
}
.dl-section-label svg { width:18px; height:18px; flex-shrink:0; }
.free-label { color:var(--success); }
.paid-label { color:var(--warning); }
.dl-section-intro {
  font-size:.9rem; color:var(--text-secondary);
  line-height:1.65; margin-bottom:22px; max-width:720px;
}

/* ── Honest box ──────────────────────────────────────── */
.dl-honest-box {
  background:var(--bg-elevated); border:1px solid var(--border);
  border-radius:var(--radius-xl); padding:22px; margin-bottom:24px;
}
.dl-honest-title {
  font-family:var(--font-display); font-size:.85rem; font-weight:700;
  color:var(--text-secondary); text-transform:uppercase;
  letter-spacing:.6px; margin-bottom:16px;
}
.dl-honest-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
.dl-honest-col-title { font-size:.82rem; font-weight:700; margin-bottom:10px; color:var(--text-primary); }
.dl-honest-does ul, .dl-honest-doesnt ul { list-style:none; }
.dl-honest-does li, .dl-honest-doesnt li {
  font-size:.82rem; color:var(--text-secondary);
  padding:4px 0; border-bottom:1px solid var(--border);
  padding-left:16px; position:relative;
}
.dl-honest-does li:last-child, .dl-honest-doesnt li:last-child { border-bottom:none; }
.dl-honest-does li::before { content:'✓'; position:absolute; left:0; color:var(--success); font-weight:700; }
.dl-honest-doesnt li::before { content:'→'; position:absolute; left:0; color:var(--text-muted); }

/* ── Free download cards ─────────────────────────────── */
.dl-free-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:18px; }
.dl-card {
  background:var(--bg-elevated); border:1px solid var(--border);
  border-radius:var(--radius-xl); padding:20px;
  display:flex; flex-direction:column; gap:12px;
  transition:all var(--transition);
}
.dl-card:hover { border-color:var(--border-accent); transform:translateY(-2px); }
.dl-card-featured { border-color:rgba(16,185,129,.3); }
.dl-card-top { display:flex; align-items:center; gap:12px; }
.dl-card-icon {
  width:40px; height:40px; flex-shrink:0;
  border:1px solid; border-radius:10px;
  display:flex; align-items:center; justify-content:center;
}
.dl-card-icon svg { width:20px; height:20px; }
.dl-card-name { font-family:var(--font-display); font-size:.95rem; font-weight:700; color:var(--text-primary); }
.dl-card-meta { font-size:.75rem; color:var(--text-muted); margin-top:2px; }
.dl-card-desc { font-size:.82rem; color:var(--text-secondary); flex:1; line-height:1.5; }
.dl-card-desc strong { color:var(--text-primary); }

/* ── Buttons ─────────────────────────────────────────── */
.dl-btn {
  display:flex; align-items:center; justify-content:center; gap:7px;
  padding:10px 16px; border-radius:10px;
  font-size:.875rem; font-weight:700; text-decoration:none;
  transition:all var(--transition);
}
.dl-btn svg { width:15px; height:15px; }
.dl-btn-green { background:rgba(16,185,129,.12); border:1px solid rgba(16,185,129,.3); color:var(--success); }
.dl-btn-green:hover { background:var(--success); color:#fff; box-shadow:0 4px 14px var(--success-glow); }
.dl-btn-blue  { background:rgba(59,130,246,.1); border:1px solid rgba(59,130,246,.25); color:#3b82f6; }
.dl-btn-blue:hover  { background:#3b82f6; color:#fff; }
.dl-btn-amber { background:rgba(245,158,11,.1); border:1px solid rgba(245,158,11,.25); color:var(--warning); }
.dl-btn-amber:hover { background:var(--warning); color:#fff; }
.dl-btn-paid  {
  background:rgba(245,158,11,.12); border:1px solid rgba(245,158,11,.35);
  color:var(--warning); padding:13px 22px; border-radius:12px;
  font-size:.95rem; width:100%; margin-bottom:10px;
}
.dl-btn-paid:hover { background:var(--warning); color:#000; box-shadow:0 4px 18px rgba(245,158,11,.3); }
.dl-btn-alt-link {
  display:block; text-align:center; font-size:.8rem;
  color:var(--text-muted); text-decoration:underline;
  transition:color var(--transition);
}
.dl-btn-alt-link:hover { color:var(--text-secondary); }

/* ── Setup link ──────────────────────────────────────── */
.dl-setup-link {
  font-size:.875rem; color:var(--text-muted); margin-top:4px;
}
.dl-setup-link a { color:var(--accent); font-weight:600; text-decoration:none; }
.dl-setup-link a:hover { text-decoration:underline; }
.dl-stat-note {
  font-size:.82rem; color:var(--text-muted);
  margin-top:12px; padding:10px 14px;
  background:var(--bg-elevated); border-radius:10px;
  border:1px solid var(--border);
}
.dl-stat-note strong { color:var(--text-primary); font-family:var(--font-display); }

/* ── Paid warning ────────────────────────────────────── */
.dl-paid-warning {
  display:flex; gap:12px; align-items:flex-start;
  background:rgba(245,158,11,.07); border:1px solid rgba(245,158,11,.25);
  border-left:4px solid var(--warning);
  border-radius:var(--radius-lg); padding:14px 16px;
  font-size:.875rem; color:var(--text-secondary);
  margin-bottom:20px; line-height:1.6;
}
.dl-paid-warning strong { color:var(--text-primary); }

/* ── Paid card ───────────────────────────────────────── */
.dl-paid-card {
  display:grid; grid-template-columns:1fr 280px; gap:28px;
  background:var(--bg-elevated); border:1px solid rgba(245,158,11,.2);
  border-radius:var(--radius-xl); padding:24px; margin-bottom:18px;
}
.dl-paid-logo {
  font-family:var(--font-display); font-size:1.6rem; font-weight:800;
  color:var(--text-primary); margin-bottom:2px;
}
.dl-paid-by { font-size:.78rem; color:var(--text-muted); margin-bottom:14px; }
.dl-paid-features { display:flex; flex-direction:column; gap:6px; }
.dl-paid-feature { font-size:.82rem; color:var(--text-secondary); }
.paid-con { color:var(--text-muted) !important; }
.dl-paid-right {
  display:flex; flex-direction:column; justify-content:center; gap:8px;
}
.dl-paid-price-note {
  font-size:.8rem; color:var(--text-muted); line-height:1.5;
  margin-bottom:10px;
  padding:10px 12px; background:rgba(245,158,11,.05);
  border:1px solid rgba(245,158,11,.15); border-radius:8px;
}
.dl-paid-disclaimer {
  font-size:.75rem; color:var(--text-muted);
  text-align:center; line-height:1.4; margin:4px 0;
}

/* ── iPhone note ─────────────────────────────────────── */
.dl-iphone-note {
  background:var(--bg-elevated); border:1px solid var(--border);
  border-radius:var(--radius-lg); padding:14px 18px;
  font-size:.84rem; color:var(--text-secondary); line-height:1.6;
}
.dl-iphone-note strong { color:var(--text-primary); }

/* ── Responsive ──────────────────────────────────────── */
@media(max-width:768px){
  .dl-compare { flex-direction:column; align-items:stretch; gap:10px; }
  .dl-compare-vs { text-align:center; padding:6px 0; }
  .dl-free-grid { grid-template-columns:1fr; }
  .dl-honest-grid { grid-template-columns:1fr; }
  .dl-paid-card { grid-template-columns:1fr; }
}
</style>

<?php include 'includes/footer.php'; ?>
