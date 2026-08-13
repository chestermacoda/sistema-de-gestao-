<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Cliente;
use App\Models\Faturas;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarCliente extends Component
{
    // ═══════════════════════════════════════════════════════════════════════════════
    // PROPRIEDADES DO CLIENTE
    // ═══════════════════════════════════════════════════════════════════════════════
    public $clienteId;
    public $cliente;
    public $medidorAtual;
    public $ultimaLeitura;
    public $ultimaFatura;
    public $faturasEmAberto;
    public $totalEmAberto = 0;

    // Dados Cadastrais
    public $tipo_pessoa = 'fisica';
    public $nome_completo = '';
    public $bi = '';
    public $nuit = '';
    public $email = '';
    public $telefone = '';
    public $data_nascimento = '';
    public $responsavel_legal = '';

    // Endereço
    public $cidade = '';
    public $endereco = '';
    public $numero_casa = '';
    public $bairro = '';
    public $zona_distribuicao = '';
    public $ponto_referencia = '';
    public $latitude = '';
    public $longitude = '';

    // Ligação
    public $numero_matricula = '';
    public $categoria_consumo = 'Residencial Normal';
    public $tipo_ligacao = 'Ativa';
    public $diametro_ramal = '15mm (1/2")';
    public $tipo_imovel = '';
    public $numero_economias = 1;
    public $observacoes = '';
    public $status = 'Ativo';

    // Hidrômetro Atual
    public $medidor_id = null;
    public $numero_hidrometro = '';
    public $marca = 'Bayard';
    public $modelo = '';
    public $diametro = '15mm';
    public $tipo_hidrometro = 'Unijato / Velocidade';
    public $numero_lacre = '';
    public $leitura_atual = 0;
    public $data_ultima_leitura = '';

    // Faturamento
    public $dia_vencimento = 10;
    public $forma_pagamento = 'Boleto Bancário';
    public $tarifa_aplicada = 'Tarifa Residencial Normal';
    public $desconto_especial = 0;
    public $isento = false;

    // Resumo Financeiro (readonly)
    public $valor_ultima_fatura = 0;
    public $status_ultima_fatura = '';
    public $valor_fatura_atual = 0;
    public $vencimento_fatura_atual = '';

    // UI
    public $abaAtiva = 'tab-edit-dados';
    public $modalAberto = false;

    // Listas para selects
    public $categoriasConsumo = [];
    public $diametrosRamal = [];
    public $statusLigacao = [];
    public $marcasHidrometro = [];
    public $diametrosHidrometro = [];
    public $tiposHidrometro = [];
    public $formasPagamento = [];
    public $tarifas = [];
    public $zonasDistribuicao = [];

    protected $listeners = ['carregarClienteEdicao'];

    // ═══════════════════════════════════════════════════════════════════════════════
    // MOUNT - Inicialização
    // ═══════════════════════════════════════════════════════════════════════════════
    public function mount()
    {
        $this->inicializarListas();
    }

    public function inicializarListas()
    {
        $this->categoriasConsumo = [
            'Residencial Social',
            'Residencial Normal',
            'Residencial de Alto Padrão',
            'Comercial',
            'Industrial',
            'Público / Institucional',
            'Rural / Agropecuária',
        ];

        $this->diametrosRamal = [
            '15mm (1/2")',
            '20mm (3/4")',
            '25mm (1")',
            '32mm (1 1/4")',
            '40mm (1 1/2")',
            '50mm (2")',
        ];

        $this->statusLigacao = [
            'Ativa',
            'Cortada',
            'Suspensa',
            'Em Processo de Corte',
        ];

        $this->marcasHidrometro = [
            'Actaris / Itron',
            'Bayard',
            'Coprel',
            'Elster',
        ];

        $this->diametrosHidrometro = [
            '15mm',
            '20mm',
            '25mm',
        ];

        $this->tiposHidrometro = [
            'Unijato / Velocidade',
            'Multijato',
            'Ultrassônico',
            'Smart / Inteligente',
        ];

        $this->formasPagamento = [
            'Boleto Bancário',
            'Débito Automático',
            'Cartão de Crédito',
            'PIX',
            'Dinheiro (Caixa)',
        ];

        $this->tarifas = [
            'Tarifa Residencial Normal',
            'Tarifa Residencial Social',
            'Tarifa Comercial',
            'Tarifa Industrial',
            'Tarifa Pública',
        ];

        $this->zonasDistribuicao = [
            'Zona Norte',
            'Zona Sul',
            'Zona Leste',
            'Zona Oeste',
            'Centro',
        ];
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // CARREGAR CLIENTE PARA EDIÇÃO
    // ═══════════════════════════════════════════════════════════════════════════════




    #[On('cliente-editar')]
    public function carregarCliente($clienteId)
    {
        // dd($clienteId);
        $this->clienteId = $clienteId;
        $this->cliente = Cliente::with(['medidor', 'ultimaLeitura', 'faturas'])->findOrFail($clienteId);

        // Carregar dados cadastrais
        $this->tipo_pessoa = $this->cliente->tipo_pessoa ?? 'fisica';
        $this->nome_completo = $this->cliente->nome_completo ?? '';
        $this->bi = $this->cliente->bi ?? '';
        $this->nuit = $this->cliente->nuit ?? '';
        $this->email = $this->cliente->email ?? '';
        $this->telefone = $this->cliente->telefone ?? '';
        $this->data_nascimento = $this->cliente->data_nascimento ? $this->cliente->data_nascimento->format('Y-m-d') : '';
        $this->responsavel_legal = $this->cliente->responsavel_legal ?? '';

        // Carregar endereço
        $this->cidade = $this->cliente->cidade ?? '';
        $this->endereco = $this->cliente->endereco ?? '';
        $this->numero_casa = $this->cliente->numero_casa ?? '';
        $this->bairro = $this->cliente->bairro ?? '';
        $this->zona_distribuicao = $this->cliente->zona_distribuicao ?? '';
        $this->ponto_referencia = $this->cliente->ponto_referencia ?? '';
        $this->latitude = $this->cliente->latitude ?? '';
        $this->longitude = $this->cliente->longitude ?? '';

        // Carregar ligação
        $this->numero_matricula = $this->cliente->numero_matricula ?? '';
        $this->categoria_consumo = $this->cliente->categoria_consumo ?? 'Residencial Normal';
        $this->tipo_ligacao = $this->cliente->tipo_ligacao ?? 'Ativa';
        $this->diametro_ramal = $this->cliente->diametro_ramal ?? '15mm (1/2")';
        $this->tipo_imovel = $this->cliente->tipo_imovel ?? '';
        $this->numero_economias = $this->cliente->numero_economias ?? 1;
        $this->observacoes = $this->cliente->observacoes ?? '';
        $this->status = $this->cliente->status ?? 'Ativo';

        // Carregar hidrômetro atual
        $this->medidorAtual = $this->cliente->medidor;
        if ($this->medidorAtual) {
            $this->medidor_id = $this->medidorAtual->id;
            $this->numero_hidrometro = $this->medidorAtual->numero_hidrometro ?? '';
            $this->marca = $this->medidorAtual->marca ?? 'Bayard';
            $this->modelo = $this->medidorAtual->modelo ?? '';
            $this->diametro = $this->medidorAtual->diametro ?? '15mm';
            $this->tipo_hidrometro = $this->medidorAtual->tipo_hidrometro ?? 'Unijato / Velocidade';
            $this->numero_lacre = $this->medidorAtual->numero_lacre ?? '';

            // Última leitura
            $this->ultimaLeitura = $this->medidorAtual->ultimaLeitura;
            $this->leitura_atual = $this->ultimaLeitura ? $this->ultimaLeitura->leitura_atual : 0;
            $this->data_ultima_leitura = $this->ultimaLeitura && $this->ultimaLeitura->data_leitura
                ? $this->ultimaLeitura->data_leitura->format('Y-m-d')
                : '';
        }

        // Carregar dados de faturamento
        $this->carregarDadosFaturamento();

        // $this->modalAberto = true;
        $this->abaAtiva = 'tab-edit-dados';

        $this->dispatch('openModal', 'modal-editar-cliente');
        // $this->dispatch('clienteCarregado', clienteId: $clienteId);
    }



    // ═══════════════════════════════════════════════════════════════════════════════
    // CARREGAR DADOS DE FATURAMENTO
    // ═══════════════════════════════════════════════════════════════════════════════
    public function carregarDadosFaturamento()
    {
        // Última fatura paga
        $this->ultimaFatura = Faturas::where('cliente_id', $this->clienteId)
            ->where('status', 'Pago')
            ->latest('data_emissao')
            ->first();

        if ($this->ultimaFatura) {
            $this->valor_ultima_fatura = $this->ultimaFatura->valor_total ?? 0;
            $this->status_ultima_fatura = 'Paga em ' . ($this->ultimaFatura->data_emissao ? $this->ultimaFatura->data_emissao->format('d/m/Y') : '');
        }

        // Fatura atual (pendente)
        $faturaAtual = Faturas::where('cliente_id', $this->clienteId)
            ->whereIn('status', ['Pendente', 'Parcial'])
            ->latest('data_vencimento')
            ->first();

        if ($faturaAtual) {
            $this->valor_fatura_atual = $faturaAtual->valor_total ?? 0;
            $this->vencimento_fatura_atual = $faturaAtual->data_vencimento ? $faturaAtual->data_vencimento->format('d/m/Y') : '';
        }

        // Total em aberto
        $this->faturasEmAberto = Faturas::where('cliente_id', $this->clienteId)
            ->whereIn('status', ['Pendente', 'Parcial'])
            ->get();

        $this->totalEmAberto = $this->faturasEmAberto->sum('valor_total');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // ALTERAR ABA
    // ═══════════════════════════════════════════════════════════════════════════════
    public function switchTab($aba)
    {
        $this->abaAtiva = $aba;
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // AÇÕES RÁPIDAS
    // ═══════════════════════════════════════════════════════════════════════════════
    public function solicitarReligacao()
    {
        try {
            // Atualizar status do medidor
            if ($this->medidorAtual) {
                $this->medidorAtual->update(['status_inicial' => 'instalado']);
                $this->cliente->update(['status' => 'Ativo', 'tipo_ligacao' => 'Ativa']);
            }

            $this->dispatch('notificacao', tipo: 'success', mensagem: 'Solicitação de religação enviada com sucesso!');
            $this->carregarCliente($this->clienteId);
        } catch (\Exception $e) {
            // Log::error('Erro ao solicitar religação: ' . $e->getMessage());
            $this->dispatch('notificacao', tipo: 'error', mensagem: 'Erro ao solicitar religação.');
        }
    }

    public function solicitarCorte()
    {
        try {
            if ($this->medidorAtual) {
                $this->medidorAtual->update(['status_inicial' => 'Cortada']);
                $this->cliente->update(['status' => 'Cortada', 'tipo_ligacao' => 'Cortada']);
            }

            $this->dispatch('notificacao', tipo: 'warning', mensagem: 'Solicitação de corte enviada com sucesso!');
            $this->carregarCliente($this->clienteId);
        } catch (\Exception $e) {

            $this->dispatch('notificacao', tipo: 'error', mensagem: 'Erro ao solicitar corte.');
        }
    }

    public function solicitarTrocaHidrometro()
    {
        $this->dispatch('abrirModalTrocaHidrometro', clienteId: $this->clienteId);
    }

    public function solicitarVistoria()
    {
        $this->dispatch('notificacao', tipo: 'info', mensagem: 'Vistoria técnica agendada! O setor técnico será notificado.');
    }

    public function gerarSegundaVia()
    {
        $this->dispatch('gerarSegundaViaFatura', clienteId: $this->clienteId);
    }

    public function negociarDivida()
    {
        $this->dispatch('abrirModalNegociacao', clienteId: $this->clienteId);
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // SALVAR ALTERAÇÕES
    // ═══════════════════════════════════════════════════════════════════════════════
    public function salvarEdicao()
    {

        $this->validate([
            'nome_completo' => 'required|string|max:255',
            'bi' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'cidade' => 'required|string|max:100',
            'endereco' => 'required|string|max:255',
            'categoria_consumo' => 'required|string',
            'diametro_ramal' => 'required|string',
        ]);


        try {
            // DB::beginTransaction();
            $data = Cliente::find($this->clienteId);


            $data->update([
                'tipo_pessoa' => $this->tipo_pessoa,
                'nome_completo' => $this->nome_completo,
                'bi' => $this->bi,
                'nuit' => $this->nuit,
                'email' => $this->email,
                'telefone' => $this->telefone,
                'data_nascimento' => $this->data_nascimento ?: null,
                'responsavel_legal' => $this->responsavel_legal,


                'cidade' => $this->cidade,
                'endereco' => $this->endereco,
                'numero_casa' => $this->numero_casa,
                'bairro' => $this->bairro,
                'zona_distribuicao' => $this->zona_distribuicao,
                'ponto_referencia' => $this->ponto_referencia,
                // 'latitude' => $this->latitude,
                // 'longitude' => $this->longitude,


                'categoria_consumo' => $this->categoria_consumo,
                'tipo_ligacao' => $this->tipo_ligacao,
                'diametro_ramal' => $this->diametro_ramal,
                'tipo_imovel' => $this->tipo_imovel,
                'numero_economias' => $this->numero_economias,
                'observacoes' => $this->observacoes,
                'status' => $this->status,

            ]);

            // Atualizar medidor se existir
            if ($this->medidorAtual) {
                $this->medidorAtual->update([
                    'numero_hidrometro' => $this->numero_hidrometro,
                    'marca' => $this->marca,
                    'modelo' => $this->modelo,
                    'diametro' => $this->diametro,
                    'tipo_hidrometro' => $this->tipo_hidrometro,
                ]);
            }

            $this->dispatch('notificacao', tipo: 'success', mensagem: 'Cliente atualizado com sucesso!');
            $this->dispatch('clienteAtualizado');
            $this->fecharModal();
        } catch (\Exception $e) {
            // DB::rollBack();

            $this->dispatch('notificacao', tipo: 'error', mensagem: 'Erro ao atualizar cliente: ' . $e->getMessage());
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // FECHAR MODAL
    // ═══════════════════════════════════════════════════════════════════════════════
    public function fecharModal()
    {
        $this->modalAberto = false;
        $this->reset([
            'clienteId',
            'cliente',
            'medidorAtual',
            'ultimaLeitura',
            'nome_completo',
            'bi',
            'nuit',
            'email',
            'telefone',
            'data_nascimento',
            'responsavel_legal',
            'cidade',
            'endereco',
            'numero_casa',
            'bairro',
            'zona_distribuicao',
            'ponto_referencia',
            'latitude',
            'longitude',
            'numero_matricula',
            'categoria_consumo',
            'tipo_ligacao',
            'diametro_ramal',
            'tipo_imovel',
            'numero_economias',
            'observacoes',
            'status',
            'medidor_id',
            'numero_hidrometro',
            'marca',
            'modelo',
            'diametro',
            'tipo_hidrometro',
            'numero_lacre',
            'leitura_atual',
            'data_ultima_leitura',
            'dia_vencimento',
            'forma_pagamento',
            'tarifa_aplicada',
            'desconto_especial',
            'isento',
            'valor_ultima_fatura',
            'status_ultima_fatura',
            'valor_fatura_atual',
            'vencimento_fatura_atual',
            'totalEmAberto',
            'abaAtiva',
        ]);
    }


    public function render()
    {
        return view('Livewire.admin.Clientes.Editar-cliente');
    }
}
