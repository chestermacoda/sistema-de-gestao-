<?php

namespace App\Livewire\Admin\Roteiro;

use App\Models\RoteiroLeiturista;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public function getStatsProperty()
    {
        $mesAtual = Carbon::parse($this->dataReferente ?? now());

        $inicioMes = $mesAtual->copy()->startOfMonth();
        $fimMes    = $mesAtual->copy()->endOfMonth();

        return [
            'leituristas_ativos' => User::role('leiturista')->count(),

            'leituristas_hoje' => RoteiroLeiturista::whereDate('data_referente', $mesAtual->toDateString())
                ->distinct('user_id')
                ->count(),

            'roteiros_hoje' => RoteiroLeiturista::whereDate('data_referente', $mesAtual->toDateString())
                ->count(),

            'total_roteiros' => RoteiroLeiturista::whereBetween('data_referente', [
                $inicioMes,
                $fimMes
            ])->count(),

            'concluido' => RoteiroLeiturista::where('status', 'Concluido')
                ->whereBetween('data_referente', [
                    $inicioMes,
                    $fimMes
                ])->count(),

            'em_andamento' => RoteiroLeiturista::where('status', 'Em andamento')
                ->whereBetween('data_referente', [
                    $inicioMes,
                    $fimMes
                ])->count(),

            'pendentes' => RoteiroLeiturista::whereIn('status', ['Pendente', 'nao_iniciado'])
                ->whereBetween('data_referente', [
                    $inicioMes,
                    $fimMes
                ])->count(),

            'concluido_percent' => $this->calcularPercentual('concluido', $mesAtual),
            'pendentes_percent' => $this->calcularPercentual('pendentes', $mesAtual),
        ];
    }

    private function calcularPercentual(string $tipo, Carbon $mes): int
    {
        $total = RoteiroLeiturista::whereBetween('data_referente', [
            $mes->startOfMonth(),
            $mes->endOfMonth()
        ])->count();

        if ($total === 0) return 0;

        $concluido = match ($tipo) {
            'concluido' => RoteiroLeiturista::where('status', 'concluido')
                ->whereBetween('data_referente', [$mes->startOfMonth(), $mes->endOfMonth()])
                ->count(),
            'pendentes' => RoteiroLeiturista::whereIn('status', ['pendente', 'nao_iniciado'])
                ->whereBetween('data_referente', [$mes->startOfMonth(), $mes->endOfMonth()])
                ->count(),
            default => 0
        };

        return round(($concluido / $total) * 100);
    }
    public function render()
    {

        return view('Livewire.admin.Roteiro.Index', [
            'stats' => $this->stats
        ]);
    }
}
