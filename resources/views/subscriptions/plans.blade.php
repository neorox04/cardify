<!DOCTYPE html>
<html lang="pt" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preços — Cardifys</title>
    <meta name="description" content="Planos simples e transparentes para profissionais e empresas. Começa grátis, cresce connosco.">
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Sora:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ═══════════════════════════════════════
           DESIGN TOKENS — idênticos à welcome
        ═══════════════════════════════════════ */
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
            --accent-subtle: rgba(99,102,241,0.10);
            --accent-subtle-2: rgba(99,102,241,0.06);
            --border: rgba(255,255,255,0.06);
            --border-hover: rgba(255,255,255,0.10);
            --gradient-1: linear-gradient(135deg,#6366f1 0%,#8b5cf6 50%,#06b6d4 100%);
            --green: #10b981;
            --green-subtle: rgba(16,185,129,0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-xl: 32px;
            --transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        [data-theme="light"] {
            --bg-primary: #fafafa;
            --bg-secondary: #f0f0f3;
            --bg-tertiary: #e8e8ec;
            --bg-elevated: #ffffff;
            --text-primary: #1a1a1f;
            --text-secondary: #5c5c66;
            --text-tertiary: #8c8c96;
            --border: rgba(0,0,0,0.08);
            --border-hover: rgba(0,0,0,0.15);
            --accent-subtle: rgba(99,102,241,0.08);
            --accent-subtle-2: rgba(99,102,241,0.04);
        }
        [data-theme="light"] body { background: linear-gradient(180deg,#fafafa 0%,#f0f0f3 100%); }
        [data-theme="light"] nav.scrolled { background: rgba(255,255,255,0.85); }
        [data-theme="light"] .cta-circle { border-color: rgba(0,0,0,0.05); }

        *{margin:0;padding:0;box-sizing:border-box;}
        html{scroll-behavior:smooth;}
        body{
            font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;
            background:var(--bg-primary);color:var(--text-primary);
            line-height:1.6;overflow-x:hidden;-webkit-font-smoothing:antialiased;
        }
        .container{max-width:1200px;margin:0 auto;padding:0 24px;}

        /* ── NAV ── */
        nav{position:fixed;top:0;left:0;right:0;z-index:1000;padding:16px 0;background:transparent;transition:var(--transition);}
        nav.scrolled{background:rgba(10,10,11,0.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border);}
        .nav-inner{display:flex;align-items:center;justify-content:space-between;max-width:1200px;margin:0 auto;padding:0 24px;}
        .logo{display:flex;align-items:center;gap:8px;font-size:22px;font-weight:800;background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;letter-spacing:-.5px;text-decoration:none;}
        .nav-links{display:flex;align-items:center;gap:4px;}
        .nav-links a{color:var(--text-secondary);text-decoration:none;font-size:14px;font-weight:500;padding:8px 14px;border-radius:var(--radius-sm);transition:var(--transition);}
        .nav-links a:hover{color:var(--text-primary);background:var(--accent-subtle);}
        .nav-links a.active{color:var(--accent);}
        .nav-actions{display:flex;align-items:center;gap:10px;}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;font-size:14px;font-weight:600;padding:10px 20px;border-radius:var(--radius-sm);text-decoration:none;border:none;cursor:pointer;transition:var(--transition);font-family:inherit;}
        .btn-ghost{color:var(--text-secondary);background:transparent;}
        .btn-ghost:hover{color:var(--text-primary);background:var(--accent-subtle);}
        .btn-primary{color:white;background:var(--accent);}
        .btn-primary:hover{background:var(--accent-hover);transform:translateY(-1px);}
        .btn-secondary{color:var(--text-primary);background:var(--bg-tertiary);border:1px solid var(--border);}
        .btn-secondary:hover{background:var(--bg-elevated);border-color:var(--border-hover);}
        .btn-lg{padding:14px 28px;font-size:15px;}
        .btn-xl{padding:16px 36px;font-size:16px;border-radius:var(--radius-md);}
        .theme-toggle{width:38px;height:38px;border-radius:50%;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-secondary);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:var(--transition);}
        .theme-toggle:hover{border-color:var(--border-hover);color:var(--text-primary);}
        .theme-toggle svg{width:17px;height:17px;}
        .theme-toggle .sun{display:none;}.theme-toggle .moon{display:block;}
        [data-theme="light"] .theme-toggle .sun{display:block;}[data-theme="light"] .theme-toggle .moon{display:none;}

        /* ── HERO PRICING ── */
        .pricing-hero{
            padding:160px 0 80px;
            position:relative;overflow:hidden;
            text-align:center;
        }
        .pricing-hero::before{
            content:'';position:absolute;
            top:-200px;left:50%;transform:translateX(-50%);
            width:900px;height:600px;
            background:radial-gradient(ellipse,rgba(99,102,241,0.12) 0%,transparent 65%);
            pointer-events:none;
        }
        .pricing-hero-inner{position:relative;z-index:2;}

        .hero-eyebrow{
            display:inline-flex;align-items:center;gap:8px;
            padding:6px 16px;border-radius:100px;
            background:var(--accent-subtle);border:1px solid rgba(99,102,241,0.2);
            color:var(--accent);font-size:12px;font-weight:600;
            letter-spacing:.08em;text-transform:uppercase;
            margin-bottom:28px;
            animation:fadeUp .7s cubic-bezier(.16,1,.3,1) forwards;opacity:0;
        }
        .hero-eyebrow::before{content:'';width:5px;height:5px;background:var(--accent);border-radius:50%;animation:pulse 2s infinite;}
        @keyframes pulse{0%,100%{opacity:1;}50%{opacity:.3;}}
        @keyframes fadeUp{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}
        @keyframes fadeUpDelay{from{opacity:0;transform:translateY(24px);}to{opacity:1;transform:translateY(0);}}

        .pricing-hero h1{
            font-size:clamp(44px,6vw,76px);font-weight:800;
            line-height:1.05;letter-spacing:-2.5px;margin-bottom:20px;
            animation:fadeUp .8s cubic-bezier(.16,1,.3,1) .1s forwards;opacity:0;
        }
        .pricing-hero h1 .grad{
            background:var(--gradient-1);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
        }
        .pricing-hero-sub{
            font-size:19px;color:var(--text-secondary);max-width:540px;
            margin:0 auto 48px;line-height:1.65;
            animation:fadeUp .8s cubic-bezier(.16,1,.3,1) .2s forwards;opacity:0;
        }

        /* Toggle */
        .billing-toggle-wrap{
            display:flex;justify-content:center;margin-bottom:64px;
            animation:fadeUp .8s cubic-bezier(.16,1,.3,1) .3s forwards;opacity:0;
        }
        .billing-toggle{
            display:flex;gap:4px;background:var(--bg-secondary);
            padding:5px;border-radius:100px;
            border:1px solid var(--border);
        }
        .toggle-btn{
            padding:10px 22px;border:none;background:transparent;
            color:var(--text-secondary);font-size:14px;font-weight:600;
            border-radius:100px;cursor:pointer;transition:var(--transition);
            display:flex;align-items:center;gap:8px;font-family:inherit;
        }
        .toggle-btn:hover{color:var(--text-primary);}
        .toggle-btn.active{background:var(--accent);color:white;}
        .save-badge{
            background:rgba(16,185,129,.2);color:#10b981;
            padding:2px 8px;border-radius:100px;font-size:11px;font-weight:700;
        }
        .toggle-btn.active .save-badge{background:rgba(255,255,255,.2);color:white;}

        /* ── PRICING CARDS ── */
        .pricing-grid{
            display:grid;grid-template-columns:1fr 1fr;
            gap:20px;margin-bottom:80px;
            animation:fadeUp .8s cubic-bezier(.16,1,.3,1) .4s forwards;opacity:0;
        }

        .p-card{
            background:var(--bg-secondary);border:1px solid var(--border);
            border-radius:var(--radius-xl);padding:44px;
            position:relative;transition:var(--transition);
            display:flex;flex-direction:column;
        }
        .p-card:hover{border-color:var(--border-hover);transform:translateY(-4px);}
        .p-card.featured{
            background:var(--bg-tertiary);
            border-color:var(--accent);
            border-width:1.5px;
        }
        .p-card.featured::before{
            content:'Mais Popular';
            position:absolute;top:-14px;left:50%;transform:translateX(-50%);
            background:var(--accent);color:white;
            font-size:12px;font-weight:700;padding:4px 18px;
            border-radius:100px;white-space:nowrap;
        }
        .p-card.featured::after{
            content:'';position:absolute;inset:0;border-radius:var(--radius-xl);
            background:radial-gradient(ellipse at 50% 0%,rgba(99,102,241,.1) 0%,transparent 60%);
            pointer-events:none;
        }

        .card-label{
            font-size:12px;font-weight:700;text-transform:uppercase;
            letter-spacing:.1em;color:var(--text-tertiary);margin-bottom:20px;
        }
        .p-card.featured .card-label{color:var(--accent);}

        .price-row{display:flex;align-items:baseline;gap:4px;margin-bottom:6px;}
        .price-currency{font-size:26px;font-weight:600;color:var(--text-secondary);}
        .price-amount{font-size:68px;font-weight:800;letter-spacing:-3px;line-height:1;}
        .price-period{font-size:15px;color:var(--text-tertiary);margin-left:2px;}
        .price-custom-row{display:flex;align-items:baseline;gap:8px;flex-wrap:wrap;margin-bottom:6px;}
        .price-big{font-size:48px;font-weight:800;letter-spacing:-2px;}
        .price-plus{font-size:28px;color:var(--text-tertiary);}

        .yearly-note{font-size:13px;color:var(--green);margin-bottom:4px;font-weight:500;}
        .card-desc{font-size:14px;color:var(--text-secondary);margin:16px 0 28px;padding-bottom:28px;border-bottom:1px solid var(--border);line-height:1.6;}

        .feat-list{list-style:none;margin-bottom:36px;flex:1;}
        .feat-list li{
            display:flex;align-items:flex-start;gap:12px;
            font-size:14px;color:var(--text-secondary);padding:9px 0;
        }
        .feat-list li .check{
            width:20px;height:20px;border-radius:50%;
            background:var(--accent-subtle);border:1px solid rgba(99,102,241,.25);
            display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;
        }
        .feat-list li .check svg{width:11px;height:11px;color:var(--accent);}
        .feat-list li strong{color:var(--text-primary);font-weight:600;}

        .card-cta{width:100%;padding:14px;font-size:15px;font-weight:700;border-radius:var(--radius-md);cursor:pointer;transition:var(--transition);border:none;font-family:inherit;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:8px;}
        .cta-primary{background:var(--accent);color:white;}
        .cta-primary:hover{background:var(--accent-hover);transform:translateY(-1px);box-shadow:0 8px 24px rgba(99,102,241,.35);}
        .cta-secondary{background:transparent;color:var(--text-primary);border:1px solid var(--border);}
        .cta-secondary:hover{background:var(--bg-elevated);border-color:var(--border-hover);}

        .pricing-example-note{
            margin-top:16px;text-align:center;font-size:13px;
            color:var(--text-tertiary);background:var(--accent-subtle);
            padding:10px 16px;border-radius:var(--radius-sm);
        }

        /* ── COMPARISON TABLE ── */
        .comparison-section{padding:80px 0 100px;}
        .section-label{
            display:inline-flex;align-items:center;gap:12px;
            font-size:12px;font-weight:700;text-transform:uppercase;
            letter-spacing:.2em;color:var(--accent);margin-bottom:20px;
        }
        .section-label::before,.section-label::after{content:'';width:20px;height:1px;background:var(--accent);}
        .section-title{font-size:clamp(32px,4vw,48px);font-weight:800;letter-spacing:-1.5px;line-height:1.1;margin-bottom:16px;}
        .section-sub{font-size:17px;color:var(--text-secondary);max-width:560px;margin-bottom:56px;}

        .comp-table{width:100%;border-collapse:separate;border-spacing:0;}
        .comp-table thead tr th{
            padding:16px 24px;font-size:13px;font-weight:700;
            text-transform:uppercase;letter-spacing:.06em;
            background:var(--bg-secondary);
        }
        .comp-table thead tr th:first-child{
            text-align:left;color:var(--text-tertiary);
            border-radius:var(--radius-md) 0 0 0;
        }
        .comp-table thead tr th:not(:first-child){
            text-align:center;color:var(--text-primary);
            border-left:1px solid var(--border);
        }
        .comp-table thead tr th:last-child{
            background:rgba(99,102,241,.12);color:var(--accent);
            border-radius:0 var(--radius-md) 0 0;
        }
        .comp-table tbody tr td{
            padding:15px 24px;font-size:14px;
            border-top:1px solid var(--border);
        }
        .comp-table tbody tr td:first-child{color:var(--text-secondary);}
        .comp-table tbody tr td:not(:first-child){text-align:center;border-left:1px solid var(--border);}
        .comp-table tbody tr td:last-child{background:var(--accent-subtle-2);}
        .comp-table tbody tr:hover td{background:var(--bg-secondary);}
        .comp-table tbody tr:hover td:last-child{background:rgba(99,102,241,.08);}
        .comp-table tfoot tr td{
            padding:20px 24px;border-top:1px solid var(--border);
        }
        .comp-table tfoot tr td:first-child{border-radius:0 0 0 var(--radius-md);}
        .comp-table tfoot tr td:last-child{
            background:rgba(99,102,241,.08);border-radius:0 0 var(--radius-md) 0;
        }

        .check-yes{color:var(--accent);}
        .check-no{color:var(--text-tertiary);opacity:.4;}
        .check-partial{color:var(--text-secondary);font-size:12px;}
        .group-header td{
            background:var(--bg-tertiary)!important;
            font-size:11px!important;font-weight:700!important;
            text-transform:uppercase;letter-spacing:.12em;
            color:var(--text-tertiary)!important;padding:10px 24px!important;
        }

        /* ── FAQ ── */
        .faq-section{padding:40px 0 100px;background:var(--bg-secondary);}
        .faq-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:56px;}
        .faq-item{
            background:var(--bg-primary);border:1px solid var(--border);
            border-radius:var(--radius-lg);padding:28px;
            transition:var(--transition);cursor:pointer;
        }
        .faq-item:hover{border-color:var(--border-hover);}
        .faq-item.open{border-color:rgba(99,102,241,.3);}
        .faq-q{
            display:flex;justify-content:space-between;align-items:flex-start;gap:16px;
            font-size:16px;font-weight:600;color:var(--text-primary);margin-bottom:0;
        }
        .faq-q .icon{
            width:24px;height:24px;border-radius:50%;background:var(--bg-secondary);
            border:1px solid var(--border);display:flex;align-items:center;justify-content:center;
            flex-shrink:0;transition:var(--transition);
        }
        .faq-item.open .faq-q .icon{background:var(--accent-subtle);border-color:rgba(99,102,241,.3);transform:rotate(45deg);}
        .faq-q .icon svg{width:12px;height:12px;color:var(--text-secondary);}
        .faq-item.open .faq-q .icon svg{color:var(--accent);}
        .faq-a{
            font-size:14px;color:var(--text-secondary);line-height:1.7;
            margin-top:16px;display:none;
        }
        .faq-item.open .faq-a{display:block;}

        /* ── ENTERPRISE ── */
        .enterprise-section{padding:40px 0 100px;}
        .enterprise-card{
            background:var(--bg-secondary);border:1px solid var(--border);
            border-radius:var(--radius-xl);padding:64px;
            display:grid;grid-template-columns:1fr auto;
            gap:48px;align-items:center;position:relative;overflow:hidden;
        }
        .enterprise-card::before{
            content:'';position:absolute;right:-100px;top:50%;transform:translateY(-50%);
            width:400px;height:400px;
            background:radial-gradient(circle,rgba(99,102,241,.1) 0%,transparent 65%);
            pointer-events:none;
        }
        .ent-tag{
            display:inline-flex;align-items:center;gap:8px;
            font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
            color:var(--accent);margin-bottom:16px;
        }
        .ent-title{font-size:36px;font-weight:800;letter-spacing:-1px;margin-bottom:16px;line-height:1.15;}
        .ent-desc{font-size:16px;color:var(--text-secondary);max-width:520px;line-height:1.65;margin-bottom:32px;}
        .ent-perks{display:flex;flex-direction:column;gap:10px;}
        .ent-perk{display:flex;align-items:center;gap:10px;font-size:14px;color:var(--text-secondary);}
        .ent-perk svg{width:16px;height:16px;color:var(--accent);flex-shrink:0;}
        .ent-actions{display:flex;flex-direction:column;gap:12px;align-items:center;flex-shrink:0;min-width:220px;}
        .ent-price{text-align:center;margin-bottom:8px;}
        .ent-price-val{font-size:42px;font-weight:800;letter-spacing:-2px;color:var(--text-primary);}
        .ent-price-label{font-size:13px;color:var(--text-tertiary);}

        /* ── TRUST BAR ── */
        .trust-section{padding:60px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border);}
        .trust-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:var(--border);}
        .trust-item{
            background:var(--bg-primary);
            padding:32px 24px;text-align:center;
        }
        .trust-val{
            font-size:36px;font-weight:800;letter-spacing:-1.5px;
            background:var(--gradient-1);-webkit-background-clip:text;
            -webkit-text-fill-color:transparent;background-clip:text;
            margin-bottom:6px;
        }
        .trust-label{font-size:13px;color:var(--text-tertiary);}

        /* ── CTA ── */
        .bottom-cta{padding:120px 0;position:relative;overflow:hidden;text-align:center;}
        .bottom-cta::before{
            content:'';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
            width:700px;height:700px;
            background:radial-gradient(circle,rgba(99,102,241,.08) 0%,transparent 60%);
            pointer-events:none;
        }
        .cta-rings{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);z-index:1;}
        .cta-ring{
            position:absolute;border:1px solid var(--border);border-radius:50%;
            top:50%;left:50%;transform:translate(-50%,-50%);
            animation:ringPulse 6s ease-in-out infinite;
        }
        .cta-ring:nth-child(1){width:280px;height:280px;}
        .cta-ring:nth-child(2){width:480px;height:480px;animation-delay:.6s;}
        .cta-ring:nth-child(3){width:680px;height:680px;animation-delay:1.2s;}
        @keyframes ringPulse{
            0%,100%{transform:translate(-50%,-50%) scale(1);opacity:.3;}
            50%{transform:translate(-50%,-50%) scale(1.04);opacity:.6;}
        }
        .bottom-cta-inner{position:relative;z-index:2;}
        .bottom-cta h2{font-size:clamp(36px,5vw,58px);font-weight:800;letter-spacing:-2px;margin-bottom:20px;line-height:1.1;}
        .bottom-cta p{font-size:18px;color:var(--text-secondary);max-width:480px;margin:0 auto 40px;}
        .cta-actions{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;}

        /* ── FOOTER ── */
        footer{padding:60px 0 36px;border-top:1px solid var(--border);}
        .footer-inner{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:48px;}
        .footer-brand{max-width:260px;}
        .footer-brand p{font-size:13px;color:var(--text-secondary);line-height:1.6;margin-top:12px;}
        .footer-links{display:flex;gap:64px;}
        .footer-col h4{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--text-tertiary);margin-bottom:16px;}
        .footer-col ul{list-style:none;}
        .footer-col li{margin-bottom:10px;}
        .footer-col a{font-size:13px;color:var(--text-secondary);text-decoration:none;transition:var(--transition);}
        .footer-col a:hover{color:var(--text-primary);}
        .footer-bottom{display:flex;justify-content:space-between;align-items:center;padding-top:28px;border-top:1px solid var(--border);}
        .footer-bottom p{font-size:12px;color:var(--text-tertiary);}
        .footer-social{display:flex;gap:10px;}
        .footer-social a{width:32px;height:32px;border-radius:50%;background:var(--bg-secondary);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--text-secondary);transition:var(--transition);}
        .footer-social a:hover{background:var(--accent);border-color:var(--accent);color:white;}
        .footer-social svg{width:14px;height:14px;}

        /* ── RESPONSIVE ── */
        @media(max-width:900px){
            .pricing-grid{grid-template-columns:1fr;}
            .faq-grid{grid-template-columns:1fr;}
            .trust-grid{grid-template-columns:repeat(2,1fr);}
            .enterprise-card{grid-template-columns:1fr;gap:32px;}
            .ent-actions{min-width:auto;flex-direction:row;flex-wrap:wrap;}
            .footer-inner{flex-direction:column;gap:40px;}
            .footer-links{gap:40px;flex-wrap:wrap;}
            .nav-links{display:none;}
        }
        @media(max-width:640px){
            .comp-table{font-size:12px;}
            .comp-table thead tr th,.comp-table tbody tr td{padding:12px 14px;}
            .bottom-cta{padding:80px 0;}
        }
    </style>
</head>
<body>

<!-- ── NAV ── -->
<nav id="navbar">
    <div class="nav-inner">
        <a href="/" class="logo">
            <svg width="26" height="26" viewBox="0 0 32 32" fill="none">
                <defs><linearGradient id="lg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#06b6d4"/><stop offset="100%" stop-color="#6366f1"/></linearGradient></defs>
                <path d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14c2.5 0 4.5-.5 6.5-1.5" stroke="url(#lg)" stroke-width="3" stroke-linecap="round" fill="none"/>
                <path d="M22 8l4 4-4 4" stroke="url(#lg)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
            Cardifys
        </a>
        <div class="nav-links">
            <a href="/">Início</a>
            <a href="/#features">Funcionalidades</a>
            <a href="/#how-it-works">Como Funciona</a>
            <a href="/pricing" class="active">Preços</a>
        </div>
        <div class="nav-actions">
            <button class="theme-toggle" id="theme-toggle" aria-label="Mudar tema">
                <svg class="sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <svg class="moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </button>
            @auth
                <span style="color:#a5b4fc;font-size:1.05rem;font-weight:600;">Bem-vindo {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;margin-left:10px;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            @else
                <a href="/login" class="btn btn-ghost">Entrar</a>
                <a href="/register" class="btn btn-primary">Começar Grátis</a>
            @endauth
        </div>
    </div>
</nav>

<!-- ── HERO ── -->
<section class="pricing-hero">
    <div class="container">
        <div class="pricing-hero-inner">
            <div class="hero-eyebrow">Preços</div>
            <h1>Simples. Transparente.<br><span class="grad">Sem surpresas.</span></h1>
            <p class="pricing-hero-sub">Começa grátis com o plano Individual. Cresce para Empresas quando precisares. Cancela quando quiseres — sem contratos, sem letras pequenas.</p>

            <div class="billing-toggle-wrap">
                <div class="billing-toggle">
                    <button class="toggle-btn active" data-period="monthly">Mensal</button>
                    <button class="toggle-btn" data-period="yearly">Anual <span class="save-badge">Poupa 20%</span></button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── PRICING CARDS ── -->
<section style="padding:0 0 20px;">
    <div class="container">
        <div class="pricing-grid">

            <!-- Individual -->
            <div class="p-card featured">
                <div class="card-label">Individual</div>
                <div class="price-row" id="ind-price-row">
                    <span class="price-currency">€</span>
                    <span class="price-amount" id="ind-amount">10</span>
                    <span class="price-period">/mês</span>
                </div>
                <p class="yearly-note" id="ind-yearly-note" style="display:none;">Faturado anualmente · <strong>€84/ano</strong> — poupa €36</p>
                <p class="card-desc">O teu cartão digital profissional. Tudo o que precisas para um networking moderno e eficaz.</p>
                <ul class="feat-list">
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Cartão digital profissional</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>QR Code personalizado</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Partilha via NFC</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Analytics completos em tempo real</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Links ilimitados</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Design <strong>100% personalizável</strong></span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Exportação vCard</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Atualizações incluídas</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Cancela a qualquer momento</span></li>
                </ul>
                @auth
                    @if(Auth::user()->subscribed('default'))
                        <a href="{{ route('dashboard') }}" class="card-cta cta-primary">
                            Dashboard
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    @else
                        <form method="POST" action="{{ route('subscriptions.checkout') }}" style="width:100%;margin:0;padding:0;">
                            @csrf
                            <button type="submit" name="price" value="price_1TFgXeCcmLy5PiLsbrLtDCfP" class="card-cta cta-primary">
                                Começar Agora
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="card-cta cta-primary">
                        Começar Agora
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                @endauth
            </div>

            <!-- Empresas -->
            <div class="p-card">
                <div class="card-label">Empresas</div>
                <div class="price-custom-row">
                    <span class="price-big">€50</span>
                    <span class="price-plus">+</span>
                    <span class="price-big">€1</span>
                    <span class="price-period">/colaborador/mês</span>
                </div>
                <p class="yearly-note">Setup único · escala com a tua equipa</p>
                <p class="card-desc">Gestão centralizada para equipas. Branding corporativo consistente em toda a empresa.</p>
                <ul class="feat-list">
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Tudo do plano Individual</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Colaboradores <strong>ilimitados</strong></span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Painel de administração central</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Branding e cores corporativas</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Dashboard de analytics por equipa</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Onboarding de equipa incluído</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Suporte prioritário</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Acesso à API</span></li>
                    <li><span class="check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span><span>Relatórios exportáveis (CSV, PDF)</span></li>
                </ul>
                <a href="/register" class="card-cta cta-secondary">Falar Connosco</a>
                <p class="pricing-example-note">Ex: equipa de 20 pessoas = €50 + €20 = <strong>€70/mês</strong></p>
            </div>

        </div>
    </div>
</section>

<!-- ── TRUST BAR ── -->
<section class="trust-section">
    <div class="container">
        <div class="trust-grid">
            <div class="trust-item">
                <div class="trust-val">2 min</div>
                <div class="trust-label">Do registo ao primeiro cartão</div>
            </div>
            <div class="trust-item">
                <div class="trust-val">0€</div>
                <div class="trust-label">Para começar — sem cartão de crédito</div>
            </div>
            <div class="trust-item">
                <div class="trust-val">100%</div>
                <div class="trust-label">Cancelamento sem penalizações</div>
            </div>
            <div class="trust-item">
                <div class="trust-val">PT</div>
                <div class="trust-label">Suporte em português · feito em Portugal</div>
            </div>
        </div>
    </div>
</section>

<!-- ── COMPARISON TABLE ── -->
<section class="comparison-section">
    <div class="container">
        <div class="section-label">Comparação</div>
        <h2 class="section-title">Tudo ao mesmo tempo,<br>lado a lado.</h2>
        <p class="section-sub">Compara os planos em detalhe e escolhe o que melhor se adapta ao teu perfil.</p>

        <table class="comp-table">
            <thead>
                <tr>
                    <th style="width:40%">Funcionalidade</th>
                    <th style="width:30%">Individual</th>
                    <th style="width:30%">Empresas</th>
                </tr>
            </thead>
            <tbody>
                <tr class="group-header"><td colspan="3">Cartão Digital</td></tr>
                <tr><td>Cartão de visita digital</td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>QR Code personalizado</td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Partilha via NFC</td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Exportação vCard</td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Links ilimitados</td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>

                <tr class="group-header"><td colspan="3">Personalização</td></tr>
                <tr><td>Temas e cores personalizáveis</td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Fontes personalizadas</td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Branding corporativo unificado</td><td><span class="check-no">—</span></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Logo da empresa em todos os cartões</td><td><span class="check-no">—</span></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>

                <tr class="group-header"><td colspan="3">Analytics</td></tr>
                <tr><td>Visualizações do cartão</td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Scans de QR Code</td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Dashboard por equipa</td><td><span class="check-no">—</span></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Exportação de relatórios</td><td><span class="check-no">—</span></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>

                <tr class="group-header"><td colspan="3">Equipa & Gestão</td></tr>
                <tr><td>Utilizadores</td><td><span class="check-partial">1 utilizador</span></td><td><span class="check-partial">Ilimitados</span></td></tr>
                <tr><td>Painel de administração</td><td><span class="check-no">—</span></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Acesso à API</td><td><span class="check-no">—</span></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
                <tr><td>Suporte prioritário</td><td><span class="check-no">—</span></td><td><svg class="check-yes" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></td></tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td style="text-align:center;"><a href="/register" class="card-cta cta-primary" style="max-width:180px;margin:0 auto;padding:12px 20px;font-size:14px;">Começar grátis</a></td>
                    <td style="text-align:center;"><a href="/register" class="card-cta cta-secondary" style="max-width:180px;margin:0 auto;padding:12px 20px;font-size:14px;">Falar Connosco</a></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

<!-- ── FAQ ── -->
<section class="faq-section">
    <div class="container">
        <div class="section-label">FAQ</div>
        <h2 class="section-title">Perguntas frequentes.</h2>
        <p class="section-sub">Tudo o que precisas de saber antes de começar.</p>

        <div class="faq-grid">
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>Preciso de cartão de crédito para começar?</span>
                    <span class="icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></span>
                </div>
                <div class="faq-a">Não. O registo é completamente gratuito e não pedimos nenhum dado de pagamento. Só precisas de um email para criar a tua conta e o teu primeiro cartão digital.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>Posso cancelar a qualquer momento?</span>
                    <span class="icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></span>
                </div>
                <div class="faq-a">Sim, sempre. Não há contratos de permanência, nem penalizações. Podes cancelar a tua subscrição a qualquer momento diretamente nas definições da conta. O teu cartão continua ativo até ao fim do período já pago.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>A pessoa que recebe o cartão precisa de instalar alguma app?</span>
                    <span class="icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></span>
                </div>
                <div class="faq-a">Não. O cartão abre diretamente no browser do telemóvel — basta fazer scan do QR Code ou aproximar via NFC. Funciona em iOS e Android sem qualquer instalação necessária.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>O que acontece aos meus dados se cancelar?</span>
                    <span class="icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></span>
                </div>
                <div class="faq-a">Os teus dados permanecem na plataforma por 30 dias após o cancelamento, permitindo-te reativar se mudares de ideias. Após esse período, todos os dados são removidos permanentemente.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>Posso mudar de plano Individual para Empresas?</span>
                    <span class="icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></span>
                </div>
                <div class="faq-a">Sim, a qualquer momento. Podes fazer upgrade diretamente nas definições da conta. O valor já pago no plano Individual é descontado proporcionalmente na primeira fatura do plano Empresas.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>O plano Empresas tem limite de colaboradores?</span>
                    <span class="icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></span>
                </div>
                <div class="faq-a">Não. O plano Empresas não tem limite de colaboradores. Pagas €50 de setup inicial e depois €1 por cada colaborador ativo por mês. Podes adicionar ou remover colaboradores a qualquer momento.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>O Cardifys é compatível com todos os telemóveis?</span>
                    <span class="icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></span>
                </div>
                <div class="faq-a">Sim. O cartão digital funciona em qualquer smartphone moderno através do browser. O NFC funciona em dispositivos iOS (iPhone 7 ou posterior) e Android com NFC ativo. O QR Code funciona em absolutamente qualquer câmara.</div>
            </div>
            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-q">
                    <span>Emitem fatura com IVA português?</span>
                    <span class="icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg></span>
                </div>
                <div class="faq-a">Sim. Todos os pagamentos incluem fatura legal com IVA português a 23%. A fatura é emitida automaticamente após cada pagamento e enviada para o email da conta.</div>
            </div>
        </div>
    </div>
</section>

<!-- ── ENTERPRISE CALLOUT ── -->
<section class="enterprise-section">
    <div class="container">
        <div class="enterprise-card">
            <div>
                <div class="ent-tag">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Enterprise & Grandes Equipas
                </div>
                <h3 class="ent-title">Precisas de algo<br>à medida?</h3>
                <p class="ent-desc">Para empresas com mais de 100 colaboradores, integrações personalizadas, domínio próprio, ou requisitos específicos de segurança e compliance. Fala connosco e desenhamos uma solução à medida.</p>
                <div class="ent-perks">
                    <div class="ent-perk"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Domínio personalizado (cartao.empresa.com)</div>
                    <div class="ent-perk"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>SSO e integração com Active Directory</div>
                    <div class="ent-perk"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>SLA garantido e suporte dedicado</div>
                    <div class="ent-perk"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Onboarding presencial ou remoto</div>
                    <div class="ent-perk"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Preço negociado por volume</div>
                </div>
            </div>
            <div class="ent-actions">
                <div class="ent-price">
                    <div class="ent-price-val">Custom</div>
                    <div class="ent-price-label">Preço negociado</div>
                </div>
                <a href="mailto:hello@cardifys.com" class="card-cta cta-primary" style="width:100%;">Falar Connosco</a>
                <a href="/register" class="card-cta cta-secondary" style="width:100%;">Ver Demo</a>
            </div>
        </div>
    </div>
</section>

<!-- ── BOTTOM CTA ── -->
<section class="bottom-cta">
    <div class="cta-rings">
        <div class="cta-ring"></div>
        <div class="cta-ring"></div>
        <div class="cta-ring"></div>
    </div>
    <div class="container">
        <div class="bottom-cta-inner">
            <h2>Começa hoje.<br><span style="background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">É grátis para experimentar.</span></h2>
            <p>Sem cartão de crédito. Sem contratos. O teu cartão digital pronto em menos de 2 minutos.</p>
            <div class="cta-actions">
                <a href="/register" class="btn btn-primary btn-xl">
                    Criar Cartão Grátis
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
                <a href="/" class="btn btn-secondary btn-xl">Ver Funcionalidades</a>
            </div>
        </div>
    </div>
</section>

<!-- ── FOOTER ── -->
<footer>
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand">
                <a href="/" class="logo" style="font-size:20px;">
                    <svg width="22" height="22" viewBox="0 0 32 32" fill="none">
                        <defs><linearGradient id="lgf" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#06b6d4"/><stop offset="100%" stop-color="#6366f1"/></linearGradient></defs>
                        <path d="M16 2C8.268 2 2 8.268 2 16s6.268 14 14 14c2.5 0 4.5-.5 6.5-1.5" stroke="url(#lgf)" stroke-width="3" stroke-linecap="round" fill="none"/>
                        <path d="M22 8l4 4-4 4" stroke="url(#lgf)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                    Cardifys
                </a>
                <p>A plataforma portuguesa de cartões de visita digitais. Feito com cuidado em Portugal.</p>
            </div>
            <div class="footer-links">
                <div class="footer-col">
                    <h4>Produto</h4>
                    <ul>
                        <li><a href="/#features">Funcionalidades</a></li>
                        <li><a href="/pricing">Preços</a></li>
                        <li><a href="/#how-it-works">Como Funciona</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Empresa</h4>
                    <ul>
                        <li><a href="#">Sobre Nós</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="/termos">Termos</a></li>
                        <li><a href="/privacidade">Privacidade</a></li>
                        <li><a href="#">Cookies</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Cardifys. Todos os direitos reservados.</p>
            <div class="footer-social">
                <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Theme
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    if(saved){html.setAttribute('data-theme',saved);}else if(prefersDark){html.setAttribute('data-theme','dark');}
    themeToggle.addEventListener('click',()=>{
        const t=html.getAttribute('data-theme')==='dark'?'light':'dark';
        html.setAttribute('data-theme',t);localStorage.setItem('theme',t);
    });

    // Navbar scroll
    const navbar=document.getElementById('navbar');
    window.addEventListener('scroll',()=>navbar.classList.toggle('scrolled',window.scrollY>50));

    // Billing toggle
    const toggleBtns=document.querySelectorAll('.toggle-btn');
    toggleBtns.forEach(btn=>{
        btn.addEventListener('click',()=>{
            toggleBtns.forEach(b=>b.classList.remove('active'));
            btn.classList.add('active');
            const yearly=btn.dataset.period==='yearly';
            // Individual price
            document.getElementById('ind-amount').textContent=yearly?'7':'10';
            const note=document.getElementById('ind-yearly-note');
            note.style.display=yearly?'block':'none';
        });
    });

    // FAQ
    function toggleFaq(el){
        const wasOpen=el.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i=>i.classList.remove('open'));
        if(!wasOpen)el.classList.add('open');
    }
</script>

</body>
</html>