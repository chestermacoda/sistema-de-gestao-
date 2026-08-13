<?php

namespace App\Livewire\Admin\Leituras;

use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\Cliente;
use App\Models\User;
use App\Services\Leituristas;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class ShowLeituras extends Component
{
    use WithPagination;

    // ========== FILTROS ==========
    public string $search = '';
    public string $statusFilter = '';
    public string $mesFilter = '';
    public string $leituristaFilter = '';

    // ========== TAB ==========
    public string $tabAtiva = 'todas';

    protected string $paginationTheme = 'tailwind';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'mesFilter' => ['except' => ''],
        'leituristaFilter' => ['except' => ''],
        'tabAtiva' => ['except' => 'todas'],
    ];

    public function mount(): void
    {
        if (empty($this->mesFilter)) {
            $this->mesFilter = Carbon::now()->format('Y-m');
        }
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'statusFilter', 'mesFilter', 'leituristaFilter', 'tabAtiva'])) {
            $this->resetPage();
        }
    }

    public function setTab(string $tab): void
    {
        $this->tabAtiva = $tab;
        $this->resetPage();
    }

    #[On('reload-leituras')]
    public function refreshComponent() {}
    // ========== QUERY UNIFICADA - TODOS OS REGISTROS DO MÊS ==========

    /**
     * Retorna TODOS os registros do mês: leituras feitas + pendentes
     * CORRIGIDO: agora unifica leituras registradas com medidores pendentes
     */
    #[Computed]
    public function todosRegistrosMes(): Collection
    {
        $mesReferencia = $this->mesFilter;

        // 1. Busca todas as leituras já registradas no mês
        $leiturasQuery = Leituras::query()
            ->with(['medidor.cliente', 'leiturista'])
            // ->where('mes_referencia', $mesReferencia)
            ->where('mes_referencia', 'like', '%' . $mesReferencia . '%')
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->whereHas('medidor', function ($mq) {
                        $mq->where('numero_hidrometro', 'like', '%' . $this->search . '%');
                    })
                        ->orWhereHas('medidor.cliente', function ($cq) {
                            $cq->where('nome_completo', 'like', '%' . $this->search . '%')
                                ->orWhere('numero_matricula', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('leiturista', function ($lq) {
                            $lq->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->leituristaFilter, function ($q) {
                $q->where('user_id', $this->leituristaFilter);
            });

        $leituras = $leiturasQuery->get();

        // 2. Busca medidores instalados que NÃO têm leitura no mês (PENDENTES)
        $medidoresPendentes = Medidores::where('status_inicial', 'instalado')
            ->whereNotNull('cliente_id')
            ->whereDoesntHave('leituras', function ($q) use ($mesReferencia) {
                $q->where('mes_referencia', $mesReferencia);
            })
            ->with(['cliente', 'ultimaLeitura'])
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('numero_hidrometro', 'like', '%' . $this->search . '%')
                        ->orWhereHas('cliente', function ($cq) {
                            $cq->where('nome_completo', 'like', '%' . $this->search . '%')
                                ->orWhere('numero_matricula', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->get();

        // 3. Combina tudo em uma coleção única
        $registros = $leituras->map(function ($leitura) {
            return [
                'tipo' => 'leitura',
                'dados' => $leitura,
                'id' => 'L-' . $leitura->id,
            ];
        });

        $pendentes = $medidoresPendentes->map(function ($medidor) use ($mesReferencia) {
            return [
                'tipo' => 'pendente',
                'dados' => $medidor,
                'id' => 'P-' . $medidor->id,
                'mes_referencia' => $mesReferencia,
            ];
        });

        // 4. Junta e ordena (pendentes primeiro ou por data)
        $todos = $registros->concat($pendentes);

        // Ordena: pendentes primeiro, depois por data da leitura (mais recente)
        return $todos->sortByDesc(function ($item) {
            if ($item['tipo'] === 'pendente') {
                return '9999-99-99'; // Pendentes no topo
            }
            return $item['dados']->data_leitura?->format('Y-m-d') ?? '0000-00-00';
        })->values();
    }

    // ========== FILTRO POR TAB ==========

    /**
     * Aplica filtro da tab sobre a coleção unificada
     */
    #[Computed]
    public function registrosFiltrados(): Collection
    {
        $todos = $this->todosRegistrosMes;

        return match ($this->tabAtiva) {
            'ok' => $todos->filter(function ($item) {
                return $item['tipo'] === 'leitura'
                    && $item['dados']->status === 'validada'
                    && !$item['dados']->tem_anomalia;
            }),

            'pendente' => $todos->filter(function ($item) {
                return $item['tipo'] === 'pendente';
            }),

            'anomalias' => $todos->filter(function ($item) {
                if ($item['tipo'] !== 'leitura') return false;
                return $item['dados']->tem_anomalia
                    || $item['dados']->status === 'anomalia';
            }),

            default => $todos, // 'todas' - retorna tudo
        };
    }

    // ========== PAGINAÇÃO MANUAL DA COLEÇÃO ==========

    #[Computed]
    public function registrosPaginados()
    {
        $pagina = $this->getPage();
        $porPagina = 6;
        $itens = $this->registrosFiltrados;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $itens->forPage($pagina, $porPagina),
            $itens->count(),
            $porPagina,
            $pagina,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    // ========== HELPERS DE EXIBIÇÃO ==========

    public function getStatusRegistro(array $item): array
    {
        if ($item['tipo'] === 'pendente') {
            return [
                'class' => 'leit-pendente',
                'badgeClass' => 'leit-pendente',
                'text' => '● Pendente',
                'label' => 'Pendente',
            ];
        }

        $leitura = $item['dados'];

        if ($leitura->tem_anomalia || $leitura->status === 'Anomalia') {
            return [
                'class' => 'leit-anomalia',
                'badgeClass' => 'leit-anomalia',
                'text' => '● Anomalia',
                'label' => 'Anomalia',
            ];
        }

        if ($leitura->status === 'Processando') {
            return [
                'class' => 'leit-processando',
                'badgeClass' => 'leit-processando',
                'text' => '● Processando',
                'label' => 'Processando',
            ];
        }

        return [
            'class' => 'leit-ok',
            'badgeClass' => 'leit-ok',
            'text' => '● OK',
            'label' => 'OK',
        ];
    }

    public function getClienteInfo(array $item): array
    {
        if ($item['tipo'] === 'pendente') {
            $medidor = $item['dados'];
            $cliente = $medidor->cliente;
            return [
                'nome' => $cliente?->nome_completo ?? '—',
                'cliente_id' => $cliente?->id ?? '—',
                'Medidor_id' => $medidor?->id ?? '—',
                'matricula' => $cliente?->numero_matricula ?? 'N/A',
                'hidrometro' => $medidor->numero_hidrometro,
            ];
        }

        $leitura = $item['dados'];
        $cliente = $leitura->medidor?->cliente;
        return [
            'nome' => $cliente?->nome_completo ?? '—',
            'idLeitura' => $leitura?->id ?? '—',
            'cliente_id' => $cliente?->id ?? '—',
            'Medidor_id' => $leitura->medidor?->id ?? '—',
            'matricula' => $cliente?->numero_matricula ?? 'N/A',
            'hidrometro' => $leitura->medidor?->numero_hidrometro ?? '—',
        ];
    }


    public function getDadosExibicao(array $item): array
    {
        $mesRef = Carbon::parse($item['mes_referencia'] ?? $this->mesFilter)->format('M/Y');

        // PENDENTE
        if ($item['tipo'] === 'pendente') {
            $medidor = $item['dados'];
            $ultima = $medidor->ultimaLeitura;

            return [
                'mes_ref' => $mesRef,
                'data_leitura' => '—',
                'leitura_atual' => null,
                'leitura_anterior' => $ultima?->leitura_atual ?? 0,
                'consumo' => null,
                'consumo_formatado' => '—',
                'media' => $this->calcularMedia($medidor->id),
                'media_formatada' => number_format($this->calcularMedia($medidor->id), 0, ',', '.'),
                'leiturista' => '— Não atribuído',
                'registrado' => 'Vencimento: ' . Carbon::parse($this->mesFilter)->endOfMonth()->format('d/m/Y'),
                'box_style' => 'background: var(--warning-light);',
                'valor_color' => 'color: var(--warning);',
                'label_color' => 'color: var(--warning);',
                // ========== BARRA DE PROGRESSO PENDENTE ==========
                'bar_width' => '0%',
                'bar_style' => 'background: var(--neutral-dark);',
                'bar_color_class' => '',
                'label_text' => 'Aguardando leitura — Anterior: ' . number_format($ultima?->leitura_atual ?? 0, 0, ',', '.'),
            ];
        }

        // LEITURA REGISTRADA
        $leitura = $item['dados'];
        $consumo = $leitura->consumo ?? ($leitura->leitura_atual - $leitura->leitura_anterior);
        $consumo = max(0, $consumo);
        $media = $leitura->consumo_medio ?? $this->calcularMedia($leitura->medidores_id);
        $media = max(1, $media); // Evita divisão por zero

        // ========== CÁLCULO DA BARRA DE PROGRESSO ==========
        // Regra: 100% = consumo igual à média
        // >100% = acima da média (amarelo/laranja/vermelho)
        // <100% = abaixo da média (verde)
        $percentual = ($consumo / $media) * 100;

        // Limita entre 0 e 200% para visualização
        $barWidth = min(100, max(0, $percentual));

        // Determina cor baseada no percentual
        $barColorClass = $this->getBarColorClass($percentual, $leitura->tem_anomalia);
        $barStyle = $this->getBarStyle($percentual, $leitura->tem_anomalia);

        if ($leitura->tem_anomalia || $leitura->status === 'anomalia') {
            $boxStyle = 'background: var(--danger-light);';
            $valorColor = 'color: var(--danger);';
            $labelColor = 'color: var(--danger);';
            $labelText = 'Consumo anormal — Anterior: ' . number_format($leitura->leitura_anterior, 0, ',', '.');
        } elseif ($leitura->status === 'Processando') {
            $boxStyle = 'background: rgba(0,131,143,0.1);';
            $valorColor = 'color: var(--tertiary);';
            $labelColor = 'color: var(--tertiary);';
            $labelText = 'Aguardando validação — Anterior: ' . number_format($leitura->leitura_anterior, 0, ',', '.');
        } else {
            $boxStyle = '';
            $valorColor = '';
            $labelColor = '';
            $labelText = 'Leitura Atual — Anterior: ' . number_format($leitura->leitura_anterior, 0, ',', '.');
        }

        return [
            'mes_ref' => $mesRef,
            'data_leitura' => $leitura->data_leitura?->format('d/m/Y') ?? '—',
            'leitura_atual' => $leitura->leitura_atual,
            'leitura_anterior' => $leitura->leitura_anterior,
            'consumo' => $consumo,
            'consumo_formatado' => number_format($consumo, 0, ',', '.'),
            'media' => $media,
            'media_formatada' => number_format($media, 0, ',', '.'),
            'leiturista' => $leitura->leiturista?->name ?? '—',
            'registrado' => 'Registrado: ' . ($leitura->data_leitura?->format('d/m') ?? '-') . ' ' . ($leitura->hora_leitura ?? ''),
            'box_style' => $boxStyle,
            'valor_color' => $valorColor,
            'label_color' => $labelColor,
            // ========== BARRA DE PROGRESSO FUNCIONAL ==========
            'bar_width' => $barWidth . '%',
            'bar_style' => $barStyle,
            'bar_color_class' => $barColorClass,
            'percentual_consumo' => round($percentual, 1),
            'label_text' => $labelText,
        ];
    }


    /**
     * Determina a cor da barra baseada no percentual de consumo vs média
     */
    private function getBarColorClass(float $percentual, bool $temAnomalia): string
    {
        if ($temAnomalia) {
            return 'bar-danger';
        }

        if ($percentual <= 50) {
            return 'bar-low'; // Verde - consumo baixo
        } elseif ($percentual <= 100) {
            return 'bar-normal'; // Azul/Primary - consumo normal
        } elseif ($percentual <= 150) {
            return 'bar-high'; // Amarelo/Laranja - acima da média
        } else {
            return 'bar-critical'; // Vermelho - muito acima
        }
    }


    public function getAcoes(array $item): array
    {
        if ($item['tipo'] === 'pendente') {
            return ['ver', 'registrar'];
        }

        return match ($item['dados']->status) {
            'validada' => ['ver', 'editar'],
            'anomalia' => ['ver', 'tratar'],
            'Processando' => ['ver', 'validar'],
            default => ['ver'],
        };
    }

    /**
     * Gera o style inline da barra com gradiente baseado no percentual
     */
    private function getBarStyle(float $percentual, bool $temAnomalia): string
    {
        if ($temAnomalia) {
            return 'background: linear-gradient(90deg, var(--danger), var(--warning));';
        }

        if ($percentual <= 50) {
            return 'background: linear-gradient(90deg, #059669, #10b981);'; // Verde
        } elseif ($percentual <= 100) {
            return 'background: linear-gradient(90deg, var(--primary), var(--primary-light));'; // Azul
        } elseif ($percentual <= 150) {
            return 'background: linear-gradient(90deg, #d97706, #f59e0b);'; // Laranja
        } else {
            return 'background: linear-gradient(90deg, #dc2626, #ef4444);'; // Vermelho
        }
    }

    private function calcularMedia(int $medidorId): float
    {
        return app(Leituristas::class)->ConsumoMedio($medidorId);
    }

    // ========== DADOS PARA FILTROS ==========

    #[Computed]
    public function leituristas()
    {
        return User::role('Leiturista')->get();
    }

    #[Computed]
    public function mesesDisponiveis(): array
    {
        $meses = [];
        $atual = Carbon::now();

        for ($i = 0; $i < 12; $i++) {
            $data = $atual->copy()->subMonths($i);
            $meses[$data->format('Y-m')] = ucfirst($data->format('F/Y'));
        }

        return $meses;
    }

    public function render()
    {
        return view('livewire.admin.leituras.show-leituras');
    }
}