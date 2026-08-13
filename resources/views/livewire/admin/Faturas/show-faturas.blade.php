 <div>
     {{-- Barra de Progresso --}}
     <div style="margin-bottom: var(--space-lg);">
         <div
             style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-sm);">
             <span style="font-size: var(--small-size); color: var(--text-muted);">
                 {{ $this->progresso['atual'] }} de {{ $this->progresso['total'] }} faturas
                 @if ($tabAtiva !== 'todas')
                     —
                     {{ match ($tabAtiva) {'pagas' => 'pagas','pendentes' => 'pendentes','atrasadas' => 'em atraso',default => ''} }}
                 @endif
             </span>
             <span style="font-size: var(--small-size); font-weight: 600; color: var(--primary);">
                 {{ $this->progresso['percentual'] }}%
             </span>
         </div>
         <div
             style="
            width: 100%; height: 8px; background: var(--neutral);
            border-radius: var(--radius-full); overflow: hidden;
        ">
             <div
                 style="
                width: {{ $this->progresso['percentual'] }}%;
                height: 100%; background: var(--primary);
                border-radius: var(--radius-full);
                transition: width 0.3s ease;
            ">
             </div>
         </div>
     </div>

     {{-- Filters Bar --}}
     <div class="card" style="padding: var(--space-md) var(--space-lg); margin-bottom: var(--space-lg);">
         <div style="display: flex; gap: var(--space-md); align-items: center; flex-wrap: wrap;">

             {{-- Busca --}}
             <div style="position: relative; flex: 1; min-width: 250px;">
                 <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2"
                     style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                     <circle cx="11" cy="11" r="8" />
                     <path d="m21 21-4.3-4.3" />
                 </svg>
                 <input type="text" class="form-input" placeholder="Buscar por número, cliente, matrícula..."
                     style="padding-left: 2.5rem;" wire:model.live.debounce.300ms="busca">
             </div>

             {{-- Filtro Status --}}
             <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="statusFiltro">
                 <option value="">Todos os Status</option>
                 <option value="Paga">Paga</option>
                 <option value="Pendente">Pendente</option>
                 <option value="Em Atraso">Em Atraso</option>
                 <option value="Cancelada">Cancelada</option>
             </select>

             {{-- Filtro Mês --}}
             <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="mesFiltro">
                 <option value="">Mês Atual</option>
                 @foreach ($this->mesesOptions as $mes)
                     <option value="{{ $mes['valor'] }}">{{ $mes['label'] }}</option>
                 @endforeach
                 <option value="ultimos12">Últimos 12 Meses</option>
             </select>

             {{-- Filtro Zona --}}
             <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="zonaFiltro">
                 <option value="todas">Todas as Zonas</option>
                 <option value="Zona Norte">Zona Norte</option>
                 <option value="Zona Sul">Zona Sul</option>
                 <option value="Zona Leste">Zona Leste</option>
                 <option value="Zona Oeste">Zona Oeste</option>
                 <option value="Centro">Centro</option>
             </select>

             {{-- Exportar --}}
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

     {{-- Tabs --}}
     <div class="tabs" style="margin-bottom: var(--space-lg);">
         <button class="tab {{ $tabAtiva === 'todas' ? 'active' : '' }}" wire:click="$set('tabAtiva', 'todas')">
             Todas as Faturas
         </button>
         <button class="tab {{ $tabAtiva === 'pagas' ? 'active' : '' }}" wire:click="$set('tabAtiva', 'pagas')">
             Pagas
         </button>
         <button class="tab {{ $tabAtiva === 'pendentes' ? 'active' : '' }}" wire:click="$set('tabAtiva', 'pendentes')">
             Pendentes
         </button>
         <button class="tab {{ $tabAtiva === 'atrasadas' ? 'active' : '' }}"
             wire:click="$set('tabAtiva', 'atrasadas')">
             Em Atraso
         </button>
     </div>

     {{-- Faturas Grid --}}
     <div class="fatura-grid" style="margin-bottom: var(--space-xl);">
         @forelse($this->faturas as $fatura)
             @php
                 $cliente = $fatura->cliente;
                 $leitura = $fatura->leitura;
                 $statusClass = match ($fatura->status) {
                     'Pago', 'Parcial' => 'paga',
                     'Pendente' => 'pendente',
                     'Vencida' => 'atrasada',
                     'Cancelada' => 'cancelada',
                     default => 'pendente',
                 };
                 $statusLabel = match ($fatura->status) {
                     'Pago', 'Parcial' => 'Paga',
                     'Pendente' => 'Pendente',
                     'Vencida' => 'Em Atraso',
                     'Cancelada' => 'Cancelada',
                     default => $fatura->status,
                 };
                 $consumoPercentual =
                     $leitura && $leitura->consumo_medio > 0
                         ? min(100, round(($leitura->consumo / $leitura->consumo_medio) * 100))
                         : 50;
             @endphp

             <div class="fatura-card {{ $statusClass }}">
                 {{-- Header --}}
                 <div class="fatura-card-header">
                     <div>
                         <div class="fatura-numero">{{ $fatura->codigo_fatura }}</div>
                         <div class="fatura-cliente">{{ $cliente?->nome_completo ?? 'Cliente não encontrado' }}</div>
                     </div>
                     <span class="fatura-status-badge {{ $statusClass }}">● {{ $statusLabel }}</span>
                 </div>

                 {{-- Body --}}
                 <div class="fatura-body">
                     <div class="fatura-info-row">
                         <span class="fatura-info-label">Matrícula</span>
                         <span class="fatura-info-value" style="font-family: monospace;">
                             {{ $cliente?->numero_matricula ?? 'N/A' }}
                         </span>
                     </div>
                     <div class="fatura-info-row">
                         <span class="fatura-info-label">Período</span>
                         <span class="fatura-info-value">
                             {{ $fatura->periodo_inicio?->format('d/m') ?? '--' }} a
                             {{ $fatura->periodo_fim?->format('d/m/Y') ?? '--' }}
                         </span>
                     </div>
                     <div class="fatura-info-row">
                         <span class="fatura-info-label">Consumo</span>
                         <span class="fatura-info-value">
                             {{ $leitura ? number_format($leitura->consumo, 0, ',', '.') : '--' }} m³
                         </span>
                     </div>
                     <div class="fatura-info-row">
                         <span class="fatura-info-label">Medidor</span>
                         <span class="fatura-info-value" style="font-family: monospace;">
                             {{ $leitura?->medidor?->numero_hidrometro ?? 'N/A' }}
                         </span>
                     </div>

                     {{-- Barra de consumo --}}
                     @if ($leitura)
                         <div class="fatura-consumo-bar">
                             <div class="fatura-consumo-fill" style="width: {{ $consumoPercentual }}%;"></div>
                         </div>
                         <div class="fatura-consumo-info">
                             <span>{{ number_format($leitura->consumo, 0, ',', '.') }} m³ consumidos</span>
                             <span>Média: {{ number_format($leitura->consumo_medio ?? 0, 0, ',', '.') }} m³</span>
                         </div>
                     @endif

                     {{-- Valor --}}
                     @php
                         $valorBoxClass = match ($fatura->status) {
                             'Pago', 'Parcial' => '',
                             'Pendente' => 'style="background: var(--warning-light);"',
                             'Vencida' => 'style="background: var(--danger-light);"',
                             'Cancelada' => 'style="background: var(--neutral-dark);"',
                             default => '',
                         };
                         $valorColor = match ($fatura->status) {
                             'Pago', 'Parcial' => '',
                             'Pendente' => 'style="color: var(--warning);"',
                             'Vencida' => 'style="color: var(--danger);"',
                             'Cancelada' => 'style="color: var(--text-muted);"',
                             default => '',
                         };
                         $valorLabelColor = match ($fatura->status) {
                             'Pago', 'Parcial' => '',
                             'Pendente' => 'style="color: var(--warning);"',
                             'Vencida' => 'style="color: var(--danger);"',
                             'Cancelada' => 'style="color: var(--text-muted);"',
                             default => '',
                         };
                     @endphp

                     <div class="fatura-valor-box" {!! $valorBoxClass !!}>
                         <div class="fatura-valor-amount" {!! $valorColor !!}>
                             MZN
                             {{ number_format($fatura->valor_consumo, 2, ',', '.') }}
                         </div>
                         <div class="fatura-valor-label" {!! $valorLabelColor !!}>
                             @if (in_array($fatura->status, ['Pago', 'Parcial']))
                                 Valor Total — Pago em {{ $fatura->updated_at?->format('d/m/Y') ?? '--' }}
                             @elseif($fatura->status === 'Pendente')
                                 Aguardando Pagamento
                             @elseif($fatura->status === 'Vencida')
                                 Vencida em {{ $fatura->data_vencimento?->format('d/m/Y') ?? '--' }}
                                 @php
                                     $diasAtraso = $fatura->data_vencimento?->isPast()
                                         ? $fatura->data_vencimento->diffInDays(now())
                                         : 0;
                                 @endphp
                                 @if ($diasAtraso > 0)
                                     — {{ $diasAtraso }} dias de atraso
                                 @endif
                             @elseif($fatura->status === 'Cancelada')
                                 Fatura Cancelada
                             @endif
                         </div>
                     </div>
                 </div>

                 {{-- Footer --}}
                 <div class="fatura-footer">
                     <span class="fatura-vencimento {{ $statusClass === 'atrasada' ? 'atrasada' : '' }}">
                         @if ($fatura->status === 'Vencida')
                             Atraso: {{ $diasAtraso ?? 0 }} dias
                         @elseif($fatura->status === 'Cancelada')
                             Cancelada em {{ $fatura->updated_at?->format('d/m/Y') ?? '--' }}
                         @else
                             Vencimento: {{ $fatura->data_vencimento?->format('d/m/Y') ?? '--' }}
                         @endif
                     </span>
                     <div style="display: flex; gap: var(--space-xs);">
                         {{-- Ver detalhes --}}
                         <button class="btn btn-sm btn-ghost"
                             wire:click="$dispatch('Open-detalheFatura',{ idFatura: {{ $fatura->id }} })"
                             title="Detalhes">
                             <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                 <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                 <circle cx="12" cy="12" r="3" />
                             </svg>
                         </button>

                         {{-- 2ª Via / Boleto (só se não cancelada) --}}
                         {{-- @if ($fatura->status !== 'Cancelada')
                             <button class="btn btn-sm btn-ghost" onclick="openModal('modal-boleto-fatura')"
                                 title="2ª Via Boleto">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <rect width="20" height="14" x="2" y="5" rx="2" />
                                     <line x1="2" x2="22" y1="10" y2="10" />
                                 </svg>
                             </button>
                         @endif --}}

                         {{-- Negociar (pendente ou atrasada) --}}
                         @if (in_array($fatura->status, ['Vencida']))
                             <button class="btn btn-sm btn-ghost"
                                 wire:click="$dispatch('Negociar-Fatura',{ idFatura: {{ $fatura->id }} })"
                                 title="Negociar">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                 </svg>
                             </button>
                         @endif

                         {{-- Cancelar (só pendente) --}}
                         {{-- @if ($fatura->status === 'Pendente')
                             <button class="btn btn-sm btn-danger" wire:click="cancelarFatura({{ $fatura->id }})"
                                 wire:confirm="Deseja cancelar esta fatura?" title="Cancelar">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <circle cx="12" cy="12" r="10" />
                                     <path d="m15 9-6 6" />
                                     <path d="m9 9 6 6" />
                                 </svg>
                             </button>
                         @endif --}}

                         @if ($fatura->valor_consumo > 0 && $leitura->consumo > 0 && in_array($fatura->status, ['Pendente', 'Vencida']))
                             <button class="btn btn-sm btn-ghost"
                                 wire:click="$dispatch('Pagar-Fatura',{ idFatura: {{ $fatura->id }} })"
                                 title="Negociar">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                 </svg>
                             </button>
                         @endif
                     </div>
                 </div>
             </div>

         @empty
             <div style="grid-column: 1 / -1; text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                 <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.5" style="margin-bottom: var(--space-md); opacity: 0.5;">
                     <rect width="20" height="14" x="2" y="5" rx="2" />
                     <line x1="2" x2="22" y1="10" y2="10" />
                 </svg>
                 <p style="font-size: var(--body-size);">Nenhuma fatura encontrada</p>
                 <p style="font-size: var(--small-size);">Tente ajustar os filtros ou criar uma nova fatura.</p>
             </div>
         @endforelse
     </div>

     {{-- Pagination --}}
     {{-- <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-xl);">
         <span style="font-size: var(--small-size); color: var(--text-muted);">
             Página {{ $this->faturas->currentPage() }} de {{ $this->faturas->lastPage() }}
             — {{ $this->faturas->total() }} registros
         </span>
         <div style="display: flex; gap: var(--space-xs);">
             {{ $this->faturas->links() }}
         </div>
     </div> --}}
     @include('admin.components.pagination', ['paginator' => $this->faturas])
     {{-- CSS da paginação Livewire (override simples) --}}
     <style>
         .fatura-grid {
             display: grid;
             grid-template-columns: repeat(3, 1fr);
             gap: var(--space-lg);
         }

         @media (max-width: 1200px) {
             .fatura-grid {
                 grid-template-columns: repeat(2, 1fr);
             }
         }

         @media (max-width: 768px) {
             .fatura-grid {
                 grid-template-columns: 1fr;
             }
         }

         /* Paginação Livewire estilizada com suas variáveis */
         nav[role="navigation"] {
             display: flex;
             gap: var(--space-xs);
         }

         nav[role="navigation"] button,
         nav[role="navigation"] a {
             padding: var(--space-xs) var(--space-sm);
             border-radius: var(--radius-md);
             border: 1px solid var(--border);
             background: white;
             color: var(--text);
             font-size: var(--small-size);
             text-decoration: none;
             cursor: pointer;
         }

         nav[role="navigation"] button:hover,
         nav[role="navigation"] a:hover {
             background: var(--neutral);
         }

         nav[role="navigation"] button[aria-current="page"],
         nav[role="navigation"] span[aria-current="page"] {
             background: var(--primary);
             color: white;
             border-color: var(--primary);
         }

         nav[role="navigation"] button:disabled {
             opacity: 0.5;
             cursor: not-allowed;
         }
     </style>
 </div>
