{{--
    partials/toast.blade.php
    Global toast notification system — reads from session flash data.
    Include this partial in every layout, just before </body>.
--}}
<style>
/* ── TOAST SYSTEM ─────────────────────────────── */
#toast-container {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    pointer-events: none;
    max-width: 360px;
    width: calc(100vw - 48px);
}
.toast-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: #1e1a30;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,.45), 0 2px 8px rgba(0,0,0,.25);
    pointer-events: all;
    animation: toastIn .36s cubic-bezier(.4,0,.2,1) forwards;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(16px);
    min-width: 260px;
}
.toast-item::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    border-radius: 4px 0 0 4px;
}
.toast-item.toast-success::before { background: #22c55e; }
.toast-item.toast-error::before   { background: #ef4444; }
.toast-item.toast-warning::before { background: #f59e0b; }
.toast-item.toast-info::before    { background: #3b82f6; }
.toast-icon {
    width: 34px; height: 34px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.toast-success .toast-icon { background: rgba(34,197,94,.15); color: #22c55e; }
.toast-error   .toast-icon { background: rgba(239,68,68,.15);  color: #ef4444; }
.toast-warning .toast-icon { background: rgba(245,158,11,.15); color: #f59e0b; }
.toast-info    .toast-icon { background: rgba(59,130,246,.15); color: #3b82f6; }
.toast-body {
    flex: 1;
    min-width: 0;
}
.toast-title {
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 2px;
    letter-spacing: .01em;
}
.toast-msg {
    font-size: 12.5px;
    color: rgba(255,255,255,.65);
    line-height: 1.5;
    word-break: break-word;
}
.toast-close {
    background: none;
    border: none;
    color: rgba(255,255,255,.35);
    font-size: 14px;
    cursor: pointer;
    padding: 2px 4px;
    border-radius: 6px;
    flex-shrink: 0;
    transition: color .15s, background .15s;
    align-self: flex-start;
    margin-top: -2px;
}
.toast-close:hover { color: #fff; background: rgba(255,255,255,.08); }
.toast-progress {
    position: absolute;
    bottom: 0; left: 0;
    height: 3px;
    border-radius: 0 0 14px 14px;
    animation: toastProgress linear forwards;
}
.toast-success .toast-progress { background: #22c55e; }
.toast-error   .toast-progress { background: #ef4444; }
.toast-warning .toast-progress { background: #f59e0b; }
.toast-info    .toast-progress { background: #3b82f6; }
.toast-item.toast-out {
    animation: toastOut .3s cubic-bezier(.4,0,.2,1) forwards;
}
@keyframes toastIn {
    from { opacity: 0; transform: translateX(40px) scale(.95); }
    to   { opacity: 1; transform: translateX(0)    scale(1);   }
}
@keyframes toastOut {
    from { opacity: 1; transform: translateX(0)    scale(1);   max-height: 120px; margin-bottom: 0; }
    to   { opacity: 0; transform: translateX(40px) scale(.95); max-height: 0;     margin-bottom: -10px; padding: 0; }
}
@keyframes toastProgress {
    from { width: 100%; }
    to   { width: 0; }
}
@media (max-width: 480px) {
    #toast-container {
        bottom: 16px;
        right: 12px;
        left: 12px;
        width: auto;
        max-width: 100%;
    }
}
</style>

<div id="toast-container" aria-live="polite" aria-atomic="false"></div>

<script>
(function() {
    var DURATION = 5000; // ms

    function iconFor(type) {
        return {
            success: '<i class="fa-solid fa-circle-check"></i>',
            error:   '<i class="fa-solid fa-circle-xmark"></i>',
            warning: '<i class="fa-solid fa-triangle-exclamation"></i>',
            info:    '<i class="fa-solid fa-circle-info"></i>',
        }[type] || '<i class="fa-solid fa-bell"></i>';
    }

    function titleFor(type) {
        return {
            success: '{{ __("messages.toast_success") }}',
            error:   '{{ __("messages.toast_error") }}',
            warning: '{{ __("messages.toast_warning") }}',
            info:    '{{ __("messages.toast_info") }}',
        }[type] || 'Notification';
    }

    window.showToast = function(msg, type, duration) {
        type = type || 'info';
        duration = duration || DURATION;
        var container = document.getElementById('toast-container');
        var item = document.createElement('div');
        item.className = 'toast-item toast-' + type;
        item.innerHTML =
            '<div class="toast-icon">' + iconFor(type) + '</div>' +
            '<div class="toast-body">' +
                '<div class="toast-title">' + titleFor(type) + '</div>' +
                '<div class="toast-msg">' + msg + '</div>' +
            '</div>' +
            '<button class="toast-close" aria-label="Fermer">&#x2715;</button>' +
            '<div class="toast-progress" style="animation-duration:' + duration + 'ms;"></div>';

        container.appendChild(item);

        var closeBtn = item.querySelector('.toast-close');
        function dismiss() {
            item.classList.add('toast-out');
            setTimeout(function() { if (item.parentNode) item.parentNode.removeChild(item); }, 320);
        }
        closeBtn.addEventListener('click', dismiss);
        setTimeout(dismiss, duration);
    };

    // Show server-side flash messages on page load
    @if(session('success'))
        window.addEventListener('DOMContentLoaded', function() {
            showToast(@json(session('success')), 'success');
        });
    @endif
    @if(session('error'))
        window.addEventListener('DOMContentLoaded', function() {
            showToast(@json(session('error')), 'error');
        });
    @endif
    @if(session('warning'))
        window.addEventListener('DOMContentLoaded', function() {
            showToast(@json(session('warning')), 'warning');
        });
    @endif
    @if(session('info'))
        window.addEventListener('DOMContentLoaded', function() {
            showToast(@json(session('info')), 'info');
        });
    @endif
    @if($errors->any())
        window.addEventListener('DOMContentLoaded', function() {
            @foreach($errors->all() as $err)
                showToast(@json($err), 'error');
            @endforeach
        });
    @endif
})();
</script>
