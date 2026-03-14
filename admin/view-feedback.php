<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

// Handle approval/rejection
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE feedback SET approved = 1 WHERE feedback_id = $id");
    header('Location: view-feedback.php');
    exit();
}

if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    mysqli_query($conn, "UPDATE feedback SET approved = 0 WHERE feedback_id = $id");
    header('Location: view-feedback.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM feedback WHERE feedback_id = $id");
    header('Location: view-feedback.php');
    exit();
}

// Get all feedback
$result = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC");
$total = mysqli_num_rows($result);
?>

<div class="admin-container">
    <h2>📬 User Feedback Management</h2>
    <p>Total feedback submissions: <strong><?php echo $total; ?></strong></p>
    
    <?php if ($total > 0): ?>
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="Search by name or email..." onkeyup="filterTable()">
        <select id="statusFilter" onchange="filterTable()">
            <option value="all">All Status</option>
            <option value="approved">Approved Only</option>
            <option value="pending">Pending Only</option>
        </select>
    </div>
    
    <div class="table-container">
        <table class="data-table" id="feedbackTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr data-status="<?php echo $row['approved'] ? 'approved' : 'pending'; ?>">
                    <td>#<?php echo $row['feedback_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars(substr($row['comment'], 0, 60)); ?>...</td>
                    <td>
                        <?php if ($row['approved']): ?>
                            <span class="status-badge success">✅ Approved</span>
                        <?php else: ?>
                            <span class="status-badge warning">⏳ Pending</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <div class="action-group">
                            <?php if (!$row['approved']): ?>
                                <a href="?approve=<?php echo $row['feedback_id']; ?>" class="action-btn approve">✓ Approve</a>
                            <?php else: ?>
                                <a href="?reject=<?php echo $row['feedback_id']; ?>" class="action-btn reject">✗ Reject</a>
                            <?php endif; ?>
                            <a href="?delete=<?php echo $row['feedback_id']; ?>" class="action-btn delete" onclick="return confirm('Delete this feedback?')">🗑 Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">💬</div>
        <h3>No feedback yet</h3>
        <p>User feedback will appear here when submitted.</p>
    </div>
    <?php endif; ?>
    
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

<script>
function filterTable() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#feedbackTable tbody tr');
    
    rows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        const status = row.dataset.status;
        
        const matchesSearch = name.includes(searchInput) || email.includes(searchInput);
        const matchesStatus = statusFilter === 'all' || status === statusFilter;
        
        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}
</script>

<?php include 'includes/admin-footer.php'; ?>