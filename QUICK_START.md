# ⚡ Quick Start Guide - Vue.js 3 Wedding Page

## 🎯 Bắt Đầu Nhanh Nhất

### Cho Windows:
1. **Double-click** `install.bat` - Cài đặt dependencies
2. **Double-click** `develop.bat` - Chạy dev server
3. Browser mở tự động: `http://localhost:5173`

### Cho macOS/Linux:
```bash
npm install
npm run dev
```

## 📋 Yêu Cầu Tối Thiểu

- Node.js v14+ ([Download](https://nodejs.org/))
- npm hoặc yarn

## 🗂️ Cấu Trúc Thư Mục Chính

```
weddingpage/
├── src/
│   ├── components/        # Vue components
│   ├── views/            # Pages
│   ├── router/           # Navigation
│   ├── stores/           # State management
│   └── App.vue           # Root component
├── package.json          # Dependencies
└── vite.config.js       # Vite config
```

## 🚀 Lệnh Cơ Bản

```bash
npm install       # Cài đặt dependencies
npm run dev       # Chạy dev server
npm run build     # Build cho production
npm run preview   # Xem production build
```

## ✏️ Chỉnh Sửa Nhanh

### Thay đổi tên cặp đôi
File: `src/components/sections/HeroSection.vue`
```vue
<h1 class="couple-names">Thủy <span class="heart">&</span> Minh</h1>
```

### Thay đổi ngày tháng
File: `src/components/sections/HeroSection.vue`
```javascript
const weddingData = {
  date: new Date(2026, 7, 15),  // 15/08/2026
  venue: 'Nhà hàng Tiệc Cưới Hoa Anh Đào'
}
```

### Thay đổi hình ảnh
Tìm `img src=""` và thay URL

### Thay đổi màu sắc
Tìm và thay thế:
- `#ff69b4` (Hot Pink)
- `#ff1493` (Deep Pink)
- `#fff5f9` (Light Pink)

## 📱 Component Locations

| Phần | File |
|------|------|
| Navigation | `src/components/layout/Navbar.vue` |
| Banner | `src/components/sections/HeroSection.vue` |
| Love Story | `src/components/sections/StorySection.vue` |
| Couple Info | `src/components/sections/ProfilesSection.vue` |
| Wedding Details | `src/components/sections/DetailsSection.vue` |
| Gallery | `src/components/sections/GallerySection.vue` |
| Timeline | `src/components/sections/TimelineSection.vue` |
| RSVP Form | `src/components/sections/RSVPSection.vue` |
| Footer | `src/components/layout/Footer.vue` |

## 🐛 Troubleshooting

### Port 5173 already in use?
Edit `vite.config.js`:
```javascript
server: {
  port: 3000,  // Change port
}
```

### "Cannot find module"?
```bash
rm -rf node_modules
npm install
```

### Build fails?
```bash
npm run build -- --force
```

## 📚 Documentation Files

- `SETUP_GUIDE.md` - Chi tiết cài đặt
- `README_VUE.md` - Vue.js documentation
- `STRUCTURE.txt` - Cấu trúc dự án
- **`QUICK_START.md`** - File này

## 🎓 Learning Path

1. **Setup** (10 min) - Cài đặt dependencies
2. **Explore** (20 min) - Xem các components
3. **Customize** (30 min) - Chỉnh sửa tên, ảnh
4. **Deploy** (10 min) - Build và deploy

## 🚀 Deployment

### Development
```bash
npm run dev
```

### Production
```bash
npm run build
# Copy dist/ folder to your hosting
```

### Quick Deployments
- **Netlify**: Drag & drop `dist/` folder
- **Vercel**: Connect GitHub repo
- **GitHub Pages**: Push dist to gh-pages

## 💡 Pro Tips

1. **Hot Reload** - Thay đổi code tự động refresh
2. **DevTools** - F12 để debug
3. **Responsive** - Tùy chỉnh mobile view
4. **Git** - Use `.gitignore` đã có
5. **Environment** - Tạo `.env.local` từ `.env.example`

## 📞 Need Help?

1. Check console: **F12** (DevTools)
2. Read: `SETUP_GUIDE.md`
3. Check: `README_VUE.md`
4. Search: Components in `src/`

## ✅ Checklist

- [ ] Node.js installed? (`node --version`)
- [ ] Dependencies installed? (`npm install`)
- [ ] Dev server runs? (`npm run dev`)
- [ ] Browser opens at localhost:5173?
- [ ] See wedding page loaded?
- [ ] Ready to customize!

## 🎉 You're Ready!

Bây giờ:
1. Mở dev server
2. Chỉnh sửa components
3. Xem thay đổi live
4. Build cho production
5. Deploy!

**Chúc mừng! Happy coding! 💕**

---

📖 Xem thêm: `SETUP_GUIDE.md` | `README_VUE.md` | `STRUCTURE.txt`

