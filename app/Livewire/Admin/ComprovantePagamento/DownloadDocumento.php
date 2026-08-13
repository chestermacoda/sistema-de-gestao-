<?php

namespace App\Livewire\Admin\ComprovantePagamento;

use App\Models\Faturas;
use App\Models\pagamentos;
use App\Services\MpdfService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class DownloadDocumento extends Component
{
    protected MpdfService $mpdfService;

    public function boot(MpdfService $mpdfService): void
    {
        $this->mpdfService = $mpdfService;
    }

    /**
     * Baixar comprovativo de pagamento
     */
    #[On('Baixar-comprovante')]
    public function baixarComprovativo(int $pagamentoId): void
    {
        dd($pagamentoId);
        $clienteId = Auth::guard('cliente')->user()->id;

        $pagamento = pagamentos::with(['fatura', 'cliente'])
            ->where('cliente_id', $clienteId)
            ->findOrFail($pagamentoId);

        $fatura = $pagamento->fatura;
        $cliente = $pagamento->cliente;

        // Dados para o PDF
        $dados = [
            'valor_pago' => (float) $pagamento->valor_pago,
            'metodo' => $pagamento->metodo_pagamento,
            'banco' => $pagamento->banco ?? '—',
            'comprovante' => $pagamento->numero_comprovante,
            'transacao' => $pagamento->codigo_transacao,
            'data' => Carbon::parse($pagamento->data_pagamento)->format('d/m/Y'),
            'hora' => $pagamento->hora_pagamento ?? '—',
            'cliente_nome' => $cliente->nome_completo,
            'cliente_matricula' => $cliente->numero_matricula,
            'fatura_codigo' => $fatura->codigo_fatura,
            'fatura_mes' => Carbon::parse($fatura->periodo_fim)->translatedFormat('F/Y'),
            'fatura_periodo' => Carbon::parse($fatura->periodo_inicio)->format('d/m/Y') . ' a ' . Carbon::parse($fatura->periodo_fim)->format('d/m/Y'),
            'fatura_consumo' => (float) ($fatura->consumo_m3 ?? 0),
            'fatura_valor_total' => (float) $fatura->valor_total,
            'fatura_multa' => (float) ($fatura->multa ?? 0),
            'fatura_juros' => (float) ($fatura->juros ?? 0),
            'fatura_desconto' => (float) ($fatura->desconto ?? 0),
            'saldo_restante' => (float) $fatura->saldo_atual,
            'total_pago' => (float) $fatura->pagamentos->sum('valor_pago'),
            'observacoes' => $pagamento->observacoes ?? 'Pagamento realizado via ' . $pagamento->metodo_pagamento,
        ];

        // Gera PDF
        $caminho = $this->mpdfService->gerarComprovativo($dados);

        // Registra histórico
        $info = $this->mpdfService->baixarDocumento(
            clienteId: $clienteId,
            faturaId: $fatura->id,
            pagamentoId: $pagamento->id,
            tipo: 'comprovativo',
            codigo: $pagamento->numero_comprovante,
            caminhoArquivo: $caminho
        );

        // Dispara download
        $this->dispatch('download', [
            'url' => Storage::url($info['caminho']),
            'nome' => $info['nome'],
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Comprovativo baixado com sucesso!',
        ]);
    }

    /**
     * Baixar fatura
     */
    public function baixarFatura(int $faturaId): void
    {
        $clienteId = Auth::guard('cliente')->user()->id;

        $fatura = Faturas::with(['cliente', 'pagamentos'])
            ->where('cliente_id', $clienteId)
            ->findOrFail($faturaId);

        $cliente = $fatura->cliente;

        $dados = [
            'codigo' => $fatura->codigo_fatura,
            'status' => $fatura->status,
            'data_emissao' => Carbon::parse($fatura->data_emissao)->format('d/m/Y'),
            'data_vencimento' => Carbon::parse($fatura->data_vencimento)->format('d/m/Y'),
            'mes_referencia' => $fatura->mes_referencia,
            'periodo_inicio' => Carbon::parse($fatura->periodo_inicio)->format('d/m/Y'),
            'periodo_fim' => Carbon::parse($fatura->periodo_fim)->format('d/m/Y'),
            'consumo_m3' => (float) ($fatura->consumo_m3 ?? 0),
            'valor_consumo' => (float) $fatura->valor_consumo,
            'valor_esgoto' => (float) $fatura->valor_esgoto,
            'taxa_disponibilidade' => (float) $fatura->taxa_disponibilidade,
            'multa' => (float) ($fatura->multa ?? 0),
            'juros' => (float) ($fatura->juros ?? 0),
            'desconto' => (float) ($fatura->desconto ?? 0),
            'valor_total' => (float) $fatura->valor_total,
            'valor_pago' => (float) $fatura->valor_pago,
            'saldo_atual' => (float) $fatura->saldo_atual,
            'cliente_nome' => $cliente->nome_completo,
            'cliente_matricula' => $cliente->numero_matricula,
            'cliente_nuit' => $cliente->nuit ?? '—',
            'cliente_endereco' => $cliente->endereco ?? '—',
            'cliente_telefone' => $cliente->telefone ?? '—',
            'pagamentos' => $fatura->pagamentos->map(function ($p) {
                return [
                    'valor' => (float) $p->valor_pago,
                    'data' => Carbon::parse($p->data_pagamento)->format('d/m/Y'),
                    'metodo' => $p->metodo_pagamento,
                    'comprovante' => $p->numero_comprovante,
                ];
            })->toArray(),
        ];

        $caminho = $this->mpdfService->gerarFatura($dados);

        $info = $this->mpdfService->baixarDocumento(
            clienteId: $clienteId,
            faturaId: $fatura->id,
            pagamentoId: null,
            tipo: 'fatura',
            codigo: $fatura->codigo_fatura,
            caminhoArquivo: $caminho
        );

        $this->dispatch('download', [
            'url' => Storage::url($info['caminho']),
            'nome' => $info['nome'],
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Fatura baixada com sucesso!',
        ]);
    }
    public function render()
    {
        return view('livewire.admin.comprovante-pagamento.download-documento');
    }
}