<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cardify – 3D Phone</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    background: #06060f;
    font-family: 'Sora', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
  }

  /* ─────────────────────────────
     1. PERSPECTIVE SCENE
  ───────────────────────────── */
  .phone-scene {
    perspective: 1200px;
    width: 320px;
    height: 640px;
    position: relative;
  }

  /* ─────────────────────────────
     2. 3D WRAPPER — rotation + float
  ───────────────────────────── */
  .phone-wrapper {
    width: 100%;
    height: 100%;
    transform: rotateY(-18deg) rotateX(4deg) rotateZ(1.5deg);
    transform-style: preserve-3d;
    transition: transform 0.6s ease;
    animation: float 6s ease-in-out infinite;
    position: relative;
  }

  .phone-wrapper:hover {
    transform: rotateY(-8deg) rotateX(2deg) rotateZ(0.5deg);
  }

  @keyframes float {
    0%, 100% { transform: rotateY(-18deg) rotateX(4deg) rotateZ(1.5deg) translateY(0px); }
    50%       { transform: rotateY(-18deg) rotateX(4deg) rotateZ(1.5deg) translateY(-14px); }
  }

  /* ─────────────────────────────
     3. PHONE BODY
  ───────────────────────────── */
  .phone-body {
    width: 280px;
    height: 590px;
    background: linear-gradient(160deg, #1a1a2e 0%, #0e0e1c 50%, #0a0a16 100%);
    border-radius: 44px;
    position: relative;
    border: 1px solid rgba(255,255,255,0.12);
    overflow: hidden;
    box-shadow:
      0 0 0 1px rgba(99,102,241,0.15),
      8px 24px 80px rgba(0,0,0,0.7),
      -4px 0 40px rgba(99,102,241,0.08);
    margin: 0 auto;
  }

  /* Top edge highlight */
  .phone-body::before {
    content: '';
    position: absolute;
    top: 0; left: 20px; right: 20px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
    z-index: 10;
  }

  /* Left side reflection */
  .phone-body::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 40%; height: 100%;
    background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, transparent 100%);
    z-index: 10;
    pointer-events: none;
  }

  /* ─────────────────────────────
     4. SIDE BUTTONS
  ───────────────────────────── */
  .phone-btn-right {
    position: absolute;
    right: -3px; top: 160px;
    width: 3px; height: 60px;
    background: rgba(255,255,255,0.08);
    border-radius: 2px 0 0 2px;
  }

  .phone-btn-left-1 {
    position: absolute;
    left: -3px; top: 130px;
    width: 3px; height: 36px;
    background: rgba(255,255,255,0.08);
    border-radius: 0 2px 2px 0;
  }

  .phone-btn-left-2 {
    position: absolute;
    left: -3px; top: 180px;
    width: 3px; height: 60px;
    background: rgba(255,255,255,0.08);
    border-radius: 0 2px 2px 0;
  }

  /* ─────────────────────────────
     5. DYNAMIC ISLAND
  ───────────────────────────── */
  .dynamic-island {
    position: absolute;
    top: 14px; left: 50%;
    transform: translateX(-50%);
    width: 90px; height: 26px;
    background: #000;
    border-radius: 20px;
    z-index: 20;
    display: flex; align-items: center;
    justify-content: center; gap: 6px;
  }

  .di-camera {
    width: 10px; height: 10px; border-radius: 50%;
    background: #0a0a0a;
    border: 1px solid #1a1a1a;
  }

  .di-sensor {
    width: 6px; height: 6px; border-radius: 50%;
    background: #1a1a2e;
    border: 1px solid rgba(99,102,241,0.3);
  }

  /* ─────────────────────────────
     6. SCREEN
  ───────────────────────────── */
  .phone-screen {
    position: absolute;
    inset: 0;
    background: #0c0c18;
    border-radius: 44px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .status-bar {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 54px 24px 0;
    font-size: 11px;
    color: rgba(255,255,255,0.5);
    font-weight: 600;
    flex-shrink: 0;
  }

  /* ─────────────────────────────
     7. CARD CONTENT (screen UI)
  ───────────────────────────── */
  .card-content {
    width: 100%; flex: 1;
    display: flex; flex-direction: column;
    align-items: center;
    padding: 20px 20px 16px;
    overflow: hidden;
  }

  .card-avatar-wrap {
    width: 72px; height: 72px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px;
    border: 2px solid rgba(99,102,241,0.4);
    flex-shrink: 0; overflow: hidden;
  }

  .avatar-inner {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(160deg, #2a2a50, #1a1a30);
    border-radius: 50%;
  }

  .card-name {
    font-size: 18px; font-weight: 700; color: #fff;
    letter-spacing: -0.02em; margin-bottom: 2px;
    text-align: center; flex-shrink: 0;
  }

  .card-handle {
    font-size: 12px; color: #6366f1;
    margin-bottom: 14px; flex-shrink: 0;
  }

  .qr-wrapper {
    background: #fff; border-radius: 14px;
    padding: 12px;
    width: 130px; height: 130px;
    margin-bottom: 8px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
  }

  .qr-grid {
    display: grid;
    grid-template-columns: repeat(9, 1fr);
    gap: 1.5px; width: 100%; height: 100%;
  }

  .q  { background: #111; border-radius: 0.5px; }
  .qw { background: #f5f5f5; border-radius: 0.5px; }

  .qr-hint {
    font-size: 9px; color: #2a2c50;
    letter-spacing: 0.06em; margin-bottom: 10px;
    text-align: center; flex-shrink: 0;
  }

  .card-stats {
    display: flex; width: 100%;
    border-top: 1px solid rgba(255,255,255,0.05);
    padding: 8px 0; margin-bottom: 10px; flex-shrink: 0;
  }

  .cs { flex: 1; text-align: center; }
  .cs-num { font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.7); }
  .cs-label { font-size: 8px; color: #222444; text-transform: uppercase; letter-spacing: 0.08em; }
  .cs-div { width: 1px; background: rgba(255,255,255,0.05); align-self: stretch; }

  .contact-rows {
    width: 100%; display: flex;
    flex-direction: column; gap: 6px;
    margin-bottom: 12px; flex-shrink: 0;
  }

  .contact-row {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 10px;
    padding: 9px 12px;
    display: flex; align-items: center; gap: 10px;
  }

  .cr-icon {
    width: 24px; height: 24px; border-radius: 7px;
    background: rgba(99,102,241,0.15);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }

  .cr-text {
    font-size: 10px; color: #4a4c72;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }

  .action-btns {
    display: flex; gap: 8px;
    width: 100%; flex-shrink: 0;
  }

  .btn-call {
    flex: 1; padding: 11px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: none; border-radius: 12px;
    font-size: 12px; font-weight: 700; color: #fff;
    cursor: pointer; font-family: 'Sora', sans-serif;
    display: flex; align-items: center; justify-content: center; gap: 6px;
  }

  .btn-email {
    flex: 1; padding: 11px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.6);
    cursor: pointer; font-family: 'Sora', sans-serif;
    display: flex; align-items: center; justify-content: center; gap: 6px;
  }

  /* ─────────────────────────────
     8. HOME BAR
  ───────────────────────────── */
  .phone-home {
    position: absolute;
    bottom: 10px; left: 50%; transform: translateX(-50%);
    width: 110px; height: 4px;
    background: rgba(255,255,255,0.2);
    border-radius: 2px; z-index: 20;
  }

  /* ─────────────────────────────
     9. GLOW UNDER PHONE
  ───────────────────────────── */
  .phone-glow {
    position: absolute;
    bottom: -60px; left: 50%; transform: translateX(-50%);
    width: 280px; height: 120px;
    background: radial-gradient(ellipse, rgba(99,102,241,0.3) 0%, transparent 70%);
    pointer-events: none;
  }

  /* ─────────────────────────────
     10. FLOATING BADGES
  ───────────────────────────── */
  .floating-badge {
    position: absolute;
    top: 80px; right: -20px;
    background: rgba(10,10,24,0.9);
    border: 1px solid rgba(99,102,241,0.3);
    border-radius: 14px;
    padding: 12px 16px;
    display: flex; align-items: center; gap: 10px;
    backdrop-filter: blur(12px);
    animation: float-badge 5s ease-in-out infinite;
    z-index: 30;
  }

  .nfc-badge-float {
    position: absolute;
    bottom: 120px; left: -30px;
    background: rgba(10,10,24,0.9);
    border: 1px solid rgba(34,211,238,0.25);
    border-radius: 100px;
    padding: 10px 18px;
    display: flex; align-items: center; gap: 8px;
    backdrop-filter: blur(12px);
    animation: float-badge 4s ease-in-out infinite 0.5s;
    z-index: 30;
  }

  @keyframes float-badge {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-8px); }
  }

  .fb-icon {
    width: 32px; height: 32px; border-radius: 9px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }

  .fb-text { display: flex; flex-direction: column; gap: 1px; }
  .fb-title { font-size: 12px; font-weight: 700; color: #fff; }
  .fb-sub   { font-size: 10px; color: #4a4c72; }

  .nfc-wave-dot { width: 7px; height: 7px; border-radius: 50%; background: #22d3ee; }
  .nfc-wave-text { font-size: 11px; font-weight: 600; color: #22d3ee; letter-spacing: 0.05em; }
</style>
</head>
<body>

<!-- ═══════════════════════════════════════
     PHONE COMPONENT — copy everything below
     from .phone-scene to its closing </div>
════════════════════════════════════════ -->
<div class="phone-scene">
  <div class="phone-wrapper">

    <!-- Side buttons -->
    <div class="phone-btn-right"></div>
    <div class="phone-btn-left-1"></div>
    <div class="phone-btn-left-2"></div>

    <!-- Phone shell -->
    <div class="phone-body">

      <!-- Dynamic Island -->
      <div class="dynamic-island">
        <div class="di-sensor"></div>
        <div class="di-camera"></div>
      </div>

      <!-- Screen -->
      <div class="phone-screen">
        <div class="status-bar">
          <span>9:41</span>
          <span style="display:flex;gap:4px;align-items:center;">
            <svg width="14" height="10" viewBox="0 0 14 10" fill="none">
              <rect x="0" y="3" width="3" height="7" rx="1" fill="rgba(255,255,255,0.5)"/>
              <rect x="4" y="2" width="3" height="8" rx="1" fill="rgba(255,255,255,0.6)"/>
              <rect x="8" y="0" width="3" height="10" rx="1" fill="rgba(255,255,255,0.8)"/>
              <rect x="12" y="0" width="2" height="10" rx="1" fill="white"/>
            </svg>
          </span>
        </div>

        <div class="card-content">
          <!-- Avatar -->
          <div class="card-avatar-wrap">
            <div class="avatar-inner">
              <svg width="36" height="36" viewBox="0 0 40 40" fill="none">
                <circle cx="20" cy="14" r="5" fill="rgba(255,255,255,0.2)"/>
                <rect x="14" y="8" width="12" height="10" rx="6" fill="rgba(255,255,255,0.12)" stroke="rgba(255,255,255,0.15)" stroke-width="1"/>
                <path d="M8 36C8 29 13.373 24 20 24C26.627 24 32 29 32 36" fill="rgba(255,255,255,0.1)"/>
              </svg>
            </div>
          </div>

          <div class="card-name">Rodrigo Pacheco</div>
          <div class="card-handle">rynex</div>

          <!-- QR -->
          <div class="qr-wrapper">
            <div class="qr-grid">
              <div class="q"></div><div class="q"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="q"></div><div class="q"></div>
              <div class="q"></div><div class="qw"></div><div class="q"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="q"></div><div class="qw"></div><div class="q"></div>
              <div class="q"></div><div class="q"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="q"></div><div class="q"></div>
              <div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div>
              <div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div>
              <div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="q"></div><div class="q"></div><div class="qw"></div>
              <div class="q"></div><div class="q"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="q"></div><div class="q"></div>
              <div class="q"></div><div class="qw"></div><div class="q"></div><div class="q"></div><div class="qw"></div><div class="q"></div><div class="q"></div><div class="qw"></div><div class="q"></div>
              <div class="q"></div><div class="q"></div><div class="q"></div><div class="q"></div><div class="q"></div><div class="q"></div><div class="q"></div><div class="q"></div><div class="q"></div>
            </div>
          </div>
          <div class="qr-hint">Lê o QR Code para guardar o contacto</div>

          <!-- Stats -->
          <div class="card-stats">
            <div class="cs"><div class="cs-num">25</div><div class="cs-label">Visualizações</div></div>
            <div class="cs-div"></div>
            <div class="cs"><div class="cs-num">0</div><div class="cs-label">QR Scans</div></div>
            <div class="cs-div"></div>
            <div class="cs"><div class="cs-num">0</div><div class="cs-label">Guardados</div></div>
          </div>

          <!-- Contact rows -->
          <div class="contact-rows">
            <div class="contact-row">
              <div class="cr-icon">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><rect x="1" y="2" width="10" height="8" rx="1.5" stroke="#818cf8" stroke-width="1"/><path d="M1 4.5L6 7L11 4.5" stroke="#818cf8" stroke-width="1"/></svg>
              </div>
              <span class="cr-text">hirodrigopacheco@gmail.com</span>
            </div>
            <div class="contact-row">
              <div class="cr-icon">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M3 1.5L4.5 3L5.5 4.5C5.5 4.5 5 5.5 5 6C5 6.5 5.5 7.5 5.5 7.5L4.5 9L3 10.5C3 10.5 2.5 8.5 2.5 6C2.5 3.5 3 1.5 3 1.5Z" stroke="#818cf8" stroke-width="0.8" stroke-linejoin="round"/></svg>
              </div>
              <span class="cr-text">916 286 618</span>
            </div>
            <div class="contact-row">
              <div class="cr-icon">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="4.5" stroke="#818cf8" stroke-width="1"/><path d="M6 1.5C6 1.5 4.5 3.5 4.5 6C4.5 8.5 6 10.5 6 10.5M6 1.5C6 1.5 7.5 3.5 7.5 6C7.5 8.5 6 10.5 6 10.5M1.5 6H10.5" stroke="#818cf8" stroke-width="1"/></svg>
              </div>
              <span class="cr-text">rpachecoportfolio.vercel.app</span>
            </div>
          </div>

          <!-- Buttons -->
          <div class="action-btns">
            <button class="btn-call">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M3 1.5C3 1.5 2.5 3.5 2.5 6C2.5 8.5 3 10.5 3 10.5L4.5 9L5.5 7.5C5.5 7.5 5 6.5 5 6C5 5.5 5.5 4.5 5.5 4.5L4.5 3L3 1.5Z" fill="white"/></svg>
              Ligar
            </button>
            <button class="btn-email">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><rect x="1" y="2.5" width="10" height="7" rx="1.5" stroke="rgba(255,255,255,0.5)" stroke-width="1"/><path d="M1 5L6 7.5L11 5" stroke="rgba(255,255,255,0.5)" stroke-width="1"/></svg>
              Email
            </button>
          </div>
        </div>
      </div>

      <div class="phone-home"></div>
    </div>

    <!-- Floating badges -->
    <div class="floating-badge">
      <div class="fb-icon">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M14 9C14 11.761 11.761 14 9 14C6.239 14 4 11.761 4 9C4 6.239 6.239 4 9 4" stroke="white" stroke-width="1.8" stroke-linecap="round"/><path d="M9 4L12 7L9 10" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <div class="fb-text">
        <span class="fb-title">Contacto guardado!</span>
        <span class="fb-sub">via QR · agora mesmo</span>
      </div>
    </div>

    <div class="nfc-badge-float">
      <div class="nfc-wave-dot"></div>
      <span class="nfc-wave-text">NFC ativo</span>
    </div>

  </div>

  <div class="phone-glow"></div>
</div>
<!-- ═══════════════════════════════════════
     FIM DO COMPONENTE
════════════════════════════════════════ -->

</body>
</html>