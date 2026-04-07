@extends('emails.layouts.base')

@section('content')
    <span class="badge">Subscrição Ativa</span>
    <h1>Estás pronto para começar, {{ $user->name }}!</h1>
    <p>A tua subscrição foi ativada com sucesso. Criámos este guia rápido para te ajudares a tirar o máximo partido do Cardify desde o primeiro dia.</p>

    <hr class="divider">

    {{-- Passo 1 --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px">
        <tr>
            <td width="44" valign="top">
                <div style="width:36px;height:36px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px;color:#818cf8;text-align:center;line-height:36px">1</div>
            </td>
            <td valign="top" style="padding-left:12px">
                <h2 style="margin-bottom:6px">Cria o teu primeiro cartão de visita</h2>
                <p style="margin:0">Acede ao dashboard, clica em <strong style="color:#fafafa">"Novo Cartão"</strong> e preenche os teus dados: nome, cargo, empresa, email, telefone e redes sociais. Escolhe um dos temas disponíveis e guarda.</p>
            </td>
        </tr>
    </table>

    {{-- Passo 2 --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px">
        <tr>
            <td width="44" valign="top">
                <div style="width:36px;height:36px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px;color:#818cf8;text-align:center;line-height:36px">2</div>
            </td>
            <td valign="top" style="padding-left:12px">
                <h2 style="margin-bottom:6px">Partilha o teu link ou QR code</h2>
                <p style="margin:0">Cada cartão tem um <strong style="color:#fafafa">link único</strong> que podes enviar por mensagem, email ou WhatsApp. Também podes usar o <strong style="color:#fafafa">QR code</strong> em reuniões, conferências ou impresso no teu material.</p>
            </td>
        </tr>
    </table>

    {{-- Passo 3 --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px">
        <tr>
            <td width="44" valign="top">
                <div style="width:36px;height:36px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px;color:#818cf8;text-align:center;line-height:36px">3</div>
            </td>
            <td valign="top" style="padding-left:12px">
                <h2 style="margin-bottom:6px">Junta a tua equipa</h2>
                <p style="margin:0">Se fizeres parte de uma empresa, podes criar um espaço de empresa e <strong style="color:#fafafa">convidar colegas</strong> para terem os seus próprios cartões com a identidade da empresa.</p>
            </td>
        </tr>
    </table>

    {{-- Passo 4 --}}
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td width="44" valign="top">
                <div style="width:36px;height:36px;background:rgba(99,102,241,0.15);border:1px solid rgba(99,102,241,0.3);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px;color:#818cf8;text-align:center;line-height:36px">4</div>
            </td>
            <td valign="top" style="padding-left:12px">
                <h2 style="margin-bottom:6px">Acompanha as estatísticas</h2>
                <p style="margin:0">O Cardify regista as <strong style="color:#fafafa">visualizações</strong> do teu cartão e os <strong style="color:#fafafa">contactos guardados</strong>. Assim sabes exatamente quem mostrou interesse.</p>
            </td>
        </tr>
    </table>

    <hr class="divider">

    <div class="btn-center">
        <a href="{{ url('/dashboard') }}" class="btn">Ir para o Dashboard</a>
    </div>

    <div class="info-box">
        <p>Tens alguma dúvida? Responde a este email ou contacta o nosso suporte — estamos sempre disponíveis para ajudar.</p>
    </div>
@endsection
