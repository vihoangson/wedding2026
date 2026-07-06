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
$venue_name = "Đông Phương";                         // Tên địa điểm/nhà hàng
$venue_location = "Nguyễn Văn Quá, Quận 12, TP.HCM"; // Địa chỉ chi tiết
$venue_full_name = "Sự Kiện Đông Phương Nguyễn Văn Quá"; // Tên đầy đủ

// ===== GOOGLE MAPS — Places API + Embed =====
// Kỹ thuật: Maps Embed API v1 với query địa điểm → Google tự hiện pin đỏ
// Yêu cầu: bật "Maps Embed API" trên Google Cloud Console + tạo API key
// Hướng dẫn lấy key: https://console.cloud.google.com/apis/library/maps-embed-backend.googleapis.com
$google_maps_api_key = "AIzaSyCiNiNqPvhyJdqPFflmcLqi3BjmoR9fDwI"; // ← Thay bằng API key của bạn
$google_maps_query   = "NHÀ HÀNG Đông Phương Nguyễn Văn Quá, Quận 12, TP.HCM, Việt Nam";
$google_maps_url     = "https://www.google.com/maps/embed/v1/place"
                     . "?key=" . urlencode($google_maps_api_key)
                     . "&q="   . urlencode($google_maps_query)
                     . "&language=vi"
                     . "&zoom=16";

// ===== THÔNG TIN TÀI KHOẢN =====
$momo_account = "0798851144";      // Số tài khoản Momo
$bank_account = "215592519";      // Số tài khoản ngân hàng
$bank_account_owner = "Vi Hoàng Sơn"; // Chủ tài khoản ngân hàng

// ===== THÔNG TIN KHÁC =====
$rsvp_deadline = "2027-01-01";     // Hạn xác nhận tham dự
$footer_initials = "M & T";        // Chữ viết tắt ở footer (cô dâu & chủ rề viết tắt)
$footer_date = "14.02.2027";       // Ngày ở footer

// ===== KHÓA BÍ MẬT MÃ HÓA TÊN NGƯỜI MỜI (?inviter=...) =====
// Dùng để mã hóa/giải mã tên khách trên URL sao cho người dùng không đọc được trực tiếp,
// nhưng hệ thống vẫn giải mã ngược lại được để hiển thị đúng tên khách.
// ⚠️ Đổi khóa này sẽ khiến các link đã gửi trước đó không còn giải mã đúng nữa.
$inviter_secret_key = "yennhi-hoangson-2026-secret";

/**
 * Mã hóa tên khách mời thành chuỗi không thể đọc trực tiếp (nhưng giải mã được).
 * Kỹ thuật: XOR với khóa bí mật rồi encode Base64 kiểu URL-safe.
 */
function encodeInviterName($plainText, $key) {
    if ($plainText === '') {
        return '';
    }
    $xored = '';
    $keyLen = strlen($key);
    for ($i = 0; $i < strlen($plainText); $i++) {
        $xored .= chr(ord($plainText[$i]) ^ ord($key[$i % $keyLen]));
    }
    // Base64 URL-safe: thay +/ thành -_ và bỏ dấu = ở cuối
    return rtrim(strtr(base64_encode($xored), '+/', '-_'), '=');
}

/**
 * Giải mã ngược chuỗi đã được encodeInviterName() tạo ra, trả về tên khách gốc.
 * Trả về chuỗi rỗng nếu dữ liệu không hợp lệ.
 */
function decodeInviterName($encodedText, $key) {
    if ($encodedText === '') {
        return '';
    }
    // Khôi phục lại chuẩn Base64 (thêm padding '=' nếu thiếu)
    $b64 = strtr($encodedText, '-_', '+/');
    $mod4 = strlen($b64) % 4;
    if ($mod4 !== 0) {
        $b64 .= str_repeat('=', 4 - $mod4);
    }
    $xored = base64_decode($b64, true);
    if ($xored === false) {
        return '';
    }
    $keyLen = strlen($key);
    $plainText = '';
    for ($i = 0; $i < strlen($xored); $i++) {
        $plainText .= chr(ord($xored[$i]) ^ ord($key[$i % $keyLen]));
    }
    return $plainText;
}

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
