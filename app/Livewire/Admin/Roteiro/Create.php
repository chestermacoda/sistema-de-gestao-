<?php

namespace App\Livewire\Admin\Roteiro;


use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\RoteiroLeiturista;
use App\Models\User;
use App\Services\FaturaService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

use Livewire\Component;

class Create extends Component
{

    // ============ PROPRIEDADES DO FORMULÁRIO ============
    public ?int $userId = null;
    public string $zona = '';
    public ?string $dataInicio = null;
    public ?string $dataFim = null;
    public ?string $dataReferente = null;
    public string $observacoes = '';
    public bool $enviarNotificacao = true;
    public bool $salvarRascunho = false;

    // ============ LISTAS DINÂMICAS ============
    public $leituristas = [];
    public $zonas = [];
    public $medidoresDisponiveis = [];
    public array $medidoresSelecionados = [];

    // ============ FILTROS DE MEDIDORES ============
    public string $buscaMedidor = '';
    public string $filtroStatusMedidor = '';

    // ============ ESTADO DO MODAL ============
    public bool $mostrarModal = false;
    public bool $mostrarConfirmacao = false;
    public int $passoAtual = 1;

    // ============ CONFIGURAÇÕES ============
    public array $zonasDisponiveis = [
        'Zona Norte' => 'Zona Norte',
        'Zona Sul' => 'Zona Sul',
        'Zona Leste' => 'Zona Leste',
        'Zona Oeste' => 'Zona Oeste',
        'Centro' => 'Centro',
    ];

    public array $statusRoteiro = [
        'pendente' => 'pendente',
        'validada' => 'Em Andamento',
        'concluido' => 'Concluído',
        'cancelado' => 'Cancelado',
    ];

    protected $listeners = ['abrir-modal-roteiro' => 'abrirModal'];

    // ============ REGRAS DE VALIDAÇÃO ============
    protected function rules(): array
    {
        return [
            'userId' => 'required|exists:users,id',
            'zona' => 'required|string|in:' . implode(',', array_keys($this->zonasDisponiveis)),
            'dataInicio' => 'required|date|after_or_equal:today',
            'dataFim' => 'required|date|after_or_equal:dataInicio',
            'dataReferente' => 'required|date',
            'observacoes' => 'nullable|string|max:1000',
            'medidoresSelecionados' => 'required|array|min:1',
            // 'medidoresSelecionados.*' => 'integer|exists:leituras,id',
        ];
    }

    protected function messages(): array
    {
        return [
            'userId.required' => 'Selecione um leiturista.',
            'zona.required' => 'Selecione uma zona.',
            'dataInicio.required' => 'Informe a data de início.',
            'dataInicio.after_or_equal' => 'A data de início deve ser hoje ou futura.',
            'dataFim.required' => 'Informe a data de fim.',
            'dataFim.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',
            'dataReferente.required' => 'Informe o mês de referência.',
            'medidoresSelecionados.required' => 'Selecione pelo menos um medidor.',
            'medidoresSelecionados.min' => 'Selecione pelo menos um medidor.',
        ];
    }

    // ============ MOUNT ============
    public function mount(): void
    {
        $this->carregarLeituristas();
        $this->dataInicio = now()->format('Y-m-d');
        $this->dataFim = now()->endOfMonth()->format('Y-m-d');
        $this->dataReferente = now()->format('Y-m-d');
    }

    // ============ CARREGAR DADOS ============
    public function carregarLeituristas(): void
    {
        $this->leituristas = User::role('leiturista')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
    }

    // ============ MODAL ============
    public function abrirModal(): void
    {
        $this->resetForm();
        $this->mostrarModal = true;
        $this->dispatch('abrir-modal-js', modalId: 'modal-atribuir');
    }

    public function fecharModal(): void
    {
        $this->mostrarModal = false;
        $this->resetForm();
        $this->dispatch('fechar-modal-js', modalId: 'modal-atribuir');
    }

    // ============ RESET FORM ============
    public function resetForm(): void
    {
        $this->reset([
            'userId',
            'zona',
            'observacoes',
            'medidoresSelecionados',
            'buscaMedidor',
            'filtroStatusMedidor',
            'mostrarConfirmacao',
        ]);
        $this->passoAtual = 1;
        $this->dataInicio = now()->format('Y-m-d');
        $this->dataFim = now()->addDays(10)->format('Y-m-d');
        $this->dataReferente = now()->format('Y-m-d');
        $this->enviarNotificacao = true;
        $this->medidoresDisponiveis = [];
    }

    // ============ PASSOS DO WIZARD ============
    public function proximoPasso(): void
    {
        if ($this->passoAtual === 1) {
            $this->validate([
                'userId' => 'required',
                // 'zona' => 'required',
                'dataInicio' => 'required|date',
                'dataFim' => 'required|date|after_or_equal:dataInicio',
                'dataReferente' => 'required|date',
            ]);

            $this->carregarMedidores();
            $this->passoAtual = 2;
        }
    }

    public function passoAnterior(): void
    {
        if ($this->passoAtual > 1) {
            $this->passoAtual--;
        }
    }
    public function carregarMedidores(): void
    {
        $query = Cliente::with([
            'medidor',                    // Medidor atual
            'ultimaLeitura',              // Última leitura (pode ser null)
            'faturas' => function ($q) {  // Última fatura emitida
                $q->latest('data_emissao')->limit(1);
            }
        ])
            ->where('status', 'Ativo');      // Apenas clientes ativos


        // ==================== FILTROS ====================

        if ($this->buscaMedidor) {
            $search = '%' . $this->buscaMedidor . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nome_completo', 'like', $search)
                    ->orWhere('numero_matricula', 'like', $search)
                    ->orWhere('cpf_cnpj', 'like', $search)
                    ->orWhereHas('medidor', function ($m) use ($search) {
                        $m->where('codigo', 'like', $search)
                            ->orWhere('numero_serie', 'like', $search);
                    });
            });
        }

        if ($this->zona) {
            $query->where('zona_distribuicao', 'like', '%' . $this->zona . '%');
        }

        if ($this->filtroStatusMedidor) {
            // Se precisar filtrar por status do medidor
            $query->whereHas('medidor', fn($q) => $q->where('status', $this->filtroStatusMedidor));
        }

        // ==================== EXECUÇÃO ====================

        $clientes = $query->orderBy('nome_completo')
            ->limit(100)
            ->get();

        // ==================== MAPEAMENTO ====================

        $this->medidoresDisponiveis = $clientes->map(function ($cliente) {

            $ultimaLeitura = $cliente->ultimaLeitura;
            $ultimaFatura  = $cliente->faturas->first();
            $medidorAtual  = $cliente->medidor;

            return [
                'cliente_id'         => $cliente->id,
                'cliente_nome'       => $cliente->nome_completo,
                'cliente_matricula'  => $cliente->numero_matricula ?? 'N/A',
                'cliente_zona'       => $cliente->zona_distribuicao ?? 'N/A',
                'cliente_endereco'   => $this->formatarEndereco($cliente),
                'categoria_consumo'  => $cliente->categoria_consumo,

                // Medidor
                'medidor_id'         => $medidorAtual?->id,
                'medidor_codigo'     => $medidorAtual?->numero_hidrometro ?? 'N/A',
                'medidor_serie'      => $medidorAtual?->numero_serie ?? 'N/A',

                // Última Leitura
                'leitura_anterior'   => $ultimaLeitura?->leitura_atual ?? null,
                'data_ultima_leitura' => $ultimaLeitura?->data_leitura?->format('d/m/Y'),

                // Última Fatura
                'fatura_codigo'      => $ultimaFatura?->codigo_fatura,
                'fatura_valor_total' => $ultimaFatura?->valor_total,
                'fatura_status'      => $ultimaFatura?->status,
                'esta_vencida'       => $ultimaFatura?->esta_vencida ?? false,

                // Status
                'status_medidor'     => $medidorAtual?->status ?? 'Pendente',
                'tem_leitura_mes'    => false, // Como já filtramos, sempre false aqui
            ];
        })->toArray();
    }
    private function formatarEndereco(?Cliente $cliente): string
    {
        if (!$cliente) return 'Endereço não disponível';

        $parts = array_filter([
            $cliente->logradouro,
            $cliente->numero ? 'Nº ' . $cliente->numero : null,
            $cliente->bairro,
            $cliente->cidade,
        ]);

        return implode(', ', $parts) ?: 'Endereço não disponível';
    }

    // ============ ATUALIZAR FILTROS ============
    public function updatedBuscaMedidor(): void
    {
        if ($this->passoAtual === 2) {
            $this->carregarMedidores();
        }
    }

    public function updatedFiltroStatusMedidor(): void
    {
        if ($this->passoAtual === 2) {
            $this->carregarMedidores();
        }
    }

    public function updatedZona(): void
    {
        // 1. Limpa as seleções da zona antiga por segurança
        $this->medidoresSelecionados = [];
        $this->medidoresDisponiveis = [];

        // 2. Se o seu componente usa paginação, resete aqui
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }

        // 3. Força a busca dos novos medidores da nova zona imediatamente
        $this->carregarMedidores();
    }
    // ============ SELEÇÃO DE MEDIDORES ============
    // public function toggleMedidor(int $medidorId): void
    // {
    //     if (in_array($medidorId, $this->medidoresSelecionados)) {
    //         $this->medidoresSelecionados = array_diff(
    //             $this->medidoresSelecionados,
    //             [$medidorId]
    //         );
    //     } else {
    //         $this->medidoresSelecionados[] = $medidorId;
    //     }

    //     $this->medidoresSelecionados = array_values($this->medidoresSelecionados);
    // }

    public function toggleMedidor($clienteId): void
    {
        $clienteId = (int) $clienteId;

        if (in_array($clienteId, $this->medidoresSelecionados)) {
            $this->medidoresSelecionados = array_filter(
                $this->medidoresSelecionados,
                fn($id) => $id !== $clienteId
            );
        } else {
            $this->medidoresSelecionados[] = $clienteId;
        }

        // Remove duplicados e reindexa
        $this->medidoresSelecionados = array_values(array_unique($this->medidoresSelecionados));
    }

    public function selecionarTodos(): void
    {
        $this->medidoresSelecionados = collect($this->medidoresDisponiveis)
            ->pluck('cliente_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        // dd($this->medidoresSelecionados);
    }

    public function limparSelecao(): void
    {
        $this->medidoresSelecionados = [];
    }

    // ============ SALVAR RASCUNHO ============
    public function salvarRascunho(): void
    {
        $this->salvarRascunho = true;
        $this->criarRoteiro();
    }
    private function clienteJaTemRoteiroNoMes(int $clienteId, string $dataReferente): bool
    {
        $data = Carbon::parse($dataReferente);

        $existe = RoteiroLeiturista::where('cliente_id', $clienteId)
            ->whereYear('data_referente', $data->year)
            ->whereMonth('data_referente', $data->month)
            ->exists();

        return $existe;
    }

    // ============ CRIAR ROTEIRO ============
    public function criarRoteiro(): void
    {
        $validate = $this->validate();


        // try {
        // DB::transaction(function () {
        $ordem = 1;
        $dataEmissao = now();
        $periodoFim = $dataEmissao->copy()->endOfMonth();
        foreach ($this->medidoresSelecionados as $Cliente_id) {



            $ultimaLeituraDoCliente = Leituras::where('cliente_id', $Cliente_id)
                ->latest('id') // Ou latest('created_at'), garante que traz o último inserido
                ->first();

            if ($this->clienteJaTemRoteiroNoMes($Cliente_id, $this->dataReferente)) {

                $cliente = Cliente::find($Cliente_id);

                $this->dispatch('showToast', [
                    'type'    => 'warning',
                    'message' => "O cliente <strong>{$cliente?->nome_completo}</strong> já possui roteiro atribuído neste mês ({$dataEmissao->format('m/Y')})."
                ]);

                return; // Interrompe tudo
            }


            $fatura = Faturas::create([
                'cliente_id' => $Cliente_id,
                'leitura_id' =>  null,

                'codigo_fatura' => app(FaturaService::class)->gerarCodigoFatura($this->dataReferente),
                'mes_referencia' => $this->dataReferente,
                'periodo_inicio' => $this->dataInicio,
                'periodo_fim' => $periodoFim,
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


            RoteiroLeiturista::create([
                'user_id' => $this->userId,
                'fatura_id' => $fatura->id ?? 0,
                'cliente_id' => $Cliente_id ?? 0,
                'numero_fatura' => $Cliente_id ?? 0,
                'data_referente' => $this->dataReferente,
                'leitura_anterior' => $ultimaLeituraDoCliente->leitura_atual ?? 0,
                'leitura_atual' => null,
                'data_inicio' => $this->dataInicio,
                'data_fim' => $this->dataFim,
                'Zona' => $this->zona,
                'status' => $this->salvarRascunho ? 'Pendente' : 'Pendente',
                'observacoes' => $this->observacoes,
                'ordem' => $ordem++,
                'foto' => null,
                'lido_em' => null,
                'created_by' => Auth::id(),
            ]);
        }

        $this->dispatch('showToast', [
            'message' => 'Roteiro atribuído com sucesso!',
            'type' => 'success',
        ]);
    }



    public function render()
    {
        return view('livewire.admin.roteiro.create');
    }
}