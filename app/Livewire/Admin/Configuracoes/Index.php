<?php

namespace App\Livewire\Admin\Configuracoes;

use App\Models\Company;
use App\Models\ConfiguracaoFinanceira;
use App\Models\NotificacaoConfiguracao;
use App\Models\Tarifa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | EMPRESA
    |--------------------------------------------------------------------------
    */

    public $razao_social;
    public $nome_fantasia;
    public $cnpj;
    public $inscricao_estadual;
    public $email;
    public $telefone;
    public $endereco_completo;
    public $logo;
    public $logo_atual;
    /*
    |--------------------------------------------------------------------------
    | TARIFAS
    |--------------------------------------------------------------------------
    */

    public $tarifas = [];
    public $tarifa;

    public $categoria, $valor_m3, $tarifa_min;
    //         'taxa_minima' => $tarifa['taxa_minima'],
    /*
    |--------------------------------------------------------------------------
    | CONFIG FINANCEIRA
    |--------------------------------------------------------------------------
    */

    public $multa_atraso;
    public $juros_mes;
    public $dias_tolerancia;
    public $dias_geracao;

    /*
    |--------------------------------------------------------------------------
    | NOTIFICAÇÕES
    |--------------------------------------------------------------------------
    */

    public $email_vencimento = true;
    public $dias_antes_vencimento;

    public $sms_atraso = true;
    public $dias_atraso_sms;

    public $consumo_anomalo = true;
    public $percentual_consumo_anomalo;

    public $novo_cadastro = false;

    public $relatorio_semanal = false;

    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */

    public function mount()
    {
        // $this->tarifas = [
        //     [
        //         'categoria' => 'Residencial',
        //         'valor_m3' => 3.50,
        //         'taxa_minima' => 25.00,
        //     ],
        //     [
        //         'categoria' => 'Comercial',
        //         'valor_m3' => 5.20,
        //         'taxa_minima' => 45.00,
        //     ],
        //     [
        //         'categoria' => 'Industrial',
        //         'valor_m3' => 7.80,
        //         'taxa_minima' => 120.00,
        //     ],
        //     [
        //         'categoria' => 'Pública',
        //         'valor_m3' => 2.10,
        //         'taxa_minima' => 15.00,
        //     ],
        // ];

        $company = Company::first();

        if ($company) {
            $this->logo_atual = $company->logo;
        }
        // $this->logo = $empresa->logo;
    }

    /*
    |--------------------------------------------------------------------------
    | RULES
    |--------------------------------------------------------------------------
    */

    protected function rules()
    {
        return [

            // Empresa
            'razao_social' => 'required',
            'nome_fantasia' => 'required',
            'cnpj' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'endereco_completo' => 'required',

            // Tarifas
            'tarifas.*.categoria' => 'required',
            'tarifas.*.valor_m3' => 'required|numeric',
            'tarifas.*.taxa_minima' => 'required|numeric',

            // Financeiro
            'multa_atraso' => 'required|numeric',
            'juros_mes' => 'required|numeric',
            'dias_tolerancia' => 'required|integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE
    |--------------------------------------------------------------------------
    */

    public function salvar()
    {
        $this->validate();
        DB::transaction(function () {

            Company::updateOrCreate(
                ['id' => 1],
                [
                    'razao_social' => $this->razao_social,
                    'nome_fantasia' => $this->nome_fantasia,
                    'cnpj' => $this->cnpj,
                    'inscricao_estadual' => $this->inscricao_estadual,
                    'email' => $this->email,
                    'telefone' => $this->telefone,
                    'endereco_completo' => $this->endereco_completo,
                ]
            );
            ConfiguracaoFinanceira::updateOrCreate(
                ['id' => 1],
                [
                    'multa_atraso' => $this->multa_atraso,
                    'juros_mes' => $this->juros_mes,
                    'dias_tolerancia' => $this->dias_tolerancia,
                    'dias_geracao' => $this->dias_geracao,
                ]
            );

            NotificacaoConfiguracao::updateOrCreate(
                ['id' => 1],
                [
                    'email_vencimento' => $this->email_vencimento,
                    'dias_antes_vencimento' => $this->dias_antes_vencimento,
                    'sms_atraso' => $this->sms_atraso,
                    'dias_atraso_sms' => $this->dias_atraso_sms,
                    'consumo_anomalo' => $this->consumo_anomalo,
                    'percentual_consumo_anomalo' => $this->percentual_consumo_anomalo,
                    'novo_cadastro' => $this->novo_cadastro,
                    'relatorio_semanal' => $this->relatorio_semanal,
                ]
            );
        });
        // session()->flash('success', 'Configurações salvas com sucesso!');

        // dd();
        $this->dispatch('showToast', [
            'message' => 'Configurações salvas com sucesso!',
            'type' => 'success'
        ]);
        // dd();
    }


    public $idTarifa;
    public function editTarifas($id)
    {
        $data = Tarifa::where('id', $id)->first();
        $this->idTarifa = $id;
        $this->categoria = $data->categoria;
        $this->valor_m3 = $data->valor_m3;
        $this->tarifa_min = $data->taxa_minima;

        $this->dispatch('openModal', 'modal-tarifa');
    }

    public function saveupdate()
    {
        $this->validate([
            'categoria' => 'required',
            'valor_m3' => 'required',
            'tarifa_min' => 'required',
        ]);
        Tarifa::updateOrCreate([
            'id' => $this->idTarifa
        ], [
            'categoria' => $this->categoria,
            'valor_m3' => $this->valor_m3,
            'taxa_minima' => $this->tarifa_min,
        ]);
        $this->dispatch('showToast', [
            'message' => 'Tarifa actualizada com sucesso!',
            'type' => 'success'
        ]);
        $this->dispatch('closeModal', 'modal-tarifa');
    }

    public function editarLogo()
    {
        $this->dispatch('openModal', 'modal-logo');
    }

    public function saveLogo()
    {
        $this->validate([
            'logo' => 'required|image|max:2048',
        ]);

        $path = $this->logo->store('logos', 'public');

        Company::updateOrCreate(
            ['id' => 1],
            ['logo' => $path]
        );

        $this->logo_atual = $path;

        $this->dispatch('showToast', [
            'message' => 'Configurações salvas com sucesso!',
            'type' => 'success'
        ]);

        session()->flash('success', 'Logo atualizado com sucesso!');
    }
    public function render()
    {

        $id = 1;
        $empresa = Company::where('id', $id)->first();
        $this->razao_social = $empresa->razao_social;
        $this->nome_fantasia = $empresa->nome_fantasia;
        $this->cnpj = $empresa->cnpj;
        $this->inscricao_estadual = $empresa->inscricao_estadual;
        $this->email = $empresa->email;
        $this->telefone = $empresa->telefone;
        $this->endereco_completo = $empresa->endereco_completo;


        $notificacoes = NotificacaoConfiguracao::where('id', $id)->first();
        $this->email_vencimento = $notificacoes->email_vencimento == 1 ? true : false;
        $this->dias_antes_vencimento = $notificacoes->dias_antes_vencimento;
        $this->sms_atraso = $notificacoes->sms_atraso == 1 ? true : false;
        $this->dias_atraso_sms =  $notificacoes->dias_atraso_sms;

        $this->consumo_anomalo = $notificacoes->consumo_anomalo == 1 ? true : false;
        $this->percentual_consumo_anomalo = $notificacoes->percentual_consumo_anomalo;
        $this->novo_cadastro = $notificacoes->novo_cadastro == 1 ? true : false;
        $this->relatorio_semanal = $notificacoes->relatorio_semanal == 1 ? true : false;


        $config = ConfiguracaoFinanceira::where('id', $id)->first();
        $this->multa_atraso = $config->multa_atraso;
        $this->juros_mes = $config->juros_mes;
        $this->dias_tolerancia = $config->dias_tolerancia;
        $this->dias_geracao = $config->dias_geracao;

        return view('Livewire.admin.Configuracoes.Index', [
            'tarifass' => Tarifa::all()
        ]);
    }
}