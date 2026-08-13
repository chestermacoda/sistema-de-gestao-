<div wire:ignore.self>
    <!-- Filters Bar -->
    <div class="card" style="padding: var(--space-md) var(--space-lg); margin-bottom: var(--space-lg);">
        <div style="display: flex; gap: var(--space-md); align-items: center; flex-wrap: wrap;">
            <div style="position: relative; flex: 1; min-width: 250px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" class="form-input" placeholder="Buscar por cliente, fatura, transação..."
                    style="padding-left: 2.5rem;" wire:model.live.debounce.300ms="busca">
            </div>
            <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="statusFiltro">
                <option value="">Todos os Status</option>
                <option value="Pago">Pago</option>

                <option value="Pendente">Pendente</option>
                <option value="Em Atraso">Em Atraso</option>
                <option value="Estornado">Estornado</option>
                <option value="Cancelado">Cancelado</option>
            </select>
            <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="metodoFiltro">
                <option value="todos">Todos os Métodos</option>
                <option value="PIX">PIX</option>
                <option value="Boleto">Boleto</option>
                <option value="Cartão de Crédito">Cartão de Crédito</option>
                <option value="Cartão de Débito">Cartão de Débito</option>
                <option value="Dinheiro">Dinheiro</option>
                <option value="Débito em Conta">Débito em Conta</option>
            </select>
            <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="mesFiltro">
                <option value="atual">Mês Atual</option>
                @foreach ($this->mesesOptions as $mes)
                    <option value="{{ $mes['valor'] }}">{{ $mes['label'] }}</option>
                @endforeach
                <option value="ultimos12">Últimos 12 Meses</option>
            </select>
            <button class="btn btn-outline btn-sm" wire:click="limparFiltros">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="margin-right: 6px;">
                    <path d="M3 6h18" />
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                </svg>
                Limpar
            </button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs" style="margin-bottom: var(--space-lg);">
        <button class="tab {{ $tabAtiva === 'todas' ? 'active' : '' }}" wire:click="$set('tabAtiva', 'todas')">
            Todas as Transações
        </button>
        <button class="tab {{ $tabAtiva === 'pagas' ? 'active' : '' }}" wire:click="$set('tabAtiva', 'pagas')">
            Pagas
        </button>
        <button class="tab {{ $tabAtiva === 'pendentes' ? 'active' : '' }}" wire:click="$set('tabAtiva', 'pendentes')">
            Pendentes
        </button>
        <button class="tab {{ $tabAtiva === 'estornos' ? 'active' : '' }}" wire:click="$set('tabAtiva', 'estornos')">
            Estornos
        </button>
    </div>

    <!-- Table Card -->
    <div class="card" style="margin: 0; margin-bottom: var(--space-xl);">
        <div class="card-header">
            <h3 class="card-title">Transações e Faturas</h3>
            <span style="font-size: var(--small-size); color: var(--text-muted);">
                Mostrando {{ $this->registros->count() }} de {{ $this->totalRegistros }} registros
            </span>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fatura Ref.</th>
                        <th>Valor</th>
                        <th>Método</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->registros as $registro)
                        @php
                            $tipo = $registro['tipo_registro'];
                            $isPagamento = $tipo === 'pagamento';
                            $isFatura = $tipo === 'fatura';

                            $pagamentoId = $registro['pagamento_id'];
                            $faturaId = $registro['fatura_id'];

                            $valor = $registro['valor'];
                            $metodo = $registro['metodo_pagamento'];
                            $statusPagamento = $registro['status_pagamento'];
                            $statusFatura = $registro['status_fatura'];
                            $codigoFatura = $registro['codigo_fatura'];
                            $nomeCliente = $registro['nome_completo'];
                            $matricula = $registro['numero_matricula'];
                            $dataPagamento = $registro['data_pagamento'];
                            $horaPagamento = $registro['hora_pagamento'];
                            $dataVencimento = $registro['data_vencimento'];

                            $badgeClass = $this->badgeClass($tipo, $statusPagamento, $statusFatura);
                            $labelStatus = $this->labelStatus($tipo, $statusPagamento, $statusFatura);
                            $corMetodo = $this->corMetodo($metodo);
                            $iconeMetodo = $this->iconeMetodo($metodo);

                            $isPendente = in_array($statusFatura, ['Pendente', 'Vencida', 'Negociada', 'Parcial']);
                        @endphp
                        <tr>
                            <td style="font-family: monospace; font-weight: 600;">
                                @if ($isPagamento)
                                    {{ $this->formatarTransacao($pagamentoId) }}
                                @else
                                    <span style="color: var(--warning);">{{ $codigoFatura }}</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $nomeCliente }}</strong><br>
                                <span style="font-size: var(--small-size); color: var(--text-muted);">
                                    {{ $matricula }}
                                </span>
                            </td>
                            <td style="font-family: monospace;">
                                {{ $codigoFatura }}
                            </td>
                            <td>
                                <strong>MZN {{ number_format($valor, 2, ',', '.') }}</strong>
                            </td>
                            <td>
                                @if ($metodo)
                                    <div style="display: flex; align-items: center; gap: var(--space-xs);">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="{{ $corMetodo }}" stroke-width="2">
                                            {!! $iconeMetodo !!}
                                        </svg>
                                        <span>{{ $metodo }}</span>
                                    </div>
                                @else
                                    <span style="font-size: var(--small-size); color: var(--text-muted);">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $badgeClass }}">{{ $labelStatus }}</span>
                            </td>
                            <td style="font-size: var(--small-size); color: var(--text-muted);">
                                @if ($isPagamento && $dataPagamento)
                                    {{ \Carbon\Carbon::parse($dataPagamento)->format('d/m/Y') }}<<br>
                                        {{ $horaPagamento ?? '--:--' }}
                                    @elseif($dataVencimento)
                                        <span style="color: var(--warning);">Venc:
                                            {{ \Carbon\Carbon::parse($dataVencimento)->format('d/m/Y') }}</span>
                                    @else
                                        —
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: var(--space-xs);">
                                    {{-- Detalhes --}}
                                    @if ($isFatura && $isPendente)
                                        <button class="btn btn-sm btn-ghost" {{-- onclick="openModal('modal-comprovante')" --}} title="Detalhes"
                                            wire:click="$dispatch('detalhes-fatura', { idFatura: {{ $faturaId }} })">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </button>
                                    @endif
                                    @if ($isPagamento)
                                        <button class="btn btn-sm btn-ghost" {{-- onclick="openModal('modal-comprovante')" --}} title="Detalhes"
                                            wire:click="$dispatch('detalhes-fatura', { idFatura: {{ $faturaId }}, idPagamento:{{ $pagamentoId }} })">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </button>

                                        {{-- Comprovante --}}
                                        <button class="btn btn-sm btn-ghost"
                                            wire:click="$dispatch('Comprovante-pagamento', { idFatura: {{ $faturaId }}, idPagamento:{{ $pagamentoId }} })"
                                            title="Comprovante">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                <polyline points="14 2 14 8 20 8" />
                                            </svg>
                                        </button>

                                        <button class="btn btn-sm btn-ghost"
                                            onclick="openModal('modal-estornar-pagamento')" {{-- wire:click="$dispatch('Comprovante-pagamento', { idFatura: {{ $faturaId }}, idPagamento:{{ $pagamentoId }} })" --}}
                                            title="Estornar Pagamento">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                                <path d="M3 3v5h5" />
                                            </svg>
                                        </button>
                                    @endif

                                    @if ($isFatura && $isPendente)
                                        {{-- PAGAR — botão para faturas pendentes --}}
                                        {{-- <button class="btn btn-sm btn-primary"
                                            wire:click="$dispatch('Pagar-Fatura', { idFatura: {{ $faturaId }} })"
                                            onclick="openModal('modal-novo-pagamento')" title="Efetuar Pagamento">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M5 12h14" />
                                                <path d="M12 5v14" />
                                            </svg>
                                        </button> --}}
                                        {{-- <button class="btn btn-sm btn-ghost"
                                            onclick="openModal('modal-confirmar-pagamento')"
                                            title="Confirmar Pagamento">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M20 6 9 17l-5-5" />
                                            </svg>
                                        </button> --}}
                                        {{-- wire:click="$dispatch('Pagar-Fatura', { idFatura: {{ $faturaId }} })" --}}
                                        <button class="btn btn-sm btn-ghost"
                                            wire:click="$dispatch('Pagar-Fatura', { idFatura: {{ $faturaId }} })"
                                            title="Comprovante">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif

                                    @if ($isPagamento && $statusPagamento === 'Pendente')
                                        {{-- Confirmar --}}
                                        <button class="btn btn-sm btn-ghost"
                                            onclick="openModal('modal-confirmar-pagamento')"
                                            title="Confirmar Pagamento">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M20 6 9 17l-5-5" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                style="text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5"
                                    style="margin-bottom: var(--space-md); opacity: 0.5;">
                                    <rect width="20" height="14" x="2" y="5" rx="2" />
                                    <line x1="2" x2="22" y1="10" y2="10" />
                                </svg>
                                <p>Nenhum registro encontrado</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        {{-- <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-xl);">
            <span style="font-size: var(--small-size); color: var(--text-muted);">
                Página {{ $this->registros->currentPage() }} de {{ $this->registros->lastPage() }}
            </span>
            <div style="display: flex; gap: var(--space-xs);">
                {{ $this->registros->links() }}
            </div>
        </div> --}}
        @include('admin.components.pagination', ['paginator' => $this->registros])
    </div>

</div>
