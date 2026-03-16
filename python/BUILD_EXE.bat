@echo off
title SecureWipe — Build Standalone EXE
color 0A
echo.
echo  =====================================================
echo    SecureWipe — Build Standalone EXE
echo  =====================================================
echo.

:: ── Check Python ──────────────────────────────────────────
python --version >nul 2>&1
if errorlevel 1 (
    echo  [ERROR] Python not found.
    echo  Install Python 3.11 from https://python.org
    echo  Tick "Add Python to PATH" during install.
    pause & exit /b 1
)
echo  [OK] Python:
python --version

:: ── Install PyInstaller ────────────────────────────────────
echo.
echo  [INFO] Installing PyInstaller ...
python -m pip install pyinstaller --quiet --upgrade
if errorlevel 1 (
    echo  [ERROR] pip failed. Check internet connection.
    pause & exit /b 1
)
echo  [OK] PyInstaller ready.

:: ── Check ADB folder ──────────────────────────────────────
echo.
if not exist "adb_binaries\adb.exe" (
    echo  [ERROR] adb_binaries\adb.exe not found.
    echo.
    echo  Create a folder called adb_binaries here and put inside it:
    echo    adb.exe
    echo    AdbWinApi.dll
    echo    AdbWinUsbApi.dll
    echo.
    echo  Download from:
    echo  https://dl.google.com/android/repository/platform-tools-latest-windows.zip
    pause & exit /b 1
)
echo  [OK] adb_binaries folder found.

:: ── Build ──────────────────────────────────────────────────
echo.
echo  [BUILD] Running PyInstaller ...
echo.

python -m PyInstaller ^
    --onefile ^
    --windowed ^
    --name SecureWipe ^
    --add-data "adb_binaries;adb_binaries" ^
    --hidden-import tkinter ^
    --hidden-import tkinter.ttk ^
    --hidden-import tkinter.scrolledtext ^
    --hidden-import tkinter.messagebox ^
    --hidden-import urllib.request ^
    --hidden-import urllib.error ^
    --hidden-import json ^
    --hidden-import subprocess ^
    --hidden-import threading ^
    --hidden-import platform ^
    --hidden-import webbrowser ^
    --exclude-module matplotlib ^
    --exclude-module numpy ^
    --exclude-module pandas ^
    --exclude-module requests ^
    --clean ^
    --noconfirm ^
    secure_wipe_tool.py

if errorlevel 1 (
    echo.
    echo  [ERROR] Build failed. See output above.
    pause & exit /b 1
)

if not exist "dist\SecureWipe.exe" (
    echo  [ERROR] SecureWipe.exe not found after build.
    pause & exit /b 1
)

:: ── Report ─────────────────────────────────────────────────
echo.
echo  =====================================================
echo   SUCCESS!
echo.
for %%F in ("dist\SecureWipe.exe") do (
    set /a SIZE=%%~zF/1048576
    echo   File : dist\SecureWipe.exe
    echo   Size : approximately %%~zF bytes
)
echo.
echo   Next step:
echo   Upload dist\SecureWipe.exe to your server at:
echo   htdocs/python/dist/SecureWipe.exe
echo.
echo   The Downloads page detects it automatically.
echo  =====================================================
echo.
pause
