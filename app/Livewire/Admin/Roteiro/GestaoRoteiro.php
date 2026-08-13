<?php

namespace App\Livewire\Admin\Roteiro;

use App\Models\RoteiroLeiturista;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GestaoRoteiro extends Component
{

    use WithPagination;

    // ============ FILTROS ============
    public string $busca = '';
    public string $filtroStatus = '';
    public string $filtroZona = '';
    public string $filtroMes = '';
    public int $abaAtiva = 1;


    // ============ PAGINAÇÃO ============
    public int $perPage = 6;

    // ============ LISTAS ============
    public array $zonas = [
        'Zona Norte' => 'Zona Norte',
        'Zona Sul' => 'Zona Sul',
        'Zona Leste' => 'Zona Leste',
        'Zona Oeste' => 'Zona Oeste',
        'Centro' => 'Centro',
    ];

    public array $statusList = [
        'pendente' => 'Pendente',
        'em_andamento' => 'Em Andamento',
        'concluido' => 'Concluido',
        'cancelado' => 'Cancelado',
    ];

    // protected $queryString = ['busca', 'filtroStatus', 'filtroZona', 'filtroMes', 'abaAtiva'];

    public function stepsTabs($id)
    {
        $this->abaAtiva = $id;
        // dd($id);
    }
    // ============ COMPUTED: ROTEIROS AGRUPADOS ============
    // public function getRoteirosAgrupadosProperty()
    // {
    //     $query = RoteiroLeiturista::query()
    //         ->with(['user', 'cliente'])
    //         ->select(
    //             'Zona',
    //             'data_referente',
    //             'user_id',
    //             'status',
    //             'data_inicio',
    //             'data_fim',
    //             DB::raw('COUNT(*) as total_medidores'),
    //             DB::raw('SUM(CASE WHEN lido_em IS NOT NULL THEN 1 ELSE 0 END) as concluidos'),
    //             DB::raw('SUM(CASE WHEN leitura_atual IS NULL AND lido_em IS NULL THEN 1 ELSE 0 END) as pendentes'),
    //             DB::raw('SUM(CASE WHEN observacoes IS NOT NULL AND lido_em IS NOT NULL THEN 1 ELSE 0 END) as anomalias'),
    //             DB::raw('MAX(updated_at) as ultima_atualizacao')
    //         )
    //         ->groupBy('Zona', 'data_referente', 'user_id', 'status', 'data_inicio', 'data_fim');

    //     // Filtros
    //     if ($this->busca) {
    //         $query->whereHas('user', function ($q) {
    //             $q->where('name', 'like', '%' . $this->busca . '%');
    //         })->orWhere('Zona', 'like', '%' . $this->busca . '%');
    //     }

    //     if ($this->filtroStatus) {
    //         $query->where('status', $this->filtroStatus);
    //     }

    //     if ($this->filtroZona) {
    //         $query->where('Zona', $this->filtroZona);
    //     }

    //     if ($this->filtroMes) {
    //         $query->whereMonth('data_referente', substr($this->filtroMes, 5, 2))
    //             ->whereYear('data_referente', substr($this->filtroMes, 0, 4));
    //     }

    //     // Aba
    //     if ($this->abaAtiva === 'ativos') {
    //         $query->whereIn('status', ['pendente', 'em_andamento']);
    //     } elseif ($this->abaAtiva === 'historico') {
    //         $query->whereIn('status', ['concluido', 'cancelado']);
    //     }

    //     return $query->orderBy('data_referente', 'desc')
    //         ->orderBy('Zona')
    //         ->paginate($this->perPage);
    // }
    public function getRoteirosAgrupadosProperty()
    {
        $query = RoteiroLeiturista::query()

            ->with(['user', 'cliente'])

            ->select(
                'Zona',
                'data_referente',
                'user_id',

                DB::raw('COUNT(*) as total_medidores'),

                DB::raw('SUM(
                CASE
                    WHEN lido_em IS NOT NULL
                    THEN 1
                    ELSE 0
                END
            ) as concluidos'),

                DB::raw('SUM(
                CASE
                    WHEN leitura_atual IS NULL
                    AND lido_em IS NULL
                    THEN 1
                    ELSE 0
                END
            ) as pendentes'),

                DB::raw('SUM(
                CASE
                    WHEN observacoes IS NOT NULL
                    AND lido_em IS NOT NULL
                    THEN 1
                    ELSE 0
                END
            ) as anomalias'),

                DB::raw('MAX(updated_at) as ultima_atualizacao')
            )

            ->groupBy(
                'Zona',
                'data_referente',
                'user_id'
            );

        // =========================
        // BUSCA
        // =========================

        if ($this->busca) {

            $query->where(function ($sub) {

                $sub->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->busca . '%');
                })

                    ->orWhere('Zona', 'like', '%' . $this->busca . '%');
            });
        }

        // =========================
        // FILTROS
        // =========================

        if ($this->filtroStatus) {
            $query->where('status', $this->filtroStatus);
        }

        if ($this->filtroZona) {
            $query->where('Zona', $this->filtroZona);
        }

        if ($this->filtroMes) {

            $query->whereMonth(
                'data_referente',
                substr($this->filtroMes, 5, 2)
            )

                ->whereYear(
                    'data_referente',
                    substr($this->filtroMes, 0, 4)
                );
        }

        // =========================
        // ABAS
        // =========================

        if ($this->abaAtiva === 'ativos') {

            $query->whereIn('status', [
                'pendente',
                'em_andamento'
            ]);
        } elseif ($this->abaAtiva === 'historico') {

            $query->whereIn('status', [
                'concluido',
                'cancelado'
            ]);
        }

        return $query
            ->orderByDesc('data_referente')
            ->orderBy('Zona')
            ->paginate($this->perPage);
    }
    // ============ COMPUTED: LEITURISTAS ============
    public function getLeituristasProperty()
    {
        return User::role('Leiturista')
            ->withCount(['roteiros' => function ($q) {
                $q->whereIn('status', ['Pendente', 'em_andamento']);
            }])
            ->withCount('roteiros as total_medidores')
            ->get()
            ->map(function ($user) {
                $user->zonas_atribuidas = RoteiroLeiturista::where('user_id', $user->id)
                    // ->whereIn('status', ['Pendente', 'em_andamento'])
                    ->distinct()
                    ->pluck('Zona')
                    ->toArray();

                $user->roteiros_ativos = RoteiroLeiturista::where('user_id', $user->id)
                    // ->whereIn('status', ['Pendente', 'em_andamento'])
                    ->select('Zona', 'data_referente', 'status')
                    ->selectRaw('COUNT(*) as total')
                    ->selectRaw('SUM(CASE WHEN lido_em IS NOT NULL THEN 1 ELSE 0 END) as feitos')
                    ->groupBy('Zona', 'data_referente', 'status')
                    ->get();

                return $user;
            });
    }

    // ============ COMPUTED: ZONAS ============
    public function getZonasResumoProperty()
    {
        return collect($this->zonas)->map(function ($nome, $chave) {
            $stats = RoteiroLeiturista::where('Zona', $chave)
                ->selectRaw('COUNT(*) as total')
                ->selectRaw('SUM(CASE WHEN lido_em IS NOT NULL THEN 1 ELSE 0 END) as concluidos')
                ->selectRaw('SUM(CASE WHEN leitura_atual IS NULL AND lido_em IS NULL THEN 1 ELSE 0 END) as Pendentes')
                ->selectRaw('SUM(CASE WHEN observacoes IS NOT NULL AND lido_em IS NOT NULL THEN 1 ELSE 0 END) as anomalias')
                ->first();

            $roteiro = RoteiroLeiturista::where('Zona', $chave)
                // ->whereIn('status', ['Pendente', 'Em andamento'])
                ->with('user')
                ->latest('updated_at')
                ->first();

            return [
                'nome' => $nome,

                'total' => $stats->total ?? 0,
                'concluidos' => $stats->concluidos ?? 0,
                'pendentes' => $stats->pendentes ?? 0,
                'anomalias' => $stats->anomalias ?? 0,
                'dataRef' => $roteiro->data_referente ?? 0,
                'percentual' => $stats->total > 0 ? round(($stats->concluidos / $stats->total) * 100, 1) : 0,
                'leiturista' => $roteiro?->user,
                'periodo' => $roteiro ? Carbon::parse($roteiro->data_inicio)->format('d/m') . ' a ' . Carbon::parse($roteiro->data_fim)->format('d/m/Y') : null,
            ];
        });
    }

    // ============ COMPUTED: HISTÓRICO ============
    // public function getHistoricoProperty()
    // {
    //     return RoteiroLeiturista::query()
    //         ->with(['user', 'cliente'])
    //         ->select(
    //             'Zona',
    //             'data_referente',
    //             'user_id',
    //             'status',
    //             'data_inicio',
    //             'data_fim',
    //             DB::raw('COUNT(*) as total'),
    //             DB::raw('SUM(CASE WHEN lido_em IS NOT NULL THEN 1 ELSE 0 END) as Concluido'),
    //             DB::raw('SUM(CASE WHEN observacoes IS NOT NULL AND lido_em IS NOT NULL THEN 1 ELSE 0 END) as anomalias')
    //         )
    //         ->whereIn('status', ['concluido', 'cancelado'])
    //         ->groupBy('Zona', 'data_referente', 'user_id', 'status', 'data_inicio', 'data_fim')
    //         ->orderBy('data_referente', 'desc')
    //         ->paginate(6, pageName: 'historicoPage');
    // }

    public function getHistoricoProperty()
    {
        return RoteiroLeiturista::query()
            ->with(['user']) // Removido 'cliente' pois no agrupamento de histórico não faz sentido carregar o modelo cliente individual
            ->select([
                'Zona',
                'data_referente',
                'user_id',
                // Usamos MAX ou MIN para trazer o status, ou avaliamos o status geral do grupo
                DB::raw('MAX(status) as status'),
                DB::raw('MIN(data_inicio) as data_inicio'),
                DB::raw('MAX(data_fim) as data_fim'),

                // Conta absolutamente TODOS os clientes designados para este roteiro
                DB::raw('COUNT(*) as total'),

                // Conta quantos foram efetivamente lidos
                DB::raw('SUM(CASE WHEN lido_em IS NOT NULL THEN 1 ELSE 0 END) as Concluido'),

                // Conta quantos estão pendentes no total deste grupo
                DB::raw('SUM(CASE WHEN lido_em IS NULL AND status = "pendente" THEN 1 ELSE 0 END) as total_pendentes'),

                // Anomalias
                DB::raw('SUM(CASE WHEN observacoes IS NOT NULL AND lido_em IS NOT NULL THEN 1 ELSE 0 END) as anomalias')
            ])
            // Agrupamos estritamente pela chave que define um roteiro único
            ->groupBy('Zona', 'data_referente', 'user_id')

            // FILTRO CRUCIAL: Só exibe no histórico se o total de pendentes for igual a zero
            ->having(DB::raw('SUM(CASE WHEN lido_em IS NULL AND status = "pendente" THEN 1 ELSE 0 END)'), '=', 0)

            ->orderBy('data_referente', 'desc')
            ->paginate(6, pageName: 'historicoPage');
    }
    // ============ MÉTODOS ============
    public function setAba(string $aba): void
    {
        $this->abaAtiva = $aba;
        $this->resetPage();
    }

    public function updatedBusca(): void
    {
        $this->resetPage();
    }

    public function updatedFiltroStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFiltroZona(): void
    {
        $this->resetPage();
    }

    public function updatedFiltroMes(): void
    {
        $this->resetPage();
    }

    public function exportar(): void
    {
        $this->dispatch('notify', ['type' => 'info', 'message' => 'Exportação iniciada...']);
    }
    public function render()
    {

        // dd($this->leituristas);
        // dd($this->leituristas);
        // $leiturista->zonas_atribuidas
        return view('livewire.admin.roteiro.gestao-roteiro');
    }
}
