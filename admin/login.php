<?php
$logout_message = '';
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    $logout_message = '<div class="alert alert-success">You have been successfully logged out.</div>';
}
require_once '../includes/config.php';

if (isAdminLoggedIn()) { redirect('dashboard.php'); }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    $sql  = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin_id']       = $row['admin_id'];
            $_SESSION['admin_username'] = $row['username'];
            $update = "UPDATE admin SET last_login = NOW() WHERE admin_id = ?";
            $u = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($u, "i", $row['admin_id']);
            mysqli_stmt_execute($u);
            redirect('dashboard.php');
        } else { $error = "Invalid password"; }
    } else { $error = "Username not found"; }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — SecureWipe</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
  <style>
    /* ── Login page layout ─────────────────────────── */
    .login-page {
      min-height: 100vh;
      background: var(--bg-base);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      position: relative;
      overflow: hidden;
    }

    /* ambient background blobs */
    .login-page::before {
      content: '';
      position: fixed; top: -20%; right: -15%;
      width: 600px; height: 600px;
      background: radial-gradient(circle, var(--accent-glow) 0%, transparent 65%);
      border-radius: 50%; pointer-events: none;
    }
    .login-page::after {
      content: '';
      position: fixed; bottom: -20%; left: -10%;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(16,185,129,.12) 0%, transparent 65%);
      border-radius: 50%; pointer-events: none;
    }

    /* Security pattern background */
    .login-page {
      background-image: 
        linear-gradient(45deg, rgba(14, 165, 233, .03) 1px, transparent 1px),
        linear-gradient(-45deg, rgba(14, 165, 233, .03) 1px, transparent 1px);
      background-size: 60px 60px;
      background-position: 0 0, 30px 30px;
    }

    /* Floating security icons background elements */
    .login-page::before {
      background: 
        radial-gradient(circle at 15% 25%, var(--accent-glow) 0%, transparent 15%),
        radial-gradient(circle at 85% 75%, rgba(16,185,129,.15) 0%, transparent 20%),
        radial-gradient(circle at 50% -30%, rgba(14,165,233,.08) 0%, transparent 25%);
    }

    /* ── Card ──────────────────────────────────────── */
    .login-card {
      width: 100%;
      max-width: 420px;
      background: var(--bg-glass);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid var(--border);
      border-radius: 24px;
      padding: 44px 40px 40px;
      box-shadow: 0 32px 80px rgba(0,0,0,.25), 0 0 0 1px var(--border);
      position: relative;
      z-index: 1;
      animation: fadeUp .5s ease both;
    }

    @keyframes fadeUp {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }

    /* ── Logo block ────────────────────────────────── */
    .login-logo {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
      margin-bottom: 32px;
    }

    .login-logo-icon {
      width: 64px; height: 64px;
      background: linear-gradient(135deg, var(--accent) 0%, #38bdf8 100%);
      border-radius: 18px;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 8px 28px var(--accent-glow), 0 0 0 1px rgba(14,165,233,.3);
      position: relative;
    }
    /* subtle shine */
    .login-logo-icon::after {
      content: '';
      position: absolute; top: 4px; left: 8px; right: 8px; height: 40%;
      background: rgba(255,255,255,.18);
      border-radius: 50%;
      filter: blur(4px);
    }
    .login-logo-icon svg {
      width: 32px; height: 32px; fill: #fff; position: relative; z-index: 1;
    }

    .login-logo-name {
      font-family: var(--font-display);
      font-size: 1.5rem;
      font-weight: 800;
      letter-spacing: -.4px;
      color: var(--text-primary);
    }

    .login-logo-badge {
      font-size: .72rem;
      font-weight: 700;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: var(--text-muted);
      background: var(--bg-elevated);
      border: 1px solid var(--border);
      padding: 3px 12px;
      border-radius: 20px;
    }

    /* ── Divider ───────────────────────────────────── */
    .login-divider {
      height: 1px;
      background: var(--border);
      margin: 0 0 28px;
    }

    /* ── Form labels & inputs ──────────────────────── */
    .login-card .form-group { margin-bottom: 18px; }
    .login-card .form-group label {
      font-size: .82rem;
      font-weight: 600;
      letter-spacing: .3px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 7px;
    }
    .login-card input {
      background: var(--bg-elevated) !important;
      border: 1px solid var(--border) !important;
      border-radius: 10px !important;
      font-size: .95rem !important;
      padding: 13px 16px !important;
      color: var(--text-primary) !important;
      transition: all .2s !important;
    }
    .login-card input:focus {
      border-color: var(--accent) !important;
      box-shadow: 0 0 0 3px var(--accent-glow) !important;
      background: var(--bg-surface) !important;
    }

    /* ── Sign-in button ────────────────────────────── */
    .login-btn {
      width: 100%;
      padding: 14px;
      margin-top: 8px;
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-family: var(--font-display);
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 6px 20px var(--accent-glow);
      transition: all .2s;
    }
    .login-btn:hover {
      background: var(--accent-hover);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px var(--accent-glow);
    }
    .login-btn:active { transform: translateY(0); }

    /* ── Back link ─────────────────────────────────── */
    .login-back {
      display: block;
      text-align: center;
      margin-top: 22px;
      font-size: .82rem;
      color: var(--text-muted);
      text-decoration: none;
      transition: color .2s;
    }
    .login-back:hover { color: var(--text-secondary); }

    /* ── Theme toggle (top-right corner) ───────────── */
    .login-theme-btn {
      position: fixed; top: 20px; right: 20px;
      width: 38px; height: 38px;
      border-radius: 10px;
      border: 1px solid var(--border);
      background: var(--bg-glass);
      backdrop-filter: blur(10px);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; color: var(--text-secondary);
      transition: all .2s; z-index: 10;
    }
    .login-theme-btn:hover { border-color: var(--border-accent); color: var(--text-primary); }
    .login-theme-btn svg { width: 17px; height: 17px; }
    .login-theme-btn .icon-sun  { display: none; }
    .login-theme-btn .icon-moon { display: block; }
    [data-theme="dark"] .login-theme-btn .icon-sun  { display: block; }
    [data-theme="dark"] .login-theme-btn .icon-moon { display: none; }
  </style>
</head>
<body class="login-page">
<script>
(function(){
  const s = localStorage.getItem('sw-theme') || 'dark';
  document.documentElement.setAttribute('data-theme', s);
})();
</script>

<!-- Theme toggle -->
<button class="login-theme-btn" id="themeToggle" title="Toggle theme">
  <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
  </svg>
  <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="5"/>
    <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
    <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
  </svg>
</button>

<!-- Login card -->
<div class="login-card">

  <!-- Logo -->
  <div class="login-logo">
    <div class="login-logo-icon">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"/>
      </svg>
    </div>
    <span class="login-logo-name">SecureWipe</span>
    <span class="login-logo-badge">Admin Portal</span>
   
  </div>

  <div class="login-divider"></div>

  <?php if ($logout_message): ?>
    <div class="alert alert-success" style="margin-bottom:18px"><?= $logout_message ?></div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="alert alert-danger" style="margin-bottom:18px"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" autocomplete="off">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required
             placeholder="Enter your username" autocomplete="username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required
             placeholder="••••••••" autocomplete="current-password">
    </div>
    <button type="submit" class="login-btn">Sign In →</button>
  </form>

  <a href="../index.php" class="login-back">← Back to website</a>
</div>

<script>
document.getElementById('themeToggle').addEventListener('click', function() {
  const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
  document.documentElement.setAttribute('data-theme', next);
  localStorage.setItem('sw-theme', next);
});
</script>
</body>
</html>
