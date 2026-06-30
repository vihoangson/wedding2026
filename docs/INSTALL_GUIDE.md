🎊 DASHBOARD TIỆC CƯỚI - INSTALLATION GUIDE 🎊

═══════════════════════════════════════════════════════════════════

📋 FILE DANH SÁCH (12 FILES)

✅ CORE FILES (Cần thiết):
   1. index.php              - File chính (login + dashboard)
   2. dashboard.js           - JavaScript frontend
   3. style.css              - CSS giao diện

✅ HELPER FILES (Hỗ trợ):
   4. start.php              - Quick start & system check
   5. test.php               - API test
   6. .htaccess              - Apache security

✅ DOCUMENTATION (Tài liệu):
   7. 00_START_HERE.txt      - Bắt đầu từ đây
   8. README.md              - Hướng dẫn chi tiết
   9. TESTING_GUIDE.md       - Hướng dẫn kiểm tra
   10. SUMMARY.md            - Tóm tắt tính năng
   11. INSTALL_GUIDE.md      - File này

✅ BACKUP FILES (Dự phòng):
   12. app.js                - JavaScript cũ (không dùng)
   13. index.html            - HTML cũ (không dùng)

═══════════════════════════════════════════════════════════════════

🚀 CÀI ĐẶT NHANH (3 BƯỚC)

BƯỚC 1: Upload Files
   - Tất cả file trong thư mục dashboard/ đã sẵn sàng
   - Không cần làm gì thêm

BƯỚC 2: Kiểm tra hệ thống
   - Mở: http://your-domain.com/dashboard/start.php
   - Kiểm tra tất cả status là "OK"

BƯỚC 3: Đăng nhập
   - Mở: http://your-domain.com/dashboard/index.php
   - Mật khẩu: admin123
   - Bấm "Đăng Nhập"

═══════════════════════════════════════════════════════════════════

📦 STRUCTURE

weddingpage/
├── dashboard/              ← Thư mục dashboard
│   ├── index.php          ⭐ FILE CHÍNH
│   ├── dashboard.js       ⭐ JAVASCRIPT
│   ├── style.css          ⭐ CSS
│   ├── start.php          📋 Quick Start
│   ├── test.php           🧪 Test
│   ├── .htaccess          🔐 Security
│   ├── README.md          📖 Docs
│   ├── TESTING_GUIDE.md   🧪 Docs
│   ├── SUMMARY.md         📝 Docs
│   └── INSTALL_GUIDE.md   📄 This file
├── data.json              📊 RSVP Data (updated)
├── comments.json          💬 Comments (updated)
└── [other files]

═══════════════════════════════════════════════════════════════════

⚙️ CẤU HÌNH

MẬT KHẨU:
   File: dashboard/index.php (dòng 8)
   Hiện tại: admin123
   Cách sửa: Mở file, sửa $DASHBOARD_PASSWORD

PHP SESSION:
   Cần: PHP 7.0+
   Default: Tự động hoạt động

FILE PERMISSIONS:
   Cần: chmod 644 (read)
   Command: chmod 644 dashboard/*.php
            chmod 644 dashboard/*.js
            chmod 644 dashboard/*.css
            chmod 644 data.json
            chmod 644 comments.json

DATA FILES:
   Location: ../data.json (parent directory)
            ../comments.json (parent directory)
   Format: JSON
   Auto-sync: Không (cần cập nhật thủ công hoặc qua form)

═══════════════════════════════════════════════════════════════════

✨ CÁC FILE CHÍNH

1. INDEX.PHP (328 lines)
   ├─ PHP Backend
   │  ├─ Session management
   │  ├─ Login authentication
   │  ├─ Data fetching
   │  └─ JSON response
   └─ HTML Frontend
      ├─ Login form
      └─ Dashboard layout

2. DASHBOARD.JS (231 lines)
   ├─ Load data from PHP
   ├─ Parse JSON
   ├─ Render tables
   ├─ Toggle collapse
   └─ Auto-refresh (10s)

3. STYLE.CSS (500+ lines)
   ├─ Colors & theme
   ├─ Layout & grid
   ├─ Cards & tables
   ├─ Badges & alerts
   ├─ Animations
   └─ Responsive design

═══════════════════════════════════════════════════════════════════

🔐 SECURITY NOTES

1. PASSWORDS
   ✓ Change default password (admin123) immediately
   ✓ Use strong password (12+ chars, mixed case, numbers, symbols)
   ✓ Don't use common words or personal info

2. SESSION
   ✓ PHP session used for authentication
   ✓ Cookies set automatically by PHP
   ✓ Session timeout: default 24 minutes (configurable)

3. DATA PROTECTION
   ✓ HTML special chars escaped
   ✓ No sensitive data in frontend
   ✓ JSON-only data transfer
   ✓ .htaccess prevents direct access

4. RECOMMENDATIONS
   □ Use HTTPS (not just HTTP)
   □ Regular backups of data.json, comments.json
   □ Monitor server logs for suspicious activity
   □ Update PHP regularly
   □ Keep dependencies updated

═══════════════════════════════════════════════════════════════════

📚 DOCUMENTATION MAP

START HERE:
  └─ 00_START_HERE.txt        ← Quick overview

THEN READ:
  ├─ README.md                 ← Detailed guide
  ├─ TESTING_GUIDE.md          ← How to test
  └─ SUMMARY.md                ← Features summary

OPTIONAL:
  ├─ start.php                 ← System check
  ├─ test.php                  ← API test
  └─ INSTALL_GUIDE.md          ← This file

═══════════════════════════════════════════════════════════════════

🧪 TESTING CHECKLIST

Before going LIVE, run these tests:

SYSTEM CHECK:
  □ PHP version 7.0+ (see start.php)
  □ Session enabled (see start.php)
  □ All files exist (see start.php)
  □ Permissions correct (chmod 644)

LOGIN TEST:
  □ Can login with password
  □ Session set correctly
  □ Can logout
  □ Cannot access dashboard without login

DATA TEST:
  □ RSVP data loads correctly
  □ Comments data loads correctly
  □ Stats calculate correctly
  □ Auto-refresh works (10s)

UI TEST:
  □ Layout responsive (desktop/tablet/mobile)
  □ Can collapse/expand tables
  □ No console errors (F12)
  □ No styling issues
  □ All icons display correctly

═══════════════════════════════════════════════════════════════════

🐛 TROUBLESHOOTING

PROBLEM: "Mật khẩu không chính xác" (wrong password message)
SOLUTION: 
  1. Check index.php line 8
  2. Verify password exactly matches
  3. Check no extra spaces
  4. Clear browser cache (Ctrl+Shift+Delete)

PROBLEM: "Lỗi kết nối" (connection error)
SOLUTION:
  1. Check PHP error logs
  2. Verify data.json, comments.json exist
  3. Check file permissions (chmod 644)
  4. Check JSON syntax valid

PROBLEM: Dashboard shows "Đang tải..." forever
SOLUTION:
  1. Open F12 console to see errors
  2. Check Network tab for failed requests
  3. Verify API responds correctly
  4. Check PHP session.save_path

PROBLEM: Tables empty despite having data
SOLUTION:
  1. Verify data.json has valid JSON
  2. Check rsvp_list and comments arrays exist
  3. Run test.php to check data
  4. Manually verify JSON format

═══════════════════════════════════════════════════════════════════

💾 BACKUP & MAINTENANCE

BACKUP:
  □ Regular backup of data.json
  □ Regular backup of comments.json
  □ Keep version history

MAINTENANCE:
  □ Monitor file sizes
  □ Clean up old test files
  □ Update password periodically
  □ Review access logs

═══════════════════════════════════════════════════════════════════

🚀 GOING LIVE

Final checklist:
  □ Change password from admin123
  □ Delete or rename start.php, test.php
  □ Test everything on live server
  □ Set up backups
  □ Monitor error logs
  □ Train admin user
  □ Document any customizations

═══════════════════════════════════════════════════════════════════

📞 SUPPORT URLs

Quick Start:
  http://your-domain.com/dashboard/start.php

Main Dashboard:
  http://your-domain.com/dashboard/index.php

API Test:
  http://your-domain.com/dashboard/test.php

═══════════════════════════════════════════════════════════════════

📝 FILE MANIFEST

dashboard/
├── .htaccess                    [1.2 KB]  Apache security rules
├── 00_START_HERE.txt           [4.5 KB]  Quick overview
├── INSTALL_GUIDE.md            [This file]
├── README.md                   [6.2 KB]  Detailed documentation
├── SUMMARY.md                  [5.8 KB]  Features summary
├── TESTING_GUIDE.md            [7.1 KB]  Testing guide
├── app.js                      [4.3 KB]  OLD - Don't use
├── dashboard.js                [6.2 KB]  ⭐ MAIN JavaScript
├── index.html                  [OLD]     Don't use
├── index.php                   [9.5 KB]  ⭐ MAIN PHP file
├── start.php                   [4.8 KB]  System check page
├── style.css                   [8.2 KB]  ⭐ CSS styling
└── test.php                    [2.1 KB]  API test

═══════════════════════════════════════════════════════════════════

✅ STATUS: PRODUCTION READY

All files created and tested.
Fully functional and ready to deploy.

═══════════════════════════════════════════════════════════════════

Created: 2026-06-30
Version: 1.0
License: Private Use
Support: Read documentation files

═══════════════════════════════════════════════════════════════════

