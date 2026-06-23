<template>
  <section class="py-5" style="background: #fff5f9;">
    <div class="container">
      <h2 class="text-center section-title mb-5">Những người chính</h2>
      <div class="row g-4">
        <div class="col-md-6" v-for="profile in profiles" :key="profile.id">
          <ProfileCard :profile="profile" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import ProfileCard from '@/components/common/ProfileCard.vue'

const profiles = ref([
  {
    id: 1,
    name: 'Nguyễn Thủy',
    role: 'Cô dâu',
    image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop',
    description: 'Cô dâu tươi vui, yêu thích du lịch và nấu ăn. Thủy là một người bạn tuyệt vời luôn sẵn sàng giúp đỡ mọi người.',
    socials: [
      { icon: 'fab fa-facebook', url: '#', class: 'text-primary' },
      { icon: 'fab fa-instagram', url: '#', class: 'text-danger' },
      { icon: 'fab fa-twitter', url: '#', class: 'text-info' }
    ]
  },
  {
    id: 2,
    name: 'Trần Minh',
    role: 'Chú rể',
    image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop',
    description: 'Chú rể tính tình thẳng thắn, đam mê công nghệ và thể thao. Minh là một người đàn ông tốt bụng và trách nhiệm.',
    socials: [
      { icon: 'fab fa-facebook', url: '#', class: 'text-primary' },
      { icon: 'fab fa-instagram', url: '#', class: 'text-danger' },
      { icon: 'fab fa-twitter', url: '#', class: 'text-info' }
    ]
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

@media (max-width: 992px) {
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

