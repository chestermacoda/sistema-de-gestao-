<?php

namespace App\Livewire\Admin\Home;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\pagamentos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    // ─── Período selecionado ───────────────────────────────
    public string $periodo = 'mes';

    // ─── Dados dos Cards ───────────────────────────────────
    public array $cards = [];

    // ─── Dados dos Gráficos ────────────────────────────────
    public array $graficoConsumo = [];
    public array $graficoReceita = [];
    public array $graficoZonas = [];
    public array $graficoLeituras = [];
    public array $graficoFaturasStatus = [];
    public array $graficoInadimplencia = [];

    // ─── Alertas e Atividades ──────────────────────────────
    public array $alertas = [];
    public array $atividades = [];

    // ─── Progresso Leituras ────────────────────────────────
    public array $progressoLeituras = [];

    public function mount(): void
    {
        $this->carregarDados();
    }

    public function updatedPeriodo(): void
    {
        $this->carregarDados();
    }

    // ═══════════════════════════════════════════════════════════
    // CARREGAR TODOS OS DADOS
    // ═══════════════════════════════════════════════════════════

    public function carregarDados(): void
    {
        $this->carregarCards();
        $this->carregarGraficoConsumo();
        $this->carregarGraficoReceita();
        $this->carregarGraficoZonas();
        $this->carregarGraficoLeituras();
        $this->carregarGraficoFaturasStatus();
        $this->carregarGraficoInadimplencia();
        $this->carregarAlertas();
        $this->carregarAtividades();
        $this->carregarProgressoLeituras();
    }

    // ═══════════════════════════════════════════════════════════
    // CARDS RESUMIDOS
    // ═══════════════════════════════════════════════════════════

    protected function carregarCards(): void
    {
        $hoje = Carbon::today();
        $inicioPeriodo = $this->getInicioPeriodo();

        // Clientes
        $totalClientes = Cliente::count();
        $clientesAtivos = Cliente::where('status', 'Ativo')->count();
        $clientesNovos = Cliente::where('created_at', '>=', $inicioPeriodo)->count();
        $clientesInadimplentes = Cliente::where('status', 'Inadimplente')->count();

        // Medidores
        $totalMedidores = Medidores::count();
        $medidoresAtivos = Medidores::where('status_inicial', 'instalado')->count();
        $medidoresComProblema = Medidores::whereIn('status_inicial', ['danificado', 'suspeito'])->count();

        // Faturas
        $faturasPendentes = Faturas::whereIn('status', ['Pendente', 'Vencida'])->count();
        $faturasVencidas = Faturas::where('status', 'Vencida')->count();
        $valorPendente = Faturas::whereIn('status', ['Pendente', 'Vencida'])->sum('valor_total');

        // Pagamentos
        $pagamentosPeriodo = Pagamentos::where('created_at', '>=', $inicioPeriodo);
        $totalPagamentos = $pagamentosPeriodo->count();
        $valorPagamentos = $pagamentosPeriodo->sum('valor_pago');
        $ticketMedio = $totalPagamentos > 0 ? $valorPagamentos / $totalPagamentos : 0;

        // Leituras
        $leiturasHoje = Leituras::whereDate('data_leitura', $hoje)->count();
        $leiturasPendentes = Leituras::where('status', 'Pendente')->count();
        $leiturasPeriodo = Leituras::where('created_at', '>=', $inicioPeriodo)->count();

        // Usuários/Equipe
        $totalUsuarios = User::count();
        $usuariosAtivos = User::where('status', 'Ativo')->count();

        // Taxa de inadimplência
        $totalFaturasEmitidas = Faturas::where('created_at', '>=', $inicioPeriodo)->count();
        $taxaInadimplencia = $totalFaturasEmitidas > 0
            ? round(($faturasVencidas / $totalFaturasEmitidas) * 100, 1)
            : 0;

        $this->cards = [
            'clientes' => [
                'titulo' => 'Clientes Ativos',
                'valor' => number_format($clientesAtivos, 0, ',', '.'),
                'subtitulo' => "de {$totalClientes} cadastrados",
                'tendencia' => $clientesNovos > 0 ? "+{$clientesNovos} novos" : 'Estável',
                'tendencia_tipo' => $clientesNovos > 0 ? 'positivo' : 'neutro',
                'icone' => 'users',
                'cor' => 'primary',
                'rota' => 'admin.clientes',
                'alerta' => $clientesInadimplentes > 0 ? "{$clientesInadimplentes} inadimplentes" : null,
            ],
            'receita' => [
                'titulo' => 'Receita ' . $this->getLabelPeriodo(),
                'valor' => 'MZN ' . number_format($valorPagamentos, 2, ',', '.'),
                'subtitulo' => "{$totalPagamentos} pagamentos",
                'tendencia' => 'Ticket médio: MZN ' . number_format($ticketMedio, 2, ',', '.'),
                'tendencia_tipo' => 'neutro',
                'icone' => 'dollar',
                'cor' => 'success',
                'rota' => 'admin.pagamentos',
                'alerta' => $valorPendente > 0 ? 'MZN ' . number_format($valorPendente, 2, ',', '.') . ' em aberto' : null,
            ],
            'medidores' => [
                'titulo' => 'Medidores Ativos',
                'valor' => number_format($medidoresAtivos, 0, ',', '.'),
                'subtitulo' => "de {$totalMedidores} instalados",
                'tendencia' => $medidoresComProblema > 0 ? "{$medidoresComProblema} com problema" : 'Todos OK',
                'tendencia_tipo' => $medidoresComProblema > 0 ? 'negativo' : 'positivo',
                'icone' => 'gauge',
                'cor' => 'tertiary',
                'rota' => 'admin.medidores',
                'alerta' => null,
            ],
            'faturas' => [
                'titulo' => 'Faturas Pendentes',
                'valor' => number_format($faturasPendentes, 0, ',', '.'),
                'subtitulo' => "{$faturasVencidas} vencidas",
                'tendencia' => $taxaInadimplencia . '% inadimplência',
                'tendencia_tipo' => $taxaInadimplencia > 15 ? 'negativo' : ($taxaInadimplencia > 5 ? 'alerta' : 'positivo'),
                'icone' => 'file-text',
                'cor' => 'warning',
                'rota' => 'admin.faturas',
                'alerta' => $faturasVencidas > 0 ? "{$faturasVencidas} vencidas" : null,
            ],
            'leituras' => [
                'titulo' => 'Leituras Hoje',
                'valor' => number_format($leiturasHoje, 0, ',', '.'),
                'subtitulo' => "{$leiturasPendentes} pendentes",
                'tendencia' => $leiturasPeriodo . ' no período',
                'tendencia_tipo' => 'neutro',
                'icone' => 'activity',
                'cor' => 'purple',
                'rota' => 'admin.leituras',
                'alerta' => $leiturasPendentes > 100 ? "{$leiturasPendentes} pendentes" : null,
            ],
            'equipe' => [
                'titulo' => 'Equipe Ativa',
                'valor' => number_format($usuariosAtivos, 0, ',', '.'),
                'subtitulo' => "de {$totalUsuarios} usuários",
                'tendencia' => 'Sistema operacional',
                'tendencia_tipo' => 'positivo',
                'icone' => 'users-round',
                'cor' => 'secondary',
                'rota' => 'admin.usuarios',
                'alerta' => null,
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // GRÁFICO 1: CONSUMO MENSAL (m³)
    // ═══════════════════════════════════════════════════════════

    protected function carregarGraficoConsumo(): void
    {
        $meses = [];
        $consumoReal = [];
        $consumoPrevisto = [];
        $meta = [];

        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $meses[] = $data->translatedFormat('M/y');

            $consumo = Leituras::whereYear('data_leitura', $data->year)
                ->whereMonth('data_leitura', $data->month)
                ->sum('consumo');

            $consumoReal[] = (float) $consumo;
            $consumoPrevisto[] = (float) ($consumo * 1.05);
            $meta[] = (float) ($consumo * 0.95);
        }

        $this->graficoConsumo = [
            'labels' => $meses,
            'datasets' => [
                [
                    'label' => 'Consumo Real (m³)',
                    'data' => $consumoReal,
                    'borderColor' => '#003366',
                    'backgroundColor' => 'rgba(0, 51, 102, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Projeção',
                    'data' => $consumoPrevisto,
                    'borderColor' => '#00838f',
                    'backgroundColor' => 'transparent',
                    'borderDash' => [5, 5],
                    'tension' => 0.4,
                    'pointRadius' => 0,
                ],
                [
                    'label' => 'Meta',
                    'data' => $meta,
                    'borderColor' => '#059669',
                    'backgroundColor' => 'transparent',
                    'borderDash' => [2, 2],
                    'tension' => 0.4,
                    'pointRadius' => 0,
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // GRÁFICO 2: RECEITA vs INADIMPLÊNCIA vs LÍQUIDO
    // ═══════════════════════════════════════════════════════════

    protected function carregarGraficoReceita(): void
    {
        $meses = [];
        $receita = [];
        $inadimplencia = [];
        $liquido = [];

        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $meses[] = $data->translatedFormat('M/y');

            $rec = Faturas::whereYear('created_at', $data->year)
                ->whereMonth('created_at', $data->month)
                ->where('status', 'Pago')
                ->sum('valor_total');

            $inad = Faturas::whereYear('created_at', $data->year)
                ->whereMonth('created_at', $data->month)
                ->whereIn('status', ['Vencida', 'Pendente'])
                ->sum('valor_total');

            $receita[] = (float) $rec;
            $inadimplencia[] = (float) $inad;
            $liquido[] = (float) ($rec - ($inad * 0.3));
        }

        $this->graficoReceita = [
            'labels' => $meses,
            'datasets' => [
                [
                    'label' => 'Receita (MZN)',
                    'data' => $receita,
                    'backgroundColor' => '#003366',
                    'borderRadius' => 6,
                    'barPercentage' => 0.6,
                ],
                [
                    'label' => 'Inadimplência (MZN)',
                    'data' => $inadimplencia,
                    'backgroundColor' => '#dc2626',
                    'borderRadius' => 6,
                    'barPercentage' => 0.6,
                ],
                [
                    'label' => 'Receita Líquida Est.',
                    'data' => $liquido,
                    'type' => 'line',
                    'borderColor' => '#059669',
                    'backgroundColor' => 'transparent',
                    'borderWidth' => 2,
                    'pointRadius' => 4,
                    'pointBackgroundColor' => '#059669',
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // GRÁFICO 3: DISTRIBUIÇÃO POR ZONA
    // ═══════════════════════════════════════════════════════════

    protected function carregarGraficoZonas(): void
    {
        $zonas = Cliente::select('zona_distribuicao', DB::raw('COUNT(*) as total'))
            ->whereNotNull('zona_distribuicao')
            ->groupBy('zona_distribuicao')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        $labels = [];
        $data = [];
        $cores = ['#003366', '#1a4d7a', '#336699', '#546e7a', '#00838f', '#00acc1'];

        foreach ($zonas as $index => $zona) {
            $labels[] = $zona->zona_distribuicao;
            $data[] = (int) $zona->total;
        }

        $this->graficoZonas = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $cores,
                    'borderWidth' => 0,
                    'hoverOffset' => 8,
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // GRÁFICO 4: LEITURAS POR DIA DA SEMANA
    // ═══════════════════════════════════════════════════════════

    protected function carregarGraficoLeituras(): void
    {
        $diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
        $leituras = [];
        $meta = [];

        for ($i = 0; $i < 7; $i++) {
            $weekday = $i === 0 ? 6 : $i - 1;
            $count = Leituras::whereRaw('WEEKDAY(data_leitura) = ?', [$weekday])
                ->whereBetween('data_leitura', [Carbon::now()->subDays(30), Carbon::now()])
                ->count();

            $leituras[] = (int) $count;
            $meta[] = 150;
        }

        $this->graficoLeituras = [
            'labels' => $diasSemana,
            'datasets' => [
                [
                    'label' => 'Leituras Realizadas',
                    'data' => $leituras,
                    'backgroundColor' => 'rgba(0, 51, 102, 0.8)',
                    'borderColor' => '#003366',
                    'borderWidth' => 1,
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Meta Diária',
                    'data' => $meta,
                    'type' => 'line',
                    'borderColor' => '#d97706',
                    'backgroundColor' => 'transparent',
                    'borderDash' => [5, 5],
                    'pointRadius' => 0,
                    'borderWidth' => 2,
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // GRÁFICO 5: STATUS DAS FATURAS (Donut)
    // ═══════════════════════════════════════════════════════════

    protected function carregarGraficoFaturasStatus(): void
    {
        $statusCount = Faturas::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statusCores = [
            'Pago' => '#059669',
            'Pendente' => '#d97706',
            'Vencida' => '#dc2626',
            'Parcial' => '#00838f',
            'Negociada' => '#7c3aed',
            'Cancelada' => '#94a3b8',
        ];

        $labels = [];
        $data = [];
        $cores = [];

        foreach ($statusCount as $status => $total) {
            $labels[] = $status;
            $data[] = (int) $total;
            $cores[] = $statusCores[$status] ?? '#94a3b8';
        }

        $this->graficoFaturasStatus = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $cores,
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                    'hoverOffset' => 6,
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // GRÁFICO 6: EVOLUÇÃO DA INADIMPLÊNCIA (%)
    // ═══════════════════════════════════════════════════════════

    protected function carregarGraficoInadimplencia(): void
    {
        $meses = [];
        $taxas = [];
        $mediaSetor = [];

        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $meses[] = $data->translatedFormat('M/y');

            $total = Faturas::whereYear('created_at', $data->year)
                ->whereMonth('created_at', $data->month)
                ->count();

            $vencidas = Faturas::whereYear('created_at', $data->year)
                ->whereMonth('created_at', $data->month)
                ->where('status', 'Vencida')
                ->count();

            $taxa = $total > 0 ? round(($vencidas / $total) * 100, 1) : 0;
            $taxas[] = (float) $taxa;
            $mediaSetor[] = 12.5;
        }

        $this->graficoInadimplencia = [
            'labels' => $meses,
            'datasets' => [
                [
                    'label' => 'Taxa de Inadimplência (%)',
                    'data' => $taxas,
                    'borderColor' => '#dc2626',
                    'backgroundColor' => 'rgba(220, 38, 38, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#dc2626',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 5,
                ],
                [
                    'label' => 'Média do Setor (%)',
                    'data' => $mediaSetor,
                    'borderColor' => '#94a3b8',
                    'backgroundColor' => 'transparent',
                    'borderDash' => [5, 5],
                    'tension' => 0.4,
                    'pointRadius' => 0,
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // ALERTAS DO SISTEMA
    // ═══════════════════════════════════════════════════════════

    protected function carregarAlertas(): void
    {
        $alertas = [];

        // Anomalias de consumo
        $mediaConsumo = Leituras::avg('consumo') ?: 0;
        $anomalias = Leituras::where('consumo', '>', $mediaConsumo * 3)
            ->with('medidor.cliente')
            ->latest()
            ->take(2)
            ->get();

        foreach ($anomalias as $leitura) {
            $cliente = $leitura->medidor->cliente ?? null;
            if ($cliente) {
                $alertas[] = [
                    'tipo' => 'danger',
                    'titulo' => 'Consumo anormal detectado',
                    'descricao' => "Cliente {$cliente->nome_completo} — Consumo 300% acima da média",
                    'tempo' => 'Há ' . rand(5, 60) . ' minutos',
                    'icone' => 'alert-triangle',
                ];
            }
        }

        // Faturas vencidas críticas
        $faturasCriticas = Faturas::where('status', 'Vencida')
            ->where('data_vencimento', '<', Carbon::now()->subDays(30))
            ->with('cliente')
            ->take(2)
            ->get();

        foreach ($faturasCriticas as $fatura) {
            $cliente = $fatura->cliente ?? null;
            if ($cliente) {
                $alertas[] = [
                    'tipo' => 'warning',
                    'titulo' => 'Fatura crítica vencida',
                    'descricao' => "Cliente {$fatura->cliente->nome_completo} — MZN " . number_format($fatura->valor_total, 2, ',', '.'),
                    'tempo' => 'Vencida há ' . $fatura->data_vencimento->diffInDays(Carbon::now()) . ' dias',
                    'icone' => 'file-warning',
                ];
            }
        }

        // Medidores com problema
        $medidoresProblema = Medidores::whereIn('status_inicial', ['danificado', 'suspeito'])
            ->take(2)
            ->get();

        foreach ($medidoresProblema as $medidor) {
            $alertas[] = [
                'tipo' => 'info',
                'titulo' => 'Medidor necessita atenção',
                'descricao' => "Medidor #{$medidor->numero_serie} — Status: {$medidor->status_inicial}",
                'tempo' => 'Verificação pendente',
                'icone' => 'gauge',
            ];
        }

        $this->alertas = $alertas;
    }

    // ═══════════════════════════════════════════════════════════
    // ATIVIDADES RECENTES
    // ═══════════════════════════════════════════════════════════

    protected function carregarAtividades(): void
    {
        $atividades = [];

        // Últimas leituras
        $leituras = Leituras::with(['medidor.cliente'])
            ->latest()
            ->take(3)
            ->get();

        foreach ($leituras as $leitura) {
            $cliente = $leitura->medidor->cliente ?? null;
            $atividades[] = [
                'tipo' => 'leitura',
                'acao' => 'Leitura registrada',
                'referencia' => $cliente ? $cliente->nome_completo : 'Cliente #' . $leitura->medidor->cliente_id,
                'status' => 'Concluído',
                'status_classe' => 'success',
                'hora' => $leitura->created_at->format('H:i'),
                'cor_dot' => '#059669',
            ];
        }

        // Últimos pagamentos
        $pagamentos = Pagamentos::with('cliente')
            ->latest()
            ->take(3)
            ->get();

        foreach ($pagamentos as $pagamento) {
            $atividades[] = [
                'tipo' => 'pagamento',
                'acao' => 'Pagamento recebido',
                'referencia' => $pagamento->cliente ? $pagamento->cliente->nome_completo : 'Cliente #' . $pagamento->cliente_id,
                'status' => 'Confirmado',
                'status_classe' => 'success',
                'hora' => $pagamento->created_at->format('H:i'),
                'valor' => 'MZN ' . number_format($pagamento->valor_pago, 2, ',', '.'),
                'cor_dot' => '#00838f',
            ];
        }

        // Últimas faturas
        $faturas = Faturas::with('cliente')
            ->latest()
            ->take(2)
            ->get();

        foreach ($faturas as $fatura) {
            $atividades[] = [
                'tipo' => 'fatura',
                'acao' => 'Fatura gerada',
                'referencia' => $fatura->cliente ? $fatura->cliente->nome_completo : 'Cliente #' . $fatura->cliente_id,
                'status' => $fatura->status,
                'status_classe' => strtolower($fatura->status) === 'pago' ? 'success' : 'info',
                'hora' => $fatura->created_at->format('H:i'),
                'cor_dot' => '#003366',
            ];
        }

        usort($atividades, function ($a, $b) {
            return strcmp($b['hora'], $a['hora']);
        });

        $this->atividades = array_slice($atividades, 0, 6);
    }

    // ═══════════════════════════════════════════════════════════
    // PROGRESSO DAS LEITURAS
    // ═══════════════════════════════════════════════════════════

    protected function carregarProgressoLeituras(): void
    {
        $hoje = Carbon::today();
        $totalMeta = 1200;

        $realizadasHoje = Leituras::whereDate('data_leitura', $hoje)->count();
        $percentual = $totalMeta > 0 ? round(($realizadasHoje / $totalMeta) * 100, 1) : 0;

        $categorias = [
            'Residencial' => Cliente::where('categoria_consumo', 'Residencial')->count(),
            'Comercial' => Cliente::where('categoria_consumo', 'Comercial')->count(),
            'Industrial' => Cliente::where('categoria_consumo', 'Industrial')->count(),
        ];

        $leiturasPorCategoria = [];
        foreach ($categorias as $cat => $total) {
            $realizadas = Leituras::whereHas('medidor.cliente', function ($q) use ($cat) {
                $q->where('categoria_consumo', $cat);
            })->whereDate('data_leitura', $hoje)->count();

            $leiturasPorCategoria[] = [
                'nome' => $cat,
                'realizadas' => $realizadas,
                'total' => $total,
                'percentual' => $total > 0 ? round(($realizadas / $total) * 100, 1) : 0,
                'cor' => match ($cat) {
                    'Residencial' => 'success',
                    'Comercial' => 'tertiary',
                    'Industrial' => 'warning',
                    default => 'primary',
                },
            ];
        }

        $this->progressoLeituras = [
            'realizadas' => $realizadasHoje,
            'meta' => $totalMeta,
            'percentual' => $percentual,
            'categorias' => $leiturasPorCategoria,
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════════

    protected function getInicioPeriodo(): Carbon
    {
        return match ($this->periodo) {
            'mes' => Carbon::now()->startOfMonth(),
            'trimestre' => Carbon::now()->startOfQuarter(),
            'semestre' => Carbon::now()->subMonths(6)->startOfMonth(),
            'ano' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfMonth(),
        };
    }

    protected function getLabelPeriodo(): string
    {
        return match ($this->periodo) {
            'mes' => 'do Mês',
            'trimestre' => 'do Trimestre',
            'semestre' => 'do Semestre',
            'ano' => 'do Ano',
            default => 'do Mês',
        };
    }




    public function render()
    {
        return view('Livewire.admin.Home.Index');
    }
}
