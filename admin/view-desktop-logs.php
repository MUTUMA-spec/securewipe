<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

// Get only desktop tool logs
$result = mysqli_query($conn, "SELECT * FROM erase_logs WHERE tool_type = 'desktop' ORDER BY start_time DESC");
$total = mysqli_num_rows($result);
?>

<div class="admin-container">
    <h2>💻 Desktop Tool Usage Logs</h2>
    <p>Total desktop tool uses: <strong><?php echo $total; ?></strong></p>
    
    <?php if ($total > 0): ?>
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="Search by device model..." onkeyup="filterDesktopLogs()">
        <select id="statusFilter" onchange="filterDesktopLogs()">
            <option value="all">All Status</option>
            <option value="COMPLETED">Completed</option>
            <option value="STARTED">Started</option>
            <option value="STEP1">Step 1</option>
            <option value="STEP2">Step 2</option>
            <option value="STEP3">Step 3</option>
            <option value="STEP4">Step 4</option>
            <option value="FAILED">Failed</option>
        </select>
    </div>
    
    <div class="table-container">
        <table class="data-table" id="desktopLogsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Device Model</th>
                    <th>Status</th>
                    <th>Started</th>
                    <th>Completed</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): 
                    $status_class = '';
                    switch($row['status']) {
                        case 'COMPLETED': $status_class = 'success'; break;
                        case 'FAILED': $status_class = 'danger'; break;
                        case 'STARTED': $status_class = 'info'; break;
                        default: $status_class = 'warning';
                    }
                ?>
                <tr data-status="<?php echo $row['status']; ?>">
                    <td>#<?php echo $row['log_id']; ?></td>
                    <td><?php echo $row['device_model']; ?></td>
                    <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $row['status']; ?></span></td>
                    <td><?php echo date('M d, H:i', strtotime($row['start_time'])); ?></td>
                    <td>
                        <?php echo $row['completion_time'] ? date('M d, H:i', strtotime($row['completion_time'])) : '<span class="status-badge warning">In Progress</span>'; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">💻</div>
        <h3>No desktop tool logs yet</h3>
        <p>Desktop tool usage will appear here when users run the application.</p>
    </div>
    <?php endif; ?>
    
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

<script>
function filterDesktopLogs() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#desktopLogsTable tbody tr');
    
    rows.forEach(row => {
        const model = row.cells[1].textContent.toLowerCase();
        const status = row.dataset.status;
        
        const matchesSearch = model.includes(searchInput);
        const matchesStatus = statusFilter === 'all' || status === statusFilter;
        
        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}
</script>

<?php include 'includes/admin-footer.php'; ?>