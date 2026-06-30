<?php
// Include file cấu hình
require_once 'config.php';

// Hàm để lấy danh sách lời chúc từ comments.json
function getActiveComments() {
    // Đọc từ data folder (nơi save-rsvp.php lưu)
    $commentsFile = __DIR__ . '/data/comments.json';

    if (!file_exists($commentsFile)) {
        return [];
    }

    $jsonContent = file_get_contents($commentsFile);
    $data = json_decode($jsonContent, true);

    if ($data && isset($data['comments'])) {
        // Lọc chỉ những comment có active = true
        return array_filter($data['comments'], function($comment) {
            return isset($comment['active']) && $comment['active'] === true;
        });
    }

    return [];
}

// Lấy danh sách lời chúc hoạt động
$activeComments = getActiveComments();

// Hàm tính toán tên ngày trong tuần
function getDayName($dateString) {
    $date = new DateTime($dateString);
    $days = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
    return $days[$date->format('w')];
}

// Hàm format ngày cưới
$weddingDay = getDayName($wedding_date);
$formattedDate = DateTime::createFromFormat('Y-m-d', $wedding_date)->format('d . m . Y');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Thiệp mời cưới — <?php echo htmlspecialchars($groom_name); ?> & <?php echo htmlspecialchars($bride_name); ?>. Xác nhận tham dự buổi lễ cưới ngày <?php echo $formattedDate; ?>">
    <meta name="theme-color" content="#fffaf6">
    <title>Thiệp mời & RSVP — <?php echo htmlspecialchars($groom_name); ?> & <?php echo htmlspecialchars($bride_name); ?> | Đám cưới 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="invitation" role="main" aria-label="Trang thiệp mời cưới">
    <div class="eyebrow">Trân trọng kính mời</div>
    <div class="monogram"><?php echo htmlspecialchars($groom_initial); ?> &nbsp;•&nbsp; <?php echo htmlspecialchars($bride_initial); ?></div>

    <div class="divider" aria-hidden="true">
        <div class="line"></div>
        <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
            <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
        </svg>
        <div class="line"></div>
    </div>

    <h1 class="names"><?php echo htmlspecialchars($groom_name); ?><span class="amp">&amp;</span><?php echo htmlspecialchars($bride_name); ?></h1>
    <div class="subtitle">Sẽ nên duyên vợ chồng</div>

    <div class="details">
        <div class="item">
            <div class="label">Ngày cưới</div>
            <time class="value" datetime="<?php echo $wedding_date; ?>"><?php echo $formattedDate; ?></time>
            <div class="sub"><?php echo htmlspecialchars($weddingDay); ?></div>
        </div>
        <div class="item">
            <div class="label">Giờ</div>
            <time class="value"><?php echo htmlspecialchars($wedding_time); ?></time>
            <div class="sub"><?php echo htmlspecialchars($wedding_time_label); ?></div>
        </div>
        <div class="item">
            <div class="label">Địa điểm</div>
            <div class="value"><?php echo htmlspecialchars($venue_name); ?></div>
            <div class="sub"><?php echo htmlspecialchars($venue_location); ?></div>
        </div>
    </div>

    <!-- Countdown Timer -->
    <div class="countdown-section">
        <div class="countdown-title">Chờ đợi ngày trọng đại</div>
        <div class="countdown" id="countdown">
            <div class="countdown-item">
                <div class="countdown-value" id="days">00</div>
                <div class="countdown-label">Ngày</div>
            </div>
            <div class="countdown-item">
                <div class="countdown-value" id="hours">00</div>
                <div class="countdown-label">Giờ</div>
            </div>
            <div class="countdown-item">
                <div class="countdown-value" id="minutes">00</div>
                <div class="countdown-label">Phút</div>
            </div>
            <div class="countdown-item">
                <div class="countdown-value" id="seconds">00</div>
                <div class="countdown-label">Giây</div>
            </div>
        </div>
    </div>

    <p class="quote"><?php echo $quote; ?></p>

    <!-- Block Venue Map -->
    <div class="map-section">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="map-title">Địa điểm lễ cưới222</div>
        <div class="map-container">
            <iframe src="<?php echo htmlspecialchars($google_maps_url); ?>" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <p class="map-text">📍 <?php echo htmlspecialchars($venue_full_name); ?><br><?php echo htmlspecialchars($venue_location); ?>, Việt Nam</p>
    </div>

    <div class="gallery-section">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="gallery-title">Khoảnh khắc của chúng tôi</div>
        <p class="gallery-subtitle">Nhấp vào ảnh để xem toàn bộ kích thước</p>

        <div class="gallery-grid" role="region" aria-label="Thư viện ảnh">
            <?php foreach ($gallery_images as $index => $image): ?>
                <figure class="g-item <?php echo ($image['featured'] ?? false) ? 'g-large' : ''; ?>" data-img="<?php echo htmlspecialchars($image['url']); ?>">
                    <img src="<?php echo htmlspecialchars($image['url']); ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>">
                    <div class="g-overlay">
                        <svg class="g-icon" width="40" height="40" viewBox="0 0 24 24" fill="none">
                            <path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="2"/>
                            <path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div class="lightbox" id="lightbox">
        <div class="lightbox-overlay"></div>
        <div class="lightbox-content">
            <button class="lightbox-close" id="lightboxClose">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <button class="lightbox-nav lightbox-prev" id="lightboxPrev">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <img class="lightbox-image" id="lightboxImage" src="" alt="Full size image">
            <button class="lightbox-nav lightbox-next" id="lightboxNext">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Block Lời Nhắn -->
    <div class="wishes-section">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="wishes-title">Lời chúc của khách mời</div>
        <div class="wishes-container" id="wishesContainer">
            <?php if (!empty($activeComments)): ?>
                <?php foreach ($activeComments as $comment): ?>
                    <div class="wish-item">
                        <div class="wish-name"><?php echo htmlspecialchars($comment['name']); ?></div>
                        <div class="wish-text"><?php echo htmlspecialchars($comment['message']); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="wish-item">
                    <div class="wish-name">Chưa có lời chúc</div>
                    <div class="wish-text">Hãy là người đầu tiên gửi lời chúc cho cô dâu & chú rề!</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Block Tài Khoản Momo & Số Tài Khoản -->
    <div class="account-section">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="account-title">Thông tin tài khoản</div>
        <div class="account-info">
            <div class="account-item">
                <div class="account-type">💳 Momo</div>
                <div class="account-number" id="memoAccount"><?php echo htmlspecialchars($momo_account); ?></div>
                <button class="copy-btn" onclick="copyToClipboard('<?php echo htmlspecialchars($momo_account); ?>')">Sao chép</button>
            </div>
            <div class="account-item">
                <div class="account-type">🏦 Số tài khoản ngân hàng</div>
                <div class="account-number" id="bankAccount"><?php echo htmlspecialchars($bank_account); ?></div>
                <button class="copy-btn" onclick="copyToClipboard('<?php echo htmlspecialchars($bank_account); ?>')">Sao chép</button>
            </div>
        </div>
        <p class="account-note">Nếu muốn gửi lời chúc hoặc quà có được, bạn có thể chuyển khoản đến các số tài khoản trên.</p>
    </div>

    <form id="rsvpForm" novalidate>
        <div class="form-title">Xác nhận tham dự</div>
        <div class="form-sub">Vui lòng phản hồi trước ngày <?php echo DateTime::createFromFormat('Y-m-d', $rsvp_deadline)->format('d.m.Y'); ?></div>

        <div class="field">
            <label for="fullname">Họ và tên <span aria-label="bắt buộc">*</span></label>
            <input type="text" id="fullname" name="fullname" placeholder="Nguyễn Văn A" required aria-required="true">
        </div>

        <div class="guest-row">
            <div class="field">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="phone" name="phone" placeholder="0987654321">
            </div>
            <div class="field">
                <label for="guests">Số người tham dự <span aria-label="bắt buộc">*</span></label>
                <input type="number" id="guests" name="guests" min="1" max="10" value="1" required aria-required="true">
            </div>
        </div>

        <div class="field">
            <label>Bạn có thể tham dự? <span aria-label="bắt buộc">*</span></label>
            <div class="attend-toggle">
                <input type="radio" id="attendYes" name="attend" value="yes" checked required aria-required="true">
                <label for="attendYes">Vui mừng tham dự</label>
                <input type="radio" id="attendNo" name="attend" value="no">
                <label for="attendNo">Xin phép vắng mặt</label>
            </div>
        </div>

        <div class="field">
            <label for="message">Lời nhắn (nếu có)</label>
            <textarea id="message" name="message" placeholder="Gửi lời chúc đến cô dâu chú rể..."></textarea>
        </div>

        <button type="submit" class="submit">Gửi xác nhận</button>
    </form>

    <div class="success" id="successBox" role="alert">
        <div class="icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                <path d="M4 12.5L9.5 18L20 6" stroke="#c9a87c" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h3>Cảm ơn bạn!</h3>
        <p>Phản hồi của bạn đã được ghi nhận. Chúng tôi rất mong được đón tiếp bạn trong ngày trọng đại này.</p>
    </div>

    <div class="footer-note"><?php echo htmlspecialchars($footer_initials); ?> — <?php echo htmlspecialchars($footer_date); ?></div>
</div>

<!-- UPDATE script.js để sử dụng ngày cưới từ PHP -->
<script>
    // Cấu hình ngày cưới từ config.php
    const WEDDING_DATE = '<?php echo $wedding_date; ?>T<?php echo $wedding_time; ?>:00';
</script>

<script src="script.js"></script>

</body>
</html>

