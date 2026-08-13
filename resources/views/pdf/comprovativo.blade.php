<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Comprovativo {{ $comprovante }}</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 10pt;
            color: #1e293b;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .header-table {
            width: 100%;
            background: linear-gradient(135deg, #059669 0%, #00838f 100%);
            color: #ffffff;
        }

        .header-table td {
            padding: 32px 24px;
            vertical-align: middle;
        }

        .logo-box {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 8px;
            text-align: center;
            line-height: 48px;
            font-size: 16pt;
            font-weight: 800;
        }

        .header-title {
            font-size: 16pt;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .header-subtitle {
            font-size: 9pt;
            opacity: 0.85;
        }

        .check-circle {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            text-align: center;
            line-height: 64px;
            font-size: 24pt;
        }

        .valor-box {
            text-align: center;
            padding: 24px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin: 24px 0;
        }

        .valor-label {
            font-size: 8pt;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .valor-principal {
            font-size: 22pt;
            font-weight: 800;
            color: #059669;
            margin-bottom: 8px;
        }

        .valor-metodo {
            font-size: 9pt;
            color: #64748b;
        }

        .metodo-badge {
            background: #d1fae5;
            color: #059669;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 7pt;
            font-weight: 600;
        }

        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
            margin-bottom: 16px;
        }

        .info-table td {
            width: 50%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            vertical-align: top;
        }

        .info-label {
            font-size: 7pt;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-valor {
            font-size: 9pt;
            font-weight: 600;
            color: #1e293b;
        }

        .font-mono {
            font-family: monospace;
            font-size: 8pt;
        }

        .fatura-box {
            background: #003366;
            border-radius: 12px;
            padding: 20px;
            color: #ffffff;
            margin-bottom: 24px;
        }

        .fatura-box-title {
            font-size: 8pt;
            opacity: 0.85;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 8px;
        }

        .fatura-row-table {
            width: 100%;
        }

        .fatura-row-table td {
            padding: 6px 0;
            font-size: 9pt;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .fatura-row-table td:first-child {
            opacity: 0.85;
        }

        .fatura-row-table td:last-child {
            font-weight: 600;
            text-align: right;
        }

        .fatura-row-table tr:last-child td {
            border-bottom: none;
            font-size: 10pt;
            font-weight: 700;
        }

        .resumo-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .resumo-title {
            font-size: 8pt;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }

        .resumo-table {
            width: 100%;
        }

        .resumo-table td {
            padding: 8px 0;
            font-size: 9pt;
            border-bottom: 1px dashed #e2e8f0;
        }

        .resumo-table td:first-child {
            color: #64748b;
        }

        .resumo-table td:last-child {
            font-weight: 600;
            color: #1e293b;
            text-align: right;
        }

        .resumo-divider {
            height: 2px;
            background: #e2e8f0;
            margin: 8px 0;
        }

        .resumo-total td {
            font-size: 10pt;
            font-weight: 700;
            color: #003366;
            border-bottom: none;
        }

        .resumo-saldo td {
            font-size: 10pt;
            font-weight: 700;
            color: #dc2626;
            border-bottom: none;
        }

        .resumo-saldo.quitado td {
            color: #059669;
        }

        .obs-box {
            background: #fef3c7;
            border: 1px solid rgba(217, 119, 6, 0.2);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 24px;
        }

        .obs-label {
            font-size: 7pt;
            font-weight: 700;
            color: #d97706;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .obs-text {
            font-size: 8pt;
            color: #64748b;
            line-height: 1.5;
        }

        .validacao-box {
            text-align: center;
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .validacao-label {
            font-size: 7pt;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .validacao-code {
            font-family: monospace;
            font-size: 12pt;
            font-weight: 700;
            color: #003366;
            letter-spacing: 2px;
            background: #ffffff;
            padding: 8px 16px;
            border-radius: 6px;
            border: 1px dashed #cbd5e1;
            display: inline-block;
        }

        .validacao-hint {
            font-size: 7pt;
            color: #94a3b8;
            margin-top: 6px;
        }

        .footer-table {
            width: 100%;
            background: #f8fafc;
            border-top: 2px solid #e2e8f0;
        }

        .footer-table td {
            padding: 24px;
            text-align: center;
            vertical-align: middle;
        }

        .footer-logo-table {
            margin: 0 auto 12px;
        }

        .footer-logo-table td {
            padding: 0 4px;
            vertical-align: middle;
        }

        .footer-logo-icon {
            width: 28px;
            height: 28px;
            background: #003366;
            color: #ffffff;
            border-radius: 6px;
            text-align: center;
            line-height: 28px;
            font-size: 10pt;
            font-weight: 700;
        }

        .footer-logo-text {
            font-size: 10pt;
            font-weight: 700;
            color: #1e293b;
        }

        .footer-info {
            font-size: 8pt;
            color: #64748b;
            margin-bottom: 8px;
        }

        .footer-info strong {
            color: #1e293b;
            display: block;
            margin-bottom: 2px;
        }

        .footer-hash {
            font-family: monospace;
            font-size: 7pt;
            color: #94a3b8;
            background: #ffffff;
            padding: 4px 12px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            display: inline-block;
        }
    </style>
</head>

<body>

    <table class="header-table" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width:60px;">
                <div class="logo-box">AQ</div>
            </td>
            <td>
                <div class="header-title">AquaNexus</div>
                <div class="header-subtitle">Comprovativo de Pagamento</div>
            </td>
            <td style="text-align:right;">
                <div class="check-circle">✓</div>
            </td>
        </tr>
    </table>

    <div style="padding:24px;">

        <div class="valor-box">
            <div class="valor-label">Valor Pago</div>
            <div class="valor-principal">MZN {{ number_format($valor_pago, 2, ',', '.') }}</div>
            <div class="valor-metodo">
                via <span class="metodo-badge">{{ $metodo }}</span>
                <span style="color:#94a3b8;"> • {{ $banco }}</span>
            </div>
        </div>

        <table class="info-table" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <div class="info-label">Número do Comprovativo</div>
                    <div class="info-valor font-mono">{{ $comprovante }}</div>
                </td>
                <td>
                    <div class="info-label">Código de Transação</div>
                    <div class="info-valor font-mono">{{ $transacao }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="info-label">Data do Pagamento</div>
                    <div class="info-valor">{{ $data }}</div>
                </td>
                <td>
                    <div class="info-label">Hora do Pagamento</div>
                    <div class="info-valor">{{ $hora }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="info-label">Cliente</div>
                    <div class="info-valor">{{ $cliente_nome }}</div>
                </td>
                <td>
                    <div class="info-label">Matrícula</div>
                    <div class="info-valor">{{ $cliente_matricula }}</div>
                </td>
            </tr>
        </table>

        <div class="fatura-box">
            <div class="fatura-box-title">Fatura Paga</div>
            <table class="fatura-row-table" cellspacing="0" cellpadding="0">
                <tr>
                    <td>Código da Fatura</td>
                    <td>{{ $fatura_codigo }}</td>
                </tr>
                <tr>
                    <td>Mês de Referência</td>
                    <td>{{ $fatura_mes }}</td>
                </tr>
                <tr>
                    <td>Período</td>
                    <td>{{ $fatura_periodo }}</td>
                </tr>
                <tr>
                    <td>Consumo</td>
                    <td>{{ number_format($fatura_consumo, 0, ',', '.') }} m³</td>
                </tr>
                <tr>
                    <td>Valor Total da Fatura</td>
                    <td>MZN {{ number_format($fatura_valor_total, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="resumo-box">
            <div class="resumo-title">Resumo do Pagamento</div>
            <table class="resumo-table" cellspacing="0" cellpadding="0">
                <tr>
                    <td>Valor Base da Fatura</td>
                    <td>MZN
                        {{ number_format($fatura_valor_total - $fatura_multa - $fatura_juros + $fatura_desconto, 2, ',', '.') }}
                    </td>
                </tr>
                @if ($fatura_multa > 0)
                    <tr>
                        <td>Multa</td>
                        <td style="color:#dc2626;">+ MZN {{ number_format($fatura_multa, 2, ',', '.') }}</td>
                    </tr>
                @endif
                @if ($fatura_juros > 0)
                    <tr>
                        <td>Juros</td>
                        <td style="color:#dc2626;">+ MZN {{ number_format($fatura_juros, 2, ',', '.') }}</td>
                    </tr>
                @endif
                @if ($fatura_desconto > 0)
                    <tr>
                        <td>Desconto</td>
                        <td style="color:#059669;">- MZN {{ number_format($fatura_desconto, 2, ',', '.') }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="2">
                        <div class="resumo-divider"></div>
                    </td>
                </tr>
                <tr class="resumo-total">
                    <td>Valor Total da Fatura</td>
                    <td>MZN {{ number_format($fatura_valor_total, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Valor Pago (esta parcela)</td>
                    <td style="color:#059669;">MZN {{ number_format($valor_pago, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Total Pago Acumulado</td>
                    <td style="color:#059669;">MZN {{ number_format($total_pago, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="resumo-divider"></div>
                    </td>
                </tr>
                <tr class="resumo-saldo {{ $saldo_restante <= 0 ? 'quitado' : '' }}">
                    <td>Saldo Restante</td>
                    <td>MZN {{ number_format($saldo_restante, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="obs-box">
            <div class="obs-label">Observações</div>
            <div class="obs-text">{{ $observacoes }}</div>
        </div>

        <div class="validacao-box">
            <div class="validacao-label">Código de Validação</div>
            <div class="validacao-code">{{ substr(md5($comprovante), 0, 16) }}</div>
            <div class="validacao-hint">Apresente este código para validar o pagamento junto ao atendimento</div>
        </div>

    </div>

    <table class="footer-table" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table class="footer-logo-table" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <div class="footer-logo-icon">AQ</div>
                        </td>
                        <td><span class="footer-logo-text">AquaNexus</span></td>
                    </tr>
                </table>
                <div class="footer-info">
                    <strong>Atendido por: AquaNexus System</strong>
                    <span>Processado em {{ now()->format('d/m/Y H:i:s') }}</span>
                </div>
                <div class="footer-hash">Hash: {{ substr(md5($comprovante . $transacao), 0, 16) }} | AquaNexus v3.0
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
