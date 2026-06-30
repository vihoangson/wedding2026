'use strict';

// ===== COUNTDOWN TIMER =====
function initCountdown() {
    const weddingDate = new Date('2026-12-13T11:30:00').getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = weddingDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').textContent = String(days).padStart(2, '0');
        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

        if (distance < 0) {
            document.querySelector('.countdown-title').textContent = '🎉 Ngày trọng đại đã tới!';
            document.getElementById('countdown').style.opacity = '0.5';
        }
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
}

// ===== FLOATING HEARTS =====
function createFloatingHeart() {
    const hearts = ['❤️', '💕', '💖', '💗', '💝'];
    const heart = document.createElement('div');
    heart.className = 'heart';
    heart.textContent = hearts[Math.floor(Math.random() * hearts.length)];

    const leftPos = Math.random() * 100;
    const duration = 4 + Math.random() * 2;
    const tx = (Math.random() - 0.5) * 200 - 50;

    heart.style.left = leftPos + '%';
    heart.style.setProperty('--tx', tx + 'px');
    heart.style.animationDuration = duration + 's';
    heart.style.animationDelay = Math.random() * 0.5 + 's';

    document.body.appendChild(heart);

    setTimeout(() => heart.remove(), (duration + 1) * 1000);
}

// Khởi động floating hearts trên desktop
function startFloatingHearts() {
    if (window.innerWidth > 768) {
        setInterval(createFloatingHeart, 800);
    }
}

// ===== CONFETTI EFFECT =====
function createConfetti() {
    const colors = ['#b8636f', '#c9a87c', '#fbe9ec', '#f3d2da', '#e7c3ca'];
    const shapes = ['●', '■', '▲', '★', '◆'];

    for (let i = 0; i < 50; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        confetti.textContent = shapes[Math.floor(Math.random() * shapes.length)];
        confetti.style.left = Math.random() * 100 + '%';
        confetti.style.top = '-10px';
        confetti.style.color = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.fontSize = (Math.random() * 20 + 10) + 'px';
        confetti.style.animationDuration = (Math.random() * 2 + 2.5) + 's';
        confetti.style.animationDelay = Math.random() * 0.2 + 's';
        confetti.style.transform = 'translateX(' + (Math.random() * 200 - 100) + 'px)';

        document.body.appendChild(confetti);

        setTimeout(() => confetti.remove(), 5000);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    initCountdown();
    startFloatingHearts();
});

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
    const phone = document.getElementById('phone').value.trim();
    // Không validate phone - bỏ check

    // Show success message
    form.style.display = 'none';
    successBox.classList.add('show');

    // Trigger confetti effect
    createConfetti();

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

