@extends('emails.layouts.base')

@section('content')
    <span class="badge">Bem-vindo</span>
    <h1>Olá, {{ $user->name }}! 👋</h1>
    <p>A tua conta no <strong style="color:#fafafa">Cardify</strong> foi criada com sucesso. Estamos muito contentes por teres-te juntado a nós!</p>
    <p>Com o Cardify podes criar e partilhar cartões de visita digitais profissionais, com QR code incluído, em segundos.</p>

    <hr class="divider">

    <h2>Como começar</h2>
    <p style="margin-bottom:8px">
        <strong style="color:#fafafa">1. Verifica o teu email</strong><br>
        Enviámos-te um email de verificação. Confirma o teu endereço para desbloquear todas as funcionalidades.
    </p>
    <p style="margin-bottom:8px">
        <strong style="color:#fafafa">2. Cria o teu primeiro cartão</strong><br>
        Adiciona o teu nome, cargo, empresa, contactos e redes sociais.
    </p>
    <p>
        <strong style="color:#fafafa">3. Partilha com o mundo</strong><br>
        O teu cartão fica disponível num link único que podes partilhar ou imprimir como QR code.
    </p>

    <div class="btn-center">
        <a href="{{ url('/dashboard') }}" class="btn">Ir para o Dashboard</a>
    </div>

    <div class="success-box">
        <p>Se tiveres alguma dúvida ou precisares de ajuda, estamos aqui para ti.</p>
    </div>
@endsection
