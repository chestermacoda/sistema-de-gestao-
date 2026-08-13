<?php

namespace App\Livewire\Admin\Faturas;

use App\Models\Cliente;
use App\Models\Faturas;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowFaturas extends Component
{
    use WithPagination;

    // Filtros
    public string $busca = '';
    public string $statusFiltro = '';
    public string $mesFiltro = '';
    public string $zonaFiltro = '';

    // Tab ativa
    public string $tabAtiva = 'todas';

    // Paginação
    protected int $porPagina = 6;

    public function mount()
    {
        $this->verificarStatusFatura();
    }

    public function verificarStatusFatura()
    {

        $tipoNegociacao = null;

        // $clientes = Cliente::where('status', 'ativo')->get();

        // $faturas = [];
        // foreach ($clientes as $cliente) {
        //     $faturas = Faturas::whereIn('status', ['Pendente', 'Pago', 'Parcial', 'Vencida', 'Negociada'])
        //         ->where('cliente_id', $cliente->id)
        //         ->whereMonth('mes_referencia', Carbon::now()->month)
        //         ->get();
        // }
        // // dd($faturas);

        // var_dump($faturas);

        $faturas = Faturas::where('status', 'Pendente')
            ->whereMonth('mes_referencia', '<', Carbon::now()->month)
            ->get();


        foreach ($faturas as $fatura) {
            $calculo = app(NegociarFatura::class)->calcularTarifasAtualizadas($fatura, $tipoNegociacao);
            // $fatura->status = 'Vencida';
            $fatura->update([
                'status' => 'Vencida',
                'multa' => $calculo['multa'],
                'valor_total' => $calculo['valor_total'],
                'observacoes' => ($fatura->observacoes ? $fatura->observacoes . "\n" : '')
                    . "Vencida Em" . now()->format('d/m/Y') . ". "
                    . "Valor final: MZN " . number_format($calculo['valor_total'], 2, ',', '.'),
            ]);
        }
    }


    // Escuta evento de nova fatura
    #[On('fatura-criada')]
    public function atualizar(): void
    {
        $this->resetPage();
    }

    /**
     * Quando muda a tab, reseta filtros de status
     */
    public function updatedTabAtiva(): void
    {
        $this->statusFiltro = '';
        $this->resetPage();
    }

    /**
     * Reseta todos os filtros
     */
    public function limparFiltros(): void
    {
        $this->reset(['busca', 'statusFiltro', 'mesFiltro', 'zonaFiltro', 'tabAtiva']);
        $this->tabAtiva = 'todas';
    }

    /**
     * Query principal das faturas
     */
    public function getFaturasProperty()
    {
        $query = Faturas::with(['cliente', 'leitura']);
        // ->whereMonth('mes_referencia', Carbon::now()->month);
        // Filtro por tab
        $query->when($this->tabAtiva !== 'todas', function ($q) {
            $statusMap = [
                'pagas' => ['Pago', 'Parcial'],
                'pendentes' => ['Pendente'],
                'atrasadas' => ['Vencida'],
            ];
            if (isset($statusMap[$this->tabAtiva])) {
                $q->whereIn('status', $statusMap[$this->tabAtiva]);
            }
        });

        // Filtro por status no select
        $query->when($this->statusFiltro, function ($q) {
            $map = [
                'Paga' => ['Pago', 'Parcial'],
                'Pendente' => ['Pendente'],
                'Em Atraso' => ['Vencida'],
                'Cancelada' => ['Cancelada'],
            ];
            if (isset($map[$this->statusFiltro])) {
                $q->whereIn('status', $map[$this->statusFiltro]);
            }
        });

        // Filtro por mês
        $query->when($this->mesFiltro && $this->mesFiltro !== 'todos', function ($q) {
            if ($this->mesFiltro === 'ultimos12') {
                $q->where('mes_referencia', '>=', now()->subMonths(12)->format('m/Y'));
            } else {
                // dd($this->mesFiltro);
                $q->where('mes_referencia', 'like', $this->mesFiltro . '%');

                // $q->whereMonth('mes_referencia', $this->mesFiltro);
            }
        });

        // Filtro por zona (via relacionamento cliente)
        $query->when($this->zonaFiltro && $this->zonaFiltro !== 'todas', function ($q) {
            $q->whereHas('cliente', function ($cq) {
                $cq->where('zona_distribuicao', $this->zonaFiltro);
            });
        });

        // Busca por texto
        $query->when($this->busca, function ($q) {
            $termo = '%' . $this->busca . '%';
            $q->where(function ($sq) use ($termo) {
                $sq->where('codigo_fatura', 'like', $termo)
                    ->orWhereHas('cliente', function ($cq) use ($termo) {
                        $cq->where('nome_completo', 'like', $termo)
                            ->orWhere('numero_matricula', 'like', $termo);
                    });
            });
        });

        return $query->latest('data_emissao')->paginate($this->porPagina);
    }

    /**
     * Barra de progresso — estatísticas da tab atual
     */
    public function getProgressoProperty(): array
    {
        $total = Faturas::count();
        if ($total === 0) return ['total' => 0, 'atual' => 0, 'percentual' => 0];

        $atual = match ($this->tabAtiva) {
            'pagas' => Faturas::whereIn('status', ['Pago', 'Parcial'])->count(),
            'pendentes' => Faturas::where('status', 'Pendente')->count(),
            'atrasadas' => Faturas::where('status', 'Vencida')->count(),
            default => $total,
        };

        return [
            'total' => $total,
            'atual' => $atual,
            'percentual' => round(($atual / $total) * 100, 1),
        ];
    }

    /**
     * Mês atual formatado
     */
    public function getMesAtualProperty(): string
    {
        return now()->format('m/Y');
    }

    /**
     * Meses para o select (últimos 12)
     */
    public function getMesesOptionsProperty(): array
    {
        $meses = [];
        for ($i = 0; $i < 12; $i++) {
            $data = now()->subMonths($i);
            $meses[] = [
                'valor' => $data->format('Y-m'),
                'label' => $data->translatedFormat('F/Y'),
            ];
        }
        return $meses;
    }
    public function render()
    {
        return view('Livewire.admin.Faturas.Show-faturas');
    }
}