<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Thiệp mời cưới — {{ config('wedding.groom_name') }} & {{ config('wedding.bride_name') }}. Xác nhận tham dự buổi lễ cưới ngày {{ $formattedDate }}">
    <meta name="theme-color" content="#fffaf6">
    <title>Thiệp mời & RSVP — {{ config('wedding.groom_name') }} & {{ config('wedding.bride_name') }} | Đám cưới 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/style.css?x=33">
</head>
<body>

<div class="invitation" role="main" aria-label="Trang thiệp mời cưới" id="home">
    <div class="eyebrow">Trân trọng kính mời</div>
    @if($guestName !== '')
    <div class="guest-name"><center>{{ $guestName }}</center></div>
    @endif
    <div class="monogram">{{ config('wedding.groom_initial') }} &nbsp;•&nbsp; {{ config('wedding.bride_initial') }}</div>

    <div class="divider" aria-hidden="true">
        <div class="line"></div>
        <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
            <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
        </svg>
        <div class="line"></div>
    </div>

    <h1 class="names">{{ config('wedding.groom_name') }}<span class="amp">&amp;</span>{{ config('wedding.bride_name') }}</h1>
    <div class="subtitle">Sẽ nên duyên vợ chồng</div>

    <div class="details">
        <div class="item">
            <div class="label">Ngày cưới</div>
            <time class="value" datetime="{{ config('wedding.wedding_date') }}">{{ $formattedDate }}</time>
            <div class="sub">{{ $weddingDayName }}</div>
        </div>
        <div class="item">
            <div class="label">Giờ</div>
            <time class="value">{{ config('wedding.wedding_time') }}</time>
            <div class="sub">{{ config('wedding.wedding_time_label') }}</div>
        </div>
        <div class="item">
            <div class="label">Địa điểm</div>
            <div class="value">{{ config('wedding.venue_name') }}</div>
            <div class="sub">{{ config('wedding.venue_location') }}</div>
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

    <p class="quote">{!! config('wedding.quote') !!}</p>

    <!-- Photo Collage Section -->
    <div class="collage-section">
        <div class="collage-container">
            <div class="collage-frame">
                <div class="collage-header">
                    <span class="collage-couple">{{ config('wedding.groom_name') }} & {{ config('wedding.bride_name') }}</span>
                    <span class="collage-date">{{ $formattedDate }}</span>
                </div>

                <div class="collage-grid">
                    @foreach(array_slice(config('wedding.gallery_images'), 0, 5) as $photoIndex => $image)
                        <div class="collage-photo collage-photo-{{ ($photoIndex % 5) + 1 }}">
                            <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" loading="lazy">
                        </div>
                    @endforeach
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
                    @foreach(config('wedding.gallery_images') as $index => $image)
                        <div class="carousel-slide" data-index="{{ $index }}">
                            <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" loading="lazy">
                        </div>
                    @endforeach
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
                @foreach(config('wedding.gallery_images') as $index => $image)
                    <button class="carousel-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" aria-label="Ảnh {{ $index + 1 }}"></button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Block Video Section -->
    <div class="video-section" id="videoSection">
        <div class="divider" aria-hidden="true">
            <div class="line"></div>
            <svg width="22" height="14" viewBox="0 0 22 14" fill="none">
                <path d="M11 13C11 13 1 8 1 4.2C1 1.6 3.2 0.8 4.8 1.6C6.4 2.4 7.4 4 11 7.4C14.6 4 15.6 2.4 17.2 1.6C18.8 0.8 21 1.6 21 4.2C21 8 11 13 11 13Z" fill="#c9a87c"/>
            </svg>
            <div class="line"></div>
        </div>
        <div class="video-title">{{ config('wedding.wedding_video.title') }}</div>
        <p class="video-subtitle">{{ config('wedding.wedding_video.subtitle') }}</p>
        <div class="video-player" id="videoPlayer" data-youtube-url="{{ config('wedding.wedding_video.youtube_url') }}">
            <img class="video-thumbnail" src="{{ config('wedding.wedding_video.thumbnail') }}" alt="{{ config('wedding.wedding_video.title') }}" loading="lazy">
            <button type="button" class="video-play-btn" id="videoPlayBtn" aria-label="Phát video">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path d="M8 5v14l11-7L8 5z" fill="currentColor"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Video Fullscreen Modal Popup -->
    <div class="video-modal" id="videoModal">
        <div class="video-modal-overlay"></div>
        <div class="video-modal-content">
            <button class="video-modal-close" id="videoModalClose" aria-label="Đóng">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </button>
            <div class="video-modal-frame" id="videoModalFrame"></div>
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
            @forelse($activeComments as $comment)
                <div class="wish-item">
                    <div class="wish-name">{{ $comment['name'] }}</div>
                    <div class="wish-text">{{ $comment['message'] }}</div>
                </div>
            @empty
                <div class="wish-item">
                    <div class="wish-name">Chưa có lời chúc</div>
                    <div class="wish-text">Hãy là người đầu tiên gửi lời chúc cho cô dâu & chú rề!</div>
                </div>
            @endforelse
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
        </div>
        <p class="map-text">📍 {{ config('wedding.venue_full_name') }}<br>{{ config('wedding.venue_location') }}, Việt Nam</p>
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
        <div class="form-sub">Vui lòng phản hồi trước ngày {{ $rsvpDeadline }}</div>

        <div class="field">
            <label for="fullname">Họ và tên <span aria-label="bắt buộc">*</span></label>
            <input type="text" id="fullname" name="fullname" placeholder="Nguyễn Văn A" value="{{ $guestName }}" {{ $guestName !== '' ? 'readonly' : '' }} required aria-required="true">
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

    <div class="footer-note">{{ config('wedding.footer_initials') }} — {{ config('wedding.footer_date') }}</div>
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

<!-- Cấu hình ngày cưới truyền từ Laravel sang JS -->
<script>
    const WEDDING_DATE = '{{ config('wedding.wedding_date') }}T{{ config('wedding.wedding_time') }}:00';
    const WEDDING_DATE_ONLY = '{{ config('wedding.wedding_date') }}'; // YYYY-MM-DD format
</script>

<!-- Calendar Script -->
<script>
    let currentDisplayMonth = new Date();
    const weddingDateObj = new Date('{{ config('wedding.wedding_date') }}');

    function initCalendar() {
        currentDisplayMonth = new Date(weddingDateObj.getFullYear(), weddingDateObj.getMonth(), 1);
        renderCalendar();

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

        const monthNames = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                          'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
        document.getElementById('monthYearDisplay').textContent = monthNames[month] + ' ' + year;

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        const calendarDaysContainer = document.getElementById('calendarDays');
        calendarDaysContainer.innerHTML = '';

        for (let i = firstDay - 1; i >= 0; i--) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day other-month';
            dayEl.textContent = daysInPrevMonth - i;
            calendarDaysContainer.appendChild(dayEl);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day';
            dayEl.textContent = day;

            const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
            if (dateStr === WEDDING_DATE_ONLY) {
                dayEl.classList.add('wedding-date');
                dayEl.title = 'Ngày cưới';
            }

            const today = new Date();
            if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dayEl.classList.add('today');
            }

            calendarDaysContainer.appendChild(dayEl);
        }

        const totalCells = calendarDaysContainer.children.length;
        const remainingCells = 42 - totalCells;
        for (let day = 1; day <= remainingCells; day++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'calendar-day other-month';
            dayEl.textContent = day;
            calendarDaysContainer.appendChild(dayEl);
        }
    }

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
    function openMomoApp(account) {
        const phoneMatch = account.match(/\d{10,11}/);
        const phone = phoneMatch ? phoneMatch[0] : account;
        const momoDeeplink = `momo://app?ACTION=TRANSFER&PHONE=${phone}&AMOUNT=0`;
        const momoWebLink = `https://me.momo.vn`;

        if (/mobile|tablet|android|iphone/i.test(navigator.userAgent)) {
            const link = document.createElement('a');
            link.href = momoDeeplink;
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();

            setTimeout(() => {
                if (!document.hidden) {
                    window.location.href = momoWebLink;
                }
                link.remove();
            }, 1500);
        } else {
            window.open(momoWebLink, '_blank');
        }
    }

    function openBankApp(account) {
        const bankMessage = `Số tài khoản: ${account}\n\nVui lòng mở app ngân hàng của bạn và chuyển khoản đến số tài khoản trên.`;

        if (/mobile|tablet|android|iphone/i.test(navigator.userAgent)) {
            const isIOS = /iphone|ipad|ipod/i.test(navigator.userAgent);
            window.location.href = 'https://www.vietcombank.com.vn';
        } else {
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
                const modalContent = document.querySelector('.hongbao-modal-content');
                if (modalContent) {
                    setTimeout(() => {
                        modalContent.scrollTop = 0;
                    }, 50);
                }
            });

            hongbaoClose.addEventListener('click', () => {
                hongbaoModal.classList.remove('active');
                document.body.classList.remove('hongbao-modal-open');
            });

            hongbaoOverlay.addEventListener('click', () => {
                hongbaoModal.classList.remove('active');
                document.body.classList.remove('hongbao-modal-open');
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && hongbaoModal.classList.contains('active')) {
                    hongbaoModal.classList.remove('active');
                    document.body.classList.remove('hongbao-modal-open');
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHongbaoModal);
    } else {
        initHongbaoModal();
    }
</script>

<script src="/script.js"></script>

<!-- Wedding Video Embed Script -->
<script>
    (function () {
        const player = document.getElementById('videoPlayer');
        const modal = document.getElementById('videoModal');
        const modalFrame = document.getElementById('videoModalFrame');
        const modalClose = document.getElementById('videoModalClose');
        const modalOverlay = modal ? modal.querySelector('.video-modal-overlay') : null;
        if (!player || !modal || !modalFrame) return;

        function getYoutubeId(url) {
            if (!url) return null;
            const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]{11})/);
            return match ? match[1] : null;
        }

        function openVideoModal() {
            const youtubeUrl = player.getAttribute('data-youtube-url');
            const videoId = getYoutubeId(youtubeUrl);
            if (!videoId) return;

            const iframe = document.createElement('iframe');
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
            iframe.title = 'Video cưới';
            iframe.frameBorder = '0';
            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
            iframe.allowFullscreen = true;

            modalFrame.innerHTML = '';
            modalFrame.appendChild(iframe);
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            modal.classList.remove('active');
            modalFrame.innerHTML = '';
            document.body.style.overflow = '';
        }

        player.addEventListener('click', openVideoModal);

        if (modalClose) {
            modalClose.addEventListener('click', closeVideoModal);
        }
        if (modalOverlay) {
            modalOverlay.addEventListener('click', closeVideoModal);
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeVideoModal();
            }
        });
    })();
</script>

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

        navItems.forEach((item) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(item.getAttribute('data-target'));
                if (!target) return;
                const navHeight = document.getElementById('bottomNav').offsetHeight;
                const top = target.getBoundingClientRect().top + window.pageYOffset - (navHeight + 16);
                window.scrollTo({ top, behavior: 'smooth' });
                setActive(target.id);

                if (bottomNav) {
                    bottomNav.classList.remove('open');
                    if (toggleBtn) {
                        toggleBtn.setAttribute('aria-expanded', 'false');
                        toggleBtn.setAttribute('aria-label', 'Mở menu điều hướng');
                    }
                }
            });
        });

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
