// Dashboard - JavaScript Frontend
// Làm việc với PHP backend

let dashboardState = {
    rsvpCollapsed: false,
    commentsCollapsed: false,
    data: {
        rsvp: [],
        comments: [],
        stats: {}
    }
};

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    setupEventListeners();
    loadDashboardData();
});

// Setup Event Listeners
function setupEventListeners() {
    // Collapse/Expand
    const rsvpHeader = document.getElementById('rsvpHeader');
    const commentsHeader = document.getElementById('commentsHeader');

    if (rsvpHeader) {
        rsvpHeader.addEventListener('click', toggleRsvpTable);
    }
    if (commentsHeader) {
        commentsHeader.addEventListener('click', toggleCommentsTable);
    }
}

// Load Dashboard Data từ PHP Backend
async function loadDashboardData() {
    try {
        const response = await fetch(window.location.pathname + '?action=get_data');

        if (!response.ok) {
            if (response.status === 401) {
                // Not logged in, redirect to login
                window.location.href = window.location.pathname;
                return;
            }
            throw new Error('Failed to load data');
        }

        const data = await response.json();

        dashboardState.data.rsvp = data.rsvp || [];
        dashboardState.data.comments = data.comments || [];
        dashboardState.data.stats = data.stats || {};

        updateDashboard();
    } catch (error) {
        console.error('Error loading data:', error);
    }
}

// Update Dashboard Display
function updateDashboard() {
    const stats = dashboardState.data.stats;
    const rsvpList = dashboardState.data.rsvp;
    const commentsList = dashboardState.data.comments;

    // Update stats
    document.getElementById('totalRsvp').textContent = stats.total_rsvp || 0;
    document.getElementById('confirmedCount').textContent = stats.confirmed || 0;
    document.getElementById('declinedCount').textContent = stats.declined || 0;
    document.getElementById('totalGuests').textContent = stats.total_guests || 0;
    document.getElementById('rsvpCount').textContent = stats.total_rsvp || 0;
    document.getElementById('commentsCount').textContent = commentsList.length || 0;

    // Update tables
    populateRsvpTable(rsvpList);
    populateCommentsTable(commentsList);

    // Update last updated time
    if (rsvpList.length > 0) {
        const lastRsvp = rsvpList[rsvpList.length - 1];
        document.getElementById('lastUpdated').textContent = formatDate(lastRsvp.timestamp);
    }
}

// Populate RSVP Table
function populateRsvpTable(rsvpList) {
    const tbody = document.getElementById('rsvpTableBody');

    if (!rsvpList || rsvpList.length === 0) {
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

    if (!commentsList || commentsList.length === 0) {
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
    const icon = header.querySelector('i');

    dashboardState.rsvpCollapsed = !dashboardState.rsvpCollapsed;

    if (dashboardState.rsvpCollapsed) {
        header.classList.add('collapsed');
        content.style.display = 'none';
        icon.style.transform = 'rotate(-180deg)';
    } else {
        header.classList.remove('collapsed');
        content.style.display = 'block';
        icon.style.transform = 'rotate(0deg)';
    }
}

// Toggle Comments Table
function toggleCommentsTable() {
    const header = document.getElementById('commentsHeader');
    const content = document.getElementById('commentsContent');
    const icon = header.querySelector('i');

    dashboardState.commentsCollapsed = !dashboardState.commentsCollapsed;

    if (dashboardState.commentsCollapsed) {
        header.classList.add('collapsed');
        content.style.display = 'none';
        icon.style.transform = 'rotate(-180deg)';
    } else {
        header.classList.remove('collapsed');
        content.style.display = 'block';
        icon.style.transform = 'rotate(0deg)';
    }
}

// Utility Functions
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

// Auto-refresh data every 10 seconds
setInterval(() => {
    loadDashboardData();
}, 10000);

