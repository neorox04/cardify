@extends('emails.layouts.base')

@section('content')
    <span class="badge">Segurança</span>
    <h1>Recupera a tua password</h1>
    <p>Recebemos um pedido para redefinir a password da tua conta Cardify. Clica no botão abaixo para criar uma nova password.</p>
    <p>Este link é válido durante <strong style="color:#fafafa">60 minutos</strong>. Depois disso, terás de fazer um novo pedido.</p>

    <div class="btn-center">
        <a href="{{ $url }}" class="btn">Redefinir Password</a>
    </div>

    <hr class="divider">

    <div class="info-box">
        <p>Se o botão não funcionar, copia e cola este link no teu navegador:</p>
    </div>
    <div class="url-box">{{ $url }}</div>

    <div class="warning-box">
        <p><strong>Não fizeste este pedido?</strong> A tua password está segura — podes ignorar este email. Se achares que a tua conta foi comprometida, altera a tua password imediatamente.</p>
    </div>
@endsection
