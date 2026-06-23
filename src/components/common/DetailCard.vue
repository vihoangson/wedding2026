<template>
  <div class="detail-card text-center">
    <div class="detail-icon mb-3">
      <i :class="[detail.icon, 'fa-3x', 'text-danger']"></i>
    </div>
    <h3 class="mb-3">{{ detail.title }}</h3>
    <p class="mb-2"><strong>Thời gian:</strong> {{ detail.time }}</p>
    <p class="mb-3"><strong>Địa điểm:</strong> {{ detail.location }}</p>
    <p class="text-muted">{{ detail.description }}</p>
  </div>
</template>

<script setup>
defineProps({
  detail: {
    type: Object,
    required: true
  }
})
</script>

<style scoped>
.detail-card {
  padding: 30px;
  background: linear-gradient(135deg, #fff5f9 0%, #ffe0ec 100%);
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(255, 105, 180, 0.1);
  transition: all 0.3s ease;
  border-left: 4px solid #ff69b4;
  position: relative;
}

.detail-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, transparent, #ff69b4, transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.detail-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
  border-left-color: #ff1493;
}

.detail-card:hover::before {
  opacity: 1;
}

.detail-icon {
  color: #ff69b4;
  transition: all 0.3s ease;
  animation: float 3s ease-in-out infinite;
}

.detail-card:hover .detail-icon {
  color: #ff1493;
  transform: scale(1.1);
}

.detail-card h3 {
  font-size: 1.5rem;
  color: #333333;
  font-weight: 600;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-20px);
  }
}

@media (max-width: 576px) {
  .detail-card {
    padding: 20px;
  }
}
</style>

