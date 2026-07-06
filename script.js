'use strict';

// ===== COLLAGE MODAL =====
function initCollageModal() {
    const collagePhotos = document.querySelectorAll('.collage-photo');
    const collageModal = document.getElementById('collageModal');
    const collageModalImage = document.getElementById('collageModalImage');
    const collageModalClose = document.getElementById('collageModalClose');
    const collageModalOverlay = document.querySelector('.collage-modal-overlay');

    if (!collageModal) return;

    // Open modal when clicking collage photo
    collagePhotos.forEach(photo => {
        photo.addEventListener('click', () => {
            const img = photo.querySelector('img');
            if (img) {
                collageModalImage.src = img.src;
                collageModalImage.alt = img.alt;
                collageModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Close modal functions
    function closeCollageModal() {
        collageModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    collageModalClose.addEventListener('click', closeCollageModal);

    collageModalOverlay.addEventListener('click', closeCollageModal);

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && collageModal.classList.contains('active')) {
            closeCollageModal();
        }
    });
}

// Initialize collage modal on DOM ready
document.addEventListener('DOMContentLoaded', initCollageModal);

// ===== COUNTDOWN TIMER =====
function initCountdown() {
    // Sử dụng biến WEDDING_DATE từ index.php
    const weddingDateString = typeof WEDDING_DATE !== 'undefined' ? WEDDING_DATE : '2026-12-13T11:30:00';
    const weddingDate = new Date(weddingDateString).getTime();

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

// ===== CAROUSEL GALLERY =====
let currentSlideIndex = 0;
let carouselSlides = [];
let carouselDots = [];
let autoPlayInterval = null;

function initCarousel() {
    carouselSlides = Array.from(document.querySelectorAll('.carousel-slide'));
    carouselDots = Array.from(document.querySelectorAll('.carousel-dot'));

    if (carouselSlides.length === 0) return;

    // Set first slide as active
    showSlide(0);

    // Add event listeners to dot buttons
    carouselDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlideIndex = index;
            showSlide(index);
            resetAutoPlay();
        });
    });

    // Add event listeners to nav buttons
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');

    if (prevBtn) prevBtn.addEventListener('click', () => {
        currentSlideIndex = (currentSlideIndex - 1 + carouselSlides.length) % carouselSlides.length;
        showSlide(currentSlideIndex);
        resetAutoPlay();
    });

    if (nextBtn) nextBtn.addEventListener('click', () => {
        currentSlideIndex = (currentSlideIndex + 1) % carouselSlides.length;
        showSlide(currentSlideIndex);
        resetAutoPlay();
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        const carouselContainer = document.querySelector('.carousel-container');
        if (!carouselContainer) return;

        if (e.key === 'ArrowLeft') {
            currentSlideIndex = (currentSlideIndex - 1 + carouselSlides.length) % carouselSlides.length;
            showSlide(currentSlideIndex);
            resetAutoPlay();
        } else if (e.key === 'ArrowRight') {
            currentSlideIndex = (currentSlideIndex + 1) % carouselSlides.length;
            showSlide(currentSlideIndex);
            resetAutoPlay();
        }
    });

    // Start auto play
    startAutoPlay();
}

function showSlide(index) {
    if (carouselSlides.length === 0) return;

    // Remove active class from all slides and dots
    carouselSlides.forEach(slide => slide.classList.remove('active'));
    carouselDots.forEach(dot => dot.classList.remove('active'));

    // Add active class to current slide and dot
    carouselSlides[index].classList.add('active');
    carouselDots[index].classList.add('active');
}

function startAutoPlay() {
    // Auto advance slides every 6 seconds
    autoPlayInterval = setInterval(() => {
        currentSlideIndex = (currentSlideIndex + 1) % carouselSlides.length;
        showSlide(currentSlideIndex);
    }, 6000);
}

function resetAutoPlay() {
    if (autoPlayInterval) {
        clearInterval(autoPlayInterval);
    }
    startAutoPlay();
}

// Pause auto play when user hovers over carousel
const carouselContainer = document.querySelector('.carousel-container');
if (carouselContainer) {
    carouselContainer.addEventListener('mouseenter', () => {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
            autoPlayInterval = null;
        }
    });

    carouselContainer.addEventListener('mouseleave', () => {
        startAutoPlay();
    });
}

// Initialize carousel on DOM ready
document.addEventListener('DOMContentLoaded', initCarousel);

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

    // Prepare data to send
    const phone = document.getElementById('phone').value.trim();
    const message = document.getElementById('message').value.trim();

    const dataToSend = {
        fullname: fullname,
        phone: phone,
        guests: parseInt(guests),
        attend: attend.value,
        message: message
    };

    // Disable submit button
    const submitBtn = form.querySelector('button.submit');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Đang gửi...';

    // Send data to API
    fetch('/api/save-rsvp.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataToSend)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            // Show success message
            form.style.display = 'none';
            successBox.classList.add('show');

            // Trigger confetti effect
            createConfetti();

            // Reset form after a delay
            setTimeout(() => {
                form.reset();
                form.style.display = 'block';
                successBox.classList.remove('show');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Gửi xác nhận';
            }, 4000);
        } else {
            // Show error message
            alert('Lỗi: ' + result.message);
            submitBtn.disabled = false;
            submitBtn.textContent = 'Gửi xác nhận';
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Lỗi kết nối. Vui lòng thử lại.');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Gửi xác nhận';
    });
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

