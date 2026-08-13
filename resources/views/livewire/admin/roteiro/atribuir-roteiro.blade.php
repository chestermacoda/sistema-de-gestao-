{{-- resources/views/livewire/admin/roteiro/reatribuir.blade.php --}}

<div>
    {{-- CSS específico da modal --}}
    {{-- MODAL RE-ATRIBUIR ROTEIRO --}}
    <div class="modal-overlay" id="modal-reatribuir" wire:ignore.self {{-- style="display: {{ $mostrarModal ? 'flex' : 'none' }};" --}}>
        <style>
            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .modal-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.6);
                backdrop-filter: blur(4px);
                z-index: 1050;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: var(--space-md);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .modal-overlay[style*="display: flex"] {
                opacity: 1;
                visibility: visible;
            }

            .modal {
                background: white;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-xl);
                width: 100%;
                max-height: 92vh;
                overflow: hidden;
                transform: scale(0.95) translateY(10px);
                transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .modal-overlay[style*="display: flex"] .modal {
                transform: scale(1) translateY(0);
            }

            .modal-xl {
                max-width: 1100px;
            }

            .modal-lg {
                max-width: 900px;
            }

            .modal-header {
                padding: var(--space-lg) var(--space-xl);
                border-bottom: 1px solid var(--neutral-dark);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .modal-body {
                padding: var(--space-xl);
            }

            #modal-reatribuir .modal-footer {
                padding: var(--space-lg) var(--space-xl);
                border-top: 1px solid var(--neutral-dark);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .modal-title {
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--text-primary);
                margin: 0;
            }

            .modal-subtitle {
                font-size: var(--small-size);
                color: var(--text-muted);
                margin: 2px 0 0 0;
            }

            .roteiro-header-icon {
                width: 44px;
                height: 44px;
                border-radius: var(--radius-md);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: var(--space-sm);
                padding: 10px 20px;
                border-radius: var(--radius-md);
                font-size: var(--label-size);
                font-weight: 600;
                cursor: pointer;
                border: none;
                transition: all 0.2s ease;
                text-decoration: none;
            }

            .btn-primary {
                background: var(--primary);
                color: white;
            }

            .btn-primary:hover {
                background: var(--primary-light);
                transform: translateY(-1px);
                box-shadow: var(--shadow-md);
            }

            .btn-ghost {
                background: transparent;
                color: var(--text-secondary);
                border: 1px solid var(--neutral-darker);
            }

            .btn-ghost:hover {
                background: var(--neutral);
                color: var(--text-primary);
            }

            .btn-sm {
                padding: 6px 12px;
                font-size: var(--small-size);
            }

            .btn-icon {
                width: 36px;
                height: 36px;
                border-radius: var(--radius-md);
                display: flex;
                align-items: center;
                justify-content: center;
                background: transparent;
                border: none;
                color: var(--text-muted);
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .btn-icon:hover {
                background: var(--neutral-dark);
                color: var(--text-primary);
            }

            .form-group {
                margin-bottom: var(--space-lg);
            }

            .form-label {
                display: block;
                font-size: var(--label-size);
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: var(--space-sm);
            }

            .form-control {
                width: 100%;
                padding: 10px 14px;
                border: 1.5px solid var(--neutral-darker);
                border-radius: var(--radius-md);
                font-size: var(--body-size);
                color: var(--text-primary);
                background: white;
                transition: all 0.2s ease;
                font-family: var(--font-body);
            }

            .form-control:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
            }

            .form-control.is-invalid {
                border-color: var(--danger);
            }

            .form-control.is-invalid:focus {
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            }

            .invalid-feedback {
                display: block;
                margin-top: var(--space-xs);
                font-size: var(--small-size);
                color: var(--danger);
            }

            select.form-control {
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                padding-right: 36px;
            }

            textarea.form-control {
                resize: vertical;
                min-height: 80px;
            }
        </style>

        <div class="modal modal-xl" style="max-width: 1100px; max-height: 92vh; display: flex; flex-direction: column;">

            {{-- ═══════════ HEADER ═══════════ --}}
            <div class="modal-header" style="flex-shrink: 0;">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div class="roteiro-header-icon"
                        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-lighter) 100%);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M16 3h3v3h-3zM8 3h3v3H8zM5 3h2v3H5zM3 8h18v13H3zM8 8v13M16 8v13" />
                            <path d="M12 3v5M7 8l5-5 5 5" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Re-Atribuir Roteiro</h3>
                        <p class="modal-subtitle">
                            {{ $roteiroInfo['mes_ano'] ?? 'N/A' }} — {{ $roteiroInfo['leiturista_nome'] ?? 'N/A' }} —
                            {{ $roteiroInfo['zona'] ?? 'Todas' }}
                        </p>
                    </div>
                </div>
                <div style="display: flex; gap: var(--space-sm); align-items: center;">
                    {{-- Indicador de Passo --}}
                    <div
                        style="display: flex; gap: var(--space-xs); align-items: center; margin-right: var(--space-md);">
                        @foreach ([1 => 'Dados', 2 => 'Clientes', 3 => 'Confirmação'] as $num => $label)
                            <div style="display: flex; align-items: center; gap: var(--space-xs);">
                                <div
                                    style="
                                    width: 28px; height: 28px; border-radius: 50%;
                                    display: flex; align-items: center; justify-content: center;
                                    font-size: var(--small-size); font-weight: 600;
                                    transition: all 0.3s ease;
                                    {{ $passoAtual == $num ? 'background: var(--primary); color: white;' : ($passoAtual > $num ? 'background: var(--success); color: white;' : 'background: var(--neutral-dark); color: var(--text-muted);') }}
                                ">
                                    @if ($passoAtual > $num)
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="3">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    @else
                                        {{ $num }}
                                    @endif
                                </div>
                                <span
                                    style="font-size: var(--small-size); color: {{ $passoAtual >= $num ? 'var(--text-primary)' : 'var(--text-muted)' }}; font-weight: 500;">
                                    {{ $label }}
                                </span>
                                @if ($num < 3)
                                    <div
                                        style="width: 20px; height: 2px; background: {{ $passoAtual > $num ? 'var(--success)' : 'var(--neutral-darker)' }}; margin: 0 var(--space-xs);">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn-icon" wire:click="fecharModal" title="Fechar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- ═══════════ LOADING ═══════════ --}}
            @if ($carregando)
                <div
                    style="flex: 1; display: flex; align-items: center; justify-content: center; padding: var(--space-2xl);">
                    <div style="text-align: center;">
                        <div class="spinner"
                            style="width: 48px; height: 48px; border: 4px solid var(--neutral-dark); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto var(--space-lg);">
                        </div>
                        <p style="color: var(--text-secondary); font-size: var(--body-size);">Carregando roteiro...</p>
                    </div>
                </div>
            @elseif($erroValidacao)
                {{-- ═══════════ ERRO ═══════════ --}}
                <div
                    style="flex: 1; display: flex; align-items: center; justify-content: center; padding: var(--space-2xl);">
                    <div style="text-align: center; max-width: 400px;">
                        <div
                            style="width: 64px; height: 64px; background: var(--danger-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-lg);">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--danger)"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                        </div>
                        <h4 style="color: var(--text-primary); margin-bottom: var(--space-sm);">Não foi possível
                            reatribuir</h4>
                        <p
                            style="color: var(--text-secondary); font-size: var(--body-size); margin-bottom: var(--space-lg);">
                            {{ $erroValidacao }}</p>
                        <button type="button" class="btn btn-primary" wire:click="fecharModal">
                            Fechar
                        </button>
                    </div>
                </div>
            @else
                {{-- ═══════════ BODY ═══════════ --}}
                <div class="modal-body" style="flex: 1; overflow-y: auto; padding: 0;">

                    {{-- ========================================== --}}
                    {{-- PASSO 1: DADOS DO NOVO ROTEIRO            --}}
                    {{-- ========================================== --}}
                    @if ($passoAtual === 1)
                        <div style="padding: var(--space-xl);">
                            {{-- Info do Roteiro Origem --}}
                            <div
                                style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); border-radius: var(--radius-lg); padding: var(--space-lg); margin-bottom: var(--space-xl); color: white;">
                                <div
                                    style="display: flex; align-items: center; gap: var(--space-md); margin-bottom: var(--space-md);">
                                    <div
                                        style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="white" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                            <line x1="16" y1="13" x2="8" y2="13" />
                                            <line x1="16" y1="17" x2="8" y2="17" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 style="margin: 0; font-size: var(--body-size); font-weight: 600;">Roteiro
                                            de
                                            Origem</h4>
                                        <p style="margin: 0; font-size: var(--small-size); opacity: 0.9;">
                                            {{ $roteiroInfo['mes_ano'] ?? 'N/A' }} |
                                            {{ $roteiroInfo['total_clientes'] ?? 0 }} cliente(s)</p>
                                    </div>
                                </div>
                                <div
                                    style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-md);">
                                    <div
                                        style="background: rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: var(--space-sm) var(--space-md);">
                                        <span style="font-size: var(--small-size); opacity: 0.8;">Leiturista</span>
                                        <p style="margin: 0; font-weight: 600;">
                                            {{ $roteiroInfo['leiturista_nome'] ?? 'N/A' }}</p>
                                    </div>
                                    <div
                                        style="background: rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: var(--space-sm) var(--space-md);">
                                        <span style="font-size: var(--small-size); opacity: 0.8;">Período</span>
                                        <p style="margin: 0; font-weight: 600;">
                                            {{ $roteiroInfo['data_inicio'] ?? 'N/A' }} —
                                            {{ $roteiroInfo['data_fim'] ?? 'N/A' }}</p>
                                    </div>
                                    <div
                                        style="background: rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: var(--space-sm) var(--space-md);">
                                        <span style="font-size: var(--small-size); opacity: 0.8;">Zona</span>
                                        <p style="margin: 0; font-weight: 600;">{{ $roteiroInfo['zona'] ?? 'Todas' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <h4
                                style="color: var(--text-primary); margin-bottom: var(--space-lg); display: flex; align-items: center; gap: var(--space-sm);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--primary)" stroke-width="2">
                                    <circle cx="12" cy="12" r="3" />
                                    <path
                                        d="M12 1v6m0 6v6m4.22-10.22l4.24-4.24M6.34 6.34L2.1 2.1m17.8 17.8l-4.24-4.24M6.34 17.66l-4.24 4.24" />
                                </svg>
                                Configuração do Novo Roteiro
                            </h4>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-lg);">
                                {{-- Leiturista Destino --}}
                                <div class="form-group">
                                    <label class="form-label"
                                        style="display: flex; align-items: center; gap: var(--space-xs);">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                            <circle cx="12" cy="7" r="4" />
                                        </svg>
                                        Novo Leiturista
                                    </label>
                                    <select wire:model.live="userIdDestino"
                                        class="form-control @error('userIdDestino') is-invalid @enderror">
                                        <option value="">Selecione um leiturista...</option>
                                        @foreach ($leituristas as $leit)
                                            <option value="{{ $leit['id'] }}">{{ $leit['name'] }}
                                                {{ $leit['id'] == $userIdOrigem ? '(Atual)' : '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('userIdDestino')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Data Referente (Mês Atual - readonly) --}}
                                <div class="form-group">
                                    <label class="form-label"
                                        style="display: flex; align-items: center; gap: var(--space-xs);">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2"
                                                ry="2" />
                                            <line x1="16" y1="2" x2="16" y2="6" />
                                            <line x1="8" y1="2" x2="8" y2="6" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        Mês de Referência
                                    </label>
                                    <input type="month" wire:model="dataReferenteDestino" class="form-control"
                                        readonly style="background: var(--neutral-dark); cursor: not-allowed;">
                                    <small style="color: var(--text-muted); font-size: var(--small-size);">Sempre o mês
                                        atual</small>
                                </div>

                                {{-- Data Início --}}
                                <div class="form-group">
                                    <label class="form-label"
                                        style="display: flex; align-items: center; gap: var(--space-xs);">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2"
                                                ry="2" />
                                            <line x1="16" y1="2" x2="16" y2="6" />
                                            <line x1="8" y1="2" x2="8" y2="6" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        Data de Início
                                    </label>
                                    <input type="date" wire:model="dataInicio"
                                        class="form-control @error('dataInicio') is-invalid @enderror">
                                    @error('dataInicio')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Data Fim --}}
                                <div class="form-group">
                                    <label class="form-label"
                                        style="display: flex; align-items: center; gap: var(--space-xs);">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2"
                                                ry="2" />
                                            <line x1="16" y1="2" x2="16" y2="6" />
                                            <line x1="8" y1="2" x2="8" y2="6" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                        Data de Fim
                                    </label>
                                    <input type="date" wire:model="dataFim"
                                        class="form-control @error('dataFim') is-invalid @enderror">
                                    @error('dataFim')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Opções Adicionais --}}
                            <div
                                style="margin-top: var(--space-lg); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md); border: 1px solid var(--neutral-dark);">
                                <label
                                    style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer;">
                                    <input type="checkbox" wire:model="manterOrdem"
                                        style="width: 18px; height: 18px; accent-color: var(--primary);">
                                    <span style="color: var(--text-primary); font-weight: 500;">Manter ordem original
                                        do roteiro</span>
                                </label>
                                <p
                                    style="margin: var(--space-xs) 0 0 28px; color: var(--text-muted); font-size: var(--small-size);">
                                    Se marcado, preserva a sequência de visitas do roteiro anterior. Caso contrário,
                                    reordena numericamente.
                                </p>
                            </div>

                            {{-- Observações --}}
                            <div class="form-group" style="margin-top: var(--space-lg);">
                                <label class="form-label"
                                    style="display: flex; align-items: center; gap: var(--space-xs);">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Observações
                                </label>
                                <textarea wire:model="observacoes" rows="3" class="form-control"
                                    placeholder="Observações sobre a re-atribuição..."></textarea>
                                @error('observacoes')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    {{-- ========================================== --}}
                    {{-- PASSO 2: SELEÇÃO DE CLIENTES              --}}
                    {{-- ========================================== --}}
                    @if ($passoAtual === 2)
                        <div style="display: flex; flex-direction: column; height: 100%;">
                            {{-- Barra de Ações --}}
                            <div
                                style="padding: var(--space-md) var(--space-xl); background: var(--neutral); border-bottom: 1px solid var(--neutral-dark); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
                                <div style="display: flex; align-items: center; gap: var(--space-md);">
                                    <span
                                        style="font-size: var(--label-size); color: var(--text-secondary); font-weight: 500;">
                                        <strong
                                            style="color: var(--primary);">{{ count($clientesSelecionados) }}</strong>
                                        de <strong>{{ count($roteiroAntigo) }}</strong> selecionados
                                    </span>
                                    @if (count($clientesComProblema) > 0)
                                        <span
                                            style="background: var(--warning-light); color: var(--warning); padding: 2px var(--space-sm); border-radius: var(--radius-sm); font-size: var(--small-size); font-weight: 500;">
                                            {{ count($clientesComProblema) }} com problema/anomalia
                                        </span>
                                    @endif
                                </div>
                                <div style="display: flex; gap: var(--space-sm);">
                                    <button type="button" class="btn btn-sm btn-ghost" wire:click="selecionarTodos">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <polyline points="9 11 12 14 22 4" />
                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                                        </svg>
                                        Todos
                                    </button>
                                    @if (count($clientesComProblema) > 0)
                                        <button type="button" class="btn btn-sm btn-ghost"
                                            wire:click="selecionarApenasComProblema" style="color: var(--warning);">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path
                                                    d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                                <line x1="12" y1="9" x2="12" y2="13" />
                                                <line x1="12" y1="17" x2="12.01" y2="17" />
                                            </svg>
                                            Só com Problema
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-ghost" wire:click="limparSelecao"
                                        style="color: var(--danger);">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                        Limpar
                                    </button>
                                </div>
                            </div>

                            {{-- Lista de Clientes --}}
                            <div style="flex: 1; overflow-y: auto; padding: var(--space-md) var(--space-xl);">
                                <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
                                    @forelse($roteiroAntigo as $index => $item)
                                        @php
                                            $selecionado = in_array($item['cliente_id'], $clientesSelecionados);
                                            $statusColors = [
                                                'OK' => [
                                                    'bg' => 'var(--success-light)',
                                                    'text' => 'var(--success)',
                                                    'icon' => 'check',
                                                ],
                                                'Anomalia' => [
                                                    'bg' => 'var(--warning-light)',
                                                    'text' => 'var(--warning)',
                                                    'icon' => 'alert-triangle',
                                                ],
                                                'Problema' => [
                                                    'bg' => 'var(--danger-light)',
                                                    'text' => 'var(--danger)',
                                                    'icon' => 'x-circle',
                                                ],
                                                'Não lido' => [
                                                    'bg' => 'var(--neutral-dark)',
                                                    'text' => 'var(--text-muted)',
                                                    'icon' => 'minus-circle',
                                                ],
                                            ];
                                            $cor = $statusColors[$item['status']] ?? $statusColors['Não lido'];
                                        @endphp

                                        <div wire:click="toggleCliente({{ $item['cliente_id'] }})"
                                            style="
                                                display: flex; align-items: center; gap: var(--space-md);
                                                padding: var(--space-md); border-radius: var(--radius-md);
                                                border: 2px solid {{ $selecionado ? 'var(--primary)' : 'var(--neutral-dark)' }};
                                                background: {{ $selecionado ? 'rgba(0,51,102,0.04)' : 'white' }};
                                                cursor: pointer; transition: all 0.2s ease;
                                            "
                                            onmouseover="this.style.borderColor='var(--primary-lighter)'; this.style.background='rgba(0,51,102,0.02)';"
                                            onmouseout="this.style.borderColor='{{ $selecionado ? 'var(--primary)' : 'var(--neutral-dark)' }}'; this.style.background='{{ $selecionado ? 'rgba(0,51,102,0.04)' : 'white' }}';">
                                            {{-- Checkbox --}}
                                            <div
                                                style="
                                                width: 22px; height: 22px; border-radius: var(--radius-sm);
                                                border: 2px solid {{ $selecionado ? 'var(--primary)' : 'var(--neutral-darker)' }};
                                                background: {{ $selecionado ? 'var(--primary)' : 'white' }};
                                                display: flex; align-items: center; justify-content: center;
                                                flex-shrink: 0; transition: all 0.2s ease;
                                            ">
                                                @if ($selecionado)
                                                    <svg width="14" height="14" viewBox="0 0 24 24"
                                                        fill="none" stroke="white" stroke-width="3">
                                                        <polyline points="20 6 9 17 4 12" />
                                                    </svg>
                                                @endif
                                            </div>

                                            {{-- Ordem --}}
                                            <div style="width: 32px; text-align: center; flex-shrink: 0;">
                                                <span
                                                    style="font-size: var(--small-size); color: var(--text-muted); font-weight: 600;">#{{ $item['ordem'] }}</span>
                                            </div>

                                            {{-- Info do Cliente --}}
                                            <div style="flex: 1; min-width: 0;">
                                                <div
                                                    style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: 2px;">
                                                    <span
                                                        style="font-weight: 600; color: var(--text-primary); font-size: var(--body-size);">{{ $item['nome'] }}</span>
                                                    <span
                                                        style="background: {{ $cor['bg'] }}; color: {{ $cor['text'] }}; padding: 1px 8px; border-radius: 12px; font-size: 10px; font-weight: 600; text-transform: uppercase;">
                                                        {{ $item['status'] }}
                                                    </span>
                                                </div>
                                                <div
                                                    style="display: flex; gap: var(--space-lg); font-size: var(--small-size); color: var(--text-muted);">
                                                    <span style="display: flex; align-items: center; gap: 4px;">
                                                        <svg width="12" height="12" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                                            <circle cx="12" cy="10" r="3" />
                                                        </svg>
                                                        {{ $item['endereco'] }}
                                                    </span>
                                                    <span style="display: flex; align-items: center; gap: 4px;">
                                                        <svg width="12" height="12" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2">
                                                            <path
                                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                                        </svg>
                                                        {{ $item['contacto'] }}
                                                    </span>
                                                    <span style="display: flex; align-items: center; gap: 4px;">
                                                        <svg width="12" height="12" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2">
                                                            <path
                                                                d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z" />
                                                            <path d="M12 6v6l4 2" />
                                                        </svg>
                                                        Medidor: {{ $item['medidor'] }}
                                                        ({{ $item['medidor_codigo'] }})
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Leituras --}}
                                            <div style="text-align: right; flex-shrink: 0; min-width: 140px;">
                                                <div style="font-size: var(--small-size); color: var(--text-muted);">
                                                    Ant: <strong
                                                        style="color: var(--text-primary);">{{ number_format($item['leitura_anterior'] ?? 0, 0, ',', '.') }}</strong>
                                                </div>
                                                <div style="font-size: var(--small-size); color: var(--text-muted);">
                                                    Atual: <strong
                                                        style="color: var(--text-primary);">{{ $item['leitura_atual'] !== null ? number_format($item['leitura_atual'], 0, ',', '.') : '—' }}</strong>
                                                </div>
                                                @if ($item['consumo'] !== null)
                                                    <div
                                                        style="font-size: var(--small-size); color: var(--primary); font-weight: 600;">
                                                        Consumo: {{ number_format($item['consumo'], 0, ',', '.') }} m³
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div
                                            style="text-align: center; padding: var(--space-2xl); color: var(--text-muted);">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1"
                                                style="margin-bottom: var(--space-md); opacity: 0.5;">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                                <circle cx="9" cy="7" r="4" />
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            </svg>
                                            <p>Nenhum cliente encontrado no roteiro.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ========================================== --}}
                    {{-- PASSO 3: CONFIRMAÇÃO                      --}}
                    {{-- ========================================== --}}
                    @if ($passoAtual === 3)
                        <div style="padding: var(--space-xl);">
                            <div style="text-align: center; margin-bottom: var(--space-xl);">
                                <div
                                    style="width: 72px; height: 72px; background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-lg); box-shadow: var(--shadow-lg);">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                                        stroke="white" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                        <polyline points="9 12 12 15 16 10" />
                                    </svg>
                                </div>
                                <h3 style="color: var(--text-primary); margin-bottom: var(--space-sm);">Confirmar
                                    Re-Atribuição</h3>
                                <p style="color: var(--text-secondary); max-width: 500px; margin: 0 auto;">Revise os
                                    dados abaixo antes de confirmar. Esta ação criará um novo roteiro no mês atual.</p>
                            </div>

                            <div style="max-width: 600px; margin: 0 auto;">
                                {{-- Resumo Origem → Destino --}}
                                <div
                                    style="background: white; border-radius: var(--radius-lg); border: 1px solid var(--neutral-dark); overflow: hidden; margin-bottom: var(--space-lg);">
                                    <div
                                        style="background: var(--neutral); padding: var(--space-md) var(--space-lg); border-bottom: 1px solid var(--neutral-dark);">
                                        <h4
                                            style="margin: 0; font-size: var(--label-size); color: var(--text-primary); font-weight: 600;">
                                            Resumo da Operação</h4>
                                    </div>
                                    <div style="padding: var(--space-lg);">
                                        {{-- Origem --}}
                                        <div
                                            style="display: flex; align-items: center; gap: var(--space-md); margin-bottom: var(--space-lg);">
                                            <div
                                                style="width: 40px; height: 40px; background: var(--neutral-dark); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                                <svg width="18" height="18" viewBox="0 0 24 24"
                                                    fill="none" stroke="var(--text-muted)" stroke-width="2">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                    <circle cx="12" cy="7" r="4" />
                                                </svg>
                                            </div>
                                            <div style="flex: 1;">
                                                <span
                                                    style="font-size: var(--small-size); color: var(--text-muted);">De</span>
                                                <p style="margin: 0; font-weight: 600; color: var(--text-primary);">
                                                    {{ $roteiroInfo['leiturista_nome'] ?? 'N/A' }}</p>
                                                <p
                                                    style="margin: 0; font-size: var(--small-size); color: var(--text-muted);">
                                                    {{ $roteiroInfo['mes_ano'] ?? 'N/A' }}</p>
                                            </div>
                                        </div>

                                        {{-- Seta --}}
                                        <div
                                            style="display: flex; justify-content: center; margin: var(--space-md) 0;">
                                            <div
                                                style="width: 32px; height: 32px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <svg width="16" height="16" viewBox="0 0 24 24"
                                                    fill="none" stroke="white" stroke-width="2">
                                                    <line x1="12" y1="5" x2="12"
                                                        y2="19" />
                                                    <polyline points="19 12 12 19 5 12" />
                                                </svg>
                                            </div>
                                        </div>

                                        {{-- Destino --}}
                                        <div style="display: flex; align-items: center; gap: var(--space-md);">
                                            <div
                                                style="width: 40px; height: 40px; background: var(--primary-light); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                                <svg width="18" height="18" viewBox="0 0 24 24"
                                                    fill="none" stroke="white" stroke-width="2">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                    <circle cx="12" cy="7" r="4" />
                                                </svg>
                                            </div>
                                            <div style="flex: 1;">
                                                <span
                                                    style="font-size: var(--small-size); color: var(--text-muted);">Para</span>
                                                <p style="margin: 0; font-weight: 600; color: var(--text-primary);">
                                                    {{ collect($leituristas)->firstWhere('id', $userIdDestino)['name'] ?? 'N/A' }}
                                                    @if ($userIdDestino == $userIdOrigem)
                                                        <span
                                                            style="font-size: var(--small-size); color: var(--text-muted); font-weight: 400;">(mesmo
                                                            leiturista)</span>
                                                    @endif
                                                </p>
                                                <p
                                                    style="margin: 0; font-size: var(--small-size); color: var(--text-muted);">
                                                    {{ \Carbon\Carbon::parse($dataReferenteDestino)->translatedFormat('F/Y') }}
                                                    |
                                                    {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }} —
                                                    {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Estatísticas --}}
                                <div
                                    style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-md); margin-bottom: var(--space-lg);">
                                    <div
                                        style="background: var(--success-light); border-radius: var(--radius-md); padding: var(--space-md); text-align: center;">
                                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">
                                            {{ count($clientesSelecionados) }}</div>
                                        <div style="font-size: var(--small-size); color: var(--text-secondary);">
                                            Clientes Selecionados</div>
                                    </div>
                                    <div
                                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); text-align: center;">
                                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">
                                            {{ count($roteiroAntigo) - count($clientesSelecionados) }}</div>
                                        <div style="font-size: var(--small-size); color: var(--text-secondary);">Não
                                            Selecionados</div>
                                    </div>
                                    <div
                                        style="background: var(--primary-light); border-radius: var(--radius-md); padding: var(--space-md); text-align: center;">
                                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                                            {{ count($clientesComProblema) }}</div>
                                        <div style="font-size: var(--small-size); color: var(--text-secondary);">Com
                                            Problema</div>
                                    </div>
                                </div>

                                @if (!empty($observacoes))
                                    <div
                                        style="background: var(--warning-light); border-radius: var(--radius-md); padding: var(--space-md); margin-bottom: var(--space-lg);">
                                        <div
                                            style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-xs);">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="var(--warning)" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                            <span
                                                style="font-size: var(--small-size); font-weight: 600; color: var(--warning);">Observações</span>
                                        </div>
                                        <p
                                            style="margin: 0; color: var(--text-secondary); font-size: var(--body-size);">
                                            {{ $observacoes }}</p>
                                    </div>
                                @endif

                                {{-- Alerta --}}
                                <div
                                    style="background: var(--danger-light); border: 1px solid var(--danger); border-radius: var(--radius-md); padding: var(--space-md); display: flex; gap: var(--space-md); align-items: flex-start;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="var(--danger)" stroke-width="2"
                                        style="flex-shrink: 0; margin-top: 2px;">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    <div>
                                        <p
                                            style="margin: 0 0 4px 0; font-weight: 600; color: var(--danger); font-size: var(--body-size);">
                                            Atenção</p>
                                        <p
                                            style="margin: 0; color: var(--text-secondary); font-size: var(--small-size);">
                                            Esta ação criará novas faturas e um novo roteiro no mês atual.
                                            Clientes que já possuem roteiro no mês de destino serão ignorados.
                                            Não é possível re-atribuir o mesmo roteiro mais de uma vez por mês.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- ═══════════ FOOTER ═══════════ --}}
                <div class="modal-footer"
                    style="flex-shrink: 0; border-top: 1px solid var(--neutral-dark); padding: var(--space-md) var(--space-xl); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        @if ($passoAtual > 1)
                            <button type="button" class="btn btn-ghost" wire:click="passoAnterior">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <line x1="19" y1="12" x2="5" y2="12" />
                                    <polyline points="12 19 5 12 12 5" />
                                </svg>
                                Voltar
                            </button>
                        @else
                            <button type="button" class="btn btn-ghost" wire:click="fecharModal">
                                Cancelar
                            </button>
                        @endif
                    </div>

                    <div style="display: flex; gap: var(--space-sm);">
                        @if ($passoAtual < 3)
                            <button type="button" class="btn btn-primary" wire:click="proximoPasso"
                                wire:loading.attr="disabled" wire:target="proximoPasso">
                                <span wire:loading.remove wire:target="proximoPasso">
                                    Próximo
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                        <polyline points="12 5 19 12 12 19" />
                                    </svg>
                                </span>
                                <span wire:loading wire:target="proximoPasso">Processando...</span>
                            </button>
                        @else
                            <button type="button" class="btn btn-primary" wire:click="confirmarReatribuicao"
                                wire:loading.attr="disabled" wire:target="confirmarReatribuicao"
                                style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);">
                                <span wire:loading.remove wire:target="confirmarReatribuicao">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    Confirmar Re-Atribuição
                                </span>
                                <span wire:loading wire:target="confirmarReatribuicao">
                                    <div class="spinner"
                                        style="width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-top-color: white; border-radius: 50%; animation: spin 0.8s linear infinite; display: inline-block; vertical-align: middle; margin-right: 6px;">
                                    </div>
                                    Processando...
                                </span>
                            </button>
                        @endif
                    </div>
                </div>

            @endif {{-- fim do else do carregamento/erro --}}

        </div>
    </div>


</div>
