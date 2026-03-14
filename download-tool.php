<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<div class="download-container" style="max-width:960px">

  <!-- Page header -->
  <div class="download-header">
    <h1>🖥️ Desktop Tool Setup</h1>
    <p class="lead">Three things to download and set up — follow each tab in order.</p>

    <!-- Progress overview -->
    <div style="display:flex;justify-content:center;align-items:center;gap:0;margin-top:28px;flex-wrap:wrap">
      <div class="setup-pill active-pill">① Python</div>
      <div class="pill-arrow">→</div>
      <div class="setup-pill">② ADB</div>
      <div class="pill-arrow">→</div>
      <div class="setup-pill">③ SecureWipe Tool</div>
      <div class="pill-arrow">→</div>
      <div class="setup-pill" style="background:rgba(16,185,129,.12);border-color:rgba(16,185,129,.3);color:var(--success)">✅ Ready</div>
    </div>
  </div>

  <!-- Tab buttons -->
  <div class="device-tabs" style="margin-bottom:0;border-bottom:1px solid var(--border);padding-bottom:0;border-radius:0;background:transparent;gap:4px">
    <button class="dl-tab-btn active" onclick="showTab('python',this)">
      <span style="font-size:1.3rem">🐍</span><br>
      <strong>Step 1</strong><br>
      <span style="font-size:.78rem;opacity:.7">Install Python</span>
    </button>
    <button class="dl-tab-btn" onclick="showTab('adb',this)">
      <span style="font-size:1.3rem">🔧</span><br>
      <strong>Step 2</strong><br>
      <span style="font-size:.78rem;opacity:.7">Set Up ADB</span>
    </button>
    <button class="dl-tab-btn" onclick="showTab('tool',this)">
      <span style="font-size:1.3rem">🛡️</span><br>
      <strong>Step 3</strong><br>
      <span style="font-size:.78rem;opacity:.7">Run the Tool</span>
    </button>
    <button class="dl-tab-btn" onclick="showTab('troubleshoot',this)">
      <span style="font-size:1.3rem">🔍</span><br>
      <strong>Troubleshoot</strong><br>
      <span style="font-size:.78rem;opacity:.7">Fix common issues</span>
    </button>
  </div>

  <!-- ═══════════════════════════════════════════════════════
       TAB 1 — PYTHON
       ═══════════════════════════════════════════════════════ -->
  <div id="tab-python" class="dl-tab-content active">

    <div class="setup-section-header">
      <div class="setup-badge">Step 1 of 3</div>
      <h2>Install Python</h2>
      <p>Python is the language the SecureWipe tool is written in. You install it once and it stays on your computer.</p>
    </div>

    <!-- Download card -->
    <div class="setup-download-card">
      <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap">
        <div style="font-size:3rem">🐍</div>
        <div style="flex:1">
          <h3 style="font-family:var(--font-display);font-size:1.2rem;color:var(--text-primary);margin-bottom:4px">Python 3.11 for Windows</h3>
          <p style="color:var(--text-muted);font-size:.875rem">Official installer from python.org · ~27 MB</p>
        </div>
        <a href="https://www.python.org/ftp/python/3.11.9/python-3.11.9-amd64.exe"
           class="btn btn-primary" target="_blank" download>
          ⬇️ Download Python 3.14
        </a>
      </div>
    </div>

    <!-- Steps -->
    <div class="setup-steps-card">
      <h3 class="steps-heading">Installation steps</h3>

      <div class="setup-step">
        <div class="setup-step-num">1</div>
        <div class="setup-step-body">
          <h4>Run the installer</h4>
          <p>Open the file you just downloaded: <code>python-3.11.9-amd64.exe</code></p>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">2</div>
        <div class="setup-step-body">
          <h4>⚠️ Check "Add Python to PATH" — this is critical</h4>
          <p>At the bottom of the first installer screen, tick the box that says
             <strong>"Add python.exe to PATH"</strong> before clicking anything else.</p>
          <div class="callout callout-warning">
            <strong>If you skip this step</strong>, the tool will not be able to find Python
            and will show an error. If you already installed Python without it, uninstall
            Python and reinstall with the box checked.
          </div>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">3</div>
        <div class="setup-step-body">
          <h4>Click "Install Now"</h4>
          <p>Use the default settings. The installation takes about 1–2 minutes.</p>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">4</div>
        <div class="setup-step-body">
          <h4>Verify the installation</h4>
          <p>Press <kbd>Win + R</kbd>, type <code>cmd</code>, press Enter. In the black
             window that opens, type:</p>
          <div class="code-block">python --version</div>
          <p style="margin-top:8px">You should see:</p>
          <div class="code-output">Python 3.11.9</div>
          <div class="callout callout-success">
            ✅ If you see a version number, Python is installed correctly. Move to Step 2.
          </div>
          <div class="callout callout-danger" style="margin-top:8px">
            ❌ If you see <strong>"'python' is not recognized"</strong> — you missed the
            "Add to PATH" checkbox. Uninstall Python from Windows Settings → Apps,
            then reinstall with the box checked.
          </div>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">5</div>
        <div class="setup-step-body">
          <h4>Install the <code>requests</code> library</h4>
          <p>In the same Command Prompt window, type:</p>
          <div class="code-block">pip install requests</div>
          <p style="margin-top:8px">You should see lines ending with:</p>
          <div class="code-output">Successfully installed requests-2.x.x</div>
          <p style="margin-top:8px;font-size:.875rem;color:var(--text-muted)">
            This is the only extra library the tool needs. It handles sending logs
            back to the website.
          </p>
        </div>
      </div>
    </div>

    <div style="display:flex;justify-content:flex-end;margin-top:16px">
      <button class="btn btn-primary" onclick="showTab('adb', document.querySelectorAll('.dl-tab-btn')[1])">
        Continue to Step 2 — ADB →
      </button>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════
       TAB 2 — ADB
       ═══════════════════════════════════════════════════════ -->
  <div id="tab-adb" class="dl-tab-content">

    <div class="setup-section-header">
      <div class="setup-badge">Step 2 of 3</div>
      <h2>Set Up ADB</h2>
      <p>ADB (Android Debug Bridge) is a tool from Google that lets your computer
         talk directly to your Android phone over USB.</p>
    </div>

    <!-- Download options -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
      <div class="setup-download-card" style="padding:20px">
        <div style="font-size:2rem;margin-bottom:10px">📦</div>
        <h3 style="font-family:var(--font-display);font-size:1rem;color:var(--text-primary);margin-bottom:6px">Official Google Download</h3>
        <p style="color:var(--text-muted);font-size:.82rem;margin-bottom:14px">Always up to date · ~8 MB ZIP</p>
        <a href="https://dl.google.com/android/repository/platform-tools-latest-windows.zip"
           class="btn btn-primary btn-block" style="font-size:.875rem" download>
          ⬇️ Download from Google
        </a>
      </div>
      <div class="setup-download-card" style="padding:20px">
        <div style="font-size:2rem;margin-bottom:10px">🔄</div>
        <h3 style="font-family:var(--font-display);font-size:1rem;color:var(--text-primary);margin-bottom:6px">Mirror Download</h3>
        <p style="color:var(--text-muted);font-size:.82rem;margin-bottom:14px">Use if Google is slow · ~8 MB ZIP</p>
        <a href="https://androidfilehost.com/?fid=platform-tools-latest-windows"
           class="btn btn-ghost btn-block" style="font-size:.875rem" target="_blank">
          ⬇️ Mirror Download
        </a>
      </div>
    </div>

    <div class="setup-steps-card">
      <h3 class="steps-heading">Setup steps</h3>

      <div class="setup-step">
        <div class="setup-step-num">1</div>
        <div class="setup-step-body">
          <h4>Extract the ZIP file</h4>
          <p>Right-click the downloaded ZIP → <strong>"Extract All…"</strong></p>
          <p>Extract to a simple location. We recommend:</p>
          <div class="code-block">C:\platform-tools</div>
          <div class="callout callout-tip">
            💡 Avoid paths with spaces or special characters (e.g. don't put it in
            <code>C:\My Documents\Downloads</code>).
          </div>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">2</div>
        <div class="setup-step-body">
          <h4>Check the extracted folder contains these files</h4>
          <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:8px;margin-top:10px">
            <div class="file-chip">📄 adb.exe</div>
            <div class="file-chip">📄 AdbWinApi.dll</div>
            <div class="file-chip">📄 AdbWinUsbApi.dll</div>
            <div class="file-chip">📁 lib\ (folder)</div>
          </div>
          <p style="margin-top:10px;font-size:.875rem;color:var(--text-muted)">
            You'll need <code>adb.exe</code>, <code>AdbWinApi.dll</code>, and
            <code>AdbWinUsbApi.dll</code> in the next step.
          </p>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">3</div>
        <div class="setup-step-body">
          <h4>Add ADB to your system PATH</h4>
          <p>This lets you run <code>adb</code> from anywhere on your computer.
             Follow these steps exactly:</p>
          <ol style="margin-left:20px;margin-top:10px;color:var(--text-secondary);font-size:.9rem">
            <li style="margin-bottom:8px">Press <kbd>Win + R</kbd>, type <code>sysdm.cpl</code>, press Enter</li>
            <li style="margin-bottom:8px">Click the <strong>Advanced</strong> tab → click <strong>Environment Variables</strong></li>
            <li style="margin-bottom:8px">In the <em>System variables</em> section (bottom half), find <strong>Path</strong> → click <strong>Edit</strong></li>
            <li style="margin-bottom:8px">Click <strong>New</strong> and type the full path to your platform-tools folder:<br>
              <div class="code-block" style="margin-top:6px">C:\platform-tools</div>
            </li>
            <li style="margin-bottom:8px">Click <strong>OK</strong> on all three windows</li>
            <li>Close and reopen any Command Prompt windows</li>
          </ol>
          <div class="callout callout-tip" style="margin-top:12px">
            💡 <strong>Alternative (simpler):</strong> You can skip adding to PATH entirely.
            Instead, just copy <code>adb.exe</code>, <code>AdbWinApi.dll</code>, and
            <code>AdbWinUsbApi.dll</code> directly into the same folder as
            <code>secure_wipe_tool.py</code> in Step 3. The tool will find them automatically.
          </div>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">4</div>
        <div class="setup-step-body">
          <h4>Verify ADB is working</h4>
          <p>Open a new Command Prompt and type:</p>
          <div class="code-block">adb version</div>
          <p style="margin-top:8px">You should see something like:</p>
          <div class="code-output">Android Debug Bridge version 1.0.41
Version 35.0.0-...</div>
          <div class="callout callout-success" style="margin-top:10px">
            ✅ If you see a version number, ADB is ready. Move to Step 3.
          </div>
          <div class="callout callout-danger" style="margin-top:8px">
            ❌ <strong>"'adb' is not recognized"</strong> — either the PATH wasn't set
            correctly, or you need to open a <em>new</em> Command Prompt window after
            changing PATH. Try the alternative method (copy files to same folder as the tool).
          </div>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">5</div>
        <div class="setup-step-body">
          <h4>Enable USB Debugging on your Android phone</h4>
          <p>ADB needs this to communicate with the phone:</p>
          <ol style="margin-left:20px;margin-top:10px;color:var(--text-secondary);font-size:.9rem">
            <li style="margin-bottom:8px">Open <strong>Settings</strong> on your phone</li>
            <li style="margin-bottom:8px">Go to <strong>About Phone</strong></li>
            <li style="margin-bottom:8px">Find <strong>Build Number</strong> and tap it <strong>7 times</strong> quickly<br>
              <span style="font-size:.82rem;color:var(--text-muted)">You'll see "You are now a developer!" appear</span>
            </li>
            <li style="margin-bottom:8px">Go back to the main Settings screen</li>
            <li style="margin-bottom:8px">Go to <strong>System → Developer Options</strong><br>
              <span style="font-size:.82rem;color:var(--text-muted)">(on Samsung: Settings → Developer Options directly)</span>
            </li>
            <li>Toggle <strong>USB Debugging</strong> ON</li>
          </ol>
          <div class="callout callout-tip" style="margin-top:12px">
            💡 Connect your phone and run <code>adb devices</code> — the first time,
            your phone will show a popup asking "Allow USB Debugging?". Tap
            <strong>Allow</strong> and check "Always allow from this computer".
          </div>
          <div class="code-block" style="margin-top:10px">adb devices</div>
          <div class="code-output" style="margin-top:6px">List of devices attached
R58M31XXXXX    device</div>
          <p style="font-size:.82rem;color:var(--text-muted);margin-top:8px">
            The word <code style="color:var(--success)">device</code> means it's connected and authorised.
            <code style="color:var(--danger)">unauthorized</code> means the Allow popup is still waiting on your phone.
          </p>
        </div>
      </div>
    </div>

    <div style="display:flex;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:10px">
      <button class="btn btn-ghost" onclick="showTab('python', document.querySelectorAll('.dl-tab-btn')[0])">
        ← Back to Step 1
      </button>
      <button class="btn btn-primary" onclick="showTab('tool', document.querySelectorAll('.dl-tab-btn')[2])">
        Continue to Step 3 — SecureWipe Tool →
      </button>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════
       TAB 3 — THE TOOL
       ═══════════════════════════════════════════════════════ -->
  <div id="tab-tool" class="dl-tab-content">

    <div class="setup-section-header">
      <div class="setup-badge">Step 3 of 3</div>
      <h2>Download &amp; Run the SecureWipe Tool</h2>
      <p>This is the actual tool. It's a single Python script — no installation,
         just download and run.</p>
    </div>

    <!-- Download card -->
    <div class="setup-download-card">
      <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap">
        <div style="font-size:3rem">🛡️</div>
        <div style="flex:1">
          <h3 style="font-family:var(--font-display);font-size:1.2rem;color:var(--text-primary);margin-bottom:4px">secure_wipe_tool.py</h3>
          <p style="color:var(--text-muted);font-size:.875rem">The SecureWipe desktop application · ~50 KB Python script</p>
        </div>
        <a href="python/secure_wipe_tool.py" class="btn btn-success" download>
          ⬇️ Download Tool
        </a>
      </div>
    </div>

    <div class="setup-steps-card">
      <h3 class="steps-heading">Getting it running</h3>

      <div class="setup-step">
        <div class="setup-step-num">1</div>
        <div class="setup-step-body">
          <h4>Put all files in the same folder</h4>
          <p>Create a folder anywhere on your computer, e.g. <code>C:\SecureWipe\</code></p>
          <p style="margin-top:8px">Place these files inside it:</p>
          <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:8px;margin-top:10px">
            <div class="file-chip required-chip">📄 secure_wipe_tool.py <span class="chip-badge">download above</span></div>
            <div class="file-chip">📄 adb.exe <span class="chip-badge">from Step 2</span></div>
            <div class="file-chip">📄 AdbWinApi.dll <span class="chip-badge">from Step 2</span></div>
            <div class="file-chip">📄 AdbWinUsbApi.dll <span class="chip-badge">from Step 2</span></div>
          </div>
          <div class="callout callout-tip" style="margin-top:12px">
            💡 If you added ADB to your system PATH in Step 2, you don't need to copy
            the DLL files here — just <code>secure_wipe_tool.py</code> is enough.
            But keeping them together is the safest option.
          </div>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">2</div>
        <div class="setup-step-body">
          <h4>Run the tool</h4>
          <p><strong>Option A — easiest:</strong> Double-click <code>secure_wipe_tool.py</code>
             (works if Python is associated with .py files)</p>
          <p style="margin-top:8px"><strong>Option B — always works:</strong> Open Command Prompt in the folder
             and type:</p>
          <div class="code-block">python secure_wipe_tool.py</div>
          <p style="margin-top:8px;font-size:.82rem;color:var(--text-muted)">
            To open Command Prompt in a specific folder: hold
            <kbd>Shift</kbd> and right-click inside the folder → "Open PowerShell/Command Prompt window here"
          </p>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">3</div>
        <div class="setup-step-body">
          <h4>The tool opens — connect your phone</h4>
          <p>You'll see the SecureWipe window with two tabs: <strong>Android</strong>
             and <strong>iPhone</strong>.</p>
          <ol style="margin-left:20px;margin-top:10px;color:var(--text-secondary);font-size:.9rem">
            <li style="margin-bottom:8px">Plug your phone in with a USB cable</li>
            <li style="margin-bottom:8px">Click <strong>"Detect Android Device"</strong></li>
            <li style="margin-bottom:8px">On your phone: tap <strong>Allow</strong> on the USB Debugging popup</li>
            <li>The status changes to <span style="color:var(--success);font-weight:600">✅ Android device connected</span></li>
          </ol>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">4</div>
        <div class="setup-step-body">
          <h4>Run the wipe</h4>
          <p>Click <strong>"START SECURE WIPE"</strong>. A confirmation box appears — click Yes.</p>
          <p style="margin-top:8px">The tool runs 4 steps:</p>
          <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:8px;margin-top:10px">
            <div class="progress-chip">🔒 1. Encrypt check</div>
            <div class="progress-chip">🔄 2. Factory reset</div>
            <div class="progress-chip">✍️ 3. Overwrite guide</div>
            <div class="progress-chip">✅ 4. Verify</div>
          </div>
          <div class="callout callout-warning" style="margin-top:12px">
            ⚠️ <strong>For Step 2 (factory reset)</strong>, the phone will reboot into recovery mode.
            Use the phone's volume buttons to navigate to <strong>"Wipe data / factory reset"</strong>
            and press the power button to confirm. This is normal — the tool cannot do
            this part automatically due to Android security restrictions.
          </div>
        </div>
      </div>

      <div class="setup-step">
        <div class="setup-step-num">5</div>
        <div class="setup-step-body">
          <h4>Collect your wipe certificate</h4>
          <p>When all 4 steps complete, the tool saves two files to the same folder:</p>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px">
            <div class="file-chip">📄 wipe_certificate_YYYYMMDD.txt</div>
            <div class="file-chip">📄 wipe_log_YYYYMMDD.txt</div>
          </div>
          <p style="margin-top:10px;font-size:.875rem;color:var(--text-secondary)">
            The certificate confirms the device was processed and includes the device model,
            Android version, and timestamp. Keep it for your records.
          </p>
        </div>
      </div>
    </div>

    <!-- iPhone section -->
    <div class="setup-steps-card" style="border-color:rgba(249,115,22,.2)">
      <h3 class="steps-heading" style="color:var(--warning)">🍎 iPhone — Guided Mode</h3>
      <p style="color:var(--text-secondary);font-size:.9rem;margin-bottom:16px">
        Apple doesn't allow third-party apps to control iPhone over USB. The tool
        guides you through the steps manually and generates a certificate at the end.
      </p>

      <div class="setup-step">
        <div class="setup-step-num">1</div>
        <div class="setup-step-body">
          <h4>Click the iPhone tab in the tool</h4>
          <p>The tool shows full on-screen instructions. Follow them in order.</p>
        </div>
      </div>
      <div class="setup-step">
        <div class="setup-step-num">2</div>
        <div class="setup-step-body">
          <h4>Sign out of iCloud first</h4>
          <p>Settings → [Your Name] → Sign Out → enter Apple ID password.<br>
          <span style="color:var(--danger);font-size:.875rem">⚠️ If you skip this, Activation Lock prevents the next owner from using the phone.</span></p>
        </div>
      </div>
      <div class="setup-step">
        <div class="setup-step-num">3</div>
        <div class="setup-step-body">
          <h4>Erase All Content and Settings</h4>
          <p>Settings → General → Transfer or Reset iPhone → Erase All Content and Settings</p>
        </div>
      </div>
      <div class="setup-step">
        <div class="setup-step-num">4</div>
        <div class="setup-step-body">
          <h4>Click "Generate Certificate" in the tool</h4>
          <p>This saves your wipe certificate to the folder.</p>
        </div>
      </div>
    </div>

    <div style="display:flex;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:10px">
      <button class="btn btn-ghost" onclick="showTab('adb', document.querySelectorAll('.dl-tab-btn')[1])">
        ← Back to Step 2
      </button>
      <div class="callout callout-success" style="margin:0;flex:1;margin-left:16px">
        🎉 <strong>All done!</strong> Your phone is securely wiped and you have a certificate.
      </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════
       TAB 4 — TROUBLESHOOT
       ═══════════════════════════════════════════════════════ -->
  <div id="tab-troubleshoot" class="dl-tab-content">

    <div class="setup-section-header">
      <div class="setup-badge" style="background:rgba(245,158,11,.12);border-color:rgba(245,158,11,.3);color:var(--warning)">Troubleshooting</div>
      <h2>Fix Common Issues</h2>
      <p>Something not working? Find your error below.</p>
    </div>

    <div class="setup-steps-card">
      <h3 class="steps-heading">Python problems</h3>

      <div class="trouble-item">
        <h4>'python' is not recognized as an internal or external command</h4>
        <p>Python wasn't added to your PATH during installation. Fix: open Windows Settings
           → Apps → find Python → Uninstall. Then reinstall from
           <a href="https://www.python.org/downloads/" target="_blank" style="color:var(--accent)">python.org</a>
           and make sure to check <strong>"Add python.exe to PATH"</strong> on the first screen.</p>
      </div>

      <div class="trouble-item">
        <h4>'pip' is not recognized</h4>
        <p>Try using <code>python -m pip install requests</code> instead of <code>pip install requests</code>.
           If that also fails, Python's PATH is not set — reinstall Python with the PATH option.</p>
      </div>

      <div class="trouble-item">
        <h4>pip install fails with a network error</h4>
        <p>You need an internet connection to install packages. If you're behind a proxy, run:<br>
        <code>pip install requests --proxy http://your-proxy:port</code></p>
      </div>
    </div>

    <div class="setup-steps-card">
      <h3 class="steps-heading">ADB problems</h3>

      <div class="trouble-item">
        <h4>'adb' is not recognized</h4>
        <p>Either ADB wasn't added to PATH, or you need to open a <em>new</em> Command Prompt
           after adding it. Try closing and reopening the Command Prompt window.
           Alternatively, copy <code>adb.exe</code> + the two DLL files into the same folder
           as <code>secure_wipe_tool.py</code>.</p>
      </div>

      <div class="trouble-item">
        <h4>adb devices shows nothing / empty list</h4>
        <p>Check: (1) USB cable is data-capable (not charge-only — try a different cable),
           (2) USB Debugging is enabled in Developer Options on the phone,
           (3) you haven't dismissed the "Allow USB Debugging?" popup on the phone.
           Unplug and reconnect the cable, then run <code>adb devices</code> again.</p>
      </div>

      <div class="trouble-item">
        <h4>Device shows "unauthorized"</h4>
        <p>Your phone has a pending popup. Unlock the phone screen and look for
           "Allow USB Debugging from this computer?" — tap <strong>Allow</strong>.
           If you can't see the popup, revoke all USB debugging authorisations in
           Developer Options and reconnect.</p>
      </div>

      <div class="trouble-item">
        <h4>Device shows "offline"</h4>
        <p>Run <code>adb kill-server</code> then <code>adb start-server</code>.
           Then unplug and reconnect the phone.</p>
      </div>
    </div>

    <div class="setup-steps-card">
      <h3 class="steps-heading">Tool problems</h3>

      <div class="trouble-item">
        <h4>Double-clicking the .py file does nothing / opens Notepad</h4>
        <p>The .py file type isn't associated with Python on your system. Use
           Option B instead: open Command Prompt in the folder and run
           <code>python secure_wipe_tool.py</code></p>
      </div>

      <div class="trouble-item">
        <h4>The tool window opens and immediately closes</h4>
        <p>There's a Python error. Run it from Command Prompt (<code>python secure_wipe_tool.py</code>)
           so you can see the error message before it closes.</p>
      </div>

      <div class="trouble-item">
        <h4>ModuleNotFoundError: No module named 'requests'</h4>
        <p>The requests library wasn't installed. In Command Prompt, run:<br>
        <code>pip install requests</code></p>
      </div>

      <div class="trouble-item">
        <h4>ModuleNotFoundError: No module named 'tkinter'</h4>
        <p>Your Python installation is missing tkinter (the GUI library). This shouldn't
           happen with the standard Windows installer from python.org. Uninstall Python
           and reinstall from
           <a href="https://www.python.org/downloads/" target="_blank" style="color:var(--accent)">python.org</a>
           — do not use a stripped-down version.</p>
      </div>

      <div class="trouble-item">
        <h4>Wipe certificate not appearing</h4>
        <p>The certificate is saved in the <em>same folder as the tool</em>.
           Check <code>C:\SecureWipe\</code> (or wherever you put the .py file).
           The file is named <code>wipe_certificate_YYYYMMDD_HHMMSS.txt</code>.</p>
      </div>
    </div>

    <div class="callout callout-tip" style="margin-top:8px">
      💬 Still stuck? Use the <a href="feedback.php" style="color:var(--accent)">Feedback</a> page
      to describe your issue and we'll help.
    </div>
  </div>

</div><!-- end .download-container -->

<style>
/* ── Tab buttons ────────────────────────────────────── */
.dl-tab-btn {
  flex: 1;
  padding: 14px 10px;
  background: var(--bg-glass);
  backdrop-filter: var(--blur-sm);
  border: 1px solid var(--border);
  border-bottom: none;
  border-radius: var(--radius-lg) var(--radius-lg) 0 0;
  cursor: pointer;
  font-family: var(--font-body);
  font-size: .82rem;
  color: var(--text-muted);
  transition: all var(--transition);
  line-height: 1.4;
  text-align: center;
  min-width: 100px;
}
.dl-tab-btn:hover { background: var(--bg-elevated); color: var(--text-secondary); }
.dl-tab-btn.active {
  background: var(--bg-surface);
  color: var(--text-primary);
  border-color: var(--border-accent);
  border-bottom-color: var(--bg-surface);
  box-shadow: 0 -4px 14px var(--accent-glow);
  z-index: 2;
  position: relative;
}

/* ── Tab content panels ─────────────────────────────── */
.dl-tab-content {
  display: none;
  background: var(--bg-surface);
  border: 1px solid var(--border-accent);
  border-radius: 0 0 var(--radius-xl) var(--radius-xl);
  padding: 36px 32px;
  animation: fadeIn .25s ease;
}
.dl-tab-content.active { display: block; }

/* ── Section header inside tab ──────────────────────── */
.setup-section-header {
  margin-bottom: 28px;
}
.setup-badge {
  display: inline-flex;
  background: rgba(14,165,233,.1);
  border: 1px solid var(--border-accent);
  color: var(--accent);
  padding: 4px 12px;
  border-radius: 20px;
  font-size: .78rem;
  font-weight: 700;
  letter-spacing: .4px;
  margin-bottom: 12px;
}
.setup-section-header h2 {
  font-family: var(--font-display);
  font-size: 1.7rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 8px;
  letter-spacing: -.3px;
}
.setup-section-header p {
  font-size: 1rem;
  color: var(--text-secondary);
  max-width: 620px;
}

/* ── Download card ──────────────────────────────────── */
.setup-download-card {
  background: var(--bg-glass);
  backdrop-filter: var(--blur-sm);
  border: 1px solid var(--border-accent);
  border-radius: var(--radius-xl);
  padding: 24px 28px;
  margin-bottom: 20px;
  box-shadow: 0 0 0 1px var(--accent-glow), var(--shadow-sm);
}

/* ── Steps card wrapper ─────────────────────────────── */
.setup-steps-card {
  background: var(--bg-glass);
  backdrop-filter: var(--blur-sm);
  border: 1px solid var(--border);
  border-radius: var(--radius-xl);
  padding: 28px;
  margin-bottom: 20px;
}
.steps-heading {
  font-family: var(--font-display);
  font-size: 1rem;
  font-weight: 700;
  color: var(--text-secondary);
  text-transform: uppercase;
  letter-spacing: .8px;
  font-size: .8rem;
  margin-bottom: 20px;
  padding-bottom: 12px;
  border-bottom: 1px solid var(--border);
}

/* ── Individual step ────────────────────────────────── */
.setup-step {
  display: flex;
  gap: 18px;
  margin-bottom: 24px;
  padding-bottom: 24px;
  border-bottom: 1px solid var(--border);
}
.setup-step:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.setup-step-num {
  width: 34px;
  height: 34px;
  flex-shrink: 0;
  background: rgba(14,165,233,.1);
  border: 1.5px solid var(--border-accent);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-display);
  font-weight: 700;
  font-size: .9rem;
  color: var(--accent);
}
.setup-step-body { flex: 1; min-width: 0; }
.setup-step-body h4 {
  font-family: var(--font-display);
  font-size: 1rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 8px;
}
.setup-step-body p { font-size: .9rem; color: var(--text-secondary); margin-bottom: 6px; }
.setup-step-body ol li { font-size: .875rem; }

/* ── Callout boxes ──────────────────────────────────── */
.callout {
  display: flex;
  gap: 10px;
  padding: 12px 16px;
  border-radius: var(--radius-lg);
  font-size: .875rem;
  line-height: 1.5;
  color: var(--text-secondary);
  margin-top: 10px;
}
.callout-tip     { background: rgba(14,165,233,.07);  border-left: 3px solid var(--accent); }
.callout-warning { background: rgba(245,158,11,.07);  border-left: 3px solid var(--warning); }
.callout-success { background: rgba(16,185,129,.07);  border-left: 3px solid var(--success); }
.callout-danger  { background: rgba(239,68,68,.07);   border-left: 3px solid var(--danger); }

/* ── File chips ─────────────────────────────────────── */
.file-chip {
  background: var(--bg-elevated);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 8px 12px;
  font-size: .82rem;
  color: var(--text-secondary);
  font-family: monospace;
  display: flex;
  align-items: center;
  gap: 6px;
  flex-wrap: wrap;
}
.required-chip { border-color: var(--border-accent); }
.chip-badge {
  font-family: var(--font-body);
  font-size: .72rem;
  background: rgba(14,165,233,.1);
  color: var(--accent);
  padding: 2px 7px;
  border-radius: 10px;
  font-weight: 600;
}

/* ── Progress chips ─────────────────────────────────── */
.progress-chip {
  background: var(--bg-elevated);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 10px 12px;
  font-size: .82rem;
  color: var(--text-secondary);
  text-align: center;
}

/* ── Progress pills at top ──────────────────────────── */
.setup-pill {
  padding: 8px 18px;
  background: var(--bg-elevated);
  border: 1px solid var(--border);
  border-radius: 20px;
  font-size: .82rem;
  font-weight: 600;
  color: var(--text-muted);
}
.active-pill {
  background: rgba(14,165,233,.1);
  border-color: var(--border-accent);
  color: var(--accent);
}
.pill-arrow {
  color: var(--text-muted);
  padding: 0 6px;
  font-size: 1rem;
  line-height: 34px;
}

/* ── Trouble items ──────────────────────────────────── */
.trouble-item {
  margin-bottom: 20px;
  padding-bottom: 20px;
  border-bottom: 1px solid var(--border);
}
.trouble-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.trouble-item h4 {
  font-family: var(--font-display);
  font-size: .95rem;
  font-weight: 700;
  color: var(--danger);
  margin-bottom: 6px;
}
.trouble-item p { font-size: .875rem; color: var(--text-secondary); }
.trouble-item code {
  background: var(--bg-elevated);
  padding: 2px 7px;
  border-radius: 4px;
  font-size: .82rem;
  color: var(--accent);
}

/* kbd */
kbd {
  background: var(--bg-elevated);
  border: 1px solid var(--border);
  border-radius: 5px;
  padding: 2px 7px;
  font-size: .8rem;
  font-family: var(--font-body);
  color: var(--text-secondary);
}

/* ── Responsive ─────────────────────────────────────── */
@media(max-width:640px) {
  .dl-tab-content { padding: 22px 16px; }
  .setup-step { flex-direction: column; gap: 10px; }
  .dl-tab-btn { font-size: .72rem; padding: 10px 6px; }
  .device-tabs { gap: 2px; }
}
</style>

<script>
function showTab(id, btn) {
  document.querySelectorAll('.dl-tab-content').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.dl-tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + id).classList.add('active');
  if (btn) btn.classList.add('active');
  window.scrollTo({ top: document.querySelector('.device-tabs').offsetTop - 80, behavior: 'smooth' });
}
</script>

<?php include 'includes/footer.php'; ?>
