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

    // ===== QUOTE =====
    'quote' => '"Sự hiện diện của bạn chính là món quà quý giá nhất, là niềm hạnh phúc trọn vẹn nhất trong ngày trọng đại của chúng tôi."',

    // ===== DANH SÁCH ẢNH GALLERY =====
    'gallery_images' => [
        [
            'url' => 'https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_iYKOBwJQnw.png',
            'alt' => 'Ảnh khoảnh khắc cưới 1',
            'featured' => true,
        ],
        [
            'url' => 'https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_7FJaGtaf0Z.png',
            'alt' => 'Ảnh khoảnh khắc cưới 2',
            'featured' => false,
        ],
        [
            'url' => 'https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_idfrF4sgD2.png',
            'alt' => 'Ảnh khoảnh khắc cưới 3',
            'featured' => false,
        ],
        [
            'url' => 'https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_iYKOBwJQnw.png',
            'alt' => 'Ảnh khoảnh khắc cưới 4',
            'featured' => false,
        ],
        [
            'url' => 'https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_8rrVQarr8A.jpg',
            'alt' => 'Ảnh khoảnh khắc cưới 5',
            'featured' => false,
        ],
    ],
];
