// Dashboard - JavaScript Frontend
// Port of the legacy dashboard/dashboard.js, adapted to call the Laravel
// /dashboard/data, /dashboard/invites and /dashboard/comments JSON endpoints instead of
// dashboard/index.php?action=...

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
    loadInvites();
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

    // Guest list / invite link generator
    const generateInvitesBtn = document.getElementById('generateInvitesBtn');
    const invitesTableBody = document.getElementById('invitesTableBody');
    const invitesSearch = document.getElementById('invitesSearch');

    if (generateInvitesBtn) {
        generateInvitesBtn.addEventListener('click', generateInvites);
    }
    if (invitesTableBody) {
        invitesTableBody.addEventListener('click', handleInviteAction);
    }
    if (invitesSearch) {
        invitesSearch.addEventListener('input', renderInvites);
    }
    const invitesFilter = document.getElementById('invitesFilter');
    if (invitesFilter) {
        invitesFilter.addEventListener('change', renderInvites);
    }

    // Approve / hide / delete guest wishes
    const commentsTableBody = document.getElementById('commentsTableBody');
    if (commentsTableBody) {
        commentsTableBody.addEventListener('click', handleCommentAction);
    }
}

// Gọi API có kèm CSRF token (các route PATCH/DELETE của dashboard)
function dashboardRequest(url, method, body) {
    return fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: body ? JSON.stringify(body) : undefined
    });
}

// Duyệt / Ẩn / Xoá lời chúc
async function handleCommentAction(e) {
    const btn = e.target.closest('[data-comment-action]');
    if (!btn) return;

    const id = btn.dataset.id;
    const action = btn.dataset.commentAction;
    const url = window.DASHBOARD_COMMENTS_URL + encodeURIComponent(id);

    if (action === 'delete' && !confirm('Xoá vĩnh viễn lời chúc này?')) {
        return;
    }

    btn.disabled = true;

    try {
        const response = action === 'delete'
            ? await dashboardRequest(url, 'DELETE')
            : await dashboardRequest(url, 'PATCH', { active: action === 'approve' });

        if (response.status === 401) {
            window.location.reload();
            return;
        }
        if (!response.ok) {
            throw new Error('Request failed: ' + response.status);
        }

        await loadDashboardData();
    } catch (err) {
        console.error(err);
        alert('Không thể cập nhật lời chúc, vui lòng thử lại.');
        btn.disabled = false;
    }
}

// ===== Danh sách khách mời =====
// Tên khách được mã hóa ở server (InviterCodec) thành link /invite/<token>;
// server lưu danh sách vào data/invites.json và soạn sẵn tin nhắn Zalo.
let invitesState = [];

async function loadInvites() {
    try {
        const response = await fetch(window.DASHBOARD_INVITES_URL, { headers: { 'Accept': 'application/json' } });
        if (response.status === 401) {
            window.location.reload();
            return;
        }
        if (!response.ok) {
            throw new Error('Failed to load invites: ' + response.status);
        }
        const data = await response.json();
        invitesState = data.invites || [];
        renderInvites();
    } catch (err) {
        console.error(err);
    }
}

async function generateInvites() {
    const textarea = document.getElementById('inviteNames');
    const resultBox = document.getElementById('generateInvitesResult');
    const btn = document.getElementById('generateInvitesBtn');
    const names = (textarea.value || '').trim();

    if (!names) {
        textarea.focus();
        return;
    }

    const originalBtnHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Đang tạo...';

    try {
        const response = await dashboardRequest(window.DASHBOARD_INVITES_URL, 'POST', { names: names });
        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.error || data.message || ('Request failed: ' + response.status));
        }

        textarea.value = '';
        resultBox.innerHTML = `<span class="text-success"><i class="bi bi-check-circle"></i> Đã tạo ${data.created} link mới</span>`
            + (data.existing ? ` <span class="text-muted">· ${data.existing} tên đã có sẵn</span>` : '');
        await loadInvites();
    } catch (err) {
        console.error(err);
        resultBox.innerHTML = `<span class="text-danger">${escapeHtml(err.message || 'Không thể tạo link mời, vui lòng thử lại.')}</span>`;
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalBtnHtml;
    }
}

function renderInvites() {
    const tbody = document.getElementById('invitesTableBody');
    if (!tbody) return;

    const keyword = (document.getElementById('invitesSearch').value || '').trim().toLowerCase();
    const filter = document.getElementById('invitesFilter').value;
    const list = invitesState.filter(invite => {
        if (keyword && !invite.name.toLowerCase().includes(keyword)) return false;
        if (filter === 'opened') return !!invite.open_count;
        if (filter === 'unopened') return !invite.open_count;
        return true;
    });

    const openedCount = invitesState.filter(invite => invite.open_count).length;
    document.getElementById('invitesCount').textContent = invitesState.length;
    document.getElementById('invitesOpenedSummary').textContent =
        invitesState.length ? `${openedCount}/${invitesState.length} đã mở thiệp` : '';

    if (list.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    <i class="bi bi-inbox"></i> ${keyword || filter !== 'all' ? 'Không tìm thấy khách mời' : 'Chưa có khách mời nào'}
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = list.map(invite => `
        <tr>
            <td><strong>${escapeHtml(invite.name)}</strong></td>
            <td>
                <a href="${escapeHtml(invite.link)}" target="_blank" rel="noopener" class="small text-break">${escapeHtml(invite.link)}</a>
            </td>
            <td class="text-nowrap">
                ${invite.open_count
                    ? `<span class="badge bg-success" title="Lần cuối: ${escapeHtml(formatDate(invite.last_opened_at))}">Đã mở · ${invite.open_count} lần</span>
                       <div class="small text-muted">${escapeHtml(formatDate(invite.first_opened_at))}</div>`
                    : '<span class="badge bg-secondary">Chưa mở</span>'
                }
            </td>
            <td class="text-end text-nowrap">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-invite-action="copy-link" data-token="${escapeHtml(invite.token)}" title="Copy link"><i class="bi bi-link-45deg"></i></button>
                <button type="button" class="btn btn-primary btn-sm" data-invite-action="copy-zalo" data-token="${escapeHtml(invite.token)}"><i class="bi bi-chat-dots"></i> Copy Zalo</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-invite-action="delete" data-token="${escapeHtml(invite.token)}" title="Xoá khỏi danh sách"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
    `).join('');
}

async function handleInviteAction(e) {
    const btn = e.target.closest('[data-invite-action]');
    if (!btn) return;

    const invite = invitesState.find(item => item.token === btn.dataset.token);
    if (!invite) return;

    const action = btn.dataset.inviteAction;

    if (action === 'copy-link' || action === 'copy-zalo') {
        await copyText(action === 'copy-zalo' ? invite.message : invite.link);
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check2"></i> Đã copy';
        setTimeout(() => { btn.innerHTML = originalHtml; }, 1500);
        return;
    }

    if (action === 'delete') {
        if (!confirm(`Xoá "${invite.name}" khỏi danh sách?\n(Link đã gửi vẫn mở được thiệp.)`)) return;

        btn.disabled = true;
        try {
            const response = await dashboardRequest(window.DASHBOARD_INVITES_URL + '/' + encodeURIComponent(invite.token), 'DELETE');
            if (!response.ok) throw new Error('Request failed: ' + response.status);
            await loadInvites();
        } catch (err) {
            console.error(err);
            alert('Không thể xoá khách mời, vui lòng thử lại.');
            btn.disabled = false;
        }
    }
}

// Copy vào clipboard (có fallback cho trình duyệt/http không hỗ trợ Clipboard API)
async function copyText(text) {
    try {
        await navigator.clipboard.writeText(text);
    } catch (err) {
        const temp = document.createElement('textarea');
        temp.value = text;
        temp.style.position = 'fixed';
        temp.style.opacity = '0';
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        temp.remove();
    }
}

// Load Dashboard Data từ Laravel Backend
async function loadDashboardData() {
    try {
        const response = await fetch(window.DASHBOARD_DATA_URL);

        if (!response.ok) {
            if (response.status === 401) {
                // Not logged in, redirect to login
                window.location.reload();
                return;
            }
            throw new Error('Failed to load data: ' + response.status);
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
                ${rsvp.updated_at ? `<div><span class="badge bg-warning text-dark">Đã sửa ${formatDate(rsvp.updated_at)}</span></div>` : ''}
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
                <td colspan="5" class="text-center text-muted py-4">
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
                    ? '<span class="badge bg-success">Đang hiển thị</span>'
                    : '<span class="badge bg-secondary">Chờ duyệt</span>'
                }
            </td>
            <td class="text-end text-nowrap">
                ${comment.active === true
                    ? `<button type="button" class="btn btn-outline-secondary btn-sm" data-comment-action="hide" data-id="${escapeHtml(comment.id)}"><i class="bi bi-eye-slash"></i> Ẩn</button>`
                    : `<button type="button" class="btn btn-success btn-sm" data-comment-action="approve" data-id="${escapeHtml(comment.id)}"><i class="bi bi-check-lg"></i> Duyệt</button>`
                }
                <button type="button" class="btn btn-outline-danger btn-sm" data-comment-action="delete" data-id="${escapeHtml(comment.id)}"><i class="bi bi-trash"></i> Xoá</button>
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
