# -*- mode: python ; coding: utf-8 -*-
# SecureWipe.spec — PyInstaller build configuration
# The GitHub Actions workflow places adb.exe + DLLs here before running this

import os, sys

block_cipher = None

# Collect ADB binaries — only include ones that actually exist
_adb_files = []
for _f in ['adb.exe', 'AdbWinApi.dll', 'AdbWinUsbApi.dll']:
    if os.path.exists(_f):
        _adb_files.append((_f, '.'))

a = Analysis(
    ['secure_wipe_tool.py'],
    pathex=['.'],
    binaries=_adb_files,
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
        'platform',
        'datetime',
    ],
    hookspath=[],
    hooksconfig={},
    runtime_hooks=[],
    excludes=[
        'matplotlib', 'numpy', 'pandas', 'scipy',
        'PIL', 'PyQt5', 'PyQt6', 'wx',
        'requests', 'pip', 'setuptools',
        'test', 'unittest',
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
    upx=True,
    upx_exclude=[],
    runtime_tmpdir=None,
    console=False,          # no black terminal window
    disable_windowed_traceback=False,
    argv_emulation=False,
    target_arch=None,
    codesign_identity=None,
    entitlements_file=None,
    # icon intentionally omitted — no .ico file in repo
)
