<?php
/**
 * Export RSVP Data to CSV
 * File này xuất dữ liệu RSVP ra CSV format (mở được trên Excel)
 */

$dataDir = __DIR__ . '/../data';
$dataFile = $dataDir . '/data.json';

// Tạo folder data nếu chưa có
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

// Tạo file data.json nếu chưa có
if (!file_exists($dataFile)) {
    $defaultData = [
        'total_rsvp' => 0,
        'last_updated' => date('Y-m-d H:i:s'),
        'rsvp_list' => []
    ];
    file_put_contents($dataFile, json_encode($defaultData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Kiểm tra file tồn tại
if (!file_exists($dataFile)) {
    die('File data.json không tồn tại');
}

// Đọc file
$jsonContent = file_get_contents($dataFile);
$data = json_decode($jsonContent, true);

if ($data === null) {
    die('JSON không hợp lệ');
}

$rsvpList = $data['rsvp_list'] ?? [];

// Set header cho CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="rsvp_' . date('Y-m-d_H-i-s') . '.csv"');

// Add UTF-8 BOM để Excel hiển thị Tiếng Việt đúng
echo chr(0xEF).chr(0xBB).chr(0xBF);

// Mở output stream
$output = fopen('php://output', 'w');

// Viết header
fputcsv($output, [
    'ID',
    'Thời gian',
    'Họ tên',
    'Điện thoại',
    'Số người tham dự',
    'Xác nhận',
    'Lời nhắn',
    'IP Address',
    'User Agentv'
], ',');

// Viết dữ liệu
foreach ($rsvpList as $rsvp) {
    fputcsv($output, [
        $rsvp['id'] ?? '',
        $rsvp['timestamp'] ?? '',
        $rsvp['fullname'] ?? '',
        $rsvp['phone'] ?? '',
        $rsvp['guests'] ?? 0,
        ($rsvp['attend'] ?? '') === 'yes' ? 'Chấp nhận' : 'Không',
        $rsvp['message'] ?? '',
        $rsvp['ip_address'] ?? '',
        substr($rsvp['user_agent'] ?? '', 0, 50) // Giới hạn 50 ký tự
    ], ',');
}

fclose($output);
?>

