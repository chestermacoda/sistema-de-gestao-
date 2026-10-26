<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Cliente;
use App\Models\Faturas;
use App\Models\Leituras;
use App\Models\Medidores;
use App\Models\pagamentos;
use App\Services\PagamentoService;
use Livewire\Attributes\On;
use Livewire\Component;

class HistoricoCliente extends Component
{

    // ═══════════════════════════════════════════════════════════════════════════════
    // PROPRIEDADES DO CLIENTE
    // ═══════════════════════════════════════════════════════════════════════════════
    public $clienteId;
    public $cliente;
    public $modalAberto = false;
    public $abaAtiva = 'tab-hist-leituras';

    // Dados do cabeçalho
    public $numeroMatricula = '';
    public $nomeCliente = '';

    // ───────────────────────────────────────────────────────────────────────────────
    // ABA: LEITURAS
    // ───────────────────────────────────────────────────────────────────────────────
    public $leituras = [];
    public $mediaConsumo = 0;

    // ───────────────────────────────────────────────────────────────────────────────
    // ABA: FATURAS
    // ───────────────────────────────────────────────────────────────────────────────
    public $faturas = [];

    // ───────────────────────────────────────────────────────────────────────────────
    // ABA: PAGAMENTOS
    // ───────────────────────────────────────────────────────────────────────────────
    public $pagamentos = [];

    // ───────────────────────────────────────────────────────────────────────────────
    // ABA: OCORRÊNCIAS
    // ───────────────────────────────────────────────────────────────────────────────
    public $ocorrencias = [];

    // ═══════════════════════════════════════════════════════════════════════════════
    // CARREGAR HISTÓRICO DO CLIENTE
    // ═══════════════════════════════════════════════════════════════════════════════
    #[On('historico-cliente')]
    public function CarregarHistorico($idCliente)
    {
        $this->clienteId = $idCliente;
        $this->cliente = Cliente::findOrFail($idCliente);

        // Dados do cabeçalho
        $this->numeroMatricula = $this->cliente->numero_matricula ?? 'MAT-0000-000000';
        $this->nomeCliente = $this->cliente->nome_completo ?? 'Cliente não identificado';

        // Carregar todas as abas
        $this->carregarLeituras();
        $this->carregarFaturas();
        $this->carregarPagamentos($this->faturas[0]['fatura_id']);
        $this->carregarOcorrencias();



        // $this->modalAberto = true;
        $this->abaAtiva = 'tab-hist-leituras';

        $this->dispatch('openModal', 'modal-historico-cliente');
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // ABA: LEITURAS
    // ═══════════════════════════════════════════════════════════════════════════════
    public function carregarLeituras()
    {

        // Buscar leituras do cliente através do medidor
        $medidor = Medidores::where('cliente_id', $this->clienteId)
            ->where('status_inicial', 'instalado')
            ->first();

        if ($medidor) {
            $this->leituras = Leituras::where('medidores_id', $medidor->id)
                ->orderBy('data_leitura', 'desc')
                ->get()
                ->map(function ($leitura) {
                    return [
                        'mes_ano' => $leitura->data_leitura ? $leitura->data_leitura->format('M/Y') : '-',
                        'leitura_anterior' => number_format($leitura->leitura_anterior ?? 0, 0, ',', '.'),
                        'leitura_atual' => number_format($leitura->leitura_atual ?? 0, 0, ',', '.'),
                        'consumo' => ($leitura->leitura_atual ?? 0) - ($leitura->leitura_anterior ?? 0),
                        'leiturista' => $leitura->leiturista ?? 'Não informado',
                        'data' => $leitura->data_leitura ? $leitura->data_leitura->format('d/m/Y') : '-',
                    ];
                })->toArray();

            // Calcular média de consumo
            $totalConsumo = collect($this->leituras)->sum('consumo');
            $quantidadeLeituras = count($this->leituras);
            $this->mediaConsumo = $quantidadeLeituras > 0 ? round($totalConsumo / $quantidadeLeituras) : 0;
        } else {
            $this->leituras = [];
            $this->mediaConsumo = 0;
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // ABA: FATURAS
    // ═══════════════════════════════════════════════════════════════════════════════
    public function carregarFaturas()
    {

        $this->faturas = Faturas::where('cliente_id', $this->clienteId)
            ->orderBy('data_vencimento', 'desc')
            ->get()
            ->map(function ($fatura) {
                return [
                    'fatura_id' => $fatura->id,
                    'numero' => $fatura->codigo_fatura ?? 'FAT-0000-000000',
                    'mes_referencia' => $fatura->mes_referencia ?? '-',
                    'vencimento' => $fatura->data_vencimento ? $fatura->data_vencimento->format('d/m/Y') : '-',
                    'valor' => $fatura->valor_total ?? 0,
                    'consumo' => $fatura->consumo_m3     ?? 0,
                    'status' => $fatura->status ?? 'pendente',
                    'status_label' => $this->getStatusLabel($fatura->status),
                    'status_classe' => $this->getStatusClasse($fatura->status),
                ];
            })->toArray();
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // ABA: PAGAMENTOS
    // ═══════════════════════════════════════════════════════════════════════════════
    public function carregarPagamentos($faturaId)
    {
        $this->pagamentos = app(PagamentoService::class)->historicoPagamentos($faturaId);
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // ABA: OCORRÊNCIAS
    // ═══════════════════════════════════════════════════════════════════════════════
    public function carregarOcorrencias()
    {

        // TODO: Implementar quando houver tabela de ocorrências/logs
        // Por enquanto, criar ocorrências baseadas nos dados existentes
        $this->ocorrencias = [];

        // Adicionar ocorrências de pagamentos
        $faturasPagas = Faturas::where('cliente_id', $this->clienteId)
            ->where('status', 'Paga')
            // ->orderBy('data_pagamento', 'desc')
            ->take(5)
            ->get();

        foreach ($faturasPagas as $fatura) {
            $this->ocorrencias[] = [
                'tipo' => 'pagamento',
                'titulo' => 'Pagamento Confirmado',
                'descricao' => "Fatura {$fatura->numero_fatura} paga no valor de Kz " . number_format($fatura->valor_total, 2, ',', '.'),
                // 'data' => $fatura->data_pagamento ? $fatura->data_pagamento->format('d/m/Y \\à\\s H:i') : '-',
                'autor' => 'Sistema Automático',
                'cor' => 'success',
                'icone' => 'check',
            ];
        }

        // Adicionar ocorrências de leituras
        $medidor = Medidores::where('cliente_id', $this->clienteId)
            ->where('status_inicial', 'instalado')
            ->first();

        if ($medidor) {
            $ultimasLeituras = Leituras::where('medidores_id', $medidor->id)
                ->orderBy('data_leitura', 'desc')
                ->take(3)
                ->get();

            foreach ($ultimasLeituras as $leitura) {
                $this->ocorrencias[] = [
                    'tipo' => 'leitura',
                    'titulo' => 'Leitura Realizada',
                    'descricao' => "Leitura de " . number_format($leitura->leitura_atual, 0, ',', '.') . " m³ registrada",
                    'data' => $leitura->data_leitura ? $leitura->data_leitura->format('d/m/Y \\à\\s H:i') : '-',
                    'autor' => $leitura->leiturista ?? 'Leiturista',
                    'cor' => 'tertiary',
                    'icone' => 'clock',
                ];
            }
        }

        // Ordenar por data (mais recente primeiro)
        usort($this->ocorrencias, function ($a, $b) {
            return strtotime($b['data']) <=> strtotime($a['data']);
        });
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════════════════════════════
    private function getStatusLabel($status)
    {
        return match ($status) {
            'Pago' => 'Pago',
            'pendente' => 'Pendente',
            'atrasada' => 'Atrasada',
            'cancelada' => 'Cancelada',
            default => 'Pendente',
        };
    }

    private function getStatusClasse($status)
    {
        return match ($status) {
            'Pago' => 'success',
            'pendente' => 'warning',
            'atrasada' => 'danger',
            'cancelada' => 'neutral',
            default => 'warning',
        };
    }

    private function getFormaPagamentoLabel($forma)
    {
        return match ($forma) {
            'PIX' => 'PIX',
            'debito_automatico' => 'Débito Auto',
            'boleto' => 'Boleto',
            'cartao_credito' => 'Cartão',
            'dinheiro' => 'Dinheiro',
            default => $forma ?: 'Não informado',
        };
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // AÇÕES DO MODAL
    // ═══════════════════════════════════════════════════════════════════════════════
    public function switchTab($aba)
    {
        $this->abaAtiva = $aba;
    }

    public function fecharModal()
    {
        $this->modalAberto = false;
        $this->reset([
            'clienteId',
            'cliente',
            'numeroMatricula',
            'nomeCliente',
            'leituras',
            'mediaConsumo',
            'faturas',
            'pagamentos',
            'ocorrencias',
            'abaAtiva'
        ]);
    }

    public function verTodasLeituras()
    {
        $this->dispatch('abrirModalTodasLeituras', clienteId: $this->clienteId);
    }

    public function exportarPDF()
    {
        $this->dispatch('exportarHistoricoPDF', clienteId: $this->clienteId);
    }

    public function render()
    {
        return view('Livewire.Admin.Clientes.Historico-cliente');
    }
}
