# SecureWipe — Build Your Own EXE

The `.py` source file uses **only Python's standard library** (no `pip install` needed
for users). To distribute a standalone `.exe` that users double-click:

## Prerequisites (one-time, for the developer)

1. Install [Python 3.8+](https://python.org) — check "Add to PATH"
2. Run:  `pip install pyinstaller`
3. Have `adb.exe`, `AdbWinApi.dll`, `AdbWinUsbApi.dll` in this folder
   (download from: https://developer.android.com/tools/releases/platform-tools)

## Build (Windows)

```
build_tools\BUILD_WINDOWS.bat
```

Or manually:
```
pyinstaller SecureWipe.spec --clean --noconfirm
```

Output: `dist\SecureWipe.exe` — a **single file**, no Python required on user machines.

## What gets bundled

| Component | Why |
|-----------|-----|
| Python runtime | So users don't need Python installed |
| tkinter | GUI framework |
| stdlib modules | urllib, threading, json, subprocess… |
| adb.exe | Android Debug Bridge |
| AdbWinApi.dll | ADB Windows driver |
| AdbWinUsbApi.dll | ADB Windows USB support |

## Distribution

Upload `dist\SecureWipe.exe` to your website and link it from `download-tool.php`.
Users get one file (~15–25 MB), double-click it, done.

## Updating the website URL

The tool posts logs to `http://localhost/secure-wipe-website/log_completion.php`.
Change this to your production URL in `secure_wipe_tool.py`:

```python
url = "https://yourdomain.com/log_completion.php"
```

Then rebuild.
