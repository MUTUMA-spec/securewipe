<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Get guides from database (if you want dynamic content)
// For now, we'll use static guides
?>

<div class="guides-container">
    <!-- Header Section -->
    <section class="guides-header">
        <h1>📚 Secure Wiping Guides</h1>
        <p class="guides-subtitle">Step-by-step instructions for permanently erasing your data</p>
    </section>

    <!-- Device Tabs -->
    <div class="device-tabs">
        <button class="tab-button active" onclick="showDevice('android', event)">📱 Android</button>
        <button class="tab-button" onclick="showDevice('iphone', event)">📱 iPhone</button>
        <button class="tab-button" onclick="showDevice('other', event)">📱 Other Devices</button>
    </div>

    <!-- Android Guides -->
    <div id="android-guides" class="device-guides active">
        <div class="guide-card">
            <div class="guide-header">
                <span class="guide-icon">🔐</span>
                <h2>Step 1: Enable Encryption</h2>
            </div>
            <div class="guide-content">
                <p>Most modern Androids are encrypted by default, but verify:</p>
                <ol>
                    <li>Go to <strong>Settings → Security</strong></li>
                    <li>Look for <strong>"Encrypt phone"</strong> or <strong>"Encrypt device"</strong></li>
                    <li>If not encrypted, follow on-screen instructions (takes about an hour)</li>
                </ol>
                <div class="tip-box">
                    <span class="tip-icon">💡</span>
                    <p>Keep your phone plugged in during encryption to avoid interruption</p>
                </div>
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-header">
                <span class="guide-icon">🔄</span>
                <h2>Step 2: Factory Reset</h2>
            </div>
            <div class="guide-content">
                <p>Different Android versions have slightly different paths:</p>
                
                <div class="accordion">
                    <div class="accordion-item">
                        <button class="accordion-header">Samsung Devices</button>
                        <div class="accordion-content">
                            <ol>
                                <li>Settings → General Management → Reset</li>
                                <li>Tap "Factory data reset"</li>
                                <li>Scroll down and tap "Reset"</li>
                                <li>Enter PIN/password if prompted</li>
                                <li>Tap "Delete all"</li>
                            </ol>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">Google Pixel / Stock Android</button>
                        <div class="accordion-content">
                            <ol>
                                <li>Settings → System → Reset options</li>
                                <li>Tap "Erase all data (factory reset)"</li>
                                <li>Tap "Reset phone"</li>
                                <li>Enter PIN/password if prompted</li>
                                <li>Tap "Erase everything"</li>
                            </ol>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">OnePlus / OxygenOS</button>
                        <div class="accordion-content">
                            <ol>
                                <li>Settings → System → Reset options</li>
                                <li>Tap "Erase all data (factory reset)"</li>
                                <li>Tap "Reset phone"</li>
                                <li>Read warning and tap "Reset"</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="warning-box">
                    <span class="warning-icon">⚠️</span>
                    <p><strong>Important:</strong> This will delete ALL data. Make sure you've backed up anything important!</p>
                </div>
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-header">
                <span class="guide-icon">✍️</span>
                <h2>Step 3: Overwrite Storage (Optional but Recommended)</h2>
            </div>
            <div class="guide-content">
                <p>For maximum security, overwrite the free space:</p>
                
                <div class="methods-grid">
                    <div class="method-card">
                        <h4>Method A: Samsung Secure Erase</h4>
                        <p>For Samsung devices, use their built-in tool:</p>
                        <ol>
                            <li>Settings → Battery and device care</li>
                            <li>Tap "Storage"</li>
                            <li>Tap "Secure Erase"</li>
                        </ol>
                    </div>

                    <div class="method-card">
                        <h4>Method B: Third-Party Apps</h4>
                        <p>Download from Play Store:</p>
                        <ul>
                            <li>iShredder</li>
                            <li>Secure Eraser</li>
                            <li>Shreddit - Data Eraser</li>
                        </ul>
                    </div>

                    <div class="method-card">
                        <h4>Method C: Multiple Resets</h4>
                        <p>Perform factory reset 2-3 times in a row. Each reset overwrites differently.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-header">
                <span class="guide-icon">🔍</span>
                <h2>Step 4: Verification</h2>
            </div>
            <div class="guide-content">
                <p>Confirm your data is gone:</p>
                <ol>
                    <li>Device should reboot to the <strong>welcome/setup screen</strong></li>
                    <li>No previous apps or accounts should appear</li>
                    <li>Try to reboot again - should still show setup</li>
                </ol>
                <div class="success-box">
                    <span class="success-icon">✅</span>
                    <p><strong>Success!</strong> Your Android is now safe to sell or dispose.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- iPhone Guides -->
    <div id="iphone-guides" class="device-guides">
        <div class="guide-card">
            <div class="guide-header">
                <span class="guide-icon">☁️</span>
                <h2>Step 1: Sign Out of iCloud</h2>
            </div>
            <div class="guide-content">
                <ol>
                    <li>Go to <strong>Settings → [Your Name]</strong> at the top</li>
                    <li>Scroll down and tap <strong>"Sign Out"</strong></li>
                    <li>Enter your Apple ID password to disable Find My iPhone</li>
                    <li>Choose what data to keep on phone (recommend: keep none)</li>
                    <li>Tap "Sign Out" again</li>
                </ol>
                <div class="warning-box">
                    <span class="warning-icon">⚠️</span>
                    <p>If you don't sign out of iCloud, Activation Lock will prevent the next user from setting up the phone!</p>
                </div>
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-header">
                <span class="guide-icon">🔄</span>
                <h2>Step 2: Factory Reset</h2>
            </div>
            <div class="guide-content">
                <ol>
                    <li>Go to <strong>Settings → General → Transfer or Reset iPhone</strong></li>
                    <li>Tap <strong>"Erase All Content and Settings"</strong></li>
                    <li>Enter your passcode if prompted</li>
                    <li>Enter your Apple ID password (to disable Activation Lock)</li>
                    <li>Tap "Erase" to confirm</li>
                </ol>
                <p>The phone will restart and show the "Hello" setup screen after a few minutes.</p>
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-header">
                <span class="guide-icon">💻</span>
                <h2>Step 3: iTunes Restore (Optional - More Secure)</h2>
            </div>
            <div class="guide-content">
                <ol>
                    <li>Connect iPhone to computer with iTunes installed</li>
                    <li>Open iTunes and select your device</li>
                    <li>Click <strong>"Restore iPhone"</strong></li>
                    <li>Click "Restore" again to confirm</li>
                    <li>iTunes will download iOS and reinstall, overwriting all data</li>
                </ol>
                <div class="tip-box">
                    <span class="tip-icon">💡</span>
                    <p>For maximum security, perform the iTunes restore 2-3 times.</p>
                </div>
            </div>
        </div>

        <div class="guide-card">
            <div class="guide-header">
                <span class="guide-icon">🔍</span>
                <h2>Step 4: Verification</h2>
            </div>
            <div class="guide-content">
                <p>Confirm your iPhone is clean:</p>
                <ol>
                    <li>Device should show the <strong>"Hello"</strong> setup screen in multiple languages</li>
                    <li>Activation Lock should be disabled (no Apple ID required)</li>
                    <li>Try setting up as new phone - no previous data should appear</li>
                </ol>
                <div class="success-box">
                    <span class="success-icon">✅</span>
                    <p><strong>Success!</strong> Your iPhone is now safe to sell.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Devices Guides -->
    <div id="other-guides" class="device-guides">
        <div class="guide-card">
            <div class="guide-header">
                <span class="guide-icon">📱</span>
                <h2>Other Devices (Windows, Blackberry, etc.)</h2>
            </div>
            <div class="guide-content">
                <p>For devices not running Android or iOS:</p>
                
                <h3>Windows Phone:</h3>
                <ol>
                    <li>Go to <strong>Settings → System → About</strong></li>
                    <li>Tap <strong>"Reset your phone"</strong></li>
                    <li>Follow on-screen instructions</li>
                </ol>

                <h3>Blackberry:</h3>
                <ol>
                    <li>Go to <strong>Settings → Security and Privacy</strong></li>
                    <li>Select <strong>"Security Wipe"</strong></li>
                    <li>Check what to wipe (recommend: all)</li>
                    <li>Type "blackberry" to confirm</li>
                </ol>

                <div class="info-box">
                    <p><strong>General Advice:</strong> Always check the manufacturer's website for specific secure erase tools for your device model.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Tool Promotion - FIXED: Both buttons now point to download-tool.php -->
    <div class="tool-promo-card">
        <div class="promo-content">
            <span class="promo-icon">💻</span>
            <h3>Want Automatic Wiping?</h3>
            <p>Our desktop tool connects directly to your phone and automates the entire process. No need to follow these steps manually!</p>
            <div class="promo-buttons">
                <a href="download-tool.php" class="btn btn-success">📥 Download Desktop Tool</a>
                <a href="download-tool.php" class="btn btn-outline-light">📖 How to Use</a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Tabs and Accordion -->
<script>
function showDevice(device, evt) {
    // Hide all guides
    document.querySelectorAll('.device-guides').forEach(el => {
        el.classList.remove('active');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(el => {
        el.classList.remove('active');
    });
    
    // Show selected device guides
    document.getElementById(device + '-guides').classList.add('active');
    
    // Add active class to clicked tab
    if(evt && evt.target) evt.target.classList.add('active');
    else { document.querySelectorAll('.tab-button').forEach(function(b,i){ if(['android','iphone','other'][i]===device) b.classList.add('active'); }); }
}

// Accordion functionality
document.querySelectorAll('.accordion-header').forEach(button => {
    button.addEventListener('click', () => {
        const accordionItem = button.parentElement;
        accordionItem.classList.toggle('active');
    });
});
</script>



<?php include 'includes/footer.php'; ?>