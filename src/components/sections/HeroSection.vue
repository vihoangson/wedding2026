<template>
  <section id="home" class="hero-section">
    <div class="hero-content">
      <div class="container text-center text-white">
        <h1 class="display-1 fw-bold mb-3 couple-names">Thủy <span class="heart">&</span> Minh</h1>
        <p class="lead mb-4 subtitle">Chúng tôi rất vui được mời bạn dự lễ cưới của chúng tôi</p>
        <div class="wedding-date">
          <p class="fs-5">
            <i class="far fa-calendar-alt me-2"></i>
            {{ formattedDate }}
          </p>
          <p class="fs-5">
            <i class="fas fa-map-marker-alt me-2"></i>
            {{ venue }}
          </p>
        </div>
        <a href="#story" class="btn btn-light btn-lg mt-4" @click="scrollTo('#story')">
          Khám phá câu chuyện của chúng tôi <i class="fas fa-arrow-down ms-2"></i>
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const weddingData = {
  date: new Date(2026, 7, 15),
  venue: 'Nhà hàng Tiệc Cưới Hoa Anh Đào, Thành phố'
}

const formattedDate = computed(() => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' }
  return weddingData.date.toLocaleDateString('vi-VN', options)
})

const venue = computed(() => weddingData.venue)

const scrollTo = (selector) => {
  const element = document.querySelector(selector)
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' })
  }
}
</script>

<style scoped>
.hero-section {
  background: linear-gradient(135deg, #ff69b4 0%, #ff1493 50%, #ff69b4 100%);
  background-attachment: fixed;
  color: white;
  padding: 120px 20px;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.hero-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ff69b4' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  opacity: 0.1;
}

.hero-content {
  position: relative;
  z-index: 1;
}

.couple-names {
  font-family: 'Playfair Display', serif;
  font-size: 4rem;
  margin-bottom: 20px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
  animation: fadeInDown 1s ease-out;
}

.couple-names .heart {
  color: #ff1493;
  margin: 0 20px;
  display: inline-block;
}

.subtitle {
  font-size: 1.5rem;
  font-weight: 300;
  margin-bottom: 30px;
  animation: fadeInUp 1s ease-out 0.2s backwards;
}

.wedding-date {
  background: rgba(255, 255, 255, 0.1);
  padding: 20px;
  border-radius: 15px;
  backdrop-filter: blur(10px);
  margin: 30px 0;
  animation: fadeInUp 1s ease-out 0.4s backwards;
}

.wedding-date p {
  margin: 10px 0;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 992px) {
  .couple-names {
    font-size: 3rem;
  }

  .subtitle {
    font-size: 1.2rem;
  }
}

@media (max-width: 576px) {
  .couple-names {
    font-size: 1.5rem;
  }

  .couple-names .heart {
    margin: 0 10px;
  }

  .subtitle {
    font-size: 0.9rem;
  }

  .hero-section {
    padding: 60px 15px;
  }
}
</style>

