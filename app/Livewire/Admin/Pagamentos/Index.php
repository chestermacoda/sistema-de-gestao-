<?php

namespace App\Livewire\Admin\Pagamentos;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\pagamentos;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $modal = false;

    public $dados = [];

    #[On('atualizar-concluido')]
    public function atualizar(): void {}
    public function getStatsProperty()
    {

        $date = date('Y-m');

        $dateAnterior = date('Y-m', strtotime('-1 month'));
        // Helper: só calcula se tiver valor anterior. Se não, retorna null
        $calcPercentual = function ($atual, $anterior) {
            if ($anterior == 0 || $anterior == null) {
                return null; // Sem base de comparação
            }
            return (($atual - $anterior) / $anterior) * 100;
        };

        // Mês Atual
        $transacoesAtual = pagamentos::where('data_pagamento', 'like', '%' . $date . '%')->count();
        $transacoesAnterior = pagamentos::where('data_pagamento', 'like', '%' . $dateAnterior . '%')->count();

        // $receitaAtual = pagamentos::where('data_pagamento', 'like', '%' . $dateAtual . '%')->sum('valor_pago');
        // Mês Anterior
        $receitaAnterior = pagamentos::where('data_pagamento', 'like', '%' . $dateAnterior . '%')->sum('valor_pago');

        // Calcula
        $percentTransacoes = $calcPercentual($transacoesAtual, $transacoesAnterior);
        // $percentReceita = $calcPercentual($receitaAtual, $receitaAnterior);
        return [
            'ReceitaTotal' =>  pagamentos::where('data_pagamento', 'like', '%' . $date . '%')->get()->sum('valor_pago'),

            'Pendente' =>  Faturas::where('mes_referencia', 'like', '%' . $date . '%')->whereIn('status', ['Pendente', 'Vencida', 'Parcial'])->where('saldo_atual', '>', 0)->get()->sum('saldo_atual'),

            'Count_Pendente' =>  Faturas::where('mes_referencia', 'like', '%' . $date . '%')->whereIn('status', ['Pendente', 'Vencida', 'Parcial'])->where('saldo_atual', '>', 0)->get()->count(),

            'Estornos' =>  pagamentos::where('data_pagamento', 'like', '%' . $date . '%')->where('status', 'Estornado')->get()->sum('valor_pago'),
            'Count_estorno' =>  pagamentos::where('data_pagamento', 'like', '%' . $date . '%')->where('status', 'Estornado')->get()->count(),

            'transacoes' =>  pagamentos::where('data_pagamento', 'like', '%' . $date . '%')->count(),
            'TransacoesPercentual' => $percentTransacoes !== null ? round($percentTransacoes, 2) : null,



        ];
    }


    #[On('detalhes-fatura')]
    public function detalhesFatura($idFatura, $idPagamento = null)
    {

        $fatura = Faturas::where('id', $idFatura)->first();

        $cliente = Cliente::where('id', $fatura->cliente_id)->first();


        $this->dados = [
            // Dados da Fatura
            'codigo_fatura' => $fatura->codigo_fatura,
            'mes_referencia' => $fatura->mes_referencia,
            'consumo_m3' => $fatura->consumo_m3,
            'valor_consumo' => $fatura->valor_consumo,
            'multa' => $fatura->multa,
            'juros' => $fatura->juros,
            'valor_pago' => $fatura->valor_pago,
            'valor_total' => $fatura->valor_total,
            'status' => $fatura->status,

            // Dados do Cliente
            'nome' => $cliente->nome_completo,
            'numero_matricula' => $cliente->numero_matricula,
            'bairro' => $cliente->bairro,
            'endereco' => $cliente->endereco,
            'zona_distribuicao' => $cliente->zona_distribuicao,
            'data_solicitacao' => $cliente->data_solicitacao,
            'tipo_imovel' => $cliente->tipo_imovel,
        ];
        $this->dispatch('openModal', 'modal-comprovante');
        $this->modal = true;
    }
    public function render()
    {
        return view('Livewire.admin.Pagamentos.Index', [
            'states' => $this->stats
        ]);
    }
}
