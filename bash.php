<?php
/**
 * Tạo link thiệp mời cá nhân hóa cho từng khách mời.
 *
 * Cách dùng (chạy trong terminal):
 *   php bash.php "Tên người mời"
 *   php bash.php "Tên người mời" "https://domain-cua-ban.com"
 *
 * Output: link thiệp mời với tên khách đã được MÃ HÓA (không đọc được trực tiếp
 * trên URL) nhưng index.php sẽ tự giải mã ngược lại để hiển thị đúng tên khách.
 */

require_once __DIR__ . '/config.php'; // Nạp $inviter_secret_key + encodeInviterName()

// ===== Domain mặc định của trang cưới =====
// Có thể override bằng tham số thứ 2 khi chạy lệnh, ví dụ:
//   php bash.php "Nguyễn Văn A" "https://hoangson-yennhi.oop.vn"
$defaultDomain = "https://hoangson-yennhi.oop.vn";

// ===== Lấy tham số dòng lệnh =====
$guestName = isset($argv[1]) ? trim($argv[1]) : '';
$domain    = isset($argv[2]) ? rtrim(trim($argv[2]), '/') : $defaultDomain;

if ($guestName === '') {
    fwrite(STDERR, "❌ Thiếu tên người mời.\n");
    fwrite(STDERR, "Cách dùng: php bash.php \"Tên người mời\" [domain]\n");
    exit(1);
}

// Mã hóa tên khách (XOR + Base64 URL-safe) rồi encode URL để an toàn trên đường link
$encodedName = rawurlencode(encodeInviterName($guestName, $inviter_secret_key));

// Link thân thiện dùng rewrite rule: /invite/<ten-da-ma-hoa>
$friendlyLink = $domain . '/invite/' . $encodedName;

// Link dự phòng dùng query string: ?inviter=<ten-da-ma-hoa>
$queryLink = $domain . '/index.php?inviter=' . $encodedName;

echo "👤 Tên khách mời : {$guestName}\n";
echo "🔗 Link thiệp mời: {$friendlyLink}\n";
echo "🔗 Link dự phòng : {$queryLink}\n";
