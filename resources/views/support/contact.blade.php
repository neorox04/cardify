<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte · Cardifys</title>
    <link rel="icon" type="image/svg+xml" href="/icon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: oklch(0.15 0.012 290); --bg-2: oklch(0.19 0.015 290); --bg-3: oklch(0.23 0.018 290);
            --ink: oklch(0.97 0.010 290); --ink-dim: oklch(0.72 0.015 290); --ink-mute: oklch(0.52 0.012 290);
            --line-soft: oklch(0.28 0.018 290 / 0.35); --purple: oklch(0.72 0.19 300); --green: oklch(0.78 0.15 162); --danger: oklch(0.68 0.19 22);
        }
        html, body { min-height: 100vh; background: var(--bg); color: var(--ink); font-family: 'Geist', ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
        body::before { content: ""; position: fixed; inset: 0; pointer-events: none; background: radial-gradient(ellipse 60% 40% at 50% 0%, oklch(0.72 0.19 300 / 0.09), transparent 60%); }
        .brand { position: fixed; top: 24px; left: 28px; display: flex; align-items: center; gap: 8px; text-decoration: none; color: var(--ink); font-size: 15px; font-weight: 600; }
        .brand img { width: 26px; height: 26px; border-radius: 7px; }
        .wrap { position: relative; z-index: 1; max-width: 480px; margin: 0 auto; padding: 90px 22px 40px; }
        .card { background: var(--bg-2); border: 1px solid var(--line-soft); border-radius: 22px; padding: 34px 30px; box-shadow: 0 24px 60px oklch(0 0 0 / 0.4); }
        h1 { font-size: 24px; font-weight: 600; letter-spacing: -0.02em; margin-bottom: 6px; }
        .sub { font-size: 14px; color: var(--ink-dim); margin-bottom: 24px; line-height: 1.5; }
        label { display: block; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--ink-mute); margin: 0 0 6px; }
        .field { margin-bottom: 14px; }
        input, textarea { width: 100%; padding: 12px 14px; background: var(--bg-3); border: 1.5px solid var(--line-soft); border-radius: 10px; color: var(--ink); font-family: inherit; font-size: 14px; outline: none; transition: border-color .15s; }
        input:focus, textarea:focus { border-color: oklch(0.72 0.19 300 / 0.6); }
        textarea { min-height: 130px; resize: vertical; }
        .err { color: var(--danger); font-size: 12px; margin-top: 5px; }
        .btn { width: 100%; height: 50px; margin-top: 6px; background: linear-gradient(135deg, oklch(0.75 0.19 300), oklch(0.6 0.19 300)); color: #fff; border: none; border-radius: 12px; font-size: 15px; font-weight: 600; cursor: pointer; box-shadow: 0 8px 24px oklch(0.72 0.19 300 / 0.35); }
        .btn:hover { transform: translateY(-1px); }
        .ok { text-align: center; padding: 20px 0; }
        .ok-ic { width: 64px; height: 64px; border-radius: 50%; background: oklch(0.78 0.15 162 / 0.12); border: 1px solid oklch(0.78 0.15 162 / 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; }
        .ok-ic svg { width: 30px; height: 30px; color: var(--green); }
        .ok a { color: var(--purple); text-decoration: none; font-weight: 600; }
        .foot { text-align: center; margin-top: 18px; font-size: 13px; color: var(--ink-mute); }
        .foot a { color: var(--ink-dim); text-decoration: none; }
    </style>
</head>
<body>
    <a href="/" class="brand"><img src="/icon.svg" alt="Cardifys">Cardifys</a>
    <div class="wrap">
        <div class="card">
            @if(session('support_sent'))
                <div class="ok">
                    <div class="ok-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg></div>
                    <h1>Pedido enviado! 🎉</h1>
                    <p class="sub" style="margin-bottom:20px;">Recebemos o teu pedido e vamos responder o mais rápido possível para o email que indicaste.</p>
                    <a href="/">← Voltar ao início</a>
                </div>
            @else
                <h1>Precisas de ajuda?</h1>
                <p class="sub">Envia-nos o teu pedido e a equipa Cardifys responde-te por email.</p>
                <form method="POST" action="{{ route('support.store') }}">
                    @csrf
                    <input type="hidden" name="source" value="public">
                    <div class="field">
                        <label for="name">Nome</label>
                        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                        @error('name')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        @error('email')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label for="message">Mensagem</label>
                        <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                        @error('message')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn">Enviar pedido</button>
                </form>
            @endif
        </div>
        <p class="foot">Ou escreve-nos diretamente para <a href="mailto:{{ config('mail.support_address') }}">{{ config('mail.support_address') }}</a></p>
    </div>
</body>
</html>
