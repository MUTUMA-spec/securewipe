<?php
// Resolve base path for footer links (works from root and /admin/)
$_footer_base = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
?>
    </main><!-- /.page-content -->
    <footer class="site-footer">
      <div class="footer-container">
        <div class="footer-brand">
          <div class="footer-logo">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"/>
            </svg>
          </div>
          <span>SecureWipe</span>
        </div>
        <nav class="footer-nav">
          <a href="<?= $_footer_base ?>index.php">Home</a>
          <a href="<?= $_footer_base ?>guides.php">Why It Matters</a>
          <a href="<?= $_footer_base ?>secure-erase.php">Erase Tool</a>
          <a href="<?= $_footer_base ?>survey.php">Survey</a>
          <a href="<?= $_footer_base ?>feedback.php">Feedback</a>
          <a href="<?= $_footer_base ?>downloads.php">Downloads</a>
        </nav>
        <div class="footer-copy">
          &copy; <?php echo date('Y'); ?> SecureWipe &mdash;
          Educational project, Zetech University
        </div>
      </div>
    </footer>
</body>
</html>
