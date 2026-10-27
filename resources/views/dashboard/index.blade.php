<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Tiệc Cưới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/dashboard.css">
</head>
<body>
@if(!$isLoggedIn)

    <!-- LOGIN FORM -->
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: linear-gradient(135deg, #f5e6ee 0%, #faf8fc 100%);">
        <div style="width: 100%; max-width: 400px; padding: 20px;">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-wedding mb-2">
                            <i class="bi bi-suit-heart-fill"></i> Dashboard
                        </h2>
                        <p class="text-muted">Vui lòng đăng nhập để tiếp tục</p>
                    </div>
                    <form method="POST" action="{{ route('dashboard.login') }}">
                        @csrf
                        @if(!empty($loginError))
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-circle"></i> {{ $loginError }}
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="password" class="form-label fw-500">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Nhập mật khẩu" required autofocus>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-wedding btn-lg w-100 fw-600">
                            <i class="bi bi-lock"></i> Đăng Nhập
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        });
    </script>

@else

    <!-- DASHBOARD -->
    <nav class="navbar navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 text-wedding fw-bold">
                <i class="bi bi-suit-heart-fill"></i> Dashboard Tiệc Cưới
            </span>
            <div>
                <a href="{{ route('dashboard.config') }}" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="bi bi-images"></i> Cấu hình ảnh & video
                </a>
                <span class="me-3 text-muted">
                    <i class="bi bi-person-circle"></i> Admin
                </span>
                <form method="POST" action="{{ route('dashboard.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <!-- Guest list / invite link generator -->
        <div class="row mb-4">
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-link-45deg"></i> Danh Sách Khách Mời
                            <span class="badge bg-wedding ms-2" id="invitesCount">0</span>
                        </h5>
                        <a href="{{ route('dashboard.invites.export') }}" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Xuất Excel
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <label for="inviteNames" class="form-label fw-500">Tên khách mời <small class="text-muted">(mỗi dòng một người)</small></label>
                                <textarea class="form-control" id="inviteNames" rows="6" placeholder="Anh Nguyễn Văn A&#10;Chị Trần Thị B&#10;Gia đình chú Ba"></textarea>
                                <button type="button" class="btn btn-wedding w-100 fw-600 mt-2" id="generateInvitesBtn">
                                    <i class="bi bi-magic"></i> Tạo Link
                                </button>
                                <div class="small mt-2" id="generateInvitesResult"></div>
                            </div>
                            <div class="col-lg-8">
                                <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                                    <input type="search" class="form-control form-control-sm flex-grow-1 w-auto" id="invitesSearch" placeholder="Tìm theo tên...">
                                    <select class="form-select form-select-sm w-auto" id="invitesFilter">
                                        <option value="all">Tất cả</option>
                                        <option value="unopened">Chưa mở thiệp</option>
                                        <option value="opened">Đã mở thiệp</option>
                                    </select>
                                    <small class="text-muted text-nowrap" id="invitesOpenedSummary"></small>
                                </div>
                                <div class="table-responsive" style="max-height: 420px;">
                                    <table class="table table-hover table-sm align-middle mb-0">
                                        <thead class="bg-light sticky-top">
                                            <tr>
                                                <th class="text-muted fw-600">Tên khách</th>
                                                <th class="text-muted fw-600">Link</th>
                                                <th class="text-muted fw-600">Mở thiệp</th>
                                                <th class="text-muted fw-600 text-end">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="invitesTableBody">
                                            <tr><td colspan="4" class="text-center text-muted py-4">Đang tải...</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-2">
                            <i class="bi bi-people-fill text-wedding"></i>
                        </div>
                        <h6 class="card-title text-muted text-uppercase fw-600 mb-2">Tổng RSVP</h6>
                        <h2 class="card-text fw-bold text-wedding" id="totalRsvp">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-2">
                            <i class="bi bi-check-circle-fill text-success"></i>
                        </div>
                        <h6 class="card-title text-muted text-uppercase fw-600 mb-2">Tham Dự</h6>
                        <h2 class="card-text fw-bold text-success" id="confirmedCount">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-2">
                            <i class="bi bi-x-circle-fill text-danger"></i>
                        </div>
                        <h6 class="card-title text-muted text-uppercase fw-600 mb-2">Không Tham Dự</h6>
                        <h2 class="card-text fw-bold text-danger" id="declinedCount">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-2">
                            <i class="bi bi-people-fill text-info"></i>
                        </div>
                        <h6 class="card-title text-muted text-uppercase fw-600 mb-2">Tổng Khách</h6>
                        <h2 class="card-text fw-bold text-info" id="totalGuests">0</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- RSVP Table -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 cursor-pointer" id="rsvpHeader">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-table"></i> Danh Sách RSVP
                            <span class="badge bg-wedding ms-2" id="rsvpCount">0</span>
                        </h5>
                    </div>
                    <div class="card-body p-0" id="rsvpContent">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-muted fw-600">Thời gian</th>
                                        <th class="text-muted fw-600">Họ tên</th>
                                        <th class="text-muted fw-600">Điện thoại</th>
                                        <th class="text-muted fw-600">Số khách</th>
                                        <th class="text-muted fw-600">Tham dự</th>
                                        <th class="text-muted fw-600">Lời nhắn</th>
                                    </tr>
                                </thead>
                                <tbody id="rsvpTableBody">
                                    <tr><td colspan="6" class="text-center text-muted py-4">Đang tải...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Table -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 cursor-pointer" id="commentsHeader">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-chat-left-text"></i> Danh Sách Bình Luận
                            <span class="badge bg-info ms-2" id="commentsCount">0</span>
                        </h5>
                    </div>
                    <div class="card-body p-0" id="commentsContent">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-muted fw-600">ID</th>
                                        <th class="text-muted fw-600">Tên</th>
                                        <th class="text-muted fw-600">Tin nhắn</th>
                                        <th class="text-muted fw-600">Trạng thái</th>
                                        <th class="text-muted fw-600 text-end">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="commentsTableBody">
                                    <tr><td colspan="5" class="text-center text-muted py-4">Đang tải...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.DASHBOARD_DATA_URL = "{{ route('dashboard.data') }}";
        window.DASHBOARD_COMMENTS_URL = "{{ url('/dashboard/comments') }}/";
        window.DASHBOARD_INVITES_URL = "{{ route('dashboard.invites.index') }}";
    </script>
    <script src="/dashboard.js"></script>

@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
