<div>

    <!-- ========== FILTERS BAR ========== -->
    <div class="card" style="padding: var(--space-md) var(--space-lg); margin-bottom: var(--space-lg);">
        <div style="display: flex; gap: var(--space-md); align-items: center; flex-wrap: wrap;">

            <div style="position: relative; flex: 1; min-width: 250px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" class="form-input" wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por cliente, medidor, leiturista..." style="padding-left: 2.5rem;">
            </div>

            <select class="form-select" wire:model.live="statusFilter" style="width: auto; min-width: 160px;">
                <option value="">Todos os Status</option>
                <option value="validada">OK</option>
                <option value="Pendente">Pendente</option>
                <option value="anomalia">Anomalia</option>
                <option value="Processando">Processando</option>
            </select>

            <select class="form-select" wire:model.live="mesFilter" style="width: auto; min-width: 160px;">
                <option value="">Todos os Meses</option>
                @foreach ($this->mesesDisponiveis as $valor => $label)
                    <option value="{{ $valor }}">{{ $label }}</option>
                @endforeach
            </select>

            <select class="form-select" wire:model.live="leituristaFilter" style="width: auto; min-width: 160px;">
                <option value="">Todos os Leituristas</option>
                @foreach ($this->leituristas as $leiturista)
                    <option value="{{ $leiturista->id }}">{{ $leiturista->name }}</option>
                @endforeach
            </select>

            <button class="btn btn-outline btn-sm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="margin-right: 6px;">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" x2="12" y1="15" y2="3" />
                </svg>
                Exportar
            </button>
        </div>
    </div>

    <!-- ========== TABS ========== -->
    <div class="tabs" style="margin-bottom: var(--space-lg);">
        <button class="tab {{ $tabAtiva === 'todas' ? 'active' : '' }}" wire:click="setTab('todas')">
            Todas as Leituras
        </button>
        <button class="tab {{ $tabAtiva === 'ok' ? 'active' : '' }}" wire:click="setTab('ok')">
            OK
        </button>
        <button class="tab {{ $tabAtiva === 'pendente' ? 'active' : '' }}" wire:click="setTab('pendente')">
            Pendentes
        </button>
        <button class="tab {{ $tabAtiva === 'anomalias' ? 'active' : '' }}" wire:click="setTab('anomalias')">
            Anomalias
        </button>
    </div>

    <!-- ========== GRID UNIFICADO ========== -->
    <div class="leit-grid" style="margin-bottom: var(--space-xl);">

        @forelse($this->registrosPaginados as $registro)
            @php
                $status = $this->getStatusRegistro($registro);
                $cliente = $this->getClienteInfo($registro);
                $dados = $this->getDadosExibicao($registro);
                $acoes = $this->getAcoes($registro);
            @endphp

            <div class="leit-card {{ $status['class'] }}" wire:key="{{ $registro['id'] }}">
                <div class="leit-card-header">
                    <div>
                        <div class="leit-mes-ref">{{ $dados['mes_ref'] }}</div>
                        <div class="leit-cliente">{{ $cliente['nome'] }}</div>
                    </div>
                    <span class="leit-status-badge {{ $status['badgeClass'] }}">{{ $status['text'] }}</span>
                </div>
                <div class="leit-body">
                    <div class="leit-info-row">
                        <span class="leit-info-label">Hidrômetro</span>
                        <span class="leit-info-value"
                            style="font-family: monospace;">{{ $cliente['hidrometro'] }}</span>
                    </div>
                    <div class="leit-info-row">
                        <span class="leit-info-label">Matrícula</span>
                        <span class="leit-info-value"
                            style="font-family: monospace;">{{ $cliente['matricula'] }}</span>
                    </div>
                    <div class="leit-info-row">
                        <span class="leit-info-label">Leiturista</span>
                        <span class="leit-info-value">{{ $dados['leiturista'] }}</span>
                    </div>
                    <div class="leit-info-row">
                        <span class="leit-info-label">
                            {{ $registro['tipo'] === 'pendente' ? 'Data Prevista' : 'Data Leitura' }}
                        </span>
                        <span class="leit-info-value">{{ $dados['data_leitura'] }}</span>
                    </div>
                    <div class="leit-leitura-box" style="{{ $dados['box_style'] }}">
                        <div class="leit-leitura-valor" style="{{ $dados['valor_color'] }}">
                            {{ $dados['leitura_atual'] ? number_format($dados['leitura_atual'], 0, ',', '.') . ' m³' : '—' }}
                        </div>
                        <div class="leit-leitura-label" style="{{ $dados['label_color'] }}">
                            {{ $dados['label_text'] }}
                        </div>
                    </div>
                    <!-- Barra de Progresso -->
                    <div class="leit-consumo-bar" data-percentual="{{ $dados['percentual_consumo'] ?? 0 }}%">
                        <div class="leit-consumo-fill {{ $dados['bar_color_class'] }}"
                            style="width: {{ $dados['bar_width'] }}; {{ $dados['bar_style'] }}">
                        </div>
                    </div>

                    <!-- Info de Consumo -->
                    <div class="leit-consumo-info">
                        @if ($registro['tipo'] === 'pendente')
                            <span>Consumo: —</span>
                        @elseif($registro['dados']->tem_anomalia)
                            <span style="color: var(--danger); font-weight: 600;">
                                Consumo: {{ $dados['consumo_formatado'] }} m³
                                ({{ $dados['percentual_consumo'] > 100 ? '+' : '' }}{{ number_format($dados['percentual_consumo'] - 100, 0) }}%)
                            </span>
                        @else
                            <span>
                                Consumo: {{ $dados['consumo_formatado'] }} m³
                                @if ($dados['percentual_consumo'] > 100)
                                    <span
                                        style="color: var(--warning);">({{ number_format($dados['percentual_consumo'] - 100, 0) }}%
                                        acima)</span>
                                @elseif($dados['percentual_consumo'] < 50)
                                    <span
                                        style="color: var(--success);">({{ number_format(100 - $dados['percentual_consumo'], 0) }}%
                                        abaixo)</span>
                                @endif
                            </span>
                        @endif
                        <span>Média: {{ $dados['media_formatada'] }} m³</span>
                    </div>
                </div>
                <div class="leit-footer">
                    <span class="leit-data">{{ $dados['registrado'] }}</span>
                    <div style="display: flex; gap: var(--space-xs);">
                        @if (in_array('ver', $acoes) && $registro['tipo'] != 'pendente')
                            <button class="btn btn-sm btn-ghost"
                                wire:click="$dispatch('ver-leitura', { idCliente: {{ $cliente['cliente_id'] }}, idMedidor: {{ $cliente['Medidor_id'] }},idLeitura: {{ $cliente['idLeitura'] }} })"
                                onclick="openModal('modal-ver-leitura')" title="Detalhes">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        @endif
                        @if (in_array('editar', $acoes) && $registro['tipo'] != 'pendente')
                            <button class="btn btn-sm btn-ghost"
                                wire:click="$dispatch('editar-leitura', { idCliente: {{ $cliente['cliente_id'] }}, idMedidor: {{ $cliente['Medidor_id'] }},idLeitura: {{ $cliente['idLeitura'] }} })"
                                onclick="openModal('modal-editar-leitura')" title="Editar">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                </svg>
                            </button>
                        @endif
                        @if (in_array('registrar', $acoes))
                            <button class="btn btn-sm btn-ghost" onclick="openModal('modal-nova-leitura')"
                                title="Registrar Leitura">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>
                            </button>
                        @endif
                        @if (in_array('tratar', $acoes))
                            <button class="btn btn-sm btn-ghost"
                                wire:click="$dispatch('editar-leitura', { idCliente: {{ $cliente['cliente_id'] }}, idMedidor: {{ $cliente['Medidor_id'] }},idLeitura: {{ $cliente['idLeitura'] }} })"
                                onclick="openModal('modal-anomalia')" title="Tratar Anomalia">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                    <line x1="12" x2="12" y1="9" y2="13" />
                                    <line x1="12" x2="12.01" y1="17" y2="17" />
                                </svg>
                            </button>
                        @endif
                        @if (in_array('validar', $acoes))
                            <button class="btn btn-sm btn-ghost" onclick="validarLeitura()" title="Validar">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M20 6 9 17l-5-5" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1" style="margin: 0 auto 16px; opacity: 0.4;">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <p style="font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Nenhum registro encontrado
                </p>
                <p style="font-size: var(--small-size);">
                    @if ($search || $statusFilter || $mesFilter || $leituristaFilter)
                        Tente ajustar os filtros de busca
                        <br>
                        <button
                            wire:click="$set('search', ''); $set('statusFilter', ''); $set('mesFilter', ''); $set('leituristaFilter', '')"
                            class="btn btn-primary" style="margin-top: 16px;">
                            Limpar filtros
                        </button>
                    @else
                        Não há registros para este período
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    <!-- ========== PAGINATION ========== -->
    {{-- @if ($this->registrosPaginados->hasPages())
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-xl);">
            <span style="font-size: var(--small-size); color: var(--text-muted);">
                Página {{ $this->registrosPaginados->currentPage() }} de {{ $this->registrosPaginados->lastPage() }}
            </span>
            <div style="display: flex; gap: var(--space-xs);">
                {{ $this->registrosPaginados->links() }}
            </div>
        </div>
    @endif --}}

    @include('admin.components.pagination', ['paginator' => $this->registrosPaginados])
</div>
