<?php
// Trang chờ hiển thị khi truy cập trang chủ mà không có link mời hợp lệ (?inviter=...)
require_once 'config.php';
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
</style>
</head>
<body>
  <div class="card">
    <div class="icon">💌</div>
    <div class="names"><?php echo htmlspecialchars($groom_name . ' & ' . $bride_name, ENT_QUOTES, 'UTF-8'); ?></div>
    <h1>Thiệp mời chưa sẵn sàng</h1>
    <p>
      Rất tiếc, chúng tôi không tìm thấy thông tin lời mời hợp lệ dành cho bạn.<br>
      Vui lòng sử dụng đúng đường link đã được gửi riêng để xem thiệp mời,
      hoặc liên hệ trực tiếp với cô dâu / chú rể để được hỗ trợ.
    </p>
  </div>
</body>
</html>
