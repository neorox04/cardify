@extends('layouts.dashboard')

@section('title', 'Contactos recebidos')

@section('content')
<div class="rc-head">
    <div>
        <h1 class="page-title">Contactos recebidos</h1>
        <p class="page-subtitle">Pessoas que retribuíram o contacto ao ler os teus cartões</p>
    </div>
    <div class="rc-head-right">
        <span class="rc-count">{{ $contacts->total() }}</span>
        @if($contacts->total())
            <a href="{{ route('user.received-contacts.export') }}" class="rc-export">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Exportar CSV
            </a>
        @endif
    </div>
</div>

@if($contacts->count())
    <div class="rc-panel">
        <table class="rc-table">
            <thead>
                <tr>
                    <th>Contacto</th>
                    <th>Telemóvel</th>
                    <th>Via cartão</th>
                    <th>Quando</th>
                    <th class="r">vCard</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $c)
                    <tr>
                        <td>
                            <div class="rc-name">{{ $c->full_name }}</div>
                            <a href="mailto:{{ $c->email }}" class="rc-email">{{ $c->email }}</a>
                        </td>
                        <td><a href="tel:{{ $c->phone }}" class="rc-link">{{ $c->phone }}</a></td>
                        <td class="rc-muted">{{ $c->businessCard->full_name ?? '—' }}</td>
                        <td class="rc-muted">{{ $c->created_at->locale('pt')->diffForHumans() }}</td>
                        <td class="r">
                            <a href="{{ route('user.received-contacts.vcard', $c) }}" class="rc-dl" title="Guardar vCard">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $contacts->links() }}</div>
@else
    <div class="rc-panel rc-empty">
        <div class="rc-empty-ic">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
        </div>
        <h3>Ainda sem contactos recebidos</h3>
        <p>Quando alguém ler o teu cartão e retribuir o contacto, aparece aqui. Partilha os teus cartões para começar!</p>
    </div>
@endif
@endsection

@push('styles')
<style>
    .rc-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }
    .rc-count { font-size: 13px; font-weight: 600; color: var(--purple, oklch(0.72 0.19 300)); background: oklch(0.72 0.19 300 / 0.12); border: 1px solid oklch(0.72 0.19 300 / 0.25); padding: 5px 13px; border-radius: 999px; }
    .rc-head-right { display: flex; align-items: center; gap: 12px; }
    .rc-export { display: inline-flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 600; color: #fff; text-decoration: none; background: linear-gradient(135deg, oklch(0.75 0.19 300), oklch(0.6 0.19 300)); padding: 8px 15px; border-radius: 10px; box-shadow: 0 6px 18px oklch(0.72 0.19 300 / 0.3); transition: transform .15s; }
    .rc-export:hover { transform: translateY(-1px); }
    .rc-panel { background: var(--bg-2, #16181f); border: 1px solid var(--line-soft, rgba(255,255,255,0.08)); border-radius: 16px; padding: 8px 4px; }
    .rc-table { width: 100%; border-collapse: collapse; }
    .rc-table th { text-align: left; font-size: 10px; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; color: var(--ink-mute, #7a7a85); padding: 12px 16px 10px; }
    .rc-table th.r, .rc-table td.r { text-align: right; }
    .rc-table td { padding: 13px 16px; font-size: 13px; border-top: 1px solid var(--line-soft, rgba(255,255,255,0.07)); vertical-align: middle; }
    .rc-name { font-weight: 500; }
    .rc-email { font-size: 12px; color: var(--ink-mute, #7a7a85); text-decoration: none; }
    .rc-email:hover { color: var(--purple, oklch(0.72 0.19 300)); }
    .rc-link { color: var(--ink-dim, #a9a9b3); text-decoration: none; }
    .rc-link:hover { color: var(--ink, #fff); }
    .rc-muted { color: var(--ink-mute, #7a7a85); }
    .rc-dl { display: inline-flex; padding: 8px; border-radius: 9px; color: var(--ink-dim, #a9a9b3); border: 1px solid var(--line-soft, rgba(255,255,255,0.09)); transition: all .15s; }
    .rc-dl:hover { color: var(--purple, oklch(0.72 0.19 300)); border-color: oklch(0.72 0.19 300 / 0.4); }
    .rc-empty { text-align: center; padding: 54px 24px; }
    .rc-empty-ic { width: 64px; height: 64px; border-radius: 18px; background: oklch(0.72 0.19 300 / 0.1); border: 1px solid oklch(0.72 0.19 300 / 0.2); color: var(--purple, oklch(0.72 0.19 300)); display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; }
    .rc-empty h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; }
    .rc-empty p { font-size: 13px; color: var(--ink-mute, #7a7a85); max-width: 340px; margin: 0 auto; line-height: 1.6; }
</style>
@endpush
