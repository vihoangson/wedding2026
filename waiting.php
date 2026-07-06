<?php
// Trang chờ hiển thị khi truy cập trang chủ mà không có link mời hợp lệ (?inviter=...)
require_once 'config.php';

// Lý do được index.php truyền qua (?reason=missing|invalid) để hiển thị thông báo phù hợp
$reason = isset($_GET['reason']) ? $_GET['reason'] : 'missing';
if ($reason === 'invalid') {
    $waitingTitle = 'Link mời không hợp lệ';
    $waitingMessage = 'Đường link bạn truy cập đã bị chỉnh sửa hoặc không còn đúng định dạng nên hệ thống không thể xác thực.<br>'
        . 'Vui lòng sử dụng đúng nguyên vẹn đường link đã được gửi riêng để xem thiệp mời,'
        . ' hoặc liên hệ trực tiếp với cô dâu / chú rể để được hỗ trợ.';
} else {
    $waitingTitle = 'Thiệp mời chưa sẵn sàng';
    $waitingMessage = 'Rất tiếc, chúng tôi không tìm thấy thông tin lời mời hợp lệ dành cho bạn.<br>'
        . 'Vui lòng sử dụng đúng đường link đã được gửi riêng để xem thiệp mời,'
        . ' hoặc liên hệ trực tiếp với cô dâu / chú rể để được hỗ trợ.';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($groom_name . ' & ' . $bride_name, ENT_QUOTES, 'UTF-8'); ?></title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Italiana&family=Jost:wght@300;400;500&display=swap');

  :root{
    --cream:#faf5ec;
    --blush:#e8c4b8;
    --terracotta:#b8734f;
    --sage:#8a9678;
    --ink:#3a3128;
    --gold:#c9a45c;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{
    background: radial-gradient(ellipse at top, #fffdf9, var(--cream) 60%);
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Jost', sans-serif;
    padding:40px 20px;
    color: var(--ink);
  }
  .card{
    position:relative;
    width:440px;
    max-width:100%;
    background:#fffefb;
    border:1px solid rgba(184,115,79,0.25);
    padding:56px 40px 44px;
    text-align:center;
    box-shadow: 0 30px 60px -20px rgba(58,49,40,0.25), 0 0 0 1px rgba(255,255,255,0.5) inset;
  }
  .card::before{
    content:"";
    position:absolute;
    inset:10px;
    border:1px solid var(--gold);
    opacity:0.5;
    pointer-events:none;
  }
  .names{
    font-family:'Italiana', serif;
    font-size:2rem;
    letter-spacing:1px;
    color: var(--terracotta);
    margin-bottom: 18px;
  }
  .icon{
    font-size:2.6rem;
    margin-bottom: 18px;
  }
  h1{
    font-family:'Cormorant Garamond', serif;
    font-weight:600;
    font-size:1.6rem;
    margin-bottom: 14px;
  }
  p{
    font-size:0.95rem;
    line-height:1.7;
    color: rgba(58,49,40,0.75);
  }

  /* ===== COUNTDOWN ===== */
  .countdown-title{
    text-align:center;
    font-family:'Cormorant Garamond', serif;
    font-style:italic;
    font-size:16px;
    color: var(--terracotta);
    letter-spacing:0.08em;
    margin: 28px 0 16px;
  }
  .countdown{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:10px;
    margin-bottom: 6px;
  }
  .countdown-item{
    background: linear-gradient(135deg, rgba(232,196,184,0.35), rgba(201,164,92,0.15));
    border:1px solid rgba(184,115,79,0.25);
    border-radius:8px;
    padding:14px 8px;
    text-align:center;
  }
  .countdown-value{
    font-family:'Jost', sans-serif;
    font-size:22px;
    font-weight:700;
    color: var(--terracotta);
    line-height:1;
    margin-bottom:6px;
  }
  .countdown-label{
    font-size:10px;
    letter-spacing:0.1em;
    text-transform:uppercase;
    color: rgba(58,49,40,0.6);
    font-weight:500;
  }
  @media(max-width:420px){
    .countdown{ grid-template-columns:repeat(2, 1fr); gap:10px; }
  }
</style>
</head>
<body>
  <div class="card">
    <div class="icon">💌</div>
    <div class="names"><?php echo htmlspecialchars($groom_name . ' & ' . $bride_name, ENT_QUOTES, 'UTF-8'); ?></div>
    <h1><?php echo htmlspecialchars($waitingTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p>
      <?php echo $waitingMessage; ?>
    </p>

    <!-- Countdown Timer -->
    <div class="countdown-title" id="countdownTitle">Đếm ngược đến ngày trọng đại</div>
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

  <script>
    // Ngày cưới lấy từ config.php
    const WEDDING_DATE = '<?php echo $wedding_date; ?>T<?php echo $wedding_time; ?>:00';
    const weddingDate = new Date(WEDDING_DATE).getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = weddingDate - now;

        if (distance < 0) {
            document.getElementById('countdownTitle').textContent = '🎉 Ngày trọng đại đã tới!';
            document.getElementById('countdown').style.opacity = '0.5';
            document.getElementById('days').textContent = '00';
            document.getElementById('hours').textContent = '00';
            document.getElementById('minutes').textContent = '00';
            document.getElementById('seconds').textContent = '00';
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').textContent = String(days).padStart(2, '0');
        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
  </script>
</body>
</html>
