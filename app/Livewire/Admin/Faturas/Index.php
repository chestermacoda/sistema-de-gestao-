<?php

namespace App\Livewire\Admin\Faturas;

use App\Models\Faturas;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public array $stats = [];

    public function mount(): void
    {
        $this->calcularStats();
    }

    #[On('fatura-criada')]
    #[On('atualizar-lista-faturas')]
    public function calcularStats(): void
    {
        // $mesAtual = now()->format('m/Y');
        $mesAtual = Carbon::now()->month;
        $mesAnterior = Carbon::now()->subMonth()->month;
        // $mesAnterior = $this->mesAnterior($mesAtual);

        // Emitidas no mês
        $emitidasMes = Faturas::whereMonth('periodo_inicio', $mesAtual)->count();

        $emitidasMesAnt = Faturas::whereMonth('periodo_inicio', $mesAnterior)->count();
        // dd($emitidasMesAnt);
        $varEmitidas = $this->variacao($emitidasMesAnt, $emitidasMes);

        // Pagas no mês
        $pagasMes = Faturas::whereMonth('periodo_inicio', $mesAtual)
            ->whereIn('status', ['Pago', 'Parcial'])->count();


        $percQuitacao = $emitidasMes > 0 ? round(($pagasMes / $emitidasMes) * 100, 1) : 0;


        // Pendentes (total geral)
        $pendentes = Faturas::whereIn('status', ['Pendente'])->count();
        $totalFaturas = Faturas::count();
        $percPendentes = $totalFaturas > 0 ? round(($pendentes / $totalFaturas) * 100, 1) : 0;


        // Atrasadas (Vencidas)
        $atrasadas = Faturas::where('status', 'Vencida')->count();
        $percAtraso = $totalFaturas > 0 ? round(($atrasadas / $totalFaturas) * 100, 1) : 0;

        $this->stats = [
            'emitidas' => [
                'valor' => number_format($emitidasMes, 0, ',', '.'),
                'variacao' => abs($varEmitidas),
                'tendencia' => $varEmitidas >= 0 ? 'positive' : 'negative',
                'texto' => ($varEmitidas >= 0 ? '+' : '-') . abs($varEmitidas) . '% vs mês anterior',
            ],
            'pagas' => [
                'valor' => number_format($pagasMes, 0, ',', '.'),
                'texto' => $percQuitacao . '% de quitação',
            ],
            'pendentes' => [
                'valor' => number_format($pendentes, 0, ',', '.'),
                'texto' => $percPendentes . '% do total',
            ],
            'atrasadas' => [
                'valor' => number_format($atrasadas, 0, ',', '.'),
                'texto' => $percAtraso . '% do total',
            ],
        ];
    }

    private function mesAnterior(int $mesAtual): int
    {
        // return $mesAtual === 1 ? 12 : $mesAtual - 1;
        return Carbon::now()->subMonth()->month;
    }
    private function variacao(float $ant, float $atual): float
    {
        if ($ant == 0) return $atual > 0 ? 100 : 0;
        return round((($atual - $ant) / $ant) * 100, 1);
    }
    public function render()
    {
        return view('Livewire.admin.Faturas.Index');
    }
}
