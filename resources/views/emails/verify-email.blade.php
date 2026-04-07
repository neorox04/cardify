@extends('emails.layouts.base')

@section('content')
    <span class="badge">Verificação de Email</span>
    <h1>Confirma o teu endereço de email</h1>
    <p>Olá! Obrigado por te registares no Cardify. Para começares a usar a plataforma, precisamos confirmar que este email te pertence.</p>
    <p>Clica no botão abaixo para verificar o teu email. Este link expira em <strong style="color:#fafafa">60 minutos</strong>.</p>

    <div class="btn-center">
        <a href="{{ $url }}" class="btn">Verificar Email</a>
    </div>

    <hr class="divider">

    <div class="info-box">
        <p>Se o botão não funcionar, copia e cola este link no teu navegador:</p>
    </div>
    <div class="url-box">{{ $url }}</div>

    <div class="warning-box">
        <p>Se não criaste uma conta no Cardify, ignora este email.</p>
    </div>
@endsection
