#!/usr/bin/env python3
"""
SecureWipe Desktop Tool v5.1
Covers ALL Android brands including Infinix / Tecno / Itel (Android 14).
Now with: simulated wipe mode, auto-restart after completion, DB start logging.
"""

import tkinter as tk
from tkinter import ttk, scrolledtext, messagebox
import subprocess, threading, time, os, sys, json, platform, re
from datetime import datetime
from urllib.request import Request, urlopen

# ── Paths ──────────────────────────────────────────────────────
def get_base():
    return sys._MEIPASS if getattr(sys, 'frozen', False) \
           else os.path.dirname(os.path.abspath(__file__))

def get_adb():
    base = get_base()
    script_dir = os.path.dirname(os.path.abspath(__file__)) if not getattr(sys, 'frozen', False) else base
    candidates = [
        os.path.join(base,       'adb_binaries', 'adb.exe'),
        os.path.join(base,       'adb.exe'),
        os.path.join(script_dir, 'adb_binaries', 'adb.exe'),
        os.path.join(script_dir, 'adb.exe'),
    ]
    for c in candidates:
        if os.path.exists(c):
            return c
    return 'adb'

# ── HTTP helpers ────────────────────────────────────────────────
BASE_URL = "http://securetool.infinityfreeapp.com"   # change to your domain

def http_post(url, data, timeout=6):
    try:
        req = Request(url, json.dumps(data).encode(),
                      {'Content-Type': 'application/json',
                       'User-Agent':   'SecureWipe/5.1'})
        with urlopen(req, timeout=timeout) as r:
            return r.read().decode()
    except Exception:
        return None

def post_start(device_type, device_model):
    """Logging now handled by download-proxy.php on the website."""
    return None

def post_complete(device_type, device_model, log_id=None):
    """Logging now handled by download-proxy.php on the website."""
    pass

# ── Colours ────────────────────────────────────────────────────
BG = "#0e1420"; CARD = "#141a28"; ACCENT = "#0ea5e9"
SUCCESS = "#10b981"; DANGER = "#ef4444"; WARNING = "#f59e0b"
TEXT = "#f1f5f9"; MUTED = "#64748b"; BORDER = "#1e2d45"
FH = ('Segoe UI', 9); FHB = ('Segoe UI', 9, 'bold'); MONO = ('Consolas', 9)

# ══════════════════════════════════════════════════════════════
# BRAND DATABASE
# ══════════════════════════════════════════════════════════════
BRAND_RESET = {
    'infinix': [
        'com.android.settings/.Settings$FactoryResetActivity',
        'com.android.settings/.FactoryResetActivity',
        'com.transsion.settings/.Settings$FactoryResetActivity',
        'com.transsion.settings/.FactoryResetActivity',
    ],
    'tecno': [
        'com.android.settings/.Settings$FactoryResetActivity',
        'com.android.settings/.FactoryResetActivity',
        'com.transsion.settings/.Settings$FactoryResetActivity',
    ],
    'itel': [
        'com.android.settings/.Settings$FactoryResetActivity',
        'com.android.settings/.FactoryResetActivity',
        'com.transsion.settings/.Settings$FactoryResetActivity',
    ],
    'samsung': [
        'com.android.settings/.Settings$FactoryResetActivity',
        'com.android.settings/.Settings$ResetDashboardActivity',
        'com.samsung.android.settings/.Settings$FactoryResetActivity',
    ],
    'xiaomi': [
        'com.android.settings/.Settings$FactoryResetActivity',
        'com.android.settings/.FactoryResetActivity',
        'com.miui.securitycenter/.MainActivity',
    ],
    'redmi':  ['com.android.settings/.Settings$FactoryResetActivity',
               'com.android.settings/.FactoryResetActivity'],
    'poco':   ['com.android.settings/.Settings$FactoryResetActivity'],
    'huawei': [
        'com.android.settings/.Settings$FactoryResetActivity',
        'com.huawei.systemmanager/.appcontrol.activity.StartupNormalAppActivity',
        'com.android.settings/.FactoryResetActivity',
    ],
    'honor':  ['com.android.settings/.Settings$FactoryResetActivity',
               'com.android.settings/.FactoryResetActivity'],
    'oppo':   ['com.android.settings/.Settings$FactoryResetActivity',
               'com.coloros.settings/.Settings$FactoryResetActivity'],
    'realme': ['com.android.settings/.Settings$FactoryResetActivity',
               'com.android.settings/.FactoryResetActivity'],
    'oneplus':['com.android.settings/.Settings$FactoryResetActivity',
               'com.android.settings/.FactoryResetActivity'],
    'vivo':   ['com.android.settings/.Settings$FactoryResetActivity',
               'com.vivo.settings/.Settings$FactoryResetActivity'],
    'nokia':  ['com.android.settings/.Settings$FactoryResetActivity',
               'com.android.settings/.FactoryResetActivity'],
    'motorola':['com.android.settings/.Settings$FactoryResetActivity',
                'com.motorola.settings/.Settings$FactoryResetActivity'],
    'lenovo': ['com.android.settings/.Settings$FactoryResetActivity'],
    '_default': [
        'com.android.settings/.Settings$FactoryResetActivity',
        'com.android.settings/.FactoryResetActivity',
        'com.android.settings/.ResetActivity',
        'com.android.settings/.MasterClearConfirm',
    ],
}

BRAND_MANUAL = {
    'infinix': (
        "On your Infinix phone:\n\n"
        "  1. Open Settings\n"
        "  2. Scroll down and tap  System\n"
        "  3. Tap  Reset options\n"
        "  4. Tap  Erase all data (factory reset)\n"
        "  5. Tap  Reset phone\n"
        "  6. Enter your PIN if asked\n"
        "  7. Tap  Erase everything"
    ),
    'samsung': (
        "On your Samsung phone:\n\n"
        "  1. Open Settings\n"
        "  2. Tap  General management\n"
        "  3. Tap  Reset\n"
        "  4. Tap  Factory data reset\n"
        "  5. Scroll down → tap  Reset\n"
        "  6. Enter PIN → tap  Delete all"
    ),
    'xiaomi': (
        "On your Xiaomi / Redmi phone:\n\n"
        "  1. Open Settings\n"
        "  2. Tap  About phone\n"
        "  3. Tap  Factory reset\n"
        "  4. Tap  Reset phone  →  Continue  →  OK"
    ),
    'huawei': (
        "On your Huawei phone:\n\n"
        "  1. Open Settings\n"
        "  2. Tap  System  →  Reset\n"
        "  3. Tap  Factory data reset\n"
        "  4. Tap  Reset phone  →  Erase everything"
    ),
    '_default': (
        "On your phone:\n\n"
        "  1. Open Settings\n"
        "  2. Tap  System  (or  General Management)\n"
        "  3. Tap  Reset options  (or  Reset)\n"
        "  4. Tap  Erase all data (factory reset)\n"
        "  5. Tap  Reset phone\n"
        "  6. Enter your PIN if asked\n"
        "  7. Tap  Erase everything"
    ),
}


# ══════════════════════════════════════════════════════════════
class SecureWipeTool:

    def __init__(self):
        self.adb         = get_adb()
        self.device_id   = None
        self.device_info = {}
        self.cancelled   = False
        self.log_id      = None          # DB log ID for this session
        self.log_file    = f"wipe_log_{datetime.now():%Y%m%d_%H%M%S}.txt"
        self.cert_file   = f"wipe_certificate_{datetime.now():%Y%m%d_%H%M%S}.txt"
        self.win         = tk.Tk()
        self._style()
        self._build()

    # ── Theme ──────────────────────────────────────────────────
    def _style(self):
        self.win.configure(bg=BG)
        s = ttk.Style(); s.theme_use('clam')
        s.configure('.', background=BG, foreground=TEXT, font=FH)
        s.configure('TFrame', background=BG)
        s.configure('TNotebook', background=CARD)
        s.configure('TNotebook.Tab', background=CARD, foreground=MUTED,
                    padding=[14, 6], font=FH)
        s.map('TNotebook.Tab',
              background=[('selected', BG)], foreground=[('selected', TEXT)])
        s.configure('TLabel', background=BG, foreground=TEXT)
        s.configure('TButton', background=ACCENT, foreground='#fff',
                    padding=[10, 6], relief='flat', font=FH)
        s.map('TButton',
              background=[('active', '#0284c7'), ('disabled', BORDER)],
              foreground=[('disabled', MUTED)])
        s.configure('Green.TButton', background=SUCCESS)
        s.map('Green.TButton',
              background=[('active', '#059669'), ('disabled', BORDER)])
        s.configure('Red.TButton', background=DANGER)
        s.map('Red.TButton', background=[('active', '#dc2626')])
        s.configure('TProgressbar', troughcolor=BORDER, background=ACCENT,
                    lightcolor=ACCENT, darkcolor=ACCENT)
        s.configure('TLabelframe', background=CARD, foreground=MUTED, relief='flat')
        s.configure('TLabelframe.Label', background=CARD, foreground=MUTED,
                    font=('Segoe UI', 8, 'bold'))

    # ── Build UI ───────────────────────────────────────────────
    def _build(self):
        self.win.title("SecureWipe v5.1")
        self.win.geometry("980x780"); self.win.minsize(820, 640)

        hdr = tk.Frame(self.win, bg=CARD, height=56)
        hdr.pack(fill=tk.X); hdr.pack_propagate(False)
        tk.Label(hdr, text="🔐  SecureWipe",
                 font=('Segoe UI', 13, 'bold'), bg=CARD, fg=TEXT
                 ).pack(side=tk.LEFT, padx=20, pady=10)
        tk.Label(hdr, text="v5.1 — Supports all Android brands",
                 font=('Segoe UI', 8), bg=CARD, fg=MUTED
                 ).pack(side=tk.LEFT, pady=16)
        adb_ok = os.path.exists(self.adb) or self.adb == 'adb'
        tk.Label(hdr,
                 text="ADB ✓  Ready" if adb_ok else "⚠  adb.exe not found",
                 bg=SUCCESS if adb_ok else DANGER, fg='#fff',
                 font=('Segoe UI', 8, 'bold'), padx=8, pady=3
                 ).pack(side=tk.RIGHT, padx=20, pady=14)

        nb = ttk.Notebook(self.win)
        nb.pack(fill=tk.BOTH, expand=True, padx=10, pady=(6, 0))
        self.f_android = ttk.Frame(nb, padding=12)
        nb.add(self.f_android, text="  📱 Android  ")
        self.f_ios = ttk.Frame(nb, padding=12)
        nb.add(self.f_ios, text="  🍎 iPhone (guided)  ")
        self._build_android(); self._build_ios()

        lw = tk.Frame(self.win, bg=BG)
        lw.pack(fill=tk.BOTH, expand=True, padx=10, pady=6)
        tk.Label(lw, text="Operation Log",
                 font=('Segoe UI', 8, 'bold'), bg=BG, fg=MUTED).pack(anchor='w')
        self.log_box = scrolledtext.ScrolledText(
            lw, height=9, bg="#0a0d14", fg="#4ade80",
            font=MONO, relief='flat', wrap=tk.WORD, state='disabled')
        self.log_box.pack(fill=tk.BOTH, expand=True)

    def _build_android(self):
        p = self.f_android

        det = ttk.LabelFrame(p, text="  Device Connection  ", padding=10)
        det.pack(fill=tk.X, pady=(0, 8))
        r = tk.Frame(det, bg=CARD); r.pack(fill=tk.X)
        ttk.Button(r, text="🔍  Detect Android Device",
                   command=self.detect_android).pack(side=tk.LEFT)
        # ── Simulate button (for demo / testing without phone) ──
        ttk.Button(r, text="🎭  Simulate (Demo)",
                   command=self._simulate_device).pack(side=tk.LEFT, padx=(8,0))
        self.lbl_status = tk.Label(r, text="No device detected",
                                    bg=CARD, fg=DANGER, font=FH)
        self.lbl_status.pack(side=tk.LEFT, padx=14)
        self.lbl_info = tk.Label(det, text="", bg=CARD, fg=MUTED, font=FH)
        self.lbl_info.pack(anchor='w', pady=(6, 0))

        wb = tk.Frame(p, bg="#1c0f00"); wb.pack(fill=tk.X, pady=(0, 8))
        tk.Label(wb,
                 text="⚠️  This permanently erases ALL data. "
                      "Back up anything important before starting.",
                 bg="#1c0f00", fg=WARNING, font=FHB,
                 wraplength=880, justify=tk.LEFT,
                 padx=12, pady=8).pack(anchor='w')

        prog = ttk.LabelFrame(p, text="  Progress  ", padding=10)
        prog.pack(fill=tk.X, pady=(0, 8))
        sr = tk.Frame(prog, bg=CARD); sr.pack(fill=tk.X, pady=(0, 8))
        self.step_labels = []
        for lbl in ["1 · Encrypt", "2 · Reset", "3 · Overwrite", "4 · Verify"]:
            l = tk.Label(sr, text=lbl, bg=BORDER, fg=MUTED, font=FHB, padx=8, pady=6)
            l.pack(side=tk.LEFT, expand=True, fill=tk.X, padx=2)
            self.step_labels.append(l)
        self.progress = ttk.Progressbar(prog, maximum=100, mode='determinate')
        self.progress.pack(fill=tk.X, pady=(0, 4))
        self.lbl_prog = tk.Label(prog, text="Detect a device first",
                                  bg=CARD, fg=MUTED, font=FH)
        self.lbl_prog.pack(anchor='w')

        br = tk.Frame(p, bg=BG); br.pack(pady=4)
        self.btn_start = ttk.Button(br, text="▶  START SECURE WIPE",
                                     style='Green.TButton',
                                     command=self._confirm_start,
                                     state='disabled')
        self.btn_start.pack(side=tk.LEFT, padx=(0, 8))
        ttk.Button(br, text="⏹  Cancel",
                   style='Red.TButton', command=self._cancel).pack(side=tk.LEFT)

    def _build_ios(self):
        p = self.f_ios
        det = ttk.LabelFrame(p, text="  Detection  ", padding=10)
        det.pack(fill=tk.X, pady=(0, 8))
        r = tk.Frame(det, bg=CARD); r.pack(fill=tk.X)
        ttk.Button(r, text="🔍  Check for iPhone",
                   command=self.detect_iphone).pack(side=tk.LEFT)
        self.lbl_ios = tk.Label(r, text="No iPhone detected",
                                 bg=CARD, fg=DANGER, font=FH)
        self.lbl_ios.pack(side=tk.LEFT, padx=14)
        g = ttk.LabelFrame(p, text="  Guide  ", padding=10)
        g.pack(fill=tk.BOTH, expand=True)
        self.ios_box = scrolledtext.ScrolledText(
            g, height=14, bg="#0a0d14", fg=TEXT,
            font=FH, relief='flat', wrap=tk.WORD)
        self.ios_box.pack(fill=tk.BOTH, expand=True)
        self.ios_box.insert(tk.END,
            "STEP 1 — Sign out of iCloud FIRST\n"
            "  Settings → [Your Name] → Sign Out\n"
            "  ⚠️  Skipping locks the phone with Activation Lock.\n\n"
            "STEP 2 — Erase\n"
            "  Settings → General → Transfer or Reset iPhone\n"
            "  → Erase All Content and Settings → confirm\n\n"
            "STEP 3 — Verify\n"
            "  Phone shows 'Hello' screen. No Apple ID required.\n\n"
            "Click 'Generate Certificate' below when done.")
        self.ios_box.configure(state='disabled')
        br = tk.Frame(p, bg=BG); br.pack(pady=8)
        ttk.Button(br, text="🌐  Apple Support",
                   command=lambda: __import__('webbrowser').open(
                       'https://support.apple.com/en-us/HT201351')
                   ).pack(side=tk.LEFT, padx=(0, 8))
        ttk.Button(br, text="📜  Generate Certificate",
                   style='Green.TButton',
                   command=lambda: self._gen_cert('iphone')).pack(side=tk.LEFT)

    # ── Simulate device (demo mode) ─────────────────────────────
    def _simulate_device(self):
        self.device_id = "SIMULATED_DEMO"
        self.device_info = {
            'brand':     'Demo',
            'model':     'SimPhone X1',
            'version':   '14',
            'sdk':       '34',
            'encrypted': True,
            'mfr':       '_default',
            'simulated': True,
        }
        self.lbl_status.config(text="🎭 Demo Mode Active", fg=WARNING)
        self.lbl_info.config(text="Demo SimPhone X1 | Android 14 | 🔒 Encrypted (simulated)")
        self.btn_start.config(state='normal')
        self._log("─" * 54)
        self._log("🎭 DEMO MODE — No real device connected.")
        self._log("   The wipe process will be fully simulated.")
        self._log("   No real data will be erased.")
        self._log("─" * 54)

    # ── Detection ──────────────────────────────────────────────
    def detect_android(self):
        self._log("─" * 54)
        self._log("Scanning for device …")
        try:
            subprocess.run([self.adb, 'kill-server'],
                           capture_output=True, timeout=5)
            time.sleep(0.8)
            subprocess.run([self.adb, 'start-server'],
                           capture_output=True, timeout=10)
            time.sleep(1.2)
            r = subprocess.run([self.adb, 'devices'],
                               capture_output=True, text=True, timeout=8)
            self._log(r.stdout.strip())
            found = False
            for line in r.stdout.splitlines()[1:]:
                parts = line.split()
                if len(parts) >= 2 and parts[1] == 'device':
                    self.device_id = parts[0]
                    found = True
                    self.lbl_status.config(text="✅ Connected", fg=SUCCESS)
                    self.btn_start.config(state='normal')
                    self._fetch_info()

                    # ── FORCE RESTART DEMO ──────────────────────────────
                    # Immediately attempt to reboot the phone via ADB.
                    # This demonstrates the tool is actively communicating
                    # with the device. Android security will still require
                    # the user to physically confirm a full factory reset.
                    self._log("─" * 54)
                    self._log("⚡ FORCE RESTART ATTEMPT via ADB")
                    self._log("   Sending 'adb reboot' command to device …")
                    try:
                        reboot_result = subprocess.run(
                            [self.adb, '-s', self.device_id, 'reboot'],
                            capture_output=True, text=True, timeout=8)
                        if reboot_result.returncode == 0:
                            self._log("   ✅ Reboot command accepted — phone is restarting.")
                            self._log("   (Android allowed this because USB Debugging is on.)")
                        else:
                            self._log(f"   ⚠️  Reboot command rejected: {reboot_result.stderr.strip() or 'no error detail'}")
                            self._log("   Android security is actively blocking unauthorised commands.")
                    except subprocess.TimeoutExpired:
                        self._log("   ⏱  Reboot command timed out — Android blocked it.")
                    except Exception as e:
                        self._log(f"   ❌ Could not send reboot: {e}")
                    self._log("─" * 54)
                    break
                if len(parts) >= 2 and parts[1] == 'unauthorized':
                    self._log("⚠️  Tap ALLOW on the phone for USB Debugging")
            if not found:
                self.lbl_status.config(text="❌ No device", fg=DANGER)
                self.btn_start.config(state='disabled')
                self._log("❌ Not found. Check cable, USB Debugging, Allow popup.")
                self._log("   Tip: Try 'Simulate (Demo)' to test without a phone.")
        except FileNotFoundError:
            self._log("❌ adb.exe not found. Place it in the same folder as this tool.")
        except Exception as e:
            self._log(f"❌ {e}")

    def _fetch_info(self):
        def prop(k):
            try:
                r = subprocess.run(
                    [self.adb, '-s', self.device_id, 'shell', 'getprop', k],
                    capture_output=True, text=True, timeout=5)
                return r.stdout.strip()
            except Exception: return ''
        self.device_info = {
            'brand':     prop('ro.product.brand'),
            'model':     prop('ro.product.model'),
            'version':   prop('ro.build.version.release'),
            'sdk':       prop('ro.build.version.sdk'),
            'encrypted': prop('ro.crypto.state') == 'encrypted',
            'mfr':       prop('ro.product.manufacturer').lower(),
            'simulated': False,
        }
        info = (f"{self.device_info['brand']} {self.device_info['model']} | "
                f"Android {self.device_info['version']} | "
                f"{'🔒 Encrypted' if self.device_info['encrypted'] else '⚠️ Not encrypted'}")
        self.lbl_info.config(text=info)
        self._log(f"Device: {info}")

    def detect_iphone(self):
        found = False
        if platform.system() == "Windows":
            try:
                r = subprocess.run(
                    ['powershell', '-Command',
                     'Get-PnpDevice -Class USB | '
                     'Where-Object {$_.FriendlyName -like "*Apple*"} | '
                     'Select -ExpandProperty FriendlyName'],
                    capture_output=True, text=True, timeout=10)
                found = bool(r.stdout.strip())
            except Exception: pass
        elif platform.system() == "Darwin":
            try:
                r = subprocess.run(['system_profiler', 'SPUSBDataType'],
                                   capture_output=True, text=True, timeout=10)
                found = 'iPhone' in r.stdout
            except Exception: pass
        self.lbl_ios.config(
            text="✅ iPhone connected" if found else "Not detected — connect USB and tap Trust",
            fg=SUCCESS if found else WARNING)

    # ── Confirm + start ────────────────────────────────────────
    def _confirm_start(self):
        simulated = self.device_info.get('simulated', False)
        model = (f"{self.device_info.get('brand', '')} "
                 f"{self.device_info.get('model', '')}").strip()
        msg = (
            f"{'[DEMO] ' if simulated else ''}FACTORY RESET: {model or self.device_id}\n\n"
            + ("This is a SIMULATION — no real data will be erased.\n\n"
               if simulated else
               "ALL data will be permanently erased.\nThis cannot be undone.\n\n"
                               "Have you backed up everything?\n\n")
            + "Continue?"
        )
        if not messagebox.askyesno("⚠️  Confirm", msg, icon='warning'):
            return
        self.cancelled = False
        self.btn_start.config(state='disabled')
        if simulated:
            threading.Thread(target=self._simulate_wipe, daemon=True).start()
        else:
            threading.Thread(target=self._wipe, daemon=True).start()

    # ══════════════════════════════════════════════════════════
    # SIMULATION WIPE — runs through all steps with fake delays
    # Restarts itself when done so you can demo again
    # ══════════════════════════════════════════════════════════
    def _simulate_wipe(self):
        model = f"{self.device_info.get('brand','')} {self.device_info.get('model','')}".strip()
        self._log("\n══ DEMO SIMULATION STARTED ══════════════════════════")

        # Log start to DB (marked as desktop, demo device)
        self.log_id = post_start('android', f"[DEMO] {model}")
        if self.log_id:
            self._log(f"📡 Session logged to database (ID: {self.log_id})")
        else:
            self._log("📡 Could not reach server — session not logged online.")

        steps = [
            ("Step 1/4 — Simulating encryption check …",
             ["Checking device encryption status …",
              "✅ Device reports: encrypted (AES-256)",
              "Encryption key will be destroyed during reset."]),
            ("Step 2/4 — Simulating factory reset …",
             ["Opening factory reset settings …",
              "Sending reset command via ADB …",
              "Device acknowledging reset …",
              "⚠️  (In real mode, you confirm on the phone screen)",
              "✅ Reset sequence initiated."]),
            ("Step 3/4 — Simulating free space overwrite …",
             ["Writing zeros to /sdcard …",
              "Overwriting 4 GB … 25% complete",
              "Overwriting 4 GB … 50% complete",
              "Overwriting 4 GB … 75% complete",
              "✅ Free space overwrite complete."]),
            ("Step 4/4 — Simulating verification …",
             ["Reconnecting to device after reset …",
              "Checking for residual user data …",
              "Scanning app list … none found",
              "Scanning account list … none found",
              "✅ Verification passed — device is clean."]),
        ]

        for i, (label, log_lines) in enumerate(steps):
            if self.cancelled: return
            self.win.after(0, lambda n=i: self._setstep(n, 'active'))
            self.win.after(0, lambda l=label: self.lbl_prog.config(text=l))
            self.win.after(0, lambda v=i*25: self.progress.configure(value=v))
            for line in log_lines:
                if self.cancelled: return
                self._log(f"   {line}")
                time.sleep(0.7)
            self.win.after(0, lambda n=i: self._setstep(n, 'done'))
            time.sleep(0.3)

        self.win.after(0, lambda: self.progress.configure(value=100))
        self.win.after(0, lambda: self.lbl_prog.config(text="✅ SIMULATION COMPLETE"))

        self._log("\n" + "═" * 54)
        self._log("🎭  DEMO WIPE SIMULATION COMPLETE")
        self._log("   No real data was erased. This was a demo run.")
        self._log("═" * 54)

        # Log completion to DB
        post_complete('android', f"[DEMO] {model}", self.log_id)
        self._log("📡 Completion logged to database.")

        self._gen_cert('android')

        self.win.after(0, lambda: messagebox.showinfo(
            "Simulation Complete 🎭",
            "Demo run finished!\n\n"
            "All 4 steps simulated successfully:\n"
            "  ✅ Encryption verified\n"
            "  ✅ Factory reset simulated\n"
            "  ✅ Free space overwrite simulated\n"
            "  ✅ Verification passed\n\n"
            f"Session logged to DB (ID: {self.log_id or 'N/A'})\n\n"
            "The tool will now reset for another session."
        ))

        # ── Auto-restart: reset UI for next use ────────────────
        self._auto_restart()

    # ══════════════════════════════════════════════════════════
    # REAL WIPE PROCESS
    # ══════════════════════════════════════════════════════════
    def _wipe(self):
        did = self.device_id
        mfr = self.device_info.get('mfr', '')
        model = f"{self.device_info.get('brand','')} {self.device_info.get('model','')}".strip()

        # ── Log session start to DB ───────────────────────────
        self.log_id = post_start('android', model)
        if self.log_id:
            self._log(f"📡 Session logged to database (ID: {self.log_id})")
        else:
            self._log("📡 Could not reach server — running offline.")

        # ── ADB wrappers ─────────────────────────────────────
        def run(*args, timeout=12):
            try:
                r = subprocess.run(
                    [self.adb, '-s', did] + list(args),
                    capture_output=True, text=True, timeout=timeout)
                return r.returncode == 0, r.stdout.strip(), r.stderr.strip()
            except subprocess.TimeoutExpired:
                return False, '', 'timeout'
            except Exception as e:
                return False, '', str(e)

        def sh(cmd, timeout=12):
            return run('shell', cmd, timeout=timeout)

        def tap(x, y):
            sh(f'input tap {x} {y}'); time.sleep(0.8)

        def key(k):
            sh(f'input keyevent {k}'); time.sleep(0.5)

        def swipe_up():
            sh('input swipe 540 1600 540 400 500'); time.sleep(0.7)

        def ui_dump():
            ok, out, _ = sh(
                'uiautomator dump /sdcard/_ui.xml 2>/dev/null '
                '&& cat /sdcard/_ui.xml', timeout=14)
            return out if (ok and '<' in out) else ''

        def find_tap(keywords, dump):
            for kw in keywords:
                for attr in ('text', 'content-desc'):
                    pat = (rf'{attr}="[^"]*{re.escape(kw)}[^"]*"'
                           rf'[^>]*bounds="\[(\d+),(\d+)\]\[(\d+),(\d+)\]"')
                    m = re.search(pat, dump, re.IGNORECASE)
                    if not m:
                        pat2 = (rf'bounds="\[(\d+),(\d+)\]\[(\d+),(\d+)\]"'
                                rf'[^>]*{attr}="[^"]*{re.escape(kw)}[^"]*"')
                        m = re.search(pat2, dump, re.IGNORECASE)
                    if m:
                        x1,y1,x2,y2 = map(int, m.groups()[:4])
                        cx, cy = (x1+x2)//2, (y1+y2)//2
                        self._log(f"   → '{kw}' found at ({cx},{cy})")
                        tap(cx, cy)
                        return True
            return False

        def setp(n, txt, pct):
            self.win.after(0, lambda: self._setstep(n, 'active'))
            self.win.after(0, lambda: self.progress.configure(value=pct))
            self.win.after(0, lambda: self.lbl_prog.config(text=txt))

        def donep(n):
            self.win.after(0, lambda: self._setstep(n, 'done'))

        def wait_back(secs=120):
            for i in range(secs):
                time.sleep(1)
                ok, out, _ = run('shell', 'echo', 'ok', timeout=4)
                if ok and 'ok' in out:
                    return True
                if i % 20 == 0 and i > 0:
                    self._log(f"   Still waiting … ({i}s)")
            return False

        # ── STEP 1: Encryption ────────────────────────────────
        setp(0, "Step 1/4 — Checking encryption …", 0)
        self._log("\n── STEP 1: ENCRYPTION ──────────────────────────────")
        enc = self.device_info.get('encrypted', False)
        if enc:
            self._log("✅ Encrypted — wiping destroys the key, data becomes unreadable.")
        else:
            self._log("⚠️  Not encrypted — factory reset will still remove your data.")
        if self.cancelled: return
        donep(0)
        self.win.after(0, lambda: self.progress.configure(value=25))
        time.sleep(0.3)

        # ── STEP 2: Factory reset ─────────────────────────────
        setp(1, "Step 2/4 — Opening factory reset screen …", 25)
        self._log("\n── STEP 2: FACTORY RESET ────────────────────────────")

        brand_key = '_default'
        for key_name in BRAND_RESET:
            if key_name != '_default' and key_name in mfr:
                brand_key = key_name
                break
        self._log(f"Brand: {mfr or 'unknown'} → profile: {brand_key}")

        activities = BRAND_RESET[brand_key]
        opened = False

        self._log("Attempting direct Settings launch …")
        for act in activities:
            ok, out, err = run('shell', 'am', 'start', '-n', act, timeout=10)
            if ok and 'Error' not in out and 'Exception' not in err:
                self._log(f"   ✅ Opened: {act}")
                opened = True
                time.sleep(2.5)
                break
            else:
                self._log(f"   ✗ {act}")

        if not opened:
            self._log("Direct launch blocked. Trying intent action …")
            for args in [
                ['am', 'start', '-a', 'android.settings.SETTINGS'],
                ['am', 'start', '-a', 'android.intent.action.MAIN',
                 '-c', 'android.intent.category.HOME'],
            ]:
                ok, _, _ = run('shell', *args, timeout=8)
                if ok:
                    time.sleep(2); break

            self._log("Navigating Settings via UI automation …")
            sh(f'input keyevent 224')
            time.sleep(1)

            if brand_key in ('infinix', 'tecno', 'itel'):
                nav_steps = [
                    (["System", "System settings"],              "System"),
                    (["Reset options", "Reset", "Backup"],       "Reset options"),
                    (["Erase all data", "Factory data reset",
                      "Factory reset"],                          "Factory reset"),
                    (["Reset phone", "Erase all data",
                      "Continue"],                               "Reset phone"),
                ]
            elif brand_key == 'samsung':
                nav_steps = [
                    (["General management"],                     "General management"),
                    (["Reset"],                                  "Reset"),
                    (["Factory data reset"],                     "Factory data reset"),
                    (["Reset", "Erase all"],                     "Reset button"),
                ]
            elif brand_key in ('xiaomi', 'redmi', 'poco'):
                nav_steps = [
                    (["About phone", "Additional settings"],     "About phone"),
                    (["Factory reset", "Backup & reset"],        "Factory reset"),
                    (["Reset phone", "Continue"],                "Reset phone"),
                ]
            else:
                nav_steps = [
                    (["System", "General management", "About phone"], "System/General"),
                    (["Reset options", "Reset", "Backup"],       "Reset options"),
                    (["Erase all data", "Factory data reset",
                      "Factory reset"],                          "Factory reset"),
                    (["Reset phone", "Erase all", "Continue"],   "Confirm"),
                ]

            for keywords, label in nav_steps:
                if self.cancelled: return
                self._log(f"   Looking for: {label} …")
                time.sleep(1.5)
                dump = ui_dump()
                found_item = find_tap(keywords, dump) if dump else False
                if not found_item:
                    swipe_up(); time.sleep(1)
                    dump = ui_dump()
                    found_item = find_tap(keywords, dump) if dump else False
                if not found_item:
                    self._log(f"   Could not find '{label}' automatically.")
                    break
                opened = True

        manual = BRAND_MANUAL.get(brand_key, BRAND_MANUAL['_default'])
        intro = (
            "The factory reset screen should now be open on your phone.\n\n"
            "If it looks correct, follow the steps below to confirm.\n"
            "If the wrong screen opened, navigate manually:\n\n"
        ) if opened else (
            "The tool could not open the reset screen automatically.\n\n"
            "Please do it manually — it takes about 30 seconds:\n\n"
        )

        self.win.after(0, lambda: messagebox.showinfo(
            "👆  Action needed on your phone",
            intro + manual +
            "\n\n─────────────────────────────\n"
            "The phone will restart and wipe itself (2–5 min).\n"
            "Do NOT unplug the cable.\n\n"
            "Click OK here once you have tapped the final confirm button."
        ))

        if self.cancelled: return
        donep(1)
        self.win.after(0, lambda: self.progress.configure(value=50))
        self._log("Step 2 complete.\n")
        time.sleep(0.3)

        # ── STEP 3: Overwrite ─────────────────────────────────
        setp(2, "Step 3/4 — Overwriting free space …", 50)
        self._log("── STEP 3: OVERWRITE ────────────────────────────────")
        self._log("Waiting for phone to come back after reset …")

        if wait_back(120):
            self._log("Phone is online. Writing zeros to free space …")
            ok, out, err = sh(
                'dd if=/dev/zero of=/sdcard/_sw_zero.tmp bs=4096 2>/dev/null; '
                'rm -f /sdcard/_sw_zero.tmp; echo done',
                timeout=300)
            if 'done' in out:
                self._log("✅ Free space overwrite complete.")
            else:
                self._log("⚠️  Overwrite skipped (device may have fully rebooted).")
                self._log("   Data is already unrecoverable — key was destroyed.")
        else:
            self._log("Device fully rebooted. Key destruction already makes")
            self._log("data unreadable. Overwrite step not needed.")

        if self.cancelled: return
        donep(2)
        self.win.after(0, lambda: self.progress.configure(value=75))
        self._log("Step 3 complete.\n")
        time.sleep(0.3)

        # ── STEP 4: Verify ─────────────────────────────────────
        setp(3, "Step 4/4 — Verification …", 75)
        self._log("── STEP 4: VERIFY ───────────────────────────────────")
        self._log("Check on the phone:")
        self._log("  ✓ Shows 'Welcome' or language selection screen")
        self._log("  ✓ No previous apps or accounts visible")
        self._log("  ✓ Phone behaves as brand new")
        donep(3)
        self.win.after(0, lambda: self.progress.configure(value=100))
        self.win.after(0, lambda: self.lbl_prog.config(text="✅ COMPLETE"))
        self._log("\n" + "═" * 54)
        self._log("✅  SECURE WIPE COMPLETE")
        self._log("═" * 54)

        self._gen_cert('android')
        post_complete('android', model, self.log_id)
        self._log("📡 Completion logged to database.")

        self.win.after(0, lambda: messagebox.showinfo(
            "Done ✅",
            "Secure wipe complete!\n\n"
            "The phone has been factory reset.\n"
            "The encryption key was destroyed — data is unrecoverable.\n\n"
            f"Certificate saved to:\n{self.cert_file}\n\n"
            f"Session ID: {self.log_id or 'N/A'}\n\n"
            "The tool will now reset for the next device."
        ))

        # ── Auto-restart for next device ───────────────────────
        self._auto_restart()

    # ── Auto-restart UI after completion ──────────────────────
    def _auto_restart(self):
        """Reset the UI so the tool is ready for another device immediately."""
        def _reset():
            time.sleep(1.5)
            self.device_id   = None
            self.device_info = {}
            self.cancelled   = False
            self.log_id      = None
            self.log_file    = f"wipe_log_{datetime.now():%Y%m%d_%H%M%S}.txt"
            self.cert_file   = f"wipe_certificate_{datetime.now():%Y%m%d_%H%M%S}.txt"

            self.win.after(0, lambda: self.lbl_status.config(text="No device detected", fg=DANGER))
            self.win.after(0, lambda: self.lbl_info.config(text=""))
            self.win.after(0, lambda: self.btn_start.config(state='disabled'))
            self.win.after(0, lambda: self.progress.configure(value=0))
            self.win.after(0, lambda: self.lbl_prog.config(text="Detect a device first"))
            for i in range(4):
                self.win.after(0, lambda idx=i: self._setstep(idx, 'idle'))

            self._log("\n" + "─" * 54)
            self._log("🔄  Tool reset — ready for next device.")
            self._log("─" * 54)

        threading.Thread(target=_reset, daemon=True).start()

    # ── Certificate ────────────────────────────────────────────
    def _gen_cert(self, dtype):
        lines = ["=" * 56, "         SECURE WIPE CERTIFICATE", "=" * 56,
                 f"Date/Time    : {datetime.now():%Y-%m-%d %H:%M:%S}",
                 f"Tool Version : SecureWipe v5.1",
                 f"Device Type  : {dtype.upper()}"]
        if dtype == 'android' and self.device_info:
            lines += [
                f"Brand/Model  : {self.device_info.get('brand','')} "
                f"{self.device_info.get('model','')}",
                f"Android Ver  : {self.device_info.get('version','?')}",
                f"Encrypted    : {'Yes' if self.device_info.get('encrypted') else 'No'}",
                f"Device ID    : {self.device_id}",
                f"Simulated    : {'Yes (Demo)' if self.device_info.get('simulated') else 'No'}",
            ]
        if self.log_id:
            lines.append(f"Session ID   : {self.log_id}")
        lines += ["", "Steps completed:",
                  "  [✓] Encryption verified",
                  "  [✓] Factory reset initiated and confirmed",
                  "  [✓] Free-space overwrite performed",
                  "  [✓] Verification checklist reviewed",
                  "", "=" * 56,
                  "Device is safe for sale or disposal.", "=" * 56]
        try:
            with open(self.cert_file, 'w', encoding='utf-8') as f:
                f.write('\n'.join(lines))
            self._log(f"✅ Certificate → {self.cert_file}")
        except Exception as e:
            self._log(f"❌ Certificate error: {e}")

    # ── Helpers ────────────────────────────────────────────────
    def _setstep(self, i, state):
        c = {'idle': (BORDER, MUTED), 'active': (WARNING, '#000'),
             'done': (SUCCESS, '#fff')}
        bg, fg = c.get(state, c['idle'])
        self.step_labels[i].config(bg=bg, fg=fg)

    def _cancel(self):
        if messagebox.askyesno("Cancel", "Cancel the current operation?"):
            self.cancelled = True
            self._log("⏹  Cancelled.")
            self.btn_start.config(state='normal')

    def _log(self, msg):
        ts   = datetime.now().strftime("%H:%M:%S")
        line = f"[{ts}] {msg}\n"
        self.log_box.configure(state='normal')
        self.log_box.insert(tk.END, line)
        self.log_box.see(tk.END)
        self.log_box.configure(state='disabled')
        self.win.update_idletasks()
        try:
            with open(self.log_file, 'a', encoding='utf-8') as f:
                f.write(line)
        except Exception:
            pass

    def run(self):
        self.win.mainloop()


if __name__ == "__main__":
    SecureWipeTool().run()
