<?php
/**
 * Session Test
 * Kiểm tra xem Session có hoạt động đúng không
 */

session_start();

// Set cache headers
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$info = [];

// Test 1: Session ID
$info['session_id'] = session_id();

// Test 2: Session status
$status = session_status();
$info['session_status'] = $status === PHP_SESSION_ACTIVE ? 'ACTIVE' : ($status === PHP_SESSION_DISABLED ? 'DISABLED' : 'NONE');

// Test 3: Session save path
$info['session_save_path'] = ini_get('session.save_path') ?: 'Default';

// Test 4: Set test value
$_SESSION['test_login'] = true;
$_SESSION['test_time'] = time();

// Test 5: Get values
$info['session_can_write'] = isset($_SESSION['test_login']) ? true : false;
$info['session_data'] = $_SESSION;

// Test 6: Cookie info
$info['cookies'] = $_COOKIE;
$info['cookie_params'] = session_get_cookie_params();

// Output
header('Content-Type: application/json; charset=utf-8');
echo json_encode($info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

