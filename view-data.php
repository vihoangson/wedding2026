<?php
/**
 * View Data Files
 * File này hiển thị nội dung của data.json và comments.json
 */

header('Content-Type: text/html; charset=utf-8');

$dataDir = __DIR__ . '/data';
$dataFile = $dataDir . '/data.json';
$commentsFile = $dataDir . '/comments.json';

$rsvpData = [];
$commentsData = [];

if (file_exists($dataFile)) {
    $rsvpData = json_decode(file_get_contents($dataFile), true);
}

if (file_exists($commentsFile)) {
    $commentsData = json_decode(file_get_contents($commentsFile), true);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data Files</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        pre {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            font-size: 12px;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
        .info {
            background: #e7f3ff;
            padding: 10px;
            border-left: 4px solid #007bff;
            margin-bottom: 15px;
        }
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <h1>📊 View Data Files</h1>

    <div class="container">
        <!-- RSVP Data -->
        <div class="card">
            <h2>📋 RSVP Data (data.json)</h2>
            <?php if ($rsvpData): ?>
                <div class="info">
                    <strong>Total RSVP:</strong> <?php echo $rsvpData['total_rsvp'] ?? 0; ?><br>
                    <strong>Last Updated:</strong> <?php echo $rsvpData['last_updated'] ?? '-'; ?><br>
                    <strong>Entries:</strong> <?php echo count($rsvpData['rsvp_list'] ?? []); ?>
                </div>
                <pre><?php echo json_encode($rsvpData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
            <?php else: ?>
                <p class="error">❌ File tidak tồn tại</p>
            <?php endif; ?>
        </div>

        <!-- Comments Data -->
        <div class="card">
            <h2>💬 Comments Data (comments.json)</h2>
            <?php if ($commentsData): ?>
                <div class="info">
                    <strong>Total Comments:</strong> <?php echo $commentsData['total_comments'] ?? 0; ?><br>
                    <strong>Last Updated:</strong> <?php echo $commentsData['last_updated'] ?? '-'; ?><br>
                    <strong>Entries:</strong> <?php echo count($commentsData['comments'] ?? []); ?>
                </div>
                <pre><?php echo json_encode($commentsData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
            <?php else: ?>
                <p class="error">❌ File không tồn tại</p>
            <?php endif; ?>
        </div>
    </div>

    <div style="margin-top: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h3>🔍 Kiểm tra Dashboard</h3>
        <p>
            <a href="dashboard/index.php" target="_blank" style="color: #007bff; text-decoration: none;">
                ➡️ Truy cập Dashboard →
            </a>
            (Mật khẩu: admin123)
        </p>
        <p>
            <a href="test-submit.php" style="color: #28a745; text-decoration: none;">
                ➡️ Test Form Submit →
            </a>
        </p>
    </div>
</body>
</html>

