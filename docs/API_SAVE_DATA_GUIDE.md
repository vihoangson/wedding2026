# 📊 Hướng Dẫn API Save RSVP Data

## 🎯 Tổng Quan

Hệ thống lưu trữ RSVP (Xác nhận tham dự) gồm:
1. **API Endpoint**: `api/save-rsvp.php` - Xử lý lưu dữ liệu
2. **Storage**: `data.json` - Lưu trữ dữ liệu RSVP
3. **Client Script**: `script.js` - Gửi dữ liệu từ form

---

## 📂 Cấu Trúc File

```
weddingpage/
├── api/
│   └── save-rsvp.php          🔧 API endpoint (MỚI)
├── data.json                    📊 Dữ liệu RSVP (MỚI)
├── index.php                    📄 Trang chính
├── script.js                    ⚙️ Updated - gửi AJAX
└── ... (các file khác)
```

---

## 🔧 API Endpoint: `api/save-rsvp.php`

### **Chức Năng**
- Nhận dữ liệu POST từ form
- Validate dữ liệu
- Lưu vào `data.json`
- Trả về response JSON

### **Request Format**

```json
POST /api/save-rsvp.php
Content-Type: application/json

{
  "fullname": "Nguyễn Văn A",
  "phone": "0987654321",
  "guests": 2,
  "attend": "yes",
  "message": "Chúc mừng!"
}
```

### **Response Format**

**Success (200):**
```json
{
  "success": true,
  "message": "Cảm ơn bạn! Xác nhận tham dự đã được ghi nhận.",
  "data": {
    "id": "rsvp_...",
    "fullname": "Nguyễn Văn A",
    "attend": "yes",
    "guests": 2
  }
}
```

**Error (400):**
```json
{
  "success": false,
  "message": "Vui lòng nhập họ và tên",
  "data": null
}
```

---

## 📊 Data Structure: `data.json`

### **Cấu Trúc Dữ liệu**

```json
{
  "total_rsvp": 5,
  "last_updated": "2026-06-30 15:30:45",
  "rsvp_list": [
    {
      "id": "rsvp_66a1b2c3d4e5f",
      "timestamp": "2026-06-30 15:30:45",
      "fullname": "Nguyễn Văn A",
      "phone": "0987654321",
      "guests": 2,
      "attend": "yes",
      "message": "Chúc 2 người hạnh phúc!",
      "ip_address": "192.168.1.100",
      "user_agent": "Mozilla/5.0 ..."
    },
    {
      "id": "rsvp_66a1b2c3d4e5g",
      "timestamp": "2026-06-30 16:45:30",
      "fullname": "Trần Thị B",
      "phone": "0912345678",
      "guests": 1,
      "attend": "no",
      "message": "Xin lỗi vì không thể tham dự",
      "ip_address": "192.168.1.101",
      "user_agent": "Mozilla/5.0 ..."
    }
  ]
}
```

### **Chi Tiết Các Property**

| Property | Kiểu | Mô Tả |
|----------|------|-------|
| `id` | string | ID duy nhất cho mỗi RSVP |
| `timestamp` | string | Thời gian gửi (YYYY-MM-DD HH:MM:SS) |
| `fullname` | string | Họ và tên (bắt buộc) |
| `phone` | string | Số điện thoại (optional) |
| `guests` | number | Số người tham dự (1-10) |
| `attend` | string | "yes" hoặc "no" |
| `message` | string | Lời nhắn từ khách (optional) |
| `ip_address` | string | IP người gửi |
| `user_agent` | string | Information trình duyệt |
| `total_rsvp` | number | Tổng số RSVP nhận được |
| `last_updated` | string | Lần cập nhật cuối |

---

## 🔐 Validation Rules

### **Fullname (Bắt Buộc)**
- ✅ Không để trống
- ✅ Tối thiểu 1 ký tự
- ✅ Escaped với `htmlspecialchars()`

### **Phone (Optional)**
- ✅ Nếu có thì phải hợp lệ: 9-15 ký tự
- ✅ Chỉ chấp nhận: số, dấu cộng, dấu gạch, khoảng trắng, ngoặc
- ✅ Ví dụ hợp lệ: `0987654321`, `+84 9 87654321`, `(098) 765-4321`

### **Guests (Bắt Buộc)**
- ✅ Phải là số nguyên
- ✅ Từ 1 đến 10
- ✅ Không được để trống

### **Attend (Bắt Buộc)**
- ✅ Chỉ chấp nhận: `"yes"` hoặc `"no"`

### **Message (Optional)**
- ✅ Có thể để trống hoặc nhập tối đa ~500 ký tự
- ✅ Escaped với `htmlspecialchars()`

---

## 🛡️ Bảo Mật

### **Các Biện Pháp Bảo Mật**

1. **Input Sanitization**
   ```php
   htmlspecialchars($input)  // Chống XSS injection
   trim($input)              // Loại bỏ khoảng trắng thừa
   ```

2. **Validation**
   - Regex validation cho số điện thoại
   - Range check cho guests (1-10)
   - Type casting: `intval()`, `trim()`

3. **File Locking**
   ```php
   file_put_contents($file, $data, LOCK_EX)  // Prevent race condition
   ```

4. **CORS & Headers**
   - Response header: `Content-Type: application/json`
   - Chỉ chấp nhận POST request

---

## 📝 Các Property Đầy Đủ Được Lưu Trữ

### **Từ Form (User Input)**
✅ `fullname` - Họ và tên  
✅ `phone` - Số điện thoại  
✅ `guests` - Số người tham dự  
✅ `attend` - Tham dự (yes/no)  
✅ `message` - Lời nhắn

### **Từ Server (Auto)**
✅ `id` - ID duy nhất (`uniqid()`)  
✅ `timestamp` - Thời gian gửi  
✅ `ip_address` - IP người gửi  
✅ `user_agent` - Thông tin trình duyệt  
✅ `total_rsvp` - Tổng số RSVP  
✅ `last_updated` - Lần cập nhật cuối

---

## 🚀 Cách Sử Dụng

### **1. Frontend - Gửi Dữ Liệu**

Khi form được submit, JavaScript tự động:

```javascript
fetch('api/save-rsvp.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(formData)
})
.then(response => response.json())
.then(result => {
    if (result.success) {
        // Show success message
    } else {
        // Show error
    }
})
```

### **2. Backend - Xử Lý & Lưu**

File `api/save-rsvp.php`:
1. Validate input
2. Sanitize data
3. Load `data.json`
4. Thêm RSVP mới
5. Lưu file
6. Return JSON response

### **3. Truy Vấn Dữ Liệu**

Để xem dữ liệu RSVP, đơn giản mở file `data.json`:

```bash
cat data.json | python -m json.tool
```

---

## ✅ Checklist Triển Khai

- [ ] Folder `api/` đã được tạo
- [ ] File `api/save-rsvp.php` đã được tạo
- [ ] File `data.json` đã được tạo (ban đầu trống)
- [ ] File `script.js` đã được cập nhật (AJAX calls)
- [ ] Quyền ghi cho folder weddingpage (755 trở lên)
- [ ] PHP error_reporting có bật không (để debug)
- [ ] Test form trên localhost

---

## 🧪 Cách Test

### **1. Test trên Browser**
- Truy cập: `http://localhost/vhosts/weddingpage/index.php`
- Điền form RSVP
- Click "Gửi xác nhận"
- Kiểm tra console (F12)
- Kiểm tra `data.json` có được cập nhật không

### **2. Test với cURL**
```bash
curl -X POST http://localhost/vhosts/weddingpage/api/save-rsvp.php \
  -H "Content-Type: application/json" \
  -d '{
    "fullname": "Test Name",
    "phone": "0987654321",
    "guests": 2,
    "attend": "yes",
    "message": "Test message"
  }'
```

### **3. Kiểm tra File Permissions**
```bash
ls -la data.json
# Nên có quyền: -rw-r--r-- (644) trở lên
```

---

## 🐛 Xử Lý Lỗi Thường Gặp

### **Lỗi: "Không thể lưu dữ liệu"**
- **Nguyên nhân:** Quyền ghi file không đủ
- **Cách sửa:** 
  ```bash
  chmod 644 data.json
  chmod 755 /path/to/weddingpage
  ```

### **Lỗi: JSON Parse Error**
- **Nguyên nhân:** `data.json` bị corrupt
- **Cách sửa:** Reset file:
  ```json
  {
    "total_rsvp": 0,
    "last_updated": "2026-06-30 00:00:00",
    "rsvp_list": []
  }
  ```

### **Lỗi: Fetch Error**
- **Nguyên nhân:** Path API không đúng hoặc PHP không bật
- **Cách sửa:** Kiểm tra:
  - URL đúng không: `api/save-rsvp.php`
  - PHP extension bật không
  - Browser DevTools → Network tab

### **Lỗi: Validation Failed**
- **Nguyên nhân:** Dữ liệu không hợp lệ
- **Cách sửa:** Check message error từ API

---

## 📖 Ví Dụ Data.json Sau Khi Có Dữ Liệu

```json
{
  "total_rsvp": 2,
  "last_updated": "2026-06-30 17:00:00",
  "rsvp_list": [
    {
      "id": "rsvp_66a1b2c3d4e5f1a0b1c",
      "timestamp": "2026-06-30 15:30:45",
      "fullname": "Nguyễn Văn A",
      "phone": "0987654321",
      "guests": 2,
      "attend": "yes",
      "message": "Chúc mừng ngày trọng đại!",
      "ip_address": "192.168.1.100",
      "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
    },
    {
      "id": "rsvp_66a1b2c3d4e5f1a0b1d",
      "timestamp": "2026-06-30 16:45:30",
      "fullname": "Trần Thị B",
      "phone": "",
      "guests": 1,
      "attend": "no",
      "message": "Xin phép vắng mặt do bận công việc",
      "ip_address": "192.168.1.101",
      "user_agent": "Mozilla/5.0 (iPhone; CPU iPhone OS)"
    }
  ]
}
```

---

## 📊 Thống Kê Từ Data.json

Bạn có thể tính toán:
- **Tổng RSVP:** `total_rsvp`
- **Tham dự:** Đếm `attend = "yes"`
- **Vắng mặt:** Đếm `attend = "no"`
- **Tổng khách:** Cộng tất cả `guests`
- **Messages:** Danh sách lời chúc từ `message` field

---

## 🔄 Quy Trình Hoàn Chỉnh

```
User Form Submit
    ↓
JavaScript Validation
    ↓
Fetch POST to api/save-rsvp.php
    ↓
Server Validation & Sanitization
    ↓
Load data.json
    ↓
Append New RSVP
    ↓
Calculate Statistics
    ↓
Save to data.json (with LOCK_EX)
    ↓
Return JSON Response
    ↓
JavaScript Show Success Message
    ↓
Confetti Animation
    ↓
Reset Form
```

---

**Catatan:** File `data.json` sẽ tự động cập nhật mỗi lần có submission. Dữ liệu được lưu trữ định dạng JSON để dễ dàng backup, chuyển đổi hoặc import vào database sau này.


