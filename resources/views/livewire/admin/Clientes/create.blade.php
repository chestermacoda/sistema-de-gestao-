<div class="modal-overlay" id="modal-novo-cliente" wire:ignore.self>
    <form wire:submit.prevent='salvar' onsubmit="clearClienteTab()" class="modal modal-lg" style="max-width: 900px;">
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
                    <h3 class="modal-title">Cadastrar Novo Cliente</h3>
                    <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Preencha
                        todos os dados do cliente e da ligação de água</p>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('modal-novo-cliente')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <!-- Abas do Modal -->
            <div class="tabs" style="margin-bottom: var(--space-lg);">
                <button class="tab active" onclick="switchTabNovo(this, 'tab-dados-pessoais')">Dados
                    Pessoais</button>
                <button type="button" class="tab" onclick="switchTabNovo(this, 'tab-endereco')">Endereço de
                    Instalação</button>
                <button type="button" class="tab" onclick="switchTabNovo(this, 'tab-ligacao')">Dados da
                    Ligação</button>
                <button type="button" class="tab"
                    onclick="switchTabNovo(this, 'tab-hidrometro')">Hidrômetro</button>
            </div>

            <!-- Aba: Dados Pessoais -->
            <div id="tab-dados-pessoais" class="tab-content-novo" style="display: block;">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Tipo de Pessoa *</label>
                        <div style="display: flex; gap: var(--space-md);">
                            <label
                                style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; padding: var(--space-sm) var(--space-md); border: 2px solid var(--primary); border-radius: var(--radius-md); background: rgba(0,51,102,0.05); flex: 1; justify-content: center;">
                                <input type="radio" name="tipo_pessoa" value="fisica" wire:model="tipo_pessoa"
                                    style="accent-color: var(--primary);">
                                <span style="font-weight: 600; color: var(--primary);">Pessoa Física</span>
                            </label>
                            <label
                                style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; padding: var(--space-sm) var(--space-md); border: 2px solid var(--neutral-darker); border-radius: var(--radius-md); flex: 1; justify-content: center;">
                                <input type="radio" name="tipo_pessoa" value="juridica"
                                    style="accent-color: var(--primary);" wire:model="tipo_pessoa">
                                <span style="font-weight: 500; color: var(--text-secondary);">Pessoa Jurídica</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" class="form-input" placeholder="Digite o nome completo"
                            wire:model="nome_completo" required>
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Bilhete de Identidade (BI) *</label>
                        <input type="text" class="form-input" wire:model="bi" placeholder="000.000.000-00"
                            maxlength="14">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nuit</label>
                        <input type="text" class="form-input" wire:model="nuit" placeholder="00.000.000-0">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">E-mail *</label>
                        <input type="email" class="form-input" wire:model="email" placeholder="cliente@email.com"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telefone / WhatsApp *</label>
                        <input type="tel" class="form-input" wire:model="telefone" placeholder="(00) 00000-0000"
                            required>
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Data de Nascimento / Fundação</label>
                        <input type="date" class="form-input" wire:model="data_nascimento">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nome do Responsável Legal</label>
                        <input type="text" class="form-input" placeholder="Nome completo"
                            wire:model="responsavel_legal">
                    </div>
                </div>
            </div>

            <!-- Aba: Endereço de Instalação -->
            <div id="tab-endereco" class="tab-content-novo" style="display: none;">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Cidade *</label>
                        <input type="text" class="form-input" wire:model="cidade" placeholder="Cidade">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Endereco *</label>
                        <input type="text" class="form-input" wire:model="endereco"
                            placeholder="Rua, Avenida, Travessa...">
                    </div>
                </div>
                <div class="grid-3">
                    <div class="form-group">
                        <label class="form-label">Número Casa *</label>
                        <input type="text" class="form-input" wire:model="numero_casa" placeholder="123">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bairro *</label>
                        <input type="text" class="form-input" wire:model="bairro" placeholder="Bairro">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Zona de Distribuição *</label>
                        <select class="form-select" wire:model="zona_distribuicao" required>
                            <option>Selecione...</option>
                          @if($zona)
                            @foreach($zona as $z)
                                <option value="{{ $z->nome }}">{{$z->nome}}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Ponto de Referência</label>
                    <input type="text" class="form-input" wire:model="ponto_referencia"
                        placeholder="Próximo ao mercado, igreja, etc.">
                </div>
                 
            </div>

            <!-- Aba: Dados da Ligação -->
            <div id="tab-ligacao" class="tab-content-novo" style="display: none;">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Número da Matrícula *</label>
                        <input type="text" class="form-input" wire:model="numero_matricula"
                            placeholder="MAT-2026-XXXXXX" style="font-family: monospace;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Categoria de Consumo *</label>
                        <select class="form-select" wire:model="categoria_consumo" required>
                            <option>Selecione...</option>
                            <option value="Residencial">Residencial Normal</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Público">Público / Institucional</option>
                        </select>
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Tipo de Ligação *</label>
                        <select class="form-select" wire:model="tipo_ligacao" required>
                            <option>Selecione...</option>
                            <option value="Ligação Nova">Ligação Nova</option>
                            <option value="Transferência">Transferência</option>
                            <option value="Desmembramento">Desmembramento</option>
                            <option value="Regularização">Regularização</option>
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label class="form-label">Diâmetro do Ramal (mm) *</label>
                        <select class="form-select" wire:model="diametro_ramal" required>
                            <option>Selecione...</option>
                            <option value="15mm">15mm (1/2")</option>
                            <option value="20mm">20mm (3/4")</option>
                            <option value="25mm">25mm (1")</option>
                            <option value="32mm">32mm (1 1/4")</option>
                            <option value="40mm">40mm (1 1/2")</option>
                            <option value="50mm">50mm (2")</option>
                            <option value="75mm">75mm (3")</option>
                            <option value="100mm">100mm (4")</option>
                        </select>
                    </div> --}}
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Data da Solicitação *</label>
                        <input type="date" class="form-input" wire:model="data_solicitacao" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Data Prevista de Ligação</label>
                        <input type="date" wire:model="data_solicitacao" class="form-input">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Tipo de Imóvel *</label>
                        <select class="form-select" wire:model='tipo_imovel' required>
                            <option>Selecione...</option>
                            <option value="Casa">Casa</option>
                            <option value="Apartamento">Apartamento</option>
                            <option value="Galpão / Depósito">Galpão / Depósito</option>
                            <option value="Terreno">Terreno</option>
                            <option value="Prédio Comercial">Prédio Comercial</option>
                            <option value="Indústria">Indústria</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Número de Economias *</label>
                        <input type="number" class="form-input" wire:model='numero_economias' placeholder="1"
                            min="1" value="1" required>
                        <p class="form-hint">Quantidade de unidades consumidoras no imóvel</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Observações / Condições Especiais</label>
                    <textarea class="form-textarea" wire:model='observacoes'
                        placeholder="Informações adicionais sobre a ligação, acesso restrito, etc."></textarea>
                </div>
            </div>

            <!-- Aba: Hidrômetro -->
            <div id="tab-hidrometro" class="tab-content-novo" style="display: none;">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Número do Hidrômetro *</label>
                        <input type="text" class="form-input" wire:model="numero_hidrometro"
                            wire:keydown.enter="buscarMedidor" wire:blur="buscarMedidor" placeholder="H-XXXX-XX"
                            style="font-family: monospace;" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Marca / Fabricante</label>
                        <select class="form-select" wire:model="marca" wire:change="buscarMedidor">
                            <option value="">Selecione...</option>
                            @if ($marcas)
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca }}">{{ $marca }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                {{--<div class="grid-2">
                     <div class="form-group">
                        <label class="form-label">Diâmetro do Hidrômetro (mm) *</label>
                        <select class="form-select" wire:model='diametro' required>
                            <option value="">Selecione...</option>
                            <option value="15mm">15mm</option>
                            <option value="20mm">20mm</option>
                            <option value="25mm">25mm</option>
                            <option value="32mm">32mm</option>
                            <option value="40mm">40mm</option>
                            <option value="50mm">50mm</option>
                            <option value="75mm">75mm</option>
                            <option value="100mm">100mm</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label class="form-label">Tipo de Hidrômetro</label>
                        <select class="form-select" wire:model='tipo_hidrometro'>
                            <option value="">Selecione...</option>
                            <option value="Unijato / Velocidade">Unijato / Velocidade</option>
                            <option value="Multijato">Multijato</option>
                            <option value="Woltman">Woltman</option>
                            <option value="Ultrassônico">Ultrassônico</option>
                            <option value="Eletromagnético">Eletromagnético</option>
                            <option value="Smart / Inteligente">Smart / Inteligente</option>
                        </select>
                    </div> 
                </div>--}}
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Leitura Inicial (m³) *</label>
                        <input type="number" wire:model='leitura_inicial' class="form-input" placeholder="0"
                            min="0" value="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Data de Instalação *</label>
                        <input type="date" wire:model='data_instalacao' class="form-input" required>
                    </div>
                </div>
                {{-- <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Local de Instalação</label>
                        <select class="form-select" wire:model='local_instalacao'>
                            <option>Calçada / Passeio Público</option>
                            <option>Muro / Fronteira</option>
                            <option>Interior do Imóvel</option>
                            <option>Caixa Subterrânea</option>
                            <option>Outro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Condição do Hidrômetro</label>
                        <select class="form-select" wire:model='condicao_hidrometro'>
                            <option value="Novo">Novo</option>
                            <option value="Usado / Recondicionado">Usado / Recondicionado</option>
                            <option value="Em Manutenção">Em Manutenção</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="form-label">Número do Lacre / Selo</label>
                    <input type="text" wire:model='numero_lacre' class="form-input"
                        placeholder="Número do lacre de segurança">
                </div>--}}
                <div
                    style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-top: var(--space-md);">
                    <label
                        style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                        <input type="checkbox" wire:model="vistoria_realizada"
                            style="accent-color: var(--primary); width: 18px; height: 18px;">
                        <span><strong>Vistoria técnica realizada</strong> — Confirmo que a instalação foi verificada
                            por técnico autorizado</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('modal-novo-cliente')">Cancelar</button>
             
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="margin-right: 6px;">
                    <path d="M20 6 9 17l-5-5" />
                </svg>
                Cadastrar Cliente
            </button>
        </div>
    </form>
</div>
