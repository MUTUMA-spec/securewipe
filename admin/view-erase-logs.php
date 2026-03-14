<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

// Get all erase logs
$result = mysqli_query($conn, "SELECT * FROM erase_logs ORDER BY start_time DESC");
$total = mysqli_num_rows($result);
?>

<div class="admin-container">
    <h2>🛡️ Secure Erase Tool Logs</h2>
    <p>Total tool uses: <strong><?php echo $total; ?></strong></p>
    
    <?php if ($total > 0): ?>
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="Search by device model..." onkeyup="filterLogs()">
        <select id="statusFilter" onchange="filterLogs()">
            <option value="all">All Status</option>
            <option value="COMPLETED">Completed</option>
            <option value="STARTED">Started</option>
            <option value="STEP1">Step 1</option>
            <option value="STEP2">Step 2</option>
            <option value="STEP3">Step 3</option>
            <option value="STEP4">Step 4</option>
            <option value="FAILED">Failed</option>
        </select>
        <select id="toolFilter" onchange="filterLogs()">
            <option value="all">All Tools</option>
            <option value="web">Web Tool</option>
            <option value="desktop">Desktop Tool</option>
        </select>
    </div>
    
    <div class="table-container">
        <table class="data-table" id="logsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Device</th>
                    <th>Model</th>
                    <th>Tool</th>
                    <th>Status</th>
                    <th>Steps</th>
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
                <tr data-status="<?php echo $row['status']; ?>" data-tool="<?php echo $row['tool_type']; ?>">
                    <td>#<?php echo $row['log_id']; ?></td>
                    <td>
                        <?php 
                        $icon = '';
                        switch($row['device_type']) {
                            case 'android': $icon = '📱'; break;
                            case 'iphone': $icon = '📱'; break;
                            default: $icon = '📟';
                        }
                        echo $icon . ' ' . ucfirst($row['device_type']); 
                        ?>
                    </td>
                    <td><?php echo $row['device_model']; ?></td>
                    <td>
                        <?php if ($row['tool_type'] == 'web'): ?>
                            <span class="status-badge info">🌐 Web</span>
                        <?php else: ?>
                            <span class="status-badge success">💻 Desktop</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $row['status']; ?></span></td>
                    <td><?php echo $row['steps_completed']; ?>/4</td>
                    <td><?php echo date('M d, H:i', strtotime($row['start_time'])); ?></td>
                    <td>
                        <?php echo $row['completion_time'] ? date('M d, H:i', strtotime($row['completion_time'])) : '-'; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">📊</div>
        <h3>No logs yet</h3>
        <p>Tool usage data will appear here when users start the secure erase process.</p>
    </div>
    <?php endif; ?>
    
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>

<script>
function filterLogs() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const toolFilter = document.getElementById('toolFilter').value;
    const rows = document.querySelectorAll('#logsTable tbody tr');
    
    rows.forEach(row => {
        const model = row.cells[2].textContent.toLowerCase();
        const status = row.dataset.status;
        const tool = row.dataset.tool;
        
        const matchesSearch = model.includes(searchInput);
        const matchesStatus = statusFilter === 'all' || status === statusFilter;
        const matchesTool = toolFilter === 'all' || tool === toolFilter;
        
        row.style.display = matchesSearch && matchesStatus && matchesTool ? '' : 'none';
    });
}
</script>

<?php include 'includes/admin-footer.php'; ?>