#!/usr/bin/env bash
set -e
echo "============================================"
echo "  SecureWipe Desktop Tool — Build Script"
echo "============================================"

# Check Python3
if ! command -v python3 &>/dev/null; then
    echo "[ERROR] python3 not found. Install Python 3.8+ first."
    exit 1
fi
python3 --version

# Install PyInstaller
pip3 install pyinstaller --quiet

# Build
cd "$(dirname "$0")/.."
echo "[BUILD] Running PyInstaller..."
pyinstaller SecureWipe.spec --clean --noconfirm

echo ""
echo "============================================"
echo " SUCCESS! Binary at: dist/SecureWipe"
echo "============================================"
ls -lh dist/SecureWipe* 2>/dev/null || true
