<?php

namespace App\Livewire\Admin\Pagamentos;

use App\Models\Cliente;
use App\Models\ConfiguracaoFinanceira;
use App\Models\Faturas;
use App\Models\negociar_fatura;
use App\Models\negociar_fatura_itens;
use App\Models\NegociarFatura;
use App\Models\pagamentos;
use App\Services\PagamentoService;
use App\Services\Relatorio\RelatorioService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegistrarPagamento extends Component
{
    use WithFileUploads;

    // ─── Propriedades da Fatura ──────────────────────────────
    public ?int $faturaId = null;
    public array $fatura = [];
    public array $cliente = [];

    // ─── Formulário de Pagamento ─────────────────────────────
    public float $valorPago = 0;
    public string $metodoPagamento = '';
    public ?string $dataPagamento = null;
    public ?string $codigoTransacao = null;
    public ?string $banco = null;
    public ?string $numeroComprovante = null;
    public string $observacoes = '';
    public bool $gerarRecibo = true;
    public $comprovante = null; // Upload de arquivo

    // ─── Dados Calculados ──────────────────────────────────
    public float $saldoDevedor = 0;
    public float $valorTotal = 0;
    public float $multaAtual = 0;
    public float $jurosAtual = 0;
    public int $diasAtraso = 0;
    public int $mesesAtraso = 0;
    public array $historicoPagamentos = [];
    public array $parcelasPendentes = [];

    // ─── Parcelas ────────────────────────────────────────────
    public ?int $parcelaSelecionada = null;
    public ?float $valorParcela = null;
    public int $quantidadeParcelas = 1;
    public bool $editarValorParcela = false; // Permite editar valor da parcela

    // ─── Comprovante/Fatura ──────────────────────────────────
    public array $dadosComprovante = [];
    public bool $mostrarComprovante = false;
    public $relatorio;
    public $valor_base;
    public string $abaAtiva = 'tab-pagamento';

    protected PagamentoService $pagamentoService;

    public function boot(PagamentoService $pagamentoService): void
    {
        $this->pagamentoService = $pagamentoService;
    }

    // ═══════════════════════════════════════════════════════════
    // REGRAS DE VALIDAÇÃO
    // ═══════════════════════════════════════════════════════════

    protected function rules(): array
    {
        return [
            'faturaId' => 'required|exists:faturas,id',
            'valorPago' => 'required|numeric|min:0.01',
            'metodoPagamento' => 'required',
            'dataPagamento' => 'required|date|before_or_equal:today',
            'codigoTransacao' => 'nullable|string|max:100',
            'numeroComprovante' => 'nullable|string|max:100',
            'banco' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string|max:1000',
            'comprovante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    // ═══════════════════════════════════════════════════════════
    // CARREGAR FATURA
    // ═══════════════════════════════════════════════════════════

    #[\Livewire\Attributes\On('Pagar-Fatura')]
    public function carregarFatura(int $idFatura): void
    {
        $this->resetAll();
        $this->dispatch('openModal', 'modal-novo-pagamento');

        $fatura = Faturas::with(['cliente', 'pagamentos'])->findOrFail($idFatura);

        // Verifica status permitido
        if (!in_array($fatura->status, ['Pendente', 'Vencida', 'Negociada', 'Parcial'])) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => "Fatura '{$fatura->status}' não pode receber pagamento.",
            ]);
            return;
        }

        $this->faturaId = $fatura->id;
        $this->valorTotal = (float) $fatura->valor_total;
        $this->saldoDevedor = $this->pagamentoService->saldoDevedor($idFatura);
        $this->quantidadeParcelas = (int) ($fatura->parcelas_qtd ?? 1);

        // $this->saldoDevedor = $fatura->valor_total;

        // ─── Calcular multa, juros e dias de atraso ────────────
        $this->calcularTarifasAtualizadas($fatura);

        $this->valor_base = $fatura->valor_consumo + $fatura->valor_esgoto + $fatura->taxa_disponibilidade;
        // ─── Dados da fatura ─────────────────────────────────────
        $this->fatura = [
            'id' => $fatura->id,
            'codigo' => $fatura->codigo_fatura,
            'status' => $fatura->status,
            'valor_total' => $fatura->valor_total,
            'valor_base' => $this->valor_base,
            'saldo_actual' => $fatura->saldo_atual,
            'multa' => $this->multaAtual,
            'juros' => $this->jurosAtual,
            'desconto' => (float) $fatura->desconto,
            'dias_atraso' => $this->diasAtraso,
            'meses_atraso' => $this->mesesAtraso,
            'data_vencimento' => $fatura->data_vencimento?->format('d/m/Y'),
            'consumo_m3' => $fatura->consumo_m3,
            'parcelas_qtd' => $fatura->parcelas_qtd,
            'negociada' => $fatura->negociada,
            'juros_isento' => $fatura->juros_isento,
        ];

        // ─── Dados do cliente ──────────────────────────────────
        $cliente = $fatura->cliente;
        $this->cliente = [
            'nome' => $cliente?->nome_completo ?? 'N/A',
            'matricula' => $cliente?->numero_matricula ?? 'N/A',
            'categoria_consumo' => $cliente?->categoria_consumo ?? 'N/A',
            'nuit' => $cliente?->nuit ?? 'N/A',
            'endereco' => $cliente?->endereco ?? 'N/A',
            'contacto' => $cliente?->telefone ?? 'N/A',
        ];

        // ─── Valores padrão ────────────────────────────────────
        // $this->valorPago = $this->saldoDevedor;

        $this->valorPago = empty($this->saldoDevedor) ? $this->valor_base : $this->saldoDevedor;
        $this->dataPagamento = now()->format('Y-m-d');
        $this->metodoPagamento = 'PIX';
        $this->gerarRecibo = true;
        $this->numeroComprovante = $this->gerarNumeroComprovante();
        $this->codigoTransacao = $this->gerarCodigoTransacao();

        // ─── Histórico de pagamentos ───────────────────────────
        $this->historicoPagamentos = $this->HistoricoPagamentos($fatura->id);

        // ─── Parcelas (se negociada ou parcial) ─────────────────
        // $this->carregarParcelas($fatura);

        $this->abaAtiva = 'tab-pagamento';
    }

    public function HistoricoPagamentos($faturaId)
    {
        return pagamentos::where('fatura_id', $faturaId)
            ->with(['usuario', 'fatura'])
            ->orderByDesc('data_pagamento')
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'valor' => (float) $p->valor_pago,
                'data' => $p->data_pagamento?->format('d/m/Y'),
                'metodo' => $p->metodo_pagamento,
                'comprovante' => $p->numero_comprovante,
                'usuario' => $p->usuario?->name ?? 'Sistema',
                'Fatura' => $p->fatura?->codigo_fatura ?? 'N/F',
            ])

            ->toArray();
    }




    public function setAba($data)
    {
        $this->abaAtiva = $data;
    }
    // ═══════════════════════════════════════════════════════════
    // CÁLCULO DE TARIFAS ATUALIZADAS
    // ═══════════════════════════════════════════════════════════

    protected function calcularTarifasAtualizadas($fatura): void
    {
        $hoje = \Carbon\Carbon::today();
        $periodoFim = \Carbon\Carbon::parse($fatura->periodo_fim)->startOfDay();

        // Dias de atraso
        $this->diasAtraso = 0;
        $this->mesesAtraso = 0;

        if ($hoje->greaterThan($periodoFim)) {
            $this->diasAtraso = abs((int) $hoje->diff($periodoFim)->format('%r%a'));
            $this->mesesAtraso = ceil($this->diasAtraso / 30);
        }

        $config = ConfiguracaoFinanceira::first();
        $this->multaAtual = 0;
        $this->jurosAtual = 0;

        if ($this->diasAtraso > 0 && !$fatura->juros_isento) {
            $this->multaAtual = $config ? (float) $config->multa_atraso : 0;

            $base = (float) $fatura->valor_consumo +
                (float) $fatura->valor_esgoto +
                (float) $fatura->taxa_disponibilidade;

            // $this->jurosAtual = $base * (($this->mesesAtraso * 10) / 100);
        }
    }

    // ═══════════════════════════════════════════════════════════
    // CARREGAR PARCELAS
    // ═══════════════════════════════════════════════════════════

    protected function carregarParcelas($fatura): void
    {
        $this->parcelasPendentes = [];
        $this->parcelaSelecionada = null;
        $this->valorParcela = null;

        if (!in_array($fatura->status, ['Negociada', 'Parcial'])) {
            return;
        }

        // Busca parcelas da tabela fatura_parcelas ou negociar_fatura_itens
        $parcelas =  negociar_fatura::where('fatura_id', $fatura->id)->get();

        if ($parcelas->isEmpty()) {
            // Fallback: busca da tabela negociar_fatura_itens
            $negociacao = negociar_fatura::where('fatura_id', $fatura->id)
                ->where('status', 'Ativa')
                ->first();

            if ($negociacao) {
                $parcelas = $negociacao->itens()->orderBy('numero_parcela')->get();
            }
        }

        if ($parcelas->isNotEmpty()) {
            $this->parcelasPendentes = $parcelas->map(function ($item, $index) {
                return [
                    'id' => $item->id,
                    'numero' => $item->numero ?? ($index + 1),
                    'valor_original' => (float) ($item->valor_original ?? $item->valor),
                    'valor_parcela' => (float) ($item->valor_parcela ?? $item->valor),
                    'valor_restante' => (float) ($item->valor_restante ?? $item->valor),
                    'data_vencimento' => $item->data_vencimento?->format('d/m/Y'),
                    'status' => $item->status ?? 'Pendente',
                ];
            })->toArray();

            // Seleciona primeira parcela pendente
            $primeiraPendente = collect($this->parcelasPendentes)
                ->firstWhere('status', 'Pendente');

            if ($primeiraPendente) {
                $this->selecionarParcela($primeiraPendente['id']);
            }
        }
    }

    // ═══════════════════════════════════════════════════════════
    // SELECIONAR PARCELA (COM EDIÇÃO DE VALOR)
    // ═══════════════════════════════════════════════════════════

    /**
     * Seleciona parcela e permite edição do valor
     * O usuário pode pagar MAIS ou MENOS que o valor da parcela
     */
    public function selecionarParcela(int $parcelaId): void
    {
        $this->parcelaSelecionada = $parcelaId;
        $this->editarValorParcela = false;

        $parcela = collect($this->parcelasPendentes)->firstWhere('id', $parcelaId);

        if (!$parcela || $parcela['status'] === 'Paga') {
            return;
        }

        // Valor sugerido = valor restante da parcela ou valor padrão
        $valorSugerido = $parcela['valor_restante'] > 0
            ? $parcela['valor_restante']
            : $parcela['valor_parcela'];

        $this->valorParcela = (float) $valorSugerido;

        // Preenche o valor pago com o sugerido, mas permite edição
        $this->valorPago = min($valorSugerido, $this->saldoDevedor);

        $this->dispatch('parcela-selecionada', [
            'parcela_id' => $parcelaId,
            'valor_sugerido' => $valorSugerido,
        ]);
    }

    /**
     * Ativa modo de edição do valor da parcela
     */
    public function habilitarEdicaoValor(): void
    {
        $this->editarValorParcela = true;
    }

    /**
     * Quando muda valor pago manualmente (fora do valor da parcela)
     */
    // public function updatedValorPago(): void
    // {


    //     // Valida contra saldo devedor
    //     if ($this->valorPago > $this->saldoDevedor) {
    //     $this->valorPago =  $this->saldoDevedor;

    //     $this->dispatch('notify', [
    //         'type' => 'warning',
    //         'message' => 'Valor ajustado ao saldo devedor: MZN ' . number_format($this->saldoDevedor, 2, ',', '.'),
    //     ]);
    //     // }



    //     // Se pagou valor diferente da parcela, marca como edição
    //     if ($this->parcelaSelecionada && $this->valorParcela) {
    //         $this->editarValorParcela = abs($this->valorPago - $this->valorParcela) > 0.01;
    //     }
    // }


    public function updateValorPagos($valor): void
    {


        // Valida contra saldo devedor

        $this->valorPago =  $valor;

        $this->dispatch('showToast', [
            'type' => 'warning',
            'message' => 'Valor ajustado ao saldo devedor: MZN ' . number_format($valor, 2, ',', '.'),
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    // CONFIRMAR PAGAMENTO
    // ═══════════════════════════════════════════════════════════

    public function confirmarPagamento(): void
    {
        // dd($this->valorPago);

        $this->validate();

        $fatura = Faturas::findOrFail($this->faturaId);
        try {
            // ─── Recalcula tarifas no momento do pagamento ───────
            $this->calcularTarifasAtualizadas($fatura);

            // ─── Atualiza fatura com multa/juros atuais ────────────
            $valorBase = (float) $fatura->valor_consumo +
                (float) $fatura->valor_esgoto +
                (float) $fatura->taxa_disponibilidade;



            $fatura->update([
                'multa' => $this->multaAtual,
                'juros' => $this->jurosAtual,
                'valor_total' => $valorBase + $this->multaAtual + $this->jurosAtual - (float) $fatura->desconto,
            ]);



            $payments = pagamentos::where('fatura_id', $fatura->id)->exists();
            if ($payments && $this->valorPago == $fatura->valor_total) {
                $this->dispatch('showToast', [
                    'type' => 'warning',
                    'message' => 'Pagamentos Ja Foi efectuado',
                ]);
                return;
            }


            // ─── Cria pagamento ────────────────────────────────────
            $pagamento = pagamentos::create([
                'fatura_id' => $fatura->id,
                'cliente_id' => $fatura->cliente_id,
                'user_id' => Auth()->user()->id,
                'valor_pago' => $this->valorPago,
                'saldo_restante' => 0,
                'metodo_pagamento' => $this->metodoPagamento,
                'data_pagamento' => $this->dataPagamento,
                'hora_pagamento' => now()->toTimeString(),
                'codigo_transacao' => $this->codigoTransacao,
                'numero_comprovante' => $this->numeroComprovante,
                'banco' => $this->banco,
                'observacoes' => $this->observacoes,
                'status' => 'Confirmado',
                'parcela_id' => $this->parcelaSelecionada,
                'valor_parcela_esperado' => $this->valorParcela,
                'diferenca_parcela' => $this->parcelaSelecionada
                    ? round($this->valorPago - ($this->valorParcela ?? 0), 2)
                    : 0,
            ]);

            // ─── Upload de comprovante ─────────────────────────────
            if ($this->comprovante) {
                $path = $this->comprovante->store('comprovantes/' . $fatura->id, 'public');
                $pagamento->update(['comprovante_path' => $path]);
            }

            // ─── Atualiza saldo e status ───────────────────────────
            $fatura->refresh();
            $novoValorPago = (float) $fatura->pagamentos()->sum('valor_pago');
            $saldoAtual = (float) $fatura->valor_total - $novoValorPago;

            $novoStatus = match (true) {
                $saldoAtual <= 0 => 'Pago',
                $novoValorPago > 0 => 'Parcial',
                default => $fatura->status,
            };

            $fatura->update([
                'valor_pago' => $novoValorPago,
                'saldo_atual' => max(0, $saldoAtual),
                'status' => $novoStatus,
                'data_pagamento' => $this->dataPagamento,
            ]);

            $pagamento->saldo_restante = $saldoAtual;
            $pagamento->save();

            $dataRelatorio = [
                'user_id' => Auth()->user()->id,

                'cliente_id' => $fatura->cliente_id,

                'fatura_id' => $fatura->id,

                'origem' => 'Pagamentos-' . $pagamento->id,

                'data_referencia' => now()->format('Y-m-d'),

                'codigo_fatura' => $fatura->codigo_fatura,

                'mes_referencia' => $fatura->mes_referencia,

                'periodo' => $fatura->periodo_inicio->format('Y-m-d') . ' a ' . $fatura->periodo_fim->format('Y-m-d'),

                'consumo_m3' => $fatura->consumo_m3,

                'valor_pago' => $this->valorPago,

                'valor_Acumulado' => $fatura->valor_pago,

                'valor_consumo' => $fatura->valor_consumo,

                'valor_total' => $fatura->valor_total,

                'saldo_atual' => $fatura->saldo_atual,

                'multa' => $fatura->multa,

                'juros' => $fatura->juros,

                'desconto' => $fatura->desconto,

                'numero_comprovante' => $this->numeroComprovante,

                'codigo_transacao' => $this->codigoTransacao,

                'data_pagamento' => now()->format('Y-m-d'),

                'hora_pagamento' => now()->format('H:i:s'),

                'metodo' => $this->metodoPagamento,

                'cliente' => $this->cliente,

                'saldo_restante' => max(0, $saldoAtual),
                'usuario' => Auth()->user()->name ?? 'Sistema',
                'observacoes' => $this->observacoes,
            ];

            $this->relatorio = app(RelatorioService::class)->FaturaPagamento($dataRelatorio);

            // dd($this->relatorio);
            // ─── Prepara dados do comprovante ───────────────────────
            // $this->dadosComprovante = [
            //     'numero_comprovante' => $this->numeroComprovante,
            //     'codigo_transacao' => $this->codigoTransacao,
            //     'data_pagamento' => $this->dataPagamento,
            //     'hora_pagamento' => now()->format('H:i:s'),
            //     'valor_pago' => $this->valorPago,
            //     'metodo' => $this->metodoPagamento,
            //     'banco' => $this->banco,
            //     'fatura' => $this->fatura,
            //     'cliente' => $this->cliente,
            //     'parcela' => $this->parcelaSelecionada ? collect($this->parcelasPendentes)->firstWhere('id', $this->parcelaSelecionada) : null,
            //     'saldo_restante' => max(0, $saldoAtual),
            //     'usuario' => Auth()->user()->name ?? 'Sistema',
            //     'observacoes' => $this->observacoes,
            // ];

            // ─── Mostra comprovante ──────────────────────────────────
            $this->mostrarComprovante = true;

            $this->abaAtiva = 'tab-comprovante';
            $this->dispatch('pagamento-concluido', $this->dadosComprovante);
            //

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Pagamento de MZN ' . number_format($this->valorPago, 2, ',', '.') . ' registrado!',
            ]);

            $this->dispatch('atualizar-lista-faturas');
            $this->dispatch('atualizar-concluido');
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erro: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Atualiza status da parcela paga
     */
    protected function atualizarParcela(int $parcelaId, float $valorPago): void
    {
        $parcela = negociar_fatura::find($parcelaId);
        if (!$parcela) return;

        $novoRestante = (float) $parcela->valor_restante - $valorPago;

        if ($novoRestante <= 0.01) {
            $parcela->update([
                'valor_restante' => 0,
                'status' => 'Paga',
                'data_pagamento' => now(),
            ]);
        } else {
            $parcela->update([
                'valor_restante' => $novoRestante,
                'status' => 'Parcial',
            ]);
        }
    }

    // ═══════════════════════════════════════════════════════════
    // GERADORES DE CÓDIGOS
    // ═══════════════════════════════════════════════════════════

    public function gerarCodigoTransacao(): string
    {
        return 'TRX-' . strtoupper(uniqid()) . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
    }

    public function gerarNumeroComprovante(): string
    {
        return 'COMP-' . date('Ymd') . '-' . random_int(100000, 999999);
    }

    // ═══════════════════════════════════════════════════════════
    // UTILITÁRIOS
    // ═══════════════════════════════════════════════════════════

    public function resetAll(): void
    {
        $this->reset([
            'faturaId',
            'fatura',
            'cliente',
            'valorPago',
            'metodoPagamento',
            'dataPagamento',
            'codigoTransacao',
            'banco',
            'numeroComprovante',
            'observacoes',
            'comprovante',
            'saldoDevedor',
            'valorTotal',
            'multaAtual',
            'jurosAtual',
            'diasAtraso',
            'mesesAtraso',
            'historicoPagamentos',
            'parcelasPendentes',
            'parcelaSelecionada',
            'valorParcela',
            'editarValorParcela',
            'dadosComprovante',
            'mostrarComprovante',
            'abaAtiva',
            'quantidadeParcelas',
        ]);
        $this->gerarRecibo = true;
    }

    public function render()
    {
        return view('livewire.admin.pagamentos.registrar-pagamento');
    }
}