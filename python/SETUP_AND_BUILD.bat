@echo off
setlocal EnableDelayedExpansion
title SecureWipe — One-Click EXE Builder
color 0A
mode con: cols=70 lines=40

echo.
echo  ====================================================
echo     SecureWipe EXE Builder — One Click Setup
echo  ====================================================
echo.
echo  This will:
echo    1. Install Python (if not already installed)
echo    2. Install PyInstaller (automatically)
echo    3. Build SecureWipe.exe
echo    4. Put the finished file in READY_TO_UPLOAD\
echo.
echo  You just need to upload READY_TO_UPLOAD\SecureWipe.exe
echo  to your server when done.
echo.
pause

:: ── Step 1: Check / install Python ──────────────────────────
echo.
echo  [1/4] Checking for Python...

python --version >nul 2>&1
if not errorlevel 1 (
    for /f "tokens=*" %%i in ('python --version 2^>^&1') do set PYVER=%%i
    echo  [OK] !PYVER! found
    goto :python_ready
)

echo  [INFO] Python not found. Downloading installer...
echo.

:: Download Python 3.12 embedded installer using PowerShell
powershell -Command ^
  "Invoke-WebRequest -Uri 'https://www.python.org/ftp/python/3.12.8/python-3.12.8-amd64.exe' ^
   -OutFile '%TEMP%\python_installer.exe' -UseBasicParsing" 2>nul

if not exist "%TEMP%\python_installer.exe" (
    echo  [ERROR] Could not download Python installer.
    echo  Please install Python manually from https://python.org
    echo  Make sure to check "Add Python to PATH" during install.
    pause
    exit /b 1
)

echo  [INFO] Installing Python silently (this takes ~1 minute)...
"%TEMP%\python_installer.exe" /quiet InstallAllUsers=0 PrependPath=1 Include_test=0

:: Refresh PATH
for /f "tokens=2*" %%a in ('reg query "HKCU\Environment" /v PATH 2^>nul') do set "UPATH=%%b"
set "PATH=%PATH%;%UPATH%"

python --version >nul 2>&1
if errorlevel 1 (
    echo  [ERROR] Python install failed. Please install manually.
    start https://python.org/downloads
    pause
    exit /b 1
)
echo  [OK] Python installed successfully

:python_ready

:: ── Step 2: Install PyInstaller ──────────────────────────────
echo.
echo  [2/4] Installing PyInstaller...

pip install pyinstaller --quiet --disable-pip-version-check 2>nul
if errorlevel 1 (
    python -m pip install pyinstaller --quiet 2>nul
)

pyinstaller --version >nul 2>&1
if errorlevel 1 (
    echo  [ERROR] PyInstaller install failed. Check your internet connection.
    pause
    exit /b 1
)
echo  [OK] PyInstaller ready

:: ── Step 3: Verify ADB files present ─────────────────────────
echo.
echo  [3/4] Checking ADB files...

set MISSING=0
if not exist "adb.exe"          ( echo  [WARN] adb.exe missing         & set MISSING=1 )
if not exist "AdbWinApi.dll"    ( echo  [WARN] AdbWinApi.dll missing    & set MISSING=1 )
if not exist "AdbWinUsbApi.dll" ( echo  [WARN] AdbWinUsbApi.dll missing & set MISSING=1 )

if !MISSING!==1 (
    echo.
    echo  [ERROR] ADB files are missing from the python\ folder.
    echo  They should have come with the zip. Re-download and try again.
    pause
    exit /b 1
)
echo  [OK] ADB files present

:: ── Step 4: Build EXE ────────────────────────────────────────
echo.
echo  [4/4] Building SecureWipe.exe...
echo  (This takes 1-3 minutes)
echo.

if exist "dist\SecureWipe.exe" del /f /q "dist\SecureWipe.exe"
if exist "build" rmdir /s /q "build" 2>nul

pyinstaller SecureWipe.spec --clean --noconfirm --log-level WARN

if not exist "dist\SecureWipe.exe" (
    echo.
    echo  [ERROR] Build failed. Try running as Administrator.
    echo  Or run: pyinstaller SecureWipe.spec --clean
    pause
    exit /b 1
)

:: ── Done — move to READY_TO_UPLOAD ───────────────────────────
if not exist "READY_TO_UPLOAD" mkdir "READY_TO_UPLOAD"
copy /y "dist\SecureWipe.exe" "READY_TO_UPLOAD\SecureWipe.exe" >nul

echo.
echo  ====================================================
echo   SUCCESS!
echo  ====================================================
echo.

for %%F in ("READY_TO_UPLOAD\SecureWipe.exe") do (
    set /a SIZE=%%~zF / 1048576
    echo   File : READY_TO_UPLOAD\SecureWipe.exe
    echo   Size : ~!SIZE! MB
)

echo.
echo   NEXT STEP:
echo   Upload READY_TO_UPLOAD\SecureWipe.exe to your server
echo   at:  python/dist/SecureWipe.exe
echo.
echo  ====================================================
echo.

:: Open the folder automatically
explorer "READY_TO_UPLOAD"
pause
