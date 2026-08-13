<?php

namespace App\Livewire\Admin\Pagamentos;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\negociar_fatura;
use App\Models\negociar_fatura_itens;
use App\Models\NegociarFatura;
use App\Services\PagamentoService;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrarPagamento extends Component
{
    public ?int $faturaId = null;
    public array $fatura = [];
    public array $cliente = [];

    // Formulário
    public   $valorPago = 0;
    public string $metodoPagamento = '';
    public ?string $dataPagamento = null;
    public ?string $codigoTransacao = null;
    public ?string $banco = null;
    public ?string $numeroComprovante = null;
    public string $observacoes = '';
    public bool $gerarRecibo = true;

    // Dados calculados
    public float $saldoDevedor = 0;
    public float $valorTotal = 0;
    public array $historicoPagamentos = [];
    public array $parcelasPendentes = [];

    // Propriedade para parcela selecionada
    public ?int $parcelaSelecionada = null;
    public ?float $valorParcela = null;

    protected PagamentoService $pagamentoService;

    public function boot(PagamentoService $pagamentoService): void
    {
        $this->pagamentoService = $pagamentoService;
    }

    protected function rules(): array
    {
        return [
            'faturaId' => 'required|exists:faturas,id',
            'valorPago' => 'required|numeric|min:0.01',
            'metodoPagamento' => 'required|in:PIX,Boleto,Cartão de Crédito,Cartão de Débito,Dinheiro,Débito em Conta,Transferência Bancária',
            'dataPagamento' => 'required|date',
            'codigoTransacao' => 'nullable|string|max:100',
            'numeroComprovante' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string|max:1000',
        ];
    }



    /**
     * Seleciona uma parcela e preenche o valor
     */
    public function selecionarParcela(int $parcelaId): void
    {
        $this->parcelaSelecionada = $parcelaId;
        // $valor = negociar_fatura_itens::where('fatura_id', $parcelaId)
        //     ->where('status', '<>', 'Paga')
        //     ->sum('valor_parcela');
        // dd($valor);
        // $this->valorPago = $valor;
        $parcela = collect($this->parcelasPendentes)->firstWhere('id', $parcelaId);
        if ($parcela && ($parcela['status'] ?? 'Pendente') !== 'Paga') {

            $this->valorParcela = (float) $parcela['valor_parcela'];
            // $this->valorPago = $valor;
            $this->valorPago = $this->valorParcela;
        }
    }

    /**
     * Atualiza carregarFatura para incluir ID nas parcelas
     */
    /**
     * Carrega dados da fatura ao receber evento
     */
    #[On('Pagar-Fatura')]
    public function carregarFatura(int $idFatura): void
    {
        $this->dispatch('openModal', 'modal-novo-pagamento');
        $fatura = Faturas::with(['cliente', 'pagamentos'])->findOrFail($idFatura);


        // Só permite pagar faturas pendentes, vencidas, negociadas ou parciais
        if (!in_array($fatura->status, ['Pendente', 'Vencida', 'Negociada', 'Parcial'])) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => "Fatura '{$fatura->status}' não pode receber pagamento.",
            ]);
            return;
        }

        $this->faturaId = $fatura->id;
        $this->valorTotal = (float) $fatura->valor_total;
        $this->saldoDevedor = $this->pagamentoService->saldoDevedor($fatura->id);

        $this->fatura = [
            'id' => $fatura->id,
            'codigo' => $fatura->codigo_fatura,
            'status' => $fatura->status,
            'valor_total' => $fatura->valor_total,
            'data_vencimento' => $fatura->data_vencimento?->format('d/m/Y'),
        ];

        $cliente = $fatura->cliente;
        $this->cliente = [
            'nome' => $cliente?->nome_completo ?? 'N/A',
            'matricula' => $cliente?->numero_matricula ?? 'N/A',
        ];
        $this->numeroComprovante = $this->gerarNumeroComprovante();
        $this->codigoTransacao = $this->gerarCodigoTransacao();

        // Preenche valor pago com saldo devedor por padrão
        $this->valorPago = $this->saldoDevedor;
        $this->dataPagamento = now()->format('Y-m-d');

        // Busca histórico de pagamentos
        $this->historicoPagamentos = $this->pagamentoService->historicoPagamentos($fatura->id);

        // Se negociada, busca parcelas pendentes
        // Busca parcelas com ID incluído
        if ($fatura->status === 'Negociada' || $fatura->status === 'Parcial') {
            $negociacao = negociar_fatura::where('fatura_id', $fatura->id)
                ->where('status', 'Ativa')
                ->first();

            if ($negociacao) {
                $this->parcelasPendentes = $negociacao->itens()
                    ->get()

                    ->map(fn($item, $index) => [
                        'id' => $item->id,
                        'numero' => $index + 1,
                        'valor_original' => (float) $item->valor_original,
                        'valor_parcela' => (float) $item->valor_parcela,
                        'status' => $item->status ?? 'Pendente',
                    ])
                    ->toArray();

                // Seleciona primeira parcela pendente por padrão
                $primeiraPendente = collect($this->parcelasPendentes)
                    ->firstWhere('status', 'Pendente');

                $this->valorPago = collect($this->parcelasPendentes)->where('status', '<>', 'Paga')->sum('valor_parcela');
                // dd($this->valorPago);
                // if ($primeiraPendente) {
                // $this->selecionarParcela($fatura->id);
                //     $this->selecionarParcela($primeiraPendente['id']);
                // }
            }
        }

        // Reseta outros campos
        $this->reset([
            'metodoPagamento',
            'codigoTransacao',
            'banco',
            'numeroComprovante',
            'observacoes'
        ]);
        $this->metodoPagamento = 'PIX';
        $this->gerarRecibo = true;
    }

    /**
     * Quando muda valor pago, valida contra saldo
     */
    public function updatedValorPago(): void
    {
        if ($this->valorPago > $this->saldoDevedor) {
            $this->valorPago = $this->saldoDevedor;
            $this->dispatch('notify', [
                'type' => 'warning',
                'message' => 'Valor ajustado ao saldo devedor.',
            ]);
        }
    }

    /**
     * Confirma pagamento
     */
    public function confirmarPagamento(): void
    {

        $this->validate();


        try {
            $resultado = $this->pagamentoService->registrarPagamento([
                'fatura_id' => $this->faturaId,
                'valor_pago' => $this->valorPago,
                'parcela_id' => $this->parcelaSelecionada,
                'metodo_pagamento' => $this->metodoPagamento,
                'data_pagamento' => $this->dataPagamento,
                'codigo_transacao' => $this->gerarCodigoTransacao(),
                'numero_comprovante' => $this->gerarNumeroComprovante(),
                'observacoes' => $this->observacoes,
            ]);

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => $resultado['mensagem'],
            ]);

            $this->dispatch('atualizar-lista-faturas');
            $this->dispatch('close-modal', 'modal-novo-pagamento');

            $this->reset();
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erro: ' . $e->getMessage(),
            ]);
        }
    }

    function gerarCodigoTransacao(): string
    {
        // Gera um ID único baseado no milissegundo atual (Ex: 65f3a2b1)
        $uniqid = uniqid();

        // Gera 4 caracteres aleatórios em maiúsculo
        $bytes = random_bytes(2);
        $randomStr = strtoupper(bin2hex($bytes));

        // Exemplo de retorno: TRX-65F3A2B1-4E8F
        return 'TRX-' . strtoupper($uniqid) . '-' . $randomStr;
    }

    function gerarNumeroComprovante(): string
    {
        $anoMes = date('Ymd'); // Formato: 20260515

        // Gera um número aleatório de 6 dígitos entre 100000 e 999999
        $numeroAleatorio = random_int(100000, 999999);

        // Exemplo de retorno: COMP-20260515-482915
        return 'COMP-' . $anoMes . '-' . $numeroAleatorio;
    }


    public function render()
    {
        return view('livewire.admin.pagamentos.registrar-pagamento');
    }
}
