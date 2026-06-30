# ⚡ Quick Start - Hướng Dẫn Nhanh

## 🚀 Bắt Đầu Trong 5 Phút

### **1. Đã Chuẩn Bị Gì?**

✅ Trang thiệp mời PHP động  
✅ Quản lý cấu hình tập trung  
✅ Lưu RSVP vào `data.json`  
✅ Xem & xuất dữ liệu  

---

## 📋 Danh Sách Công Việc

### **Bước 1: Cấu Hình Thông Tin (2 phút)**

Mở: `config.php`

```php
// Sửa dòng này:
$bride_name = "Tên cô dâu";
$groom_name = "Tên chủ rề";
$wedding_date = "YYYY-MM-DD";
$wedding_time = "HH:MM";
$venue_name = "Nhà hàng";
$momo_account = "Số Momo";
$bank_account = "Số ngân hàng";
```

**Lưu file → Done! ✓**

---

### **Bước 2: Thêm Lời Chúc (1 phút)**

Mở: `comments.json`

Thêm:
```json
{
  "id": 9,
  "name": "Tên khách",
  "message": "Lời chúc",
  "active": true
}
```

**Lưu file → Done! ✓**

---

### **Bước 3: Test Trang (2 phút)**

1. Mở: `http://localhost/vhosts/weddingpage/index.php`
2. Kiểm tra:
   - ✓ Tên hiển thị đúng?
   - ✓ Ngày, giờ, địa điểm đúng?
   - ✓ Lời chúc hiển thị?
3. Điền form RSVP test
4. Click "Gửi xác nhận"
5. Kiểm tra dữ liệu: `http://localhost/vhosts/weddingpage/api/view-data.php`

---

## 🎯 URL Cần Biết

```
📄 Trang mời:        http://localhost/vhosts/weddingpage/index.php
📊 Xem RSVP:         http://localhost/vhosts/weddingpage/api/view-data.php
📥 Xuất CSV:         http://localhost/vhosts/weddingpage/api/export-csv.php
📋 File dữ liệu:     data.json (trong thư mục chính)
⚙️ Cấu hình:         config.php
💬 Lời chúc:         comments.json
```

---

## ✨ Những Gì Hoạt Động

| Chức Năng | URL | Trạng Thái |
|-----------|-----|-----------|
| Xem trang mời | `/index.php` | ✅ Động |
| Quản lý biến | `/config.php` | ✅ Tập trung |
| Lời chúc | `/comments.json` | ✅ Lọc active/inactive |
| Submit RSVP | Form → API | ✅ AJAX |
| Lưu dữ liệu | `/api/save-rsvp.php` | ✅ Validation + Save |
| Xem dữ liệu | `/api/view-data.php` | ✅ HTML/JSON/CSV |
| Xuất CSV | `/api/export-csv.php` | ✅ Excel |

---

## 🔑 Các Property Được Lưu

**Từ Khách (User Input):**
- `fullname` - Họ tên
- `phone` - Số điện thoại
- `guests` - Số người tham dự
- `attend` - yes/no
- `message` - Lời nhắn

**Tự Động Thêm (Server):**
- `id` - ID unique
- `timestamp` - Thời gian gửi
- `ip_address` - IP khách
- `user_agent` - Trình duyệt

---

## 📖 Hướng Dẫn Chi Tiết

Nếu cần chi tiết, đọc:

1. **README.md** - Tổng quan
2. **CONFIGURE_GUIDE.md** - Cấu hình chi tiết
3. **API_SAVE_DATA_GUIDE.md** - API chi tiết
4. **RSVP_DATA_MANAGEMENT.md** - Quản lý dữ liệu
5. **COMPLETION_SUMMARY.md** - Tất cả file mới

---

## ✅ Kiểm Tra Hoàn Tất

- [ ] File `config.php` - Cập nhật thông tin
- [ ] File `comments.json` - Thêm lời chúc
- [ ] File `api/save-rsvp.php` - Tồn tại
- [ ] File `data.json` - Tồn tại
- [ ] File `script.js` - Cập nhật AJAX
- [ ] Test form - Gửi dữ liệu
- [ ] Xem `view-data.php` - Dữ liệu xuất hiện

---

## 🐛 Lỗi Thường Gặp

**Dữ liệu không lưu:**
- Kiểm tra: Quyền ghi `data.json`
- Fix: `chmod 644 data.json`

**Form không gửi:**
- Kiểm tra: Browser console (F12)
- Fix: Đảm bảo PHP bật

**data.json bị lỗi:**
- Reset file:
```json
{"total_rsvp":0,"last_updated":"2026-06-30","rsvp_list":[]}
```

---

## 🎉 Bạn Đã Sẵn Sàng!

✨ **Trang cưới của bạn đã hoàn toàn động và sẵn sàng nhận RSVP!**

---

**Happy Wedding! 💕**

