<?php

namespace App\Livewire\Admin\Medidores;

use App\Models\Medidores;
use App\Models\ClienteMedidor;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Computed;

class MedidoresStats extends Component
{

    #[Computed]
    public function totalMedidores(): int
    {
        return Medidores::count();
    }

    #[Computed]
    public function medidoresNesteMes(): int
    {
        return Medidores::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
    }

    #[Computed]
    public function emOperacao(): int
    {
        return Medidores::where('status_inicial', 'instalado')->count();
    }

    #[Computed]
    public function percentualEmOperacao(): float
    {
        $total = $this->totalMedidores;
        if ($total === 0) return 0;

        return round(($this->emOperacao / $total) * 100, 1);
    }

    #[Computed]
    public function emManutencao(): int
    {
        return Medidores::where('status_inicial', 'Manutencao')
            ->count();
    }

    #[Computed]
    public function percentualManutencao(): float
    {
        $total = $this->totalMedidores;
        if ($total === 0) return 0;

        return round(($this->emManutencao / $total) * 100, 1);
    }

    #[Computed]
    public function emEstoque(): int
    {
        return Medidores::where('status_inicial', 'Estoque')
            ->count();
    }

    #[Computed]
    public function medidoresDescartados(): int
    {
        return Medidores::where('status_inicial', 'Descartado')
            ->count();
    }

    #[Computed]
    public function medidoresCorte(): int
    {
        return Medidores::where('status_inicial', 'Cortada')
            ->count();
    }

    #[Computed]
    public function vencendoCalibracao(): int
    {
        return Medidores::whereNotNull('validade_certificado')
            ->whereDate('validade_certificado', '<=', Carbon::now()->addDays(30))
            ->whereDate('validade_certificado', '>=', Carbon::now())
            ->count();
    }

    public function render()
    {
        return view('Livewire.admin.Medidores.Medidores-stats');
    }
}
