<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

$result = mysqli_query($conn, "SELECT * FROM survey_responses ORDER BY submitted_at DESC");
$total  = mysqli_num_rows($result);
$yes_count = 0; $no_count = 0; $rows_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows_data[] = $row;
    if ($row['believes_secure']) $yes_count++; else $no_count++;
}
$pct_yes = $total > 0 ? round(($yes_count/$total)*100) : 0;
?>
<div class="admin-container">
    <div class="admin-page-banner">
        <h2>📊 Survey Responses</h2>
        <p>User beliefs about factory resets and data security — insight into public awareness levels</p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:16px;position:relative;z-index:1;">
            <span class="banner-stat">📋 <?php echo $total; ?> total responses</span>
            <span class="banner-stat" style="background:rgba(16,185,129,0.12);border-color:rgba(16,185,129,0.3);color:var(--success);">✅ <?php echo $yes_count; ?> believe it's secure</span>
            <span class="banner-stat" style="background:rgba(239,68,68,0.12);border-color:rgba(239,68,68,0.3);color:var(--danger);">❌ <?php echo $no_count; ?> don't</span>
            <span class="banner-stat" style="background:rgba(245,158,11,0.12);border-color:rgba(245,158,11,0.3);color:var(--warning);">📈 <?php echo $pct_yes; ?>% misconception rate</span>
        </div>
    </div>

    <?php if ($total > 0): ?>

    <!-- Mini insight bar -->
    <div style="background:var(--bg-glass);backdrop-filter:var(--blur-sm);border:1px solid var(--border);border-radius:var(--radius-xl);padding:20px 24px;margin-bottom:24px;">
        <div style="font-size:.82rem;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:.6px;margin-bottom:10px;">Believes factory reset is secure enough</div>
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="flex:1;height:10px;background:var(--bg-elevated);border-radius:8px;overflow:hidden;">
                <div style="height:100%;width:<?php echo $pct_yes; ?>%;background:linear-gradient(90deg,var(--success),var(--accent));border-radius:8px;transition:width .6s ease;"></div>
            </div>
            <span style="font-family:var(--font-display);font-weight:700;color:var(--text-primary);min-width:40px;"><?php echo $pct_yes; ?>%</span>
        </div>
        <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">
            <?php echo $yes_count; ?> out of <?php echo $total; ?> users incorrectly believe a basic factory reset fully protects their data.
        </div>
    </div>

    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="🔍 Search by age group or device..." onkeyup="filterSurveys()">
        <select id="beliefFilter" onchange="filterSurveys()">
            <option value="all">All Responses</option>
            <option value="yes">✅ Believes Secure (Yes)</option>
            <option value="no">❌ Doesn't Believe (No)</option>
        </select>
    </div>

    <div class="table-container">
        <table class="data-table" id="surveyTable">
            <thead><tr>
                <th>ID</th><th>Age Group</th><th>Device</th>
                <th>Reset Method</th><th>Info Source</th>
                <th>Believes Secure?</th><th>Date</th>
            </tr></thead>
            <tbody>
            <?php foreach ($rows_data as $row): ?>
            <tr data-belief="<?php echo $row['believes_secure'] ? 'yes' : 'no'; ?>">
                <td style="color:var(--text-muted);font-size:.8rem;">#<?php echo $row['response_id']; ?></td>
                <td>
                    <span style="background:rgba(14,165,233,0.08);border:1px solid var(--border-accent);padding:3px 10px;border-radius:20px;font-size:.78rem;color:var(--accent);">
                        <?php echo htmlspecialchars($row['age_group']); ?>
                    </span>
                </td>
                <td style="color:var(--text-primary);"><?php echo htmlspecialchars($row['device_type'] ?: 'Not specified'); ?></td>
                <td style="max-width:200px;white-space:normal;font-size:.82rem;"><?php echo htmlspecialchars(substr($row['reset_method'],0,60)); ?>...</td>
                <td style="font-size:.82rem;"><?php echo htmlspecialchars(str_replace('_',' ',$row['info_source'])); ?></td>
                <td>
                    <?php if ($row['believes_secure']): ?>
                        <span class="status-badge success">✅ Yes</span>
                    <?php else: ?>
                        <span class="status-badge danger">❌ No</span>
                    <?php endif; ?>
                </td>
                <td style="font-size:.82rem;"><?php echo date('M d, Y', strtotime($row['submitted_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="noResults" style="display:none;" class="empty-state">
        <div class="empty-icon">🔍</div><h3>No matching responses</h3>
        <p>Try adjusting your search or filter criteria.</p>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">📋</div><h3>No survey responses yet</h3>
        <p>Survey responses will appear here when users participate through the website.</p>
    </div>
    <?php endif; ?>

    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>
<script>
function filterSurveys() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const belief = document.getElementById('beliefFilter').value;
    const rows   = document.querySelectorAll('#surveyTable tbody tr');
    let visible  = 0;
    rows.forEach(row => {
        const ok = (row.cells[1].textContent.toLowerCase().includes(search) ||
                    row.cells[2].textContent.toLowerCase().includes(search))
            && (belief==='all' || row.dataset.belief===belief);
        row.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });
    const nr = document.getElementById('noResults');
    if (nr) nr.style.display = visible===0 ? 'block' : 'none';
}
</script>
<?php include 'includes/admin-footer.php'; ?>
