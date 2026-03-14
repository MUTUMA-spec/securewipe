<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Get total uses for display
$total_uses = 0;
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM erase_logs WHERE tool_type='web'");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_uses = $row['count'];
}
?>

<div class="secure-erase-page">
    <div class="erase-header">
        <h1>🛡️ Secure Erase Guide</h1>
        <p class="header-description">Follow this 4-step process to permanently erase all personal data from your device</p>
        <div class="header-stats">
            <div class="stat-badge">
                <span class="stat-icon">📊</span>
                <span class="stat-text"><?php echo number_format($total_uses); ?> devices wiped</span>
            </div>
            <div class="stat-badge">
                <span class="stat-icon">⏱️</span>
                <span class="stat-text">Takes 15-30 minutes</span>
            </div>
        </div>
    </div>

    <div id="secureEraseTool" class="erase-tool-container">
        
        <div class="device-selection-card">
            <div class="card-header">
                <span class="step-indicator-large">Step 0</span>
                <h2>Device Information</h2>
            </div>
            
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group">
                        <label for="deviceType">
                            <span class="label-icon">📱</span>
                            Device Type <span class="required">*</span>
                        </label>
                        <select id="deviceType" class="form-select" required>
                            <option value="" disabled selected>-- Select your device type --</option>
                            <option value="android">📱 Android</option>
                            <option value="iphone">📱 iPhone</option>
                            <option value="other">📱 Other (Windows, Blackberry, etc.)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="deviceModel">
                            <span class="label-icon">📝</span>
                            Device Model <span class="required">*</span>
                        </label>
                        <input type="text" id="deviceModel" class="form-input" 
                               placeholder="e.g., Samsung S21, iPhone 12, Google Pixel 6"
                               autocomplete="off">
                        <small class="input-hint">Enter your exact model for specific instructions</small>
                    </div>
                </div>

                <div id="deviceInstructions" class="instructions-area"></div>

                <div class="action-area">
                    <button id="startEraseBtn" class="btn-start">
                        <span class="btn-icon">▶</span>
                        START SECURE ERASE PROCESS
                    </button>
                </div>
            </div>
        </div>

        <div id="progressContainer" class="progress-container" style="display: none;">
            
            <div class="progress-header">
                <h2>Erase Progress</h2>
                <div class="progress-percentage" id="progressPercentage">0%</div>
            </div>

            <div class="step-indicator-modern">
                <div class="step-wrapper" id="stepWrapper1">
                    <div class="step-marker" id="stepIndicator1">1</div>
                    <div class="step-label">Encrypt</div>
                </div>
                <div class="step-connector"></div>
                <div class="step-wrapper" id="stepWrapper2">
                    <div class="step-marker" id="stepIndicator2">2</div>
                    <div class="step-label">Reset</div>
                </div>
                <div class="step-connector"></div>
                <div class="step-wrapper" id="stepWrapper3">
                    <div class="step-marker" id="stepIndicator3">3</div>
                    <div class="step-label">Overwrite</div>
                </div>
                <div class="step-connector"></div>
                <div class="step-wrapper" id="stepWrapper4">
                    <div class="step-marker" id="stepIndicator4">4</div>
                    <div class="step-label">Verify</div>
                </div>
            </div>

            <div class="progress-bar-container">
                <div id="progressBar" class="progress-bar-fill" style="width: 0%"></div>
            </div>

            <div class="status-card">
                <div class="status-icon" id="statusIcon">🔐</div>
                <div class="status-content">
                    <div class="status-label">Current Step:</div>
                    <div class="status-value" id="currentStepName">Encrypt Storage</div>
                </div>
            </div>

            <div class="steps-container">
                <div id="step1" class="step-card" style="display: none;">
                    <div class="step-header">
                        <div class="step-title">
                            <span class="step-number-badge">Step 1</span>
                            <h3>🔐 Encrypt Storage</h3>
                        </div>
                    </div>
                    
                    <div id="step1Instructions" class="step-instructions"></div>
                    
                    <div class="step-action-area">
                        <label class="confirm-checkbox">
                            <input type="checkbox" id="step1Confirm">
                            <span class="checkbox-text">I have completed encryption</span>
                        </label>
                        <button id="confirmStep1" class="btn-confirm" disabled>Confirm Step 1</button>
                    </div>
                </div>

                <div id="step2" class="step-card" style="display: none;">
                    <div class="step-header">
                        <div class="step-title">
                            <span class="step-number-badge">Step 2</span>
                            <h3>🔄 Factory Reset</h3>
                        </div>
                    </div>
                    
                    <div id="step2Instructions" class="step-instructions"></div>
                    
                    <div class="step-action-area">
                        <label class="confirm-checkbox">
                            <input type="checkbox" id="step2Confirm">
                            <span class="checkbox-text">I have completed factory reset</span>
                        </label>
                        <button id="confirmStep2" class="btn-confirm" disabled>Confirm Step 2</button>
                    </div>
                </div>

                <div id="step3" class="step-card" style="display: none;">
                    <div class="step-header">
                        <div class="step-title">
                            <span class="step-number-badge">Step 3</span>
                            <h3>✍️ Overwrite Storage</h3>
                        </div>
                    </div>
                    
                    <div id="step3Instructions" class="step-instructions"></div>
                    
                    <div class="step-action-area">
                        <label class="confirm-checkbox">
                            <input type="checkbox" id="step3Confirm">
                            <span class="checkbox-text">I have completed storage overwrite</span>
                        </label>
                        <button id="confirmStep3" class="btn-confirm" disabled>Confirm Step 3</button>
                    </div>
                </div>

                <div id="step4" class="step-card" style="display: none;">
                    <div class="step-header">
                        <div class="step-title">
                            <span class="step-number-badge">Step 4</span>
                            <h3>🔍 Verification</h3>
                        </div>
                    </div>
                    
                    <div id="step4Instructions" class="step-instructions"></div>
                    
                    <div class="step-action-area">
                        <label class="confirm-checkbox">
                            <input type="checkbox" id="step4Confirm">
                            <span class="checkbox-text">I have verified no data remains</span>
                        </label>
                        <button id="confirmStep4" class="btn-confirm" disabled>Confirm Step 4</button>
                    </div>
                </div>
            </div>

            <div id="completionMessage" class="completion-message" style="display: none;"></div>
        </div>

        <div class="info-section">
            <div class="info-card">
                <div class="info-icon">📋</div>
                <div class="info-content">
                    <h3>About This Tool</h3>
                    <p>This web-based guide walks you through the 4 essential steps to securely erase your device:</p>
                    <ul class="info-list">
                        <li><strong>Encrypt Storage</strong> - Scrambles data so it's unreadable without key</li>
                        <li><strong>Factory Reset</strong> - Removes encryption key, making data inaccessible</li>
                        <li><strong>Overwrite Storage</strong> - Writes over free space to prevent recovery</li>
                        <li><strong>Verification</strong> - Confirms device is clean and ready for sale</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/secure-erase.js"></script>



<?php include 'includes/footer.php'; ?>