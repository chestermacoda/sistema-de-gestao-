<div>

    {{--

    <button wire:click="$dispatch('abrir-configuracoes')">
        ⚙️ Configurações
    </button>


    --}}
    <!-- ===== OVERLAY ===== -->
    <div class="leitura-sheet-overlay"
        style="opacity: {{ $modalAberto ? '1' : '0' }}; visibility: {{ $modalAberto ? 'visible' : 'hidden' }};"
        wire:click="fecharModal">
    </div>

    <!-- ===== BOTTOM SHEET ===== -->
    <div class="leitura-sheet" id="modalConfig"
        style="transform: translateY({{ $modalAberto ? '0' : '100%' }}); max-height: 90vh;" x-data="{}"
        x-on:tema-alterado.window="aplicarTema($event.detail.tema)">

        <div class="leitura-sheet-handle"></div>

        <!-- Header -->
        <div class="leitura-sheet-header">
            <span class="leitura-sheet-title">Configurações</span>
            <button class="leitura-sheet-close" wire:click="fecharModal">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="18" x2="6" y1="6" y2="18" />
                    <line x1="6" x2="18" y1="6" y2="18" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="leitura-sheet-body">

            <!-- ===== NOTIFICAÇÕES ===== -->
            <div style="margin-bottom: var(--space-lg);">
                <h4 class="cfg-section-title">Notificações</h4>

                <div class="cfg-toggle-list">
                    <!-- Novas Leituras -->
                    <div class="cfg-toggle-item">
                        <div class="cfg-toggle-info">
                            <div class="cfg-toggle-title">Novas Leituras</div>
                            <div class="cfg-toggle-desc">Alerta quando houver novas leituras no roteiro</div>
                        </div>
                        <label class="cfg-toggle">
                            <input type="checkbox"
                                wire:click="atualizarToggle('notif_novas_leituras', !{{ $notif_novas_leituras ? 'true' : 'false' }})"
                                {{ $notif_novas_leituras ? 'checked' : '' }}>
                            <span class="cfg-toggle-slider"></span>
                        </label>
                    </div>

                    <!-- Anomalias -->
                    <div class="cfg-toggle-item">
                        <div class="cfg-toggle-info">
                            <div class="cfg-toggle-title">Anomalias</div>
                            <div class="cfg-toggle-desc">Notificar consumos fora da média</div>
                        </div>
                        <label class="cfg-toggle">
                            <input type="checkbox"
                                wire:click="atualizarToggle('notif_anomalias', !{{ $notif_anomalias ? 'true' : 'false' }})"
                                {{ $notif_anomalias ? 'checked' : '' }}>
                            <span class="cfg-toggle-slider"></span>
                        </label>
                    </div>

                    <!-- Sincronização -->
                    <div class="cfg-toggle-item">
                        <div class="cfg-toggle-info">
                            <div class="cfg-toggle-title">Sincronização</div>
                            <div class="cfg-toggle-desc">Aviso quando sincronizar com o servidor</div>
                        </div>
                        <label class="cfg-toggle">
                            <input type="checkbox"
                                wire:click="atualizarToggle('notif_sincronizacao', !{{ $notif_sincronizacao ? 'true' : 'false' }})"
                                {{ $notif_sincronizacao ? 'checked' : '' }}>
                            <span class="cfg-toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- ===== APARÊNCIA ===== -->
            <div style="margin-bottom: var(--space-lg);">
                <h4 class="cfg-section-title">Aparência</h4>

                <div class="cfg-theme-selector">
                    <div class="cfg-theme-option {{ $tema === 'claro' ? 'cfg-theme-active' : '' }}"
                        wire:click="alterarTema('claro')">
                        <div class="cfg-theme-preview cfg-theme-light"></div>
                        <span>Claro</span>
                    </div>
                    <div class="cfg-theme-option {{ $tema === 'escuro' ? 'cfg-theme-active' : '' }}"
                        wire:click="alterarTema('escuro')">
                        <div class="cfg-theme-preview cfg-theme-dark"></div>
                        <span>Escuro</span>
                    </div>
                    <div class="cfg-theme-option {{ $tema === 'auto' ? 'cfg-theme-active' : '' }}"
                        wire:click="alterarTema('auto')">
                        <div class="cfg-theme-preview cfg-theme-auto"></div>
                        <span>Auto</span>
                    </div>
                </div>
            </div>

            <!-- ===== DADOS E ARMAZENAMENTO ===== -->
            <div style="margin-bottom: var(--space-lg);">
                <h4 class="cfg-section-title">Dados e Armazenamento</h4>

                <div class="cfg-toggle-list">
                    <!-- Modo Offline -->
                    <div class="cfg-toggle-item">
                        <div class="cfg-toggle-info">
                            <div class="cfg-toggle-title">Modo Offline</div>
                            <div class="cfg-toggle-desc">Guardar leituras localmente sem internet</div>
                        </div>
                        <label class="cfg-toggle">
                            <input type="checkbox"
                                wire:click="atualizarToggle('modo_offline', !{{ $modo_offline ? 'true' : 'false' }})"
                                {{ $modo_offline ? 'checked' : '' }}>
                            <span class="cfg-toggle-slider"></span>
                        </label>
                    </div>

                    <!-- Fotos em Alta Resolução -->
                    <div class="cfg-toggle-item">
                        <div class="cfg-toggle-info">
                            <div class="cfg-toggle-title">Fotos em Alta Resolução</div>
                            <div class="cfg-toggle-desc">Qualidade máxima para fotos dos medidores</div>
                        </div>
                        <label class="cfg-toggle">
                            <input type="checkbox"
                                wire:click="atualizarToggle('fotos_alta_resolucao', !{{ $fotos_alta_resolucao ? 'true' : 'false' }})"
                                {{ $fotos_alta_resolucao ? 'checked' : '' }}>
                            <span class="cfg-toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Cache -->
                <div class="cfg-cache-box">
                    <div>
                        <div class="cfg-cache-title">Cache do Aplicativo</div>
                        <div class="cfg-cache-size">
                            {{ $cache_utilizado > 0 ? number_format($cache_utilizado / 1048576, 1) . ' MB' : '0 MB' }}
                            utilizados
                        </div>
                    </div>
                    <button class="cfg-btn-text" wire:click="limparCache" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="limparCache">Limpar</span>
                        <span wire:loading wire:target="limparCache">Limpando...</span>
                    </button>
                </div>
            </div>

            <!-- ===== BOTÃO SALVAR ===== -->
            <button class="mobile-btn-primary" wire:click="salvarTudo" wire:loading.attr="disabled">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                    <polyline points="17 21 17 13 7 13 7 21" />
                    <polyline points="7 3 7 8 15 8" />
                </svg>
                <span wire:loading.remove wire:target="salvarTudo">Salvar Configurações</span>
                <span wire:loading wire:target="salvarTudo">Salvando...</span>
            </button>
        </div>
    </div>

    <!-- ===== TOAST ===== -->
    @if ($toast)
        <div class="mobile-toast {{ $toastTipo }} show" x-data="{ show: true }" x-init="setTimeout(() => {
            show = false;
            $wire.set('toast', null);
        }, 3000)"
            x-show="show" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-full">
            @if ($toastTipo === 'success')
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
            @elseif ($toastTipo === 'error')
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" x2="9" y1="9" y2="15" />
                    <line x1="9" x2="15" y1="9" y2="15" />
                </svg>
            @endif
            {{ $toast }}
        </div>
    @endif

    <!-- ===== SCRIPT DO TEMA ===== -->
    @script
        <script>
            // Aplica o tema ao carregar a página
            document.addEventListener('DOMContentLoaded', function() {
                const temaSalvo = localStorage.getItem('aquanexus-tema') || 'claro';
                aplicarTema(temaSalvo);
            });

            // Listener do evento Livewire
            document.addEventListener('tema-alterado', function(e) {
                aplicarTema(e.detail.tema);
            });

            function aplicarTema(tema) {
                let temaFinal = tema;

                // Se for "auto", detecta preferência do sistema
                if (tema === 'auto') {
                    temaFinal = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'escuro' : 'claro';
                }

                // Salva no localStorage
                localStorage.setItem('aquanexus-tema', tema);

                // Aplica/remover classe dark no HTML
                const html = document.documentElement;

                if (temaFinal === 'escuro') {
                    html.classList.add('tema-escuro');
                } else {
                    html.classList.remove('tema-escuro');
                }

                // Atualiza meta theme-color para mobile
                const metaTheme = document.querySelector('meta[name="theme-color"]');
                if (metaTheme) {
                    metaTheme.setAttribute('content', temaFinal === 'escuro' ? '#0f172a' : '#003366');
                }
            }

            // Observa mudanças no prefers-color-scheme quando tema é "auto"
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                const temaAtual = localStorage.getItem('aquanexus-tema');
                if (temaAtual === 'auto') {
                    aplicarTema('auto');
                }
            });
        </script>
    @endscript
</div>
