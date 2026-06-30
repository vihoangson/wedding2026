<?php
/**
 * Wedding Page Configuration
 * File quản lý tất cả các biến cấu hình cho trang thiệp mời cưới
 */

// ===== THÔNG TIN CÔ DÂU & CHỦ RỀ =====
$bride_name = "Yến Nhi";           // Tên cô dâu
$groom_name = "Hoàng Sơn";         // Tên chủ rề
$bride_initial = "N";              // Chữ đầu cô dâu
$groom_initial = "S";              // Chữ đầu chủ rề

// ===== THÔNG TIN ĐÁM CƯỚI =====
$wedding_date = "2026-12-13";      // Ngày cưới (YYYY-MM-DD)
$wedding_time = "11:30";           // Giờ cưới
$wedding_day_name = "Chủ Nhật";    // Tên ngày trong tuần
$wedding_time_label = "Tiệc chính thức"; // Nhãn giờ tiệc

// ===== ĐỊA ĐIỂM CƯỚI & NHÀ HÀNG =====
$venue_name = "Đông Phương";       // Tên địa điểm/nhà hàng
$venue_location = "Quận 12, TP.HCM"; // Địa chỉ chi tiết
$venue_full_name = "Trung Tâm Sự Kiện Đông Phương"; // Tên đầy đủ
$venue_lat = 10.877937;             // Vĩ độ
$venue_lng = 106.62575;             // Kinh độ
$google_maps_url = "https://www.openstreetmap.org/export/embed.html"; // URL bản đồ cơ bản

// ===== THÔNG TIN TÀI KHOẢN =====
$momo_account = "0987654321";      // Số tài khoản Momo
$bank_account = "0123456789";      // Số tài khoản ngân hàng
$bank_account_owner = "Hoàng Sơn"; // Chủ tài khoản ngân hàng

// ===== THÔNG TIN KHÁC =====
$rsvp_deadline = "2027-01-01";     // Hạn xác nhận tham dự
$footer_initials = "M & T";        // Chữ viết tắt ở footer (cô dâu & chủ rề viết tắt)
$footer_date = "14.02.2027";       // Ngày ở footer

// ===== QUOTE/LỜI TUYÊN NGÔN =====
$quote = '"Sự hiện diện của bạn chính là món quà quý giá nhất, là niềm hạnh phúc trọn vẹn nhất trong ngày trọng đại của chúng tôi."';

// ===== DANH SÁCH ẢNH GALLERY =====
$gallery_images = [
    [
        "url" => "https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_iYKOBwJQnw.png",
        "alt" => "Ảnh khoảnh khắc cưới 1",
        "featured" => true
    ],
    [
        "url" => "https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_7FJaGtaf0Z.png",
        "alt" => "Ảnh khoảnh khắc cưới 2",
        "featured" => false
    ],
    [
        "url" => "https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_idfrF4sgD2.png",
        "alt" => "Ảnh khoảnh khắc cưới 3",
        "featured" => false
    ],
    [
        "url" => "https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_iYKOBwJQnw.png",
        "alt" => "Ảnh khoảnh khắc cưới 4",
        "featured" => false
    ],
    [
        "url" => "https://hn.ss.bfcplatform.vn/talentdad/ShareX/2026/06/chrome_8rrVQarr8A.jpg",
        "alt" => "Ảnh khoảnh khắc cưới 5",
        "featured" => false
    ]
];

?>
