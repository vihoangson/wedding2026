@echo off
REM ================================================================
REM Wedding Page Vue.js 3 - Build for Production Script
REM ================================================================

echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║   💍 Wedding Page - Production Build                       ║
echo ║   Creating optimized build...                              ║
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

REM Check if dist folder exists and delete it
if exist "dist" (
    echo [1/3] Cleaning old build...
    rmdir /s /q dist
    echo ✓ Old build removed
)

echo.
echo [2/3] Building for production...
call npm run build

if errorlevel 1 (
    echo.
    echo ❌ Build failed!
    pause
    exit /b 1
)

echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║   ✅ Build Complete!                                       ║
echo ╚════════════════════════════════════════════════════════════╝
echo.
echo 📦 Output folder: dist/
echo.
echo 🚀 Deployment options:
echo.
echo   1. XAMPP/Apache (Local):
echo      Copy dist/* to: htdocs/vhosts/weddingpage/
echo      Access: http://localhost/vhosts/weddingpage/
echo.
echo   2. Netlify:
echo      Drag & drop dist folder
echo.
echo   3. Vercel:
echo      Connect repository
echo.
echo   4. GitHub Pages:
echo      Push dist to gh-pages branch
echo.
echo 💡 To preview build locally:
echo      npm run preview
echo.

pause

