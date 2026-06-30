<?php
/**
 * Dashboard - Quản lý Tiệc Cưới
 * Sử dụng PHP để xử lý backend
 */

// Cấu hình
$DASHBOARD_PASSWORD = 'admin123'; // Thay đổi mật khẩu này!
$DATA_FILE = __DIR__ . '/../data.json';
$COMMENTS_FILE = __DIR__ . '/../comments.json';

// Bắt đầu session
session_start();

// Xử lý logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Xử lý login via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $password = $_POST['password'] ?? '';

    if ($password === $DASHBOARD_PASSWORD) {
        $_SESSION['dashboard_logged_in'] = true;
        $_SESSION['login_time'] = time();
        // Redirect sau khi login thành công
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $login_error = 'Mật khẩu không chính xác!';
    }
}

// Xử lý lấy dữ liệu via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    header('Content-Type: application/json; charset=utf-8');

    if ($_GET['action'] === 'get_data') {
        if (!isset($_SESSION['dashboard_logged_in'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $rsvpData = [];
        $commentsData = [];

        // Đọc RSVP data
        if (file_exists($DATA_FILE)) {
            $data = json_decode(file_get_contents($DATA_FILE), true);
            $rsvpData = $data['rsvp_list'] ?? [];
        }

        // Đọc comments data
        if (file_exists($COMMENTS_FILE)) {
            $data = json_decode(file_get_contents($COMMENTS_FILE), true);
            $commentsData = $data['comments'] ?? [];
        }

        // Tính toán stats
        $totalRsvp = count($rsvpData);
        $confirmed = count(array_filter($rsvpData, fn($x) => ($x['attend'] ?? '') === 'yes'));
        $declined = count(array_filter($rsvpData, fn($x) => ($x['attend'] ?? '') === 'no'));
        $totalGuests = array_sum(array_column($rsvpData, 'guests', null));

        echo json_encode([
            'rsvp' => $rsvpData,
            'comments' => $commentsData,
            'stats' => [
                'total_rsvp' => $totalRsvp,
                'confirmed' => $confirmed,
                'declined' => $declined,
                'total_guests' => $totalGuests
            ]
        ]);
        exit;
    }
}

// Kiểm tra đã đăng nhập
$isLoggedIn = isset($_SESSION['dashboard_logged_in']) && $_SESSION['dashboard_logged_in'] === true;
$login_error = $login_error ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Quản lý Tiệc Cưới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if (!$isLoggedIn): ?>
    <!-- Login Modal -->
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
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="action" value="login">
                        <?php if (!empty($login_error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle"></i> <?php echo htmlspecialchars($login_error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
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
    <?php else: ?>
    <!-- Main Dashboard -->
    <!-- Header -->
    <nav class="navbar navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 text-wedding fw-bold">
                <i class="bi bi-suit-heart-fill"></i> Dashboard Tiệc Cưới
            </span>
            <div>
                <span class="me-3 text-muted">
                    <i class="bi bi-person-circle"></i> Admin
                </span>
                <a href="?logout=1" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container-fluid py-4">
        <!-- Stats Row -->
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

        <!-- Data Tables -->
        <div class="row">
            <!-- RSVP Table -->
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex align-items-center justify-content-between cursor-pointer" id="rsvpHeader">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-table"></i> Danh Sách RSVP
                                <span class="badge bg-wedding ms-2" id="rsvpCount">0</span>
                            </h5>
                            <i class="bi bi-chevron-up fs-5"></i>
                        </div>
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
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox"></i> Đang tải dữ liệu...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Table -->
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex align-items-center justify-content-between cursor-pointer" id="commentsHeader">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-chat-left-text"></i> Danh Sách Bình Luận
                                <span class="badge bg-info ms-2" id="commentsCount">0</span>
                            </h5>
                            <i class="bi bi-chevron-up fs-5"></i>
                        </div>
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
                                    </tr>
                                </thead>
                                <tbody id="commentsTableBody">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox"></i> Đang tải dữ liệu...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-muted small py-4">
            <p>Cập nhật lần cuối: <span id="lastUpdated">--</span></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dashboard.js"></script>
    <?php endif; ?>
</body>
</html>

