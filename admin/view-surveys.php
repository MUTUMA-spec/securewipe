<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

// Get all surveys
$result = mysqli_query($conn, "SELECT * FROM survey_responses ORDER BY submitted_at DESC");
$total = mysqli_num_rows($result);
?>

<div class="admin-container">
    <h2>📊 Survey Responses</h2>
    <p>Total responses: <strong><?php echo $total; ?></strong></p>
    
    <?php if ($total > 0): ?>
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="Search by age group or device..." onkeyup="filterSurveys()">
        <select id="beliefFilter" onchange="filterSurveys()">
            <option value="all">All Responses</option>
            <option value="yes">Believes Secure (Yes)</option>
            <option value="no">Believes Secure (No)</option>
        </select>
    </div>
    
    <div class="table-container">
        <table class="data-table" id="surveyTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Age Group</th>
                    <th>Device</th>
                    <th>Reset Method</th>
                    <th>Info Source</th>
                    <th>Believes Secure?</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr data-belief="<?php echo $row['believes_secure'] ? 'yes' : 'no'; ?>">
                    <td>#<?php echo $row['response_id']; ?></td>
                    <td><?php echo $row['age_group']; ?></td>
                    <td><?php echo $row['device_type'] ?: 'Not specified'; ?></td>
                    <td><?php echo htmlspecialchars(substr($row['reset_method'], 0, 50)); ?>...</td>
                    <td><?php echo str_replace('_', ' ', $row['info_source']); ?></td>
                    <td>
                        <?php if ($row['believes_secure']): ?>
                            <span class="status-badge success">✅ Yes</span>
                        <?php else: ?>
                            <span class="status-badge danger">❌ No</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($row['submitted_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">📋</div>
        <h3>No survey responses yet</h3>
        <p>Survey responses will appear here when users participate.</p>
    </div>
    <?php endif; ?>
    
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

<script>
function filterSurveys() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const beliefFilter = document.getElementById('beliefFilter').value;
    const rows = document.querySelectorAll('#surveyTable tbody tr');
    
    rows.forEach(row => {
        const ageGroup = row.cells[1].textContent.toLowerCase();
        const device = row.cells[2].textContent.toLowerCase();
        const belief = row.dataset.belief;
        
        const matchesSearch = ageGroup.includes(searchInput) || device.includes(searchInput);
        const matchesBelief = beliefFilter === 'all' || belief === beliefFilter;
        
        row.style.display = matchesSearch && matchesBelief ? '' : 'none';
    });
}
</script>

<?php include 'includes/admin-footer.php'; ?>