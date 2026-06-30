<?php
/**
 * Test Dashboard Login
 * File kiểm tra xem login có hoạt động không
 */

session_start();

// Thông tin kiểm tra
$info = [
    'php_version' => phpversion(),
    'session_id' => session_id(),
    'session_status' => session_status(),
    'post_data' => $_POST,
    'get_data' => $_GET,
    'session_data' => $_SESSION,
    'files' => [
        'data.json' => file_exists(__DIR__ . '/../data.json'),
        'comments.json' => file_exists(__DIR__ . '/../comments.json'),
        'index.php' => file_exists(__DIR__ . '/index.php'),
        'dashboard.js' => file_exists(__DIR__ . '/dashboard.js'),
        'style.css' => file_exists(__DIR__ . '/style.css'),
    ]
];

// Xử lý login test
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $correct_password = 'admin123';

    if ($password === $correct_password) {
        $_SESSION['dashboard_logged_in'] = true;
        $info['login_result'] = 'SUCCESS - Session set';
        $info['session_after_login'] = $_SESSION;
    } else {
        $info['login_result'] = 'FAILED - Wrong password';
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

