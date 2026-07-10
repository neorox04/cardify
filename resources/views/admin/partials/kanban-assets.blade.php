@push('styles')
<style>
    .kb-board { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; align-items: start; }
    .kb-col { background: var(--bg-2, #16181f); border: 1px solid var(--line-soft, rgba(255,255,255,0.08)); border-radius: 16px; padding: 14px; min-height: 160px; transition: border-color .15s, background .15s; }
    .kb-col.kb-over { border-color: var(--purple, #B884FF); background: oklch(0.72 0.19 300 / 0.05); }
    .kb-col-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; padding: 0 4px; }
    .kb-col-title { font-size: 12px; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase; color: var(--ink-dim, #a9a9b3); display: flex; align-items: center; gap: 8px; }
    .kb-dot { width: 8px; height: 8px; border-radius: 999px; }
    .kb-count { font-size: 11px; font-weight: 600; color: var(--ink-mute, #7a7a85); background: var(--bg-3, rgba(255,255,255,0.05)); padding: 1px 8px; border-radius: 999px; }
    .kb-list { display: flex; flex-direction: column; gap: 10px; min-height: 40px; }
    .kb-card { background: var(--bg-3, #1d2029); border: 1px solid var(--line-soft, rgba(255,255,255,0.08)); border-radius: 12px; padding: 13px 14px; cursor: grab; transition: transform .1s, box-shadow .15s, border-color .15s; }
    .kb-card:hover { border-color: var(--line, rgba(255,255,255,0.18)); }
    .kb-card.kb-dragging { opacity: 0.5; cursor: grabbing; }
    .kb-card:active { cursor: grabbing; }
    .kb-card-title { font-size: 14px; font-weight: 600; margin-bottom: 4px; }
    .kb-card-meta { font-size: 11.5px; color: var(--ink-mute, #7a7a85); }
    .kb-card-body { font-size: 12.5px; color: var(--ink-dim, #a9a9b3); margin-top: 8px; line-height: 1.5; }
    .kb-card-foot { display: flex; align-items: center; justify-content: space-between; margin-top: 10px; }
    .kb-pill { font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 999px; }
    .kb-del { background: none; border: none; color: var(--ink-mute, #7a7a85); cursor: pointer; padding: 3px; border-radius: 6px; display: inline-flex; }
    .kb-del:hover { color: #ef4444; }
    .kb-empty { font-size: 12px; color: var(--ink-mute, #7a7a85); text-align: center; padding: 16px 8px; }
    @media (max-width: 820px) { .kb-board { grid-template-columns: 1fr; } }
</style>
@endpush

@push('scripts')
<script>
    (function () {
        var CSRF = '{{ csrf_token() }}';
        var dragId = null;

        function bindCards() {
            document.querySelectorAll('.kb-card').forEach(function (card) {
                card.setAttribute('draggable', 'true');
                card.addEventListener('dragstart', function (e) {
                    dragId = card.dataset.id;
                    card.classList.add('kb-dragging');
                    e.dataTransfer.effectAllowed = 'move';
                });
                card.addEventListener('dragend', function () {
                    dragId = null;
                    card.classList.remove('kb-dragging');
                });
            });
        }

        function recount(board) {
            board.querySelectorAll('.kb-col').forEach(function (col) {
                var badge = col.querySelector('.kb-count');
                if (badge) badge.textContent = col.querySelectorAll('.kb-card').length;
            });
        }

        document.querySelectorAll('.kb-col').forEach(function (col) {
            var list = col.querySelector('.kb-list');
            col.addEventListener('dragover', function (e) { e.preventDefault(); col.classList.add('kb-over'); });
            col.addEventListener('dragleave', function () { col.classList.remove('kb-over'); });
            col.addEventListener('drop', function (e) {
                e.preventDefault();
                col.classList.remove('kb-over');
                if (!dragId) return;
                var card = document.querySelector('.kb-card[data-id="' + dragId + '"]');
                if (!card) return;
                var board = col.closest('.kb-board');
                var status = col.dataset.status;
                var empty = list.querySelector('.kb-empty');
                if (empty) empty.remove();
                list.appendChild(card);
                recount(board);

                fetch(board.dataset.url.replace('__ID__', dragId), {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                    body: JSON.stringify({ status: status })
                }).catch(function () {});
            });
        });

        bindCards();
    })();
</script>
@endpush
