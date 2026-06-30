<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Quick Start</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --wedding-color: #d946a6;
        }
        body {
            background: linear-gradient(135deg, #f5e6ee 0%, #faf8fc 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
        }
        .text-wedding {
            color: var(--wedding-color);
        }
        .btn-wedding {
            background-color: var(--wedding-color);
            border-color: var(--wedding-color);
            color: white;
        }
        .btn-wedding:hover {
            background-color: #be185d;
            border-color: #be185d;
            color: white;
        }
        .status-ok {
            color: #198754;
        }
        .status-error {
            color: #dc3545;
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(217, 70, 166, 0.1);
            margin-bottom: 20px;
        }
        code {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="text-wedding fw-bold mb-2">
                <i class="bi bi-suit-heart-fill"></i> Dashboard Tiệc Cưới
            </h1>
            <p class="text-muted">Quick Start & Verification</p>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <a href="index.php" class="btn btn-wedding btn-lg w-100">
                    <i class="bi bi-speedometer2"></i> Vào Dashboard
                </a>
            </div>
            <div class="col-md-6 mb-3">
                <button class="btn btn-outline-secondary btn-lg w-100" id="checkBtn">
                    <i class="bi bi-check-circle"></i> Kiểm Tra Hệ Thống
                </button>
            </div>
        </div>

        <hr>

        <!-- System Info -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-gear"></i> Thông Tin Hệ Thống</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>PHP Version:</strong> <code><?php echo phpversion(); ?></code></p>
                        <p><strong>Server:</strong> <code><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></code></p>
                        <p><strong>OS:</strong> <code><?php echo php_uname(); ?></code></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Session Path:</strong> <code><?php echo ini_get('session.save_path') ?: 'Default'; ?></code></p>
                        <p><strong>Upload Max:</strong> <code><?php echo ini_get('upload_max_filesize'); ?></code></p>
                        <p><strong>Memory Limit:</strong> <code><?php echo ini_get('memory_limit'); ?></code></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Check -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-file-check"></i> Kiểm Tra File</h5>
            </div>
            <div class="card-body">
                <?php
                    $files = [
                        'index.php' => __DIR__ . '/index.php',
                        'dashboard.js' => __DIR__ . '/dashboard.js',
                        'style.css' => __DIR__ . '/style.css',
                        'test.php' => __DIR__ . '/test.php',
                        'data/ (folder)' => __DIR__ . '/../data',
                        'data/data.json' => __DIR__ . '/../data/data.json',
                        'data/comments.json' => __DIR__ . '/../data/comments.json',
                        'data/.gitkeep' => __DIR__ . '/../data/.gitkeep',
                    ];

                    foreach ($files as $name => $path):
                        $exists = file_exists($path);
                        $status = $exists ? '<span class="status-ok"><i class="bi bi-check-circle"></i> OK</span>' : '<span class="status-error"><i class="bi bi-x-circle"></i> NOT FOUND</span>';
                        echo "<p><strong>$name</strong> ... $status</p>";
                    endforeach;
                ?>
            </div>
        </div>

        <!-- Session Check -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Kiểm Tra Session</h5>
            </div>
            <div class="card-body">
                <?php
                    session_start();
                    echo "<p><strong>Session ID:</strong> <code>" . session_id() . "</code></p>";
                    echo "<p><strong>Session Status:</strong> ";

                    $status = session_status();
                    if ($status === PHP_SESSION_ACTIVE) {
                        echo '<span class="status-ok">ACTIVE</span>';
                    } elseif ($status === PHP_SESSION_DISABLED) {
                        echo '<span class="status-error">DISABLED</span>';
                    } else {
                        echo '<span class="status-error">NONE</span>';
                    }
                    echo "</p>";

                    // Test session write
                    $_SESSION['test_key'] = 'test_value_' . time();
                    $session_test = isset($_SESSION['test_key']) ? '<span class="status-ok">WRITABLE</span>' : '<span class="status-error">NOT WRITABLE</span>';
                    echo "<p><strong>Session Writable:</strong> $session_test</p>";
                ?>
            </div>
        </div>

        <!-- JSON Data Check -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-database"></i> Dữ Liệu JSON</h5>
            </div>
            <div class="card-body">
                <?php
                    $dataFile = __DIR__ . '/../data/data.json';
                    $commentsFile = __DIR__ . '/../data/comments.json';

                    // Check data.json
                    if (file_exists($dataFile)) {
                        $data = json_decode(file_get_contents($dataFile), true);
                        echo "<p><strong>data/data.json:</strong> ";
                        echo "<span class='status-ok'>EXISTS</span>";
                        echo " | RSVP Count: <code>" . count($data['rsvp_list'] ?? []) . "</code>";
                        echo "</p>";
                    } else {
                        echo "<p><strong>data/data.json:</strong> <span class='status-error'>NOT FOUND</span></p>";
                    }

                    // Check comments.json
                    if (file_exists($commentsFile)) {
                        $comments = json_decode(file_get_contents($commentsFile), true);
                        echo "<p><strong>data/comments.json:</strong> ";
                        echo "<span class='status-ok'>EXISTS</span>";
                        echo " | Comments Count: <code>" . count($comments['comments'] ?? []) . "</code>";
                        echo "</p>";
                    } else {
                        echo "<p><strong>data/comments.json:</strong> <span class='status-error'>NOT FOUND</span></p>";
                    }
                ?>
            </div>
        </div>

        <!-- Login Test -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-key"></i> Test Login</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="input-group">
                        <input type="password" class="form-control" id="testPassword" name="test_password" placeholder="Nhập test_password: admin123">
                        <button class="btn btn-wedding" type="submit" name="test_login">Test</button>
                    </div>
                </form>

                <?php
                    if (isset($_POST['test_login'])) {
                        $testPassword = $_POST['test_password'] ?? '';
                        $correctPassword = 'admin123';

                        if ($testPassword === $correctPassword) {
                            echo '<div class="alert alert-success mt-3"><i class="bi bi-check-circle"></i> <strong>✅ Login TEST OK!</strong> Mật khẩu chính xác.</div>';
                        } else {
                            echo '<div class="alert alert-danger mt-3"><i class="bi bi-x-circle"></i> <strong>❌ Login TEST FAILED!</strong> Mật khẩu không chính xác.</div>';
                        }
                    }
                ?>
            </div>
        </div>

        <!-- Instructions -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-book"></i> Hướng Dẫn</h5>
            </div>
            <div class="card-body">
                <h6>1️⃣ Login vào Dashboard:</h6>
                <ul>
                    <li>Sử dụng mật khẩu mặc định: <code>admin123</code></li>
                    <li>Để thay đổi mật khẩu, sửa file <code>index.php</code> dòng 8</li>
                </ul>

                <h6>2️⃣ Kiểm tra xem hệ thống OK không:</h6>
                <ul>
                    <li>✅ Tất cả file phải có status OK</li>
                    <li>✅ Session phải ACTIVE và WRITABLE</li>
                    <li>✅ File JSON phải EXISTS</li>
                    <li>✅ Login test phải PASS</li>
                </ul>

                <h6>3️⃣ Nếu có lỗi:</h6>
                <ul>
                    <li>Kiểm tra quyền file (chmod 644)</li>
                    <li>Kiểm tra PHP version (cần 7.0+)</li>
                    <li>Kiểm tra session.save_path có hợp lệ không</li>
                    <li>Xóa cookies browser và thử lại</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-muted mt-5">
            <small><i class="bi bi-heart-fill text-wedding"></i> Dashboard v1.0 | Created 2026-06-30</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('checkBtn').addEventListener('click', function() {
            window.location.reload();
        });
    </script>
</body>
</html>

