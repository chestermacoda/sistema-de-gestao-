 <!DOCTYPE html>
 <html>

 <head>
     <meta charset="UTF-8">
     <style>
         /* Reset e configurações base para mPDF */
         * {
             margin: 0;
             padding: 0;
             box-sizing: border-box;
         }

         body {
             font-family: Arial, Helvetica, sans-serif;
             font-size: 8pt;
             line-height: 1.3;
             color: #333;
         }

         /* Container principal - usa tabela para layout seguro no mPDF */
         .page-container {
             width: 100%;
             border-collapse: collapse;
         }

         /* Cada fatura é uma linha da tabela principal */
         .invoice-row {
             page-break-inside: avoid;
         }

         /* Container de cada fatura */
         .invoice-box {
             width: 100%;
             border: 1px dashed #999;
             margin-bottom: 2mm;
             background: #fff;
             height: 120mm;
             /* Altura fixa para caber 3 por página A4 */
             overflow: hidden;
             position: relative;
         }

         /* Linha tracejada de corte entre faturas */
         .cut-line {
             border-top: 1px dashed #ccc;
             margin: 1mm 0;
             text-align: center;
             font-size: 6pt;
             color: #999;
             padding: 1mm 0;
         }

         /* ==================== CABEÇALHO ==================== */
         .invoice-header {
             width: 100%;
             border-collapse: collapse;
             margin-bottom: 2mm;
         }

         .invoice-header td {
             vertical-align: top;
             padding: 1mm;
         }

         .company-info {
             width: 45%;
         }

         .company-name {
             font-size: 10pt;
             font-weight: bold;
             color: #0066cc;
             text-transform: uppercase;
         }

         .company-details {
             font-size: 7pt;
             color: #666;
             line-height: 1.2;
         }

         .invoice-title-cell {
             width: 25%;
             text-align: center;
         }

         .invoice-title {
             font-size: 12pt;
             font-weight: bold;
             color: #0066cc;
             border: 2px solid #0066cc;
             padding: 2mm 4mm;
             display: inline-block;
         }

         .invoice-meta-cell {
             width: 30%;
             text-align: right;
         }

         .meta-table {
             width: 100%;
             border-collapse: collapse;
             font-size: 7pt;
         }

         .meta-table td {
             padding: 0.5mm 1mm;
             border: 1px solid #ddd;
         }

         .meta-label {
             background: #f0f0f0;
             font-weight: bold;
             width: 50%;
             text-align: left;
         }

         .meta-value {
             text-align: right;
             font-weight: bold;
             color: #0066cc;
         }

         /* ==================== DADOS DO CLIENTE ==================== */
         .client-section {
             width: 100%;
             border-collapse: collapse;
             margin-bottom: 2mm;
             border: 1px solid #ddd;
         }

         .client-section td {
             padding: 1.5mm;
             vertical-align: top;
         }

         .client-label {
             font-size: 6pt;
             color: #666;
             text-transform: uppercase;
             font-weight: bold;
             margin-bottom: 1mm;
         }

         .client-name {
             font-size: 9pt;
             font-weight: bold;
             color: #333;
         }

         .client-address {
             font-size: 7pt;
             color: #555;
             line-height: 1.3;
         }

         .client-contract {
             font-size: 8pt;
             font-weight: bold;
             color: #0066cc;
         }

         /* ==================== TABELA DE CONSUMO ==================== */
         .consumption-table {
             width: 100%;
             border-collapse: collapse;
             margin-bottom: 2mm;
             font-size: 7pt;
         }

         .consumption-table th {
             background: #0066cc;
             color: #fff;
             padding: 1.5mm 1mm;
             text-align: center;
             font-weight: bold;
             border: 1px solid #0055aa;
             font-size: 6.5pt;
         }

         .consumption-table td {
             padding: 1.5mm 1mm;
             text-align: center;
             border: 1px solid #ddd;
             font-size: 8pt;
         }

         .consumption-table .highlight {
             background: #e6f2ff;
             font-weight: bold;
             color: #0066cc;
         }

         .consumption-table .total-row {
             background: #fff3cd;
             font-weight: bold;
             font-size: 9pt;
         }

         .consumption-table .total-row td {
             border-top: 2px solid #0066cc;
             border-bottom: 2px solid #0066cc;
         }

         /* ==================== RESUMO DE PAGAMENTO - CORREÇÃO CRÍTICA ==================== */
         .payment-summary {
             width: 100%;
             border-collapse: collapse;
             margin-bottom: 2mm;
             table-layout: fixed;
         }

         .payment-summary td {
             vertical-align: top;
             width: 50%;
             padding: 0;
         }

         .payment-summary td:first-child {
             padding-right: 1mm;
         }

         .payment-summary td:last-child {
             padding-left: 1mm;
         }

         .payment-box {
             border: 2px solid #0066cc;
             padding: 2mm;
             background: #f8fbff;
             width: 100%;
             box-sizing: border-box;
         }

         .payment-title {
             font-size: 7pt;
             font-weight: bold;
             color: #0066cc;
             text-transform: uppercase;
             margin-bottom: 1mm;
             border-bottom: 1px solid #0066cc;
             padding-bottom: 1mm;
         }

         .payment-amount {
             font-size: 14pt;
             font-weight: bold;
             color: #0066cc;
             text-align: center;
             padding: 2mm 0;
         }

         .payment-details {
             font-size: 6.5pt;
             color: #555;
             line-height: 1.3;
         }

         /* ==================== NORMAS E AVISOS - CORREÇÃO CRÍTICA ==================== */
         .notice-box {
             border: 1px solid #ff9800;
             background: #fff8e1;
             padding: 1.5mm;
             font-size: 6pt;
             line-height: 1.3;
             color: #e65100;
             width: 100%;
             box-sizing: border-box;
         }

         .notice-title {
             font-weight: bold;
             font-size: 6.5pt;
             margin-bottom: 1mm;
             color: #e65100;
         }

         .notice-box ul {
             margin: 0;
             padding-left: 3mm;
         }

         .notice-box li {
             margin-bottom: 0.5mm;
         }

         /* ==================== INFORMAÇÕES ADICIONAIS ==================== */
         .extra-info {
             width: 100%;
             border-collapse: collapse;
             margin-top: 1mm;
             font-size: 6pt;
             color: #666;
         }

         .extra-info td {
             padding: 0.5mm 1mm;
             border: 1px solid #eee;
         }

         .extra-label {
             background: #f5f5f5;
             font-weight: bold;
             width: 30%;
         }

         /* ==================== CÓDIGO DE BARRAS / REFERÊNCIA ==================== */
         .barcode-area {
             text-align: center;
             padding: 1mm;
             border: 1px dashed #ccc;
             margin-top: 1mm;
             font-size: 8pt;
             font-family: monospace;
             letter-spacing: 2px;
         }

         /* ==================== RESPONSIVIDADE PARA IMPRESSÃO ==================== */
         @media print {
             .invoice-box {
                 page-break-inside: avoid;
             }
         }

         /* Cores de status */
         .status-pago {
             color: #4caf50;
             font-weight: bold;
         }

         .status-pendente {
             color: #ff9800;
             font-weight: bold;
         }

         .status-atrasado {
             color: #f44336;
             font-weight: bold;
         }

         /* Utility classes */
         .text-right {
             text-align: right;
         }

         .text-center {
             text-align: center;
         }

         .text-left {
             text-align: left;
         }

         .bold {
             font-weight: bold;
         }

         .small {
             font-size: 6pt;
         }
     </style>
     <base target="_blank">
 </head>

 <body>

     <!-- ==================== FATURA 1 ==================== -->
     <table class="page-container">
         @foreach ($data as $dat)
             <tr class="invoice-row">
                 <td>
                     <div class="invoice-box">

                         <!-- CABEÇALHO -->
                         <table class="invoice-header">
                             <tr>
                                 <td class="company-info">
                                     <div class="company-name">ÁGUAS DO MUNICÍPIO, S.A.</div>
                                     <div class="company-details">
                                         Av. da República, 1234 · CP 1000-001 Lisboa<br>
                                         NIF: 500 123 456 · Tel: 213 456 789<br>
                                         Email: faturas@aguasmunicipio.pt
                                     </div>
                                 </td>
                                 <td class="invoice-title-cell">
                                     <div class="invoice-title">FATURA DE ÁGUA</div>
                                 </td>
                                 <td class="invoice-meta-cell">
                                     <table class="meta-table">
                                         <tr>
                                             <td class="meta-label">Fatura Nº</td>
                                             <td class="meta-value">{{ $dat['Fatura']['codgo_fatura'] }}</td>
                                         </tr>
                                         <tr>
                                             <td class="meta-label">Data Emissão</td>
                                             <td class="meta-value">{{ $dat['Fatura']['periodo_inicio'] }}</td>
                                         </tr>
                                         <tr>
                                             <td class="meta-label">Mês Ref.</td>
                                             <td class="meta-value">{{ $dat['Fatura']['mes_referencia'] }}</td>
                                         </tr>
                                         <tr>
                                             <td class="meta-label">Vencimento</td>
                                             <td class="meta-value">{{ $dat['Fatura']['periodo_fim'] }}</td>
                                         </tr>
                                     </table>
                                 </td>
                             </tr>
                         </table>

                         <!-- DADOS DO CLIENTE -->
                         <table class="client-section">
                             <tr>
                                 <td style="width: 55%; border-right: 1px solid #ddd;">
                                     <div class="client-label">Cliente</div>
                                     <div class="client-name">{{ $dat['cliente_nome'] }}</div>
                                     <div class="client-address">
                                         {{ $dat['cliente_dados']['endereco'] }} ,
                                         {{ $dat['cliente_dados']['cidade'] }}
                                     </div>
                                 </td>
                                 <td style="width: 20%; border-right: 1px solid #ddd; text-align: center;">
                                     <div class="client-label">Contador Nº</div>
                                     <div class="client-contract">{{ $dat['medidor_numero'] }}</div>
                                 </td>
                                 <td style="width: 25%; text-align: center;">
                                     <div class="client-label">Numero Matricula Cliente</div>
                                     <div class="client-contract">{{ $dat['cliente_dados']['numero_matricula'] }}</div>
                                     <div class="client-label" style="margin-top: 2mm;">Estado: <span
                                             class="status-pendente">{{ $dat['Fatura']['status'] }}</span></div>

                                 </td>
                             </tr>
                         </table>

                         <!-- TABELA DE CONSUMO -->
                         <table class="consumption-table">
                             <thead>
                                 <tr>
                                     <th style="width: 12%;">Leitura Anterior</th>
                                     <th style="width: 12%;">Leitura Atual</th>
                                     <th style="width: 12%;">Consumo (m³)</th>
                                     <th style="width: 12%;">Taxa Mínima</th>
                                     <th style="width: 14%;">Consumo Excedente</th>
                                     <th style="width: 14%;">Tarifa (m³)</th>
                                     <th style="width: 12%;">Taxa Limite m3</th>
                                     <th style="width: 12%;">TOTAL A PAGAR</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr>
                                     <td>{{ number_format($dat['leitura_anterior'], 2) }}</td>
                                     <td>{{ !empty($dat['leitura_atual']) ? $dat['leitura_atual'] : ' ' }}</td>
                                     <td class="highlight">
                                         {{ !empty($dat['Fatura']['consumo_m3']) ? number_format($dat['Fatura']['consumo_m3']) : ' ' }}
                                     </td>
                                     <td>{{ number_format($dat['tarifas']['taxa_minima']) }}MT</td>
                                     <td>0 m³</td>
                                     <td>{{ number_format($dat['tarifas']['valor_m3']) }} MT</td>
                                     <td>{{ number_format($dat['tarifas']['limite_m3']) }}</td>
                                     <td class="highlight">
                                         {{ !empty($dat['Fatura']['valor_total']) ? number_format($dat['Fatura']['valor_total']) : '' }}
                                     </td>
                                 </tr>

                             </tbody>
                         </table>

                         <!-- RESUMO E NORMAS -->
                         <!-- RESUMO E NORMAS - VERSÃO ISOLADA PARA MPDF -->
                         <table
                             style="width:100%; border:none; border-collapse:collapse; table-layout:fixed; margin:0; padding:0;">
                             <tr style="border:none;">
                                 <td
                                     style="width:50%; vertical-align:top; border:none; padding:0; padding-right:1.5mm;">
                                     <table
                                         style="width:100%; border:1.5px solid #0066cc; border-collapse:collapse; background:#f8fbff; margin:0;">
                                         <tr style="border:none;">
                                             <td style="border:none; padding:2mm; padding-bottom:1mm;">
                                                 <div
                                                     style="font-size:7pt; font-weight:bold; color:#0066cc; text-transform:uppercase; border-bottom:1px solid #0066cc; padding-bottom:1mm;">
                                                     VALOR A PAGAR
                                                 </div>
                                             </td>
                                         </tr>
                                         <tr style="border:none;">
                                             <td
                                                 style="border:none; padding:2mm; padding-top:1mm; padding-bottom:1mm; text-align:center;">
                                                 <div style="font-size:14pt; font-weight:bold; color:#0066cc;">
                                                     {{ !empty($dat['Fatura']['valor_total']) ? number_format($dat['Fatura']['valor_total'], 2, ',', ' ') : '____________' }}
                                                     MT
                                                 </div>
                                             </td>
                                         </tr>
                                         <tr style="border:none;">
                                             <td style="border:none; padding:2mm; padding-top:1mm;">
                                                 <div style="font-size:6.5pt; color:#555; line-height:1.4;">
                                                     IBAN: PT50 0002 0123 1234 5678 9015 4<br>
                                                     Ref. Multibanco: 123 456 789<br>
                                                     Entidade: 21023 · Referência: 123 456 789
                                                 </div>
                                             </td>
                                         </tr>
                                     </table>
                                 </td>
                                 <td style="width:50%; vertical-align:top; border:none; padding:0; padding-left:1.5mm;">
                                     <table
                                         style="width:100%; border:1px solid #ff9800; border-collapse:collapse; background:#fff8e1; margin:0;">
                                         <tr style="border:none;">
                                             <td style="border:none; padding:1.5mm; padding-bottom:0.5mm;">
                                                 <div style="font-weight:bold; font-size:6.5pt; color:#e65100;">
                                                     ⚠ NORMAS PARA EVITAR MULTA
                                                 </div>
                                             </td>
                                         </tr>
                                         <tr style="border:none;">
                                             <td style="border:none; padding:1.5mm; padding-top:0;">
                                                 <table
                                                     style="width:100%; border:none; border-collapse:collapse; margin:0;">
                                                     <tr style="border:none;">
                                                         <td
                                                             style="border:none; padding:0; padding-left:2mm; font-size:6pt; color:#e65100; line-height:1.4;">
                                                             • Pague até <b>25/07/2026</b> para evitar juros de mora<br>
                                                             • Após vencimento: juros de <b>5% + €1,50</b> custos
                                                             processamento<br>
                                                             • Corte de fornecimento após <b>60 dias</b> de atraso<br>
                                                             • Reclamações no prazo de <b>30 dias</b> após emissão
                                                         </td>
                                                     </tr>
                                                 </table>
                                             </td>
                                         </tr>
                                     </table>
                                 </td>
                             </tr>
                         </table>

                         <!-- INFORMAÇÕES ADICIONAIS -->
                         <table class="extra-info">
                             <tr>
                                 <td class="extra-label">Consumo Mês Anterior</td>
                                 <td>{{ number_format($dat['leitura_anterior'], 2 ?? 0) }} m³</td>
                                 <td class="extra-label">Média Anual</td>
                                 <td>- m³</td>
                                 <td class="extra-label">Tipo de Tarifa</td>
                                 <td>{{ $dat['categoria'] }}</td>
                             </tr>

                         </table>

                         <table
                             style="width:100%; border:1px dashed #ccc; border-collapse:separate; margin:1mm 0 0 0; padding:0; background:#fff;">
                             <tr>
                                 <td
                                     style="text-align:center; padding:1mm; font-size:8pt; font-family:monospace; letter-spacing:2px; color:#333; border:none;">
                                     ||| 1234567890123 |||
                                 </td>
                             </tr>
                         </table>

                     </div>
                 </td>
             </tr>

             <!-- LINHA DE CORTE -->
             <table style="width:100%; border-collapse:separate; margin:1mm 0; padding:0;">
                 <tr>
                     <td
                         style="border-top:1px dashed #ccc; text-align:center; font-size:6pt; color:#999; padding:1mm 0;">
                         ✂ CORTE AQUI ✂
                     </td>
                 </tr>
             </table>
         @endforeach

     </table>

 </body>

 </html>
