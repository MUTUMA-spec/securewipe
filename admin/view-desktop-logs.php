<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

$result    = mysqli_query($conn, "SELECT * FROM erase_logs WHERE tool_type='desktop' ORDER BY start_time DESC");
$total     = mysqli_num_rows($result);
$rows_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows_data[] = $row;
}
?>
<div class="admin-container">
    <div class="admin-page-banner">
        <h2>⬇️ Desktop Tool Downloads</h2>
        <p>Every time a user downloads SecureWipe.exe from the website, it is recorded here.</p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:16px;position:relative;z-index:1;">
            <span class="banner-stat">⬇️ <?php echo $total; ?> total downloads</span>
        </div>
    </div>

    <?php if ($total > 0): ?>
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="🔍 Search by IP or date..." onkeyup="filterLogs()">
    </div>

    <div class="table-container">
        <table class="data-table" id="desktopLogsTable">
            <thead><tr>
                <th>#</th>
                <th>File</th>
                <th>Status</th>
                <th>IP Address</th>
                <th>Downloaded At</th>
            </tr></thead>
            <tbody>
            <?php foreach ($rows_data as $row): ?>
            <tr>
                <td style="color:var(--text-muted);font-size:.8rem;"><?php echo $row['log_id']; ?></td>
                <td style="color:var(--text-primary);font-weight:500;">
                    ⬇️ <?php echo htmlspecialchars($row['device_model'] ?: 'SecureWipe.exe'); ?>
                </td>
                <td><span class="status-badge success">DOWNLOADED</span></td>
                <td style="font-size:.82rem;color:var(--text-muted);">
                    <?php echo htmlspecialchars($row['ip_address'] ?: '—'); ?>
                </td>
                <td style="font-size:.82rem;">
                    <?php echo date('M d, Y · H:i', strtotime($row['start_time'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="noResults" style="display:none;" class="empty-state">
        <div class="empty-icon">🔍</div><h3>No matching results</h3>
        <p>Try adjusting your search.</p>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">⬇️</div>
        <h3>No downloads recorded yet</h3>
        <p>Downloads will appear here when users click the download button on the downloads page.</p>
    </div>
    <?php endif; ?>

    <a href="dashboard.php" class="back-btn" style="margin-top:24px;display:inline-flex;">← Back to Dashboard</a>
</div>

<script>
function filterLogs() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const rows   = document.querySelectorAll('#desktopLogsTable tbody tr');
    let visible  = 0;
    rows.forEach(row => {
        const ok = row.textContent.toLowerCase().includes(search);
        row.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });
    const nr = document.getElementById('noResults');
    if (nr) nr.style.display = visible === 0 ? 'block' : 'none';
}
</script>

<?php include 'includes/admin-footer.php'; ?>
