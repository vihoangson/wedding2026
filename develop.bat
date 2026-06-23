@echo off
REM ================================================================
REM Wedding Page Vue.js 3 - Development Server Script
REM ================================================================

echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║   💍 Wedding Page - Development Server                     ║
echo ║   Starting Vue.js dev server...                            ║
echo ╚════════════════════════════════════════════════════════════╝
echo.

REM Check if node_modules exists
if not exist "node_modules" (
    echo ❌ Dependencies not installed!
    echo.
    echo Please run: npm install
    echo Or double-click: install.bat
    echo.
    pause
    exit /b 1
)

echo [✓] Starting development server...
echo [✓] Browser will open automatically
echo.
echo 📝 Tips:
echo   - Edit files in src/ folder
echo   - Changes will auto-reload
echo   - Press CTRL+C to stop server
echo.

npm run dev

pause

