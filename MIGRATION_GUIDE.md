# 🔄 Chuyển Đổi từ HTML sang PHP - Hướng Dẫn

## 📌 Những Gì Đã Thay Đổi

### **TRƯỚC (HTML tĩnh):**
```html
<h1 class="names">Hoàng Sơn<span class="amp">&amp;</span>Yến Nhi</h1>
```
- Tên cứng mã, không thể đổi
- Phải chỉnh sửa HTML trực tiếp

### **NGÀY NAY (PHP động):**
```php
<h1 class="names"><?php echo htmlspecialchars($groom_name); ?>
    <span class="amp">&amp;</span>
    <?php echo htmlspecialchars($bride_name); ?>
</h1>
```
- Tên lấy từ `config.php`
- Chỉnh sửa config.php là xong, không cần sửa HTML

---

## ✨ Lợi Ích của Phiên Bản PHP

| Tính Năng | HTML | PHP |
|-----------|------|-----|
| Quản lý biến tập trung | ❌ | ✅ |
| Tự động cập nhật | ❌ | ✅ |
| Lọc lời chúc active/inactive | ❌ | ✅ |
| Động gallery | ❌ | ✅ |
| Bảo vệ XSS | ❌ | ✅ |
| Dễ bảo trì | ❌ | ✅ |

---

## 📂 Cấu Trúc File Mới

```
weddingpage/
├── index.php                 📄 Trang chính (PHP) - ĐÃI THAY THẾ
├── index.html                📄 Cũ (có thể xóa)
├── config.php                ⚙️ Quản lý config (MỚI)
├── comments.json             📋 Lời chúc (MỚI)
├── style.css                 🎨 CSS (không đổi)
├── script.js                 ⚙️ JS (cập nhật nhẹ)
├── README.md                 📖 Hướng dẫn chung (MỚI)
├── CONFIGURE_GUIDE.md        📖 Hướng dẫn chi tiết (MỚI)
└── MIGRATION_GUIDE.md        📖 File này
```

---

## 🔑 Các File Mới Tạo

### 1. **config.php** (Tệp Cấu Hình)

Chứa tất cả các biến cấu hình:

```php
<?php
$bride_name = "Yến Nhi";
$groom_name = "Hoàng Sơn";
$wedding_date = "2026-12-13";
$wedding_time = "11:30";
$venue_name = "Đông Phương";
$momo_account = "0987654321";
// ... Tất cả các biến khác
?>
```

**Sử dụng:** Mở file này và chỉnh sửa các biến để thay đổi thông tin trang.

---

### 2. **comments.json** (Danh Sách Lời Chúc)

Lưu trữ tất cả lời chúc dưới dạng JSON:

```json
{
  "comments": [
    {
      "id": 1,
      "name": "Nguyễn Văn A",
      "message": "Chúc 2 người hạnh phúc!",
      "active": true
    }
  ]
}
```

**Sử dụng:** 
- Thêm/sửa/xóa lời chúc
- Đặt `active: true` để hiển thị
- Đặt `active: false` để ẩn

---

### 3. **index.php** (Trang Chính)

Phiên bản PHP mới của `index.html`:

```php
<?php
// Include config
require_once 'config.php';

// Hàm lấy lời chúc
function getActiveComments() { ... }

// Hàm tính ngày
function getDayName($dateString) { ... }
?>
<!DOCTYPE html>
<html>
<!-- Sử dụng các biến PHP -->
<h1><?php echo htmlspecialchars($groom_name); ?></h1>
</html>
```

**Tính năng:**
- Tự động include config.php
- Lọc lời chúc có `active = true`
- Tính toán ngày trong tuần tự động
- Bảo vệ chống XSS với `htmlspecialchars()`

---

### 4. **script.js** (Cập Nhật Nhẹ)

Chỉ 1 dòng thay đổi:

**TRƯỚC:**
```javascript
const weddingDate = new Date('2026-12-13T11:30:00').getTime();
```

**NGÀY NAY:**
```javascript
const weddingDateString = typeof WEDDING_DATE !== 'undefined' ? WEDDING_DATE : '2026-12-13T11:30:00';
const weddingDate = new Date(weddingDateString).getTime();
```

**Tác dụng:** Lấy ngày cưới từ PHP thay vì hardcode.

---

## 🚀 Cách Chuyển Sang Phiên Bản PHP

### **Bước 1: Backup**
```bash
cp index.html index.html.bak
cp config.php config.php.bak
```

### **Bước 2: Đảm bảo PHP kích hoạt**
Kiểm tra xem Apache đã kích hoạt PHP Module không:
- Kiểm tra file `httpd.conf`
- Tìm dòng: `LoadModule php7_module modules/libphp7.so`
- Nếu chưa có, thêm dòng đó

### **Bước 3: Sử dụng index.php**
- Xóa hoặc rename `index.html` thành `index.html.bak`
- Sử dụng `index.php` như file chính

### **Bước 4: Cập Nhật Config**
Mở `config.php` và chỉnh sửa thông tin:
```php
$bride_name = "Tên cô dâu";
$groom_name = "Tên chủ rề";
$wedding_date = "YYYY-MM-DD";
// ...
```

### **Bước 5: Quản Lý Lời Chúc**
Mở `comments.json` và thêm/sửa lời chúc:
```json
{
  "id": 1,
  "name": "Tên",
  "message": "Lời chúc",
  "active": true
}
```

---

## 🔐 Bảo Mật

### **Tính Năng Bảo Mật Mới:**

1. **htmlspecialchars()** - Chống XSS injection
```php
// Sai (nguy hiểm):
<h1><?php echo $groom_name; ?></h1>

// Đúng (an toàn):
<h1><?php echo htmlspecialchars($groom_name); ?></h1>
```

2. **file_exists()** - Kiểm tra file tồn tại
```php
if (!file_exists($commentsFile)) {
    return [];  // Trả lại rỗng nếu file không tồn tại
}
```

3. **json_decode()** - Parse JSON an toàn
```php
$data = json_decode($jsonContent, true);
if ($data === null) {
    // JSON không hợp lệ
}
```

---

## 📋 Danh Sách Kiểm Tra

**Trước khi deploy:**

- [ ] Sửa thông tin cô dâu, chủ rề trong config.php
- [ ] Cập nhật ngày cưới
- [ ] Cập nhật địa điểm & nhà hàng
- [ ] Thêm lời chúc vào comments.json
- [ ] Đặt `active: true/false` cho lời chúc
- [ ] Kiểm tra PHP đã bật
- [ ] Test trang web hoạt động
- [ ] Kiểm tra countdown timer
- [ ] Kiểm tra lời chúc hiển thị

---

## ✅ Cách Kiểm Tra Hoạt Động

### **Kiểm tra 1: Tên hiển thị đúng**
```
Kiểm tra: Tên cô dâu & chủ rề có trong tiêu đề trang?
```

### **Kiểm tra 2: Ngày cưới đúng**
```
Kiểm tra: Countdown timer đếm về ngày cưới?
```

### **Kiểm tra 3: Lời chúc**
```
Kiểm tra: Toàn bộ lời chúc có active:true có hiển thị?
Kiểm tra: Lời chúc có active:false không hiển thị?
```

### **Kiểm tra 4: Browser DevTools**
```
1. Mở F12
2. Xem Console có lỗi gì không?
3. Xem Network có file nào 404 không?
```

---

## 🎯 Ưu Điểm So Với HTML Tĩnh

| Vấn Đề | HTML | PHP |
|--------|------|-----|
| Cập nhật tên từ HTML | Phải chỉnh sửa HTML | Chỉnh sửa config |
| Ẩn lời chúc không phù hợp | Phải xóa từ HTML | Chỉ cần `active: false` |
| Thêm ảnh | Phải viết code HTML | `$gallery_images` array |
| Phòng chống XSS | Không | ✅ Có `htmlspecialchars()` |
| Tính tái sử dụng | Không | ✅ Hàm `getActiveComments()` |
| Dễ bảo trì | Khó | ✅ Dễ |

---

## 📝 Ghi Chú Cuối Cùng

1. **Cần PHP 7.0+** - Sử dụng syntax mới
2. **JSON phải hợp lệ** - Dùng JSON validator online
3. **Luôn backup** - Trước mỗi lần chỉnh sửa
4. **Test sau khi chỉnh sửa** - Refresh trang chuẩn từ (Ctrl+Shift+R)

---

**Chúc mừng bạn đã nâng cấp lên phiên bản PHP! 🎊**

