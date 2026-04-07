@extends('layouts.legal')
@section('title', 'Pagamento cancelado')
@section('content')
    <h1>Pagamento cancelado</h1>
    <p>O seu pagamento não foi concluído. Pode tentar novamente quando quiser.</p>
    <a href="{{ route('subscriptions.plans') }}" class="btn btn-primary mt-6">Escolher plano</a>
@endsection
