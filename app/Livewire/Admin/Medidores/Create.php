<?php

namespace App\Livewire\Admin\Medidores;

use App\Models\Medidores;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Component;


class Create extends Component
{


    use WithFileUploads;

    // Identificação
    public $numero_hidrometro;
    public $numero_serie;

    // Fabricante
    public $marca;
    public $modelo;

    // Especificações
    public $diametro;
    public $tipo_hidrometro;
    public $classe_metrologica;

    // Vazões
    public $qn;
    public $qmax;
    public $qmin;

    // Fabricação
    public $ano_fabricacao;
    public $data_aquisicao;

    // Compra
    public $fornecedor;
    public $nota_fiscal;

    // Status
    public $status_inicial = 'estoque';

    // Observações
    public $observacoes;

    // Uploads
    public $certificado_calibracao;
    public $laudo_inmetro;

    // Certificação
    public $numero_certificado_inmetro;
    public $validade_certificado;
    public $laboratorio_calibracao;
    public $quantidade;

    protected function rules()
    {
        return [

            'numero_hidrometro' => [
                'required',
                'string',
                'max:50',
                'unique:medidores,numero_hidrometro',
                'regex:/^[A-Za-z0-9\-]+$/'
            ],

            'numero_serie' => 'nullable|string|max:100',

            'marca' => [
                'required',
                Rule::in([
                    'Actaris / Itron',
                    'Bayard',
                    'Coprel',
                    'Elster',
                    'Hersey',
                    'Hydrometer',
                    'Poços',
                    'Sensus',
                    'Outra',
                ])
            ],

            'modelo' => 'nullable|string|max:100',

            'diametro' => [
                'required',
                Rule::in([
                    '15mm',
                    '20mm',
                    '25mm',
                    '32mm',
                    '40mm',
                    '50mm',
                    '75mm',
                    '100mm',
                ])
            ],

            'tipo_hidrometro' => [
                'required',
                Rule::in([
                    'Unijato / Velocidade',
                    'Multijato',
                    'Woltman',
                    'Ultrassônico',
                    'Eletromagnético',
                    'Smart / Inteligente',
                ])
            ],

            'classe_metrologica' => [
                'nullable',
                Rule::in([
                    'Classe A',
                    'Classe B',
                    'Classe C',
                ])
            ],

            'qn' => 'nullable|string|max:50',
            'qmax' => 'nullable|string|max:50',
            'qmin' => 'nullable|string|max:50',

            'ano_fabricacao' => [
                'nullable',
                'integer',
                'min:2000',
                'max:' . date('Y')
            ],

            'data_aquisicao' => 'required|date',

            'fornecedor' => 'nullable|string|max:255',
            'nota_fiscal' => 'nullable|string|max:100',

            'status_inicial' => [
                'required',
                Rule::in(['estoque', 'instalar'])
            ],

            'observacoes' => 'nullable|string',

            'certificado_calibracao' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240'
            ],

            'laudo_inmetro' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:10240'
            ],

            'numero_certificado_inmetro' => 'nullable|string|max:100',

            'validade_certificado' => 'nullable|date',

            'quantidade' => 'nullable',

            'laboratorio_calibracao' => 'nullable|string|max:255',
        ];
    }

    protected $messages = [

        'numero_hidrometro.required' =>
        'Número do hidrômetro obrigatório.',

        'numero_hidrometro.unique' =>
        'Este hidrômetro já foi cadastrado.',

        'marca.required' =>
        'Selecione a marca.',

        'diametro.required' =>
        'Selecione o diâmetro.',

        'tipo_hidrometro.required' =>
        'Selecione o tipo.',

        'data_aquisicao.required' =>
        'Informe a data de aquisição.',

        'certificado_calibracao.max' =>
        'Arquivo máximo 10MB.',

        'laudo_inmetro.max' =>
        'Arquivo máximo 10MB.',
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function salvar()
    {
        // dd($this->validate());
        $data = $this->validate();

        // Upload certificado
        if ($this->certificado_calibracao) {

            $data['certificado_calibracao'] =
                $this->certificado_calibracao
                ->store('medidores/certificados', 'public');
        }

        // Upload laudo
        if ($this->laudo_inmetro) {

            $data['laudo_inmetro'] =
                $this->laudo_inmetro
                ->store('medidores/laudos', 'public');
        }

        $data = Medidores::create($data);

        $this->reset();

        $this->dispatch('closeModal', 'modal-instalar-medidor');
        $this->dispatch('leitura-salva', medidorId: $data->id);
        $this->dispatch('showToast', [
            'message' => 'Medidor cadastrado com sucesso.!',
            'type' => 'success'
        ]);
    }

    public function render()
    {
        return view('Livewire.admin.Medidores.Create');
    }
}
