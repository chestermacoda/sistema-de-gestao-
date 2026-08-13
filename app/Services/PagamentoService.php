<?php

namespace App\Services;

use App\Models\Faturas;
use App\Models\negociar_fatura;
use App\Models\NegociarFatura;
use App\Models\Pagamentos;
use App\Models\pagamentos as ModelsPagamentos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PagamentoService
{

    /**
     * Registra um pagamento e atualiza a fatura
     *
     * @param array $dados [
     *   'fatura_id' => int,
     *   'valor_pago' => float,
     *   'metodo_pagamento' => string,
     *   'data_pagamento' => string,
     *   'parcela_id' => int|null,
     *   'codigo_transacao' => string|null,
     *   'banco' => string|null,
     *   'numero_comprovante' => string|null,
     *   'observacoes' => string|null,
     * ]
     *
     * @return array ['pagamento' => Pagamentos, 'fatura' => Faturas, 'mensagem' => string]
     * @throws \Exception
     */
    public function registrarPagamento(array $dados): array
    {

        return DB::transaction(function () use ($dados) {
            $fatura = Faturas::findOrFail($dados['fatura_id']);

            // Valida status
            if (!in_array($fatura->status, ['Pendente', 'Vencida', 'Negociada', 'Parcial'])) {
                throw new \Exception("Fatura com status '{$fatura->status}' não pode receber pagamento.");
            }

            $valorPago = (float) $dados['valor_pago'];

            if ($valorPago <= 0) {
                throw new \Exception("Valor pago deve ser maior que zero.");
            }

            // Calcula total já pago anteriormente
            $totalPagoAnterior = (float) Pagamentos::where('fatura_id', $fatura->id)
                ->where('status', 'Confirmado')
                ->sum('valor_pago');

            $saldoDevedor = (float) $fatura->valor_total - $totalPagoAnterior;

            if ($valorPago > $saldoDevedor) {
                throw new \Exception(
                    "Valor pago (MZN " . number_format($valorPago, 2, ',', '.') . ") "
                        . "excede o saldo devedor (MZN " . number_format($saldoDevedor, 2, ',', '.') . ")."
                );
            }


            $novoTotalPago = $totalPagoAnterior + $valorPago;
            // dd();
            // dd([
            //     'fatura_id' => $fatura->id,
            //     'cliente_id' => $fatura->cliente_id,
            //     'user_id' => auth()->id() ?? 1,
            //     'parcela_id' => $dados['parcela_id'] ?? null,
            //     'codigo_transacao' => $dados['codigo_transacao'] ?? null,
            //     'valor_pago' => $valorPago,
            //     'data_pagamento' => $dados['data_pagamento'] ?? now()->format('Y-m-d'),
            //     'hora_pagamento' => now()->format('H:i:s'),
            //     'metodo_pagamento' => $dados['metodo_pagamento'],
            //     'numero_comprovante' => $dados['numero_comprovante'] ?? null,
            //     'status' => 1,
            //     'observacoes' => $dados['observacoes'] ?? null,
            // ]);
            $statusPagamento = $this->definirStatusPagamento($valorPago, $saldoDevedor);



            try {

                $pagamento = Pagamentos::create([
                    'fatura_id' => $fatura->id,
                    'cliente_id' => $fatura->cliente_id,
                    'user_id' => auth()->id(),
                    'parcela_id' => $dados['parcela_id'] ?? null,
                    'codigo_transacao' => $dados['codigo_transacao'] ?? null,
                    'valor_pago' => $valorPago,
                    'data_pagamento' => $dados['data_pagamento'] ?? now()->format('Y-m-d'),
                    'hora_pagamento' => now()->format('H:i:s'),
                    'metodo_pagamento' => $dados['metodo_pagamento'],
                    'numero_comprovante' => $dados['numero_comprovante'] ?? null,
                    'status' => $statusPagamento,
                    'observacoes' => $dados['observacoes'] ?? null,
                ]);
            } catch (\Exception $e) {

                dd([
                    'erro' => $e->getMessage(),
                    'linha' => $e->getLine(),
                    'ficheiro' => $e->getFile(),
                ]);
            }
            // $pagamento = Pagamentos::create([
            //     'fatura_id' => $fatura->id,
            //     'cliente_id' => $fatura->cliente_id,
            //     'user_id' => auth()->id() ?? 1,
            //     'parcela_id' => $dados['parcela_id'] ?? null,
            //     'codigo_transacao' => $dados['codigo_transacao'] ?? null,
            //     'valor_pago' => $valorPago,
            //     'data_pagamento' => $dados['data_pagamento'] ?? now()->format('Y-m-d'),
            //     'hora_pagamento' => now()->format('H:i:s'),
            //     'metodo_pagamento' => $dados['metodo_pagamento'],
            //     'numero_comprovante' => $dados['numero_comprovante'] ?? null,
            //     'status' => $statusPagamento,
            //     'observacoes' => $dados['observacoes'] ?? null,
            // ]);

            // if ($dados['parcela_id'] != '') {

            // $this->calcularParcelas($dados);
            // }
            // Define novo status da fatura
            $novoStatus = $this->definirNovoStatus($fatura, $novoTotalPago);

            // Atualiza fatura
            $fatura->update([
                'status' => $novoStatus,
                'observacoes' => ($fatura->observacoes ? $fatura->observacoes . "\n" : '')
                    . "Pagamento de MZN " . number_format($valorPago, 2, ',', '.')
                    . " em " . now()->format('d/m/Y H:i') . " via " . $dados['metodo_pagamento'] . ".",
            ]);

            // Se tem parcela, atualiza status dela
            if (!empty($dados['parcela_id'])) {
                $this->atualizarParcela($dados['parcela_id']);
            }

            $mensagem = $novoStatus === 'Pago'
                ? "Fatura {$fatura->codigo_fatura} quitada com sucesso!"
                : "Pagamento parcial registrado. Saldo devedor: MZN " . number_format($fatura->valor_total - $novoTotalPago, 2, ',', '.');

            Log::info('Pagamento registrado', [
                'pagamento_id' => $pagamento->id,
                'fatura_id' => $fatura->id,
                'valor' => $valorPago,
                'status_fatura' => $novoStatus,
            ]);

            return [
                'pagamento' => $pagamento->fresh(),
                'fatura' => $fatura->fresh(),
                'mensagem' => $mensagem,
                'saldo_restante' => $fatura->valor_total - $novoTotalPago,
            ];
        });
    }

    private function definirStatusPagamento(float $valorPago, float $saldoDevedor): string
    {
        $tolerancia = 0.01;

        if ($valorPago >= ($saldoDevedor - $tolerancia)) {
            return 'Confirmado';  // pagou tudo
        }

        return 'Parcial';  // pagou parte
    }


    /**
     * Define novo status da fatura após pagamento
     */
    private function definirNovoStatus(Faturas $fatura, float $totalPago): string
    {
        $tolerancia = 0.01; // tolerância para arredondamento

        if ($totalPago >= ((float) $fatura->valor_total - $tolerancia)) {
            return 'Pago';
        }

        if ($totalPago > 0) {
            return 'Parcial';
        }

        return $fatura->status;
    }


    /**
     * Atualiza status da parcela quando paga
     */
    private function atualizarParcela(int $parcelaId): void
    {
        $parcela = \App\Models\negociar_fatura_itens::find($parcelaId);
        if ($parcela) {
            $parcela->update([
                'status' => 'Paga'
            ]);
        }
        // $parcela = \App\Models\negociar_fatura::find($parcelaId);
        // if ($parcela) {
        //     $parcela->update([
        //         'status' => 'Paga',
        //         'observacoes' => ($parcela->observacoes ? $parcela->observacoes . "\n" : '')
        //             . "Parcela paga em " . now()->format('d/m/Y') . " — MZN " . number_format($valorPago, 2, ',', '.'),
        //     ]);
        // }
    }


    /**
     * Busca saldo devedor de uma fatura
     */
    public function saldoDevedor(int $faturaId): float
    {
        $fatura = Faturas::findOrFail($faturaId);
        $totalPago = (float) Pagamentos::where('fatura_id', $faturaId)
            ->where('status', 'Confirmado')
            ->sum('valor_pago');

        return max(0, (float) $fatura->valor_total - $totalPago);
    }


    /**
     * Histórico de pagamentos de uma fatura
     */
    public function historicoPagamentos(int $faturaId): array
    {
        // return Pagamentos::where('fatura_id', $faturaId)
        //     ->with(['usuario', 'fatura'])
        //     ->orderByDesc('data_pagamento')
        //     ->get()
        //     ->map(fn($p) => [
        //         'id' => $p->id,
        //         'valor' => (float) $p->valor_pago,
        //         'data' => $p->data_pagamento?->format('d/m/Y'),
        //         'metodo' => $p->metodo_pagamento,
        //         'comprovante' => $p->numero_comprovante,
        //         'usuario' => $p->usuario?->name ?? 'Sistema',
        //         'Fatura' => $p->fatura?->codigo_fatura ?? 'N/F',
        //     ])

        //     ->toArray();


        return  Pagamentos::with(['usuario', 'fatura'])
            ->where('fatura_id', $faturaId) // ou remove este where se quiseres todas as faturas
            ->orderByDesc('data_pagamento')
            ->get()
            ->groupBy('fatura_id')
            ->map(function ($pagamentos) {

                // Último pagamento da fatura
                $ultimo = $pagamentos->sortByDesc('data_pagamento')->first();

                return [
                    'id' => $ultimo->id,
                    'fatura_id' => $ultimo->fatura_id,
                    'Fatura' => $ultimo->fatura?->codigo_fatura ?? 'N/F',
                    'valor' => (float) $pagamentos->sum('valor_pago'),
                    'ultimo_pagamento' => $ultimo->data_pagamento?->format('d/m/Y'),
                    'data' => $ultimo->data_pagamento?->format('d/m/Y'),
                    'metodo' => $ultimo->metodo_pagamento,
                    'comprovante' => $ultimo->numero_comprovante,
                    'usuario' => $ultimo->usuario?->name ?? 'Sistema',
                ];
            })
            ->values() // remove as chaves do groupBy
            ->toArray();
    }

    // public function historicoPagamentos(int $faturaId, $perPage = 10)
    // {
    //     $dados = Pagamentos::with(['usuario', 'fatura'])
    //         ->where('fatura_id', $faturaId)
    //         ->orderByDesc('data_pagamento')
    //         ->get()
    //         ->groupBy('fatura_id')
    //         ->map(function ($pagamentos) {
    //             $ultimo = $pagamentos->sortByDesc('data_pagamento')->first();

    //             return [
    //                 'id' => $ultimo->id,
    //                 'fatura_id' => $ultimo->fatura_id,
    //                 'Fatura' => $ultimo->fatura?->codigo_fatura ?? 'N/F',
    //                 'valor' => (float) $pagamentos->sum('valor_pago'),
    //                 'ultimo_pagamento' => $ultimo->data_pagamento?->format('d/m/Y'),
    //                 'data' => $ultimo->data_pagamento?->format('d/m/Y'),
    //                 'metodo' => $ultimo->metodo_pagamento,
    //                 'comprovante' => $ultimo->numero_comprovante,
    //                 'usuario' => $ultimo->usuario?->name ?? 'Sistema',
    //             ];
    //         })
    //         ->values();

    //     $page = request()->get('page', 1);

    //     return new LengthAwarePaginator(
    //         $dados->forPage($page, $perPage),
    //         $dados->count(),
    //         $perPage,
    //         $page,
    //         [
    //             'path' => request()->url(),
    //             'query' => request()->query(),
    //         ]
    //     );
    // }



    /**
     * Processa o pagamento de uma fatura que está em negociação/parcelamento
     */
    public function calcularParcelas($dados)
    {
        // $dados deve conter no mínimo:
        // 'fatura_id', 'valor_pago', 'pagamento_id' (opcional)

        $faturaId = $dados['fatura_id'];
        $valorPago = (float) $dados['valor_pago'];

        if ($valorPago <= 0) {
            return false;
        }

        // 1. Buscar todas as parcelas em aberto (ordenadas por número da parcela)
        $parcelas = DB::table('negociar_fatura_itens')
            ->where('fatura_id', $faturaId)
            ->whereIn('status', ['Pendente', 'Vencida', 'Parcial'])
            ->orderBy('numero_parcela')
            ->get();

        // Se não houver parcelas, sai da função
        if ($parcelas->isEmpty()) {

            return true; // Já tratado em outro lugar
        }

        // 2. Buscar valor total combinado na negociação
        $valorCombinadoTotal = DB::table('negociar_faturas')
            ->where('fatura_id', $faturaId)
            ->value('valor_final'); // ou sum se tiver várias negociações

        // 3. Total já pago anteriormente
        $totalPagoAnterior = ModelsPagamentos::where('fatura_id', $faturaId)
            ->sum('valor_pago');

        $valorRestanteTotal = $valorCombinadoTotal - $totalPagoAnterior;

        // Valor que ainda precisa ser distribuído agora
        $valorParaDistribuir = min($valorPago, $valorRestanteTotal);

        $valorRestante = $valorParaDistribuir;


        foreach ($parcelas as $parcela) {
            if ($valorRestante <= 0) break;

            $valorParcelaAtual = (float) $parcela->valor_parcela;
            $valorRestanteParcela = (float) $parcela->valor_restante;

            // Se a parcela já está quitada, pula
            // if ($valorRestanteParcela <= 0) continue;

            // Cenário 1: Pagamento cobre ou excede esta parcela
            // if ($valorRestante >= $valorRestanteParcela) {
            if ($valorRestanteTotal == $dados['valor_pago']) {
                // Quita a parcela
                DB::table('negociar_fatura_itens')
                    ->where('id', $parcela->id)
                    ->update([
                        'valor_restante' => 0,
                        'status' => 'Paga'
                    ]);

                $valorRestante -= $valorRestanteParcela;
            }
            // Cenário 2: Pagamento parcial nesta parcela
            else {
                $novoRestante = $valorRestanteParcela - $valorRestante;

                DB::table('negociar_fatura_itens')
                    ->where('id', $parcela->id)
                    ->update([
                        'valor_restante' => $novoRestante,
                        'status' => 'Parcial'
                    ]);

                $valorRestante = 0;
            }
        }


        // Atualiza status geral da negociação (opcional)
        $this->atualizarStatusNegociacao($faturaId);

        return true;
    }

    private function atualizarStatusNegociacao($faturaId)
    {
        $parcelasPendentes = DB::table('negociar_fatura_itens')
            ->where('fatura_id', $faturaId)
            ->whereIn('status', ['Pendente', 'Vencida', 'Parcial'])
            ->count();

        if ($parcelasPendentes === 0) {
            // Marca negociação como concluída
            DB::table('negociar_fatura')
                ->where('fatura_id', $faturaId)
                ->update(['status' => 'Paga']);
        }
    }
}