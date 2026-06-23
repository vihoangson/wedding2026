@echo off
REM ================================================================
REM Wedding Page Vue.js 3 - Installation Script for Windows
REM ================================================================

echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║   💍 Wedding Page Vue.js 3 Installation Script             ║
echo ║   Windows PowerShell/CMD                                   ║
echo ╚════════════════════════════════════════════════════════════╝
echo.

REM Check if Node.js is installed
echo [1/5] Checking Node.js installation...
node --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Node.js not found!
    echo Please install Node.js from: https://nodejs.org/
    pause
    exit /b 1
) else (
    echo ✅ Node.js found:
    node --version
)

echo.
echo [2/5] Checking npm installation...
npm --version >nul 2>&1
if errorlevel 1 (
    echo ❌ npm not found!
    exit /b 1
) else (
    echo ✅ npm found:
    npm --version
)

echo.
echo [3/5] Installing dependencies...
echo This may take a few minutes...
call npm install
if errorlevel 1 (
    echo ❌ npm install failed!
    pause
    exit /b 1
) else (
    echo ✅ Dependencies installed successfully!
)

echo.
echo [4/5] Creating environment file...
if not exist ".env.local" (
    copy .env.example .env.local >nul
    echo ✅ .env.local created
) else (
    echo ✅ .env.local already exists
)

echo.
echo [5/5] Setup complete!
echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║   ✅ Installation Complete!                                ║
echo ╚════════════════════════════════════════════════════════════╝
echo.
echo 📚 Next Steps:
echo.
echo   1. Start development server:
echo      npm run dev
echo.
echo   2. Open browser and go to:
echo      http://localhost:5173
echo.
echo   3. For production build:
echo      npm run build
echo.
echo 📖 Documentation:
echo   - SETUP_GUIDE.md - Installation guide
echo   - README_VUE.md - Vue.js setup details
echo   - STRUCTURE.txt - Project structure
echo.
echo 💡 Tips:
echo   - Edit components in src/ folder
echo   - Changes auto-reload in dev mode
echo   - Use F12 to open DevTools
echo.

pause

