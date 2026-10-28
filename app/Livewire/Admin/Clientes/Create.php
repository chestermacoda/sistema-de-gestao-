<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Cliente;
use App\Models\ClienteMedidor;
use App\Models\zona_distribuicao;
use App\Models\Medidores;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    /**
     * =========================
     * CLIENTE
     * =========================
     */

    public $tipo_pessoa = 'fisica';

    public $nome_completo;

    public $bi;

    public $nuit;

    public $email;

    public $telefone;

    public $data_nascimento;

    public $responsavel_legal;

    /**
     * =========================
     * ENDEREÇO
     * =========================
     */

    public $cidade;

    public $endereco;

    public $numero_casa;

    public $bairro;

    public $zona_distribuicao;

    public $ponto_referencia;

    public $latitude =1;

    public $longitude = 1;

    /**
     * =========================
     * LIGAÇÃO
     * =========================
     */

    public $numero_matricula;

    public $categoria_consumo;

    public $tipo_ligacao;

    public $diametro_ramal = '';

    public $data_solicitacao;

    public $data_prevista_ligacao;

    public $tipo_imovel;

    public $numero_economias = 1;

    public $observacoes;

    /**
     * =========================
     * MEDIDOR
     * =========================
     */

    public $marca;

    public $numero_hidrometro;

    public $medidor_id;

    public $modelo;

    public $diametro;

    public $tipo_hidrometro = 'Eletromagnético';

    public $classe_metrologica;

    public $numero_serie;

    /**
     * Instalação
     */

    public $leitura_inicial = 0;

    public $data_instalacao;

    public $local_instalacao = 'Interior do Imóvel';

    public $condicao_hidrometro = 'Novo';

    public $numero_lacre = '';

    public $vistoria_realizada = true;

    /**
     * =========================
     * AUTO BUSCA HIDRÔMETRO
     * =========================
     */

    public function buscarMedidor()
    {
        //

        // if (!$this->marca || !$this->numero_hidrometro) {
        //     return;
        // }
        // dd($this->marca);
        $medidor = Medidores::query()
            ->when($this->marca, function ($query) {
                $query->where('marca', $this->marca);
            })
            ->when($this->numero_hidrometro, function ($query) {
                // Se já houver a marca, ele tenta número como alternativa ou complemento
                $query->orWhere('numero_hidrometro', $this->numero_hidrometro);
            })
            ->where('status_inicial', 'estoque')
            ->first();


        if (!$medidor) {

            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Hidrômetro não encontrado no estoque.'
            ]);

            return;
        }

        $this->numero_hidrometro =  $this->numero_hidrometro == '' ? $medidor->numero_hidrometro : $this->numero_hidrometro;


        $this->medidor_id = $medidor->id;

        $this->modelo = $medidor->modelo;

        $this->diametro = $medidor->diametro;

        $this->tipo_hidrometro = $medidor->tipo_hidrometro;

        $this->classe_metrologica = $medidor->classe_metrologica;

        $this->numero_serie = $medidor->numero_serie;

        // dd($this->numero_hidrometro);
        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Hidrômetro encontrado.'
        ]);
    }


    /*

        activity()
   ->performedOn($cliente)
   ->causedBy(auth()->user())
   ->withProperties(['old_status' => 'pendente', 'new_status' => 'ativo'])
   ->log('Matrícula gerada automaticamente para o cliente');

    */

    public function gerarMatricula()
    {
        $ultimaMatricula = Cliente::max('numero_matricula');


        // dd($ultimaMatricula);
        $novoNumero = 0;
        if ($ultimaMatricula) {
            // Extrai a parte numérica (os últimos 6 caracteres)
            $ultimoNumero = (int) substr($ultimaMatricula, -6);
            $novoNumero = $ultimoNumero + 1;
        } else {
            $novoNumero = 1;
        }

        return 'MAT-' . date('Y') . '-' . str_pad($novoNumero, 6, '0', STR_PAD_LEFT);
    }

    public function mount()
    {
        // $this->gerarMatricula();

        // $this->numero_matricula = $this->gerarMatricula();
    }
    /**
     * =========================
     * SALVAR
     * =========================
     */

    public function salvar()
    {
        // dd([

        //     'tipo_pessoa' => $this->tipo_pessoa,

        //     'nome_completo' => $this->nome_completo,

        //     'bi' => $this->bi,

        //     'nuit' => $this->nuit,

        //     'email' => $this->email,

        //     'telefone' => $this->telefone,

        //     'data_nascimento' => $this->data_nascimento,

        //     'responsavel_legal' => $this->responsavel_legal,

        //     'cidade' => $this->cidade,

        //     'endereco' => $this->endereco,

        //     'numero_casa' => $this->numero_casa,

        //     'bairro' => $this->bairro,

        //     'zona_distribuicao' => $this->zona_distribuicao,

        //     'ponto_referencia' => $this->ponto_referencia,

        //     'latitude' => $this->latitude,

        //     'longitude' => $this->longitude,

        //     'numero_matricula' => $this->numero_matricula,

        //     'categoria_consumo' => $this->categoria_consumo,

        //     'tipo_ligacao' => $this->tipo_ligacao,

        //     'diametro_ramal' => $this->diametro_ramal,

        //     'data_solicitacao' => $this->data_solicitacao,

        //     'data_prevista_ligacao' => $this->data_prevista_ligacao,

        //     'tipo_imovel' => $this->tipo_imovel,

        //     'numero_economias' => $this->numero_economias,

        //     'observacoes' => $this->observacoes,
        // ]);
        $this->validate([

            'nome_completo' => 'required',

            'telefone' => 'required',

            'bairro' => 'required',

            'cidade' => 'required',

            'numero_matricula' => 'required|unique:clientes',

            'medidor_id' => 'required',
        ]);

        // DB::beginTransaction();

        try {

            /**
             * Cliente
             */

            $cliente = Cliente::create([

                'tipo_pessoa' => $this->tipo_pessoa,

                'nome_completo' => $this->nome_completo,

                'bi' => $this->bi,

                'nuit' => $this->nuit,

                'email' => $this->email,

                'telefone' => $this->telefone,

                'data_nascimento' => $this->data_nascimento,

                'responsavel_legal' => $this->responsavel_legal,

                'cidade' => $this->cidade,

                'endereco' => $this->endereco,

                'numero_casa' => $this->numero_casa,

                'bairro' => $this->bairro,

                'zona_distribuicao' => $this->zona_distribuicao,

                'ponto_referencia' => $this->ponto_referencia,

                'latitude' => $this->latitude,

                'longitude' => $this->longitude,

                'numero_matricula' => $this->numero_matricula,

                'categoria_consumo' => $this->categoria_consumo,

                'tipo_ligacao' => $this->tipo_ligacao,

                'diametro_ramal' => $this->diametro_ramal,

                'data_solicitacao' => $this->data_solicitacao,

                'data_prevista_ligacao' => $this->data_prevista_ligacao,

                'tipo_imovel' => $this->tipo_imovel,

                'numero_economias' => $this->numero_economias,

                'observacoes' => $this->observacoes,

                'status' => 'Ativo',
                'password' => Hash::make('123456')
            ]);

            /**
             * Atualiza estoque
             */
            $medidor = Medidores::find($this->medidor_id);
            /**
             * Atualiza medidor
             */
            // dd($medidor);
            $medidor->update([
                'cliente_id' => $cliente->id,
                'status_inicial' => 'instalado',
            ]);
            /**
             * Instalação do medidor
             */
            ClienteMedidor::create([

                'cliente_id' => $cliente->id,

                'medidor_id' => $this->medidor_id,

                'leitura_inicial' => $this->leitura_inicial,

                'data_instalacao' => $this->data_instalacao,

                'local_instalacao' => $this->local_instalacao,

                'condicao_hidrometro' => $this->condicao_hidrometro,

                'numero_lacre' => $this->numero_lacre,

                'vistoria_realizada' => $this->vistoria_realizada,
            ]);


            // DB::commit();

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Cliente cadastrado com sucesso.'
            ]);

            $this->dispatch('closeModal', 'modal-novo-cliente');

            $this->reset();
        } catch (\Exception $e) {

            // DB::rollBack();

            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function editar($id) {}
    public function render()
    {

        $this->numero_matricula = $this->gerarMatricula();
        $marcas = Medidores::select('marca')->where('status_inicial', 'estoque')
            ->distinct()
            ->pluck('marca');
        return view('Livewire.Admin.Clientes.Create', [
            'marcas' => $marcas,
               'zona'=>zona_distribuicao::all(),
        ]);
    }
}
