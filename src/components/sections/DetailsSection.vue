<template>
  <section id="details" class="py-5">
    <div class="container">
      <h2 class="text-center section-title mb-5">Chi tiết đám cưới</h2>
      <div class="row g-4">
        <div class="col-md-4" v-for="detail in details" :key="detail.id">
          <DetailCard :detail="detail" />
        </div>
      </div>

      <!-- Venue Map -->
      <div class="row mt-5">
        <div class="col-12">
          <h3 class="mb-4">Bản đồ địa điểm</h3>
          <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.1234567890123!2d105.82!3d20.99!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab0000000001%3A0x0000000000000001!2sHa%20Dong%20District%2C%20Hanoi!5e0!3m2!1svi!2svn!4v1234567890123"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    class="rounded-3"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import DetailCard from '@/components/common/DetailCard.vue'

const details = ref([
  {
    id: 1,
    title: 'Lễ Cưới',
    icon: 'fas fa-church',
    time: '10:00 - 11:30 sáng',
    location: 'Nhà thờ Thánh Mary, Quận Hà Đông',
    description: 'Lễ cưới sẽ bắt đầu đúng 10:00, xin vui lòng đến sớm.'
  },
  {
    id: 2,
    title: 'Tiệc Cưới',
    icon: 'fas fa-utensils',
    time: '17:00 - 23:00 chiều',
    location: 'Nhà hàng Tiệc Cưới Hoa Anh Đào',
    description: 'Menu đã được chuẩn bị đặc biệt. Rượu, nước uống và bia phục vụ tự do.'
  },
  {
    id: 3,
    title: 'Quy Định Trang Phục',
    icon: 'fas fa-tuxedo',
    time: 'Trang phục lịch sự',
    location: 'Tránh màu đỏ hoặc trắng',
    description: 'Chúng tôi muốn bạn cảm thấy thoải mái và tự tin trong bộ quần áo yêu thích của mình.'
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

