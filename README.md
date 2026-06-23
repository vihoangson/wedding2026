# 💍 Wedding Landing Page - Trang Giới Thiệu Lễ Cưới

Đây là một trang web giới thiệu lễ cưới hiện đại, đẹp mắt, được xây dựng bằng HTML5, CSS3, Bootstrap 5 và JavaScript.

## 🌸 Theme Màu Hồng Lãng Mạn

Trang này sử dụng **tông màu hồng (Pink Theme)** sang trọng:
- 💗 **Màu hồng chủ đạo** (#ff69b4)
- 🌸 **Màu hồng nhạt** (#fff5f9)
- 🎀 **Màu hồng sâu** (#ff1493)

Với các hiệu ứng:
- ✨ Gradient animations
- 💫 Floating & heartbeat effects
- 🌟 Glow effects
- 🎨 Modern design

## ✨ Tính Năng

- 🎨 **Giao diện đẹp mắt** - Thiết kế hiện đại với gradient, animations
- 📱 **Responsive** - Tương thích với mọi kích thước màn hình (mobile, tablet, desktop)
- 🎭 **Bootstrap Framework** - Sử dụng Bootstrap 5 để xây dựng UI
- 💫 **Animations** - Các hiệu ứng fade-in, scroll, parallax
- 📝 **RSVP Form** - Mẫu xác nhận tham dự với lưu trữ localStorage
- 🖼️ **Gallery** - Thư viện ảnh với lightbox
- 🗺️ **Google Maps** - Nhúng bản đồ địa điểm
- 🎯 **Timeline** - Dòng thời gian của mối quan hệ
- 📱 **Smooth Scrolling** - Cuộn mượt mà đến các phần khác nhau

## 📁 Cấu Trúc Tệp

```
weddingpage/
├── index.html          # File HTML chính
├── styles.css          # Stylesheet CSS chính
├── enhancements.css    # Stylesheet CSS - hiệu ứng hồng nâng cao
├── script.js           # JavaScript cho tương tác
└── README.md          # File hướng dẫn này
```

## 🚀 Cách Sử Dụng

### 1. **Mở trực tiếp trên trình duyệt**
```bash
# Mở file index.html trong trình duyệt yêu thích của bạn
```

### 2. **Chạy trên máy chủ web (XAMPP)**
```bash
# File đã được đặt trong: D:\xampp8\htdocs\vhosts\weddingpage
# Truy cập: http://localhost/vhosts/weddingpage/
# hoặc: http://weddingpage.local (nếu đã cấu hình hosts)
```

## ✏️ Tuỳ Chỉnh

### 1. **Thay đổi tên cặp đôi**
Mở `index.html` và tìm kiếm:
```html
<h1 class="display-1 fw-bold mb-3 couple-names">
    Thủy <span class="heart">&</span> Minh
</h1>
```
Thay `Thủy` và `Minh` bằng tên của bạn

### 2. **Thay đổi ngày tháng đám cưới**
Tìm kiếm các phần:
```html
<p>Ngày 15 tháng 8 năm 2026</p>
```
Thay đổi ngày tháng phù hợp

### 3. **Thay đổi hình ảnh**
- Tìm tất cả các tag `<img src="..."`
- Thay URL hình ảnh bằng ảnh của bạn hoặc đặt ảnh trong folder

### 4. **Thay đổi nội dung câu chuyện**
Tìm section "Câu chuyện của chúng tôi" và chỉnh sửa text

### 5. **Thay đổi địa điểm**
- Tìm phần "Chi tiết đám cưới"
- Cập nhật địa chỉ lễ cưới và tiệc cưới
- Cập nhật Google Maps embed code

### 6. **Thay đổi màu sắc**
Chỉnh sửa trong `styles.css`:
```css
:root {
    --primary-color: #ff69b4;        /* Màu hồng chủ đạo */
    --secondary-color: #fff5f9;      /* Màu nền hồng nhạt */
    --accent-color: #ff1493;         /* Màu hồng sẫm */
    --text-dark: #333333;            /* Màu text tối */
    --text-light: #666666;           /* Màu text sáng */
}
```

### 7. **Tìm hiểu thêm hiệu ứng**
Xem file `enhancements.css` để khám phá các animations và effects:
- Gradient transitions
- Heartbeat animations
- Floating effects
- Glow effects
- Smooth transitions

## 📝 Các Phần Chính

### 1. **Navigation Bar**
- Menu điều hướng sticky
- Links đến các phần khác nhau

### 2. **Hero Section**
- Ảnh nền gradient đẹp
- Tên cặp đôi
- Ngày tháng và địa điểm

### 3. **Story Section**
- Ảnh cặp đôi
- Câu chuyện tình yêu

### 4. **Profiles Section**
- Giới thiệu chi tiết cô dâu
- Giới thiệu chi tiết chú rể
- Links mạng xã hội

### 5. **Wedding Details**
- Chi tiết lễ cưới (giờ giấc, địa điểm)
- Chi tiết tiệc cưới
- Quy định trang phục
- Bản đồ Google Maps

### 6. **Gallery**
- Thư viện ảnh 6 hình
- Lightbox khi click ảnh

### 7. **Timeline**
- Dòng thời gian mối quan hệ
- 4 mốc quan trọng

### 8. **RSVP Form**
- Form xác nhận tham dự
- Lưu trữ dữ liệu trong localStorage
- Validation form

### 9. **Footer**
- Thông tin bản quyền
- Lời cảm ơn

## 🎨 Tuỳ Chỉnh Nâng Cao

### Thay đổi Font
Mở `index.html`, tìm Google Fonts link:
```html
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
```
Sử dụng fonts khác từ Google Fonts

### Thêm Hiệu Ứng
Chỉnh sửa `script.js` để thêm các hiệu ứng interactivity khác

### Kết Nối với Backend
Cho RSVP form, bạn có thể kết nối với backend:
```javascript
fetch('/api/rsvp', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(formData)
})
```

## 🔗 Các Công Nghệ Sử Dụng

- **HTML5** - Cấu trúc trang web
- **CSS3** - Styling và animations
- **Bootstrap 5** - Framework UI
- **Font Awesome** - Icons
- **Google Fonts** - Fonts đẹp
- **JavaScript** - Interactivity
- **Google Maps API** - Bản đồ

## 📱 Tương Thích Trình Duyệt

- ✅ Chrome/Chromium
- ✅ Firefox
- ✅ Safari
- ✅ Edge
- ✅ Mobile browsers

## 💡 Mẹo

1. **RSVP Data**: Dữ liệu RSVP được lưu trong localStorage của trình duyệt
2. **Hình ảnh**: Sử dụng hình ảnh chất lượng cao (tối thiểu 1200x800px)
3. **SEO**: Thêm meta tags để tối ưu hoá tìm kiếm
4. **Analytics**: Thêm Google Analytics để theo dõi lượt truy cập

## 🐛 Troubleshooting

### Hình ảnh không tải
- Kiểm tra URL hình ảnh
- Đảm bảo kết nối internet (nếu dùng URL ngoài)
- Kiểm tra console để xem lỗi

### RSVP Form không hoạt động
- Kiểm tra browser console
- Đảm bảo JavaScript được bật
- Xóa cache và load lại trang

## 📧 Hỗ Trợ

Để thêm tính năng hoặc gặp vấn đề:
1. Kiểm tra console (F12)
2. Xem file README này
3. Tìm kiếm trong code các comments

## 📄 License

Mã nguồn này được cung cấp miễn phí để sử dụng cá nhân.

---

**Chúc bạn có một lễ cưới tuyệt vời! 💕**




