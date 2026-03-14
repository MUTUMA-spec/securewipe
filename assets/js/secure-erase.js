// Secure Erase Web Tool - JavaScript Controller
class SecureEraseController {
    constructor() {
        this.currentStep = 0;
        this.totalSteps = 4;
        this.deviceType = '';
        this.deviceModel = '';
        this.logId = null;
        
        this.steps = [
            { name: 'Encrypt Storage', completed: false },
            { name: 'Factory Reset', completed: false },
            { name: 'Overwrite Storage', completed: false },
            { name: 'Verification Scan', completed: false }
        ];
    }
    
    // Initialize the tool
    init() {
        this.bindEvents();
        this.loadDeviceOptions();
        console.log('Secure Erase Tool initialized');
    }
    
    // Set up event listeners
    bindEvents() {
        const startBtn = document.getElementById('startEraseBtn');
        if (startBtn) {
            startBtn.addEventListener('click', () => this.startProcess());
        }
        
        const deviceSelect = document.getElementById('deviceType');
        if (deviceSelect) {
            deviceSelect.addEventListener('change', (e) => this.onDeviceChange(e));
        }
        
        // Step confirmation buttons
        for (let i = 1; i <= 4; i++) {
            const btn = document.getElementById(`confirmStep${i}`);
            if (btn) {
                btn.addEventListener('click', () => this.completeStep(i));
            }
            
            const checkbox = document.getElementById(`step${i}Confirm`);
            if (checkbox) {
                checkbox.addEventListener('change', (e) => {
                    const btn = document.getElementById(`confirmStep${i}`);
                    if (btn) {
                        btn.disabled = !e.target.checked;
                    }
                });
            }
        }
    }
    
    // Handle device type change
    onDeviceChange(event) {
        this.deviceType = event.target.value;
        this.updateInstructions(this.deviceType);
    }
    
    // Update instructions based on device type
    updateInstructions(deviceType) {
        const instructionsDiv = document.getElementById('deviceInstructions');
        if (!instructionsDiv) return;
        
        let instructions = '';
        
        switch(deviceType) {
            case 'android':
                instructions = `
                    <div class="alert alert-info">
                        <h4>📱 Android Preparation:</h4>
                        <ul>
                            <li>Ensure your phone is charged above 50%</li>
                            <li>Back up important data to cloud/external storage</li>
                            <li>Remove SIM card and SD card</li>
                            <li>Disable screen lock (PIN/pattern) temporarily</li>
                        </ul>
                    </div>
                `;
                break;
            case 'iphone':
                instructions = `
                    <div class="alert alert-info">
                        <h4>📱 iPhone Preparation:</h4>
                        <ul>
                            <li>Sign out of iCloud and iTunes/App Store</li>
                            <li>Turn off Find My iPhone</li>
                            <li>Back up to iCloud or computer</li>
                            <li>Remove SIM card</li>
                        </ul>
                    </div>
                `;
                break;
            case 'other':
                instructions = `
                    <div class="alert alert-info">
                        <h4>📱 Other Devices:</h4>
                        <ul>
                            <li>Check manufacturer website for specific tools</li>
                            <li>Back up important data</li>
                            <li>Remove external storage (SD card)</li>
                            <li>Note your device model for specific instructions</li>
                        </ul>
                    </div>
                `;
                break;
            default:
                instructions = '';
        }
        
        instructionsDiv.innerHTML = instructions;
    }
    
    // Start the erase process
    async startProcess() {
        this.deviceType = document.getElementById('deviceType').value;
        this.deviceModel = document.getElementById('deviceModel').value;
        
        if (!this.deviceType) {
            alert('Please select your device type');
            return;
        }
        
        if (!this.deviceModel) {
            alert('Please enter your device model');
            return;
        }
        
        // Disable start button
        document.getElementById('startEraseBtn').disabled = true;
        
        // Log to database
        await this.logProcessStart();
        
        // Show progress container
        document.getElementById('progressContainer').style.display = 'block';
        
        // Start with step 1
        this.updateProgress(1);
        
        // Scroll to progress
        document.getElementById('progressContainer').scrollIntoView({ behavior: 'smooth' });
    }
    
    // Log process start to database
    async logProcessStart() {
        try {
            const response = await fetch('log_erase_start.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    device_type: this.deviceType,
                    device_model: this.deviceModel,
                    tool_type: 'web'
                })
            });
            
            const data = await response.json();
            if (data.success) {
                this.logId = data.log_id;
                console.log('Log created:', this.logId);
            }
        } catch (error) {
            console.error('Error logging process start:', error);
        }
    }
    
    // Update progress bar and step display
    updateProgress(step) {
        this.currentStep = step;
        const percentage = (step / this.totalSteps) * 100;
        
        // Update progress bar
        const progressBar = document.getElementById('progressBar');
        if (progressBar) {
            progressBar.style.width = percentage + '%';
            progressBar.textContent = Math.round(percentage) + '%';
        }
        
        // Update step indicators
        for (let i = 1; i <= this.totalSteps; i++) {
            const stepElement = document.getElementById(`step${i}`);
            const indicator = document.getElementById(`stepIndicator${i}`);
            
            if (i < step) {
                // Completed steps
                if (indicator) {
                    indicator.classList.remove('active');
                    indicator.classList.add('completed');
                }
                if (stepElement) stepElement.style.display = 'none';
            } else if (i === step) {
                // Current step
                if (indicator) {
                    indicator.classList.remove('completed');
                    indicator.classList.add('active');
                }
                if (stepElement) {
                    stepElement.style.display = 'block';
                    this.loadStepInstructions(i);
                }
            } else {
                // Future steps
                if (indicator) {
                    indicator.classList.remove('active', 'completed');
                }
                if (stepElement) stepElement.style.display = 'none';
            }
        }
        
        // Update status message
        const statusEl = document.getElementById('currentStepName');
        if (statusEl) {
            statusEl.textContent = this.steps[step-1].name;
        }
    }
    
    // Load step-specific instructions
    loadStepInstructions(step) {
        const instructionsMap = {
            1: {
                android: '<p><strong>🔐 Step 1: Encrypt Storage (Android)</strong></p><ol><li>Go to <strong>Settings → Security</strong></li><li>Look for <strong>"Encrypt phone"</strong> or <strong>"Encrypt device"</strong></li><li>Follow on-screen instructions (this may take an hour)</li><li>Keep phone plugged in during encryption</li></ol><p class="alert alert-warning">⚠️ Already encrypted? Most modern Androids are encrypted by default. Skip this step.</p>',
                iphone: '<p><strong>🔐 Step 1: Encryption Check (iPhone)</strong></p><ol><li>iPhone is <strong>automatically encrypted</strong> when you set a passcode</li><li>Go to <strong>Settings → Face ID & Passcode</strong></li><li>Ensure passcode is enabled</li><li>✅ Encryption is active - you can proceed</li></ol>',
                other: '<p><strong>🔐 Step 1: Encryption</strong></p><ol><li>Check your device settings for encryption options</li><li>Most modern devices have encryption built-in</li><li>If unsure, proceed to factory reset</li></ol>'
            },
            2: {
                android: '<p><strong>🔄 Step 2: Factory Reset (Android)</strong></p><ol><li>Go to <strong>Settings → System → Reset options</strong></li><li>Tap <strong>"Erase all data (factory reset)"</strong></li><li>Tap <strong>"Reset phone"</strong></li><li>Enter PIN/password if prompted</li><li>Tap <strong>"Erase everything"</strong></li></ol><p class="alert alert-danger">⚠️ This will delete ALL data. Make sure you backed up!</p>',
                iphone: '<p><strong>🔄 Step 2: Factory Reset (iPhone)</strong></p><ol><li>Go to <strong>Settings → General → Transfer or Reset iPhone</strong></li><li>Tap <strong>"Erase All Content and Settings"</strong></li><li>Enter your passcode</li><li>Enter Apple ID password (to disable Activation Lock)</li><li>Confirm erase</li></ol>',
                other: '<p><strong>🔄 Step 2: Factory Reset</strong></p><ol><li>Look in Settings for "Backup & Reset" or similar</li><li>Select "Factory data reset"</li><li>Confirm the reset</li><li>Wait for device to reboot</li></ol>'
            },
            3: {
                android: '<p><strong>✍️ Step 3: Overwrite Storage (Android)</strong></p><ol><li><strong>Option A:</strong> Use Samsung Secure Erase (Samsung devices)</li><li><strong>Option B:</strong> Download "iShredder" from Play Store</li><li><strong>Option C:</strong> After reset, fill phone with large files (movies) then reset again</li></ol><p class="alert alert-info">Multiple overwrites make data unrecoverable!</p>',
                iphone: '<p><strong>✍️ Step 3: Overwrite Storage (iPhone)</strong></p><ol><li><strong>Option A:</strong> Restore via iTunes/Finder (creates encrypted backup)</li><li><strong>Option B:</strong> Perform reset twice in a row</li><li><strong>Option C:</strong> Download secure erase apps from App Store</li></ol>',
                other: '<p><strong>✍️ Step 3: Overwrite Storage</strong></p><ol><li>Check manufacturer website for secure erase tools</li><li>Some devices have built-in secure erase options</li><li>Perform multiple reset cycles for better security</li></ol>'
            },
            4: {
                android: '<p><strong>🔍 Step 4: Verification (Android)</strong></p><ol><li>Device should show <strong>welcome/setup screen</strong></li><li>Try to reboot - should go to setup</li><li>No previous apps or data should appear</li><li>✅ If you see setup screen, wipe was successful!</li></ol>',
                iphone: '<p><strong>🔍 Step 4: Verification (iPhone)</strong></p><ol><li>Device should show <strong>"Hello"</strong> setup screen</li><li>Activation Lock should be disabled</li><li>No previous settings or apps remain</li><li>✅ Hello screen means device is clean!</li></ol>',
                other: '<p><strong>🔍 Step 4: Verification</strong></p><ol><li>Device should boot to first-time setup</li><li>No personal data should be accessible</li><li>Check storage - should show as empty/new</li><li>✅ If device is like new, wipe succeeded!</li></ol>'
            }
        };
        
        const instructionDiv = document.getElementById(`step${step}Instructions`);
        if (instructionDiv && instructionsMap[step] && instructionsMap[step][this.deviceType]) {
            instructionDiv.innerHTML = instructionsMap[step][this.deviceType];
        } else if (instructionDiv && instructionsMap[step]) {
            instructionDiv.innerHTML = instructionsMap[step]['other'];
        }
    }
    
    // Complete a step
    async completeStep(step) {
        // Mark step as completed
        this.steps[step-1].completed = true;
        
        // Update database
        await this.logStepCompletion(step);
        
        if (step < this.totalSteps) {
            // Move to next step
            this.updateProgress(step + 1);
        } else {
            // All steps completed
            this.completeProcess();
        }
    }
    
    // Log step completion to database
    async logStepCompletion(step) {
        if (!this.logId) return;
        
        try {
            await fetch('log_step_complete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    log_id: this.logId,
                    step: step
                })
            });
        } catch (error) {
            console.error('Error logging step completion:', error);
        }
    }
    
    // Complete the entire process
    async completeProcess() {
        // Update progress to 100%
        this.updateProgress(4);
        
        // Log completion
        try {
            await fetch('log_completion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    log_id: this.logId
                })
            });
        } catch (error) {
            console.error('Error logging completion:', error);
        }
        
        // Show success message
        const completionDiv = document.getElementById('completionMessage');
        if (completionDiv) {
            completionDiv.style.display = 'block';
            completionDiv.innerHTML = `
                <div class="alert alert-success">
                    <h3>✅ Your phone has been securely wiped!</h3>
                    <p>Safe to sell, donate, or dispose of your device.</p>
                    <p><strong>Reference ID:</strong> ${this.logId}</p>
                </div>
            `;
        }
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('secureEraseTool')) {
        const controller = new SecureEraseController();
        controller.init();
        window.eraseController = controller;
    }
});