# -*- mode: python ; coding: utf-8 -*-
# SecureWipe.spec — PyInstaller build config
# Run: pyinstaller SecureWipe.spec

import os

block_cipher = None

a = Analysis(
    ['secure_wipe_tool.py'],
    pathex=[],
    binaries=[
        # Bundle ADB + DLLs (Windows) — must be in same folder as .spec
        ('adb.exe',         '.'),
        ('AdbWinApi.dll',   '.'),
        ('AdbWinUsbApi.dll','.'),
    ],
    datas=[],
    hiddenimports=[
        'tkinter',
        'tkinter.ttk',
        'tkinter.scrolledtext',
        'tkinter.messagebox',
        'tkinter.filedialog',
        'urllib.request',
        'urllib.error',
        'urllib.parse',
        'json',
        'threading',
        'subprocess',
        'webbrowser',
    ],
    hookspath=[],
    hooksconfig={},
    runtime_hooks=[],
    excludes=[
        'matplotlib', 'numpy', 'pandas', 'scipy',
        'PIL', 'PyQt5', 'PyQt6', 'wx',
        'requests',       # removed — we use stdlib urllib now
        'pip', 'setuptools',
    ],
    win_no_prefer_redirects=False,
    win_private_assemblies=False,
    cipher=block_cipher,
    noarchive=False,
)

pyz = PYZ(a.pure, a.zipped_data, cipher=block_cipher)

exe = EXE(
    pyz,
    a.scripts,
    a.binaries,
    a.zipfiles,
    a.datas,
    [],
    name='SecureWipe',
    debug=False,
    bootloader_ignore_signals=False,
    strip=False,
    upx=True,          # compress with UPX if available (reduces size ~40%)
    upx_exclude=[],
    runtime_tmpdir=None,
    console=False,     # no black console window — GUI only
    disable_windowed_traceback=False,
    argv_emulation=False,
    target_arch=None,
    codesign_identity=None,
    entitlements_file=None,
    icon='icon.ico',   # optional — remove this line if you don't have an icon
)
