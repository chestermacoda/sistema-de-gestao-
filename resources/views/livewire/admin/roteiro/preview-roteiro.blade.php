<div>
    <div class="modal-overlay" id="modal-preview" wire:ignore.self>
        <style>
            /* ─── Header Icon ─── */
            .roteiro-header-icon {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--primary), var(--primary-light));
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
            }

            /* ─── Status Badge ─── */
            .rot-status-badge {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 4px 12px;
                border-radius: var(--radius-full);
                font-size: var(--small-size);
                font-weight: 600;
            }



            .rot-em-andamento {
                background: rgba(0, 131, 143, 0.1);
                color: var(--tertiary);
            }

            .rot-concluido {
                background: var(--success-light);
                color: var(--success);
            }

            .rot-nao-lido {
                background: var(--neutral-dark);
                color: var(--text-secondary);
            }

            .rot-problema {
                background: var(--danger-light);
                color: var(--danger);
            }

            /* ─── Resumo Grid ─── */
            .roteiro-resumo-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: var(--space-md);
                margin-bottom: var(--space-xl);
            }

            .roteiro-resumo-card {
                background: var(--neutral);
                border-radius: var(--radius-md);
                padding: var(--space-lg);
                text-align: center;
                transition: all 0.2s;
            }

            .roteiro-resumo-card:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
            }

            .roteiro-resumo-label {
                font-size: var(--small-size);
                color: var(--text-muted);
                margin-bottom: 4px;
            }

            .roteiro-resumo-valor {
                font-size: 1.5rem;
                font-weight: 700;
                font-family: var(--font-headline);
            }

            /* ─── Progresso ─── */
            .roteiro-progresso-section {
                margin-bottom: var(--space-xl);
                padding: var(--space-lg);
                background: var(--neutral);
                border-radius: var(--radius-lg);
            }

            .roteiro-progresso-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: var(--space-sm);
                font-size: var(--label-size);
                font-weight: 600;
                color: var(--text-primary);
            }

            .roteiro-progresso-pct {
                color: var(--primary);
                font-family: var(--font-headline);
            }

            .roteiro-progresso-barra-bg {
                width: 100%;
                height: 10px;
                background: var(--neutral-dark);
                border-radius: var(--radius-full);
                overflow: hidden;
                margin-bottom: var(--space-sm);
            }

            .roteiro-progresso-barra-fill {
                height: 100%;
                background: linear-gradient(90deg, var(--success) 0%, var(--tertiary) 50%, var(--primary) 100%);
                border-radius: var(--radius-full);
                transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .roteiro-progresso-meta {
                display: flex;
                gap: var(--space-md);
                font-size: var(--small-size);
                color: var(--text-secondary);
            }

            .roteiro-meta-destaque {
                color: var(--warning);
                font-weight: 600;
            }

            .roteiro-meta-problema {
                color: var(--danger);
                font-weight: 600;
            }

            /* ─── Filtros ─── */
            .roteiro-filtros {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: var(--space-md);
                margin-bottom: var(--space-lg);
                flex-wrap: wrap;
            }

            .roteiro-filtro-group {
                display: flex;
                gap: var(--space-xs);
                flex-wrap: wrap;
            }

            .roteiro-filtro-btn {
                padding: 6px 14px;
                border: 1px solid var(--neutral-dark);
                border-radius: var(--radius-full);
                background: var(--white);
                color: var(--text-secondary);
                font-size: var(--small-size);
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
            }

            .roteiro-filtro-btn:hover {
                border-color: var(--primary-lighter);
                color: var(--primary);
            }

            .roteiro-filtro-btn.active {
                background: var(--primary);
                color: white;
                border-color: var(--primary);
            }

            .roteiro-busca {
                display: flex;
                align-items: center;
                gap: var(--space-sm);
                padding: var(--space-sm) var(--space-md);
                background: var(--white);
                border: 1px solid var(--neutral-dark);
                border-radius: var(--radius-full);
                min-width: 280px;
            }

            .roteiro-busca svg {
                color: var(--text-muted);
                flex-shrink: 0;
            }

            .roteiro-busca input {
                border: none;
                background: none;
                outline: none;
                font-size: var(--label-size);
                color: var(--text-primary);
                width: 100%;
            }

            .roteiro-busca input::placeholder {
                color: var(--text-muted);
            }

            /* ─── Lista de Medidores ─── */
            .roteiro-lista-count {
                margin-left: var(--space-sm);
                font-size: var(--small-size);
                color: var(--text-muted);
                font-weight: 400;
                background: var(--neutral);
                padding: 2px 8px;
                border-radius: var(--radius-full);
            }

            .rot-roteiro-item-preview {
                display: flex;
                align-items: flex-start;
                gap: var(--space-md);
                padding: var(--space-md);
                border-radius: var(--radius-md);
                margin-bottom: var(--space-sm);
                transition: all 0.2s;
                border-left: 3px solid transparent;
            }

            .rot-roteiro-item-preview:hover {
                box-shadow: var(--shadow-sm);
                transform: translateX(2px);
            }

            .rot-roteiro-item-preview.rot-ok {
                background: var(--success-light);
                border-left-color: var(--success);
            }

            .rot-roteiro-item-preview.rot-pendente {
                background: var(--warning-light);
                border-left-color: var(--warning);
            }

            .rot-roteiro-item-preview.rot-anomalia {
                background: rgba(220, 38, 38, 0.05);
                border-left-color: var(--danger);
            }

            .rot-roteiro-item-preview.rot-nao-lido {
                background: var(--neutral);
                border-left-color: var(--neutral-darker);
            }

            .rot-roteiro-item-preview.rot-problema {
                background: var(--danger-light);
                border-left-color: var(--danger);
            }

            .rot-roteiro-numero {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: var(--white);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: var(--small-size);
                font-weight: 700;
                color: var(--text-primary);
                flex-shrink: 0;
                margin-top: 2px;
            }

            .rot-roteiro-info-preview {
                flex: 1;
                min-width: 0;
            }

            .rot-roteiro-endereco-preview {
                font-size: var(--label-size);
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 2px;
            }

            .rot-roteiro-medidor-preview {
                font-size: var(--small-size);
                color: var(--text-muted);
                margin-bottom: var(--space-xs);
            }

            .rot-roteiro-leitura {
                display: flex;
                gap: var(--space-md);
                font-size: var(--small-size);
                margin-top: var(--space-xs);
            }

            .rot-roteiro-consumo {
                color: var(--tertiary);
                font-weight: 600;
            }

            .rot-roteiro-data {
                color: var(--text-muted);
            }

            .rot-roteiro-obs {
                margin-top: var(--space-xs);
                padding: var(--space-xs) var(--space-sm);
                background: rgba(255, 255, 255, 0.6);
                border-radius: var(--radius-sm);
                font-size: var(--small-size);
                color: var(--text-secondary);
                font-style: italic;
            }

            .rot-roteiro-status-preview {
                padding: 4px 10px;
                border-radius: var(--radius-full);
                font-size: 11px;
                font-weight: 600;
                text-transform: uppercase;
                flex-shrink: 0;
            }

            .rot-roteiro-status-preview.rot-ok {
                background: var(--success);
                color: white;
            }

            .rot-roteiro-status-preview.rot-pendente {
                background: var(--warning);
                color: white;
            }

            .rot-roteiro-status-preview.rot-anomalia {
                background: var(--danger);
                color: white;
            }

            .rot-roteiro-status-preview.rot-nao-lido {
                background: var(--neutral-darker);
                color: var(--text-secondary);
            }

            .rot-roteiro-status-preview.rot-problema {
                background: var(--danger);
                color: white;
            }

            /* ─── Timeline ─── */
            .roteiro-timeline-section {
                margin-top: var(--space-xl);
            }

            .roteiro-timeline-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: var(--label-size);
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: var(--space-md);
            }

            .roteiro-timeline-toggle {
                background: none;
                border: none;
                cursor: pointer;
                color: var(--text-muted);
                padding: 4px;
            }

            .rot-timeline {
                position: relative;
                padding-left: var(--space-lg);
            }

            .rot-timeline::before {
                content: '';
                position: absolute;
                left: 7px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: var(--neutral-dark);
            }

            .rot-timeline-item {
                position: relative;
                padding-bottom: var(--space-lg);
            }

            .rot-timeline-dot {
                position: absolute;
                left: -25px;
                top: 4px;
                width: 14px;
                height: 14px;
                border-radius: 50%;
                background: var(--neutral-dark);
                border: 2px solid var(--white);
                box-shadow: 0 0 0 2px var(--neutral-dark);
            }

            .rot-timeline-item.rot-ok .rot-timeline-dot {
                background: var(--success);
                box-shadow: 0 0 0 2px var(--success);
            }

            .rot-timeline-item.rot-anomalia .rot-timeline-dot {
                background: var(--danger);
                box-shadow: 0 0 0 2px var(--danger);
            }

            .rot-timeline-content {
                background: var(--neutral);
                padding: var(--space-md);
                border-radius: var(--radius-md);
            }

            .rot-timeline-title {
                font-size: var(--label-size);
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 2px;
            }

            .rot-timeline-desc {
                font-size: var(--small-size);
                color: var(--text-secondary);
                margin-bottom: var(--space-xs);
            }

            .rot-timeline-date {
                font-size: 11px;
                color: var(--text-muted);
            }

            /* ─── Empty State ─── */
            .roteiro-empty {
                text-align: center;
                padding: var(--space-2xl) var(--space-lg);
                color: var(--text-muted);
            }

            .roteiro-empty h4 {
                color: var(--text-primary);
                margin: var(--space-md) 0 var(--space-sm);
                font-size: var(--body-size);
            }

            .roteiro-empty p {
                font-size: var(--label-size);
            }

            /* ─── Responsividade ─── */
            @media (max-width: 640px) {
                .roteiro-resumo-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .roteiro-filtros {
                    flex-direction: column;
                    align-items: stretch;
                }

                .roteiro-filtro-group {
                    justify-content: center;
                }

                .roteiro-busca {
                    min-width: auto;
                }

                .rot-roteiro-item-preview {
                    flex-direction: column;
                    gap: var(--space-sm);
                }

                .rot-roteiro-status-preview {
                    align-self: flex-start;
                }
            }

            /* ─── Print Styles ─── */
            @media print {
                .modal-overlay {
                    position: static;
                    background: white;
                }

                .modal {
                    box-shadow: none;
                    max-width: 100%;
                    height: auto;
                }

                .modal-header,
                .modal-footer,
                .roteiro-filtros,
                .roteiro-timeline-toggle {
                    display: none !important;
                }

                .rot-roteiro-item-preview {
                    break-inside: avoid;
                }
            }
        </style>
        <div class="modal modal-lg" style="max-width: 900px; max-height: 92vh; display: flex; flex-direction: column;">

            @if ($userId)
                <!-- HEADER -->
                <div class="modal-header" style="flex-shrink: 0;">
                    <div style="display: flex; align-items: center; gap: var(--space-md);">
                        <div class="roteiro-header-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="modal-title">Pré-visualização do Roteiro</h3>
                            <p class="modal-subtitle">
                                {{ $roteiro['zona'] ?? 'Zona N/A' }} — {{ $roteiro['mes_ano'] ?? 'N/A' }} —
                                {{ $leiturista['nome'] ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <div style="display: flex; gap: var(--space-sm); align-items: center;">
                        <span
                            class="rot-status-badge rot-{{ strtolower(str_replace(' ', '-', $roteiro['status'] ?? 'pendente')) }}">
                            ● {{ $roteiro['status'] ?? 'Pendente' }}
                        </span>
                        <button class="modal-close" onclick="closeModal('modal-preview')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- CONTEÚDO COM SCROLL -->
                <div class="modal-body" style="flex: 1; overflow-y: auto;">

                    <!-- Cards de Resumo -->
                    <div class="roteiro-resumo-grid">
                        <div class="roteiro-resumo-card">
                            <div class="roteiro-resumo-label">Total</div>
                            <div class="roteiro-resumo-valor" style="color: var(--primary);">{{ $resumo['total'] }}
                            </div>
                        </div>
                        <div class="roteiro-resumo-card">
                            <div class="roteiro-resumo-label">OK</div>
                            <div class="roteiro-resumo-valor" style="color: var(--success);">{{ $resumo['ok'] }}</div>
                        </div>
                        <div class="roteiro-resumo-card">
                            <div class="roteiro-resumo-label">Pendentes</div>
                            <div class="roteiro-resumo-valor" style="color: var(--warning);">{{ $resumo['nao_lidos'] }}
                            </div>
                        </div>
                        <div class="roteiro-resumo-card">
                            <div class="roteiro-resumo-label">Anomalias</div>
                            <div class="roteiro-resumo-valor" style="color: var(--danger);">{{ $resumo['anomalias'] }}
                            </div>
                        </div>
                    </div>

                    <!-- Barra de Progresso -->
                    <div class="roteiro-progresso-section">
                        <div class="roteiro-progresso-header">
                            <span>Progresso do Roteiro</span>
                            <span class="roteiro-progresso-pct">{{ $resumo['percentual'] }}%</span>
                        </div>
                        <div class="roteiro-progresso-barra-bg">
                            <div class="roteiro-progresso-barra-fill" style="width: {{ $resumo['percentual'] }}%;">
                            </div>
                        </div>
                        <div class="roteiro-progresso-meta">
                            <span>{{ $resumo['ok'] + $resumo['anomalias'] }} de {{ $resumo['total'] }} medidores
                                lidos</span>
                            @if ($resumo['nao_lidos'] > 0)
                                <span class="roteiro-meta-destaque">{{ $resumo['nao_lidos'] }} não lidos</span>
                            @endif
                            @if ($resumo['problemas'] > 0)
                                <span class="roteiro-meta-problema">{{ $resumo['problemas'] }} problemas</span>
                            @endif
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="roteiro-filtros">
                        <div class="roteiro-filtro-group">
                            <button type="button"
                                class="roteiro-filtro-btn {{ $filtroStatus === 'todos' ? 'active' : '' }}"
                                wire:click="$set('filtroStatus', 'todos')">
                                Todos ({{ $resumo['total'] }})
                            </button>
                            <button type="button"
                                class="roteiro-filtro-btn {{ $filtroStatus === 'ok' ? 'active' : '' }}"
                                wire:click="$set('filtroStatus', 'ok')">
                                OK ({{ $resumo['ok'] }})
                            </button>
                            <button type="button"
                                class="roteiro-filtro-btn {{ $filtroStatus === 'pendente' ? 'active' : '' }}"
                                wire:click="$set('filtroStatus', 'pendente')">
                                Pendentes ({{ $resumo['pendentes'] }})
                            </button>
                            <button type="button"
                                class="roteiro-filtro-btn {{ $filtroStatus === 'anomalia' ? 'active' : '' }}"
                                wire:click="$set('filtroStatus', 'anomalia')">
                                Anomalias ({{ $resumo['anomalias'] }})
                            </button>
                            <button type="button"
                                class="roteiro-filtro-btn {{ $filtroStatus === 'nao-lido' ? 'active' : '' }}"
                                wire:click="$set('filtroStatus', 'nao-lido')">
                                Não Lidos ({{ $resumo['nao_lidos'] }})
                            </button>
                        </div>
                        <div class="roteiro-busca">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            <input type="text" wire:model.live.debounce.300ms="busca"
                                placeholder="Buscar cliente, endereço, medidor...">
                        </div>
                    </div>

                    <!-- Lista de Medidores -->
                    <div class="rot-roteiro-preview">
                        <div class="rot-roteiro-preview-header">
                            <div style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary);">
                                Lista de Medidores
                                <span class="roteiro-lista-count">{{ count($this->itensFiltrados) }} item(ns)</span>
                            </div>
                            <div style="display: flex; gap: var(--space-sm);">
                                <button class="btn btn-sm btn-outline" wire:click="exportarPDF">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" x2="12" y1="15" y2="3" />
                                    </svg>
                                    Exportar
                                </button>
                                <button class="btn btn-sm btn-primary" wire:click='print_faturas'
                                    {{-- onclick="openModal('modal-editar-roteiros')" --}}>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 6 2 18 2 18 9" />
                                        <path
                                            d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                        <rect width="12" height="8" x="6" y="14" />
                                    </svg>
                                    Imprimir
                                </button>
                            </div>
                        </div>

                        <div class="rot-roteiro-lista">
                            @forelse($this->itensFiltrados as $item)
                                <div
                                    class="rot-roteiro-item-preview rot-{{ strtolower(str_replace(' ', '-', $item['status'])) }}">
                                    <div class="rot-roteiro-numero">{{ $item['ordem'] }}</div>
                                    <div class="rot-roteiro-info-preview">
                                        <div class="rot-roteiro-endereco-preview">{{ $item['endereco'] }}</div>
                                        <div class="rot-roteiro-medidor-preview">
                                            {{ $item['medidor'] }} — {{ $item['matricula'] }} —
                                            {{ $item['cliente_nome'] }}
                                        </div>
                                        @if ($item['leitura_atual'] !== null)
                                            <div class="rot-roteiro-leitura">
                                                <span>Leitura:
                                                    <strong>{{ number_format($item['leitura_atual'], 2, ',', '.') }}
                                                        m³</strong></span>
                                                @if ($item['consumo'] !== null)
                                                    <span class="rot-roteiro-consumo">Consumo:
                                                        {{ number_format($item['consumo'], 2, ',', '.') }} m³</span>
                                                @endif
                                                @if ($item['lido_em'])
                                                    <span class="rot-roteiro-data">{{ $item['lido_em'] }}</span>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($item['observacoes'])
                                            <div class="rot-roteiro-obs">{{ $item['observacoes'] }}</div>
                                        @endif
                                    </div>
                                    <span
                                        class="rot-roteiro-status-preview rot-{{ strtolower(str_replace(' ', '-', $item['status'])) }}">
                                        {{ $item['status'] }}
                                    </span>
                                </div>
                            @empty
                                <div class="roteiro-empty">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    <h4>Nenhum item encontrado</h4>
                                    <p>Tente ajustar os filtros ou a busca.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Timeline do Roteiro -->
                    @if ($mostrarTimeline && !empty($timeline))
                        <div class="roteiro-timeline-section">
                            <div class="roteiro-timeline-header">
                                <span>Timeline do Roteiro</span>
                                <button type="button" class="roteiro-timeline-toggle"
                                    wire:click="$toggle('mostrarTimeline')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="m18 15-6-6-6 6" />
                                    </svg>
                                </button>
                            </div>
                            <div class="rot-timeline">
                                @foreach ($timeline as $evento)
                                    <div
                                        class="rot-timeline-item rot-{{ strtolower(str_replace(' ', '-', $evento['status'])) }}">
                                        <div class="rot-timeline-dot"></div>
                                        <div class="rot-timeline-content">
                                            <div class="rot-timeline-title">{{ $evento['titulo'] }}</div>
                                            <div class="rot-timeline-desc">{{ $evento['descricao'] }}</div>
                                            <div class="rot-timeline-date">{{ $evento['data'] }} —
                                                {{ $evento['autor'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- FOOTER -->
                <div class="modal-footer" style="flex-shrink: 0;">
                    <button class="btn btn-outline" onclick="closeModal('modal-preview')">Fechar</button>
                    <button class="btn btn-secondary" wire:click="exportarPDF">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="margin-right: 6px;">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" x2="12" y1="15" y2="3" />
                        </svg>
                        Exportar PDF
                    </button>
                    <button class="btn btn-primary" wire:click="enviarParaApp">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="margin-right: 6px;">
                            <rect width="14" height="20" x="5" y="2" rx="2" ry="2" />
                            <path d="M12 18h.01" />
                        </svg>
                        Enviar para App
                    </button>
                </div>
            @else
                <!-- Estado Vazio -->
                <div class="modal-body empty-state" style="flex: 1;">
                    <div class="empty-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                        </svg>
                    </div>
                    <h4>Nenhum roteiro selecionado</h4>
                    <p>Selecione um roteiro na lista para visualizar os detalhes.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MODAL: EDITAR ROTEIRO                       -->
    <!-- ============================================ -->
    <div class="modal-overlay" id="modal-editar-roteiros">
        <div class="modal" style="max-width: 600px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--warning); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Visualizar Faturas</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Zona Norte
                            — Maio/2026</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-editar-roteiros')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                @if ($verFaturas)
                    <iframe src="{{ asset('pdfs/' . $relatorio['filename']) }}" width="100%" height="600px">
                    </iframe>
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-editar-roteiros')">Cancelar</button>

                <button class="btn btn-primary" onclick="salvarEdicaoRoteiro()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                    </svg>
                    Salvar Alterações
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ESTILOS -->
