# ⚡ HƯỚNG DẪN NHANH - TEST FORM & DASHBOARD

## 🎯 Vấn đề Đã Sửa

❌ **Trước:** Form nhập thành công nhưng comments không hiển thị ở dashboard
✅ **Bây giờ:** Comments được lưu đúng và hiển thị ở cả form & dashboard

---

## 📱 Các Bước Test

### **1️⃣ Xem Dữ Liệu Hiện Tại**
```
Truy cập: http://localhost/vhosts/weddingpage/view-data.php
```
- Xem RSVP data (3 entries test)
- Xem Comments data (2 entries test)
- Kiểm tra file paths

### **2️⃣ Test Form Submit**
```
Truy cập: http://localhost/vhosts/weddingpage/test-submit.php
```
- Điền form test
- Click "Gửi Test"
- Kiểm tra response success/error
- Comments sẽ được lưu với `active: false` (cần phê duyệt)

### **3️⃣ Xem Dashboard**
```
Truy cập: http://localhost/vhosts/weddingpage/dashboard/index.php
Mật khẩu: admin123
```
- Xem stats (RSVP count, confirmed, declined)
- Xem RSVP table (danh sách người xác nhận)
- Xem Comments table (danh sách bình luận - giờ đã hiển thị! ✨)

### **4️⃣ Xem Trang Chính (Thiệp Mời)**
```
Truy cập: http://localhost/vhosts/weddingpage/
```
- Scroll xuống section "Lời chúc của khách mời"
- Sẽ hiển thị comments có `active=true`
- Hiện tại: 1 comment test (Nguyễn Văn A)

---

## 🔍 Lỗi Đã Sửa (Chi Tiết)

### **Lỗi #1: Path File Không Nhất Quán**
```
❌ index.php đọc: /weddingpage/comments.json (không tồn tại)
✅ Sửa thành: /weddingpage/data/comments.json
```

### **Lỗi #2: JSON Structure**
```
❌ Lưu: 'comments_list' → 'sender_name' → 'status'
✅ Sửa: 'comments' → 'name' → 'active'
```

### **Lỗi #3: Data Type**
```
❌ Status: 'inactive' (string)
✅ Active: false (boolean)
```

---

## 📊 Test Data Có Sẵn

### RSVP Data (3 entries)
| Tên | Khách | Tham Dự | Note |
|-----|-------|---------|------|
| Nguyễn Văn A | 2 | Yes | ✅ |
| Trần Thị B | 1 | No | ❌ |
| Lê Minh C | 3 | Yes | ✅ |

### Comments Data (2 entries)
| Tên | Status | Hiển Thị | Note |
|-----|--------|---------|------|
| Nguyễn Văn A | Active | Trang Chính + Dashboard | ✅ |
| Trần Thị B | Inactive | Chỉ Dashboard | 👁️ |

---

## ✨ Tính Năng

- ✅ Form trang chính nhập được dữ liệu
- ✅ API save-rsvp.php lưu đúng vào `/data/` folder
- ✅ Dashboard hiển thị danh sách comments
- ✅ Trang chính hiển thị lời chúc (active=true)
- ✅ Test data có sẵn để kiểm tra
- ✅ File view-data.php để debug dữ liệu

---

## 💡 Tip Debugging

Nếu comments vẫn không hiển thị:

1. **Kiểm tra file đã lưu:**
   ```
   Truy cập: view-data.php → Check comments data
   ```

2. **Kiểm tra active status:**
   ```
   Comments phải có: "active": true
   Nếu false, sẽ không hiển thị trên trang chính
   ```

3. **Kiểm tra browser console:**
   ```
   Mở: F12 → Console → Xem lỗi gì
   ```

4. **Kiểm tra file permissions:**
   ```
   /data/ folder cần write permission
   Nếu lỗi: lệnh chmod 755 /data
   ```

---

## 📢 Những Điều Cần Biết

1. **Form bên ngoài** (trang chính) nhập dữ liệu → lưu vào `/data/data.json` & `/data/comments.json`
2. **Dashboard** đọc dữ liệu từ `/data/` folder → hiển thị tất cả comments
3. **Trang chính** (thiệp mời) hiển thị chỉ comments có `active=true`
4. **Comments mặc định** là inactive (cần admin phê duyệt) - nếu muốn auto-show thì thay `active: false` → `active: true` trong save-rsvp.php

---

## 🚀 Bước Tiếp Theo

**Optional:** Thêm tính năng admin phê duyệt comments trực tiếp trong dashboard
- Button "Approve" / "Reject" comments
- Thay đổi `active` status
- Real-time update

---

**Tất cả mọi thứ đã sẵn sàng để test! 🎉**

