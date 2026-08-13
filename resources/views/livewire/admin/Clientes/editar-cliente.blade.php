<div>
    {{-- @if ($modalAberto) --}}
    <div class="modal-overlay" id="modal-editar-cliente" wire:ignore.self>
        <div class="modal modal-lg" style="max-width: 900px;">
            <!-- Header -->
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--tertiary); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Editar Cliente</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                            {{ $numero_matricula ?: 'MAT-0000-000000' }} — {{ $nome_completo }}
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

            <!-- Body -->
            <div class="modal-body">
                <!-- Tabs -->
                <div class="tabs" style="margin-bottom: var(--space-lg);">
                    <button class="tab {{ $abaAtiva === 'tab-edit-dados' ? 'active' : '' }}"
                        wire:click="switchTab('tab-edit-dados')" type="button">
                        Dados Cadastrais
                    </button>
                    <button class="tab {{ $abaAtiva === 'tab-edit-ligacao' ? 'active' : '' }}"
                        wire:click="switchTab('tab-edit-ligacao')" type="button">
                        Ligação & Hidrômetro
                    </button>
                    <button class="tab {{ $abaAtiva === 'tab-edit-faturamento' ? 'active' : '' }}"
                        wire:click="switchTab('tab-edit-faturamento')" type="button">
                        Faturamento
                    </button>
                    <button class="tab {{ $abaAtiva === 'tab-edit-acoes' ? 'active' : '' }}"
                        wire:click="switchTab('tab-edit-acoes')" type="button">
                        Ações Rápidas
                    </button>
                </div>

                <!-- Aba: Dados Cadastrais -->
                <div id="tab-edit-dados" class="tab-content-editar"
                    style="display: {{ $abaAtiva === 'tab-edit-dados' ? 'block' : 'none' }};">
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Nome Completo *</label>
                            <input type="text" class="form-input" wire:model="nome_completo"
                                placeholder="Nome completo do cliente">
                            @error('nome_completo')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Bilhete de Identidade (BI) *</label>
                            <input type="text" class="form-input" wire:model="bi" style="font-family: monospace;"
                                placeholder="000.000.000-00">
                            @error('bi')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">E-mail</label>
                            <input type="email" class="form-input" wire:model="email" placeholder="email@exemplo.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telefone</label>
                            <input type="tel" class="form-input" wire:model="telefone"
                                placeholder="(00) 00000-0000">
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-input" wire:model="data_nascimento">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nome do Responsável Legal</label>
                            <input type="text" class="form-input" wire:model="responsavel_legal"
                                placeholder="Nome do responsável">
                        </div>
                    </div>
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); margin-top: var(--space-md);">
                        <h4
                            style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-md);">
                            Endereço de Instalação
                        </h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">NUIT</label>
                                <input type="text" class="form-input" wire:model="nuit" placeholder="0000000000">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Endereço *</label>
                                <input type="text" class="form-input" wire:model="endereco"
                                    placeholder="Rua, Avenida, etc.">
                                @error('endereco')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid-3">
                            <div class="form-group">
                                <label class="form-label">Número Casa</label>
                                <input type="text" class="form-input" wire:model="numero_casa" placeholder="123">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bairro</label>
                                <input type="text" class="form-input" wire:model="bairro"
                                    placeholder="Nome do bairro">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cidade *</label>
                                <input type="text" class="form-input" wire:model="cidade" placeholder="Cidade">
                                @error('cidade')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Zona de Distribuição</label>
                                <select class="form-select" wire:model="zona_distribuicao">
                                    <option value="">Selecione...</option>
                                    @foreach ($zonasDistribuicao as $zona)
                                        <option value="{{ $zona }}">{{ $zona }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Ponto de Referência</label>
                                <input type="text" class="form-input" wire:model="ponto_referencia"
                                    placeholder="Próximo a...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aba: Ligação & Hidrômetro -->
                <div id="tab-edit-ligacao" class="tab-content-editar"
                    style="display: {{ $abaAtiva === 'tab-edit-ligacao' ? 'block' : 'none' }};">
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Número da Matrícula</label>
                            <input type="text" class="form-input" wire:model="numero_matricula"
                                style="font-family: monospace;" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Categoria de Consumo *</label>
                            <select class="form-select" wire:model="categoria_consumo">
                                @foreach ($categoriasConsumo as $cat)
                                    <option value="{{ $cat }}"
                                        {{ $categoria_consumo === $cat ? 'selected' : '' }}>{{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_consumo')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Diâmetro do Ramal *</label>
                            <select class="form-select" wire:model="diametro_ramal">
                                @foreach ($diametrosRamal as $diam)
                                    <option value="{{ $diam }}">{{ $diam }}</option>
                                @endforeach
                            </select>
                            @error('diametro_ramal')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status da Ligação</label>
                            <select class="form-select" wire:model="tipo_ligacao">
                                @foreach ($statusLigacao as $statusLig)
                                    <option value="{{ $statusLig }}">{{ $statusLig }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Tipo de Imóvel</label>
                            <input type="text" class="form-input" wire:model="tipo_imovel"
                                placeholder="Casa, Apartamento, etc.">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Número de Economias</label>
                            <input type="number" class="form-input" wire:model="numero_economias" min="1">
                        </div>
                    </div>

                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); margin-top: var(--space-md);">
                        <h4
                            style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-md);">
                            Hidrômetro Atual
                        </h4>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Número</label>
                                <input type="text" class="form-input" wire:model="numero_hidrometro"
                                    style="font-family: monospace;" placeholder="H-0000-XX">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Marca</label>
                                <select class="form-select" wire:model="marca">
                                    @foreach ($marcasHidrometro as $marcaH)
                                        <option value="{{ $marcaH }}">{{ $marcaH }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Diâmetro</label>
                                <select class="form-select" wire:model="diametro">
                                    @foreach ($diametrosHidrometro as $diamH)
                                        <option value="{{ $diamH }}">{{ $diamH }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tipo</label>
                                <select class="form-select" wire:model="tipo_hidrometro">
                                    @foreach ($tiposHidrometro as $tipoH)
                                        <option value="{{ $tipoH }}">{{ $tipoH }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid-2">
                            <div class="form-group">
                                <label class="form-label">Leitura Atual (m³)</label>
                                <input type="number" class="form-input" value="{{ $leitura_atual }}" readonly
                                    style="background: var(--neutral-dark);">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Data da Última Leitura</label>
                                <input type="date" class="form-input" value="{{ $data_ultima_leitura }}" readonly
                                    style="background: var(--neutral-dark);">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Número do Lacre</label>
                            <input type="text" class="form-input" wire:model="numero_lacre"
                                placeholder="L-0000-0000">
                        </div>
                    </div>
                </div>

                <!-- Aba: Faturamento -->
                <div id="tab-edit-faturamento" class="tab-content-editar"
                    style="display: {{ $abaAtiva === 'tab-edit-faturamento' ? 'block' : 'none' }};">
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Dia de Vencimento</label>
                            <select class="form-select" wire:model="dia_vencimento">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Forma de Pagamento</label>
                            <select class="form-select" wire:model="forma_pagamento">
                                @foreach ($formasPagamento as $forma)
                                    <option value="{{ $forma }}">{{ $forma }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Tarifa Aplicada</label>
                            <select class="form-select" wire:model="tarifa_aplicada">
                                @foreach ($tarifas as $tarifa)
                                    <option value="{{ $tarifa }}">{{ $tarifa }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Desconto Especial (%)</label>
                            <input type="number" class="form-input" wire:model="desconto_especial" min="0"
                                max="100" step="0.01">
                        </div>
                    </div>

                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); margin-top: var(--space-md);">
                        <h4
                            style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-md);">
                            Resumo Financeiro
                        </h4>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-md);">
                            <div
                                style="text-align: center; padding: var(--space-md); background: white; border-radius: var(--radius-md);">
                                <div
                                    style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                                    Última Fatura</div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">
                                    MT {{ number_format($valor_ultima_fatura, 2, ',', '.') }}
                                </div>
                                <div style="font-size: var(--small-size); color: var(--success);">
                                    {{ $status_ultima_fatura }}</div>
                            </div>
                            <div
                                style="text-align: center; padding: var(--space-md); background: white; border-radius: var(--radius-md);">
                                <div
                                    style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                                    Fatura Atual</div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">
                                    MT {{ number_format($valor_fatura_atual, 2, ',', '.') }}
                                </div>
                                <div style="font-size: var(--small-size); color: var(--warning);">Vence em
                                    {{ $vencimento_fatura_atual }}</div>
                            </div>
                            <div
                                style="text-align: center; padding: var(--space-md); background: white; border-radius: var(--radius-md);">
                                <div
                                    style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                                    Total em Aberto</div>
                                <div
                                    style="font-size: 1.25rem; font-weight: 700; color: {{ $totalEmAberto > 0 ? 'var(--danger)' : 'var(--success)' }};">
                                    MT {{ number_format($totalEmAberto, 2, ',', '.') }}
                                </div>
                                <div
                                    style="font-size: var(--small-size); color: {{ $totalEmAberto > 0 ? 'var(--danger)' : 'var(--success)' }};">
                                    {{ $totalEmAberto > 0 ? 'Débitos pendentes' : 'Cliente em dia' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: var(--space-lg);">
                        <label
                            style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                            <input type="checkbox" wire:model="isento"
                                style="accent-color: var(--primary); width: 18px; height: 18px;">
                            <span>Isento de pagamento (instituição filantrópica / governo)</span>
                        </label>
                    </div>
                </div>

                <!-- Aba: Ações Rápidas -->
                <div id="tab-edit-acoes" class="tab-content-editar"
                    style="display: {{ $abaAtiva === 'tab-edit-acoes' ? 'block' : 'none' }};">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--space-md);">
                        <button class="btn btn-outline" style="justify-content: flex-start; padding: var(--space-lg);"
                            wire:click="solicitarReligacao" type="button">
                            <div
                                style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--success-light); display: flex; align-items: center; justify-content: center; margin-right: var(--space-md);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--success)" stroke-width="2">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                </svg>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 600; color: var(--text-primary);">Solicitar Religação
                                </div>
                                <div style="font-size: var(--small-size); color: var(--text-muted);">Reativar
                                    ligação cortada</div>
                            </div>
                        </button>

                        <button class="btn btn-outline" style="justify-content: flex-start; padding: var(--space-lg);"
                            wire:click="solicitarCorte" type="button">
                            <div
                                style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--danger-light); display: flex; align-items: center; justify-content: center; margin-right: var(--space-md);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--danger)" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="8" x2="16" y1="12" y2="12" />
                                </svg>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 600; color: var(--text-primary);">Solicitar Corte</div>
                                <div style="font-size: var(--small-size); color: var(--text-muted);">Interromper
                                    fornecimento</div>
                            </div>
                        </button>

                        <button class="btn btn-outline" style="justify-content: flex-start; padding: var(--space-lg);"
                            wire:click="solicitarTrocaHidrometro" type="button">
                            <div
                                style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--warning-light); display: flex; align-items: center; justify-content: center; margin-right: var(--space-md);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--warning)" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 600; color: var(--text-primary);">Trocar Hidrômetro</div>
                                <div style="font-size: var(--small-size); color: var(--text-muted);">Substituir
                                    medidor</div>
                            </div>
                        </button>

                        <button class="btn btn-outline" style="justify-content: flex-start; padding: var(--space-lg);"
                            wire:click="solicitarVistoria" type="button">
                            <div
                                style="width: 40px; height: 40px; border-radius: var(--radius-md); background: rgba(0,131,143,0.1); display: flex; align-items: center; justify-content: center; margin-right: var(--space-md);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--tertiary)" stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 600; color: var(--text-primary);">Solicitar Vistoria</div>
                                <div style="font-size: var(--small-size); color: var(--text-muted);">Verificação
                                    técnica</div>
                            </div>
                        </button>

                        <button class="btn btn-outline" style="justify-content: flex-start; padding: var(--space-lg);"
                            wire:click="gerarSegundaVia" type="button">
                            <div
                                style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--neutral-dark); display: flex; align-items: center; justify-content: center; margin-right: var(--space-md);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--text-secondary)" stroke-width="2">
                                    <rect width="20" height="14" x="2" y="5" rx="2" />
                                    <line x1="2" x2="22" y1="10" y2="10" />
                                </svg>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 600; color: var(--text-primary);">2ª Via de Fatura</div>
                                <div style="font-size: var(--small-size); color: var(--text-muted);">Reemitir
                                    documento</div>
                            </div>
                        </button>

                        <button class="btn btn-outline" style="justify-content: flex-start; padding: var(--space-lg);"
                            wire:click="negociarDivida" type="button">
                            <div
                                style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--primary-light); display: flex; align-items: center; justify-content: center; margin-right: var(--space-md);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="white" stroke-width="2">
                                    <line x1="12" x2="12" y1="2" y2="22" />
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-weight: 600; color: var(--text-primary);">Negociar Dívida</div>
                                <div style="font-size: var(--small-size); color: var(--text-muted);">Parcelamento
                                    em aberto</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button class="btn btn-outline" wire:click="fecharModal" type="button">Cancelar</button>
                <button class="btn btn-primary" wire:click="salvarEdicao" wire:loading.attr="disabled"
                    type="button">
                    <span wire:loading.remove wire:target="salvarEdicao">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="margin-right: 6px;">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                        Salvar Alterações
                    </span>
                    <span wire:loading wire:target="salvarEdicao">
                        <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                            <circle cx="12" cy="12" r="10" stroke-dasharray="60"
                                stroke-dashoffset="10" />
                        </svg>
                        Salvando...
                    </span>
                </button>
            </div>
        </div>
    </div>
    {{-- @endif --}}
</div>
