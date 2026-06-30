# 🎊 Trang Thiệp Mời Cưới Động (Dynamic Wedding Invitation Page)

## ✨ Các đặc điểm chính

### 1. **Quản lý Cấu hình Tập trung (Config.php)**
Tất cả các biến cấu hình được quản lý trong file `config.php`:

- **Thông tin Cô dâu & Chủ rề**
  - `$bride_name`: Tên cô dâu
  - `$groom_name`: Tên chủ rề
  - `$bride_initial`: Chữ đầu cô dâu
  - `$groom_initial`: Chữ đầu chủ rề

- **Thông tin Đám cưới**
  - `$wedding_date`: Ngày cưới (format: YYYY-MM-DD)
  - `$wedding_time`: Giờ cưới
  - `$wedding_day_name`: Tên ngày trong tuần
  - `$wedding_time_label`: Nhãn giờ tiệc (vd: "Tiệc chính thức")

- **Địa điểm & Nhà hàng**
  - `$venue_name`: Tên điểm tiệc
  - `$venue_location`: Địa chỉ chi tiết
  - `$venue_full_name`: Tên đầy đủ địa điểm
  - `$google_maps_url`: URL Google Maps nhúng

- **Tài khoản thanh toán**
  - `$momo_account`: Số tài khoản Momo
  - `$bank_account`: Số tài khoản ngân hàng
  - `$bank_account_owner`: Chủ tài khoản

- **Thông tin khác**
  - `$rsvp_deadline`: Hạn xác nhận tham dự
  - `$quote`: Lời tuyên ngôn/trích dẫn
  - `$footer_initials`: Chữ viết tắt footer
  - `$footer_date`: Ngày ở footer
  - `$gallery_images`: Danh sách ảnh với cờ featured

### 2. **Quản lý Lời Chúc (comments.json)**
Danh sách lời chúc được lưu trữ trong file `comments.json` với cấu trúc:

```json
{
  "comments": [
    {
      "id": 1,
      "name": "Tên người gửi",
      "message": "Lời chúc",
      "active": true
    }
  ]
}
```

**Công dụng thuộc tính `active`:**
- `true`: Lời chúc sẽ được hiển thị trên trang
- `false`: Lời chúc sẽ bị ẩn (có thể dùng để quản lý)

### 3. **Sử dụng Biến Động**
Mọi dữ liệu trên trang được tạo động từ `config.php` và `comments.json`:
- Tên cô dâu, chú rề tự động update
- Ngày cưới tự động tính toán tên ngày trong tuần
- Danh sách lời chúc chỉ hiển thị những cái có `active: true`
- Tất cả thông tin liên hệ được update trực tiếp

---

## 📝 Cách Sử Dụng

### **Chỉnh sửa thông tin cơ bản:**

Mở file `config.php` và sửa các biến:

```php
$bride_name = "Yến Nhi";
$groom_name = "Hoàng Sơn";
$wedding_date = "2026-12-13";
$wedding_time = "11:30";
$venue_name = "Đông Phương";
$momo_account = "0987654321";
// ... và các biến khác
```

### **Thêm/Sửa Lời Chúc:**

Mở file `comments.json` và thêm hoặc sửa các lời chúc:

```json
{
  "comments": [
    {
      "id": 1,
      "name": "Người gửi",
      "message": "Lời chúc",
      "active": true
    }
  ]
}
```

**Để ẩn một lời chúc:** Đổi `"active": true` thành `"active": false`

### **Thêm/Sửa Ảnh Gallery:**

Trong `config.php`, chỉnh sửa mảng `$gallery_images`:

```php
$gallery_images = [
    [
        "url" => "https://link-ảnh.com/image.jpg",
        "alt" => "Mô tả ảnh",
        "featured" => true  // true cho ảnh lớn ở góc trái, false cho ảnh nhỏ
    ]
];
```

---

## 🗂️ Cấu Trúc Tệp

```
weddingpage/
├── index.php           📄 Trang chính (PHP)
├── index.html          📄 Bản sao cũ (có thể xóa)
├── config.php          ⚙️ File cấu hình
├── comments.json       📋 Danh sách lời chúc
├── style.css           🎨 Tệp CSS (không thay đổi)
├── script.js           ⚙️ File JavaScript (cập nhật)
└── deploy.sh           📜 Script triển khai
```

---

## 🔧 Tính Năng

✅ Thiệp mời động - mọi thông tin từ config.php
✅ Danh sách lời chúc từ JSON với bộ lọc active/inactive
✅ Countdown timer tự động từ ngày cưới
✅ Gallery ảnh responsive
✅ Form RSVP tương tác
✅ Thông tin tài khoản dễ sao chép
✅ Responsive design trên tất cả devices

---

## 📱 Trình duyệt Hỗ Trợ

- Chrome/Edge (mới nhất)
- Firefox (mới nhất)
- Safari (mới nhất)
- Mobile browsers

---

## ⚠️ Lưu Ý

1. Đảm bảo PHP được bật trên server
2. File `comments.json` phải có định dạng JSON hợp lệ
3. Sử dụng `htmlspecialchars()` để bảo vệ chống XSS
4. Kiểm tra file được load đúng bằng `file_exists()` trước khi đọc
5. Luôn backup dữ liệu trong `comments.json`

---

**Tạo bởi:** AI Assistant  
**Ngày cập nhật:** 2026-06-30  
**Phiên bản:** 2.0 (Dynamic PHP Version)

