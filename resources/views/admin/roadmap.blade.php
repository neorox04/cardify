@extends('layouts.dashboard')

@section('title', 'Roadmap')

@section('content')
@php
    $colColors = ['todo' => '#7a7a85', 'doing' => '#B884FF', 'done' => '#34d399'];
    $prColors = ['low' => ['Baixa', '#7a7a85', 'rgba(255,255,255,0.06)'], 'medium' => ['Média', '#B884FF', 'rgba(184,132,255,0.14)'], 'high' => ['Alta', '#ef4444', 'rgba(239,68,68,0.14)']];
@endphp

<div class="dashboard-header">
    <div>
        <h1 class="page-title">Roadmap</h1>
        <p class="page-subtitle">O teu guia de produto · arrasta os cartões entre colunas</p>
    </div>
</div>

{{-- New item --}}
<form method="POST" action="{{ route('admin.roadmap.store') }}" class="rm-add" id="rm-add-form" data-del-base="{{ url('admin/roadmap/__ID__') }}">
    @csrf
    <input type="text" name="title" class="rm-input" placeholder="Nova tarefa / ideia…" required maxlength="255">
    <select name="priority" class="rm-input rm-select">
        <option value="medium">Média</option>
        <option value="low">Baixa</option>
        <option value="high">Alta</option>
    </select>
    <button type="submit" class="rm-btn">Adicionar</button>
</form>
@error('title')<p style="color:#ef4444;font-size:12px;margin:-8px 0 14px;">{{ $message }}</p>@enderror

<div class="kb-board" data-url="{{ url('admin/roadmap/__ID__') }}">
    @foreach(\App\Models\RoadmapItem::STATUSES as $key => $label)
        @php $col = $items->get($key, collect()); @endphp
        <div class="kb-col" data-status="{{ $key }}">
            <div class="kb-col-head">
                <span class="kb-col-title"><span class="kb-dot" style="background:{{ $colColors[$key] }}"></span>{{ $label }}</span>
                <span class="kb-count">{{ $col->count() }}</span>
            </div>
            <div class="kb-list">
                @forelse($col as $item)
                    @php $pr = $prColors[$item->priority] ?? $prColors['medium']; @endphp
                    <div class="kb-card" data-id="{{ $item->id }}">
                        <div class="kb-card-title">{{ $item->title }}</div>
                        @if($item->description)
                            <div class="kb-card-body">{{ \Illuminate\Support\Str::limit($item->description, 160) }}</div>
                        @endif
                        <div class="kb-card-foot">
                            <span class="kb-pill" style="color:{{ $pr[1] }};background:{{ $pr[2] }};">{{ $pr[0] }}</span>
                            <button type="button" class="kb-del" data-del-url="{{ route('admin.roadmap.destroy', $item) }}" title="Remover">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="kb-empty">Vazio.</div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

@include('admin.partials.kanban-assets')

@push('scripts')
<script>
    (function () {
        var form = document.getElementById('rm-add-form');
        if (!form || !window.KB) return;

        var PR = {
            low:    ['Baixa', '#7a7a85', 'rgba(255,255,255,0.06)'],
            medium: ['Média', '#B884FF', 'rgba(184,132,255,0.14)'],
            high:   ['Alta',  '#ef4444', 'rgba(239,68,68,0.14)'],
        };
        var TRASH = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>';

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var titleInput = form.querySelector('[name=title]');
            if (!titleInput.value.trim()) return;

            fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': window.KB.CSRF, 'Accept': 'application/json' },
                body: new FormData(form)
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data.item) return;
                var it = data.item;
                var pr = PR[it.priority] || PR.medium;

                var card = document.createElement('div');
                card.className = 'kb-card';
                card.dataset.id = it.id;
                var delUrl = form.dataset.delBase.replace('__ID__', it.id);
                card.innerHTML =
                    '<div class="kb-card-title"></div>' +
                    (it.description ? '<div class="kb-card-body"></div>' : '') +
                    '<div class="kb-card-foot">' +
                        '<span class="kb-pill" style="color:' + pr[1] + ';background:' + pr[2] + ';">' + pr[0] + '</span>' +
                        '<button type="button" class="kb-del" data-del-url="' + delUrl + '" title="Remover">' + TRASH + '</button>' +
                    '</div>';
                card.querySelector('.kb-card-title').textContent = it.title;
                if (it.description) card.querySelector('.kb-card-body').textContent = it.description;

                var todo = document.querySelector('.kb-col[data-status="todo"]');
                var list = todo.querySelector('.kb-list');
                var empty = list.querySelector('.kb-empty');
                if (empty) empty.remove();
                list.insertBefore(card, list.firstChild);
                window.KB.bindCard(card);
                window.KB.recount(todo.closest('.kb-board'));

                titleInput.value = '';
                titleInput.focus();
            })
            .catch(function () {});
        });
    })();
</script>
@endpush

@push('styles')
<style>
    .rm-add { display: flex; gap: 10px; margin-bottom: 18px; }
    .rm-input { height: 44px; padding: 0 14px; background: var(--bg-2, #16181f); border: 1px solid var(--line-soft, rgba(255,255,255,0.1)); border-radius: 10px; color: var(--ink, #f0f0f3); font-family: inherit; font-size: 14px; outline: none; }
    .rm-input:focus { border-color: var(--purple, #B884FF); }
    .rm-add > .rm-input:first-child { flex: 1; }
    .rm-select { width: 130px; }
    .rm-btn { height: 44px; padding: 0 22px; background: linear-gradient(135deg, #a56bff, #7c3aed); border: none; border-radius: 10px; color: #fff; font-weight: 600; font-size: 14px; cursor: pointer; white-space: nowrap; }
    .rm-btn:hover { opacity: 0.92; }
</style>
@endpush
@endsection
