<?php

namespace App\Livewire\Admin\Faturas;

use App\Models\ConfiguracaoFinanceira;
use App\Models\Faturas;
use App\Models\negociar_fatura as NegociaFatura;
use App\Models\negociar_fatura;
use App\Models\negociar_fatura_itens;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class NegociarFatura extends Component
{

    // ─── Propriedades Públicas ───────────────────────────────
    public ?int $faturaId = null;
    public float $valorOriginal = 0;
    public float $valorFinal = 0;
    public float $valorComDesconto = 0;
    public float $percentualDesconto = 0;
    public float $economia = 0;
    public string $tipoNegociacao = '';
    public int $quantidadeParcelas = 1;
    public ?string $novaDataVencimento = null;
    public string $observacoes = '';
    public bool $gerarNovoBoleto = true;

    // Dados exibidos na modal
    public array $fatura = [];
    public array $cliente = [];

    // ─── Regras de Validação ─────────────────────────────────
    protected $rules = [
        'tipoNegociacao' => 'required|in:Parcelar,Isenção de Juros/Multas',
        'valorComDesconto' => 'required|numeric|min:1',
        'percentualDesconto' => 'nullable|numeric|min:0|max:100',
        'quantidadeParcelas' => 'required|integer|min:1|max:12',
        'novaDataVencimento' => 'nullable|date|after_or_equal:today',
        'observacoes' => 'nullable|string|max:500',
    ];

    // ═══════════════════════════════════════════════════════════
    // LISTENERS & INICIALIZAÇÃO
    // ═══════════════════════════════════════════════════════════

    #[\Livewire\Attributes\On('Negociar-Fatura')]
    public function carregarDadosFatura(int $idFatura): void
    {
        $fatura = Faturas::with('cliente')->findOrFail($idFatura);

        // Só permite negociar faturas pendentes ou vencidas
        if (!in_array($fatura->status, ['Pendente', 'Vencida'])) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Apenas faturas pendentes ou vencidas podem ser negociadas.',
            ]);
            return;
        }

        // ─── Reseta tudo antes de carregar ─────────────────────
        $this->reset([
            'tipoNegociacao',
            'percentualDesconto',
            'observacoes',
            'economia',
            'quantidadeParcelas',
            'gerarNovoBoleto'
        ]);
        $this->quantidadeParcelas = 1;
        $this->gerarNovoBoleto = true;
        $this->tipoNegociacao = 'Parcelar';

        // ─── Cálculo das tarifas atualizadas ───────────────────
        $calculo = $this->calcularTarifasAtualizadas($fatura, $this->tipoNegociacao);

        // ─── Calcular dias/meses de atraso ─────────────────────
        $hoje = \Carbon\Carbon::today();
        $periodoFim = \Carbon\Carbon::parse($fatura->periodo_fim)->startOfDay();
        $diasAtraso = 0;
        $mesesAtraso = 0;

        if ($hoje->greaterThan($periodoFim)) {
            $diasAtraso = abs((int) $hoje->diff($periodoFim)->format('%r%a'));
            $mesesAtraso = ceil($diasAtraso / 30);
        }

        // ─── Define valores base ───────────────────────────────
        $this->faturaId = $fatura->id;
        $this->valorOriginal = (float) $calculo['valor_total'];
        $this->valorFinal = $this->valorOriginal;
        $this->valorComDesconto = $this->valorOriginal;
        $this->economia = 0;

        // ─── Dados da fatura para exibição ─────────────────────
        $this->fatura = [
            'id' => $fatura->id,
            'codigo' => $fatura->codigo_fatura,
            'status' => $fatura->status,
            'valor_total' => $calculo['valor_total'],
            'valor_base' => $calculo['valor_base'],
            'multa_atual' => $calculo['multa'],
            'juros_atual' => $calculo['juros'],
            'desconto' => (float) $fatura->desconto,
            'dias_atraso' => $diasAtraso,
            'meses_atraso' => $mesesAtraso,
            'data_vencimento' => $fatura->data_vencimento?->format('Y-m-d'),
            'consumo_m3' => $fatura->consumo_m3,
        ];

        // ─── Dados do cliente ──────────────────────────────────
        $cliente = $fatura->cliente;
        $this->cliente = [
            'nome' => $cliente?->nome_completo ?? 'N/A',
            'matricula' => $cliente?->numero_matricula ?? 'N/A',
        ];

        // ─── Data padrão: 5 dias à frente ──────────────────────
        $this->novaDataVencimento = now()->addDays(5)->format('Y-m-d');

        $this->dispatch('openModal', 'modal-negociar-fatura');
    }

    // ═══════════════════════════════════════════════════════════
    // HOOKS DE ATUALIZAÇÃO EM TEMPO REAL
    // ═══════════════════════════════════════════════════════════

    /**
     * Quando muda o tipo de negociação
     * → Recalcula tudo do zero com base no tipo
     */
    public function updatedTipoNegociacao(): void
    {
        $fatura = Faturas::find($this->faturaId);
        if (!$fatura) return;

        // Recalcula as tarifas com o novo tipo (isenção ou não)
        $calculo = $this->calcularTarifasAtualizadas($fatura, $this->tipoNegociacao);

        // Atualiza o valor original (pode mudar se isentar juros/multa)
        $this->valorOriginal = (float) $calculo['valor_total'];

        // Atualiza os dados da fatura na view
        $this->fatura['valor_total'] = $calculo['valor_total'];
        $this->fatura['multa_atual'] = $calculo['multa'];
        $this->fatura['juros_atual'] = $calculo['juros'];

        // Se mudou para isenção, zera o desconto adicional
        if ($this->tipoNegociacao === 'Isenção de Juros/Multas') {
            $this->percentualDesconto = 0;
            $this->valorComDesconto = $this->valorOriginal;
        }

        $this->calcularValorFinal();
    }

    /**
     * Quando muda percentual de desconto
     * → Atualiza valorComDesconto automaticamente
     */
    public function updatedPercentualDesconto(): void
    {
        if ($this->percentualDesconto > 0 && $this->valorOriginal > 0) {
            $this->valorComDesconto = round(
                $this->valorOriginal * (1 - ($this->percentualDesconto / 100)),
                2
            );
        } elseif ($this->percentualDesconto <= 0) {
            $this->valorComDesconto = $this->valorOriginal;
        }

        $this->calcularValorFinal();
    }

    /**
     * Quando muda valor com desconto manualmente
     * → Atualiza percentualDesconto automaticamente
     */
    public function updatedValorComDesconto(): void
    {
        if ($this->valorOriginal > 0 && $this->valorComDesconto >= 0) {
            if ($this->valorComDesconto >= $this->valorOriginal) {
                $this->percentualDesconto = 0;
            } else {
                $this->percentualDesconto = round(
                    (($this->valorOriginal - $this->valorComDesconto) / $this->valorOriginal) * 100,
                    1
                );
            }
        }

        $this->calcularValorFinal();
    }

    /**
     * Quando muda quantidade de parcelas
     * → Só recalcula o valorFinal (não muda o total)
     */
    public function updatedQuantidadeParcelas(): void
    {
        // Não precisa recalcular valor, só atualiza a view
        $this->dispatch('parcelas-atualizadas');
    }

    // ═══════════════════════════════════════════════════════════
    // CÁLCULOS
    // ═══════════════════════════════════════════════════════════

    /**
     * Calcula o valor final com base em todos os fatores
     */
    protected function calcularValorFinal(): void
    {
        $this->economia = round($this->valorOriginal - $this->valorComDesconto, 2);
        $this->valorFinal = round($this->valorComDesconto, 2);

        // Garante que não fique negativo
        if ($this->valorFinal < 0) {
            $this->valorFinal = 0;
            $this->valorComDesconto = 0;
            $this->economia = $this->valorOriginal;
        }
    }

    /**
     * Calcula multa, juros e valor total atualizado
     */
    public function calcularTarifasAtualizadas($fatura, $tipoNegociacao): array
    {
        $juros_isento = $tipoNegociacao === 'Isenção de Juros/Multas' ? 1 : 0;
        $hoje =  Carbon::today();
        // dd($fatura);
        $periodoFim =  Carbon::parse($fatura->periodo_fim)->startOfDay();

        // Calcula os dias de atraso com sinal real
        $diasSinalizados = $hoje->greaterThan($periodoFim)
            ? (int) $hoje->diff($periodoFim)->format('%r%a')
            : 0;

        $config = ConfiguracaoFinanceira::first();
        $multa = 0;
        $juros = 0;

        // Se o sinal for menor que zero, a fatura está atrasada
        if ($diasSinalizados < 0) {
            $multa = $config ? (float) $config->multa_atraso : 0;

            if (!$juros_isento) {
                $diasAtrasoPositivo = abs($diasSinalizados);
                $meses = ceil($diasAtrasoPositivo / 30);

                $base = (float) $fatura->valor_consumo +
                    (float) $fatura->valor_esgoto +
                    (float) $fatura->taxa_disponibilidade;

                // $juros = $base * (($meses * 10) / 100);
            }
        }

        $valorBase = (float) $fatura->valor_consumo +
            (float) $fatura->valor_esgoto +
            (float) $fatura->taxa_disponibilidade;

        // Valor calculado com o acréscimo das taxas de atraso
        $valorTotalAtualizado = $valorBase + $multa + $juros - (float) $fatura->desconto;

        return [
            'multa' => $multa,
            'juros' => $juros,
            'valor_base' => $valorBase,
            'valor_total' => max(0, $valorTotalAtualizado),
            'juros_isento' => $juros_isento,
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // CONFIRMAÇÃO
    // ═══════════════════════════════════════════════════════════

    public function confirmarNegociacao(): void
    {
        $this->validate();

        $fatura = Faturas::findOrFail($this->faturaId);

        // Reaproveita exatamente o mesmo cálculo
        $calculo = $this->calcularTarifasAtualizadas($fatura, $this->tipoNegociacao);

        try {
            $quantidade = (int) $this->quantidadeParcelas;
            $isParcelar = $this->tipoNegociacao === 'Parcelar' ? 1 : 0;

            // Atualiza fatura
            $fatura->update([
                'status' => 'Negociada',
                'parcelas_qtd' => $quantidade,
                'negociada' => $isParcelar,
                'juros_isento' => $calculo['juros_isento'],
                'multa' => $calculo['multa'],
                'juros' => $calculo['juros'],
                'valor_total' => $this->valorFinal,
                'desconto' => (float) $fatura->desconto + ($this->economia > 0 ? $this->economia : 0),
                'data_vencimento' => $this->novaDataVencimento ?? $fatura->data_vencimento,
                'observacoes' => ($fatura->observacoes ? $fatura->observacoes . "\n" : '')
                    . "Negociada em " . now()->format('d/m/Y') . ". "
                    . "Tipo: {$this->tipoNegociacao}. "
                    . "Parcelas: {$this->quantidadeParcelas}x. "
                    . "Valor final: MZN " . number_format($this->valorFinal, 2, ',', '.'),
            ]);

            // Gera parcelas se for parcelado
            if ($isParcelar && $quantidade > 1) {
                $this->gerarParcelas($fatura, $quantidade);
            }

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => "Fatura {$this->fatura['codigo']} negociada com sucesso! "
                    . "Valor final: MZN " . number_format($this->valorFinal, 2, ',', '.')
                    . " em {$this->quantidadeParcelas}x.",
            ]);

            $this->dispatch('fatura-criada');
            $this->dispatch('closeModal', 'modal-negociar-fatura');

            // Reseta formulário
            $this->reset();
        } catch (\Exception $e) {
            Log::error('Erro ao negociar fatura', [
                'fatura_id' => $this->faturaId,
                'erro' => $e->getMessage(),
            ]);

            $this->dispatch('showToast', [
                'type' => 'warning',
                'message' => 'Erro ao negociar fatura: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Gera os registros de parcelas no banco
     */
    protected function gerarParcelas($fatura, int $quantidade): void
    {
        $valorParcela = round($this->valorFinal / $quantidade, 2);
        $dataVencimento = \Carbon\Carbon::parse($this->novaDataVencimento);

        for ($i = 1; $i <= $quantidade; $i++) {
            // Ajusta o último valor para cobrir arredondamentos
            $valor = ($i === $quantidade)
                ? round($this->valorFinal - ($valorParcela * ($quantidade - 1)), 2)
                : $valorParcela;

            FaturaParcela::create([
                'fatura_id' => $fatura->id,
                'numero' => $i,
                'valor' => $valor,
                'data_vencimento' => $dataVencimento->copy()->addMonths($i - 1)->format('Y-m-d'),
                'status' => 'Pendente',
            ]);
        }
    }


    public function render()
    {
        return view('Livewire.admin.Faturas.Negociar-fatura');
    }
}