<?php
/**
 * API Save RSVP Data
 * File này xử lý lưu dữ liệu từ form RSVP vào data.json
 */

header('Content-Type: application/json; charset=utf-8');

// Hàm trả về response JSON
function respondJSON($success, $message, $data = null) {
    http_response_code($success ? 200 : 400);
    return json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
}

// Chỉ chấp nhận POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(respondJSON(false, 'Chỉ chấp nhận POST request'));
}

// Lấy dữ liệu từ request
$postData = json_decode(file_get_contents('php://input'), true);

// Validation dữ liệu
$fullname = isset($postData['fullname']) ? trim($postData['fullname']) : '';
$phone = isset($postData['phone']) ? trim($postData['phone']) : '';
$guests = isset($postData['guests']) ? intval($postData['guests']) : 0;
$attend = isset($postData['attend']) ? $postData['attend'] : '';
$message = isset($postData['message']) ? trim($postData['message']) : '';

// Validate required fields
if (empty($fullname)) {
    die(respondJSON(false, 'Vui lòng nhập họ và tên'));
}

if ($guests < 1 || $guests > 10) {
    die(respondJSON(false, 'Số người tham dự phải từ 1 đến 10'));
}

if (!in_array($attend, ['yes', 'no'])) {
    die(respondJSON(false, 'Vui lòng chọn tham dự hoặc không tham dự'));
}

// Validate phone nếu có
if (!empty($phone) && !preg_match('/^[0-9\-\+\s\(\)]{9,15}$/', $phone)) {
    die(respondJSON(false, 'Số điện thoại không hợp lệ'));
}

// Đường dẫn file data.json
$dataFile = __DIR__ . '/../data.json';

// Tạo object dữ liệu mới
$newRSVP = [
    'id' => uniqid('rsvp_', true),
    'timestamp' => date('Y-m-d H:i:s'),
    'fullname' => htmlspecialchars($fullname),
    'phone' => !empty($phone) ? htmlspecialchars($phone) : '',
    'guests' => $guests,
    'attend' => $attend,
    'message' => !empty($message) ? htmlspecialchars($message) : '',
    'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
    'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 255) : ''
];

// Đọc file data.json hiện tại
$rsvpData = [];
if (file_exists($dataFile)) {
    $jsonContent = file_get_contents($dataFile);
    $data = json_decode($jsonContent, true);
    if ($data && isset($data['rsvp_list'])) {
        $rsvpData = $data['rsvp_list'];
    }
}

// Thêm RSVP mới vào danh sách
$rsvpData[] = $newRSVP;

// Chuẩn bị dữ liệu để lưu
$saveData = [
    'total_rsvp' => count($rsvpData),
    'last_updated' => date('Y-m-d H:i:s'),
    'rsvp_list' => $rsvpData
];

// Lưu vào file
if (file_put_contents($dataFile, json_encode($saveData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX)) {
    // Lưu thành công - Không trả về dữ liệu nhạy cảm
    $responseData = [
        'id' => $newRSVP['id'],
        'fullname' => $newRSVP['fullname'],
        'attend' => $newRSVP['attend'],
        'guests' => $newRSVP['guests']
    ];
    die(respondJSON(true, 'Cảm ơn bạn! Xác nhận tham dự đã được ghi nhận.', $responseData));
} else {
    // Lỗi khi lưu file
    die(respondJSON(false, 'Lỗi: Không thể lưu dữ liệu. Vui lòng thử lại.'));
}
?>

