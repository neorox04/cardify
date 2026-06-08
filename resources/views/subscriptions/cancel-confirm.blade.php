@extends('layouts.dashboard')
@section('title', 'Cancelar subscrição')

@section('content')
<div style="max-width:520px;margin:60px auto;padding:0 24px;">

    <div style="background:oklch(0.19 0.015 290);border:1px solid oklch(0.28 0.018 290/0.5);border-radius:16px;padding:36px;">

        <div style="width:48px;height:48px;background:oklch(0.65 0.22 25/0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:24px;">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="oklch(0.65 0.22 25)" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
        </div>

        <h1 style="font-size:20px;font-weight:600;color:oklch(0.97 0.010 290);margin-bottom:12px;">Cancelar subscrição</h1>

        <p style="color:oklch(0.72 0.015 290);font-size:14px;line-height:1.6;margin-bottom:8px;">
            Tens a certeza que queres cancelar?
        </p>
        <p style="color:oklch(0.72 0.015 290);font-size:14px;line-height:1.6;margin-bottom:24px;">
            Mantens acesso completo até <strong style="color:oklch(0.97 0.010 290);">{{ $periodEnd->format('d/m/Y') }}</strong>. Depois disso, a conta passa para modo gratuito e os teus cartões ficam inativos.
        </p>

        <form method="POST" action="{{ route('subscriptions.cancel-confirm.post') }}">
            @csrf
            <div style="display:flex;gap:12px;">
                <button type="submit" style="flex:1;padding:11px;background:oklch(0.65 0.22 25/0.15);border:1px solid oklch(0.65 0.22 25/0.4);border-radius:10px;color:oklch(0.75 0.18 25);font-size:14px;font-weight:500;cursor:pointer;">
                    Confirmar cancelamento
                </button>
                <a href="{{ route('dashboard') }}" style="flex:1;padding:11px;background:oklch(0.72 0.19 300/0.1);border:1px solid oklch(0.72 0.19 300/0.3);border-radius:10px;color:oklch(0.72 0.19 300);font-size:14px;font-weight:500;text-align:center;text-decoration:none;">
                    Manter subscrição
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
