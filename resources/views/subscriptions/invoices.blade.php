@extends('layouts.dashboard')
@section('title', 'Faturas')

@section('content')
<div style="max-width:680px;margin:48px auto;padding:0 24px;">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;">
        <div>
            <h1 style="font-size:22px;font-weight:600;color:oklch(0.97 0.010 290);">Faturas</h1>
            <p style="font-size:13px;color:oklch(0.52 0.012 290);margin-top:4px;">Histórico de pagamentos da tua subscrição</p>
        </div>
        <a href="{{ route('dashboard') }}" style="font-size:13px;color:oklch(0.72 0.015 290);text-decoration:none;">← Voltar</a>
    </div>

    @if(session('success'))
        <div style="background:oklch(0.78 0.17 160/0.12);border:1px solid oklch(0.78 0.17 160/0.3);border-radius:10px;padding:12px 16px;margin-bottom:20px;color:oklch(0.78 0.17 160);font-size:13px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background:oklch(0.19 0.015 290);border:1px solid oklch(0.28 0.018 290/0.5);border-radius:16px;overflow:hidden;">

        @if($invoices->isEmpty())
            <div style="padding:48px;text-align:center;color:oklch(0.52 0.012 290);">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 12px;display:block;opacity:0.4;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                <p style="font-size:14px;">Ainda não tens faturas.</p>
            </div>
        @else
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid oklch(0.28 0.018 290/0.5);">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:500;letter-spacing:0.08em;text-transform:uppercase;color:oklch(0.52 0.012 290);">Data</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:500;letter-spacing:0.08em;text-transform:uppercase;color:oklch(0.52 0.012 290);">Descrição</th>
                        <th style="padding:14px 20px;text-align:right;font-size:11px;font-weight:500;letter-spacing:0.08em;text-transform:uppercase;color:oklch(0.52 0.012 290);">Total</th>
                        <th style="padding:14px 20px;text-align:right;font-size:11px;font-weight:500;letter-spacing:0.08em;text-transform:uppercase;color:oklch(0.52 0.012 290);"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr style="border-bottom:1px solid oklch(0.28 0.018 290/0.25);">
                        <td style="padding:14px 20px;font-size:13px;color:oklch(0.72 0.015 290);">
                            {{ $invoice->date()->format('d/m/Y') }}
                        </td>
                        <td style="padding:14px 20px;font-size:13px;color:oklch(0.97 0.010 290);">
                            {{ $invoice->lines->data[0]->description ?? 'Subscrição Cardifys' }}
                        </td>
                        <td style="padding:14px 20px;font-size:13px;font-weight:600;color:oklch(0.97 0.010 290);text-align:right;">
                            {{ $invoice->total() }}
                        </td>
                        <td style="padding:14px 20px;text-align:right;">
                            <a href="{{ route('subscriptions.invoices.download', $invoice->id) }}"
                               style="font-size:12px;color:oklch(0.72 0.19 300);text-decoration:none;padding:5px 10px;border:1px solid oklch(0.72 0.19 300/0.3);border-radius:6px;">
                                Download
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

    @auth
    @if(Auth::user()->subscribed('default'))
    <div style="margin-top:32px;padding:20px;background:oklch(0.65 0.22 25/0.06);border:1px solid oklch(0.65 0.22 25/0.2);border-radius:12px;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <p style="font-size:13px;font-weight:500;color:oklch(0.97 0.010 290);margin-bottom:2px;">Cancelar subscrição</p>
            <p style="font-size:12px;color:oklch(0.52 0.012 290);">Mantens acesso até ao fim do período atual.</p>
        </div>
        <a href="{{ route('subscriptions.cancel-confirm') }}" style="font-size:13px;color:oklch(0.75 0.18 25);padding:8px 14px;border:1px solid oklch(0.65 0.22 25/0.4);border-radius:8px;text-decoration:none;white-space:nowrap;">
            Cancelar plano
        </a>
    </div>
    @endif
    @endauth

</div>
@endsection
