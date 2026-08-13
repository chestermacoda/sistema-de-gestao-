<?php

namespace App\Livewire\Admin\Leituras;

use App\Models\Leituras;
use App\Models\Medidores;
use App\Services\Leituristas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarLeitura extends Component
{
    // Dados da leitura sendo editada
    public ?int $leitura_id = null;
    public int $cliente_id;
    public int $medidores_id;
    public int $user_id;

    // Dados atuais (para exibição)
    public float $leitura_atual = 0;
    public float $consumo_presente = 0;
    public string $mes_referencia = '';
    public string $data_leitura = '';
    public string $hora_leitura = '';
    public float $leitura_anterior = 0;

    // Dados do formulário
    public float $nova_leitura = 0;
    public string $motivo_edicao = '';
    public string $observacoes = '';
    public bool $recalcular_fatura = false;
    public bool $confirmada_local = true;

    // ========== EXCLUSIVO DA ANOMALIA ==========
    public string $tipo_anomalia = '';        // Consumo Excessivo, Consumo Muito Baixo, etc.
    public string $acao_corretiva = '';      // Confirmar, Refazer, Aplicar Média, etc.
    public ?float $leitura_corrigida = null; // Nova leitura informada pelo técnico
    public ?float $consumo_aplicado = null;  // Consumo que será usado (média ou corrigido)
    public bool $gerar_os = false;           // Gerar ordem de serviço

    protected function rules()
    {
        // return [
        //     'cliente_id'     => 'required|exists:clientes,id',
        //     'medidores_id'   => 'required|exists:medidores,id',
        //     'user_id'        => 'required|exists:users,id',
        //     'mes_referencia' => 'required|string',
        //     'data_leitura'   => 'required|date',
        //     'hora_leitura'   => 'required',
        //     'leitura_anterior' => 'required|numeric|min:0',
        //     'nova_leitura'   => ['required', 'numeric', 'gt:leitura_anterior'],
        //     'motivo_edicao'  => 'required|string|max:255',
        //     'observacoes'    => 'nullable|string|max:1000',
        //     'recalcular_fatura' => 'boolean',
        //     'confirmada_local'  => 'boolean',
        // ];

        // $baseRules = (new EditarLeitura())->getRules(); // Ou defina manualmente abaixo

        // Se não conseguir reaproveitar, defina aqui diretamente:
        return [
            // === HERDADO DO EditarLeitura ===
            'cliente_id'       => 'required|exists:clientes,id',
            'medidores_id'     => 'required|exists:medidores,id',
            'user_id'          => 'required|exists:users,id',
            'mes_referencia'   => 'required|string',
            'data_leitura'     => 'required|date',
            'hora_leitura'     => 'required',
            'leitura_anterior' => 'required|numeric|min:0',
            'nova_leitura'     => ['required', 'numeric', 'gt:leitura_anterior'],
            'motivo_edicao'    => 'required|string|max:255',
            'observacoes'      => 'nullable|string|max:1000',
            'recalcular_fatura' => 'boolean',
            'confirmada_local' => 'boolean',


        ];
    }

    protected $messages = [
        'medidores_id.required' => 'Selecione o medidor',
        'nova_leitura.gt'       => 'A nova leitura deve ser maior que a leitura anterior (:value m³)',
        'nova_leitura.required' => 'Informe a nova leitura',
        'data_leitura.required' => 'Informe a data da leitura',
        'hora_leitura.required' => 'Informe a hora da leitura',
        'user_id.required'      => 'Selecione o leiturista',
        'motivo_edicao.required' => 'Informe o motivo da edição',
    ];

    /**
     * Recebe evento para abrir modal de edição
     */
    #[On('editar-leitura')]
    public function carregarLeitura(int $idCliente, int $idMedidor, int $idLeitura): void
    {
        $leitura = app(Leituristas::class)->buscarLeitura($idMedidor, $idLeitura);

        if (!$leitura) {
            $this->dispatch('notify', type: 'error', message: 'Leitura não encontrada.');
            return;
        }

        // Preenche propriedades com dados atuais
        $this->leitura_id       = $leitura->id;
        $this->cliente_id       = $idCliente;
        $this->medidores_id     = $idMedidor;
        $this->user_id          = $leitura->user_id;
        $this->leitura_atual    = (float) $leitura->leitura_atual;
        $this->consumo_presente = (float) $leitura->consumo;
        $this->mes_referencia   = $leitura->mes_referencia ?? '';
        $this->data_leitura     = $leitura->data_leitura?->format('Y-m-d') ?? now()->format('Y-m-d');
        $this->hora_leitura     = $leitura->hora_leitura ?? now()->format('H:i');
        $this->leitura_anterior = (float) $leitura->leitura_anterior;
        $this->observacoes      = $leitura->observacoes ?? '';

        // Campos editáveis iniciam vazios
        $this->nova_leitura     = (float) $leitura->leitura_atual;
        $this->motivo_edicao    = '';
        $this->recalcular_fatura = false;

        $this->dispatch('openModal', 'modal-editar-leitura');
    }

    /**
     * Recalcula consumo em tempo real (live)
     */
    public function updatedNovaLeitura(): void
    {
        $this->validateOnly('nova_leitura');

        // Recalcula consumo para preview
        $this->consumo_presente = max(0, (float)$this->nova_leitura - (float)$this->leitura_anterior);
    }

    /**
     * Salva a edição da leitura
     */
    public function update(): void
    {

        $validated = $this->validate();

        // Prepara dados para o service
        $dadosAtualizacao = [
            'id'               => $this->leitura_id,
            'cliente_id'       => $validated['cliente_id'],
            'medidores_id'     => $validated['medidores_id'],
            'user_id'          => $validated['user_id'],
            'mes_referencia'   => $validated['mes_referencia'],
            'data_leitura'     => $validated['data_leitura'],
            'hora_leitura'     => $validated['hora_leitura'],
            'leitura_anterior' => $validated['leitura_anterior'],
            'leitura_atual'    => $validated['nova_leitura'],
            'consumo'          => max(0, $validated['nova_leitura'] - $validated['leitura_anterior']),
            'motivo_edicao'    => $validated['motivo_edicao'],
            'observacoes'      => $validated['observacoes'],
            'editado_por'      => Auth::id(),
            'editada'          => true,
            'editado_em'       => now(),
            'status'           => 'Editada',
            'recalcular_fatura' => $validated['recalcular_fatura'],
        ];

        // Chama o service para atualizar
        app(Leituristas::class)->updateLeitura($dadosAtualizacao);

        // Feedback e reset
        $this->dispatch(
            'notify',
            type: 'success',
            message: 'Leitura editada com sucesso! Consumo recalculado: ' . $dadosAtualizacao['consumo'] . ' m³'
        );

        $this->reset();
        $this->dispatch('reload-leituras');
        $this->dispatch('reload-card');
        $this->dispatch('closeModal', 'modal-editar-leitura');
    }


    /**
     * Carrega leitura com anomalia para tratamento
     */
    // #[On('tratar-anomalia')]
    // public function carregarAnomalia(int $idCliente, int $idMedidor, int $idLeitura): void
    // {
    //     $leitura = app(Leituristas::class)->buscarLeitura($idMedidor, $idLeitura);

    //     if (!$leitura || !$leitura->tem_anomalia) {
    //         $this->dispatch('showToast', type: 'error', message: 'Leitura sem anomalia ou não encontrada.');
    //         return;
    //     }

    //     // Preenche dados base (mesmo fluxo do EditarLeitura)
    //     $this->leitura_id       = $leitura->id;
    //     $this->cliente_id       = $idCliente;
    //     $this->medidores_id     = $idMedidor;
    //     $this->user_id          = $leitura->user_id;
    //     $this->leitura_atual    = (float) $leitura->leitura_atual;
    //     $this->consumo_presente = (float) $leitura->consumo;
    //     $this->mes_referencia   = $leitura->mes_referencia ?? '';
    //     $this->data_leitura     = $leitura->data_leitura?->format('Y-m-d') ?? now()->format('Y-m-d');
    //     $this->hora_leitura     = $leitura->hora_leitura ?? now()->format('H:i');
    //     $this->leitura_anterior = (float) $leitura->leitura_anterior;
    //     $this->observacoes      = $leitura->observacoes ?? '';

    //     // Campos editáveis
    //     $this->nova_leitura     = (float) $leitura->leitura_atual;
    //     $this->motivo_edicao    = '';

    //     // Campos da anomalia (preenche com o que já foi detectado)
    //     $this->tipo_anomalia    = $leitura->tipo_anomalia ?? '';
    //     $this->acao_corretiva   = '';
    //     $this->leitura_corrigida = null;
    //     $this->consumo_aplicado = null;
    //     $this->gerar_os         = false;

    //     // dd($this->medidores_id);
    //     $this->dispatch('openModal', 'modal-anomalia');
    // }


    /**
     * Recalcula preview quando muda a leitura corrigida
     */
    public function updatedLeituraCorrigida(): void
    {
        if ($this->leitura_corrigida && $this->leitura_corrigida > $this->leitura_anterior) {
            $this->consumo_aplicado = max(0, $this->leitura_corrigida - $this->leitura_anterior);
        }
    }

    /**
     * Aplica média de consumo como consumo_aplicado
     */
    public function aplicarMedia(): void
    {
        $media = app(Leituristas::class)->ConsumoMedio($this->medidores_id);
        $this->consumo_aplicado = $media;
        $this->acao_corretiva = 'Aplicar Média de Consumo';

        // Recalcula leitura_corrigida baseado na média
        $this->leitura_corrigida = $this->leitura_anterior + $media;
    }

    /**
     * Salva o tratamento da anomalia
     */
    public function resolverAnomalia(): void
    {
        $validated = $this->validate([
            // === HERDADO DO EditarLeitura ===
            'cliente_id'       => 'required|exists:clientes,id',
            'medidores_id'     => 'required|exists:medidores,id',
            'user_id'          => 'required|exists:users,id',
            'mes_referencia'   => 'required|string',
            'data_leitura'     => 'required|date',
            'hora_leitura'     => 'required',
            'leitura_anterior' => 'required|numeric|min:0',
            'nova_leitura'     => ['required', 'numeric', 'gt:leitura_anterior'],
            'motivo_edicao'    => 'required|string|max:255',
            'observacoes'      => 'nullable|string|max:1000',
            'recalcular_fatura' => 'boolean',
            'confirmada_local' => 'boolean',

            // === EXCLUSIVO DA ANOMALIA ===
            'tipo_anomalia'    => 'required|string|in:Consumo Excessivo,Consumo Muito Baixo,Leitura Estagnada,Medidor Invertido,Vazamento Identificado,Medidor com Defeito,Outro',
            'acao_corretiva'   => 'required|string|in:Confirmar Leitura,Refazer Leitura,Aplicar Média de Consumo,Substituir Medidor,Registrar Vazamento,Enviar para Verificação Técnica',
            'leitura_corrigida' => 'nullable|numeric|gt:leitura_anterior',
            'consumo_aplicado' => 'nullable|numeric|min:0',
            'gerar_os'         => 'boolean',
        ]);

        // Prepara dados para atualização
        $dados = [
            'id'               => $this->leitura_id,
            'cliente_id'       => $validated['cliente_id'],
            'medidores_id'     => $validated['medidores_id'],
            'user_id'          => $validated['user_id'],
            'mes_referencia'   => $validated['mes_referencia'],
            'data_leitura'     => $validated['data_leitura'],
            'hora_leitura'     => $validated['hora_leitura'],
            'leitura_anterior' => $validated['leitura_anterior'],

            // Se informou leitura corrigida, usa ela. Senão, mantém a original
            'leitura_atual'    => $validated['leitura_corrigida'] ?? $validated['nova_leitura'],

            // Se informou consumo aplicado, usa ele. Senão, recalcula
            'consumo'          => $validated['consumo_aplicado'] ?? max(0, ($validated['leitura_corrigida'] ?? $validated['nova_leitura']) - $validated['leitura_anterior']),

            'motivo_edicao'    => $validated['motivo_edicao'],
            'observacoes'      => $validated['observacoes'],
            'editado_por'      => Auth::id(),
            'editada'          => true,
            'editado_em'       => now(),

            // Resolve a anomalia
            'status'           => $this->resolveStatus($validated['acao_corretiva']),
            'tem_anomalia'     => false,  // Resolvida!
            'tipo_anomalia'    => $validated['tipo_anomalia'],
            'acao_corretiva'   => $validated['acao_corretiva'],
        ];

        // Atualiza via Service
        app(Leituristas::class)->updateLeitura($dados);

        // Se solicitou OS, dispara evento
        if ($validated['gerar_os']) {
            $this->dispatch('gerar-ordem-servico', [
                'leitura_id' => $this->leitura_id,
                'tipo'       => $validated['tipo_anomalia'],
                'acao'       => $validated['acao_corretiva'],
            ]);
        }

        $this->dispatch('showToast', type: 'success', message: 'Anomalia tratada com sucesso!');
        $this->reset();
        $this->dispatch('reload-leituras');
        $this->dispatch('closeModal', 'modal-anomalia');
    }

    /**
     * Envia para técnico sem resolver (mantém anomalia)
     */
    public function enviarParaTecnico(): void
    {
        $this->validateOnly('tipo_anomalia');

        // Apenas atualiza observações e mantém status de anomalia
        Leituras::where('id', $this->leitura_id)->update([
            'observacoes'    => $this->observacoes . "
[ENVIADO PARA TÉCNICO em " . now()->format('d/m/Y H:i') . "]",
            'acao_corretiva' => 'Enviar para Verificação Técnica',
        ]);

        $this->dispatch('showToast', type: 'warning', message: 'Leitura enviada para revisão técnica.');
        $this->dispatch('closeModal', 'modal-anomalia');
    }

    /**
     * Define status final baseado na ação corretiva
     */
    private function resolveStatus(string $acao): string
    {
        return match ($acao) {
            'Confirmar Leitura'           => 'Normal',
            'Refazer Leitura'             => 'Revisar',
            'Aplicar Média de Consumo'    => 'Normal',
            'Substituir Medidor'          => 'Revisar',
            'Registrar Vazamento'         => 'Anomalia', // Mantém anomalia para acompanhamento
            default                     => 'Normal',
        };
    }



    public function render()
    {
        return view('livewire.admin.leituras.editar-leitura');
    }
}
