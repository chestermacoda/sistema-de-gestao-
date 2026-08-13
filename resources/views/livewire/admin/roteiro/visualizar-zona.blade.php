<div class="modal-overlay" id="modal-visualizar-zona" wire:ignore.self>
    <style>
        /* ─── Header Icon ─── */
        .zona-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--tertiary), var(--tertiary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .zona-badge-total {
            padding: 4px 12px;
            background: var(--neutral);
            border-radius: var(--radius-full);
            font-size: var(--small-size);
            font-weight: 600;
            color: var(--text-secondary);
        }

        /* ─── Resumo Section ─── */
        .zona-resumo-section {
            padding: var(--space-lg);
            background: linear-gradient(180deg, var(--neutral) 0%, var(--white) 100%);
            border-bottom: 1px solid var(--neutral-dark);
        }

        .zona-resumo-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: var(--space-md);
            margin-bottom: var(--space-lg);
        }

        .zona-resumo-card {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            padding: var(--space-md);
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--neutral-dark);
            transition: all 0.2s;
        }

        .zona-resumo-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .zona-resumo-icon {
            font-size: 1.5rem;
        }

        .zona-resumo-info {
            flex: 1;
        }

        .zona-resumo-valor {
            font-size: 1.25rem;
            font-weight: 700;
            font-family: var(--font-headline);
        }

        .zona-resumo-label {
            font-size: var(--small-size);
            color: var(--text-muted);
        }

        .zona-card-total .zona-resumo-valor {
            color: var(--primary);
        }

        .zona-card-concluido .zona-resumo-valor {
            color: var(--success);
        }

        .zona-card-pendente .zona-resumo-valor {
            color: var(--warning);
        }

        .zona-card-anomalia .zona-resumo-valor {
            color: var(--danger);
        }

        .zona-card-nao-lido .zona-resumo-valor {
            color: var(--text-secondary);
        }

        .zona-card-problema .zona-resumo-valor {
            color: #7c3aed;
        }

        /* ─── Progresso ─── */
        .zona-progresso-section {
            padding: var(--space-md);
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--neutral-dark);
        }

        .zona-progresso-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-sm);
            font-size: var(--label-size);
            font-weight: 600;
            color: var(--text-primary);
        }

        .zona-progresso-pct {
            color: var(--primary);
            font-family: var(--font-headline);
            font-size: var(--body-size);
        }

        .zona-progresso-barra-bg {
            width: 100%;
            height: 12px;
            background: var(--neutral-dark);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: var(--space-sm);
        }

        .zona-progresso-barra-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--success) 0%, var(--tertiary) 50%, var(--primary) 100%);
            border-radius: var(--radius-full);
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .zona-progresso-meta {
            display: flex;
            justify-content: space-between;
            font-size: var(--small-size);
            color: var(--text-secondary);
        }

        .zona-meta-faturas {
            font-weight: 500;
        }

        .zona-meta-vencido {
            color: var(--danger);
            font-weight: 600;
        }

        /* ─── Filtros ─── */
        .zona-filtros-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: var(--space-md);
            padding: var(--space-md) var(--space-lg);
            border-bottom: 1px solid var(--neutral-dark);
            flex-wrap: wrap;
            background: var(--white);
        }

        .zona-filtro-group {
            display: flex;
            gap: var(--space-xs);
            flex-wrap: wrap;
        }

        .zona-filtro-btn {
            padding: 6px 14px;
            border: 1px solid var(--neutral-dark);
            border-radius: var(--radius-full);
            background: var(--white);
            color: var(--text-secondary);
            font-size: var(--small-size);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .zona-filtro-btn:hover {
            border-color: var(--primary-lighter);
            color: var(--primary);
        }

        .zona-filtro-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .zona-busca-wrapper {
            flex-shrink: 0;
        }

        .zona-busca {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            padding: var(--space-sm) var(--space-md);
            background: var(--neutral);
            border: 1px solid var(--neutral-dark);
            border-radius: var(--radius-full);
            min-width: 300px;
        }

        .zona-busca svg {
            color: var(--text-muted);
            flex-shrink: 0;
        }

        .zona-busca input {
            border: none;
            background: none;
            outline: none;
            font-size: var(--label-size);
            color: var(--text-primary);
            width: 100%;
        }

        .zona-busca input::placeholder {
            color: var(--text-muted);
        }

        /* ─── Tabela ─── */
        .zona-tabela-section {
            padding: var(--space-lg);
        }

        .zona-tabela-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-md);
            flex-wrap: wrap;
            gap: var(--space-sm);
        }

        .zona-tabela-count {
            margin-left: var(--space-sm);
            font-size: var(--small-size);
            color: var(--text-muted);
            font-weight: 400;
            background: var(--neutral);
            padding: 2px 8px;
            border-radius: var(--radius-full);
        }

        .zona-ordenacao {
            display: flex;
            align-items: center;
            gap: var(--space-xs);
            font-size: var(--small-size);
            color: var(--text-muted);
        }

        .zona-ordem-btn {
            padding: 4px 10px;
            border: 1px solid var(--neutral-dark);
            border-radius: var(--radius-sm);
            background: var(--white);
            color: var(--text-secondary);
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .zona-ordem-btn:hover,
        .zona-ordem-btn.active {
            border-color: var(--primary);
            color: var(--primary);
        }

        .zona-tabela-wrapper {
            border: 1px solid var(--neutral-dark);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .zona-tabela {
            width: 100%;
            border-collapse: collapse;
            font-size: var(--small-size);
        }

        .zona-tabela thead {
            background: var(--neutral);
        }

        .zona-tabela th {
            padding: var(--space-sm) var(--space-md);
            text-align: left;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 11px;
            border-bottom: 1px solid var(--neutral-dark);
            white-space: nowrap;
        }

        .zona-tabela td {
            padding: var(--space-md);
            border-bottom: 1px solid var(--neutral-dark);
            vertical-align: top;
        }

        .zona-tabela tbody tr {
            transition: all 0.15s;
        }

        .zona-tabela tbody tr:hover {
            background: rgba(0, 51, 102, 0.02);
        }

        .zona-tabela tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status row colors */
        .zona-status-concluido {
            border-left: 3px solid var(--success);
        }

        .zona-status-pendente {
            border-left: 3px solid var(--warning);
        }

        .zona-status-anomalia {
            border-left: 3px solid var(--danger);
        }

        .zona-status-nao-lido {
            border-left: 3px solid var(--neutral-darker);
        }

        .zona-status-problema {
            border-left: 3px solid #7c3aed;
        }

        .zona-status-pago {
            border-left: 3px solid var(--tertiary);
        }

        /* ─── Células ─── */
        .zona-cell-numero {
            font-weight: 700;
            color: var(--text-muted);
            text-align: center;
        }

        .zona-cell-cliente .zona-cliente-nome {
            font-weight: 600;
            color: var(--text-primary);
            font-size: var(--label-size);
        }

        .zona-cell-cliente .zona-cliente-meta {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .zona-cell-endereco .zona-endereco-texto {
            color: var(--text-primary);
            font-size: var(--small-size);
            line-height: 1.4;
        }

        .zona-cell-endereco .zona-endereco-contato {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .zona-cell-medidor .zona-medidor-numero {
            font-family: monospace;
            font-weight: 600;
            color: var(--text-primary);
            font-size: var(--label-size);
        }

        .zona-cell-medidor .zona-medidor-tipo {
            font-size: 11px;
            color: var(--text-muted);
        }

        .zona-cell-leitura .zona-leitura-atual {
            font-weight: 700;
            color: var(--primary);
            font-family: var(--font-headline);
        }

        .zona-cell-leitura .zona-leitura-anterior {
            font-size: 11px;
            color: var(--text-muted);
        }

        .zona-cell-leitura .zona-leitura-pendente {
            color: var(--text-muted);
            font-style: italic;
        }

        .zona-cell-consumo .zona-consumo-valor {
            font-weight: 600;
            color: var(--text-primary);
        }

        .zona-cell-consumo .zona-consumo-alto {
            color: var(--danger);
        }

        .zona-cell-consumo .zona-consumo-pendente {
            color: var(--text-muted);
            font-style: italic;
        }

        .zona-cell-status .zona-status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: var(--radius-full);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .zona-badge-concluido {
            background: var(--success-light);
            color: var(--success);
        }

        .zona-badge-pendente {
            background: var(--warning-light);
            color: var(--warning);
        }

        .zona-badge-anomalia {
            background: var(--danger-light);
            color: var(--danger);
        }

        .zona-badge-nao-lido {
            background: var(--neutral-dark);
            color: var(--text-secondary);
        }

        .zona-badge-problema {
            background: rgba(124, 58, 237, 0.1);
            color: #7c3aed;
        }

        .zona-badge-pago {
            background: rgba(0, 131, 143, 0.1);
            color: var(--tertiary);
        }

        .zona-lido-em {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .zona-cell-fatura .zona-fatura-codigo {
            font-family: monospace;
            font-size: 11px;
            color: var(--text-secondary);
        }

        .zona-cell-fatura .zona-fatura-valor {
            font-weight: 600;
            color: var(--text-primary);
            font-size: var(--label-size);
        }

        .zona-cell-fatura .zona-fatura-status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: var(--radius-sm);
            font-size: 10px;
            font-weight: 600;
            margin-top: 4px;
        }

        .zona-fatura-paga {
            background: var(--success-light);
            color: var(--success);
        }

        .zona-fatura-pendente {
            background: var(--warning-light);
            color: var(--warning);
        }

        .zona-fatura-vencida {
            background: var(--danger-light);
            color: var(--danger);
        }

        .zona-fatura-vazio {
            color: var(--text-muted);
            font-style: italic;
            font-size: 11px;
        }

        .zona-cell-acoes {
            display: flex;
            gap: var(--space-xs);
        }

        .zona-btn-acao {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-md);
            border: 1px solid var(--neutral-dark);
            background: var(--white);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .zona-btn-acao:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* ─── Tabela Vazio ─── */
        .zona-tabela-vazio {
            text-align: center;
            padding: var(--space-2xl) !important;
        }

        .zona-empty {
            color: var(--text-muted);
        }

        .zona-empty h4 {
            color: var(--text-primary);
            margin: var(--space-md) 0 var(--space-sm);
            font-size: var(--body-size);
        }

        .zona-empty p {
            font-size: var(--label-size);
        }

        /* ─── Detalhes Modal ─── */
        .zona-detalhes-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: var(--space-lg);
        }

        .zona-detalhes-modal {
            background: var(--white);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: var(--shadow-xl);
        }

        .zona-detalhes-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: var(--space-lg);
            border-bottom: 1px solid var(--neutral-dark);
        }

        .zona-detalhes-header h4 {
            margin: 0 0 4px;
            font-size: var(--body-size);
            color: var(--text-primary);
        }

        .zona-detalhes-header p {
            margin: 0;
            font-size: var(--small-size);
            color: var(--text-muted);
        }

        .zona-detalhes-close {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 4px;
        }

        .zona-detalhes-close:hover {
            color: var(--danger);
        }

        .zona-detalhes-body {
            padding: var(--space-lg);
        }

        .zona-detalhes-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--space-md);
            margin-bottom: var(--space-lg);
        }

        .zona-detalhes-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: var(--space-sm);
            background: var(--neutral);
            border-radius: var(--radius-md);
        }

        .zona-detalhes-label {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .zona-detalhes-valor {
            font-size: var(--label-size);
            font-weight: 600;
            color: var(--text-primary);
        }

        .zona-detalhes-leitura {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-md);
            padding: var(--space-lg);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-lg);
            color: white;
            margin-bottom: var(--space-lg);
        }

        .zona-detalhes-leitura-item {
            text-align: center;
        }

        .zona-detalhes-leitura-item span {
            display: block;
            font-size: var(--small-size);
            opacity: 0.8;
            margin-bottom: 4px;
        }

        .zona-detalhes-leitura-item strong {
            font-size: var(--body-size);
            font-family: var(--font-headline);
        }

        .zona-detalhes-seta {
            font-size: 1.5rem;
            opacity: 0.6;
        }

        .zona-detalhes-consumo {
            background: rgba(255, 255, 255, 0.2);
            padding: var(--space-sm) var(--space-md);
            border-radius: var(--radius-md);
        }

        .zona-detalhes-historico {
            margin-bottom: var(--space-lg);
        }

        .zona-detalhes-historico h5 {
            margin: 0 0 var(--space-md);
            font-size: var(--label-size);
            color: var(--text-primary);
        }

        .zona-historico-lista {
            display: flex;
            flex-direction: column;
            gap: var(--space-xs);
        }

        .zona-historico-item {
            display: flex;
            align-items: center;
            gap: var(--space-md);
            padding: var(--space-sm) var(--space-md);
            background: var(--neutral);
            border-radius: var(--radius-md);
            font-size: var(--small-size);
        }

        .zona-historico-data {
            color: var(--text-muted);
            min-width: 80px;
        }

        .zona-historico-leitura {
            font-weight: 600;
            color: var(--primary);
            font-family: var(--font-headline);
        }

        .zona-historico-consumo {
            color: var(--tertiary);
            font-weight: 600;
        }

        .zona-historico-codigo {
            font-family: monospace;
            color: var(--text-secondary);
        }

        .zona-historico-valor {
            font-weight: 600;
            color: var(--text-primary);
        }

        .zona-historico-venc {
            color: var(--text-muted);
        }

        .zona-historico-status {
            margin-left: auto;
            padding: 2px 8px;
            border-radius: var(--radius-sm);
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .zona-hist-concluido,
        .zona-hist-paga {
            background: var(--success-light);
            color: var(--success);
        }

        .zona-hist-pendente {
            background: var(--warning-light);
            color: var(--warning);
        }

        .zona-hist-anomalia,
        .zona-hist-vencida {
            background: var(--danger-light);
            color: var(--danger);
        }

        /* ─── Responsividade ─── */
        @media (max-width: 768px) {
            .zona-resumo-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .zona-tabela {
                font-size: 11px;
            }

            .zona-tabela th,
            .zona-tabela td {
                padding: var(--space-sm);
            }

            .zona-cell-endereco,
            .zona-cell-medidor-tipo,
            .zona-lido-em,
            .zona-fatura-codigo {
                display: none;
            }

            .zona-detalhes-grid {
                grid-template-columns: 1fr;
            }

            .zona-detalhes-leitura {
                flex-direction: column;
                gap: var(--space-sm);
            }

            .zona-detalhes-seta {
                transform: rotate(90deg);
            }
        }

        @media (max-width: 480px) {
            .zona-resumo-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .zona-filtros-section {
                flex-direction: column;
                align-items: stretch;
            }

            .zona-filtro-group {
                justify-content: center;
            }

            .zona-busca {
                min-width: auto;
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
            .modal-footer,
            .zona-filtros-section,
            .zona-cell-acoes {
                display: none !important;
            }

            .zona-tabela tbody tr {
                break-inside: avoid;
            }

            .zona-detalhes-overlay {
                display: none !important;
            }
        }
    </style>
    <div class="modal modal-xl" style="max-width: 1100px; height: 92vh; display: flex; flex-direction: column;">

        @if ($zona)
            <!-- HEADER -->
            <div class="modal-header" style="flex-shrink: 0;">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div class="zona-header-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5z" />
                            <path d="M2 17l10 5 10-5" />
                            <path d="M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Visualizar Zona</h3>
                        <p class="modal-subtitle">
                            {{ $zonaInfo['nome'] ?? 'N/A' }} — {{ $zonaInfo['mes_ano'] ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <div style="display: flex; gap: var(--space-sm); align-items: center;">
                    <span class="zona-badge-total">
                        {{ $resumo['total_clientes'] }} clientes
                    </span>
                    <button class="modal-close" onclick="closeModal('modal-visualizar-zona')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- CONTEÚDO COM SCROLL -->
            <div class="modal-body" style="flex: 1; overflow-y: auto; padding: 0;">

                <!-- Cards de Resumo -->
                <div class="zona-resumo-section">
                    <div class="zona-resumo-grid">
                        <div class="zona-resumo-card zona-card-total">
                            <div class="zona-resumo-icon">👥</div>
                            <div class="zona-resumo-info">
                                <div class="zona-resumo-valor">{{ $resumo['total_clientes'] }}</div>
                                <div class="zona-resumo-label">Total Clientes</div>
                            </div>
                        </div>
                        <div class="zona-resumo-card zona-card-concluido">
                            <div class="zona-resumo-icon">✅</div>
                            <div class="zona-resumo-info">
                                <div class="zona-resumo-valor">{{ $resumo['lidos'] }}</div>
                                <div class="zona-resumo-label">Concluídos</div>
                            </div>
                        </div>
                        <div class="zona-resumo-card zona-card-pendente">
                            <div class="zona-resumo-icon">⏳</div>
                            <div class="zona-resumo-info">
                                <div class="zona-resumo-valor">{{ $resumo['pendentes'] }}</div>
                                <div class="zona-resumo-label">Pendentes</div>
                            </div>
                        </div>
                        <div class="zona-resumo-card zona-card-anomalia">
                            <div class="zona-resumo-icon">⚠️</div>
                            <div class="zona-resumo-info">
                                <div class="zona-resumo-valor">{{ $resumo['anomalias'] }}</div>
                                <div class="zona-resumo-label">Anomalias</div>
                            </div>
                        </div>
                        <div class="zona-resumo-card zona-card-nao-lido">
                            <div class="zona-resumo-icon">📋</div>
                            <div class="zona-resumo-info">
                                <div class="zona-resumo-valor">{{ $resumo['nao_lidos'] }}</div>
                                <div class="zona-resumo-label">Não Lidos</div>
                            </div>
                        </div>
                        <div class="zona-resumo-card zona-card-problema">
                            <div class="zona-resumo-icon">🔧</div>
                            <div class="zona-resumo-info">
                                <div class="zona-resumo-valor">{{ $resumo['problemas'] }}</div>
                                <div class="zona-resumo-label">Problemas</div>
                            </div>
                        </div>
                    </div>

                    <!-- Barra de Progresso -->
                    <div class="zona-progresso-section">
                        <div class="zona-progresso-header">
                            <span>Progresso da Zona</span>
                            <span class="zona-progresso-pct">{{ $resumo['percentual_concluido'] }}%</span>
                        </div>
                        <div class="zona-progresso-barra-bg">
                            <div class="zona-progresso-barra-fill"
                                style="width: {{ $resumo['percentual_concluido'] }}%;"></div>
                        </div>
                        <div class="zona-progresso-meta">
                            <span>{{ $resumo['lidos'] + $resumo['pagos'] }} de {{ $resumo['total_clientes'] }}
                                finalizados</span>
                            <span class="zona-meta-faturas">
                                💰 {{ $resumo['faturas_abertas'] }} faturas abertas | {{ $resumo['faturas_pagas'] }}
                                pagas
                                @if ($resumo['faturas_vencidas'] > 0)
                                    | <span class="zona-meta-vencido">{{ $resumo['faturas_vencidas'] }} vencidas</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Filtros e Busca -->
                <div class="zona-filtros-section">
                    <div class="zona-filtro-group">
                        <button type="button" class="zona-filtro-btn {{ $filtroStatus === 'todos' ? 'active' : '' }}"
                            wire:click="$set('filtroStatus', 'todos')">
                            Todos ({{ $resumo['total_clientes'] }})
                        </button>
                        <button type="button"
                            class="zona-filtro-btn {{ $filtroStatus === 'concluido' ? 'active' : '' }}"
                            wire:click="$set('filtroStatus', 'concluido')">
                            ✅ Concluídos ({{ $resumo['lidos'] }})
                        </button>
                        <button type="button"
                            class="zona-filtro-btn {{ $filtroStatus === 'pendente' ? 'active' : '' }}"
                            wire:click="$set('filtroStatus', 'pendente')">
                            ⏳ Pendentes ({{ $resumo['pendentes'] }})
                        </button>
                        <button type="button"
                            class="zona-filtro-btn {{ $filtroStatus === 'anomalia' ? 'active' : '' }}"
                            wire:click="$set('filtroStatus', 'anomalia')">
                            ⚠️ Anomalias ({{ $resumo['anomalias'] }})
                        </button>
                        <button type="button"
                            class="zona-filtro-btn {{ $filtroStatus === 'nao-lido' ? 'active' : '' }}"
                            wire:click="$set('filtroStatus', 'nao-lido')">
                            📋 Não Lidos ({{ $resumo['nao_lidos'] }})
                        </button>
                        <button type="button"
                            class="zona-filtro-btn {{ $filtroStatus === 'problema' ? 'active' : '' }}"
                            wire:click="$set('filtroStatus', 'problema')">
                            🔧 Problemas ({{ $resumo['problemas'] }})
                        </button>
                    </div>
                    <div class="zona-busca-wrapper">
                        <div class="zona-busca">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            <input type="text" wire:model.live.debounce.300ms="busca"
                                placeholder="Buscar cliente, endereço, medidor, matrícula...">
                        </div>
                    </div>
                </div>

                <!-- Tabela de Clientes -->
                <div class="zona-tabela-section">
                    <div class="zona-tabela-header">
                        <div style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary);">
                            Lista de Clientes
                            <span class="zona-tabela-count">{{ count($this->clientesFiltrados) }} resultado(s)</span>
                        </div>
                        <div class="zona-ordenacao">
                            <span>Ordenar por:</span>
                            <button class="zona-ordem-btn {{ $ordenacao === 'ordem' ? 'active' : '' }}"
                                wire:click="ordenarPor('ordem')">
                                Ordem {{ $ordenacao === 'ordem' ? ($direcao === 'asc' ? '↑' : '↓') : '' }}
                            </button>
                            <button class="zona-ordem-btn {{ $ordenacao === 'nome' ? 'active' : '' }}"
                                wire:click="ordenarPor('nome')">
                                Nome {{ $ordenacao === 'nome' ? ($direcao === 'asc' ? '↑' : '↓') : '' }}
                            </button>
                            <button class="zona-ordem-btn {{ $ordenacao === 'status' ? 'active' : '' }}"
                                wire:click="ordenarPor('status')">
                                Status {{ $ordenacao === 'status' ? ($direcao === 'asc' ? '↑' : '↓') : '' }}
                            </button>
                        </div>
                    </div>

                    <div class="zona-tabela-wrapper">
                        <table class="zona-tabela">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Cliente</th>
                                    <th>Endereço</th>
                                    <th>Medidor</th>
                                    <th>Leitura</th>
                                    <th>Consumo</th>
                                    <th>Status</th>
                                    <th>Fatura</th>
                                    <th style="width: 100px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->clientesFiltrados as $cliente)
                                    <tr
                                        class="zona-row zona-status-{{ strtolower(str_replace(' ', '-', $cliente['status'])) }}">
                                        <td class="zona-cell-numero">{{ $cliente['ordem'] }}</td>
                                        <td class="zona-cell-cliente">
                                            <div class="zona-cliente-nome">{{ $cliente['nome'] }}</div>
                                            <div class="zona-cliente-meta">{{ $cliente['matricula'] }} | NUIT:
                                                {{ $cliente['nuit'] }}</div>
                                        </td>
                                        <td class="zona-cell-endereco">
                                            <div class="zona-endereco-texto">{{ $cliente['endereco'] }}</div>
                                            <div class="zona-endereco-contato">📞 {{ $cliente['contacto'] }}</div>
                                        </td>
                                        <td class="zona-cell-medidor">
                                            <div class="zona-medidor-numero">{{ $cliente['medidor'] }}</div>
                                            <div class="zona-medidor-tipo">{{ $cliente['tipo_medidor'] }}</div>
                                        </td>
                                        <td class="zona-cell-leitura">
                                            @if ($cliente['leitura_atual'] !== null)
                                                <div class="zona-leitura-atual">
                                                    {{ number_format($cliente['leitura_atual'], 2, ',', '.') }} m³
                                                </div>
                                                <div class="zona-leitura-anterior">Ant:
                                                    {{ number_format($cliente['leitura_anterior'] ?? 0, 2, ',', '.') }}
                                                </div>
                                            @else
                                                <span class="zona-leitura-pendente">—</span>
                                            @endif
                                        </td>
                                        <td class="zona-cell-consumo">
                                            @if ($cliente['consumo'] !== null)
                                                <span
                                                    class="zona-consumo-valor {{ $cliente['consumo'] > 100 ? 'zona-consumo-alto' : '' }}">
                                                    {{ number_format($cliente['consumo'], 2, ',', '.') }} m³
                                                </span>
                                            @else
                                                <span class="zona-consumo-pendente">—</span>
                                            @endif
                                        </td>
                                        <td class="zona-cell-status">
                                            <span
                                                class="zona-status-badge zona-badge-{{ strtolower(str_replace(' ', '-', $cliente['status'])) }}">
                                                {{ $cliente['status'] }}
                                            </span>
                                            @if ($cliente['lido_em'])
                                                <div class="zona-lido-em">{{ $cliente['lido_em'] }}</div>
                                            @endif
                                        </td>
                                        <td class="zona-cell-fatura">
                                            @if ($cliente['fatura_codigo'])
                                                <div class="zona-fatura-codigo">{{ $cliente['fatura_codigo'] }}</div>
                                                <div class="zona-fatura-valor">MZN
                                                    {{ number_format($cliente['fatura_valor'], 2, ',', '.') }}</div>
                                                <span
                                                    class="zona-fatura-status zona-fatura-{{ strtolower(str_replace(' ', '-', $cliente['fatura_status'])) }}">
                                                    {{ $cliente['fatura_status'] }}
                                                </span>
                                            @else
                                                <span class="zona-fatura-vazio">Sem fatura</span>
                                            @endif
                                        </td>
                                        <td class="zona-cell-acoes">
                                            <button class="zona-btn-acao"
                                                wire:click="verDetalhes({{ $cliente['id'] }})" title="Ver detalhes">
                                                <svg width="16" height="16" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </button>
                                            @if ($cliente['foto'])
                                                <button class="zona-btn-acao"
                                                    onclick="window.open('{{ asset('storage/' . $cliente['foto']) }}', '_blank')"
                                                    title="Ver foto">
                                                    <svg width="16" height="16" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2">
                                                        <rect width="18" height="18" x="3" y="3"
                                                            rx="2" ry="2" />
                                                        <circle cx="9" cy="9" r="2" />
                                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="zona-tabela-vazio">
                                            <div class="zona-empty">
                                                <svg width="48" height="48" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="1.5">
                                                    <circle cx="11" cy="11" r="8" />
                                                    <path d="m21 21-4.3-4.3" />
                                                </svg>
                                                <h4>Nenhum cliente encontrado</h4>
                                                <p>Tente ajustar os filtros ou a busca.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer" style="flex-shrink: 0;">
                <button class="btn btn-outline" onclick="closeModal('modal-visualizar-zona')">Fechar</button>
                <button class="btn btn-secondary" wire:click="exportarExcel">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <path d="M8 13h2v6H8zM12 13h2v6h-2z" />
                    </svg>
                    Exportar Excel
                </button>
                <button class="btn btn-primary" wire:click="exportarPDF">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Exportar PDF
                </button>
            </div>

            <!-- MODAL DE DETALHES DO CLIENTE -->
            @if ($mostrarDetalhes && !empty($detalhesCliente))
                <div class="zona-detalhes-overlay" wire:click.self="fecharDetalhes">
                    <div class="zona-detalhes-modal">
                        <div class="zona-detalhes-header">
                            <div>
                                <h4>{{ $detalhesCliente['nome'] ?? 'Cliente' }}</h4>
                                <p>{{ $detalhesCliente['matricula'] ?? '' }} |
                                    {{ $detalhesCliente['endereco'] ?? '' }}</p>
                            </div>
                            <button class="zona-detalhes-close" wire:click="fecharDetalhes">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="zona-detalhes-body">
                            <!-- Info do Cliente -->
                            <div class="zona-detalhes-grid">
                                <div class="zona-detalhes-item">
                                    <span class="zona-detalhes-label">NUIT</span>
                                    <span class="zona-detalhes-valor">{{ $detalhesCliente['nuit'] ?? 'N/A' }}</span>
                                </div>
                                <div class="zona-detalhes-item">
                                    <span class="zona-detalhes-label">Contacto</span>
                                    <span
                                        class="zona-detalhes-valor">{{ $detalhesCliente['contacto'] ?? 'N/A' }}</span>
                                </div>
                                <div class="zona-detalhes-item">
                                    <span class="zona-detalhes-label">Medidor</span>
                                    <span
                                        class="zona-detalhes-valor">{{ $detalhesCliente['medidor'] ?? 'N/A' }}</span>
                                </div>
                                <div class="zona-detalhes-item">
                                    <span class="zona-detalhes-label">Leiturista</span>
                                    <span
                                        class="zona-detalhes-valor">{{ $detalhesCliente['leiturista'] ?? 'Não atribuído' }}</span>
                                </div>
                            </div>

                            <!-- Leitura Atual -->
                            @if ($detalhesCliente['leitura_atual'] !== null)
                                <div class="zona-detalhes-leitura">
                                    <div class="zona-detalhes-leitura-item">
                                        <span>Leitura Anterior</span>
                                        <strong>{{ number_format($detalhesCliente['leitura_anterior'] ?? 0, 2, ',', '.') }}
                                            m³</strong>
                                    </div>
                                    <div class="zona-detalhes-seta">→</div>
                                    <div class="zona-detalhes-leitura-item">
                                        <span>Leitura Atual</span>
                                        <strong>{{ number_format($detalhesCliente['leitura_atual'], 2, ',', '.') }}
                                            m³</strong>
                                    </div>
                                    <div class="zona-detalhes-seta">=</div>
                                    <div class="zona-detalhes-leitura-item zona-detalhes-consumo">
                                        <span>Consumo</span>
                                        <strong>{{ number_format($detalhesCliente['consumo'] ?? 0, 2, ',', '.') }}
                                            m³</strong>
                                    </div>
                                </div>
                            @endif

                            <!-- Histórico de Leituras -->
                            @if (!empty($detalhesCliente['historico_leituras']))
                                <div class="zona-detalhes-historico">
                                    <h5>📊 Histórico de Leituras</h5>
                                    <div class="zona-historico-lista">
                                        @foreach ($detalhesCliente['historico_leituras'] as $hist)
                                            <div class="zona-historico-item">
                                                <span class="zona-historico-data">{{ $hist['data'] }}</span>
                                                <span
                                                    class="zona-historico-leitura">{{ number_format($hist['leitura'], 2, ',', '.') }}
                                                    m³</span>
                                                @if ($hist['consumo'] !== null)
                                                    <span
                                                        class="zona-historico-consumo">{{ number_format($hist['consumo'], 2, ',', '.') }}
                                                        m³</span>
                                                @endif
                                                <span
                                                    class="zona-historico-status zona-hist-{{ strtolower(str_replace(' ', '-', $hist['status'])) }}">{{ $hist['status'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Histórico de Faturas -->
                            @if (!empty($detalhesCliente['historico_faturas']))
                                <div class="zona-detalhes-historico">
                                    <h5>💰 Histórico de Faturas</h5>
                                    <div class="zona-historico-lista">
                                        @foreach ($detalhesCliente['historico_faturas'] as $fat)
                                            <div class="zona-historico-item">
                                                <span class="zona-historico-codigo">{{ $fat['codigo'] }}</span>
                                                <span class="zona-historico-valor">MZN
                                                    {{ number_format($fat['valor'], 2, ',', '.') }}</span>
                                                <span class="zona-historico-venc">Venc:
                                                    {{ $fat['vencimento'] }}</span>
                                                <span
                                                    class="zona-historico-status zona-hist-{{ strtolower(str_replace(' ', '-', $fat['status'])) }}">{{ $fat['status'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Estado Vazio -->
            <div class="modal-body empty-state" style="flex: 1;">
                <div class="empty-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg>
                </div>
                <h4>Nenhuma zona selecionada</h4>
                <p>Selecione uma zona na lista para visualizar os clientes.</p>
            </div>
        @endif
    </div>
</div>

<!-- ESTILOS -->
