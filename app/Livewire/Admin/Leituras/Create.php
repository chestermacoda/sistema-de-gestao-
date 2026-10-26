<?php

namespace App\Livewire\Admin\Leituras;

use Livewire\Component;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\User;
use App\Services\Leituristas;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{

    public $medidores = [];
    public $leituristas = [];

    // FORM
    public $medidores_id;
    public $cliente_id;
    public $user_id;

    public $mes_referencia;

    public $data_leitura;
    public $hora_leitura;

    public $leitura_anterior = 0;
    public $leitura_atual;
    public $media_consumo = 0;
    public $consumo = 0;

    public $observacoes;

    public $confirmada_local = true;

    // INFO AUXILIAR
    public $ultima_leitura_data;
    public $origem = 'sistema';

    protected function rules()
    {
        return  [
            // ===== RELAÇÕES =====
            'cliente_id' => 'required|exists:clientes,id',
            'medidores_id' => 'required|exists:medidores,id',
            'user_id' => 'required|exists:users,id',
            // ===== PERÍODO =====
            'mes_referencia' => 'required|date',
            // ===== LEITURA =====
            'data_leitura' => 'required|date',
            'hora_leitura' => 'required',

            'leitura_anterior' => 'required|numeric|min:0',

            'leitura_atual' => [
                'required',
                'numeric',
                'gt:leitura_anterior', // garante que é maior
            ],
            'consumo' => 'nullable|numeric|min:0',
            'media_consumo' => 'nullable',
            'confirmada_local' => 'boolean',
            'origem' => 'nullable',
        ];
    }

    protected $messages = [

        'medidores_id.required' => 'Selecione o medidor',

        'leitura_atual.gt' => 'A leitura deve ser maior que a leitura anterior',

        'leitura_atual.required' => 'Informe a leitura atual',

        'data_leitura.required' => 'Informe a data da leitura',

        'hora_leitura.required' => 'Informe a hora da leitura',

        'user_id.required' => 'Selecione o leiturista',
    ];

    public function mount()
    {
        $this->mes_referencia = now()->format('Y-m-d');

        $this->data_leitura = now()->format('Y-m-d');

        $this->hora_leitura = now()->format('H:i');

        $this->user_id = Auth::id();

        $this->medidores = Medidores::with('cliente')
            ->where('status_inicial', 'instalado')
            ->get();
        $this->leituristas = User::role('Leiturista')->get();
    }

    /**
     * VALIDAÇÃO LIVE
     */
    public function updated($property)
    {
        $this->validateOnly($property);

        // Atualiza consumo automaticamente
        if ($property === 'leitura_atual') {

            $this->consumo =
                max(0, (float)$this->leitura_atual - (float)$this->leitura_anterior);
        }
    }

    /**
     * Quando seleciona medidor
     */
    public function updatedMedidoresId($value)
    {
        $medidor = Medidores::with([
            'cliente',
            'ultimaLeitura'
        ])->find($value);

        if (!$medidor) {
            return;
        }

        // Busca a média das últimas 6 leituras
        $this->media_consumo = Leituras::where('medidores_id', $value)
            ->whereNotNull('consumo')
            ->latest('data_leitura')
            ->limit(6)
            ->avg('consumo') ?? 0;

        $this->cliente_id = $medidor->cliente_id;

        // Última leitura
        if ($medidor->ultimaLeitura) {

            $this->leitura_anterior =
                $medidor->ultimaLeitura->leitura_atual;

            $this->ultima_leitura_data =
                $medidor->ultimaLeitura->data_leitura
                ->format('d/m/Y');
        } else {

            $this->leitura_anterior = 0;

            $this->ultima_leitura_data = 'Sem leitura';
        }

        $this->consumo = 0;

        $this->leitura_atual = null;
    }

    /**
     * SALVAR
     */
    public function salvar()
    {
        $validate = $this->validate();


        app(Leituristas::class)->create($validate);

        $this->dispatch('showToast', [
            'message' => 'Leitura registrada com sucesso!',
            'type' => 'success'
        ]);

        $this->reset([
            'medidores_id',
            'cliente_id',
            'leitura_atual',
            'observacoes',
            'consumo',
        ]);

        $this->dispatch('reload-leituras');
        $this->dispatch('reload-Card');
        $this->dispatch('closeModal', 'modal-nova-leitura');
    }



    public function render()
    {
        return view('Livewire.admin.Leituras.Create');
    }
}