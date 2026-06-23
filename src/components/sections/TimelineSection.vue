<template>
  <section class="py-5">
    <div class="container">
      <h2 class="text-center section-title mb-5">Timeline - Hành trình của chúng tôi</h2>
      <div class="timeline">
        <div class="timeline-item" v-for="(item, index) in timelineItems" :key="index">
          <div class="timeline-marker">
            <i :class="item.icon"></i>
          </div>
          <div class="timeline-content">
            <h4>{{ item.title }}</h4>
            <p>{{ item.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const timelineItems = ref([
  {
    title: 'Tháng 6 năm 2021',
    description: 'Gặp nhau lần đầu tiên tại một buổi họp mặt bạn bè',
    icon: 'fas fa-heart text-danger'
  },
  {
    title: 'Tháng 9 năm 2021',
    description: 'Chuyến du lịch đầu tiên đến Đà Lạt',
    icon: 'fas fa-calendar text-danger'
  },
  {
    title: 'Tháng 2 năm 2024',
    description: 'Minh cầu hôn Thủy trên bãi biển',
    icon: 'fas fa-ring text-danger'
  },
  {
    title: 'Tháng 8 năm 2026',
    description: 'Lễ cưới chính thức',
    icon: 'fas fa-church text-danger'
  }
])
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

.timeline {
  position: relative;
  padding: 40px 0;
}

.timeline::before {
  content: '';
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  width: 3px;
  height: 100%;
  background: linear-gradient(180deg, #ff69b4, #ff1493, #ff69b4);
}

.timeline-item {
  margin-bottom: 40px;
  position: relative;
}

.timeline-item:nth-child(odd) .timeline-content {
  margin-left: 0;
  margin-right: 52%;
  text-align: right;
}

.timeline-item:nth-child(even) .timeline-content {
  margin-left: 52%;
  margin-right: 0;
  text-align: left;
}

.timeline-marker {
  position: absolute;
  left: 50%;
  width: 50px;
  height: 50px;
  background: white;
  border: 4px solid #ff69b4;
  border-radius: 50%;
  transform: translateX(-50%);
  display: flex;
  align-items: center;
  justify-content: center;
  top: 0;
  z-index: 2;
  box-shadow: 0 0 0 4px #fff5f9, 0 0 20px rgba(255, 105, 180, 0.5);
}

.timeline-content h4 {
  color: #ff69b4;
  font-weight: 600;
  margin-bottom: 10px;
}

.timeline-content p {
  color: #666666;
  font-size: 1rem;
}

@media (max-width: 768px) {
  .timeline::before {
    left: 30px;
  }

  .timeline-marker {
    left: 30px;
  }

  .timeline-item:nth-child(odd) .timeline-content,
  .timeline-item:nth-child(even) .timeline-content {
    margin-left: 100px;
    margin-right: 0;
    text-align: left;
  }

  .section-title {
    font-size: 2.2rem;
  }
}

@media (max-width: 576px) {
  .section-title {
    font-size: 1.8rem;
  }
}
</style>

