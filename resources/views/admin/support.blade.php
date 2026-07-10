@extends('layouts.dashboard')

@section('title', 'Suporte')

@section('content')
@php
    $colColors = ['received' => '#e0a43a', 'in_progress' => '#B884FF', 'done' => '#34d399'];
    $total = collect(\App\Models\SupportTicket::STATUSES)->keys()->sum(fn ($k) => optional($tickets->get($k))->count() ?? 0);
@endphp

<div class="dashboard-header">
    <div>
        <h1 class="page-title">Suporte</h1>
        <p class="page-subtitle">Pedidos recebidos · arrasta os cartões entre colunas</p>
    </div>
    <span class="kb-count" style="font-size:13px;padding:6px 14px;">{{ $total }} pedidos</span>
</div>

<div class="kb-board" data-url="{{ url('admin/support/__ID__/status') }}">
    @foreach(\App\Models\SupportTicket::STATUSES as $key => $label)
        @php $col = $tickets->get($key, collect()); @endphp
        <div class="kb-col" data-status="{{ $key }}">
            <div class="kb-col-head">
                <span class="kb-col-title"><span class="kb-dot" style="background:{{ $colColors[$key] }}"></span>{{ $label }}</span>
                <span class="kb-count">{{ $col->count() }}</span>
            </div>
            <div class="kb-list">
                @forelse($col as $ticket)
                    <div class="kb-card" data-id="{{ $ticket->id }}">
                        <div class="kb-card-title">{{ $ticket->subject ?: \Illuminate\Support\Str::limit($ticket->message, 42) }}</div>
                        <div class="kb-card-meta">{{ $ticket->name }} · {{ $ticket->email }}</div>
                        @if($ticket->subject)<div class="kb-card-body">{{ \Illuminate\Support\Str::limit($ticket->message, 160) }}</div>@endif
                        <div class="kb-card-foot">
                            <span class="kb-card-meta">{{ $ticket->created_at->locale('pt')->diffForHumans() }}</span>
                            <div style="display:flex;gap:6px;align-items:center;">
                                <a href="mailto:{{ $ticket->email }}?subject=Re: {{ $ticket->subject }}" class="kb-del" title="Responder por email">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </a>
                                <button type="button" class="kb-del" data-del-url="{{ route('admin.support.destroy', $ticket) }}" title="Remover">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="kb-empty">Sem pedidos aqui.</div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

@include('admin.partials.kanban-assets')
@endsection
