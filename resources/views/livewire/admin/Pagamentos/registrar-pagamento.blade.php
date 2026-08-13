<div class="modal-overlay" id="modal-novo-pagamento" wire:ignore.self>
    <form wire:submit.prevent='confirmarPagamento' class="modal modal-lg"
        style="max-width: 900px; height: 92vh; display: flex; flex-direction: column;">

        <!-- ═══ HEADER ═══ -->
        <div class="modal-header" style="flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: var(--space-md);">
                <div class="header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                </div>
                <div>
                    <h3 class="modal-title">Registrar Pagamento</h3>
                    <p class="modal-subtitle">
                        {{ $fatura['codigo'] ?? 'Selecione uma fatura' }} — {{ $cliente['nome'] ?? '' }}
                    </p>
                </div>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('modal-novo-pagamento')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        @if ($faturaId)
            <!-- ═══ ABAS ═══ -->
            <div class="tabs-bar">
                <button type="button" wire:click="setAba('tab-pagamento')" id="btn-tab-pagamento"
                    class="tab-btn   @if ($abaAtiva === 'tab-pagamento') active @endif"
                    onclick="switchTab('tab-pagamento')">
                    <span class="tab-icon">💳</span>
                    <span class="tab-label">Pagamento</span>
                </button>
                <button type="button" wire:click="setAba('tab-metodosPagamento')" id="btn-tab-comprovante"
                    class="tab-btn @if ($abaAtiva === 'tab-metodosPagamento') active @endif"
                    onclick="switchTab('tab-metodosPagamento')">
                    <span class="tab-icon">📄</span>
                    <span class="tab-label">Metodos Pagamento</span>
                    @if ($mostrarComprovante)
                        <span class="tab-badge">✓</span>
                    @endif
                </button>
                <button type="button" wire:click="setAba('tab-comprovante')" id="btn-tab-comprovante"
                    class="tab-btn @if ($abaAtiva === 'tab-comprovante') active @endif"
                    onclick="switchTab('tab-comprovante')">
                    <span class="tab-icon">📄</span>
                    <span class="tab-label">Comprovante</span>
                    @if ($mostrarComprovante)
                        <span class="tab-badge">✓</span>
                    @endif
                </button>
            </div>

            <!-- ═══ CONTEÚDO COM SCROLL ═══ -->
            <div class="modal-scroll-area">

                <!-- ═══ ABA 1: PAGAMENTO ═══ -->
                <div id="tab-pagamento" class="tab-content @if ($abaAtiva === 'tab-pagamento') active @endif">
                    <div class="modal-body">
                        @php
                            $valorApagar = empty($saldoDevedor) ? $fatura['valor_base'] : $saldoDevedor;

                            $pct25 = round($valorApagar * 0.25, 2);
                            $pct50 = round($valorApagar * 0.5, 2);
                            $pct75 = round($valorApagar * 0.75, 2);
                        @endphp
                        <!-- Card Saldo Devedor -->
                        <div class="saldo-card">
                            <div class="saldo-label">Saldo Devedor</div>
                            <div class="saldo-valor">
                                MZN {{ number_format($valorApagar, 2) }}
                            </div>
                            <div class="saldo-meta">
                                <span>{{ $fatura['codigo'] }}</span>
                                <span class="meta-sep">|</span>
                                <span>{{ $cliente['nome'] }}</span>
                            </div>
                            <div style="margin-top: var(--space-sm);">
                                <span class="status-badge status-{{ strtolower($fatura['status'] ?? 'pendente') }}">
                                    {{ $fatura['status'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Detalhes da Fatura (Resumo) -->
                        <div class="fatura-resumo">
                            <div class="resumo-grid">
                                <div class="resumo-item">
                                    <span class="resumo-label">Valor Base</span>
                                    <span class="resumo-valor">MZN
                                        {{ number_format($fatura['valor_base'] ?? 0, 2, ',', '.') }}</span>
                                </div>
                                <div class="resumo-item">
                                    <span class="resumo-label">Multa</span>
                                    <span class="resumo-valor resumo-multa">+ MZN
                                        {{ number_format($multaAtual, 2, ',', '.') }}</span>
                                </div>
                                <div class="resumo-item">
                                    <span class="resumo-label">Juros</span>
                                    <span class="resumo-valor resumo-juros">+ MZN
                                        {{ number_format($jurosAtual, 2, ',', '.') }}</span>
                                </div>
                                <div class="resumo-item">
                                    <span class="resumo-label">Desconto</span>
                                    <span class="resumo-valor resumo-desconto">- MZN
                                        {{ number_format($fatura['desconto'] ?? 0, 2, ',', '.') }}</span>
                                </div>
                                <div class="resumo-item resumo-total">
                                    <span class="resumo-label">Valor Total</span>
                                    <span class="resumo-valor">MZN
                                        {{ number_format($fatura['valor_total'], 2, ',', '.') }}</span>
                                </div>
                            </div>
                            @if ($diasAtraso > 0)
                                <div class="atraso-alert">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                        <line x1="12" y1="9" x2="12" y2="13" />
                                        <line x1="12" y1="17" x2="12.01" y2="17" />
                                    </svg>
                                    <span>{{ $diasAtraso }} dias de atraso ({{ $mesesAtraso }}
                                        {{ $mesesAtraso == 1 ? 'mês' : 'meses' }})</span>
                                </div>
                            @endif
                        </div>

                        <!-- ═══ PARCELAS ═══ -->
                        {{-- @if (!empty($parcelasPendentes) && count($parcelasPendentes) > 1)
                            <div class="parcelas-section">
                                <h5 class="section-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect width="20" height="14" x="2" y="5" rx="2" />
                                        <line x1="2" x2="22" y1="10" y2="10" />
                                    </svg>
                                    Selecione a Parcela
                                    <span class="parcelas-count">{{ count($parcelasPendentes) }} parcelas</span>
                                </h5>

                                <div class="parcelas-grid">
                                    @foreach ($parcelasPendentes as $index => $parcela)
                                        @php
                                            $parcelaNumero = $index + 1;
                                            $totalParcelas = count($parcelasPendentes);
                                            $isPaga = ($parcela['status'] ?? 'Pendente') === 'Paga';
                                            $isSelecionada =
                                                isset($parcelaSelecionada) && $parcelaSelecionada == $parcela['id'];
                                        @endphp

                                        <div class="parcela-card {{ $isPaga ? 'paga' : '' }} {{ $isSelecionada ? 'selecionada' : '' }}"
                                            {{ $isPaga ? '' : 'wire:click=selecionarParcela(' . $parcela['id'] . ')' }}>

                                            <div class="parcela-check">
                                                @if ($isPaga || $isSelecionada)
                                                    <svg width="12" height="12" viewBox="0 0 24 24"
                                                        fill="none" stroke="white" stroke-width="3">
                                                        <path d="M20 6 9 17l-5-5" />
                                                    </svg>
                                                @endif
                                            </div>

                                            <div class="parcela-numero">{{ $parcelaNumero }}/{{ $totalParcelas }}
                                            </div>
                                            <div class="parcela-valor">
                                                MZN {{ number_format($parcela['valor_parcela'], 2, ',', '.') }}
                                            </div>
                                            <div
                                                class="parcela-status status-{{ strtolower($parcela['status'] ?? 'pendente') }}">
                                                {{ $parcela['status'] ?? 'Pendente' }}
                                            </div>
                                            @if ($parcela['data_vencimento'])
                                                <div class="parcela-vencimento">Venc:
                                                    {{ $parcela['data_vencimento'] }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Barra de Progresso -->
                                @php
                                    $totalParcelas = count($parcelasPendentes);
                                    $parcelasPagas = collect($parcelasPendentes)->where('status', 'Paga')->count();
                                    $percentualQuitado =
                                        $totalParcelas > 0 ? round(($parcelasPagas / $totalParcelas) * 100) : 0;
                                @endphp
                                <div class="progresso-parcelas">
                                    <div class="progresso-header">
                                        <span>{{ $parcelasPagas }} de {{ $totalParcelas }} parcelas quitadas</span>
                                        <span class="progresso-pct">{{ $percentualQuitado }}%</span>
                                    </div>
                                    <div class="progresso-barra-bg">
                                        <div class="progresso-barra-fill" style="width: {{ $percentualQuitado }}%;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Edição de Valor da Parcela -->
                                @if ($parcelaSelecionada && !$editarValorParcela)
                                    <div class="edicao-parcela-hint">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                        <span>Valor da parcela: <strong>MZN
                                                {{ number_format($valorParcela ?? 0, 2, ',', '.') }}</strong></span>
                                        <button type="button" class="btn-editar-valor"
                                            wire:click="habilitarEdicaoValor">
                                            Editar valor
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif --}}

                        <!-- ═══ VALOR DO PAGAMENTO ═══ -->
                        <div class="valor-section">
                            <div class="valor-header">
                                <span class="section-title-text">Valor do Pagamento</span>
                                <span class="valor-max">Máx: MZN
                                    {{ number_format($valorPago, 2, ',', '.') }}</span>
                            </div>

                            <div class="valor-input-wrapper">
                                <span class="valor-prefix">MZN</span>
                                <input type="number" class="form-input valor-input" wire:model.live="valorPago"
                                    step="0.01" min="0.01" max="{{ $valorPago }}" placeholder="0,00">
                            </div>
                            @error('valorPago')
                                <span class="error-text">{{ $message }}</span>
                            @enderror

                            <!-- Aviso de variação de parcela -->
                            @if ($parcelaSelecionada && $editarValorParcela)
                                <div
                                    class="variacao-alert {{ $valorPago > ($valorParcela ?? 0) ? 'positivo' : ($valorPago < ($valorParcela ?? 0) ? 'negativo' : '') }}">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    @if ($valorPago > ($valorParcela ?? 0))
                                        <span>Pagando <strong>MZN
                                                {{ number_format($valorPago - ($valorParcela ?? 0), 2, ',', '.') }}</strong>
                                            a mais que o valor da parcela negociada</span>
                                    @elseif($valorPago < ($valorParcela ?? 0))
                                        <span>Pagando <strong>MZN
                                                {{ number_format(($valorParcela ?? 0) - $valorPago, 2, ',', '.') }}</strong>
                                            a menos que o valor da parcela negociada</span>
                                    @else
                                        <span>Valor igual ao da parcela negociada</span>
                                    @endif
                                </div>
                            @endif

                            <!-- Botões de Percentual -->
                            <div class="percentual-botoes">

                                <button type="button" class="pct-btn"
                                    wire:click="updateValorPagos({{ $pct25 }})">
                                    25%
                                    <span class="pct-valor">MZN {{ number_format($pct25, 2, ',', '.') }}</span>
                                </button>

                                <button type="button" class="pct-btn"
                                    wire:click="updateValorPagos({{ $pct50 }})">
                                    50%
                                    <span class="pct-valor">MZN {{ number_format($pct50, 2, ',', '.') }}</span>
                                </button>

                                <button type="button" class="pct-btn"
                                    wire:click="updateValorPagos({{ $pct75 }})">
                                    75%
                                    <span class="pct-valor">MZN {{ number_format($pct75, 2, ',', '.') }}</span>
                                </button>

                                <button type="button" class="pct-btn pct-total"
                                    wire:click="updateValorPagos({{ $valorApagar }})">
                                    Total
                                    <span class="pct-valor">MZN
                                        {{ number_format($valorApagar, 2, ',', '.') }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- ═══ HISTÓRICO DE PAGAMENTOS ═══ -->
                        @if (!empty($historicoPagamentos))
                            <div class="historico-section">
                                <h5 class="section-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                        <polyline points="22 4 12 14.01 9 11.01" />
                                    </svg>
                                    Pagamentos Anteriores
                                    <span class="historico-count">{{ count($historicoPagamentos) }}</span>
                                </h5>
                                <div class="historico-lista">
                                    @foreach ($historicoPagamentos as $pag)
                                        <div class="historico-item">
                                            <div class="historico-icon">
                                                <svg width="14" height="14" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20 6 9 17l-5-5" />
                                                </svg>
                                            </div>
                                            <div class="historico-info">
                                                <div class="historico-valor">MZN
                                                    {{ number_format($pag['valor'], 2, ',', '.') }}</div>
                                                <div class="historico-meta">{{ $pag['metodo'] }} —
                                                    {{ $pag['data'] }}</div>
                                            </div>
                                            <div class="historico-usuario">{{ $pag['usuario'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif


                    </div>
                </div>


                <div id="tab-metodosPagamento" class="tab-content @if ($abaAtiva === 'tab-metodosPagamento') active @endif">
                    <!-- ═══ DETALHES DO PAGAMENTO ═══ -->
                    <div class="modal-body detalhes-section">
                        <h5 class="section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg>
                            Detalhes do Pagamento
                        </h5>

                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Método de Pagamento <span class="required">*</span></label>
                                <select class="form-select" wire:model="metodoPagamento" required>
                                    <option value="">Selecione o método...</option>
                                    <option value="Dinheiro">Dinheiro</option>
                                    <option value="Mpesa">Mpesa</option>
                                    <option value="Emola">Emola</option>
                                    <option value="Transferência Bancária">Transferência Bancária</option>
                                </select>
                                @error('metodoPagamento')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Data do Pagamento <span class="required">*</span></label>
                                <input type="date" class="form-input" wire:model="dataPagamento"
                                    max="{{ now()->format('Y-m-d') }}">
                                @error('dataPagamento')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Banco / Instituição</label>
                                <input type="text" class="form-input" wire:model="banco"
                                    placeholder="Ex: BCI, Millennium BIM, Standard Bank">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Código de Transação / TxID</label>
                                <input type="text" class="form-input" wire:model="codigoTransacao"
                                    placeholder="Gerado automaticamente" readonly
                                    style="background: var(--neutral); color: var(--text-muted);">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Número do Comprovante</label>
                            <input type="text" class="form-input" wire:model="numeroComprovante"
                                placeholder="Gerado automaticamente" readonly
                                style="background: var(--neutral); color: var(--text-muted);">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Observações</label>
                            <textarea class="form-textarea" wire:model="observacoes" placeholder="Informações adicionais sobre o pagamento..."
                                rows="2"></textarea>
                        </div>

                        <!-- Upload de Comprovante -->
                        <div class="upload-section">
                            <label class="form-label">Anexar Comprovante</label>
                            <div class="upload-area" onclick="document.getElementById('comprovante-file').click()">
                                <input type="file" id="comprovante-file" wire:model="comprovante"
                                    accept=".pdf,.jpg,.jpeg,.png" style="display: none;">

                                @if ($comprovante)
                                    <div class="upload-preview">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                            stroke="var(--success)" stroke-width="1.5">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                            <polyline points="14 2 14 8 20 8" />
                                            <path d="M9 15l2 2 4-4" />
                                        </svg>
                                        <span
                                            class="upload-filename">{{ $comprovante->getClientOriginalName() }}</span>
                                        <span class="upload-filesize">{{ round($comprovante->getSize() / 1024, 1) }}
                                            KB</span>
                                        <button type="button" class="upload-remove"
                                            wire:click="$set('comprovante', null)">Remover</button>
                                    </div>
                                @else
                                    <div class="upload-placeholder">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="var(--text-muted)" stroke-width="1.5">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="17 8 12 3 7 8" />
                                            <line x1="12" y1="3" x2="12" y2="15" />
                                        </svg>
                                        <span class="upload-title">Clique para selecionar arquivo</span>
                                        <span class="upload-subtitle">PDF, JPG ou PNG até 5MB</span>
                                    </div>
                                @endif
                            </div>
                            @error('comprovante')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <label class="checkbox-wrapper">
                            <input type="checkbox" wire:model="gerarRecibo">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">
                                <strong>Gerar recibo</strong> — Enviar comprovante por e-mail ao cliente
                            </span>
                        </label>
                    </div>
                </div>
                <!-- ═══ ABA 2: COMPROVANTE ═══ -->
                <div id="tab-comprovante" class="tab-content @if ($abaAtiva === 'tab-comprovante') active @endif">
                    <div class="modal-body">

                        @if ($mostrarComprovante)
                            <!-- Comprovante Estruturado -->

                            <div class="comprovante-wrapper" id="comprovante-pdf">
                                <iframe src="{{ asset('pdfs/' . $relatorio['filename']) }}" width="100%"
                                    height="600px">
                                </iframe>
                            </div>
                            <!-- Ações do Comprovante -->
                            <div class="comp-actions">
                                <button type="button" class="btn-comp btn-comp-print" onclick="window.print()">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M6 9V2h12v7" />
                                        <path
                                            d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                        <path d="M6 14h12v8H6z" />
                                    </svg>
                                    Imprimir
                                </button>
                                <button type="button" class="btn-comp btn-comp-pdf"
                                    onclick="baixarComprovantePDF()">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" y1="15" x2="12" y2="3" />
                                    </svg>
                                    Baixar PDF
                                </button>
                                <button type="button" class="btn-comp btn-comp-email"
                                    onclick="enviarComprovanteEmail()">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg>
                                    Enviar por E-mail
                                </button>
                            </div>
                        @else
                            <!-- Estado Vazio do Comprovante -->
                            <div class="comp-empty">
                                <div class="comp-empty-icon">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" y1="13" x2="8" y2="13" />
                                        <line x1="16" y1="17" x2="8" y2="17" />
                                        <polyline points="10 9 9 9 8 9" />
                                    </svg>
                                </div>
                                <h4>Nenhum comprovante disponível</h4>
                                <p>Realize um pagamento para gerar o comprovante.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ═══ FOOTER DINÂMICO ═══ -->
            <div id="footer-pagamento" class="modal-footer tab-footer active">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-novo-pagamento')">
                    Cancelar
                </button>
                @if (!$mostrarComprovante)
                    @if ($abaAtiva != 'tab-metodosPagamento')
                        <button type="button" class="btn btn-primary" wire:click="setAba('tab-metodosPagamento')">
                            Seguinte
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                style="margin-right: 6px; display: inline; vertical-align: middle;">
                                <path d="M20 6 9 17l-5-5" />
                            </svg>
                        </button>
                    @else
                        <button type="button" class="btn btn-primary" wire:click="setAba('tab-pagamento')">
                            Anterior
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                style="margin-right: 6px; display: inline; vertical-align: middle;">
                                <path d="M20 6 9 17l-5-5" />
                            </svg>
                        </button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                            style="min-width: 220px;">
                            <span wire:loading.remove>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    style="margin-right: 6px; display: inline; vertical-align: middle;">
                                    <path d="M20 6 9 17l-5-5" />
                                </svg>
                                @if ($valorPago <= 0)
                                    Informe o valor
                                @else
                                    Confirmar MZN {{ number_format((float) $valorPago, 2, ',', '.') }}
                                @endif
                            </span>
                            <span wire:loading>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    style="margin-right: 6px; display: inline; vertical-align: middle; animation: spin 1s linear infinite;">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                </svg>
                                Processando...
                            </span>
                        </button>
                    @endif

                @endif
            </div>

            <div id="footer-comprovante" class="modal-footer tab-footer">
                <button type="button" class="btn btn-outline" onclick="switchTab('tab-pagamento')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px; display: inline; vertical-align: middle;">
                        <path d="M19 12H5" />
                        <path d="M12 19l-7-7 7-7" />
                    </svg>
                    Voltar ao Pagamento
                </button>
                <button type="button" class="btn btn-primary" onclick="baixarComprovantePDF()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px; display: inline; vertical-align: middle;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Baixar PDF
                </button>
            </div>
        @else
            <!-- Sem fatura selecionada -->
            <div class="modal-body empty-state" style="flex: 1;">
                <div class="empty-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <line x1="2" x2="22" y1="10" y2="10" />
                    </svg>
                </div>
                <h4>Nenhuma fatura selecionada</h4>
                <p>Selecione uma fatura na lista para registrar o pagamento.</p>
            </div>
        @endif
    </form>
</div>

<!-- ═══════════════════════════════════════════════════════════════ -->
<!-- ESTILOS DA MODAL DE PAGAMENTO                                   -->
<!-- ═══════════════════════════════════════════════════════════════ -->
<style>
    /* ─── Animações ─── */
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* ─── Header ─── */
    .header-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .modal-subtitle {
        font-size: var(--small-size);
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* ─── Tabs ─── */
    .tabs-bar {
        display: flex;
        border-bottom: 1px solid var(--border);
        background: var(--neutral);
        flex-shrink: 0;
    }

    .tab-btn {
        flex: 1;
        padding: 14px;
        background: none;
        border: none;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        color: var(--text-muted);
        border-bottom: 2px solid transparent;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
    }

    .tab-btn:hover {
        color: var(--primary-light);
        background: rgba(0, 51, 102, 0.04);
    }

    .tab-btn.active {
        color: var(--primary);
        font-weight: 600;
        border-bottom-color: var(--primary);
        background: rgba(0, 51, 102, 0.06);
    }

    .tab-icon {
        font-size: 16px;
    }

    .tab-badge {
        position: absolute;
        top: 8px;
        right: 20%;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--success);
        color: white;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ─── Scroll Area ─── */
    .modal-scroll-area {
        flex: 1;
        overflow: hidden;
        position: relative;
        background: var(--white);
    }

    /* ─── Tab Content ─── */
    .tab-content {
        display: none;
        height: 100%;
        overflow-y: auto;
        animation: fadeIn 0.3s ease;
    }

    .tab-content.active {
        display: block;
    }

    /* ─── Saldo Card ─── */
    .saldo-card {
        text-align: center;
        padding: var(--space-lg);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--primary-lighter) 100%);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-lg);
        color: var(--white);
        box-shadow: var(--shadow-lg);
    }

    .saldo-label {
        font-size: var(--label-size);
        opacity: 0.9;
        margin-bottom: var(--space-xs);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .saldo-valor {
        font-size: var(--headline-size);
        font-weight: 700;
        font-family: var(--font-headline);
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .saldo-meta {
        margin-top: var(--space-sm);
        font-size: var(--small-size);
        opacity: 0.85;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-sm);
    }

    .meta-sep {
        opacity: 0.5;
    }

    .status-badge {
        display: inline-block;
        padding: var(--space-xs) var(--space-md);
        border-radius: var(--radius-md);
        font-size: var(--small-size);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .status-pendente {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .status-vencida {
        background: var(--danger);
        color: white;
    }

    .status-paga {
        background: var(--success);
        color: white;
    }

    .status-parcial {
        background: var(--warning);
        color: white;
    }

    .status-negociada {
        background: var(--purple);
        color: white;
    }

    /* ─── Fatura Resumo ─── */
    .fatura-resumo {
        background: var(--white);
        border: 1px solid var(--neutral-dark);
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        margin-bottom: var(--space-lg);
    }

    .resumo-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-md);
    }

    .resumo-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-sm) 0;
        border-bottom: 1px dashed var(--neutral-dark);
    }

    .resumo-item.resumo-total {
        grid-column: 1 / -1;
        border-top: 2px solid var(--neutral-dark);
        border-bottom: none;
        padding-top: var(--space-md);
        margin-top: var(--space-xs);
    }

    .resumo-label {
        font-size: var(--small-size);
        color: var(--text-secondary);
    }

    .resumo-valor {
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--text-primary);
        font-family: var(--font-headline);
    }

    .resumo-multa {
        color: var(--danger);
    }

    .resumo-juros {
        color: var(--warning);
    }

    .resumo-desconto {
        color: var(--success);
    }

    .resumo-total .resumo-valor {
        font-size: var(--body-size);
        color: var(--primary);
    }

    .atraso-alert {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        margin-top: var(--space-md);
        padding: var(--space-sm) var(--space-md);
        background: var(--warning-light);
        border: 1px solid var(--warning);
        border-radius: var(--radius-md);
        color: var(--warning);
        font-size: var(--small-size);
        font-weight: 500;
    }

    /* ─── Parcelas ─── */
    .parcelas-section {
        margin-bottom: var(--space-lg);
    }

    .section-title {
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: var(--space-md);
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .section-title svg {
        color: var(--tertiary);
    }

    .parcelas-count {
        margin-left: auto;
        font-size: var(--small-size);
        color: var(--text-muted);
        font-weight: 400;
        background: var(--neutral);
        padding: 2px 8px;
        border-radius: var(--radius-full);
    }

    .parcelas-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--space-md);
        margin-bottom: var(--space-md);
    }

    .parcela-card {
        position: relative;
        padding: var(--space-md);
        border-radius: var(--radius-lg);
        border: 2px solid var(--neutral-dark);
        background: var(--white);
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }

    .parcela-card:hover:not(.paga) {
        border-color: var(--primary-lighter);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .parcela-card.selecionada {
        border-color: var(--primary);
        background: linear-gradient(135deg, rgba(0, 51, 102, 0.05) 0%, rgba(51, 102, 153, 0.08) 100%);
        box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
    }

    .parcela-card.paga {
        border-color: var(--success);
        background: var(--success-light);
        cursor: not-allowed;
        opacity: 0.7;
    }

    .parcela-check {
        position: absolute;
        top: var(--space-sm);
        right: var(--space-sm);
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2px solid var(--neutral-darker);
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .parcela-card.selecionada .parcela-check {
        border-color: var(--primary);
        background: var(--primary);
    }

    .parcela-card.paga .parcela-check {
        border-color: var(--success);
        background: var(--success);
    }

    .parcela-numero {
        font-size: var(--small-size);
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: var(--space-xs);
    }

    .parcela-valor {
        font-size: var(--body-size);
        font-weight: 700;
        color: var(--text-primary);
        font-family: var(--font-headline);
        margin-bottom: var(--space-xs);
    }

    .parcela-status {
        font-size: var(--small-size);
        font-weight: 600;
        padding: 2px 8px;
        border-radius: var(--radius-full);
        display: inline-block;
    }

    .status-pendente {
        color: var(--warning);
        background: var(--warning-light);
    }

    .status-paga {
        color: var(--success);
        background: rgba(5, 150, 105, 0.15);
    }

    .status-parcial {
        color: var(--tertiary);
        background: rgba(0, 131, 143, 0.1);
    }

    .parcela-vencimento {
        margin-top: var(--space-xs);
        font-size: 11px;
        color: var(--text-muted);
    }

    /* ─── Progresso Parcelas ─── */
    .progresso-parcelas {
        margin-bottom: var(--space-md);
    }

    .progresso-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-xs);
        font-size: var(--small-size);
    }

    .progresso-header span:first-child {
        color: var(--text-secondary);
    }

    .progresso-pct {
        font-weight: 700;
        color: var(--primary);
    }

    .progresso-barra-bg {
        width: 100%;
        height: 8px;
        background: var(--neutral-dark);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progresso-barra-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--success) 0%, var(--tertiary) 100%);
        border-radius: var(--radius-full);
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ─── Edição Parcela ─── */
    .edicao-parcela-hint {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-sm) var(--space-md);
        background: linear-gradient(90deg, var(--primary-lighter) 0%, var(--tertiary-light) 100%);
        border-radius: var(--radius-md);
        color: white;
        font-size: var(--small-size);
        margin-top: var(--space-sm);
    }

    .edicao-parcela-hint svg {
        flex-shrink: 0;
    }

    .btn-editar-valor {
        margin-left: auto;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: white;
        padding: 4px 12px;
        border-radius: var(--radius-sm);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-editar-valor:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* ─── Valor Section ─── */
    .valor-section {
        background: var(--neutral);
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        margin-bottom: var(--space-lg);
    }

    .valor-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-md);
    }

    .section-title-text {
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--text-primary);
    }

    .valor-max {
        font-size: var(--small-size);
        color: var(--text-muted);
        background: var(--white);
        padding: 2px 10px;
        border-radius: var(--radius-full);
    }

    .valor-input-wrapper {
        position: relative;
    }

    .valor-prefix {
        position: absolute;
        left: var(--space-md);
        top: 50%;
        transform: translateY(-50%);
        font-size: var(--body-size);
        font-weight: 600;
        color: var(--text-muted);
        pointer-events: none;
    }

    .valor-input {
        padding-left: 3.8rem !important;
        font-size: 1.75rem !important;
        font-weight: 700 !important;
        font-family: var(--font-headline) !important;
        text-align: right !important;
        height: 56px !important;
    }

    /* ─── Variação Alert ─── */
    .variacao-alert {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        margin-top: var(--space-sm);
        padding: var(--space-sm) var(--space-md);
        border-radius: var(--radius-md);
        font-size: var(--small-size);
        animation: slideIn 0.3s ease;
    }

    .variacao-alert.positivo {
        background: var(--success-light);
        color: var(--success);
        border: 1px solid rgba(5, 150, 105, 0.2);
    }

    .variacao-alert.negativo {
        background: var(--warning-light);
        color: var(--warning);
        border: 1px solid rgba(217, 119, 6, 0.2);
    }

    .variacao-alert:not(.positivo):not(.negativo) {
        background: var(--neutral-dark);
        color: var(--text-secondary);
    }

    /* ─── Percentual Botões ─── */
    .percentual-botoes {
        display: flex;
        gap: var(--space-sm);
        margin-top: var(--space-md);
    }

    .pct-btn {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        padding: var(--space-sm) var(--space-xs);
        background: var(--white);
        border: 1px solid var(--neutral-dark);
        border-radius: var(--radius-md);
        cursor: pointer;
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--text-primary);
        transition: all 0.2s;
    }

    .pct-btn:hover {
        border-color: var(--primary-lighter);
        background: rgba(0, 51, 102, 0.04);
        transform: translateY(-1px);
    }

    .pct-btn.pct-total {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .pct-btn.pct-total:hover {
        background: var(--primary-light);
    }

    .pct-valor {
        font-size: 11px;
        font-weight: 400;
        color: var(--text-muted);
    }

    .pct-btn.pct-total .pct-valor {
        color: rgba(255, 255, 255, 0.8);
    }

    /* ─── Histórico ─── */
    .historico-section {
        margin-bottom: var(--space-lg);
    }

    .historico-count {
        margin-left: auto;
        font-size: var(--small-size);
        color: var(--text-muted);
        font-weight: 400;
        background: var(--neutral);
        padding: 2px 8px;
        border-radius: var(--radius-full);
    }

    .historico-lista {
        display: flex;
        flex-direction: column;
        gap: var(--space-xs);
    }

    .historico-item {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-sm) var(--space-md);
        background: var(--white);
        border: 1px solid var(--neutral-dark);
        border-radius: var(--radius-md);
        transition: all 0.2s;
    }

    .historico-item:hover {
        border-color: var(--primary-lighter);
        box-shadow: var(--shadow-sm);
    }

    .historico-icon {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-md);
        background: var(--success-light);
        color: var(--success);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .historico-info {
        flex: 1;
        min-width: 0;
    }

    .historico-valor {
        font-size: var(--body-size);
        font-weight: 600;
        color: var(--text-primary);
    }

    .historico-meta {
        font-size: var(--small-size);
        color: var(--text-muted);
    }

    .historico-usuario {
        font-size: var(--small-size);
        color: var(--text-muted);
        white-space: nowrap;
    }

    /* ─── Detalhes Section ─── */
    .detalhes-section {
        border-top: 1px solid var(--neutral-dark);
        padding-top: var(--space-lg);
    }

    .required {
        color: var(--danger);
    }

    /* ─── Upload Section ─── */
    .upload-section {
        margin-top: var(--space-md);
    }

    .upload-area {
        border: 2px dashed var(--neutral-darker);
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .upload-area:hover {
        border-color: var(--primary-lighter);
        background: rgba(0, 51, 102, 0.02);
    }

    .upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: var(--space-sm);
    }

    .upload-title {
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--text-primary);
    }

    .upload-subtitle {
        font-size: var(--small-size);
        color: var(--text-muted);
    }

    .upload-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: var(--space-xs);
    }

    .upload-filename {
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--text-primary);
        word-break: break-all;
    }

    .upload-filesize {
        font-size: var(--small-size);
        color: var(--text-muted);
    }

    .upload-remove {
        margin-top: var(--space-xs);
        background: var(--danger-light);
        color: var(--danger);
        border: none;
        padding: 4px 12px;
        border-radius: var(--radius-sm);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .upload-remove:hover {
        background: var(--danger);
        color: white;
    }

    /* ─── Checkbox ─── */
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-md);
        background: var(--neutral);
        border-radius: var(--radius-md);
        cursor: pointer;
        margin-top: var(--space-md);
        transition: all 0.2s;
    }

    .checkbox-wrapper:hover {
        background: var(--neutral-dark);
    }

    .checkbox-wrapper input[type="checkbox"] {
        display: none;
    }

    .checkbox-custom {
        width: 20px;
        height: 20px;
        border: 2px solid var(--neutral-darker);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .checkbox-wrapper input[type="checkbox"]:checked+.checkbox-custom {
        background: var(--primary);
        border-color: var(--primary);
    }

    .checkbox-wrapper input[type="checkbox"]:checked+.checkbox-custom::after {
        content: '✓';
        color: white;
        font-size: 12px;
        font-weight: 700;
    }

    .checkbox-label {
        font-size: var(--label-size);
        color: var(--text-primary);
    }

    /* ─── Footer ─── */
    .tab-footer {
        display: none;
    }

    .tab-footer.active {
        display: flex;
    }

    /* ─── Comprovante Styles ─── */
    .comprovante-wrapper {
        background: var(--white);
        border: 1px solid var(--neutral-dark);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        margin-bottom: var(--space-lg);
    }

    .comp-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-lg);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
    }

    .comp-logo-area {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .comp-logo {
        width: 40px;
        height: 40px;
        background: white;
        color: var(--primary);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
    }

    .comp-empresa h4 {
        font-size: var(--body-size);
        font-weight: 700;
        margin: 0;
    }

    .comp-empresa span {
        font-size: var(--small-size);
        opacity: 0.8;
    }

    .comp-tipo {
        text-align: right;
    }

    .comp-tipo-badge {
        display: block;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 2px;
    }

    .comp-numero {
        font-size: var(--small-size);
        font-family: monospace;
        opacity: 0.8;
    }

    .comp-status-bar {
        display: flex;
        align-items: center;
        gap: var(--space-md);
        padding: var(--space-md) var(--space-lg);
        background: var(--success-light);
        border-bottom: 1px solid rgba(5, 150, 105, 0.15);
    }

    .comp-status-icon {
        width: 32px;
        height: 32px;
        background: var(--success);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }

    .comp-status-info {
        display: flex;
        flex-direction: column;
    }

    .comp-status-label {
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--success);
    }

    .comp-status-data {
        font-size: var(--small-size);
        color: var(--text-secondary);
    }

    .comp-valor-box {
        text-align: center;
        padding: var(--space-xl) var(--space-lg);
        background: linear-gradient(180deg, var(--neutral) 0%, var(--white) 100%);
        border-bottom: 1px solid var(--neutral-dark);
    }

    .comp-valor-label {
        display: block;
        font-size: var(--small-size);
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: var(--space-xs);
    }

    .comp-valor {
        display: block;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        font-family: var(--font-headline);
    }

    .comp-valor-metodo {
        display: block;
        font-size: var(--label-size);
        color: var(--text-secondary);
        margin-top: var(--space-xs);
    }

    .comp-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0;
        padding: var(--space-md) var(--space-lg);
    }

    .comp-grid-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
        padding: var(--space-sm) 0;
        border-bottom: 1px solid var(--neutral-dark);
    }

    .comp-grid-label {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .comp-grid-valor {
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }


    .comp-grid-valor.comp-mono {
        font-family: 'Courier New', monospace;
        font-size: var(--small-size);
        color: var(--text-secondary);
    }

    .comp-parcela-box {
        margin: var(--space-md) var(--space-lg);
        padding: var(--space-md);
        background: linear-gradient(135deg, var(--tertiary-light) 0%, var(--tertiary) 100%);
        border-radius: var(--radius-md);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .comp-parcela-label {
        font-size: var(--small-size);
        font-weight: 600;
        opacity: 0.9;
    }

    .comp-parcela-info {
        text-align: right;
    }

    .comp-parcela-info span:first-child {
        display: block;
        font-size: var(--small-size);
        opacity: 0.85;
    }

    .comp-parcela-valor {
        font-size: var(--body-size);
        font-weight: 700;
        font-family: var(--font-headline);
    }

    .comp-resumo {
        margin: var(--space-md) var(--space-lg);
        padding: var(--space-lg);
        background: var(--neutral);
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral-dark);
    }

    .comp-resumo h6 {
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 var(--space-md) 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .comp-resumo-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-xs) 0;
        font-size: var(--label-size);
    }

    .comp-resumo-row span:first-child {
        color: var(--text-secondary);
    }

    .comp-resumo-row span:last-child {
        font-weight: 600;
        color: var(--text-primary);
        font-family: var(--font-headline);
    }

    .comp-resumo-divider {
        height: 1px;
        background: var(--neutral-dark);
        margin: var(--space-sm) 0;
    }

    .comp-resumo-row.comp-total {
        font-size: var(--body-size);
        padding-top: var(--space-sm);
    }

    .comp-resumo-row.comp-total span:last-child {
        color: var(--primary);
        font-size: var(--body-size);
    }

    .comp-resumo-row.comp-pago span:last-child {
        color: var(--success);
    }

    .comp-resumo-row.comp-saldo span:last-child {
        color: var(--warning);
        font-weight: 700;
    }

    .comp-resumo-row.comp-saldo.quitado span:last-child {
        color: var(--success);
    }

    .comp-observacoes {
        margin: var(--space-md) var(--space-lg);
        padding: var(--space-md);
        background: var(--warning-light);
        border: 1px solid rgba(217, 119, 6, 0.15);
        border-radius: var(--radius-md);
    }

    .comp-obs-label {
        display: block;
        font-size: var(--small-size);
        font-weight: 600;
        color: var(--warning);
        margin-bottom: var(--space-xs);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .comp-observacoes p {
        margin: 0;
        font-size: var(--label-size);
        color: var(--text-primary);
        line-height: 1.5;
    }

    .comp-footer {
        padding: var(--space-lg);
        background: var(--neutral);
        border-top: 1px solid var(--neutral-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .comp-footer-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .comp-footer-info span {
        font-size: var(--small-size);
        color: var(--text-muted);
    }

    .comp-footer-code {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: var(--space-xs);
    }

    .comp-footer-hash {
        font-size: 10px;
        font-family: monospace;
        color: var(--text-muted);
        letter-spacing: 0.5px;
    }

    /* ─── Ações do Comprovante ─── */
    .comp-actions {
        display: flex;
        gap: var(--space-sm);
        margin-bottom: var(--space-lg);
    }

    .btn-comp {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-sm);
        padding: var(--space-md) var(--space-lg);
        border-radius: var(--radius-md);
        font-size: var(--label-size);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .btn-comp svg {
        flex-shrink: 0;
    }

    .btn-comp-print {
        background: var(--neutral);
        color: var(--text-primary);
        border: 1px solid var(--neutral-dark);
    }

    .btn-comp-print:hover {
        background: var(--neutral-dark);
        transform: translateY(-1px);
    }

    .btn-comp-pdf {
        background: var(--danger);
        color: white;
    }

    .btn-comp-pdf:hover {
        background: #b91c1c;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-comp-email {
        background: var(--primary);
        color: white;
    }

    .btn-comp-email:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* ─── Estado Vazio do Comprovante ─── */
    .comp-empty {
        text-align: center;
        padding: var(--space-2xl) var(--space-lg);
    }

    .comp-empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto var(--space-lg);
        border-radius: var(--radius-xl);
        background: var(--neutral);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
    }

    .comp-empty h4 {
        color: var(--text-primary);
        margin-bottom: var(--space-sm);
        font-size: var(--body-size);
    }

    .comp-empty p {
        color: var(--text-muted);
        font-size: var(--label-size);
    }

    /* ─── Empty State ─── */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: var(--space-2xl);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin-bottom: var(--space-lg);
        border-radius: var(--radius-xl);
        background: var(--neutral);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
    }

    .empty-state h4 {
        color: var(--text-primary);
        margin-bottom: var(--space-sm);
        font-size: var(--body-size);
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: var(--label-size);
    }

    /* ─── Responsividade ─── */
    @media (max-width: 640px) {
        .parcelas-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .resumo-grid {
            grid-template-columns: 1fr;
        }

        .comp-grid {
            grid-template-columns: 1fr;
        }

        .comp-actions {
            flex-direction: column;
        }

        .percentual-botoes {
            flex-wrap: wrap;
        }

        .pct-btn {
            min-width: calc(50% - var(--space-xs));
        }

        .saldo-valor {
            font-size: 2rem;
        }

        .comp-valor {
            font-size: 2rem;
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
        .tabs-bar,
        .tab-footer,
        .comp-actions {
            display: none !important;
        }

        .comprovante-wrapper {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .tab-content {
            display: none !important;
        }

        #tab-comprovante.tab-content.active {
            display: block !important;
        }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════════ -->
<!-- JAVASCRIPT DE CONTROLE                                          -->
<!-- ═══════════════════════════════════════════════════════════════ -->
<script>
    /**
     * Sistema de Tabs da Modal de Pagamento
     */
    function switchTab(tabId) {
        console.log("welcome");
        // Conteúdo das tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        const tabContent = document.getElementById(tabId);
        if (tabContent) {
            tabContent.classList.add('active');
        }

        // Botões das tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        const tabBtn = document.getElementById('btn-' + tabId);
        if (tabBtn) {
            tabBtn.classList.add('active');
        }

        // Footers
        document.querySelectorAll('.tab-footer').forEach(footer => {
            footer.classList.remove('active');
        });
        const footer = document.getElementById('footer-' + tabId.replace('tab-', ''));
        if (footer) {
            footer.classList.add('active');
        }

        // Dispara evento para o Livewire saber qual aba está ativa
        if (window.Livewire) {
            window.Livewire.dispatch('tabChanged', {
                tab: tabId
            });
        }
    }

    /**
     * Inicializa a tab padrão ao carregar
     */
    document.addEventListener('DOMContentLoaded', function() {
        // Só inicializa se a modal estiver aberta
        const modal = document.getElementById('modal-novo-pagamento');
        if (modal && modal.style.display !== 'none') {
            switchTab('tab-pagamento');
        }
    });

    /**
     * Listener para quando o Livewire atualiza o DOM
     */
    document.addEventListener('livewire:updated', function() {
        // Reaplica a tab ativa após atualização do Livewire
        const activeTab = document.querySelector('.tab-content.active');
        if (!activeTab) {
            switchTab('tab-pagamento');
        }
    });

    /**
     * Baixa o comprovante em PDF
     * Preparado para integração com bibliotecas como html2pdf.js ou jsPDF
     */
    function baixarComprovantePDF() {
        const comprovante = document.getElementById('comprovante-pdf');
        if (!comprovante) {
            console.error('Comprovante não encontrado');
            return;
        }

        // Dispara evento para o Livewire processar o download
        if (window.Livewire) {
            window.Livewire.dispatch('baixarComprovantePDF');
        }

        // Fallback: tenta usar window.print() se não houver biblioteca de PDF
        // Ou pode ser integrado com html2pdf.js:
        /*
        if (typeof html2pdf !== 'undefined') {
            const opt = {
                margin: 10,
                filename: 'comprovante-' + new Date().getTime() + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(comprovante).save();
        } else {
            window.print();
        }
        */
    }

    /**
     * Envia comprovante por e-mail
     */
    function enviarComprovanteEmail() {
        if (window.Livewire) {
            window.Livewire.dispatch('enviarComprovanteEmail');
        }
    }

    /**
     * Preview do arquivo de comprovante antes do upload
     */
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('comprovante-file');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Valida tamanho (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('O arquivo deve ter no máximo 5MB');
                        e.target.value = '';
                        return;
                    }

                    // Valida tipo
                    const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Formato não suportado. Use PDF, JPG ou PNG.');
                        e.target.value = '';
                        return;
                    }
                }
            });
        }
    });

    /**
     * Formatação de moeda em tempo real
     */
    document.addEventListener('DOMContentLoaded', function() {
        const valorInput = document.querySelector('.valor-input');
        if (valorInput) {
            valorInput.addEventListener('blur', function(e) {
                let value = parseFloat(e.target.value);
                if (!isNaN(value)) {
                    e.target.value = value.toFixed(2);
                }
            });
        }
    });

    /**
     * Atalhos de teclado
     */
    document.addEventListener('keydown', function(e) {
        // ESC fecha a modal
        if (e.key === 'Escape') {
            const modal = document.getElementById('modal-novo-pagamento');
            if (modal && modal.style.display !== 'none') {
                closeModal('modal-novo-pagamento');
            }
        }

        // Ctrl+P imprime comprovante quando na aba de comprovante
        if (e.ctrlKey && e.key === 'p') {
            const comprovanteTab = document.getElementById('tab-comprovante');
            if (comprovanteTab && comprovanteTab.classList.contains('active')) {
                e.preventDefault();
                window.print();
            }
        }
    });
</script>
