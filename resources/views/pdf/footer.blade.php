<!-- ═══════════════════════════════════════════════════════════ -->
<!-- RODAPÉ -->
<!-- ═══════════════════════════════════════════════════════════ -->
<table style="width:100%; background:#f8f8f8; border-top:2px solid #0066cc; border-collapse:collapse; margin-top:2mm;"
    cellspacing="0" cellpadding="0">
    <tr>
        <td style="padding:3mm 4mm; text-align:center; vertical-align:middle;">
            <div style="font-size:10pt; font-weight:700; color:#0066cc; margin-bottom:1mm;">
                {{ strlen($nome) > 30 ? substr($nome, 0, 27) . '...' : $nome }}
            </div>
            <div style="font-size:7pt; color:#666; margin-bottom:2mm;">
                <strong style="color:#333;">Atendido por: {{ $usuario }}</strong> |
                Processado em {{ $data_pagamento }} às {{ $hora_pagamento }}
            </div>
            <div
                style="font-family:'Courier New',monospace; font-size:6.5pt; color:#888; background:#fff; padding:1mm 2mm; border:1px solid #ddd; display:inline-block;">
                Hash: a1b2c3d4e5f67890 | {{ $nome }} v3.0
            </div>
        </td>
    </tr>
</table>
