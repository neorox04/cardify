@extends('emails.layouts.base')

@section('content')
    <span class="badge">Subscrição ativa</span>
    <h1>Estás pronto para começar, {{ $user->name }}! 🚀</h1>
    <p>A tua subscrição foi ativada com sucesso. Aqui fica um guia rápido para tirares o máximo partido da Cardifys desde o primeiro dia.</p>

    <hr class="divider">

    @php
        $steps = [
            ['1', 'Cria o teu primeiro cartão', 'No dashboard, clica em <strong>"Novo cartão"</strong> e preenche os teus dados: cargo, empresa, contactos e redes sociais. Escolhe o estilo do teu avatar e guarda.'],
            ['2', 'Partilha o teu link ou QR code', 'Cada cartão tem um <strong>link único</strong> e um <strong>QR code</strong>. Partilha por mensagem, mostra em reuniões ou imprime no teu material — o contacto é guardado num toque.'],
            ['3', 'Recebe contactos de volta', 'Quem lê o teu cartão pode <strong>retribuir o contacto</strong> na hora. Encontra-os todos em <strong>"Contactos recebidos"</strong> — nunca mais perdes um lead.'],
            ['4', 'Acompanha as tuas estatísticas', 'Vê as <strong>visualizações</strong>, <strong>scans</strong> e <strong>contactos guardados</strong> de cada cartão na tua página de <strong>Analytics</strong>.'],
        ];
    @endphp

    @foreach($steps as $step)
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:22px;">
        <tr>
            <td width="42" valign="top">
                <div style="width:34px;height:34px;background:rgba(184,132,255,0.15);border:1px solid rgba(184,132,255,0.32);border-radius:50%;text-align:center;">
                    <span class="email-font" style="font-weight:700;font-size:15px;color:#c9a6ff;line-height:34px;">{{ $step[0] }}</span>
                </div>
            </td>
            <td valign="top" style="padding-left:14px;">
                <h2 style="margin:0 0 5px;">{{ $step[1] }}</h2>
                <p style="margin:0;">{!! $step[2] !!}</p>
            </td>
        </tr>
    </table>
    @endforeach

    <div class="btn-center">
        <a href="{{ url('/dashboard') }}" class="btn">Ir para o dashboard</a>
    </div>

    <div class="info-box">
        <p>Tens alguma dúvida? Responde a este email — estamos sempre disponíveis para ajudar.</p>
    </div>
@endsection
