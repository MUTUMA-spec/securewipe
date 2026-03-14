@echo off
title SecureWipe — Build EXE
color 0A
echo.
echo  ============================================
echo    SecureWipe Desktop Tool — EXE Builder
echo  ============================================
echo.

:: Check Python
python --version >nul 2>&1
if errorlevel 1 (
    echo  [ERROR] Python not found.
    echo  Please install Python from https://python.org
    echo  Make sure to check "Add Python to PATH" during install.
    pause
    exit /b 1
)

echo  [OK] Python found
python --version

:: Install PyInstaller if missing
pip show pyinstaller >nul 2>&1
if errorlevel 1 (
    echo.
    echo  [INFO] Installing PyInstaller...
    pip install pyinstaller
)

echo  [OK] PyInstaller ready
echo.

:: Copy ADB files to python/ folder if not already there
if not exist "..\adb.exe" (
    echo  [WARN] adb.exe not found in python folder.
    echo  Make sure adb.exe, AdbWinApi.dll, AdbWinUsbApi.dll
    echo  are in the python\ folder before building.
    echo.
)

:: Build
echo  [BUILD] Running PyInstaller...
cd ..
pyinstaller SecureWipe.spec --clean --noconfirm

if errorlevel 1 (
    echo.
    echo  [ERROR] Build failed. Check the output above.
    pause
    exit /b 1
)

echo.
echo  ============================================
echo   SUCCESS! Your EXE is at:
echo   dist\SecureWipe.exe
echo  ============================================
echo.
echo  File size:
for %%F in ("dist\SecureWipe.exe") do echo  %%~zF bytes
echo.
pause
