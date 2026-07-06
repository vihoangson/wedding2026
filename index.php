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

// Lấy tên người được mời từ query string (?inviter=<mã đã mã hóa>), nếu không có thì để trống
// Tên khách được mã hóa (xem encodeInviterName trong config.php) nên trên URL sẽ là 1 chuỗi
// không đọc được trực tiếp. decodeInviterName() còn kiểm tra checksum toàn vẹn để phát hiện
// link bị sửa/giả mạo: trả về false nếu dữ liệu không hợp lệ.
$rawInviterParam = isset($_GET['inviter']) ? trim($_GET['inviter']) : '';
$decodedInviterName = $rawInviterParam !== '' ? decodeInviterName($rawInviterParam, $inviter_secret_key) : '';
$inviterName = ($decodedInviterName !== '' && $decodedInviterName !== false)
    ? htmlspecialchars($decodedInviterName, ENT_QUOTES, 'UTF-8')
    : '';

// Khóa trang chủ: nếu không có ?inviter= thì chuyển sang trang chờ (thiếu lời mời);
// nếu có ?inviter= nhưng giải mã/kiểm tra toàn vẹn thất bại (bị sửa/giả mạo) thì báo lỗi riêng.
// Lưu ý: PHẢI dùng đường dẫn tuyệt đối (bắt đầu bằng "/"), vì nếu dùng đường dẫn tương đối
// "waiting.php" thì khi request đến từ /invite/<ma>, trình duyệt sẽ resolve thành
// /invite/waiting.php và bị RewriteRule ^invite/... bắt lại => redirect loop (ERR_TOO_MANY_REDIRECTS).
if ($rawInviterParam === '') {
    header('Location: /waiting.php?reason=missing');
    exit;
}
if ($decodedInviterName === false || $inviterName === '') {
    header('Location: /waiting.php?reason=invalid');
    exit;
}

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
    <link rel="stylesheet" href="/style.css?x=33">
</head>
<body>

<div class="invitation" role="main" aria-label="Trang thiệp mời cưới" id="home">
    <div class="eyebrow">Trân trọng kính mời</div>
    <?php if ($inviterName !== ''): ?>
    <div class="guest-name"><center></center><?php echo htmlspecialchars(htmlspecialchars_decode($inviterName, ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?></center></div>
    <?php endif; ?>
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

    <!-- Photo Collage Section -->
    <div class="collage-section">
        <div class="collage-container">
            <div class="collage-frame">
                <div class="collage-header">
                    <span class="collage-couple"><?php echo htmlspecialchars($groom_name); ?> & <?php echo htmlspecialchars($bride_name); ?></span>
                    <span class="collage-date"><?php echo $formattedDate; ?></span>
                </div>

                <div class="collage-grid">
                    <?php $photoCount = 0; foreach ($gallery_images as $index => $image): ?>
                        <?php if ($photoCount < 5): ?>
                            <div class="collage-photo collage-photo-<?php echo ($photoCount % 5) + 1; ?>">
                                <img src="<?php echo htmlspecialchars($image['url']); ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>" loading="lazy">
                            </div>
                            <?php $photoCount++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="collage-decorations">
                    <span class="decoration decoration-1">💐</span>
                    <span class="decoration decoration-2">🌿</span>
                    <span class="decoration decoration-3">💐</span>
                    <span class="decoration decoration-4">🌿</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Collage Photo Modal Popup -->
    <div class="collage-modal" id="collageModal">
        <div class="collage-modal-overlay"></div>
        <div class="collage-modal-content">
            <button class="collage-modal-close" id="collageModalClose" aria-label="Đóng">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </button>
            <img class="collage-modal-image" id="collageModalImage" src="" alt="Enlarged photo">
        </div>
    </div>

    <div class="gallery-section" id="gallerySection">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="gallery-title">Khoảnh khắc của chúng tôi</div>
        <p class="gallery-subtitle">Những tấm ảnh đẹp của chúng tôi</p>
        <div class="carousel-container" role="region" aria-label="Thư viện ảnh">
            <div class="carousel-wrapper">
                <div class="carousel-main" id="carouselMain">
                    <?php foreach ($gallery_images as $index => $image): ?>
                        <div class="carousel-slide" data-index="<?php echo $index; ?>">
                            <img src="<?php echo htmlspecialchars($image['url']); ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>" loading="lazy">
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-nav carousel-prev" id="carouselPrev" aria-label="Ảnh trước">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <button class="carousel-nav carousel-next" id="carouselNext" aria-label="Ảnh tiếp">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

            <div class="carousel-dots" id="carouselDots">
                <?php foreach ($gallery_images as $index => $image): ?>
                    <button class="carousel-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>" aria-label="Ảnh <?php echo $index + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Block Links Section -->
    <div class="links-section">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="links-title">Thêm thông tin</div>
        <div class="links-container">
            <a href="/invitation.html" class="link-btn link-btn-primary" target="_blank" rel="noopener noreferrer">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-4.5c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-4.5c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                    <path d="M19 3H7v4.5"/>
                </svg>
                Xem Thiệp Mời
            </a>
            <a href="#rsvpForm" class="link-btn link-btn-accent">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Xác Nhận Tham Dự
            </a>
        </div>
    </div>

    <!-- Block Lời Nhắn -->
    <div class="wishes-section" id="wishesSection">
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

    <!-- Block Venue Map -->
    <div class="map-section">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="map-title">Địa điểm lễ cưới</div>
        <div class="map-container">

            <img src="https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_eEH4SBYiLd.png" class="w-100 card-body" alt="Bản đồ địa điểm cưới" style="margin-bottom: 5px; border-radius: 15px;">
            <img src="https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_bxlmb5uezs.png" class="w-100 card-body" alt="Bản đồ địa điểm cưới" style="margin-bottom: 5px; border-radius: 15px;">

            <!--            <iframe src="--><?php //echo htmlspecialchars($google_maps_url); ?><!--" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
        </div>
        <p class="map-text">📍 <?php echo htmlspecialchars($venue_full_name); ?><br><?php echo htmlspecialchars($venue_location); ?>, Việt Nam</p>
    </div>

    <!-- Block Calendar -->
    <div class="calendar-section" id="calendarSection">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="calendar-title">📅 Lịch cưới</div>
        <div class="calendar-container">
            <div class="calendar-header">
                <button class="calendar-nav-btn" id="prevMonth" aria-label="Tháng trước">❮</button>
                <div class="calendar-month-year" id="monthYearDisplay"></div>
                <button class="calendar-nav-btn" id="nextMonth" aria-label="Tháng sau">❯</button>
            </div>
            <div class="calendar-weekdays">
                <div class="calendar-weekday">CN</div>
                <div class="calendar-weekday">T2</div>
                <div class="calendar-weekday">T3</div>
                <div class="calendar-weekday">T4</div>
                <div class="calendar-weekday">T5</div>
                <div class="calendar-weekday">T6</div>
                <div class="calendar-weekday">T7</div>
            </div>
            <div class="calendar-days" id="calendarDays"></div>
        </div>
    </div>

    <!-- Form -->
    <form id="rsvpForm" novalidate>
        <div class="form-title">Xác nhận tham dự</div>
        <div class="form-sub">Vui lòng phản hồi trước ngày <?php echo DateTime::createFromFormat('Y-m-d', $rsvp_deadline)->format('d.m.Y'); ?></div>

        <div class="field">
            <label for="fullname">Họ và tên <span aria-label="bắt buộc">*</span></label>
            <?php
                // Nếu đã có tên người được mời từ link /invite/<ten>, tự điền và khóa không cho sửa
                $fullnameValue = $inviterName !== '' ? htmlspecialchars_decode($inviterName, ENT_QUOTES) : '';
                $fullnameReadonly = $inviterName !== '' ? 'readonly' : '';
            ?>
            <input type="text" id="fullname" name="fullname" placeholder="Nguyễn Văn A" value="<?php echo htmlspecialchars($fullnameValue, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $fullnameReadonly; ?> required aria-required="true">
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

    <!-- Phong Bao Mừng Cưới Section -->
    <div class="hongbao-section">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="hongbao-title">Phong Bao Mừng Cưới</div>
        <p class="hongbao-subtitle">Nhân để mở </p>
        <div class="hongbao-container" id="hongbaoBtn">
            <div class="hongbao">
                <div class="hongbao-glow"></div>
                <div class="hongbao-text">💰</div>
                <div class="hongbao-coins">
                    <span class="coin coin-1">💰</span>
                    <span class="coin coin-2">💰</span>
                    <span class="coin coin-3">💰</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Hongbao QR Modal -->
    <div class="hongbao-modal" id="hongbaoModal">
        <div class="hongbao-modal-overlay"></div>
        <div class="hongbao-modal-content">
            <button class="hongbao-modal-close" id="hongbaoClose">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <div class="hongbao-modal-header">
                <h2>Chuyển Khoản Quà Cưới</h2>
                <p>Quét mã QR để gửi lời chúc và quà cho cô dâu & chú rể</p>
            </div>
            <div class="hongbao-qr-container">
                <div class="qr-item">
                    <div class="qr-label">💝 Quà Cưới</div>
                    <div class="qr-code qr-code-image">
                        <img src="https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_kKmxGvRgIL.png" alt="QR code chuyển khoản nhanh" width="200" height="200">
                    </div>

                </div>
            </div>
            <p class="hongbao-modal-note">Cảm ơn bạn đã gửi lời chúc và quà cho chúng tôi! 🙏</p>
        </div>
    </div>

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

<!-- Bottom Navigation Bar (dùng chung cho mobile & desktop) -->
<nav class="bottom-nav" id="bottomNav" aria-label="Điều hướng nhanh">
    <button type="button" class="bottom-nav-toggle" id="bottomNavToggle" aria-label="Mở menu điều hướng" aria-expanded="false">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7" rx="1.5"/>
            <rect x="3" y="14" width="7" height="7" rx="1.5"/>
            <rect x="14" y="14" width="7" height="7" rx="1.5"/>
            <rect x="14.5" y="3.5" width="7" height="7" rx="1.5" transform="rotate(45 18 7)"/>
        </svg>
    </button>
    <div class="bottom-nav-bar">
        <a href="#home" class="bottom-nav-item active" data-target="#home" aria-label="Trang chủ">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 10.5L12 3l9 7.5"/>
                <path d="M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"/>
            </svg>
            <span class="bottom-nav-dot"></span>
        </a>
        <a href="#gallerySection" class="bottom-nav-item" data-target="#gallerySection" aria-label="Ảnh cưới">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"/>
                <path d="M21 21l-4.3-4.3"/>
            </svg>
            <span class="bottom-nav-dot"></span>
        </a>
        <a href="#wishesSection" class="bottom-nav-item" data-target="#wishesSection" aria-label="Lời chúc">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 21s-7.2-4.5-9.6-9C.8 8.6 2.3 5 5.8 5c2 0 3.4 1 4.2 2.3C10.8 6 12.2 5 14.2 5c3.5 0 5 3.6 3.4 7-2.4 4.5-9.6 9-9.6 9z"/>
            </svg>
            <span class="bottom-nav-dot"></span>
        </a>
        <a href="/dashboard/" class="bottom-nav-item" data-target="#calendarSection" aria-label="Lịch cưới">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 2v2M6 2v2M3 8h18M5 4h14a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
            </svg>
            <span class="bottom-nav-dot"></span>
        </a>
        <a href="#rsvpForm" class="bottom-nav-item" data-target="#rsvpForm" aria-label="Xác nhận tham dự">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 21c0-4 3.6-6.5 8-6.5s8 2.5 8 6.5"/>
            </svg>
            <span class="bottom-nav-dot"></span>
        </a>
    </div>
</nav>

<!-- UPDATE script.js để sử dụng ngày cưới từ PHP -->
<script>
    // Cấu hình ngày cưới từ config.php
    const WEDDING_DATE = '<?php echo $wedding_date; ?>T<?php echo $wedding_time; ?>:00';
    const WEDDING_DATE_ONLY = '<?php echo $wedding_date; ?>'; // YYYY-MM-DD format
</script>

<!-- Calendar Script -->
<script>
    let currentDisplayMonth = new Date();
    const weddingDateObj = new Date('<?php echo $wedding_date; ?>');

    function initCalendar() {
        // Set initial display to wedding month
        currentDisplayMonth = new Date(weddingDateObj.getFullYear(), weddingDateObj.getMonth(), 1);
        renderCalendar();

        // Add event listeners
        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDisplayMonth.setMonth(currentDisplayMonth.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDisplayMonth.setMonth(currentDisplayMonth.getMonth() + 1);
            renderCalendar();
        });
    }

    function renderCalendar() {
        const year = currentDisplayMonth.getFullYear();
        const month = currentDisplayMonth.getMonth();

        // Update month/year display
        const monthNames = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                          'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
        document.getElementById('monthYearDisplay').textContent = monthNames[month] + ' ' + year;

        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        const calendarDaysContainer = document.getElementById('calendarDays');
        calendarDaysContainer.innerHTML = '';

        // Add previous month's days
        for (let i = firstDay - 1; i >= 0; i--) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day other-month';
            dayEl.textContent = daysInPrevMonth - i;
            calendarDaysContainer.appendChild(dayEl);
        }

        // Add current month's days
        for (let day = 1; day <= daysInMonth; day++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day';
            dayEl.textContent = day;

            // Check if this is the wedding date
            const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
            if (dateStr === WEDDING_DATE_ONLY) {
                dayEl.classList.add('wedding-date');
                dayEl.title = 'Ngày cưới';
            }

            // Check if this is today
            const today = new Date();
            if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dayEl.classList.add('today');
            }

            calendarDaysContainer.appendChild(dayEl);
        }

        // Add next month's days
        const totalCells = calendarDaysContainer.children.length;
        const remainingCells = 42 - totalCells; // 6 rows × 7 days
        for (let day = 1; day <= remainingCells; day++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day other-month';
            dayEl.textContent = day;
            calendarDaysContainer.appendChild(dayEl);
        }
    }

    // Initialize calendar on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCalendar);
    } else {
        initCalendar();
    }
</script>

<!-- QR Code Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<!-- Hongbao Modal Script -->
<script>
    // Open Momo app for transfer
    function openMomoApp(account) {
        // Extract phone number from account (if it contains phone number)
        const phoneMatch = account.match(/\d{10,11}/);
        const phone = phoneMatch ? phoneMatch[0] : account;

        // Try to open Momo app via deeplink
        const momoDeeplink = `momo://app?ACTION=TRANSFER&PHONE=${phone}&AMOUNT=0`;

        // Fallback URLs
        const momoWebLink = `https://me.momo.vn`;

        // Try to open app on mobile
        if (/mobile|tablet|android|iphone/i.test(navigator.userAgent)) {
            // Create a hidden link and click it
            const link = document.createElement('a');
            link.href = momoDeeplink;
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();

            // Wait a bit to see if app opened, if not, fallback to web
            setTimeout(() => {
                if (!document.hidden) {
                    window.location.href = momoWebLink;
                }
                link.remove();
            }, 1500);
        } else {
            // On desktop, open Momo web
            window.open(momoWebLink, '_blank');
        }
    }

    // Open Bank app or web for transfer
    function openBankApp(account) {
        // For bank transfer, we can open popular banking apps or web
        // This is a fallback to show a message
        const bankMessage = `Số tài khoản: ${account}\n\nVui lòng mở app ngân hàng của bạn và chuyển khoản đến số tài khoản trên.`;

        if (/mobile|tablet|android|iphone/i.test(navigator.userAgent)) {
            // On mobile, try to open a banking service
            // Common approach: Open app store or banking website
            const isIOS = /iphone|ipad|ipod/i.test(navigator.userAgent);

            if (isIOS) {
                // For iOS, try to open banking apps or fallback
                window.location.href = 'https://www.vietcombank.com.vn';
            } else {
                // For Android, promote banking apps
                window.location.href = 'https://www.vietcombank.com.vn';
            }
        } else {
            // Show message on desktop
            alert(bankMessage);
        }
    }

    function initHongbaoModal() {
        const hongbaoBtn = document.getElementById('hongbaoBtn');
        const hongbaoModal = document.getElementById('hongbaoModal');
        const hongbaoClose = document.getElementById('hongbaoClose');
        const hongbaoOverlay = document.querySelector('.hongbao-modal-overlay');

        if (hongbaoBtn && hongbaoModal) {
            hongbaoBtn.addEventListener('click', () => {
                hongbaoModal.classList.add('active');
                document.body.classList.add('hongbao-modal-open');
                // Scroll modal to top when opened
                const modalContent = document.querySelector('.hongbao-modal-content');
                if (modalContent) {
                    setTimeout(() => {
                        modalContent.scrollTop = 0;
                    }, 50);
                }
                generateQRCodes();
            });

            hongbaoClose.addEventListener('click', () => {
                hongbaoModal.classList.remove('active');
                document.body.classList.remove('hongbao-modal-open');
            });

            hongbaoOverlay.addEventListener('click', () => {
                hongbaoModal.classList.remove('active');
                document.body.classList.remove('hongbao-modal-open');
            });

            // Close on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && hongbaoModal.classList.contains('active')) {
                    hongbaoModal.classList.remove('active');
                    document.body.classList.remove('hongbao-modal-open');
                }
            });
        }
    }

    function generateQRCodes() {
        // Clear previous QR codes
        const qrMomo = document.getElementById('qrMomo');
        const qrBank = document.getElementById('qrBank');

        if (qrMomo && qrMomo.innerHTML === '') {
            const momoAccount = '<?php echo htmlspecialchars($momo_account); ?>';
            new QRCode(qrMomo, {
                text: momoAccount,
                width: 150,
                height: 150,
                colorDark: '#d41e3a',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        }

        if (qrBank && qrBank.innerHTML === '') {
            const bankAccount = '<?php echo htmlspecialchars($bank_account); ?>';
            new QRCode(qrBank, {
                text: bankAccount,
                width: 150,
                height: 150,
                colorDark: '#2e5090',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHongbaoModal);
    } else {
        initHongbaoModal();
    }
</script>

<script src="/script.js"></script>

<!-- Bottom Navigation Script -->
<script>
    (function () {
        const navItems = Array.from(document.querySelectorAll('.bottom-nav-item'));
        const bottomNav = document.getElementById('bottomNav');
        const toggleBtn = document.getElementById('bottomNavToggle');

        if (bottomNav && toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const isOpen = bottomNav.classList.toggle('open');
                toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                toggleBtn.setAttribute('aria-label', isOpen ? 'Đóng menu điều hướng' : 'Mở menu điều hướng');
            });
        }

        if (!navItems.length) return;

        const targets = navItems
            .map((item) => document.querySelector(item.getAttribute('data-target')))
            .filter(Boolean);

        function setActive(id) {
            navItems.forEach((item) => {
                item.classList.toggle('active', item.getAttribute('data-target') === '#' + id);
            });
        }

        // Smooth scroll with offset so content isn't hidden behind the fixed bar
        navItems.forEach((item) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(item.getAttribute('data-target'));
                if (!target) return;
                const navHeight = document.getElementById('bottomNav').offsetHeight;
                const top = target.getBoundingClientRect().top + window.pageYOffset - (navHeight + 16);
                window.scrollTo({ top, behavior: 'smooth' });
                setActive(target.id);

                // Đóng menu sau khi chọn mục
                if (bottomNav) {
                    bottomNav.classList.remove('open');
                    if (toggleBtn) {
                        toggleBtn.setAttribute('aria-expanded', 'false');
                        toggleBtn.setAttribute('aria-label', 'Mở menu điều hướng');
                    }
                }
            });
        });

        // Highlight active item while scrolling
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        setActive(entry.target.id);
                    }
                });
            }, { rootMargin: '-45% 0px -45% 0px', threshold: 0 });

            targets.forEach((target) => observer.observe(target));
        }
    })();
</script>

</body>
</html>

