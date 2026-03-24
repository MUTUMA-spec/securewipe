<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

$result = mysqli_query($conn, "SELECT * FROM erase_logs ORDER BY start_time DESC");
$total = mysqli_num_rows($result);
$web_count = 0; $desktop_count = 0; $completed_count = 0;
$rows_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows_data[] = $row;
    if ($row['tool_type'] === 'web') $web_count++;
    if ($row['tool_type'] === 'desktop') $desktop_count++;
    if ($row['status'] === 'COMPLETED') $completed_count++;
}
?>
<div class="admin-container">
    <div class="admin-page-banner">
        <h2>🛡️ Secure Erase Tool Logs</h2>
        <p>All web and desktop tool usage sessions — track every device that has gone through the wipe process</p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:16px;position:relative;z-index:1;">
            <span class="banner-stat">📊 <?php echo $total; ?> total sessions</span>
            <span class="banner-stat" style="background:rgba(16,185,129,0.12);border-color:rgba(16,185,129,0.3);color:var(--success);">✅ <?php echo $completed_count; ?> completed</span>
            <span class="banner-stat">🌐 <?php echo $web_count; ?> web</span>
            <span class="banner-stat" style="background:rgba(245,158,11,0.12);border-color:rgba(245,158,11,0.3);color:var(--warning);">💻 <?php echo $desktop_count; ?> desktop</span>
        </div>
    </div>

    <?php if ($total > 0): ?>
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="🔍 Search by device model..." onkeyup="filterLogs()">
        <select id="statusFilter" onchange="filterLogs()">
            <option value="all">All Status</option>
            <option value="COMPLETED">Completed</option>
            <option value="STARTED">Started</option>
            <option value="STEP1">Step 1</option><option value="STEP2">Step 2</option>
            <option value="STEP3">Step 3</option><option value="STEP4">Step 4</option>
            <option value="FAILED">Failed</option>
        </select>
        <select id="toolFilter" onchange="filterLogs()">
            <option value="all">All Tools</option>
            <option value="web">🌐 Web Tool</option>
            <option value="desktop">💻 Desktop Tool</option>
        </select>
    </div>
    <div class="table-container">
        <table class="data-table" id="logsTable">
            <thead><tr>
                <th>ID</th><th>Device</th><th>Model</th><th>Tool</th>
                <th>Status</th><th>Steps</th><th>Started</th><th>Completed</th>
            </tr></thead>
            <tbody>
            <?php foreach ($rows_data as $row):
                $sc = ['COMPLETED'=>'success','FAILED'=>'danger','STARTED'=>'info'];
                $status_class = $sc[$row['status']] ?? 'warning';
                $icon = in_array($row['device_type'],['android','iphone']) ? '📱' : '📟';
            ?>
            <tr data-status="<?php echo htmlspecialchars($row['status']); ?>" data-tool="<?php echo htmlspecialchars($row['tool_type']); ?>">
                <td style="color:var(--text-muted);font-size:.8rem;">#<?php echo $row['log_id']; ?></td>
                <td><?php echo $icon.' '.ucfirst(htmlspecialchars($row['device_type'])); ?></td>
                <td style="color:var(--text-primary);font-weight:500;"><?php echo htmlspecialchars($row['device_model'] ?: '—'); ?></td>
                <td><?php echo $row['tool_type']==='web'
                    ? '<span class="status-badge info">🌐 Web</span>'
                    : '<span class="status-badge success">💻 Desktop</span>'; ?></td>
                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                <td>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <div style="flex:1;height:6px;background:var(--bg-elevated);border-radius:4px;min-width:60px;">
                            <div style="height:100%;background:var(--accent);border-radius:4px;width:<?php echo ($row['steps_completed']/4)*100; ?>%"></div>
                        </div>
                        <span style="font-size:.75rem;color:var(--text-muted);"><?php echo $row['steps_completed']; ?>/4</span>
                    </div>
                </td>
                <td style="font-size:.82rem;"><?php echo date('M d, H:i', strtotime($row['start_time'])); ?></td>
                <td style="font-size:.82rem;"><?php echo $row['completion_time']
                    ? date('M d, H:i', strtotime($row['completion_time']))
                    : '<span class="status-badge warning">In progress</span>'; ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="noResults" style="display:none;" class="empty-state">
        <div class="empty-icon">🔍</div><h3>No matching results</h3>
        <p>Try adjusting your search or filter criteria.</p>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">📊</div><h3>No logs yet</h3>
        <p>Tool usage data will appear here when users start the secure erase process.</p>
    </div>
    <?php endif; ?>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>
<script>
function filterLogs() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value;
    const tool   = document.getElementById('toolFilter').value;
    const rows   = document.querySelectorAll('#logsTable tbody tr');
    let visible  = 0;
    rows.forEach(row => {
        const ok = row.cells[2].textContent.toLowerCase().includes(search)
            && (status==='all'||row.dataset.status===status)
            && (tool==='all'||row.dataset.tool===tool);
        row.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });
    const nr = document.getElementById('noResults');
    if (nr) nr.style.display = visible===0 ? 'block' : 'none';
}
</script>
<?php include 'includes/admin-footer.php'; ?>
