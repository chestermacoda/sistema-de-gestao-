<?php

namespace App\Livewire\Admin\Pagamentos;

use App\Models\Faturas as ModelsFaturas;
use App\Models\pagamentos;
use App\Models\relatorio;
use App\Services\Relatorio\RelatorioService;
use Livewire\Attributes\On;
use Livewire\Component;

class Faturas extends Component
{

    public $showmodal = false;
    public $cliente = [];
    public $fatura = [];
    public $pagamentos = [];
    public $relatorio;

    #[On('Comprovante-pagamento')]
    public function carregarFatura(int $idFatura, $idPagamento): void
    {



        $fatura = ModelsFaturas::with(['cliente', 'pagamentos'])->findOrFail($idFatura);
        $pagamento = pagamentos::findOrFail($idPagamento);


        // ─── Dados do cliente ──────────────────────────────────
        $cliente = $fatura->cliente;
        $this->cliente = [
            'nome' => $cliente?->nome_completo ?? 'N/A',
            'matricula' => $cliente?->numero_matricula ?? 'N/A',
            'nuit' => $cliente?->nuit ?? 'N/A',
            'endereco' => $cliente?->endereco ?? 'N/A',
            'contacto' => $cliente?->telefone ?? 'N/A',
            'categoria_consumo' => $cliente?->categoria_consumo ?? 'N/A'
        ];

        /*
        valor_pago = 2000
        valor_consumo = 1950
        multa = 50
        valor_total =2300
        saldo_atual =

        valor_total - valor_pago = saldo_atual
        */

        // $saldo_atual = $fatura->saldo_atual;
        // $saldo_atual = $fatura->valor_total - $pagamento->valor_pago;


        $dataRelatorio = [
            'user_id' => Auth()->user()->id,

            // 'pagamento_id' => $pagamento->id,

            'cliente_id' => $fatura->cliente_id,

            'fatura_id' => $fatura->id,

            'origem' => 'Pagamentos-' . $pagamento->id,

            'data_referencia' => $pagamento->data_pagamento->format('Y-m-d'),

            'codigo_fatura' => $fatura->codigo_fatura,

            'mes_referencia' => $fatura->mes_referencia,

            'periodo' => $fatura->periodo_inicio->format('Y-m-d') . ' a ' . $fatura->periodo_fim->format('Y-m-d'),

            'consumo_m3' => $fatura->consumo_m3,

            'valor_pago' => $pagamento->valor_pago,

            'valor_Acumulado' => $fatura->valor_pago,

            'valor_consumo' => $fatura->valor_consumo,

            'valor_total' => $fatura->valor_total,

            'saldo_atual' => $pagamento->saldo_restante,

            'multa' => $fatura->multa,

            'juros' => $fatura->juros,

            'desconto' => $fatura->desconto,

            'numero_comprovante' => $pagamento->numero_comprovante,

            'codigo_transacao' => $pagamento->codigo_transacao,

            'data_pagamento' => $pagamento->data_pagamento->format('Y-m-d'),

            'hora_pagamento' => now()->format('H:i:s'),

            'metodo' => $pagamento->metodo_pagamento,

            'cliente' => $this->cliente,

            'usuario' => Auth()->user()->name ?? 'Sistema',
        ];

        $relatorios = relatorio::where('pagamentos_id', $idPagamento)->first();


        if ($relatorios) {

            $this->relatorio = [
                'status' => true,
                'filename' => $relatorios->nome_arquivo,
            ];
        } else {
            // dd($dataRelatorio);
            $this->relatorio = app(RelatorioService::class)->FaturaPagamento($dataRelatorio);
        }
        // dd($this->relatorio);



        $this->showmodal = true;
        $this->dispatch('openModal', 'modal-detalhes-pagamento');
    }

    public function render()
    {
        return view('Livewire.Admin.Pagamentos.Faturas');
    }
}