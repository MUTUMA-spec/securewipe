<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

if (isset($_GET['approve'])) {
    mysqli_query($conn, "UPDATE feedback SET approved=1 WHERE feedback_id=".intval($_GET['approve']));
    header('Location: view-feedback.php'); exit();
}
if (isset($_GET['reject'])) {
    mysqli_query($conn, "UPDATE feedback SET approved=0 WHERE feedback_id=".intval($_GET['reject']));
    header('Location: view-feedback.php'); exit();
}
if (isset($_GET['delete'])) {
    mysqli_query($conn, "DELETE FROM feedback WHERE feedback_id=".intval($_GET['delete']));
    header('Location: view-feedback.php'); exit();
}

$result = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC");
$total  = mysqli_num_rows($result);
$approved_count = 0; $pending_count = 0; $rows_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows_data[] = $row;
    if ($row['approved']) $approved_count++; else $pending_count++;
}
?>
<div class="admin-container">
    <div class="admin-page-banner">
        <h2>📬 User Feedback Management</h2>
        <p>Review, approve, and manage feedback submitted by users about their experience</p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:16px;position:relative;z-index:1;">
            <span class="banner-stat">💬 <?php echo $total; ?> total submissions</span>
            <span class="banner-stat" style="background:rgba(16,185,129,0.12);border-color:rgba(16,185,129,0.3);color:var(--success);">✅ <?php echo $approved_count; ?> approved</span>
            <span class="banner-stat" style="background:rgba(245,158,11,0.12);border-color:rgba(245,158,11,0.3);color:var(--warning);">⏳ <?php echo $pending_count; ?> pending</span>
        </div>
    </div>

    <?php if ($total > 0): ?>
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="🔍 Search by name or email..." onkeyup="filterTable()">
        <select id="statusFilter" onchange="filterTable()">
            <option value="all">All Status</option>
            <option value="approved">✅ Approved Only</option>
            <option value="pending">⏳ Pending Only</option>
        </select>
    </div>

    <div id="feedbackList">
    <?php foreach ($rows_data as $row):
        $cls = $row['approved'] ? 'approved' : 'pending';
    ?>
    <div class="feedback-card <?php echo $cls; ?>" data-status="<?php echo $cls; ?>"
         data-search="<?php echo strtolower(htmlspecialchars($row['user_name'].' '.$row['email'])); ?>">
        <div class="feedback-header">
            <div>
                <div class="feedback-author"><?php echo htmlspecialchars($row['user_name']); ?></div>
                <div class="feedback-email">✉️ <?php echo htmlspecialchars($row['email']); ?></div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <?php if ($row['approved']): ?>
                    <span class="status-badge success">✅ Approved</span>
                <?php else: ?>
                    <span class="status-badge warning">⏳ Pending Review</span>
                <?php endif; ?>
                <span style="font-size:.78rem;color:var(--text-muted);">
                    <?php echo date('M d, Y · H:i', strtotime($row['created_at'])); ?>
                </span>
            </div>
        </div>
        <div class="feedback-comment"><?php echo nl2br(htmlspecialchars($row['comment'])); ?></div>
        <div class="feedback-actions">
            <?php if (!$row['approved']): ?>
                <a href="?approve=<?php echo $row['feedback_id']; ?>" class="action-btn approve">✓ Approve</a>
            <?php else: ?>
                <a href="?reject=<?php echo $row['feedback_id']; ?>" class="action-btn reject">✗ Revoke Approval</a>
            <?php endif; ?>
            <a href="?delete=<?php echo $row['feedback_id']; ?>" class="action-btn delete"
               onclick="return confirm('Permanently delete this feedback entry?')">🗑️ Delete</a>
        </div>
    </div>
    <?php endforeach; ?>
    </div>

    <div id="noResults" style="display:none;" class="empty-state">
        <div class="empty-icon">🔍</div><h3>No matching feedback</h3>
        <p>Try adjusting your search or filter.</p>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">💬</div><h3>No feedback yet</h3>
        <p>User feedback will appear here when submitted through the site.</p>
    </div>
    <?php endif; ?>

    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>
<script>
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value;
    const cards  = document.querySelectorAll('#feedbackList .feedback-card');
    let visible  = 0;
    cards.forEach(card => {
        const ok = card.dataset.search.includes(search)
            && (status==='all' || card.dataset.status===status);
        card.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });
    const nr = document.getElementById('noResults');
    if (nr) nr.style.display = visible===0 ? 'block' : 'none';
}
</script>
<?php include 'includes/admin-footer.php'; ?>
