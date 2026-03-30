<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<div class="edu-page">

  <div class="edu-header">
    <h1>Why Factory Reset Is Not Enough</h1>
    <p>Understanding the real risk — and what actually protects your data before you sell your phone.</p>
  </div>

  <!-- Section 1 -->
  <div class="edu-card">
    <div class="edu-card-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
           stroke-linecap="round" stroke-linejoin="round">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
      </svg>
    </div>
    <div class="edu-card-body">
      <h2>What a factory reset actually does</h2>
      <p>When you perform a factory reset, your phone does not physically erase your photos, messages, or credentials. It simply removes the pointers that tell the operating system where your files are stored — like tearing the index out of a book but leaving all the pages intact.</p>
      <p>The actual data sits on the storage chip, completely intact, until new data happens to overwrite it. This can take weeks or months — or never happen at all if the buyer does not use the phone heavily.</p>
      <div class="edu-highlight">
        A buyer with free recovery software (widely available online) can retrieve your photos, messages, banking app data, and saved passwords within minutes of buying your phone.
      </div>
    </div>
  </div>

  <!-- Section 2 -->
  <div class="edu-card">
    <div class="edu-card-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
           stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
      </svg>
    </div>
    <div class="edu-card-body">
      <h2>What encryption does differently</h2>
      <p>Encryption scrambles every file on your phone using a cryptographic key — a unique code tied to your device. When you factory reset an encrypted phone, the operating system destroys that key.</p>
      <p>Even though the raw data is still on the storage chip, it is now completely unreadable. Without the key, the data is indistinguishable from random noise. No recovery tool can make sense of it.</p>
      <div class="edu-two-col">
        <div class="edu-col edu-col-bad">
          <div class="edu-col-title">Without encryption</div>
          <p>Factory reset removes the file index. Data is gone from view but physically present. Recoverable with free tools.</p>
        </div>
        <div class="edu-col edu-col-good">
          <div class="edu-col-title">With encryption</div>
          <p>Factory reset destroys the decryption key. Data is physically present but permanently unreadable. Not recoverable.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Section 3 -->
  <div class="edu-card">
    <div class="edu-card-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
           stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
    </div>
    <div class="edu-card-body">
      <h2>Is my phone encrypted?</h2>
      <p>Most Android phones made after 2016 are encrypted by default. iPhones have been encrypted by default since the iPhone 3GS. You can check:</p>
      <div class="edu-check-grid">
        <div class="edu-check-item">
          <div class="edu-check-title">Android</div>
          <p>Settings → Security → Encryption<br>
          If it says "Encrypted" or "Device is encrypted" you are protected.</p>
        </div>
        <div class="edu-check-item">
          <div class="edu-check-title">Samsung</div>
          <p>Settings → Biometrics and Security → Encrypt device<br>
          Most Samsung phones are encrypted by default from Android 7 onwards.</p>
        </div>
        <div class="edu-check-item">
          <div class="edu-check-title">iPhone</div>
          <p>All iPhones running iOS 8 and above are encrypted automatically when a passcode is set. If you have a passcode, you are encrypted.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Section 4 -->
  <div class="edu-card">
    <div class="edu-card-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
           stroke-linecap="round" stroke-linejoin="round">
        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
      </svg>
    </div>
    <div class="edu-card-body">
      <h2>What data is actually at risk</h2>
      <p>Research and real-world tests have shown that data recovery tools can retrieve the following from a phone that was only factory reset without encryption:</p>
      <div class="edu-risk-grid">
        <div class="edu-risk-item high">
          <div class="edu-risk-level">High risk</div>
          <div class="edu-risk-name">Photos and videos</div>
        </div>
        <div class="edu-risk-item high">
          <div class="edu-risk-level">High risk</div>
          <div class="edu-risk-name">WhatsApp and SMS messages</div>
        </div>
        <div class="edu-risk-item high">
          <div class="edu-risk-level">High risk</div>
          <div class="edu-risk-name">Saved passwords</div>
        </div>
        <div class="edu-risk-item high">
          <div class="edu-risk-level">High risk</div>
          <div class="edu-risk-name">Banking app credentials</div>
        </div>
        <div class="edu-risk-item med">
          <div class="edu-risk-level">Medium risk</div>
          <div class="edu-risk-name">Email content</div>
        </div>
        <div class="edu-risk-item med">
          <div class="edu-risk-level">Medium risk</div>
          <div class="edu-risk-name">Contacts and call logs</div>
        </div>
        <div class="edu-risk-item med">
          <div class="edu-risk-level">Medium risk</div>
          <div class="edu-risk-name">Social media session tokens</div>
        </div>
        <div class="edu-risk-item low">
          <div class="edu-risk-level">Lower risk</div>
          <div class="edu-risk-name">App data (varies by app)</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section 5 -->
  <div class="edu-card">
    <div class="edu-card-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
           stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
    </div>
    <div class="edu-card-body">
      <h2>The right way to wipe your phone</h2>
      <p>The safest approach combines three steps in order:</p>
      <div class="edu-steps-row">
        <div class="edu-step-box">
          <div class="edu-step-num">1</div>
          <div class="edu-step-title">Verify encryption</div>
          <div class="edu-step-desc">Confirm your phone is encrypted before resetting. If not, enable it first.</div>
        </div>
        <div class="edu-step-arrow">→</div>
        <div class="edu-step-box">
          <div class="edu-step-num">2</div>
          <div class="edu-step-title">Factory reset</div>
          <div class="edu-step-desc">This destroys the encryption key, making all existing data permanently unreadable.</div>
        </div>
        <div class="edu-step-arrow">→</div>
        <div class="edu-step-box">
          <div class="edu-step-num">3</div>
          <div class="edu-step-title">Overwrite free space</div>
          <div class="edu-step-desc">Write dummy data to fill the now-empty storage, leaving no trace of the original files.</div>
        </div>
      </div>
      <div class="edu-cta">
        <a href="secure-erase.php" class="btn-edu-cta">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
               stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
          Use the Secure Erase Tool — get exact steps for your phone model
        </a>
      </div>
    </div>
  </div>

</div>

<style>
.edu-page { max-width:820px; margin:0 auto; padding:48px 24px; }

.edu-header { text-align:center; margin-bottom:40px; }
.edu-header h1 {
  font-family:var(--font-display); font-size:clamp(1.8rem,3vw,2.4rem);
  font-weight:800; color:var(--text-primary); margin-bottom:10px;
}
.edu-header p { font-size:.95rem; color:var(--text-secondary); max-width:560px; margin:0 auto; }

.edu-card {
  display:flex; gap:22px; align-items:flex-start;
  background:var(--bg-glass); backdrop-filter:blur(10px);
  border:1px solid var(--border); border-radius:20px;
  padding:28px; margin-bottom:20px; transition:.22s;
}
.edu-card:hover { border-color:var(--border-accent); }

.edu-card-icon {
  width:44px; height:44px; flex-shrink:0;
  background:rgba(14,165,233,.1); border:1px solid var(--border-accent);
  border-radius:12px; display:flex; align-items:center; justify-content:center;
  color:var(--accent);
}
.edu-card-icon svg { width:22px; height:22px; }

.edu-card-body { flex:1; }
.edu-card-body h2 {
  font-family:var(--font-display); font-size:1.15rem; font-weight:700;
  color:var(--text-primary); margin-bottom:10px;
}
.edu-card-body p { font-size:.9rem; color:var(--text-secondary); line-height:1.7; margin-bottom:12px; }
.edu-card-body p:last-child { margin-bottom:0; }

.edu-highlight {
  background:rgba(239,68,68,.06); border:1px solid rgba(239,68,68,.2);
  border-left:4px solid var(--danger); border-radius:10px;
  padding:12px 16px; font-size:.875rem; color:var(--text-secondary);
  line-height:1.6; margin-top:12px;
}

/* Two col */
.edu-two-col { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-top:14px; }
.edu-col { padding:16px; border-radius:12px; font-size:.85rem; color:var(--text-secondary); line-height:1.6; }
.edu-col-bad  { background:rgba(239,68,68,.06);  border:1px solid rgba(239,68,68,.2); }
.edu-col-good { background:rgba(16,185,129,.06); border:1px solid rgba(16,185,129,.2); }
.edu-col-title { font-weight:700; margin-bottom:6px; font-size:.82rem; text-transform:uppercase; letter-spacing:.4px; }
.edu-col-bad  .edu-col-title { color:var(--danger); }
.edu-col-good .edu-col-title { color:var(--success); }

/* Check grid */
.edu-check-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-top:14px; }
.edu-check-item {
  background:var(--bg-elevated); border:1px solid var(--border);
  border-radius:10px; padding:14px;
}
.edu-check-title { font-family:var(--font-display); font-size:.85rem; font-weight:700; color:var(--text-primary); margin-bottom:6px; }
.edu-check-item p { font-size:.8rem; color:var(--text-muted); line-height:1.55; margin:0; }

/* Risk grid */
.edu-risk-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-top:14px; }
.edu-risk-item { border-radius:10px; padding:12px; text-align:center; }
.edu-risk-item.high { background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.2); }
.edu-risk-item.med  { background:rgba(245,158,11,.08); border:1px solid rgba(245,158,11,.2); }
.edu-risk-item.low  { background:rgba(16,185,129,.08); border:1px solid rgba(16,185,129,.2); }
.edu-risk-level { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.4px; margin-bottom:5px; }
.high .edu-risk-level { color:var(--danger); }
.med  .edu-risk-level { color:var(--warning); }
.low  .edu-risk-level { color:var(--success); }
.edu-risk-name { font-size:.82rem; color:var(--text-secondary); line-height:1.4; }

/* Steps row */
.edu-steps-row {
  display:flex; align-items:center; gap:10px;
  margin-top:14px; flex-wrap:wrap;
}
.edu-step-box {
  flex:1; min-width:160px; padding:16px;
  background:var(--bg-elevated); border:1px solid var(--border);
  border-radius:12px; text-align:center;
}
.edu-step-num {
  width:32px; height:32px; margin:0 auto 8px;
  background:rgba(14,165,233,.1); border:1.5px solid var(--border-accent);
  border-radius:50%; display:flex; align-items:center; justify-content:center;
  font-family:var(--font-display); font-size:.9rem; font-weight:700; color:var(--accent);
}
.edu-step-title { font-family:var(--font-display); font-size:.875rem; font-weight:700; color:var(--text-primary); margin-bottom:6px; }
.edu-step-desc  { font-size:.78rem; color:var(--text-muted); line-height:1.5; }
.edu-step-arrow { font-size:1.2rem; color:var(--text-muted); flex-shrink:0; }

/* CTA */
.edu-cta { margin-top:22px; }
.btn-edu-cta {
  display:inline-flex; align-items:center; gap:8px;
  padding:13px 24px; border-radius:12px; text-decoration:none;
  background:var(--accent); color:#fff; font-family:var(--font-display);
  font-size:.95rem; font-weight:700;
  box-shadow:0 6px 20px var(--accent-glow); transition:.2s;
}
.btn-edu-cta:hover { background:var(--accent-hover); transform:translateY(-2px); }
.btn-edu-cta svg { width:18px; height:18px; }

@media(max-width:768px){
  .edu-card { flex-direction:column; }
  .edu-two-col { grid-template-columns:1fr; }
  .edu-check-grid { grid-template-columns:1fr; }
  .edu-risk-grid { grid-template-columns:repeat(2,1fr); }
  .edu-steps-row { flex-direction:column; align-items:stretch; }
  .edu-step-arrow { text-align:center; transform:rotate(90deg); }
}
</style>

<?php include 'includes/footer.php'; ?>
