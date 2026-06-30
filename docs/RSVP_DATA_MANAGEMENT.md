# 📊 Hướng Dẫn Quản Lý & Xuất Dữ Liệu RSVP

## 🎯 Tổng Quan

Hướng dẫn này giúp bạn:
- Xem dữ liệu RSVP đã lưu
- Quản lý & lọc dữ liệu
- Xuất dữ liệu ra Excel, CSV
- Phân tích thống kê
- Backup dữ liệu

---

## 📂 Vị Trí Dữ Liệu

**File chứa dữ liệu:** `D:\xampp8\htdocs\vhosts\weddingpage\data.json`

---

## 🔍 Xem Dữ Liệu

### **1. Mở Trực Tiếp File (Đơn Giản)**

1. Mở file explorer
2. Truy cập: `D:\xampp8\htdocs\vhosts\weddingpage\data.json`
3. Mở bằng: Notepad, VS Code hoặc JSON Viewer

### **2. Xem Qua Browser (Tốt Nhất)**

Tạo file `api/view-data.php`:

```php
<?php
$dataFile = __DIR__ . '/../data.json';
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo 'File không tồn tại';
}
?>
```

Truy cập: `http://localhost/vhosts/weddingpage/api/view-data.php`

### **3. Format JSON Tẹp**

Nếu file `data.json` không dễ đọc, dùng tool online:
- **jsoncrack.com** - Hình ảnh hóa JSON
- **jsonformatter.org** - Format đẹp
- **jq** (command line) - Parse & query JSON

---

## 📈 Phân Tích Dữ Liệu

### **Thống Kê Cơ Bản**

```json
{
  "total_rsvp": 15,
  "statistcs": {
    "confirmed": 12,     // attend = "yes"
    "declined": 3,       // attend = "no"
    "total_guests": 25   // tổng số guests
  }
}
```

### **Cách Tính Manual**

1. **Tổng RSVP:** Xem trường `total_rsvp`
2. **Tham dự:** Đếm bao nhiêu `attend = "yes"`
3. **Vắng mặt:** Đếm bao nhiêu `attend = "no"`
4. **Tổng khách:** `SUM(guests)` cho tất cả items

---

## 📊 Xuất Dữ Liệu

### **Format 1: CSV (Excel)**

**File:** `api/export-csv.php`

```php
<?php
$dataFile = __DIR__ . '/../data.json';
$data = json_decode(file_get_contents($dataFile), true);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="rsvp_data.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Thời gian', 'Họ tên', 'Điện thoại', 'Số khách', 'Tham dự', 'Lời nhắn']);

foreach ($data['rsvp_list'] as $item) {
    fputcsv($output, [
        $item['id'],
        $item['timestamp'],
        $item['fullname'],
        $item['phone'] ?? '',
        $item['guests'],
        $item['attend'],
        $item['message'] ?? ''
    ]);
}

fclose($output);
?>
```

Truy cập: `http://localhost/vhosts/weddingpage/api/export-csv.php` → Tự động download

### **Format 2: Excel XLSX**

Cần cài library: `composer require phpoffice/phpspreadsheet`

```php
<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$dataFile = __DIR__ . '/../data.json';
$data = json_decode(file_get_contents($dataFile), true);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Thời gian');
$sheet->setCellValue('C1', 'Họ tên');
// ... set các cột khác

// Data
$row = 2;
foreach ($data['rsvp_list'] as $item) {
    $sheet->setCellValue('A' . $row, $item['id']);
    $sheet->setCellValue('B' . $row, $item['timestamp']);
    $sheet->setCellValue('C' . $row, $item['fullname']);
    // ... set các cột khác
    $row++;
}

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="rsvp_data.xlsx"');
$writer->save('php://output');
?>
```

### **Format 3: JSON (Backup)**

```bash
# Sao chép file
cp data.json data_backup_2026-06-30.json
```

---

## 🔧 Lọc & Tìm Kiếm Dữ Liệu

### **Lọc theo Tham Dự**

Để tìm tất cả người tham dự:

```json
// Filter: "attend" = "yes"
[
  {
    "fullname": "Nguyễn Văn A",
    "attend": "yes",
    "guests": 2
  },
  {
    "fullname": "Trần Thị B",
    "attend": "yes",
    "guests": 1
  }
]
```

### **Lọc theo Ngày**

Sử dụng DateTime để tìm RSVP trong khoảng thời gian:

```php
$startDate = new DateTime('2026-06-01');
$endDate = new DateTime('2026-06-30');

$filtered = array_filter($rsvpList, function($item) use ($startDate, $endDate) {
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $item['timestamp']);
    return $date >= $startDate && $date <= $endDate;
});
```

### **Tìm Kiếm theo Tên**

```php
$keyword = "Nguyễn";
$results = array_filter($rsvpList, function($item) use ($keyword) {
    return stripos($item['fullname'], $keyword) !== false;
});
```

---

## 📋 Tạo Dashboard Xem Dữ Liệu

File mới: `rsvp-dashboard.php`

```php
<?php
require_once 'config.php';

$dataFile = __DIR__ . '/data.json';
$data = json_decode(file_get_contents($dataFile), true) ?? ['rsvp_list' => []];

$rsvpList = $data['rsvp_list'] ?? [];
$totalRSVP = count($rsvpList);
$confirmed = count(array_filter($rsvpList, fn($x) => $x['attend'] === 'yes'));
$declined = count(array_filter($rsvpList, fn($x) => $x['attend'] === 'no'));
$totalGuests = array_sum(array_column($rsvpList, 'guests'));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard RSVP</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px; }
        .stat-box { background: #f0f0f0; padding: 15px; border-radius: 5px; text-align: center; }
        .stat-number { font-size: 24px; font-weight: bold; color: #c9a87c; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #c9a87c; color: white; }
        .yes { color: green; }
        .no { color: red; }
    </style>
</head>
<body>
    <h1>📊 Dashboard RSVP</h1>
    
    <div class="stats">
        <div class="stat-box">
            <div>Tổng RSVP</div>
            <div class="stat-number"><?php echo $totalRSVP; ?></div>
        </div>
        <div class="stat-box">
            <div>Tham Dự</div>
            <div class="stat-number"><?php echo $confirmed; ?></div>
        </div>
        <div class="stat-box">
            <div>Vắng Mặt</div>
            <div class="stat-number"><?php echo $declined; ?></div>
        </div>
        <div class="stat-box">
            <div>Tổng Khách</div>
            <div class="stat-number"><?php echo $totalGuests; ?></div>
        </div>
    </div>

    <h2>Danh Sách RSVP</h2>
    <table>
        <thead>
            <tr>
                <th>Thời gian</th>
                <th>Họ tên</th>
                <th>Điện thoại</th>
                <th>Số khách</th>
                <th>Tham dự</th>
                <th>Lời nhắn</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rsvpList as $rsvp): ?>
            <tr>
                <td><?php echo htmlspecialchars($rsvp['timestamp']); ?></td>
                <td><?php echo htmlspecialchars($rsvp['fullname']); ?></td>
                <td><?php echo htmlspecialchars($rsvp['phone'] ?? ''); ?></td>
                <td><?php echo $rsvp['guests']; ?></td>
                <td class="<?php echo $rsvp['attend']; ?>">
                    <?php echo $rsvp['attend'] === 'yes' ? '✓ Có' : '✗ Không'; ?>
                </td>
                <td><?php echo htmlspecialchars($rsvp['message'] ?? ''); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
```

Truy cập: `http://localhost/vhosts/weddingpage/rsvp-dashboard.php`

---

## 💾 Backup Dữ Liệu

### **Manual Backup**

```bash
# Windows PowerShell
Copy-Item data.json "data_backup_$(Get-Date -Format 'yyyy-MM-dd_HH-mm-ss').json"
```

### **Automatic Backup (Scheduled)**

Tạo `api/backup-data.php`:

```php
<?php
$dataFile = __DIR__ . '/../data.json';
$backupDir = __DIR__ . '/../backups/';

if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

$backupFile = $backupDir . 'data_' . date('Y-m-d_H-i-s') . '.json';
copy($dataFile, $backupFile);

echo json_encode([
    'success' => true,
    'message' => 'Backup thành công',
    'backup_file' => $backupFile
]);
?>
```

---

## 🔐 Bảo Vệ Dữ Liệu

### **1. Giới Hạn Truy Cập**

Tạo file `.htaccess` trong thư mục `api/`:

```apache
# Chỉ cho phép GET từ localhost
RewriteEngine On
RewriteCond %{REQUEST_METHOD} POST
RewriteCond %{REMOTE_ADDR} !^127\.0\.0\.1$
RewriteRule ^ - [F]
```

### **2. Mã Hóa Dữ Liệu Nhạy Cảm**

```php
// Xóa IP Addresss trước khi export
foreach ($rsvpList as &$item) {
    unset($item['ip_address']);
    unset($item['user_agent']);
}
```

### **3. Permission Files**

```bash
chmod 644 data.json              # Cho phép read/write
chmod 755 /path/to/weddingpage   # Directory
```

---

## 📧 Gửi Dữ Liệu qua Email

Tạo `api/email-report.php`:

```php
<?php
$dataFile = __DIR__ . '/../data.json';
$data = json_decode(file_get_contents($dataFile), true);

$rsvpList = $data['rsvp_list'] ?? [];
$confirmed = count(array_filter($rsvpList, fn($x) => $x['attend'] === 'yes'));

$emailBody = "
BÁOCÁO RSVP
================
Tổng RSVP: " . count($rsvpList) . "
Tham dự: $confirmed
Vắng mặt: " . (count($rsvpList) - $confirmed) . "

Danh sách:
";

foreach ($rsvpList as $item) {
    $emailBody .= "\n- " . $item['fullname'] . " (" . $item['guests'] . " khách)";
}

mail('your-email@example.com', 'RSVP Report', $emailBody);
?>
```

---

## 🏆 Best Practices

✅ **Backup thường xuyên** (hàng ngày)  
✅ **Verify dữ liệu** trước export  
✅ **Xóa dữ liệu nhạy cảm** nếu chia sẻ  
✅ **Giới hạn quyền truy cập** API  
✅ **Monitor file size** (data.json không quá lớn)  
✅ **Validate input** ở server (done ✓)  

---

## 🆘 Troubleshooting

**Q: File data.json biến mất?**
A: Restore từ backup, hoặc reset:
```json
{
  "total_rsvp": 0,
  "last_updated": "2026-06-30",
  "rsvp_list": []
}
```

**Q: Dữ liệu báng nước hoặc không đầy đủ?**
A: Kiểm tra quyền ghi & validation ở `api/save-rsvp.php`

**Q: Cần chuyển sang database?**
A: Dùng file `api/import-to-db.php` để migrate JSON → MySQL

---

**Lưu ý:** Dữ liệu RSVP là thông tin cá nhân, nên bảo vệ cẩn thận!


