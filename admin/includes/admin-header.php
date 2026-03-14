<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - <?php echo defined('SITE_NAME') ? SITE_NAME : 'SecureWipe'; ?></title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
</head>
<body>

<header id="site-header">
  <div class="header-container">
    <div class="logo">
      <a href="../index.php">
        <div class="logo-icon">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z" fill="#fff"/></svg>
        </div>
        <span class="logo-text">SecureWipe Admin</span>
      </a>
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="view-surveys.php">Surveys</a></li>
        <li><a href="view-feedback.php">Feedback</a></li>
        <li><a href="view-erase-logs.php">Erase Logs</a></li>
        <li><a href="../index.php" target="_blank">View Site ↗</a></li>
      </ul>
    </nav>
    <div class="nav-actions">
      <button class="theme-toggle" id="themeToggle" title="Toggle theme">
        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
      </button>
    </div>
  </div>
</header>

<script>
(function(){
  const saved = localStorage.getItem('sw-theme') || 'dark';
  document.documentElement.setAttribute('data-theme', saved);
  document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('themeToggle');
    if (btn) btn.addEventListener('click', function() {
      const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('sw-theme', next);
    });
    const header = document.getElementById('site-header');
    if (header) window.addEventListener('scroll', function() {
      header.classList.toggle('scrolled', window.scrollY > 10);
    }, {passive:true});
  });
})();
</script>

<main class="container" style="padding-top:32px">
