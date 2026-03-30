<?php
$_footer_base = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
?>
    </main>

    <footer class="sw-footer">
      <div class="sw-footer-inner">

        <!-- Brand -->
        <div class="sw-footer-brand">
          <div class="sw-footer-logo">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"/>
            </svg>
          </div>
          <span class="sw-footer-name">SecureWipe</span>
        </div>

        <!-- Divider -->
        <div class="sw-footer-divider"></div>

        <!-- Nav links -->
        <nav class="sw-footer-nav">
          <a href="<?= $_footer_base ?>index.php">Home</a>
          <a href="<?= $_footer_base ?>guides.php">Why It Matters</a>
          <a href="<?= $_footer_base ?>secure-erase.php">Erase Tool</a>
          <a href="<?= $_footer_base ?>downloads.php">Downloads</a>
          <a href="<?= $_footer_base ?>survey.php">Survey</a>
          <a href="<?= $_footer_base ?>feedback.php">Feedback</a>
        </nav>

        <!-- Copy -->
        <p class="sw-footer-copy">
          &copy; <?php echo date('Y'); ?> SecureWipe &mdash; Educational project, Zetech University
        </p>

      </div>
    </footer>

    <style>
    .sw-footer {
      margin-top: 80px;
      background: var(--bg-surface);
      border-top: 1px solid var(--border);
      padding: 40px 0 28px;
    }
    .sw-footer-inner {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 32px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
    }
    .sw-footer-brand {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .sw-footer-logo {
      width: 32px;
      height: 32px;
      background: var(--accent);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 4px 12px var(--accent-glow);
    }
    .sw-footer-name {
      font-family: var(--font-display);
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: -.2px;
    }
    .sw-footer-divider {
      width: 40px;
      height: 1px;
      background: var(--border);
      border-radius: 2px;
    }
    .sw-footer-nav {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 4px;
    }
    .sw-footer-nav a {
      padding: 6px 13px;
      border-radius: 20px;
      font-size: .85rem;
      font-weight: 500;
      color: var(--text-secondary);
      text-decoration: none;
      transition: color .2s, background .2s;
    }
    .sw-footer-nav a:hover {
      color: var(--text-primary);
      background: rgba(128,128,128,.08);
    }
    .sw-footer-copy {
      font-size: .78rem;
      color: var(--text-muted);
      margin: 0;
      text-align: center;
    }
    @media (max-width: 480px) {
      .sw-footer-inner { padding: 0 20px; gap: 16px; }
      .sw-footer-nav { gap: 2px; }
      .sw-footer-nav a { padding: 5px 10px; font-size: .82rem; }
    }
    </style>

</body>
</html>
