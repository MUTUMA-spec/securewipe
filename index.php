<?php
require_once 'includes/config.php';
include 'includes/header.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Get some stats for the homepage
$total_surveys = 0;
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM survey_responses");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_surveys = $row['count'];
}

$total_tool_uses = 0;
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM erase_logs");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_tool_uses = $row['count'];
}
?>

<section class="hero-banking">
    <div class="hero-container">
        <div class="hero-content">
            <div class="trust-badge">
                <span class="badge-80">80%</span>
                <span class="badge-text">of users don't know the truth</span>
            </div>
            
            <h1 class="hero-headline">
                Is Your Phone <span class="gradient-text">Really Clean?</span>
            </h1>
            
            <p class="hero-description">
                That "factory reset" probably didn't erase your data. 
                Banking-grade security requires banking-grade understanding.
            </p>
            
            <div class="hero-stats-enterprise">
                <div class="stat-block">
                    <span class="stat-number"><?php echo number_format($total_surveys); ?></span>
                    <span class="stat-label">Survey Responses</span>
                </div>
                <div class="stat-block">
                    <span class="stat-number"><?php echo number_format($total_tool_uses); ?></span>
                    <span class="stat-label">Devices Secured</span>
                </div>
                <div class="stat-block">
                    <span class="stat-number">4</span>
                    <span class="stat-label">Security Steps</span>
                </div>
            </div>
            
            <div class="hero-actions">
                <a href="secure-erase.php" class="btn-primary-large">
                    <span class="btn-icon">🔒</span>
                    Start Secure Erase
                </a>
                <a href="#learn-more" class="btn-ghost">
                    Learn More
                </a>
            </div>
        </div>
        
        <div class="hero-visual">
            <div class="phone-premium">
                <div class="phone-frame-premium">
                    <div class="phone-notch-premium"></div>
                    <div class="phone-screen-premium">
                        <div class="hello-screen-premium">
                            <span class="hello-large">Hello</span>
                            <div class="hello-languages-premium">
                                <span>你好</span>
                                <span>Bonjour</span>
                                <span>Hola</span>
                                <span>こんにちは</span>
                            </div>
                        </div>
                    </div>
                    <div class="phone-home-premium"></div>
                </div>
                <div class="phone-caption-premium">
                    <span class="caption-dot"></span>
                    Successfully wiped device
                </div>
            </div>
        </div>
    </div>
</section>

<section id="learn-more" class="problem-section">
    <div class="section-header">
        <h2>The Hard Truth About Factory Resets</h2>
        <p class="section-subtitle">What you don't know could cost you your privacy</p>
    </div>
    
    <div class="problem-grid">
        <div class="problem-card">
            <div class="problem-icon">❌</div>
            <h3>Factory Reset</h3>
            <p>Only marks data as "deleted" - it's still physically on your phone</p>
            <div class="problem-detail">
                <span class="badge danger">Recoverable</span>
            </div>
        </div>
        
        <div class="problem-card vs-card">
            <div class="vs-badge">VS</div>
        </div>
        
        <div class="problem-card highlight">
            <div class="problem-icon">✅</div>
            <h3>Secure Erase</h3>
            <p>Actually overwrites data multiple times - completely gone forever</p>
            <div class="problem-detail">
                <span class="badge success">Permanently Erased</span>
            </div>
        </div>
    </div>
</section>

<section class="how-it-works">
    <div class="section-header">
        <h2>How Our Secure Erase Tool Works</h2>
        <p class="section-subtitle">4 simple steps to complete peace of mind</p>
    </div>
    
    <div class="steps-container">
        <div class="step-item">
            <div class="step-number">1</div>
            <div class="step-content">
                <h4>Encrypt Storage</h4>
                <p>Scrambles all data so it's unreadable without the key</p>
            </div>
        </div>
        
        <div class="step-item">
            <div class="step-number">2</div>
            <div class="step-content">
                <h4>Factory Reset</h4>
                <p>Removes the encryption key, making data inaccessible</p>
            </div>
        </div>
        
        <div class="step-item">
            <div class="step-number">3</div>
            <div class="step-content">
                <h4>Overwrite Storage</h4>
                <p>Writes random data to every sector multiple times</p>
            </div>
        </div>
        
        <div class="step-item">
            <div class="step-number">4</div>
            <div class="step-content">
                <h4>Verification</h4>
                <p>Confirms no recoverable data remains</p>
            </div>
        </div>
    </div>
    
    <div class="progress-demo">
        <div class="demo-label">Real-time progress tracking:</div>
        <div class="demo-bar">
            <div class="demo-progress" style="width: 75%"></div>
        </div>
        <div class="demo-steps">
            <span class="demo-step completed">Encrypt</span>
            <span class="demo-step completed">Reset</span>
            <span class="demo-step active">Overwrite</span>
            <span class="demo-step">Verify</span>
        </div>
    </div>
</section>

<section class="tools-showcase">
    <div class="section-header">
        <h2>Choose Your Tool</h2>
        <p class="section-subtitle">Web-based guide or desktop application - you decide</p>
    </div>
    
    <div class="tools-grid">
        <div class="tool-card">
            <div class="tool-header web">
                <span class="tool-icon">🌐</span>
                <h3>Web-Based Tool</h3>
            </div>
            <div class="tool-body">
                <ul class="tool-features">
                    <li>✓ No installation needed</li>
                    <li>✓ Works on any device</li>
                    <li>✓ Step-by-step guidance</li>
                    <li>✓ Progress tracking</li>
                </ul>
                <a href="secure-erase.php" class="btn btn-primary btn-block">Use Web Tool</a>
            </div>
        </div>
        
        <div class="tool-card featured">
            <div class="featured-badge">RECOMMENDED</div>
            <div class="tool-header desktop">
                <span class="tool-icon">💻</span>
                <h3>Desktop Application</h3>
            </div>
            <div class="tool-body">
                <ul class="tool-features">
                    <li>✓ Direct phone connection</li>
                    <li>✓ Automatic device detection</li>
                    <li>✓ Actual ADB commands</li>
                    <li>✓ Wipe certificate</li>
                </ul>
                <a href="download-tool.php" class="btn btn-success btn-block">Download Desktop Tool</a>
            </div>
        </div>
    </div>
</section>

<section class="stats-section">
    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-icon">📊</div>
            <div class="stat-box-number"><?php echo $total_surveys; ?></div>
            <div class="stat-box-label">Survey Participants</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon">📱</div>
            <div class="stat-box-number"><?php echo $total_tool_uses; ?></div>
            <div class="stat-box-label">Devices Securely Wiped</div>
        </div>
        <div class="stat-box">
            <div class="stat-icon">⭐</div>
            <div class="stat-box-number">100+</div>
            <div class="stat-box-label">Research Participants</div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="cta-content">
        <h2>Ready to protect your privacy?</h2>
        <p>Join thousands of users who securely wipe their devices before selling</p>
        <div class="cta-buttons">
            <a href="survey.php" class="btn btn-primary btn-large">Take Our Survey</a>
            <a href="feedback.php" class="btn btn-outline-light btn-large">Leave Feedback</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>