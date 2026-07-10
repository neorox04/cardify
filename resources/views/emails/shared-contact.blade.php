@extends('emails.layouts.base')

@section('content')
    <h1 style="margin:0 0 8px;font-size:22px;">Novo contacto partilhado 👋</h1>
    <p style="margin:0 0 20px;color:#a1a1aa;font-size:15px;line-height:1.6;">
        <strong style="color:#fff;">{{ $shared->full_name }}</strong> leu o teu cartão
        <strong style="color:#fff;">{{ $card->full_name }}</strong> e quis partilhar o contacto contigo.
        Está em anexo como vCard — abre para guardar no telemóvel.
    </p>

    <table style="width:100%;border-collapse:collapse;background:#18181b;border:1px solid rgba(255,255,255,0.08);border-radius:12px;overflow:hidden;">
        <tr><td style="padding:14px 18px;color:#71717a;font-size:13px;width:110px;">Nome</td><td style="padding:14px 18px;font-size:14px;color:#fafafa;">{{ $shared->full_name }}</td></tr>
        <tr><td style="padding:14px 18px;color:#71717a;font-size:13px;border-top:1px solid rgba(255,255,255,0.06);">Telemóvel</td><td style="padding:14px 18px;font-size:14px;color:#fafafa;border-top:1px solid rgba(255,255,255,0.06);"><a href="tel:{{ $shared->phone }}" style="color:#B884FF;text-decoration:none;">{{ $shared->phone }}</a></td></tr>
        <tr><td style="padding:14px 18px;color:#71717a;font-size:13px;border-top:1px solid rgba(255,255,255,0.06);">Email</td><td style="padding:14px 18px;font-size:14px;color:#fafafa;border-top:1px solid rgba(255,255,255,0.06);"><a href="mailto:{{ $shared->email }}" style="color:#B884FF;text-decoration:none;">{{ $shared->email }}</a></td></tr>
    </table>

    <p style="margin:22px 0 0;color:#71717a;font-size:12px;">Também podes ver todos os contactos recebidos no teu dashboard Cardifys.</p>
@endsection
