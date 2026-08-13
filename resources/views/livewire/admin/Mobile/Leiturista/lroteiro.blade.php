<div>
    <style>
        /* ==================== SMOOTH TRANSITIONS ==================== */

        .roteiro-progress {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            max-height: 120px;
            /* ajuste conforme necessário */
            opacity: 1;
        }

        /* Quando estiver pesquisando */
        .search-active .roteiro-progress {
            max-height: 0;
            opacity: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        /* Campo de busca com sticky suave */
        .search-container {
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            /* padding: 12px 0; */
            border-radius: 0.8rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        /* Efeito ao digitar */
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.15);
            border-color: var(--primary);
        }

        /* Animação da barra de progresso */
        .roteiro-progress-fill {
            transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Suavidade na lista ao filtrar */
        .roteiro-card {
            transition: all 0.3s ease;
        }

        .roteiro-card.hidden {
            opacity: 0;
            transform: translateY(10px);
        }
    </style>
    <section class="mobile-section active" id="section-roteiro">
        <!-- PROGRESSO DO DIA -->
        <div class="roteiro-progress" id="progress-container" style="display: {{ empty($search) ? 'block' : 'none' }};">
            <div class="roteiro-progress-header">
                <span class="roteiro-progress-title">Progresso do Dia</span>
                <span class="roteiro-progress-percent">{{ $percentual }}%</span>
            </div>
            <div class="roteiro-progress-bar">
                <div class="roteiro-progress-fill" style="width: {{ $percentual }}%"></div>
            </div>
            <div class="roteiro-progress-stats">
                <span>{{ $concluidos }} de {{ $total }} leituras</span>
                <span>~{{ max(0, round(($total - $concluidos) * 0.25)) }}h restantes</span>
            </div>
        </div>

        <!-- PESQUISA -->
        <div style="margin-bottom: var(--space-lg);" class="search-container">

            <div style="position: relative; flex: 1; min-width: 250px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2"
                    style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" wire:model.live.debounce.500ms="search"
                    placeholder="Pesquisar cliente, endereço ou hidrômetro..." class="form-input"
                    style="padding-left: 2.5rem;">
            </div>
        </div>
        <h3
            style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
            Próximas Leituras
        </h3>

        <!-- LISTA DE ROTEIROS -->
        @forelse($roteiros as $roteiro)
            <div class="roteiro-card @if ($roteiro->lido_em) concluido @endif"
                @if (!$roteiro->lido_em) wire:click="abrirLeitura({{ $roteiro->id }})"
                 style="cursor: pointer;" @endif
                @if ($roteiro->status != 'Concluido') onclick="openLeituraSheet()" @endif>

                <div class="roteiro-card-header">
                    <div class="roteiro-numero"
                        @if ($roteiro->status == 'Concluido') style="background: var(--success)" @else style="background: var(--primary)" @endif>
                        {{ $roteiro->ordem }}</div>
                    <div class="roteiro-endereco-info">
                        <div class="roteiro-endereco">
                            {{ $roteiro->cliente->endereco ?? 'Endereço não disponível' }}
                            @if ($roteiro->leitura->cliente->numero ?? false)
                                , {{ $roteiro->cliente->numero }}
                            @endif
                        </div>
                        <div class="roteiro-cliente">
                            {{ $roteiro->cliente->nome_completo ?? 'Cliente não encontrado' }}
                        </div>
                    </div>
                </div>
                <div class="roteiro-card-body">
                    <div class="roteiro-medidor-info">
                        <span class="roteiro-medidor-tag">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                            {{ $roteiro->cliente->medidor->numero_hidrometro ?? 'N/A' }}

                        </span>
                        <span class="roteiro-ultima-leitura">
                            @if ($roteiro->status == 'Concluido')
                                Atual: {{ number_format($roteiro->leitura_atual, 0, ',', '.') }} m³
                            @else
                                Última: {{ number_format($roteiro->leitura_anterior, 0, ',', '.') }} m³
                            @endif
                        </span>
                    </div>
                </div>
                <div class="roteiro-card-footer">
                    @if ($roteiro->status == 'Concluido')
                        <span class="roteiro-status concluido">
                            <span class="roteiro-status-dot"></span>
                            Concluído
                        </span>
                        <button class="roteiro-btn-lancar" disabled>✓ Feito</button>
                    @else
                        <span class="roteiro-status pendente">
                            <span class="roteiro-status-dot"></span>
                            Pendente
                        </span>
                        <button class="roteiro-btn-lancar" type="button">Lançar</button>
                    @endif
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" style="margin-bottom: var(--space-md); opacity: 0.5;">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
                    <rect x="9" y="3" width="6" height="4" rx="2" />
                    <path d="M9 14h.01" />
                    <path d="M12 14h.01" />
                    <path d="M15 14h.01" />
                </svg>
                <p style="font-weight: 500;">Nenhum roteiro encontrado</p>
                <p style="font-size: var(--small-size);">Você não possui leituras atribuídas no momento.</p>
            </div>
        @endforelse

        <!-- PAGINAÇÃO -->
        @if ($roteiros->hasPages())
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--space-xl); margin-bottom: var(--space-xl);">
                <span style="font-size: var(--small-size); color: var(--text-muted);">
                    Página {{ $roteiros->currentPage() }} de {{ $roteiros->lastPage() }}
                </span>
                <div style="display: flex; gap: var(--space-xs);">
                    <!-- Anterior -->
                    <button class="btn btn-sm btn-ghost" wire:click="previousPage"
                        @if ($roteiros->onFirstPage()) disabled @endif>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>

                    <!-- Números das páginas -->
                    @php
                        $start = max(1, $roteiros->currentPage() - 1);
                        $end = min($roteiros->lastPage(), $roteiros->currentPage() + 1);
                    @endphp

                    @if ($start > 1)
                        <button class="btn btn-sm btn-ghost" style="min-width: 32px; justify-content: center;"
                            wire:click="gotoPage(1)">1</button>
                        @if ($start > 2)
                            <span
                                style="display: flex; align-items: center; padding: 0 var(--space-sm); color: var(--text-muted);">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        <button class="btn btn-sm @if ($i === $roteiros->currentPage()) btn-primary @else btn-ghost @endif"
                            style="min-width: 32px; justify-content: center;"
                            wire:click="gotoPage({{ $i }})">{{ $i }}</button>
                    @endfor

                    @if ($end < $roteiros->lastPage())
                        @if ($end < $roteiros->lastPage() - 1)
                            <span
                                style="display: flex; align-items: center; padding: 0 var(--space-sm); color: var(--text-muted);">...</span>
                        @endif
                        <button class="btn btn-sm btn-ghost" style="min-width: 32px; justify-content: center;"
                            wire:click="gotoPage({{ $roteiros->lastPage() }})">{{ $roteiros->lastPage() }}</button>
                    @endif

                    <!-- Próximo -->
                    <button class="btn btn-sm btn-ghost" wire:click="nextPage"
                        @if (!$roteiros->hasMorePages()) disabled @endif>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </section>
    <!-- BOTTOM SHEET - LANÇAR LEITURA -->
    <div class="leitura-sheet-overlay" id="leituraOverlay" onclick="closeLeituraSheet()"></div>
    <div class="leitura-sheet" id="leituraSheet" wire:ignore.self>
        <div class="leitura-sheet-handle"></div>
        <div class="leitura-sheet-header">
            <span class="leitura-sheet-title">Lançar Leitura</span>
            <button type="button" class="leitura-sheet-close" onclick="closeLeituraSheet()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="18" x2="6" y1="6" y2="18" />
                    <line x1="6" x2="18" y1="6" y2="18" />
                </svg>
            </button>
        </div>
        <div class="leitura-sheet-body">
            <div class="leitura-cliente-info">
                <div class="leitura-cliente-nome" id="sheetClienteNome">{{ $nome }}</div>
                <div class="leitura-cliente-endereco" id="sheetClienteEndereco">{{ $endereco }} - Apto 42</div>
                <div class="leitura-cliente-medidor">
                    <span class="leitura-cliente-medidor-tag" id="sheetMedidorNumero">{{ $matricula }}</span>
                    <span style="font-size: var(--small-size); color: var(--text-muted);">Última: <strong
                            id="sheetUltimaLeitura">{{ $ultimaLeitura }}</strong> m³</span>
                </div>
            </div>
            @if ($steps == 1)
                <div class="leitura-input-area">
                    <label class="leitura-input-label">Nova Leitura (m³)</label>
                    <p class="leitura-input-hint">Digite o valor atual do medidor. Última leitura: <strong
                            id="hintUltimaLeitura">{{ $ultimaLeitura }}</strong> m³</p>
                    <div class="leitura-input-wrapper">
                        <input type="number" class="leitura-input" id="inputLeitura" placeholder="0.000"
                            wire:model.live='leitura_atual'>
                    </div>
                </div>
            @endif
            @if ($steps == 2)
                <div class="leitura-cliente-info">

                    <p
                        style="display: flex; justify-content: space-between; font-size: var(--normal-size); padding: var(--space-xs) 0;">
                        <span style="color: var(--text-muted);">Leitura Anterior:</span>
                        <strong>{{ $ultimaLeitura }} m³</strong>
                    </p>
                    <p
                        style="display: flex; justify-content: space-between; font-size: var(--normal-size); padding: var(--space-xs) 0; border-top: 1px solid var(--neutral);">
                        <span>Leitura Atual:</span>
                        <strong style="color: var(--primary);">{{ $leitura_atual }} m³</strong>
                    </p>
                    <p
                        style="display: flex; justify-content: space-between; font-size: var(--normal-size); padding: var(--space-xs) 0; border-top: 1px solid var(--neutral);">
                        <span>Consumo Calculado:</span>
                        <strong style="color: var(--success);">{{ (float) $leitura_atual - (float) $ultimaLeitura }}
                            m³</strong>
                    </p>
                </div>
            @endif
            {{-- @if ($leitura_atual)
                <div class="leitura-consumo-preview" id="consumoPreview" style="display: block;">
                    <div class="leitura-consumo-valor" id="consumoValor">{{ $leitura_atual }}</div>
                    <div class="leitura-consumo-label">m³ consumidos</div>
                    <div class="leitura-consumo-variacao normal" id="consumoVariacao">Consumo dentro da média</div>
                </div>
            @endif --}}
            <div class="leitura-anomalia" id="anomaliaAlert">
                <div class="leitura-anomalia-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" x2="12" y1="9" y2="13" />
                        <line x1="12" x2="12.01" y1="17" y2="17" />
                    </svg>
                    Anomalia Detectada
                </div>
                <div class="leitura-anomalia-desc">O consumo está muito acima da média histórica. Verifique se o
                    valor foi digitado corretamente.</div>
            </div>

            <div style="display: flex; gap: var(--space-sm); margin-bottom: var(--space-md);">
                <button type="button" class="btn btn-outline" style="flex: 1; justify-content: center;"
                    onclick="closeLeituraSheet()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="18" x2="6" y1="6" y2="18" />
                        <line x1="6" x2="18" y1="6" y2="18" />
                    </svg>
                    Cancelar
                </button>
                @if ($steps == 1)
                    <button type="button" class="mobile-btn-primary" style="flex: 2;" id="btnSalvarLeitura"
                        wire:click='pagina'>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Seguir
                    </button>
                @endif
                @if ($steps == 2)
                    <button wire:click='CadastrarLeitura' class="mobile-btn-primary" style="flex: 2;"
                        id="btnSalvarLeitura" wire:>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Salvar Leitura
                    </button>
                @endif
                @error('fatura_id')
                    <small style="color:var(--danger)">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-ghost" style="width: 100%; justify-content: center; color: var(--danger);"
                onclick="showToast('Ocorrência registrada', 'warning')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path
                        d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" x2="12" y1="9" y2="13" />
                    <line x1="12" x2="12.01" y1="17" y2="17" />
                </svg>
                Registrar Ocorrência
            </button>
        </div>
    </div>





    <!-- ===== MODAL: EDITAR DADOS PESSOAIS ===== -->
    <div class="leitura-sheet-overlay" id="modalDadosOverlay" onclick="closeModal('modalDados')"></div>
    <div class="leitura-sheet" id="modalDados" style="max-height: 90vh;" wire:ignore.self>
        <div class="leitura-sheet-handle"></div>
        <div class="leitura-sheet-header">
            <span class="leitura-sheet-title">Editar Dados Pessoais</span>
            <button class="leitura-sheet-close" onclick="closeModal('modalDados')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="18" x2="6" y1="6" y2="18" />
                    <line x1="6" x2="18" y1="6" y2="18" />
                </svg>
            </button>
        </div>
        <form wire:submit.prevent='save' class="leitura-sheet-body">
            <div style="text-align: center; margin-bottom: var(--space-lg);">
                <div
                    style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md); color: var(--white); font-weight: 700; font-size: 1.75rem; border: 3px solid var(--neutral-dark);">
                    JL</div>
                <button class="btn btn-sm btn-outline" style="margin: 0 auto; display: inline-flex;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                        <circle cx="12" cy="13" r="4" />
                    </svg>
                    Alterar Foto
                </button>
            </div>

            <div class="form-group">
                <label class="form-label">Nome Completo</label>
                <input type="text" class="form-input" value="João Leiturista" id="editNome"
                    wire:model='nomeleiturista'>
            </div>

            <div class="form-group">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-input" value="joao@aquanexus.pt" id="editEmail"
                    wire:model='email'>
            </div>

            <div class="form-group">
                <label class="form-label">Telemóvel</label>
                <input type="text" class="form-input" wire:model='telefone'>
            </div>

            <div class="form-group">
                <label class="form-label">Zona de Atuação</label>
                <select class="form-select" wire:model='zona' id="editZona">
                    <option value="norte" selected>Zona Norte</option>
                    <option value="sul">Zona Sul</option>
                    <option value="centro">Zona Centro</option>
                    <option value="leste">Zona Leste</option>
                </select>

            </div>
            <div class="form-group">
                <button type="button" class="mobile-btn-primary" style="flex: 2;" onclick="openSenhaPessoal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Mudar Senha
                </button>
            </div>

            <div style="display: flex; gap: var(--space-sm); margin-top: var(--space-lg);">
                <button type="button" class="btn btn-outline" style="flex: 1; justify-content: center;"
                    onclick="closeModal('modalDados')">Cancelar</button>

                <button type="submit" class="mobile-btn-primary" style="flex: 2;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>


    <div class="leitura-sheet-overlay" id="modalsenhaOverlay" onclick="closeModal('modalsenha')"></div>
    <div class="leitura-sheet" id="modalsenha" style="max-height: 90vh;" wire:ignore.self>
        <div class="leitura-sheet-handle"></div>
        <div class="leitura-sheet-header">
            <span class="leitura-sheet-title">Mudar Senha</span>
            <button class="leitura-sheet-close" onclick="closeModal('modalsenha')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="18" x2="6" y1="6" y2="18" />
                    <line x1="6" x2="18" y1="6" y2="18" />
                </svg>
            </button>
        </div>
        <form wire:submit.prevent='salvarSenha' class="leitura-sheet-body">


            <div class="form-group">
                <label class="form-label">Senha Actual</label>
                <input type="password" class="form-input" id="editNome" wire:model='senha'>
                @error('senha')
                    <small style="color: var(--danger)">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nova Senha</label>
                <input type="password" class="form-input" id="editEmail" wire:model='novasenha'>
                @error('novasenha')
                    <small style="color: var(--danger)">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Confirmar Senha</label>
                <input type="password" class="form-input" wire:model='confirmarSenha'>
                @error('confirmarSenha')
                    <small style="color: var(--danger)">{{ $message }}</small>
                @enderror
            </div>


            <div style="display: flex; gap: var(--space-sm); margin-top: var(--space-lg);">
                <button type="button" class="btn btn-outline" style="flex: 1; justify-content: center;"
                    onclick="closeModal('modalsenha')">Cancelar</button>

                <button type="submit" class="mobile-btn-primary" style="flex: 2;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Salvar senha
                </button>
            </div>
        </form>
    </div>
</div>
