@extends('admin.Layout.layouts')

@section('content')
    <style>
        /* ═══════════════════════════════════════════════════════════════
                   DASHBOARD PRINCIPAL — ESTILOS ESPECÍFICOS
                   AquaNexus Water Utility Management System
                   ═══════════════════════════════════════════════════════════════ */

        /* ─── Header com Período ─── */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-xl);
            flex-wrap: wrap;
            gap: var(--space-md);
        }

        .periodo-selector .form-select {
            padding: 10px 16px;
            border: 2px solid var(--neutral-dark);
            border-radius: var(--radius-lg);
            font-size: var(--label-size);
            font-weight: 600;
            color: var(--text-primary);
            background: var(--white);
            cursor: pointer;
            transition: all 0.2s;
            min-width: 180px;
        }

        .periodo-selector .form-select:hover,
        .periodo-selector .form-select:focus {
            border-color: var(--primary-lighter);
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.08);
            outline: none;
        }

        /* ─── Grid de Cards ─── */
        .dash-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--space-lg);
            margin-bottom: var(--space-xl);
        }

        @media (max-width: 1200px) {
            .dash-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .dash-cards-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ─── Card Individual ─── */
        .dash-card {
            display: flex;
            align-items: flex-start;
            gap: var(--space-md);
            padding: var(--space-lg);
            background: var(--white);
            border: 1px solid var(--neutral-dark);
            border-radius: var(--radius-lg);
            text-decoration: none;
            color: inherit;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .dash-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--card-accent, var(--primary));
            transition: width 0.3s ease;
        }

        .dash-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            border-color: var(--card-accent, var(--primary-lighter));
        }

        .dash-card:hover::before {
            width: 6px;
        }

        /* Cores por tipo */
        .dash-card-primary {
            --card-accent: var(--primary);
        }

        .dash-card-success {
            --card-accent: var(--success);
        }

        .dash-card-tertiary {
            --card-accent: var(--tertiary);
        }

        .dash-card-warning {
            --card-accent: var(--warning);
        }

        .dash-card-purple {
            --card-accent: var(--purple);
        }

        .dash-card-secondary {
            --card-accent: var(--secondary);
        }

        .dash-card-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--card-accent, var(--primary)) 0%, var(--card-accent, var(--primary-light)) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .dash-card-icon svg {
            width: 22px;
            height: 22px;
        }

        .dash-card-content {
            flex: 1;
            min-width: 0;
        }

        .dash-card-value {
            font-size: 1.75rem;
            font-weight: 700;
            font-family: var(--font-headline);
            color: var(--text-primary);
            line-height: 1.2;
            margin-bottom: 2px;
        }

        .dash-card-title {
            font-size: var(--label-size);
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 2px;
        }

        .dash-card-subtitle {
            font-size: var(--small-size);
            color: var(--text-muted);
            margin-bottom: var(--space-sm);
        }

        .dash-card-tendencia {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: var(--small-size);
            font-weight: 600;
            padding: 3px 10px;
            border-radius: var(--radius-full);
        }

        .tendencia-positivo {
            background: var(--success-light);
            color: var(--success);
        }

        .tendencia-negativo {
            background: var(--danger-light);
            color: var(--danger);
        }

        .tendencia-alerta {
            background: var(--warning-light);
            color: var(--warning);
        }

        .tendencia-neutro {
            background: var(--neutral);
            color: var(--text-secondary);
        }

        .dash-card-alerta {
            position: absolute;
            top: var(--space-sm);
            right: var(--space-sm);
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: var(--danger);
            background: var(--danger-light);
            padding: 3px 8px;
            border-radius: var(--radius-full);
        }

        .dash-card-alerta svg {
            width: 12px;
            height: 12px;
        }

        /* ─── Cards de Gráficos ─── */
        .chart-card {
            overflow: hidden;
        }

        .chart-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--space-sm);
        }

        .chart-badge {
            font-size: var(--small-size);
            color: var(--text-muted);
            background: var(--neutral);
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-weight: 500;
        }

        .chart-container {
            height: 300px;
            padding: var(--space-md) var(--space-lg) var(--space-lg);
            position: relative;
        }

        .chart-legend-inline {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            font-size: var(--small-size);
            color: var(--text-secondary);
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .legend-line {
            width: 16px;
            height: 0;
            border-top: 2px dashed;
            display: inline-block;
        }

        /* ─── Progresso Leituras ─── */
        .progresso-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-sm);
        }

        .progresso-barra-bg {
            width: 100%;
            height: 10px;
            background: var(--neutral-dark);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: var(--space-xl);
        }

        .progresso-barra-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--tertiary) 100%);
            border-radius: var(--radius-full);
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .progresso-categorias {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--space-lg);
        }

        .progresso-cat-item {
            text-align: center;
        }

        .progresso-cat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-xs);
            font-size: var(--label-size);
        }

        .progresso-cat-nome {
            font-weight: 600;
            color: var(--text-primary);
        }

        .progresso-cat-valor {
            font-weight: 700;
            color: var(--text-secondary);
            font-family: var(--font-headline);
        }

        .progresso-cat-barra-bg {
            width: 100%;
            height: 6px;
            background: var(--neutral-dark);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: var(--space-xs);
        }

        .progresso-cat-barra-fill {
            height: 100%;
            border-radius: var(--radius-full);
            transition: width 0.6s ease;
        }

        .progresso-cat-success {
            background: var(--success);
        }

        .progresso-cat-tertiary {
            background: var(--tertiary);
        }

        .progresso-cat-warning {
            background: var(--warning);
        }

        .progresso-cat-primary {
            background: var(--primary);
        }

        .progresso-cat-pct {
            font-size: var(--small-size);
            font-weight: 600;
            color: var(--text-muted);
        }

        /* ─── Alertas ─── */
        .alertas-lista {
            display: flex;
            flex-direction: column;
            gap: var(--space-md);
            padding: var(--space-lg);
        }

        .alerta-item {
            display: flex;
            align-items: flex-start;
            gap: var(--space-md);
            padding: var(--space-md);
            border-radius: var(--radius-md);
            border-left: 3px solid;
            transition: all 0.2s;
        }

        .alerta-item:hover {
            transform: translateX(2px);
        }

        .alerta-danger {
            background: var(--danger-light);
            border-left-color: var(--danger);
        }

        .alerta-danger .alerta-icon {
            color: var(--danger);
        }

        .alerta-danger .alerta-titulo {
            color: var(--danger);
        }

        .alerta-warning {
            background: var(--warning-light);
            border-left-color: var(--warning);
        }

        .alerta-warning .alerta-icon {
            color: var(--warning);
        }

        .alerta-warning .alerta-titulo {
            color: var(--warning);
        }

        .alerta-info {
            background: rgba(0, 131, 143, 0.08);
            border-left-color: var(--tertiary);
        }

        .alerta-info .alerta-icon {
            color: var(--tertiary);
        }

        .alerta-info .alerta-titulo {
            color: var(--tertiary);
        }

        .alerta-icon {
            flex-shrink: 0;
            margin-top: 2px;
        }

        .alerta-content {
            flex: 1;
            min-width: 0;
        }

        .alerta-titulo {
            font-weight: 600;
            font-size: var(--label-size);
            margin-bottom: 2px;
        }

        .alerta-descricao {
            font-size: var(--small-size);
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .alerta-tempo {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .alerta-empty {
            text-align: center;
            padding: var(--space-xl);
            color: var(--text-muted);
        }

        .alerta-empty p {
            margin-top: var(--space-sm);
            font-size: var(--label-size);
        }

        /* ─── Atividades ─── */
        .atividades-lista {
            display: flex;
            flex-direction: column;
            padding: var(--space-sm) 0;
        }

        .atividade-item {
            display: flex;
            align-items: center;
            gap: var(--space-md);
            padding: var(--space-md) var(--space-lg);
            border-bottom: 1px solid var(--neutral-dark);
            transition: all 0.2s;
        }

        .atividade-item:last-child {
            border-bottom: none;
        }

        .atividade-item:hover {
            background: var(--neutral);
        }

        .atividade-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .atividade-content {
            flex: 1;
            min-width: 0;
        }

        .atividade-linha1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2px;
        }

        .atividade-acao {
            font-size: var(--label-size);
            font-weight: 600;
            color: var(--text-primary);
        }

        .atividade-hora {
            font-size: var(--small-size);
            color: var(--text-muted);
            white-space: nowrap;
        }

        .atividade-linha2 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: var(--space-sm);
        }

        .atividade-ref {
            font-size: var(--small-size);
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .atividade-valor {
            font-size: var(--small-size);
            font-weight: 600;
            color: var(--success);
            white-space: nowrap;
        }

        /* ─── Badges ─── */
        .badge-success {
            background: var(--success-light);
            color: var(--success);
        }

        .badge-info {
            background: rgba(0, 51, 102, 0.1);
            color: var(--primary);
        }

        .badge-warning {
            background: var(--warning-light);
            color: var(--warning);
        }

        .badge-danger {
            background: var(--danger-light);
            color: var(--danger);
        }

        /* ─── Animações ─── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dash-card {
            animation: fadeInUp 0.4s ease backwards;
        }

        .dash-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .dash-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .dash-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .dash-card:nth-child(4) {
            animation-delay: 0.2s;
        }

        .dash-card:nth-child(5) {
            animation-delay: 0.25s;
        }

        .dash-card:nth-child(6) {
            animation-delay: 0.3s;
        }
    </style>
    <div class="page-content">
        <!-- Page Header com Filtro de Período -->
        <div class="page-header" style="flex-wrap: wrap; gap: var(--space-md);">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Visão geral do sistema de fornecimento de água</p>
            </div>
            <div class="periodo-selector">
                <select wire:model.live="periodo" class="form-select" style="width: auto; min-width: 160px;">
                    <option value="mes">📅 Este Mês</option>
                    <option value="trimestre">📊 Este Trimestre</option>
                    <option value="semestre">📈 Este Semestre</option>
                    <option value="ano">🗓️ Este Ano</option>
                </select>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- CARDS RESUMIDOS — 6 cards com dados dos módulos principais -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="dash-cards-grid">
            @foreach ($cards as $key => $card)
                <a href="{{ route($card['rota']) }}" class="dash-card dash-card-{{ $card['cor'] }}">
                    <div class="dash-card-icon">
                        @include('livewire.admin.dashboard.icons.' . $card['icone'])
                        {{-- @include('livewire.admin.dashboard.icons.activity') --}}
                    </div>
                    <div class="dash-card-content">
                        <div class="dash-card-value">{{ $card['valor'] }}</div>
                        <div class="dash-card-title">{{ $card['titulo'] }}</div>
                        <div class="dash-card-subtitle">{{ $card['subtitulo'] }}</div>
                        <div class="dash-card-tendencia tendencia-{{ $card['tendencia_tipo'] }}">
                            @if ($card['tendencia_tipo'] === 'positivo')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path d="M18 15l-6-6-6 6" />
                                </svg>
                            @elseif($card['tendencia_tipo'] === 'negativo')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            @endif
                            {{ $card['tendencia'] }}
                        </div>
                    </div>
                    @if ($card['alerta'])
                        <div class="dash-card-alerta">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <line x1="12" y1="9" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                            {{ $card['alerta'] }}
                        </div>
                    @endif
                </a>
            @endforeach
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- GRÁFICOS — Linha 1: Consumo + Distribuição por Zona -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="grid-2" style="margin-bottom: var(--space-xl);">
            <!-- Gráfico 1: Consumo de Água -->
            <div class="card chart-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 3v18h18" />
                            <path d="m19 9-5 5-4-4-3 3" />
                        </svg>
                        Consumo de Água (m³)
                    </h3>
                    <span class="chart-badge">últimos 6 meses</span>
                </div>
                <div class="chart-container">
                    <canvas id="chartConsumo" data-chart='@json($graficoConsumo)'></canvas>
                </div>
            </div>

            <!-- Gráfico 2: Distribuição por Zona -->
            <div class="card chart-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
                            <path d="M22 12A10 10 0 0 0 9 2.83" />
                            <path d="M8 2.83v4.24" />
                            <path d="M8 2.83l3.54 3.54" />
                        </svg>
                        Distribuição por Zona
                    </h3>
                </div>
                <div class="chart-container" style="display: flex; align-items: center; justify-content: center;">
                    <canvas id="chartZonas" data-chart='@json($graficoZonas)'></canvas>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- GRÁFICOS — Linha 2: Receita vs Inadimplência + Leituras -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="grid-2" style="margin-bottom: var(--space-xl);">
            <!-- Gráfico 3: Receita vs Inadimplência -->
            <div class="card chart-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="12" x2="12" y1="2" y2="22" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                        Receita vs Inadimplência
                    </h3>
                    <div class="chart-legend-inline">
                        <span class="legend-dot" style="background: #003366;"></span> Receita
                        <span class="legend-dot" style="background: #dc2626;"></span> Inadimplência
                        <span class="legend-line" style="border-color: #059669;"></span> Líquido
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="chartReceita" data-chart='@json($graficoReceita)'></canvas>
                </div>
            </div>

            <!-- Gráfico 4: Leituras por Dia da Semana -->
            <div class="card chart-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                        Leituras por Dia da Semana
                    </h3>
                    <span class="chart-badge">últimos 30 dias</span>
                </div>
                <div class="chart-container">
                    <canvas id="chartLeituras" data-chart='@json($graficoLeituras)'></canvas>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- GRÁFICOS — Linha 3: Status Faturas + Inadimplência -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="grid-2" style="margin-bottom: var(--space-xl);">
            <!-- Gráfico 5: Status das Faturas -->
            <div class="card chart-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" x2="8" y1="13" y2="13" />
                            <line x1="16" x2="8" y1="17" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                        Status das Faturas
                    </h3>
                </div>
                <div class="chart-container" style="display: flex; align-items: center; justify-content: center;">
                    <canvas id="chartFaturasStatus" data-chart='@json($graficoFaturasStatus)'></canvas>
                </div>
            </div>

            <!-- Gráfico 6: Evolução da Inadimplência -->
            <div class="card chart-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 20v-6M6 20V10M18 20V4" />
                        </svg>
                        Evolução da Inadimplência (%)
                    </h3>
                    <span class="chart-badge">vs média do setor</span>
                </div>
                <div class="chart-container">
                    <canvas id="chartInadimplencia" data-chart='@json($graficoInadimplencia)'></canvas>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- PROGRESSO DAS LEITURAS — Card especial -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="card" style="margin-bottom: var(--space-xl);">
            <div class="card-header">
                <h3 class="card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 6v6l4 2" />
                    </svg>
                    Progresso das Leituras de Hoje
                </h3>
                <span
                    class="badge badge-{{ $progressoLeituras['percentual'] >= 70 ? 'success' : ($progressoLeituras['percentual'] >= 40 ? 'warning' : 'danger') }}">
                    {{ $progressoLeituras['realizadas'] }}/{{ $progressoLeituras['meta'] }}
                </span>
            </div>
            <div style="padding: var(--space-lg);">
                <div class="progresso-header">
                    <span style="font-size: var(--label-size); color: var(--text-secondary);">Progresso Geral</span>
                    <span
                        style="font-size: var(--label-size); font-weight: 700; color: var(--primary);">{{ $progressoLeituras['percentual'] }}%</span>
                </div>
                <div class="progresso-barra-bg">
                    <div class="progresso-barra-fill" style="width: {{ min($progressoLeituras['percentual'], 100) }}%;">
                    </div>
                </div>

                <div class="progresso-categorias">
                    @foreach ($progressoLeituras['categorias'] as $cat)
                        <div class="progresso-cat-item">
                            <div class="progresso-cat-header">
                                <span class="progresso-cat-nome">{{ $cat['nome'] }}</span>
                                <span class="progresso-cat-valor">{{ $cat['realizadas'] }}/{{ $cat['total'] }}</span>
                            </div>
                            <div class="progresso-cat-barra-bg">
                                <div class="progresso-cat-barra-fill progresso-cat-{{ $cat['cor'] }}"
                                    style="width: {{ min($cat['percentual'], 100) }}%;"></div>
                            </div>
                            <span class="progresso-cat-pct">{{ $cat['percentual'] }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- ALERTAS + ATIVIDADES — Última linha -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="grid-2">
            <!-- Alertas do Sistema -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                        </svg>
                        Alertas do Sistema
                    </h3>
                    <span class="badge badge-danger">{{ count($alertas) }}</span>
                </div>
                <div class="alertas-lista">
                    @forelse($alertas as $alerta)
                        <div class="alerta-item alerta-{{ $alerta['tipo'] }}">
                            <div class="alerta-icon">
                                @if ($alerta['icone'] === 'alert-triangle')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                        <line x1="12" y1="9" x2="12" y2="13" />
                                        <line x1="12" y1="17" x2="12.01" y2="17" />
                                    </svg>
                                @elseif($alerta['icone'] === 'file-warning')
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="12" y1="13" x2="12" y2="17" />
                                        <line x1="12" y1="9" x2="12.01" y2="9" />
                                    </svg>
                                @else
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="16" x2="12" y2="12" />
                                        <line x1="12" y1="8" x2="12.01" y2="8" />
                                    </svg>
                                @endif
                            </div>
                            <div class="alerta-content">
                                <div class="alerta-titulo">{{ $alerta['titulo'] }}</div>
                                <div class="alerta-descricao">{{ $alerta['descricao'] }}</div>
                                <div class="alerta-tempo">{{ $alerta['tempo'] }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="alerta-empty">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="var(--success)" stroke-width="1.5">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                            <p>Tudo em ordem! Nenhum alerta no momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Atividade Recente -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                        Atividade Recente
                    </h3>
                </div>
                <div class="atividades-lista">
                    @foreach ($atividades as $atividade)
                        <div class="atividade-item">
                            <div class="atividade-dot" style="background: {{ $atividade['cor_dot'] }};"></div>
                            <div class="atividade-content">
                                <div class="atividade-linha1">
                                    <span class="atividade-acao">{{ $atividade['acao'] }}</span>
                                    <span class="atividade-hora">{{ $atividade['hora'] }}</span>
                                </div>
                                <div class="atividade-linha2">
                                    <span class="atividade-ref">{{ $atividade['referencia'] }}</span>
                                    @if (isset($atividade['valor']))
                                        <span class="atividade-valor">{{ $atividade['valor'] }}</span>
                                    @endif
                                </div>
                            </div>
                            <span class="badge badge-{{ $atividade['status_classe'] }}">{{ $atividade['status'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- SCRIPTS CHART.JS -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            // Configuração global do Chart.js
            Chart.defaults.font.family = '"Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif';
            Chart.defaults.font.size = 12;
            Chart.defaults.color = '#64748b';

            function initChart(canvasId, type, options = {}) {
                const canvas = document.getElementById(canvasId);
                if (!canvas) return;

                const data = JSON.parse(canvas.dataset.chart);

                return new Chart(canvas, {
                    type: type,
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 16,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                titleFont: {
                                    size: 13,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                padding: 12,
                                cornerRadius: 8,
                            }
                        },
                        ...options
                    }
                });
            }

            document.addEventListener('livewire:init', () => {
                // Gráfico 1: Consumo (Line)
                initChart('chartConsumo', 'line', {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                });

                // Gráfico 2: Zonas (Doughnut)
                initChart('chartZonas', 'doughnut', {
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 16
                            }
                        }
                    }
                });

                // Gráfico 3: Receita (Mixed: Bar + Line)
                initChart('chartReceita', 'bar', {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return 'MZN ' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                });

                // Gráfico 4: Leituras (Bar)
                initChart('chartLeituras', 'bar', {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                });

                // Gráfico 5: Status Faturas (Doughnut)
                initChart('chartFaturasStatus', 'doughnut', {
                    cutout: '55%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 12,
                                usePointStyle: true
                            }
                        }
                    }
                });

                // Gráfico 6: Inadimplência (Line)
                initChart('chartInadimplencia', 'line', {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 30,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                });
            });
        </script>
    </div>
@endsection
