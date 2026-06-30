<?php
/**
 * View RSVP Data
 * File này hiển thị dữ liệu RSVP dưới dạng JSON hoặc HTML table
 */

// Lấy tham số từ URL
$format = isset($_GET['format']) ? $_GET['format'] : 'json'; // json, html, csv
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
    if ($format === 'json') {
        header('Content-Type: application/json; charset=utf-8');
        die(json_encode(['error' => 'File data.json không tồn tại']));
    } else {
        die('File data.json không tồn tại');
    }
}

// Đọc file
$jsonContent = file_get_contents($dataFile);
$data = json_decode($jsonContent, true);

if ($data === null) {
    if ($format === 'json') {
        header('Content-Type: application/json; charset=utf-8');
        die(json_encode(['error' => 'JSON không hợp lệ']));
    } else {
        die('JSON không hợp lệ');
    }
}

$rsvpList = $data['rsvp_list'] ?? [];

// JSON Format
if ($format === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// CSV Format
if ($format === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="rsvp_' . date('Y-m-d') . '.csv"');

    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel

    fputcsv($output, ['ID', 'Thời gian', 'Họ tên', 'Điện thoại', 'Số khách', 'Tham dự', 'Lời nhắn', 'IP']);

    foreach ($rsvpList as $item) {
        fputcsv($output, [
            $item['id'] ?? '',
            $item['timestamp'] ?? '',
            $item['fullname'] ?? '',
            $item['phone'] ?? '',
            $item['guests'] ?? 0,
            $item['attend'] ?? '',
            $item['message'] ?? '',
            $item['ip_address'] ?? ''
        ]);
    }

    fclose($output);
    exit;
}

// HTML Format (Default)
header('Content-Type: text/html; charset=utf-8');

$totalRSVP = count($rsvpList);
$confirmed = count(array_filter($rsvpList, fn($x) => ($x['attend'] ?? '') === 'yes'));
$declined = count(array_filter($rsvpList, fn($x) => ($x['attend'] ?? '') === 'no'));
$totalGuests = array_sum(array_column($rsvpList, 'guests', null));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Dashboard RSVP</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Jost', sans-serif;
            background: linear-gradient(135deg, #fbe9ec 0%, #f3d2da 100%), #fffaf6;
            padding: 30px 20px;
            margin: 0;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(142, 68, 82, 0.1);
            padding: 40px;
        }
        h1 {
            color: #8e4452;
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-box {
            background: linear-gradient(135deg, rgba(251, 233, 236, 0.8), rgba(243, 210, 218, 0.6));
            border: 1px solid #e7c3ca;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(142, 68, 82, 0.1);
        }
        .stat-label {
            color: #8a7174;
            font-size: 13px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #8e4452;
        }
        .controls {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn {
            padding: 10px 20px;
            background: #c9a87c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #8e4452;
            transform: translateY(-2px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #8e4452;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e7c3ca;
        }
        tr:hover {
            background: #fffaf6;
        }
        .yes {
            color: #2e7d32;
            font-weight: 600;
        }
        .no {
            color: #c62828;
            font-weight: 600;
        }
        .empty {
            text-align: center;
            padding: 40px;
            color: #8a7174;
        }
        .last-updated {
            text-align: center;
            color: #8a7174;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e7c3ca;
        }
        @media (max-width: 768px) {
            .container { padding: 20px; }
            h1 { font-size: 24px; }
            table { font-size: 12px; }
            th, td { padding: 8px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Dashboard RSVP - Xác Nhận Tham Dự</h1>

        <div class="stats">
            <div class="stat-box">
                <div class="stat-label">Tổng RSVP</div>
                <div class="stat-number"><?php echo $totalRSVP; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">✓ Tham Dự</div>
                <div class="stat-number yes"><?php echo $confirmed; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">✗ Vắng Mặt</div>
                <div class="stat-number no"><?php echo $declined; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">👥 Tổng Khách</div>
                <div class="stat-number"><?php echo $totalGuests; ?></div>
            </div>
        </div>

        <div class="controls">
            <a href="?format=html" class="btn" title="Xem trên web">📊 HTML</a>
            <a href="?format=json" class="btn" title="Tải JSON">📄 JSON</a>
            <a href="?format=csv" class="btn" title="Xuất CSV/Excel">📥 CSV</a>
            <button class="btn" onclick="location.reload()" title="Làm mới">🔄 Làm Mới</button>
        </div>

        <?php if ($totalRSVP > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Họ tên</th>
                        <th>Điện thoại</th>
                        <th>Số khách</th>
                        <th>Tham dự</th>
                        <th>Lời nhắn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rsvpList as $rsvp): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rsvp['timestamp'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($rsvp['fullname'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($rsvp['phone'] ?? ''); ?></td>
                        <td><?php echo $rsvp['guests'] ?? 0; ?></td>
                        <td class="<?php echo $rsvp['attend']; ?>">
                            <?php echo ($rsvp['attend'] ?? '') === 'yes' ? '✓ Chấp nhận' : '✗ Không'; ?>
                        </td>
                        <td><?php echo htmlspecialchars($rsvp['message'] ?? ''); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">
                <p>Chưa có dữ liệu RSVP nào</p>
                <small>Dữ liệu sẽ xuất hiện ở đây khi khách bắt đầu gửi xác nhận</small>
            </div>
        <?php endif; ?>

        <div class="last-updated">
            <strong>Cập nhật lần cuối:</strong> <?php echo $data['last_updated'] ?? 'N/A'; ?>
        </div>
    </div>
</body>
</html>

