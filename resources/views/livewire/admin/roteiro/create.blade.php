<div>
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: var(--space-lg);
            overflow-y: auto;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            padding: var(--space-lg);
            border-bottom: 1px solid var(--neutral-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .modal-body {
            padding: var(--space-lg);
        }

        .modal-footer {
            padding: var(--space-lg);
            border-top: 1px solid var(--neutral-dark);
            display: flex;
            align-items: center;
            gap: var(--space-md);
            position: sticky;
            bottom: 0;
            background: white;
            z-index: 10;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        }

        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            padding: var(--space-sm);
            border-radius: var(--radius-md);
            color: var(--text-muted);
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: var(--neutral);
            color: var(--text);
        }

        .modal-title {
            font-size: var(--h4-size);
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }

        /* Wizard */
        .wizard-step {
            display: flex;
            align-items: center;
            gap: var(--space-xs);
        }

        .wizard-step-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .wizard-step-number.active {
            background: var(--primary);
            color: white;
        }

        .wizard-step-number.inactive {
            background: var(--neutral-dark);
            color: var(--text-muted);
        }

        .wizard-line {
            flex: 1;
            height: 2px;
            border-radius: 1px;
            transition: all 0.3s;
        }

        .wizard-line.active {
            background: var(--primary);
        }

        .wizard-line.inactive {
            background: var(--neutral-dark);
        }

        /* Medidores */
        .rot-medidores-selecao {
            border: 1px solid var(--neutral-dark);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .rot-medidor-item {
            padding: var(--space-md);
            border-bottom: 1px solid var(--neutral);
            transition: all 0.2s;
        }

        .rot-medidor-item:last-child {
            border-bottom: none;
        }

        .rot-medidor-item:hover {
            background: var(--neutral);
        }

        .rot-medidor-item.selected {
            background: rgba(var(--primary-rgb), 0.05);
            border-left: 3px solid var(--primary);
        }

        .rot-medidor-item.selected:hover {
            background: rgba(var(--primary-rgb), 0.08);
        }

        /* Animação de loading */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsivo */
        @media (max-width: 640px) {
            .modal-overlay {
                padding: var(--space-sm);
                align-items: flex-end;
            }

            .modal {
                max-height: 95vh;
                border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            }

            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
    {{-- MODAL OVERLAY CONTROLADO PELO LIVEWIRE --}}
    <div class="modal-overlay @if ($mostrarModal) active @endif" id="modal-atribuir" wire:ignore.self>
        <div class="modal modal-lg" style="max-width: 900px;">

            {{-- HEADER --}}
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--primary); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">
                            @if ($passoAtual === 1)
                                Atribuir Novo Roteiro
                            @else
                                Selecionar Medidores
                            @endif
                        </h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                            @if ($passoAtual === 1)
                                Defina o leiturista, zona e período de leitura
                            @else
                                {{ count($medidoresSelecionados) }} medidor(es) selecionado(s) de
                                {{ count($medidoresDisponiveis) }} disponíveis
                            @endif
                        </p>
                    </div>
                </div>
                <button class="modal-close" wire:click="fecharModal" type="button">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            {{-- PROGRESSO DO WIZARD --}}
            {{-- <div style="padding: 0 var(--space-lg);">
                <div style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-md);">
                    <div style="display: flex; align-items: center; gap: var(--space-xs);">
                        <div
                            style="width: 28px; height: 28px; border-radius: 50%; background: {{ $passoAtual >= 1 ? 'var(--primary)' : 'var(--neutral-dark)' }}; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600;">
                            1</div>
                        <span
                            style="font-size: var(--small-size); color: {{ $passoAtual >= 1 ? 'var(--primary)' : 'var(--text-muted)' }}; font-weight: 600;">Dados
                            do Roteiro</span>
                    </div>
                    <div
                        style="flex: 1; height: 2px; background: {{ $passoAtual >= 2 ? 'var(--primary)' : 'var(--neutral-dark)' }}; border-radius: 1px;">
                    </div>
                    <div style="display: flex; align-items: center; gap: var(--space-xs);">
                        <div
                            style="width: 28px; height: 28px; border-radius: 50%; background: {{ $passoAtual >= 2 ? 'var(--primary)' : 'var(--neutral-dark)' }}; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600;">
                            2</div>
                        <span
                            style="font-size: var(--small-size); color: {{ $passoAtual >= 2 ? 'var(--primary)' : 'var(--text-muted)' }}; font-weight: 600;">Medidores</span>
                    </div>
                </div>
            </div> --}}
            {{-- PROGRESSO DO WIZARD - VERSÃO ORGANIZADA --}}
            <div
                style="padding: var(--space-md) var(--space-lg); background: var(--neutral); border-bottom: 1px solid var(--neutral-dark);">
                <div
                    style="display: flex; align-items: center; justify-content: center; max-width: 600px; margin: 0 auto;">

                    <!-- Passo 1 -->
                    <div style="display: flex; align-items: center; gap: var(--space-sm); flex: 1;">
                        <div
                            style="width: 32px; height: 32px; border-radius: 50%;
                       background: {{ $passoAtual >= 1 ? 'var(--primary)' : 'var(--neutral-dark)' }};
                       color: white;
                       display: flex;
                       align-items: center;
                       justify-content: center;
                       font-weight: 700;
                       font-size: 14px;
                       transition: all 0.3s ease;">
                            1
                        </div>
                        <div>
                            <div
                                style="font-weight: 600; font-size: var(--small-size);
                            color: {{ $passoAtual >= 1 ? 'var(--primary)' : 'var(--text-muted)' }};">
                                Dados do Roteiro
                            </div>
                            <div style="font-size: 12px; color: var(--text-muted);">Informações básicas</div>
                        </div>
                    </div>

                    <!-- Linha Conectora -->
                    <div
                        style="flex: 1; height: 3px; background: linear-gradient(to right,
                    {{ $passoAtual >= 1 ? 'var(--primary)' : 'var(--neutral-dark)' }} 50%,
                    {{ $passoAtual >= 2 ? 'var(--primary)' : 'var(--neutral-dark)' }} 50%);
                    margin: 0 var(--space-md); border-radius: 2px;">
                    </div>

                    <!-- Passo 2 -->
                    <div style="display: flex; align-items: center; gap: var(--space-sm); flex: 1;">
                        <div
                            style="width: 32px; height: 32px; border-radius: 50%;
                       background: {{ $passoAtual >= 2 ? 'var(--primary)' : 'var(--neutral-dark)' }};
                       color: white;
                       display: flex;
                       align-items: center;
                       justify-content: center;
                       font-weight: 700;
                       font-size: 14px;
                       transition: all 0.3s ease;">
                            2
                        </div>
                        <div>
                            <div
                                style="font-weight: 600; font-size: var(--small-size);
                            color: {{ $passoAtual >= 2 ? 'var(--primary)' : 'var(--text-muted)' }};">
                                Selecionar Medidores
                            </div>
                            <div style="font-size: 12px; color: var(--text-muted);">Escolha os clientes/medidores</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CORPO DO MODAL --}}
            <div class="modal-body">

                {{-- ========== PASSO 1: DADOS DO ROTEIRO ========== --}}
                @if ($passoAtual === 1)
                    <div class="grid-2">
                        {{-- Leiturista --}}
                        <div class="form-group">
                            <label class="form-label">Leiturista *</label>
                            <select class="form-select @error('userId') is-invalid @enderror" wire:model.live="userId"
                                required>
                                <option value="">Selecione o leiturista...</option>
                                @foreach ($leituristas as $leiturista)
                                    <option value="{{ $leiturista->id }}">{{ $leiturista->name }} —
                                        {{ $leiturista->email }}</option>
                                @endforeach
                            </select>
                            @error('userId')
                                <span style="color: var(--danger)">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Mês de Referência --}}
                        <div class="form-group">
                            <label class="form-label">Mês de Referência *</label>
                            <input type="date" class="form-input @error('dataReferente') is-invalid @enderror"
                                wire:model.live="dataReferente" required>
                            @error('dataReferente')
                                <span style="color: var(--danger)">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="grid-2">
                        {{-- Data Início --}}
                        <div class="form-group">
                            <label class="form-label">Data Início *</label>
                            <input type="date" class="form-input @error('dataInicio') is-invalid @enderror"
                                wire:model.live="dataInicio" required>
                            @error('dataInicio')
                                <span style="color: var(--danger)">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Data Fim --}}
                        <div class="form-group">
                            <label class="form-label">Data Fim *</label>
                            <input type="date" class="form-input @error('dataFim') is-invalid @enderror"
                                wire:model.live="dataFim" required>
                            @error('dataFim')
                                <span style="color: var(--danger)">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    {{-- Observações --}}
                    <div class="form-group">
                        <label class="form-label">Observações</label>
                        <textarea class="form-textarea @error('observacoes') is-invalid @enderror" wire:model.live="observacoes"
                            placeholder="Instruções especiais para o leiturista..." rows="3"></textarea>
                        @error('observacoes')
                            <span style="color: var(--danger)">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Notificação --}}
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-top: var(--space-md);">
                        <label
                            style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                            <input type="checkbox" wire:model.live="enviarNotificacao"
                                style="accent-color: var(--primary); width: 18px; height: 18px;">
                            <span><strong>Enviar notificação ao leiturista</strong> — O leiturista receberá uma
                                notificação no app mobile</span>
                        </label>
                    </div>
                @endif

                {{-- ========== PASSO 2: SELEÇÃO DE MEDIDORES ========== --}}
                @if ($passoAtual === 2)
                    {{-- Filtros --}}
                    <div style="display: flex; gap: var(--space-md); margin-bottom: var(--space-md); flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 200px;">
                            <input type="text" class="form-input" wire:model.live.debounce.300ms="buscaMedidor"
                                placeholder="Buscar por cliente, código ou série...">
                        </div>
                        <div style="min-width: 180px;">
                            <select class="form-select" wire:model="filtroStatusMedidor"
                                wire:change="carregarMedidores">
                                <option value="">Todos os status</option>
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                                <option value="pendente">Pendente</option>
                            </select>
                        </div>
                        <div class="form-group">
                            {{-- <label class="form-label">Zona *</label> --}}
                            <select class="form-select @error('zona') is-invalid @enderror" wire:model.live="zona"
                                required>
                                <option value="">Selecione a zona...</option>
                                @foreach ($zonasDisponiveis as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('zona')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Ações em lote --}}
                    <div style="display: flex; gap: var(--space-sm); margin-bottom: var(--space-md);">
                        <button type="button" class="btn btn-sm btn-outline" wire:click="selecionarTodos">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Selecionar Todos
                        </button>
                        <button type="button" class="btn btn-sm btn-outline" wire:click="limparSelecao">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                            Limpar Seleção
                        </button>
                        <span
                            style="margin-left: auto; font-size: var(--small-size); color: var(--text-muted); align-self: center;">
                            {{ count($medidoresSelecionados) }} selecionados
                        </span>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">
                            Medidores Disponíveis na {{ $zonasDisponiveis[$zona] ?? $zona }}
                        </label>

                        @if (count($medidoresDisponiveis) === 0)
                            <div
                                style="text-align: center; padding: var(--space-xl); color: var(--text-muted); background: var(--neutral); border-radius: var(--radius-md);">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5"
                                    style="margin-bottom: var(--space-md); opacity: 0.5;">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M16 16s-1.5-2-4-2-4 2-4 2" />
                                    <path d="M9 9h.01" />
                                    <path d="M15 9h.01" />
                                </svg>
                                <p style="font-weight: 500;">Nenhum medidor encontrado</p>
                                <p style="font-size: var(--small-size);">Tente ajustar os filtros ou verifique se há
                                    medidores para esta zona e período.</p>
                            </div>
                        @else
                            <div class="rot-medidores-selecao" style="max-height: 400px; overflow-y: auto;">
                                @foreach ($medidoresDisponiveis as $medidor)
                                    <div class="rot-medidor-item @if (in_array($medidor['cliente_id'], $medidoresSelecionados)) selected @endif"
                                        wire:click="toggleMedidor({{ $medidor['cliente_id'] }})"
                                        style="cursor: pointer; transition: all 0.2s; padding: var(--space-sm); border-bottom: 1px solid var(--neutral);">

                                        <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                            <!-- Checkbox Visual -->
                                            <input type="checkbox" @if (in_array($medidor['cliente_id'], $medidoresSelecionados)) checked @endif
                                                style="accent-color: var(--primary); width: 18px; height: 18px; pointer-events: none;">

                                            <div style="flex: 1;">
                                                <!-- Topo: Identificadores e Badges de Status -->
                                                <div
                                                    style="display: flex; align-items: center; gap: var(--space-sm); flex-wrap: wrap;">
                                                    <span
                                                        style="font-weight: 600; font-size: var(--label-size); color: var(--primary);">
                                                        {{ $medidor['medidor_codigo'] }}
                                                    </span>

                                                    <span style="font-size: 11px; color: var(--text-muted);">
                                                        Série: {{ $medidor['medidor_serie'] }}
                                                    </span>

                                                    <!-- Status da Leitura Atual -->
                                                    <span class="badge badge-sm"
                                                        style="background: {{ $medidor['status_medidor'] === 'Ativo' ? 'var(--success)' : 'var(--warning)' }}; color: white; padding: 2px 8px; border-radius: 4px; font-size: 10px; text-transform: uppercase;">
                                                        {{ $medidor['status_medidor'] }}
                                                    </span>

                                                    <!-- Alerta Financeiro (Tabela Faturas) se o cliente possuir pendências -->
                                                    @if ($medidor['esta_vencida'])
                                                        <span class="badge badge-sm"
                                                            style="background: var(--danger); color: white; padding: 2px 8px; border-radius: 4px; font-size: 10px; text-transform: uppercase;"
                                                            title="Fatura {{ $medidor['fatura_codigo'] }} vencida">
                                                            Fatura Pendente
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Meio: Informações do Cliente e Endereço -->
                                                <div
                                                    style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                                                    <strong>{{ $medidor['cliente_nome'] }}</strong>
                                                    <span
                                                        style="color: var(--text-muted); opacity: 0.7;">({{ $medidor['cliente_zona'] }})</span>
                                                    —
                                                    {{ $medidor['cliente_endereco'] }}
                                                </div>

                                                <!-- Rodapé: Histórico de Leitura Anterior -->
                                                @if ($medidor['leitura_anterior'] !== null)
                                                    <div
                                                        style="font-size: 11px; color: var(--text-muted); margin-top: 2px; display: flex; gap: var(--space-md);">
                                                        <span>Última leitura:
                                                            <strong>{{ $medidor['leitura_anterior'] }}
                                                                m³</strong></span>
                                                        @if ($medidor['fatura_valor_total'] > 0)
                                                            <span style="color: var(--text-muted);">Ref:
                                                                {{ $medidor['fatura_codigo'] }}
                                                                ({{ number_format($medidor['fatura_valor_total'], 2, ',', '.') }}
                                                                MT)
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @error('medidoresSelecionados')
                        <span class="form-error"
                            style="margin-top: var(--space-sm); display: block;">{{ $message }}</span>
                    @enderror
                @endif
            </div>

            {{-- FOOTER / AÇÕES --}}
            <div class="modal-footer" style="justify-content: space-between;">
                <div>
                    @if ($passoAtual === 2)
                        <button class="btn btn-outline" wire:click="passoAnterior" type="button">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                            Voltar
                        </button>
                    @else
                        <button class="btn btn-outline" wire:click="fecharModal" type="button">Cancelar</button>
                    @endif
                </div>

                <div style="display: flex; gap: var(--space-sm);">
                    @if ($passoAtual === 1)
                        <button class="btn btn-primary" wire:click="proximoPasso" type="button">
                            Próximo: Selecionar Medidores
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" style="margin-left: 6px;">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </button>
                    @else
                        <button class="btn btn-secondary" wire:click="salvarRascunho" type="button">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Salvar Rascunho
                        </button>
                        <button class="btn btn-primary" wire:click="criarRoteiro" type="button"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="criarRoteiro">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>
                                Atribuir Roteiro
                            </span>
                            <span wire:loading wire:target="criarRoteiro">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    style="margin-right: 6px; animation: spin 1s linear infinite;">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                </svg>
                                Atribuindo...
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
