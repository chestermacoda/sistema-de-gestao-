<div class="modal-overlay" id="modal-novo-medidor" wire:ignore.self>
    <form wire:submit="salvar" onsubmit="clearMedidorTab()" class="modal modal-lg" style="max-width: 800px;">
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
                    <h3 class="modal-title">Cadastrar Novo Medidor</h3>
                    <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Registre um
                        novo hidrômetro no estoque ou para instalação</p>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('modal-novo-medidor')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="tabs" style="margin-bottom: var(--space-lg);">
                <button type="button" class="tab active" onclick="switchTabNovoMed(this, 'tab-novo-dados')">Dados do
                    Medidor</button>
                <button type="button" class="tab" onclick="switchTabNovoMed(this, 'tab-novo-documentos')">Documentos
                    &
                    Certificados</button>
            </div>

            <!-- Aba: Dados do Medidor -->
            <div id="tab-novo-dados" class="tab-content-novo-med" style="display: block;">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Número do Hidrômetro *</label>
                        <input type="text" class="form-input" wire:model.live="numero_hidrometro"
                            placeholder="H-XXXX-XX" style="font-family: monospace;" required>
                        @error('numero_hidrometro')
                            <span style="color: var(--danger)">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Número de Série do Fabricante</label>
                        <input type="text" class="form-input" wire:model.live="numero_serie"
                            placeholder="Série do fabricante" style="font-family: monospace;">
                        @error('numero_serie')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Marca / Fabricante *</label>
                        <select class="form-select" wire:model.live="marca" required>
                            <option>Selecione...</option>
                            <option value="Actaris / Itron">Actaris / Itron</option>
                            <option value="Bayard">Bayard</option>
                            <option value="Coprel">Coprel</option>
                            <option value="Elster">Elster</option>
                            <option value="Hersey">Hersey</option>
                            <option value="Hydrometer">Hydrometer</option>
                            <option value="Poços">Poços</option>
                            <option value="Sensus">Sensus</option>
                            <option value="Outra">Outra</option>
                        </select>
                        @error('marca')
                            <span style="color: var(--danger)">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Modelo</label>
                        <input type="text" class="form-input" placeholder="Ex: MN-15, Multimag, etc.">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Diâmetro (mm) *</label>
                        <select class="form-select" wire:model.live="diametro" required>
                            <option>Selecione...</option>
                            <option value="15mm">15mm</option>
                            <option value="20mm">20mm</option>
                            <option value="25mm">25mm</option>
                            <option value="32mm">32mm</option>
                            <option value="40mm">40mm</option>
                            <option value="50mm">50mm</option>
                            <option value="75mm">75mm</option>
                            <option value="100mm">100mm</option>
                        </select>
                        @error('diametro')
                            <span style="color: var(--danger)">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tipo de Hidrômetro *</label>
                        <select wire:model.live="tipo_hidrometro" class="form-select" required>
                            <option>Selecione...</option>
                            <option value="Unijato / Velocidade">Unijato / Velocidade</option>
                            <option value="Multijato">Multijato</option>
                            <option value="Woltman">Woltman</option>
                            <option value="Ultrassônico">Ultrassônico</option>
                            <option value="Eletromagnético">Eletromagnético</option>
                            <option value="Smart / Inteligente">Smart / Inteligente</option>
                        </select>
                        @error('tipo_hidrometro')
                            <span style="color:var(--danger)">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Classe Metrológica</label>
                        <select class="form-select" wire:model.live='classe_metrologica'>
                            <option>Selecione...</option>
                            <option value="Classe A">Classe A</option>
                            <option value="Classe B">Classe B</option>
                            <option value="Classe C">Classe C</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Qn (Vazão Nominal)</label>
                        <input type="text" class="form-input" wire:model.live='qn' placeholder="Ex: 1.5 m³/h">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Qmax (Vazão Máxima)</label>
                        <input type="text" class="form-input" wire:model.live='qmax' placeholder="Ex: 3.0 m³/h">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Qmin (Vazão Mínima)</label>
                        <input type="text" class="form-input" wire:model.live='qmin' placeholder="Ex: 0.03 m³/h">
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Ano de Fabricação</label>
                        <input type="number" class="form-input" wire:model.live='ano_fabricacao' placeholder="2026"
                            min="2000" max="2030">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Data de Aquisição *</label>
                        <input type="date" class="form-input" wire:model.live="data_aquisicao" required>
                    </div>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Fornecedor</label>
                        <input type="text" class="form-input" wire:model.live='fornecedor'
                            placeholder="Nome do fornecedor">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nota Fiscal</label>
                        <input type="text" class="form-input" wire:model.live='nota_fiscal'
                            placeholder="Nº da NF de compra">
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label class="form-label">Status Inicial *</label>
                    <div style="display: flex; gap: var(--space-md);">
                        <label
                            style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; padding: var(--space-sm) var(--space-md); border: 2px solid var(--primary); border-radius: var(--radius-md); background: rgba(0,51,102,0.05); flex: 1; justify-content: center;">
                            <input type="radio" name="status_inicial" value="estoque" checked
                                style="accent-color: var(--primary);">
                            <span style="font-weight: 600; color: var(--primary);">Em Estoque</span>
                        </label>
                        <label
                            style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; padding: var(--space-sm) var(--space-md); border: 2px solid var(--neutral-darker); border-radius: var(--radius-md); flex: 1; justify-content: center;">
                            <input type="radio" name="status_inicial" value="instalar"
                                style="accent-color: var(--primary);">
                            <span style="font-weight: 500; color: var(--text-secondary);">Instalar Direto</span>
                        </label>
                    </div>
                </div> --}}
                <div class="form-group">
                    <label class="form-label">Status Inicial *</label>
                    <div style="display: flex; gap: var(--space-md);">

                        <!-- Opção: Em Estoque -->
                        <label
                            style="
            display: flex; align-items: center; gap: var(--space-sm); cursor: pointer;
            padding: var(--space-sm) var(--space-md);
            border: 2px solid {{ $status_inicial === 'estoque' ? 'var(--primary)' : 'var(--neutral-darker)' }};
            border-radius: var(--radius-md);
            background: {{ $status_inicial === 'estoque' ? 'rgba(0,51,102,0.05)' : 'transparent' }};
            flex: 1; justify-content: center; transition: all 0.2s;">

                            <input type="radio" wire:model.live="status_inicial" value="estoque"
                                style="accent-color: var(--primary);">

                            <span
                                style="font-weight: {{ $status_inicial === 'estoque' ? '600' : '500' }};
                         color: {{ $status_inicial === 'estoque' ? 'var(--primary)' : 'var(--text-secondary)' }};">
                                Em Estoque
                            </span>
                        </label>

                        <!-- Opção: Instalar Direto -->
                        <label
                            style="
            display: flex; align-items: center; gap: var(--space-sm); cursor: pointer;
            padding: var(--space-sm) var(--space-md);
            border: 2px solid {{ $status_inicial === 'instalar' ? 'var(--primary)' : 'var(--neutral-darker)' }};
            border-radius: var(--radius-md);
            background: {{ $status_inicial === 'instalar' ? 'rgba(0,51,102,0.05)' : 'transparent' }};
            flex: 1; justify-content: center; transition: all 0.2s;">

                            <input type="radio" wire:model.live="status_inicial" value="instalar"
                                style="accent-color: var(--primary);">

                            <span
                                style="font-weight: {{ $status_inicial === 'instalar' ? '600' : '500' }};
                         color: {{ $status_inicial === 'instalar' ? 'var(--primary)' : 'var(--text-secondary)' }};">
                                Instalar Direto
                            </span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Quantidade</label>
                    <input type="number" class="form-input" wire:model.live="quantidade"
                        placeholder="Informações adicionais sobre o medidor">
                </div>
                <div class="form-group">
                    <label class="form-label">Observações</label>
                    <textarea class="form-textarea" wire:model.live="observacoes" placeholder="Informações adicionais sobre o medidor"></textarea>
                </div>
            </div>

            <!-- Aba: Documentos -->
            <div id="tab-novo-documentos" class="tab-content-novo-med" style="display: none;">
                <div class="grid-2">
                    {{-- <div class="form-group">
                        <label class="form-label">Certificado de Calibração</label>
                        <div
                            style="border: 2px dashed var(--neutral-darker); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center; cursor: pointer;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="var(--text-muted)" stroke-width="2" style="margin: 0 auto var(--space-sm);">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" x2="12" y1="3" y2="15" />
                            </svg>
                            <p style="font-size: var(--label-size); color: var(--text-secondary);">Arraste ou clique
                                para upload</p>
                            <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">PDF,
                                JPG ou PNG até 10MB</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Laudo Técnico INMETRO</label>
                        <div
                            style="border: 2px dashed var(--neutral-darker); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center; cursor: pointer;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="var(--text-muted)" stroke-width="2" style="margin: 0 auto var(--space-sm);">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" x2="12" y1="3" y2="15" />
                            </svg>
                            <p style="font-size: var(--label-size); color: var(--text-secondary);">Arraste ou clique
                                para upload</p>
                            <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">PDF
                                até 10MB</p>
                        </div>
                    </div> --}}

                    <!-- Campo: Certificado de Calibração -->
                    <div class="form-group">
                        <label class="form-label">Certificado de Calibração</label>
                        <!-- Área de Clique (Dropzone) -->
                        <div onclick="document.getElementById('file-certificado').click()"
                            style="border: 2px dashed var(--neutral-darker); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center; cursor: pointer; position: relative;">

                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="var(--text-muted)" stroke-width="2" style="margin: 0 auto var(--space-sm);">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" x2="12" y1="3" y2="15" />
                            </svg>

                            <!-- Feedback de Nome do Arquivo ou Instrução -->
                            @if ($certificado_calibracao)
                                <p style="font-size: var(--label-size); color: var(--success); font-weight: 600;">
                                    ✓ Arquivo selecionado:
                                    {{ is_string($certificado_calibracao) ? 'Arquivo atual' : $certificado_calibracao->getClientOriginalName() }}
                                </p>
                            @else
                                <p style="font-size: var(--label-size); color: var(--text-secondary);">Arraste ou
                                    clique para upload</p>
                                <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                                    PDF, JPG ou PNG até 10MB</p>
                            @endif

                            <!-- Loading Indicator -->
                            <div wire:loading wire:target="certificado_calibracao"
                                style="margin-top: 10px; font-size: var(--small-size); color: var(--primary);">
                                Enviando arquivo...
                            </div>
                        </div>

                        <!-- Input Escondido -->
                        <input type="file" id="file-certificado" wire:model="certificado_calibracao"
                            style="display: none;">

                        @error('certificado_calibracao')
                            <span
                                style="color: var(--danger); font-size: var(--small-size); display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo: Laudo Técnico INMETRO -->
                    <div class="form-group" style="margin-top: var(--space-md);">
                        <label class="form-label">Laudo Técnico INMETRO</label>

                        <div onclick="document.getElementById('file-laudo').click()"
                            style="border: 2px dashed var(--neutral-darker); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center; cursor: pointer;">

                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="var(--text-muted)" stroke-width="2" style="margin: 0 auto var(--space-sm);">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" x2="12" y1="3" y2="15" />
                            </svg>

                            @if ($laudo_inmetro)
                                <p style="font-size: var(--label-size); color: var(--success); font-weight: 600;">
                                    ✓ Arquivo selecionado:
                                    {{ is_string($laudo_inmetro) ? 'Arquivo atual' : $laudo_inmetro->getClientOriginalName() }}
                                </p>
                            @else
                                <p style="font-size: var(--label-size); color: var(--text-secondary);">Arraste ou
                                    clique para upload</p>
                                <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">PDF
                                    até 10MB</p>
                            @endif

                            <div wire:loading wire:target="laudo_inmetro"
                                style="margin-top: 10px; font-size: var(--small-size); color: var(--primary);">
                                Enviando arquivo...
                            </div>
                        </div>

                        <input type="file" id="file-laudo" wire:model="laudo_inmetro" style="display: none;">

                        @error('laudo_inmetro')
                            <span
                                style="color: var(--danger); font-size: var(--small-size); display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Número do Certificado INMETRO</label>
                    <input type="text" class="form-input" placeholder="Nº do certificado de aprovação do modelo"
                        wire:model.live='numero_certificado_inmetro'>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Validade do Certificado</label>
                        <input type="date" class="form-input" wire:model.live='validade_certificado'>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Laboratório de Calibração</label>
                        <input type="text" class="form-input" wire:model.live='laboratorio_calibracao'
                            placeholder="Nome do laboratório">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('modal-novo-medidor')">Cancelar</button>
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="margin-right: 6px;">
                    <path d="M20 6 9 17l-5-5" />
                </svg>
                Cadastrar Medidor
            </button>
        </div>
    </form>
</div>
