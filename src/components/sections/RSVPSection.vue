<template>
  <section id="rsvp" class="py-5" style="background: #fff5f9;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h2 class="text-center section-title mb-5">Xác nhận tham dự</h2>
          <div class="rsvp-card p-5 rounded-3 shadow">
            <form @submit.prevent="submitRSVP" v-if="!submitted">
              <div class="mb-3">
                <label for="name" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                <input
                  type="text"
                  class="form-control form-control-lg"
                  id="name"
                  v-model="formData.name"
                  required
                  placeholder="Nhập tên của bạn">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                <input
                  type="email"
                  class="form-control form-control-lg"
                  id="email"
                  v-model="formData.email"
                  required
                  placeholder="Nhập email của bạn">
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                <input
                  type="tel"
                  class="form-control form-control-lg"
                  id="phone"
                  v-model="formData.phone"
                  required
                  placeholder="Nhập số điện thoại">
              </div>
              <div class="mb-3">
                <label for="guests" class="form-label fw-bold">Số người tham dự <span class="text-danger">*</span></label>
                <select
                  class="form-select form-select-lg"
                  id="guests"
                  v-model="formData.guests"
                  required>
                  <option value="">-- Chọn số người --</option>
                  <option value="1">1 người</option>
                  <option value="2">2 người</option>
                  <option value="3">3 người</option>
                  <option value="4">4 người</option>
                  <option value="5">5 người trở lên</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="dietary" class="form-label fw-bold">Yêu cầu về ăn uống (nếu có)</label>
                <textarea
                  class="form-control form-control-lg"
                  id="dietary"
                  v-model="formData.dietary"
                  rows="3"
                  placeholder="Vd: Ăn chay, không ăn các loại hải sản, v.v..."></textarea>
              </div>
              <div class="mb-3">
                <label for="message" class="form-label fw-bold">Lời chúc (tuỳ chọn)</label>
                <textarea
                  class="form-control form-control-lg"
                  id="message"
                  v-model="formData.message"
                  rows="3"
                  placeholder="Gửi lời chúc tốt đẹp cho cặp đôi..."></textarea>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-danger btn-lg">
                  <i class="fas fa-check me-2"></i> Xác nhận tham dự
                </button>
              </div>
            </form>

            <!-- Success Message -->
            <div v-if="submitted" class="alert alert-success" role="alert">
              <i class="fas fa-check-circle me-2"></i> Cảm ơn bạn! Chúng tôi đã nhận được xác nhận của bạn.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const formData = ref({
  name: '',
  email: '',
  phone: '',
  guests: '',
  dietary: '',
  message: ''
})

const submitted = ref(false)

const submitRSVP = () => {
  console.log('RSVP submitted:', formData.value)

  // Store in localStorage for demo purposes
  const rsvpData = {
    ...formData.value,
    timestamp: new Date().toLocaleString('vi-VN')
  }

  localStorage.setItem('wedding_rsvp_' + formData.value.email, JSON.stringify(rsvpData))

  // Show success message
  submitted.value = true

  // Reset form after 3 seconds
  setTimeout(() => {
    formData.value = {
      name: '',
      email: '',
      phone: '',
      guests: '',
      dietary: '',
      message: ''
    }
    submitted.value = false
  }, 3000)
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

.rsvp-card {
  background: linear-gradient(135deg, #fff5f9 0%, #ffe0ec 100%);
  border: 2px solid #ff69b4;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.rsvp-card:hover {
  border-color: #ff1493;
  box-shadow: 0 10px 30px rgba(255, 105, 180, 0.25) !important;
}

.rsvp-card::after {
  content: '';
  position: absolute;
  top: -50%;
  right: -50%;
  width: 200%;
  height: 200%;
  background: linear-gradient(45deg, transparent, rgba(255, 105, 180, 0.1), transparent);
  animation: shimmer 3s infinite;
}

.form-control,
.form-select {
  border: 1px solid #ddd;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
  border-color: #ff69b4;
  box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.25);
}

.form-label {
  color: #333;
  font-weight: 600;
  margin-bottom: 12px;
  background: linear-gradient(135deg, #ff69b4, #ff1493);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.btn-danger {
  background: linear-gradient(135deg, #ff69b4, #ff1493);
  border: none;
  border-radius: 10px;
  padding: 12px 30px;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
}

.btn-danger:hover {
  background: linear-gradient(135deg, #ff1493, #ff69b4);
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(255, 105, 180, 0.4);
}

.alert-success {
  background: linear-gradient(135deg, #fff5f9, #ffe0ec);
  border: 2px solid #ff69b4;
  color: #333;
}

@keyframes shimmer {
  0% {
    background-position: -1000px 0;
  }
  100% {
    background-position: 1000px 0;
  }
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

  .rsvp-card {
    padding: 1.5rem !important;
  }
}
</style>

