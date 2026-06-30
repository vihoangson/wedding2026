# Dashboard Tiệc Cưới - Hướng dẫn sử dụng

## 🎊 Giới thiệu
Dashboard Tiệc Cưới là công cụ quản lý toàn bộ thông tin khách mời, RSVP và bình luận từ trang thiệp mời cưới.

## 📋 Tính năng

✅ **Đăng nhập bảo mật** - Bảo vệ dashboard bằng mật khẩu
✅ **Quản lý RSVP** - Xem danh sách khách xác nhận tham dự/không tham dự
✅ **Quản lý bình luận** - Xem toàn bộ bình luận từ khách
✅ **Thống kê chi tiết** - Hiển thị số liệu thống kê (Tổng RSVP, Tham dự, Không tham dự, Tổng khách)
✅ **Giao diện chuyên nghiệp** - Design hiện đại, responsive trên toàn bộ device
✅ **Collapse/Expand** - Ẩn hiện các bảng dữ liệu theo nhu cầu
✅ **Auto-refresh** - Tự động cập nhật dữ liệu mỗi 10 giây

## 🚀 Cách sử dụng

### Truy cập Dashboard
1. Mở URL: `http://your-domain.com/dashboard/index.php`
2. Nhập mật khẩu (mặc định: `admin123`)
3. Nhấn "Đăng Nhập"

### Xem dữ liệu
- **Danh sách RSVP**: Hiển thị tất cả khách xác nhận RSVP với chi tiết (tên, điện thoại, số khách, trạng thái tham dự, lời nhắn)
- **Danh sách Bình Luận**: Hiển thị tất cả bình luận từ khách mời
- **Thống kê**: Ở phía trên hiển thị 4 card thống kê

### Ẩn/Hiện bảng dữ liệu
- Nhấn vào tiêu đề bảng "Danh sách RSVP" hoặc "Danh sách Bình Luận" để ẩn/hiện bảng
- Mũi tên ↑ sẽ xoay khi ẩn/hiện

### Đăng xuất
- Nhấn nút "Đăng xuất" ở góc trên phải để thoát khỏi dashboard

## 🔐 Bảo mật

### Thay đổi mật khẩu

1. Mở file `index.php` trong thư mục `dashboard`
2. Tìm dòng:
   ```php
   $DASHBOARD_PASSWORD = 'admin123'; // Thay đổi mật khẩu này!
   ```
3. Sửa `'admin123'` thành mật khẩu của bạn. Ví dụ:
   ```php
   $DASHBOARD_PASSWORD = 'my_secure_password_123';
   ```
4. Lưu file

**⚠️ Lưu ý quan trọng:** 
- Sử dụng mật khẩu mạnh (ít nhất 8 ký tự, kết hợp chữ hoa, chữ thường, số)
- Thay đổi mật khẩu mặc định ngay lần đầu tiên
- Nếu quên mật khẩu, yêu cầu quản trị viên server sửa lại file

## 📊 Cấu trúc dữ liệu

### RSVP Data (data.json)
```json
{
  "total_rsvp": 5,
  "last_updated": "2026-06-30 10:30:00",
  "rsvp_list": [
    {
      "id": "rsvp_1",
      "timestamp": "2026-06-28 14:30:00",
      "fullname": "Nguyễn Văn A",
      "phone": "0901234567",
      "guests": 2,
      "attend": "yes",
      "message": "Sẽ tham dự cùng gia đình",
      "ip_address": "192.168.1.1",
      "user_agent": "Mozilla/5.0"
    }
  ]
}
```

### Comments Data (comments.json)
```json
{
  "total_comments": 8,
  "last_updated": "2026-06-30 12:00:00",
  "comments": [
    {
      "id": 1,
      "name": "Nguyễn Văn A",
      "message": "Chúc 2 người hạnh phúc bên nhau!",
      "active": true
    }
  ]
}
```

## 🔄 Cập nhật dữ liệu

Dashboard sẽ **tự động cập nhật** dữ liệu từ file:
- `data.json` - RSVP từ form xác nhận
- `comments.json` - Bình luận từ khách

Dữ liệu sẽ được refresh mỗi 10 giây tự động. Bạn không cần làm gì khác.

## 📁 Cấu trúc file

```
dashboard/
├── index.php              # File chính (PHP backend + HTML)
├── dashboard.js           # File JavaScript
├── style.css              # File CSS
├── .htaccess              # File bảo mật (Apache)
└── README.md              # File hướng dẫn này
```

## 🛠 Yêu cầu hệ thống

- PHP 7.0+
- Apache hoặc servidor web tương thích
- File `data.json` và `comments.json` ở thư mục gốc (`../`)
- Browser hiện đại (Chrome, Firefox, Safari, Edge)

## 📱 Tương thích

✅ Desktop (Windows, Mac, Linux)
✅ Tablet (iPad, Android)
✅ Mobile (iPhone, Android)

## 🐛 Xử lý sự cố

### Dashboard không tải dữ liệu
- Kiểm tra đường dẫn file `data.json` và `comments.json`
- Kiểm tra quyền file (permissions) của PHP
- Xem console browser (F12) để xem lỗi

### Mật khẩu bị quên
- Yêu cầu quản trị viên server sửa file `index.php`
- Hoặc xóa session cookie của browser

### Lỗi 401 Unauthorized
- Cần đăng nhập trước
- Kiểm tra PHP session đã bật chưa

## 📞 Hỗ trợ

Nếu gặp vấn đề, vui lòng kiểm tra:
1. Tệp `index.php` có tồn tại không
2. Thư mục `dashboard` có quyền ghi không
3. File `data.json` và `comments.json` có tồn tại không
4. PHP session đã bật chưa (session.save_path có hợp lệ không)

---

**Version:** 1.0  
**Last Updated:** 2026-06-30

