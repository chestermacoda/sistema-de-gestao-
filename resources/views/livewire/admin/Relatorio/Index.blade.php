   @extends('admin.Layout.layouts')

   @section('content')
       <link rel="stylesheet" href="{{ asset('assets/css/relatorio.css') }}">
       <div class="page-content">
           {{-- Page Header --}}
           <div class="page-header">
               <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                   <div>
                       <h1 class="page-title">Relatórios</h1>
                       <p class="page-subtitle">Análise completa de faturamento, consumo, inadimplência e performance
                           operacional</p>
                   </div>
                   <div style="display: flex; gap: var(--space-sm);">
                       <button class="btn btn-outline" wire:click="openModalAgendar">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <circle cx="12" cy="12" r="10" />
                               <polyline points="12 6 12 12 16 14" />
                           </svg>
                           Agendar
                       </button>
                       <button class="btn btn-primary" wire:click="openModalGerar">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                               <polyline points="14 2 14 8 20 8" />
                               <line x1="16" x2="8" y1="13" y2="13" />
                               <line x1="16" x2="8" y1="17" y2="17" />
                               <polyline points="10 9 9 9 8 9" />
                           </svg>
                           Gerar Relatório
                       </button>
                   </div>
               </div>
           </div>

           {{-- Stats Cards --}}
           <div class="stats-grid" style="margin-bottom: var(--space-xl);">
               <div class="stat-card">
                   <div class="stat-icon primary">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                           <line x1="12" x2="12" y1="20" y2="10" />
                           <line x1="18" x2="18" y1="20" y2="4" />
                           <line x1="6" x2="6" y1="20" y2="16" />
                       </svg>
                   </div>
                   <div class="stat-content">
                       <div class="stat-value">{{ $stats['faturamento_fmt'] ?? 'R$ 0,00' }}</div>
                       <div class="stat-label">Faturamento Total (Ano)</div>
                       <div class="stat-change {{ ($stats['var_faturamento'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                           {{ ($stats['var_faturamento'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['var_faturamento'] ?? 0 }}% vs
                           período anterior
                       </div>
                   </div>
               </div>
               <div class="stat-card">
                   <div class="stat-icon success">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                           <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                       </svg>
                   </div>
                   <div class="stat-content">
                       <div class="stat-value">{{ $stats['volume_fmt'] ?? '0 m³' }}</div>
                       <div class="stat-label">Volume Consumido (Ano)</div>
                       <div class="stat-change {{ ($stats['var_volume'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                           {{ ($stats['var_volume'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['var_volume'] ?? 0 }}% vs período
                           anterior
                       </div>
                   </div>
               </div>
               <div class="stat-card">
                   <div class="stat-icon danger">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                           <circle cx="12" cy="12" r="10" />
                           <line x1="15" x2="9" y1="9" y2="15" />
                           <line x1="9" x2="15" y1="9" y2="15" />
                       </svg>
                   </div>
                   <div class="stat-content">
                       <div class="stat-value">{{ $stats['inadimplencia_fmt'] ?? 'R$ 0,00' }}</div>
                       <div class="stat-label">Inadimplência Acumulada</div>
                       <div class="stat-change negative">{{ $stats['var_inadimplencia'] ?? 0 }}% vs mês anterior</div>
                   </div>
               </div>
               <div class="stat-card">
                   <div class="stat-icon tertiary">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                           <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                           <polyline points="22 4 12 14.01 9 11.01" />
                       </svg>
                   </div>
                   <div class="stat-content">
                       <div class="stat-value">{{ $stats['eficiencia_fmt'] ?? '0%' }}</div>
                       <div class="stat-label">Eficiência de Leitura</div>
                       <div class="stat-change positive">+{{ $stats['var_eficiencia'] ?? 0 }}% vs mês anterior</div>
                   </div>
               </div>
           </div>

           {{-- Filters Bar --}}
           <div class="card" style="padding: var(--space-md) var(--space-lg); margin-bottom: var(--space-lg);">
               <div style="display: flex; gap: var(--space-md); align-items: center; flex-wrap: wrap;">
                   <div style="position: relative; flex: 1; min-width: 250px;">
                       <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2"
                           style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                           <circle cx="11" cy="11" r="8" />
                           <path d="m21 21-4.3-4.3" />
                       </svg>
                       <input type="text" class="form-input" wire:model.live.debounce.300ms="busca"
                           placeholder="Buscar relatórios, métricas..." style="padding-left: 2.5rem;">
                   </div>
                   <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="periodo">
                       <option value="ano">Período: Último Ano</option>
                       <option value="mes">Último Mês</option>
                       <option value="trimestre">Último Trimestre</option>
                       <option value="semestre">Último Semestre</option>
                   </select>
                   <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="tipoFiltro">
                       <option value="todos">Todos os Tipos</option>
                       <option value="financeiro">Financeiro</option>
                       <option value="consumo">Consumo</option>
                       <option value="inadimplencia">Inadimplência</option>
                       <option value="operacional">Operacional</option>
                   </select>
                   <button class="btn btn-outline btn-sm" wire:click="openModalExportar">
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

           {{-- Tabs --}}
           <div class="tabs" style="margin-bottom: var(--space-lg);">
               <button class="tab {{ $tabAtiva === 'visao' ? 'active' : '' }}" wire:click="switchTab('visao')">Visão
                   Geral</button>
               <button class="tab {{ $tabAtiva === 'financeiro' ? 'active' : '' }}"
                   wire:click="switchTab('financeiro')">Financeiro</button>
               <button class="tab {{ $tabAtiva === 'consumo' ? 'active' : '' }}"
                   wire:click="switchTab('consumo')">Consumo</button>
               <button class="tab {{ $tabAtiva === 'inadimplencia' ? 'active' : '' }}"
                   wire:click="switchTab('inadimplencia')">Inadimplência</button>
               <button class="tab {{ $tabAtiva === 'operacional' ? 'active' : '' }}"
                   wire:click="switchTab('operacional')">Operacional</button>
           </div>

           {{-- TAB: Visão Geral --}}
           @if ($tabAtiva === 'visao')
               <div class="tab-content-rel">
                   <div class="rel-grid" style="margin-bottom: var(--space-xl);">
                       <div class="rel-card rel-financeiro" wire:click="switchTab('financeiro')" style="cursor:pointer;">
                           <div class="rel-card-header">
                               <div>
                                   <div class="rel-card-title">Faturamento</div>
                                   <div class="rel-card-desc">Receitas e projeções</div>
                               </div>
                               <div class="rel-card-icon rel-financeiro">
                                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2">
                                       <line x1="12" x2="12" y1="2" y2="22" />
                                       <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                   </svg>
                               </div>
                           </div>
                           <div class="rel-card-body">
                               <div class="rel-metrica">
                                   <span class="rel-metrica-valor">{{ $stats['faturamento_fmt'] ?? '—' }}</span>
                                   <span class="rel-metrica-label">total período</span>
                                   <span
                                       class="rel-metrica-variacao positiva">{{ ($stats['var_faturamento'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['var_faturamento'] ?? 0 }}%</span>
                               </div>
                           </div>
                           <div class="rel-card-footer">
                               <span class="rel-card-data">Atualizado em: {{ now()->format('d/m/Y') }}</span>
                               <button class="btn btn-sm btn-ghost">Ver detalhes →</button>
                           </div>
                       </div>

                       <div class="rel-card rel-consumo" wire:click="switchTab('consumo')" style="cursor:pointer;">
                           <div class="rel-card-header">
                               <div>
                                   <div class="rel-card-title">Consumo</div>
                                   <div class="rel-card-desc">Volume e comparativos</div>
                               </div>
                               <div class="rel-card-icon rel-consumo">
                                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2">
                                       <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                   </svg>
                               </div>
                           </div>
                           <div class="rel-card-body">
                               <div class="rel-metrica">
                                   <span class="rel-metrica-valor">{{ $stats['volume_fmt'] ?? '—' }}</span>
                                   <span class="rel-metrica-label">total período</span>
                                   <span
                                       class="rel-metrica-variacao positiva">{{ ($stats['var_volume'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['var_volume'] ?? 0 }}%</span>
                               </div>
                           </div>
                           <div class="rel-card-footer">
                               <span class="rel-card-data">Atualizado em: {{ now()->format('d/m/Y') }}</span>
                               <button class="btn btn-sm btn-ghost">Ver detalhes →</button>
                           </div>
                       </div>

                       <div class="rel-card rel-inadimplencia" wire:click="switchTab('inadimplencia')"
                           style="cursor:pointer;">
                           <div class="rel-card-header">
                               <div>
                                   <div class="rel-card-title">Inadimplência</div>
                                   <div class="rel-card-desc">Débitos e recuperação</div>
                               </div>
                               <div class="rel-card-icon rel-inadimplencia">
                                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2">
                                       <circle cx="12" cy="12" r="10" />
                                       <line x1="15" x2="9" y1="9" y2="15" />
                                       <line x1="9" x2="15" y1="9" y2="15" />
                                   </svg>
                               </div>
                           </div>
                           <div class="rel-card-body">
                               <div class="rel-metrica">
                                   <span class="rel-metrica-valor">{{ $stats['inadimplencia_fmt'] ?? '—' }}</span>
                                   <span class="rel-metrica-label">em aberto</span>
                                   <span
                                       class="rel-metrica-variacao positiva">{{ $stats['var_inadimplencia'] ?? 0 }}%</span>
                               </div>
                           </div>
                           <div class="rel-card-footer">
                               <span class="rel-card-data">Atualizado em: {{ now()->format('d/m/Y') }}</span>
                               <button class="btn btn-sm btn-ghost">Ver detalhes →</button>
                           </div>
                       </div>

                       <div class="rel-card rel-leituras" wire:click="switchTab('operacional')" style="cursor:pointer;">
                           <div class="rel-card-header">
                               <div>
                                   <div class="rel-card-title">Operacional</div>
                                   <div class="rel-card-desc">Leituras e performance</div>
                               </div>
                               <div class="rel-card-icon rel-leituras">
                                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2">
                                       <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                       <polyline points="22 4 12 14.01 9 11.01" />
                                   </svg>
                               </div>
                           </div>
                           <div class="rel-card-body">
                               <div class="rel-metrica">
                                   <span class="rel-metrica-valor">{{ $stats['eficiencia_fmt'] ?? '—' }}</span>
                                   <span class="rel-metrica-label">eficiência</span>
                                   <span
                                       class="rel-metrica-variacao positiva">+{{ $stats['var_eficiencia'] ?? 0 }}%</span>
                               </div>
                           </div>
                           <div class="rel-card-footer">
                               <span class="rel-card-data">Atualizado em: {{ now()->format('d/m/Y') }}</span>
                               <button class="btn btn-sm btn-ghost">Ver detalhes →</button>
                           </div>
                       </div>
                   </div>

                   {{-- Relatórios Recentes --}}
                   <div class="card" style="margin-bottom: var(--space-xl);">
                       <div class="card-header">
                           <h3 class="card-title">Relatórios Recentes</h3>
                           <button class="btn btn-sm btn-outline" wire:click="openModalGerar">
                               <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                   stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                   <path d="M5 12h14" />
                                   <path d="M12 5v14" />
                               </svg>
                               Novo Relatório
                           </button>
                       </div>
                       <div class="rel-relatorios-list">
                           @forelse($relatoriosRecentes as $rel)
                               <div class="rel-relatorio-item">
                                   <div class="rel-relatorio-icon"
                                       style="background: var(--success-light); color: var(--success);">
                                       <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                           stroke="currentColor" stroke-width="2">
                                           <line x1="12" x2="12" y1="2" y2="22" />
                                           <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                       </svg>
                                   </div>
                                   <div class="rel-relatorio-info">
                                       <div class="rel-relatorio-titulo">{{ $rel->titulo }}</div>
                                       <div class="rel-relatorio-meta">
                                           Gerado em
                                           {{ $rel->gerado_em?->format('d/m/Y \à\s H:i') ?? $rel->created_at->format('d/m/Y H:i') }}
                                           por {{ $rel->user->name ?? 'Sistema' }}
                                       </div>
                                   </div>
                                   <span
                                       class="rel-relatorio-status {{ $rel->status_badge }}">{{ ucfirst($rel->status) }}</span>
                                   <div class="rel-relatorio-actions">
                                       @if ($rel->status === 'pronto')
                                           <button class="btn btn-sm btn-ghost"
                                               wire:click="openModalVisualizar({{ $rel->id }})" title="Visualizar">
                                               <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                   stroke="currentColor" stroke-width="2">
                                                   <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                                   <circle cx="12" cy="12" r="3" />
                                               </svg>
                                           </button>
                                           <button class="btn btn-sm btn-ghost"
                                               wire:click="openModalExportar({{ $rel->id }})" title="Exportar">
                                               <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                   stroke="currentColor" stroke-width="2">
                                                   <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                   <polyline points="7 10 12 15 17 10" />
                                                   <line x1="12" x2="12" y1="15" y2="3" />
                                               </svg>
                                           </button>
                                       @endif
                                   </div>
                               </div>
                           @empty
                               <div style="padding: var(--space-lg); text-align: center; color: var(--text-muted);">
                                   Nenhum relatório gerado ainda. Clique em "Gerar Relatório" para começar.
                               </div>
                           @endforelse
                       </div>
                   </div>

                   {{-- Relatórios Agendados --}}
                   <div class="card" style="margin-bottom: var(--space-xl);">
                       <div class="card-header">
                           <h3 class="card-title">Relatórios Agendados</h3>
                           <button class="btn btn-sm btn-outline" wire:click="openModalAgendar">
                               <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                   stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                                   <circle cx="12" cy="12" r="10" />
                                   <polyline points="12 6 12 12 16 14" />
                               </svg>
                               Novo Agendamento
                           </button>
                       </div>
                       <div class="rel-agenda-list">
                           @forelse($agendamentos as $ag)
                               <div class="rel-agenda-item {{ $ag->frequencia_css }}">
                                   <div class="rel-agenda-info">
                                       <div class="rel-agenda-titulo">{{ $ag->titulo }}</div>
                                       <div class="rel-agenda-freq">{{ $ag->frequencia_label }} às
                                           {{ substr($ag->horario, 0, 5) }}</div>
                                       <div class="rel-agenda-dest">Enviado para: {{ $ag->destinatarios }}</div>
                                   </div>
                                   <div class="rel-relatorio-actions">
                                       <button class="btn btn-sm btn-ghost"
                                           wire:click="openModalAgendar({{ $ag->id }})">
                                           <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                               stroke="currentColor" stroke-width="2">
                                               <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                           </svg>
                                       </button>
                                       <button class="btn btn-sm btn-ghost" style="color: var(--danger);"
                                           wire:click="cancelarAgendamento({{ $ag->id }})"
                                           wire:confirm="Cancelar este agendamento?">
                                           <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                               stroke="currentColor" stroke-width="2">
                                               <circle cx="12" cy="12" r="10" />
                                               <line x1="15" x2="9" y1="9" y2="15" />
                                               <line x1="9" x2="15" y1="9" y2="15" />
                                           </svg>
                                       </button>
                                   </div>
                               </div>
                           @empty
                               <div style="padding: var(--space-lg); text-align: center; color: var(--text-muted);">
                                   Nenhum agendamento ativo.
                               </div>
                           @endforelse
                       </div>
                   </div>
               </div>
           @endif

           {{-- TAB: Financeiro --}}
           @if ($tabAtiva === 'financeiro')
               <div class="tab-content-rel">
                   <div class="grid-2" style="margin-bottom: var(--space-xl);">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Faturamento Mensal</h3>
                           </div>
                           <div class="rel-grafico-container">
                               @foreach ($faturamentoMensal as $bar)
                                   <div class="rel-grafico-bar-wrap">
                                       <div class="rel-grafico-bar" style="height: {{ max(5, $bar['altura']) }}%;">
                                           <span class="rel-grafico-bar-valor">{{ $bar['fmt'] }}</span>
                                       </div>
                                       <span class="rel-grafico-label">{{ $bar['mes'] }}</span>
                                   </div>
                               @endforeach
                           </div>
                       </div>
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Composição da Receita</h3>
                           </div>
                           <div style="padding: var(--space-lg);">
                               <div style="display: flex; flex-direction: column; gap: var(--space-md);">
                                   @foreach ($composicaoReceita as $item)
                                       <div
                                           style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                                           <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                               <div
                                                   style="width: 12px; height: 12px; border-radius: 50%; background: var(--{{ $item['cor'] }});">
                                               </div>
                                               <span
                                                   style="font-size: var(--label-size); color: var(--text-primary);">{{ $item['nome'] }}</span>
                                           </div>
                                           <span
                                               style="font-weight: 700; font-size: var(--label-size); color: var(--text-primary);">
                                               R$ {{ number_format($item['valor'], 2, ',', '.') }} ({{ $item['pct'] }}%)
                                           </span>
                                       </div>
                                   @endforeach
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="card">
                       <div class="card-header">
                           <h3 class="card-title">Detalhamento Financeiro por Período</h3>
                           <button class="btn btn-sm btn-outline" wire:click="openModalExportar">Exportar</button>
                       </div>
                       <div class="table-container">
                           <table>
                               <thead>
                                   <tr>
                                       <th>Mês</th>
                                       <th>Residencial</th>
                                       <th>Comercial</th>
                                       <th>Industrial</th>
                                       <th>Taxas</th>
                                       <th>Total</th>
                                       <th>Variação</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($detalheFinanceiro as $row)
                                       <tr>
                                           <td style="font-weight: 600;">{{ $row['mes'] }}</td>
                                           <td>R$ {{ number_format($row['residencial'], 2, ',', '.') }}</td>
                                           <td>R$ {{ number_format($row['comercial'], 2, ',', '.') }}</td>
                                           <td>R$ {{ number_format($row['industrial'], 2, ',', '.') }}</td>
                                           <td>R$ {{ number_format($row['taxas'], 2, ',', '.') }}</td>
                                           <td style="font-weight: 700; color: var(--primary);">R$
                                               {{ number_format($row['total'], 2, ',', '.') }}</td>
                                           <td>
                                               <span
                                                   class="stat-change {{ $row['variacao'] >= 0 ? 'positive' : 'negative' }}">
                                                   {{ $row['variacao'] >= 0 ? '+' : '' }}{{ $row['variacao'] }}%
                                               </span>
                                           </td>
                                       </tr>
                                   @endforeach
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           @endif

           {{-- TAB: Consumo --}}
           @if ($tabAtiva === 'consumo')
               <div class="tab-content-rel">
                   <div class="grid-2" style="margin-bottom: var(--space-xl);">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Consumo por Zona</h3>
                           </div>
                           <div style="padding: var(--space-lg);">
                               <div class="rel-zona-comparativo">
                                   @forelse($consumoPorZona as $z)
                                       <div class="rel-zona-item">
                                           <span class="rel-zona-nome">{{ $z['nome'] }}</span>
                                           <div class="rel-zona-bar-wrap">
                                               <div class="rel-zona-bar"
                                                   style="width: {{ $z['largura'] }}%; background: var(--{{ $z['cor'] }});">
                                                   <span class="rel-zona-bar-valor">{{ $z['fmt'] }}</span>
                                               </div>
                                           </div>
                                           <span class="rel-zona-total">{{ $z['pct'] }}%</span>
                                       </div>
                                   @empty
                                       <p style="color: var(--text-muted);">Sem dados de consumo no período.</p>
                                   @endforelse
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           @endif

           {{-- TAB: Inadimplência --}}
           @if ($tabAtiva === 'inadimplencia')
               <div class="tab-content-rel">
                   <div class="card" style="margin-bottom: var(--space-xl);">
                       <div class="card-header">
                           <h3 class="card-title">Evolução da Inadimplência</h3>
                       </div>
                       <div class="rel-grafico-container">
                           @foreach ($inadimplenciaMensal as $bar)
                               <div class="rel-grafico-bar-wrap">
                                   <div class="rel-grafico-bar"
                                       style="height: {{ max(5, $bar['altura']) }}%; background: linear-gradient(to top, var(--danger), #ef4444);">
                                       <span class="rel-grafico-bar-valor">{{ $bar['fmt'] }}</span>
                                   </div>
                                   <span class="rel-grafico-label">{{ $bar['mes'] }}</span>
                               </div>
                           @endforeach
                       </div>
                   </div>

                   <div class="card">
                       <div class="card-header">
                           <h3 class="card-title">Detalhamento de Inadimplência</h3>
                           <button class="btn btn-sm btn-outline" wire:click="openModalExportar">Exportar</button>
                       </div>
                       <div class="table-container">
                           <table>
                               <thead>
                                   <tr>
                                       <th>Cliente</th>
                                       <th>Valor em Aberto</th>
                                       <th>Meses em Atraso</th>
                                       <th>Vencimento</th>
                                       <th>Status</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @forelse($detalheInadimplencia as $row)
                                       <tr>
                                           <td style="font-weight: 600;">{{ $row['cliente'] }}</td>
                                           <td style="font-weight: 700; color: var(--danger); font-family: monospace;">
                                               {{ $row['valor_fmt'] }}</td>
                                           <td><span class="badge badge-{{ $row['badge'] }}">{{ $row['meses_atraso'] }}
                                                   {{ $row['meses_atraso'] == 1 ? 'mês' : 'meses' }}</span></td>
                                           <td>{{ $row['ultimo_pagamento'] }}</td>
                                           <td><span class="badge badge-{{ $row['badge'] }}">{{ $row['status'] }}</span>
                                           </td>
                                       </tr>
                                   @empty
                                       <tr>
                                           <td colspan="5" style="text-align:center;color:var(--text-muted);">Nenhuma
                                               fatura em atraso.</td>
                                       </tr>
                                   @endforelse
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           @endif

           {{-- TAB: Operacional --}}
           @if ($tabAtiva === 'operacional')
               <div class="tab-content-rel">
                   <div class="grid-2" style="margin-bottom: var(--space-xl);">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Eficiência de Leituras por Leiturista</h3>
                           </div>
                           <div style="padding: var(--space-lg);">
                               <div class="rel-zona-comparativo">
                                   @forelse($eficienciaLeituristas as $l)
                                       <div class="rel-zona-item">
                                           <span class="rel-zona-nome">{{ $l['nome'] }}</span>
                                           <div class="rel-zona-bar-wrap">
                                               <div class="rel-zona-bar"
                                                   style="width: {{ $l['eficiencia'] }}%; background: var(--{{ $l['cor'] }});">
                                                   <span class="rel-zona-bar-valor">{{ $l['eficiencia'] }}%</span>
                                               </div>
                                           </div>
                                           <span class="rel-zona-total">{{ $l['lidos'] }} lidos</span>
                                       </div>
                                   @empty
                                       <p style="color: var(--text-muted);">Sem dados de roteiros no período.</p>
                                   @endforelse
                               </div>
                           </div>
                       </div>
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Anomalias Detectadas</h3>
                               <span style="font-size: var(--small-size); color: var(--text-muted);">Últimos 30 dias</span>
                           </div>
                           <div style="padding: var(--space-lg);">
                               <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--space-md);">
                                   <div
                                       style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                       <div style="font-size: 2rem; font-weight: 700; color: var(--danger);">
                                           {{ $anomalias['consumo_excessivo'] ?? 0 }}</div>
                                       <div
                                           style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                                           Consumo Excessivo</div>
                                   </div>
                                   <div
                                       style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                       <div style="font-size: 2rem; font-weight: 700; color: var(--warning);">
                                           {{ $anomalias['medidor_parado'] ?? 0 }}</div>
                                       <div
                                           style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                                           Medidor Parado</div>
                                   </div>
                                   <div
                                       style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                       <div style="font-size: 2rem; font-weight: 700; color: var(--tertiary);">
                                           {{ $anomalias['vazamento'] ?? 0 }}</div>
                                       <div
                                           style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                                           Vazamento Suspeito</div>
                                   </div>
                                   <div
                                       style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                       <div style="font-size: 2rem; font-weight: 700; color: var(--secondary);">
                                           {{ $anomalias['leitura_inconsistente'] ?? 0 }}</div>
                                       <div
                                           style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                                           Leitura Inconsistente</div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="card">
                       <div class="card-header">
                           <h3 class="card-title">Performance dos Roteiros</h3>
                           <button class="btn btn-sm btn-outline" wire:click="openModalExportar">Exportar</button>
                       </div>
                       <div class="table-container">
                           <table>
                               <thead>
                                   <tr>
                                       <th>Roteiro</th>
                                       <th>Leiturista</th>
                                       <th>Total</th>
                                       <th>Lidos</th>
                                       <th>Anomalias</th>
                                       <th>Eficiência</th>
                                       <th>Status</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @forelse($performanceRoteiros as $r)
                                       <tr>
                                           <td style="font-weight: 600;">{{ $r['roteiro'] }}</td>
                                           <td>{{ $r['leiturista'] }}</td>
                                           <td>{{ $r['total'] }}</td>
                                           <td style="color: var(--success); font-weight: 600;">{{ $r['lidos'] }}</td>
                                           <td style="color: var(--danger); font-weight: 600;">{{ $r['anomalias'] }}</td>
                                           <td style="font-weight: 700; color: var(--{{ $r['badge'] }});">
                                               {{ $r['eficiencia'] }}%</td>
                                           <td><span class="badge badge-{{ $r['badge'] }}">{{ $r['status'] }}</span>
                                           </td>
                                       </tr>
                                   @empty
                                       <tr>
                                           <td colspan="7" style="text-align:center;color:var(--text-muted);">Sem
                                               roteiros no período.</td>
                                       </tr>
                                   @endforelse
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           @endif
       </div>

       {{-- ==================== MODAL: GERAR ==================== --}}
       @if ($modalGerar)
           <div class="modal-overlay active" wire:click.self="closeModalGerar">
               <div class="modal modal-lg" style="max-width: 700px;">
                   <div class="modal-header">
                       <div style="display: flex; align-items: center; gap: var(--space-md);">
                           <div
                               style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--primary); display: flex; align-items: center; justify-content: center; color: white;">
                               <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                   stroke="currentColor" stroke-width="2">
                                   <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                   <polyline points="14 2 14 8 20 8" />
                               </svg>
                           </div>
                           <div>
                               <h3 class="modal-title">Gerar Novo Relatório</h3>
                               <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                                   Selecione o tipo, período e filtros</p>
                           </div>
                       </div>
                       <button class="modal-close" wire:click="closeModalGerar">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <path d="M18 6 6 18" />
                               <path d="m6 6 12 12" />
                           </svg>
                       </button>
                   </div>
                   <div class="modal-body">
                       @if ($gerando)
                           <div class="rel-progress-wrap">
                               <div class="rel-progress-label">
                                   <span>Gerando relatório...</span>
                                   <span>{{ $progressoGeracao }}%</span>
                               </div>
                               <div class="rel-progress-bar">
                                   <div class="rel-progress-fill" style="width: {{ $progressoGeracao }}%"></div>
                               </div>
                           </div>
                       @else
                           <div style="margin-bottom: var(--space-md);">
                               <label class="form-label">Tipo de Relatório *</label>
                               <div class="rel-tipo-grid">
                                   @foreach (['financeiro' => ['Financeiro', 'Faturamento, receitas e projeções', 'success'], 'consumo' => ['Consumo', 'Volume, comparativos e anomalias', 'tertiary'], 'inadimplencia' => ['Inadimplência', 'Débitos, ranking e recuperação', 'danger'], 'operacional' => ['Operacional', 'Leituras, roteiros e eficiência', 'warning']] as $key => $info)
                                       <div class="rel-tipo-card {{ $gerarTipo === $key ? 'selected' : '' }}"
                                           wire:click="selectTipoGerar('{{ $key }}')" style="cursor:pointer;">
                                           <div class="rel-tipo-icon" style="background: var(--{{ $info[2] }});">
                                               <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                   stroke="currentColor" stroke-width="2">
                                                   <circle cx="12" cy="12" r="10" />
                                               </svg>
                                           </div>
                                           <div class="rel-tipo-name">{{ $info[0] }}</div>
                                           <div class="rel-tipo-desc">{{ $info[1] }}</div>
                                       </div>
                                   @endforeach
                               </div>
                           </div>

                           <div class="grid-2">
                               <div class="form-group">
                                   <label class="form-label">Data Início *</label>
                                   <input type="date" class="form-input" wire:model="gerarDataInicio">
                                   @error('gerarDataInicio')
                                       <span class="text-danger">{{ $message }}</span>
                                   @enderror
                               </div>
                               <div class="form-group">
                                   <label class="form-label">Data Fim *</label>
                                   <input type="date" class="form-input" wire:model="gerarDataFim">
                                   @error('gerarDataFim')
                                       <span class="text-danger">{{ $message }}</span>
                                   @enderror
                               </div>
                           </div>

                           <div class="grid-2">
                               <div class="form-group">
                                   <label class="form-label">Zona</label>
                                   <select class="form-select" wire:model="gerarZona">
                                       <option value="">Todas as Zonas</option>
                                       <option value="Zona Norte">Zona Norte</option>
                                       <option value="Zona Sul">Zona Sul</option>
                                       <option value="Zona Leste">Zona Leste</option>
                                       <option value="Zona Oeste">Zona Oeste</option>
                                       <option value="Centro">Centro</option>
                                   </select>
                               </div>
                               <div class="form-group">
                                   <label class="form-label">Categoria</label>
                                   <select class="form-select" wire:model="gerarCategoria">
                                       <option value="">Todas as Categorias</option>
                                       <option value="Residencial">Residencial</option>
                                       <option value="Comercial">Comercial</option>
                                       <option value="Industrial">Industrial</option>
                                       <option value="Público">Público</option>
                                   </select>
                               </div>
                           </div>

                           <div class="form-group">
                               <label class="form-label">Nome do Relatório</label>
                               <input type="text" class="form-input" wire:model="gerarTitulo">
                           </div>
                       @endif
                   </div>
                   <div class="modal-footer">
                       <button class="btn btn-outline" wire:click="closeModalGerar">Cancelar</button>
                       @unless ($gerando)
                           <button class="btn btn-primary" wire:click="gerarRelatorio" wire:loading.attr="disabled">
                               Gerar Relatório
                           </button>
                       @endunless
                   </div>
               </div>
           </div>
       @endif

       {{-- ==================== MODAL: EXPORTAR ==================== --}}
       @if ($modalExportar)
           <div class="modal-overlay active" wire:click.self="closeModalExportar">
               <div class="modal" style="max-width: 600px;">
                   <div class="modal-header">
                       <div style="display: flex; align-items: center; gap: var(--space-md);">
                           <div
                               style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--tertiary); display: flex; align-items: center; justify-content: center; color: white;">
                               <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                   stroke="currentColor" stroke-width="2">
                                   <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                   <polyline points="7 10 12 15 17 10" />
                                   <line x1="12" x2="12" y1="15" y2="3" />
                               </svg>
                           </div>
                           <div>
                               <h3 class="modal-title">Exportar Relatório</h3>
                               <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Escolha
                                   o formato de exportação</p>
                           </div>
                       </div>
                       <button class="modal-close" wire:click="closeModalExportar">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <path d="M18 6 6 18" />
                               <path d="m6 6 12 12" />
                           </svg>
                       </button>
                   </div>
                   <div class="modal-body">
                       <div class="rel-export-options">
                           <div class="rel-export-option {{ $exportFormato === 'pdf' ? 'selected' : '' }}"
                               wire:click="$set('exportFormato', 'pdf')" style="cursor:pointer;">
                               <div class="rel-export-icon">
                                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2">
                                       <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                       <polyline points="14 2 14 8 20 8" />
                                   </svg>
                               </div>
                               <div class="rel-export-name">PDF</div>
                               <div class="rel-export-desc">Documento formatado (mPDF)</div>
                           </div>
                           <div class="rel-export-option {{ $exportFormato === 'excel' ? 'selected' : '' }}"
                               wire:click="$set('exportFormato', 'excel')" style="cursor:pointer;">
                               <div class="rel-export-icon">
                                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2">
                                       <path d="M18 20V10" />
                                       <path d="M12 20V4" />
                                       <path d="M6 20v-6" />
                                   </svg>
                               </div>
                               <div class="rel-export-name">Excel</div>
                               <div class="rel-export-desc">Planilha editável (.xlsx)</div>
                           </div>
                           <div class="rel-export-option {{ $exportFormato === 'csv' ? 'selected' : '' }}"
                               wire:click="$set('exportFormato', 'csv')" style="cursor:pointer;">
                               <div class="rel-export-icon">
                                   <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2">
                                       <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                       <polyline points="7 10 12 15 17 10" />
                                       <line x1="12" x2="12" y1="15" y2="3" />
                                   </svg>
                               </div>
                               <div class="rel-export-name">CSV</div>
                               <div class="rel-export-desc">Dados brutos (separador ;)</div>
                           </div>
                       </div>

                       <div class="form-group" style="margin-top: var(--space-lg);">
                           <label class="form-label">Nome do Arquivo</label>
                           <input type="text" class="form-input" wire:model="exportNome"
                               placeholder="relatorio-financeiro-agosto-2026">
                           <small style="color: var(--text-muted); font-size: var(--small-size);">
                               A extensão ( .pdf / .xlsx / .csv ) será adicionada automaticamente
                           </small>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button class="btn btn-outline" wire:click="closeModalExportar">Cancelar</button>
                       <button class="btn btn-primary" wire:click="exportarRelatorio" wire:loading.attr="disabled">
                           <span wire:loading.remove wire:target="exportarRelatorio">
                               <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                   stroke="currentColor" stroke-width="2"
                                   style="margin-right: 6px; vertical-align: middle;">
                                   <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                   <polyline points="7 10 12 15 17 10" />
                                   <line x1="12" x2="12" y1="15" y2="3" />
                               </svg>
                               Exportar
                           </span>
                           <span wire:loading wire:target="exportarRelatorio">Preparando...</span>
                       </button>
                   </div>
               </div>
           </div>
       @endif

       {{-- ==================== MODAL: AGENDAR ==================== --}}
       @if ($modalAgendar)
           <div class="modal-overlay active" wire:click.self="closeModalAgendar">
               <div class="modal" style="max-width: 600px;">
                   <div class="modal-header">
                       <div>
                           <h3 class="modal-title">{{ $agendamentoId ? 'Editar' : 'Agendar' }} Relatório</h3>
                       </div>
                       <button class="modal-close" wire:click="closeModalAgendar">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <path d="M18 6 6 18" />
                               <path d="m6 6 12 12" />
                           </svg>
                       </button>
                   </div>
                   <div class="modal-body">
                       <div class="form-group">
                           <label class="form-label">Título *</label>
                           <input type="text" class="form-input" wire:model="agendarTitulo">
                       </div>
                       <div class="form-group">
                           <label class="form-label">Tipo *</label>
                           <select class="form-select" wire:model="agendarTipo">
                               <option value="resumo_diario">Resumo Diário de Leituras</option>
                               <option value="inadimplencia">Relatório Semanal de Inadimplência</option>
                               <option value="financeiro">Relatório Mensal de Faturamento</option>
                               <option value="consumo">Relatório de Consumo por Zona</option>
                               <option value="operacional">Relatório Operacional de Eficiência</option>
                           </select>
                       </div>
                       <div class="grid-2">
                           <div class="form-group">
                               <label class="form-label">Frequência *</label>
                               <select class="form-select" wire:model="agendarFrequencia">
                                   <option value="diario">Diário</option>
                                   <option value="semanal">Semanal</option>
                                   <option value="mensal">Mensal</option>
                                   <option value="trimestral">Trimestral</option>
                               </select>
                           </div>
                           <div class="form-group">
                               <label class="form-label">Horário *</label>
                               <input type="time" class="form-input" wire:model="agendarHorario">
                           </div>
                       </div>
                       @if ($agendarFrequencia === 'semanal')
                           <div class="form-group">
                               <label class="form-label">Dia da Semana</label>
                               <select class="form-select" wire:model="agendarDiaSemana">
                                   <option value="1">Segunda-feira</option>
                                   <option value="2">Terça-feira</option>
                                   <option value="3">Quarta-feira</option>
                                   <option value="4">Quinta-feira</option>
                                   <option value="5">Sexta-feira</option>
                               </select>
                           </div>
                       @endif
                       <div class="form-group">
                           <label class="form-label">Destinatários (e-mails separados por vírgula)</label>
                           <textarea class="form-textarea" wire:model="agendarDestinatarios" rows="2"></textarea>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button class="btn btn-outline" wire:click="closeModalAgendar">Cancelar</button>
                       <button class="btn btn-primary" wire:click="salvarAgendamento">Salvar Agendamento</button>
                   </div>
               </div>
           </div>
       @endif

       {{-- ==================== MODAL: VISUALIZAR ==================== --}}
       @if ($modalVisualizar && $relatorioVisualizar)
           <div class="modal-overlay active" wire:click.self="closeModalVisualizar">
               <div class="modal modal-lg" style="max-width: 900px;">
                   <div class="modal-header">
                       <div>
                           <h3 class="modal-title">{{ $relatorioVisualizar->titulo }}</h3>
                           <p style="font-size: var(--small-size); color: var(--text-muted);">
                               Gerado em {{ $relatorioVisualizar->gerado_em?->format('d/m/Y \à\s H:i') }}
                           </p>
                       </div>
                       <button class="modal-close" wire:click="closeModalVisualizar">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <path d="M18 6 6 18" />
                               <path d="m6 6 12 12" />
                           </svg>
                       </button>
                   </div>
                   <div class="modal-body">
                       @if ($relatorioVisualizar->resumo)
                           <div
                               style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--space-md); margin-bottom: var(--space-xl);">
                               <div
                                   style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                   <div style="font-size: var(--small-size); color: var(--text-muted);">Faturamento</div>
                                   <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                                       {{ $relatorioVisualizar->resumo['faturamento_fmt'] ?? '—' }}
                                   </div>
                               </div>
                               <div
                                   style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                   <div style="font-size: var(--small-size); color: var(--text-muted);">Volume</div>
                                   <div style="font-size: 1.25rem; font-weight: 700; color: var(--success);">
                                       {{ $relatorioVisualizar->resumo['volume_fmt'] ?? '—' }}
                                   </div>
                               </div>
                               <div
                                   style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                   <div style="font-size: var(--small-size); color: var(--text-muted);">Inadimplência</div>
                                   <div style="font-size: 1.25rem; font-weight: 700; color: var(--danger);">
                                       {{ $relatorioVisualizar->resumo['inadimplencia_fmt'] ?? '—' }}
                                   </div>
                               </div>
                               <div
                                   style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                   <div style="font-size: var(--small-size); color: var(--text-muted);">Eficiência</div>
                                   <div style="font-size: 1.25rem; font-weight: 700; color: var(--tertiary);">
                                       {{ $relatorioVisualizar->resumo['eficiencia_fmt'] ?? '—' }}
                                   </div>
                               </div>
                           </div>
                       @endif
                       <p style="color: var(--text-muted);">Tipo: <strong>{{ $relatorioVisualizar->tipo_label }}</strong>
                           |
                           Período: {{ $relatorioVisualizar->data_inicio?->format('d/m/Y') }} —
                           {{ $relatorioVisualizar->data_fim?->format('d/m/Y') }}
                       </p>
                   </div>
                   <div class="modal-footer">
                       <button class="btn btn-outline" wire:click="closeModalVisualizar">Fechar</button>
                       <button class="btn btn-secondary"
                           wire:click="openModalExportar({{ $relatorioVisualizar->id }})">Exportar PDF</button>
                   </div>
               </div>
           </div>
       @endif
       <script>
           document.addEventListener('livewire:initialized', () => {
               Livewire.on('download-relatorio', ({
                   url
               }) => {
                   // Cria um link invisível e clica — evita popup blockers
                   const a = document.createElement('a');
                   a.href = url;
                   a.style.display = 'none';
                   document.body.appendChild(a);
                   a.click();
                   a.remove();
               });

               Livewire.on('toast', ({
                   message,
                   type
               }) => {
                   // Reutiliza a função showToast se existir no layout, senão cria uma simples
                   if (typeof showToast === 'function') {
                       showToast(message, type || 'success');
                       return;
                   }
                   const toast = document.createElement('div');
                   toast.style.cssText =
                       'position:fixed;bottom:20px;right:20px;padding:12px 24px;border-radius:8px;color:white;font-weight:600;z-index:9999;';
                   toast.style.background = type === 'success' ? '#059669' : type === 'error' ? '#DC2626' :
                       '#D97706';
                   toast.textContent = message;
                   document.body.appendChild(toast);
                   setTimeout(() => toast.remove(), 3000);
               });
           });
           // Modal functions
           function openModal(id) {
               document.getElementById(id).classList.add('active');
               document.body.style.overflow = 'hidden';
           }

           function closeModal(id) {
               document.getElementById(id).classList.remove('active');
               document.body.style.overflow = '';
           }

           // Close modal on overlay click
           document.addEventListener('click', function(e) {
               if (e.target.classList.contains('modal-overlay')) {
                   e.target.classList.remove('active');
                   document.body.style.overflow = '';
               }
           });

           // Close modal on escape key
           document.addEventListener('keydown', function(e) {
               if (e.key === 'Escape') {
                   document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                       modal.classList.remove('active');
                   });
                   document.body.style.overflow = '';
               }
           });

           // Toggle sidebar on mobile
           function toggleSidebar() {
               document.querySelector('.sidebar').classList.toggle('open');
           }

           // Tab switching - Relatórios
           function switchTabRel(btn, tabId) {
               document.querySelectorAll('.tabs .tab').forEach(t => t.classList.remove('active'));
               btn.classList.add('active');
               document.querySelectorAll('.tab-content-rel').forEach(c => c.style.display = 'none');
               document.getElementById(tabId).style.display = 'block';
           }

           function switchTabRelById(tabId) {
               document.querySelectorAll('.tabs .tab').forEach(t => t.classList.remove('active'));
               document.querySelectorAll('.tab-content-rel').forEach(c => c.style.display = 'none');
               document.getElementById(tabId).style.display = 'block';
               // Ativa a tab correspondente
               const tabs = document.querySelectorAll('.tabs .tab');
               const tabMap = {
                   'tab-visao': 0,
                   'tab-financeiro': 1,
                   'tab-consumo': 2,
                   'tab-inadimplencia': 3,
                   'tab-operacional': 4
               };
               if (tabs[tabMap[tabId]]) {
                   tabs[tabMap[tabId]].classList.add('active');
               }
           }

           // Seleção de tipo de relatório
           function selectTipoRel(element) {
               document.querySelectorAll('.rel-tipo-card').forEach(c => c.classList.remove('selected'));
               element.classList.add('selected');
           }

           // Seleção de formato de exportação
           function selectExport(element) {
               document.querySelectorAll('.rel-export-option').forEach(c => c.classList.remove('selected'));
               element.classList.add('selected');
           }

           // Actions
           function gerarRelatorio() {
               const modal = document.getElementById('modal-gerar');
               const body = modal.querySelector('.modal-body');

               // Mostra progresso
               body.innerHTML = `
                <div class="rel-progress-wrap">
                    <div class="rel-progress-label">
                        <span>Gerando relatório...</span>
                        <span id="progress-percent">0%</span>
                    </div>
                    <div class="rel-progress-bar">
                        <div class="rel-progress-fill" id="progress-fill" style="width: 0%"></div>
                    </div>
                </div>
                <div style="text-align: center; color: var(--text-muted); font-size: var(--label-size); margin-top: var(--space-lg);">
                    <p>Processando dados financeiros...</p>
                    <p style="font-size: var(--small-size); margin-top: var(--space-sm);">Isso pode levar alguns segundos</p>
                </div>
            `;

               let progress = 0;
               const interval = setInterval(() => {
                   progress += Math.random() * 20;
                   if (progress >= 100) {
                       progress = 100;
                       clearInterval(interval);
                       setTimeout(() => {
                           alert(
                               'Relatório gerado com sucesso!\n\nO relatório foi salvo e está disponível na lista de relatórios recentes.'
                           );
                           closeModal('modal-gerar');
                           location.reload();
                       }, 500);
                   }
                   document.getElementById('progress-fill').style.width = progress + '%';
                   document.getElementById('progress-percent').textContent = Math.round(progress) + '%';
               }, 300);
           }

           function exportarRelatorio() {
               alert('Relatório exportado com sucesso!\n\nFormato: PDF\nArquivo: relatorio-financeiro-agosto-2026.pdf');
               closeModal('modal-exportar');
           }

           function salvarAgendamento() {
               alert('Agendamento salvo com sucesso!\n\nO relatório será gerado automaticamente conforme configurado.');
               closeModal('modal-agendar');
           }

           function confirmDelete(message) {
               if (confirm(message || 'Tem certeza que deseja excluir este item?')) {
                   showToast('Item removido com sucesso!', 'success');
               }
           }

           function showToast(message, type) {
               const toast = document.createElement('div');
               toast.style.cssText =
                   'position:fixed;bottom:20px;right:20px;padding:12px 24px;border-radius:8px;color:white;font-weight:600;z-index:9999;animation:fadeIn 0.3s ease;';
               toast.style.background = type === 'success' ? '#059669' : type === 'error' ? '#DC2626' : '#D97706';
               toast.textContent = message;
               document.body.appendChild(toast);
               setTimeout(() => toast.remove(), 3000);
           }
       </script>
   @endsection
