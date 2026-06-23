# 🚀 Setup & Installation Guide - Vue.js 3 Wedding Page

## 📋 Yêu Cầu Hệ Thống

- **Node.js** v14.0.0 hoặc cao hơn
- **npm** v6.0.0 hoặc cao hơn (hoặc yarn)

### Kiểm tra phiên bản:
```bash
node --version
npm --version
```

## 🔧 Bước 1: Cài Đặt Dependencies

Mở Terminal/PowerShell trong thư mục `D:\xampp8\htdocs\vhosts\weddingpage`:

```bash
npm install
```

Hoặc nếu bạn sử dụng yarn:
```bash
yarn install
```

**Lưu ý**: Quá trình này sẽ tải xuống tất cả các gói theo danh sách trong `package.json` và có thể mất vài phút.

## 💻 Bước 2: Chạy Development Server

```bash
npm run dev
```

Kết quả:
```
VITE v4.4.9  ready in 123 ms

➜  Local:   http://localhost:5173/
➜  press h to show help
```

Truy cập: **http://localhost:5173/**

## 📦 Bước 3: Build cho Production

```bash
npm run build
```

Kết quả:
```
vite v4.4.9 building for production...
✓ 1234 modules transformed.
dist/index.html          0.45 kB
dist/assets/main.abc123.js   123.45 kB
```

## 🎯 File Structure Giải Thích

```
src/
├── components/           # Vue components
│   ├── layout/          # Layout components (Navbar, Footer)
│   ├── sections/        # Section components (Hero, Story, etc.)
│   └── common/          # Reusable components (ProfileCard, DetailCard)
├── router/              # Vue Router configuration
├── stores/              # Pinia state management
├── views/               # Page components
├── App.vue              # Root component
└── main.js              # Application entry point
```

## 🎨 Tùy Chỉnh

### Thay đổi tên cặp đôi

Mở `src/components/sections/HeroSection.vue`:

```vue
<h1 class="display-1 fw-bold mb-3 couple-names">
  Thủy <span class="heart">&</span> Minh
</h1>
```

Thay `Thủy` và `Minh` bằng tên của bạn.

### Thay đổi ngày tháng

Mở `src/components/sections/HeroSection.vue`:

```javascript
const weddingData = {
  date: new Date(2026, 7, 15),  // August 15, 2026
  venue: 'Nhà hàng Tiệc Cưới Hoa Anh Đào, Thành phố'
}
```

### Thay đổi hình ảnh

Tìm `img src=""` trong các component và thay đổi URL.

### Thay đổi màu sắc

Tìm `#ff69b4`, `#ff1493`, `#fff5f9` trong các file `.vue` và thay đổi.

## 📚 Component Descriptions

### Layout
- **Navbar.vue** - Navigation bar
- **Footer.vue** - Page footer

### Sections
- **HeroSection.vue** - Banner chính với tên cặp đôi
- **StorySection.vue** - Câu chuyện tình yêu
- **ProfilesSection.vue** - Giới thiệu cô dâu & chú rể
- **DetailsSection.vue** - Chi tiết lễ cưới, tiệc cưới
- **GallerySection.vue** - Thư viện ảnh
- **TimelineSection.vue** - Dòng thời gian quan hệ
- **RSVPSection.vue** - Form xác nhận tham dự

### Common Components
- **ProfileCard.vue** - Card hiển thị thông tin cá nhân
- **DetailCard.vue** - Card hiển thị chi tiết sự kiện

## 🔄 Workflow Phát Triển

### 1. Khởi động dev server
```bash
npm run dev
```

### 2. Chỉnh sửa các component trong `src/`
```
src/components/sections/HeroSection.vue
```

### 3. Hot Module Replacement
Các thay đổi sẽ được cập nhật tự động trên trình duyệt (không cần reload)

### 4. Build cho production
```bash
npm run build
```

## 🌐 Deployment Options

### Option 1: XAMPP/Apache (Local)
```bash
npm run build
# Copy dist/* vào htdocs/vhosts/weddingpage/
```
Truy cập: `http://localhost/vhosts/weddingpage/`

### Option 2: Netlify
```bash
npm run build
# Drag & drop folder dist vào Netlify
```

### Option 3: Vercel
```bash
npm run build
# Connect to Vercel, auto deploy
```

### Option 4: GitHub Pages
```bash
npm run build
# Push dist folder to gh-pages branch
```

## 🔌 Lệnh NPM Available

| Lệnh | Mô Tả |
|------|-------|
| `npm run dev` | Start development server |
| `npm run build` | Build cho production |
| `npm run preview` | Preview production build |
| `npm install` | Cài đặt dependencies |
| `npm update` | Cập nhật packages |

## ⚙️ Advanced Configuration

### Thay đổi cổng (Port)

Sửa `vite.config.js`:
```javascript
server: {
  port: 3000,  // Change to your preferred port
  host: true
}
```

### Alias Paths

Đã cấu hình `@` trỏ tới `src/`:
```javascript
import Component from '@/components/MyComponent.vue'
// Thay vì
import Component from '../../components/MyComponent.vue'
```

### Environment Variables

Tạo `.env.local`:
```env
VITE_APP_TITLE=My Wedding
```

Sử dụng:
```javascript
console.log(import.meta.env.VITE_APP_TITLE)
```

## 🐛 Fixes Thường Gặp

### 1. "Module not found"
```bash
rm -rf node_modules
npm install
```

### 2. "Port already in use"
```bash
# Windows
netstat -ano | findstr :5173
taskkill /PID <PID> /F

# macOS/Linux
lsof -i :5173
kill -9 <PID>
```

### 3. "Permission denied"
```bash
# Windows - Run as Administrator
# macOS/Linux
sudo npm install
```

## 📖 File Chính để Chỉnh Sửa

| File | Dùng Để |
|------|---------|
| `src/App.vue` | Root component, layout chính |
| `src/views/HomePage.vue` | Trang chính |
| `src/components/sections/*.vue` | Các phần chính trang |
| `src/router/index.js` | Cấu hình routing |
| `src/stores/weddingStore.js` | State management |
| `vite.config.js` | Cấu hình Vite |
| `package.json` | Dependencies |

## 🎓 Best Practices

1. **Giữ components nhỏ** - Mỗi component nên có một trách nhiệm
2. **Sử dụng Pinia store** - Cho global state
3. **Scoped styles** - Tránh xung đột CSS
4. **Lazy load** - Tối ưu hoá bundle size
5. **Semantic HTML** - Tốt cho SEO

## 📞 Support

Nếu gặp vấn đề:
1. Kiểm tra console browser (F12)
2. Xem file README_VUE.md
3. Xem thêm docs tại vuejs.org

## 🎉 Kết Thúc

Chúc mừng! Bạn đã setup Vue.js 3 wedding page thành công. Hãy tùy chỉnh theo ý của bạn và tạo ra một trang cưới tuyệt đẹp! 💕

---

**Happy coding! 🚀**

