<?php

namespace App\Livewire\Admin\Mobile\Leiturista;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\RoteiroLeiturista;
use App\Models\Tarifa;
use App\Models\User;
use App\Services\Leituristas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Lroteiro extends Component
{
    use WithPagination;

    public int $perPage = 4;

    public $steps = 1;
    public $modalAberta = false;

    public $nome;
    public $endereco;
    public $medidor;
    public $ultimaLeitura = 0;
    public $matricula;
    public $leitura_atual;
    public $cliente_id;
    public $idLeitura;

    public $user_id = 0;

    public $mes_referencia;

    public $data_leitura;
    public $hora_leitura;
    public $consumo;
    public $consumo_medio;
    public $medidores_id;

    public $roteiroId;
    public $fatura_id;

    public $media_consumo = 0;
    public $confirmada_local = 0;


    public $origem = 'mobile';
    public $search = '';


    public $nomeleiturista;
    public $email;
    public int $telefone;
    public $zona;


    protected function rules()
    {
        return  [
            // ===== RELAÇÕES =====
            'cliente_id' => 'required|exists:clientes,id',
            'user_id' => 'required|exists:users,id',
            // ===== PERÍODO =====
            'mes_referencia' => 'required',
            // ===== LEITURA =====
            'data_leitura' => 'required|date',
            'hora_leitura' => 'required',

            'ultimaLeitura' => 'nullable|numeric|min:0',

            'leitura_atual' => [
                'required',
                'numeric',
                'gt:ultimaLeitura', // garante que é maior
            ],
            'consumo' => 'nullable|numeric|min:0',
            'media_consumo' => 'nullable',
            'medidores_id' => 'nullable',
            'confirmada_local' => 'boolean',
            'fatura_id' => 'required',
            'origem' => 'nullable',
        ];
    }

    protected $messages = [



        'leitura_atual.gt' => 'A leitura deve ser maior que a leitura anterior',

        'leitura_atual.required' => 'Informe a leitura atual',

        'data_leitura.required' => 'Informe a data da leitura',

        'hora_leitura.required' => 'Informe a hora da leitura',

        'user_id.required' => 'Selecione o leiturista',
    ];



    public function pagina()
    {
        $this->validate([
            'leitura_atual' => 'required'
        ]);
        $this->steps  = 2;
    }

    public function mount()
    {
        $this->datas();
    }


    public function datas()
    {
        $this->mes_referencia = now()->format('Y-m-d');

        $this->data_leitura = now()->format('Y-m-d');

        $this->hora_leitura = now()->format('H:i');

        $this->user_id = Auth::id();
    }

    public function CadastrarLeitura()
    {

        $this->datas();
        $validate = $this->validate();

        // app(Leituristas::class)->create($validate);

        if ($this->roteiroId) {

            $rot = RoteiroLeiturista::where('id', $this->roteiroId)->first();

            $rot->update([
                'leitura_atual' => $this->leitura_atual,
                'status' => 'Concluido',
                'lido_em' => $this->data_leitura,

                'consumo' => 'nullable|numeric|min:0',
                'media_consumo' => 'nullable',
                'confirmada_local' => 'boolean',
                'origem' => 'nullable',
            ]);
        }


        $data = app(Leituristas::class)->create($validate);

        // dd($data);

        $fatura = Faturas::where('id', $this->fatura_id)->where('cliente_id', $this->cliente_id)->first();


        $cliente = Cliente::find($this->cliente_id);


        $consumo = $cliente->categoria_consumo;


        $tarifa = Tarifa::where('categoria', 'like', '%' . $consumo . '%')->first();


        $valorPorMetroCubico = $tarifa->valor_m3;


        $valorCalculado = $valorPorMetroCubico * $data['consumo'];


        $taxaMinima = $tarifa->taxa_minima;
        $limiteTaxaMinima = $tarifa->limite_m3;

        $valorFinal =  $data['consumo'] > $limiteTaxaMinima ? $valorCalculado : $taxaMinima;

        $feito = $fatura->update([
            'leitura_id'      => $data['leitura_id'],
            'mes_referencia'  => $this->mes_referencia,
            'consumo_m3'      => $data['consumo'],
            'valor_consumo'   => $valorFinal,
            'saldo_atual'      => $valorFinal,
            'leitura_atual'   => $this->leitura_atual,
        ]);


        $this->dispatch('reload-appleitura');
        $this->dispatch('closeModal', 'closeLeituraSheet');
        $this->dispatch('showToast', [
            'message' => 'Leitura registrada com sucesso!',
            'type' => 'success'
        ]);
        $this->reset();

        $this->steps = 1;
    }


    public function abrirLeitura($roteiroId)
    {
        $this->roteiroId = $roteiroId;
        $roteiro = RoteiroLeiturista::with(['cliente.medidor', 'cliente.faturas'])->find($roteiroId);


        if ($roteiro) {
            // Monta o endereço completo
            $endereco = ($roteiro->cliente->endereco ?? 'Endereço não disponível') .
                (($roteiro->leitura->cliente->numero ?? false) ? ', ' . $roteiro->leitura->cliente->numero : '');

            // Dispara o evento para o front-end com os dados empacotados

            $this->cliente_id     = $roteiro->cliente->id;
            $this->idLeitura     = $roteiro->id;
            $this->endereco     = $roteiro->cliente->endereco;
            $this->nome       = $roteiro->cliente->nome_completo;
            $this->matricula       = $roteiro->cliente->numero_matricula;
            $this->medidores_id       = $roteiro->cliente->medidor->id ?? 'N/A';
            $this->ultimaLeitura = $roteiro->leitura_anterior ?? 0;
            $faturaId  = $roteiro->cliente->faturas->first();

            if ($faturaId) {
                // dd($faturaId);
                $this->fatura_id = $faturaId->id;
            }
        }
    }



    public function save()
    {


        $this->validate([
            'nomeleiturista' => 'required',
            'email' => 'required',
            'telefone' => 'required',
        ]);
        $users = User::find(Auth()->user()->id);

        $users->update([
            'name' => $this->nomeleiturista,
            'email' => $this->email,
            'telefone' => $this->telefone,
        ]);

        $this->dispatch('closeModal', 'closeLeituraSheet');
        $this->dispatch('showToast', [
            'message' => 'Dados actualizados com sucesso!',
            'type' => 'success'
        ]);
    }


    public $senha;
    public $novasenha;
    public $confirmarSenha;
    public function salvarSenha()
    {
        $request = $this->validate([
            'senha' => 'required',
            'novasenha' => 'required|min:6',
            'confirmarSenha' => 'required|min:6',
        ], [
            'senha.required' => 'Preencha o campo senha',
            'novasenha.required' => 'Preencha o campo Nova Senha',
            'confirmarSenha.required' => 'Preencha o campo Confirmar Senha',
        ]);


        $user = auth()->user();
        if (!Hash::check($this->senha, $user->password)) {

            $this->dispatch('showToast', [
                'message' => "Senha actual incorrecta",
                'type' => 'warning'
            ]);
            return;
        } else if ($this->novasenha != $this->confirmarSenha) {
            $this->dispatch('showToast', [
                'message' => "Nova Senha e Confirmar senha sao diferentes",
                'type' => 'warning'
            ]);
            return;
        }

        // atualizar senha
        $user->update([
            'password' => Hash::make($this->novasenha)
        ]);
        $this->dispatch('showToast', [
            'message' => "Senha actualizada com sucesso",
            'type' => 'success'
        ]);

        $this->reset([
            'senha',
            'novasenha',
            'confirmarSenha',
        ]);
        $this->dispatch('closeModal', 'modalsenha');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $id_user = $user->id;
        $this->nomeleiturista = $user->name;
        $this->email = $user->email;
        $this->zona = $user->zona;
        $this->telefone = $user->telefone ?? 0;
        // $roteiros = RoteiroLeiturista::where('user_id', $id_user)
        //     ->with(['cliente', 'medidores'])
        //     ->orderBy('ordem')
        //     ->latest()
        //     ->paginate($this->perPage);

        $roteiros = RoteiroLeiturista::query()
            ->where('user_id', $id_user)
            ->where(function ($query) {
                $query->whereMonth('data_referente', date('m'))
                    ->orWhere('status', '!=', 'Concluido');
            })
            ->with([
                'cliente.medidor',
                'cliente.medidores'
            ])

            ->when($this->search, function ($query) {

                $query->where(function ($q) {

                    // ordem
                    $q->where('ordem', 'like', '%' . $this->search . '%')

                        // cliente
                        ->orWhereHas('cliente', function ($cliente) {
                            $cliente->where('nome_completo', 'like', '%' . $this->search . '%')
                                ->orWhere('endereco', 'like', '%' . $this->search . '%');
                        })

                        // hidrômetro
                        ->orWhereHas('cliente.medidor', function ($medidor) {
                            $medidor->where('numero_hidrometro', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('ordem')
            ->paginate($this->perPage);

        $total = RoteiroLeiturista::where('user_id', $id_user)->whereMonth('data_referente', Carbon::now()->month)->count();

        $concluidos = RoteiroLeiturista::where('user_id', $id_user)
            ->where('status', 'Concluido')
            ->whereMonth('data_referente', Carbon::now()->month)
            ->count();


        $percentual = $total > 0 ? round(($concluidos / $total) * 100) : 0;

        return view('Livewire.Admin.Mobile.Leiturista.lroteiro', [
            'roteiros' => $roteiros,
            'total' => $total,
            'concluidos' => $concluidos,
            'percentual' => $percentual,
        ]);
    }
}
