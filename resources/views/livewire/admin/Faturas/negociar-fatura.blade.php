<div class="modal-overlay" id="modal-negociar-fatura" wire:ignore.self>
    <style>
        /* ============================================
            MODAL DE NEGOCIAÇÃO DE FATURA
            ============================================ */

        /* Header da fatura com todos os detalhes */
        .fatura-header-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-lg);
            padding: var(--space-lg);
            margin: var(--space-md) var(--space-lg) 0;
            color: var(--white);
            box-shadow: var(--shadow-lg);
        }

        .fatura-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--space-md);
            flex-wrap: wrap;
            gap: var(--space-sm);
        }

        .fatura-header-info {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }

        .fatura-codigo {
            font-family: monospace;
            font-size: var(--label-size);
            background: rgba(255, 255, 255, 0.15);
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            font-weight: 600;
        }

        .fatura-cliente {
            display: flex;
            align-items: center;
            gap: var(--space-xs);
            font-size: var(--small-size);
            color: rgba(255, 255, 255, 0.8);
            margin-top: var(--space-xs);
        }

        .fatura-cliente svg {
            opacity: 0.7;
        }

        /* Grid de detalhes financeiros */
        .fatura-detalhes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--space-sm);
            margin-bottom: var(--space-md);
        }

        .detalhe-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-md);
            padding: var(--space-sm) var(--space-md);
            display: flex;
            flex-direction: column;
            gap: 4px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.2s ease;
        }

        .detalhe-item:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .detalhe-item.atrasado {
            background: rgba(220, 38, 38, 0.2);
            border-color: rgba(220, 38, 38, 0.3);
        }

        .detalhe-item.atrasado:hover {
            background: rgba(220, 38, 38, 0.25);
        }

        .detalhe-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: var(--small-size);
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }

        .detalhe-label svg {
            opacity: 0.6;
            flex-shrink: 0;
        }

        .detalhe-valor {
            font-size: var(--body-size);
            font-weight: 700;
            color: var(--white);
            font-family: 'Inter', monospace;
        }

        .detalhe-valor .text-danger {
            color: #fca5a5;
        }

        .detalhe-valor .text-success {
            color: #86efac;
        }

        /* Valor original destacado */
        .fatura-valor-original {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: var(--space-md);
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            font-size: var(--label-size);
            color: rgba(255, 255, 255, 0.8);
        }

        .fatura-valor-original .valor-destaque {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--white);
            font-family: 'Inter', monospace;
        }

        /* Resumo da negociação */
        .resumo-negociacao {
            background: linear-gradient(135deg, var(--primary-50, #f0f7ff) 0%, var(--success-50, #f0fdf4) 100%);
            border: 1px solid var(--primary-200, #bfdbfe);
            border-radius: var(--radius-md);
            padding: var(--space-md);
            margin: var(--space-md) 0;
        }

        .resumo-titulo {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            font-weight: 700;
            color: var(--primary);
            margin-bottom: var(--space-md);
            padding-bottom: var(--space-sm);
            border-bottom: 1px solid var(--primary-200, #bfdbfe);
            font-size: var(--label-size);
        }

        .resumo-linha {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-sm);
            font-size: var(--body-size);
            color: var(--text-secondary);
        }

        .resumo-linha span:first-child {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .resumo-linha span:first-child svg {
            color: var(--success);
            flex-shrink: 0;
        }

        .resumo-linha span:last-child {
            font-family: 'Inter', monospace;
            font-weight: 600;
            color: var(--text-primary);
        }

        .resumo-linha.isencao {
            color: var(--success);
        }

        .resumo-linha.isencao span:last-child {
            color: var(--success);
            font-weight: 700;
        }

        .resumo-linha.desconto {
            color: var(--success);
        }

        .resumo-linha.desconto span:last-child {
            color: var(--success);
            font-weight: 700;
        }

        .resumo-linha.total {
            padding-top: var(--space-sm);
            border-top: 2px solid var(--primary-200, #bfdbfe);
            margin-top: var(--space-sm);
            font-size: 1.1rem;
        }

        .resumo-linha.total span:first-child {
            font-weight: 700;
            color: var(--text-primary);
        }

        .resumo-linha.total span:last-child {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
        }

        .resumo-parcelas {
            text-align: center;
            margin-top: var(--space-md);
            padding-top: var(--space-md);
            border-top: 1px dashed var(--primary-200, #bfdbfe);
            font-size: var(--body-size);
            color: var(--text-secondary);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-xs);
        }

        .resumo-parcelas svg {
            color: var(--tertiary);
        }

        .resumo-parcelas strong {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .resumo-parcelas small {
            color: var(--text-muted);
            font-size: var(--small-size);
        }

        /* Checkbox customizado */
        .checkbox-boleto {
            background: var(--neutral);
            border-radius: var(--radius-md);
            padding: var(--space-md);
            margin-top: var(--space-md);
        }

        .checkbox-boleto label {
            display: flex;
            align-items: flex-start;
            gap: var(--space-sm);
            cursor: pointer;
            font-size: var(--label-size);
            color: var(--text-primary);
            line-height: 1.5;
        }

        .checkbox-boleto input[type="checkbox"] {
            accent-color: var(--primary);
            width: 18px;
            height: 18px;
            margin-top: 2px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .checkbox-boleto .checkbox-text strong {
            color: var(--primary);
        }

        /* Estado vazio */
        .estado-vazio {
            text-align: center;
            padding: var(--space-xl);
            color: var(--text-muted);
        }

        .estado-vazio svg {
            margin-bottom: var(--space-md);
            opacity: 0.5;
        }

        /* Utilitários de texto */
        .text-danger {
            color: var(--danger) !important;
        }

        .text-success {
            color: var(--success) !important;
        }

        /* Animações */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fatura-header-card,
        .resumo-negociacao {
            animation: fadeInUp 0.3s ease-out;
        }

        /* Responsividade */
        @media (max-width: 640px) {
            .fatura-detalhes-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .fatura-header-top {
                flex-direction: column;
            }

            .fatura-valor-original {
                flex-direction: column;
                gap: var(--space-sm);
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .fatura-detalhes-grid {
                grid-template-columns: 1fr;
            }

            .fatura-header-card {
                margin: var(--space-sm);
                padding: var(--space-md);
            }

            .resumo-linha {
                flex-direction: column;
                align-items: flex-start;
                gap: 2px;
            }
        }
    </style>
    <div class="modal" style="max-width: 680px;">
        <div class="modal-header">
            <div style="display: flex; align-items: center; gap: var(--space-md);">
                <div
                    style="
                    width: 40px; height: 40px; border-radius: var(--radius-md);
                    background: var(--tertiary); display: flex;
                    align-items: center; justify-content: center; color: white;
                ">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </div>
                <div>
                    <h3 class="modal-title">Negociar Fatura</h3>
                    <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                        Defina os termos da negociação
                    </p>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('modal-negociar-fatura')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        <div>
            @if ($faturaId)
                {{-- Header com dados da fatura --}}
                <div class="fatura-header-card">
                    <div class="fatura-header-top">
                        <div class="fatura-header-info">
                            <span class="fatura-codigo">{{ $fatura['codigo'] }}</span>
                            <span class="badge badge-{{ $fatura['status'] === 'Vencida' ? 'danger' : 'warning' }}">
                                {{ $fatura['status'] }}
                            </span>
                        </div>
                        <div class="fatura-cliente">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            {{ $cliente['nome'] }} — Matrícula: {{ $cliente['matricula'] }}
                        </div>
                    </div>

                    {{-- Grid de detalhes financeiros --}}
                    <div class="fatura-detalhes-grid">
                        {{-- Valor Base --}}
                        <div class="detalhe-item">
                            <span class="detalhe-label">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                                Valor Base
                            </span>
                            <span class="detalhe-valor">MZN
                                {{ number_format($fatura['valor_base'] ?? $valorOriginal, 2, ',', '.') }}</span>
                        </div>

                        {{-- Consumo --}}
                        <div class="detalhe-item">
                            <span class="detalhe-label">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                </svg>
                                Consumo
                            </span>
                            <span class="detalhe-valor">{{ $fatura['consumo_m3'] ?? 0 }} m³</span>
                        </div>

                        {{-- Dias em Atraso --}}
                        <div class="detalhe-item {{ ($fatura['dias_atraso'] ?? 0) > 0 ? 'atrasado' : '' }}">
                            <span class="detalhe-label">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                Dias em Atraso
                            </span>
                            <span class="detalhe-valor">
                                @if (($fatura['dias_atraso'] ?? 0) > 0)
                                    <span class="text-danger">{{ $fatura['dias_atraso'] }} dias</span>
                                @else
                                    <span class="text-success">Em dia</span>
                                @endif
                            </span>
                        </div>

                        {{-- Multa por Atraso --}}
                        <div class="detalhe-item {{ ($fatura['multa_atual'] ?? 0) > 0 ? 'atrasado' : '' }}">
                            <span class="detalhe-label">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                    <line x1="12" y1="9" x2="12" y2="13" />
                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                </svg>
                                Multa por Atraso
                            </span>
                            <span class="detalhe-valor">
                                @if (($fatura['multa_atual'] ?? 0) > 0)
                                    <span class="text-danger">+ MZN
                                        {{ number_format($fatura['multa_atual'], 2, ',', '.') }}</span>
                                @else
                                    MZN 0,00
                                @endif
                            </span>
                        </div>

                        {{-- Juros --}}
                        <div class="detalhe-item {{ ($fatura['juros_atual'] ?? 0) > 0 ? 'atrasado' : '' }}">
                            <span class="detalhe-label">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                                    <polyline points="17 6 23 6 23 12" />
                                </svg>
                                Juros ({{ $fatura['meses_atraso'] ?? 0 }}x 10%)
                            </span>
                            <span class="detalhe-valor">
                                @if (($fatura['juros_atual'] ?? 0) > 0)
                                    <span class="text-danger">+ MZN
                                        {{ number_format($fatura['juros_atual'], 2, ',', '.') }}</span>
                                @else
                                    MZN 0,00
                                @endif
                            </span>
                        </div>

                        {{-- Desconto Aplicado --}}
                        <div class="detalhe-item">
                            <span class="detalhe-label">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <line x1="19" y1="5" x2="5" y2="19" />
                                    <circle cx="6.5" cy="6.5" r="2.5" />
                                    <circle cx="17.5" cy="17.5" r="2.5" />
                                </svg>
                                Desconto Aplicado
                            </span>
                            <span class="detalhe-valor text-success">
                                - MZN {{ number_format($fatura['desconto'] ?? 0, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Valor Original Total (com acréscimos) --}}
                    <div class="fatura-valor-original">
                        <span>Valor Original Atualizado</span>
                        <span class="valor-destaque">MZN {{ number_format($valorOriginal, 2, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Formulário --}}
                <div class="modal-body">
                    {{-- Tipo de Negociação --}}
                    <div class="form-group">
                        <label class="form-label">Tipo de Negociação *</label>
                        <select class="form-select" wire:model.live="tipoNegociacao" required>
                            <option value="">Selecione...</option>
                            <option value="Parcelar">Parcelamento</option>
                            <option value="Isenção de Juros/Multas">Isenção de Juros/Multas</option>
                        </select>
                        @error('tipoNegociacao')
                            <span style="color: var(--danger)">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Valor e Desconto --}}
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Valor com Desconto *</label>
                            <input type="number" class="form-input"
                                wire:model.live.debounce.300ms="valorComDesconto" step="0.01" min="1">
                            @error('valorComDesconto')
                                <span style="color: var(--danger)">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Percentual de Desconto</label>
                            <input type="number" class="form-input"
                                wire:model.live.debounce.300ms="percentualDesconto" placeholder="0%" min="0"
                                max="100" step="0.1">
                            @error('percentualDesconto')
                                <span style="color: var(--danger)">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Parcelas --}}
                    <div class="form-group">
                        <label class="form-label">Número de Parcelas</label>
                        <select class="form-select" wire:model.live="quantidadeParcelas">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }}x
                                    {{ $i > 1 ? 'de MZN ' . number_format($valorFinal / $i, 2, ',', '.') : 'à vista' }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- Nova Data de Vencimento --}}
                    <div class="form-group">
                        <label class="form-label">Nova Data de Vencimento</label>
                        <input type="date" class="form-input" wire:model="novaDataVencimento"
                            min="{{ now()->format('Y-m-d') }}">
                    </div>

                    {{-- Resumo do cálculo --}}
                    @if ($valorFinal > 0)
                        <div class="resumo-negociacao">
                            <div class="resumo-titulo">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="16" y1="13" x2="8" y2="13" />
                                    <line x1="16" y1="17" x2="8" y2="17" />
                                    <polyline points="10 9 9 9 8 9" />
                                </svg>
                                Resumo da Negociação
                            </div>

                            <div class="resumo-linha">
                                <span>Valor Original Atualizado</span>
                                <span>MZN {{ number_format($valorOriginal, 2, ',', '.') }}</span>
                            </div>

                            @if ($tipoNegociacao === 'Isenção de Juros/Multas' && ($fatura['multa_atual'] ?? 0) + ($fatura['juros_atual'] ?? 0) > 0)
                                <div class="resumo-linha isencao">
                                    <span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                            <polyline points="22 4 12 14.01 9 11.01" />
                                        </svg>
                                        Isenção de Multa + Juros
                                    </span>
                                    <span class="text-success">
                                        - MZN
                                        {{ number_format(($fatura['multa_atual'] ?? 0) + ($fatura['juros_atual'] ?? 0), 2, ',', '.') }}
                                    </span>
                                </div>
                            @endif

                            @if ($economia > 0)
                                <div class="resumo-linha desconto">
                                    <span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <line x1="19" y1="5" x2="5" y2="19" />
                                            <circle cx="6.5" cy="6.5" r="2.5" />
                                            <circle cx="17.5" cy="17.5" r="2.5" />
                                        </svg>
                                        Desconto Adicional
                                    </span>
                                    <span class="text-success">
                                        - MZN {{ number_format($economia, 2, ',', '.') }}
                                    </span>
                                </div>
                            @endif

                            <div class="resumo-linha total">
                                <span>Valor Final</span>
                                <span>MZN {{ number_format($valorFinal, 2, ',', '.') }}</span>
                            </div>

                            @if ($quantidadeParcelas > 1)
                                <div class="resumo-parcelas">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="1" y="4" width="22" height="16" rx="2"
                                            ry="2" />
                                        <line x1="1" y1="10" x2="23" y2="10" />
                                    </svg>
                                    {{ $quantidadeParcelas }} parcelas de
                                    <strong>MZN
                                        {{ number_format($valorFinal / $quantidadeParcelas, 2, ',', '.') }}</strong>
                                    @if ($novaDataVencimento)
                                        <br><small>1ª vencimento em
                                            {{ \Carbon\Carbon::parse($novaDataVencimento)->format('d/m/Y') }}</small>
                                    @endif
                                </div>
                            @elseif($quantidadeParcelas == 1 && $novaDataVencimento)
                                <div class="resumo-parcelas">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="1" y="4" width="22" height="16" rx="2"
                                            ry="2" />
                                        <line x1="1" y1="10" x2="23" y2="10" />
                                    </svg>
                                    Pagamento à vista — Vencimento em
                                    {{ \Carbon\Carbon::parse($novaDataVencimento)->format('d/m/Y') }}
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Observações --}}
                    <div class="form-group">
                        <label class="form-label">Justificativa / Observações</label>
                        <textarea class="form-textarea" wire:model="observacoes" placeholder="Descreva o motivo da negociação..."
                            rows="3"></textarea>
                    </div>

                    {{-- Checkbox boleto --}}
                    <div class="checkbox-boleto">
                        <label>
                            <input type="checkbox" wire:model="gerarNovoBoleto">
                            <span class="checkmark"></span>
                            <span class="checkbox-text">
                                <strong>Gerar novo boleto</strong> — Substituir o boleto original pelo negociado
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button class="btn btn-outline" onclick="closeModal('modal-negociar-fatura')">Cancelar</button>
                    <button class="btn btn-primary" wire:click="confirmarNegociacao" wire:loading.attr="disabled">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="margin-right: 6px;">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                        Confirmar Negociação
                        <span wire:loading wire:target="confirmarNegociacao" style="margin-left: 8px;">
                            <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" stroke-dasharray="60"
                                    stroke-dashoffset="20" />
                            </svg>
                        </span>
                    </button>
                </div>
            @else
                {{-- Estado vazio --}}
                <div class="estado-vazio">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                    <p>Selecione uma fatura para negociar</p>
                </div>
            @endif
        </div>
    </div>
</div>
