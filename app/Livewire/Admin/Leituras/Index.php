<?php

namespace App\Livewire\Admin\Leituras;

use App\Livewire\Admin\Clientes\ClientesStats;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\Cliente;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class Index extends Component
{

    #[On('reload-Card')]
    public function refreshComponent() {}
    /**
     * Mês de referência atual (formato Y-m)
     * Pode ser alterado para consultar meses anteriores
     */
    public string $mesReferencia;

    public function mount(): void
    {
        $this->mesReferencia = Carbon::now()->format('Y-m');
    }

    // ============================================
    // CARD 1: TOTAL DE LEITURAS DO MÊS
    // ============================================

    #[Computed]
    public function totalLeiturasMes(): int
    {
        return Leituras::where('mes_referencia',  'like', '%' . $this->mesReferencia . '%')->count();
    }

    /**
     * Total de leituras do mês anterior (para comparação %)
     */
    #[Computed]
    public function totalLeiturasMesAnterior(): int
    {
        $mesAnterior = Carbon::parse($this->mesReferencia . '-01')
            ->subMonth()
            ->format('Y-m');

        return Leituras::where('mes_referencia',  'like', '%' . $mesAnterior . '%')->count();
    }

    /**
     * Variação percentual vs mês anterior
     */
    #[Computed]
    public function variacaoLeituras(): float
    {
        $atual = $this->totalLeiturasMes;
        $anterior = $this->totalLeiturasMesAnterior;

        if ($anterior === 0) return 0;

        return round((($atual - $anterior) / $anterior) * 100, 1);
    }

    // ============================================
    // CARD 2: LEITURAS OK (STATUS NORMAL)
    // ============================================

    #[Computed]
    public function leiturasOk(): int
    {
        return Leituras::where('mes_referencia',  'like', '%' . $this->mesReferencia . '%')
            ->where('status', 'validada')
            ->where('tem_anomalia', 0)
            ->count();
    }

    /**
     * Percentual de leituras OK sobre o total
     */
    #[Computed]
    public function percentualOk(): float
    {
        $total = $this->totalLeiturasMes;
        if ($total === 0) return 0;

        return round(($this->leiturasOk / $total) * 100, 1);
    }

    // ============================================
    // CARD 3: LEITURAS PENDENTES
    // ============================================
    // Lógica: Total de clientes ATIVOS com medidor instalado
    // MINUS clientes que já têm leitura no mês

    #[Computed]
    public function leiturasPendentes(): int
    {
        // Total de clientes com medidor instalado ativo
        // $totalInstalados = Medidores::where('status_inicial', 'instalado')
        //     ->whereNotNull('cliente_id')
        //     ->count();

        // // Total de leituras já registradas no mês
        // $totalLeituras = $this->totalLeiturasMes;

        // return max(0, $totalInstalados - $totalLeituras);



        $mesAtual = Carbon::now()->format('Y-m');

        $totalLigacoesAtivas = app(ClientesStats::class)->ligacoesAtivas;
        $leiturasRealizadas = Leituras::where('mes_referencia',  'like', '%' . $mesAtual . '%')->count();

        return max(0, $totalLigacoesAtivas - $leiturasRealizadas);
    }

    /**
     * Percentual de pendentes sobre o total de instalados
     */
    #[Computed]
    public function percentualPendentes(): float
    {
        $totalInstalados = Medidores::where('status_inicial', 'instalado')
            ->whereNotNull('cliente_id')
            ->count();

        if ($totalInstalados === 0) return 0;

        return round(($this->leiturasPendentes / $totalInstalados) * 100, 1);
    }

    // ============================================
    // CARD 4: ANOMALIAS
    // ============================================
    // Lógica: Leituras com tem_anomalia = true OU status = 'Anomalia'

    #[Computed]
    public function totalAnomalias(): int
    {
        return Leituras::where('mes_referencia',  'like', '%' . $this->mesReferencia . '%')
            ->where(function ($q) {
                $q->where('tem_anomalia', 1)
                    ->orWhere('status', 'anomalia');
            })
            ->count();
    }

    /**
     * Percentual de anomalias sobre o total de leituras
     */
    #[Computed]
    public function percentualAnomalias(): float
    {
        $total = $this->totalLeiturasMes;
        if ($total === 0) return 0;

        return round(($this->totalAnomalias / $total) * 100, 1);
    }

    /**
     * Detalhamento dos tipos de anomalia
     */
    #[Computed]
    public function detalheAnomalias(): array
    {
        return Leituras::where('mes_referencia',  'like', '%' . $this->mesReferencia . '%')
            ->where(function ($q) {
                $q->where('tem_anomalia', 1)
                    ->orWhere('status', 'Anomalia');
            })
            ->selectRaw('tipo_anomalia, COUNT(*) as total')
            ->groupBy('tipo_anomalia')
            ->pluck('total', 'tipo_anomalia')
            ->toArray();
    }

    // ============================================
    // HELPERS DE EXIBIÇÃO
    // ============================================

    /**
     * Nome do mês atual formatado
     */
    public function getMesAtualFormatado(): string
    {
        $meses = [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro',
        ];

        $partes = explode('-', $this->mesReferencia);
        return $meses[$partes[1]] ?? '' . ' / ' . $partes[0];
    }

    public function render()
    {
        return view('Livewire.admin.Leituras.Index');
    }
}