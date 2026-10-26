<?php

namespace App\Livewire\Admin\Mobile\Clientes;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\Leituras;
use App\Models\pagamentos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    // ─── Cliente logado ────────────────────────────────────
    protected int $clienteId;
    public ?Cliente $cliente = null;

    // ─── Cards de Resumo ───────────────────────────────────
    public array $cards = [];

    // ─── Consumo Atual ─────────────────────────────────────
    public array $consumoAtual = [];

    // ─── Últimas Faturas ───────────────────────────────────
    public array $ultimasFaturas = [];

    // ─── Últimos Pagamentos ────────────────────────────────
    public array $ultimosPagamentos = [];

    // ─── Alertas ───────────────────────────────────────────
    public array $alertas = [];

    public function mount(): void
    {
        $this->clienteId = Auth::guard('cliente')->user()->id;
        $this->cliente = Cliente::find($this->clienteId);
        $this->carregarDados();
    }

    // ═══════════════════════════════════════════════════════════
    // CARREGAR TODOS OS DADOS
    // ═══════════════════════════════════════════════════════════

    public function carregarDados(): void
    {
        $this->carregarConsumoAtual();
        $this->carregarCards();
        $this->carregarUltimasFaturas();
        $this->carregarUltimosPagamentos();
        $this->carregarAlertas();
    }

    // ═══════════════════════════════════════════════════════════
    // CONSUMO ATUAL (card principal)
    // ═══════════════════════════════════════════════════════════

    protected function carregarConsumoAtual(): void
    {
        $hoje = Carbon::today();
        $inicioMes = $hoje->copy()->startOfMonth();
        $fimMes = $hoje->copy()->endOfMonth();

        // Última leitura do cliente
        $ultimaLeitura = Faturas::where('cliente_id', $this->clienteId)
            ->whereNotNull('consumo_m3')
            ->latest('mes_referencia')
            ->first();

        // Consumo do mês atual (soma de todas as leituras do mês)
        $consumoMes = Leituras::where('cliente_id', $this->clienteId)
            ->whereBetween('data_leitura', [$inicioMes, $fimMes])
            ->sum('consumo') ?: 0;

        // Média mensal dos últimos 6 meses
        $mediaConsumo = Leituras::where('cliente_id', $this->clienteId)
            ->whereBetween('data_leitura', [
                $hoje->copy()->subMonths(6)->startOfMonth(),
                $hoje->copy()->subMonth()->endOfMonth()
            ])
            ->select(DB::raw('SUM(consumo) as total'), DB::raw('COUNT(DISTINCT mes_referencia) as meses'))
            ->first();

        $mediaMensal = ($mediaConsumo && $mediaConsumo->meses > 0)
            ? round($mediaConsumo->total / $mediaConsumo->meses, 0)
            : 75; // fallback

        $percentualMedia = $mediaMensal > 0
            ? min(round(($consumoMes / $mediaMensal) * 100, 1), 100)
            : 0;

        // Período da última leitura ou mês atual
        $periodoInicio = $ultimaLeitura && $ultimaLeitura->periodo_inicio
            ? Carbon::parse($ultimaLeitura->periodo_inicio)->startOfMonth()->format('d/m/Y')
            : $inicioMes->format('d/m/Y');
        $periodoFim = $ultimaLeitura && $ultimaLeitura->periodo_fim
            ? Carbon::parse($ultimaLeitura->periodo_fim)->format('d/m/Y')
            : $hoje->format('d/m/Y');

        // ✅ Corrigido: usa Carbon::parse direto (mais seguro que createFromFormat)
        $dataVencimento = $ultimaLeitura && $ultimaLeitura->periodo_fim
            ? Carbon::parse($ultimaLeitura->periodo_fim)->startOfDay()
            : $fimMes->copy()->startOfDay();

        $dias = Carbon::today()->diffInDays($dataVencimento, false);

        // ✅ Corrigido: valor padrão quando não existe fatura
        $data = $this->getAcoes($ultimaLeitura->status ?? 'Pendente');

        $this->consumoAtual = [
            // ✅ Corrigido: ternário para quando não há fatura
            'valorRestante' => $ultimaLeitura
                ? (float) ($ultimaLeitura->valor_total - $ultimaLeitura->saldo_atual)
                : 0,
            'status' => $ultimaLeitura->status ?? 'Sem faturas',
            'badge' => $data[0],
            'diasRestantes' => $dias,
            'valor_total' => $ultimaLeitura ? (float) $ultimaLeitura->valor_total : 0,
            'mes_ano' => $hoje->translatedFormat('F/Y'),
            'consumo_m3' => (float) $consumoMes,
            'periodo_inicio' => $periodoInicio,
            'periodo_fim' => $periodoFim,
            'media_mensal' => (float) $mediaMensal,
            'percentual_media' => (float) $percentualMedia,
            'ultima_leitura' => $ultimaLeitura && isset($ultimaLeitura->data_leitura) ? [
                'data' => Carbon::parse($ultimaLeitura->data_leitura)->format('d/m/Y'),
                'valor' => (float) $ultimaLeitura->consumo,
            ] : null,
            'tendencia' => $consumoMes > $mediaMensal ? 'acima' : 'abaixo',
        ];
    }

    public function getAcoes($item)
    {
        return match ($item) {
            'Pendente' => ['badge-warning'],
            'Parcial' => ['badge-warning'],
            'Vencida ' => ['badge-warning'],
            'Pago' => ['badge-success'],

            default => ['badge-warning'],
        };
    }



    // ═══════════════════════════════════════════════════════════
    // CARDS DE RESUMO
    // ═══════════════════════════════════════════════════════════

    protected function carregarCards(): void
    {
        // Faturas
        $faturasPendentes = Faturas::where('cliente_id', $this->clienteId)
            ->whereIn('status', ['Pendente', 'Vencida'])
            ->count();

        $faturasVencidas = Faturas::where('cliente_id', $this->clienteId)
            ->where('status', 'Vencida')
            ->count();

        $saldoDevedor = Faturas::where('cliente_id', $this->clienteId)
            ->whereIn('status', ['Pendente', 'Vencida', 'Parcial'])
            ->sum('saldo_atual');

        // Pagamentos
        $totalPago = pagamentos::where('cliente_id', $this->clienteId)
            ->sum('valor_pago');

        // Leituras
        $totalLeituras = Leituras::where('cliente_id', $this->clienteId)->count();

        $this->cards = [
            'faturas' => [
                'titulo' => 'Faturas Pendentes',
                'valor' => $faturasPendentes,
                'subtitulo' => $faturasVencidas > 0 ? "{$faturasVencidas} vencidas" : 'Tudo em dia',
                'icone' => 'file-text',
                'cor' => $faturasVencidas > 0 ? 'danger' : 'warning',
                'rota' => 'cliente.faturas',
            ],
            'saldo' => [
                'titulo' => 'Saldo Devedor',
                'valor' => 'MZN ' . number_format($saldoDevedor, 2, ',', '.'),
                'subtitulo' => $saldoDevedor > 0 ? 'Pagamento necessário' : 'Sem dívidas',
                'icone' => 'wallet',
                'cor' => $saldoDevedor > 0 ? 'danger' : 'success',
                'rota' => 'cliente.pagamentos',
            ],
            'pagamentos' => [
                'titulo' => 'Total Pago',
                'valor' => 'MZN ' . number_format($totalPago, 2, ',', '.'),
                'subtitulo' => 'Desde o início',
                'icone' => 'check-circle',
                'cor' => 'success',
                'rota' => 'cliente.pagamentos',
            ],
            'leituras' => [
                'titulo' => 'Leituras',
                'valor' => $totalLeituras,
                'subtitulo' => 'Registros no sistema',
                'icone' => 'activity',
                'cor' => 'tertiary',
                'rota' => 'cliente.leituras',
            ],
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // ÚLTIMAS FATURAS
    // ═══════════════════════════════════════════════════════════

    protected function carregarUltimasFaturas(): void
    {
        $faturas = Faturas::where('cliente_id', $this->clienteId)
            ->with(['pagamentos'])
            ->latest('periodo_fim')
            ->take(3)
            ->get();

        $this->ultimasFaturas = $faturas->map(function ($fatura) {
            $vencimento = Carbon::parse($fatura->data_vencimento);
            $totalPago = $fatura->pagamentos->sum('valor_pago');
            $saldoRestante = (float) $fatura->valor_total - $totalPago;
            return [
                'id' => $fatura->id,
                'codigo' => $fatura->codigo_fatura,
                'mes_ano' => Carbon::parse($fatura->periodo_fim)->translatedFormat('F/Y'),
                'status' => $fatura->status,
                'status_classe' => strtolower($fatura->status),
                'valor_total' => (float) $fatura->valor_consumo,
                'saldo_restante' => max(0, $saldoRestante),
                'data_vencimento' => $vencimento->format('d/m/Y'),
                'dias_ate_vencimento' => $vencimento->isFuture() ? $vencimento->diffInDays(Carbon::today()) : 0,
                'consumo_m3' => (float) ($fatura->consumo_m3 ?? 0),
            ];
        })->toArray();
    }

    // ═══════════════════════════════════════════════════════════
    // ÚLTIMOS PAGAMENTOS
    // ═══════════════════════════════════════════════════════════

    protected function carregarUltimosPagamentos(): void
    {
        $pagamentos = pagamentos::where('cliente_id', $this->clienteId)
            ->with('fatura')
            ->latest('data_pagamento')
            ->take(3)
            ->get();

        $this->ultimosPagamentos = $pagamentos->map(function ($pagamento) {
            return [
                'id' => $pagamento->id,
                'valor' => (float) $pagamento->valor_pago,
                'data' => Carbon::parse($pagamento->data_pagamento)->format('d/m/Y'),
                'metodo' => $pagamento->metodo_pagamento,
                'fatura_codigo' => $pagamento->fatura?->codigo_fatura ?? '—',
                'comprovante' => $pagamento->numero_comprovante,
            ];
        })->toArray();
    }

    // ═══════════════════════════════════════════════════════════
    // ALERTAS
    // ═══════════════════════════════════════════════════════════

    protected function carregarAlertas(): void
    {
        $alertas = [];

        // Fatura vencida
        $faturaVencida = Faturas::where('cliente_id', $this->clienteId)
            ->where('status', 'Vencida')
            ->orderBy('data_vencimento', 'asc')
            ->first();

        if ($faturaVencida) {
            $diasAtraso = Carbon::parse($faturaVencida->data_vencimento)->diffInDays(Carbon::today());
            $alertas[] = [
                'tipo' => 'danger',
                'titulo' => 'Fatura vencida',
                'mensagem' => "Sua fatura {$faturaVencida->codigo_fatura} está vencida há {$diasAtraso} dias. Evite multas e juros adicionais.",
                'acao' => 'Pagar agora',
                'rota' => 'cliente.pagamentos',
            ];
        }

        // Fatura próxima do vencimento
        $faturaProxima = Faturas::where('cliente_id', $this->clienteId)
            ->where('status', 'Pendente')
            ->whereBetween('data_vencimento', [Carbon::today(), Carbon::today()->addDays(5)])
            ->first();

        if ($faturaProxima) {
            $diasRestantes = Carbon::parse($faturaProxima->data_vencimento)->diffInDays(Carbon::today());
            $alertas[] = [
                'tipo' => 'warning',
                'titulo' => 'Vencimento próximo',
                'mensagem' => "Sua fatura {$faturaProxima->codigo_fatura} vence em {$diasRestantes} dias.",
                'acao' => 'Pagar agora',
                'rota' => 'cliente.pagamentos',
            ];
        }

        // Consumo anormal
        if ($this->consumoAtual['tendencia'] === 'acima' && $this->consumoAtual['percentual_media'] > 120) {
            $alertas[] = [
                'tipo' => 'info',
                'titulo' => 'Consumo elevado',
                'mensagem' => "Seu consumo está {$this->consumoAtual['percentual_media']}% acima da média mensal. Verifique possíveis vazamentos.",
                'acao' => 'Ver leituras',
                'rota' => 'cliente.leituras',
            ];
        }

        $this->alertas = $alertas;
    }

    // ═══════════════════════════════════════════════════════════
    // AÇÕES
    // ═══════════════════════════════════════════════════════════

    public function pagarFatura(int $faturaId): void
    {
        $this->dispatch('Pagar-Fatura', faturaId: $faturaId);
    }

    public function verFatura(int $faturaId): void
    {
        $this->dispatch('Ver-Fatura', faturaId: $faturaId);
    }

    public function verComprovante(int $pagamentoId): void
    {
        $this->dispatch('Ver-Comprovante', pagamentoId: $pagamentoId);
    }
    public function render()
    {
        return view('Livewire.Admin.Mobile.Clientes.Index');
    }
}
