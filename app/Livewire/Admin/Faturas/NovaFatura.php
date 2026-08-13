<?php

namespace App\Livewire\Admin\Faturas;

use App\Livewire\Admin\Mobile\Leiturista\Lroteiro;
use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Services\FaturaService;
use App\Services\Leituristas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class NovaFatura extends Component
{
    // Passo atual do wizard
    public int $passo = 1;

    // Dados do formulário
    public ?int $cliente_id = null;
    public string $mes_referencia = '';
    public ?string $data_vencimento = null;
    public ?float $leitura_anterior = null;
    public ?float $leitura_atual = null;
    public ?string $observacoes = null;
    public bool $gerar_boleto = true;

    // Dados carregados dinamicamente
    public array $clienteSelecionado = [];
    public array $previewCalculo = [];
    public array $ultimasFaturas = [];
    public bool $mostrarPreview = false;

    // Lista de clientes para o select
    public string $buscaCliente = '';
    public array $clientesFiltrados = [];

    protected FaturaService $faturaService;

    public function boot(FaturaService $faturaService): void
    {
        $this->faturaService = $faturaService;
    }

    protected function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'mes_referencia' => 'required', // MM/YYYY
            'data_vencimento' => 'nullable|date|after_or_equal:today',
            'leitura_atual' => 'required|numeric|min:0',
            'observacoes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * ============================================================
     * EVENTOS REATIVOS
     * ============================================================
     */

    /**
     * Quando seleciona um cliente, carrega dados dele
     */
    public function updatedClienteId(): void
    {
        $this->mostrarPreview = false;
        $this->previewCalculo = [];
        $this->leitura_anterior = null;
        $this->leitura_atual = null;

        if (!$this->cliente_id) {
            $this->clienteSelecionado = [];
            return;
        }

        $cliente = Cliente::with('medidor')->find($this->cliente_id);

        if (!$cliente) return;

        $medidor = Medidores::where('cliente_id', $cliente->id)
            ->where('status_inicial', 'instalado')
            ->first();

        // Busca última leitura para preencher leitura_anterior
        $ultimaLeitura = $medidor
            ? Leituras::where('medidores_id', $medidor->id)->latest('data_leitura')->first()
            : null;

        $this->leitura_anterior = $ultimaLeitura?->leitura_atual ?? 0;

        // Busca últimas faturas do cliente
        $this->ultimasFaturas = Faturas::where('cliente_id', $cliente->id)
            ->latest('data_emissao')
            ->limit(3)
            ->get()
            ->map(fn($f) => [
                'codigo' => $f->codigo_fatura,
                'mes' => $f->mes_referencia,
                'total' => number_format($f->valor_total, 2, ',', '.'),
                'status' => $f->status,
                'status_class' => match ($f->status) {
                    'Pago' => 'status-pago',
                    'Pendente' => 'status-pendente',
                    'Vencida' => 'status-vencida',
                    default => 'status-pendente',
                },
            ])
            ->toArray();

        $this->clienteSelecionado = [
            'id' => $cliente->id,
            'nome' => $cliente->nome_completo,
            'matricula' => $cliente->numero_matricula,
            'categoria' => $cliente->categoria_consumo,
            'hidrometro' => $medidor?->numero_hidrometro ?? 'N/A',
            'endereco' => "{$cliente->bairro}, {$cliente->cidade}",
            'medidor' => $medidor->id
        ];

        // Define mês de referência padrão (mês atual)
        if (empty($this->mes_referencia)) {
            $this->mes_referencia = now()->format('Y-m-d');
        }

        // Define vencimento padrão (5 dias úteis)
        if (empty($this->data_vencimento)) {
            // $this->data_vencimento = now()->addDays(5)->format('Y-m-d');
            $this->data_vencimento = now()->endOfMonth()->format('Y-m-d');
        }
    }

    /**
     * Quando altera leitura_atual, recalcula preview
     */
    public function updatedLeituraAtual(): void
    {
        $this->calcularPreview();
    }

    /**
     * Busca clientes para o autocomplete
     */
    public function updatedBuscaCliente(): void
    {
        if (strlen($this->buscaCliente) < 2) {
            $this->clientesFiltrados = [];
            return;
        }

        $this->clientesFiltrados = Cliente::query()
            ->where('status', 'Ativo')
            ->where(function ($q) {
                $q->where('nome_completo', 'like', "%{$this->buscaCliente}%")
                    ->orWhere('numero_matricula', 'like', "%{$this->buscaCliente}%")
                    ->orWhere('bi', 'like', "%{$this->buscaCliente}%");
            })
            ->limit(10)
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'nome' => $c->nome_completo,
                'matricula' => $c->numero_matricula,
                'categoria' => $c->categoria_consumo,
                'label' => "{$c->nome_completo} — {$c->numero_matricula} — {$c->categoria_consumo}",
            ])
            ->toArray();
    }

    /**
     * Seleciona cliente da busca
     */
    public function selecionarCliente(int $id): void
    {
        $this->cliente_id = $id;
        $this->buscaCliente = '';
        $this->clientesFiltrados = [];
        $this->updatedClienteId();
    }

    /**
     * ============================================================
     * AÇÕES
     * ============================================================
     */

    /**
     * Calcula preview da fatura (não persiste)
     */
    public function calcularPreview(): void
    {
        if (!$this->cliente_id || $this->leitura_atual === null || $this->leitura_atual === '') {
            $this->mostrarPreview = false;
            return;
        }

        try {
            $resultado = $this->faturaService->simularFatura(
                $this->cliente_id,
                (float) $this->leitura_atual,
                $this->leitura_anterior
            );
            // dd($resultado);

            $this->previewCalculo = $resultado['calculo'];
            $this->mostrarPreview = true;
        } catch (\Exception $e) {
            $this->mostrarPreview = false;
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Avança para o próximo passo
     */
    public function avancarPasso(): void
    {
        if ($this->passo === 1) {
            $this->validateOnly('cliente_id');
            $this->validateOnly('mes_referencia');
            $this->passo = 2;
        } elseif ($this->passo === 2) {
            $this->validateOnly('leitura_atual');
            $this->calcularPreview();
            $this->passo = 3;
        }
    }

    /**
     * Volta ao passo anterior
     */
    public function voltarPasso(): void
    {
        if ($this->passo > 1) {
            $this->passo--;
        }
    }

    /**
     * Emite a fatura (persiste no banco)
     */
    public function emitirFatura(): void
    {
        $this->validate();


        // Validação adicional: leitura atual > anterior
        if ((float) $this->leitura_atual < (float) $this->leitura_anterior) {
            $this->addError('leitura_atual', 'A leitura atual deve ser maior ou igual à anterior.');
            return;
        }

        $dataEmissao = now();
        $periodoFim = $this->data_vencimento;

        $dataInicio = $this->mes_referencia;
        $dataFim = $this->data_vencimento;

        try {
            // $resultado = $this->faturaService->criarFaturaManual([
            //     'cliente_id' => $this->cliente_id,
            //     'mes_referencia' => $this->mes_referencia,
            //     'data_vencimento' => $this->data_vencimento,
            //     'leitura_atual' => (float) $this->leitura_atual,
            //     'leitura_anterior' => (float) $this->leitura_anterior,
            //     'observacoes' => $this->observacoes,
            //     'origem' => 'sistema',
            // ]);

            $fatura = Faturas::create([
                'cliente_id' => $this->cliente_id,
                'leitura_id' =>  null,

                'codigo_fatura' => app(FaturaService::class)->gerarCodigoFatura($this->mes_referencia),
                'mes_referencia' => $this->mes_referencia,
                'periodo_inicio' => $dataInicio,
                'periodo_fim' => $dataFim,
                'consumo_m3' => 0,
                'valor_consumo' => 0,
                'valor_esgoto' => 0,
                'taxa_disponibilidade' => 0,


                'valor_pago'           => 0.00,
                'saldo_atual'          => 0.00,
                'negociada'            => 0.00,
                'parcelas_qtd'         => 0,
                'juros_isento'         => 0,

                'multa' => 0.00,
                'juros' => 0.00,
                'desconto' => 0.00,
                'valor_total' => 0,
                'data_emissao' => $dataEmissao,
                'data_vencimento' => $dataEmissao->copy()->endOfMonth(),

                'status' => 'Pendente',
                'observacoes' => null,
            ]);


            $modal = app(Lroteiro::class);

            $modal->cliente_id =  $this->cliente_id;
            $modal->user_id =  Auth::id();
            $modal->mes_referencia =  $this->mes_referencia;
            $modal->ultimaLeitura =  $this->leitura_anterior;
            $modal->leitura_atual =  $this->leitura_atual;
            $modal->fatura_id =  $fatura->id;
            $modal->medidores_id =  $this->clienteSelecionado['medidor'];
            $modal->origem =  "sistema";

            $resultado =  $modal->CadastrarLeitura();
            // [
            //     'cliente_id' => $this->cliente_id,
            //     'user_id' => Auth::id(),
            //     'mes_referencia' => $this->mes_referencia,
            //     'ultimaLeitura' => $this->leitura_anterior,
            //     'leitura_atual' => $this->leitura_atual,
            //     'fatura_id' => $fatura->id,
            // ]
            // $fatura = $resultado['fatura'];

            // Dispara evento para notificar sucesso e fechar modal
            // $this->dispatch('fatura-criada', [
            //     'fatura_id' => $fatura->id,
            //     'codigo' => $fatura->codigo_fatura,
            //     'valor' => number_format($fatura->valor_total, 2, ',', '.'),
            // ]);

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => "Fatura {$fatura->codigo_fatura} emitida com sucesso! Valor: MZN " . number_format($fatura->valor_total, 2, ',', '.'),
            ]);

            // $this->dispatch('showToast', [
            //     'message' => 'Leitura registrada com sucesso!',
            //     'type' => 'success'
            // ]);

            $this->dispatch('fatura-criada');
            $this->dispatch('closeModal', 'modal-nova-fatura');

            // Reseta formulário
            $this->reset([
                'cliente_id',
                'mes_referencia',
                'data_vencimento',
                'leitura_anterior',
                'leitura_atual',
                'observacoes',
                'clienteSelecionado',
                'previewCalculo',
                'ultimasFaturas',
                'mostrarPreview',
                'passo',
                'gerar_boleto'
            ]);
            $this->passo = 1;
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erro ao emitir fatura: ' . $e->getMessage(),
            ]);
            Log::error('Erro emissão fatura manual', [
                'erro' => $e->getMessage(),
                'dados' => [
                    'cliente_id' => $this->cliente_id,
                    'leitura' => $this->leitura_atual,
                ],
            ]);
        }
    }

    /**
     * Salva como rascunho (fatura com status especial ou apenas leitura)
     */
    public function salvarRascunho(): void
    {
        // Implementar se necessário: criar fatura com status 'Rascunho'
        // ou apenas salvar os dados em sessão
        $this->dispatch('notify', [
            'type' => 'info',
            'message' => 'Rascunho salvo (funcionalidade em desenvolvimento).',
        ]);
    }



    public function render()
    {
        return view('livewire.admin.faturas.nova-fatura', [
            'clientes' => Cliente::where('status', 'Ativo')
                ->orderBy('nome_completo')
                ->get(['id', 'nome_completo', 'numero_matricula', 'categoria_consumo']),
        ]);
    }
}