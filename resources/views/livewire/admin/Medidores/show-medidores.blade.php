<div>
    <!-- Filtros Dinâmicos -->
    <div class="card" style="padding: var(--space-md) var(--space-lg); margin-bottom: var(--space-lg);">
        <div style="display: flex; gap: var(--space-md); align-items: center; flex-wrap: wrap;">

            <!-- Busca -->
            <div style="position: relative; flex: 1; min-width: 250px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" class="form-input" wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por número, série, marca, modelo..." style="padding-left: 2.5rem;">
            </div>

            <!-- Filtro Status -->
            <select class="form-select" wire:model.live="statusFilter" style="width: auto; min-width: 160px;">
                <option value="">Todos os Status</option>
                <option value="Estoque">Em Estoque</option>
                <option value="instalado">Em Operação</option>
                <option value="Manutencao">Em Manutenção</option>
                <option value="Descartado">Descartado</option>
                <option value="Cortada">Ligação Cortada</option>
            </select>

            <!-- Filtro Diâmetro -->
            <select class="form-select" wire:model.live="diametroFilter" style="width: auto; min-width: 160px;">
                <option value="">Todos os Diâmetros</option>
                <option value="15mm">15mm</option>
                <option value="20mm">20mm</option>
                <option value="25mm">25mm</option>
                <option value="32mm">32mm</option>
                <option value="40mm">40mm</option>
                <option value="50mm">50mm</option>
                <option value="75mm">75mm</option>
                <option value="100mm">100mm</option>
            </select>

            <!-- Filtro Marca -->
            <select class="form-select" wire:model.live="marcaFilter" style="width: auto; min-width: 160px;">
                <option value="">Todas as Marcas</option>
                <option value="Actaris">Actaris / Itron</option>
                <option value="Bayard">Bayard</option>
                <option value="Coprel">Coprel</option>
                <option value="Elster">Elster</option>
                <option value="Sensus">Sensus</option>
            </select>

            <!-- Exportar -->
            <button class="btn btn-outline btn-sm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="margin-right: 6px;">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" x2="12" y1="15" y2="3" />
                </svg>
                Exportar
            </button>
        </div>
    </div>

    <!-- View Toggle + Contador -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-lg);">
        <div
            style="display: flex; gap: var(--space-xs); background: var(--neutral); padding: 4px; border-radius: var(--radius-md);">

            <!-- Botão Cards -->
            <button wire:click="setViewMode('cards')"
                class="btn btn-sm {{ $viewMode === 'cards' ? 'btn-primary' : 'btn-ghost' }}"
                style="border-radius: var(--radius-sm);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="margin-right: 4px;">
                    <rect width="7" height="7" x="3" y="3" rx="1" />
                    <rect width="7" height="7" x="14" y="3" rx="1" />
                    <rect width="7" height="7" x="14" y="14" rx="1" />
                    <rect width="7" height="7" x="3" y="14" rx="1" />
                </svg>
                Cards
            </button>

            <!-- Botão Lista -->
            <button wire:click="setViewMode('lista')"
                class="btn btn-sm {{ $viewMode === 'lista' ? 'btn-primary' : 'btn-ghost' }}"
                style="border-radius: var(--radius-sm);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="margin-right: 4px;">
                    <line x1="4" x2="20" y1="6" y2="6" />
                    <line x1="4" x2="20" y1="12" y2="12" />
                    <line x1="4" x2="20" y1="18" y2="18" />
                </svg>
                Lista
            </button>
        </div>

        <span style="font-size: var(--small-size); color: var(--text-muted);">
            Mostrando {{ $this->medidores->firstItem() ?? 0 }}-{{ $this->medidores->lastItem() ?? 0 }}
            de {{ $this->medidores->total() }} medidores
        </span>
    </div>

    <!-- ==================== VIEW: CARDS ==================== -->
    @if ($viewMode === 'cards')
        <div class="medidores-grid" style="margin-bottom: var(--space-xl);">
            @forelse ($this->medidores as $medidor)
                @php
                    $status = $this->getStatusMedidor($medidor);
                    $leitura = $this->getLeituraData($medidor);
                    $cliente = $this->getClienteInfo($medidor);
                    $estoque = $this->getEstoqueInfo($medidor);
                    $calibracao = $this->getCalibracaoStatus($medidor);
                    $acoes = $this->getAcoes($medidor);
                @endphp

                <div class="medidor-card {{ $status['cardClass'] }}" wire:key="medidor-card-{{ $medidor->id }}">
                    <div class="medidor-header">
                        <div>
                            <div class="medidor-numero">{{ $medidor->numero_hidrometro }}</div>
                            <div class="medidor-cliente">{{ $cliente['nome'] }}</div>
                        </div>
                        <span class="status-medidor {{ $status['class'] }}">{{ $status['text'] }}</span>
                    </div>

                    <div class="medidor-body">
                        <div class="medidor-info-row">
                            <span class="medidor-info-label">Marca / Modelo</span>
                            <span class="medidor-info-value">{{ $medidor->marca }} —
                                {{ $medidor->modelo ?? '—' }}</span>
                        </div>
                        <div class="medidor-info-row">
                            <span class="medidor-info-label">Diâmetro</span>
                            <span class="medidor-info-value">{{ $medidor->diametro ?? '-' }}</span>
                        </div>
                        <div class="medidor-info-row">
                            <span class="medidor-info-label">Local</span>
                            <span class="medidor-info-value">{{ $cliente['local'] }}</span>
                        </div>
                        @if ($status['label'] === 'Em Estoque' || $estoque['total'] > 1)
                            <div class="medidor-info-row">
                                <span class="medidor-info-label">Entrada</span>
                                <span class="medidor-info-value">{{ $cliente['instalacao'] }}</span>
                            </div>
                        @else
                            <div class="medidor-info-row">
                                <span class="medidor-info-label">Instalação</span>
                                <span class="medidor-info-value">{{ $cliente['instalacao'] }}</span>
                            </div>
                        @endif
                        <!-- Estoque info (se aplicável) -->
                        @if ($status['label'] === 'Em Estoque' || $estoque['total'] > 1)
                            <div class="medidor-info-row">
                                <span class="medidor-info-label">Estoque</span>
                                <span class="medidor-info-value">
                                    {{ $estoque['disponivel'] }} disp. / {{ $estoque['total'] }} total
                                </span>
                            </div>
                        @endif

                        <!-- Calibração -->
                        <div class="medidor-info-row">
                            <span class="medidor-info-label">Calibração</span>
                            <span class="medidor-info-value" style="color: var(--{{ $calibracao['class'] }});">
                                {{ $calibracao['text'] }}
                            </span>
                        </div>

                        <div class="medidor-leitura" style="{{ $leitura['style'] }}">
                            <div class="medidor-leitura-valor" style="{{ $leitura['valorColor'] }}">
                                {{ $leitura['valor'] }}</div>
                            <div class="medidor-leitura-label" style="{{ $leitura['labelColor'] }}">
                                {{ $leitura['label'] }}</div>
                        </div>
                    </div>

                    <div class="medidor-footer">
                        <span class="medidor-data">{{ $cliente['matricula'] }}</span>
                        <div style="display: flex; gap: var(--space-xs);">

                            <!-- Ver Detalhes -->
                            <button class="btn btn-sm btn-ghost" onclick="openModal('modal-ver-medidor')"
                                title="Detalhes">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>

                            <!-- Registrar Leitura -->
                            {{-- onclick="openModal('modal-leitura-medidor')"  --}}
                            @if (in_array('leitura', $acoes))
                                <button class="btn btn-sm btn-ghost"
                                    wire:click="$dispatch('leitura-OpenAction', { idMedidor: {{ $medidor->id }},idCliente: {{ $cliente['cliente_id'] }} })"
                                    title="Registrar Leitura">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" x2="8" y1="13" y2="13" />
                                    </svg>
                                </button>
                            @endif

                            <!-- Manutenção -->
                            @if (in_array('manutencao', $acoes))
                                <button class="btn btn-sm btn-ghost" onclick="openModal('modal-manutencao-medidor')"
                                    title="Manutenção">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                                    </svg>
                                </button>
                            @endif

                            <!-- Finalizar Manutenção -->
                            @if (in_array('finalizar_manutencao', $acoes))
                                <button class="btn btn-sm btn-ghost" onclick="openModal('modal-manutencao-medidor')"
                                    title="Finalizar Manutenção">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M20 6 9 17l-5-5" />
                                    </svg>
                                </button>
                            @endif

                            <!-- Instalar -->
                            @if (in_array('instalar', $acoes))
                                <button class="btn btn-sm btn-ghost" onclick="openModal('modal-instalar-medidor')"
                                    title="Instalar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14" />
                                        <path d="M12 5v14" />
                                    </svg>
                                </button>
                            @endif

                            @if (in_array('religar', $acoes))
                                <button class="btn btn-sm btn-ghost" onclick="openModal('modal-religar-medidor')"
                                    title="Solicitar Religação">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1" style="margin: 0 auto 16px; opacity: 0.4;">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <p style="font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Nenhum medidor encontrado
                    </p>
                    <p style="font-size: var(--small-size);">
                        @if ($search || $statusFilter || $diametroFilter || $marcaFilter)
                            Tente ajustar os filtros de busca
                            <br>
                            <button
                                wire:click="$set('search', ''); $set('statusFilter', ''); $set('diametroFilter', ''); $set('marcaFilter', '')"
                                class="btn btn-primary" style="margin-top: 16px;">
                                Limpar filtros
                            </button>
                        @else
                            Comece cadastrando um novo medidor
                        @endif
                    </p>
                </div>
            @endforelse
        </div>
    @endif

    <!-- ==================== VIEW: LISTA ==================== -->
    @if ($viewMode === 'lista')
        <div class="card" style="margin: 0; margin-bottom: var(--space-xl);">
            <div class="table-container">
                <table id="tabelaMedidores" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--neutral); border-bottom: 1px solid var(--neutral-dark);">
                            <th
                                style="padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted);">
                                Nº Hidrômetro</th>
                            <th
                                style="padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted);">
                                Cliente</th>
                            <th
                                style="padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted);">
                                Marca/Modelo</th>
                            <th
                                style="padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted);">
                                Diâmetro</th>
                            <th
                                style="padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted);">
                                Local</th>
                            <th
                                style="padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted);">
                                Status</th>
                            <th
                                style="padding: 12px 16px; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted);">
                                Leitura Atual</th>
                            <th
                                style="padding: 12px 16px; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted); width: 120px;">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->medidores as $medidor)
                            @php
                                $status = $this->getStatusMedidor($medidor);
                                $leitura = $this->getLeituraData($medidor);
                                $cliente = $this->getClienteInfo($medidor);
                                $estoque = $this->getEstoqueInfo($medidor);
                                $calibracao = $this->getCalibracaoStatus($medidor);
                                $acoes = $this->getAcoes($medidor);
                            @endphp

                            <tr wire:key="medidor-lista-{{ $medidor->id }}"
                                style="border-bottom: 1px solid var(--neutral-dark);">
                                <td style="padding: 14px 16px;">
                                    <div
                                        style="font-family: monospace; font-size: var(--label-size); font-weight: 600; color: var(--text-primary);">
                                        {{ $medidor->numero_hidrometro }}
                                    </div>
                                    <div style="font-size: var(--small-size); color: var(--text-muted);">
                                        Série: {{ $medidor->numero_serie ?? '-' }}
                                    </div>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <div
                                        style="font-weight: 600; color: var(--text-primary); font-size: var(--label-size);">
                                        {{ $cliente['nome'] }}
                                    </div>
                                    <div
                                        style="font-size: var(--small-size); color: var(--text-muted); font-family: monospace;">
                                        {{ $cliente['numero_matricula'] ?? $cliente['matricula'] }}
                                    </div>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <div style="font-size: var(--label-size); color: var(--text-primary);">
                                        {{ $medidor->marca }}
                                    </div>
                                    <div style="font-size: var(--small-size); color: var(--text-muted);">
                                        {{ $medidor->modelo ?? '-' }}
                                    </div>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <span style="font-size: var(--label-size); color: var(--text-primary);">
                                        {{ $medidor->diametro ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <div style="font-size: var(--label-size); color: var(--text-primary);">
                                        {{ $cliente['local'] }}
                                    </div>
                                    <div style="font-size: var(--small-size); color: var(--text-muted);">
                                        Inst. {{ $cliente['instalacao'] }}
                                    </div>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <span class="badge {{ $status['badgeClass'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                    @if ($estoque['total'] > 1)
                                        <div style="font-size: 0.625rem; color: var(--text-muted); margin-top: 2px;">
                                            {{ $estoque['disponivel'] }}/{{ $estoque['total'] }} disp.
                                        </div>
                                    @endif
                                </td>
                                <td style="padding: 14px 16px;">
                                    <div
                                        style="font-size: var(--label-size); font-weight: 600; {{ $leitura['valorColor'] }}">
                                        {{ $leitura['valor'] }}
                                    </div>
                                    <div style="font-size: var(--small-size); {{ $leitura['labelColor'] }}">
                                        {{ $leitura['label'] }}
                                    </div>
                                </td>
                                <td style="padding: 14px 16px; text-align: right;">
                                    <div style="display: flex; gap: var(--space-xs); justify-content: flex-end;">
                                        <button class="btn btn-sm btn-ghost" onclick="openModal('modal-ver-medidor')"
                                            title="Detalhes"
                                            wire:click="$dispatch('Comprovante-pagamento', { idFatura: {{ }} )">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </button>
                                        @if (in_array('leitura', $acoes))
                                            <button class="btn btn-sm btn-ghost"
                                                onclick="openModal('modal-leitura-medidor')"
                                                title="Registrar Leitura">
                                                <svg width="16" height="16" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                    <polyline points="14 2 14 8 20 8" />
                                                    <line x1="16" x2="8" y1="13"
                                                        y2="13" />
                                                </svg>
                                            </button>
                                        @endif
                                        @if (in_array('manutencao', $acoes))
                                            <button class="btn btn-sm btn-ghost"
                                                onclick="openModal('modal-manutencao-medidor')" title="Manutenção">
                                                <svg width="16" height="16" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <path
                                                        d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8"
                                    style="text-align: center; padding: 60px 20px; color: var(--text-muted);">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1"
                                        style="margin: 0 auto 16px; opacity: 0.4;">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    <p
                                        style="font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                                        Nenhum medidor encontrado
                                    </p>
                                    <p style="font-size: var(--small-size);">
                                        @if ($search || $statusFilter || $diametroFilter || $marcaFilter)
                                            Tente ajustar os filtros de busca
                                            <br>
                                            <button
                                                wire:click="$set('search', ''); $set('statusFilter', ''); $set('diametroFilter', ''); $set('marcaFilter', '')"
                                                class="btn btn-primary" style="margin-top: 16px;">
                                                Limpar filtros
                                            </button>
                                        @else
                                            Comece cadastrando um novo medidor
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Paginação -->

    @include('admin.components.pagination', ['paginator' => $this->medidores])
</div>
