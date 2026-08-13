<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\ConfiguracaoFinanceira;
use App\Models\Faturas;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\Tarifa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FaturaService
{

    /**
     * ============================================================
     * CRIAÇÃO MANUAL DE FATURA (sem leitura prévia)
     * ============================================================
     * Cria uma leitura manual e a fatura associada, pronta para pagamento.
     * A fatura nasce com status 'Pendente'.
     *
     * @param array $dados [
     *   'cliente_id' => int,
     *   'mes_referencia' => string,        // ex: '05/2026'
     *   'data_vencimento' => string|null,  // Y-m-d (opcional)
     *   'leitura_atual' => float,
     *   'leitura_anterior' => float|null,  // se null, busca última leitura
     *   'observacoes' => string|null,
     *   'origem' => string,                // 'manual', 'leitura', 'ajuste'
     * ]
     *
     * @return array ['fatura' => Faturas, 'leitura' => Leituras, 'calculo' => array]
     * @throws \Exception
     */
    public function criarFaturaManual(array $dados): array
    {
        return DB::transaction(function () use ($dados) {

            // 1. Validações básicas
            $cliente = Cliente::findOrFail($dados['cliente_id']);
            $medidor = Medidores::where('cliente_id', $cliente->id)
                ->where('status_inicial', 'instalado')
                ->first();

            if (!$medidor) {
                throw new \Exception("Cliente não possui hidrômetro instalado ativo.");
            }

            // 2. Busca última leitura real para definir leitura_anterior
            $ultimaLeitura = Leituras::where('medidores_id', $medidor->id)
                ->latest('data_leitura')
                ->first();

            $leituraAnterior = $dados['leitura_anterior']
                ?? $ultimaLeitura?->leitura_atual
                ?? 0;

            $leituraAtual = (float) $dados['leitura_atual'];

            if ($leituraAtual < $leituraAnterior) {
                throw new \Exception(
                    "Leitura atual ({$leituraAtual}) não pode ser menor que a anterior ({$leituraAnterior})."
                );
            }

            // 3. Calcula consumo
            $consumo = max(0, $leituraAtual - $leituraAnterior);

            // 4. Busca tarifa pela categoria do cliente
            $tarifa = Tarifa::where('categoria', $cliente->categoria_consumo)->first();

            if (!$tarifa) {
                throw new \Exception(
                    "Tarifa não encontrada para a categoria '{$cliente->categoria_consumo}'."
                );
            }

            // 5. Busca configuração financeira ativa
            $config = ConfiguracaoFinanceira::where('id', 1)->first();

            if (!$config) {
                throw new \Exception("Configuração financeira não encontrada. Cadastre uma configuração primeiro.");
            }

            // 6. CÁLCULO FINANCEIRO
            $calculo = $this->calcularValoresFatura($consumo, $tarifa, $config);

            // 7. Define datas
            $dataEmissao = now();
            // $dataVencimento = !empty($dados['data_vencimento'])
            //     ? Carbon::parse($dados['data_vencimento'])
            //     : $dataEmissao->copy()->addDays($config->dias_vencimento);
            $dataVencimento = !empty($dados['data_vencimento'])
                ? Carbon::parse($dados['data_vencimento'])
                : $dataEmissao->copy()->endOfMonth();



            // 8. Define período (início = dia após fim do mês anterior, fim = data da leitura/emissão)
            $periodoFim = $dataEmissao->copy();
            $periodoInicio = $this->calcularPeriodoInicio($cliente->id, $periodoFim);

            // 9. CRIA A LEITURA MANUAL (origem = 'fatura_manual')

            if (!isset($dados['fatura_Automatica'])) {
                $leitura = Leituras::create([
                    'cliente_id' => $cliente->id,
                    'medidores_id' => $medidor->id,
                    'user_id' => auth()->id(),

                    'mes_referencia' => $dados['mes_referencia'],

                    'data_leitura' => $dataEmissao->format('Y-m-d'),
                    'hora_leitura' => $dataEmissao->format('H:i:s'),

                    'leitura_anterior' => $leituraAnterior,
                    'leitura_atual' => $leituraAtual,

                    'consumo' => $consumo,
                    'consumo_medio' => $this->calcularConsumoMedio($medidor->id),

                    'status' => 'validada',
                    'tem_anomalia' => false,
                    'tipo_anomalia' => null,
                    'descricao_anomalia' => null,

                    'editada' => false,
                    'origem' => $dados['origem'] ?? 'fatura_manual',
                    'observacoes' => $dados['observacoes'] ?? 'Leitura lançada manualmente via emissão de fatura.',
                ]);
            }

            // 10. GERA CÓDIGO DA FATURA
            $codigoFatura = $this->gerarCodigoFatura($dados['mes_referencia']);

            // 11. CRIA A FATURA (status = 'Pendente' — pronta para pagamento)
            $fatura = Faturas::create([
                'cliente_id' => $cliente->id,
                'leitura_id' => isset($dados['fatura_Automatica']) ? $dados['leitura_id'] : $leitura->id,

                'codigo_fatura' => $codigoFatura,
                'mes_referencia' => $dados['mes_referencia'],

                'periodo_inicio' => $periodoInicio,
                'periodo_fim' => $periodoFim,

                'consumo_m3' => $consumo,

                'valor_consumo' => $calculo['valor_consumo'],
                'valor_esgoto' => $calculo['valor_esgoto'],
                'taxa_disponibilidade' => $calculo['taxa_disponibilidade'],

                'multa' => 0.00,
                'juros' => 0.00,
                'desconto' => 0.00,

                'valor_total' => $calculo['valor_total'],

                'data_emissao' => $dataEmissao,
                'data_vencimento' => $dataVencimento,

                'status' => 'Pendente',
                'observacoes' => $dados['observacoes'] ?? null,
            ]);

            Log::info("Fatura manual criada", [
                'fatura_id' => $fatura->id,
                'codigo' => $codigoFatura,
                'cliente' => $cliente->nome_completo,
                'consumo' => $consumo,
                'total' => $calculo['valor_total'],
            ]);

            return [
                'fatura' => $fatura->fresh(['cliente', 'leitura']),
                'leitura' => isset($dados['fatura_Automatica']) ? '' : $leitura->fresh(),
                'calculo' => $calculo,
            ];
        });
    }


    /**
     * ============================================================
     * CÁLCULO DOS VALORES DA FATURA
     * ============================================================
     */

    public function calcularValoresFatura(float $consumo, Tarifa $tarifa, ConfiguracaoFinanceira $config): array
    {
        // 1. CÁLCULO DO CONSUMO REAL
        // Ex: 10m3 * 70MT = 700MT
        $precoPorMetro = (float) $tarifa->valor_m3;
        $valorConsumoReal = $consumo * $precoPorMetro;

        // 2. APLICAÇÃO DA REGRA DE PISO (Paga o maior valor entre o real e o mínimo)
        // Se Consumo Real (Ex: 280MT) for menor que Taxa Mínima (350MT), aplica 350.
        $taxaMinima = (float) $tarifa->taxa_minima;
        $valorFinalAgua = max($valorConsumoReal, $taxaMinima);

        // 3. TAXAS ADICIONAIS (Configurações Financeiras)
        // Se você tiver taxa de disponibilidade ou esgoto no banco, recupere aqui
        $taxaEsgotoPercentual = 0; // Ajuste se houver campo na migration
        $valorEsgoto = $valorFinalAgua * ($taxaEsgotoPercentual / 100);

        // Como a sua Model ConfiguracaoFinanceira não tem taxa_disponibilidade,
        // coloquei 0 ou você pode buscar de outra fonte.
        $taxaDisponibilidade = 0;

        // 4. SUBTOTAL
        $subtotal = $valorFinalAgua + $valorEsgoto + $taxaDisponibilidade;

        // return [
        //     'consumo_m3'             => $consumo,
        //     'valor_unitario_m3'      => $precoPorMetro,
        //     'taxa_minima_aplicada'   => $taxaMinima,
        //     'valor_consumo_real'     => round($valorConsumoReal, 2),

        //     // Este é o valor final da água (ou o mínimo ou o real multiplicado)
        //     'valor_final_agua'       => round($valorFinalAgua, 2),

        //     'valor_esgoto'           => round($valorEsgoto, 2),
        //     'taxa_disponibilidade'   => round($taxaDisponibilidade, 2),
        //     'subtotal'               => round($subtotal, 2),

        //     // Campos de atraso (iniciam em 0 para faturas novas)
        //     'multa'                  => 0.00,
        //     'juros'                  => 0.00,
        //     'desconto'               => 0.00,
        //     'valor_total'            => round($subtotal, 2),

        //     // Helper para o Blade (ajuda a mostrar "Taxa Mínima" ou "Consumo Real" no PDF)
        //     'metodo_calculo'         => $valorConsumoReal < $taxaMinima ? 'Taxa Mínima' : 'Consumo Real'
        // ];

        return [
            'consumo_m3'             => $consumo,
            'tarifa_base'            => (float) $tarifa->taxa_minima,
            'limite_m3'              => (float) $tarifa->limite_m3,
            'preco_excedente'        => (float) ($tarifa->valor_m3 ?? 0),
            'valor_consumo'          => round($valorEsgoto, 2),
            'taxa_esgoto_percentual' => (float) $taxaDisponibilidade,
            'valor_esgoto'           => round($valorEsgoto, 2),
            'taxa_disponibilidade'   => round($taxaDisponibilidade, 2),
            'subtotal'               => round($subtotal, 2),
            'multa'                  => 0.00,
            'juros'                  => 0.00,
            'desconto'               => 0.00,
            'valor_total'            => round($subtotal, 2),

            // Mantive este campo extra pois ele ajuda muito na visualização do PDF/Relatórios
            'metodo_calculo'         => $valorConsumoReal < $taxaMinima ? 'Taxa Mínima' : 'Consumo Real'
        ];
    }

    /**
     * ============================================================
     * SIMULAÇÃO DE FATURA (para preview em tempo real)
     * ============================================================
     * Não persiste nada no banco. Usado no formulário de criação.
     */
    public function simularFatura(int $clienteId, float $leituraAtual, ?float $leituraAnterior = null): array
    {
        $cliente = Cliente::findOrFail($clienteId);

        // Busca leitura anterior se não informada
        if ($leituraAnterior === null) {
            $medidor = Medidores::where('cliente_id', $clienteId)
                ->where('status_inicial', 'instalado')
                ->first();

            $ultima = $medidor
                ? Leituras::where('medidores_id', $medidor->id)->latest('data_leitura')->first()
                : null;

            $leituraAnterior = $ultima?->leitura_atual ?? 0;
        }

        if ($leituraAtual < $leituraAnterior) {
            throw new \Exception("Leitura atual não pode ser menor que a anterior.");
        }

        $consumo = max(0, $leituraAtual - $leituraAnterior);

        $tarifa = Tarifa::where('categoria', $cliente->categoria_consumo)->first();
        if (!$tarifa) {
            throw new \Exception("Tarifa não encontrada para categoria '{$cliente->categoria_consumo}'.");
        }

        $config = ConfiguracaoFinanceira::where('id', 1)->first();
        if (!$config) {
            throw new \Exception("Configuração financeira não encontrada.");
        }

        $calculo = $this->calcularValoresFatura($consumo, $tarifa, $config);

        return [
            'cliente' => [
                'id' => $cliente->id,
                'nome' => $cliente->nome_completo,
                'matricula' => $cliente->numero_matricula,
                'categoria' => $cliente->categoria_consumo,
            ],
            'leitura_anterior' => $leituraAnterior,
            'leitura_atual' => $leituraAtual,
            'consumo_m3' => $consumo,
            'calculo' => $calculo,
        ];
    }


    /**
     * ============================================================
     * RECÁLCULO DE FATURA EXISTENTE
     * ============================================================
     * Útil quando uma leitura é editada e a fatura precisa ser recalculada.
     */
    public function recalcularFatura(Faturas $fatura): Faturas
    {
        $leitura = $fatura->leitura;

        if (!$leitura) {
            throw new \Exception("Fatura não possui leitura associada.");
        }

        $cliente = $fatura->cliente;
        $tarifa = Tarifa::where('categoria', $cliente->categoria_consumo)->first();
        $config = ConfiguracaoFinanceira::ativa();

        if (!$tarifa || !$config) {
            throw new \Exception("Tarifa ou configuração financeira não encontrada.");
        }

        $consumo = max(0, $leitura->leitura_atual - $leitura->leitura_anterior);
        $calculo = $this->calcularValoresFatura($consumo, $tarifa, $config);

        // Atualiza valores mantendo multas/juros/descontos já aplicados
        $fatura->update([
            'consumo_m3' => $consumo,
            'valor_consumo' => $calculo['valor_consumo'],
            'valor_esgoto' => $calculo['valor_esgoto'],
            'taxa_disponibilidade' => $calculo['taxa_disponibilidade'],
            'valor_total' => $calculo['subtotal'] + $fatura->multa + $fatura->juros - $fatura->desconto,
        ]);

        return $fatura->fresh();
    }


    /**
     * ============================================================
     * HELPERS PRIVADOS
     * ============================================================
     */

    /**
     * Calcula consumo médio dos últimos 6 meses de um medidor
     */
    private function calcularConsumoMedio(int $medidorId): float
    {
        $consumos = Leituras::where('medidores_id', $medidorId)
            ->whereNotNull('consumo')
            ->where('consumo', '>', 0)
            ->orderByDesc('data_leitura')
            ->limit(6)
            ->pluck('consumo');

        return $consumos->isEmpty() ? 0.0 : (float) $consumos->avg();
    }


    /**
     * Gera código único da fatura: FAT-AAAAMM-XXXXX
     */
    public function gerarCodigoFatura(string $mesReferencia): string
    {
        // mes_referencia vem como '05/2026' → converte para '202605'
        // $mesAno = str_replace('/', '', $mesReferencia);
        // $mesAno = strlen($mesAno) === 6 ? $mesAno : now()->format('Ym');

        // $sequencia = Faturas::where('codigo_fatura', 'like', "FAT-{$mesAno}-%")
        //     ->count() + 1;

        // return sprintf("FAT-%s-%05d", $mesAno, $sequencia);

        // Ex.: "2026-06" -> "202606"
        $mesAno = str_replace('-', '', substr($mesReferencia, 0, 7));

        $ultima = Faturas::where('codigo_fatura', 'like', "FAT-{$mesAno}-%")
            ->orderByDesc('codigo_fatura')
            ->first();

        $sequencia = 1;

        if ($ultima) {
            $partes = explode('-', $ultima->codigo_fatura);
            $sequencia = (int) end($partes) + 1;
        }

        return sprintf("FAT-%s-%05d", $mesAno, $sequencia);
    }


    /**
     * Calcula data de início do período de faturamento
     * (1 dia após o fim do período da última fatura, ou 30 dias antes se for a primeira)
     */
    private function calcularPeriodoInicio(int $clienteId, Carbon $periodoFim): Carbon
    {
        $ultimaFatura = Faturas::where('cliente_id', $clienteId)
            ->latest('periodo_fim')
            ->first();

        if ($ultimaFatura && $ultimaFatura->periodo_fim) {
            return $ultimaFatura->periodo_fim->copy()->addDay();
        }

        // Primeira fatura: período de 30 dias antes
        return $periodoFim->copy()->subDays(30);
    }


    /**
     * ============================================================
     * MÉTODOS PARA CONSULTA / RELATÓRIO
     * ============================================================
     */

    /**
     * Busca faturas pendentes de um cliente com cálculo de juros ao dia
     */
    public function faturasPendentesComJuros(int $clienteId): array
    {
        $hoje = now();

        return Faturas::where('cliente_id', $clienteId)
            ->whereIn('status', ['Pendente', 'Vencida'])
            ->get()
            ->map(function (Faturas $fatura) use ($hoje) {
                $diasAtraso = $fatura->data_vencimento->isPast()
                    ? $fatura->data_vencimento->diffInDays($hoje)
                    : 0;

                // Juros simples: 0.033% ao dia (1% ao mês) — ajuste conforme sua configuração
                $taxaJurosDiaria = 0.00033;
                $jurosCalculados = $diasAtraso > 0
                    ? $fatura->valor_total * $taxaJurosDiaria * $diasAtraso
                    : 0;

                return [
                    'fatura' => $fatura,
                    'dias_atraso' => $diasAtraso,
                    'juros_calculados' => round($jurosCalculados, 2),
                    'valor_com_juros' => round($fatura->valor_total + $jurosCalculados, 2),
                ];
            })
            ->toArray();
    }



    public function atualizarMultasEJuros(Faturas $fatura): void
    {
        // Se a fatura já foi paga, não há o que recalcular
        if (in_array($fatura->status, ['Pago', 'Parcial', 'Negociada', 'Cancelada', 'Estornada', 'Quitada'])) {
            return;
        }

        $hoje = now()->startOfDay();
        $dataVencimento = Carbon::parse($fatura->data_vencimento); // Ex: 31/05/2026

        // 1º Dia do próximo mês (Quando teoricamente começaria a multa)
        $dataInicioMulta = $dataVencimento->copy()->addMonth()->startOfMonth(); // Ex: 01/06/2026

        // Busca as configurações financeiras do banco
        $config = ConfiguracaoFinanceira::where('id', 1)->first();
        $diasTolerancia = $config ? (int) $config->dias_tolerancia : 5; // Usa o banco ou padrão 5

        // Calcula até que dia o cliente pode pagar sem juros/multa (Data Limite da Tolerância)
        // Ex: 01/06 + 5 dias = Até dia 06/06 ele pode pagar limpo. A multa cobra no dia 07.
        // Se a regra for incluir o dia 1º como dia 1, use ($diasTolerancia - 1)
        $dataLimiteTolerancia = $dataInicioMulta->copy()->addDays($diasTolerancia);

        // Se HOJE ainda está dentro do prazo de tolerância, não cobra nada, mas atualiza o status para Vencida
        if ($hoje->le($dataLimiteTolerancia)) {
            if ($hoje->gt($dataVencimento) && $fatura->status !== 'Vencida') {
                $fatura->update(['status' => 'Vencida']);
            }
            return;
        }

        // --- SE PASSOU DA TOLERÂNCIA, APLICA AS PENALIDADES ---

        $percentualMulta = $config ? (float) $config->multa_atraso : 2.00;
        $juroMes = $config ? (float) $config->juro_mes : 1.00;
        $percentualJurosDiario = $juroMes / 30; // Converte juro mensal para diário

        // Calcula o subtotal base da fatura
        $subtotalOriginal = $fatura->valor_consumo + $fatura->valor_esgoto + $fatura->taxa_disponibilidade;

        // 1. CÁLCULO DA MULTA FIXA
        $novaMulta = $subtotalOriginal * ($percentualMulta / 100);

        // 2. CÁLCULO DOS JUROS DIÁRIOS
        // Conta quantos dias se passaram DESDE o fim da tolerância até HOJE
        $diasEmAtrasoReal = $dataLimiteTolerancia->diffInDays($hoje);
        $novosJuros = $subtotalOriginal * (($percentualJurosDiario / 100) * $diasEmAtrasoReal);

        // 3. ATUALIZAÇÃO NO BANCO DE DADOS
        $fatura->update([
            'multa' => round($novaMulta, 2),
            'juros' => round($novosJuros, 2),
            'valor_total' => round($subtotalOriginal + $novaMulta + $novosJuros, 2),
            'status' => 'Vencida'
        ]);
    }
}
