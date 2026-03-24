<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

$result = mysqli_query($conn, "SELECT * FROM erase_logs WHERE tool_type='desktop' ORDER BY start_time DESC");
$total  = mysqli_num_rows($result);
$completed = 0; $rows_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows_data[] = $row;
    if ($row['status']==='COMPLETED') $completed++;
}
$success_rate = $total > 0 ? round(($completed/$total)*100) : 0;
?>
<div class="admin-container">
    <div class="admin-page-banner">
        <h2>💻 Desktop Tool Usage Logs</h2>
        <p>Sessions from the SecureWipe desktop application — showing ADB-connected device wipes</p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:16px;position:relative;z-index:1;">
            <span class="banner-stat">💻 <?php echo $total; ?> total desktop sessions</span>
            <span class="banner-stat" style="background:rgba(16,185,129,0.12);border-color:rgba(16,185,129,0.3);color:var(--success);">✅ <?php echo $completed; ?> completed</span>
            <span class="banner-stat" style="background:rgba(245,158,11,0.12);border-color:rgba(245,158,11,0.3);color:var(--warning);">📈 <?php echo $success_rate; ?>% success rate</span>
        </div>
    </div>

    <?php if ($total > 0): ?>
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="🔍 Search by device model..." onkeyup="filterLogs()">
        <select id="statusFilter" onchange="filterLogs()">
            <option value="all">All Status</option>
            <option value="COMPLETED">✅ Completed</option>
            <option value="STARTED">🔵 Started</option>
            <option value="FAILED">❌ Failed</option>
        </select>
    </div>

    <div class="table-container">
        <table class="data-table" id="desktopLogsTable">
            <thead><tr>
                <th>ID</th><th>Device Model</th><th>Steps</th>
                <th>Status</th><th>Started</th><th>Completed</th>
            </tr></thead>
            <tbody>
            <?php foreach ($rows_data as $row):
                $sc = ['COMPLETED'=>'success','FAILED'=>'danger','STARTED'=>'info'];
                $status_class = $sc[$row['status']] ?? 'warning';
            ?>
            <tr data-status="<?php echo htmlspecialchars($row['status']); ?>">
                <td style="color:var(--text-muted);font-size:.8rem;">#<?php echo $row['log_id']; ?></td>
                <td style="color:var(--text-primary);font-weight:500;">
                    💻 <?php echo htmlspecialchars($row['device_model'] ?: 'Unknown Device'); ?>
                </td>
                <td>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <div style="flex:1;height:6px;background:var(--bg-elevated);border-radius:4px;min-width:60px;">
                            <div style="height:100%;background:<?php echo $row['status']==='COMPLETED' ? 'var(--success)' : 'var(--accent)'; ?>;border-radius:4px;width:<?php echo ($row['steps_completed']/4)*100; ?>%"></div>
                        </div>
                        <span style="font-size:.75rem;color:var(--text-muted);"><?php echo $row['steps_completed']; ?>/4</span>
                    </div>
                </td>
                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                <td style="font-size:.82rem;"><?php echo date('M d, Y · H:i', strtotime($row['start_time'])); ?></td>
                <td style="font-size:.82rem;"><?php echo $row['completion_time']
                    ? date('M d, Y · H:i', strtotime($row['completion_time']))
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
        <div class="empty-icon">💻</div><h3>No desktop tool logs yet</h3>
        <p>Logs will appear here when users run the SecureWipe desktop application and complete wipe sessions.</p>
        <p style="margin-top:8px;font-size:.82rem;">Make sure the Python tool is posting to <code style="background:var(--bg-elevated);padding:2px 8px;border-radius:4px;color:var(--accent);">log_completion.php</code> on completion.</p>
    </div>
    <?php endif; ?>

    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>
<script>
function filterLogs() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value;
    const rows   = document.querySelectorAll('#desktopLogsTable tbody tr');
    let visible  = 0;
    rows.forEach(row => {
        const ok = row.cells[1].textContent.toLowerCase().includes(search)
            && (status==='all' || row.dataset.status===status);
        row.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });
    const nr = document.getElementById('noResults');
    if (nr) nr.style.display = visible===0 ? 'block' : 'none';
}
</script>
<?php include 'includes/admin-footer.php'; ?>
