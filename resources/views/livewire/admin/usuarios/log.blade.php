<style>
    /* ============================================
   LOGS DE AUDITORIA - ESTILOS ESPECIFICOS
   ============================================ */

    /* Badge de contagem no titulo */
    .usr-badge-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        height: 24px;
        padding: 0 8px;
        background: var(--primary);
        color: var(--white);
        font-size: var(--small-size);
        font-weight: 600;
        border-radius: 12px;
        margin-left: var(--space-sm);
        vertical-align: middle;
    }

    /* Container de filtros */
    .usr-filtros-auditoria {
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
        margin-bottom: var(--space-lg);
        padding: var(--space-md);
        background: var(--neutral);
        border-radius: var(--radius-md);
        border: 1px solid var(--neutral-dark);
    }

    .usr-filtros-row {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        flex-wrap: wrap;
    }

    .usr-filtro-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .usr-filtro-busca {
        flex: 1;
        min-width: 250px;
    }

    .usr-filtro-busca svg {
        position: absolute;
        left: 12px;
        color: var(--text-muted);
        pointer-events: none;
    }

    .usr-filtro-busca input {
        width: 100%;
        padding-left: 2.5rem !important;
    }

    .usr-filtro-datas {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        flex-wrap: wrap;
    }

    .usr-filtro-datas label {
        font-size: var(--small-size);
        color: var(--text-secondary);
        font-weight: 500;
    }

    .usr-filtro-datas input[type="date"] {
        width: auto;
        min-width: 140px;
    }

    .usr-filtros-acoes {
        justify-content: space-between;
        align-items: center;
        padding-top: var(--space-sm);
        border-top: 1px solid var(--neutral-dark);
    }

    .usr-filtro-paginacao {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .usr-filtro-paginacao label {
        font-size: var(--small-size);
        color: var(--text-secondary);
    }

    .usr-filtros-exportar {
        display: flex;
        gap: var(--space-sm);
    }

    /* Loading overlay */
    .usr-loading-overlay {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: var(--space-2xl);
        gap: var(--space-md);
        color: var(--text-muted);
        font-size: var(--label-size);
    }

    .usr-spinner {
        width: 32px;
        height: 32px;
        border: 3px solid var(--neutral-dark);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: usr-spin 0.8s linear infinite;
    }

    @keyframes usr-spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Lista de auditoria */
    .usr-audit-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
        max-height: 500px;
        overflow-y: auto;
        padding-right: var(--space-xs);
    }

    .usr-audit-item {
        display: flex;
        gap: var(--space-md);
        padding: var(--space-md);
        background: var(--white);
        border: 1px solid var(--neutral-dark);
        border-radius: var(--radius-md);
        transition: all 0.2s ease;
    }

    .usr-audit-item:hover {
        border-color: var(--primary-lighter);
        box-shadow: var(--shadow-sm);
    }

    /* Icones de tipo */
    .usr-audit-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        flex-shrink: 0;
    }

    .usr-audit-icon svg {
        width: 20px;
        height: 20px;
    }

    .usr-create {
        background: var(--success-light);
        color: var(--success);
    }

    .usr-update {
        background: #dbeafe;
        color: #2563eb;
    }

    .usr-delete {
        background: var(--danger-light);
        color: var(--danger);
    }

    .usr-login {
        background: #e0e7ff;
        color: #4f46e5;
    }

    .usr-logout {
        background: #f3e8ff;
        color: #7c3aed;
    }

    .usr-warning {
        background: var(--warning-light);
        color: var(--warning);
    }

    .usr-permission {
        background: #ccfbf1;
        color: #0d9488;
    }

    .usr-role {
        background: #fce7f3;
        color: #db2777;
    }

    /* Conteudo do log */
    .usr-audit-content {
        flex: 1;
        min-width: 0;
    }

    .usr-audit-title {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        font-weight: 600;
        color: var(--text-primary);
        font-size: var(--label-size);
        margin-bottom: var(--space-xs);
    }

    .usr-audit-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 8px;
        border-radius: var(--radius-sm);
        font-size: var(--small-size);
        font-weight: 500;
    }

    .usr-audit-desc {
        font-size: var(--small-size);
        color: var(--text-secondary);
        margin-bottom: var(--space-xs);
    }

    .usr-audit-meta {
        display: flex;
        align-items: center;
        gap: var(--space-md);
        flex-wrap: wrap;
        font-size: var(--small-size);
        color: var(--text-muted);
    }

    .usr-audit-meta span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .usr-audit-meta svg {
        color: var(--text-muted);
    }

    .usr-audit-detalhes-btn {
        background: none;
        border: none;
        color: var(--primary);
        font-size: var(--small-size);
        font-weight: 500;
        cursor: pointer;
        padding: 2px 0;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .usr-audit-detalhes-btn:hover {
        color: var(--primary-light);
    }

    /* Estado vazio */
    .usr-audit-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: var(--space-2xl);
        text-align: center;
        color: var(--text-muted);
    }

    .usr-audit-empty p {
        margin: 0;
        font-size: var(--label-size);
    }

    /* Paginacao */
    .usr-audit-pagination {
        margin-top: var(--space-lg);
        display: flex;
        justify-content: center;
    }

    .usr-audit-pagination nav {
        display: flex;
        gap: var(--space-xs);
    }

    .usr-audit-pagination nav>* {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 var(--space-sm);
        border-radius: var(--radius-md);
        font-size: var(--small-size);
        font-weight: 500;
        color: var(--text-secondary);
        background: var(--white);
        border: 1px solid var(--neutral-dark);
        transition: all 0.2s;
    }

    .usr-audit-pagination nav>*[aria-current="page"] {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .usr-audit-pagination nav>*:hover:not([aria-current="page"]) {
        background: var(--neutral);
        color: var(--text-primary);
    }

    /* Detalhes do log (modal interno) */
    .usr-log-detalhes {
        display: flex;
        flex-direction: column;
        gap: var(--space-md);
    }

    .usr-log-detalhe-row {
        display: flex;
        gap: var(--space-sm);
        padding: var(--space-sm) 0;
        border-bottom: 1px solid var(--neutral-dark);
    }

    .usr-log-detalhe-row:last-child {
        border-bottom: none;
    }

    .usr-log-label {
        min-width: 120px;
        font-weight: 600;
        color: var(--text-secondary);
        font-size: var(--small-size);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .usr-log-value {
        flex: 1;
        color: var(--text-primary);
        font-size: var(--label-size);
    }

    .usr-log-alteracoes h4,
    .usr-log-propriedades h4 {
        font-size: var(--label-size);
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: var(--space-sm);
        padding-bottom: var(--space-xs);
        border-bottom: 1px solid var(--neutral-dark);
    }

    .usr-log-tabela {
        width: 100%;
        border-collapse: collapse;
        font-size: var(--small-size);
    }

    .usr-log-tabela th {
        text-align: left;
        padding: var(--space-sm);
        background: var(--neutral);
        color: var(--text-secondary);
        font-weight: 600;
        border-bottom: 2px solid var(--neutral-dark);
    }

    .usr-log-tabela td {
        padding: var(--space-sm);
        border-bottom: 1px solid var(--neutral-dark);
        color: var(--text-primary);
    }

    .usr-log-tabela tr.usr-log-changed {
        background: var(--warning-light);
    }

    .usr-log-old {
        color: var(--danger);
        text-decoration: line-through;
        opacity: 0.7;
    }

    .usr-log-new {
        color: var(--success);
        font-weight: 600;
    }

    .usr-log-propriedades pre {
        background: var(--neutral);
        padding: var(--space-md);
        border-radius: var(--radius-md);
        font-size: var(--small-size);
        color: var(--text-secondary);
        overflow-x: auto;
        max-height: 300px;
        overflow-y: auto;
    }

    /* Transicoes do modal */
    .modal-enter {
        transition: opacity 0.3s ease;
    }

    .modal-enter-start {
        opacity: 0;
    }

    .modal-enter-end {
        opacity: 1;
    }

    .modal-leave {
        transition: opacity 0.2s ease;
    }

    .modal-leave-start {
        opacity: 1;
    }

    .modal-leave-end {
        opacity: 0;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .usr-filtros-row {
            flex-direction: column;
            align-items: stretch;
        }

        .usr-filtro-busca {
            min-width: 100%;
        }

        .usr-filtros-acoes {
            flex-direction: column;
            gap: var(--space-md);
        }

        .usr-filtros-exportar {
            width: 100%;
            justify-content: stretch;
        }

        .usr-filtros-exportar button {
            flex: 1;
        }

        .usr-audit-item {
            flex-direction: column;
            gap: var(--space-sm);
        }

        .usr-audit-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--space-xs);
        }
    }
</style>

<div>
    <div class="modal-overlay" id="modal-audit" wire:ignore.self>
        <div class="modal modal-lg">
            <div class="modal-header">
                <h3 class="modal-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                    Logs de Auditoria
                    @if ($totalLogs > 0)
                        <span class="usr-badge-count">{{ $totalLogs }}</span>
                    @endif
                </h3>
                <button class="modal-close" onclick="fecharModalAudit()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <!-- Filtros Avançados -->
                {{-- <div class="usr-filtros-auditoria">
                    <!-- Linha 1: Busca + Tipo + Período -->
                    <div class="usr-filtros-row">
                        <div class="usr-filtro-group usr-filtro-busca">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            <input type="text" class="form-input" placeholder="Buscar ação, descrição, usuário..."
                                wire:model.live.debounce.300ms="search">
                        </div>

                        <select class="form-select" wire:model.live="tipoFiltro">
                            <option value="">Todos os Tipos</option>
                            @foreach ($tiposAtividade as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        <select class="form-select" wire:model.live="periodoFiltro">
                            <option value="1">Últimas 24h</option>
                            <option value="7">Últimos 7 dias</option>
                            <option value="30">Últimos 30 dias</option>
                            <option value="90">Últimos 90 dias</option>
                            <option value="365">Último ano</option>
                            <option value="custom">Período customizado</option>
                        </select>
                    </div>

                    <!-- Linha 2: Período Customizado (condicional) -->
                    @if ($periodoFiltro === 'custom')
                        <div class="usr-filtros-row">
                            <div class="usr-filtro-datas">
                                <label>De:</label>
                                <input type="date" class="form-input" wire:model.live="dataInicio">
                                <label>Até:</label>
                                <input type="date" class="form-input" wire:model.live="dataFim">
                            </div>
                        </div>
                    @endif

                    <!-- Linha 3: Usuário + Cliente + Role -->
                    <div class="usr-filtros-row">
                        <select class="form-select" wire:model.live="usuarioFiltro">
                            <option value="">Todos os Usuários</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>

                        <select class="form-select" wire:model.live="clienteFiltro">
                            <option value="">Todos os Clientes</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                            @endforeach
                        </select>

                        <select class="form-select" wire:model.live="roleFiltro">
                            <option value="">Todas as Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Linha 4: Ações -->
                    <div class="usr-filtros-row usr-filtros-acoes">
                        <button class="btn btn-outline btn-sm" wire:click="limparFiltros">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="margin-right: 6px;">
                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                <path d="M3 3v5h5" />
                            </svg>
                            Limpar Filtros
                        </button>

                        <div class="usr-filtro-paginacao">
                            <label>Itens por página:</label>
                            <select class="form-select" wire:model.live="porPagina" style="width: 80px;">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="usr-filtros-exportar">

                            <button class="btn btn-primary btn-sm" wire:click="exportarExcel"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="exportarExcel">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" x2="8" y1="13" y2="13" />
                                        <line x1="16" x2="8" y1="17" y2="17" />
                                    </svg>
                                    Exportar Excel
                                </span>
                                <span wire:loading wire:target="exportarExcel">Exportando...</span>
                            </button>
                        </div>
                    </div>
                </div> --}}

                <div class="usr-filtros-auditoria">
                    <!-- Linha 1: Busca + Tipo + Período -->
                    <div class="usr-filtros-row">
                        <div class="usr-filtro-group usr-filtro-busca">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            <!-- CORRIGIDO: debounce aumentado para evitar requisições em cascata -->
                            <input type="text" class="form-input" placeholder="Buscar ação, descrição, usuário..."
                                wire:model.live.debounce.500ms="search">
                        </div>

                        <select class="form-select" wire:model.live="tipoFiltro">
                            <option value="">Todos os Tipos</option>
                            @foreach ($tiposAtividade as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        <select class="form-select" wire:model.live="periodoFiltro">
                            <option value="1">Últimas 24h</option>
                            <option value="7">Últimos 7 dias</option>
                            <option value="30">Últimos 30 dias</option>
                            <option value="90">Últimos 90 dias</option>
                            <option value="365">Último ano</option>
                            <option value="custom">Período customizado</option>
                        </select>
                    </div>

                    <!-- Linha 2: Período Customizado (condicional) -->
                    @if ($periodoFiltro === 'custom')
                        <div class="usr-filtros-row">
                            <div class="usr-filtro-datas">
                                <label>De:</label>
                                <input type="date" class="form-input" wire:model.live="dataInicio">
                                <label>Até:</label>
                                <input type="date" class="form-input" wire:model.live="dataFim">
                            </div>
                        </div>
                    @endif

                    <!-- Linha 3: Usuário + Cliente + Role -->
                    {{-- <div class="usr-filtros-row">
                        <select class="form-select" wire:model.live="usuarioFiltro">
                            <option value="">Todos os Usuários</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>

                        <select class="form-select" wire:model.live="clienteFiltro">
                            <option value="">Todos os Clientes</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                            @endforeach
                        </select>

                        <select class="form-select" wire:model.live="roleFiltro">
                            <option value="">Todas as Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <!-- Linha 4: Ações -->
                    <div class="usr-filtros-row usr-filtros-acoes">
                        <button class="btn btn-outline btn-sm" wire:click="limparFiltros">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="margin-right: 6px;">
                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                <path d="M3 3v5h5" />
                            </svg>
                            Limpar Filtros
                        </button>

                        <div class="usr-filtro-paginacao">
                            <label>Itens por página:</label>
                            <select class="form-select" wire:model.live="porPagina" style="width: 80px;">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="usr-filtros-exportar">
                            <button class="btn btn-outline btn-sm" wire:click="exportarCsv">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" x2="12" y1="15" y2="3" />
                                </svg>
                                Exportar CSV
                            </button>
                            <button class="btn btn-primary btn-sm" wire:click="exportarExcel"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="exportarExcel">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" x2="8" y1="13" y2="13" />
                                        <line x1="16" x2="8" y1="17" y2="17" />
                                    </svg>
                                    Exportar Excel
                                </span>
                                <span wire:loading wire:target="exportarExcel">Exportando...</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Lista de Auditoria -->
                <div class="usr-audit-list">
                    @forelse($logs as $log)
                        <div class="usr-audit-item" wire:key="log-{{ $log->id }}">
                            <div class="usr-audit-icon {{ $coresTipo[$log->event] ?? 'usr-update' }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    {!! $iconesTipo[$log->event] ?? $iconesTipo['updated'] !!}
                                </svg>
                            </div>
                            <div class="usr-audit-content">
                                <div class="usr-audit-title">
                                    {{ $log->description }}
                                    <span class="usr-audit-badge {{ $coresTipo[$log->event] ?? 'usr-update' }}">
                                        {{ $tiposAtividade[$log->event] ?? $log->event }}
                                    </span>
                                </div>
                                <div class="usr-audit-desc">
                                    @if ($log->subject)
                                        {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                                    @else
                                        {{ $log->log_name }}
                                    @endif
                                </div>
                                <div class="usr-audit-meta">
                                    <span>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                            <circle cx="12" cy="7" r="4" />
                                        </svg>
                                        {{ $log->causer?->name ?? 'Sistema' }}
                                    </span>
                                    <span>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12 6 12 12 16 14" />
                                        </svg>
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </span>
                                    <span>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <rect x="2" y="3" width="20" height="14" rx="2"
                                                ry="2" />
                                            <line x1="8" y1="21" x2="16" y2="21" />
                                            <line x1="12" y1="17" x2="12" y2="21" />
                                        </svg>
                                        {{ $log->getExtraProperty('ip') ?? 'N/A' }}
                                    </span>

                                    <!-- BOTÃO VER DETALHES CORRIGIDO -->
                                    <button class="usr-audit-detalhes-btn"
                                        wire:click="$dispatch('verDetalhes-ver',{ id: {{ $log->id }} })">
                                        <span>
                                            Ver alterações
                                        </span>

                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="usr-audit-empty">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5"
                                style="color: var(--text-muted); margin-bottom: var(--space-md);">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" x2="8" y1="13" y2="13" />
                                <line x1="16" x2="8" y1="17" y2="17" />
                            </svg>
                            <p>Nenhum log de auditoria encontrado para os filtros selecionados.</p>
                            <button class="btn btn-outline btn-sm" wire:click="limparFiltros"
                                style="margin-top: var(--space-sm);">
                                Limpar filtros
                            </button>
                        </div>
                    @endforelse
                </div>

                <!-- Paginação -->
                @if ($logs->hasPages())
                    <div class="usr-audit-pagination">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline" onclick="fecharModalAudit()">Fechar</button>
            </div>
        </div>
    </div>

    <livewire:admin.usuarios.logs-auditorio />



</div>
