<!DOCTYPE html>
<html lang="pt" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Sora:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/icon-192.png">
    <meta name="theme-color" content="#6366f1">
    <link rel="apple-touch-icon" href="/icon-192.png">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Cardify">
    <style>
        :root {
            --bg-primary: #0a0a0b;
            --bg-secondary: #111113;
            --bg-tertiary: #18181b;
            --bg-elevated: #1f1f23;
            --text-primary: #fafafa;
            --text-secondary: #a1a1aa;
            --text-tertiary: #71717a;
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --accent-subtle: rgba(99, 102, 241, 0.1);
            --border: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.1);
            --gradient-1: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%);
            --gradient-2: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-xl: 32px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="light"] {
            --bg-primary: #fafafa;
            --bg-secondary: #f0f0f3;
            --bg-tertiary: #e8e8ec;
            --bg-elevated: #ffffff;
            --text-primary: #1a1a1f;
            --text-secondary: #5c5c66;
            --text-tertiary: #8c8c96;
            --border: rgba(0, 0, 0, 0.08);
            --border-hover: rgba(0, 0, 0, 0.15);
            --accent-subtle: rgba(99, 102, 241, 0.1);
        }

        [data-theme="light"] body {
            background: linear-gradient(180deg, #fafafa 0%, #f0f0f3 100%);
        }

        [data-theme="light"] .bento-item,
        [data-theme="light"] .process-card,
        [data-theme="light"] .pricing-card,
        [data-theme="light"] .testimonial-featured,
        [data-theme="light"] .testimonial-mini {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        [data-theme="light"] .marquee-section {
            background: #e8e8ec;
        }

        [data-theme="light"] .cta-circle {
            border-color: rgba(0, 0, 0, 0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 16px 0;
            background: transparent;
            transition: var(--transition);
        }

        nav.scrolled {
            background: rgba(10, 10, 11, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        [data-theme="light"] nav.scrolled {
            background: rgba(255, 255, 255, 0.8);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 24px;
            font-weight: 800;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .logo svg { flex-shrink: 0; }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--text-primary);
            background: var(--accent-subtle);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-ghost {
            color: var(--text-secondary);
            background: transparent;
        }

        .btn-ghost:hover {
            color: var(--text-primary);
            background: var(--accent-subtle);
        }

        .btn-primary {
            color: white;
            background: var(--accent);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
        }

        .btn-secondary {
            color: var(--text-primary);
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--bg-elevated);
            border-color: var(--border-hover);
        }

        .theme-toggle {
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--bg-secondary);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            border-color: var(--border-hover);
            color: var(--text-primary);
        }

        .theme-toggle svg { width: 18px; height: 18px; }
        .theme-toggle .sun { display: none; }
        .theme-toggle .moon { display: block; }
        [data-theme="light"] .theme-toggle .sun { display: block; }
        [data-theme="light"] .theme-toggle .moon { display: none; }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
            background: var(--bg-primary);
        }


        .hero {
            position: relative;
            overflow: hidden;
            background: var(--bg-primary);
        }

        .hero-particles {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        #particles-canvas {
            width: 100vw;
            height: 100vh;
            min-width: 100%;
            min-height: 100%;
            max-width: 100vw;
            max-height: 100vh;
            display: block;
            position: absolute;
            top: 0;
            left: 0;
        }

        .hero > .container {
            position: relative;
            z-index: 2;
        }

        .hero > .container {
            position: relative;
            z-index: 1;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 220px;
            align-items: center;
        }

        @media (max-width: 1200px) {
            .hero-grid {
                gap: 64px;
            }
        }
        @media (max-width: 900px) {
            .hero-grid {
                gap: 32px;
            }
        }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 100px;
            background: var(--accent-subtle);
            border: 1px solid rgba(99, 102, 241, 0.2);
            color: var(--accent);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .hero-badge::before {
            content: '';
            width: 6px; height: 6px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-60px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(60px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-badge { animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        .hero h1 {
            font-size: clamp(48px, 6vw, 72px);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -2px;
            margin-bottom: 24px;
            animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards;
            opacity: 0;
        }

        .hero h1 .gradient {
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 18px;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 40px;
            max-width: 480px;
            animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards;
            opacity: 0;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards;
            opacity: 0;
        }

        .btn-lg { padding: 14px 28px; font-size: 15px; }

        .hero-stats {
            display: flex;
            gap: 48px;
            margin-top: 64px;
            padding-top: 32px;
            border-top: 1px solid var(--border);
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards;
            opacity: 0;
        }

        .stat { text-align: left; }

        .stat-value {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* ═══════════════════════════════════
           3D PHONE COMPONENT
        ═══════════════════════════════════ */
        .hero-visual {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 600px;
            animation: slideInRight 1s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards;
            opacity: 0;
            z-index: 2;
        }

        .phone-scene {
            perspective: 1200px;
            width: 320px;
            height: 600px;
            position: relative;
        }

        .phone-wrapper {
            width: 100%; height: 100%;
            transform: rotateY(-18deg) rotateX(4deg) rotateZ(1.5deg);
            transform-style: preserve-3d;
            transition: transform 0.6s ease;
            animation: phone-float 6s ease-in-out infinite;
            position: relative;
        }

        .phone-wrapper:hover {
            transform: rotateY(-8deg) rotateX(2deg) rotateZ(0.5deg);
        }

        @keyframes phone-float {
            0%, 100% { transform: rotateY(-18deg) rotateX(4deg) rotateZ(1.5deg) translateY(0px); }
            50%       { transform: rotateY(-18deg) rotateX(4deg) rotateZ(1.5deg) translateY(-14px); }
        }

        .phone-body {
            width: 280px;
            height: 570px;
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

        .phone-body::before {
            content: '';
            position: absolute;
            top: 0; left: 20px; right: 20px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            z-index: 10;
        }

        .phone-body::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 40%; height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, transparent 100%);
            z-index: 10;
            pointer-events: none;
        }

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

        .dynamic-island {
            position: absolute;
            top: 14px; left: 50%;
            transform: translateX(-50%);
            width: 90px; height: 26px;
            background: #000;
            border-radius: 20px;
            z-index: 20;
            display: flex; align-items: center; justify-content: center; gap: 6px;
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

        .p-status-bar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 54px 24px 0;
            font-family: 'Sora', sans-serif;
            font-size: 11px;
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            flex-shrink: 0;
        }

        .p-card-content {
            width: 100%; flex: 1;
            display: flex; flex-direction: column;
            align-items: center;
            padding: 18px 18px 14px;
            overflow: hidden;
        }

        .p-avatar {
            width: 68px; height: 68px; border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
            border: 2px solid rgba(99,102,241,0.4);
            flex-shrink: 0; overflow: hidden;
        }

        .p-avatar-inner {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(160deg, #2a2a50, #1a1a30);
            border-radius: 50%;
        }

        .p-name {
            font-family: 'Sora', sans-serif;
            font-size: 17px; font-weight: 700; color: #fff;
            letter-spacing: -0.02em; margin-bottom: 2px;
            text-align: center; flex-shrink: 0;
        }

        .p-handle {
            font-family: 'Sora', sans-serif;
            font-size: 11px; color: #6366f1;
            margin-bottom: 12px; flex-shrink: 0;
        }

        .p-qr {
            background: #fff; border-radius: 12px;
            padding: 10px;
            width: 118px; height: 118px;
            margin-bottom: 7px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }

        .p-qr-grid {
            display: grid;
            grid-template-columns: repeat(9, 1fr);
            gap: 1.5px; width: 100%; height: 100%;
        }

        .pq  { background: #111; border-radius: 0.5px; }
        .pqw { background: #f5f5f5; border-radius: 0.5px; }

        .p-qr-hint {
            font-family: 'Sora', sans-serif;
            font-size: 8px; color: #2a2c50;
            letter-spacing: 0.06em; margin-bottom: 9px;
            text-align: center; flex-shrink: 0;
        }

        .p-stats {
            display: flex; width: 100%;
            border-top: 1px solid rgba(255,255,255,0.05);
            padding: 7px 0; margin-bottom: 9px; flex-shrink: 0;
        }

        .ps { flex: 1; text-align: center; }
        .ps-num { font-family: 'Sora', sans-serif; font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.7); }
        .ps-lbl { font-family: 'Sora', sans-serif; font-size: 7px; color: #222444; text-transform: uppercase; letter-spacing: 0.08em; }
        .ps-div { width: 1px; background: rgba(255,255,255,0.05); align-self: stretch; }

        .p-contacts {
            width: 100%;
            display: flex; flex-direction: column; gap: 5px;
            margin-bottom: 10px; flex-shrink: 0;
        }

        .p-contact-row {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 9px;
            padding: 8px 10px;
            display: flex; align-items: center; gap: 8px;
        }

        .p-cr-icon {
            width: 22px; height: 22px; border-radius: 6px;
            background: rgba(99,102,241,0.15);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .p-cr-text {
            font-family: 'Sora', sans-serif;
            font-size: 9px; color: #4a4c72;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .p-action-btns {
            display: flex; gap: 7px;
            width: 100%; flex-shrink: 0;
        }

        .p-btn-call {
            flex: 1; padding: 9px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none; border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 11px; font-weight: 700; color: #fff;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 5px;
        }

        .p-btn-email {
            flex: 1; padding: 9px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.6);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 5px;
        }

        .phone-home {
            position: absolute;
            bottom: 10px; left: 50%; transform: translateX(-50%);
            width: 110px; height: 4px;
            background: rgba(255,255,255,0.2);
            border-radius: 2px; z-index: 20;
        }

        .phone-glow {
            position: absolute;
            bottom: -60px; left: 50%; transform: translateX(-50%);
            width: 280px; height: 120px;
            background: radial-gradient(ellipse, rgba(99,102,241,0.28) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Floating badges */
        .p-badge-saved {
            position: absolute;
            top: 70px; right: -24px;
            background: rgba(10,10,24,0.92);
            border: 1px solid rgba(99,102,241,0.3);
            border-radius: 14px;
            padding: 11px 14px;
            display: flex; align-items: center; gap: 10px;
            backdrop-filter: blur(12px);
            animation: badge-float 5s ease-in-out infinite;
            z-index: 30;
            white-space: nowrap;
        }

        .p-badge-nfc {
            position: absolute;
            bottom: 110px; left: -28px;
            background: rgba(10,10,24,0.92);
            border: 1px solid rgba(34,211,238,0.25);
            border-radius: 100px;
            padding: 9px 16px;
            display: flex; align-items: center; gap: 8px;
            backdrop-filter: blur(12px);
            animation: badge-float 4s ease-in-out infinite 0.5s;
            z-index: 30;
            white-space: nowrap;
        }

        @keyframes badge-float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-8px); }
        }

        .pb-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .pb-text { display: flex; flex-direction: column; gap: 1px; }
        .pb-title { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700; color: #fff; }
        .pb-sub   { font-family: 'Sora', sans-serif; font-size: 9px; color: #4a4c72; }

        .pbnfc-dot { width: 6px; height: 6px; border-radius: 50%; background: #22d3ee; }
        .pbnfc-text { font-family: 'Sora', sans-serif; font-size: 10px; font-weight: 600; color: #22d3ee; letter-spacing: 0.05em; }
        /* ═══════════════════════════════════ */

        /* Marquee */
        .marquee-section {
            padding: 48px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            overflow: hidden;
            background: var(--bg-secondary);
        }

        .marquee {
            display: flex;
            gap: 64px;
            animation: marquee 30s linear infinite;
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .marquee-item {
            display: flex;
            align-items: center;
            gap: 16px;
            white-space: nowrap;
            color: var(--text-tertiary);
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .marquee-item::after { content: '✦'; color: var(--accent); }

        /* Features Bento */
        .features-section { padding: 160px 0; }

        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--accent);
            margin-bottom: 20px;
        }

        .section-eyebrow::before,
        .section-eyebrow::after {
            content: '';
            width: 24px; height: 1px;
            background: var(--accent);
        }

        .section-title {
            font-size: clamp(36px, 5vw, 56px);
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .section-subtitle {
            font-size: 18px;
            color: var(--text-secondary);
            max-width: 600px;
            margin-bottom: 64px;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
        }

        .bento-item {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 32px;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .bento-item:hover {
            border-color: var(--border-hover);
            transform: translateY(-4px);
        }

        .bento-item.span-8 { grid-column: span 8; }
        .bento-item.span-6 { grid-column: span 6; }
        .bento-item.span-4 { grid-column: span 4; }

        .bento-icon {
            width: 48px; height: 48px;
            border-radius: var(--radius-md);
            background: var(--accent-subtle);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px;
        }

        .bento-icon svg { width: 24px; height: 24px; color: var(--accent); }

        .bento-item h3 { font-size: 20px; font-weight: 700; margin-bottom: 12px; letter-spacing: -0.3px; }
        .bento-item p { color: var(--text-secondary); font-size: 15px; line-height: 1.6; }

        .bento-item.featured { background: var(--gradient-1); border: none; }
        .bento-item.featured h3, .bento-item.featured p { color: white; }
        .bento-item.featured .bento-icon { background: rgba(255,255,255,0.2); }
        .bento-item.featured .bento-icon svg { color: white; }

        .bento-visual {
            position: absolute;
            bottom: -20px; right: -20px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(99,102,241,0.3) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Process Section */
        .process-section { padding: 160px 0; background: var(--bg-secondary); }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 64px;
        }

        .process-card {
            position: relative;
            padding: 40px 32px;
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            transition: var(--transition);
        }

        .process-card:hover { border-color: var(--accent); transform: translateY(-8px); }

        .process-number {
            position: absolute;
            top: -20px; left: 32px;
            width: 40px; height: 40px;
            background: var(--accent);
            color: white;
            font-size: 16px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            border-radius: var(--radius-sm);
        }

        .process-card h3 { font-size: 18px; font-weight: 700; margin-bottom: 12px; margin-top: 16px; }
        .process-card p { font-size: 14px; color: var(--text-secondary); line-height: 1.6; }

        /* Pricing Section */
        .pricing-section { padding: 160px 0; }

        .pricing-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 64px;
        }

        .pricing-wrapper.pricing-two-cols {
            grid-template-columns: repeat(2, 1fr);
            max-width: 900px;
            margin-left: auto; margin-right: auto;
        }

        .pricing-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 40px;
            position: relative;
            transition: var(--transition);
        }

        .pricing-card:hover { border-color: var(--border-hover); }

        .pricing-card.popular {
            background: var(--bg-tertiary);
            border-color: var(--accent);
            transform: scale(1.05);
        }

        .pricing-card.popular::before {
            content: 'Popular';
            position: absolute;
            top: -12px; left: 50%; transform: translateX(-50%);
            background: var(--accent);
            color: white;
            font-size: 12px; font-weight: 600;
            padding: 4px 16px;
            border-radius: 100px;
        }

        .pricing-name { font-size: 14px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; }

        .pricing-price {
            display: flex;
            align-items: baseline;
            gap: 4px;
            margin-bottom: 8px;
        }

        .pricing-price .currency { font-size: 24px; font-weight: 600; color: var(--text-secondary); }
        .pricing-price .amount { font-size: 56px; font-weight: 800; letter-spacing: -2px; line-height: 1; }
        .pricing-price .period { font-size: 14px; color: var(--text-tertiary); }

        .pricing-description { font-size: 14px; color: var(--text-secondary); margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid var(--border); }

        .pricing-features { list-style: none; margin-bottom: 32px; }

        .pricing-features li {
            display: flex; align-items: center; gap: 12px;
            font-size: 14px; color: var(--text-secondary);
            padding: 10px 0;
        }

        .pricing-features li svg { width: 18px; height: 18px; color: var(--accent); flex-shrink: 0; }

        .pricing-card .btn { width: 100%; }

        .pricing-custom { display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap; }
        .pricing-custom .amount-small { font-size: 36px; font-weight: 800; letter-spacing: -1px; }
        .pricing-custom .amount-plus { font-size: 24px; color: var(--text-tertiary); }

        .pricing-example { margin-top: 16px; font-size: 13px; color: var(--text-tertiary); text-align: center; padding: 12px; background: var(--accent-subtle); border-radius: var(--radius-sm); }

        .pricing-business { background: var(--bg-tertiary); border: 2px dashed var(--border-hover); }
        .pricing-business:hover { border-color: var(--accent); border-style: solid; }

        .pricing-toggle {
            display: flex; justify-content: center;
            gap: 4px; margin-bottom: 48px;
            background: var(--bg-secondary);
            padding: 6px; border-radius: 100px;
            width: fit-content;
            margin-left: auto; margin-right: auto;
            border: 1px solid var(--border);
        }

        .toggle-btn {
            padding: 12px 24px; border: none;
            background: transparent; color: var(--text-secondary);
            font-size: 14px; font-weight: 600;
            border-radius: 100px; cursor: pointer;
            transition: var(--transition);
            display: flex; align-items: center; gap: 8px;
        }

        .toggle-btn:hover { color: var(--text-primary); }
        .toggle-btn.active { background: var(--accent); color: white; }

        .discount-badge { background: rgba(16,185,129,0.2); color: #10b981; padding: 2px 8px; border-radius: 100px; font-size: 11px; font-weight: 700; }
        .toggle-btn.active .discount-badge { background: rgba(255,255,255,0.2); color: white; }

        .pricing-yearly-note { font-size: 13px; color: var(--text-tertiary); margin-bottom: 16px; margin-top: -4px; }
        .pricing-yearly-note strong { color: #10b981; }
        [data-period="yearly"] .pricing-yearly-note { display: none; }

        /* Testimonials */
        .testimonials-section { padding: 160px 0; background: var(--bg-secondary); }

        .testimonials-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 24px;
            margin-top: 64px;
        }

        .testimonial-featured {
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 48px;
            display: flex; flex-direction: column; justify-content: space-between;
        }

        .testimonial-quote { font-size: 28px; font-weight: 500; line-height: 1.5; letter-spacing: -0.5px; margin-bottom: 48px; }

        .testimonial-author { display: flex; align-items: center; gap: 16px; }

        .testimonial-avatar {
            width: 56px; height: 56px; border-radius: 50%;
            background: var(--gradient-1);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 18px;
        }

        .testimonial-info h4 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
        .testimonial-info p { font-size: 14px; color: var(--text-tertiary); }

        .testimonials-stack { display: flex; flex-direction: column; gap: 24px; }

        .testimonial-mini {
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 28px;
        }

        .testimonial-mini-quote { font-size: 15px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 20px; }
        .testimonial-mini .testimonial-avatar { width: 40px; height: 40px; font-size: 14px; }
        .testimonial-mini .testimonial-info h4 { font-size: 14px; }
        .testimonial-mini .testimonial-info p { font-size: 12px; }

        /* CTA Section */
        .cta-section { padding: 160px 0; position: relative; overflow: hidden; }

        .cta-content { text-align: center; position: relative; z-index: 2; }

        .cta-title { font-size: clamp(40px, 5vw, 64px); font-weight: 800; letter-spacing: -2px; margin-bottom: 24px; line-height: 1.1; }

        .cta-description { font-size: 18px; color: var(--text-secondary); margin-bottom: 40px; max-width: 500px; margin-left: auto; margin-right: auto; }

        .cta-circles { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1; }

        .cta-circle {
            position: absolute;
            border: 1px solid var(--border);
            border-radius: 50%;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation: cta-float 6s ease-in-out infinite;
        }

        .cta-circle:nth-child(1) { width: 300px; height: 300px; animation-delay: 0s; }
        .cta-circle:nth-child(2) { width: 500px; height: 500px; animation-delay: 0.5s; }
        .cta-circle:nth-child(3) { width: 700px; height: 700px; animation-delay: 1s; }

        @keyframes cta-float {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.3; }
            50% { transform: translate(-50%, -50%) scale(1.05); opacity: 0.6; }
        }

        /* Footer */
        footer { padding: 80px 0 40px; border-top: 1px solid var(--border); }

        .footer-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 64px; }

        .footer-brand { max-width: 300px; }
        .footer-brand .logo { margin-bottom: 16px; }
        .footer-brand p { font-size: 14px; color: var(--text-secondary); line-height: 1.6; }

        .footer-links { display: flex; gap: 80px; }

        .footer-column h4 { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--text-tertiary); margin-bottom: 20px; }
        .footer-column ul { list-style: none; }
        .footer-column li { margin-bottom: 12px; }
        .footer-column a { font-size: 14px; color: var(--text-secondary); text-decoration: none; transition: var(--transition); }
        .footer-column a:hover { color: var(--text-primary); }

        .footer-bottom { display: flex; justify-content: space-between; align-items: center; padding-top: 32px; border-top: 1px solid var(--border); }
        .footer-bottom p { font-size: 13px; color: var(--text-tertiary); }

        .footer-social { display: flex; gap: 16px; }
        .footer-social a { width: 36px; height: 36px; border-radius: 50%; background: var(--bg-secondary); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); transition: var(--transition); }
        .footer-social a:hover { background: var(--accent); border-color: var(--accent); color: white; }
        .footer-social svg { width: 16px; height: 16px; }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr; gap: 48px; }
            .hero-visual { height: 500px; }
            .bento-item.span-8, .bento-item.span-6, .bento-item.span-4 { grid-column: span 6; }
            .process-grid { grid-template-columns: repeat(2, 1fr); }
            .pricing-wrapper { grid-template-columns: 1fr; }
            .pricing-card.popular { transform: none; }
            .testimonials-grid { grid-template-columns: 1fr; }
            .footer-top { flex-direction: column; gap: 48px; }
            .footer-links { gap: 48px; }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .bento-item.span-8, .bento-item.span-6, .bento-item.span-4 { grid-column: span 12; }
            .process-grid { grid-template-columns: 1fr; }
            .hero-stats { flex-wrap: wrap; gap: 32px; }
            .footer-links { flex-wrap: wrap; gap: 32px; }
            .footer-bottom { flex-direction: column; gap: 24px; text-align: center; }
            .p-badge-saved { display: none; }
            .p-badge-nfc { display: none; }
        }

        .demo-section { padding: 160px 0; background: var(--bg-primary); position: relative; overflow: hidden; }
        .demo-section::before { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 800px; height: 600px; background: radial-gradient(ellipse, rgba(99,102,241,0.07) 0%, transparent 65%); pointer-events: none; }
        .demo-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; position: relative; z-index: 2; }
        .demo-steps { display: flex; flex-direction: column; gap: 28px; margin-top: 40px; }
        .demo-step { display: flex; gap: 18px; align-items: flex-start; }
        .demo-step-num { width: 34px; height: 34px; border-radius: 50%; background: var(--accent-subtle); border: 1px solid rgba(99,102,241,0.25); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: var(--accent); flex-shrink: 0; }
        .demo-step-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin-bottom: 3px; }
        .demo-step-desc { font-size: 14px; color: var(--text-secondary); line-height: 1.6; }
        .demo-cta-note { margin-top: 36px; display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--text-secondary); }
        .demo-cta-note svg { width: 18px; height: 18px; color: #10b981; flex-shrink: 0; }
        .demo-card { background: var(--bg-secondary); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 44px 40px; display: flex; flex-direction: column; align-items: center; position: relative; }
        .demo-card::before { content: ''; position: absolute; top: 0; left: 40px; right: 40px; height: 1px; background: linear-gradient(90deg, transparent, rgba(99,102,241,0.3), transparent); }
        .demo-card-badge { display: inline-flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .14em; color: var(--accent); margin-bottom: 28px; }
        .demo-card-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--accent); animation: pulse 2s infinite; }
        .demo-digital-card { background: linear-gradient(160deg, #1a1a2e, #0c0c18); border: 1px solid rgba(255,255,255,0.08); border-radius: 18px; padding: 22px 20px; width: 100%; max-width: 260px; display: flex; flex-direction: column; align-items: center; box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(99,102,241,0.1); margin-bottom: 28px; }
        .ddc-avatar { width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; margin-bottom: 9px; border: 2px solid rgba(99,102,241,0.35); }
        .ddc-avatar svg { width: 26px; height: 26px; }
        .ddc-name { font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 2px; letter-spacing: -0.02em; }
        .ddc-role { font-family: 'Sora', sans-serif; font-size: 10px; color: #6366f1; margin-bottom: 16px; }
        .demo-qr-box { width: 140px; height: 140px; background: white; border-radius: 10px; padding: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 20px rgba(0,0,0,0.15); margin-bottom: 10px; overflow: hidden; }
        .demo-qr-placeholder { width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; border: 1.5px dashed #d1d5db; border-radius: 6px; }
        .demo-qr-placeholder svg { width: 36px; height: 36px; color: #6366f1; opacity: .6; }
        .demo-qr-placeholder span { font-size: 9px; color: #9ca3af; text-align: center; line-height: 1.4; font-family: 'Inter', sans-serif; }
        .ddc-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.06); margin: 14px 0; }
        .ddc-links { width: 100%; display: flex; flex-direction: column; gap: 5px; }
        .ddc-link { display: flex; align-items: center; gap: 8px; padding: 6px 8px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 7px; }
        .ddc-link-icon { width: 18px; height: 18px; border-radius: 4px; background: rgba(99,102,241,0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .ddc-link-icon svg { width: 9px; height: 9px; color: #818cf8; }
        .ddc-link-text { font-family: 'Sora', sans-serif; font-size: 9px; color: #4a4c72; }
        .demo-qr-hint { font-size: 12px; color: var(--text-tertiary); text-align: center; display: flex; align-items: center; gap: 6px; margin-bottom: 20px; }
        .demo-qr-hint svg { width: 13px; height: 13px; color: var(--accent); }
        .demo-or { font-size: 12px; color: var(--text-tertiary); margin: 8px 0 12px; }
        .demo-link-btn { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: var(--accent); text-decoration: none; transition: var(--transition); }
        .demo-link-btn:hover { gap: 10px; }
        .demo-link-btn svg { width: 13px; height: 13px; }
 
        @media (max-width: 1024px) {
            .demo-grid { grid-template-columns: 1fr; gap: 48px; }
        }
    </style>
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/service-worker.js');
        });
    }
</script>
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-inner">
            <a href="/" class="logo">
                <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="7" fill="#070915"/>
                    <path d="M20.8 21.2C17.99 24.01 13.43 24.01 10.62 21.2C7.81 18.39 7.81 13.83 10.62 11.02C13.43 8.21 17.99 8.21 20.8 11.02" stroke="#F2F2EE" stroke-width="2" stroke-linecap="round"/>
                    <path d="M13.85 13.45L17.65 16L13.85 18.55" stroke="#B08CFF" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Cardifys
            </a>
            <div class="nav-links">
                <a href="#features">Funcionalidades</a>
                <a href="#how-it-works">Como Funciona</a>
                <a href="#pricing">Preços</a>
            </div>
            <div class="nav-actions">
                <button class="theme-toggle" id="theme-toggle" aria-label="Toggle theme">
                    <svg class="sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg class="moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-ghost">Sair</button>
                    </form>
                @else
                    <a href="/login" class="btn btn-ghost">Entrar</a>
                    <a href="/register" class="btn btn-primary">Começar Grátis</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-particles">
            <canvas id="particles-canvas"></canvas>
        </div>

        <div class="container">
            <div class="hero-grid">
                <!-- LEFT: copy (unchanged) -->
                <div class="hero-content">

                    <h1>
                        Networking<br>
                        <span class="gradient">reinventado.</span>
                    </h1>
                    <p class="hero-description">
                        Crie cartões de visita digitais impressionantes. Partilhe com um toque.
                        Acompanhe resultados em tempo real.
                    </p>
                    <div class="hero-actions">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                Criar Cartão
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        @endif
                        <a href="#demo" class="btn btn-secondary btn-lg">Ver Demo</a>
                    </div>
                    <div class="hero-stats" style="justify-content: flex-start;">
                        <div class="stat" style="font-size: 1.1rem; font-weight: 600; color: var(--accent);">
                            Lançamento oficial — sê dos primeiros
                        </div>
                    </div>
                </div>

                <!-- RIGHT: 3D Phone (substitui hero-canvas) -->
                <div class="hero-visual">
                    <div class="phone-scene">
                        <div class="phone-wrapper">

                            <div class="phone-btn-right"></div>
                            <div class="phone-btn-left-1"></div>
                            <div class="phone-btn-left-2"></div>

                            <div class="phone-body">
                                <div class="dynamic-island">
                                    <div class="di-sensor"></div>
                                    <div class="di-camera"></div>
                                </div>

                                <div class="phone-screen">
                                    <div class="p-status-bar">
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

                                    <div class="p-card-content">
                                        <div class="p-avatar">
                                            <div class="p-avatar-inner">
                                                <svg width="34" height="34" viewBox="0 0 40 40" fill="none">
                                                    <circle cx="20" cy="14" r="5" fill="rgba(255,255,255,0.2)"/>
                                                    <rect x="14" y="8" width="12" height="10" rx="6" fill="rgba(255,255,255,0.12)" stroke="rgba(255,255,255,0.15)" stroke-width="1"/>
                                                    <path d="M8 36C8 29 13.373 24 20 24C26.627 24 32 29 32 36" fill="rgba(255,255,255,0.1)"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="p-name">Rodrigo Pacheco</div>
                                        <div class="p-handle">rynex</div>

                                        <div class="p-qr">
                                            <div class="p-qr-grid">
                                                <div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div>
                                                <div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div>
                                                <div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div>
                                                <div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div>
                                                <div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div>
                                                <div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pqw"></div>
                                                <div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div>
                                                <div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div><div class="pq"></div><div class="pqw"></div><div class="pq"></div>
                                                <div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div><div class="pq"></div>
                                            </div>
                                        </div>
                                        <div class="p-qr-hint">Lê o QR Code para guardar o contacto</div>

                                        <div class="p-stats">
                                            <div class="ps"><div class="ps-num">25</div><div class="ps-lbl">Visualizações</div></div>
                                            <div class="ps-div"></div>
                                            <div class="ps"><div class="ps-num">0</div><div class="ps-lbl">QR Scans</div></div>
                                            <div class="ps-div"></div>
                                            <div class="ps"><div class="ps-num">0</div><div class="ps-lbl">Guardados</div></div>
                                        </div>

                                        <div class="p-contacts">
                                            <div class="p-contact-row">
                                                <div class="p-cr-icon">
                                                    <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><rect x="1" y="2" width="10" height="8" rx="1.5" stroke="#818cf8" stroke-width="1"/><path d="M1 4.5L6 7L11 4.5" stroke="#818cf8" stroke-width="1"/></svg>
                                                </div>
                                                <span class="p-cr-text"><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="7f17160d101b0d1618100f1e1c171a1c103f18121e1613511c1012">[email&#160;protected]</a></span>
                                            </div>
                                            <div class="p-contact-row">
                                                <div class="p-cr-icon">
                                                    <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><path d="M3 1.5C3 1.5 2.5 3.5 2.5 6C2.5 8.5 3 10.5 3 10.5L4.5 9L5.5 7.5C5.5 7.5 5 6.5 5 6C5 5.5 5.5 4.5 5.5 4.5L4.5 3L3 1.5Z" stroke="#818cf8" stroke-width="0.8" stroke-linejoin="round"/></svg>
                                                </div>
                                                <span class="p-cr-text">916 286 618</span>
                                            </div>
                                            <div class="p-contact-row">
                                                <div class="p-cr-icon">
                                                    <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="4.5" stroke="#818cf8" stroke-width="1"/><path d="M6 1.5C6 1.5 4.5 3.5 4.5 6C4.5 8.5 6 10.5 6 10.5M6 1.5C6 1.5 7.5 3.5 7.5 6C7.5 8.5 6 10.5 6 10.5M1.5 6H10.5" stroke="#818cf8" stroke-width="1"/></svg>
                                                </div>
                                                <span class="p-cr-text">rpachecoportfolio.vercel.app</span>
                                            </div>
                                        </div>

                                        <div class="p-action-btns">
                                            <button class="p-btn-call">
                                                <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><path d="M3 1.5C3 1.5 2.5 3.5 2.5 6C2.5 8.5 3 10.5 3 10.5L4.5 9L5.5 7.5C5.5 7.5 5 6.5 5 6C5 5.5 5.5 4.5 5.5 4.5L4.5 3L3 1.5Z" fill="white"/></svg>
                                                Ligar
                                            </button>
                                            <button class="p-btn-email">
                                                <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><rect x="1" y="2.5" width="10" height="7" rx="1.5" stroke="rgba(255,255,255,0.5)" stroke-width="1"/><path d="M1 5L6 7.5L11 5" stroke="rgba(255,255,255,0.5)" stroke-width="1"/></svg>
                                                Email
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="phone-home"></div>
                            </div>

                            <!-- Floating badges -->
                            <div class="p-badge-saved">
                                <div class="pb-icon">
                                    <svg width="16" height="16" viewBox="0 0 18 18" fill="none"><path d="M14 9C14 11.761 11.761 14 9 14C6.239 14 4 11.761 4 9C4 6.239 6.239 4 9 4" stroke="white" stroke-width="1.8" stroke-linecap="round"/><path d="M9 4L12 7L9 10" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <div class="pb-text">
                                    <span class="pb-title">Contacto guardado!</span>
                                    <span class="pb-sub">via QR · agora mesmo</span>
                                </div>
                            </div>



                        </div>
                        <div class="phone-glow"></div>
                    </div>
                </div>
                <!-- END 3D Phone -->

            </div>
        </div>
    </section>

    <!-- Marquee Section -->
    <section class="marquee-section">
        <div class="marquee">
            <span class="marquee-item">QR Code</span>

            <span class="marquee-item">Analytics</span>
            <span class="marquee-item">Multi-cartão</span>
            <span class="marquee-item">API</span>
            <span class="marquee-item">Equipas</span>
            <span class="marquee-item">Personalização</span>
            <span class="marquee-item">QR Code</span>

            <span class="marquee-item">Analytics</span>
            <span class="marquee-item">Multi-cartão</span>
            <span class="marquee-item">API</span>
            <span class="marquee-item">Equipas</span>
            <span class="marquee-item">Personalização</span>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-eyebrow">Funcionalidades</div>
            <h2 class="section-title">Tudo o que precisa,<br>nada que não precise.</h2>
            <p class="section-subtitle">Ferramentas profissionais pensadas para quem valoriza conexões genuínas e resultados mensuráveis.</p>
            <div class="bento-grid">
                <div class="bento-item span-8">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                    <h3>Partilha Instantânea</h3>
                    <p>QR Code ou link direto. O destinatário não precisa de instalar qualquer app. Basta digitalizar ou aceder ao link.</p>
                </div>
                <div class="bento-item span-4">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3>Analytics Real-time</h3>
                    <p>Saiba quem visualizou, quando e de onde. Optimize a sua estratégia.</p>
                </div>
                <div class="bento-item span-4">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                    </div>
                    <h3>100% Personalizável</h3>
                    <p>Cores, fontes, layouts. A sua marca, a sua identidade.</p>
                </div>
                <div class="bento-item span-4">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <h3>Gestão de Equipas</h3>
                    <p>Controle centralizado para empresas de qualquer dimensão.</p>
                </div>
                <div class="bento-item span-4">
                    <div class="bento-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <h3>Privacidade Total</h3>
                    <p>Controle exatamente o que partilha. Encriptação end-to-end.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section id="how-it-works" class="process-section">
        <div class="container">
            <div class="section-eyebrow">Como Funciona</div>
            <h2 class="section-title">Do registo à primeira<br>partilha em 2 minutos.</h2>
            <p class="section-subtitle">Sem complicações. Sem curva de aprendizagem. Comece agora.</p>
            <div class="process-grid">
                <div class="process-card"><div class="process-number">1</div><h3>Crie conta</h3><p>Email e password. É tudo o que precisa para começar. Sem cartão de crédito.</p></div>
                <div class="process-card"><div class="process-number">2</div><h3>Personalize</h3><p>Adicione as suas informações, foto e escolha um design que represente a sua marca.</p></div>
                <div class="process-card"><div class="process-number">3</div><h3>Partilhe</h3><p>Use o QR Code ou partilhe o link diretamente. Sem apps necessárias.</p></div>
                <div class="process-card"><div class="process-number">4</div><h3>Analise</h3><p>Acompanhe métricas em tempo real e optimize a sua estratégia de networking.</p></div>
            </div>
        </div>
    </section>

    <section id="demo" class="demo-section">
    <div class="container">
        <div class="demo-grid">
 
            <!-- LEFT: copy -->
            <div class="demo-copy">
                <div class="section-eyebrow">Demo ao vivo</div>
                <h2 class="section-title">Experimenta antes<br>de te registares.</h2>
                <p class="section-subtitle" style="margin-bottom:0;">Pega no telemóvel, aponta a câmara para o QR Code e vê exactamente o que um cliente ou parceiro vê quando recebe o teu cartão Cardifys.</p>
 
                <div class="demo-steps">
                    <div class="demo-step">
                        <div class="demo-step-num">1</div>
                        <div>
                            <div class="demo-step-title">Abre a câmara do telemóvel</div>
                            <div class="demo-step-desc">Funciona com a câmara nativa do iOS e Android. Sem instalar qualquer app.</div>
                        </div>
                    </div>
                    <div class="demo-step">
                        <div class="demo-step-num">2</div>
                        <div>
                            <div class="demo-step-title">Aponta para o QR Code</div>
                            <div class="demo-step-desc">Um link aparece automaticamente no ecrã. Clica e o cartão abre no browser.</div>
                        </div>
                    </div>
                    <div class="demo-step">
                        <div class="demo-step-num">3</div>
                        <div>
                            <div class="demo-step-title">Explora o cartão demo</div>
                            <div class="demo-step-desc">Vê o design, os links, guarda o contacto como vCard. É isto que os teus contactos vão receber.</div>
                        </div>
                    </div>
                </div>
 
                <div class="demo-cta-note">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Sem registo. Sem dados pedidos. Experimenta à vontade.
                </div>
            </div>
 
            <!-- RIGHT: QR card -->
            <div class="demo-card">
                <div class="demo-card-badge">Cartão de Demonstração</div>
 
                <!-- Mini cartão digital -->
                <div class="demo-digital-card">
                    <div class="ddc-avatar">
                        <svg fill="none" viewBox="0 0 40 40">
                            <circle cx="20" cy="14" r="6" fill="rgba(255,255,255,0.25)"/>
                            <path d="M8 38C8 30.268 13.373 25 20 25C26.627 25 32 30.268 32 38" fill="rgba(255,255,255,0.15)"/>
                        </svg>
                    </div>
                    <div class="ddc-name">Cardifys Demo</div>
                    <div class="ddc-role">Cartão de visita digital</div>
 
                    {{-- QR CODE funcional - aponta para o cartão demo --}}
                    <div class="demo-qr-box">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&color=6366f1&data={{ urlencode(route('card.demo')) }}"
                             alt="QR Code Demo Cardifys"
                             style="width:100%;height:100%;object-fit:contain;border-radius:4px;">
                    </div>
 
                    <div class="ddc-divider"></div>
                    <div class="ddc-links">
                        <div class="ddc-link">
                            <div class="ddc-link-icon">
                                <svg fill="none" viewBox="0 0 12 12" stroke="currentColor"><rect x="1" y="2" width="10" height="8" rx="1.5" stroke-width="1"/><path d="M1 4.5L6 7L11 4.5" stroke-width="1"/></svg>
                            </div>
                            <span class="ddc-link-text">hello@cardifys.com</span>
                        </div>
                        <div class="ddc-link">
                            <div class="ddc-link-icon">
                                <svg fill="none" viewBox="0 0 12 12" stroke="currentColor"><circle cx="6" cy="6" r="4.5" stroke-width="1"/><path d="M6 1.5C6 1.5 4.5 3.5 4.5 6C4.5 8.5 6 10.5 6 10.5M6 1.5C6 1.5 7.5 3.5 7.5 6C7.5 8.5 6 10.5 6 10.5M1.5 6H10.5" stroke-width="1"/></svg>
                            </div>
                            <span class="ddc-link-text">cardifys.com</span>
                        </div>
                    </div>
                </div>
 
                <!-- Instrução scan -->
                <div class="demo-qr-hint">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Aponta a câmara do telemóvel para o QR
                </div>
 
                <div class="demo-or">— ou —</div>
 
                {{-- Link direto para abrir o cartão demo --}}
                <a href="{{ route('card.demo') }}" class="demo-link-btn" target="_blank" rel="noopener">
                    Abrir cartão demo no browser
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
 
        </div>
    </div>
</section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing-section">
        <div class="container">
            <div class="section-eyebrow">Preços</div>
            <h2 class="section-title">Simples. Transparente.<br>Sem surpresas.</h2>
            <p class="section-subtitle">Dois planos claros. Escolha mensal ou anual com 20% de desconto.</p>
            <div class="pricing-toggle">
                <button class="toggle-btn active" data-period="monthly">Mensal</button>
                <button class="toggle-btn" data-period="yearly">Anual <span class="discount-badge">-20%</span></button>
            </div>
            <div class="pricing-wrapper pricing-two-cols">
                <div class="pricing-card popular">
                    <div class="pricing-name">Individual</div>
                    <div class="pricing-price" data-monthly="10" data-yearly="7">
                        <span class="currency">€</span>
                        <span class="amount">10</span>
                        <span class="period">/mês</span>
                    </div>
                    <p class="pricing-yearly-note">ou <strong>€84/ano</strong> (pago uma vez, equivale a €7/mês)</p>
                    <p class="pricing-description">O seu cartão digital profissional. Cancele quando quiser.</p>
                    <ul class="pricing-features">
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Cartão digital profissional</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>QR Code personalizado</li>

                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Analytics completos</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Links ilimitados</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Design 100% personalizável</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Atualizações incluídas</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Cancele a qualquer momento</li>
                    </ul>
                    <a href="{{ Route::has('register') ? route('register') : '#' }}" class="btn btn-primary">Começar Agora</a>
                </div>
                <div class="pricing-card pricing-business">
                    <div class="pricing-name">Empresas</div>
                    <div class="pricing-price pricing-custom">
                        <span class="amount-small">€50</span>
                        <span class="amount-plus">+</span>
                        <span class="amount-small">€1</span>
                        <span class="period">/colaborador</span>
                    </div>
                    <p class="pricing-description">Setup inicial + custo por colaborador. Escala connosco.</p>
                    <ul class="pricing-features">
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Tudo do plano Individual</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Colaboradores ilimitados</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Gestão centralizada</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Branding corporativo</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Dashboard de analytics</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Suporte prioritário</li>
                        <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Acesso à API</li>
                    </ul>
                    <a href="#contacto" class="btn btn-secondary">Falar Connosco</a>
                    <p class="pricing-example">Ex: 20 colaboradores = €50 + €20 = €70</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-eyebrow">Testemunhos</div>
            <h2 class="section-title">Adorado por milhares<br>de profissionais.</h2>
            <p class="section-subtitle">Não acredite apenas em nós. Veja o que os nossos utilizadores dizem.</p>
            <div class="testimonials-grid">
                <div class="testimonial-featured">
                    <p class="testimonial-quote">"O Cardifys mudou completamente a forma como faço networking. Já não preciso de andar com centenas de cartões físicos e as pessoas ficam sempre impressionadas quando partilho o meu cartão digital."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">JS</div>
                        <div class="testimonial-info"><h4>João Silva</h4><p>CEO @ TechStart</p></div>
                    </div>
                </div>
                <div class="testimonials-stack">
                    <div class="testimonial-mini">
                        <p class="testimonial-mini-quote">"A gestão centralizada para a nossa equipa de vendas é fantástica. Controlo total sobre a marca."</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">MC</div>
                            <div class="testimonial-info"><h4>Maria Costa</h4><p>Dir. Marketing @ Innova</p></div>
                        </div>
                    </div>
                    <div class="testimonial-mini">
                        <p class="testimonial-mini-quote">"Analytics em tempo real ajudam-me a perceber que contactos são mais interessantes."</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">PS</div>
                            <div class="testimonial-info"><h4>Pedro Santos</h4><p>Consultor @ Deloitte</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-circles">
            <div class="cta-circle"></div>
            <div class="cta-circle"></div>
            <div class="cta-circle"></div>
        </div>
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Pronto para o futuro<br>do networking?</h2>
                <p class="cta-description">Junte-se a milhares de profissionais que já modernizaram a forma como criam conexões.</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        Criar Conta Grátis
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="logo">
                        <svg width="24" height="24" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="32" height="32" rx="7" fill="#070915"/>
                            <path d="M20.8 21.2C17.99 24.01 13.43 24.01 10.62 21.2C7.81 18.39 7.81 13.83 10.62 11.02C13.43 8.21 17.99 8.21 20.8 11.02" stroke="#F2F2EE" stroke-width="2" stroke-linecap="round"/>
                            <path d="M13.85 13.45L17.65 16L13.85 18.55" stroke="#B08CFF" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Cardifys
                    </div>
                    <p>A plataforma líder em cartões de visita digitais em Portugal. Conecte, partilhe e cresça a sua rede profissional.</p>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h4>Produto</h4>
                        <ul>
                            <li><a href="#features">Funcionalidades</a></li>
                            <li><a href="#pricing">Preços</a></li>
                            <li><a href="#how-it-works">Como Funciona</a></li>
                            <li><a href="#">Integrações</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>Empresa</h4>
                        <ul>
                            <li><a href="#">Sobre Nós</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Carreiras</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>Legal</h4>
                        <ul>
                            <li><a href="#">Termos</a></li>
                            <li><a href="#">Privacidade</a></li>
                            <li><a href="#">Cookies</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ date('Y') }} Cardifys. Todos os direitos reservados.</p>
                <div class="footer-social">
                    <a href="#" aria-label="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('theme');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (savedTheme) { html.setAttribute('data-theme', savedTheme); }
        else if (systemPrefersDark) { html.setAttribute('data-theme', 'dark'); }
        themeToggle.addEventListener('click', () => {
            const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });

        // Navbar scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Particles
        document.addEventListener('DOMContentLoaded', function () {
            const particlesCanvas = document.getElementById('particles-canvas');
            if (!particlesCanvas) return;
            const pCtx = particlesCanvas.getContext('2d');
            let dots = [];
            let mouse = { x: null, y: null };

            function resizeParticlesCanvas() {
                particlesCanvas.width = window.innerWidth;
                particlesCanvas.height = window.innerHeight;
            }
            resizeParticlesCanvas();
            window.addEventListener('resize', resizeParticlesCanvas);

            class Dot {
                constructor() {
                    this.x = Math.random() * particlesCanvas.width;
                    this.y = Math.random() * particlesCanvas.height;
                    this.size = Math.random() * 2 + 1;
                    this.speedY = Math.random() * 0.3 + 0.1;
                    this.opacity = Math.random() * 0.5 + 0.2;
                }
                draw() {
                    const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
                    pCtx.fillStyle = isDark
                        ? `rgba(99, 102, 241, ${this.opacity})`
                        : `rgba(99, 102, 241, ${this.opacity * 0.6})`;
                    pCtx.beginPath();
                    pCtx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    pCtx.fill();
                }
                update() {
                    this.y -= this.speedY;
                    if (this.y < -10) {
                        this.y = particlesCanvas.height + 10;
                        this.x = Math.random() * particlesCanvas.width;
                    }
                    if (mouse.x && mouse.y) {
                        let dx = mouse.x - this.x, dy = mouse.y - this.y;
                        if (Math.sqrt(dx * dx + dy * dy) < 100) {
                            this.x -= dx * 0.02;
                            this.y -= dy * 0.02;
                        }
                    }
                }
            }

            function initDots() {
                dots = [];
                const count = Math.min(50, (particlesCanvas.width * particlesCanvas.height) / 20000);
                for (let i = 0; i < count; i++) dots.push(new Dot());
            }
            initDots();

            function animateDots() {
                pCtx.clearRect(0, 0, particlesCanvas.width, particlesCanvas.height);
                dots.forEach(d => { d.draw(); d.update(); });
                requestAnimationFrame(animateDots);
            }
            animateDots();

            window.addEventListener('mousemove', e => { mouse.x = e.x; mouse.y = e.y; });
            window.addEventListener('mouseout', () => { mouse.x = null; mouse.y = null; });
            window.addEventListener('resize', initDots);
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        // Pricing Toggle
        const toggleBtns = document.querySelectorAll('.toggle-btn');
        const priceAmount = document.querySelector('.pricing-price .amount');
        const yearlyNote = document.querySelector('.pricing-yearly-note');

        toggleBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                toggleBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const period = btn.dataset.period;
                const priceEl = document.querySelector('.pricing-price[data-monthly]');
                if (period === 'yearly') {
                    priceAmount.textContent = priceEl.dataset.yearly;
                    yearlyNote.innerHTML = 'Faturado anualmente • <strong>€192/ano</strong>';
                } else {
                    priceAmount.textContent = priceEl.dataset.monthly;
                    yearlyNote.innerHTML = 'ou <strong>€192/ano</strong> (poupa €48)';
                }
            });
        });
    </script>
</body>
</html>