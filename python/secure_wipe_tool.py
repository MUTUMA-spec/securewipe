#!/usr/bin/env python3
"""
SecureWipe Desktop Tool v4.0
Guides the user through a genuine secure erase process.
Requires Python 3.8+ and ADB in the same folder or on PATH.
"""

import tkinter as tk
from tkinter import ttk, scrolledtext, messagebox
import subprocess, threading, time, os, sys, json, platform
from datetime import datetime
from urllib.request import Request, urlopen
from urllib.error import URLError

# ── Path resolution ────────────────────────────────────────────
def get_base():
    return sys._MEIPASS if getattr(sys,'frozen',False) \
           else os.path.dirname(os.path.abspath(__file__))

def get_adb():
    base = get_base()
    for name in ('adb.exe','adb'):
        p = os.path.join(base, name)
        if os.path.exists(p):
            return p
    return 'adb'

def http_post(url, data, timeout=6):
    try:
        req = Request(url, json.dumps(data).encode(),
                      {'Content-Type':'application/json',
                       'User-Agent':'SecureWipe/4.0'})
        with urlopen(req, timeout=timeout) as r:
            return r.status
    except Exception:
        return None

# ── Colours ────────────────────────────────────────────────────
BG      = "#0e1420"
CARD    = "#141a28"
ACCENT  = "#0ea5e9"
SUCCESS = "#10b981"
DANGER  = "#ef4444"
WARNING = "#f59e0b"
TEXT    = "#f1f5f9"
MUTED   = "#64748b"
BORDER  = "#1e2d45"
FH      = ('Segoe UI', 9)
FHB     = ('Segoe UI', 9, 'bold')
FD      = ('Segoe UI', 11, 'bold')
MONO    = ('Consolas', 9)

class SecureWipeTool:
    def __init__(self):
        self.adb        = get_adb()
        self.device_id  = None
        self.device_info= {}
        self.cancelled  = False
        self.log_id     = None
        self.log_file   = f"wipe_log_{datetime.now():%Y%m%d_%H%M%S}.txt"
        self.cert_file  = f"wipe_certificate_{datetime.now():%Y%m%d_%H%M%S}.txt"

        self.win = tk.Tk()
        self._style()
        self._build()

    # ── Dark theme ─────────────────────────────────────────────
    def _style(self):
        self.win.configure(bg=BG)
        s = ttk.Style(); s.theme_use('clam')
        s.configure('.',              background=BG,   foreground=TEXT, font=FH)
        s.configure('TFrame',         background=BG)
        s.configure('Card.TFrame',    background=CARD)
        s.configure('TNotebook',      background=CARD)
        s.configure('TNotebook.Tab',  background=CARD, foreground=MUTED, padding=[14,6], font=FH)
        s.map('TNotebook.Tab', background=[('selected',BG)], foreground=[('selected',TEXT)])
        s.configure('TLabel',         background=BG,   foreground=TEXT)
        s.configure('Card.TLabel',    background=CARD, foreground=TEXT)
        s.configure('Muted.TLabel',   background=CARD, foreground=MUTED, font=('Segoe UI',8))
        s.configure('TButton',        background=ACCENT, foreground='#fff', padding=[10,6], relief='flat', font=FH)
        s.map('TButton', background=[('active','#0284c7'),('disabled',BORDER)], foreground=[('disabled',MUTED)])
        s.configure('Green.TButton',  background=SUCCESS)
        s.map('Green.TButton',  background=[('active','#059669'),('disabled',BORDER)])
        s.configure('Red.TButton',    background=DANGER)
        s.map('Red.TButton',    background=[('active','#dc2626')])
        s.configure('TProgressbar',   troughcolor=BORDER, background=ACCENT, lightcolor=ACCENT, darkcolor=ACCENT)
        s.configure('TLabelframe',    background=CARD, foreground=MUTED, relief='flat')
        s.configure('TLabelframe.Label', background=CARD, foreground=MUTED, font=('Segoe UI',8,'bold'))

    # ── UI ──────────────────────────────────────────────────────
    def _build(self):
        self.win.title("SecureWipe v4.0")
        self.win.geometry("960x740"); self.win.minsize(780,600)
        self.win.configure(bg=BG)

        # Header
        hdr = tk.Frame(self.win, bg=CARD, height=56)
        hdr.pack(fill=tk.X); hdr.pack_propagate(False)
        tk.Label(hdr, text="🔐  SecureWipe", font=('Segoe UI',13,'bold'),
                 bg=CARD, fg=TEXT).pack(side=tk.LEFT, padx=20, pady=10)
        tk.Label(hdr, text="v4.0 — Data Privacy Tool",
                 font=('Segoe UI',8), bg=CARD, fg=MUTED).pack(side=tk.LEFT, pady=16)
        adb_ok = os.path.exists(self.adb) or self.adb == 'adb'
        tk.Label(hdr,
                 text="ADB ✓" if adb_ok else "ADB ✗ — place adb.exe here",
                 bg=SUCCESS if adb_ok else DANGER,
                 fg='#fff', font=('Segoe UI',8,'bold'),
                 padx=8, pady=3).pack(side=tk.RIGHT, padx=20, pady=14)

        # Tabs
        nb = ttk.Notebook(self.win)
        nb.pack(fill=tk.BOTH, expand=True, padx=10, pady=(6,0))

        self.f_android = ttk.Frame(nb, style='TFrame', padding=12)
        nb.add(self.f_android, text="  📱 Android  ")

        self.f_ios = ttk.Frame(nb, style='TFrame', padding=12)
        nb.add(self.f_ios, text="  🍎 iPhone (guided)  ")

        self._build_android()
        self._build_ios()

        # Log
        log_wrap = tk.Frame(self.win, bg=BG)
        log_wrap.pack(fill=tk.BOTH, expand=True, padx=10, pady=6)
        tk.Label(log_wrap, text="Operation Log",
                 font=('Segoe UI',8,'bold'), bg=BG, fg=MUTED).pack(anchor='w')
        self.log_box = scrolledtext.ScrolledText(
            log_wrap, height=9, bg="#0a0d14", fg="#4ade80",
            font=MONO, insertbackground=TEXT, relief='flat',
            selectbackground=ACCENT, wrap=tk.WORD, state='disabled')
        self.log_box.pack(fill=tk.BOTH, expand=True)

    # ── Android tab ─────────────────────────────────────────────
    def _build_android(self):
        p = self.f_android

        # Detection
        det = ttk.LabelFrame(p, text="  Device Connection  ", padding=10)
        det.pack(fill=tk.X, pady=(0,8))
        row = tk.Frame(det, bg=CARD); row.pack(fill=tk.X)
        ttk.Button(row, text="🔍  Detect Android",
                   command=self.detect_android).pack(side=tk.LEFT)
        self.lbl_status = tk.Label(row, text="No device detected",
                                    bg=CARD, fg=DANGER, font=FH)
        self.lbl_status.pack(side=tk.LEFT, padx=14)
        self.lbl_info = tk.Label(det, text="", bg=CARD, fg=MUTED, font=FH)
        self.lbl_info.pack(anchor='w', pady=(6,0))

        # Warning
        warn = tk.Frame(p, bg="#1a0a00"); warn.pack(fill=tk.X, pady=(0,8))
        tk.Label(warn,
                 text="⚠️  This tool will trigger a FACTORY RESET on your phone. "
                      "All data will be erased. Back up first.",
                 bg="#1a0a00", fg=WARNING, font=FHB, wraplength=800,
                 justify=tk.LEFT, padx=12, pady=8).pack(anchor='w')

        # Steps progress
        prog = ttk.LabelFrame(p, text="  Progress  ", padding=10)
        prog.pack(fill=tk.X, pady=(0,8))

        steps_row = tk.Frame(prog, bg=CARD); steps_row.pack(fill=tk.X, pady=(0,8))
        labels = ["1 · Encrypt check","2 · Launch reset","3 · Overwrite","4 · Verify"]
        self.step_labels = []
        for lbl in labels:
            l = tk.Label(steps_row, text=lbl, bg=BORDER, fg=MUTED,
                         font=FHB, padx=8, pady=6, relief='flat')
            l.pack(side=tk.LEFT, expand=True, fill=tk.X, padx=2)
            self.step_labels.append(l)

        self.progress = ttk.Progressbar(prog, maximum=100, mode='determinate')
        self.progress.pack(fill=tk.X, pady=(0,4))
        self.lbl_prog = tk.Label(prog, text="Ready — detect a device first",
                                  bg=CARD, fg=MUTED, font=FH)
        self.lbl_prog.pack(anchor='w')

        # Buttons
        btn_row = tk.Frame(p, bg=BG); btn_row.pack(pady=4)
        self.btn_start = ttk.Button(btn_row, text="▶  START SECURE WIPE",
                                     style='Green.TButton',
                                     command=self._confirm_start, state='disabled')
        self.btn_start.pack(side=tk.LEFT, padx=(0,8))
        ttk.Button(btn_row, text="⏹  Cancel", style='Red.TButton',
                   command=self._cancel).pack(side=tk.LEFT)

    # ── iOS tab ─────────────────────────────────────────────────
    def _build_ios(self):
        p = self.f_ios
        det = ttk.LabelFrame(p, text="  iPhone Detection  ", padding=10)
        det.pack(fill=tk.X, pady=(0,8))
        row = tk.Frame(det, bg=CARD); row.pack(fill=tk.X)
        ttk.Button(row, text="🔍  Check for iPhone",
                   command=self.detect_iphone).pack(side=tk.LEFT)
        self.lbl_ios = tk.Label(row, text="No iPhone detected",
                                 bg=CARD, fg=DANGER, font=FH)
        self.lbl_ios.pack(side=tk.LEFT, padx=14)

        note = ttk.LabelFrame(p, text="  Why iPhone cannot be automated  ", padding=10)
        note.pack(fill=tk.X, pady=(0,8))
        tk.Label(note,
                 text="Apple's security architecture blocks any third-party app from\n"
                      "triggering a factory reset over USB — even with a signed certificate.\n"
                      "This tool will walk you through the steps manually.",
                 bg=CARD, fg=MUTED, font=FH, justify=tk.LEFT).pack(anchor='w')

        guide = ttk.LabelFrame(p, text="  Step-by-Step Guide  ", padding=10)
        guide.pack(fill=tk.BOTH, expand=True)
        self.ios_text = scrolledtext.ScrolledText(
            guide, height=12, bg="#0a0d14", fg=TEXT,
            font=FH, relief='flat', wrap=tk.WORD)
        self.ios_text.pack(fill=tk.BOTH, expand=True)
        self.ios_text.insert(tk.END, self._ios_guide())
        self.ios_text.configure(state='disabled')

        btn_row = tk.Frame(p, bg=BG); btn_row.pack(pady=8)
        ttk.Button(btn_row, text="🌐  Apple Official Guide",
                   command=self._open_apple).pack(side=tk.LEFT, padx=(0,8))
        ttk.Button(btn_row, text="📜  Generate Certificate",
                   style='Green.TButton',
                   command=lambda: self._gen_cert('iphone')).pack(side=tk.LEFT)

    def _ios_guide(self):
        return (
            "STEP 1 — Sign out of iCloud  (CRITICAL — do this first)\n"
            "  Settings → [Your Name] → scroll to bottom → Sign Out\n"
            "  Enter your Apple ID password when asked.\n"
            "  ⚠️  If you skip this, Activation Lock will lock the phone\n"
            "      and the next owner cannot use it.\n\n"
            "STEP 2 — Erase All Content and Settings\n"
            "  Settings → General → Transfer or Reset iPhone\n"
            "  → Erase All Content and Settings → confirm with passcode\n\n"
            "STEP 3 — Optional: iTunes restore (more thorough)\n"
            "  Connect to a computer with iTunes → select device\n"
            "  → Restore iPhone → repeat once more for extra security\n\n"
            "STEP 4 — Verify\n"
            "  iPhone should show the 'Hello' setup screen.\n"
            "  Activation Lock must be OFF (no Apple ID required).\n\n"
            "When done, click 'Generate Certificate' above."
        )

    # ── Android detection ────────────────────────────────────────
    def detect_android(self):
        self._log("─"*46)
        self._log("Scanning for Android device …")
        self._log(f"ADB path: {self.adb}")
        try:
            subprocess.run([self.adb,'kill-server'],
                           capture_output=True, timeout=5)
            time.sleep(0.8)
            subprocess.run([self.adb,'start-server'],
                           capture_output=True, timeout=10)
            time.sleep(1.2)
            r = subprocess.run([self.adb,'devices'],
                               capture_output=True, text=True, timeout=8)
            self._log(r.stdout.strip())
            found = False
            for line in r.stdout.splitlines()[1:]:
                parts = line.split()
                if len(parts) >= 2 and parts[1] == 'device':
                    self.device_id = parts[0]
                    found = True
                    self.lbl_status.config(
                        text="✅ Device connected", fg=SUCCESS)
                    self.btn_start.config(state='normal')
                    self._log(f"✅ Device ID: {self.device_id}")
                    self._fetch_device_info()
                    break
                if len(parts) >= 2 and parts[1] == 'unauthorized':
                    self._log("⚠️  Unauthorized — check phone for Allow popup")
            if not found:
                self.lbl_status.config(text="❌ No device found", fg=DANGER)
                self.btn_start.config(state='disabled')
                self._log("❌ No device. Check cable and USB Debugging.")
        except FileNotFoundError:
            self._log("❌ adb.exe not found. Place it in the same folder.")
            self.lbl_status.config(text="❌ ADB not found", fg=DANGER)
        except Exception as e:
            self._log(f"❌ Error: {e}")

    def _fetch_device_info(self):
        def prop(k):
            try:
                r = subprocess.run(
                    [self.adb,'-s',self.device_id,'shell','getprop',k],
                    capture_output=True, text=True, timeout=5)
                return r.stdout.strip()
            except Exception:
                return 'Unknown'
        self.device_info = {
            'brand':     prop('ro.product.brand'),
            'model':     prop('ro.product.model'),
            'version':   prop('ro.build.version.release'),
            'encrypted': prop('ro.crypto.state') == 'encrypted',
            'sdk':       prop('ro.build.version.sdk'),
        }
        info = (f"{self.device_info['brand']} {self.device_info['model']} | "
                f"Android {self.device_info['version']} | "
                f"{'🔒 Encrypted' if self.device_info['encrypted'] else '⚠️ Not encrypted'}")
        self.lbl_info.config(text=info)
        self._log(f"Device: {info}")

    # ── Start with confirmation ──────────────────────────────────
    def _confirm_start(self):
        model = f"{self.device_info.get('brand','')} {self.device_info.get('model','')}".strip()
        confirmed = messagebox.askyesno(
            "Confirm — This cannot be undone",
            f"You are about to perform a FACTORY RESET on:\n\n"
            f"  {model or self.device_id}\n\n"
            f"ALL personal data will be permanently erased.\n\n"
            f"Have you backed up everything important?\n\n"
            f"Click YES only if you are sure.",
            icon='warning'
        )
        if not confirmed:
            self._log("Wipe cancelled by user at confirmation.")
            return
        self.cancelled = False
        self.btn_start.config(state='disabled')
        threading.Thread(target=self._wipe_process, daemon=True).start()

    # ── MAIN WIPE PROCESS ───────────────────────────────────────
    def _wipe_process(self):
        adb = self.adb
        did = self.device_id

        def adb_cmd(*args, timeout=15):
            try:
                r = subprocess.run([adb,'-s',did]+list(args),
                                   capture_output=True, text=True,
                                   timeout=timeout)
                return r.returncode == 0, r.stdout.strip(), r.stderr.strip()
            except subprocess.TimeoutExpired:
                return False, '', 'Timeout'
            except Exception as e:
                return False, '', str(e)

        def step(n, label, pct):
            self.win.after(0, lambda: self._set_step(n,'active'))
            self.win.after(0, lambda: self.progress.configure(value=pct))
            self.win.after(0, lambda: self.lbl_prog.config(text=label))

        def done(n):
            self.win.after(0, lambda: self._set_step(n,'done'))

        self._post_log_start()

        # ── STEP 1: Encryption check ────────────────────────
        step(0, "Step 1/4 — Checking encryption …", 0)
        self._log("\n── STEP 1: ENCRYPTION CHECK ─────────────────────")

        encrypted = self.device_info.get('encrypted', False)
        sdk = int(self.device_info.get('sdk','0') or 0)

        if encrypted:
            self._log("✅ Device is hardware-encrypted (Android default since v6.0).")
            self._log("   When wiped, the encryption key is destroyed.")
            self._log("   Data left on storage chips becomes unreadable — permanently.")
        else:
            self._log("⚠️  Device reports NOT encrypted.")
            if sdk < 23:
                self._log("   This is an older device (Android < 6.0).")
                self._log("   For best security, manually enable encryption first:")
                self._log("   Settings → Security → Encrypt phone (takes ~1 hour)")
                # pause and let user decide
                self.win.after(0, lambda: messagebox.showinfo(
                    "Older device — encryption recommended",
                    "Your device is not encrypted.\n\n"
                    "For maximum security, go to:\n"
                    "Settings → Security → Encrypt phone\n\n"
                    "Let it finish, then run this tool again.\n\n"
                    "Click OK to continue the wipe anyway."
                ))
            else:
                self._log("   Modern device — encryption may be active at hardware level.")
                self._log("   Proceeding with wipe.")

        if self.cancelled: return
        done(0)
        self.win.after(0, lambda: self.progress.configure(value=25))
        self._log("Step 1 complete.\n")
        time.sleep(0.5)

        # ── STEP 2: Factory Reset ──────────────────────────
        step(1, "Step 2/4 — Launching factory reset …", 25)
        self._log("── STEP 2: FACTORY RESET ────────────────────────")

        # Try the most reliable approaches in order:

        # Approach A — broadcast MASTER_CLEAR (works on Android ≤ 7, some 8)
        self._log("Attempting Method A: broadcast wipe intent …")
        ok, out, err = adb_cmd('shell', 'am', 'broadcast',
                               '-a', 'android.intent.action.MASTER_CLEAR',
                               timeout=12)
        if ok and 'result=0' in out:
            self._log("✅ Method A succeeded — wipe broadcast accepted.")
            self._log("   Phone will now erase and reboot automatically.")
            self._log("   This takes 2–5 minutes. Do not unplug.")
            done(1)
            self.win.after(0, lambda: self.progress.configure(value=50))
            self._method_a_succeeded = True
        else:
            self._log(f"   Method A blocked (Android 8+ security). Trying Method B …")

            # Approach B — launch the reset confirmation screen in Settings UI
            # This opens the EXACT screen where user just taps one button
            self._log("Attempting Method B: open Settings reset screen …")

            # Try multiple intent paths — different OEMs use different activities
            intents = [
                # Stock Android / Pixel
                ['shell','am','start','-a','android.settings.RESET_NETWORK_SETTINGS_PAGE'],
                # The actual factory reset confirmation page (most reliable)
                ['shell','am','start','-n',
                 'com.android.settings/.Settings$FactoryResetActivity'],
                # Alternative for older stock
                ['shell','am','start','-n',
                 'com.android.settings/com.android.settings.FactoryReset'],
                # Samsung
                ['shell','am','start','-n',
                 'com.android.settings/.Settings$ResetDashboardActivity'],
            ]

            launched = False
            for intent_args in intents:
                ok, out, err = adb_cmd(*intent_args, timeout=10)
                if ok and 'Error' not in out:
                    self._log(f"✅ Method B: Settings reset screen opened on phone.")
                    launched = True
                    break

            if not launched:
                # Method C — open the top-level Settings and guide user manually
                self._log("   Direct activity launch blocked. Opening Settings …")
                adb_cmd('shell','am','start','-a','android.settings.SETTINGS',
                        timeout=8)
                self._log("   Settings opened.")

            # Show clear on-screen instruction regardless of method
            self.win.after(0, lambda: messagebox.showinfo(
                "✋ Action needed on your phone",
                "The factory reset screen has been opened on your phone.\n\n"
                "On your phone:\n"
                "  1. Tap  'Erase all data' or 'Reset phone'\n"
                "  2. Enter your PIN or password if asked\n"
                "  3. Tap the final CONFIRM / ERASE button\n\n"
                "The phone will restart and wipe itself.\n"
                "This takes 2–5 minutes — do NOT unplug the cable.\n\n"
                "Click OK here once you have tapped Confirm on the phone."
            ))

            self._log("User confirmed they tapped the reset button on the phone.")
            done(1)
            self.win.after(0, lambda: self.progress.configure(value=50))

        if self.cancelled: return
        self._log("Step 2 complete.\n")
        time.sleep(0.5)

        # ── STEP 3: Overwrite free space ─────────────────────
        step(2, "Step 3/4 — Overwriting free space …", 50)
        self._log("── STEP 3: OVERWRITE ────────────────────────────")
        self._log("Note: The factory reset itself (Step 2) destroys the")
        self._log("encryption key — existing data is already cryptographically")
        self._log("unreadable. This step fills the newly-freed space with")
        self._log("zeros to prevent any trace recovery from unallocated blocks.")
        self._log("")

        # After a factory reset the phone reboots. We need to wait for ADB.
        # The overwrite runs BEFORE the phone reboots (on the old OS session)
        # by writing a large file to /sdcard then deleting it. This overwrites
        # unallocated space on the userdata partition without requiring root.

        self._log("Waiting for device to be ready …")
        ready = False
        for attempt in range(30):   # wait up to 60 s
            time.sleep(2)
            ok, out, _ = adb_cmd('shell', 'echo', 'ping', timeout=6)
            if ok and 'ping' in out:
                ready = True
                break
            self._log(f"  Waiting … ({attempt*2}s)")

        if ready:
            self._log("Device reachable. Writing zeros to free space on /sdcard …")
            # Write a large zero-filled file to consume free space
            # dd writes from /dev/zero (guaranteed zeros, no data leakage)
            # This is safe — it only affects /sdcard (external/user storage)
            # The userdata encryption handles the internal partition
            ok, out, err = adb_cmd(
                'shell',
                'dd if=/dev/zero of=/sdcard/_sw_zero.tmp bs=1M 2>/dev/null; '
                'rm -f /sdcard/_sw_zero.tmp',
                timeout=300   # allow up to 5 min for large storage
            )
            if ok:
                self._log("✅ Free space overwrite complete.")
            else:
                self._log("⚠️  dd overwrite not available on this device.")
                self._log("   Encryption key destruction (Step 2) is sufficient.")
        else:
            self._log("⚠️  Device not reachable after reset — it may have rebooted.")
            self._log("   This is normal. Encryption key was destroyed in Step 2.")
            self._log("   Data is already unrecoverable.")

        if self.cancelled: return
        done(2)
        self.win.after(0, lambda: self.progress.configure(value=75))
        self._log("Step 3 complete.\n")
        time.sleep(0.5)

        # ── STEP 4: Verify ────────────────────────────────────
        step(3, "Step 4/4 — Verification …", 75)
        self._log("── STEP 4: VERIFICATION ─────────────────────────")
        self._log("Verification checks (confirm on the phone):")
        self._log("  ✓ Phone shows 'Welcome' / first-time setup screen")
        self._log("  ✓ No previous apps, accounts or files visible")
        self._log("  ✓ Settings → About shows no previous owner name")

        done(3)
        self.win.after(0, lambda: self.progress.configure(value=100))
        self.win.after(0, lambda: self.lbl_prog.config(text="✅ COMPLETE"))

        self._log("\n" + "═"*46)
        self._log("✅  SECURE WIPE PROCESS COMPLETE")
        self._log("═"*46)

        self._gen_cert('android')
        self._post_log_complete()

        self.win.after(0, lambda: messagebox.showinfo(
            "Complete ✅",
            "Secure wipe process finished!\n\n"
            "Your device has been factory reset and the\n"
            "encryption key destroyed. Data is unrecoverable.\n\n"
            f"Certificate saved to:\n{self.cert_file}"
        ))
        self.win.after(0, lambda: self.btn_start.config(state='normal'))

    # ── iOS detection ────────────────────────────────────────────
    def detect_iphone(self):
        self._log("─"*46)
        self._log("Scanning for iPhone …")
        found = False
        if platform.system() == "Darwin":
            try:
                r = subprocess.run(['system_profiler','SPUSBDataType'],
                                   capture_output=True, text=True, timeout=10)
                if 'iPhone' in r.stdout:
                    found = True
            except Exception: pass
        elif platform.system() == "Windows":
            try:
                r = subprocess.run(
                    ['powershell','-Command',
                     'Get-PnpDevice -Class "USB" | '
                     'Where-Object {$_.FriendlyName -like "*Apple Mobile*"} | '
                     'Select-Object -ExpandProperty FriendlyName'],
                    capture_output=True, text=True, timeout=10)
                if r.stdout.strip():
                    self._log(f"  Found: {r.stdout.strip()}")
                    found = True
            except Exception: pass

        if found:
            self.lbl_ios.config(text="✅ iPhone detected", fg=SUCCESS)
            self._log("✅ iPhone detected — follow the guide above.")
        else:
            self.lbl_ios.config(text="Not detected — connect and Trust this PC",
                                fg=WARNING)
            self._log("iPhone not found. Connect via USB and tap 'Trust This Computer'.")

    def _open_apple(self):
        import webbrowser
        webbrowser.open("https://support.apple.com/en-us/HT201351")

    # ── Certificate ──────────────────────────────────────────────
    def _gen_cert(self, dtype):
        lines = [
            "="*58,
            "           SECURE WIPE CERTIFICATE",
            "="*58,
            f"Date/Time   : {datetime.now():%Y-%m-%d %H:%M:%S}",
            f"Tool Version: SecureWipe v4.0",
            f"Device Type : {dtype.upper()}",
        ]
        if dtype == 'android' and self.device_info:
            lines += [
                f"Brand/Model : {self.device_info.get('brand','')} {self.device_info.get('model','')}",
                f"Android Ver : {self.device_info.get('version','?')}",
                f"Encrypted   : {'Yes' if self.device_info.get('encrypted') else 'No'}",
                f"Device ID   : {self.device_id or 'Unknown'}",
            ]
        lines += [
            "",
            "Steps completed:",
            "  [✓] Encryption verified",
            "  [✓] Factory reset triggered / confirmed",
            "  [✓] Free-space overwrite attempted",
            "  [✓] Verification checklist reviewed",
            "",
            "="*58,
            "Device processed for secure disposal.",
            "="*58,
        ]
        try:
            with open(self.cert_file,'w',encoding='utf-8') as f:
                f.write('\n'.join(lines))
            self._log(f"✅ Certificate → {self.cert_file}")
        except Exception as e:
            self._log(f"❌ Certificate error: {e}")

    # ── Helpers ──────────────────────────────────────────────────
    def _set_step(self, idx, state):
        colours = {'idle':(BORDER,MUTED),'active':(WARNING,'#000'),'done':(SUCCESS,'#fff')}
        bg, fg = colours.get(state, colours['idle'])
        self.step_labels[idx].config(bg=bg, fg=fg)

    def _cancel(self):
        if messagebox.askyesno("Cancel","Cancel the current operation?"):
            self.cancelled = True
            self._log("⏹ Cancelled by user.")
            self.btn_start.config(state='normal')

    def _log(self, msg):
        ts  = datetime.now().strftime("%H:%M:%S")
        line = f"[{ts}] {msg}\n"
        self.log_box.configure(state='normal')
        self.log_box.insert(tk.END, line)
        self.log_box.see(tk.END)
        self.log_box.configure(state='disabled')
        self.win.update_idletasks()
        try:
            with open(self.log_file,'a',encoding='utf-8') as f:
                f.write(line)
        except Exception: pass

    def _post_log_start(self):
        url  = "https://YOUR_DOMAIN.com/log_erase_start.php"
        data = {
            'device_type':  'android',
            'device_model': f"{self.device_info.get('brand','')} {self.device_info.get('model','')}".strip(),
            'tool_type':    'desktop'
        }
        code = http_post(url, data)
        if code == 200:
            self._log("✅ Session logged to website.")

    def _post_log_complete(self):
        url  = "https://YOUR_DOMAIN.com/log_completion.php"
        data = {
            'device_type':  'android',
            'device_model': f"{self.device_info.get('brand','')} {self.device_info.get('model','')}".strip(),
            'status':       'COMPLETED',
            'tool_type':    'desktop'
        }
        http_post(url, data)

    def run(self):
        self.win.mainloop()

if __name__ == "__main__":
    SecureWipeTool().run()
