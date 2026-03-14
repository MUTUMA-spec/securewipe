<?php
require_once 'includes/config.php';
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $age_group = sanitizeInput($_POST['age_group']);
    $reset_method = sanitizeInput($_POST['reset_method']);
    $believes_secure = isset($_POST['believes_secure']) ? 1 : 0;
    $info_source = sanitizeInput($_POST['info_source']);
    $device_type = sanitizeInput($_POST['device_type']);

    if (empty($age_group) || empty($reset_method) || empty($info_source)) {
        $error_message = "Please fill in all required fields.";
    } else {
        $sql = "INSERT INTO survey_responses (age_group, reset_method, believes_secure, info_source, device_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiss", $age_group, $reset_method, $believes_secure, $info_source, $device_type);
        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Thank you! Your response has been recorded.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

include 'includes/header.php';
?>

<div class="survey-container">
  <h1>📊 Smartphone Reset Practices Survey</h1>
  <p>Help us understand how people reset their phones before selling. Your responses are anonymous.</p>

  <?php if ($success_message): ?><div class="alert alert-success"><?= $success_message ?></div><?php endif; ?>
  <?php if ($error_message): ?><div class="alert alert-danger"><?= $error_message ?></div><?php endif; ?>

  <div class="card">
    <form method="POST" action="survey.php">
      <div class="form-group">
        <label for="age_group">Your Age Group *</label>
        <select name="age_group" id="age_group" required>
          <option value="">-- Select --</option>
          <option value="18-24">18-24 years</option>
          <option value="25-34">25-34 years</option>
          <option value="35-44">35-44 years</option>
          <option value="45-54">45-54 years</option>
          <option value="55+">55+ years</option>
        </select>
      </div>
      <div class="form-group">
        <label for="device_type">What type of phone do you use?</label>
        <select name="device_type" id="device_type">
          <option value="">-- Select --</option>
          <option value="android">Android</option>
          <option value="iphone">iPhone</option>
          <option value="other">Other</option>
        </select>
      </div>
      <div class="form-group">
        <label for="reset_method">How do you reset your phone before selling? *</label>
        <textarea name="reset_method" id="reset_method" rows="4" required placeholder="Example: I go to Settings → System → Reset and tap 'Erase all data'"></textarea>
        <small class="input-hint">Tell us the exact steps you follow</small>
      </div>
      <div class="form-group">
        <label for="info_source">Where did you learn this reset method? *</label>
        <select name="info_source" id="info_source" required>
          <option value="">-- Select --</option>
          <option value="online_tutorial">Online tutorial (YouTube, website)</option>
          <option value="device_manual">Device manual</option>
          <option value="friend_family">Friend or family member</option>
          <option value="social_media">Social media</option>
          <option value="store_employee">Store employee</option>
          <option value="figured_out">Figured it out myself</option>
        </select>
      </div>
      <div class="form-group">
        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
          <input type="checkbox" name="believes_secure" value="1" style="width:18px;height:18px;accent-color:var(--success)">
          <span style="font-weight:400;font-size:.9rem;color:var(--text-secondary)">I believe a factory reset completely and permanently erases all my personal data</span>
        </label>
      </div>
      <div style="display:flex;gap:12px;flex-wrap:wrap">
        <button type="submit" class="btn btn-primary">Submit Survey</button>
        <a href="index.php" class="btn btn-ghost">Cancel</a>
      </div>
    </form>
  </div>

  <div class="card" style="margin-top:20px">
    <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--text-primary);margin-bottom:10px">📋 About This Survey</h3>
    <p style="font-size:.9rem;color:var(--text-secondary);margin-bottom:10px">This survey is part of our research to understand common reset practices and create better educational content about secure data wiping.</p>
    <p style="font-size:.875rem;color:var(--text-muted)"><strong style="color:var(--text-primary)">Total responses:</strong>
      <?php $result=mysqli_query($conn,"SELECT COUNT(*) as count FROM survey_responses");$row=mysqli_fetch_assoc($result);echo $row['count']; ?>
    </p>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
