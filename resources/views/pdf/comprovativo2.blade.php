 <!DOCTYPE html>
 <html lang="pt-BR">

 <head>
     <meta charset="UTF-8">
     <title>Comprovativo de Pagamento</title>
     <style>
         body {
             font-family: Arial, "DejaVu Sans", sans-serif;
             font-size: 9pt;
             color: #333;
             margin: 0;
             padding: 0;
             line-height: 1.4;
         }
     </style>
 </head>

 <body>

     <!-- ═══════════════════════════════════════════════════════════ -->
     <!-- CABEÇALHO -->
     <!-- ═══════════════════════════════════════════════════════════ -->
     <table style="width:100%; background:#0066cc; border-collapse:collapse;" cellspacing="0" cellpadding="0">
         <tr>
             <td style="padding:3mm 2mm 3mm 3mm; vertical-align:middle; width:50px;">
                 <table style="width:42px; height:42px; border-collapse:collapse;" cellspacing="0" cellpadding="0">
                     <tr>
                         <td style="width:50px; text-align:center; vertical-align:middle;">
                             <svg width="42" height="42">
                                 <circle cx="21" cy="21" r="20" fill="#FFFFFF" stroke="#0066cc"
                                     stroke-width="2" />

                                 <text x="21" y="27" text-anchor="middle" font-size="15" font-weight="bold"
                                     fill="#0066cc">
                                     {{ $iniciais }}
                                 </text>
                             </svg>
                         </td>
                     </tr>
                 </table>
             </td>
             <td style="padding:3mm 3mm 3mm 1mm; vertical-align:middle;">
                 <div
                     style="font-size:12pt; font-weight:700; color:#fff; text-transform:uppercase; letter-spacing:0.5px;">
                     {{ strlen($nome) > 25 ? substr($nome, 0, 22) . '...' : $nome }}
                 </div>
                 <div style="font-size:7.5pt; color:rgba(255,255,255,0.85); margin-top:0.5mm;">
                     Comprovativo de Pagamento
                 </div>
             </td>
         </tr>
     </table>

     <!-- ═══════════════════════════════════════════════════════════ -->
     <!-- INFO CLIENTE + INFO PAGAMENTO (2 COLUNAS) -->
     <!-- ═══════════════════════════════════════════════════════════ -->
     <table style="width:100%; border-collapse:collapse; margin:2mm 0;" cellspacing="0" cellpadding="0">
         <tr>
             <td style="width:50%; vertical-align:top; padding:2mm; border:1px solid #e0e0e0; background:#fafafa;">
                 <div
                     style="font-size:6.5pt; color:#888; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:2mm; border-bottom:1px solid #ddd; padding-bottom:1mm;">
                     Cliente
                 </div>
                 <div style="font-size:8pt; font-weight:900; color:#1f1d1d; margin-bottom:1mm;">
                     {{ $data['cliente']['nome'] }}
                 </div>
                 <div style="font-size:7.5pt; color:#666;">
                     Matrícula: <span style="font-weight:600; color:#0066cc;">{{ $data['cliente']['matricula'] }}</span>
                 </div>
                 <div style="font-size:7.5pt; color:#666;">
                     Categoria: <span
                         style="font-weight:600; color:#0066cc;">{{ $data['cliente']['categoria_consumo'] }}</span>
                 </div>
                 <div style="font-size:7.5pt; color:#666;">
                     Contacto: <span style="font-weight:600; color:#0066cc;">{{ $data['cliente']['contacto'] }}</span>
                 </div>
                 <div style="font-size:7.5pt; color:#666;">
                     Endereco: <span style="font-weight:600; color:#0066cc;">{{ $data['cliente']['endereco'] }}</span>
                 </div>
             </td>
             <td
                 style="width:50%; vertical-align:top; padding:2mm; border:1px solid #e0e0e0; border-left:none; background:#fafafa;">
                 <div
                     style="font-size:6.5pt; color:#888; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:2mm; border-bottom:1px solid #ddd; padding-bottom:1mm;">
                     Dados do Pagamento
                 </div>
                 <table style="width:100%; border-collapse:collapse;" cellspacing="0" cellpadding="0">
                     <tr>
                         <td style="font-size:7pt; color:#666; padding:1mm 0;">Nº Comprovativo</td>
                         <td
                             style="font-size:7.5pt; font-weight:700; color:#0066cc; text-align:right; font-family:'Courier New',monospace;">
                             {{ $data['numero_comprovante'] }}</td>
                     </tr>
                     <tr>
                         <td style="font-size:7pt; color:#666; padding:1mm 0;">Código Transação</td>
                         <td
                             style="font-size:7.5pt; font-weight:700; color:#0066cc; text-align:right; font-family:'Courier New',monospace;">
                             {{ $data['codigo_transacao'] }}</td>
                     </tr>
                     <tr>
                         <td style="font-size:7pt; color:#666; padding:1mm 0;">Data / Hora</td>
                         <td style="font-size:7.5pt; font-weight:600; color:#333; text-align:right;">
                             {{ $data['data_pagamento'] }} {{ $data['hora_pagamento'] }}</td>
                     </tr>
                 </table>
             </td>
         </tr>
     </table>

     <!-- ═══════════════════════════════════════════════════════════ -->
     <!-- VALOR DESTACADO -->
     <!-- ═══════════════════════════════════════════════════════════ -->
     <table style="width:100%; border-collapse:collapse; margin:2mm 0;" cellspacing="0" cellpadding="0">
         <tr>
             <td style="padding:0 2mm;">
                 <table style="width:100%; border:2px solid #0066cc; border-collapse:collapse; background:#f0f7ff;"
                     cellspacing="0" cellpadding="0">
                     <tr>
                         <td
                             style="padding:3mm 2mm 1.5mm 2mm; font-size:7pt; color:#0066cc; text-transform:uppercase; font-weight:700; letter-spacing:1px; text-align:center; border:none;">
                             Valor Pago
                         </td>
                     </tr>
                     <tr>
                         <td
                             style="padding:1.5mm 2mm 1.5mm 2mm; font-size:22pt; font-weight:800; color:#0066cc; text-align:center; border:none;">
                             MZN {{ number_format($data['valor_pago'], 2, ',', ' ') }}
                         </td>
                     </tr>
                     <tr>
                         <td
                             style="padding:1.5mm 2mm 3mm 2mm; font-size:7pt; color:#666; text-align:center; border:none;">
                             {{ 'Pagamento em:' . $data['metodo'] ?? 'Pagamento via Multibanco' }}
                         </td>
                     </tr>
                 </table>
             </td>
         </tr>
     </table>


     <!-- ═══════════════════════════════════════════════════════════ -->
     <!-- DETALHES DA FATURA -->
     <!-- ═══════════════════════════════════════════════════════════ -->
     <div
         style="font-size:8pt; font-weight:700; color:#0066cc; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1.5px solid #0066cc; padding-bottom:1.5mm; margin:3mm 2mm 0 2mm;">
         Detalhes da Fatura
     </div>
     <table style="width:100%; border-collapse:collapse; margin:0 2mm 2mm 2mm;" cellspacing="0" cellpadding="0">
         <tr>
             <td style="padding:2mm 0; font-size:8.5pt; color:#666; width:50%; border-bottom:1px solid #eee;">Código da
                 Fatura</td>
             <td
                 style="padding:2mm 0; font-size:8.5pt; font-weight:600; color:#333; text-align:right; border-bottom:1px solid #eee;">
                 {{ $data['codigo_fatura'] }}</td>
         </tr>
         <tr>
             <td style="padding:2mm 0; font-size:8.5pt; color:#666; border-bottom:1px solid #eee;">Mês de Referência
             </td>
             <td
                 style="padding:2mm 0; font-size:8.5pt; font-weight:600; color:#333; text-align:right; border-bottom:1px solid #eee;">
                 {{ $data['mes_referencia'] }}</td>
         </tr>
         <tr>
             <td style="padding:2mm 0; font-size:8.5pt; color:#666; border-bottom:1px solid #eee;">Período de Consumo
             </td>
             <td
                 style="padding:2mm 0; font-size:8.5pt; font-weight:600; color:#333; text-align:right; border-bottom:1px solid #eee;">
                 {{ $data['periodo'] }}</td>
         </tr>
         <tr>
             <td style="padding:2mm 0; font-size:8.5pt; color:#666; border-bottom:1px solid #eee;">Consumo Registado
             </td>
             <td
                 style="padding:2mm 0; font-size:8.5pt; font-weight:600; color:#333; text-align:right; border-bottom:1px solid #eee;">
                 {{ $data['consumo_m3'] }} m³</td>
         </tr>
         <tr>
             <td style="padding:2mm 0; font-size:9pt; font-weight:700; color:#0066cc; border-bottom:2px solid #0066cc;">
                 Valor Total da Fatura</td>
             <td
                 style="padding:2mm 0; font-size:9pt; font-weight:700; color:#0066cc; text-align:right; border-bottom:2px solid #0066cc;">
                 MZN {{ number_format($data['valor_total'], 2, ',', ' ') }}</td>
         </tr>
     </table>

     <!-- ═══════════════════════════════════════════════════════════ -->
     <!-- RESUMO DO PAGAMENTO -->
     <!-- ═══════════════════════════════════════════════════════════ -->
     <div
         style="font-size:8pt; font-weight:700; color:#0066cc; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1.5px solid #0066cc; padding-bottom:1.5mm; margin:3mm 2mm 0 2mm;">
         Resumo do Pagamento
     </div>
     <table style="width:100%; border-collapse:collapse; margin:0 2mm;" cellspacing="0" cellpadding="0">
         <tr>
             <td style="padding:0;">
                 <table style="width:100%; border-collapse:collapse;" cellspacing="0" cellpadding="0">
                     <tr>
                         <td
                             style="padding:2mm 0; font-size:8.5pt; color:#666; border-bottom:1px dashed #ddd; width:55%;">
                             Valor Base (Consumo)</td>
                         <td
                             style="padding:2mm 0; font-size:8.5pt; font-weight:600; color:#333; text-align:right; border-bottom:1px dashed #ddd;">
                             MZN {{ number_format($data['valor_consumo'], 2, ',', ' ') }}</td>
                     </tr>
                     <tr>
                         <td style="padding:2mm 0; font-size:8.5pt; color:#666; border-bottom:1px dashed #ddd;">Multa
                             por Atraso</td>
                         <td
                             style="padding:2mm 0; font-size:8.5pt; font-weight:600; color:#dc2626; text-align:right; border-bottom:1px dashed #ddd;">
                             + MZN {{ number_format($data['multa'], 2, ',', ' ') }}</td>
                     </tr>
                     <tr>
                         <td style="padding:2mm 0; font-size:8.5pt; color:#666; border-bottom:1px dashed #ddd;">Juros de
                             Mora</td>
                         <td
                             style="padding:2mm 0; font-size:8.5pt; font-weight:600; color:#dc2626; text-align:right; border-bottom:1px dashed #ddd;">
                             + MZN {{ number_format($data['juros'], 2, ',', ' ') }}</td>
                     </tr>
                     <tr>
                         <td style="padding:2mm 0; font-size:8.5pt; color:#666; border-bottom:1px dashed #ddd;">Desconto
                             Aplicado</td>
                         <td
                             style="padding:2mm 0; font-size:8.5pt; font-weight:600; color:#059669; text-align:right; border-bottom:1px dashed #ddd;">
                             - MZN {{ number_format($data['desconto'], 2, ',', ' ') }}</td>
                     </tr>
                     <tr>
                         <td
                             style="padding:2.5mm 0 2mm 0; font-size:9pt; font-weight:700; color:#333; border-top:2px solid #333; border-bottom:1px dashed #ddd;">
                             Valor Total da Fatura</td>
                         <td
                             style="padding:2.5mm 0 2mm 0; font-size:9pt; font-weight:700; color:#333; text-align:right; border-top:2px solid #333; border-bottom:1px dashed #ddd;">
                             MZN {{ number_format($data['valor_total'], 2, ',', ' ') }}</td>
                     </tr>
                     <tr>
                         <td style="padding:2mm 0; font-size:8.5pt; color:#666; border-bottom:1px dashed #ddd;">Valor
                             Pago (esta parcela)</td>
                         <td
                             style="padding:2mm 0; font-size:8.5pt; font-weight:700; color:#0066cc; text-align:right; border-bottom:1px dashed #ddd;">
                             MZN {{ number_format($data['valor_pago'], 2, ',', ' ') }}</td>
                     </tr>
                     <tr>
                         <td style="padding:2mm 0; font-size:8.5pt; color:#666; border-bottom:1px dashed #ddd;">Total
                             Pago Acumulado</td>
                         <td
                             style="padding:2mm 0; font-size:8.5pt; font-weight:700; color:#059669; text-align:right; border-bottom:1px dashed #ddd;">
                             MZN {{ number_format($data['valor_Acumulado'], 2, ',', ' ') }}</td>
                     </tr>
                     <tr>
                         <td style="padding:2mm 0; font-size:9.5pt; font-weight:800; color:#333; border-bottom:none;">
                             Saldo Restante</td>
                         <td
                             style="padding:2mm 0; font-size:9.5pt; font-weight:800; text-align:right; border-bottom:none; color: #dc2626  ;">
                             MZN {{ $data['saldo_atual'] }}
                         </td>
                     </tr>
                 </table>
             </td>
         </tr>
     </table>

     <!-- ═══════════════════════════════════════════════════════════ -->
     <!-- OBSERVAÇÕES -->
     <!-- ═══════════════════════════════════════════════════════════ -->
     <table style="width:100%; border-collapse:collapse; margin:2mm 0;" cellspacing="0" cellpadding="0">
         <tr>
             <td style="padding:0 2mm;">
                 <table style="width:100%; border:1px solid #ff9800; border-collapse:collapse; background:#fff8e1;"
                     cellspacing="0" cellpadding="0">
                     <tr>
                         <td
                             style="padding:2mm 2.5mm 1mm 2.5mm; font-size:7pt; font-weight:700; color:#e65100; text-transform:uppercase; letter-spacing:0.5px; border:none;">
                             Informações Importantes
                         </td>
                     </tr>
                     <tr>
                         <td
                             style="padding:0 2.5mm 2mm 2.5mm; font-size:7pt; color:#666; line-height:1.5; border:none;">
                             Este comprovativo é válido como prova de pagamento. Guarde-o para seus registos.
                             Em caso de discrepância, contacte o suporte em até 30 dias.
                         </td>
                     </tr>
                 </table>
             </td>
         </tr>
     </table>


 </body>

 </html>
