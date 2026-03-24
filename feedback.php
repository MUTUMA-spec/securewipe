<?php
require_once 'includes/config.php';
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $comment = sanitizeInput($_POST['comment']);
    if (empty($name) || empty($email) || empty($comment)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        $sql = "INSERT INTO feedback (user_name, email, comment, approved) VALUES (?, ?, ?, 0)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $comment);
        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Thank you for your feedback! It will be reviewed by our team.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

$approved_feedback = [];
$result = mysqli_query($conn, "SELECT * FROM feedback WHERE approved = 1 ORDER BY created_at DESC LIMIT 10");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $approved_feedback[] = $row;
    }
}
include 'includes/header.php';
?>


<div class="page-hero-banner">
    <h1>💬 Share Your Experience</h1>
    <p>Your feedback helps us improve SecureWipe for everyone</p>
</div>
<div class="feedback-container">
  <h1>💬 Feedback & Suggestions</h1>
  <p>We'd love to hear your thoughts about our website and tools.</p>

  <?php if ($success_message): ?><div class="alert alert-success"><?= $success_message ?></div><?php endif; ?>
  <?php if ($error_message): ?><div class="alert alert-danger"><?= $error_message ?></div><?php endif; ?>

  <div class="feedback-grid">
    <div class="card">
      <h2 style="font-family:var(--font-display);font-size:1.3rem;font-weight:700;color:var(--text-primary);margin-bottom:22px">📝 Leave Your Feedback</h2>
      <form method="POST" action="feedback.php">
        <div class="form-group">
          <label for="name">Your Name *</label>
          <input type="text" id="name" name="name" required placeholder="e.g., John Doe">
        </div>
        <div class="form-group">
          <label for="email">Email Address *</label>
          <input type="email" id="email" name="email" required placeholder="e.g., john@example.com">
          <small class="input-hint">We'll only use this to respond to your feedback</small>
        </div>
        <div class="form-group">
          <label for="comment">Your Feedback *</label>
          <textarea id="comment" name="comment" rows="5" required placeholder="Tell us what you think..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Submit Feedback</button>
      </form>
    </div>

    <div class="card">
      <h2 style="font-family:var(--font-display);font-size:1.3rem;font-weight:700;color:var(--text-primary);margin-bottom:22px">⭐ Recent Feedback</h2>
      <?php if (empty($approved_feedback)): ?>
        <p style="color:var(--text-muted);font-style:italic">No feedback yet. Be the first to leave a comment!</p>
      <?php else: ?>
        <?php foreach ($approved_feedback as $fb): ?>
        <div style="border-bottom:1px solid var(--border);padding:14px 0">
          <p style="font-weight:600;color:var(--text-primary);margin-bottom:4px"><?= htmlspecialchars($fb['user_name']) ?></p>
          <p style="font-size:.9rem;color:var(--text-secondary);margin-bottom:6px"><?= htmlspecialchars($fb['comment']) ?></p>
          <small style="color:var(--text-muted);font-size:.8rem"><?= date('F j, Y', strtotime($fb['created_at'])) ?></small>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="card" style="margin-top:20px">
    <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--text-primary);margin-bottom:12px">📌 Why Your Feedback Matters</h3>
    <p style="color:var(--text-secondary);font-size:.9rem;margin-bottom:10px">Your input helps us improve the Secure Erase Tool, create better educational content, fix bugs, and add features users actually want.</p>
    <p style="font-size:.875rem;color:var(--text-muted)"><strong style="color:var(--text-primary)">Total submissions:</strong>
      <?php $result=mysqli_query($conn,"SELECT COUNT(*) as count FROM feedback");$row=mysqli_fetch_assoc($result);echo $row['count']; ?>
    </p>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
