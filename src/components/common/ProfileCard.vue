<template>
  <div class="card h-100 shadow-sm border-0 profile-card">
    <img :src="profile.image" :alt="profile.name" class="card-img-top">
    <div class="card-body text-center">
      <h3 class="card-title fw-bold mb-2">{{ profile.name }}</h3>
      <p class="card-text text-muted mb-3">
        {{ profile.description }}
      </p>
      <div class="social-links">
        <a v-for="social in profile.socials" :key="social.icon" :href="social.url" class="me-2">
          <i :class="[social.icon, social.class]"></i>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  profile: {
    type: Object,
    required: true
  }
})
</script>

<style scoped>
.profile-card {
  transition: all 0.3s ease;
  overflow: hidden;
  background: linear-gradient(135deg, #fff5f9 0%, #ffe0ec 100%);
  box-shadow: 0 8px 25px rgba(255, 105, 180, 0.15) !important;
}

.profile-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
}

.profile-card img {
  height: 300px;
  object-fit: cover;
  transition: filter 0.3s ease, transform 0.3s ease;
}

.profile-card:hover img {
  filter: brightness(1.1) saturate(1.1);
  transform: scale(1.05);
}

.profile-card .card-body {
  padding: 2rem;
}

.profile-card .card-title {
  color: #ff69b4;
  font-size: 1.5rem;
}

.profile-card .card-text {
  font-size: 0.95rem;
}

.social-links a {
  color: #666666;
  text-decoration: none;
  font-size: 1.3rem;
  transition: all 0.3s ease;
}

.social-links a:hover {
  color: #ff69b4;
  transform: scale(1.3);
}
</style>

