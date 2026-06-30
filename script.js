'use strict';

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

