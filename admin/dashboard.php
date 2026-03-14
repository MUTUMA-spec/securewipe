<?php
require_once '../includes/config.php';
include 'includes/admin-header.php';

// Get statistics
$stats = [];

// Total guides
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM guides");
$stats['guides'] = mysqli_fetch_assoc($result)['count'];

// Total surveys
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM survey_responses");
$stats['surveys'] = mysqli_fetch_assoc($result)['count'];

// Total feedback
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM feedback");
$stats['feedback'] = mysqli_fetch_assoc($result)['count'];

// Total erase logs
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM erase_logs");
$stats['erase_logs'] = mysqli_fetch_assoc($result)['count'];

// Completed erases
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM erase_logs WHERE status = 'COMPLETED'");
$completed = mysqli_fetch_assoc($result)['count'];
$completion_rate = $stats['erase_logs'] > 0 ? round(($completed / $stats['erase_logs']) * 100) : 0;

// Device breakdown
$device_stats = [];
$result = mysqli_query($conn, "SELECT device_type, COUNT(*) as count FROM erase_logs GROUP BY device_type");
while ($row = mysqli_fetch_assoc($result)) {
    $device_stats[$row['device_type']] = $row['count'];
}

// Tool usage (web vs desktop)
$tool_stats = [];
$result = mysqli_query($conn, "SELECT tool_type, COUNT(*) as count FROM erase_logs GROUP BY tool_type");
while ($row = mysqli_fetch_assoc($result)) {
    $tool_stats[$row['tool_type']] = $row['count'];
}
?>

<div class="admin-dashboard">
    <!-- Header with User Info -->
    <div class="admin-header">
        <h1>Dashboard Overview</h1>
        <div class="admin-user-info">
            <span>Welcome back, <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
            <a href="logout.php" class="admin-logout-btn">Logout</a>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="admin-stat-icon">📚</div>
            <div class="admin-stat-value"><?php echo $stats['guides']; ?></div>
            <div class="admin-stat-label">Educational Guides</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-icon">📊</div>
            <div class="admin-stat-value"><?php echo $stats['surveys']; ?></div>
            <div class="admin-stat-label">Survey Responses</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-icon">💬</div>
            <div class="admin-stat-value"><?php echo $stats['feedback']; ?></div>
            <div class="admin-stat-label">Feedback Entries</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-icon">🛡️</div>
            <div class="admin-stat-value"><?php echo $stats['erase_logs']; ?></div>
            <div class="admin-stat-label">Erase Tool Uses</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-icon">📈</div>
            <div class="admin-stat-value"><?php echo $completion_rate; ?>%</div>
            <div class="admin-stat-label">Completion Rate</div>
        </div>
    </div>

    <!-- Two Column Layout for Stats -->
    <div class="admin-sections-grid">
        <!-- Device Usage Section -->
        <div class="admin-section">
            <div class="admin-section-header">
                <h2>📱 Device Usage Breakdown</h2>
            </div>
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Device Type</th>
                            <th>Usage Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($device_stats as $type => $count): ?>
                        <tr>
                            <td>
                                <?php 
                                $icon = '';
                                switch($type) {
                                    case 'android': $icon = '📱'; break;
                                    case 'iphone': $icon = '📱'; break;
                                    case 'other': $icon = '📟'; break;
                                    default: $icon = '❓';
                                }
                                echo $icon . ' ' . ucfirst($type); 
                                ?>
                            </td>
                            <td><span class="admin-badge admin-badge-info"><?php echo $count; ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tool Usage Section -->
        <div class="admin-section">
            <div class="admin-section-header">
                <h2>⚙️ Tool Usage (Web vs Desktop)</h2>
            </div>
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Tool Type</th>
                            <th>Usage Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tool_stats as $type => $count): ?>
                        <tr>
                            <td>
                                <?php 
                                $icon = ($type == 'web') ? '🌐' : '💻';
                                echo $icon . ' ' . ucfirst($type); 
                                ?>
                            </td>
                            <td><span class="admin-badge admin-badge-success"><?php echo $count; ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Surveys Section -->
    <div class="admin-section">
        <div class="admin-section-header">
            <h2>📝 Recent Survey Responses</h2>
            <a href="view-surveys.php" class="btn btn-primary">View All Surveys</a>
        </div>
        
        <?php
        $result = mysqli_query($conn, "SELECT * FROM survey_responses ORDER BY submitted_at DESC LIMIT 5");
        if (mysqli_num_rows($result) > 0):
        ?>
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Age Group</th>
                        <th>Device</th>
                        <th>Believes Secure?</th>
                        <th>Info Source</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['age_group']; ?></td>
                        <td><?php echo $row['device_type'] ?: 'Not specified'; ?></td>
                        <td>
                            <?php if ($row['believes_secure']): ?>
                                <span class="admin-badge admin-badge-success">✅ Yes</span>
                            <?php else: ?>
                                <span class="admin-badge admin-badge-danger">❌ No</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo str_replace('_', ' ', $row['info_source']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($row['submitted_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="admin-empty-state">
            <div class="empty-icon">📊</div>
            <h3>No survey responses yet</h3>
            <p>Survey responses will appear here when users participate.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Recent Feedback Section -->
    <div class="admin-section">
        <div class="admin-section-header">
            <h2>💭 Recent Feedback</h2>
            <a href="view-feedback.php" class="btn btn-primary">Manage Feedback</a>
        </div>
        
        <?php
        $result = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC LIMIT 5");
        if (mysqli_num_rows($result) > 0):
        ?>
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo substr(htmlspecialchars($row['comment']), 0, 40); ?>...</td>
                        <td>
                            <?php if ($row['approved']): ?>
                                <span class="admin-badge admin-badge-success">Approved</span>
                            <?php else: ?>
                                <span class="admin-badge admin-badge-warning">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="admin-empty-state">
            <div class="empty-icon">💭</div>
            <h3>No feedback yet</h3>
            <p>User feedback will appear here when submitted.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Action Buttons -->
    <div class="admin-section">
        <div class="admin-section-header">
            <h2>⚡ Quick Actions</h2>
        </div>
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="view-surveys.php" class="btn btn-primary" style="padding: 12px 24px;">📊 View All Surveys</a>
            <a href="view-feedback.php" class="btn btn-primary" style="padding: 12px 24px;">💬 Moderate Feedback</a>
            <a href="view-erase-logs.php" class="btn btn-primary" style="padding: 12px 24px;">🌐 Web Tool Logs</a>
            <a href="view-desktop-logs.php" class="btn btn-success" style="padding: 12px 24px;">💻 Desktop Tool Logs</a>
        </div>
    </div>
</div>



<?php include 'includes/admin-footer.php'; ?>