<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\Leituras;
use App\Models\Medidores;
use Livewire\Attributes\On;
use Livewire\Component;

class VerCliente extends Component
{
    // ═══════════════════════════════════════════════════════════════════════════════
    // PROPRIEDADES DO CLIENTE
    // ═══════════════════════════════════════════════════════════════════════════════
    public $clienteId;
    public $cliente;
    public $medidor;
    public $ultimaLeitura;
    public $faturaAtual;
    public $modalAberto = false;

    // Dados Cadastrais
    public $nome_completo = '';
    public $bi = '';
    public $email = '';
    public $telefone = '';
    public $data_nascimento = '';

    // Endereço
    public $endereco_completo = '';
    public $cidade = '';
    public $bairro = '';
    public $zona_distribuicao = '';
    public $numero_casa = '';

    // Ligação
    public $numero_matricula = '';
    public $categoria_consumo = '';
    public $diametro_ramal = '';
    public $numero_economias = 1;
    public $data_ligacao = '';
    public $status_ligacao = '';

    // Hidrômetro
    public $numero_hidrometro = '';
    public $marca_hidrometro = '';
    public $tipo_hidrometro = '';
    public $diametro_hidrometro = '';
    public $leitura_atual = 0;
    public $data_ultima_leitura = '';

    // Fatura Atual
    public $valor_fatura_atual = 0;
    public $vencimento_fatura = '';
    public $numero_fatura_atual = '';

    // ═══════════════════════════════════════════════════════════════════════════════
    // CARREGAR CLIENTE PARA VISUALIZAÇÃO
    // ═══════════════════════════════════════════════════════════════════════════════
    #[On('ver-cliente')]
    public function carregarCliente($idCliente)
    {
        $this->clienteId = $idCliente;
        $this->cliente = Cliente::findOrFail($idCliente);

        // Dados Cadastrais
        $this->nome_completo = $this->cliente->nome_completo ?? 'Não informado';
        $this->bi = $this->cliente->bi ?? 'Não informado';
        $this->email = $this->cliente->email ?? 'Não informado';
        $this->telefone = $this->cliente->telefone ?? 'Não informado';
        $this->data_nascimento = $this->cliente->data_nascimento
            ? $this->cliente->data_nascimento->format('d/m/Y')
            : 'Não informado';

        // Endereço formatado
        $this->endereco_completo = $this->formatarEndereco($this->cliente);
        $this->cidade = $this->cliente->cidade ?? '';
        $this->bairro = $this->cliente->bairro ?? '';
        $this->zona_distribuicao = $this->cliente->zona_distribuicao ?? '';
        $this->numero_casa = $this->cliente->numero_casa ?? '';

        // Ligação
        $this->numero_matricula = $this->cliente->numero_matricula ?? 'MAT-0000-000000';
        $this->categoria_consumo = $this->cliente->categoria_consumo ?? 'Não informado';
        $this->diametro_ramal = $this->cliente->diametro_ramal ?? 'Não informado';
        $this->numero_economias = $this->cliente->numero_economias ?? 1;
        $this->data_ligacao = $this->cliente->data_solicitacao
            ? $this->cliente->data_solicitacao->format('d/m/Y')
            : 'Não informado';
        $this->status_ligacao = $this->cliente->status ?? 'Ativo';

        // Hidrômetro e Leituras
        $this->carregarMedidorELeituras();

        // Fatura Atual
        $this->carregarFaturaAtual();

        $this->dispatch('openModal', 'modal-ver-cliente');
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // CARREGAR MEDIDOR E LEITURAS
    // ═══════════════════════════════════════════════════════════════════════════════
    public function carregarMedidorELeituras()
    {

        $this->medidor = Medidores::where('cliente_id', $this->clienteId)
            ->where('status_inicial', 'instalado')
            ->first();

        if ($this->medidor) {
            $this->numero_hidrometro = $this->medidor->numero_hidrometro ?? 'N/A';
            $this->marca_hidrometro = $this->medidor->marca ?? 'N/A';
            $this->tipo_hidrometro = $this->medidor->tipo_hidrometro ?? 'N/A';
            $this->diametro_hidrometro = $this->medidor->diametro ?? 'N/A';

            // Última leitura
            $this->ultimaLeitura = Leituras::where('medidores_id', $this->medidor->id)
                ->orderBy('data_leitura', 'desc')
                ->first();

            if ($this->ultimaLeitura) {
                $this->leitura_atual = $this->ultimaLeitura->leitura_atual ?? 0;
                $this->data_ultima_leitura = $this->ultimaLeitura->data_leitura
                    ? $this->ultimaLeitura->data_leitura->format('d/m/Y')
                    : 'N/A';
            } else {
                $this->leitura_atual = 0;
                $this->data_ultima_leitura = 'N/A';
            }
        } else {
            $this->numero_hidrometro = 'Nenhum hidrômetro instalado';
            $this->marca_hidrometro = 'N/A';
            $this->tipo_hidrometro = 'N/A';
            $this->diametro_hidrometro = 'N/A';
            $this->leitura_atual = 0;
            $this->data_ultima_leitura = 'N/A';
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // CARREGAR FATURA ATUAL
    // ═══════════════════════════════════════════════════════════════════════════════
    public function carregarFaturaAtual()
    {

        $this->faturaAtual = Faturas::where('cliente_id', $this->clienteId)
            ->whereIn('status', ['Pendente', 'aberta'])
            ->orderBy('data_vencimento', 'desc')
            ->first();

        if ($this->faturaAtual) {
            $this->valor_fatura_atual = $this->faturaAtual->valor_total ?? 0;

            $this->vencimento_fatura = $this->faturaAtual->data_vencimento
                ? $this->faturaAtual->data_vencimento->format('d/m/Y')
                : 'N/A';
            $this->numero_fatura_atual = $this->faturaAtual->numero_fatura ?? 'FAT-0000-000000';
        } else {
            $this->valor_fatura_atual = 0;
            $this->vencimento_fatura = 'N/A';
            $this->numero_fatura_atual = 'N/A';
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════════════════════════════
    private function formatarEndereco($cliente)
    {
        $partes = [];

        if ($cliente->endereco) {
            $partes[] = $cliente->endereco;
        }
        if ($cliente->numero_casa) {
            $partes[] = ', ' . $cliente->numero_casa;
        }

        $linha1 = implode('', $partes);

        $partes2 = [];
        if ($cliente->tipo_imovel) {
            $partes2[] = $cliente->tipo_imovel;
        }
        if ($cliente->bairro) {
            $partes2[] = ' — ' . $cliente->bairro;
        }

        $linha2 = implode('', $partes2);

        $linha3 = '';
        if ($cliente->cidade) {
            $linha3 = $cliente->cidade;
        }

        $resultado = array_filter([$linha1, $linha2, $linha3]);
        return implode('<br>', $resultado) ?: 'Endereço não informado';
    }

    public function getStatusBadgeClass()
    {
        return match ($this->status_ligacao) {
            'Ativo' => 'badge-success',
            'Cortada' => 'badge-danger',
            'Suspensa' => 'badge-warning',
            'Inadimplente' => 'badge-danger',
            default => 'badge-neutral',
        };
    }

    public function getStatusLabel()
    {
        return match ($this->status_ligacao) {
            'ativo' => 'Ligação Ativa',
            'Cortada' => 'Ligação Cortada',
            'inativa' => 'Ligação Suspensa',
            'Inadimplente' => 'Inadimplente',
            default => 'Status: ' . $this->status_ligacao,
        };
    }

    public function getIniciaisNome()
    {
        $nome = $this->nome_completo;
        $partes = explode(' ', $nome);
        $iniciais = '';

        if (count($partes) >= 2) {
            $iniciais = strtoupper(substr($partes[0], 0, 1) . substr($partes[count($partes) - 1], 0, 1));
        } elseif (count($partes) === 1) {
            $iniciais = strtoupper(substr($partes[0], 0, 2));
        }

        return $iniciais ?: 'CL';
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // AÇÕES DO MODAL
    // ═══════════════════════════════════════════════════════════════════════════════
    public function fecharModal()
    {
        $this->modalAberto = false;
        $this->reset();
    }

    public function abrirEdicao()
    {
        $this->modalAberto = false;
        $this->dispatch('abrirEdicaoCliente', clienteId: $this->clienteId);
    }

    public function verFatura()
    {
        if ($this->faturaAtual) {
            $this->dispatch('verFatura', faturaId: $this->faturaAtual->id);
        }
    }

    public function pagarFatura()
    {
        if ($this->faturaAtual) {
            $this->dispatch('pagarFatura', faturaId: $this->faturaAtual->id);
        }
    }
    public function render()
    {
        return view('Livewire.Admin.Clientes.Ver-cliente');
    }
}
