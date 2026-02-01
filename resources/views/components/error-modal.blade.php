{{-- Modal d'erreur global avec Alpine.js --}}
<div x-data="errorModal()" x-init="init()" x-cloak>
    {{-- Overlay --}}
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[9999]"
         @click="close()">
    </div>

    {{-- Modal --}}
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[10000] flex items-center justify-center p-4"
         @click.self="close()">

        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden" @click.stop>
            {{-- Header avec icône --}}
            <div class="p-6 text-center" :class="getHeaderClass()">
                {{-- Icône d'erreur --}}
                <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-4" :class="getIconBgClass()">
                    {{-- Erreur --}}
                    <template x-if="type === 'error'">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </template>
                    {{-- Succès --}}
                    <template x-if="type === 'success'">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </template>
                    {{-- Warning --}}
                    <template x-if="type === 'warning'">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </template>
                    {{-- Info --}}
                    <template x-if="type === 'info'">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                </div>

                {{-- Titre --}}
                <h3 class="text-xl font-bold text-neutral-900" x-text="title"></h3>
            </div>

            {{-- Message --}}
            <div class="px-6 pb-6">
                <p class="text-neutral-600 text-center" x-text="message"></p>
            </div>

            {{-- Boutons --}}
            <div class="px-6 pb-6 flex flex-col sm:flex-row gap-3 justify-center">
                <button @click="close()"
                        class="px-6 py-3 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium rounded-xl transition-colors">
                    {{ __('errors.close') }}
                </button>
                <template x-if="showRetry">
                    <button @click="retry()"
                            class="px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-xl transition-colors">
                        {{ __('errors.try_again') }}
                    </button>
                </template>
                <template x-if="showHome">
                    <a href="{{ route('home') }}"
                       class="px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-xl transition-colors text-center">
                        {{ __('errors.go_home') }}
                    </a>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
    function errorModal() {
        return {
            show: false,
            type: 'error',
            title: '',
            message: '',
            showRetry: false,
            showHome: false,

            init() {
                // Écouter les erreurs de session
                @if(session('modal_error'))
                    this.showError(
                        '{{ session('modal_error.title', __('errors.error_occurred')) }}',
                        '{{ session('modal_error.message', __('errors.generic')) }}',
                        {{ session('modal_error.showRetry', false) ? 'true' : 'false' }},
                        {{ session('modal_error.showHome', false) ? 'true' : 'false' }}
                    );
                @endif

                @if(session('modal_success'))
                    this.showSuccess(
                        '{{ session('modal_success.title', __('errors.success')) }}',
                        '{{ session('modal_success.message', '') }}'
                    );
                @endif

                @if(session('modal_warning'))
                    this.showWarning(
                        '{{ session('modal_warning.title', __('errors.warning')) }}',
                        '{{ session('modal_warning.message', '') }}'
                    );
                @endif

                // Écouter les événements JavaScript globaux
                window.addEventListener('show-error-modal', (e) => {
                    this.showError(e.detail.title, e.detail.message, e.detail.showRetry, e.detail.showHome);
                });

                window.addEventListener('show-success-modal', (e) => {
                    this.showSuccess(e.detail.title, e.detail.message);
                });
            },

            showError(title, message, showRetry = false, showHome = false) {
                this.type = 'error';
                this.title = title || '{{ __('errors.error_occurred') }}';
                this.message = message || '{{ __('errors.generic') }}';
                this.showRetry = showRetry;
                this.showHome = showHome;
                this.show = true;
            },

            showSuccess(title, message) {
                this.type = 'success';
                this.title = title || '{{ __('errors.success') }}';
                this.message = message;
                this.showRetry = false;
                this.showHome = false;
                this.show = true;
            },

            showWarning(title, message) {
                this.type = 'warning';
                this.title = title || '{{ __('errors.warning') }}';
                this.message = message;
                this.showRetry = false;
                this.showHome = false;
                this.show = true;
            },

            close() {
                this.show = false;
            },

            retry() {
                this.close();
                window.location.reload();
            },

            getHeaderClass() {
                return '';
            },

            getIconBgClass() {
                const classes = {
                    'error': 'bg-red-100',
                    'success': 'bg-green-100',
                    'warning': 'bg-yellow-100',
                    'info': 'bg-blue-100'
                };
                return classes[this.type] || 'bg-red-100';
            }
        };
    }
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
