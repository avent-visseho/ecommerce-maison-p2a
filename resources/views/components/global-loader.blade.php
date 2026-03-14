{{-- Global Loader Component --}}
<div id="global-loader"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/90 backdrop-blur"
    style="display: none;">

    <div id="loader-content" class="flex flex-col items-center gap-4">

        {{-- Spinning gradient ring + ambient glow --}}
        <div class="relative flex items-center justify-center">
            <div class="absolute loader-glow"></div>
            <div class="relative loader-ring"></div>
        </div>

        {{-- Brand --}}
        <span class="loader-brand">La Maison</span>

        {{-- Bouncing dots --}}
        <div class="flex items-center gap-1.5">
            <div class="loader-dot"></div>
            <div class="loader-dot" style="animation-delay: 0.2s;"></div>
            <div class="loader-dot" style="animation-delay: 0.4s;"></div>
        </div>

        {{-- Context text --}}
        <p id="loader-text" class="text-xs font-medium text-neutral-400 tracking-wide">
            {{ __('common.loading') }}
        </p>
    </div>
</div>

<style>
    /* ── Visibility & backdrop ────────────────────── */
    #global-loader {
        opacity: 0;
        transition: opacity 0.35s ease;
    }

    #global-loader.show {
        display: flex !important;
        opacity: 1;
    }

    #global-loader.hide {
        opacity: 0;
        pointer-events: none;
    }

    /* ── Content entrance / exit ──────────────────── */
    #loader-content {
        opacity: 0;
        transform: translateY(8px);
        transition:
            opacity 0.4s ease 0.08s,
            transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.08s;
    }

    #global-loader.show #loader-content {
        opacity: 1;
        transform: translateY(0);
    }

    #global-loader.hide #loader-content {
        opacity: 0;
        transform: translateY(-4px);
        transition-delay: 0s;
    }

    /* ── Gradient ring (conic + mask) ─────────────── */
    .loader-ring {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: conic-gradient(
            from 0deg,
            transparent 0%,
            transparent 20%,
            #fde788 45%,
            #e8bf5e 65%,
            transparent 85%,
            transparent 100%
        );
        -webkit-mask: radial-gradient(
            farthest-side,
            transparent calc(100% - 3.5px),
            black calc(100% - 3.5px)
        );
        mask: radial-gradient(
            farthest-side,
            transparent calc(100% - 3.5px),
            black calc(100% - 3.5px)
        );
        animation: loader-spin 1.1s linear infinite;
    }

    @keyframes loader-spin {
        to { transform: rotate(360deg); }
    }

    /* ── Ambient glow behind the ring ─────────────── */
    .loader-glow {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: radial-gradient(
            circle,
            rgba(253, 231, 136, 0.4) 0%,
            rgba(232, 191, 94, 0.12) 50%,
            transparent 70%
        );
        animation: loader-glow-pulse 2.4s ease-in-out infinite;
    }

    @keyframes loader-glow-pulse {
        0%, 100% { opacity: 0.7; transform: scale(1); }
        50%      { opacity: 1;   transform: scale(1.18); }
    }

    /* ── Brand name ───────────────────────────────── */
    .loader-brand {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.24em;
        text-transform: uppercase;
        color: #b88a30;
    }

    /* ── Bouncing dots ────────────────────────────── */
    .loader-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #e8bf5e;
        animation: loader-dot-bounce 1.1s ease-in-out infinite;
    }

    @keyframes loader-dot-bounce {
        0%, 100% { transform: translateY(0);  opacity: 0.3; }
        50%      { transform: translateY(-5px); opacity: 1; }
    }
</style>

<script>
    (function () {
        const loader     = document.getElementById('global-loader');
        const loaderText = document.getElementById('loader-text');

        const texts = {
            default:  '{{ __("common.loading") }}',
            form:     '{{ __("common.processing") }}',
            navigate: '{{ __("common.loading_page") }}'
        };

        function showLoader(text = 'default') {
            loaderText.textContent = texts[text] || texts.default;
            loader.style.display = 'flex';
            void loader.offsetWidth; // force reflow → transitions kick in
            loader.classList.add('show');
        }

        function hideLoader() {
            loader.classList.add('hide');
            setTimeout(() => {
                loader.style.display = 'none';
                loader.classList.remove('show', 'hide');
            }, 420);
        }

        window.GlobalLoader = { show: showLoader, hide: hideLoader };

        /* ── Form submit ──────────────────────────── */
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.hasAttribute('data-no-loader'))                  return;
            if (form.action && form.action.includes('logout'))        return;
            showLoader('form');
        });

        /* ── Link click ───────────────────────────── */
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (!link)                                                return;
            if (link.hasAttribute('data-no-loader'))                  return;
            if (link.target === '_blank')                             return;

            const href = link.getAttribute('href');
            if (!href || href === '#' || href.startsWith('#'))        return;
            if (href.startsWith('javascript:'))                      return;
            if (href.startsWith('mailto:') || href.startsWith('tel:'))return;
            if (link.hasAttribute('download'))                       return;

            if (link.hasAttribute('@click') || link.hasAttribute('x-on:click')) {
                if (!href || href === '#')                           return;
            }

            showLoader('navigate');
        });

        /* ── Hide on page restore (back button) ───── */
        window.addEventListener('pageshow', function (e) {
            if (e.persisted) hideLoader();
        });

        /* ── Hide after initial load ──────────────── */
        window.addEventListener('load', function () {
            hideLoader();
        });
    })();
</script>
