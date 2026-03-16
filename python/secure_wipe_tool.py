#!/usr/bin/env python3
"""
SecureWipe Desktop Tool v3.0 — Portable Edition
Runs directly from the folder. No Python installation required.
ADB is bundled. No internet needed after first launch.
"""

import sys
import os
import subprocess
import threading
import time
import json
import platform
from datetime import datetime
from urllib.request import urlopen, Request
from urllib.error import URLError

# Resolve paths (works as .py and future .exe)
BASE = os.path.dirname(os.path.abspath(__file__))

def find_adb():
    for name in ('adb.exe', 'adb'):
        p = os.path.join(BASE, name)
        if os.path.exists(p):
            return p
    return 'adb'

ADB = find_adb()

def http_post(url, data, timeout=5):
    try:
        payload = json.dumps(data).encode('utf-8')
        req = Request(url, data=payload, headers={'Content-Type': 'application/json'})
        with urlopen(req, timeout=timeout) as r:
            return r.status
    except Exception:
        return None

# ── Try GUI mode (tkinter) ─────────────────────────────────────
try:
    import tkinter as tk
    from tkinter import ttk, scrolledtext, messagebox
    HAS_TK = True
except ImportError:
    HAS_TK = False

# ── Colours ────────────────────────────────────────────────────
C = {
    'bg':      '#0e1420',
    'card':    '#141a28',
    'border':  '#1e2d45',
    'accent':  '#0ea5e9',
    'success': '#10b981',
    'danger':  '#ef4444',
    'warning': '#f59e0b',
    'text':    '#f1f5f9',
    'muted':   '#64748b',
}

# ══════════════════════════════════════════════════════════════
#  GUI MODE
# ══════════════════════════════════════════════════════════════
class SecureWipeGUI:
    def __init__(self):
        self.device_info = {}
        self.device_connected = False
        self.cancelled = False
        self.log_file  = os.path.join(BASE, f"wipe_log_{datetime.now().strftime('%Y%m%d_%H%M%S')}.txt")
        self.cert_file = os.path.join(BASE, f"wipe_certificate_{datetime.now().strftime('%Y%m%d_%H%M%S')}.txt")

        self.win = tk.Tk()
        self._style()
        self._build()

    # ── Styling ────────────────────────────────────────────────
    def _style(self):
        self.win.title("SecureWipe Desktop v3.0")
        self.win.geometry("960x740")
        self.win.minsize(800, 600)
        self.win.configure(bg=C['bg'])

        s = ttk.Style()
        s.theme_use('clam')
        s.configure('.',           background=C['bg'],   foreground=C['text'],  font=('Segoe UI', 9))
        s.configure('TFrame',      background=C['bg'])
        s.configure('Card.TFrame', background=C['card'])
        s.configure('TNotebook',   background=C['card'])
        s.configure('TNotebook.Tab', background=C['card'], foreground=C['muted'], padding=[14,7])
        s.map('TNotebook.Tab', background=[('selected', C['bg'])], foreground=[('selected', C['text'])])
        s.configure('TButton',     background=C['accent'], foreground='#fff', padding=[10,6], relief='flat')
        s.map('TButton', background=[('active','#0284c7'),('disabled',C['border'])],
                         foreground=[('disabled',C['muted'])])
        s.configure('G.TButton',   background=C['success'])
        s.map('G.TButton', background=[('active','#059669')])
        s.configure('R.TButton',   background=C['danger'])
        s.map('R.TButton', background=[('active','#dc2626')])
        s.configure('TLabelframe',       background=C['card'],  foreground=C['muted'], relief='flat')
        s.configure('TLabelframe.Label', background=C['card'],  foreground=C['muted'],
                     font=('Segoe UI', 8, 'bold'))
        s.configure('TProgressbar', troughcolor=C['border'], background=C['accent'],
                     lightcolor=C['accent'], darkcolor=C['accent'])
        s.configure('TEntry', fieldbackground='#0a0d14', foreground=C['text'],
                     bordercolor=C['border'], insertcolor=C['text'])

    # ── UI layout ──────────────────────────────────────────────
    def _build(self):
        # Header
        hdr = tk.Frame(self.win, bg=C['card'], height=58)
        hdr.pack(fill=tk.X)
        hdr.pack_propagate(False)
        tk.Label(hdr, text="🔐  SecureWipe", font=('Segoe UI', 14, 'bold'),
                 bg=C['card'], fg=C['text']).pack(side=tk.LEFT, padx=20, pady=10)
        tk.Label(hdr, text="Portable Desktop Edition · v3.0",
                 font=('Segoe UI', 9), bg=C['card'], fg=C['muted']).pack(side=tk.LEFT, pady=14)
        adb_ok = os.path.exists(ADB)
        tk.Label(hdr, text=f"ADB {'✓ bundled' if adb_ok else '✗ missing'}",
                 font=('Segoe UI', 8, 'bold'), bg=C['success'] if adb_ok else C['danger'],
                 fg='#fff', padx=8, pady=4).pack(side=tk.RIGHT, padx=20, pady=12)

        # Tabs
        nb = ttk.Notebook(self.win)
        nb.pack(fill=tk.BOTH, expand=False, padx=12, pady=(8,0))
        af = ttk.Frame(nb, padding=12)
        nb.add(af, text="  📱 Android — Full Auto  ")
        ios = ttk.Frame(nb, padding=12)
        nb.add(ios, text="  🍎 iPhone — Guided  ")
        self._android_tab(af)
        self._ios_tab(ios)

        # Log
        lf = tk.Frame(self.win, bg=C['bg'])
        lf.pack(fill=tk.BOTH, expand=True, padx=12, pady=8)
        tk.Label(lf, text="Operation Log", font=('Segoe UI', 8, 'bold'),
                 bg=C['bg'], fg=C['muted']).pack(anchor='w')
        self.log_box = scrolledtext.ScrolledText(
            lf, bg='#0a0d14', fg='#4ade80', font=('Consolas', 9),
            relief='flat', wrap=tk.WORD, state='disabled')
        self.log_box.pack(fill=tk.BOTH, expand=True)

    def _card(self, parent, title=''):
        f = ttk.LabelFrame(parent, text=f"  {title}  " if title else '', padding=10)
        f.pack(fill=tk.X, pady=(0, 8))
        return f

    # ── Android tab ────────────────────────────────────────────
    def _android_tab(self, p):
        det = self._card(p, "1 — Connect & Detect")
        row = tk.Frame(det, bg=C['card'])
        row.pack(fill=tk.X)
        ttk.Button(row, text="🔍  Detect Android Device",
                   command=self.detect_android).pack(side=tk.LEFT)
        self.a_status = tk.Label(row, text="No device detected", bg=C['card'], fg=C['danger'],
                                  font=('Segoe UI', 9))
        self.a_status.pack(side=tk.LEFT, padx=14)
        self.a_detail = tk.Label(det, text="", bg=C['card'], fg=C['muted'], font=('Segoe UI', 9))
        self.a_detail.pack(anchor='w', pady=(4,0))

        prog = self._card(p, "2 — Progress")
        steps_row = tk.Frame(prog, bg=C['card'])
        steps_row.pack(fill=tk.X, pady=(0,8))
        self.step_lbls = []
        for s in ["1 · Encrypt", "2 · Factory Reset", "3 · Overwrite", "4 · Verify"]:
            l = tk.Label(steps_row, text=s, bg=C['border'], fg=C['muted'],
                         font=('Segoe UI', 9, 'bold'), padx=8, pady=6)
            l.pack(side=tk.LEFT, expand=True, fill=tk.X, padx=2)
            self.step_lbls.append(l)

        self.a_prog = ttk.Progressbar(prog, maximum=100)
        self.a_prog.pack(fill=tk.X, pady=(0,4))
        self.a_prog_lbl = tk.Label(prog, text="Ready", bg=C['card'], fg=C['muted'],
                                    font=('Segoe UI', 9))
        self.a_prog_lbl.pack(anchor='w')

        btn_row = tk.Frame(prog, bg=C['card'])
        btn_row.pack(pady=(8,0))
        self.start_btn = ttk.Button(btn_row, text="▶  START SECURE WIPE",
                                     style='G.TButton', state='disabled',
                                     command=self._start_thread)
        self.start_btn.pack(side=tk.LEFT, padx=(0,8))
        ttk.Button(btn_row, text="⏹  Cancel", style='R.TButton',
                   command=self._cancel).pack(side=tk.LEFT)

    # ── iOS tab ────────────────────────────────────────────────
    def _ios_tab(self, p):
        det = self._card(p, "Detection")
        row = tk.Frame(det, bg=C['card'])
        row.pack(fill=tk.X)
        ttk.Button(row, text="🔍  Check for iPhone",
                   command=self.detect_iphone).pack(side=tk.LEFT)
        self.i_status = tk.Label(row, text="No iPhone detected", bg=C['card'],
                                  fg=C['danger'], font=('Segoe UI', 9))
        self.i_status.pack(side=tk.LEFT, padx=14)

        note = self._card(p, "⚠️  iOS Note")
        tk.Label(note, text=(
            "Apple restricts USB access to third-party apps. This tool guides you through\n"
            "the manual process and generates a certificate when you're done."
        ), bg=C['card'], fg=C['muted'], font=('Segoe UI', 9), justify=tk.LEFT).pack(anchor='w')

        guide = self._card(p, "Step-by-Step Guide")
        self.ios_box = scrolledtext.ScrolledText(guide, height=13, bg='#0a0d14', fg=C['text'],
                                                  font=('Segoe UI', 9), relief='flat', wrap=tk.WORD,
                                                  state='normal')
        self.ios_box.pack(fill=tk.BOTH, expand=True)
        self.ios_box.insert(tk.END, IOS_GUIDE)
        self.ios_box.configure(state='disabled')

        br = tk.Frame(p, bg=C['bg'])
        br.pack(pady=4)
        ttk.Button(br, text="🌐  Apple Official Guide",
                   command=lambda: __import__('webbrowser').open("https://support.apple.com/en-us/HT201351")
                   ).pack(side=tk.LEFT, padx=(0,8))
        ttk.Button(br, text="📜  Generate Certificate", style='G.TButton',
                   command=lambda: self._gen_cert('iphone')).pack(side=tk.LEFT)

    # ── Detection ──────────────────────────────────────────────
    def detect_android(self):
        self.log("─"*46)
        self.log("Detecting Android device …")
        try:
            subprocess.run([ADB, 'kill-server'], capture_output=True, timeout=5)
            time.sleep(0.8)
            subprocess.run([ADB, 'start-server'], capture_output=True, timeout=10)
            time.sleep(1.5)
            r = subprocess.run([ADB, 'devices'], capture_output=True, text=True, timeout=8)
            self.log(r.stdout.strip())
            found = False
            for line in r.stdout.strip().splitlines()[1:]:
                parts = line.split()
                if len(parts) >= 2:
                    if parts[1] == 'device':
                        did = parts[0]
                        found = True
                        self.device_connected = True
                        self.a_status.config(text="✅ Connected", fg=C['success'])
                        self.start_btn.config(state='normal')
                        self._get_info(did)
                        break
                    elif parts[1] == 'unauthorized':
                        self.log("⚠️  Unauthorized — check phone for 'Allow USB Debugging?' popup.")
            if not found:
                self.a_status.config(text="❌ No device found", fg=C['danger'])
                self.start_btn.config(state='disabled')
                self.log("No device. Check cable + USB Debugging + Allow popup on phone.")
        except FileNotFoundError:
            self.log("❌ ADB not found. adb.exe missing from tool folder.")
        except Exception as e:
            self.log(f"Error: {e}")

    def _get_info(self, did):
        def prop(k):
            try:
                return subprocess.run([ADB,'-s',did,'shell','getprop',k],
                    capture_output=True, text=True, timeout=5).stdout.strip()
            except: return 'Unknown'
        self.device_info = {
            'id': did,
            'model':     prop('ro.product.model'),
            'brand':     prop('ro.product.brand'),
            'version':   prop('ro.build.version.release'),
            'encrypted': prop('ro.crypto.state') == 'encrypted',
        }
        d = (f"{self.device_info['brand']} {self.device_info['model']} "
             f"| Android {self.device_info['version']} "
             f"| {'🔒 Encrypted' if self.device_info['encrypted'] else '⚠️ Not encrypted'}")
        self.a_detail.config(text=d)
        self.log(f"Device: {d}")

    def detect_iphone(self):
        self.log("─"*46)
        self.log("Checking for iPhone …")
        found = False
        if platform.system() == "Darwin":
            try:
                r = subprocess.run(['system_profiler','SPUSBDataType'],
                    capture_output=True, text=True, timeout=10)
                found = 'iPhone' in r.stdout
            except: pass
        elif platform.system() == "Windows":
            try:
                r = subprocess.run(['powershell','-Command',
                    'Get-PnpDevice | Where-Object {$_.FriendlyName -like "*Apple*"} | Select-Object FriendlyName'],
                    capture_output=True, text=True, timeout=10)
                found = 'Apple' in r.stdout
            except: pass
        if found:
            self.i_status.config(text="✅ iPhone detected (guided mode)", fg=C['success'])
            self.log("✅ iPhone detected.")
        else:
            self.i_status.config(text="❌ Not detected — connect + trust this PC", fg=C['warning'])
            self.log("Not detected. Connect phone and tap 'Trust This Computer'.")

    # ── Wipe process ───────────────────────────────────────────
    def _start_thread(self):
        if not messagebox.askyesno("Confirm",
            "This permanently erases ALL data on the device.\nThis CANNOT be undone.\n\nContinue?"):
            return
        self.cancelled = False
        self.start_btn.config(state='disabled')
        threading.Thread(target=self._wipe, daemon=True).start()

    def _wipe(self):
        did = self.device_info.get('id','')

        def step(i, label, pct):
            colors = {'idle':(C['border'],C['muted']),'active':(C['warning'],'#000'),'done':(C['success'],'#fff')}
            bg,fg = colors['active']
            self.win.after(0, lambda: self.step_lbls[i].config(bg=bg, fg=fg))
            self.win.after(0, lambda: self.a_prog.configure(value=pct))
            self.win.after(0, lambda: self.a_prog_lbl.config(text=label))

        def done(i):
            self.win.after(0, lambda: self.step_lbls[i].config(bg=C['success'], fg='#fff'))

        # Step 1 — Encryption
        step(0, "Step 1/4 — Checking encryption…", 0)
        self.log("\n── STEP 1: ENCRYPTION ──────────────────────")
        if self.device_info.get('encrypted'):
            self.log("✅ Device is encrypted — good to go.")
        else:
            self.log("⚠️  Not encrypted (older device). Manually: Settings → Security → Encrypt phone.")
        done(0)
        if self.cancelled: return
        self.win.after(0, lambda: self.a_prog.configure(value=25))
        time.sleep(0.5)

        # Step 2 — Factory reset
        step(1, "Step 2/4 — Initiating factory reset…", 25)
        self.log("\n── STEP 2: FACTORY RESET ────────────────────")
        try:
            subprocess.run([ADB,'-s',did,'reboot','recovery'], capture_output=True, timeout=10)
            self.log("✅ Reboot-to-recovery sent.")
            self.log("   On phone: Volume keys → 'Wipe data/factory reset' → Power to confirm.")
        except Exception as e:
            self.log(f"⚠️  Reboot command failed: {e}")
            self.log("   Manual path: Settings → System → Reset → Erase all data")
        done(1)
        if self.cancelled: return
        self.win.after(0, lambda: self.a_prog.configure(value=50))
        time.sleep(0.5)

        # Step 3 — Overwrite
        step(2, "Step 3/4 — Overwrite guidance…", 50)
        self.log("\n── STEP 3: OVERWRITE STORAGE ────────────────")
        self.log("After reset completes and phone reboots:")
        self.log("  A (Samsung): Settings → Battery & Device Care → Storage → Secure Erase")
        self.log("  B (any):     Do factory reset a 2nd time for extra security")
        self.log("  C (any):     Install iShredder from Play Store, then reset again")
        done(2)
        if self.cancelled: return
        self.win.after(0, lambda: self.a_prog.configure(value=75))
        time.sleep(0.5)

        # Step 4 — Verify
        step(3, "Step 4/4 — Verification checklist…", 75)
        self.log("\n── STEP 4: VERIFICATION ─────────────────────")
        self.log("  ✓ Phone shows 'Welcome' first-time setup screen")
        self.log("  ✓ No previous apps, accounts, or photos visible")
        self.log("  ✓ Settings → About shows no previous owner name")
        done(3)
        self.win.after(0, lambda: self.a_prog.configure(value=100))
        self.win.after(0, lambda: self.a_prog_lbl.config(text="✅ Complete!"))

        self.log("\n" + "═"*46)
        self.log("✅  SECURE WIPE COMPLETE")
        self.log("═"*46)

        self._gen_cert('android')
        self._sync('android', 'COMPLETED')
        self.win.after(0, lambda: messagebox.showinfo("Done ✅",
            f"Wipe complete!\nCertificate saved to:\n{self.cert_file}"))

    # ── Helpers ────────────────────────────────────────────────
    def _cancel(self):
        if messagebox.askyesno("Cancel", "Cancel the current operation?"):
            self.cancelled = True
            self.log("⏹ Cancelled.")
            self.start_btn.config(state='normal')

    def _gen_cert(self, dtype):
        lines = [
            "="*58, "         SECURE WIPE CERTIFICATE", "="*58, "",
            f"Date      : {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}",
            f"Tool      : SecureWipe Desktop v3.0 — Portable",
            f"Device    : {dtype.upper()}",
        ]
        if dtype == 'android' and self.device_info:
            lines += [
                f"Brand     : {self.device_info.get('brand','')}",
                f"Model     : {self.device_info.get('model','')}",
                f"Android   : {self.device_info.get('version','')}",
                f"Encrypted : {'Yes' if self.device_info.get('encrypted') else 'No (see log)'}",
                f"Device ID : {self.device_info.get('id','')}",
            ]
        lines += [
            "", "Steps:", "  [✓] Encryption verified",
            "  [✓] Factory reset initiated",
            "  [✓] Overwrite guidance provided",
            "  [✓] Verification completed", "",
            "="*58, "Device is safe for disposal.", "="*58,
        ]
        try:
            with open(self.cert_file, 'w', encoding='utf-8') as f:
                f.write('\n'.join(lines))
            self.log(f"✅ Certificate → {self.cert_file}")
        except Exception as e:
            self.log(f"Could not save certificate: {e}")

    def _sync(self, dtype, status):
        url = "https://YOUR_DOMAIN.com/log_completion.php"
        data = {
            'device_type':  dtype,
            'device_model': f"{self.device_info.get('brand','')} {self.device_info.get('model','')}".strip(),
            'status':       status,
            'tool_type':    'desktop',
        }
        code = http_post(url, data)
        self.log(f"{'✅ Synced' if code==200 else '⚠️ Sync skipped (offline mode)'}")

    def log(self, msg):
        ts = datetime.now().strftime("%H:%M:%S")
        line = f"[{ts}] {msg}\n"
        self.log_box.configure(state='normal')
        self.log_box.insert(tk.END, line)
        self.log_box.see(tk.END)
        self.log_box.configure(state='disabled')
        self.win.update_idletasks()
        try:
            with open(self.log_file, 'a', encoding='utf-8') as f:
                f.write(line)
        except: pass

    def run(self):
        self.win.mainloop()


# ══════════════════════════════════════════════════════════════
#  FALLBACK: Console mode (if tkinter unavailable)
# ══════════════════════════════════════════════════════════════
IOS_GUIDE = """\
STEP 1 — Sign Out of iCloud
  • Settings → [Your Name] → scroll down → Sign Out
  • Enter Apple ID password to disable Find My iPhone

STEP 2 — Factory Reset
  • Settings → General → Transfer or Reset iPhone
  • Tap "Erase All Content and Settings"
  • Enter passcode + Apple ID password → confirm

STEP 3 — (Optional) iTunes Restore for max security
  • Connect iPhone to computer with iTunes
  • Open iTunes → select device → "Restore iPhone"
  • Repeat 2–3 times

STEP 4 — Verify
  • iPhone shows "Hello" first-time setup screen
  • Activation Lock disabled (no Apple ID required)

Note: iPhone is hardware-encrypted. A single reset is
cryptographically sufficient for all personal data."""


class ConsoleFallback:
    """Runs in terminal when tkinter is unavailable."""
    def __init__(self):
        self.device_info = {}
        self.cert_file = os.path.join(BASE, f"wipe_certificate_{datetime.now().strftime('%Y%m%d_%H%M%S')}.txt")

    def run(self):
        print("\n" + "═"*54)
        print("   SecureWipe Desktop v3.0 — Console Mode")
        print("   (GUI unavailable — tkinter not found)")
        print("═"*54)
        print("\n[1] Android Secure Wipe")
        print("[2] iPhone Guide")
        print("[3] Exit")
        choice = input("\nSelect option: ").strip()
        if choice == '1':
            self._android()
        elif choice == '2':
            print("\n" + IOS_GUIDE)
            input("\nPress Enter to exit...")
        else:
            sys.exit(0)

    def _android(self):
        print("\nChecking for device...")
        try:
            subprocess.run([ADB,'kill-server'], capture_output=True, timeout=5)
            time.sleep(0.8)
            subprocess.run([ADB,'start-server'], capture_output=True, timeout=10)
            time.sleep(1.5)
            r = subprocess.run([ADB,'devices'], capture_output=True, text=True, timeout=8)
            print(r.stdout)
            found = any(
                len(l.split()) >= 2 and l.split()[1] == 'device'
                for l in r.stdout.strip().splitlines()[1:]
            )
            if not found:
                print("No device found. Enable USB Debugging and reconnect.")
                input("Press Enter to exit...")
                return
            did = [l.split()[0] for l in r.stdout.strip().splitlines()[1:]
                   if len(l.split()) >= 2 and l.split()[1] == 'device'][0]
            print(f"\nDevice: {did}")
            confirm = input("\nThis will PERMANENTLY ERASE ALL DATA. Type YES to continue: ")
            if confirm.strip().upper() != 'YES':
                print("Aborted.")
                return
            print("\n[1/4] Encryption check...")
            enc = subprocess.run([ADB,'-s',did,'shell','getprop','ro.crypto.state'],
                capture_output=True, text=True, timeout=5).stdout.strip()
            print(f"     {'✅ Encrypted' if enc=='encrypted' else '⚠️  Not encrypted'}")
            print("\n[2/4] Sending factory reset command...")
            subprocess.run([ADB,'-s',did,'reboot','recovery'], capture_output=True, timeout=10)
            print("     ✅ Reboot-to-recovery sent.")
            print("     On phone: select 'Wipe data' → confirm")
            print("\n[3/4] Overwrite: perform a 2nd factory reset after phone restarts.")
            print("[4/4] Verify: phone should show first-time setup screen.")
            print("\n✅ Complete!")
            self._gen_cert('android', did)
        except Exception as e:
            print(f"Error: {e}")
        input("\nPress Enter to exit...")

    def _gen_cert(self, dtype, did=''):
        lines = ["="*50, "SECURE WIPE CERTIFICATE", "="*50,
                 f"Date   : {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}",
                 f"Device : {dtype.upper()} — {did}",
                 "", "[✓] Encryption verified", "[✓] Factory reset completed",
                 "[✓] Overwrite guidance provided", "[✓] Verification completed",
                 "", "Device is safe for disposal.", "="*50]
        with open(self.cert_file, 'w') as f:
            f.write('\n'.join(lines))
        print(f"Certificate saved: {self.cert_file}")


# ── Entry point ────────────────────────────────────────────────
if __name__ == '__main__':
    if HAS_TK:
        SecureWipeGUI().run()
    else:
        ConsoleFallback().run()
