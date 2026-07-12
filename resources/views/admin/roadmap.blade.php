@extends('layouts.dashboard')

@section('title', 'Roadmap')

@section('content')
@php
    $colColors = ['todo' => '#7a7a85', 'doing' => '#B884FF', 'done' => '#34d399'];
    $prColors = ['low' => ['Baixa', '#34d399', 'rgba(52,211,153,0.14)'], 'medium' => ['Média', '#eab308', 'rgba(234,179,8,0.14)'], 'high' => ['Alta', '#ef4444', 'rgba(239,68,68,0.14)']];
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
                    <div class="kb-card" data-id="{{ $item->id }}"
                         data-title="{{ $item->title }}"
                         data-description="{{ $item->description }}"
                         data-priority="{{ $item->priority }}">
                        <div class="kb-card-title">{{ $item->title }}</div>
                        @if($item->description)
                            <div class="kb-card-body">{{ \Illuminate\Support\Str::limit($item->description, 160) }}</div>
                        @endif
                        <div class="kb-card-foot">
                            <span class="kb-pill" style="color:{{ $pr[1] }};background:{{ $pr[2] }};">{{ $pr[0] }}</span>
                            <div class="kb-actions">
                                <button type="button" class="kb-edit" title="Editar">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                <button type="button" class="kb-del" data-del-url="{{ route('admin.roadmap.destroy', $item) }}" title="Remover">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="kb-empty">Vazio.</div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

{{-- Edit modal --}}
<div class="rm-modal" id="rm-edit-modal">
    <div class="rm-modal-bg" onclick="rmCloseEdit()"></div>
    <div class="rm-modal-box">
        <div class="rm-modal-head">
            <h3>Editar item</h3>
            <button type="button" class="rm-modal-x" onclick="rmCloseEdit()">&times;</button>
        </div>
        <form id="rm-edit-form">
            <label class="rm-label">Título</label>
            <input type="text" name="title" class="rm-input rm-full" required maxlength="255">
            <label class="rm-label">Descrição</label>
            <textarea name="description" class="rm-input rm-full rm-textarea" placeholder="Adiciona detalhes…" maxlength="5000"></textarea>
            <label class="rm-label">Prioridade</label>
            <select name="priority" class="rm-input rm-full">
                <option value="low">Baixa</option>
                <option value="medium">Média</option>
                <option value="high">Alta</option>
            </select>
            <div class="rm-modal-actions">
                <button type="button" class="rm-cancel" onclick="rmCloseEdit()">Cancelar</button>
                <button type="submit" class="rm-btn">Guardar</button>
            </div>
        </form>
    </div>
</div>

@include('admin.partials.kanban-assets')

@push('scripts')
<script>
    (function () {
        if (!window.KB) return;

        var PR = {
            low:    ['Baixa', '#34d399', 'rgba(52,211,153,0.14)'],
            medium: ['Média', '#eab308', 'rgba(234,179,8,0.14)'],
            high:   ['Alta',  '#ef4444', 'rgba(239,68,68,0.14)'],
        };
        var DEL_BASE = '{{ url('admin/roadmap/__ID__') }}';
        var EDIT = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>';
        var TRASH = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>';

        // Render a card's inner content + data attributes from an item.
        function renderCard(card, it) {
            var pr = PR[it.priority] || PR.medium;
            card.dataset.id = it.id;
            card.dataset.title = it.title;
            card.dataset.description = it.description || '';
            card.dataset.priority = it.priority;
            card.innerHTML =
                '<div class="kb-card-title"></div>' +
                (it.description ? '<div class="kb-card-body"></div>' : '') +
                '<div class="kb-card-foot">' +
                    '<span class="kb-pill" style="color:' + pr[1] + ';background:' + pr[2] + ';">' + pr[0] + '</span>' +
                    '<div class="kb-actions">' +
                        '<button type="button" class="kb-edit" title="Editar">' + EDIT + '</button>' +
                        '<button type="button" class="kb-del" data-del-url="' + DEL_BASE.replace('__ID__', it.id) + '" title="Remover">' + TRASH + '</button>' +
                    '</div>' +
                '</div>';
            card.querySelector('.kb-card-title').textContent = it.title;
            if (it.description) card.querySelector('.kb-card-body').textContent = it.description;
        }

        // ── Add ──
        var addForm = document.getElementById('rm-add-form');
        if (addForm) {
            addForm.addEventListener('submit', function (e) {
                e.preventDefault();
                var titleInput = addForm.querySelector('[name=title]');
                if (!titleInput.value.trim()) return;
                fetch(addForm.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': window.KB.CSRF, 'Accept': 'application/json' },
                    body: new FormData(addForm)
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (!data.item) return;
                    var card = document.createElement('div');
                    card.className = 'kb-card';
                    renderCard(card, data.item);
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
        }

        // ── Edit ──
        var editModal = document.getElementById('rm-edit-modal');
        var editForm = document.getElementById('rm-edit-form');
        var editing = null;

        window.rmCloseEdit = function () {
            editModal.classList.remove('open');
            editing = null;
        };

        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.kb-edit');
            if (!btn) return;
            editing = btn.closest('.kb-card');
            editForm.querySelector('[name=title]').value = editing.dataset.title || '';
            editForm.querySelector('[name=description]').value = editing.dataset.description || '';
            editForm.querySelector('[name=priority]').value = editing.dataset.priority || 'medium';
            editModal.classList.add('open');
            editForm.querySelector('[name=title]').focus();
        });

        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!editing) return;
            var payload = {
                title: editForm.querySelector('[name=title]').value,
                description: editForm.querySelector('[name=description]').value,
                priority: editForm.querySelector('[name=priority]').value,
            };
            fetch(DEL_BASE.replace('__ID__', editing.dataset.id), {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.KB.CSRF, 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.item) renderCard(editing, data.item);
                window.rmCloseEdit();
            })
            .catch(function () {});
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && editModal.classList.contains('open')) window.rmCloseEdit();
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

    .kb-actions { display: flex; align-items: center; gap: 4px; }
    .kb-edit { background: none; border: none; color: var(--ink-mute, #7a7a85); cursor: pointer; padding: 3px; border-radius: 6px; display: inline-flex; }
    .kb-edit:hover { color: var(--purple, #B884FF); }

    /* Edit modal */
    .rm-modal { display: none; position: fixed; inset: 0; z-index: 100; align-items: center; justify-content: center; padding: 20px; }
    .rm-modal.open { display: flex; }
    .rm-modal-bg { position: absolute; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(2px); }
    .rm-modal-box { position: relative; width: 100%; max-width: 460px; background: var(--bg-2, #16181f); border: 1px solid var(--line-soft, rgba(255,255,255,0.1)); border-radius: 18px; padding: 22px 24px; box-shadow: 0 24px 60px rgba(0,0,0,0.5); }
    .rm-modal-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .rm-modal-head h3 { font-size: 16px; font-weight: 600; }
    .rm-modal-x { background: none; border: none; color: var(--ink-mute, #7a7a85); font-size: 24px; line-height: 1; cursor: pointer; }
    .rm-modal-x:hover { color: var(--ink, #fff); }
    .rm-label { display: block; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--ink-mute, #7a7a85); margin: 12px 0 6px; }
    .rm-full { width: 100%; box-sizing: border-box; }
    .rm-textarea { min-height: 110px; padding: 12px 14px; resize: vertical; line-height: 1.5; }
    .rm-modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .rm-cancel { height: 44px; padding: 0 20px; background: var(--bg-3, #1d2029); border: 1px solid var(--line-soft, rgba(255,255,255,0.1)); border-radius: 10px; color: var(--ink-dim, #a9a9b3); font-weight: 600; font-size: 14px; cursor: pointer; }
    .rm-cancel:hover { color: var(--ink, #fff); }
</style>
@endpush
@endsection
