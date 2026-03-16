<?php
require_once 'includes/config.php';

// Track download clicks if you want (optional)
$total_downloads = 0;
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM erase_logs WHERE tool_type='desktop'");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_downloads = $row['count'];
}

include 'includes/header.php';
?>

<div style="max-width:960px;margin:0 auto;padding:48px 24px">

  <!-- Page header -->
  <div style="text-align:center;margin-bottom:48px">
    <h1 style="font-family:var(--font-display);font-size:clamp(1.8rem,3vw,2.6rem);font-weight:800;letter-spacing:-.5px;color:var(--text-primary);margin-bottom:12px">
      Downloads
    </h1>
    <p style="font-size:1.05rem;color:var(--text-secondary);max-width:520px;margin:0 auto">
      Everything you need to securely wipe your device — all free, no account required.
    </p>
  </div>

  <!-- ── FEATURED: Desktop Tool ─────────────────────────────── -->
  <div class="dl-feature-card">
    <div class="dl-feature-left">
      <div class="dl-feature-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
        </svg>
      </div>
      <div>
        <div class="dl-feature-badge">Desktop Application</div>
        <h2 class="dl-feature-title">SecureWipe Tool</h2>
        <p class="dl-feature-desc">
          A Python desktop app that connects directly to your Android phone and guides you
          through a complete four-step secure wipe — encryption check, factory reset,
          storage overwrite, and verification. Generates a wipe certificate when done.
        </p>
        <div class="dl-feature-tags">
          <span class="dl-tag">🐍 Python 3.8+</span>
          <span class="dl-tag">🤖 Android &amp; iPhone</span>
          <span class="dl-tag">📜 Wipe Certificate</span>
          <span class="dl-tag">🆓 Free</span>
        </div>
      </div>
    </div>
    <div class="dl-feature-actions">
      <a href="python/secure_wipe_tool.py" class="btn btn-success btn-large" download>
        <svg style="width:18px;height:18px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Download Tool
      </a>
      <a href="download-tool.php" class="btn btn-ghost" style="font-size:.875rem">
        Setup Guide →
      </a>
      <p style="font-size:.78rem;color:var(--text-muted);margin-top:8px;text-align:center">
        secure_wipe_tool.py · ~50 KB
      </p>
    </div>
  </div>

  <!-- ── Three supporting downloads ────────────────────────── -->
  <h2 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.8px;margin:40px 0 20px">
    Required Components
  </h2>

  <div class="dl-grid">

    <!-- Python -->
    <div class="dl-card">
      <div class="dl-card-icon" style="background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.25)">
        <svg viewBox="0 0 24 24" fill="currentColor" style="color:#3b82f6">
          <path d="M11.998 2C6.477 2 6.818 4.388 6.818 4.388l.006 2.476h5.264v.744H4.71S2 7.3 2 12.87c0 5.57 3.076 5.37 3.076 5.37h1.836v-2.582s-.099-3.076 3.024-3.076h5.207s2.924.047 2.924-2.824V6.824S18.565 2 11.998 2zm-2.89 1.678a.932.932 0 1 1 0 1.864.932.932 0 0 1 0-1.864z"/>
          <path d="M12.002 22c5.521 0 5.18-2.388 5.18-2.388l-.006-2.476h-5.264v-.744h7.378S22 16.7 22 11.13c0-5.57-3.076-5.37-3.076-5.37h-1.836v2.582s.099 3.076-3.024 3.076H8.857s-2.924-.047-2.924 2.824v4.934S5.435 22 12.002 22zm2.89-1.678a.932.932 0 1 1 0-1.864.932.932 0 0 1 0 1.864z"/>
        </svg>
      </div>
      <div class="dl-card-body">
        <h3 class="dl-card-title">Python 3.11</h3>
        <p class="dl-card-desc">Required runtime to run the SecureWipe tool. Free, official installer from python.org.</p>
        <div class="dl-card-meta">
          <span>~27 MB</span>
          <span>Windows 64-bit</span>
        </div>
      </div>
      <a href="https://www.python.org/ftp/python/3.11.9/python-3.11.9-amd64.exe"
         class="dl-card-btn" target="_blank" download>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Download
      </a>
    </div>

    <!-- ADB -->
    <div class="dl-card">
      <div class="dl-card-icon" style="background:rgba(16,185,129,.1);border-color:rgba(16,185,129,.25)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:#10b981">
          <rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>
          <path d="M9 7h6M9 11h4"/>
        </svg>
      </div>
      <div class="dl-card-body">
        <h3 class="dl-card-title">ADB Platform Tools</h3>
        <p class="dl-card-desc">Android Debug Bridge — lets the tool communicate with your phone over USB. Official Google release.</p>
        <div class="dl-card-meta">
          <span>~8 MB ZIP</span>
          <span>Windows</span>
        </div>
      </div>
      <a href="https://dl.google.com/android/repository/platform-tools-latest-windows.zip"
         class="dl-card-btn" style="background:rgba(16,185,129,.1);border-color:rgba(16,185,129,.25);color:var(--success)" download>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Download
      </a>
    </div>

    <!-- ADB Mirror -->
    <div class="dl-card">
      <div class="dl-card-icon" style="background:rgba(245,158,11,.1);border-color:rgba(245,158,11,.25)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--warning)">
          <path d="M21 2H3v16h5v4l4-4h4l5-5V2z"/><line x1="12" y1="8" x2="12" y2="12"/><dot cx="12" cy="16" r="1"/>
          <circle cx="12" cy="16" r="1" fill="currentColor"/>
        </svg>
      </div>
      <div class="dl-card-body">
        <h3 class="dl-card-title">ADB Mirror</h3>
        <p class="dl-card-desc">Alternative download link for ADB if the Google link is slow or unavailable in your region.</p>
        <div class="dl-card-meta">
          <span>~8 MB ZIP</span>
          <span>Windows</span>
        </div>
      </div>
      <a href="https://androidfilehost.com/?fid=platform-tools-latest-windows"
         class="dl-card-btn" style="background:rgba(245,158,11,.1);border-color:rgba(245,158,11,.25);color:var(--warning)" target="_blank">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        Mirror
      </a>
    </div>

  </div>

  <!-- ── Download order notice ──────────────────────────────── -->
  <div class="dl-order-card">
    <div class="dl-order-title">
      <svg style="width:18px;height:18px;flex-shrink:0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Download in this order
    </div>
    <div class="dl-order-steps">
      <div class="dl-order-step">
        <div class="dl-order-num">1</div>
        <div>
          <strong>Python 3.11</strong>
          <span>Install it — tick "Add to PATH" on the first screen</span>
        </div>
      </div>
      <div class="dl-order-arrow">→</div>
      <div class="dl-order-step">
        <div class="dl-order-num">2</div>
        <div>
          <strong>ADB Platform Tools</strong>
          <span>Extract the ZIP to <code>C:\platform-tools</code></span>
        </div>
      </div>
      <div class="dl-order-arrow">→</div>
      <div class="dl-order-step">
        <div class="dl-order-num">3</div>
        <div>
          <strong>SecureWipe Tool</strong>
          <span>Put in same folder as adb.exe, double-click to run</span>
        </div>
      </div>
    </div>
    <a href="download-tool.php" style="display:inline-flex;align-items:center;gap:6px;margin-top:18px;font-size:.875rem;font-weight:600;color:var(--accent);text-decoration:none">
      Full step-by-step setup guide →
    </a>
  </div>

  <!-- ── Stats strip ────────────────────────────────────────── -->
  <?php if ($total_downloads > 0): ?>
  <div style="text-align:center;margin:40px 0 0;padding:24px;background:var(--bg-glass);backdrop-filter:blur(10px);border:1px solid var(--border);border-radius:16px">
    <p style="font-size:.875rem;color:var(--text-muted)">
      The desktop tool has been used
      <strong style="color:var(--text-primary);font-family:var(--font-display);font-size:1.1rem"><?= number_format($total_downloads) ?></strong>
      times so far.
    </p>
  </div>
  <?php endif; ?>

</div>

<style>
/* ── Feature card ──────────────────────────────── */
.dl-feature-card {
  display: flex;
  gap: 32px;
  align-items: flex-start;
  background: var(--bg-glass);
  backdrop-filter: blur(14px);
  border: 1px solid var(--border-accent);
  border-radius: 24px;
  padding: 32px;
  margin-bottom: 12px;
  box-shadow: 0 0 0 1px var(--accent-glow), var(--shadow-md);
  transition: box-shadow .25s;
}
.dl-feature-card:hover { box-shadow: 0 0 0 1px var(--accent-glow), var(--shadow-lg); }

.dl-feature-left { display:flex; gap:20px; flex:1; min-width:0; }

.dl-feature-icon {
  width: 56px; height: 56px; flex-shrink: 0;
  background: rgba(14,165,233,.1);
  border: 1px solid var(--border-accent);
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  color: var(--accent);
}
.dl-feature-icon svg { width:26px; height:26px; }

.dl-feature-badge {
  display: inline-flex;
  background: rgba(14,165,233,.1);
  border: 1px solid var(--border-accent);
  color: var(--accent);
  font-size: .72rem; font-weight: 700; letter-spacing: .4px;
  padding: 3px 10px; border-radius: 20px; margin-bottom: 8px;
}
.dl-feature-title {
  font-family: var(--font-display);
  font-size: 1.5rem; font-weight: 800;
  color: var(--text-primary); letter-spacing: -.3px;
  margin-bottom: 8px;
}
.dl-feature-desc {
  font-size: .9rem; color: var(--text-secondary);
  line-height: 1.6; margin-bottom: 14px; max-width: 480px;
}
.dl-feature-tags { display:flex; flex-wrap:wrap; gap:6px; }
.dl-tag {
  font-size: .78rem; font-weight: 600;
  background: var(--bg-elevated);
  border: 1px solid var(--border);
  color: var(--text-secondary);
  padding: 4px 10px; border-radius: 20px;
}

.dl-feature-actions {
  display: flex; flex-direction: column; align-items: center;
  gap: 10px; flex-shrink: 0; min-width: 150px;
}

/* ── Grid of supporting downloads ──────────────── */
.dl-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}

.dl-card {
  background: var(--bg-glass);
  backdrop-filter: blur(10px);
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 22px;
  display: flex;
  flex-direction: column;
  gap: 14px;
  transition: all .22s;
}
.dl-card:hover { border-color: var(--border-accent); box-shadow: var(--shadow-md); transform: translateY(-3px); }

.dl-card-icon {
  width: 46px; height: 46px;
  border: 1px solid;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
}
.dl-card-icon svg { width: 22px; height: 22px; }

.dl-card-body { flex: 1; }
.dl-card-title {
  font-family: var(--font-display);
  font-size: 1rem; font-weight: 700;
  color: var(--text-primary); margin-bottom: 6px;
}
.dl-card-desc { font-size: .82rem; color: var(--text-secondary); line-height: 1.55; margin-bottom: 10px; }
.dl-card-meta { display:flex; gap:8px; flex-wrap:wrap; }
.dl-card-meta span {
  font-size: .72rem; background: var(--bg-elevated);
  border: 1px solid var(--border);
  color: var(--text-muted); padding: 2px 8px; border-radius: 10px;
}

.dl-card-btn {
  display: flex; align-items: center; justify-content: center; gap: 7px;
  padding: 10px 16px;
  background: rgba(14,165,233,.1);
  border: 1px solid var(--border-accent);
  border-radius: 10px;
  font-size: .875rem; font-weight: 700;
  color: var(--accent);
  text-decoration: none;
  transition: all .2s;
}
.dl-card-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 14px var(--accent-glow); }
.dl-card-btn svg { width:15px; height:15px; }

/* ── Download order card ────────────────────────── */
.dl-order-card {
  background: var(--bg-elevated);
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 24px 28px;
  margin-bottom: 8px;
}
.dl-order-title {
  display: flex; align-items: center; gap: 8px;
  font-family: var(--font-display);
  font-size: .9rem; font-weight: 700;
  color: var(--text-primary); margin-bottom: 18px;
}
.dl-order-steps {
  display: flex; align-items: center;
  gap: 12px; flex-wrap: wrap;
}
.dl-order-step {
  display: flex; align-items: center; gap: 12px;
  flex: 1; min-width: 160px;
}
.dl-order-num {
  width: 30px; height: 30px; flex-shrink: 0;
  background: rgba(14,165,233,.1);
  border: 1.5px solid var(--border-accent);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: var(--font-display);
  font-size: .85rem; font-weight: 700; color: var(--accent);
}
.dl-order-step strong { display:block; font-size:.875rem; color:var(--text-primary); margin-bottom:2px; }
.dl-order-step span  { font-size:.78rem; color:var(--text-muted); }
.dl-order-step code  { font-family:monospace; font-size:.78rem; color:var(--accent); }
.dl-order-arrow { font-size:1.1rem; color:var(--text-muted); flex-shrink:0; }

/* ── Responsive ─────────────────────────────────── */
@media(max-width:768px) {
  .dl-feature-card { flex-direction:column; }
  .dl-feature-left { flex-direction:column; }
  .dl-feature-actions { width:100%; }
  .dl-grid { grid-template-columns:1fr; }
  .dl-order-steps { flex-direction:column; align-items:flex-start; }
  .dl-order-arrow { transform:rotate(90deg); }
}
@media(max-width:480px) {
  .dl-feature-card { padding:20px; }
}
</style>

<?php include 'includes/footer.php'; ?>
