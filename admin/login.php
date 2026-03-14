<?php
// Check for logout message
$logout_message = '';
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    $logout_message = '<div class="alert alert-success">You have been successfully logged out.</div>';
}
require_once '../includes/config.php';

// Redirect if already logged in
if (isAdminLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    
    // Simple query - we'll create an admin user first
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Verify password
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_username'] = $row['username'];
            
            // Update last login
            $update = "UPDATE admin SET last_login = NOW() WHERE admin_id = ?";
            $update_stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($update_stmt, "i", $row['admin_id']);
            mysqli_stmt_execute($update_stmt);
            
            redirect('dashboard.php');
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Username not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — SecureWipe</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
</head>
<body class="admin-login-page">
<script>(function(){const s=localStorage.getItem('sw-theme')||'dark';document.documentElement.setAttribute('data-theme',s);})();</script>
    <div class="admin-login-container">
        <div class="admin-login-box">
            <h2>Admin Access</h2>
            <div class="admin-login-subtitle">Secure Dashboard Login</div>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block" style="margin-top:8px">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>