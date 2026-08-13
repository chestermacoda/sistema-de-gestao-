<?php

namespace App\Services;

use App\Models\Faturas;
use App\Models\Pagamento;
use App\Models\pagamentos;
use Carbon\Carbon;
use Mpdf\Mpdf;

class ComprovanteService
{
    /**
     * Gera PDF do comprovante de pagamento
     */
    public function gerarComprovantePDF(pagamentos $pagamento, Faturas $fatura): string
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
        ]);

        $html = $this->renderTemplate($pagamento, $fatura);

        $mpdf->WriteHTML($html);

        $nomeArquivo = 'comprovante_' . $pagamento->codigo_transacao . '.pdf';
        $caminho = storage_path('app/public/comprovantes/' . $nomeArquivo);

        // Cria diretório se não existir
        if (!is_dir(dirname($caminho))) {
            mkdir(dirname($caminho), 0755, true);
        }

        $mpdf->Output($caminho, 'F');

        return $caminho;
    }

    /**
     * Retorna HTML para pré-visualização no iframe
     */
    public function gerarHtmlPreview(Pagamentos $pagamento, Faturas $fatura): string
    {
        return $this->renderTemplate($pagamento, $fatura);
    }

    /**
     * Template do comprovante
     */
    private function renderTemplate(pagamentos $pagamento, Faturas $fatura): string
    {
        $cliente = $fatura->cliente;
        $dataPagamento = Carbon::parse($pagamento->data_pagamento)->format('d/m/Y H:i');
        $dataEmissao = now()->format('d/m/Y H:i');

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .container { max-width: 700px; margin: 0 auto; }

        /* Cabeçalho */
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px solid #2563EB;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            color: #2563EB;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header p {
            color: #666;
            font-size: 11px;
        }

        /* Badge pago */
        .badge-pago {
            display: inline-block;
            background: #10B981;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin: 15px 0;
        }

        /* Info boxes */
        .info-box {
            background: #F3F4F6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .info-box h3 {
            font-size: 11px;
            text-transform: uppercase;
            color: #6B7280;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dashed #E5E7EB;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #6B7280; }
        .info-value { font-weight: 600; }

        /* Valor destacado */
        .valor-box {
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            color: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            margin: 20px 0;
        }
        .valor-box .label {
            font-size: 11px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .valor-box .valor {
            font-size: 32px;
            font-weight: 700;
            margin: 10px 0;
        }
        .valor-box .codigo {
            font-size: 10px;
            opacity: 0.8;
            font-family: monospace;
        }

        /* Tabela de itens */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th {
            background: #2563EB;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #E5E7EB;
        }
        .text-right { text-align: right; }
        .total-row {
            font-weight: 700;
            font-size: 14px;
            background: #F3F4F6;
        }

        /* Rodapé */
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #E5E7EB;
            text-align: center;
            color: #9CA3AF;
            font-size: 10px;
        }
        .qr-code {
            width: 80px;
            height: 80px;
            background: #F3F4F6;
            margin: 10px auto;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #9CA3AF;
        }

        /* Assinatura digital */
        .assinatura {
            margin-top: 30px;
            padding: 15px;
            border: 2px dashed #10B981;
            border-radius: 8px;
            text-align: center;
        }
        .assinatura-icon {
            color: #10B981;
            font-size: 24px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Cabeçalho -->
        <div class="header">
            <h1>💧 AquaNexus</h1>
            <p>Sistema de Gestão de Água</p>
            <div class="badge-pago">✓ PAGAMENTO CONFIRMADO</div>
        </div>

        <!-- Valor -->
        <div class="valor-box">
            <div class="label">Valor Pago</div>
            <div class="valor">MZN {$this->formatarValor($pagamento->valor_pago)}</div>
            <div class="codigo">{$pagamento->codigo_transacao}</div>
        </div>

        <!-- Dados do Cliente -->
        <div class="info-box">
            <h3>👤 Dados do Cliente</h3>
            <div class="info-row">
                <span class="info-label">Nome</span>
                <span class="info-value">{$cliente?->nome_completo}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Matrícula</span>
                <span class="info-value">{$cliente?->numero_matricula}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Categoria</span>
                <span class="info-value">{$cliente?->categoria_consumo}</span>
            </div>
        </div>

        <!-- Dados da Fatura -->
        <div class="info-box">
            <h3>📄 Dados da Fatura</h3>
            <div class="info-row">
                <span class="info-label">Código</span>
                <span class="info-value">{$fatura->codigo_fatura}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Mês Referência</span>
                <span class="info-value">{$fatura->mes_referencia}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Consumo</span>
                <span class="info-value">{$fatura->consumo_m3} m³</span>
            </div>
            <div class="info-row">
                <span class="info-label">Valor Total da Fatura</span>
                <span class="info-value">MZN {$this->formatarValor($fatura->valor_total)}</span>
            </div>
        </div>

        <!-- Detalhes do Pagamento -->
        <div class="info-box">
            <h3>💳 Detalhes do Pagamento</h3>
            <div class="info-row">
                <span class="info-label">Método</span>
                <span class="info-value">{$pagamento->metodo_pagamento}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Data/Hora</span>
                <span class="info-value">{$dataPagamento}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Comprovante</span>
                <span class="info-value">{$pagamento->numero_comprovante}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Transação</span>
                <span class="info-value" style="font-family: monospace; font-size: 10px;">{$pagamento->codigo_transacao}</span>
            </div>
            @if($pagamento->banco)
            <div class="info-row">
                <span class="info-label">Banco</span>
                <span class="info-value">{$pagamento->banco}</span>
            </div>
            @endif
        </div>

        <!-- Tabela de valores -->
        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th class="text-right">Valor (MZN)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Valor do Consumo</td>
                    <td class="text-right">{$this->formatarValor($fatura->valor_consumo)}</td>
                </tr>
                <tr>
                    <td>Esgoto (50%)</td>
                    <td class="text-right">{$this->formatarValor($fatura->valor_esgoto)}</td>
                </tr>
                <tr>
                    <td>Taxa de Disponibilidade</td>
                    <td class="text-right">{$this->formatarValor($fatura->taxa_disponibilidade)}</td>
                </tr>
                <tr class="total-row">
                    <td>Total da Fatura</td>
                    <td class="text-right">{$this->formatarValor($fatura->valor_total)}</td>
                </tr>
                <tr style="background: #ECFDF5;">
                    <td><strong>Valor Pago</strong></td>
                    <td class="text-right"><strong style="color: #059669;">{$this->formatarValor($pagamento->valor_pago)}</strong></td>
                </tr>
                @if($fatura->valor_total - $pagamento->valor_pago > 0)
                <tr style="background: #FEF3C7;">
                    <td>Saldo Devedor</td>
                    <td class="text-right" style="color: #D97706;">{$this->formatarValor($fatura->valor_total -$pagamento->valor_pago)}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Assinatura digital -->
        <div class="assinatura">
            <div class="assinatura-icon">🔒</div>
            <div style="font-size: 11px; color: #10B981; font-weight: 600;">Documento Autenticado Digitalmente</div>
            <div style="font-size: 9px; color: #9CA3AF; margin-top: 5px;">
                Emitido em {$dataEmissao} | AquaNexus Sistema de Gestão de Água
            </div>
        </div>

        <!-- Rodapé -->
        <div class="footer">
            <div class="qr-code">QR CODE<br>VERIFICAÇÃO</div>
            <p>Este documento é válido sem assinatura física.</p>
            <p>Para verificar autenticidade, acesse: aquanexus.co.mz/verificar</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    private function formatarValor(float $valor): string
    {
        return number_format($valor, 2, ',', '.');
    }
}
