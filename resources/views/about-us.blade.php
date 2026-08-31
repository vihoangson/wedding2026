<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Về chúng tôi — {{ config('wedding.groom_name') }} & {{ config('wedding.bride_name') }}">
<meta name="theme-color" content="#f4f2ea">
<title>Về chúng tôi — {{ config('wedding.groom_name') }} & {{ config('wedding.bride_name') }}</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap');

  :root{
    --cream:#f4f2ea;
    --card-bg:#fbfaf5;
    --gold:#c9a45c;
    --ink:#3a3128;
    --sage-1:#8fa07a;
    --sage-2:#6f8a5e;
    --sage-3:#b9c7a4;
  }
  *{ box-sizing:border-box; margin:0; padding:0; }
  body{
    min-height:100vh;
    background: radial-gradient(ellipse at top, #fffefb, var(--cream) 70%);
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Jost', sans-serif;
    color:var(--ink);
    padding:48px 16px;
  }

  .ab-frame-outer{
    position:relative;
    width:440px;
    max-width:100%;
    aspect-ratio:440/640;
    clip-path:polygon(30% 0%, 70% 0%, 100% 22%, 100% 78%, 70% 100%, 30% 100%, 0% 78%, 0% 22%);
    background:linear-gradient(160deg, var(--gold), #e4c98a 45%, var(--gold));
    padding:3px;
    box-shadow:0 30px 60px -25px rgba(58,49,40,0.35);
  }

  .ab-frame-inner{
    position:relative;
    width:100%;
    height:100%;
    clip-path:polygon(30% 0%, 70% 0%, 100% 22%, 100% 78%, 70% 100%, 30% 100%, 0% 78%, 0% 22%);
    background:var(--card-bg);
    overflow:hidden;
  }

  .ab-content{
    position:relative;
    z-index:3;
    height:100%;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding:15% 14%;
  }

  .ab-eyebrow{
    font-size:11px;
    letter-spacing:0.22em;
    text-transform:uppercase;
    color:rgba(58,49,40,0.65);
    margin-bottom:18px;
  }

  .ab-names{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:2px;
    margin-bottom:16px;
  }

  .ab-name{
    font-family:'Cormorant Garamond', serif;
    font-weight:600;
    font-size:1.7rem;
    letter-spacing:0.05em;
    text-transform:uppercase;
    line-height:1.25;
  }

  .ab-amp{
    font-family:'Cormorant Garamond', serif;
    font-style:italic;
    font-size:1rem;
    color:var(--gold);
    margin:2px 0;
  }

  .ab-invite-text{
    font-size:11.5px;
    letter-spacing:0.02em;
    color:rgba(58,49,40,0.75);
    margin-bottom:16px;
    max-width:260px;
    line-height:1.75;
  }

  .ab-divider{
    width:34px;
    height:1px;
    background:var(--gold);
    opacity:0.6;
    margin-bottom:18px;
  }

  .ab-date{
    font-family:'Cormorant Garamond', serif;
    font-style:italic;
    font-weight:600;
    font-size:1.05rem;
    letter-spacing:0.03em;
    margin-bottom:2px;
  }

  .ab-time{
    font-size:11px;
    letter-spacing:0.05em;
    color:rgba(58,49,40,0.65);
    margin-bottom:18px;
  }

  .ab-venue{
    font-family:'Cormorant Garamond', serif;
    font-weight:600;
    font-size:1rem;
    text-transform:uppercase;
    letter-spacing:0.05em;
    margin-bottom:4px;
  }

  .ab-venue-location{
    font-size:11px;
    color:rgba(58,49,40,0.65);
    letter-spacing:0.03em;
    margin-bottom:18px;
  }

  .ab-rsvp-note{
    font-size:10px;
    letter-spacing:0.08em;
    text-transform:uppercase;
    color:rgba(58,49,40,0.5);
  }

  /* ===== Greenery decoration (original artwork) ===== */
  .ab-greenery{
    position:absolute;
    z-index:2;
    width:170px;
    height:170px;
    pointer-events:none;
  }
  .ab-greenery svg{ width:100%; height:100%; overflow:visible; }

  .ab-greenery-tl{ top:-28px; left:-32px; transform:rotate(0deg); }
  .ab-greenery-tr{ top:-28px; right:-32px; transform:scaleX(-1); }
  .ab-greenery-bl{ bottom:-28px; left:-32px; transform:scaleY(-1); }
  .ab-greenery-br{ bottom:-28px; right:-32px; transform:scale(-1,-1); }

  @media(max-width:420px){
    .ab-frame-outer{ width:100%; }
    .ab-greenery{ width:130px; height:130px; }
    .ab-name{ font-size:1.4rem; }
  }
</style>
</head>
<body>

<div class="ab-frame-outer">
  <div class="ab-frame-inner">

    <!-- Original greenery branch illustration, repeated & mirrored at each corner -->
    <div class="ab-greenery ab-greenery-tl">
      <svg viewBox="0 0 170 170" fill="none">
        <path d="M5 20 Q40 30 60 55 Q80 80 70 110" stroke="#7c8f68" stroke-width="2" fill="none" opacity="0.6"/>
        <ellipse cx="18" cy="18" rx="16" ry="9" fill="#a9bb92" transform="rotate(35 18 18)"/>
        <ellipse cx="34" cy="34" rx="18" ry="10" fill="#8fa07a" transform="rotate(40 34 34)"/>
        <ellipse cx="52" cy="30" rx="14" ry="8" fill="#6f8a5e" transform="rotate(-15 52 30)"/>
        <ellipse cx="50" cy="55" rx="17" ry="9" fill="#9db486" transform="rotate(55 50 55)"/>
        <ellipse cx="70" cy="50" rx="13" ry="7" fill="#6f8a5e" transform="rotate(5 70 50)"/>
        <ellipse cx="68" cy="75" rx="16" ry="8" fill="#a9bb92" transform="rotate(70 68 75)"/>
        <ellipse cx="86" cy="68" rx="12" ry="7" fill="#7c8f68" transform="rotate(20 86 68)"/>
        <ellipse cx="78" cy="98" rx="14" ry="7" fill="#8fa07a" transform="rotate(80 78 98)"/>
        <ellipse cx="8" cy="42" rx="11" ry="6" fill="#b9c7a4" transform="rotate(90 8 42)"/>
        <ellipse cx="26" cy="8" rx="10" ry="6" fill="#7c8f68" transform="rotate(10 26 8)"/>
      </svg>
    </div>

    <div class="ab-greenery ab-greenery-tr">
      <svg viewBox="0 0 170 170" fill="none">
        <path d="M5 20 Q40 30 60 55 Q80 80 70 110" stroke="#7c8f68" stroke-width="2" fill="none" opacity="0.6"/>
        <ellipse cx="18" cy="18" rx="16" ry="9" fill="#a9bb92" transform="rotate(35 18 18)"/>
        <ellipse cx="34" cy="34" rx="18" ry="10" fill="#8fa07a" transform="rotate(40 34 34)"/>
        <ellipse cx="52" cy="30" rx="14" ry="8" fill="#6f8a5e" transform="rotate(-15 52 30)"/>
        <ellipse cx="50" cy="55" rx="17" ry="9" fill="#9db486" transform="rotate(55 50 55)"/>
        <ellipse cx="70" cy="50" rx="13" ry="7" fill="#6f8a5e" transform="rotate(5 70 50)"/>
        <ellipse cx="68" cy="75" rx="16" ry="8" fill="#a9bb92" transform="rotate(70 68 75)"/>
        <ellipse cx="86" cy="68" rx="12" ry="7" fill="#7c8f68" transform="rotate(20 86 68)"/>
        <ellipse cx="78" cy="98" rx="14" ry="7" fill="#8fa07a" transform="rotate(80 78 98)"/>
        <ellipse cx="8" cy="42" rx="11" ry="6" fill="#b9c7a4" transform="rotate(90 8 42)"/>
        <ellipse cx="26" cy="8" rx="10" ry="6" fill="#7c8f68" transform="rotate(10 26 8)"/>
      </svg>
    </div>

    <div class="ab-greenery ab-greenery-bl">
      <svg viewBox="0 0 170 170" fill="none">
        <path d="M5 20 Q40 30 60 55 Q80 80 70 110" stroke="#7c8f68" stroke-width="2" fill="none" opacity="0.6"/>
        <ellipse cx="18" cy="18" rx="16" ry="9" fill="#a9bb92" transform="rotate(35 18 18)"/>
        <ellipse cx="34" cy="34" rx="18" ry="10" fill="#8fa07a" transform="rotate(40 34 34)"/>
        <ellipse cx="52" cy="30" rx="14" ry="8" fill="#6f8a5e" transform="rotate(-15 52 30)"/>
        <ellipse cx="50" cy="55" rx="17" ry="9" fill="#9db486" transform="rotate(55 50 55)"/>
        <ellipse cx="70" cy="50" rx="13" ry="7" fill="#6f8a5e" transform="rotate(5 70 50)"/>
        <ellipse cx="68" cy="75" rx="16" ry="8" fill="#a9bb92" transform="rotate(70 68 75)"/>
        <ellipse cx="86" cy="68" rx="12" ry="7" fill="#7c8f68" transform="rotate(20 86 68)"/>
        <ellipse cx="78" cy="98" rx="14" ry="7" fill="#8fa07a" transform="rotate(80 78 98)"/>
        <ellipse cx="8" cy="42" rx="11" ry="6" fill="#b9c7a4" transform="rotate(90 8 42)"/>
        <ellipse cx="26" cy="8" rx="10" ry="6" fill="#7c8f68" transform="rotate(10 26 8)"/>
      </svg>
    </div>

    <div class="ab-greenery ab-greenery-br">
      <svg viewBox="0 0 170 170" fill="none">
        <path d="M5 20 Q40 30 60 55 Q80 80 70 110" stroke="#7c8f68" stroke-width="2" fill="none" opacity="0.6"/>
        <ellipse cx="18" cy="18" rx="16" ry="9" fill="#a9bb92" transform="rotate(35 18 18)"/>
        <ellipse cx="34" cy="34" rx="18" ry="10" fill="#8fa07a" transform="rotate(40 34 34)"/>
        <ellipse cx="52" cy="30" rx="14" ry="8" fill="#6f8a5e" transform="rotate(-15 52 30)"/>
        <ellipse cx="50" cy="55" rx="17" ry="9" fill="#9db486" transform="rotate(55 50 55)"/>
        <ellipse cx="70" cy="50" rx="13" ry="7" fill="#6f8a5e" transform="rotate(5 70 50)"/>
        <ellipse cx="68" cy="75" rx="16" ry="8" fill="#a9bb92" transform="rotate(70 68 75)"/>
        <ellipse cx="86" cy="68" rx="12" ry="7" fill="#7c8f68" transform="rotate(20 86 68)"/>
        <ellipse cx="78" cy="98" rx="14" ry="7" fill="#8fa07a" transform="rotate(80 78 98)"/>
        <ellipse cx="8" cy="42" rx="11" ry="6" fill="#b9c7a4" transform="rotate(90 8 42)"/>
        <ellipse cx="26" cy="8" rx="10" ry="6" fill="#7c8f68" transform="rotate(10 26 8)"/>
      </svg>
    </div>

    <div class="ab-content">
      <div class="ab-eyebrow">Lời tri ân</div>

      <div class="ab-names">
        <div class="ab-name">{{ config('wedding.groom_name') }}</div>
        <div class="ab-amp">&amp;</div>
        <div class="ab-name">{{ config('wedding.bride_name') }}</div>
      </div>

      <div class="ab-invite-text">Chúng con xin gửi lời cảm ơn chân thành đến ông bà, cô bác, anh chị và các bạn đã luôn quan tâm, thương yêu và giúp đỡ chúng con trong suốt thời gian qua. Lễ cưới chính là dịp để mọi người cùng chung vui và sẻ chia niềm hạnh phúc này cùng chúng tôi.</div>

      <div class="ab-divider"></div>

      <div class="ab-date">{{ $weddingDayName }}, {{ $formattedDate }}</div>
      <div class="ab-time">Lúc {{ config('wedding.wedding_time') }} — {{ config('wedding.wedding_time_label') }}</div>

      <div class="ab-venue">{{ config('wedding.venue_name') }}</div>
      <div class="ab-venue-location">{{ config('wedding.venue_location') }}</div>

      <div class="ab-rsvp-note">Rất mong được đón tiếp quý vị trong ngày trọng đại của chúng tôi</div>
    </div>
  </div>
</div>

</body>
</html>
