{{-- Modal Registrar Pagamento --}}
<div class="modal-overlay" id="modal-novo-pagamento" wire:ignore.self>
    <form wire:submit.prevent='confirmarPagamento' class="modal modal-lg" style="max-width: 700px;">
        <div class="modal-header">
            <div style="display: flex; align-items: center; gap: var(--space-md);">
                <div
                    style="
                    width: 40px; height: 40px; border-radius: var(--radius-md);
                    background: var(--primary); display: flex;
                    align-items: center; justify-content: center; color: white;
                ">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                </div>
                <div>
                    <h3 class="modal-title">Registrar Pagamento</h3>
                    <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                        Registre um pagamento recebido manualmente
                    </p>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('modal-novo-pagamento')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>


        <div>
            @if ($faturaId)


                <div class="modal-body" style="padding-bottom: 0;">
                    <div
                        style="
            text-align: center;
            padding: var(--space-lg);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-lg);
            color: var(--white);
        ">
                        <div style="font-size: var(--label-size); opacity: 0.9; margin-bottom: var(--space-xs);">
                            Saldo Devedor
                        </div>
                        <div
                            style="font-size: var(--headline-size); font-weight: 700; font-family: var(--font-headline);">
                            MZN {{ number_format($saldoDevedor, 2, ',', '.') }}
                        </div>
                        <div
                            style="
                margin-top: var(--space-sm);
                font-size: var(--small-size);
                opacity: 0.85;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: var(--space-sm);
            ">
                            <span>{{ $fatura['codigo'] }}</span>
                            <span style="opacity: 0.5;">|</span>
                            <span>{{ $cliente['nome'] }}</span>
                        </div>
                        <div style="margin-top: var(--space-sm);">
                            <span
                                style="
                    display: inline-block;
                    padding: var(--space-xs) var(--space-sm);
                    background: rgba(255,255,255,0.2);
                    border-radius: var(--radius-md);
                    font-size: var(--small-size);
                    font-weight: 600;
                ">
                                {{ $fatura['status'] }}
                            </span>
                        </div>
                    </div>


                    @if (!empty($parcelasPendentes) && count($parcelasPendentes) > 1)
                        <div style="margin-bottom: var(--space-lg);">
                            <h5
                                style="
                font-size: var(--label-size);
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: var(--space-md);
                display: flex;
                align-items: center;
                gap: var(--space-sm);
            ">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" style="color: var(--tertiary);">
                                    <rect width="20" height="14" x="2" y="5" rx="2" />
                                    <line x1="2" x2="22" y1="10" y2="10" />
                                </svg>
                                Selecione a parcela
                            </h5>

                            <div
                                style="
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: var(--space-md);
                margin-bottom: var(--space-md);
            ">
                                @foreach ($parcelasPendentes as $index => $parcela)
                                    @php
                                        $parcelaNumero = $index + 1;
                                        $totalParcelas = count($parcelasPendentes);
                                        $isPaga = ($parcela['status'] ?? 'Pendente') === 'Paga';
                                        $isSelecionada =
                                            isset($parcelaSelecionada) && $parcelaSelecionada == $parcela['id'];
                                    @endphp

                                    <label
                                        style="
                    position: relative;
                    padding: var(--space-md);
                    border-radius: var(--radius-lg);
                    border: 2px solid {{ $isPaga ? 'var(--success)' : ($isSelecionada ? 'var(--primary)' : 'var(--neutral-dark)') }};
                    background: {{ $isPaga ? 'var(--success-light)' : ($isSelecionada ? 'var(--primary-lighter)' : 'var(--white)') }};
                    cursor: {{ $isPaga ? 'not-allowed' : 'pointer' }};
                    opacity: {{ $isPaga ? '0.6' : '1' }};
                    transition: all 0.2s ease;
                    text-align: center;
                "
                                        {{ $isPaga ? '' : 'wire:click=selecionarParcela(' . $parcela['id'] . ')' }}>

                                        {{-- Checkbox/Radio visual --}}
                                        <div
                                            style="
                        position: absolute;
                        top: var(--space-sm);
                        right: var(--space-sm);
                        width: 20px;
                        height: 20px;
                        border-radius: 50%;
                        border: 2px solid {{ $isPaga ? 'var(--success)' : ($isSelecionada ? 'var(--primary)' : 'var(--neutral-darker)') }};
                        background: {{ $isPaga || $isSelecionada ? 'var(--primary)' : 'transparent' }};
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">
                                            @if ($isPaga || $isSelecionada)
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                    stroke="white" stroke-width="3">
                                                    <path d="M20 6 9 17l-5-5" />
                                                </svg>
                                            @endif
                                        </div>

                                        {{-- Número da parcela --}}
                                        <div
                                            style="
                        font-size: var(--small-size);
                        font-weight: 600;
                        color: var(--text-secondary);
                        margin-bottom: var(--space-xs);
                    ">
                                            {{ $parcelaNumero }}/{{ $totalParcelas }}
                                        </div>

                                        {{-- Valor --}}
                                        <div
                                            style="
                        font-size: var(--body-size);
                        font-weight: 700;
                        color: var(--text-primary);
                        font-family: var(--font-headline);
                    ">
                                            MZN {{ number_format($parcela['valor_parcela'], 2, ',', '.') }}
                                        </div>

                                        {{-- Status --}}
                                        <div
                                            style="
                        margin-top: var(--space-xs);
                        font-size: var(--small-size);
                        color: {{ $isPaga ? 'var(--success)' : 'var(--warning)' }};
                        font-weight: 600;
                    ">
                                            {{ $parcela['status'] ?? 'Pendente' }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Barra de progresso das parcelas --}}
                            @php
                                $totalParcelas = count($parcelasPendentes);
                                $parcelasPagas = collect($parcelasPendentes)->where('status', 'Paga')->count();
                                $percentualQuitado =
                                    $totalParcelas > 0 ? round(($parcelasPagas / $totalParcelas) * 100) : 0;
                            @endphp
                            <div style="margin-bottom: var(--space-sm);">
                                <div
                                    style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: var(--space-xs);
                ">
                                    <span style="font-size: var(--small-size); color: var(--text-secondary);">
                                        {{ $parcelasPagas }} de {{ $totalParcelas }} parcelas quitadas
                                    </span>
                                    <span
                                        style="font-size: var(--small-size); font-weight: 700; color: var(--primary);">
                                        {{ $percentualQuitado }}%
                                    </span>
                                </div>
                                <div
                                    style="
                    width: 100%;
                    height: 6px;
                    background: var(--neutral-dark);
                    border-radius: var(--radius-full);
                    overflow: hidden;
                ">
                                    <div
                                        style="
                        width: {{ $percentualQuitado }}%;
                        height: 100%;
                        background: linear-gradient(90deg, var(--success) 0%, var(--tertiary) 100%);
                        border-radius: var(--radius-full);
                        transition: width 0.5s ease;
                    ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div
                        style="
            background: var(--neutral);
            border-radius: var(--radius-lg);
            padding: var(--space-lg);
            margin-bottom: var(--space-lg);
        ">
                        <div
                            style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: var(--space-md);
            ">
                            <span style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary);">
                                Valor do Pagamento
                            </span>
                            <span style="font-size: var(--small-size); color: var(--text-muted);">
                                Máx: MZN {{ number_format($saldoDevedor, 2, ',', '.') }}
                            </span>
                        </div>

                        <div style="position: relative;">
                            <span
                                style="
                    position: absolute;
                    left: var(--space-md);
                    top: 50%;
                    transform: translateY(-50%);
                    font-size: var(--body-size);
                    font-weight: 600;
                    color: var(--text-muted);
                ">MZN</span>
                            <input type="number" class="form-input" wire:model.live="valorPago" step="0.01"
                                min="0.01" max="{{ $saldoDevedor }}"
                                style="
                        padding-left: 3.5rem;
                        font-size: 1.5rem;
                        font-weight: 700;
                        font-family: var(--font-headline);
                        text-align: right;
                    ">
                        </div>
                        @error('valorPago')
                            <span class="error-text"
                                style="margin-top: var(--space-xs); display: block;">{{ $message }}</span>
                        @enderror

                        {{-- Slider rápido --}}
                        <div
                            style="
                display: flex;
                gap: var(--space-sm);
                margin-top: var(--space-md);
            ">
                            @php
                                $pct25 = round($saldoDevedor * 0.25, 2);
                                $pct50 = round($saldoDevedor * 0.5, 2);
                                $pct75 = round($saldoDevedor * 0.75, 2);
                            @endphp
                            <button type="button" class="btn btn-sm btn-ghost"
                                wire:click="$set('valorPago', {{ $pct25 }})"
                                style="flex: 1; font-size: var(--small-size);">
                                25%
                            </button>
                            <button type="button" class="btn btn-sm btn-ghost"
                                wire:click="$set('valorPago', {{ $pct50 }})"
                                style="flex: 1; font-size: var(--small-size);">
                                50%
                            </button>
                            <button type="button" class="btn btn-sm btn-ghost"
                                wire:click="$set('valorPago', {{ $pct75 }})"
                                style="flex: 1; font-size: var(--small-size);">
                                75%
                            </button>
                            <button type="button" class="btn btn-sm btn-primary"
                                wire:click="$set('valorPago', {{ $saldoDevedor }})"
                                style="flex: 1; font-size: var(--small-size);">
                                Total
                            </button>
                        </div>
                    </div>


                    @if (!empty($historicoPagamentos))
                        <div style="margin-bottom: var(--space-lg);">
                            <h5
                                style="
                    font-size: var(--label-size);
                    font-weight: 600;
                    color: var(--text-primary);
                    margin-bottom: var(--space-md);
                    display: flex;
                    align-items: center;
                    gap: var(--space-sm);
                ">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" style="color: var(--success);">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                                Pagamentos Anteriores
                            </h5>
                            <div style="display: flex; flex-direction: column; gap: var(--space-xs);">
                                @foreach ($historicoPagamentos as $pag)
                                    <div
                                        style="
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: var(--space-sm) var(--space-md);
                        background: var(--white);
                        border: 1px solid var(--neutral-dark);
                        border-radius: var(--radius-md);
                    ">
                                        <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                            <div
                                                style="
                                width: 32px;
                                height: 32px;
                                border-radius: var(--radius-md);
                                background: var(--success-light);
                                color: var(--success);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                                                <svg width="14" height="14" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20 6 9 17l-5-5" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div
                                                    style="font-size: var(--body-size); font-weight: 600; color: var(--text-primary);">
                                                    MZN {{ number_format($pag['valor'], 2, ',', '.') }}
                                                </div>
                                                <div style="font-size: var(--small-size); color: var(--text-muted);">
                                                    {{ $pag['metodo'] }} — {{ $pag['data'] }}
                                                </div>
                                            </div>
                                        </div>
                                        <span style="font-size: var(--small-size); color: var(--text-muted);">
                                            {{ $pag['usuario'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif


                    <div
                        style="
            border-top: 1px solid var(--neutral-dark);
            padding-top: var(--space-lg);
        ">
                        <h5
                            style="
                font-size: var(--label-size);
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: var(--space-md);
            ">
                            Detalhes do Pagamento
                        </h5>

                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Método *</label>
                                <select class="form-select" wire:model="metodoPagamento">
                                    <option value="">Selecione...</option>
                                    <option value="PIX">PIX</option>
                                    <option value="Boleto">Boleto</option>
                                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                                    <option value="Cartão de Débito">Cartão de Débito</option>
                                    <option value="Dinheiro">Dinheiro</option>
                                    <option value="Débito em Conta">Débito em Conta</option>
                                    <option value="Transferência Bancária">Transferência Bancária</option>
                                </select>
                                @error('metodoPagamento')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Data *</label>
                                <input type="date" class="form-input" wire:model="dataPagamento"
                                    max="{{ now()->format('Y-m-d') }}">
                                @error('dataPagamento')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Banco</label>
                                <input type="text" class="form-input" wire:model="banco"
                                    placeholder="Ex: BCI, Millennium BIM">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Comprovante / TxID</label>
                                <input type="text" class="form-input" wire:model="codigoTransacao"
                                    placeholder="Número do comprovante" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Observações</label>
                            <textarea class="form-textarea" wire:model="observacoes" placeholder="Informações adicionais..." rows="2"></textarea>
                        </div>

                        <label
                            style="
                display: flex;
                align-items: center;
                gap: var(--space-sm);
                padding: var(--space-md);
                background: var(--neutral);
                border-radius: var(--radius-md);
                cursor: pointer;
                font-size: var(--label-size);
                margin-top: var(--space-md);
            ">
                            <input type="checkbox" wire:model="gerarRecibo"
                                style="width: 18px; height: 18px; accent-color: var(--primary);">
                            <span>
                                <strong>Gerar recibo</strong> — Enviar comprovante por e-mail
                            </span>
                        </label>
                    </div>
                </div>


                <div class="modal-footer" style="border-top: 1px solid var(--neutral-dark);">
                    <button class="btn btn-outline" onclick="closeModal('modal-novo-pagamento')">Cancelar</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                        style="min-width: 180px;">
                        <span wire:loading.remove>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                style="margin-right: 6px; display: inline; vertical-align: middle;">
                                <path d="M20 6 9 17l-5-5" />
                            </svg>
                            Confirmar MZN {{ number_format((float) $valorPago, 2, ',', '.') }}
                        </span>
                        <span wire:loading>
                            <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2"
                                style="display: inline; vertical-align: middle;">
                                <circle cx="12" cy="12" r="10" stroke-dasharray="60"
                                    stroke-dashoffset="20" />
                            </svg>
                            Processando...
                        </span>
                    </button>
                </div>
            @else
                <div class="modal-body" style="text-align: center; padding: var(--space-2xl);">
                    <div
                        style="
            width: 64px;
            height: 64px;
            margin: 0 auto var(--space-lg);
            border-radius: var(--radius-xl);
            background: var(--neutral);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        ">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <rect width="20" height="14" x="2" y="5" rx="2" />
                            <line x1="2" x2="22" y1="10" y2="10" />
                        </svg>
                    </div>
                    <h4 style="color: var(--text-primary); margin-bottom: var(--space-sm);">Nenhuma fatura selecionada
                    </h4>
                    <p style="color: var(--text-muted); font-size: var(--body-size);">
                        Selecione uma fatura na lista para registrar o pagamento.
                    </p>
                </div>
            @endif

            <style>
                .animate-spin {
                    animation: spin 1s linear infinite;
                }

                @keyframes spin {
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);
                    }
                }
            </style>


        </div>
    </form>
