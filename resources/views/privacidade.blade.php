@extends('layouts.legal')
@section('title', 'Política de Privacidade')
@section('content')
    <h1>Política de Privacidade</h1>
    <p style="color: var(--ink-mute); font-size: 13px; margin-bottom: 20px;">Última atualização: 15 de outubro de 2026</p>

    <p>Esta Política de Privacidade explica como a Cardifys recolhe, utiliza, partilha e protege dados pessoais, e os direitos que lhe assistem ao abrigo do Regulamento Geral sobre a Proteção de Dados (RGPD) e da legislação portuguesa aplicável.</p>

    <h2>1. Responsável pelo tratamento</h2>
    <p>O responsável pelo tratamento dos dados é <strong>[Nome legal da entidade]</strong>, com sede em <strong>[morada]</strong>, NIF <strong>[NIF]</strong> (adiante "Cardifys", "nós").</p>
    <p>Para qualquer questão sobre privacidade ou para exercer os seus direitos, contacte-nos através de <a href="mailto:{{ config('mail.support_address') }}">{{ config('mail.support_address') }}</a>.</p>

    <h2>2. Dados que recolhemos</h2>
    <p><strong>a) Titulares de conta (utilizadores da Cardifys):</strong></p>
    <ul>
        <li><strong>Dados de registo:</strong> nome, email e palavra-passe (guardada cifrada, nunca em texto simples).</li>
        <li><strong>Dados de faturação:</strong> tratados pela Stripe enquanto processador de pagamentos — não armazenamos os dados do cartão nos nossos servidores.</li>
        <li><strong>Conteúdo dos cartões:</strong> a informação que coloca nos seus cartões digitais (nome, cargo, contactos, links, etc.).</li>
        <li><strong>Dados de utilização:</strong> registos de acesso, visualizações, leituras de QR e eventos de analítica dos seus cartões.</li>
    </ul>
    <p><strong>b) Terceiros que partilham o contacto (o "reciprocity loop"):</strong></p>
    <ul>
        <li>Quando alguém lê um cartão e opta por retribuir o contacto, recolhemos o <strong>nome, email e telefone</strong> que essa pessoa fornece, para os entregar ao titular do cartão.</li>
        <li>Estes dados são fornecidos pela própria pessoa, de forma voluntária, no momento da partilha. O titular do cartão que os recebe é responsável pela utilização que faz desses contactos e deve ter uma base legal própria para os tratar (por exemplo, para seguimento comercial).</li>
        <li>Qualquer pessoa cujos dados tenham sido partilhados desta forma pode pedir-nos o acesso ou a eliminação através do email acima.</li>
    </ul>
    <p><strong>c) Cookies:</strong> usamos cookies essenciais ao funcionamento (ex.: sessão e autenticação) e, apenas com o seu consentimento, cookies analíticos. Ver secção 8.</p>

    <h2>3. Finalidades e base legal</h2>
    <ul>
        <li><strong>Prestar o serviço</strong> — gestão de conta, criação, gestão e partilha de cartões (base: execução do contrato, art. 6.º/1/b do RGPD).</li>
        <li><strong>Processar pagamentos e subscrições</strong> (base: execução do contrato).</li>
        <li><strong>Entregar os contactos partilhados</strong> ao titular do cartão (base: interesse legítimo do titular e ação voluntária de quem partilha, art. 6.º/1/f).</li>
        <li><strong>Segurança, prevenção de fraude e melhoria do serviço</strong> (base: interesse legítimo).</li>
        <li><strong>Cookies analíticos e comunicações de marketing</strong> (base: consentimento, art. 6.º/1/a — revogável a qualquer momento).</li>
        <li><strong>Cumprir obrigações legais</strong>, nomeadamente fiscais (base: obrigação jurídica, art. 6.º/1/c).</li>
    </ul>

    <h2>4. Subcontratantes e partilha de dados</h2>
    <p>Não vendemos dados pessoais. Partilhamos apenas o necessário com subcontratantes que nos prestam serviços, sob contrato e obrigações de confidencialidade:</p>
    <ul>
        <li><strong>Stripe</strong> — processamento de pagamentos e subscrições.</li>
        <li><strong>Fornecedor de email transacional</strong> — envio de emails do serviço (ex.: boas-vindas, contactos partilhados).</li>
        <li><strong>Alojamento (hosting)</strong> — infraestrutura onde a aplicação corre.</li>
        <li><strong>Sentry</strong> — monitorização de erros técnicos.</li>
    </ul>
    <p>Podemos ainda divulgar dados quando exigido por lei ou por autoridade competente.</p>

    <h2>5. Transferências internacionais</h2>
    <p>Alguns subcontratantes (como a Stripe e a Sentry) podem tratar dados fora do Espaço Económico Europeu. Nesses casos, as transferências são protegidas por mecanismos adequados ao abrigo do RGPD, como as Cláusulas Contratuais-Tipo da Comissão Europeia ou decisões de adequação.</p>

    <h2>6. Prazo de conservação</h2>
    <ul>
        <li><strong>Dados de conta:</strong> enquanto a conta estiver ativa; após o encerramento, eliminamos ou anonimizamos os dados num prazo razoável, salvo obrigação legal de os conservar.</li>
        <li><strong>Dados de faturação:</strong> pelo período exigido pela legislação fiscal portuguesa (regra geral, 10 anos).</li>
        <li><strong>Contactos partilhados:</strong> enquanto a conta do titular que os recebeu estiver ativa, ou até ser pedida a eliminação.</li>
    </ul>

    <h2>7. Os seus direitos</h2>
    <p>Ao abrigo do RGPD, tem o direito de:</p>
    <ul>
        <li>Aceder aos seus dados e obter uma cópia;</li>
        <li>Retificar dados incorretos ou incompletos;</li>
        <li>Solicitar a eliminação ("direito a ser esquecido");</li>
        <li>Limitar ou opor-se a determinados tratamentos;</li>
        <li>Portabilidade dos dados que nos forneceu;</li>
        <li>Retirar o consentimento a qualquer momento, sem afetar a licitude do tratamento anterior.</li>
    </ul>
    <p>Para exercer qualquer destes direitos, escreva para <a href="mailto:{{ config('mail.support_address') }}">{{ config('mail.support_address') }}</a>. Tem também o direito de apresentar reclamação à autoridade de controlo — em Portugal, a <strong>Comissão Nacional de Proteção de Dados (CNPD)</strong>, em <a href="https://www.cnpd.pt" target="_blank" rel="noopener">www.cnpd.pt</a>.</p>

    <h2>8. Cookies</h2>
    <p>Os cookies essenciais são necessários ao funcionamento do site e não exigem consentimento. Os cookies analíticos só são ativados com o seu consentimento e podem ser recusados ou retirados sem afetar a utilização do serviço.</p>

    <h2>9. Segurança</h2>
    <p>Aplicamos medidas técnicas e organizativas adequadas para proteger os dados, incluindo cifragem de palavras-passe e comunicações por HTTPS. Nenhum sistema é 100% seguro, mas comprometemo-nos a notificar os titulares e a CNPD em caso de violação de dados que o exija, nos termos do RGPD.</p>

    <h2>10. Menores</h2>
    <p>O serviço não se destina a menores de 16 anos e não recolhemos intencionalmente dados dessas pessoas.</p>

    <h2>11. Alterações</h2>
    <p>Podemos atualizar esta Política periodicamente. As alterações relevantes serão comunicadas na plataforma, e a data no topo reflete a versão em vigor.</p>

    <h2>12. Contacto</h2>
    <p>Para questões sobre esta Política ou sobre o tratamento dos seus dados: <a href="mailto:{{ config('mail.support_address') }}">{{ config('mail.support_address') }}</a>.</p>
@endsection
