// Dashboard Configuration
const DASHBOARD_CONFIG = {
    PASSWORD: 'admin123', // Default password - Change this!
    API_BASE: '../api'
};

// State
let dashboardState = {
    isLoggedIn: false,
    rsvpCollapsed: false,
    commentsCollapsed: false,
    data: {
        rsvp: [],
        comments: []
    }
};

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    initializeDashboard();
    setupEventListeners();
    checkLoginStatus();
});

// Initialize Dashboard
function initializeDashboard() {
    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'), {
        keyboard: false,
        backdrop: 'static'
    });
    loginModal.show();
}

// Setup Event Listeners
function setupEventListeners() {
    // Login
    document.getElementById('loginForm').addEventListener('submit', handleLogin);
    document.getElementById('togglePassword').addEventListener('click', togglePasswordVisibility);

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', handleLogout);

    // Collapse/Expand
    document.getElementById('rsvpHeader').addEventListener('click', toggleRsvpTable);
    document.getElementById('commentsHeader').addEventListener('click', toggleCommentsTable);
}

// Login Handler
function handleLogin(e) {
    e.preventDefault();
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('errorMessage');

    if (password === DASHBOARD_CONFIG.PASSWORD) {
        dashboardState.isLoggedIn = true;
        localStorage.setItem('dashboardLoggedIn', 'true');
        localStorage.setItem('loginTime', Date.now());

        // Hide login modal and show dashboard
        const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
        loginModal.hide();

        document.getElementById('mainDashboard').classList.remove('d-none');
        errorMessage.classList.add('d-none');

        // Load data
        loadDashboardData();
    } else {
        errorMessage.textContent = 'Mật khẩu không chính xác!';
        errorMessage.classList.remove('d-none');
    }
}

// Toggle Password Visibility
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('togglePassword');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        passwordInput.type = 'password';
        toggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
    }
}

// Check Login Status
function checkLoginStatus() {
    const isLoggedIn = localStorage.getItem('dashboardLoggedIn') === 'true';
    if (isLoggedIn) {
        dashboardState.isLoggedIn = true;
        const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
        if (loginModal) loginModal.hide();

        document.getElementById('mainDashboard').classList.remove('d-none');
        loadDashboardData();
    }
}

// Logout Handler
function handleLogout() {
    localStorage.removeItem('dashboardLoggedIn');
    localStorage.removeItem('loginTime');
    dashboardState.isLoggedIn = false;

    document.getElementById('mainDashboard').classList.add('d-none');
    document.getElementById('password').value = '';

    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'), {
        keyboard: false,
        backdrop: 'static'
    });
    loginModal.show();
}

// Load Dashboard Data
async function loadDashboardData() {
    try {
        const [rsvpData, commentsData] = await Promise.all([
            fetch(DASHBOARD_CONFIG.API_BASE + '/view-data.php?format=json').then(r => r.json()),
            loadCommentsData()
        ]);

        dashboardState.data.rsvp = rsvpData.rsvp_list || [];
        dashboardState.data.comments = commentsData.comments || [];

        updateDashboard();
    } catch (error) {
        console.error('Error loading data:', error);
        showToast('Lỗi', 'Không thể tải dữ liệu. Vui lòng làm mới trang.', 'danger');
    }
}

// Load Comments Data
async function loadCommentsData() {
    try {
        const response = await fetch('../comments.json');
        return await response.json();
    } catch (error) {
        console.error('Error loading comments:', error);
        return { comments: [] };
    }
}

// Update Dashboard
function updateDashboard() {
    const rsvpList = dashboardState.data.rsvp;
    const commentsList = dashboardState.data.comments;

    // Calculate stats
    const totalRsvp = rsvpList.length;
    const confirmed = rsvpList.filter(r => r.attend === 'yes').length;
    const declined = rsvpList.filter(r => r.attend === 'no').length;
    const totalGuests = rsvpList.reduce((sum, r) => sum + (r.guests || 0), 0);

    // Update stats
    document.getElementById('totalRsvp').textContent = totalRsvp;
    document.getElementById('confirmedCount').textContent = confirmed;
    document.getElementById('declinedCount').textContent = declined;
    document.getElementById('totalGuests').textContent = totalGuests;
    document.getElementById('rsvpCount').textContent = totalRsvp;
    document.getElementById('commentsCount').textContent = commentsList.length;

    // Update tables
    populateRsvpTable(rsvpList);
    populateCommentsTable(commentsList);

    // Update last updated time
    if (rsvpList.length > 0) {
        const lastRsvp = rsvpList[rsvpList.length - 1];
        document.getElementById('lastUpdated').textContent = lastRsvp.timestamp || '--';
    }
}

// Populate RSVP Table
function populateRsvpTable(rsvpList) {
    const tbody = document.getElementById('rsvpTableBody');

    if (rsvpList.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    <i class="bi bi-inbox"></i> Chưa có dữ liệu RSVP
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = rsvpList.map(rsvp => `
        <tr>
            <td>
                <small class="text-muted">${formatDate(rsvp.timestamp)}</small>
            </td>
            <td>
                <strong>${escapeHtml(rsvp.fullname)}</strong>
            </td>
            <td>
                <small>${rsvp.phone ? escapeHtml(rsvp.phone) : '-'}</small>
            </td>
            <td>
                <span class="badge bg-info">${rsvp.guests || 0}</span>
            </td>
            <td>
                ${rsvp.attend === 'yes' 
                    ? '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Tham dự</span>' 
                    : '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Từ chối</span>'
                }
            </td>
            <td>
                <small>${rsvp.message ? escapeHtml(rsvp.message) : '-'}</small>
            </td>
        </tr>
    `).join('');
}

// Populate Comments Table
function populateCommentsTable(commentsList) {
    const tbody = document.getElementById('commentsTableBody');

    if (commentsList.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    <i class="bi bi-inbox"></i> Chưa có bình luận
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = commentsList.map((comment, index) => `
        <tr>
            <td>
                <small class="text-muted">#${index + 1}</small>
            </td>
            <td>
                <strong>${escapeHtml(comment.name)}</strong>
            </td>
            <td>
                <small>${escapeHtml(comment.message)}</small>
            </td>
            <td>
                ${comment.active === true 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-secondary">Inactive</span>'
                }
            </td>
        </tr>
    `).join('');
}

// Toggle RSVP Table
function toggleRsvpTable() {
    const header = document.getElementById('rsvpHeader');
    const content = document.getElementById('rsvpContent');

    dashboardState.rsvpCollapsed = !dashboardState.rsvpCollapsed;

    if (dashboardState.rsvpCollapsed) {
        header.classList.add('collapsed');
        content.style.display = 'none';
    } else {
        header.classList.remove('collapsed');
        content.style.display = 'block';
    }
}

// Toggle Comments Table
function toggleCommentsTable() {
    const header = document.getElementById('commentsHeader');
    const content = document.getElementById('commentsContent');

    dashboardState.commentsCollapsed = !dashboardState.commentsCollapsed;

    if (dashboardState.commentsCollapsed) {
        header.classList.add('collapsed');
        content.style.display = 'none';
    } else {
        header.classList.remove('collapsed');
        content.style.display = 'block';
    }
}

// Utilities
function formatDate(dateString) {
    if (!dateString) return '--';
    const date = new Date(dateString);
    return date.toLocaleString('vi-VN', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

function showToast(title, message, type = 'info') {
    const toastHtml = `
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-${type} text-white">
                <strong class="me-auto">${title}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;

    const toastContainer = document.createElement('div');
    toastContainer.className = 'position-fixed top-0 end-0 p-3';
    toastContainer.style.zIndex = 11;
    toastContainer.innerHTML = toastHtml;

    document.body.appendChild(toastContainer);

    const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'));
    toast.show();

    setTimeout(() => toastContainer.remove(), 5000);
}

// Auto-refresh data every 10 seconds
setInterval(() => {
    if (dashboardState.isLoggedIn) {
        loadDashboardData();
    }
}, 10000);

