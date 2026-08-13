@extends('admin.Layout.layouts')

@section('content')
    <div class="page-content">
        <!-- Page Header -->
        <div class="page-header">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <h1 class="page-title">Leituras</h1>
                    <p class="page-subtitle">Registro e acompanhamento de leituras de hidrômetros</p>
                </div>
                <div style="display: flex; gap: var(--space-sm);">
                    <button class="btn btn-outline" onclick="openModal('modal-roteiro')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                        </svg>
                        Roteiro
                    </button>
                    <button class="btn btn-outline" onclick="openModal('modal-importar-leituras')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="17 8 12 3 7 8" />
                            <line x1="12" x2="12" y1="3" y2="15" />
                        </svg>
                        Importar
                    </button>
                    <button class="btn btn-primary" onclick="openModal('modal-nova-leitura')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                        Nova Leitura
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid" style="margin-bottom: var(--space-xl);">

            <!-- CARD 1: Total de Leituras do Mês -->
            <div class="stat-card">
                <div class="stat-icon primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" x2="8" y1="13" y2="13" />
                        <line x1="16" x2="8" y1="17" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">
                        {{ number_format($this->totalLeiturasMes, 0, ',', '.') }}
                    </div>
                    <div class="stat-label">
                        Leituras {{ $this->getMesAtualFormatado() }}
                    </div>
                    <div class="stat-change {{ $this->variacaoLeituras >= 0 ? 'positive' : 'negative' }}">
                        @if ($this->variacaoLeituras > 0)
                            +{{ number_format($this->variacaoLeituras, 1, ',', '.') }}% vs mês anterior
                        @elseif($this->variacaoLeituras < 0)
                            {{ number_format($this->variacaoLeituras, 1, ',', '.') }}% vs mês anterior
                        @else
                            Sem variação vs mês anterior
                        @endif
                    </div>
                </div>
            </div>

            <!-- CARD 2: Leituras OK -->
            <div class="stat-card">
                <div class="stat-icon success">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">
                        {{ number_format($this->leiturasOk, 0, ',', '.') }}
                    </div>
                    <div class="stat-label">Leituras OK</div>
                    <div class="stat-change positive">
                        {{ $this->percentualOk }}% do total
                    </div>
                </div>
            </div>

            <!-- CARD 3: Leituras Pendentes -->
            <div class="stat-card">
                <div class="stat-icon warning">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">
                        {{ number_format($this->leiturasPendentes, 0, ',', '.') }}
                    </div>
                    <div class="stat-label">Pendentes</div>
                    <div class="stat-change {{ $this->percentualPendentes > 10 ? 'negative' : 'warning' }}">
                        {{ $this->percentualPendentes }}% dos instalados
                    </div>
                </div>
            </div>

            <!-- CARD 4: Anomalias -->
            <div class="stat-card">
                <div class="stat-icon danger">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="m15 9-6 6" />
                        <path d="m9 9 6 6" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">
                        {{ number_format($this->totalAnomalias, 0, ',', '.') }}
                    </div>
                    <div class="stat-label">Anomalias</div>
                    <div class="stat-change negative">
                        {{ $this->percentualAnomalias }}% das leituras
                    </div>

                    <!-- Detalhamento das anomalias (opcional, mostra se hover ou expandir) -->
                    @if (count($this->detalheAnomalias) > 0)
                        <div style="margin-top: 8px; font-size: 0.625rem; color: var(--text-muted);">
                            @foreach ($this->detalheAnomalias as $tipo => $qtd)
                                <span style="display: inline-block; margin-right: 8px;">
                                    {{ $tipo ?? 'Não classificada' }}: {{ $qtd }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Filters Bar -->
        <livewire:admin.leituras.show-leituras />
    </div>

    <!-- ============================================ -->
    <!-- MODAL: VER LEITURA (Detalhes Completos)     -->
    <!-- ============================================ -->
    <livewire:admin.leituras.ver-leituraespecifica />
    <!-- ============================================ -->
    <!-- MODAL: NOVA LEITURA                         -->
    <!-- ============================================ -->
    <livewire:admin.leituras.create />

    <!-- ============================================ -->
    <!-- MODAL: TRATAR ANOMALIA                      -->
    <!-- ============================================ -->
    <livewire:admin.leituras.editar-leitura />

    <!-- ============================================ -->
    <!-- MODAL: IMPORTAR LEITURAS                    -->
    <!-- ============================================ -->
    <livewire:admin.leituras.importarleituras />
    <!-- Toast Container -->
    <div id="toast-container"
        style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: var(--space-sm);">
    </div>
    <script>
        // Close modal on overlay click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                    modal.classList.remove('active');
                });
                document.body.style.overflow = '';
            }
        });

        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }

        // Tab switching - Leituras
        function switchTabLeit(btn, tabId) {
            document.querySelectorAll('.tabs .tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
        }

        // Tab switching - Importar
        function switchTabImport(btn, tabId) {
            document.querySelectorAll('#modal-importar .tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.tab-content-import').forEach(c => c.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }

        // // Actions
        // function registrarLeitura() {
        //     alert('Leitura registrada com sucesso!\\n\\nConsumo: 50 m³ — Status: OK');
        //     closeModal('modal-nova-leitura');
        // }

        // function salvarEdicaoLeitura() {
        //     alert('Leitura editada com sucesso!\\n\\nFatura recalculada e cliente notificado.');
        //     closeModal('modal-editar-leitura');
        // }

        // function tratarAnomalia() {
        //     alert('Anomalia resolvida!\\n\\nLeitura validada e fatura gerada com consumo corrigido.');
        //     closeModal('modal-anomalia');
        // }

        // function validarLeitura() {
        //     alert('Leitura validada com sucesso!\\n\\nStatus alterado para OK.');
        // }

        // function importarLeituras() {
        //     alert('Importação concluída!\\n\\n245 leituras importadas com sucesso.\\n3 anomalias detectadas para revisão.');
        //     closeModal('modal-importar');
        // }
    </script>
@endsection
