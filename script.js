'use strict';

// ===== LIGHTBOX GALLERY =====
const lightbox = document.getElementById('lightbox');
const lightboxImage = document.getElementById('lightboxImage');
const lightboxClose = document.getElementById('lightboxClose');
const lightboxPrev = document.getElementById('lightboxPrev');
const lightboxNext = document.getElementById('lightboxNext');
let currentImageIndex = 0;
let images = [];

// Khởi tạo gallery
function initGallery() {
    images = Array.from(document.querySelectorAll('.g-item'));

    images.forEach((item, index) => {
        item.addEventListener('click', () => {
            currentImageIndex = index;
            openLightbox();
        });
    });
}

function openLightbox() {
    const imgUrl = images[currentImageIndex].dataset.img;
    lightboxImage.src = imgUrl;
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    lightbox.classList.remove('active');
    document.body.style.overflow = 'auto';
}

function showPrevImage() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    lightboxImage.src = images[currentImageIndex].dataset.img;
}

function showNextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    lightboxImage.src = images[currentImageIndex].dataset.img;
}

// Event listeners
lightboxClose.addEventListener('click', closeLightbox);
lightboxPrev.addEventListener('click', showPrevImage);
lightboxNext.addEventListener('click', showNextImage);

// Close lightbox when clicking outside the image (on overlay or background)
lightbox.addEventListener('click', (e) => {
    // Chỉ đóng nếu click vào overlay hoặc lightbox-content nhưng không phải click vào image, buttons
    if (e.target === lightbox || e.target === lightbox.querySelector('.lightbox-overlay')) {
        closeLightbox();
    }
});

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (!lightbox.classList.contains('active')) return;

    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') showPrevImage();
    if (e.key === 'ArrowRight') showNextImage();
});

// Initialize gallery on page load
document.addEventListener('DOMContentLoaded', initGallery);

// Hàm copy tài khoản vào clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Đã sao chép: ' + text);
    }).catch(err => {
        console.error('Lỗi sao chép:', err);
        alert('Sao chép không thành công');
    });
}

const form = document.getElementById('rsvpForm');
const successBox = document.getElementById('successBox');

form.addEventListener('submit', function(e){
    e.preventDefault();

    // Validate required fields
    const fullname = document.getElementById('fullname').value.trim();
    const guests = document.getElementById('guests').value;
    const attend = document.querySelector('input[name="attend"]:checked');

    if (!fullname) {
        alert('Vui lòng nhập họ và tên');
        return;
    }

    if (!guests || guests < 1) {
        alert('Vui lòng nhập số người tham dự');
        return;
    }

    if (!attend) {
        alert('Vui lòng chọn phương án tham dự');
        return;
    }

    // Validate email if provided
    const email = document.getElementById('email').value.trim();
    if (email && !validateEmail(email)) {
        alert('Vui lòng nhập địa chỉ email hợp lệ');
        return;
    }

    // Show success message
    form.style.display = 'none';
    successBox.classList.add('show');

    // Optional: Reset form after a delay
    setTimeout(() => {
        form.reset();
        form.style.display = 'block';
        successBox.classList.remove('show');
    }, 4000);
});

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Add input validation feedback
document.getElementById('fullname').addEventListener('blur', function() {
    if (!this.value.trim()) {
        this.style.borderColor = '#b8636f';
        this.style.borderWidth = '2px';
    } else {
        this.style.borderColor = '#e7c3ca';
        this.style.borderWidth = '2px';
    }
});

document.getElementById('email').addEventListener('blur', function() {
    if (this.value && !validateEmail(this.value)) {
        this.style.borderColor = '#b8636f';
        this.style.borderWidth = '2px';
    } else {
        this.style.borderColor = '#e7c3ca';
        this.style.borderWidth = '2px';
    }
});

