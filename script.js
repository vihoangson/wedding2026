// ==================== SCROLL ANIMATIONS ====================
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all elements with animation classes
    document.querySelectorAll('.detail-card, .profile-card, .gallery-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});

// ==================== RSVP FORM HANDLING ====================
document.getElementById('rsvpForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const guests = document.getElementById('guests').value;
    const dietary = document.getElementById('dietary').value;
    const message = document.getElementById('message').value;

    // Validate form
    if (!name || !email || !phone || !guests) {
        alert('Vui lòng điền đầy đủ các trường bắt buộc!');
        return;
    }

    // In a real application, this would send data to a server
    console.log({
        name: name,
        email: email,
        phone: phone,
        guests: guests,
        dietary: dietary,
        message: message,
        timestamp: new Date().toLocaleString('vi-VN')
    });

    // Store in localStorage for demo purposes
    const rsvpData = {
        name: name,
        email: email,
        phone: phone,
        guests: guests,
        dietary: dietary,
        message: message,
        timestamp: new Date().toLocaleString('vi-VN')
    };

    localStorage.setItem('wedding_rsvp_' + email, JSON.stringify(rsvpData));

    // Show success message
    const form = this;
    const successMessage = document.getElementById('successMessage');

    form.style.display = 'none';
    successMessage.classList.remove('d-none');

    // Reset form after 3 seconds
    setTimeout(() => {
        form.reset();
        form.style.display = 'block';
        successMessage.classList.add('d-none');
    }, 3000);
});

// ==================== SMOOTH SCROLL FOR NAVIGATION ====================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');

        // Skip if href is just '#'
        if (href === '#') return;

        const element = document.querySelector(href);
        if (element) {
            e.preventDefault();

            // Close navbar if it's open
            const navbarToggle = document.querySelector('.navbar-toggler');
            if (navbarToggle.offsetParent !== null) { // If toggler is visible (mobile)
                const navbarCollapse = document.querySelector('.navbar-collapse');
                navbarCollapse.classList.remove('show');
            }

            // Scroll to element
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ==================== NAVBAR STYLING ON SCROLL ====================
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');

    if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.15)';
        navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
    } else {
        navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
        navbar.style.backgroundColor = '';
    }
});

// ==================== COUNTER ANIMATION ====================
function animateCounter(element, target, duration = 2000) {
    let current = 0;
    const increment = target / (duration / 16);

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// ==================== GALLERY LIGHTBOX (Optional) ====================
document.querySelectorAll('.gallery-item').forEach(item => {
    item.addEventListener('click', function() {
        const img = this.querySelector('img');
        const src = img.src;

        // Create lightbox
        const lightbox = document.createElement('div');
        lightbox.className = 'lightbox';
        lightbox.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            cursor: pointer;
        `;

        const imageContainer = document.createElement('div');
        imageContainer.style.cssText = `
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
        `;

        const image = document.createElement('img');
        image.src = src;
        image.style.cssText = `
            width: 100%;
            height: 100%;
            object-fit: contain;
        `;

        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.cssText = `
            position: absolute;
            top: -40px;
            right: 0;
            background: none;
            border: none;
            color: white;
            font-size: 40px;
            cursor: pointer;
        `;

        imageContainer.appendChild(image);
        imageContainer.appendChild(closeBtn);
        lightbox.appendChild(imageContainer);
        document.body.appendChild(lightbox);

        function closeLightbox() {
            lightbox.remove();
        }

        lightbox.addEventListener('click', closeLightbox);
        closeBtn.addEventListener('click', closeLightbox);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        }, { once: true });
    });
});

// ==================== PARALLAX EFFECT ====================
window.addEventListener('scroll', function() {
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        const scrollPosition = window.scrollY;
        heroSection.style.backgroundPosition = `center ${scrollPosition * 0.5}px`;
    }
});

// ==================== PREVENT FORM SUBMISSION TO SERVER ====================
// This is for demo purposes - in production, you'd send this to a backend
document.getElementById('rsvpForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(this);

    // In production, you would do something like:
    // fetch('/api/rsvp', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify(Object.fromEntries(formData))
    // })

    console.log('RSVP submitted:', Object.fromEntries(formData));
});

// ==================== ADD TO CALENDAR FUNCTIONALITY ====================
function addToCalendar() {
    const event = {
        title: 'Lễ Cưới của Thủy & Minh',
        start: new Date(2026, 7, 15, 10, 0), // August 15, 2026 at 10:00
        end: new Date(2026, 7, 15, 23, 0),
        description: 'Lễ cưới của Thủy & Minh'
    };

    // Google Calendar URL
    const googleCalendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(event.title)}&dates=${event.start.toISOString().split('T')[0].replace(/-/g, '')}/${event.end.toISOString().split('T')[0].replace(/-/g, '')}&details=${encodeURIComponent(event.description)}&location=Nh%C3%A0%20h%C3%A0ng%20Ti%E1%BB%87c%20C%C6%B0%E1%BB%9Bi%20Hoa%20Anh%20%C4%90%C3%A0o`;

    window.open(googleCalendarUrl, '_blank');
}

// ==================== LOADING ANIMATION ====================
window.addEventListener('load', function() {
    document.body.style.opacity = '1';
});

// ==================== ACTIVE NAV LINK ON SCROLL ====================
window.addEventListener('scroll', function() {
    let current = '';
    const sections = document.querySelectorAll('section');

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });

    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').slice(1) === current) {
            link.classList.add('active');
        }
    });
});
