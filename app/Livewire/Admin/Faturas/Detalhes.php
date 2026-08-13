<?php

namespace App\Livewire\Admin\Faturas;

use App\Models\Faturas;
use App\Models\Tarifa;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Detalhes extends Component
{
    public $faturaId;
    public $valorOriginal;
    public $valorFinal;
    public $valorComDesconto;
    public $economia;
    public array $cliente;
    public $novaDataVencimento;
    public array $fatura = [];
    public $detalhe = false;
    public array $status = [];


    #[On('Open-detalheFatura')]
    public function atualizar($idFatura): void
    {
        $fatura = Faturas::with('cliente', 'leitura')->findOrFail($idFatura);

        $categoria = $fatura->cliente->categoria_consumo;
        $tarifa = Tarifa::where('categoria', $categoria)->first();

        // Só permite negociar faturas pendentes ou vencidas
        // if (!in_array($fatura->status, ['Pendente', 'Vencida'])) {
        //     $this->dispatch('notify', [
        //         'type' => 'error',
        //         'message' => 'Apenas faturas pendentes ou vencidas podem ser negociadas.',
        //     ]);
        //     return;
        // }

        // ─── Reseta tudo antes de carregar ─────────────────────

        // $this->quantidadeParcelas = 1;
        // $this->gerarNovoBoleto = true;
        // $this->tipoNegociacao = 'Parcelar';

        // ─── Cálculo das tarifas atualizadas ───────────────────
        // $calculo = app(NegociarFatura::class)->calcularTarifasAtualizadas($fatura, $this->tipoNegociacao);


        // ─── Calcular dias/meses de atraso ─────────────────────
        $hoje = Carbon::today();
        $periodoFim = Carbon::parse($fatura->periodo_fim)->startOfDay();
        $diasAtraso = 0;
        $mesesAtraso = 0;

        if ($hoje->greaterThan($periodoFim)) {
            $diasAtraso = abs((int) $hoje->diff($periodoFim)->format('%r%a'));
            $mesesAtraso = ceil($diasAtraso / 30);
        }

        // ─── Define valores base ───────────────────────────────
        $this->faturaId = $fatura->id;
        // $this->valorOriginal = (float) $calculo['valor_total'];
        $this->valorFinal = $this->valorOriginal;
        $this->valorComDesconto = $this->valorOriginal;
        $this->economia = 0;

        // dd($fatura->mes_referencia?->format('Y-m-d'));

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


        // ─── Dados da fatura para exibição ─────────────────────
        $this->fatura = [
            'id' => $fatura->id,
            'codigo' => $fatura->codigo_fatura,
            'status' => $fatura->status,
            'statusClass' => $statusClass,
            'statusLabel' => $statusLabel,
            'valor_consumo' => $fatura->valor_consumo,
            'metrocubicos_Consumo' => $fatura->consumo_m3,
            'LeituraDo_Medidor' => $fatura->consumo_m3,

            // 'valor_total' => $calculo['valor_total'],
            // 'valor_base' => $calculo['valor_base'],
            // 'multa_atual' => $calculo['multa'],
            // 'juros_atual' => $calculo['juros'],

            'tarifa' => $tarifa->valor_m3,

            'leitura_anterior' => $fatura->leitura->leitura_anterior ?? 0,
            'leitura_atual' => $fatura->leitura->leitura_atual ?? 0,

            'desconto' => (float) $fatura->desconto,
            'dias_atraso' => $diasAtraso,
            'meses_atraso' => $mesesAtraso,
            'data_vencimento' => $fatura->data_vencimento?->format('d-m-Y'),

            'data_emissao' => $fatura->data_emissao?->format('d-m-Y'),

            'mes_referente' => $fatura->mes_referencia,

            'periodo' => $fatura->periodo_inicio?->format('d-m-Y') . ' a ' . $fatura->periodo_fim?->format('d-m-Y'),

            'consumo_m3' => $fatura->consumo_m3,
        ];

        // ─── Dados do cliente ──────────────────────────────────
        $cliente = $fatura->cliente;
        $this->cliente = [
            'nome' => $cliente?->nome_completo ?? 'N/A',
            'matricula' => $cliente?->numero_matricula ?? 'N/A',
            'bi' => $cliente?->bi  ?? 'N/A',
            'endereco' => $cliente?->endereco  ?? 'N/A',
            'bairrozona' => $cliente?->cidade . '/' . $cliente?->bairro ?? 'N/A',
            'telefone' => $cliente?->telefone  ?? 'N/A',

        ];

        // ─── Data padrão: 5 dias à frente ──────────────────────
        $this->novaDataVencimento = now()->addDays(5)->format('Y-m-d');

        $this->detalhe = true;
        $this->dispatch('openModal', 'modal-ver-fatura');
    }


    public function render()
    {
        return view('Livewire.Admin.Faturas.Detalhes');
    }
}