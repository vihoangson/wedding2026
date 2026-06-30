<template>
  <section id="story" class="py-5 story-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=500&h=600&fit=crop"
               alt="Cặp đôi" class="img-fluid rounded-3 shadow-lg">
        </div>
        <div class="col-lg-6">
          <h2 class="section-title mb-4">Câu chuyện của chúng tôi</h2>
          <p class="lead mb-3" v-for="(paragraph, index) in story" :key="index">
            {{ paragraph }}
          </p>
          <p class="text-muted fst-italic">
            "Trong cuộc sống này, tôi chỉ cần một người - chính là bạn." - Minh
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const story = ref([
  'Gặp nhau lần đầu tiên tại một buổi họp mặt bạn bè vào mùa hè 2021, chúng tôi không ngờ rằng đó sẽ là điểm khởi đầu của một tình yêu đẹp.',
  'ádasdas ádasdas Thủy bị ấn tượng bởi nụ cười ấm áp của Minh, còn Minh lại yêu thích tính tính tế và lòng tốt của Thủy. Từ những cuộc hẹn hò đơn giản cho đến những chuyến du lịch xa xôi, chúng tôi đã chia sẻ những khoảnh khắc quý giá nhất của cuộc sống.',
  'Vào ngày 14 tháng 2 năm 2024, Minh đã quỳ xuống và cầu hôn Thủy dưới ánh trăng ở bãi biển, và Thủy đã nói "Có" với nước mắt hạnh phúc.'
])
</script>

<style scoped>
.story-section {
  background: #fff5f9;
}

.story-section img {
  transition: transform 0.3s ease;
}

.story-section img:hover {
  transform: scale(1.02);
}

.story-section p {
  font-size: 1.1rem;
  color: #666666;
  line-height: 1.8;
}

.section-title {
  font-family: 'Playfair Display', serif;
  font-size: 3rem;
  color: #333333;
  position: relative;
  display: inline-block;
  margin-bottom: 40px;
}

.section-title::after {
  content: '';
  display: block;
  width: 60px;
  height: 4px;
  background: linear-gradient(90deg, #ff69b4, #ff1493);
  margin: 15px 0 0 0;
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

