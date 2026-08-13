<div wire:ignore.self>
    {{-- BARRA DE FILTROS --}}
    <div class="card" style="padding: var(--space-md) var(--space-lg); margin-bottom: var(--space-lg);">
        <div style="display: flex; gap: var(--space-md); align-items: center; flex-wrap: wrap;">
            <div style="position: relative; flex: 1; min-width: 250px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" class="form-input" placeholder="Buscar por leiturista, zona, roteiro..."
                    style="padding-left: 2.5rem;" wire:model.live.debounce.300ms="busca">
            </div>
            <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="filtroStatus">
                <option value="">Todos os Status</option>
                @foreach ($statusList as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="filtroZona">
                <option value="">Todas as Zonas</option>
                @foreach ($zonas as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            <select class="form-select" style="width: auto; min-width: 160px;" wire:model.live="filtroMes">
                <option value="">Todos os Meses</option>
                @php
                    $meses = [];
                    for ($i = 0; $i < 12; $i++) {
                        $data = now()->subMonths($i);
                        $meses[$data->format('Y-m')] = $data->translatedFormat('F/Y');
                    }
                @endphp
                @foreach ($meses as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline btn-sm" wire:click="exportar">
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

    {{-- TABS --}}
    {{-- <div class="tabs" style="margin-bottom: var(--space-lg);">
        <button class="tab @if ($abaAtiva === 'ativos') active @endif" wire:click="setAba('ativos')">Roteiros
            Ativos</button>
        <button class="tab @if ($abaAtiva === 'historico') active @endif"
            wire:click="setAba('historico')">Histórico</button>
        <button class="tab @if ($abaAtiva === 'leituristas') active @endif"
            wire:click="setAba('leituristas')">Leituristas</button>
        <button class="tab @if ($abaAtiva === 'zonas') active @endif" wire:click="setAba('zonas')">Zonas</button>
    </div> --}}

    <div class="tabs" style="margin-bottom: var(--space-lg);">
        <button class="tab  @if ($abaAtiva == 1) active @else @endif" wire:click="stepsTabs(1)"
            onclick="switchTabRoteiro(this, 'tab-ativos')">
            Roteiros Ativos
        </button>

        <button class="tab  @if ($abaAtiva == 2) active @endif" wire:click="stepsTabs(2)"
            onclick="switchTabRoteiro(this, 'tab-historico')">
            Histórico
        </button>

        <button class="tab @if ($abaAtiva == 3) active @endif" wire:click="stepsTabs(3)"
            onclick="switchTabRoteiro(this, 'tab-leituristas')">
            Leituristas
        </button>

        <button class="tab @if ($abaAtiva == 4) active @endif" wire:click="stepsTabs(4)"
            onclick="switchTabRoteiro(this, 'tab-zonas')">
            Zonas
        </button>
    </div>

    {{-- TAB: ROTEIROS ATIVOS --}}
    <div id="tab-ativos" class="tab-content-roteiro"
        @if ($abaAtiva == 1) style="display: block;" @else style="display: none;" @endif>
        <div class="rot-grid" style="margin-bottom: var(--space-xl);">

            @forelse($this->roteirosAgrupados as $roteiro)
                @php
                    $percentual =
                        $roteiro->total_medidores > 0
                            ? round(($roteiro->concluidos / $roteiro->total_medidores) * 100, 1)
                            : 0;
                    $classeStatus = match ($roteiro->status) {
                        'em_andamento' => 'rot-andamento',
                        'pendente' => 'rot-pendente',
                        'concluido' => 'rot-concluido',
                        'cancelado' => 'rot-cancelado',
                        default => 'rot-pendente',
                    };
                    $corStatus = match ($roteiro->status) {
                        'em_andamento' => 'var(--primary)',
                        'pendente' => 'var(--warning)',
                        'concluido' => 'var(--success)',
                        'cancelado' => 'var(--danger)',
                        default => 'var(--warning)',
                    };
                    $bgStatus = match ($roteiro->status) {
                        'em_andamento' => 'var(--primary-light)',
                        'pendente' => 'var(--warning-light)',
                        'concluido' => 'var(--success-light)',
                        'cancelado' => 'var(--danger-light)',
                        default => 'var(--warning-light)',
                    };
                    $nomeStatus = $statusList[$roteiro->status] ?? $roteiro->status;
                    $restam = $roteiro->total_medidores - $roteiro->concluidos;
                @endphp

                <div class="rot-card {{ $classeStatus }}">
                    <div class="rot-card-header">
                        <div>
                            <div class="rot-titulo">Roteiro {{ $roteiro->Zona }} —
                                {{ \Carbon\Carbon::parse($roteiro->data_referente)->format('m/Y') }}</div>
                            <div class="rot-subtitulo">{{ $roteiro->total_medidores }} medidores —
                                {{ $roteiro->user?->name ?? 'N/A' }}</div>
                        </div>
                        <span class="rot-status-badge {{ $classeStatus }}">● {{ $nomeStatus }}</span>
                    </div>
                    <div class="rot-body">
                        <div class="rot-info-row">
                            <span class="rot-info-label">Leiturista</span>
                            <span class="rot-info-value">{{ $roteiro->user?->name ?? 'N/A' }} —
                                MAT-{{ str_pad($roteiro->user_id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="rot-info-row">
                            <span class="rot-info-label">Zona</span>
                            <span class="rot-info-value">{{ $roteiro->Zona }}</span>
                        </div>
                        <div class="rot-info-row">
                            <span class="rot-info-label">Período</span>
                            <span
                                class="rot-info-value">{{ \Carbon\Carbon::parse($roteiro->data_inicio)->format('d/m') }}
                                a {{ \Carbon\Carbon::parse($roteiro->data_fim)->format('d/m/Y') }}</span>
                        </div>
                        <div class="rot-info-row">
                            <span class="rot-info-label">Mês Ref.</span>
                            <span
                                class="rot-info-value">{{ \Carbon\Carbon::parse($roteiro->data_referente)->format('F/Y') }}</span>
                        </div>
                        <div class="rot-progress-box" style="background: {{ $bgStatus }};">
                            <div style="display: flex; justify-content: space-between; margin-bottom: var(--space-sm);">
                                <span
                                    style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary);">Progresso</span>
                                <span
                                    style="font-size: var(--label-size); font-weight: 700; color: {{ $corStatus }};">{{ $roteiro->concluidos }}
                                    / {{ $roteiro->total_medidores }}</span>
                            </div>
                            <div class="rot-progress-bar">
                                <div class="rot-progress-fill"
                                    style="width: {{ $percentual }}%; background: {{ $corStatus }};"></div>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-top: 4px;">
                                <span
                                    style="font-size: var(--small-size); color: var(--text-muted);">{{ $percentual }}%
                                    concluído</span>
                                <span
                                    style="font-size: var(--small-size); color: {{ $corStatus }};">{{ $restam }}
                                    pendentes</span>
                            </div>
                        </div>
                        <div class="rot-stats-mini">
                            <div class="rot-stat-mini">
                                <div class="rot-stat-mini-valor" style="color: var(--success);">
                                    {{ $roteiro->concluidos }}
                                </div>
                                <div class="rot-stat-mini-label">OK</div>
                            </div>
                            <div class="rot-stat-mini">
                                <div class="rot-stat-mini-valor" style="color: var(--warning);">
                                    {{ $roteiro->pendentes }}
                                </div>
                                <div class="rot-stat-mini-label">Pend.</div>
                            </div>
                            <div class="rot-stat-mini">
                                <div class="rot-stat-mini-valor" style="color: var(--danger);">
                                    {{ $roteiro->anomalias }}
                                </div>
                                <div class="rot-stat-mini-label">Anom.</div>
                            </div>
                            <div class="rot-stat-mini">
                                <div class="rot-stat-mini-valor" style="color: var(--tertiary);">{{ $restam }}
                                </div>
                                <div class="rot-stat-mini-label">Rest.</div>
                            </div>
                        </div>
                    </div>
                    <div class="rot-footer">
                        <span class="rot-data">Última atualização:
                            {{ \Carbon\Carbon::parse($roteiro->ultima_atualizacao)->format('d/m H:i') }}</span>
                        <div style="display: flex; gap: var(--space-xs);">



                            <button class="btn btn-sm btn-ghost"
                                wire:click="$dispatch('preview-roteiro', {
                                userId: '{{ $roteiro->user_id }}',
                                dataReferente: '{{ $roteiro->data_referente }}',
                                zona: '{{ $roteiro->Zona }}'
                            })"
                                title="Pré-visualizar">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                            <button class="btn btn-sm btn-ghost" onclick="openModal('modal-editar-roteiro')"
                                title="Editar">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                </svg>
                            </button>
                            <button class="btn btn-sm btn-ghost" onclick="openModal('modal-rastrear')"
                                title="Rastrear">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    style="grid-column: 1 / -1; text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" style="margin-bottom: var(--space-md); opacity: 0.5;">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
                        <rect x="9" y="3" width="6" height="4" rx="2" />
                        <path d="M9 14h.01" />
                        <path d="M12 14h.01" />
                        <path d="M15 14h.01" />
                    </svg>
                    <p style="font-weight: 500;">Nenhum roteiro encontrado</p>
                    <p style="font-size: var(--small-size);">Ajuste os filtros ou crie um novo roteiro.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINAÇÃO ROTEIROS ATIVOS --}}
        @if ($this->roteirosAgrupados->hasPages())
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-xl);">
                <span style="font-size: var(--small-size); color: var(--text-muted);">
                    Página {{ $this->roteirosAgrupados->currentPage() }} de {{ $this->roteirosAgrupados->lastPage() }}
                </span>
                <div style="display: flex; gap: var(--space-xs);">
                    <button class="btn btn-sm btn-ghost" wire:click="previousPage"
                        @if ($this->roteirosAgrupados->onFirstPage()) disabled @endif>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    @php
                        $start = max(1, $this->roteirosAgrupados->currentPage() - 1);
                        $end = min($this->roteirosAgrupados->lastPage(), $this->roteirosAgrupados->currentPage() + 1);
                    @endphp
                    @if ($start > 1)
                        <button class="btn btn-sm btn-ghost" style="min-width: 32px; justify-content: center;"
                            wire:click="gotoPage(1)">1</button>
                        @if ($start > 2)
                            <span
                                style="display: flex; align-items: center; padding: 0 var(--space-sm); color: var(--text-muted);">...</span>
                        @endif
                    @endif
                    @for ($i = $start; $i <= $end; $i++)
                        <button class="btn btn-sm @if ($i === $this->roteirosAgrupados->currentPage()) btn-primary @else btn-ghost @endif"
                            style="min-width: 32px; justify-content: center;"
                            wire:click="gotoPage({{ $i }})">{{ $i }}</button>
                    @endfor
                    @if ($end < $this->roteirosAgrupados->lastPage())
                        @if ($end < $this->roteirosAgrupados->lastPage() - 1)
                            <span
                                style="display: flex; align-items: center; padding: 0 var(--space-sm); color: var(--text-muted);">...</span>
                        @endif
                        <button class="btn btn-sm btn-ghost" style="min-width: 32px; justify-content: center;"
                            wire:click="gotoPage({{ $this->roteirosAgrupados->lastPage() }})">{{ $this->roteirosAgrupados->lastPage() }}</button>
                    @endif
                    <button class="btn btn-sm btn-ghost" wire:click="nextPage"
                        @if (!$this->roteirosAgrupados->hasMorePages()) disabled @endif>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- TAB: HISTÓRICO --}}
    <div id="tab-historico" class="tab-content-roteiro"
        @if ($abaAtiva == 2) style="display: block;" @else style="display: none;" @endif>
        <div class="card" style="margin-bottom: var(--space-xl);">
            <div class="card-header">
                <h3 class="card-title">Histórico de Roteiros</h3>
                <div style="display: flex; gap: var(--space-sm);">
                    <select class="form-select" style="width: auto;" wire:model.live="filtroMes">
                        <option value="">Todos os Meses</option>
                        @foreach ($meses ?? [] as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Roteiro</th>
                            <th>Zona</th>
                            <th>Leiturista</th>
                            <th>Período</th>
                            <th>Total</th>
                            <th>Concluídas</th>
                            <th>Anomalias</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->historico as $item)
                            <tr>
                                <td style="font-weight: 600;">{{ $item->Zona }} —
                                    {{ \Carbon\Carbon::parse($item->data_referente)->format('M/Y') }}</td>
                                <td>{{ $item->Zona }}</td>
                                <td>{{ $item->user?->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->data_inicio)->format('d/m') }} a
                                    {{ \Carbon\Carbon::parse($item->data_fim)->format('d/m') }}</td>
                                <td>{{ $item->total }}</td>
                                <td style="color: var(--success); font-weight: 600;">{{ $item->concluidas }}</td>
                                <td style="color: var(--danger); font-weight: 600;">{{ $item->anomalias }}</td>
                                <td><span
                                        class="badge badge-{{ $item->status === 'concluido' ? 'success' : 'danger' }}">{{ $statusList[$item->status] ?? $item->status }}</span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: var(--space-xs);">
                                        <button class="btn btn-sm btn-ghost"
                                            wire:click="$dispatch('preview-roteiro', {
                                            userId: '{{ $item->user_id }}',
                                            dataReferente: '{{ $item->data_referente }}',
                                            zona: '{{ $item->Zona }}'
                                        })">Ver</button>
                                        <button class="btn btn-sm btn-outline"
                                            onclick="duplicarRoteiro()">Duplicar</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9"
                                    style="text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                                    Nenhum roteiro no histórico.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINAÇÃO HISTÓRICO --}}
        @if ($this->historico->hasPages())
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-xl);">
                <span style="font-size: var(--small-size); color: var(--text-muted);">
                    Página {{ $this->historico->currentPage() }} de {{ $this->historico->lastPage() }}
                </span>
                <div style="display: flex; gap: var(--space-xs);">
                    <button class="btn btn-sm btn-ghost" wire:click="previousPage('historicoPage')"
                        @if ($this->historico->onFirstPage()) disabled @endif>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    @for ($i = max(1, $this->historico->currentPage() - 1); $i <= min($this->historico->lastPage(), $this->historico->currentPage() + 1); $i++)
                        <button
                            class="btn btn-sm @if ($i === $this->historico->currentPage()) btn-primary @else btn-ghost @endif"
                            style="min-width: 32px; justify-content: center;"
                            wire:click="gotoPage({{ $i }}, 'historicoPage')">{{ $i }}</button>
                    @endfor
                    <button class="btn btn-sm btn-ghost" wire:click="nextPage('historicoPage')"
                        @if (!$this->historico->hasMorePages()) disabled @endif>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- TAB: LEITURISTAS --}}
    <div id="tab-leituristas" class="tab-content-roteiro"
        @if ($abaAtiva == 3) style="display: block;" @else style="display: none;" @endif">
        <div class="rot-leituristas-grid" style="margin-bottom: var(--space-xl);">

            @forelse($this->leituristas as $leiturista)
                <div class="rot-leiturista-card">
                    <div class="rot-leiturista-header">
                        <div class="rot-leiturista-avatar"
                            style="background: linear-gradient(135deg, var(--primary), var(--primary-light));">
                            {{ collect(explode(' ', $leiturista->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->implode('') }}
                        </div>
                        <div class="rot-leiturista-info">
                            <div class="rot-leiturista-nome">{{ $leiturista->name }}</div>
                            <div class="rot-leiturista-matricula">
                                MAT-{{ str_pad($leiturista->id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                            <span class="usr-role-badge usr-leiturista">Leiturista</span>
                        </div>
                    </div>
                    <div class="rot-leiturista-body">
                        <div class="rot-leiturista-stats">
                            <div class="rot-leiturista-stat">
                                <div class="rot-leiturista-stat-valor">{{ $leiturista->roteiros_count ?? 0 }}</div>
                                <div class="rot-leiturista-stat-label">Roteiros Ativos</div>
                            </div>
                            <div class="rot-leiturista-stat">
                                <div class="rot-leiturista-stat-valor">{{ $leiturista->total_medidores_count ?? 0 }}
                                </div>
                                <div class="rot-leiturista-stat-label">Medidores</div>
                            </div>
                            <div class="rot-leiturista-stat">
                                <div class="rot-leiturista-stat-valor">{{ rand(90, 100) }}%</div>
                                <div class="rot-leiturista-stat-label">Eficiência</div>
                            </div>
                        </div>
                        <div class="rot-leiturista-zonas">
                            <div
                                style="font-size: var(--small-size); font-weight: 600; color: var(--text-secondary); margin-bottom: var(--space-sm);">
                                Zonas Atribuídas</div>
                            <div style="display: flex; flex-wrap: wrap; gap: var(--space-xs);">
                                @php
                                    $zona_add = null;
                                @endphp
                                @foreach ($leiturista->zonas_atribuidas ?? [] as $zona)
                                    @php
                                        $zona_add = $zona;
                                    @endphp
                                    <span class="badge badge-info">{{ $zona }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="rot-leiturista-roteiros">
                            <div
                                style="font-size: var(--small-size); font-weight: 600; color: var(--text-secondary); margin-bottom: var(--space-sm);">
                                Roteiros em Andamento</div>
                            <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
                                @php
                                    $dataReference = null;
                                @endphp
                                @foreach ($leiturista->roteiros_ativos ?? [] as $rot)
                                    @php
                                        $pct = $rot->total > 0 ? round(($rot->feitos / $rot->total) * 100, 1) : 0;
                                        $dataReference = $rot->data_referente;
                                    @endphp
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-sm); background: var(--neutral); border-radius: var(--radius-md);">
                                        <span style="font-size: var(--label-size);">{{ $rot->Zona }} —
                                            {{ \Carbon\Carbon::parse($rot->data_referente)->format('M/Y') }}</span>
                                        <span
                                            style="font-size: var(--small-size); color: {{ $pct >= 100 ? 'var(--success)' : 'var(--primary)' }}; font-weight: 600;">{{ $pct }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="rot-leiturista-footer">
                        <span style="font-size: var(--small-size); color: var(--text-muted);">Última leitura:
                            {{ now()->subHours(rand(1, 48))->format('d/m H:i') }}</span>
                        <button class="btn btn-sm btn-primary" {{-- onclick="openModal('modal-atribuir')" --}}
                            wire:click="$dispatch('reatribuir-roteiro', {
                                            userId: {{ $leiturista->id }},
                                            dataReferente: '{{ $dataReference }}',
                                            zona:  '{{ $zona_add }}'
                                        })">Atribuir
                            Roteiro</button>
                    </div>
                </div>
            @empty
                <div
                    style="grid-column: 1 / -1; text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                    <p style="font-weight: 500;">Nenhum leiturista encontrado</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- TAB: ZONAS --}}
    <div id="tab-zonas" class="tab-content-roteiro"
        @if ($abaAtiva == 4) style="display: block;" @else style="display: none;" @endif">
        <div class="rot-zonas-grid" style="margin-bottom: var(--space-xl);">
            @foreach ($this->zonasResumo as $zona)
                @php
                    $coresZona = [
                        'Zona Norte' => 'var(--primary)',
                        'Zona Sul' => 'var(--tertiary)',
                        'Zona Leste' => 'var(--secondary)',
                        'Zona Oeste' => 'var(--warning)',
                        'Centro' => '#7c3aed',
                    ];
                    $cor = $coresZona[$zona['nome']] ?? 'var(--primary)';
                @endphp
                <div class="rot-zona-card">
                    <div class="rot-zona-header">
                        <div class="rot-zona-icon" style="background: {{ $cor }};">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div class="rot-zona-info">
                            <div class="rot-zona-nome">{{ $zona['nome'] }}</div>
                            <div class="rot-zona-medidores">{{ $zona['total'] }} medidores</div>
                        </div>
                    </div>
                    <div class="rot-zona-body">
                        <div class="rot-zona-stats">
                            <div class="rot-zona-stat">
                                <div class="rot-zona-stat-valor" style="color: var(--success);">
                                    {{ $zona['concluidos'] }}
                                </div>
                                <div class="rot-zona-stat-label">Concluídas</div>
                            </div>
                            <div class="rot-zona-stat">
                                <div class="rot-zona-stat-valor" style="color: var(--warning);">
                                    {{ $zona['pendentes'] }}
                                </div>
                                <div class="rot-zona-stat-label">Pendentes</div>
                            </div>
                            <div class="rot-zona-stat">
                                <div class="rot-zona-stat-valor" style="color: var(--danger);">
                                    {{ $zona['anomalias'] }}
                                </div>
                                <div class="rot-zona-stat-label">Anomalias</div>
                            </div>
                        </div>
                        <div class="rot-zona-progress">
                            <div class="rot-zona-progress-bar">
                                <div class="rot-zona-progress-fill"
                                    style="width: {{ $zona['percentual'] }}%; background: {{ $zona['percentual'] >= 100 ? 'var(--success)' : $cor }};">
                                </div>
                            </div>
                            <span
                                style="font-size: var(--small-size); color: {{ $zona['percentual'] >= 100 ? 'var(--success)' : 'var(--text-muted)' }};">{{ $zona['percentual'] }}%
                                concluído</span>
                        </div>
                        <div class="rot-zona-leiturista">
                            <div
                                style="font-size: var(--small-size); font-weight: 600; color: var(--text-secondary); margin-bottom: var(--space-sm);">
                                Leiturista Responsável</div>
                            <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                <div class="rot-leiturista-avatar-sm"
                                    style="background: linear-gradient(135deg, {{ $cor }}, {{ $cor }}aa);">
                                    {{ collect(explode(' ', $zona['leiturista']?->name ?? 'N/A'))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->implode('') }}
                                </div>
                                <div>
                                    <div style="font-weight: 600; font-size: var(--label-size);">
                                        {{ $zona['leiturista']?->name ?? 'Não atribuído' }}</div>
                                    <div style="font-size: var(--small-size); color: var(--text-muted);">
                                        {{ $zona['leiturista'] ? 'MAT-' . str_pad($zona['leiturista']->id, 4, '0', STR_PAD_LEFT) : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rot-zona-footer">
                        <span style="font-size: var(--small-size); color: var(--text-muted);">Período:
                            {{ $zona['periodo'] ?? 'Não definido' }}</span>
                        <button class="btn btn-sm btn-primary"
                            wire:click="$dispatch('visualizar-Zona', {
                                            userId: {{ $zona['leiturista']?->id }},
                                            dataReferente: '{{ $zona['dataRef'] }}',
                                            zona: '{{ $zona['nome'] }}'
                                        })">Visualizar</button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAGINAÇÃO ZONAS --}}
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-xl);">
            <span style="font-size: var(--small-size); color: var(--text-muted);">Página 1 de 1</span>
            <div style="display: flex; gap: var(--space-xs);">
                <button class="btn btn-sm btn-ghost" disabled>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </button>
                <button class="btn btn-sm btn-primary" style="min-width: 32px; justify-content: center;">1</button>
                <button class="btn btn-sm btn-ghost" disabled>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

</div>
