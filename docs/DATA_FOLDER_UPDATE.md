📁 DATA FOLDER RESTRUCTURING - HOÀN THÀNH ✅

═══════════════════════════════════════════════════════════════════

📋 NHỮNG GÌ ĐÃ THAY ĐỔI

1️⃣ FOLDER STRUCTURE
   ❌ Cũ: data.json, comments.json ở root
   ✅ Mới: data/data.json, data/comments.json

2️⃣ FILE ĐƯỢC TẠO
   ✅ data/.gitkeep          - Để keep folder trong git
   ✅ data/.gitignore        - To ignore JSON files but keep .gitkeep
   ✅ data/data.json         - Mô file (chứa dữ liệu RSVP)
   ✅ data/comments.json     - Mô file (chứa bình luận)

3️⃣ PHP SCRIPTS ĐƯỢC UPDATE
   ✅ dashboard/index.php    - Tự tạo file/folder nếu chưa có
   ✅ api/save-rsvp.php      - Update path để dùng data/ folder
   ✅ api/view-data.php      - Update path để dùng data/ folder
   ✅ api/export-csv.php     - Update path để dùng data/ folder
   ✅ dashboard/start.php    - Update paths để check từ data/ folder

4️⃣ AUTO-CREATE LOGIC
   ✅ Nếu chưa có folder data/ → tạo tự động
   ✅ Nếu chưa có data.json → tạo file mô với dữ liệu rỗng
   ✅ Nếu chưa có comments.json → tạo file mô với dữ liệu rỗng

═══════════════════════════════════════════════════════════════════

📁 NEW FOLDER STRUCTURE

weddingpage/
├── data/                      ← NEW FOLDER
│   ├── .gitkeep              ✅ Keep folder in git
│   ├── .gitignore            ✅ Ignore *.json files
│   ├── data.json             ✅ RSVP data (auto-created)
│   └── comments.json         ✅ Comments data (auto-created)
├── api/
│   ├── save-rsvp.php         ✅ Updated
│   ├── view-data.php         ✅ Updated
│   └── export-csv.php        ✅ Updated
├── dashboard/
│   ├── index.php             ✅ Updated
│   ├── start.php             ✅ Updated
│   ├── dashboard.js
│   └── style.css
├── data.json                 ← OLD (kept for backup)
├── comments.json             ← OLD (kept for backup)
└── [other files]

═══════════════════════════════════════════════════════════════════

🔧 KỸ THUẬT

index.php NEW LOGIC:
```php
// Set data dir
$DATA_DIR = __DIR__ . '/../data';
$DATA_FILE = $DATA_DIR . '/data.json';

// Create folder if not exists
if (!is_dir($DATA_DIR)) {
    mkdir($DATA_DIR, 0755, true);
}

// Create file if not exists
if (!file_exists($DATA_FILE)) {
    createDefaultDataFile($DATA_FILE, 'data');
}
```

═══════════════════════════════════════════════════════════════════

✅ VERIFY CHANGES

1. Check folder structure:
   http://your-domain.com/dashboard/start.php
   
   ✅ Should show:
   - data/ (folder) ... OK
   - data/.gitkeep ... OK
   - data/data.json ... OK (auto-created)
   - data/comments.json ... OK (auto-created)

2. Login to dashboard:
   http://your-domain.com/dashboard/index.php
   Password: admin123
   
   ✅ Everything should work same as before

3. Submit RSVP form:
   - Data should be saved to data/data.json
   - Comments should be saved to data/comments.json

═══════════════════════════════════════════════════════════════════

📝 GIT IGNORE EXPLANATION

data/.gitignore:
```
*                    # Ignore all files
!.gitkeep            # But keep .gitkeep
!.gitignore          # And keep .gitignore itself
```

Điều này đảm bảo:
- ✅ Folder data/ được tracked (vì có .gitkeep)
- ✅ File JSON (data.json, comments.json) không tracked
- ✅ Mỗi developer có file JSON riêng của họ
- ✅ Tránh conflict khi merge

═══════════════════════════════════════════════════════════════════

🚀 CÁCH DÙNG

1. PRODUCTION (Deployment)
   - Folder data/ sẽ được commit
   - File JSON sẽ được ignore
   - Server có thể tạo file JSON lần đầu

2. DEVELOPMENT (Local)
   - Folder data/ sẽ được commit
   - Mỗi lần chạy, files sẽ auto-create nếu cần
   - Có thể commit JSON files cho development samples

3. AUTO-CREATE
   - Khi access dashboard/index.php lần đầu
   - Script sẽ check folder data/ existence
   - Script sẽ check/create data.json
   - Script sẽ check/create comments.json
   - No manual setup needed!

═══════════════════════════════════════════════════════════════════

⚠️ IMPORTANT NOTES

1. OLD FILES (Backup)
   - data.json (root) → KEPT for compatibility
   - comments.json (root) → KEPT for compatibility
   
   Scripts now use data/ folder, old root files are ignored.
   
   You can delete root files if you want, but recommend keeping
   them as backup first.

2. GIT MIGRATION
   If you have git repo:
   ```bash
   # Add new folder
   git add data/.gitkeep data/.gitignore
   
   # Update scripts to use new paths
   git add api/*.php dashboard/index.php dashboard/start.php
   
   # Optional: remove old root files from tracking
   git rm --cached data.json comments.json
   echo "data.json" >> .gitignore
   echo "comments.json" >> .gitignore
   git add .gitignore
   ```

3. FILE PERMISSIONS
   Make sure data/ folder is writable:
   ```bash
   chmod 755 data/
   chmod 644 data/.gitkeep
   chmod 644 data/.gitignore
   ```

═══════════════════════════════════════════════════════════════════

✨ BENEFITS

✅ Clean folder structure
✅ All data in one folder
✅ Better organization
✅ Auto-create functionality
✅ No manual setup needed
✅ Git-friendly (separate data from config)
✅ Development-friendly (JSON ignored)
✅ Production-safe (folder structure tracked)

═══════════════════════════════════════════════════════════════════

🎯 STATUS

Restructuring: ✅ COMPLETE
Auto-create: ✅ WORKING
Git setup: ✅ READY

All scripts updated and tested!

═══════════════════════════════════════════════════════════════════

Created: 2026-06-30
Version: 2.0 (with data folder)

