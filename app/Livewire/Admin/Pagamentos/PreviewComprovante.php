<?php

namespace App\Livewire\Admin\Pagamentos;

use App\Models\Faturas;
use App\Models\pagamentos;
use App\Services\ComprovanteService;
use Livewire\Attributes\On;
use Livewire\Component;

class PreviewComprovante extends Component
{
    public ?int $faturaId = null;
    public ?float $valorPago = null;
    public string $metodoPagamento = '';
    public string $dataPagamento = '';

    // Estado do comprovante
    public bool $pagamentoConfirmado = false;
    public ?string $pdfUrl = null;
    public ?string $codigoTransacao = null;
    public ?string $numeroComprovante = null;

    // Preview HTML para iframe
    public string $htmlPreview = '';
    public bool $carregando = false;

    /**
     * Atualiza preview com dados atuais do formulário (pré-visualização)
     */
    #[On('atualizar-preview-comprovante')]
    public function atualizarDadosPreview(int $faturaId, float $valorPago, string $metodoPagamento, string $dataPagamento, bool $confirmado = false): void
    {
        $this->faturaId = $faturaId;
        $this->valorPago = $valorPago;
        $this->metodoPagamento = $metodoPagamento;
        $this->dataPagamento = $dataPagamento;
        $this->pagamentoConfirmado = $confirmado;
        $this->carregando = true;

        $this->gerarPreview();
        $this->carregando = false;
    }

    /**
     * Recebe evento quando um pagamento é confirmado
     */

    public function pagamentos() {}
    #[On('pagamento-confirmado')]
    public function carregarComprovante($faturaId, $dadosPagamento = []): void
    {


        $this->faturaId = $faturaId;
        $this->pagamentoConfirmado = true;
        $this->carregando = true;

        if (!empty($dadosPagamento)) {
            $this->valorPago = $dadosPagamento['valor_pago'] ?? null;
            $this->metodoPagamento = $dadosPagamento['metodo_pagamento'] ?? '';
            $this->dataPagamento = $dadosPagamento['data_pagamento'] ?? '';
            $this->codigoTransacao = $dadosPagamento['codigo_transacao'] ?? null;
            $this->numeroComprovante = $dadosPagamento['numero_comprovante'] ?? null;
        }

        $this->gerarPreview();
        $this->carregando = false;
    }

    /**
     * Carrega preview mesmo sem pagamento (modo simulação)
     */
    #[On('simular-comprovante')]
    public function simularComprovante(int $faturaId, float $valorPago, string $metodo = 'PIX'): void
    {
        $this->faturaId = $faturaId;
        $this->valorPago = $valorPago;
        $this->metodoPagamento = $metodo;
        $this->dataPagamento = now()->format('Y-m-d');
        $this->codigoTransacao = 'TRX-SIMULADO-' . uniqid();
        $this->numeroComprovante = 'COMP-SIMULADO-' . random_int(100000, 999999);
        $this->pagamentoConfirmado = false;

        $this->gerarPreview();
    }

    /**
     * Gera HTML do preview
     */
    public function gerarPreview(): void
    {
        if (!$this->faturaId) {
            $this->htmlPreview = $this->htmlVazio();
            return;
        }

        $fatura = Faturas::with('cliente')->find($this->faturaId);
        if (!$fatura) {
            $this->htmlPreview = $this->htmlVazio();
            return;
        }

        // Cria pagamento mock para preview
        $pagamento = new pagamentos();
        $pagamento->valor_pago = $this->valorPago ?? $fatura->valor_total;
        $pagamento->metodo_pagamento = $this->metodoPagamento ?: 'PIX';
        $pagamento->data_pagamento = $this->dataPagamento ?: now();
        $pagamento->codigo_transacao = $this->codigoTransacao ?: 'TRX-PREVIEW-' . uniqid();
        $pagamento->numero_comprovante = $this->numeroComprovante ?: 'COMP-PREVIEW-' . random_int(100000, 999999);
        $pagamento->banco = null;
        $pagamento->observacoes = $this->pagamentoConfirmado ? 'Pagamento confirmado' : 'Pré-visualização';

        $service = app(ComprovanteService::class);
        $this->htmlPreview = $service->gerarHtmlPreview($pagamento, $fatura);

        // Gera URL do PDF se pagamento confirmado
        // if ($this->pagamentoConfirmado) {
        //     $this->pdfUrl = route('comprovante.download', ['fatura' => $this->faturaId]);
        // }

        $service = app(ComprovanteService::class);
        $this->htmlPreview = $service->gerarHtmlPreview($pagamento, $fatura);
    }

    public function baixarPdf(): void
    {
        if (!$this->faturaId) {
            $this->dispatch('notify', type: 'warning', message: 'Nenhuma fatura selecionada.');
            return;
        }

        $fatura = Faturas::with('cliente')->find($this->faturaId);
        if (!$fatura) {
            $this->dispatch('notify', type: 'error', message: 'Fatura não encontrada.');
            return;
        }

        // Recupera ou cria pagamento real do banco se confirmado
        $pagamento = pagamentos::where('fatura_id', $this->faturaId)
            ->latest()
            ->first();

        if (!$pagamento) {
            // Fallback: cria mock para preview/download
            $pagamento = new pagamentos();
            $pagamento->valor_pago = $this->valorPago ?? $fatura->valor_total;
            $pagamento->metodo_pagamento = $this->metodoPagamento ?: 'PIX';
            $pagamento->data_pagamento = $this->dataPagamento ?: now();
            $pagamento->codigo_transacao = $this->codigoTransacao ?: 'TRX-PREVIEW-' . uniqid();
            $pagamento->numero_comprovante = $this->numeroComprovante ?: 'COMP-PREVIEW-' . random_int(100000, 999999);
            $pagamento->banco = null;
            $pagamento->observacoes = 'Comprovante de pagamento';
        }

        try {
            $service = app(ComprovanteService::class);
            $caminhoPdf = $service->gerarComprovantePDF($pagamento, $fatura);

            // Dispara evento para JS fazer o download
            $this->dispatch('download-pdf', caminho: $caminhoPdf);
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Erro ao gerar PDF: ' . $e->getMessage());
        }
    }

    /**
     * Reseta o componente
     */
    #[On('limpar-comprovante')]
    public function resetar(): void
    {
        $this->reset();
        $this->htmlPreview = $this->htmlVazio();
    }


    /**
     * HTML quando não há fatura
     */
    private function htmlVazio(): string
    {
        return '<div style="text-align:center;padding:40px;color:#999;font-family:sans-serif;">' .
            '<div style="font-size:48px;margin-bottom:16px;">📄</div>' .
            '<h3 style="margin:0 0 8px;">Nenhum comprovante</h3>' .
            '<p style="margin:0;font-size:14px;">Confirme o pagamento para gerar o comprovante.</p>' .
            '</div>';
    }

    public function render()
    {
        return view('livewire.admin.pagamentos.preview-comprovante');
    }
}