# 💍 Wedding Landing Page - Vue.js 3 Version

Đây là phiên bản Vue.js 3 của trang web giới thiệu lễ cưới hiện đại, đẹp mắt.

## 🚀 Công Nghệ Sử Dụng

- **Vue.js 3** - Progressive JavaScript Framework
- **Vue Router 4** - Official router for Vue.js
- **Pinia** - Vue Store (State Management)
- **Vite** - Next generation frontend tooling
- **Bootstrap 5** - CSS Framework
- **Axios** - HTTP Client (optional)

## 📁 Cấu Trúc Thư Mục

```
weddingpage/
├── src/
│   ├── components/
│   │   ├── layout/
│   │   │   ├── Navbar.vue          # Navigation component
│   │   │   └── Footer.vue          # Footer component
│   │   ├── sections/
│   │   │   ├── HeroSection.vue     # Hero/banner section
│   │   │   ├── StorySection.vue    # Love story section
│   │   │   ├── ProfilesSection.vue # Couple profiles
│   │   │   ├── DetailsSection.vue  # Wedding details
│   │   │   ├── GallerySection.vue  # Photo gallery
│   │   │   ├── TimelineSection.vue # Timeline section
│   │   │   └── RSVPSection.vue     # RSVP form section
│   │   └── common/
│   │       ├── ProfileCard.vue     # Reusable profile card
│   │       └── DetailCard.vue      # Reusable detail card
│   ├── router/
│   │   └── index.js                # Router configuration
│   ├── stores/
│   │   └── weddingStore.js         # Pinia store for wedding data
│   ├── views/
│   │   └── HomePage.vue            # Main home page view
│   ├── App.vue                     # Root component
│   ├── main.js                     # Application entry point
│   └── assets/                     # Static assets (images, styles, etc.)
├── index_vue.html                  # HTML entry point
├── vite.config.js                  # Vite configuration
├── package.json                    # Dependencies
├── .gitignore                      # Git ignore file
├── .env.example                    # Environment variables example
└── README.md                       # This file
```

## 🛠️ Installation & Setup

### 1. Install Dependencies
```bash
npm install
```

### 2. Development Server
```bash
npm run dev
```
Truy cập tại: `http://localhost:5173`

### 3. Build for Production
```bash
npm run build
```

### 4. Preview Production Build
```bash
npm run preview
```

## 📦 Available Scripts

- `npm run dev` - Start development server with hot module replacement
- `npm run build` - Build for production
- `npm run preview` - Preview production build locally
- `npm run serve` - Alias for dev

## 🎯 Component Structure

### Layout Components
- **Navbar.vue** - Top navigation bar with smooth scrolling
- **Footer.vue** - Footer with company info

### Section Components
- **HeroSection.vue** - Landing hero section with couple names
- **StorySection.vue** - Love story with images and text
- **ProfilesSection.vue** - Couple profiles with details
- **DetailsSection.vue** - Wedding ceremony and reception details
- **GallerySection.vue** - Photo gallery with lightbox
- **TimelineSection.vue** - Timeline of relationship milestones
- **RSVPSection.vue** - RSVP form with validation

### Reusable Components
- **ProfileCard.vue** - Profile card component for couple members
- **DetailCard.vue** - Card component for wedding details

## 📊 State Management with Pinia

The `weddingStore.js` manages:
- Couple information
- Wedding date and venue
- RSVP list
- Global wedding data

Usage in components:
```javascript
import { useWeddingStore } from '@/stores/weddingStore'

const weddingStore = useWeddingStore()
```

## 🛣️ Routing

Configured in `src/router/index.js`:
- `/` - Home page (default route)

You can add more routes as needed:
```javascript
{
  path: '/gallery',
  name: 'Gallery',
  component: GalleryPage
}
```

## 🎨 Styling

The application uses:
- **Bootstrap 5** for responsive grid and components
- **Scoped CSS** in Vue components for component-specific styles
- **CSS Variables** for theme colors
- **Tailwind-like utilities** from Bootstrap

Color Theme:
- Primary: `#ff69b4` (Hot Pink)
- Secondary: `#fff5f9` (Light Pink)
- Accent: `#ff1493` (Deep Pink)

## 🔧 Environment Variables

Create a `.env.local` file based on `.env.example`:

```env
VITE_APP_TITLE=Wedding Landing Page
VITE_APP_VERSION=1.0.0
VITE_API_BASE_URL=http://localhost:3000/api
```

Access in components:
```javascript
console.log(import.meta.env.VITE_APP_TITLE)
```

## 📱 Responsive Design

All components are responsive with breakpoints:
- Mobile: < 576px
- Tablet: 576px - 768px
- Desktop: 768px - 992px
- Large Desktop: > 992px

## ✨ Features

✅ **Component-based Architecture** - Modular and maintainable code
✅ **Reactive State Management** - Using Pinia for global state
✅ **Routing** - Vue Router for navigation
✅ **File Upload Ready** - Can add file upload features
✅ **Form Validation** - Built-in form validation
✅ **Animation** - Smooth transitions and animations
✅ **SEO Friendly** - Clean semantic HTML
✅ **Mobile Responsive** - Works on all devices
✅ **Performance** - Optimized with Vite

## 📝 Component Example

```vue
<template>
  <div class="my-component">
    <h1>{{ title }}</h1>
    <button @click="increment">Click me</button>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const title = ref('Welcome')

const increment = () => {
  title.value = 'Clicked!'
}
</script>

<style scoped>
.my-component {
  padding: 20px;
}
</style>
```

## 🚀 Deployment

### Build and Deploy to Hosting
```bash
npm run build
```

Upload `dist` folder to your hosting provider.

### For XAMPP/Apache
1. Build the project: `npm run build`
2. Copy `dist` folder contents to `htdocs/vhosts/weddingpage/`
3. Access via: `http://localhost/vhosts/weddingpage/`

## 🐛 Troubleshooting

### Port Already in Use
```bash
# Use different port
npm run dev -- --port 3000
```

### Clear Vite Cache
```bash
rm -rf node_modules/.vite
npm run dev
```

### Build Issues
```bash
# Clear node_modules and reinstall
rm -rf node_modules
npm install
npm run build
```

## 📚 Learning Resources

- [Vue.js 3 Documentation](https://vuejs.org/)
- [Vue Router Documentation](https://router.vuejs.org/)
- [Pinia Documentation](https://pinia.vuejs.org/)
- [Vite Documentation](https://vitejs.dev/)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.0/)

## 📄 License

This project is open source and available under the MIT License.

## 💝 Credits

Built with ❤️ for a beautiful wedding celebration.

---

**Happy Wedding! 🎉💕**

