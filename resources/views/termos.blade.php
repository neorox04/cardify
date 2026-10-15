@extends('layouts.legal')
@section('title', 'Termos de Utilização')
@section('content')
    <h1>Termos de Utilização</h1>
    <p style="color: var(--ink-mute); font-size: 13px; margin-bottom: 20px;">Última atualização: 15 de outubro de 2026</p>

    <p>Estes Termos regulam o acesso e a utilização da plataforma Cardifys, operada por <strong>[Nome legal da entidade]</strong>, NIF <strong>[NIF]</strong>, com sede em <strong>[morada]</strong> (adiante "Cardifys", "nós"). Ao criar uma conta ou utilizar o serviço, aceita estes Termos.</p>

    <h2>1. O serviço</h2>
    <p>A Cardifys é uma plataforma de cartões de visita digitais que permite criar, gerir e partilhar cartões (com código QR), recolher contactos partilhados e exportá-los. O serviço é disponibilizado mediante subscrição paga.</p>

    <h2>2. Conta e registo</h2>
    <ul>
        <li>Deve ter pelo menos 16 anos e fornecer informação verdadeira e atualizada.</li>
        <li>É responsável por manter a confidencialidade da sua palavra-passe e por toda a atividade na sua conta.</li>
        <li>Deve notificar-nos de imediato de qualquer utilização não autorizada da conta.</li>
    </ul>

    <h2>3. Planos, pagamentos e renovação</h2>
    <ul>
        <li>Os planos (individual mensal, individual anual e empresa por lugares) e respetivos preços estão indicados na plataforma, em euros (EUR) e, quando aplicável, acrescidos de IVA.</li>
        <li>Os pagamentos são processados pela <strong>Stripe</strong>. Ao subscrever, autoriza a cobrança recorrente do plano escolhido.</li>
        <li>As subscrições <strong>renovam-se automaticamente</strong> no fim de cada período, pelo preço então em vigor, até serem canceladas.</li>
        <li>Pode cancelar a qualquer momento; o cancelamento produz efeitos no fim do período já pago, sem reembolso do período em curso, salvo o disposto na secção 4 ou exigência legal.</li>
    </ul>

    <h2>4. Direito de livre resolução (consumidores)</h2>
    <p>Se for consumidor na União Europeia, tem o direito de resolver o contrato no prazo de 14 dias sem indicar motivo. Ao subscrever um serviço digital de execução imediata, pode ser-lhe pedido que consinta no início imediato da prestação e reconheça que, ao fazê-lo, perde o direito de livre resolução na parte já prestada. Para exercer este direito, contacte <a href="mailto:{{ config('mail.support_address') }}">{{ config('mail.support_address') }}</a>.</p>

    <h2>5. Utilização aceitável</h2>
    <ul>
        <li>Não pode usar o serviço para fins ilícitos, enganosos, abusivos ou que violem direitos de terceiros.</li>
        <li>Não pode tentar comprometer a segurança, integridade ou disponibilidade da plataforma.</li>
        <li><strong>Contactos e leads:</strong> ao recolher e tratar os contactos que recebe através da plataforma, é o responsável pelo tratamento desses dados e compromete-se a cumprir o RGPD — nomeadamente a ter uma base legal válida e a respeitar os direitos dos titulares.</li>
    </ul>

    <h2>6. Conteúdo do utilizador e propriedade intelectual</h2>
    <p>Mantém a titularidade do conteúdo que carrega (dados dos cartões, logótipos, etc.) e concede-nos uma licença limitada para o alojar e apresentar com o único fim de prestar o serviço. O software, a marca e os materiais da Cardifys são propriedade da empresa e não podem ser usados sem autorização.</p>

    <h2>7. Disponibilidade do serviço</h2>
    <p>Esforçamo-nos por manter o serviço disponível e fiável, mas não garantimos funcionamento ininterrupto ou isento de erros. Podemos realizar manutenções e alterações às funcionalidades.</p>

    <h2>8. Limitação de responsabilidade</h2>
    <p>Na medida máxima permitida por lei, a Cardifys não é responsável por danos indiretos, lucros cessantes ou perda de dados resultantes do uso ou impossibilidade de uso do serviço. Nada nestes Termos exclui responsabilidades que não possam ser legalmente excluídas, incluindo os direitos que a lei confere aos consumidores.</p>

    <h2>9. Suspensão e encerramento</h2>
    <p>Podemos suspender ou encerrar o acesso em caso de violação destes Termos, uso indevido ou falta de pagamento. Pode encerrar a sua conta a qualquer momento; após o encerramento, os dados são tratados conforme a Política de Privacidade.</p>

    <h2>10. Alterações aos Termos</h2>
    <p>Podemos alterar estes Termos. As alterações relevantes serão comunicadas na plataforma e a data no topo reflete a versão em vigor. A continuação do uso após a comunicação implica aceitação.</p>

    <h2>11. Lei aplicável e resolução de litígios</h2>
    <p>Estes Termos regem-se pela lei portuguesa. Sem prejuízo dos direitos imperativos do consumidor, o foro competente é o dos tribunais de <strong>[comarca]</strong>, Portugal. Enquanto consumidor, pode recorrer à plataforma de Resolução de Litígios em Linha da União Europeia em <a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener">ec.europa.eu/consumers/odr</a> ou a uma entidade de resolução alternativa de litígios (RAL).</p>

    <h2>12. Contacto</h2>
    <p>Para dúvidas sobre estes Termos: <a href="mailto:{{ config('mail.support_address') }}">{{ config('mail.support_address') }}</a>.</p>
@endsection
