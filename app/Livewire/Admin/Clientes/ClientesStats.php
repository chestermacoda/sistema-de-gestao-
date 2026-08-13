<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Cliente;
use App\Models\ClienteMedidor;
use App\Models\Leituras;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Computed;

class ClientesStats extends Component
{

    #[Computed]
    public function totalClientes(): int
    {
        return Cliente::count();
    }

    #[Computed]
    public function clientesNesteMes(): int
    {
        return Cliente::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
    }

    #[Computed]
    public function ligacoesAtivas(): int
    {
        return Cliente::where('status', 'ativo')->count();
    }

    #[Computed]
    public function percentualLigacoesAtivas(): float
    {
        $total = Cliente::count();
        if ($total === 0) return 0;

        return round(($this->ligacoesAtivas / $total) * 100, 1);
    }

    #[Computed]
    public function inadimplentes(): int
    {
        return Cliente::where('status', 'suspenso')->count();
    }

    #[Computed]
    public function percentualInadimplentes(): float
    {
        $total = $this->totalClientes;
        if ($total === 0) return 0;

        return round(($this->inadimplentes / $total) * 100, 1);
    }

    #[Computed]
    public function consumoMedioMes(): float
    {
        $mesAtual = Carbon::now()->format('Y-m');

        $media = Leituras::where('mes_referencia', $mesAtual)
            ->whereNotNull('consumo')
            ->avg('consumo');

        return round($media ?? 0, 1);
    }

    #[Computed]
    public function variacaoConsumo(): float
    {
        $mesAtual = Carbon::now()->format('Y-m');
        $mesAnterior = Carbon::now()->subMonth()->format('Y-m');

        $mediaAtual = Leituras::where('mes_referencia', $mesAtual)
            ->whereNotNull('consumo')
            ->avg('consumo') ?? 0;

        $mediaAnterior = Leituras::where('mes_referencia', $mesAnterior)
            ->whereNotNull('consumo')
            ->avg('consumo') ?? 0;

        if ($mediaAnterior == 0) return 0;

        return round((($mediaAtual - $mediaAnterior) / $mediaAnterior) * 100, 1);
    }

    #[Computed]
    public function cortesMes(): int
    {
        return Cliente::where('status', 'inativo')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();
    }

    #[Computed]
    public function leiturasPendentes(): int
    {
        $mesAtual = Carbon::now()->format('Y-m');

        $totalLigacoesAtivas = $this->ligacoesAtivas;
        $leiturasRealizadas = Leituras::where('mes_referencia', $mesAtual)->count();

        return max(0, $totalLigacoesAtivas - $leiturasRealizadas);
    }

    public function render()
    {
        return view('livewire.admin.clientes.clientes-stats');
    }
}
