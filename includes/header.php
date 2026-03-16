<?php
$current_page = basename($_SERVER['PHP_SELF']);
$is_admin_dir = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$base = $is_admin_dir ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo defined('SITE_NAME') ? SITE_NAME : 'SecureWipe'; ?></title>
  <link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
</head>
<body>

<header id="site-header">
  <div class="header-container">
    <!-- Logo -->
    <div class="logo">
      <a href="<?= $base ?>index.php">
        <div class="logo-icon">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"/>
          </svg>
        </div>
        <span class="logo-text">SecureWipe</span>
      </a>
    </div>

    <!-- Desktop Nav -->
    <nav>
      <ul class="nav-links">
        <li><a href="<?= $base ?>index.php" <?= $current_page=='index.php' ? 'class="active"' : '' ?>>Home</a></li>
        <li><a href="<?= $base ?>guides.php" <?= $current_page=='guides.php' ? 'class="active"' : '' ?>>Guides</a></li>
        <li><a href="<?= $base ?>secure-erase.php" <?= $current_page=='secure-erase.php' ? 'class="active"' : '' ?>>Erase web Tool</a></li>
        <li><a href="<?= $base ?>survey.php" <?= $current_page=='survey.php' ? 'class="active"' : '' ?>>Survey</a></li>
        <li><a href="<?= $base ?>feedback.php" <?= $current_page=='feedback.php' ? 'class="active"' : '' ?>>Feedback</a></li>
        <li><a href="<?= $base ?>downloads.php" <?= $current_page=='downloads.php' ? 'class="active"' : '' ?>>Downloads</a></li>
      </ul>
    </nav>

    <div class="nav-actions">
      <!-- Theme toggle -->
      <button class="theme-toggle" id="themeToggle" title="Toggle theme" aria-label="Toggle dark/light mode">
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

      <?php if(function_exists('isAdminLoggedIn') && isAdminLoggedIn()): ?>
      <div class="admin-nav">
        <a href="<?= $base ?>admin/dashboard.php" class="admin-btn">Dashboard</a>
        <a href="<?= $base ?>admin/logout.php" class="logout-btn">Logout</a>
      </div>
      <?php else: ?>
      <a href="<?= $base ?>secure-erase.php" class="btn-nav-cta">Erase Now</a>
      <?php endif; ?>

      <!-- Hamburger -->
      <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Nav -->
<nav class="mobile-nav" id="mobileNav">
  <a href="<?= $base ?>index.php">Home</a>
  <a href="<?= $base ?>guides.php">Guides</a>
  <a href="<?= $base ?>secure-erase.php">Erase web Tool</a>
  <a href="<?= $base ?>survey.php">Survey</a>
  <a href="<?= $base ?>feedback.php">Feedback</a>
  <a href="<?= $base ?>downloads.php">Downloads</a>
</nav>

<main>
<script>
(function(){
  // Theme persistence
  const saved = localStorage.getItem('sw-theme') || 'dark';
  document.documentElement.setAttribute('data-theme', saved);

  document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('themeToggle');
    if (btn) {
      btn.addEventListener('click', function() {
        const current = document.documentElement.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('sw-theme', next);
      });
    }

    // Mobile menu
    const mb = document.getElementById('mobileMenuBtn');
    const mn = document.getElementById('mobileNav');
    if (mb && mn) {
      mb.addEventListener('click', function() {
        mn.classList.toggle('open');
      });
    }

    // Scrolled header
    const header = document.getElementById('site-header');
    if (header) {
      window.addEventListener('scroll', function() {
        header.classList.toggle('scrolled', window.scrollY > 10);
      }, {passive: true});
    }

    // Active nav
    const links = document.querySelectorAll('.nav-links a');
    links.forEach(function(link) {
      if (link.href === window.location.href) link.classList.add('active');
    });
  });
})();
</script>
