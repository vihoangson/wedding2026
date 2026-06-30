# 📖 Hướng Dẫn Cấu Hình & Chỉnh Sửa Trang Thiệp Mời Cưới

## 🚀 Bắt Đầu Nhanh

### 1. **Chỉnh Sửa Thông Tin CƠ BẢN (config.php)**

Mở file `config.php` và sửa các biến sau:

```php
// Tên cô dâu & chủ rề
$bride_name = "Yến Nhi";           // ← Đổi tên cô dâu
$groom_name = "Hoàng Sơn";         // ← Đổi tên chủ rề
$bride_initial = "N";              // ← Chữ cái đầu cô dâu (hiển thị ở monogram)
$groom_initial = "S";              // ← Chữ cái đầu chủ rề (hiển thị ở monogram)

// Ngày cưới
$wedding_date = "2026-12-13";      // ← Đổi ngày (format: YYYY-MM-DD)
$wedding_time = "11:30";           // ← Đổi giờ (24h format)
$wedding_time_label = "Tiệc chính thức"; // ← Nhãn (có thể để nguyên)

// Địa điểm
$venue_name = "Đông Phương";       // ← Tên nhà hàng/sự kiện
$venue_location = "Quận 12, TP.HCM"; // ← Địa chỉ
$venue_full_name = "Trung Tâm Sự Kiện Đông Phương"; // ← Tên đầy đủ

// Tài khoản
$momo_account = "0987654321";      // ← Đổi số Momo
$bank_account = "0123456789";      // ← Đổi số ngân hàng

// Footer
$footer_initials = "M & T";        // ← Chữ viết tắt (vd: S & N cho Sơn & Nhi)
$footer_date = "14.02.2027";       // ← Ngày hiển thị ở footer

// Quote
$quote = '"Lời tuyên ngôn của bạn"'; // ← Đổi lời tuyên ngôn
```

---

### 2. **Quản Lý Lời Chúc (comments.json)**

Mở file `comments.json` và thêm/sửa/xóa lời chúc.

#### **Ví dụ thêm lời chúc mới:**

```json
{
  "comments": [
    {
      "id": 1,
      "name": "Nguyễn Văn A",
      "message": "Chúc 2 người hạnh phúc!",
      "active": true
    },
    {
      "id": 2,
      "name": "Trần Thị B",
      "message": "Lời chúc mới",
      "active": true
    },
    {
      "id": 3,
      "name": "Lê Văn C",
      "message": "Lời chúc này sẽ được ẩn",
      "active": false
    }
  ]
}
```

**Giải thích:**
- `id`: Số thứ tự (không trùng)
- `name`: Tên người gửi lời chúc
- `message`: Nội dung lời chúc
- `active`: `true` = hiển thị, `false` = ẩn

---

## 📝 Các Trường Hợp Sử Dụng Phổ Biến

### **Trường hợp 1: Đặt lịch cưới mới**

Sửa chỉ 3 dòng trong config.php:

```php
$wedding_date = "2027-06-15";    // Ngày cưới mới
$wedding_time = "18:00";          // Giờ cưới mới
$venue_name = "Nhà hàng ABC";    // Tên nhà hàng mới
```

**Kết quả:** Countdown timer, ngày tháng năm, giờ, địa điểm trên trang sẽ tự động cập nhật.

---

### **Trường hợp 2: Thay đổi tên cô dâu & chủ rề**

```php
$bride_name = "Tên cô dâu mới";
$groom_name = "Tên chủ rề mới";
$bride_initial = "T";
$groom_initial = "C";
$footer_initials = "C & T";  // Cập nhật footer
```

**Kết quả:** Tên sẽ hiển thị ở tiêu đề, monogram, và tất cả các nơi có tên.

---

### **Trường hợp 3: Ẩn một lời chúc không thích hợp**

Tìm lời chúc đó trong `comments.json` và đổi:

```json
"active": true   // ← Từ
// Thành:
"active": false  // ← Này
```

**Kết quả:** Lời chúc sẽ bị ẩn khỏi trang ngay lập tức.

---

### **Trường hợp 4: Cộng thêm ảnh gallery mới**

Mở `config.php`, tìm phần `$gallery_images` và thêm:

```php
$gallery_images = [
    // ... ảnh cũ ...
    [
        "url" => "https://example.com/anh-moi.jpg",
        "alt" => "Ảnh khoảnh khắc mới",
        "featured" => false  // true = ảnh lớn, false = ảnh nhỏ
    ]
];
```

---

### **Trường hợp 5: Thay đổi Google Maps**

1. Truy cập Google Maps
2. Click "Share" → "Embed a map"
3. Copy URL `iframe` src
4. Paste vào config.php:

```php
$google_maps_url = "https://www.google.com/maps/embed?pb=...";
```

---

## ⚙️ Các Biến Config Cần Chỉnh Sửa Thường Xuyên

| Biến | Mục Đích | Ví Dụ |
|------|----------|-------|
| `$bride_name` | Tên cô dâu | "Yến Nhi" |
| `$groom_name` | Tên chủ rề | "Hoàng Sơn" |
| `$wedding_date` | Ngày cưới | "2026-12-13" |
| `$wedding_time` | Giờ cưới | "11:30" |
| `$venue_name` | Tên nhà hàng | "Đông Phương" |
| `$momo_account` | Số Momo | "0987654321" |
| `$bank_account` | Số TK ngân hàng | "0123456789" |
| `$quote` | Lời tuyên ngôn | "Lời nói hay..." |
| `$footer_initials` | Viết tắt footer | "S & N" |

---

## 🔍 Ghi Chú Quan Trọng

### ✅ Đúng cách:
```php
$wedding_date = "2027-06-15";  // Format: YYYY-MM-DD ✓
$wedding_time = "18:00";        // Format: HH:MM (24h) ✓
$momo_account = "0987654321";  // Chuỗi số ✓
```

### ❌ Sai cách:
```php
$wedding_date = "15-06-2027";   // ✗ Sai format
$wedding_time = "6:00 PM";      // ✗ Sai format
$momo_account = 0987654321;     // ✗ Thiếu dấu ngoặc
```

---

## 🧪 Kiểm Tra Sau Khi Chỉnh Sửa

1. **Lưu file** (Ctrl+S)
2. **Refresh trang** (F5)
3. **Kiểm tra:**
   - ✓ Tên cô dâu, chủ rề hiển thị đúng
   - ✓ Ngày, giờ, địa điểm cập nhật
   - ✓ Countdown timer đếm ngược đúng
   - ✓ Lời chúc chỉ hiển thị những cái active = true

---

## 💾 Backup Dữ Liệu

Trước khi chỉnh sửa, **LUÔN backup**:

```
config.php → config.php.bak
comments.json → comments.json.bak
```

Sau đó mới chỉnh sửa. Nếu có lỗi, có thể restore lại.

---

## 🆘 Xử Lý Lỗi Thường Gặp

### Lỗi: Lời chúc không hiển thị

**Nguyên nhân:** Có thể `active` = false

**Cách sửa:**
1. Mở `comments.json`
2. Tìm lời chúc đó
3. Đổi `"active": false` → `"active": true`
4. Lưu & refresh trang

### Lỗi: Countdown timer không cập nhật

**Nguyên nhân:** Định dạng ngày sai

**Cách sửa:**
1. Mở `config.php`
2. Kiểm tra: `$wedding_date = "YYYY-MM-DD"` (đúng format không?)
3. Ví dụ: `"2027-06-15"` ✓

### Lỗi: Tên không hiển thị đúng

**Nguyên nhân:** Malformed biến

**Cách sửa:**
```php
$bride_name = "Yến Nhi";      // ✓ Đúng: có dấu ngoặc
$bride_name = Yến Nhi;        // ✗ Sai: thiếu dấu ngoặc
```

---

## 📞 Liên Hệ Hỗ Trợ

Nếu có vấn đề hoặc câu hỏi, hãy:
1. Kiểm tra README.md
2. Kiểm tra đầu dòng comment trong config.php
3. Sử dụng browser DevTools (F12) để debug

---

**Happy Wedding! 🎊**

