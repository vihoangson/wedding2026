<template>
  <section id="gallery" class="py-5" style="background: #fff5f9;">
    <div class="container">
      <h2 class="text-center section-title mb-5">Khoảnh khắc của chúng tôi</h2>
      <div class="row g-3">
        <div class="col-md-4" v-for="(image, index) in gallery" :key="index">
          <div class="gallery-item" @click="openLightbox(image)">
            <img :src="image.src" :alt="`Ảnh ${index + 1}`" class="img-fluid rounded-3">
            <div class="gallery-overlay">
              <i class="fas fa-heart fa-2x text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Lightbox Modal -->
    <transition name="fade">
      <div v-if="lightboxImage" class="lightbox" @click="closeLightbox">
        <div class="lightbox-content" @click.stop>
          <button class="close-btn" @click="closeLightbox">&times;</button>
          <img :src="lightboxImage.src" :alt="lightboxImage.alt" class="lightbox-img">
        </div>
      </div>
    </transition>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const gallery = ref([
  { src: 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=400&h=300&fit=crop', alt: 'Ảnh 1' },
  { src: 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=400&h=300&fit=crop', alt: 'Ảnh 2' },
  { src: 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=400&h=300&fit=crop', alt: 'Ảnh 3' },
  { src: 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=400&h=300&fit=crop', alt: 'Ảnh 4' },
  { src: 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=400&h=300&fit=crop', alt: 'Ảnh 5' },
  { src: 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=400&h=300&fit=crop', alt: 'Ảnh 6' }
])

const lightboxImage = ref(null)

const openLightbox = (image) => {
  lightboxImage.value = image
}

const closeLightbox = () => {
  lightboxImage.value = null
}
</script>

<style scoped>
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: 3rem;
  color: #333333;
  position: relative;
  display: inline-block;
  width: 100%;
  margin-bottom: 40px;
}

.section-title::after {
  content: '';
  display: block;
  width: 60px;
  height: 4px;
  background: linear-gradient(90deg, #ff69b4, #ff1493);
  margin: 15px auto 0;
  border-radius: 2px;
}

.gallery-item {
  position: relative;
  overflow: hidden;
  border-radius: 15px;
  cursor: pointer;
  height: 300px;
}

.gallery-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.gallery-item:hover img {
  transform: scale(1.1);
}

.gallery-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(255, 105, 180, 0.85), rgba(255, 20, 147, 0.85));
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
  opacity: 1;
}

.lightbox {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  cursor: pointer;
}

.lightbox-content {
  position: relative;
  max-width: 90vw;
  max-height: 90vh;
}

.lightbox-img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.close-btn {
  position: absolute;
  top: -40px;
  right: 0;
  background: none;
  border: none;
  color: white;
  font-size: 40px;
  cursor: pointer;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

@media (max-width: 992px) {
  .section-title {
    font-size: 2.2rem;
  }
}

@media (max-width: 576px) {
  .section-title {
    font-size: 1.8rem;
  }

  .gallery-item {
    height: 250px;
  }
}
</style>

