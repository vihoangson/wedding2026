# Script xóa file .md cũ ở root
# Chạy: .\cleanup.ps1

Write-Host "🗑️ Đang xóa file .md cũ ở root..." -ForegroundColor Yellow

$filesToDelete = @(
    "API_SAVE_DATA_GUIDE.md",
    "COMPLETION_SUMMARY.md",
    "CONFIGURE_GUIDE.md",
    "FINAL_SUMMARY.md",
    "INDEX.md",
    "MIGRATION_GUIDE.md",
    "QUICK_START.md",
    "README.md",
    "RSVP_DATA_MANAGEMENT.md",
    "RSVP_SAVE_DATA_SUMMARY.md",
    "START_HERE.md"
)

$deleted = 0
$failed = 0

foreach ($file in $filesToDelete) {
    $filePath = Join-Path (Get-Location) $file
    if (Test-Path $filePath) {
        Remove-Item $filePath -Force
        Write-Host "✅ Đã xóa: $file" -ForegroundColor Green
        $deleted++
    } else {
        Write-Host "⚠️  File không tìm thấy: $file" -ForegroundColor Yellow
        $failed++
    }
}

Write-Host ""
Write-Host "📊 Kết quả:" -ForegroundColor Cyan
Write-Host "✅ Xóa thành công: $deleted file"
Write-Host "⚠️  Không tìm thấy: $failed file"
Write-Host ""
Write-Host "✨ Folder đã gọn gàng! Tất cả .md đều ở trong docs/ folder" -ForegroundColor Green

