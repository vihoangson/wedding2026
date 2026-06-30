# 🔧 Hướng Dẫn Kiểm Tra Dashboard

## ✅ Điều kiện tiên quyết

Trước khi sử dụng dashboard, hãy kiểm tra:

### 1. Kiểm tra file cấu hình
```bash
# Kiểm tra các file cần thiết
- ✓ dashboard/index.php (file chính)
- ✓ dashboard/dashboard.js (xử lý dữ liệu)
- ✓ dashboard/style.css (giao diện)
- ✓ data.json (dữ liệu RSVP)
- ✓ comments.json (bình luận)
```

### 2. Kiểm tra quyền file
```bash
# Trên Linux/Mac, chạy:
chmod 755 dashboard/
chmod 644 dashboard/*.php
chmod 644 dashboard/*.js
chmod 644 dashboard/*.css
chmod 644 data.json
chmod 644 comments.json
```

## 🚀 Cách truy cập Dashboard

### Phương pháp 1: Truy cập trực tiếp
```
http://your-domain.com/dashboard/
hoặc
http://your-domain.com/dashboard/index.php
```

### Phương pháp 2: Test API
```
http://your-domain.com/dashboard/test.php
```
File này sẽ hiển thị:
- ✓ Phiên bản PHP
- ✓ Trạng thái Session
- ✓ Các file tồn tại hay không
- ✓ Thông tin test login

## 📝 Bước login

1. **Mở URL:** `http://your-domain.com/dashboard/index.php`
2. **Bạn sẽ thấy** màn hình đăng nhập với:
   - Title: "💗 Dashboard"
   - Input: Nhập mật khẩu
   - Button: Nút hiển thị/ẩn mật khẩu
   - Submit: Nút "Đăng Nhập"

3. **Nhập mật khẩu mặc định:** `admin123`
4. **Nhấn "Đăng Nhập"** hoặc nhấn Enter

## 🎉 Dashboard sau khi login

Khi login thành công, bạn sẽ thấy:

### Stats (Thống kê)
- 📊 **Tổng RSVP** - Tổng số khách xác nhận
- ✅ **Tham Dự** - Số khách xác nhận tham dự
- ❌ **Không Tham Dự** - Số khách từ chối
- 👥 **Tổng Khách** - Tổng số người sẽ dự tiệc

### Danh sách RSVP
Bảng hiển thị:
- Thời gian xác nhận
- Họ tên khách
- Số điện thoại
- Số lượng khách
- Trạng thái (Tham dự/Không)
- Lời nhắn

### Danh sách Bình Luận
Bảng hiển thị:
- ID bình luận
- Tên người bình luận
- Nội dung bình luận
- Trạng thái (Active/Inactive)

## 🔐 Thay đổi mật khẩu

### Cách 1: Sửa file trực tiếp
1. Mở file `dashboard/index.php`
2. Tìm dòng 8:
   ```php
   $DASHBOARD_PASSWORD = 'admin123';
   ```
3. Sửa thành:
   ```php
   $DASHBOARD_PASSWORD = 'mat_khau_moi_cua_ban';
   ```
4. Lưu file

### Cách 2: Sử dụng cPanel/FTP
- Upload file `index.php` đã sửa
- Hoặc chỉnh sửa trên cPanel File Manager

## 🐛 Xử lý Lỗi

### Lỗi 1: "Mật khẩu không chính xác" khi nhập đúng
**Nguyên nhân:** File index.php chưa được cập nhật hoặc session PHP bị lỗi
**Giải pháp:**
```bash
# 1. Kiểm tra PHP session
php -r "echo ini_get('session.save_path');"

# 2. Kiểm tra config PHP
php -r "phpinfo();"

# 3. Xóa cache browser
- Nhấn Ctrl+Shift+Delete (hoặc Cmd+Shift+Delete trên Mac)
- Xóa cookies và cached files
```

### Lỗi 2: "Lỗi kết nối" hoặc không tải dữ liệu
**Nguyên nhân:** File JSON không tồn tại hoặc PHP không thể đọc
**Giải pháp:**
```bash
# 1. Kiểm tra file data.json
ls -la data.json
# Kết quả như sau là OK:
# -rw-r--r-- ... data.json

# 2. Kiểm tra nội dung JSON
cat data.json | python -m json.tool

# 3. Kiểm tra quyền đọc
chmod 644 data.json
chmod 644 comments.json
```

### Lỗi 3: Bảng dữ liệu trống
**Nguyên nhân:** data.json rỗng hoặc format sai
**Giải pháp:**
- Kiểm tra file `data.json` có dữ liệu không
- Xác nhận JSON syntax đúng không
- Kiểm tra xem có người xác nhận RSVP chưa

### Lỗi 4: "401 Unauthorized"
**Nguyên nhân:** Chưa login hoặc session hết hạn
**Giải pháp:**
- Làm mới trang (F5)
- Xóa cookies (Ctrl+Shift+Delete)
- Đăng nhập lại

## 📊 Test dữ liệu

### Test RSVP data
File data.json phải có format:
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
      "message": "Lời nhắn",
      "ip_address": "...",
      "user_agent": "..."
    }
  ]
}
```

### Test Comments data
File comments.json phải có format:
```json
{
  "total_comments": 8,
  "last_updated": "2026-06-30 12:00:00",
  "comments": [
    {
      "id": 1,
      "name": "Nguyễn Văn A",
      "message": "Chúc mừng!",
      "active": true
    }
  ]
}
```

## 🔄 Auto-refresh

Dashboard tự động cập nhật dữ liệu mỗi **10 giây**.
- Không cần làm mới trang
- Dữ liệu mới sẽ xuất hiện tự động

## 💡 Mẹo sử dụng

### Ẩn/Hiện bảng
- Nhấn vào tiêu đề "Danh Sách RSVP" hoặc "Danh Sách Bình Luận"
- Mũi tên sẽ quay để biểu thị trạng thái

### Xem thông tin chi tiết
- Rê chuột qua dòng trong bảng để highlight
- Xem đầy đủ thông tin ở các cột

### Export dữ liệu
- Dữ liệu được tự động lưu trong file JSON
- Có thể sao chép hoặc tải về

## 📋 Checklist trước khi live

- ✅ Thay đổi mật khẩu từ `admin123` sang mật khẩu mạnh
- ✅ Kiểm tra các file có quyền đọc-ghi đúng không
- ✅ Test login thành công
- ✅ Test xem dữ liệu hiển thị đúng không
- ✅ Kiểm tra trên các device (desktop, tablet, mobile)
- ✅ Xóa file test.php (hoặc giữ lại nếu cần debug)

## 📞 Hỗ trợ

Nếu gặp lỗi:
1. Kiểm tra `test.php` để xem thông tin hệ thống
2. Xem browser console (F12) để xem lỗi JavaScript
3. Kiểm tra file logs của server (Apache error.log, PHP error.log)
4. Đảm bảo PHP version 7.0+

---

**Version:** 1.0  
**Last Updated:** 2026-06-30

