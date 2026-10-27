<?php

/**
 * Wedding Page Configuration
 * Ported from the original config.php of the wedding_main PHP source.
 */

return [
    // ===== THÔNG TIN CÔ DÂU & CHÚ RỂ =====
    'bride_name' => 'Yến Nhi',
    'groom_name' => 'Hoàng Sơn',
    'bride_initial' => 'N',
    'groom_initial' => 'S',

    // ===== THÔNG TIN ĐÁM CƯỚI =====
    'wedding_date' => '2026-12-13', // YYYY-MM-DD
    'wedding_time' => '11:30',
    'wedding_time_label' => 'Tiệc chính thức',
    'timezone' => 'Asia/Ho_Chi_Minh',
    'duration_minutes' => 180, // độ dài sự kiện khi thêm vào lịch điện thoại

    // ===== ĐỊA ĐIỂM CƯỚI & NHÀ HÀNG =====
    'venue_name' => 'Đông Phương',
    'venue_location' => 'Nguyễn Văn Quá, Quận 12, TP.HCM',
    'venue_full_name' => 'Sự Kiện Đông Phương Nguyễn Văn Quá',

    // ===== GOOGLE MAPS =====
    'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY', 'AIzaSyCiNiNqPvhyJdqPFflmcLqi3BjmoR9fDwI'),
    'google_maps_query' => 'NHÀ HÀNG Đông Phương Nguyễn Văn Quá, Quận 12, TP.HCM, Việt Nam',

    // ===== THÔNG TIN TÀI KHOẢN =====
    'momo_account' => '0798851144',
    'bank_account' => '215592519',
    'bank_account_owner' => 'Vi Hoàng Sơn',

    // ===== THÔNG TIN KHÁC =====
    'rsvp_deadline' => '2027-01-01',
    'footer_initials' => 'M & T',
    'footer_date' => '14.02.2027',

    // ===== KHÓA BÍ MẬT MÃ HÓA TÊN NGƯỜI MỜI (/invite/<token>) =====
    // ⚠️ Đổi khóa này sẽ khiến các link đã gửi trước đó không còn giải mã đúng nữa.
    'inviter_secret_key' => env('INVITER_SECRET_KEY', 'yennhi-hoangson-2026-secret'),

    // ===== MẬT KHẨU ĐĂNG NHẬP DASHBOARD (/dashboard) =====
    // ⚠️ Đổi mật khẩu mặc định này trước khi đưa trang lên production!
    'dashboard_password' => env('DASHBOARD_PASSWORD', 'admin123'),

    // ===== QUOTE =====
    'quote' => '"Sự hiện diện của bạn chính là món quà quý giá nhất, là niềm hạnh phúc trọn vẹn nhất trong ngày trọng đại của chúng tôi."',

    // ===== VIDEO CƯỚI =====
    'wedding_video' => [
        'thumbnail' => 'https://i.ytimg.com/vi/nVsYiUhuwcY/hqdefault.jpg',
        'youtube_url' => 'https://youtube.com/shorts/nVsYiUhuwcY',
        'title' => 'Video Cưới Của Chúng Tôi',
        'subtitle' => 'Cùng xem lại những khoảnh khắc đáng nhớ',
    ],


    // ===== TRANG KỶ NIỆM (/memorize) - LAYOUT KIỂU FACEBOOK =====
    'memorize' => [
        'page_name' => 'Hoàng Sơn & Yến Nhi',
        'page_bio' => 'Kỷ niệm hành trình yêu thương của chúng tôi 💕',
        'cover_photo' => 'https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_bxlmb5uezs.png',
        'avatar' => 'https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_iYKOBwJQnw.png',
    ],

    // ===== DANH SÁCH ẢNH GALLERY (khung collage phía trên, tối đa 5 ảnh) =====
    'gallery_images' => [
        [
            'url' => 'https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_iYKOBwJQnw.png',
            'alt' => 'Ảnh khoảnh khắc cưới 1',
            'featured' => true,
        ],

    ],

    // ===== ẢNH "KHOẢNH KHẮC CỦA CHÚNG TÔI" (carousel, bộ ảnh riêng) =====
    'moments_images' => [
        [
            'url' => 'https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_iYKOBwJQnw.png',
            'alt' => 'Khoảnh khắc của chúng tôi 1',
            'featured' => false,
        ],
    ],
];
