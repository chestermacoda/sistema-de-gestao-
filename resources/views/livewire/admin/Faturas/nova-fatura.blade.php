{{-- Modal de Nova Fatura (Livewire) --}}
<div class="modal-overlay" id="modal-nova-fatura" wire:ignore.self>
    <div class="modal modal-lg" style="max-width: 800px;">
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
                    <h3 class="modal-title">Emitir Nova Fatura</h3>
                    <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                        Gere uma fatura manualmente para um cliente
                    </p>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('modal-nova-fatura')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        <div class="modal-body">


            <div>
                {{-- Wizard de Passos --}}
                <div class="wizard-steps" style="margin-bottom: var(--space-lg);">
                    <div class="step {{ $passo >= 1 ? 'active' : '' }} {{ $passo > 1 ? 'completed' : '' }}">
                        <div class="step-number">1</div>
                        <div class="step-label">Cliente</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step {{ $passo >= 2 ? 'active' : '' }} {{ $passo > 2 ? 'completed' : '' }}">
                        <div class="step-number">2</div>
                        <div class="step-label">Leitura</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step {{ $passo >= 3 ? 'active' : '' }}">
                        <div class="step-number">3</div>
                        <div class="step-label">Revisão</div>
                    </div>
                </div>

                {{-- PASSO 1: SELEÇÃO DO CLIENTE --}}
                @if ($passo === 1)
                    <div class="form-section">
                        {{-- Busca de cliente --}}
                        <div class="form-group">
                            <label class="form-label">Buscar Cliente *</label>
                            <div class="search-wrapper" style="position: relative;">
                                <input type="text" class="form-input" wire:model.live.debounce.300ms="buscaCliente"
                                    placeholder="Digite nome, matrícula ou BI..." autocomplete="off">
                                @if (!empty($clientesFiltrados))
                                    <div class="search-dropdown"
                                        style="
                                            position: absolute; top: 100%; left: 0; right: 0;
                                            background: white; border: 1px solid var(--border);
                                            border-radius: var(--radius-md); z-index: 100;
                                            max-height: 250px; overflow-y: auto; margin-top: 4px;
                                            box-shadow: var(--shadow-lg);
                                        ">
                                        @foreach ($clientesFiltrados as $c)
                                            <div wire:click="selecionarCliente({{ $c['id'] }})"
                                                style="padding: var(--space-sm) var(--space-md); cursor: pointer;
                               border-bottom: 1px solid var(--border-light);"
                                                class="search-item">
                                                <div style="font-weight: 600; color: var(--text);">{{ $c['nome'] }}
                                                </div>
                                                <div style="font-size: var(--small-size); color: var(--text-muted);">
                                                    {{ $c['matricula'] }} — {{ $c['categoria'] }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @error('cliente_id')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Cliente selecionado --}}
                        @if (!empty($clienteSelecionado))
                            <div class="cliente-card"
                                style="
            background: var(--neutral); border-radius: var(--radius-md);
            padding: var(--space-md); margin-bottom: var(--space-lg);
            border-left: 4px solid var(--primary);
        ">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <h4 style="margin: 0 0 4px 0; color: var(--text);">
                                            {{ $clienteSelecionado['nome'] }}</h4>
                                        <p style="margin: 0; font-size: var(--small-size); color: var(--text-muted);">
                                            {{ $clienteSelecionado['matricula'] }} |
                                            {{ $clienteSelecionado['categoria'] }}
                                        </p>
                                        <p
                                            style="margin: 4px 0 0 0; font-size: var(--small-size); color: var(--text-muted);">
                                            Hidrômetro: {{ $clienteSelecionado['hidrometro'] }} |
                                            {{ $clienteSelecionado['endereco'] }}
                                        </p>
                                    </div>
                                    <span class="badge badge-primary">{{ $clienteSelecionado['categoria'] }}</span>
                                </div>
                            </div>

                            {{-- Últimas faturas --}}
                            @if (!empty($ultimasFaturas))
                                <div style="margin-bottom: var(--space-lg);">
                                    <h5
                                        style="font-size: var(--label-size); color: var(--text-muted); margin-bottom: var(--space-sm);">
                                        Últimas Faturas
                                    </h5>
                                    <div style="display: flex; gap: var(--space-sm); flex-wrap: wrap;">
                                        @foreach ($ultimasFaturas as $f)
                                            <div
                                                style="
                    background: white; border: 1px solid var(--border);
                    border-radius: var(--radius-sm); padding: var(--space-sm) var(--space-md);
                    font-size: var(--small-size);
                ">
                                                <span style="font-weight: 600;">{{ $f['codigo'] }}</span>
                                                <span style="color: var(--text-muted);"> — {{ $f['mes'] }}</span>
                                                <span style="font-weight: 700; color: var(--primary);"> MZN
                                                    {{ $f['total'] }}</span>
                                                <span class="status-badge {{ $f['status_class'] }}"
                                                    style="margin-left: 8px;">
                                                    {{ $f['status'] }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        {{-- Mês de referência e vencimento --}}
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Mês de Referência *</label>
                                <input type="text" class="form-input" wire:model="mes_referencia"
                                    placeholder="MM/YYYY" maxlength="7">
                                @error('mes_referencia')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Data de Vencimento *</label>
                                <input type="date" class="form-input" wire:model="data_vencimento"
                                    min="{{ now()->format('Y-m-d') }}">
                                @error('data_vencimento')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                {{-- PASSO 2: LEITURA --}}
                @if ($passo === 2)
                    <div class="form-section">
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Leitura Anterior (m³)</label>
                                <input type="number" class="form-input"
                                    value="{{ number_format($leitura_anterior, 0, '', '') }}" readonly
                                    style="font-family: monospace; background: var(--neutral);">
                                <small style="color: var(--text-muted); font-size: var(--small-size);">
                                    Última leitura registrada no sistema
                                </small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Leitura Atual (m³) *</label>
                                <input type="number" class="form-input" wire:model.live.debounce.500ms="leitura_atual"
                                    placeholder="00000" style="font-family: monospace;" step="1"
                                    min="{{ $leitura_anterior }}">
                                @error('leitura_atual')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Preview do consumo --}}
                        @if ($mostrarPreview && !empty($previewCalculo))
                            <div
                                style="
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--primary-100) 100%);
            border: 1px solid var(--primary-200);
            border-radius: var(--radius-md);
            padding: var(--space-lg);
            margin: var(--space-lg) 0;
        ">
                                <h4
                                    style="margin: 0 0 var(--space-md) 0; color: var(--primary); font-size: var(--h5-size);">
                                    Cálculo da Fatura
                                </h4>

                                <div style="display: grid; gap: var(--space-sm);">
                                    {{-- Consumo --}}
                                    <div
                                        style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px dashed var(--primary-200);">
                                        <span style="color: var(--text-muted);">Consumo Calculado</span>
                                        <span style="font-family: monospace; font-weight: 700; color: var(--primary);">
                                            {{ number_format($previewCalculo['consumo_m3'], 2, ',', '.') }} m³
                                        </span>
                                    </div>

                                    {{-- Tarifa aplicada --}}
                                    <div
                                        style="display: flex; justify-content: space-between; padding: var(--space-sm) 0;">
                                        <span style="color: var(--text-muted);">Tarifa Base (até
                                            {{ number_format($previewCalculo['limite_m3'], 0, ',', '.') }} m³)</span>
                                        <span style="font-family: monospace;">MZN
                                            {{ number_format($previewCalculo['tarifa_base'], 2, ',', '.') }}</span>
                                    </div>

                                    @if ($previewCalculo['consumo_m3'] > $previewCalculo['limite_m3'])
                                        <div
                                            style="display: flex; justify-content: space-between; padding: var(--space-sm) 0;">
                                            <span style="color: var(--text-muted);">
                                                Excedente
                                                ({{ number_format($previewCalculo['consumo_m3'] - $previewCalculo['limite_m3'], 2, ',', '.') }}
                                                m³ ×
                                                {{ number_format($previewCalculo['preco_excedente'], 2, ',', '.') }})
                                            </span>
                                            <span style="font-family: monospace;">
                                                MZN
                                                {{ number_format($previewCalculo['valor_consumo'] - $previewCalculo['tarifa_base'], 2, ',', '.') }}
                                            </span>
                                        </div>
                                    @endif

                                    <div
                                        style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--primary-200);">
                                        <span style="font-weight: 600;">Valor do Consumo</span>
                                        <span style="font-family: monospace; font-weight: 700;">MZN
                                            {{ number_format($previewCalculo['valor_consumo'], 2, ',', '.') }}</span>
                                    </div>

                                    {{-- Esgoto --}}
                                    <div
                                        style="display: flex; justify-content: space-between; padding: var(--space-sm) 0;">
                                        <span style="color: var(--text-muted);">Esgoto
                                            ({{ $previewCalculo['taxa_esgoto_percentual'] }}%)</span>
                                        <span style="font-family: monospace;">MZN
                                            {{ number_format($previewCalculo['valor_esgoto'], 2, ',', '.') }}</span>
                                    </div>

                                    {{-- Disponibilidade --}}
                                    <div
                                        style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--primary-200);">
                                        <span style="color: var(--text-muted);">Taxa de Disponibilidade</span>
                                        <span style="font-family: monospace;">MZN
                                            {{ number_format($previewCalculo['taxa_disponibilidade'], 2, ',', '.') }}</span>
                                    </div>

                                    {{-- Total --}}
                                    <div
                                        style="
                    display: flex; justify-content: space-between;
                    padding: var(--space-md) 0 0 0; margin-top: var(--space-sm);
                ">
                                        <span
                                            style="font-size: var(--h5-size); font-weight: 700; color: var(--text);">TOTAL</span>
                                        <span
                                            style="font-size: var(--h5-size); font-family: monospace; font-weight: 700; color: var(--primary);">
                                            MZN {{ number_format($previewCalculo['valor_total'], 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- PASSO 3: REVISÃO E EMISSÃO --}}
                @if ($passo === 3)
                    <div class="form-section">
                        <div
                            style="
            background: var(--success-50); border: 1px solid var(--success-200);
            border-radius: var(--radius-md); padding: var(--space-md);
            margin-bottom: var(--space-lg);
        ">
                            <div
                                style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-sm);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--success)" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                                <span style="font-weight: 600; color: var(--success);">Tudo certo para emitir!</span>
                            </div>
                            <p style="margin: 0; font-size: var(--small-size); color: var(--text-muted);">
                                Revise os dados abaixo e confirme a emissão da fatura. Ela ficará com status
                                <strong>Pendente</strong> e pronta para receber pagamento.
                            </p>
                        </div>

                        {{-- Resumo --}}
                        @if (!empty($clienteSelecionado))
                            <div
                                style="
            background: var(--neutral); border-radius: var(--radius-md);
            padding: var(--space-md); margin-bottom: var(--space-lg);
        ">
                                <h5 style="margin: 0 0 var(--space-md) 0; color: var(--text);">Resumo da Fatura</h5>

                                <div
                                    style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-sm); font-size: var(--small-size);">
                                    <div><span style="color: var(--text-muted);">Cliente:</span>
                                        <strong>{{ $clienteSelecionado['nome'] }}</strong>
                                    </div>
                                    <div><span style="color: var(--text-muted);">Matrícula:</span>
                                        {{ $clienteSelecionado['matricula'] }}</div>
                                    <div><span style="color: var(--text-muted);">Mês Ref.:</span>
                                        {{ $mes_referencia }}</div>
                                    <div><span style="color: var(--text-muted);">Vencimento:</span>
                                        {{ \Carbon\Carbon::parse($data_vencimento)->format('d/m/Y') }}</div>
                                    <div><span style="color: var(--text-muted);">Leitura Anterior:</span>
                                        {{ number_format($leitura_anterior, 0, ',', '.') }} m³</div>
                                    <div><span style="color: var(--text-muted);">Leitura Atual:</span>
                                        {{ number_format($leitura_atual, 0, ',', '.') }} m³</div>
                                    <div><span style="color: var(--text-muted);">Consumo:</span>
                                        <strong>{{ number_format($previewCalculo['consumo_m3'] ?? 0, 2, ',', '.') }}
                                            m³</strong>
                                    </div>
                                    <div><span style="color: var(--text-muted);">Valor Total:</span> <strong
                                            style="color: var(--primary);">MZN
                                            {{ number_format($previewCalculo['valor_total'] ?? 0, 2, ',', '.') }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Observações --}}
                        <div class="form-group">
                            <label class="form-label">Observações / Justificativa</label>
                            <textarea class="form-textarea" wire:model="observacoes" placeholder="Informações adicionais sobre esta fatura..."
                                rows="3"></textarea>
                        </div>

                        {{-- Checkbox boleto --}}
                        <div
                            style="
            background: var(--neutral); border-radius: var(--radius-md);
            padding: var(--space-md); margin-top: var(--space-lg);
        ">
                            <label
                                style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                                <input type="checkbox" wire:model="gerar_boleto"
                                    style="accent-color: var(--primary); width: 18px; height: 18px;">
                                <span>
                                    <strong>Gerar boleto automaticamente</strong> — O boleto será enviado ao cliente por
                                    e-mail
                                </span>
                            </label>
                        </div>
                    </div>
                @endif

                {{-- BOTÕES DE AÇÃO --}}
                <div class="modal-footer"
                    style="margin-top: var(--space-lg); padding-top: var(--space-lg); border-top: 1px solid var(--border);">
                    <button type="button" class="btn btn-outline" onclick="closeModal('modal-nova-fatura')">
                        Cancelar
                    </button>

                    @if ($passo > 1)
                        <button type="button" class="btn btn-outline" wire:click="voltarPasso"
                            wire:loading.attr="disabled">
                            ← Voltar
                        </button>
                    @endif

                    @if ($passo < 3)
                        <button type="button" class="btn btn-primary" wire:click="avancarPasso"
                            wire:loading.attr="disabled">
                            Próximo →
                            <span wire:loading wire:target="avancarPasso" style="margin-left: 8px;">
                                <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" stroke-dasharray="60"
                                        stroke-dashoffset="20" />
                                </svg>
                            </span>
                        </button>
                    @else
                        <button type="button" class="btn btn-secondary" wire:click="salvarRascunho"
                            wire:loading.attr="disabled">
                            Salvar Rascunho
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="emitirFatura"
                            wire:loading.attr="disabled">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                <path d="M20 6 9 17l-5-5" />
                            </svg>
                            Emitir Fatura
                            <span wire:loading wire:target="emitirFatura" style="margin-left: 8px;">
                                <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" stroke-dasharray="60"
                                        stroke-dashoffset="20" />
                                </svg>
                            </span>
                        </button>
                    @endif
                </div>

                {{-- CSS do Wizard --}}
                <style>
                    .wizard-steps {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0;
                    }

                    .step {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        gap: 6px;
                        opacity: 0.5;
                        transition: all 0.3s ease;
                    }

                    .step.active {
                        opacity: 1;
                    }

                    .step.completed {
                        opacity: 1;
                    }

                    .step-number {
                        width: 32px;
                        height: 32px;
                        border-radius: 50%;
                        background: var(--neutral);
                        border: 2px solid var(--border);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-weight: 700;
                        font-size: 14px;
                        color: var(--text-muted);
                        transition: all 0.3s ease;
                    }

                    .step.active .step-number {
                        background: var(--primary);
                        border-color: var(--primary);
                        color: white;
                    }

                    .step.completed .step-number {
                        background: var(--success);
                        border-color: var(--success);
                        color: white;
                    }

                    .step-label {
                        font-size: 12px;
                        font-weight: 600;
                        color: var(--text-muted);
                    }

                    .step.active .step-label {
                        color: var(--primary);
                    }

                    .step-line {
                        width: 60px;
                        height: 2px;
                        background: var(--border);
                        margin: 0 var(--space-sm);
                        margin-bottom: 20px;
                    }

                    .search-item:hover {
                        background: var(--primary-50);
                    }

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



        </div>
    </div>
</div>
