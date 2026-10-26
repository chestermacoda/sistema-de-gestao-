<?php

namespace App\Repositories;

use App\Models\Fatura;
use App\Models\Faturas;
use App\Models\Leitura;
use App\Models\Leituras;
use App\Models\RelatorioAnalitico;
use App\Models\relatorios_analiticos;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RelatorioRepository
{
    /**
     * Busca um relatório analítico pelo ID (com resumo já gravado).
     */
    public function findAnalitico(int $id): ?relatorios_analiticos
    {
        return relatorios_analiticos::with('user')->find($id);
    }

    /**
     * Resolve o intervalo de datas a partir do relatório ou dos filtros.
     */
    public function resolverPeriodo(?string $dataInicio, ?string $dataFim, string $periodo = 'ano'): array
    {
        if ($dataInicio && $dataFim) {
            return [Carbon::parse($dataInicio)->startOfDay(), Carbon::parse($dataFim)->endOfDay()];
        }

        $agora = now();

        return match ($periodo) {
            'mes'       => [$agora->copy()->startOfMonth(), $agora->copy()->endOfMonth()],
            'trimestre' => [$agora->copy()->startOfQuarter(), $agora->copy()->endOfQuarter()],
            'semestre'  => [
                $agora->month <= 6
                    ? $agora->copy()->startOfYear()
                    : $agora->copy()->startOfYear()->addMonths(6),
                $agora->month <= 6
                    ? $agora->copy()->startOfYear()->addMonths(5)->endOfMonth()
                    : $agora->copy()->endOfYear(),
            ],
            default     => [$agora->copy()->startOfYear(), $agora->copy()->endOfYear()],
        };
    }

    /**
     * Dados principais de estatísticas (cards).
     */
    public function getStats(Carbon $inicio, Carbon $fim): array
    {
        // Total Faturado no Regime de Competência
        $totalFaturado = (float) Faturas::whereBetween('mes_referencia', [$inicio, $fim])
            ->where('valor_total', '>', 0)
            ->sum('valor_total');

        // Total Efetivamente Arrecadado (Faturas Pagas ou Parciais no período)
        $totalArrecadado = (float) DB::table('pagamentos')
            ->whereBetween('data_pagamento', [$inicio, $fim])
            ->sum('valor_pago');

        // Volume Total Consumido
        $volume = (float) Leituras::whereBetween('mes_referencia', [$inicio, $fim])
            ->where('status', 'validada')
            ->sum('consumo');

        // Inadimplência Acumulada no Período
        $inadimplenciaTotal = (float) Faturas::whereIn('status', ['Pendente', 'Parcial', 'Vencida'])
            ->where('data_vencimento', '<', now())
            ->sum('valor_total');

        // Taxa de Inadimplência (%)
        $taxaInadimplencia = $totalFaturado > 0
            ? round(($inadimplenciaTotal / $totalFaturado) * 100, 2)
            : 0;

        // Ticket Médio por Fatura
        $totalFaturas = Faturas::whereBetween('mes_referencia', [$inicio, $fim])->where('valor_total', '>', 0)->count();
        $ticketMedio = $totalFaturas > 0 ? round($totalFaturado / $totalFaturas, 2) : 0;

        return [
            'faturamento'          => $totalFaturado,
            'faturamento_fmt'      => 'MT ' . number_format($totalFaturado, 2, ',', '.'),
            'arrecadacao'          => $totalArrecadado,
            'arrecadacao_fmt'      => 'MT ' . number_format($totalArrecadado, 2, ',', '.'),
            'volume'               => $volume,
            'volume_fmt'           => number_format($volume, 2, ',', '.') . ' m³',
            'inadimplencia'        => $inadimplenciaTotal,
            'inadimplencia_fmt'    => 'MT ' . number_format($inadimplenciaTotal, 2, ',', '.'),
            'taxa_inadimplencia'   => $taxaInadimplencia,
            'taxa_inadimplencia_fmt' => $taxaInadimplencia . '%',
            'ticket_medio'         => $ticketMedio,
            'ticket_medio_fmt'     => 'MT ' . number_format($ticketMedio, 2, ',', '.'),
            'periodo_inicio'       => $inicio->format('d/m/Y'),
            'periodo_fim'          => $fim->format('d/m/Y'),
        ];
    }

    /**
     * Gráfico Comparativo: Faturado vs Arrecadado Mensal.
     */
    public function getComparativoFaturadoVsArrecadado(Carbon $inicio, Carbon $fim): Collection
    {
        $faturado = Faturas::select(
            DB::raw("DATE_FORMAT(mes_referencia, '%Y-%m') as mes"),
            DB::raw('SUM(valor_total) as faturado')
        )
            ->whereBetween('mes_referencia', [$inicio, $fim])
            ->groupBy('mes')
            ->get()
            ->keyBy('mes');

        $arrecadado = DB::table('pagamentos')
            ->select(
                DB::raw("DATE_FORMAT(data_pagamento, '%Y-%m') as mes"),
                DB::raw('SUM(valor_pago) as arrecadado')
            )
            ->whereBetween('data_pagamento', [$inicio, $fim])
            ->groupBy('mes')
            ->get()
            ->keyBy('mes');

        $meses = $faturado->keys()->merge($arrecadado->keys())->unique()->sort();

        return $meses->map(function ($mes) use ($faturado, $arrecadado) {
            $c = Carbon::createFromFormat('Y-m', $mes);
            $fat = $faturado->get($mes)->faturado ?? 0;
            $arr = $arrecadado->get($mes)->arrecadado ?? 0;

            return [
                'mes'        => $c->translatedFormat('M/Y'),
                'mes_key'    => $mes,
                'faturado'   => (float) $fat,
                'arrecadado' => (float) $arr,
                'saldo'      => (float) ($fat - $arr),
            ];
        });
    }

    /**
     * Gráfico de Distribuição por Status das Faturas (Pizza/Donut).
     */
    public function getDistribuicaoStatusFaturas(Carbon $inicio, Carbon $fim): Collection
    {
        return Faturas::query()
            ->whereBetween('mes_referencia', [$inicio, $fim])
            ->select('status', DB::raw('COUNT(*) as qtd'), DB::raw('SUM(valor_total) as total'))
            ->groupBy('status')
            ->get()
            ->map(function ($row) {
                return [
                    'status' => $row->status,
                    'qtd'    => (int) $row->qtd,
                    'total'  => (float) $row->total,
                ];
            });
    }
    /**
     * Aging de Inadimplência (Análise de Dívidas por Período de Atraso).
     */
    public function getAgingInadimplencia(): array
    {
        $faturas = Faturas::whereIn('status', ['Pendente', 'Parcial', 'Vencida'])
            ->where('data_vencimento', '<', now())
            ->get();

        $aging = [
            'ate_30_dias'   => 0,
            '31_a_60_dias'  => 0,
            '61_a_90_dias'  => 0,
            'acima_90_dias' => 0,
        ];

        foreach ($faturas as $fatura) {
            $dias = Carbon::parse($fatura->data_vencimento)->diffInDays(now());
            $val = (float) ($fatura->saldo_atual ?? $fatura->valor_total);

            if ($dias <= 30) {
                $aging['ate_30_dias'] += $val;
            } elseif ($dias <= 60) {
                $aging['31_a_60_dias'] += $val;
            } elseif ($dias <= 90) {
                $aging['61_a_90_dias'] += $val;
            } else {
                $aging['acima_90_dias'] += $val;
            }
        }

        return $aging;
    }

    /**
     * Aba/Listagem Completa de Clientes com Faturas, Leitura e Histórico de Saldos.
     */
    public function getListagemClientesFaturas(
        Carbon $inicio,
        Carbon $fim,
        ?string $search = null,
        ?string $statusFatura = null,
        int $perPage = 15
    ) {
        $query = DB::table('clientes')
            ->leftJoin('faturas', 'clientes.id', '=', 'faturas.cliente_id')
            ->leftJoin('leituras', 'faturas.leitura_id', '=', 'leituras.id')
            ->whereBetween('faturas.mes_referencia', [$inicio, $fim])
            ->select(
                'clientes.id as cliente_id',
                'clientes.nome_completo',
                'clientes.numero_matricula',
                'clientes.zona_distribuicao',
                'clientes.categoria_consumo',
                'faturas.codigo_fatura',
                'faturas.mes_referencia',
                'faturas.valor_total',
                'faturas.status as status_fatura',
                'faturas.data_vencimento',
                'leituras.consumo as consumo_m3'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('clientes.nome_completo', 'like', "%{$search}%")
                    ->orWhere('clientes.numero_matricula', 'like', "%{$search}%")
                    ->orWhere('faturas.codigo_fatura', 'like', "%{$search}%");
            });
        }

        if ($statusFatura) {
            $query->where('faturas.status', $statusFatura);
        }

        return $query->orderByDesc('faturas.mes_referencia')->paginate($perPage);
    }


    /**
     * Faturamento mensal (para gráfico / tabela).
     */
    public function getFaturamentoMensal(Carbon $inicio, Carbon $fim): Collection
    {
        return Faturas::select(
            DB::raw("DATE_FORMAT(mes_referencia, '%Y-%m') as mes"),
            DB::raw('SUM(valor_total) as total'),
            DB::raw('SUM(consumo_m3) as volume')
        )
            ->whereBetween('mes_referencia', [$inicio, $fim])
            ->where('valor_total', '>', 0)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(function ($row) {
                $c = Carbon::createFromFormat('Y-m', $row->mes);
                return [
                    'mes'    => $c->translatedFormat('M/Y'),
                    'mes_key' => $row->mes,
                    'total'  => (float) $row->total,
                    'volume' => (float) $row->volume,
                ];
            });
    }

    /**
     * Composição da receita por categoria de consumo.
     */
    public function getComposicaoReceita(Carbon $inicio, Carbon $fim): Collection
    {
        return Faturas::query()
            ->join('clientes', 'faturas.cliente_id', '=', 'clientes.id')
            ->whereBetween('faturas.mes_referencia', [$inicio, $fim])
            ->where('faturas.valor_total', '>', 0)
            ->select(
                'clientes.categoria_consumo as categoria',
                DB::raw('SUM(faturas.valor_total) as total'),
                DB::raw('SUM(faturas.consumo_m3) as volume'),
                DB::raw('COUNT(DISTINCT faturas.cliente_id) as clientes')
            )
            ->groupBy('clientes.categoria_consumo')
            ->get()
            ->map(function ($row) {
                return [
                    'categoria' => $row->categoria ?? 'Outros',
                    'total'     => (float) $row->total,
                    'volume'    => (float) $row->volume,
                    'clientes'  => (int) $row->clientes,
                ];
            });
    }

    /**
     * Detalhamento financeiro por mês e categoria.
     */
    public function getDetalheFinanceiro(Carbon $inicio, Carbon $fim): Collection
    {
        return Faturas::query()
            ->join('clientes', 'faturas.cliente_id', '=', 'clientes.id')
            ->whereBetween('faturas.mes_referencia', [$inicio, $fim])
            ->where('faturas.valor_total', '>', 0)
            ->select(
                DB::raw("DATE_FORMAT(faturas.mes_referencia, '%Y-%m') as mes"),
                'clientes.categoria_consumo as categoria',
                DB::raw('SUM(faturas.valor_total) as total'),
                DB::raw('SUM(faturas.consumo_m3) as volume')
            )
            ->groupBy('mes', 'clientes.categoria_consumo')
            ->orderBy('mes')
            ->get()
            ->map(function ($row) {
                $c = Carbon::createFromFormat('Y-m', $row->mes);
                return [
                    'mes'       => $c->translatedFormat('F/Y'),
                    'mes_key'   => $row->mes,
                    'categoria' => $row->categoria ?? 'Outros',
                    'total'     => (float) $row->total,
                    'volume'    => (float) $row->volume,
                ];
            });
    }

    /**
     * Consumo por zona de distribuição.
     */
    public function getConsumoPorZona(Carbon $inicio, Carbon $fim, ?string $zona = null): Collection
    {
        $query = Leituras::query()
            ->join('clientes', 'leituras.cliente_id', '=', 'clientes.id')
            ->whereBetween('leituras.mes_referencia', [$inicio, $fim])
            ->where('leituras.status', 'validada')
            ->select(
                DB::raw("COALESCE(clientes.zona_distribuicao, 'Centro') as zona"),
                DB::raw('SUM(leituras.consumo) as total'),
                DB::raw('COUNT(*) as leituras'),
                DB::raw('AVG(leituras.consumo) as media')
            )
            ->groupBy('zona');

        if ($zona) {
            $query->where('clientes.zona_distribuicao', 'like', '%' . str_replace('Zona ', '', $zona) . '%');
        }

        return $query->get()->map(function ($row) {
            $zonaNome = str_replace('Zona ', '', $row->zona);
            return [
                'zona'     => $zonaNome,
                'total'    => (float) $row->total,
                'leituras' => (int) $row->leituras,
                'media'    => round((float) $row->media, 2),
            ];
        });
    }

    /**
     * Ranking de inadimplência (faturas em aberto).
     */
    public function getInadimplenciaDetalhe(?string $zona = null, int $limit = 50): Collection
    {
        $query = Faturas::query()
            ->with(['cliente'])
            ->whereIn('status', ['Pendente', 'Parcial', 'Vencida'])
            ->where('data_vencimento', '<', now())
            ->where('valor_total', '>', 0)
            ->orderByDesc('valor_total')
            ->limit($limit);

        if ($zona) {
            $query->whereHas('cliente', function ($q) use ($zona) {
                $q->where('zona_distribuicao', 'like', '%' . str_replace('Zona ', '', $zona) . '%');
            });
        }

        return $query->get()->map(function ($f) {
            $meses = max(1, (int) Carbon::parse($f->data_vencimento)->diffInMonths(now()));
            return [
                'cliente'       => $f->cliente->nome_completo ?? 'Cliente #' . $f->cliente_id,
                'matricula'      => $f->cliente->numero_matricula ?? '—',
                'codigo_fatura' => $f->codigo_fatura,
                'valor'         => (float) $f->valor_total,
                'saldo'         => (float) ($f->saldo_atual ?? $f->valor_total),
                'meses_atraso'  => $meses,
                'vencimento'    => Carbon::parse($f->data_vencimento)->format('d/m/Y'),
                'status'        => $f->status,
                'zona'          => $f->cliente->zona_distribuicao ?? '—',
                'categoria'     => $f->cliente->categoria_consumo ?? '—',
            ];
        });
    }

    /**
     * Evolução mensal da inadimplência.
     */
    public function getInadimplenciaMensal(Carbon $inicio, Carbon $fim): Collection
    {
        return Faturas::select(
            DB::raw("DATE_FORMAT(data_vencimento, '%Y-%m') as mes"),
            DB::raw('SUM(valor_total) as total'),
            DB::raw('COUNT(*) as quantidade')
        )
            ->whereIn('status', ['Pendente', 'Parcial', 'Vencida'])
            ->whereBetween('data_vencimento', [$inicio, $fim])
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(function ($row) {
                $c = Carbon::createFromFormat('Y-m', $row->mes);
                return [
                    'mes'        => $c->translatedFormat('M/Y'),
                    'mes_key'    => $row->mes,
                    'total'      => (float) $row->total,
                    'quantidade' => (int) $row->quantidade,
                ];
            });
    }

    /**
     * Eficiência por leiturista.
     */
    public function getEficienciaLeituristas(Carbon $inicio, Carbon $fim): Collection
    {
        return DB::table('roteiro_leituristas')
            ->join('users', 'roteiro_leituristas.user_id', '=', 'users.id')
            ->whereBetween('roteiro_leituristas.data_referente', [$inicio, $fim])
            ->select(
                'users.name as leiturista',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN roteiro_leituristas.status = 'Concluido' THEN 1 ELSE 0 END) as lidos"),
                DB::raw("SUM(CASE WHEN roteiro_leituristas.status = 'Problema' THEN 1 ELSE 0 END) as problemas")
            )
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('lidos')
            ->get()
            ->map(function ($r) {
                $eficiencia = $r->total > 0 ? round(($r->lidos / $r->total) * 100, 1) : 0;
                return [
                    'leiturista' => $r->leiturista,
                    'total'      => (int) $r->total,
                    'lidos'      => (int) $r->lidos,
                    'problemas'  => (int) $r->problemas,
                    'eficiencia' => $eficiencia,
                ];
            });
    }

    /**
     * Performance dos roteiros por zona.
     */
    public function getPerformanceRoteiros(Carbon $inicio, Carbon $fim): Collection
    {
        return DB::table('roteiro_leituristas')
            ->join('users', 'roteiro_leituristas.user_id', '=', 'users.id')
            ->whereBetween('roteiro_leituristas.data_referente', [$inicio, $fim])
            ->select(
                'roteiro_leituristas.Zona as zona',
                'users.name as leiturista',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status = 'Concluido' THEN 1 ELSE 0 END) as lidos"),
                DB::raw("SUM(CASE WHEN status = 'Problema' THEN 1 ELSE 0 END) as anomalias")
            )
            ->groupBy('zona', 'users.name')
            ->orderBy('zona')
            ->get()
            ->map(function ($r) {
                $eficiencia = $r->total > 0 ? round(($r->lidos / $r->total) * 100, 1) : 0;
                return [
                    'zona'       => $r->zona ?: 'Geral',
                    'leiturista' => $r->leiturista,
                    'total'      => (int) $r->total,
                    'lidos'      => (int) $r->lidos,
                    'anomalias'  => (int) $r->anomalias,
                    'eficiencia' => $eficiencia,
                ];
            });
    }

    /**
     * Monta o pacote completo de dados conforme o tipo de relatório.
     */
    // public function getDadosPorTipo(
    //     string $tipo,
    //     Carbon $inicio,
    //     Carbon $fim,
    //     ?string $zona = null,
    //     ?string $categoria = null
    // ): array {
    //     $stats = $this->getStats($inicio, $fim);

    //     $base = [
    //         'tipo'           => $tipo,
    //         'titulo'         => $this->tituloPorTipo($tipo),
    //         'periodo_inicio' => $inicio->format('d/m/Y'),
    //         'periodo_fim'    => $fim->format('d/m/Y'),
    //         'gerado_em'      => now()->format('d/m/Y H:i'),
    //         'stats'          => $stats,
    //     ];

    //     return match ($tipo) {
    //         'financeiro' => array_merge($base, [
    //             'faturamento_mensal' => $this->getFaturamentoMensal($inicio, $fim)->toArray(),
    //             'composicao'         => $this->getComposicaoReceita($inicio, $fim)->toArray(),
    //             'detalhe'            => $this->getDetalheFinanceiro($inicio, $fim)->toArray(),
    //         ]),
    //         'consumo' => array_merge($base, [
    //             'por_zona' => $this->getConsumoPorZona($inicio, $fim, $zona)->toArray(),
    //         ]),
    //         'inadimplencia' => array_merge($base, [
    //             'mensal'  => $this->getInadimplenciaMensal($inicio, $fim)->toArray(),
    //             'detalhe' => $this->getInadimplenciaDetalhe($zona)->toArray(),
    //         ]),
    //         'operacional' => array_merge($base, [
    //             'leituristas' => $this->getEficienciaLeituristas($inicio, $fim)->toArray(),
    //             'roteiros'    => $this->getPerformanceRoteiros($inicio, $fim)->toArray(),
    //         ]),
    //         default => array_merge($base, [ // geral / visão geral
    //             'faturamento_mensal' => $this->getFaturamentoMensal($inicio, $fim)->toArray(),
    //             'composicao'         => $this->getComposicaoReceita($inicio, $fim)->toArray(),
    //             'por_zona'           => $this->getConsumoPorZona($inicio, $fim, $zona)->toArray(),
    //             'inadimplencia'      => $this->getInadimplenciaDetalhe($zona, 20)->toArray(),
    //             'leituristas'        => $this->getEficienciaLeituristas($inicio, $fim)->toArray(),
    //         ]),
    //     };
    // }
    public function getDadosPorTipo(
        string $tipo,
        Carbon $inicio,
        Carbon $fim,
        ?string $zona = null,
        ?string $categoria = null
    ): array {
        $stats = $this->getStats($inicio, $fim);

        $base = [
            'tipo'           => $tipo,
            'titulo'         => $this->tituloPorTipo($tipo),
            'periodo_inicio' => $inicio->format('d/m/Y'),
            'periodo_fim'    => $fim->format('d/m/Y'),
            'gerado_em'      => now()->format('d/m/Y H:i'),
            'stats'          => $stats,
        ];

        return match ($tipo) {
            'financeiro' => array_merge($base, [
                'comparativo_mensal' => $this->getComparativoFaturadoVsArrecadado($inicio, $fim)->toArray(),
                'distribuicao_status' => $this->getDistribuicaoStatusFaturas($inicio, $fim)->toArray(),
                'aging_inadimplencia' => $this->getAgingInadimplencia(),
            ]),
            default => array_merge($base, [
                'comparativo_mensal' => $this->getComparativoFaturadoVsArrecadado($inicio, $fim)->toArray(),
                'distribuicao_status' => $this->getDistribuicaoStatusFaturas($inicio, $fim)->toArray(),
                'aging_inadimplencia' => $this->getAgingInadimplencia(),
            ]),
        };
    }
    // protected function tituloPorTipo(string $tipo): string
    // {
    //     return match ($tipo) {
    //         'financeiro'    => 'Relatório Financeiro',
    //         'consumo'       => 'Relatório de Consumo',
    //         'inadimplencia' => 'Relatório de Inadimplência',
    //         'operacional'   => 'Relatório Operacional',
    //         default         => 'Relatório Geral',
    //     };
    // }

    protected function tituloPorTipo(string $tipo): string
    {
        return match ($tipo) {
            'financeiro'    => 'Relatório Financeiro Completo',
            'consumo'       => 'Relatório de Consumo e Leitura',
            'inadimplencia' => 'Relatório de Gestão de Inadimplência',
            'operacional'   => 'Relatório Operacional de Campo',
            default         => 'Relatório Executivo Geral',
        };
    }
}
