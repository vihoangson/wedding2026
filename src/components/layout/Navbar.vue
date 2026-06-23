<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">
      <router-link to="/" class="navbar-brand fw-bold">
        <i class="fas fa-heart text-danger"></i> Đám cưới
      </router-link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#home" @click="scrollToSection('#home')">Trang chủ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#story" @click="scrollToSection('#story')">Câu chuyện</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#details" @click="scrollToSection('#details')">Chi tiết</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#gallery" @click="scrollToSection('#gallery')">Ảnh</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#rsvp" @click="scrollToSection('#rsvp')">RSVP</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
const scrollToSection = (selector) => {
  const element = document.querySelector(selector)
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' })
  }
}
</script>

<style scoped>
.navbar-brand {
  font-size: 1.5rem;
  color: #ff69b4 !important;
  transition: all 0.3s ease;
}

.navbar-brand:hover {
  transform: scale(1.05);
}

.nav-link {
  font-weight: 500;
  margin: 0 10px;
  transition: color 0.3s ease;
}

.nav-link:hover {
  color: #ff69b4 !important;
}
</style>

