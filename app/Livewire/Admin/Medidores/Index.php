<?php

namespace App\Livewire\Admin\Medidores;

use App\Models\Cliente;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{


    use WithPagination;

    // ========== FILTROS E VIEW (mantidos) ==========
    public string $search = '';
    public string $statusFilter = '';
    public string $diametroFilter = '';
    public string $marcaFilter = '';
    public string $viewMode = 'cards';
    protected string $paginationTheme = 'tailwind';

    // ========== MODAL LEITURA - CORRIGIDO ==========

    /**
     * Lista de leituristas carregada no modal
     * CORRIGIDO: nome era 'leturistas' (faltava 'i'), agora 'leituristas'
     */
    public $leituristas = null;

    /**
     * Nome do cliente para exibição no modal
     */
    public string $nome = '';

    /**
     * Número do hidrômetro para exibição no modal
     */
    public string $numero_medidor = '';

    /**
     * Última leitura registrada (valor em m³)
     * CORRIGIDO: era 'ultmaLeitura' (faltava 'i'), agora 'ultima_leitura'
     */
    public float $ultima_leitura = 0;

    /**
     * Mês/ano da última leitura para exibição
     */
    public string $data_leitura = '';

    /**
     * Nova leitura digitada pelo usuário (em m³)
     */
    public ?float $metros_cubicos = null;

    /**
     * Consumo estimado calculado (nova - anterior)
     * CORRIGIDO: era 'ConsumoEstimado' com 'C' maiúsculo, agora 'consumo_estimado'
     */
    public string $consumo_estimado = '-';

    /**
     * ID do medidor sendo editado
     */
    public ?int $medidor_id = null;

    /**
     * ID do cliente vinculado
     */
    public ?int $cliente_id = null;

    /**
     * ID do leiturista selecionado
     */
    public ?int $leiturista_id = null;

    /**
     * Data da leitura selecionada
     */
    public string $data_leitura_input = '';

    /**
     * Observações da leitura
     */
    public string $observacoes = '';

    /**
     * Confirmação de leitura no local
     */
    public bool $confirmada_local = true;

    /**
     * Mapeamento de meses para exibição
     * PERFEITO - já estava correto
     */
    public array $meses = [
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro',
    ];

    // ========== REGRAS DE VALIDAÇÃO ==========

    protected function rules(): array
    {
        return [
            'metros_cubicos' => 'required|numeric|min:0|gt:ultima_leitura',
            'data_leitura_input' => 'required|date',
            'leiturista_id' => 'required|exists:users,id',
            'observacoes' => 'nullable|string|max:500',
            'confirmada_local' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'metros_cubicos.required' => 'Informe a leitura atual.',
            'metros_cubicos.numeric' => 'A leitura deve ser um número.',
            'metros_cubicos.min' => 'A leitura não pode ser negativa.',
            'metros_cubicos.gt' => 'A nova leitura deve ser maior que a anterior (:value m³).',
            'data_leitura_input.required' => 'Informe a data da leitura.',
            'data_leitura_input.date' => 'Data inválida.',
            'leiturista_id.required' => 'Selecione o leiturista.',
            'leiturista_id.exists' => 'Leiturista inválido.',
        ];
    }

    // ========== MÉTODOS DO MODAL ==========

    /**
     * Calcula o consumo estimado quando o usuário digita
     * CORRIGIDO: nome do método e propriedades
     */
    public function calcularConsumo(): void
    {
        if ($this->metros_cubicos === null || $this->metros_cubicos === '') {
            $this->consumo_estimado = '-';
            return;
        }

        $consumo = (float) $this->metros_cubicos - $this->ultima_leitura;
        $this->consumo_estimado = $consumo >= 0
            ? number_format($consumo, 0, ',', '.')
            : '0';
    }

    /**
     * Abre o modal de leitura
     * CORRIGIDO: usa nova arquitetura direta (medidor -> cliente)
     *
     * @param int $idMedidor ID do medidor
     * @param int $idCliente ID do cliente (via medidores.cliente_id)
     */
    #[On('leitura-OpenAction')]
    public function abrirModalLeitura(int $idMedidor, int $idCliente): void
    {
        // 1. Busca o medidor com cliente direto (nova arquitetura)
        $medidor = Medidores::where('id', $idMedidor)
            ->where('cliente_id', $idCliente)
            ->with('cliente')  // Relacionamento direto BelongsTo
            ->first();

        if (!$medidor) {
            $this->dispatch('notify', type: 'error', message: 'Medidor não encontrado.');
            return;
        }

        // 2. Carrega leituristas (usuários com role 'Leiturista')
        // CORRIGIDO: nome da propriedade 'leituristas' (com 'i')
        $this->leituristas = User::role('Leiturista')->get();

        // 3. Busca última leitura DIRETAMENTE do medidor (nova arquitetura)
        // Antes: Cliente::with('ultimaLeitura') -> agora: Medidores::with('ultimaLeitura')
        $ultima = $medidor->ultimaLeitura;

        // 4. Preenche propriedades do modal
        $this->medidor_id = $idMedidor;
        $this->cliente_id = $idCliente;
        $this->ultima_leitura = $ultima?->leitura_atual ?? 0;
        $this->nome = $medidor->cliente?->nome_completo ?? '—';
        $this->numero_medidor = $medidor->numero_hidrometro;

        // 5. Formata mês/ano da última leitura
        $mesNumero = $ultima?->data_leitura?->format('m');
        $ano = $ultima?->data_leitura?->format('Y') ?? Carbon::now()->format('Y');

        $this->data_leitura = isset($this->meses[$mesNumero])
            ? $this->meses[$mesNumero] . ' / ' . $ano
            : 'Nenhuma leitura anterior';

        // 6. Reseta campos do formulário
        $this->metros_cubicos = null;
        $this->consumo_estimado = '-';
        $this->data_leitura_input = Carbon::now()->format('Y-m-d');
        $this->leiturista_id = null;
        $this->observacoes = '';
        $this->confirmada_local = true;

        // 7. Abre o modal via JavaScript
        $this->dispatch('openModal', 'modal-leitura-medidor');
    }

    /**
     * Salva a nova leitura no banco
     */
    public function salvarLeitura(): void
    {
        $this->validate();

        // Calcula consumo
        $consumo = (float) $this->metros_cubicos - $this->ultima_leitura;
        $consumo = max(0, $consumo);

        // Determina mês de referência
        $data = Carbon::parse($this->data_leitura_input);
        $mesReferencia = $data->format('Y-m');

        // Cria a leitura
        Leituras::create([
            'cliente_id' => $this->cliente_id,
            'medidores_id' => $this->medidor_id,
            'user_id' => $this->leiturista_id,
            'mes_referencia' => $mesReferencia,
            'data_leitura' => $data,
            'hora_leitura' => now()->format('H:i:s'),
            'leitura_anterior' => $this->ultima_leitura,
            'leitura_atual' => (float) $this->metros_cubicos,
            'consumo' => $consumo,
            'consumo_medio' => $this->calcularMediaConsumo(),
            'status' => 'validada',
            'tem_anomalia' => false,
            'confirmada_local' => $this->confirmada_local,
            'origem' => 'sistema',
            'observacoes' => $this->observacoes,
        ]);

        $this->dispatch('leitura-salva', medidorId: $this->medidor_id);
        $this->dispatch('closeModal', 'modal-leitura-medidor');
        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Leitura registrada com sucesso!'
        ]);

        // Limpa propriedades
        $this->reset(['metros_cubicos', 'consumo_estimado', 'observacoes', 'leiturista_id']);
    }

    /**
     * Calcula média de consumo dos últimos 3 meses
     */
    private function calcularMediaConsumo(): ?float
    {
        $media = Leituras::where('medidores_id', $this->medidor_id)
            ->whereNotNull('consumo')
            ->latest('data_leitura')
            ->limit(3)
            ->avg('consumo');

        return $media ? round($media, 2) : null;
    }



    public function render()
    {
        return view('Livewire.admin.Medidores.Index');
    }
}
