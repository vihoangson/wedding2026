@php
    $weddingDate = \Illuminate\Support\Carbon::parse(config('wedding.wedding_date'));
    $gallery = array_slice(config('wedding.gallery_images', []), 0, 5);
    $moments = config('wedding.moments_images', []);
    $heroImage = $gallery[0]['url'] ?? ($moments[0]['url'] ?? config('wedding.memorize.cover_photo'));
    $mapsUrl = 'https://www.google.com/maps/search/?api=1&query='.urlencode(config('wedding.google_maps_query'));
    $video = config('wedding.wedding_video', []);
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Thiệp mời cưới — {{ config('wedding.groom_name') }} & {{ config('wedding.bride_name') }}. Xác nhận tham dự buổi lễ cưới ngày {{ $formattedDate }}">
    <meta name="theme-color" content="#fcf0f2">
    <title>@if($guestName !== '')Kính mời {{ $guestName }} — @endif{{ config('wedding.groom_name') }} & {{ config('wedding.bride_name') }} | Thiệp cưới</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Be+Vietnam+Pro:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/invite.css?v=4">
    <script>document.documentElement.classList.add('js');</script>
</head>
<body>

{{-- Shared ornament (gold flourish) --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="flourish" viewBox="0 0 120 16">
        <path d="M0 8h46" stroke="currentColor" stroke-width=".8"/>
        <path d="M74 8h46" stroke="currentColor" stroke-width=".8"/>
        <path d="M60 2l6 6-6 6-6-6z" fill="none" stroke="currentColor" stroke-width=".9"/>
        <circle cx="60" cy="8" r="1.6" fill="currentColor"/>
        <circle cx="49" cy="8" r="1" fill="currentColor"/>
        <circle cx="71" cy="8" r="1" fill="currentColor"/>
    </symbol>
</svg>

<main id="home">

    {{-- ============ HERO ============ --}}
    <header class="hero" @if($heroImage) style="--hero-image: url('{{ $heroImage }}')" @endif>
        <div class="hero-frame" aria-hidden="true"></div>
        <div class="hero-inner">
            <p class="eyebrow">Trân trọng kính mời</p>
            @if($guestName !== '')
                <p class="hero-guest">{{ $guestName }}</p>
            @endif
            <p class="hero-lead">đến dự lễ thành hôn của</p>

            <h1 class="hero-names">
                <span>{{ config('wedding.groom_name') }}</span>
                <span class="hero-amp">&amp;</span>
                <span>{{ config('wedding.bride_name') }}</span>
            </h1>

            <svg class="flourish hero-flourish" aria-hidden="true"><use href="#flourish"/></svg>

            <div class="hero-date">
                <span>{{ $weddingDate->format('d') }}</span>
                <i aria-hidden="true"></i>
                <span>{{ $weddingDate->format('m') }}</span>
                <i aria-hidden="true"></i>
                <span>{{ $weddingDate->format('Y') }}</span>
            </div>
            <p class="hero-meta">{{ $weddingDayName }} &nbsp;·&nbsp; {{ config('wedding.wedding_time') }} &nbsp;·&nbsp; {{ config('wedding.venue_name') }}</p>

            <a href="#rsvpForm" class="btn btn-rose hero-cta">Xác nhận tham dự</a>
        </div>
        <a href="#story" class="hero-scroll" aria-label="Cuộn xuống">
            <span></span>
        </a>
    </header>

    {{-- ============ QUOTE ============ --}}
    <section class="section section-quote" id="story">
        <div class="monogram reveal" aria-hidden="true">
            <span>{{ config('wedding.groom_initial') }}</span>
            <em>&</em>
            <span>{{ config('wedding.bride_initial') }}</span>
        </div>
        <blockquote class="quote reveal">{!! config('wedding.quote') !!}</blockquote>
    </section>

    {{-- ============ EVENT DETAILS + COUNTDOWN ============ --}}
    <section class="section section-paper" id="eventSection">
        <div class="section-head reveal">
            <p class="kicker">Save the date</p>
            <h2 class="title">Lễ Thành Hôn</h2>
            <svg class="flourish" aria-hidden="true"><use href="#flourish"/></svg>
        </div>

        <div class="details reveal">
            <div class="detail">
                <p class="detail-label">Thời gian</p>
                <p class="detail-value">{{ config('wedding.wedding_time') }}</p>
                <p class="detail-sub">{{ config('wedding.wedding_time_label') }}</p>
            </div>
            <div class="detail detail-main">
                <p class="detail-label">{{ $weddingDayName }}</p>
                <time class="detail-value detail-big" datetime="{{ config('wedding.wedding_date') }}">{{ $weddingDate->format('d') }}</time>
                <p class="detail-sub">Tháng {{ $weddingDate->format('m') }} · {{ $weddingDate->format('Y') }}</p>
            </div>
            <div class="detail">
                <p class="detail-label">Địa điểm</p>
                <p class="detail-value">{{ config('wedding.venue_name') }}</p>
                <p class="detail-sub">{{ config('wedding.venue_location') }}</p>
            </div>
        </div>

        <div class="countdown-wrap reveal">
            <p class="countdown-title">Chờ đợi ngày trọng đại</p>
            <div class="countdown" id="countdown">
                <div class="countdown-item"><span class="countdown-value" id="days">00</span><span class="countdown-label">Ngày</span></div>
                <div class="countdown-item"><span class="countdown-value" id="hours">00</span><span class="countdown-label">Giờ</span></div>
                <div class="countdown-item"><span class="countdown-value" id="minutes">00</span><span class="countdown-label">Phút</span></div>
                <div class="countdown-item"><span class="countdown-value" id="seconds">00</span><span class="countdown-label">Giây</span></div>
            </div>
        </div>

        <div class="add-calendar reveal">
            <p class="add-calendar-title">Lưu ngày cưới vào lịch của bạn</p>
            <div class="add-calendar-buttons">
                <a href="{{ app(\App\Services\WeddingCalendar::class)->googleUrl() }}" class="btn btn-outline" target="_blank" rel="noopener noreferrer">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 9h18"/></svg>
                    Google Calendar
                </a>
                <a href="{{ route('calendar.ics') }}" class="btn btn-outline">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M12 3v12M7 10l5 5 5-5M5 21h14"/></svg>
                    iPhone / Outlook
                </a>
            </div>
        </div>
    </section>

    {{-- ============ COLLAGE ============ --}}
    @if(count($gallery))
    <section class="section" id="albumSection">
        <div class="section-head reveal">
            <p class="kicker">Our album</p>
            <h2 class="title">Album Cưới</h2>
            <svg class="flourish" aria-hidden="true"><use href="#flourish"/></svg>
        </div>
        <div class="collage collage-{{ count($gallery) }} reveal">
            @foreach($gallery as $photoIndex => $image)
                <figure class="collage-photo">
                    <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" loading="lazy">
                </figure>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ============ MOMENTS CAROUSEL ============ --}}
    @if(!empty($moments))
    <section class="section section-paper" id="gallerySection">
        <div class="section-head reveal">
            <p class="kicker">Moments</p>
            <h2 class="title">Khoảnh khắc của chúng tôi</h2>
            <svg class="flourish" aria-hidden="true"><use href="#flourish"/></svg>
        </div>
        <div class="carousel-container reveal" role="region" aria-label="Thư viện ảnh">
            <div class="carousel-main" id="carouselMain">
                @foreach($moments as $index => $image)
                    <div class="carousel-slide" data-index="{{ $index }}">
                        <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" loading="lazy">
                    </div>
                @endforeach
            </div>
            @if(count($moments) > 1)
                <button class="carousel-nav carousel-prev" id="carouselPrev" aria-label="Ảnh trước">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button class="carousel-nav carousel-next" id="carouselNext" aria-label="Ảnh tiếp">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            @endif
        </div>
        <div class="carousel-dots" id="carouselDots">
            @foreach($moments as $index => $image)
                <button class="carousel-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" aria-label="Ảnh {{ $index + 1 }}"></button>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ============ VIDEO ============ --}}
    @if(!empty($video['youtube_url']))
    <section class="section" id="videoSection">
        <div class="section-head reveal">
            <p class="kicker">Our film</p>
            <h2 class="title">{{ $video['title'] ?? 'Video cưới' }}</h2>
            @if(!empty($video['subtitle']))<p class="lead">{{ $video['subtitle'] }}</p>@endif
        </div>
        <div class="video-player reveal" id="videoPlayer" data-youtube-url="{{ $video['youtube_url'] }}" role="button" tabindex="0" aria-label="Phát video">
            @if(!empty($video['thumbnail']))
                <img class="video-thumbnail" src="{{ $video['thumbnail'] }}" alt="{{ $video['title'] ?? '' }}" loading="lazy">
            @endif
            <span class="video-play" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" fill="currentColor"/></svg>
            </span>
        </div>
    </section>
    @endif

    {{-- ============ VENUE + CALENDAR ============ --}}
    <section class="section section-paper" id="venueSection">
        <div class="section-head reveal">
            <p class="kicker">The venue</p>
            <h2 class="title">Địa điểm & Lịch cưới</h2>
            <svg class="flourish" aria-hidden="true"><use href="#flourish"/></svg>
        </div>

        <div class="venue-grid">
            <div class="venue-card reveal">
                <div class="venue-maps">
                    <img src="https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_eEH4SBYiLd.png" alt="Bản đồ địa điểm cưới" loading="lazy">
                    <img src="https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_bxlmb5uezs.png" alt="Hình ảnh địa điểm cưới" loading="lazy">
                </div>
                <div class="venue-info">
                    <h3>{{ config('wedding.venue_full_name') }}</h3>
                    <p>{{ config('wedding.venue_location') }}, Việt Nam</p>
                    <a href="{{ $mapsUrl }}" class="btn btn-outline" target="_blank" rel="noopener noreferrer">Chỉ đường Google Maps</a>
                </div>
            </div>

            <div class="calendar reveal" id="calendarSection">
                <div class="calendar-header">
                    <button class="calendar-nav-btn" id="prevMonth" aria-label="Tháng trước">‹</button>
                    <div class="calendar-month-year" id="monthYearDisplay"></div>
                    <button class="calendar-nav-btn" id="nextMonth" aria-label="Tháng sau">›</button>
                </div>
                <div class="calendar-weekdays">
                    <div>CN</div><div>T2</div><div>T3</div><div>T4</div><div>T5</div><div>T6</div><div>T7</div>
                </div>
                <div class="calendar-days" id="calendarDays"></div>
            </div>
        </div>
    </section>

    {{-- ============ RSVP ============ --}}
    <section class="section section-blush" id="rsvpSection">
        <div class="section-head reveal">
            <p class="kicker">R.S.V.P</p>
            <h2 class="title">Xác nhận tham dự</h2>
            <p class="lead">Vui lòng phản hồi trước ngày {{ $rsvpDeadline }}</p>
        </div>

        <form id="rsvpForm" class="rsvp reveal" data-token="{{ $inviteToken }}" novalidate>
            <p class="rsvp-notice" id="rsvpNotice" @unless($previousRsvp) hidden @endunless>
                Bạn đã xác nhận lúc <strong id="rsvpConfirmedAt">{{ $previousRsvp['confirmed_at'] ?? '' }}</strong>.
                Bạn có thể sửa thông tin bên dưới và gửi lại để cập nhật.
            </p>

            <div class="field">
                <label for="fullname">Họ và tên <span aria-label="bắt buộc">*</span></label>
                <input type="text" id="fullname" name="fullname" placeholder="Nguyễn Văn A" value="{{ $guestName }}" {{ $guestName !== '' ? 'readonly' : '' }} required aria-required="true">
            </div>

            <div class="field-row">
                <div class="field">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" placeholder="0987 654 321" value="{{ $previousRsvp['phone'] ?? '' }}">
                </div>
                <div class="field">
                    <label for="guests">Số người tham dự <span aria-label="bắt buộc">*</span></label>
                    <input type="number" id="guests" name="guests" min="1" max="10" value="{{ $previousRsvp['guests'] ?? 1 }}" required aria-required="true">
                </div>
            </div>

            <fieldset class="field">
                <legend>Bạn có thể tham dự? <span aria-label="bắt buộc">*</span></legend>
                <div class="attend-toggle">
                    <input type="radio" id="attendYes" name="attend" value="yes" @checked(($previousRsvp['attend'] ?? 'yes') === 'yes') required aria-required="true">
                    <label for="attendYes">Vui mừng tham dự</label>
                    <input type="radio" id="attendNo" name="attend" value="no" @checked(($previousRsvp['attend'] ?? 'yes') === 'no')>
                    <label for="attendNo">Xin phép vắng mặt</label>
                </div>
            </fieldset>

            <div class="field">
                <label for="message">Lời nhắn</label>
                <textarea id="message" name="message" rows="3" placeholder="Gửi lời chúc đến cô dâu & chú rể...">{{ $previousRsvp['message'] ?? '' }}</textarea>
            </div>

            <button type="submit" class="btn btn-rose submit">{{ $previousRsvp ? 'Cập nhật xác nhận' : 'Gửi xác nhận' }}</button>
        </form>

        <div class="success" id="successBox" role="alert">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle cx="12" cy="12" r="11" stroke="currentColor" stroke-width=".8"/>
                <path d="M7 12.5l3.2 3.2L17 9" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h3>Cảm ơn bạn!</h3>
            <p id="successMessage">Phản hồi của bạn đã được ghi nhận. Chúng tôi rất mong được đón tiếp bạn trong ngày trọng đại này.</p>
        </div>
    </section>

    {{-- ============ WISHES ============ --}}
    <section class="section" id="wishesSection">
        <div class="section-head reveal">
            <p class="kicker">Wishes</p>
            <h2 class="title">Lời chúc yêu thương</h2>
            <svg class="flourish" aria-hidden="true"><use href="#flourish"/></svg>
        </div>
        <div class="wishes" id="wishesContainer">
            @forelse($activeComments as $comment)
                <article class="wish reveal">
                    <p class="wish-text">{{ $comment['message'] }}</p>
                    <p class="wish-name">— {{ $comment['name'] }}</p>
                </article>
            @empty
                <article class="wish wish-empty reveal">
                    <p class="wish-text">Hãy là người đầu tiên gửi lời chúc đến cô dâu & chú rể.</p>
                    <a href="#rsvpForm" class="btn btn-outline">Gửi lời chúc</a>
                </article>
            @endforelse
        </div>
    </section>

    {{-- ============ GIFT ============ --}}
    <section class="section section-paper" id="giftSection">
        <div class="section-head reveal">
            <p class="kicker">Gift</p>
            <h2 class="title">Hộp mừng cưới</h2>
            <p class="lead">Sự hiện diện của bạn là món quà quý giá nhất. Nếu muốn gửi thêm lời chúc phúc, bạn có thể dùng mã bên dưới.</p>
        </div>
        <button type="button" class="envelope reveal" id="hongbaoBtn" aria-label="Mở hộp mừng cưới">
            <span class="envelope-flap" aria-hidden="true"></span>
            <span class="envelope-seal" aria-hidden="true">{{ config('wedding.groom_initial') }}{{ config('wedding.bride_initial') }}</span>
            <span class="envelope-label">Chạm để mở</span>
        </button>
    </section>

    {{-- ============ FOOTER ============ --}}
    <footer class="footer">
        <div class="monogram" aria-hidden="true">
            <span>{{ config('wedding.groom_initial') }}</span>
            <em>&</em>
            <span>{{ config('wedding.bride_initial') }}</span>
        </div>
        <p class="footer-thanks">Thank you</p>
        <p class="footer-names">{{ config('wedding.groom_name') }} & {{ config('wedding.bride_name') }} · {{ $formattedDate }}</p>
    </footer>
</main>

{{-- ============ MODALS ============ --}}
<div class="modal collage-modal" id="collageModal">
    <div class="modal-overlay collage-modal-overlay"></div>
    <div class="modal-body modal-image">
        <button class="modal-close" id="collageModalClose" aria-label="Đóng">&times;</button>
        <img id="collageModalImage" src="" alt="">
    </div>
</div>

<div class="modal video-modal" id="videoModal">
    <div class="modal-overlay video-modal-overlay"></div>
    <div class="modal-body modal-video">
        <button class="modal-close" id="videoModalClose" aria-label="Đóng">&times;</button>
        <div class="video-modal-frame" id="videoModalFrame"></div>
    </div>
</div>

<div class="modal hongbao-modal" id="hongbaoModal">
    <div class="modal-overlay hongbao-modal-overlay"></div>
    <div class="modal-body modal-card hongbao-modal-content">
        <button class="modal-close" id="hongbaoClose" aria-label="Đóng">&times;</button>
        <p class="kicker">With love</p>
        <h3 class="modal-title">Mừng cưới</h3>
        <div class="qr">
            <img src="https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_kKmxGvRgIL.png" alt="QR code chuyển khoản mừng cưới" width="220" height="220">
        </div>
        <dl class="bank">
            <div><dt>Chủ tài khoản</dt><dd>{{ config('wedding.bank_account_owner') }}</dd></div>
            <div>
                <dt>Số tài khoản</dt>
                <dd>{{ config('wedding.bank_account') }}
                    <button type="button" class="copy-btn" onclick="copyToClipboard('{{ config('wedding.bank_account') }}')">Sao chép</button>
                </dd>
            </div>
        </dl>
        <p class="modal-note">Cảm ơn bạn đã gửi lời chúc phúc đến chúng tôi.</p>
    </div>
</div>

{{-- ============ FLOATING NAV ============ --}}
<nav class="bottom-nav" id="bottomNav" aria-label="Điều hướng nhanh">
    <a href="#home" class="bottom-nav-item active" data-target="#home" aria-label="Trang đầu">
        <svg viewBox="0 0 24 24"><path d="M3 10.5L12 3l9 7.5M5 9.5V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"/></svg>
    </a>
    <a href="#eventSection" class="bottom-nav-item" data-target="#eventSection" aria-label="Thông tin lễ cưới">
        <svg viewBox="0 0 24 24"><path d="M18 2v2M6 2v2M3 8h18M5 4h14a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/></svg>
    </a>
    @if(!empty($moments))
    <a href="#gallerySection" class="bottom-nav-item" data-target="#gallerySection" aria-label="Ảnh cưới">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M21 16l-5-5-9 9"/></svg>
    </a>
    @endif
    <a href="#rsvpSection" class="bottom-nav-item" data-target="#rsvpSection" aria-label="Xác nhận tham dự">
        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
    </a>
    <a href="#wishesSection" class="bottom-nav-item" data-target="#wishesSection" aria-label="Lời chúc">
        <svg viewBox="0 0 24 24"><path d="M12 20s-7-4.4-9.3-8.8C1.1 7.9 2.6 4.5 6 4.5c2 0 3.3 1 4.1 2.2h3.8C14.7 5.5 16 4.5 18 4.5c3.4 0 4.9 3.4 3.3 6.7C19 15.6 12 20 12 20z"/></svg>
    </a>
</nav>

<script>
    const WEDDING_DATE = '{{ config('wedding.wedding_date') }}T{{ config('wedding.wedding_time') }}:00';
    const WEDDING_DATE_ONLY = '{{ config('wedding.wedding_date') }}';
</script>
<script src="/script.js?v=2"></script>

@if($trackOpen)
<script>
    // Record the open from JS (not on page render) so link-preview bots aren't counted.
    window.addEventListener('load', function () {
        var body = JSON.stringify({ token: @json($inviteToken) });
        var url = @json(route('api.invite-opens.store'));
        if (navigator.sendBeacon && navigator.sendBeacon(url, new Blob([body], { type: 'application/json' }))) return;
        fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: body, keepalive: true }).catch(function () {});
    });
</script>
@endif

<script>
(function () {
    // ----- Calendar -----
    const monthNames = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
        'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
    const [wy, wm] = WEDDING_DATE_ONLY.split('-').map(Number);
    let display = new Date(wy, wm - 1, 1);

    function renderCalendar() {
        const year = display.getFullYear();
        const month = display.getMonth();
        document.getElementById('monthYearDisplay').textContent = monthNames[month] + ' · ' + year;

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrev = new Date(year, month, 0).getDate();
        const today = new Date();
        const box = document.getElementById('calendarDays');
        box.innerHTML = '';

        function cell(text, cls) {
            const el = document.createElement('div');
            el.className = 'calendar-day' + (cls ? ' ' + cls : '');
            el.textContent = text;
            box.appendChild(el);
            return el;
        }

        for (let i = firstDay - 1; i >= 0; i--) cell(daysInPrev - i, 'other-month');
        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
            const el = cell(d);
            if (dateStr === WEDDING_DATE_ONLY) { el.classList.add('wedding-date'); el.title = 'Ngày cưới'; }
            if (d === today.getDate() && month === today.getMonth() && year === today.getFullYear()) el.classList.add('today');
        }
        const rest = (7 - (box.children.length % 7)) % 7;
        for (let d = 1; d <= rest; d++) cell(d, 'other-month');
    }

    document.getElementById('prevMonth').addEventListener('click', () => { display.setMonth(display.getMonth() - 1); renderCalendar(); });
    document.getElementById('nextMonth').addEventListener('click', () => { display.setMonth(display.getMonth() + 1); renderCalendar(); });
    renderCalendar();

    // ----- Modals (gift + video) -----
    function openModal(modal) { modal.classList.add('active'); document.body.classList.add('modal-open'); }
    function closeModal(modal) { modal.classList.remove('active'); document.body.classList.remove('modal-open'); }

    const gift = document.getElementById('hongbaoModal');
    document.getElementById('hongbaoBtn').addEventListener('click', () => openModal(gift));
    document.getElementById('hongbaoClose').addEventListener('click', () => closeModal(gift));
    gift.querySelector('.modal-overlay').addEventListener('click', () => closeModal(gift));

    const player = document.getElementById('videoPlayer');
    const videoModal = document.getElementById('videoModal');
    const frame = document.getElementById('videoModalFrame');

    function closeVideo() { closeModal(videoModal); frame.innerHTML = ''; }

    if (player) {
        const openVideo = () => {
            const m = (player.dataset.youtubeUrl || '').match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]{11})/);
            if (!m) return;
            frame.innerHTML = '<iframe src="https://www.youtube.com/embed/' + m[1] + '?autoplay=1&rel=0" title="Video cưới" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
            openModal(videoModal);
        };
        player.addEventListener('click', openVideo);
        player.addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openVideo(); } });
        document.getElementById('videoModalClose').addEventListener('click', closeVideo);
        videoModal.querySelector('.modal-overlay').addEventListener('click', closeVideo);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') return;
        if (gift.classList.contains('active')) closeModal(gift);
        if (videoModal.classList.contains('active')) closeVideo();
    });

    // ----- Floating nav: smooth scroll + active state -----
    const navItems = Array.from(document.querySelectorAll('.bottom-nav-item'));
    const setActive = (id) => navItems.forEach((i) => i.classList.toggle('active', i.dataset.target === '#' + id));

    navItems.forEach((item) => item.addEventListener('click', (e) => {
        const target = document.querySelector(item.dataset.target);
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setActive(target.id);
    }));

    if ('IntersectionObserver' in window) {
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => { if (entry.isIntersecting) setActive(entry.target.id); });
        }, { rootMargin: '-45% 0px -45% 0px' });
        navItems.map((i) => document.querySelector(i.dataset.target)).filter(Boolean).forEach((t) => sectionObserver.observe(t));

        // ----- Scroll reveal -----
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) { entry.target.classList.add('in'); revealObserver.unobserve(entry.target); }
            });
        }, { rootMargin: '0px 0px -8% 0px' });
        document.querySelectorAll('.reveal').forEach((el) => revealObserver.observe(el));
    } else {
        document.querySelectorAll('.reveal').forEach((el) => el.classList.add('in'));
    }
})();
</script>
</body>
</html>
