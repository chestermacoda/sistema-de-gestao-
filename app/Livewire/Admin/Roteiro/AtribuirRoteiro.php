<?php

namespace App\Livewire\Admin\Roteiro;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\Leituras;
use App\Models\RoteiroLeiturista;
use App\Models\User;
use App\Services\FaturaService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AtribuirRoteiro extends Component
{
    // ============ PROPRIEDADES DO LEITURISTA ORIGEM ============
    public ?int $userIdOrigem = null;          // Leiturista do roteiro antigo
    public ?string $dataReferenteOrigem = null; // Mês do roteiro antigo
    public ?string $zonaOrigem = null;          // Zona do roteiro antigo

    // ============ PROPRIEDADES DO NOVO ROTEIRO ============
    public ?int $userIdDestino = null;          // Novo leiturista (pode ser o mesmo)
    public ?string $dataInicio = null;
    public ?string $dataFim = null;
    public ?string $dataReferenteDestino = null; // Sempre mês atual
    public string $observacoes = '';
    public bool $manterOrdem = true;            // Manter ordem do roteiro antigo

    // ============ DADOS DO ROTEIRO ANTIGO ============
    public array $roteiroAntigo = [];           // Lista de itens do roteiro antigo
    public array $roteiroInfo = [];             // Info geral do roteiro antigo
    public array $clientesSelecionados = [];    // IDs dos clientes marcados para reatribuir
    public array $clientesComProblema = [];     // Clientes com anomalias/problemas no roteiro antigo

    // ============ LISTAS DINÂMICAS ============
    public array $leituristas = [];
    public array $zonasDisponiveis = [
        'Zona Norte'  => 'Zona Norte',
        'Zona Sul'    => 'Zona Sul',
        'Zona Leste'  => 'Zona Leste',
        'Zona Oeste'  => 'Zona Oeste',
        'Centro'      => 'Centro',
    ];

    // ============ ESTADO DO MODAL ============
    public bool $mostrarModal = false;
    public bool $mostrarConfirmacao = false;
    public int $passoAtual = 1;
    public bool $carregando = false;
    public ?string $erroValidacao = null;

    // ============ REGRAS DE VALIDAÇÃO ============
    protected function rules(): array
    {
        return [
            'userIdDestino'     => 'required|exists:users,id',
            'dataInicio'        => 'required|date|after_or_equal:today',
            'dataFim'           => 'required|date|after_or_equal:dataInicio',
            'dataReferenteDestino' => 'required|date',
            'clientesSelecionados' => 'required|array|min:1',
            'observacoes'       => 'nullable|string|max:1000',
        ];
    }

    protected function messages(): array
    {
        return [
            'userIdDestino.required'     => 'Selecione um leiturista.',
            'dataInicio.required'        => 'Informe a data de início.',
            'dataInicio.after_or_equal'  => 'A data de início deve ser hoje ou futura.',
            'dataFim.required'           => 'Informe a data de fim.',
            'dataFim.after_or_equal'     => 'A data de fim deve ser igual ou posterior à data de início.',
            'clientesSelecionados.required' => 'Selecione pelo menos um cliente.',
            'clientesSelecionados.min'   => 'Selecione pelo menos um cliente.',
        ];
    }

    // ============ MOUNT ============
    public function mount(): void
    {
        $this->carregarLeituristas();
        $this->dataInicio = now()->format('Y-m-d');
        $this->dataFim = now()->addDays(10)->format('Y-m-d');
        $this->dataReferenteDestino = now()->format('Y-m-01');


        // dd($this->dataReferenteDestino);
    }

    // ============ CARREGAR LEITURISTAS ============
    public function carregarLeituristas(): void
    {
        $this->leituristas = User::role('leiturista')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    // ═══════════════════════════════════════════════════════════
    // ABRIR MODAL COM ROTEIRO ANTIGO
    // ═══════════════════════════════════════════════════════════

    #[On('reatribuir-roteiro')]
    public function abrirModal(int $userId, string $dataReferente, ?string $zona = null): void
    {
        // dd([
        //     $userId,
        //     $dataReferente,
        //     $zona
        // ]);
        $this->resetForm();
        $this->carregando = true;

        $this->userIdOrigem = $userId;
        $this->dataReferenteOrigem = $dataReferente;
        $this->zonaOrigem = $zona;

        try {
            // ─── Verificar se roteiro existe e está concluído ───
            $roteiroExistente = RoteiroLeiturista::where('user_id', $userId)
                ->whereDate('data_referente', $dataReferente)
                ->when($zona, fn($q) => $q->where('Zona', $zona))
                ->first();

            if (!$roteiroExistente) {
                $this->erroValidacao = "Nenhum roteiro encontrado para este leiturista neste período.";
                $this->dispatch('showToast', [
                    'type'    => 'error',
                    'message' => $this->erroValidacao,
                ]);
                $this->carregando = false;
                return;
            }

            // ─── Verificar se roteiro está concluído ───
            $statusRoteiro = $this->verificarStatusRoteiro($userId, $dataReferente, $zona);

            if ($statusRoteiro !== 'Concluido') {
                $this->erroValidacao = "Este roteiro não pode ser reatribuído porque ainda não está concluído (Status atual: {$statusRoteiro}).";
                $this->dispatch('showToast', [
                    'type'    => 'warning',
                    'message' => $this->erroValidacao,
                ]);
                $this->carregando = false;
                return;
            }

            // ─── Verificar se já foi reatribuído este mês ───
            if ($this->jaFoiReatribuidoEsteMes($userId, $dataReferente, $zona)) {
                $this->erroValidacao = "Este roteiro já foi reatribuído para o mês atual. Só é possível reatribuir uma vez por mês.";
                $this->dispatch('showToast', [
                    'type'    => 'warning',
                    'message' => $this->erroValidacao,
                ]);
                $this->carregando = false;
                return;
            }

            // ─── Carregar itens do roteiro antigo ───
            $this->carregarRoteiroAntigo($userId, $dataReferente, $zona);

            // ─── Definir novo leiturista (padrão: mesmo do original) ───
            $this->userIdDestino = $userId;

            $this->mostrarModal = true;
            $this->dispatch('openModal', 'modal-reatribuir');
        } catch (\Exception $e) {

            $this->dispatch('showToast', [
                'type'    => 'error',
                'message' => 'Erro ao carregar roteiro: ' . $e->getMessage(),
            ]);
        }

        $this->carregando = false;
    }

    // ═══════════════════════════════════════════════════════════
    // VERIFICAR STATUS GERAL DO ROTEIRO
    // ═══════════════════════════════════════════════════════════

    protected function verificarStatusRoteiro(int $userId, string $dataReferente, ?string $zona): string
    {
        $itens = RoteiroLeiturista::where('user_id', $userId)
            ->whereDate('data_referente', $dataReferente)
            ->when($zona, fn($q) => $q->where('Zona', $zona))
            ->get();

        if ($itens->isEmpty()) return 'Inexistente';

        $total = $itens->count();
        $lidos = $itens->whereNotNull('leitura_atual')->count();
        $anomalias = $itens->filter(fn($i) => $this->temAnomalia($i))->count();
        $problemas = $itens->whereNotNull('foto')->whereNull('leitura_atual')->count();

        // Se todos lidos e sem problemas/anomalias pendentes = Concluido
        if ($lidos === $total && $problemas === 0) {
            return 'Concluido';
        }

        // Se todos lidos mas com anomalias = Concluido (com ressalvas)
        if ($lidos === $total) {
            return 'Concluido';
        }

        // Se parcialmente lido = Em andamento
        if ($lidos > 0) {
            return 'Em andamento';
        }

        return 'Pendente';
    }

    // ═══════════════════════════════════════════════════════════
    // VERIFICAR SE JÁ FOI REATRIBUÍDO ESTE MÊS
    // ═══════════════════════════════════════════════════════════

    protected function jaFoiReatribuidoEsteMes(int $userId, string $dataReferenteOrigem, ?string $zona): bool
    {
        $mesAtual = now()->format('Y-m-01');

        // Verifica se existe roteiro para este leiturista no mês atual
        // que tenha sido criado a partir de uma reatribuição
        $existe = RoteiroLeiturista::where('user_id', $userId)
            ->whereDate('data_referente', $mesAtual)
            ->when($zona, fn($q) => $q->where('Zona', $zona))
            ->where(function ($q) use ($dataReferenteOrigem) {
                // Verifica se há observação indicando reatribuição
                $q->where('observacoes', 'like', '%Reatribuído%')
                    ->orWhere('observacoes', 'like', '%Re-atribuído%');
            })
            ->exists();

        // Também verifica se há qualquer roteiro no mês atual para os mesmos clientes
        // independente do leiturista (evita duplicar clientes)
        $clientesOrigem = RoteiroLeiturista::where('user_id', $userId)
            ->whereDate('data_referente', $dataReferenteOrigem)
            ->when($zona, fn($q) => $q->where('Zona', $zona))
            ->pluck('cliente_id')
            ->toArray();

        if (!empty($clientesOrigem)) {
            $existeNovoRoteiro = RoteiroLeiturista::whereDate('data_referente', $mesAtual)
                ->whereIn('cliente_id', $clientesOrigem)
                ->when($zona, fn($q) => $q->where('Zona', $zona))
                ->exists();

            if ($existeNovoRoteiro) {
                return true;
            }
        }

        return $existe;
    }

    // ═══════════════════════════════════════════════════════════
    // CARREGAR ROTEIRO ANTIGO
    // ═══════════════════════════════════════════════════════════

    protected function carregarRoteiroAntigo(int $userId, string $dataReferente, ?string $zona): void
    {
        $itens = RoteiroLeiturista::with(['cliente', 'cliente.medidores', 'fatura'])
            ->where('user_id', $userId)
            ->whereDate('data_referente', $dataReferente)
            ->when($zona, fn($q) => $q->where('Zona', $zona))
            ->orderBy('ordem', 'asc')
            ->get();

        $leiturista = User::find($userId);
        $primeiroItem = $itens->first();

        $this->roteiroInfo = [
            'leiturista_nome'     => $leiturista?->name ?? 'N/A',
            'leiturista_id'       => $userId,
            'data_referente'      => Carbon::parse($dataReferente)->format('d/m/Y'),
            'mes_ano'             => Carbon::parse($dataReferente)->translatedFormat('F/Y'),
            'zona'                => $zona ?? 'Todas',
            'total_clientes'      => $itens->count(),
            'data_inicio'         => $primeiroItem?->data_inicio?->format('d/m/Y') ?? 'N/A',
            'data_fim'            => $primeiroItem?->data_fim?->format('d/m/Y') ?? 'N/A',
        ];

        $this->roteiroAntigo = $itens->map(function ($item) {
            $cliente = $item->cliente;
            $medidor = $cliente?->medidores->first();
            $consumo = null;

            if ($item->leitura_atual !== null && $item->leitura_anterior !== null) {
                $consumo = max(0, (float) $item->leitura_atual - (float) $item->leitura_anterior);
            }

            $status = $this->determinarStatusItem($item, $consumo);

            // Se tem problema/anomalia, adiciona à lista especial
            if (in_array($status, ['Anomalia', 'Problema'])) {
                $this->clientesComProblema[] = $item->cliente_id;
            }

            return [
                'id'                => $item->id,
                'cliente_id'        => $item->cliente_id,
                'ordem'             => $item->ordem,
                'nome'              => $cliente?->nome_completo ?? 'N/A',
                'matricula'         => $cliente?->numero_matricula ?? 'N/A',
                'endereco'          => $this->formatarEndereco($cliente),
                'contacto'          => $cliente?->contacto ?? 'N/A',
                'medidor'           => $medidor?->numero_serie ?? 'N/A',
                'medidor_codigo'    => $medidor?->numero_hidrometro ?? 'N/A',
                'leitura_anterior'  => $item->leitura_anterior,
                'leitura_atual'     => $item->leitura_atual,
                'consumo'           => $consumo,
                'status'            => $status,
                'lido_em'           => $item->lido_em?->format('d/m/Y H:i') ?? null,
                'foto'              => $item->foto,
                'observacoes'       => $item->observacoes,
                'fatura_codigo'     => $item->fatura?->codigo_fatura ?? null,
                'fatura_status'     => $item->fatura?->status ?? null,
            ];
        })->toArray();

        // Pré-selecionar todos os clientes por padrão
        $this->clientesSelecionados = collect($this->roteiroAntigo)
            ->pluck('cliente_id')
            ->map(fn($id) => (int) $id)
            ->toArray();
    }

    // ═══════════════════════════════════════════════════════════
    // DETERMINAR STATUS DO ITEM
    // ═══════════════════════════════════════════════════════════

    protected function determinarStatusItem($item, ?float $consumo): string
    {
        if ($item->leitura_atual === null && $item->foto !== null) {
            return 'Problema';
        }

        if ($item->leitura_atual === null) {
            return 'Não lido';
        }

        if ($consumo !== null && ($consumo < 0 || $consumo > 500)) {
            return 'Anomalia';
        }

        return 'OK';
    }

    // ═══════════════════════════════════════════════════════════
    // VERIFICAR ANOMALIA
    // ═══════════════════════════════════════════════════════════

    protected function temAnomalia($item): bool
    {
        if ($item->leitura_atual === null || $item->leitura_anterior === null) {
            return false;
        }

        $consumo = (float) $item->leitura_atual - (float) $item->leitura_anterior;
        return $consumo < 0 || $consumo > 500;
    }

    // ═══════════════════════════════════════════════════════════
    // FORMATAR ENDEREÇO
    // ═══════════════════════════════════════════════════════════

    protected function formatarEndereco(?Cliente $cliente): string
    {
        if (!$cliente) return 'Endereço não disponível';

        $parts = array_filter([
            $cliente->logradouro ?? $cliente->rua,
            $cliente->numero ? 'Nº ' . $cliente->numero : null,
            $cliente->bairro,
            $cliente->cidade,
        ]);

        return implode(', ', $parts) ?: 'Endereço não disponível';
    }

    // ═══════════════════════════════════════════════════════════
    // TOGGLE CLIENTE SELECIONADO
    // ═══════════════════════════════════════════════════════════

    public function toggleCliente(int $clienteId): void
    {
        $clienteId = (int) $clienteId;

        if (in_array($clienteId, $this->clientesSelecionados)) {
            $this->clientesSelecionados = array_filter(
                $this->clientesSelecionados,
                fn($id) => $id !== $clienteId
            );
        } else {
            $this->clientesSelecionados[] = $clienteId;
        }

        $this->clientesSelecionados = array_values(array_unique($this->clientesSelecionados));
    }

    // ═══════════════════════════════════════════════════════════
    // SELECIONAR / LIMPAR TODOS
    // ═══════════════════════════════════════════════════════════

    public function selecionarTodos(): void
    {
        $this->clientesSelecionados = collect($this->roteiroAntigo)
            ->pluck('cliente_id')
            ->map(fn($id) => (int) $id)
            ->toArray();
    }

    public function selecionarApenasComProblema(): void
    {
        $this->clientesSelecionados = $this->clientesComProblema;
    }

    public function limparSelecao(): void
    {
        $this->clientesSelecionados = [];
    }

    // ═══════════════════════════════════════════════════════════
    // PASSOS DO WIZARD
    // ═══════════════════════════════════════════════════════════

    public function proximoPasso(): void
    {
        if ($this->passoAtual === 1) {
            // Validar dados do novo roteiro
            $this->validate([
                'userIdDestino'        => 'required|exists:users,id',
                'dataInicio'           => 'required|date|after_or_equal:today',
                'dataFim'              => 'required|date|after_or_equal:dataInicio',
                'dataReferenteDestino' => 'required|date',
            ]);

            $this->passoAtual = 2;
        } elseif ($this->passoAtual === 2) {
            // Validar seleção de clientes
            if (empty($this->clientesSelecionados)) {
                $this->dispatch('showToast', [
                    'type'    => 'warning',
                    'message' => 'Selecione pelo menos um cliente para reatribuir.',
                ]);
                return;
            }

            $this->mostrarConfirmacao = true;
            $this->passoAtual = 3;
        }
    }

    public function passoAnterior(): void
    {
        if ($this->passoAtual === 3) {
            $this->mostrarConfirmacao = false;
        }
        if ($this->passoAtual > 1) {
            $this->passoAtual--;
        }
    }

    // ═══════════════════════════════════════════════════════════
    // VERIFICAR CLIENTE JÁ TEM ROTEIRO NO MÊS DESTINO
    // ═══════════════════════════════════════════════════════════

    protected function clienteJaTemRoteiroNoMes(int $clienteId, string $dataReferente): bool
    {
        $data = Carbon::parse($dataReferente);

        return RoteiroLeiturista::where('cliente_id', $clienteId)
            ->whereYear('data_referente', $data->year)
            ->whereMonth('data_referente', $data->month)
            ->exists();
    }

    // ═══════════════════════════════════════════════════════════
    // CRIAR NOVO ROTEIRO (REATRIBUIÇÃO)
    // ═══════════════════════════════════════════════════════════

    public function confirmarReatribuicao(): void
    {

        $this->validate();

        if (empty($this->clientesSelecionados)) {
            $this->dispatch('showToast', [
                'type'    => 'warning',
                'message' => 'Nenhum cliente selecionado.',
            ]);
            return;
        }

        try {
            $ordem = 1;
            $dataEmissao = now();
            $periodoFim = Carbon::parse($this->dataReferenteDestino)->endOfMonth();
            $clientesIgnorados = [];
            $clientesCriados = 0;

            foreach ($this->clientesSelecionados as $clienteId) {
                $clienteId = (int) $clienteId;

                // ─── Verificar se cliente já tem roteiro no mês destino ───
                if ($this->clienteJaTemRoteiroNoMes($clienteId, $this->dataReferenteDestino)) {
                    $cliente = Cliente::find($clienteId);
                    $clientesIgnorados[] = $cliente?->nome_completo ?? "ID {$clienteId}";
                    continue;
                }

                // ─── Buscar última leitura do cliente ───
                $ultimaLeitura = Leituras::where('cliente_id', $clienteId)
                    ->latest('id')
                    ->first();

                // ─── Criar fatura ───
                $fatura = Faturas::create([
                    'cliente_id'           => $clienteId,
                    'leitura_id'           => null,
                    'codigo_fatura'        => app(FaturaService::class)->gerarCodigoFatura($this->dataReferenteDestino),
                    'mes_referencia'       => $this->dataReferenteDestino,
                    'periodo_inicio'       => $this->dataInicio,
                    'periodo_fim'          => $periodoFim,
                    'consumo_m3'           => 0,
                    'valor_consumo'        => 0,
                    'valor_esgoto'         => 0,
                    'taxa_disponibilidade' => 0,
                    'multa'                => 0.00,
                    'juros'                => 0.00,
                    'desconto'             => 0.00,
                    'valor_total'          => 0.00,
                    'valor_pago'           => 0.00,
                    'saldo_atual'          => 0.00,
                    'negociada'            => 0.00,
                    'parcelas_qtd'         => 0,
                    'juros_isento'         => 0,
                    'data_emissao'         => $dataEmissao,
                    'data_vencimento'      => $periodoFim,
                    'status'               => 'Pendente',
                    'observacoes'          => null,
                ]);

                // ─── Criar roteiro ───
                RoteiroLeiturista::create([
                    'user_id'         => $this->userIdDestino,
                    'fatura_id'       => $fatura->id,
                    'cliente_id'      => $clienteId,
                    'numero_fatura'   => $clienteId,
                    'data_referente'  => $this->dataReferenteDestino,
                    'leitura_anterior' => $ultimaLeitura?->leitura_atual ?? 0,
                    'leitura_atual'   => null,
                    'data_inicio'     => $this->dataInicio,
                    'data_fim'        => $this->dataFim,
                    'Zona'            => $this->zonaOrigem ?? 'N/A',
                    'status'          => 'Pendente',
                    'observacoes'     => 'Reatribuído do roteiro de ' . $this->roteiroInfo['mes_ano'] .
                        ' (Leiturista: ' . $this->roteiroInfo['leiturista_nome'] . '). ' .
                        ($this->observacoes ? 'Obs: ' . $this->observacoes : ''),
                    'ordem'           => $this->manterOrdem
                        ? $this->getOrdemOriginal($clienteId)
                        : $ordem++,
                    'foto'            => null,
                    'lido_em'         => null,
                    'created_by'      => Auth::id(),
                ]);

                $clientesCriados++;
            }

            // ─── Feedback ───
            $mensagem = "Reatribuição concluída! {$clientesCriados} cliente(s) adicionado(s) ao novo roteiro.";

            if (!empty($clientesIgnorados)) {
                $mensagem .= " " . count($clientesIgnorados) . " ignorado(s) (já possuem roteiro neste mês).";
            }

            $this->dispatch('showToast', [
                'type'    => 'success',
                'message' => $mensagem,
            ]);

            if (!empty($clientesIgnorados)) {
                $this->dispatch('showToast', [
                    'type'    => 'warning',
                    'message' => 'Ignorados: ' . implode(', ', array_slice($clientesIgnorados, 0, 5)) .
                        (count($clientesIgnorados) > 5 ? '...' : ''),
                ]);
            }

            $this->dispatch('roteiro-reatribuido');
            $this->fecharModal();
        } catch (\Exception $e) {

            $this->dispatch('showToast', [
                'type'    => 'error',
                'message' => 'Erro ao reatribuir roteiro: ' . $e->getMessage(),
            ]);
        }
    }

    // ═══════════════════════════════════════════════════════════
    // GET ORDEM ORIGINAL
    // ═══════════════════════════════════════════════════════════

    protected function getOrdemOriginal(int $clienteId): int
    {
        $item = collect($this->roteiroAntigo)->firstWhere('cliente_id', $clienteId);
        return $item['ordem'] ?? 999;
    }

    // ═══════════════════════════════════════════════════════════
    // FECHAR MODAL
    // ═══════════════════════════════════════════════════════════

    public function fecharModal(): void
    {
        $this->mostrarModal = false;
        $this->mostrarConfirmacao = false;
        $this->dispatch('closeModal', 'modal-reatribuir');
        $this->resetForm();
    }

    // ═══════════════════════════════════════════════════════════
    // RESET FORM
    // ═══════════════════════════════════════════════════════════

    public function resetForm(): void
    {
        $this->reset([
            'userIdOrigem',
            'dataReferenteOrigem',
            'zonaOrigem',
            'userIdDestino',
            'dataInicio',
            'dataFim',
            'dataReferenteDestino',
            'observacoes',
            'manterOrdem',
            'roteiroAntigo',
            'roteiroInfo',
            'clientesSelecionados',
            'clientesComProblema',
            'mostrarConfirmacao',
            'passoAtual',
            'erroValidacao',
            'carregando',
        ]);

        $this->dataInicio = now()->format('Y-m-d');
        $this->dataFim = now()->addDays(10)->format('Y-m-d');
        $this->dataReferenteDestino = now()->format('Y-m-01');
        $this->manterOrdem = true;
        $this->passoAtual = 1;
    }

    // ═══════════════════════════════════════════════════════════
    // RENDER
    // ═══════════════════════════════════════════════════════════


    public function render()
    {
        return view('livewire.admin.roteiro.atribuir-roteiro');
    }
}